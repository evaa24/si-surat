<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainSuratService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $mainService;

    public function __construct()
    {
        $this->mainService = new MainSuratService();
    }

    public function index() {
        $listStaff = $this->mainService->getListStaff()->getData('data')['data'];

        return view('dashboard.admin.pengguna.index', [
            'title' => 'Data Pengguna',
            'data' => $listStaff
        ]);
    }
}
