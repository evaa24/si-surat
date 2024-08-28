@extends('template.index')
@section('content')
<!-- Container Fluid-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Surat</h1>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item">Surat</li>
    <li class="breadcrumb-item active" aria-current="page">Data Surat</li>
    </ol>
</div>

<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Arsip Surat Masuk</h6>
            </div>
            <div class="table-responsive p-3">
            <table class="table align-items-center table-flush" id="dataTable">
                <thead class="thead-light">
                <tr>
                    <th>No.</th>
                    <th>No. Agenda</th>
                    <th>No. Surat Masuk</th>
                    <th>Pengirim</th>
                    <th>Tgl. Arsip</th>
                    <th>Lokasi Arsip</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($data['surat_masuk'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $item['surat_masuk']['nmr_agenda'] }}</td>
                        <td>{{ $item['surat_masuk']['nmr_sm'] }}</td>
                        <td>{{ $item['surat_masuk']['pengirim'] }}</td>
                        <td>{{ $item['tgl_arsip'] }}</td>
                        <td>{{ $item['lokasi_arsip'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        </div>
        <!-- DataTable with Hover -->
        <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Arsip Surat Keluar</h6>
            </div>
            <div class="table-responsive p-3">
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                <tr>
                    <th>No.</th>
                    <th>No. Agenda</th>
                    <th>No. Surat Keluar</th>
                    <th>Penerima</th>
                    <th>Tgl. Arsip</th>
                    <th>Lokasi Arsip</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($data['surat_keluar'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $item['surat_keluar']['nmr_agenda'] }}</td>
                        <td>{{ $item['surat_keluar']['nmr_sk'] }}</td>
                        <td>{{ $item['surat_keluar']['penerima_sk'] }}</td>
                        <td>{{ $item['tgl_arsip'] }}</td>
                        <td>{{ $item['lokasi_arsip'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<!--Row-->
@endsection
@section('scripts')
<script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function () {
    $('#dataTable').DataTable();
    $('#dataTableHover').DataTable();
});
</script>
@endsection
