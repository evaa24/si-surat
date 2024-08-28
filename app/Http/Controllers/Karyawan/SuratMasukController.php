<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\KaryawanSuratMasukService;
use App\Models\MainSuratService;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    protected $mainService;
    protected $suratMasukService;

    public function __construct()
    {
        $this->mainService = new MainSuratService();
        $this->suratMasukService = new KaryawanSuratMasukService();
    }

    public function index()
    {
        $listSurat = $this->suratMasukService->getListSurat()->getData('data')['data']['list_surat_masuk'];

        // echo '<pre>';
        // print_r($this->suratMasukService->getListSurat());
        // print_r($_SERVER);
        // print_r($listSurat);
        // echo '</pre>';
        // exit;

        return view('dashboard.karyawan.surat_masuk.surat_masuk', [
            'list_surat' => $listSurat
        ]);
    }

    public function terima_surat(Request $request)
    {

        $data = $request->all();
        $surat_masuk_id = $request->surat_masuk_id;


        $statusResponse = $this->suratMasukService->terimaSurat($surat_masuk_id);
    }
}
