@extends('template.index')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h6 mb-0 text-gray-800">Data Surat Keluar</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item">Surat Keluar</li>
        <li class="breadcrumb-item active" aria-current="page">Data Surat Keluar</li>
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
                            <th>No. Surat Keluar</th>
                            <th>Tgl. Surat Keluar</th>
                            <th>Berkas</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_surat_keluar as $surat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $surat['tgl_keluar'] }}</td>
                            <td>{{ $surat['nmr_agenda'] }}</td>
                            <td>{{ $surat['nmr_sk'] }}</td>
                            <td>{{ $surat['tgl_sk'] }}</td>
                            <td><a href="{{ asset('file/uploads/surat-keluar/' . $surat['nama_file']) }}" target="_blank">Lihat File</a></td>
                            <td>
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#detailSuratModal"
                                    data-tanggal-surat="{{ $surat['tgl_keluar'] }}"
                                    data-nomor-agenda="{{ $surat['nmr_agenda'] }}"
                                    data-kode-sk="{{ $surat['kode_sk'] }}"
                                    data-nomor-sk="{{ $surat['nmr_sk'] }}"
                                    data-tanggal-sk="{{ $surat['tgl_sk'] }}"
                                    data-perihal-sk="{{ $surat['perihal_sk'] }}"
                                    data-lampiran-sk="{{ $surat['lampiran_sk'] }}"
                                    data-status-sk="{{ $surat['status']['ket_status'] }}"
                                    data-penerima-sk="{{ $surat['penerima_sk'] }}"
                                    data-surat_keluar_id="{{ $surat['surat_keluar_id'] }}"
                                    data-tindakan="{{ $surat['tindakan'] }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Row -->

<!-- Modal -->
<div class="modal fade" id="detailSuratModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Surat Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdateStatus" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Isi Tabel Detail Surat -->
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Tgl. Keluar</th>
                                <td id="detailTanggalSurat"></td>
                            </tr>
                            <tr>
                                <th>Nomor Agenda</th>
                                <td id="detailNomorAgenda"></td>
                            </tr>
                            <tr>
                                <th>Kode Surat</th>
                                <td id="detailKodeSK"></td>
                            </tr>
                            <tr>
                                <th>Nomor Surat</th>
                                <td id="detailNomorSK"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Surat</th>
                                <td id="detailTanggalSK"></td>
                            </tr>
                            <tr>
                                <th>Penerima Surat</th>
                                <td id="detailPenerimaSK"></td>
                            </tr>
                            <tr>
                                <th>Perihal Surat</th>
                                <td id="detailPerihalSK"></td>
                            </tr>
                            <tr>
                                <th>Lampiran</th>
                                <td id="detailLampiranSK"></td>
                            </tr>
                            <tr>
                                <th>Status Surat</th>
                                <td id="status"></td>
                            </tr>
                            <!-- <tr>
                                <th>Tindakan</th>
                                <td id="detailTindakanSk"></td>
                            </tr> -->
                        </tbody>
                    </table>

                    <table class="table">
                        <tbody>
                            <tr>
                                <div class="form-group">
                                    <label for="tindakan">Proses Kirim:</label>
                                    <select class="form-control" id="status_id" name="status_id" onchange="onChangeKeterangan(this.value)">
                                        <option value="">Pilih Status</option>
                                        @foreach ($list_status as $status)
                                        <option value="{{ $status['status_id'] }}">{{ $status['ket_status'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="uploadBerkasGroup" style="display: none;">
                                    <!-- Konten upload berkas PDF di sini -->
                                    <label for="upload-berkas">Upload Berkas PDF:</label><br>
                                    <small>Ukuran file PDF ( 50 MB )</small>
                                    <input type="file" id="file_pdf" name="file_pdf" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="tindakan">Tindakan:</label>
                                    <input type="text" class="form-control" id="tindakan_edit" name="tindakan">
                                </div>
                            </tr>
                            <input type="hidden" id="surat_keluar_id" name="surat_keluar_id">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Ajukan</button>
                </div>
            </form>
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
        var button = $(event.relatedTarget); // Button that triggered the modal
        var modal = $(this); // The modal

        // Ambil data dari button
        var tanggalSurat = button.data('tanggal-surat');
        var nomorAgenda = button.data('nomor-agenda');
        var kodeSK = button.data('kode-sk');
        var nomorSK = button.data('nomor-sk');
        var tanggalSK = button.data('tanggal-sk');
        var perihalSK = button.data('perihal-sk');
        var lampiranSK = button.data('lampiran-sk');
        var statusSK = button.data('status-sk');
        var penerimaSK = button.data('penerima-sk');
        var tindakan = button.data('tindakan');
        var surat_keluar_id = button.data('surat_keluar_id');

        // Set data ke modal
        modal.find('#detailTanggalSurat').text(tanggalSurat);
        modal.find('#detailNomorAgenda').text(nomorAgenda);
        modal.find('#detailKodeSK').text(kodeSK);
        modal.find('#detailNomorSK').text(nomorSK);
        modal.find('#detailTanggalSK').text(tanggalSK);
        modal.find('#detailPerihalSK').text(perihalSK);
        modal.find('#detailLampiranSK').text(lampiranSK);
        modal.find('#status').text(statusSK);
        modal.find('#detailPenerimaSK').text(penerimaSK);
        modal.find('#detailTindakanSk').text(tindakan);
        modal.find('#surat_keluar_id').val(surat_keluar_id);
    });

    function onChangeKeterangan(value) {
        var uploadBerkasGroup = document.getElementById('uploadBerkasGroup');
        if (value === '1') { // Pastikan value adalah string '1'
            uploadBerkasGroup.style.display = 'block'; // Menampilkan elemen
        } else {
            uploadBerkasGroup.style.display = 'none'; // Menyembunyikan elemen
        }
    }

    $('#formUpdateStatus').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('_token', '{{ csrf_token() }}'); // Menambahkan token CSRF ke formData

        $.ajax({
            url: '{{ route("ajukan.surat.keluar.wakil") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Surat berhasil diajukan'
                });
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal Mengajukan Surat'
                });
            }
        });
    });
</script>
@endsection