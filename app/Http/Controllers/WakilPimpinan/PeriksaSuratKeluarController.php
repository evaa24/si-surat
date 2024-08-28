<?php

namespace App\Http\Controllers\WakilPimpinan;

use App\Http\Controllers\Controller;
use App\Models\AdminSuratKeluarService;
use App\Models\MainSuratService;
use App\Models\WakilSuratKeluarService;
use Illuminate\Http\Request;

class PeriksaSuratKeluarController extends Controller
{
    protected $wakilSuratKeluarService;
    protected $suratKeluar;
    protected $mainService;


    public function __construct()
    {
        $this->suratKeluar = new AdminSuratKeluarService();
        $this->wakilSuratKeluarService = new WakilSuratKeluarService();
        $this->mainService = new MainSuratService();
    }

    public function periksa_surat_keluar()
    {
        $listSuratKeluar = $this->wakilSuratKeluarService->getListSuratUntukDiperiksa()->getData('data')['data']['list_surat_keluar'];
        $listStaff = $this->mainService->getListStaff()->getData('data')['data']['list_staff'];
        $listStatus = $this->wakilSuratKeluarService->getListStatus()->getData('data')['data']['list_status'];


        // echo '<pre>';
        // print_r($listStaff);
        // echo '</pre>';
        // exit;


        // Mengirim data ke view
        return view('dashboard.wakil_pimpinan.periksa_sk.periksa_surat_keluar', [
            'title' => 'Data Surat Masuk',
            'list_surat_keluar' => $listSuratKeluar,
            'list_staff' => $listStaff,
            'list_status' => $listStatus
        ]);
    }

    public function ajukan_surat_keluar_wakil(Request $request)
    {
        $data = $request->all();

        unset($data['file_pdf']);

        if ($data['status_id'] == 1) {

            $filePdfKedua = $request->file('file_pdf');
            $filePdfNameKedua = time() . '.' . $filePdfKedua->getClientOriginalExtension();
            $pathKedua = $filePdfKedua->move(public_path('file/uploads/surat-keluar'), $filePdfNameKedua);
            // $pathKedua = $filePdfKedua->storeAs('uploads/surat-keluar', $filePdfNameKedua);
            // $data['berkas_kesalahan'] = $pathKedua;
            $data['berkas_kesalahan'] = $pathKedua->getFilename();

            $statusResponse = $this->wakilSuratKeluarService->updateStatusSuratDiperiksa($data);

            // echo '<pre>';
            // print_r('masukk');
            // print_r($statusResponse);
            // echo '</pre>';
            // exit;
        } else {
            $statusResponse = $this->wakilSuratKeluarService->updateStatusSuratDiperiksa($data);

            // echo '<pre>';
            // print_r('masukk');
            // print_r($statusResponse);
            // echo '</pre>';
            // exit;
        }


        // $surat_masuk_id = $request->surat_masuk_id;
        // $user_id = $request->ajukan_ke_user_id;
        // $status_id = $request->status_id;
        // $tindakan = $request->tindakan;


    }
}
