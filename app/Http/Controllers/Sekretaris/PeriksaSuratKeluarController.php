<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\MainSuratService;
use App\Models\SekretarisSuratKeluarService;
use Illuminate\Http\Request;

class PeriksaSuratKeluarController extends Controller
{

    protected $sekretarisSuratKeluar;
    protected $mainService;

    public function __construct()
    {
        $this->sekretarisSuratKeluar = new SekretarisSuratKeluarService();
        $this->mainService = new MainSuratService();
    }

    public function periksa_surat_keluar()
    {
        $listSuratKeluar = $this->sekretarisSuratKeluar->getListSuratUntukDiperiksa()->getData('data')['data']['list_surat_keluar'];
        $listStatus = $this->sekretarisSuratKeluar->getListStatus()->getData('data')['data']['list_status'];
        $listStaff = $this->mainService->getListStaff()->getData('data')['data']['list_staff'];

        // echo '<pre>';
        // print('bb');
        // print_r($listStatus);
        // print_r($listStaff);
        // echo '</pre>';
        // exit;
        return view('dashboard.sekretaris.periksa_sk.periksa_surat_keluar', ['list_surat_keluar' => $listSuratKeluar, 'list_status' => $listStatus, 'list_staff' => $listStaff]);
    }

    public function ajukan_surat_keluar(Request $request)
    {

        $data = $request->all();
        // echo '<pre>';
        // print_r('masukk');
        // print_r($data);
        // echo '</pre>';
        // exit;
        // $surat_masuk_id = $request->surat_masuk_id;
        // $user_id = $request->ajukan_ke_user_id;
        // $status_id = $request->status_id;
        // $tindakan = $request->tindakan;

        $statusResponse = $this->sekretarisSuratKeluar->updateStatusSuratDiperiksa($data);
        // echo '<pre>';
        // print_r('masukk');
        // print_r($statusResponse);
        // echo '</pre>';
        // exit;
    }
}
