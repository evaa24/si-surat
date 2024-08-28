<?php

namespace App\Http\Controllers\WakilPimpinan;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        return view('dashboard.wakil_pimpinan.surat_keluar.surat_keluar');
    }
}
