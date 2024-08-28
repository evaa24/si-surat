<?php

namespace App\Models;

use App\Models\MyWebService;

class AdminKategoriService extends MyWebService
{
    /**
     * Selengkapnya cek dokumentasi API
     * untuk sistem surat masuk dan keluar
     */
    public function __construct()
    {
        parent::__construct('surat/kategori');
    }

    public function getListKategori()
    {
        return $this->get(null, '/list');
    }

    public function addKategori(string $nama)
    {
        return $this->post([
            'nama' => $nama
        ], '/add');
    }

    public function editKategori(int $id, string $kategoriName)
    {
        return $this->put([
            'kategori_id' => $id,
            'nama' => $kategoriName
        ], '/update');
    }

    public function deleteKategori(int $id)
    {
        return $this->delete([
            'kategori_id' => $id
        ], '/delete');
    }

    public function getDetailKategori(int $id)
    {
        return $this->get(null, ('/list?kategori_id=' . $id));
    }
}
