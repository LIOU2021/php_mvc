<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{

    private $model;

    public function __construct()
    {
        $this->model = new User();
    }
    /**
     * get all user data
     */
    public function all()
    {
        $data = $this->model->all();

        foreach ($data as $index => $item) {
            $data[$index]['isGmal'] = false;
            if (strpos($item['email'], '@gmail.com')) {
                $data[$index]['isGmal'] = true;
            }
        }

        return $data;
    }

    /**
     * find user by id
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
}
