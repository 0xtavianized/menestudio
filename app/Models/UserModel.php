<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $allowedFields = ['username', 'email', 'nama_lengkap', 'alamat', 'no_hp', 'password', 'role', 'foto_profil'];
    public function setPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
