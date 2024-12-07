<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PaketModel;

class Paket extends BaseController
{
    protected $paketModel;

    public function __construct()
    {
        $this->paketModel = new PaketModel();
    }
    public function index()
    {
        $userModel = new UserModel();
        $userId = session()->get('id_user');
        $user = $userModel->find($userId);

        $paketModel = new PaketModel();
        $data['items'] = $paketModel->getPaket();
        $data['user'] = $user;

        return view('back/paket/index', $data);
    }

    public function tambah()
    {
        $userModel = new UserModel();
        $userId = session()->get('id_user');
        $user = $userModel->find($userId);
        return view('back/paket/tambah', ['user' => $user]);
    }

    public function create()
    {
        $this->validate([
            'paket' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'required|uploaded[gambar]|is_image[gambar]|max_size[gambar,2048]'
        ]);

        $paketModel = new PaketModel();
        $gambar = $this->request->getFile('gambar');
        $randoms = $gambar->getRandomName();

        $data = [
            'paket' => $this->request->getPost('paket'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => str_replace('.', '', $this->request->getPost('harga')),
            'gambar' => $randoms,
        ];

        $this->request->getFile('gambar')->move('uploads/paket/', $data['gambar']);

        $paketModel->insert($data);

        session()->setFlashdata('sukses', 'Paket berhasil ditambahkan!');
        return redirect()->to(base_url('admin/paket'));
    }

    public function edit($id_paket)
    {
        $userModel = new UserModel();
        $paketM = new PaketModel();
        $userId = session()->get('id_user');
        $user = $userModel->find($userId);

        $paket = $paketM->find($id_paket);
        if (!$paket) {
            return redirect()->to('/admin/paket')->with('error', 'Paket tidak ditemukan.');
        }
        return view('back/paket/edit', [
            'paket' => $paket,
            'user' => $user
        ]);
    }
    public function update($id_paket)
    {
        $this->validate([
            'paket' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
        ]);

        $paketLama = $this->paketModel->find($id_paket);

        $data = [
            'paket' => $this->request->getPost('paket'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => str_replace('.', '', $this->request->getPost('harga')),
        ];

        if ($this->request->getFile('gambar')->isValid()) {
            $gambar = $this->request->getFile('gambar');
            $newName = $gambar->getRandomName();

            if ($paketLama['gambar']) {
                $gambarLama = 'uploads/paket/' . $paketLama['gambar'];
                if (file_exists($gambarLama)) {
                    unlink($gambarLama);
                }
            }

            $gambar->move('uploads/paket/', $newName);
            $data['gambar'] = $newName;
        } else {
            $data['gambar'] = $paketLama['gambar'];
        }

        // Update data ke database
        $this->paketModel->update($id_paket, $data);

        return redirect()->to('/admin/paket')->with('sukses', 'Paket berhasil diperbarui.');
    }

    public function delete($id_paket)
    {
        $paketModel = new PaketModel();
        $paket = $paketModel->find($id_paket);

        if ($paket) {
            if (file_exists('uploads/' . $paket['gambar'])) {
                unlink('uploads/' . $paket['gambar']);
            }
            $paketModel->delete($id_paket);
            session()->setFlashdata('sukses', 'Paket berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Paket tidak ditemukan!');
        }

        return redirect()->to(base_url('admin/paket'));
    }

}