<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\AdminKategoriService;
use App\Models\KaryawanSuratKeluarService;
use App\Models\MainSuratService;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{

    protected $mainService;
    protected $suratKeluarService;
    protected $kategoriService;

    public function __construct()
    {
        $this->mainService = new MainSuratService();
        $this->suratKeluarService = new KaryawanSuratKeluarService();
        $this->kategoriService = new AdminKategoriService();
    }

    public function index()
    {
        $listSurat = $this->suratKeluarService->getListSurat()->getData('data')['data']['list_surat_keluar'];
        $listStaff = $this->mainService->getListStaff()->getData('data')['data']['list_staff'];
        $listKategori = $this->kategoriService->getListKategori()->getData('data')['data']['kategori'];
        $lastNomorAgenda = $this->suratKeluarService->getNomorAgenda()->getData('data')['data']['nmr_agenda'];

        // echo '<pre>';
        // print_r($listSurat);
        // echo '</pre>';
        // exit;

        return view('dashboard.karyawan.surat_keluar.surat_keluar', [
            'title' => 'Data Surat Keluar',
            'data' => [
                'list_surat' => $listSurat,
                'list_staff' => $listStaff,
                'last_nmr_agenda' => $lastNomorAgenda,
                'list_kategori' => $listKategori
            ]
        ]);
    }
    public function addSurat(Request $request)
    {

        $data = $request->all();
        $kode_sk = 'kode_sk1';
        $data['kode_sk'] = $kode_sk;

        // Format tgl_keluar dan tgl_sk menjadi string hari-bulan-tahun
        if (isset($data['tgl_keluar']) && !is_null($data['tgl_keluar'])) {
            $tglKeluar = strtotime($data['tgl_keluar']);
            $data['tgl_keluar'] = date('d-m-Y', $tglKeluar);
        }

        if (isset($data['tgl_sk']) && !is_null($data['tgl_sk'])) {
            $tglSk = strtotime($data['tgl_sk']);
            $data['tgl_sk'] = date('d-m-Y', $tglSk);
        }

        // Hapus data yang tidak perlu
        unset($data['_token']);
        unset($data['kategori_id']);
        unset($data['file_pdf']); // hapus file, karena akan diolah dulu

        // Proses file PDF pertama
        if ($request->hasFile('file_pdf')) {
            $filePdf = $request->file('file_pdf');
            $filePdfName = time() . '.' . $filePdf->getClientOriginalExtension();
            $path = $filePdf->move(public_path('file/uploads/surat-keluar'), $filePdfName);
            // $path = $filePdf->storeAs('uploads/surat-keluar', $filePdfName);
            $data['nama_file'] = $path->getFilename();
        }

        // Proses file PDF kedua
        if ($request->hasFile('berkas_pdf')) {
            $filePdf2 = $request->file('berkas_pdf');
            $filePdfName2 = time() . '.' . $filePdf2->getClientOriginalExtension();
            $path2 = $filePdf2->move(public_path('file/uploads/surat-keluar'), $filePdfName2);
            // $path2 = $filePdf2->storeAs('uploads/surat-keluar', $filePdfName2);
            $data['berkas_kesalahan'] = $path2->getFilename();
        }

        // Urutkan data sesuai dengan format yang diinginkan
        $orderedData = [
            "tgl_keluar" => $data['tgl_keluar'],
            "tgl_sk" => $data['tgl_sk'],
            "nmr_agenda" => $data['nmr_agenda'],
            "kode_sk" => $kode_sk,
            "nmr_sk" => $data['nmr_sk'],
            "penerima_sk" => $data['penerima_sk'],
            "perihal_sk" => $data['perihal_sk'],
            "lampiran_sk" => $data['lampiran_sk'],
            "tindakan" => $data['tindakan'],
            "berkas_kesalahan" => $data['nama_file'] ?? null, // Gunakan null jika tidak ada
            "nama_file" => $data['nama_file'] ?? null, // Gunakan null jika tidak ada
        ];

        // // Kirim data ke service
        // echo '<pre>';
        // print_r($orderedData);
        // echo '</pre>';
        // exit;
        $statusResponse = $this->suratKeluarService->addSurat($orderedData)->getData('data')['status'];
        // echo '<pre>';
        // print_r($statusResponse);
        // echo '</pre>';
        // exit;
        if ($statusResponse != 'success') {
            return redirect()->back()->with('errors', 'Surat keluar gagal ditambahkan');
        }

        return redirect()->back()->with('success', 'Surat keluar ditambahkan');
    }

    public function getListStaff()
    {
        $listStaff = $this->suratKeluarService->getListStaffUntukDisposisi()->getData('data')['data'];
    }


    public function detail(Request $request)
    {
        $response = $this->suratKeluarService
            ->getDetailSurat($request->query('id'))->getData('data');

        // echo '<pre>';
        // print_r($response);
        // echo '</pre>';
        // exit;
        if ($response['status'] != 'success') {
            return response()->json([
                'message' => 'Gagal menampilkan detail surat keluar'
            ], 400);
        }



        return response()->json([
            'surat_keluar' => $response['data']['surat_keluar']
        ], 200);
    }

    public function deleteSurat(Request $request)
    {

        $response = $this->suratKeluarService
            ->deleteSurat($request->query('id'))->getData('data');

        if ($response['status'] != 'success') {
            return redirect()->back()->with('errors', 'Surat keluar gagal dihapus');
        }

        return redirect()->back()->with('success', 'Surat keluar berhasil dihapus');
    }

    public function updateSurat(Request $request)
    {
        $data = $request->post(); // ambil data dari form yang ada di view

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;

        if (isset($data['tgl_keluar']) && !is_null($data['tgl_keluar'])) {
            $tglKeluar = strtotime($data['tgl_keluar']);
            $data['tgl_keluar'] = date('d-m-Y', $tglKeluar);
        }

        if (isset($data['tgl_sk']) && !is_null($data['tgl_sk'])) {
            $tglSk = strtotime($data['tgl_sk']);
            $data['tgl_sk'] = date('d-m-Y', $tglSk);
        }

        $data['tgl_sk'];
        $data['tgl_keluar'];

        unset($data['_token']);
        unset($data['file_pdf']); // hapus file, karena akan diolah dulu
        unset($data['berkas_pdf']);

        // Proses file PDF pertama
        if ($request->hasFile('file_pdf')) {
            $filePdf = $request->file('file_pdf');
            $filePdfName = time() . '.' . $filePdf->getClientOriginalExtension();
            $path = $filePdf->move(public_path('file/uploads/surat-keluar'), $filePdfName);
            // $path = $filePdf->storeAs('uploads/surat-keluar', $filePdfName);
            $data['nama_file'] = $path->getFilename();
        }

        // Proses file PDF kedua
        if ($request->hasFile('berkas_kesalahan')) {
            $filePdf2 = $request->file('berkas_kesalahan');
            $filePdfName2 = time() . '.' . $filePdf2->getClientOriginalExtension();
            $path2 = $filePdf2->move(public_path('file/uploads/surat-keluar'), $filePdfName2);
            // $path2 = $filePdf2->storeAs('uploads/surat-keluar', $filePdfName2);
            $data['berkas_kesalahan'] = $path2->getFilename();
        }

        // Urutkan data sesuai dengan format yang diinginkan
        $orderedData = [
            "surat_keluar_id" => $data['surat_keluar_id'],
            "tgl_keluar" => $data['tgl_keluar'],
            "tgl_sk" => $data['tgl_sk'],
            "nmr_agenda" => $data['nmr_agenda'],
            "kode_sk" => $data['kode_sk'],
            "nmr_sk" => $data['nmr_sk'],
            "penerima_sk" => $data['penerima_sk'],
            "perihal_sk" => $data['perihal_sk'],
            "lampiran_sk" => $data['lampiran_sk'],
            "tindakan" => $data['tindakan'],
            "berkas_kesalahan" => $data['berkas_kesalahan'] ?? null, // Gunakan null jika tidak ada
            "nama_file" => $data['nama_file'] ?? null
        ];

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;


        $statusResponse = $this->suratKeluarService->editSurat($orderedData);



        // echo '<pre>';
        // print_r($statusResponse);
        // echo '</pre>';
        // exit;


        if ($statusResponse != 'success') {
            // response kalau gagal
            return redirect()->back()->with('errors', 'Surat masuk gagal ditambahkan');
        }

        // response kalau sukses
        return redirect()->back()->with('success', 'Surat berhasil ditambahkan');
    }
}
