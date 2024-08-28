<?php

namespace App\Models;

use App\Models\MyWebService;

class AdminSuratKeluarService extends MyWebService
{
    /**
     * Selengkapnya cek dokumentasi API
     * untuk sistem surat masuk dan keluar
     */
    public function __construct()
    {
        parent::__construct('surat/keluar');
    }

    public function getListSurat()
    {
        return $this->get(null, '/list');
    }

    public function editSurat(array $payload)
    {

        // echo '<pre>';
        // print_r($this->put($payload, '/update'));
        // echo '</pre>';
        // exit;
        return $this->put($payload, '/update');
    }

    public function deleteSurat(int $id)
    {
        return $this->delete([
            'surat_keluar_id' => $id
        ], '/delete');
    }

    public function addSurat(array $payload)
    {

        // echo '<pre>';
        // print_r($payload);
        // print_r($this->post($payload, '/add'));
        // echo '</pre>';
        // exit;


        return $this->post($payload, '/add');
    }



    public function getListStaffUntukDisposisi()
    {
        return $this->get(null, '/staff/list?target=all');
    }

    public function rekapSurat(string $date, int $statusId)
    {
        return $this->get(null, ('/rekap?date=' . $date . '&status_id=' . $statusId));
    }

    public function getListStatus()
    {
        return $this->get(null, '/status/list-by-admin');
    }

    public function getNomorAgenda()
    {
        return $this->get(null, '/generate/nomor-agenda');
    }


    public function getListSuratDisposisi()
    {

        // echo '<pre>';
        // print_r($this->get(null, '/disposisi/list'));
        // echo '</pre>';
        // exit;
        return $this->get(null, '/disposisi/list');
    }

    public function getDetailSurat(int $id)
    {
        return $this->get(null, ('/list?surat_keluar_id=' . $id));
    }



    public function getRekapSurat(string $date, int $statusId)
    {
        return $this->get(null, ('/reka?date=' . $date . '&status_id=' . $statusId));
    }


    public function getSuratKeluarFilter(string $date, int $statusId)
    {
        return $this->get(null, ('/rekap?date=' . $date . '&status_id=' . $statusId));
    }
}
