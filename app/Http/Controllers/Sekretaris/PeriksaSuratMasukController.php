<?php


namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\AdminSuratKeluarService;
use App\Models\SekretarisSuratMasukService;
use App\Models\MainSuratService;
use Dotenv\Validator;
use Illuminate\Http\Request;

class PeriksaSuratMasukController extends Controller
{
    protected $sekretarisSuratMasuk;
    protected $suratKeluar;
    protected $mainService;


    public function __construct()
    {
        $this->suratKeluar = new AdminSuratKeluarService();
        $this->sekretarisSuratMasuk = new SekretarisSuratMasukService();
        $this->mainService = new MainSuratService();
    }

    public function periksa_surat_masuk()
    {
        $listSuratMasuk = $this->sekretarisSuratMasuk->getListSuratUntukDiperiksa()->getData('data')['data']['list_surat_masuk'];
        $listStaff = $this->sekretarisSuratMasuk->getListStaffSekretaris()->getData('data')['data']['list_staff'];
        // echo '<pre>';
        // print_r($listStaff);
        // echo '</pre>';
        // exit;
        // Mengirim data ke view
        return view('dashboard.sekretaris.periksa_sm.periksa_surat_masuk', [
            'title' => 'Data Surat Masuk',
            'list_surat_masuk' => $listSuratMasuk,
            'list_staff' => $listStaff
        ]);
    }

    public function ajukan_surat(Request $request)
    {

        $data = $request->all();
        $surat_masuk_id = $request->surat_masuk_id;
        $user_id = $request->ajukan_ke_user_id;

        $statusResponse = $this->sekretarisSuratMasuk->ajukanSurat($surat_masuk_id, $user_id);

        // echo '<pre>';
        // print_r('masukk');
        // print_r($statusResponse);
        // echo '</pre>';
        // exit;
    }
}
