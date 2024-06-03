<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordModel extends Model
{
    protected $table = 'passwords';
    protected $allowedFields = ['user_id', 'website', 'username', 'password_encrypted'];
    //protected $useTimestamps = true;
}
