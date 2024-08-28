@extends('template.index')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h6 mb-0 text-gray-800">Data Surat Masuk karyawan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item">Surat Masuk karyawan</li>
        <li class="breadcrumb-item active" aria-current="page">Data Surat Masuk karyawan</li>
    </ol>
</div>

<!-- Row -->
<div class="row">
    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Surat Masuk</h6>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>No. Agenda</th>
                            <th>No.Surat Masuk</th>
                            <th>Pengirim</th>
                            <th>Tujuan Dispoisi</th>
                            <th>Berkas</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_surat as $surat)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$surat['nmr_agenda']}}</td>
                            <td>{{$surat['nmr_sm']}}</td>
                            <td>{{$surat['pengirim']}}</td>
                            <td>{{$surat['disposisi']['tujuan_disposisi']}}</td>
                            <td>
                                <a href="{{ asset('file/uploads/surat-masuk/' . $surat['nama_file']) }}" target="_blank">PDF</a>
                            </td>
                            <td>
                                @if($surat['status_baca'] == 0)
                                <button class="btn btn-warning" onclick="terimaSurat(`{{ $surat['surat_masuk_id'] }}`)">Terima Berkas</button>
                                @elseif($surat['status_baca'] == 1)
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#detailSuratModal"
                                    data-tanggal-surat="{{ $surat['tgl_surat'] }}"
                                    data-nomor-agenda="{{ $surat['nmr_agenda'] }}"
                                    data-kode-sm="{{ $surat['kode_sm'] }}"
                                    data-nomor-sm="{{ $surat['nmr_sm'] }}"
                                    data-tanggal-sm="{{ $surat['tgl_sm'] }}"
                                    data-kategori="{{ $surat['kategori']['nama'] }}"
                                    data-pengirim="{{ $surat['pengirim'] }}"
                                    data-perihal="{{ $surat['perihal_surat'] }}"
                                    data-lampiran="{{ $surat['lampiran'] }}"
                                    data-status="{{ $surat['status']['ket_status'] }}"
                                    data-disposisi-ke="{{ $surat['disposisi_ke_nm_user'] }}"
                                    data-tujuan-disposisi="{{ $surat['disposisi']['tujuan_disposisi'] }}"
                                    data-catatan="{{ $surat['disposisi']['catatan'] }}">Berkas Diterima dan Lihat Detail

                                </button>
                                @endif
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
                            <td id="modal-tanggal-sm"></td>
                        </tr>
                        <tr>
                            <th>Nomor Agenda</th>
                            <td id="modal-nomor-agenda"></td>
                        </tr>

                        <tr>
                            <th>Nomor Surat</th>
                            <td id="modal-nomor-sm"></td>
                        </tr>
                        <tr>
                            <th>Tanggal Surat</th>
                            <td id="modal-tanggal-surat"></td>
                        </tr>
                        <tr>
                            <th>Kategori Surat</th>
                            <td id="modal-kategori"></td>
                        </tr>
                        <tr>
                            <th>Pengirim</th>
                            <td id="modal-pengirim"></td>
                        </tr>
                        <tr>
                            <th>Perihal Surat</th>
                            <td id="modal-perihal"></td>
                        </tr>
                        <tr>
                            <th>Lampiran</th>
                            <td id="modal-lampiran"></td>
                        </tr>
                        <tr>
                            <th>Status Surat</th>
                            <td id="modal-status"></td>
                        </tr>
                        <tr>
                            <th>Disposisi Ke</th>
                            <td id="modal-disposisi-ke"></td>
                        </tr>
                        <tr>
                            <th>Tujuan Disposisi</th>
                            <td id="modal-tujuan-disposisi"></td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td id="modal-catatan"></td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable(); // ID From dataTable
        $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });

    $('#detailSuratModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Tombol yang diklik

        var tanggalSurat = button.data('tanggal-surat');
        var nomorAgenda = button.data('nomor-agenda');
        var kodeSm = button.data('kode-sm');
        var nomorSm = button.data('nomor-sm');
        var tanggalSm = button.data('tanggal-sm');
        var kategori = button.data('kategori');
        var pengirim = button.data('pengirim');
        var perihal = button.data('perihal');
        var lampiran = button.data('lampiran');
        var status = button.data('status');
        var disposisiKe = button.data('disposisi-ke');
        var tujuanDisposisi = button.data('tujuan-disposisi');
        var catatan = button.data('catatan');

        var modal = $(this);
        modal.find('#modal-tanggal-surat').text(tanggalSurat);
        modal.find('#modal-nomor-agenda').text(nomorAgenda);
        modal.find('#modal-kode-sm').text(kodeSm);
        modal.find('#modal-nomor-sm').text(nomorSm);
        modal.find('#modal-tanggal-sm').text(tanggalSm);
        modal.find('#modal-kategori').text(kategori);
        modal.find('#modal-pengirim').text(pengirim);
        modal.find('#modal-perihal').text(perihal);
        modal.find('#modal-lampiran').text(lampiran);
        modal.find('#modal-status').text(status);
        modal.find('#modal-disposisi-ke').text(disposisiKe);
        modal.find('#modal-tujuan-disposisi').text(tujuanDisposisi);
        modal.find('#modal-catatan').text(catatan);
    });

    function terimaSurat(suratMasukId) {
        $.ajax({
            url: '{{ route("terima.surat") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                surat_masuk_id: suratMasukId
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Surat berhasil diterima'
                });
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal Menerima Surat'
                });
            }
        });
    }
</script>
@endsection