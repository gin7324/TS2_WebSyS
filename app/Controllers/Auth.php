<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/');
        }

        return view('auth/login', ['title' => 'Log In']);
    }

    public function attemptLogin()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $user = (new UserModel())->where('username', $username)->first();

        if ($user === null || ! password_verify($password, $user['password'] ?? '')) {
            return redirect()->to('/login')->with('error', 'The username or password is incorrect.');
        }

        session()->regenerate(true);
        session()->set([
            'user_id'  => $user['id'],
            'username' => $user['username'],
        ]);

        return redirect()->to('/')->with('success', 'You are now logged in.');
    }

    public function logout()
    {
        session()->remove(['user_id', 'username']);
        session()->regenerate(true);

        return redirect()->to('/login')->with('success', 'You are now logged out.');
    }
}