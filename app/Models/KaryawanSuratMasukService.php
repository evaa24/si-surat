<?php

namespace App\Models;

use App\Models\MyWebService;

class KaryawanSuratMasukService extends MyWebService
{
    /**
     * Selengkapnya, cek dokumentasi API
     * untuk sistem surat masuk dan keluar
     */
    public function __construct()
    {
        parent::__construct('surat/masuk');
    }

    public function getListSurat()
    {
        // echo '<pre>';
        // print_r($this->get(null, '/list'));
        // echo '</pre>';
        // exit;

        return $this->get(null, '/list');
    }

    public function terimaSurat(int $id)
    {

        return $this->put([
            'surat_masuk_id' => $id
        ], '/terima');
    }

    public function arsipkanSurat(array $payload)
    {
        return $this->post($payload, '/arsip');
    }
}
