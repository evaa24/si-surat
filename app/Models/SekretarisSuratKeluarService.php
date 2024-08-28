<?php

namespace App\Models;

use App\Models\MyWebService;

class SekretarisSuratKeluarService extends MyWebService
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

    public function getListSuratMilikSendiri()
    {
        return $this->get(null, '/list');
    }

    public function getDetailSuratMilikSendiri(int $id)
    {
        return $this->get(null, ('/list?surat_keluar_id=' . $id));
    }

    public function getListSuratUntukDiperiksa()
    {

        return $this->get(null, '/list?is_periksa=true');
    }

    public function getDetailSuratUntukDiperika(int $id)
    {
        return $this->get(null, ('/list?is_periksa=true&surat_keluar_id=' . $id));
    }

    public function getListStatus()
    {
        return $this->get(null, '/status/list-by-sekretaris');
        // return $this->get(null, '/status/update-by-sekretaris');
    }

    public function updateStatusSuratDiperiksa(array $payload)
    {
        return $this->put($payload, '/status/update-by-sekretaris');
    }

    public function updateSuratMilikSendiri(array $payload)
    {
        return $this->put($payload, '/update');
    }

    public function arsipkanSurat(array $payload)
    {
        return $this->post($payload, '/arsip');
    }

    public function getListStaffUntukDisposisi()
    {
        return $this->get(null, '/staff/wk?target=all');
    }
}
