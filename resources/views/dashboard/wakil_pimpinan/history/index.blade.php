@extends('template.index')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h6 mb-0 text-gray-800">Data History</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item">History</li>
        <li class="breadcrumb-item active" aria-current="page">Data History</li>
    </ol>
</div>

<!-- Row -->
<div class="row">
    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data History</h6>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Tgl. Terima</th>
                            <th>No. Surat</th>
                            <th>Perihal</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat_surat as $riwayat)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$riwayat['tgl_sm']}}</td>
                            <td>{{$riwayat['nmr_sm']}}</td>
                            <td>{{$riwayat['perihal_surat']}}</td>
                            <td>
                                @if ($riwayat['status_id'] == 1)
                                <span class="badge badge-primary"><i class="fas fa-spinner"></i> Proses</span>
                                @elseif ($riwayat['status_id'] == 2)
                                <span class="badge badge-warning"><i class="fas fa-paper-plane"></i> Diajukan</span>
                                @elseif ($riwayat['status_id'] == 3)
                                <span class="badge badge-success"><i class="fas fa-check"></i> Selesai Disposisi</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="#" data-toggle="modal" data-target="#detailSuratModal"
                                    data-id="{{ $riwayat['surat_masuk_id'] }}"
                                    data-tgl_surat="{{ $riwayat['tgl_surat'] }}"
                                    data-nmr_agenda="{{ $riwayat['nmr_agenda'] }}"
                                    data-nmr_sm="{{ $riwayat['nmr_sm'] }}"
                                    data-kode_sm="{{ $riwayat['kode_sm'] }}"
                                    data-pengirim="{{ $riwayat['pengirim'] }}"
                                    data-perihal_surat="{{ $riwayat['perihal_surat'] }}"
                                    data-lampiran="{{ $riwayat['lampiran'] }}"
                                    data-status="{{ $riwayat['status']['ket_status'] }}"
                                    data-kategori="{{ $riwayat['kategori_surat']}}"
                                    data-disposisi_catatan="{{ isset($riwayat['disposisi']['catatan']) ? $riwayat['disposisi']['catatan'] : '-' }}"
                                    data-disposisi_tujuan="{{ isset($riwayat['disposisi']['tujuan_disposisi']) ? $riwayat['disposisi']['tujuan_disposisi'] : '-' }}"
                                    data-disposisi_ke="{{ isset($riwayat['disposisi_ke_nm_user']) ? $riwayat['disposisi_ke_nm_user'] : '-' }}"
                                    data-catatan="{{ $riwayat['tindakan'] }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Row-->
<div class="modal fade" id="detailSuratModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Data akan diisi di sini oleh jQuery -->
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

    $('#detailSuratModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Tombol yang memicu modal

        // Ambil data dari atribut data-*
        var tglSurat = button.data('tgl_surat');
        var nmrAgenda = button.data('nmr_agenda');
        var nmrSm = button.data('nmr_sm');
        var kodeSm = button.data('kode_sm');
        var pengirim = button.data('pengirim');
        var perihalSurat = button.data('perihal_surat');
        var lampiran = button.data('lampiran');
        var status = button.data('status');
        var disposisi = button.data('disposisi_ke');
        var disposisiKe = button.data('disposisi_tujuan');
        var catatan = button.data('disposisi_catatan');
        var kategori = button.data('kategori');

        // Isi data di dalam tabel modal
        var modal = $(this);
        modal.find('.modal-body').html(`
        <table class="table">
            <tbody>
                <tr><th>Tgl. Surat Masuk</th><td>${tglSurat}</td></tr>
                <tr><th>Nomor Agenda</th><td>${nmrAgenda}</td></tr>
                <tr><th>Kode Surat</th><td>${kodeSm}</td></tr>
                <tr><th>Nomor Surat</th><td>${nmrSm}</td></tr>
                <tr><th>Tanggal Surat</th><td>${tglSurat}</td></tr>
                <tr><th>Kategori Surat</th><td>${kategori}</td></tr>
                <tr><th>Pengirim</th><td>${pengirim}</td></tr>
                <tr><th>Perihal Surat</th><td>${perihalSurat}</td></tr>
                <tr><th>Lampiran</th><td>${lampiran}</td></tr>
                <tr><th>Status Surat</th><td>${status}</td></tr>
                <tr><th>Disposisi Ke</th><td>${disposisi}</td></tr>
                <tr><th>Tujuan Disposisi</th><td>${disposisiKe}</td></tr>
                <tr><th>Catatan</th><td>${catatan}</td></tr>
            </tbody>
        </table>
    `);
    });
</script>
@endsection