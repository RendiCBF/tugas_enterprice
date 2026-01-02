<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
{
    $userRole = session()->get('role'); // Ambil role dari session

    if ($arguments) {
        // in_array akan mengecek apakah role user ada di dalam daftar argumen rute
        if (!in_array($userRole, $arguments)) {
            return redirect()->to('/error403');
        }
    }
}

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Kosongkan
    }
}