<?php

namespace App\Services;

use App\Model\User;
use Exception;

class AuthService
{
    protected $keyPassword = "isSecretKeyNumbber";
    public function changePassword($request, $id)
    {
        $userValid = USER::find($id);
        if (!$userValid) {
            return ['status' => false, 'message' => "user id Tidak Valid"];
        }
        if ($request['password'] == $request['oldpassword']) {
            return ['status' => false, 'message' => "Password Tidak boleh sama"];
        }
        $userPassValid = USER::where(["password" => md5($request['oldpassword'] . $this->keyPassword)])->update([
            "password" => md5($request['password'] . $this->keyPassword),
        ]);
        if (!$userPassValid) {
            return ['status' => false, 'message' => "Password Lama Salah"];
        }
        return ['status' => true, 'data' => $userPassValid];
    }
    public function signUp($request)
    {
        $emailValid = USER::where('email', $request['email'])->first();
        if ($emailValid) {
            return ['status' => false, 'message' => "email sudah terdaftar"];
        }
        return ['status' => true, 'data' => USER::create([
            "nama" => $request["nama"],
            "email" => $request['email'],
            "password" => md5($request['password'] . $this->keyPassword),
        ])];
    }
    public function login($request)
    {
        $emailValid = USER::where('email', $request['email'])->first();
        if (!$emailValid) {
            return ['status' => false, 'message' => "email tidak terdaftar"];
        }
        $password = md5($request['password'] . $this->keyPassword);
        $passwordlValid = USER::where('password', $password)->first();
        if (!$passwordlValid) {
            return ['status' => 'false', 'message' => 'password salah'];
        }
        $data = USER::where(['email' => $request['email'], 'password' => $password])->first();
        if (!$data) {
            return ['status' => false, 'message' => 'akun tidak ditemukan'];
        }
        return ['status' => true, 'data' => $data];
    }
}
