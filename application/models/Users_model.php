<?php

/**
 * Class Users_model
 * @property CI_DB_query_builder db
 */

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

    public function getUserByEmail(string $email)
    {
        $this->db->select('id, email, password, name, lastname');
        $this->db->from('users');
        $this->db->where('email', $email);

        return $this->db->get()->row();
    }

    public function getUserById(int $id)
    {
        $this->db->select('id, email, password, name AS first_name, lastname AS last_name, picture_url');
        $this->db->from('users');
        $this->db->where('id', $id);

        return $this->db->get()->row();
    }

    public function update($userdata, $userId)
    {
        $this->db->set('email', $userdata->email);
        $this->db->set('name', $userdata->first_name);
        $this->db->set('lastname', $userdata->last_name);

        $this->db->where('id', $userId);

        $this->db->update('users');
    }

    public function updatePassword(string $password, int $id)
    {
        $this->db->set('password', $password);
        $this->db->where('id', $id);
        $this->db->update('users');
    }

    public function getUsersCount()
    {
        $this->db->select('count(*) as count');
        $this->db->from('users');

        return (int)$this->db->get()->row()->count;
    }

    public function getUsersWithOffset(int $limit, $offset = 0)
    {
        $this->db->select('id, email, name AS first_name, lastname AS last_name');
        $this->db->from('users');
        $this->db->limit($limit);
        $this->db->offset($offset);

        return $this->db->get()->result();
    }
}