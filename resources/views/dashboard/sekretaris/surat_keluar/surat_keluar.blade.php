@extends('template.index')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h6 mb-0 text-gray-800">Data Surat Keluar Sekretaris</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item">Surat Keluar Sekretaris</li>
        <li class="breadcrumb-item active" aria-current="page">Data Surat Keluar Sekretaris</li>
    </ol>
</div>

<!-- Row -->
<div class="row">
    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Surat Keluar</h6>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Tgl. Keluar</th>
                            <th>Nomor Agenda</th>
                            <th>No.Surat Keluar</th>
                            <th>Tgl. Surat Keluar</th>
                            <th>Tindakan</th>
                            <th>Berkas</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Row-->

<!-- Modal -->
<div class="modal fade" id="detailSuratModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Isi Tabel Detail Surat -->
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Tgl. Surat Masuk</th>

                        </tr>
                        <tr>
                            <th>Nomor Agenda</th>
                        </tr>
                        <tr>
                            <th>Kode Surat</th>
                        </tr>
                        <tr>
                            <th>Nomor Surat</th>
                        </tr>
                        <tr>
                            <th>Tanggal Surat</th>
                        </tr>
                        <tr>
                            <th>Kategori Surat</th>
                        </tr>
                        <tr>
                            <th>Pengirim</th>
                        </tr>
                        <tr>
                            <th>Perihal Surat</th>
                        </tr>
                        <tr>
                            <th>Lampiran</th>
                        </tr>
                        <tr>
                            <th>Status Surat</th>
                        </tr>
                        <tr>
                            <th>Disposisi Ke</th>

                        <tr>
                            <th>Tujuan Disposisi</th>

                        </tr>
                        <tr>
                            <th>Catatan</th>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable(); // ID From dataTable
        $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
</script>
@endsection