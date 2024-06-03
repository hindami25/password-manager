<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use Config\Services;

class UserController extends Controller
{
    public function register()
    {
        helper(['form', 'url']);

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('register', ['validation' => $validation]);
        }

        $userModel = new UserModel();
        $password = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
        $masterKey = bin2hex(random_bytes(32));
        $masterKeyEncrypted = encrypt($masterKey);

        $userModel->save([
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password_hash' => $password,
            'master_key_encrypted' => $masterKeyEncrypted
        ]);

        return redirect()->to('/login');
    }

    public function login()
    {
        helper(['form', 'url']);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('login', ['validation' => $validation]);
        }

        $userModel = new UserModel();
        $user = $userModel->getUserByUsername($this->request->getVar('username'));

        if ($user && password_verify($this->request->getVar('password'), $user['password_hash'])) {
            $session = session();
            $session->set('isLoggedIn', true);
            $session->set('user_id', $user['id']);
            $session->set('master_key', decrypt($user['master_key_encrypted']));

            return redirect()->to('/dashboard');
        }

        return view('login', ['error' => 'Invalid login credentials']);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function forgotPassword()
    {
        helper(['form', 'url']);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('forgot_password', ['validation' => $validation]);
        }

        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($this->request->getVar('email'));

        if ($user) {
            $resetToken = bin2hex(random_bytes(32));
            $resetTokenExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $userModel->update($user['id'], [
                'reset_token' => $resetToken,
                'reset_token_expiry' => $resetTokenExpiry
            ]);

            $resetLink = base_url('/reset_password/' . $resetToken);
            $email = \Config\Services::email();
            $email->setTo($user['email']);
            $email->setSubject('Password Reset Request');
            $email->setMessage('Click the following link to reset your password: ' . $resetLink);
            $email->send();

            return view('forgot_password', ['message' => 'Password reset link has been sent to your email']);
        }

        return view('forgot_password', ['error' => 'Email address not found']);
    }

    public function resetPassword($resetToken)
    {
        helper(['form', 'url']);

        $userModel = new UserModel();
        $user = $userModel->getUserByResetToken($resetToken);

        if (!$user || $user['reset_token_expiry'] < date('Y-m-d H:i:s')) {
            return view('reset_password', ['error' => 'Invalid or expired reset token']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'password' => 'required|min_length[8]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('reset_password', ['validation' => $validation, 'resetToken' => $resetToken]);
        }

        $newPasswordHash = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);

        $userModel->update($user['id'], [
            'password_hash' => $newPasswordHash,
            'reset_token' => null,
            'reset_token_expiry' => null
        ]);

        return view('reset_password', ['message' => 'Password has been reset successfully', 'resetToken' => $resetToken]);
    }
}
