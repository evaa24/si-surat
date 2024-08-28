<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSuratKeluarService;
use Illuminate\Http\Request;

use App\Models\AdminSuratMasukService;
use Mpdf\Mpdf;

class LaporanController extends Controller
{
    protected $suratMasukService;
    protected $suratKeluarService;

    public function __construct()
    {
        $this->suratMasukService = new AdminSuratMasukService();
        $this->suratKeluarService = new AdminSuratKeluarService();
    }

    public function laporan_masuk()
    {
        $listStatus = $this->suratMasukService->getListStatus()->getData('data')['data']['list_status'];
        // echo '<pre>';
        // print_r($listStatus);
        // echo '</pre>';
        // exit;
        return view('dashboard.admin.laporan.laporan_masuk', [
            'list_status' => $listStatus,
        ]);
    }

    public function load_table_masuk(Request $request)
    {
        $response = $request->post();
        // echo '<pre>';
        // print_r($response);
        // echo '</pre>';
        // exit;
        // $listSurat = [];

        if (
            isset($response['tanggal']) && (!empty($response['tanggal'])) &&
            isset($response['status']) && (!empty($response['status']))
        ) {
            $response['tanggal'] = date('d-m-Y', strtotime($response['tanggal']));
            $listSurat = $this->suratMasukService->getSuratMasukFilter($response['tanggal'], $response['status']);
        } else {
            $response['tanggal'] = '20-06-2999';
            $listSurat = $this->suratMasukService->getSuratMasukFilter($response['tanggal'], '99');
        }

        // echo '<pre>';
        // print_r($response);
        // print_r($listSurat);
        // echo '</pre>';
        // exit;

        // return view('dashboard.admin.laporan.laporan_masuk', [
        //     'rekap_surat_keluar' => $listSurat,
        // ]);
        return response()->json(['dataListSurat' => $listSurat]);
    }

    public function laporan_keluar()
    {
        $listStatus = $this->suratKeluarService->getListStatus()->getData('data')['data']['list_status'];
        // echo '<pre>';
        // print_r($listStatus);
        // echo '</pre>';
        // exit;
        return view('dashboard.admin.laporan.laporan_keluar', [
            'list_status' => $listStatus,
        ]);
    }

    public function load_table_keluar(Request $request)
    {
        $response = $request->post();
        // echo '<pre>';
        // print_r($response);
        // echo '</pre>';
        // exit;
        // $listSurat = [];

        if (
            isset($response['tanggal']) && (!empty($response['tanggal'])) &&
            isset($response['status']) && (!empty($response['status']))
        ) {
            $response['tanggal'] = date('d-m-Y', strtotime($response['tanggal']));
            $listSurat = $this->suratKeluarService->getSuratKeluarFilter($response['tanggal'], $response['status']);
        } else {
            $response['tanggal'] = '20-06-2999';
            $listSurat = $this->suratKeluarService->getSuratKeluarFilter($response['tanggal'], '99');
        }

        // echo '<pre>';
        // print_r($response);
        // print_r($listSurat);
        // echo '</pre>';
        // exit;

        // return view('dashboard.admin.laporan.laporan_masuk', [
        //     'rekap_surat_keluar' => $listSurat,
        // ]);
        return response()->json(['dataListSurat' => $listSurat]);
    }

    public function cetak_pdf_surat_masuk(Request $request)
    {
        if ($request->query('nama_file') !== null) {
            $path = public_path('file/uploads/surat-masuk/' . $request->query('nama_file'));

            if (file_exists($path)) {
                return response()->stream(function () use ($path) {
                    $stream = fopen($path, 'r');
                    fpassthru($stream);
                    fclose($stream);
                }, 200, [
                    'Content-Type' => mime_content_type($path),
                    'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
                ]);
            } else {
                abort(404, 'File not found.');
            }
        } elseif ($request->query('tanggal') !== null && $request->query('status') !== null) {
            $response['date'] = date('d-m-Y', strtotime($request->query('tanggal')));
            $response['status_id'] = $request->query('status');
            $listSurat = $this->suratMasukService->getSuratMasukFilter($response['date'], $response['status_id'])->getData('data')['data']['rekap_surat_keluar'];

            // Ambil data surat sesuai ID jika diperlukan
            // $listSurat = $this->suratMasukService->getListSurat()->getData('data')['data']['list_surat_masuk'];

            $mpdf = new Mpdf([
                'orientation' => 'L'
            ]);

            // Render view dengan data surat
            $html = view('dashboard.admin.laporan.cetak_pdf_surat_masuk', [
                'list_surat_masuk' => $listSurat
            ])->render();

            // Menulis HTML ke PDF
            $mpdf->WriteHTML($html);
            return $mpdf->Output('surat_masuk.pdf', 'I');
        }
    }

    public function cetak_pdf_surat_keluar(Request $request)
    {
        if ($request->query('nama_file') !== null) {
            $path = public_path('file/uploads/surat-keluar/' . $request->query('nama_file'));

            if (file_exists($path)) {
                return response()->stream(function () use ($path) {
                    $stream = fopen($path, 'r');
                    fpassthru($stream);
                    fclose($stream);
                }, 200, [
                    'Content-Type' => mime_content_type($path),
                    'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
                ]);
            } else {
                abort(404, 'File not found.');
            }
        } elseif ($request->query('tanggal') !== null && $request->query('status') !== null) {
            $response['date'] = date('d-m-Y', strtotime($request->query('tanggal')));
            $response['status_id'] = $request->query('status');
            $listSurat = $this->suratKeluarService->getSuratKeluarFilter($response['date'], $response['status_id'])->getData('data')['data']['rekap_surat_keluar'];

            // Ambil data surat sesuai ID jika diperlukan
            // $listSurat = $this->suratMasukService->getListSurat()->getData('data')['data']['list_surat_masuk'];

            $mpdf = new Mpdf([
                'orientation' => 'L'
            ]);

            // Render view dengan data surat
            $html = view('dashboard.admin.laporan.cetak_pdf_surat_keluar', [
                'list_surat_keluar' => $listSurat
            ])->render();

            // Menulis HTML ke PDF
            $mpdf->WriteHTML($html);
            return $mpdf->Output('surat_keluar.pdf', 'I');
        }
    }
}
