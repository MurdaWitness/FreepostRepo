<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;

class RegisterController extends Controller
{
    public function index(): void
    {
        $this->view('register', [], 'Registration - FreepostRepo');
    }

    public function register(): void
    {
        $validation = $this->request()->validate([
            'email' => ['required', 'email'],
            'username' => ['required'],
            'password' => ['required', 'min:8'],
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/register');
        }

        $this->db()->insert('users', [
            'email' => $this->request()->input('email'),
            'username' => $this->request()->input('username'),
            'password' => password_hash($this->request()->input('password'), PASSWORD_DEFAULT)
        ]);

        $this->redirect('/');
    }
}
