<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login(): mixed
    {
        if (session()->get('logged_in')) {
            $role = session()->get('role');
            if ($role === '1') {
                return redirect()->to(base_url('/admin/dashboard'));
            } else if ($role === '2') {
                return redirect()->to(base_url());
            }
        }
        return view('auth/login');
    }
    public function regist(): string
    {
        helper(['form']);
        $data = [];
        return view('auth/register', $data);
    }

    public function login_process()
    {
        $userModel = new UserModel();

        $usernameOrEmail = $this->request->getVar('username_or_email');
        $password = $this->request->getVar('password');

        $user = $userModel->where('username', $usernameOrEmail)
            ->orWhere('email', $usernameOrEmail)
            ->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                session()->set([
                    'id_user' => $user['id_user'],
                    'username' => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'email' => $user['email'],
                    'alamat' => $user['alamat'],
                    'no_hp' => $user['no_hp'],
                    'foto_profil' => $user['foto_profil'],
                    'role' => $user['role'],
                    'logged_in' => TRUE
                ]);

                if ($user['role'] === '1') {
                    return redirect()->to(base_url('/admin/dashboard'));
                } else if ($user['role'] === '2') {
                    return redirect()->to(base_url());
                }
            } else {
                session()->setFlashdata('error', 'Password salah.');
                return redirect()->back()->withInput();
            }
        } else {
            session()->setFlashdata('error', 'Username atau Email salah.');
            return redirect()->back()->withInput();
        }
    }
    public function create()
    {
        helper(['form']);

        $rules = [
            'username' => [
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'is_unique' => 'Username sudah ada, silahkan gunakan username yang lain.'
                ]
            ],
            'nama_lengkap' => 'required|min_length[3]|max_length[30]',
            'email' => [
                'rules' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                'errors' => [
                    'is_unique' => 'Email sudah ada, silakan gunakan email yang lain.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[5]|max_length[200]',
                'errors' => [
                    'min_length' => 'Password minimal 5 karakter'
                ]
            ],
            'no_hp' => 'permit_empty|min_length[10]|max_length[20]',
            'alamat' => 'permit_empty|max_length[255]',
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $nama = ucwords($this->request->getVar('nama_lengkap'));
            $data = [
                'username' => $this->request->getVar('username'),
                'nama_lengkap' => $nama,
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getVar('role'),
                'no_hp' => $this->request->getVar('no_hp'),
                'alamat' => $this->request->getVar('alamat'),
            ];
            $model->save($data);
            session()->setFlashdata('sukses', 'Registrasi Berhasil, silahkan Login');
            return redirect()->to(base_url('/register'));
        } else {
            $data['validation'] = $this->validator;
            return view('auth/register', $data);
        }
    }
    public function forget()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url());
        }
        return view('auth/forget');
    }
    public function reset()
    {
        $no_hp = $this->request->getPost('no_hp');
        if (empty($no_hp)) {
            return redirect()->back()->with('error', 'No. HP harus diisi');
        }

        $userModel = new UserModel();

        $user = $userModel->where('no_hp', $no_hp)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'No. HP tidak ditemukan');
        }

        $newPassword = $this->generateRandomPassword();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        log_message('debug', 'Attempting to update password for user ID: ' . $user['id_user']);
        log_message('debug', 'New hashed password: ' . $hashedPassword);

        $updateStatus = $userModel->update($user['id_user'], [
            'password' => $hashedPassword
        ]);

        log_message('debug', 'Update status: ' . ($updateStatus ? 'success' : 'failure'));

        if (!$updateStatus) {
            log_message('error', 'Gagal update password untuk user ID: ' . $user['id_user']);
            log_message('error', 'Last database error: ' . print_r($userModel->db->error(), true));
            return redirect()->back()->with('error', 'Gagal memperbarui password.');
        }

        $sendStatus = $this->sendPasswordViaFonnte($no_hp, $newPassword);

        if (!$updateStatus && !$sendStatus) {
            session()->setFlashdata('error', 'Gagal mengirim password baru. Silakan coba lagi.');
            $flashdata = session()->getFlashdata('error');
            log_message('debug', 'Flashdata set: ' . $flashdata);
            return redirect()->back();
        } else {
            $flashdata = session()->getFlashdata('success');
            log_message('debug', 'Flashdata set: ' . $flashdata);
            session()->setFlashdata('success', 'Password baru berhasil dikirim ke WhatsApp.');
            return redirect()->back();
        }
    }

    private function generateRandomPassword($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomPassword;
    }
    private function sendPasswordViaFonnte($phoneNumber, $newPassword)
    {
        $apiUrl = 'https://api.fonnte.com/send';
        $token = '3c3Rn39UQuMFTTn8cAKu';

        $data = [
            'target' => $phoneNumber,
            'message' => "Password baru Anda adalah: $newPassword \nSilakan login dengan password baru.",
            'countryCode' => '62',
        ];

        $headers = [
            'Authorization: ' . $token,
            'Content-Type: application/x-www-form-urlencoded',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        return isset($result['status']) && $result['status'] === 'success';
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }

    public function noauth()
    {
        return view('auth/505');
    }
}