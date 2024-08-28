<?php

namespace App\Models;

use App\Models\MyWebService;

class AdminSuratMasukService extends MyWebService
{
    /**
     * Selengkapnya, cek dokumentasi API
     * untuk sistem surat masuk dan keluar
     */
    public function __construct()
    {
        parent::__construct('surat/masuk');
    }

    public function getListSuratDisposisi()
    {

        // echo '<pre>';
        // print_r($this->get(null, '/disposisi/list'));
        // echo '</pre>';
        // exit;
        return $this->get(null, '/disposisi/list');
    }

    public function getNomorAgenda()
    {
        return $this->get(null, '/generate/nomor-agenda');
    }

    public function addSurat(array $payload)
    {
        return $this->post($payload, '/add');
    }

    public function editSurat(array $payload)
    {
        return $this->put($payload, '/update');
    }

    public function deleteSurat(int $id)
    {
        return $this->delete([
            'surat_masuk_id' => $id
        ], '/delete');
    }


    public function getListSurat()
    {
        return $this->get(null, '/list');
    }

    public function getDetailSurat(int $id)
    {
        return $this->get(null, ('/list?surat_masuk_id=' . $id));
    }

    public function getRekapSurat(string $date, int $statusId)
    {
        return $this->get(null, ('/reka?date=' . $date . '&status_id=' . $statusId));
    }

    public function getListStatus()
    {
        return $this->get(null, '/status/list');
    }

    public function getSuratMasukFilter(string $date, int $statusId)
    {
        return $this->get(null, ('/rekap?date=' . $date . '&status_id=' . $statusId));
    }

    public function getSuratMasukUntukDiperiksa(bool $isPeriksa = false)
    {
        $params = [
            'is_periksa' => $isPeriksa ? 'true' : 'false'
        ];

        return $this->get($params, '/list');
    }
}
