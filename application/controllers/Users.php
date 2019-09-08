<?php

/**
 * @property CI_Input input
 * @property CI_Form_validation form_validation
 * @property Users_model Users_model
 * @property CI_Session session
 * @property CI_Loader load
 * @property CI_Upload upload
 * @property CI_Pagination pagination
 */
class Users extends CI_Controller
{
    const USERS_PER_PAGE = 5;
    const ALLOWED_IMAGE_PREFIX = 'image/';
    const MAX_UPLOAD_IMAGE_SIZE = 1.8 * 1024 * 1024; // 1.8 mb
    const UPLOAD_IMAGE_DESTINATION = 'application\public\images\\';
    const UPLOAD_IMAGE_TOO_BIG_MESSAGE = 'The image you are trying to upload is too big. The maximum size is ' . self::MAX_UPLOAD_IMAGE_SIZE / 1024 / 1024 . 'MB';
    const UPLOAD_IMAGE_NO_FILE_SEND_MESSAGE = 'No file was send.';
    const UPLOAD_IMAGE_BAD_FILE_TYPE_MESSAGE = 'It seems the file you are trying to upload is not an image. Please try again.';

    public function login()
    {
        if ($this->isUserLogged()) {
            redirect(base_url('dashboard'));
        }

        $this->load->view('partials/templateNotLogged', [
            'view' => 'users/login',
            'title' => 'Login'
        ]);
    }

    public function register()
    {
        if ($this->isUserLogged()) {
            redirect(base_url('dashboard'));
        }

        $this->load->view('partials/templateNotLogged', [
            'view' => 'users/register',
            'title' => 'Register'
        ]);
    }

    public function handleLogin()
    {
        if (! $this->isRequestMethodCorrect('POST')) {
            redirect(base_url('users'));
        }

        $this->load->model('Users_model');
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->Users_model->getUserByEmail($email);

        if ($user == null || ! password_verify($password, $user->password ?? null)) {
            $this->session->set_flashdata('error', 'Wrong Email or Password');
            redirect(base_url('login'), 'refresh');
            exit;
        }

        $userdata = [
            'id' => (int)$user->id,
            'name' => $user->name,
            'isLogged' => true
        ];
        $this->session->set_userdata($userdata);

        redirect(base_url('dashboard'));
    }

