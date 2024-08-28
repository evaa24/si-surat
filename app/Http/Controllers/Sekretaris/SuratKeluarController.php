<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        return view('dashboard.sekretaris.surat_keluar.surat_keluar');
    }
}
