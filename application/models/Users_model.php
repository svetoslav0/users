<?php


class Users_model extends CI_Model
{
    public function addUser($postData)
    {
        $data = [
            'email' => $postData['email'],
            'password' => $postData['password'],
            'name' => $postData['first_name'],
            'lastname' => $postData['last_name']
        ];

        $this->db->insert('users', $data);
    }

    public function emailExists(string $email): bool
    {
        $this->db->select('email');
        $this->db->from('users');
        $this->db->where('email', $email);

        $result = $this->db->get()->row();

        return ($result == null) ? false : true;
    }

    public function getUserByEmail(string $email)
    {
        $this->db->select('id, email, password, name, lastname');
        $this->db->from('users');
        $this->db->where('email', $email);

        return $this->db->get()->row();
    }
}