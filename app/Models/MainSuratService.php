<?php

namespace App\Models;

use App\Models\MyWebService;

class MainSuratService extends MyWebService
{
    public function __construct()
    {
        parent::__construct('surat');
    }

    public function getStatistik() {
        return $this->get(null, '/statistik');
    }

    public function getListArsip() {
        return $this->get(null, '/arsip/lokasi');
    }

    public function getListCatatanArsip() {
        return $this->get(null, '/arsip/catatan');
    }

    public function getArsipSurat() {
        return $this->get(null, '/arsip');
    }

    public function getListStaff() {
        return $this->get(null, '/staff/list');
    }
}
