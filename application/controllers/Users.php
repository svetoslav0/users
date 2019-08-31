<?php


class Users extends CI_Controller
{
    public function index()
    {
        echo 'this is home page';
    }

    public function login()
    {

        $this->load->view('users/login');
    }

    public function register()
    {
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
            'id' => $user->id,
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

    private function isRequestMethodCorrect($method): bool
    {
        if ($this->input->server('REQUEST_METHOD') != strtoupper($method)) {
            return false;
        }

        return true;
    }

    public function dashboard()
    {

        $this->load->view('users/dashboard');
    }
}