<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;

    // 1. Tambahkan helper 'form' dan 'url' agar fungsi redirect dan form lebih stabil
    protected $helpers = ['form', 'url'];

    // 2. Deklarasikan properti session
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // 3. Aktifkan Session di sini agar bisa digunakan di semua Controller (Order, Customer, dll)
        $this->session = \Config\Services::session();
    }
}