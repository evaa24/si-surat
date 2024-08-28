<?php

namespace App\Models;

use App\Models\MyWebService;

class SekretarisSuratMasukService extends MyWebService
{
    /**
     * Selengkapnya, cek dokumentasi API
     * untuk sistem surat masuk dan keluar
     */
    public function __construct()
    {
        parent::__construct('surat/masuk');
    }

    public function addSurat(array $payload)
    {
        return $this->post($payload, '/add');
    }

    public function getListSuratMilikSendiri()
    {
        // echo '<pre>';
        // print_r($_SERVER);
        // print_r("disini");
        // echo '</pre>';
        // exit;
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

    public function getListStaffUntukDisposisi()
    {
        return $this->get(null, '/staff/list?target=all');
    }


    public function getDetailSuratUntukDiperika(int $id)
    {
        return $this->get(null, ('/list?is_periksa=true&surat_masuk_id=' . $id));
    }

    public function getListWakilKetua()
    {
        return $this->get(null, '/staff/wk?target=is_wk');
    }

    public function getListStaffSekretaris()
    {
        return $this->get(null, '/staff/wk?target=all');
    }

    public function getListStatus()
    {
        return $this->get(null, '/status/update-by-sekretaris');
    }

    public function ajukanSurat(int $suratId, int $userId)
    {
        return $this->put([
            'surat_masuk_id' => $suratId,
            'ajukan_ke_user_id' => $userId
        ], '/ajukan');
    }

    public function updateSuratMilikSendiri(array $payload)
    {
        return $this->put($payload, '/update');
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
