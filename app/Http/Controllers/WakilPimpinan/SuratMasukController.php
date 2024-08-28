<?php

namespace App\Http\Controllers\WakilPimpinan;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index()
    {
        return view('dashboard.wakil_pimpinan.surat_masuk.surat_masuk');
    }
}
