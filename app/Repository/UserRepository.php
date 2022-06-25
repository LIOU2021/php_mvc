<?php

namespace App\Repository;

use App\Http\Request;
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

    /**
     * update user model by id
     */
    public function update($id, Request $request)
    {
        $user = $this->model;

        $originUserData = $user->find($id);

        $name = $request->name ?? $originUserData['name'];
        $email = $request->email ?? $originUserData['email'];
        $phone = $request->phone ?? $originUserData['phone'];

        $name = prepare($name);
        $email = prepare($email);
        $phone = prepare($phone);

        $user->query("update user set name = $name , email = $email , phone = $phone where id = $id;");
        return $user->exec();
    }

    public function create(Request $request)
    {
        $user = $this->model;

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;

        $name = prepare($name);
        $email = prepare($email)??"null";
        $phone = prepare($phone)??"null";

        if(!$name){
            helpReturn(502);
        }

        $user->query("insert into user (name,email,phone) values($name,$email,$phone);");

        return $user->exec();
    }

    /**
     * delete user model by id
     */
    public function delete($id){
        $user = $this->model;
        
        if(!is_numeric($id)){
            helpReturn(408,'your id : '.$id);
        }

        $user->query("delete from user where id = $id;");

        return $user->exec();
    }
}
