<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// ? Service
use App\Models\AdminKategoriService;

class KategoriSuratController extends Controller
{
    protected $kategoriService;

    public function __construct()
    {
        $this->kategoriService = new AdminKategoriService();
    }

    public function index()
    {
        $listKategori = $this->kategoriService
            ->getListKategori()->getData('data')['data']['kategori'];

        return view('dashboard.admin.kategori.index', [
            'title' => 'Kategori',
            'data' => [
                'list_kategori' => $listKategori
            ]
        ]);
    }

    public function add(Request $request)
    {
        $kategori = $request->nama;
        $response = $this->kategoriService->addKategori($kategori)->getData('data');

        if ($response['status'] != 'success') {
            return redirect()->back()->with('errors', 'Kategori gagal ditambahkan');
        }

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function delete(Request $request)
    {
        $response = $this->kategoriService
            ->deleteKategori($request->query('id'))->getData('data');

        if ($response['status'] != 'success') {
            return redirect()->back()->with('errors', 'Kategori gagal dihapus');
        }

        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }

    public function update(Request $request)
    {
        $response = $this->kategoriService->editKategori(
            $request->id,
            $request->nama
        )->getData('data');

        if ($response['status'] != 'success') {
            return redirect()->back()->with('errors', 'Kategori gagal diubah');
        }

        return redirect()->back()->with('success', 'Kategori berhasil diubah');
    }

    public function detail(Request $request)
    {
        $response = $this->kategoriService
            ->getDetailKategori($request->query('id'))->getData('data');

        if ($response['status'] != 'success') {
            return response()->json([
                'message' => 'Gagal menampilkan detail kategori'
            ], 400);
        }

        return response()->json([
            'kategori' => $response['data']['kategori']
        ], 200);
    }
}