    public function handleRegister()
    {
        if (! $this->isRequestMethodCorrect('POST')) {
            redirect(base_url() . 'users');
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[64]');
        $this->form_validation->set_rules('confirm', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha|max_length[64]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha|max_length[64]');

        if ($this->form_validation->run()) {
            $this->load->model('Users_model');
            $postData = $this->input->post();
            $postData['password'] = password_hash($postData['password'], PASSWORD_ARGON2I);

            $this->Users_model->addUser($postData);

            redirect(base_url() . 'login');
        } else {
            $this->load->view('partials/templateNotLogged', [
                'view' => 'users/register',
                'title' => 'Register'
            ]);
        }
    }

    private function isUserLogged(): bool
    {
        if ($this->session->userdata('isLogged') ?? null) {
            return true;
        }

        return false;
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }

    private function isRequestMethodCorrect($method): bool
    {
        if ($this->input->server('REQUEST_METHOD') != strtoupper($method)) {
            return false;
        }

        return true;
    }

    public function dashboard()
    {
        if (false === $this->isUserLogged()) {
            redirect(base_url('login'));
        }

        $this->load->model('Users_model');

        $data['userdata'] = $this->Users_model->getUserById($this->session->userdata('id'));

        $this->load->view('partials/template', array_merge($data, [
            'view' => 'users/dashboard',
            'title' => 'Dashboard',
            'activeNavLink' => 'dashboard'
        ]));
    }

    public function editProfile()
    {
        if (false === $this->isUserLogged()) {
            redirect(base_url('login'));
        }

        $this->load->model('Users_model');

        $data['user'] = $this->Users_model->getUserById(
            $this->session->userdata('id')
        );

        $this->load->view('partials/template', array_merge($data, [
            'view' => 'users/editProfile',
            'title' => 'Edit Profile',
            'activeNavLink' => 'editProfile'
        ]));
    }

    public function handleEdit()
    {
        if (false === $this->isUserLogged() || $this->isRequestMethodCorrect('POST') === false) {
            redirect(base_url('login'));
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_check_email_uniqueness|valid_email');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha|max_length[64]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha|max_length[64]');

        $data['user'] = new stdClass();
        $data['user']->email = $this->input->post('email');
        $data['user']->first_name = $this->input->post('first_name');
        $data['user']->last_name = $this->input->post('last_name');

        if ($this->form_validation->run()) {
            $this->load->model('Users_model');

            $this->Users_model->update(
                $data['user'],
                $this->session->userdata('id')
            );

            $this->session->set_userdata('name', $this->input->post('first_name'));
            $this->session->set_flashdata('success', 'Changes were saved successfully');

            redirect(base_url('dashboard'));
        } else {
            $this->load->view('partials/template', array_merge($data, [
                'view' => 'users/editProfile',
                'title' => 'Edit Profile',
                'activeNavLink' => 'editProfile'
            ]));
        }
    }

    public function check_email_uniqueness($email): bool
    {
        // This method checks if the given email already exists.
        // It should return false if the email exists (meaning it's not unique),
        // unless it exists but it's the same

        $this->load->model('Users_model');
        $currentUser = $this->Users_model->getUserById($this->session->userdata('id'));

        // If email is not changed
        if ($currentUser->email == $email) {
            return true;
        }

        $emailOwner = $this->Users_model->getUserByEmail($email);

        // No user with same email
        if ($emailOwner == null) {
            return true;
        }

        // Reaching this point means that there is user with this email
        $this->form_validation->set_message('check_email_uniqueness', 'The new email must be unique.');
        return false;
    }

    public function changePassword()
    {
        if (! $this->isUserLogged()) {
            redirect(base_url('login'));
        }

        $this->load->view('partials/template', [
            'view' => 'users/changePassword',
            'title' => 'Change Password',
            'activeNavLink' => ''
        ]);
    }

    public function handleChangePassword()
    {
        if (false === $this->isUserLogged() || $this->isRequestMethodCorrect('POST') === false) {
            redirect(base_url('login'));
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[64]|callback__notMatchesOldPassword');
        $this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'trim|required|matches[new_password]');
        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|callback__matchesOldPassword');

        if ($this->form_validation->run()) {
            $this->load->model('Users_model');

            $this->Users_model->updatePassword(
                password_hash(
                    $this->input->post('new_password'),
                    PASSWORD_ARGON2I),
                $this->session->userdata('id')
            );

            $this->session->set_flashdata('success', 'Password was changed successfully.');
            redirect(base_url('dashboard'));
        } else {
            $this->load->view('partials/template', [
               'view' => 'users/changePassword',
               'title' => 'Change Password',
               'activeNavLink' => ''
            ]);
        }
    }

    public function _notMatchesOldPassword($password): bool
    {
        $this->load->model('Users_model');
        $currentUser = $this->Users_model->getUserById($this->session->userdata('id'));

        if (password_verify($password, $currentUser->password)) {
            $this->form_validation->set_message('_notMatchesOldPassword', 'The new password cannot be the same as the old one.');
            return false;
        }

        return true;
    }

    public function _matchesOldPassword($password): bool
    {
        $this->load->model('Users_model');
        $currentUser = $this->Users_model->getUserById($this->session->userdata('id'));

        if (! password_verify($password, $currentUser->password)) {
            $this->form_validation->set_message('_matchesOldPassword', 'Old password is incorrect');
            return false;
        }

        return true;
    }

    public function uploadPicture()
    {
        if (! $this->isUserLogged()) {
            redirect(base_url('login'));
        }

        $data['errors'] = '';

        $this->load->view('partials/template', array_merge($data, [
            'view' => 'users/uploadPicture',
            'title' => 'Upload Profile Picture',
            'activeNavLink' => ''
        ]));
    }

    public function handlePictureUpload()
    {
        if (! $this->isUserLogged() || $this->isRequestMethodCorrect('POST') === false) {
            redirect(base_url('dashboard'));
        }

        $tmpName = $_FILES['filename']['tmp_name'];
        $type = $_FILES['filename']['type'];
        $size = $_FILES['filename']['size'];

        $errors = [];

        $globalError = $_FILES['filename']['error'];
        if ($globalError) {
            if ($globalError == UPLOAD_ERR_INI_SIZE || $globalError == UPLOAD_ERR_FORM_SIZE) {
                $errors[] = self::UPLOAD_IMAGE_TOO_BIG_MESSAGE;
            } elseif ($globalError == UPLOAD_ERR_NO_FILE) {
                $errors[] = self::UPLOAD_IMAGE_NO_FILE_SEND_MESSAGE;
            }
        } else {
            if ($size > self::MAX_UPLOAD_IMAGE_SIZE) {
                $errors[] = self::UPLOAD_IMAGE_TOO_BIG_MESSAGE;
            }

            if (strpos($type, self::ALLOWED_IMAGE_PREFIX) !== 0) {
                $errors[] = self::UPLOAD_IMAGE_BAD_FILE_TYPE_MESSAGE;
            }
        }

        if ($errors) {
            $data['errors'] = $errors;
            $this->load->view('partials/template', array_merge($data, [
                'view' => 'users/uploadPicture',
                'title' => 'Upload Profile Picture',
                'activeNavLink' => ''
            ]));
        } else {
            $imageName = uniqid('profile_') . '.' . explode('/', $type)[1];
            $filePath = FCPATH . self::UPLOAD_IMAGE_DESTINATION . $imageName;

            if (! move_uploaded_file(
                $tmpName,
                $filePath
            )) {
                $errors[] = 'An error appeared while uploading your picture. Please try again or contact us.';
            } else {
                $this->load->model('Users_model');
                $this->Users_model->setProfilePicture($this->session->userdata('id'), $imageName);
                redirect(base_url('dashboard'));
            }
        }
    }

    public function viewAll()
    {
        $this->load->library('pagination');
        $this->load->model('Users_model');

        $usersCount = $this->Users_model->getUsersCount();

        $page = $this->input->get('page');

        if ($page != null) { // if page is set
            $requestUrl = base_url('view-all-users') . '?page=' . $page;

            $data['orderByEmailLink'] = $requestUrl . '&order=email';
            $data['orderByNameLink'] = $requestUrl . '&order=name';
            $data['orderByLastNameLink'] = $requestUrl . '&order=lastname';
        } else {
            $requestUrl = base_url('view-all-users');

            $data['orderByEmailLink'] = $requestUrl . '?order=email';
            $data['orderByNameLink'] = $requestUrl . '?order=name';
            $data['orderByLastNameLink'] = $requestUrl . '?order=lastname';
        }

        $order = $this->input->get('order') ?? null;

        if ($order != 'email' && $order != 'name' && $order != 'lastname') {
            $order = '';
        }

        $paginationConfig = [
            'base_url' => ($order) ? base_url("view-all-users?order=$order") : base_url('view-all-users '),
            'total_rows' => $usersCount,
            'per_page' => self::USERS_PER_PAGE,
            'full_tag_open' => '<p>',
            'full_tag_close' => '</p>',
            'first_tag_open' => '<span class="pagination_btn">',
            'first_tag_close' => '</span>',
            'last_tag_open' => '<span class="pagination_btn">',
            'last_tag_close' => '</span>',
            'next_link' => '<span class="pagination_btn">&gt;</span>',
            'prev_link' => '<span class="pagination_btn">&lt;</span>',
            'cur_tag_open' => '<strong class="pagination_btn">',
            'cur_tag_close' => '</strong>',
            'num_tag_open' => '<span class="pagination_btn">',
            'num_tag_close' => '</span>',
            'page_query_string' => true,
            'query_string_segment' => 'page'
        ];

        $this->pagination->initialize($paginationConfig);

        $offset = $this->input->get('page');

        $data['users'] = $this->Users_model->getUsersWithOffset(self::USERS_PER_PAGE, $offset, $order);
        $data['links'] = $this->pagination->create_links();

        $this->load->view('partials/template', array_merge($data, [
            'view' => 'users/allUsers',
            'title' => 'All Users',
            'activeNavLink' => 'allUsers'
        ]));
    }

    public function notFound()
    {
        $this->load->view('partials/templateNotLogged', [
            'view' => 'errors/notFound',
            'title' => 'Not Found'
        ]);
    }
}