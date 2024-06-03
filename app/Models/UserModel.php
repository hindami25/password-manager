<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['username', 'email', 'password_hash', 'master_key_encrypted', 'reset_token', 'reset_token_expiry'];
    //protected $useTimestamps = true;

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getUserByResetToken($resetToken)
    {
        return $this->where('reset_token', $resetToken)->first();
    }
}
