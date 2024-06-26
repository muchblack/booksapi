<?php

namespace App\Http\Services;

use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(Users $users){
        $this->users = $users;
    }

    public function getLogin($data): array
    {
        $user = $this->users->where('email', $data['email'])->first();
        if($user)
        {
            if(Hash::check($data['password'], $user->password)){
                $token = Hash::make(date('Y-m-d H:i:s'));
                $user->apiToken = $token;
                $user->save();
                return ['status'=> 0 , 'token'=>$token];
            }
            else
            {
                return ['status'=> 1, 'msg' => 'login failed'];
            }
        }
        else
        {
            return ['status'=> 1, 'msg' => 'user not found'];
        }
    }

    public function setRegister($data): array
    {
        $user = $this->users->where('email', $data['email'])->first();
        if($user)
        {
            return ['status'=> 1, 'msg' => 'user already exists'];
        }
        else
        {
            $this->users->create([
                'userName'=> $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            return ['status'=> 0, 'msg' => 'user has been created'];
        }
    }

    public function getUserFromApiToken($apiToken) {
        $user = $this->users->where('apiToken',$apiToken)->first();
        if($user)
        {
            return $user;
        }
        return [];
    }

    public function getAllUsers(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->users->all();
    }

}
