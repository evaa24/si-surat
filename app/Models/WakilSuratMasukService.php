<?php

namespace App\Models;

use App\Models\MyWebService;

class WakilSuratMasukService extends MyWebService
{
    /**
     * Selengkapnya, cek dokumentasi API
     * untuk sistem surat masuk dan keluar
     */
    public function __construct()
    {
        parent::__construct('surat/masuk');
    }

    public function getListSuratMilikSendiri()
    {
        return $this->get(null, '/list');
    }

    public function getDetailSuratMilikSendiri(int $id)
    {
        return $this->get(null, ('/list?surat_masuk_id=' . $id));
    }

    public function getListSuratUntukDiperiksa()
    {
        return $this->get(null, '/list?is_periksa=true');
    }

    public function getDetailSuratUntukDiperika(int $id)
    {
        return $this->get(null, ('/list?is_periksa=true&surat_masuk_id=' . $id));
    }

    public function getListStaff()
    {
        return $this->get(null, '/staff/list?target=all');
    }

    public function disposisikanSuratKeUser(array $payload)
    {
        return $this->put($payload, '/disposisi');
    }

    public function getListStatus()
    {
        return $this->get(null, '/status/update-by-sekretaris');
    }

    public function arsipkanSurat(array $payload)
    {
        return $this->post($payload, '/arsip');
    }

    public function riwayatSurat()
    {
        return $this->get(null, '/riwayat');
    }
}
