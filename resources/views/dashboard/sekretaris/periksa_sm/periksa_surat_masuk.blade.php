@extends('template.index')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h6 mb-0 text-gray-800">Data Surat Masuk</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item">Surat Masuk</li>
        <li class="breadcrumb-item active" aria-current="page">Data Surat Masuk</li>
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
                            <th>No. Surat Masuk</th>
                            <th>Tanggal Surat Masuk</th>
                            <th>Kategori Surat</th>
                            <th>Pengirim</th>
                            <th>Lampiran</th>
                            <th>Status Surat</th>
                            <th>Berkas</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_surat_masuk as $surat)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $surat['nmr_agenda'] }}</td>
                            <td>{{ $surat['nmr_sm'] }}</td>
                            <td>{{ $surat['tgl_sm'] }}</td>
                            <td>{{ $surat['kategori']['nama'] }}</td>
                            <td>{{ $surat['pengirim'] }}</td>
                            <td>{{ $surat['lampiran'] }}</td>
                            <td>{{ $surat['status']['ket_status'] }}</td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="{{ asset('file/uploads/surat-masuk/' . $surat['nama_file']) }}" target="_blank"> Lihat File Pdf</a>
                            </td>
                            <td>
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
                                    data-surat_masuk_id="{{ $surat['surat_masuk_id'] }}"
                                    data-status="{{ $surat['status']['ket_status'] }}">
                                    <i class=" fas fa-eye"></i>
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
<!--Row-->

<!-- Modal -->
<div class="modal fade" id="detailSuratModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Surat Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Isi Tabel Detail Surat -->
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Tanggal Surat Masuk</th>
                            <td id="modal-tanggal-surat"></td>
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
                        <br><br>
                    </tbody>
                </table>
                <table class="table">
                    <tbody>
                        <!-- Existing rows here -->
                        <tr>
                            <th>Tanggal Surat Masuk</th>
                            <th>Tindakan</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control" id="tanggal-surat" readonly>
                            </td>
                            <td>
                                <select class="form-control" id="disposisi-edit" name="disposisi_user_id">
                                    <option value="">Pilih Disposisi</option>
                                    @foreach ($list_staff as $staff)
                                    @if ($staff['user_id'] == 28 || $staff['user_id'] == 92 || $staff['user_id'] == 93)
                                    <option value="{{ $staff['user_id'] }}">Ajukan ke {{ $staff['nama'] }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </td>
                            <input type="text" id="modal-surat_masuk_id" name="surat_masuk_id" style="display: none;">
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="ajukanSurat()">Ajukan</button>
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
        $('#dataTableHover').DataTable(); // ID From dataTable with Hover

        // Mengatur data ke modal saat tombol detail diklik
        $('#detailSuratModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button yang diklik
            var modal = $(this);


            // Mengambil data dari button dan mengisi modal
            modal.find('#modal-tanggal-surat').text(button.data('tanggal-surat'));
            modal.find('#modal-tanggal-surat-masuk').text(button.data('tanggal-surat'));
            modal.find('#modal-nomor-agenda').text(button.data('nomor-agenda'));
            modal.find('#modal-kode-sm').text(button.data('kode-sm'));
            modal.find('#modal-nomor-sm').text(button.data('nomor-sm'));
            modal.find('#modal-tanggal-sm').text(button.data('tanggal-sm'));
            modal.find('#modal-kategori').text(button.data('kategori'));
            modal.find('#modal-pengirim').text(button.data('pengirim'));
            modal.find('#modal-perihal').text(button.data('perihal'));
            modal.find('#modal-lampiran').text(button.data('lampiran'));
            modal.find('#modal-status').text(button.data('status'));
            modal.find('#modal-surat_masuk_id').val(button.data('surat_masuk_id'));

            modal.find('#tanggal-surat').val(button.data('tanggal-sm'));
        });
    });

    function ajukanSurat() {
        var suratMasukId = $('#modal-surat_masuk_id').val();
        var disposisiUserId = $('#disposisi-edit').val();

        console.log(suratMasukId);

        if (!disposisiUserId) {
            alert('Silakan pilih disposisi.');
            return;
        }

        $.ajax({
            url: '{{ route("ajukan.surat") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                surat_masuk_id: suratMasukId,
                ajukan_ke_user_id: disposisiUserId
            },
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
    }
</script>
@endsection