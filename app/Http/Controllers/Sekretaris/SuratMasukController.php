<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\AdminSuratMasukService;
use Illuminate\Http\Request;
use App\Models\SekretarisSuratMasukService;

class SuratMasukController extends Controller
{
    protected $suratMasukService;


    public function __construct()
    {
        // $this->suratMasukService = new SekretarisSuratMasukService();
        $this->suratMasukService = new SekretarisSuratMasukService();
    }

    public function index()
    {

        $listSurat = $this->suratMasukService->getListSuratMilikSendiri()->getData('data')['data']['list_surat_masuk'];
        // echo '<pre>';
        // print_r($listSurat);
        // echo '</pre>';
        // exit;

        return view('dashboard.sekretaris.surat_masuk.surat_masuk', [
            'title' => 'Data Surat Masuk',
            'data' => [
                'list_surat_masuk' => $listSurat
            ]
        ]);
    }
}
