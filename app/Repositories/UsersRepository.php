<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersRepository
{
    public function all()
    {
        return User::orderBy('id', 'desc')->get();
    }

    public function paginate($limit = 15)
    {
        return User::orderBy('id', 'desc')
        ->paginate($limit);
    }

    public function getBy($col, $value, $limit = 15)
    {
        return User::where($col, $value)
        ->limit($limit)
        ->get();
    }

    public function create(array $data)
    {
        // return User::create($data);
        return User::create([
            'name' => $data['name'] ,
            'email' => $data['email'] ,
            'password' => Hash::make($data['password'] ),
            'role_id'=>1,
            'comment'=>$data['comment']
        ]);
    }
    public function find($email)
    {
        // return User::find($email);
        return User::where('email', $email)->firstOrFail();

    }

    public function update(array $data)
    {
        return User::update($data);
    }

    public function delete($model)
    {
        return $model->delete();
    }

    public function exists($id)
    {
        return User::where('id', $id)->exists();
    }

    public function getByUserId($id)
    {
       return User::where('user_id', $id)
          ->select('id', 'user_id', 'body')
          ->with('user')
          ->get();
    }
}
