<?php

namespace App\Models;

use App\Models\MyWebService;

class KaryawanSuratKeluarService extends MyWebService
{
    /**
     * Selengkapnya, cek dokumentasi API
     * untuk sistem surat masuk dan keluar
     */
    public function __construct()
    {
        parent::__construct('surat/keluar');
    }

    public function addSurat(array $payload)
    {
        return $this->post($payload, '/add');
    }

    public function getNomorAgenda()
    {
        return $this->get(null, '/generate/nomor-agenda');
    }

    public function getListSurat()
    {
        return $this->get(null, '/list');
    }

    public function getListStaffUntukDisposisi()
    {
        return $this->get(null, '/staff/list?target=all');
    }

    public function getDetailSurat(int $id)
    {
        return $this->get(null, '/list?surat_keluar_id=' . $id);
    }

    public function editSurat(array $payload)
    {
        return $this->put($payload, '/update');
    }

    public function arsipkanSurat(array $payload)
    {
        return $this->post($payload, '/arsip');
    }

    public function deleteSurat(int $id)
    {
        return $this->delete([
            'surat_keluar_id' => $id
        ], '/delete');
    }
}
