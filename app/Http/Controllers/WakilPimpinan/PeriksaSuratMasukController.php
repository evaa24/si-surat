<?php


namespace App\Http\Controllers\WakilPimpinan;

use App\Http\Controllers\Controller;
use App\Models\AdminSuratKeluarService;
use App\Models\MainSuratService;
use App\Models\SekretarisSuratMasukService;
use App\Models\WakilSuratMasukService;
use Illuminate\Http\Request;

class PeriksaSuratMasukController extends Controller
{
    protected $wakilSuratService;
    protected $suratKeluar;
    protected $mainService;


    public function __construct()
    {
        $this->suratKeluar = new AdminSuratKeluarService();
        $this->wakilSuratService = new WakilSuratMasukService();
        $this->mainService = new MainSuratService();
    }
    public function periksa_surat_masuk()
    {
        $listSuratMasuk = $this->wakilSuratService->getListSuratUntukDiperiksa()->getData('data')['data']['list_surat_masuk'];
        $listStaff = $this->wakilSuratService->getListStaff()->getData('data')['data']['list_staff'];


        // Mengirim data ke view
        return view('dashboard.wakil_pimpinan.periksa_sm.periksa_surat_masuk', [
            'title' => 'Data Surat Masuk',
            'list_surat_masuk' => $listSuratMasuk,
            'list_staff' => $listStaff
        ]);
    }

    public function ajukan_surat_masuk_wakil(Request $request)
    {
        $data = $request->all();
        $dataExplode = explode("_", $data['disposisi_ke_user_id']);
        $dataPost['surat_masuk_id'] = $data['surat_masuk_id'];
        $dataPost['disposisi_ke_user_id'] = $dataExplode[0];
        $dataPost['jabatan'] = $dataExplode[1];
        $dataPost['disposisi_ke_nm_user'] = $dataExplode[2];
        $dataPost['catatan'] = $data['tindakan'];


        $statusResponse = $this->wakilSuratService->disposisikanSuratKeUser($dataPost);
        // echo '<pre>';
        // print_r($statusResponse);
        // echo '</pre>';
        // exit;
    }
}
