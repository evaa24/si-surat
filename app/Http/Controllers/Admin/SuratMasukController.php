<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminKategoriService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// ? Service
use App\Models\AdminSuratMasukService;
use App\Models\MainSuratService;
use Dflydev\DotAccessData\Data;

class SuratMasukController extends Controller
{
    protected $mainService;
    protected $suratMasukService;
    protected $kategoriService;

    public function __construct()
    {
        $this->mainService = new MainSuratService();
        $this->suratMasukService = new AdminSuratMasukService();
        $this->kategoriService = new AdminKategoriService();
    }

    public function disposisi()
    {
        $listSurat = $this->suratMasukService->getListSuratDisposisi()->getData('data')['data']['list_disposisi'];

        // echo '<pre>';
        // print_r($listSurat);
        // echo '</pre>';
        // exit;

        return view('dashboard.admin.surat-masuk.disposisi', [
            'title' => 'Data Disposisi Surat',
            'data' => [
                'list_surat' => $listSurat
            ]
        ]);
    }

    public function getListArsip()
    {
        $arsip = $this->mainService->getArsipSurat()->getData('data')['data'];

        return view('dashboard.admin.surat-masuk.arsip', [
            'title' => 'Data Arsip Surat',
            'data' => [
                'surat_masuk' => $arsip['list_arsip']['surat_masuk'],
                'surat_keluar' => $arsip['list_arsip']['surat_keluar']
            ]
        ]);
    }

    public function getListSurat()
    {
        $listSurat = $this->suratMasukService->getListSurat()->getData('data')['data'];
        $listKategori = $this->kategoriService->getListKategori()->getData('data')['data']['kategori'];
        $lastNomorAgenda = $this->suratMasukService->getNomorAgenda()->getData('data')['data']['nmr_agenda'];

        // echo '<pre>';
        // print_r($this->suratMasukService->getListSurat());
        // print_r($_SERVER);
        // print_r($listSurat);
        // echo '</pre>';
        // exit;

        return view('dashboard.admin.surat-masuk.list', [
            'title' => 'Data Surat Masuk',
            'data' => [
                'list_surat' => $listSurat['list_surat_masuk'],
                'list_kategori' => $listKategori,
                'last_nmr_agenda' => $lastNomorAgenda
            ]
        ]);
    }

    public function addSurat(Request $request)
    {
        $data = $request->all();

        unset($data['_token']);
        unset($data['file_pdf']);
        $kode_sm = 'kdsm1';
        $data['kode_sm'] = $kode_sm;

        $filePdf = $request->file('file_pdf');
        $filePdfName = time() . '.' . $filePdf->getClientOriginalExtension();
        $path = $filePdf->move(public_path('file/uploads/surat-masuk'), $filePdfName);
        // $path = $filePdf->storeAs('uploads/surat-keluar', $filePdfName);
        $data['nama_file'] = $path->getFilename();

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;

        $statusResponse = $this->suratMasukService->addSurat($data)->getData('data')['status'];

        if ($statusResponse != 'success') {
            // response kalau gagal
            return redirect()->back()->with('errors', 'Surat masuk gagal ditambahkan');
        }

        // response kalau sukses
        return redirect()->back()->with('success', 'Surat berhasil ditambahkan');
    }

    public function updateSurat(Request $request)
    {
        $data = $request->post(); // ambil data dari form yang ada di view

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;

        unset($data['_token']);
        unset($data['file_pdf']); // hapus file, karena akan diolah dulu

        $filePdf = $request->file('file_pdf');
        $filePdfName = time() . '.' . $filePdf->getClientOriginalExtension();
        $path = $filePdf->move(public_path('file/uploads/surat-masuk'), $filePdfName);
        // $path = $filePdf->storeAs('uploads/surat-keluar', $filePdfName);
        $data['nama_file'] = $path->getFilename();

        $statusResponse = $this->suratMasukService->editSurat($data);

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

    public function deleteSurat(Request $request)
    {

        $response = $this->suratMasukService
            ->deleteSurat($request->query('id'))->getData('data');

        if ($response['status'] != 'success') {
            return redirect()->back()->with('errors', 'Surat masuk gagal dihapus');
        }

        return redirect()->back()->with('success', 'Surat masuk berhasil dihapus');
    }
}
