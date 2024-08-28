<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\AdminKategoriService;
use App\Models\MainSuratService;
use App\Models\SekretarisSuratMasukService;
use Illuminate\Http\Request;

class HistoryController extends Controller
{

    protected $sekretarisSuratMasuk;
    protected $mainService;
    protected $kategoriService;


    public function __construct()
    {
        $this->sekretarisSuratMasuk = new SekretarisSuratMasukService();
        $this->mainService = new MainSuratService();
        $this->kategoriService = new AdminKategoriService();
    }

    public function index()
    {

        $listHistory = $this->sekretarisSuratMasuk->riwayatSurat()->getData('data')['data']['riwayat_surat'];
        $listKategori = $this->kategoriService->getListKategori()->getData('data')['data']['kategori'];

        foreach ($listHistory as $datumHistoryKey => $datumHistoryValue) {
            foreach ($listKategori as $datumKategori) {
                if ($datumHistoryValue['kategori_id'] == $datumKategori['kategori_id']) {
                    $listHistory[$datumHistoryKey]['kategori_surat'] = $datumKategori['nama'];
                }
            }
        }

        // echo '<pre>';
        // print_r($listHistory);
        // echo '</pre>';
        // exit();
        return view('dashboard.sekretaris.history.index', ['riwayat_surat' => $listHistory, 'kategori' => $listKategori]);
    }
}
