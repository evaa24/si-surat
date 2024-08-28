<?php

namespace App\Http\Controllers\WakilPimpinan;

use App\Http\Controllers\Controller;
use App\Models\AdminKategoriService;
use App\Models\MainSuratService;
use App\Models\WakilSuratMasukService;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    protected $wakilSuratService;
    protected $mainService;
    protected $kategoriService;


    public function __construct()
    {
        $this->wakilSuratService = new WakilSuratMasukService();
        $this->mainService = new MainSuratService();
        $this->kategoriService = new AdminKategoriService();
    }
    public function index()
    {
        $listHistory = $this->wakilSuratService->riwayatSurat()->getData('data')['data']['riwayat_surat'];
        $listKategori = $this->kategoriService->getListKategori()->getData('data')['data']['kategori'];

        foreach ($listHistory as $datumHistoryKey => $datumHistoryValue) {
            foreach ($listKategori as $datumKategori) {
                if ($datumHistoryValue['kategori_id'] == $datumKategori['kategori_id']) {
                    $listHistory[$datumHistoryKey]['kategori_surat'] = $datumKategori['nama'];
                }
            }
        }

        // echo '<pre>';
        // // print_r($listHistory[0]['disposisi']['catatan']);
        // print_r($listHistory);
        // echo '</pre>';
        // exit();
        return view('dashboard.wakil_pimpinan.history.index', ['riwayat_surat' => $listHistory, 'kategori' => $listKategori]);
    }
}
