<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

// ? Web Service
use App\Models\MainSuratService;

class HomeController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new MainSuratService();
    }

    public function home()
    {
        $statistik = $this->service->getStatistik()->getData('data')['data']['statistik'];

        return view('dashboard.home', [
            'title' => 'Home',
            'data' => [
                'statistik' => $statistik
            ]
        ]);
    }
}
