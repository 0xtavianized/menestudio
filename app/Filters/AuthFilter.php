<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $path = $request->getUri()->getPath();
        $segments = explode('/', trim($path, '/'));

        if ($segments[0] === 'index.php') {
            array_shift($segments);
        }

        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $role = session()->get('role');
        $isAdminPath = !empty($segments) && $segments[0] === 'admin';

        if ($role === '1') {
            if (!$isAdminPath) {
                return redirect()->to(base_url('admin/dashboard'))->with('error', 'Admin hanya dapat mengakses halaman admin.');
            }
        } elseif ($role === '2') {
            if ($isAdminPath) {
                return redirect()->to(base_url('505'))->with('error', 'Anda tidak memiliki akses ke halaman admin.');
            }
        } else {
            session()->destroy();
            return redirect()->to(base_url('login'))->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada yang perlu dilakukan setelah request
    }
}