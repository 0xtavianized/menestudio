<?php

namespace App\Controllers;
use App\Models\PaketModel;
use App\Models\UserModel;
use App\Models\TransaksiModel;

class User extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->paketModel = new PaketModel();
    }
    public function index()
    {
        if (session()->get('role') == '1') {
            return redirect()->to(base_url('admin/dashboard'));
        } else {
            $data['paket'] = $this->paketModel->findAll();
            return view('front/index', $data);
        }
    }

    public function paket()
    {
        if (session()->get('role') == '1') {
            return redirect()->to(base_url('admin/dashboard'));
        } else {
            $paketModel = new PaketModel();
            $data['paket'] = $paketModel->getPaket();
            return view('front/paket', $data);
        }
    }

    public function profile()
    {
        if (session()->get('role') == '1') {
            return redirect()->to(base_url('admin/dashboard'));
        } else if (session()->get('role') == '2') {
            $userId = session()->get('id_user');

            $user = $this->userModel->find($userId);

            if (!$user) {
                return redirect()->to('/profile')->with('error', 'User not found.');
            }

            return view('front/user/index', ['user' => $user]);
        } else {
            return redirect()->to(base_url());
        }
    }
    public function editprofile()
    {
        if (session()->get('role') == '1') {
            return redirect()->to(base_url('admin/dashboard'));
        } else if (session()->get('role') == '2') {
            $userId = session()->get('id_user');

            $user = $this->userModel->find($userId);

            if (!$user) {
                return redirect()->to('/profile')->with('error', 'User not found.');
            }

            return view('front/user/edit', ['user' => $user]);
        } else {
            return redirect()->to(base_url());
        }
    }
    public function updatePhoto($userId)
    {
        if (session()->get('role') == '1') {
            return redirect()->to(base_url('admin/dashboard'));
        } else if (session()->get('role') == '2') {
            $userId = session()->get('id_user');

            $foto_profil = $this->request->getFile('foto_profil');

            $this->validate([
                'foto_profil' => 'uploaded[foto_profil]|is_image[foto_profil]|max_size[foto_profil,2048]', // Maksimal ukuran file 2MB
            ]);

            if ($foto_profil->isValid()) {
                $newName = $foto_profil->getRandomName();
                $foto_profil->move('uploads/foto_profil/', $newName);
                $data = [
                    'foto_profil' => $newName
                ];
                $this->userModel->update($userId, $data);

                return redirect()->to('/profile')->with('sukses', 'Foto berhasil diperbarui.');
            } else {
                return redirect()->back()->with('error', 'Gagal mengunggah foto. Pastikan file valid.');
            }
        } else {
            return redirect()->to(base_url());
        }
    }
    public function updateProfile($id_user)
    {
        if (session()->get('role') == '1') {
            return redirect()->to(base_url('admin/dashboard'));
        } else if (session()->get('role') == '2') {
            $userModel = new UserModel();

            $data = [
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'email' => $this->request->getPost('email'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
            ];

            $fotoProfil = $this->request->getFile('foto_profil');
            if ($fotoProfil && $fotoProfil->isValid()) {
                $newName = $fotoProfil->getRandomName();

                $fotoProfil->move('uploads/foto_profil', $newName);

                $data['foto_profil'] = $newName;
            }

            $password = $this->request->getPost('password');
            $hashpas = password_hash($password, PASSWORD_DEFAULT);
            if ($hashpas) {
                $data['password'] = $hashpas;
            }

            $userModel->update($id_user, $data);

            session()->setFlashdata('success', 'Profil berhasil diperbarui.');

            return redirect()->to(base_url('profile'));
        } else {
            return redirect()->to(base_url());
        }
    }
}
