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

    public function login()
    {
        if ($this->isUserLogged()) {
            redirect(base_url('dashboard'));
        }

        $this->load->view('users/login');
    }

    public function register()
    {
        if ($this->isUserLogged()) {
            redirect(base_url('dashboard'));
        }

        $this->load->view('users/register');
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
            $this->load->view('users/register');
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

        $this->load->view('users/dashboard', $data);
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

        $this->load->view('users/editProfile', $data);
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
            $this->load->view('users/editProfile', $data);
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
        return false;
    }

    public function changePassword()
    {
        if (! $this->isUserLogged()) {
            redirect(base_url('login'));
        }

        $this->load->view('users/changePassword');
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
            $this->load->view('users/changePassword');
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

        $data['error'] = '';

        $this->load->view('users/uploadPicture', $data);
    }

    public function handlePictureUpload()
    {
        if (! $this->isUserLogged() || $this->isRequestMethodCorrect('POST') === false) {
            redirect(base_url('dashboard'));
        }

        $targetDir = 'uploads/';
        $targetFile = $targetDir . basename($_FILES['filename']['name']);
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["filename"]["tmp_name"] ?? '');

        var_dump($check);
    }

    public function viewAll()
    {
        $this->load->library('pagination');
        $this->load->model('Users_model');

        $usersCount = $this->Users_model->getUsersCount();

        $config = [
            'base_url' => base_url('view-all-users'),
            'total_rows' => $usersCount,
            'per_page' => self::USERS_PER_PAGE,
            'full_tag_open' => '<p>',
            'full_tag_close' => '</p>',
            'next_link' => ' &gt; ',
            'prev_link' => ' &lt; ',
            'cur_tag_open' => ' <strong>',
            'cur_tag_close' => '</strong> ',
            'num_tag_open' => '<span>',
            'num_tag_close' => '</span>',
            'page_query_string' => true,
            'query_string_segment' => 'page'
        ];

        $this->pagination->initialize($config);

        $offset = $this->input->get('page');

        $data['users'] = $this->Users_model->getUsersWithOffset(self::USERS_PER_PAGE, $offset);
        $data['links'] = $this->pagination->create_links();

        $this->load->view('users/allUsers', $data);
    }
}