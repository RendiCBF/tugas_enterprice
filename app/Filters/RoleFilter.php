<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // 2. Cek apakah role user ada di dalam daftar argumen yang diperbolehkan
        // Contoh: filter role[Admin] berarti $arguments berisi ['Admin']
        if ($arguments) {
            if (!in_array(session()->get('role'), $arguments)) {
                // Jika tidak punya akses, lempar ke halaman 403
                return redirect()->to('/error403');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Kosongkan saja
    }
}