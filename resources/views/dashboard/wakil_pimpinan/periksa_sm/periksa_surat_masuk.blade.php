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
                            <th>No.Surat Masuk</th>
                            <th>Tgl.Surat Masuk</th>
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
                            <td>{{$loop->iteration}}</td>
                            <td>{{$surat['nmr_agenda']}}</td>
                            <td>{{$surat['nmr_sm']}}</td>
                            <td>{{$surat['tgl_sm']}}</td>
                            <td>{{$surat['kategori']['nama']}}</td>
                            <td>{{$surat['pengirim']}}</td>
                            <td>{{$surat['lampiran']}}</td>
                            <td>
                                @if ($surat['status_id'] == 1)
                                <span class="badge badge-primary"><i class="fas fa-spinner"></i> Proses</span>
                                @elseif ($surat['status_id'] == 2)
                                <span class="badge badge-warning"><i class="fas fa-paper-plane"></i> Diajukan</span>
                                @elseif ($surat['status_id'] == 3)
                                <span class="badge badge-success"><i class="fas fa-check"></i> Selesai Disposisi</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="{{ asset('file/uploads/surat-masuk/' . $surat['nama_file']) }}" target="_blank"> Lihat File Pdf</a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="#" data-toggle="modal" data-target="#detailSuratModal" data-id="{{ $surat['surat_masuk_id'] }}" data-tgl_surat="{{ $surat['tgl_surat'] }}" data-nmr_agenda="{{ $surat['nmr_agenda'] }}" data-nmr_sm="{{ $surat['nmr_sm'] }}" data-tgl_sm="{{ $surat['tgl_sm'] }}" data-kategori="{{ $surat['kategori']['nama'] }}" data-pengirim="{{ $surat['pengirim'] }}" data-lampiran="{{ $surat['lampiran'] }}" data-status="{{ $surat['status_id'] }}" data-tindakan="{{ $surat['tindakan'] }}" data-kode_sm="{{ $surat['kode_sm'] }}" data-perihal="{{ $surat['perihal_surat'] }}" data-ajukan="{{ $surat ['ajukan_ke_user_id'] }}">
                                    <i class=" fas fa-eye"></i>
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
                            <th>No. Agenda</th>
                            <td id="nmr_agenda"></td>
                        </tr>
                        <tr>
                            <th>Kode Surat</th>
                            <td id="kode_sm"></td>
                        </tr>

                        <tr>
                            <th>No. Surat Masuk</th>
                            <td id="nmr_sm"></td>
                        </tr>
                        <tr>
                            <th>Tgl. Surat </th>
                            <td id="tgl_sm"></td>
                        </tr>
                        <tr>
                            <th>Kategori Surat</th>
                            <td id="kategori"></td>
                        </tr>
                        <tr>
                            <th>Pengirim</th>
                            <td id="pengirim"></td>
                        </tr>
                        <tr>
                            <th>Perihal Surat</th>
                            <td id="perihal"></td>
                        </tr>
                        <tr>
                            <th>Lampiran</th>
                            <td id="lampiran"></td>
                        </tr>
                        <tr>
                            <th>Status Surat</th>
                            <td id="status"></td>
                        </tr>
                        <tr>
                            @foreach($list_staff as $staff)
                            @if($staff['user_id'] == 28)
                            <th>Diajukan ke</th>
                            <td id="ajukan_ke_user_id">{{$staff['nama']}}</td>
                            @endif
                            @endforeach
                        </tr>
                    </tbody>
                    <table class="table">
                        <tbody>
                            <!-- Existing rows here -->
                            <tr>
                                <th>Disposisi</th>

                            </tr>

                            <tr>
                                <td>
                                    <select class="form-control" id="disposisi-edit-dua" name="disposisi_ke_user_id">
                                        <option value="">Disposisi</option>
                                        @foreach ($list_staff as $staff)
                                        <option value="{{ $staff['user_id'] }}_{{$staff['jabatan']}}_{{$staff['nama']}}">{{ $staff['jabatan'] }} - {{$staff['nama']}}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <input type="text" id="surat_masuk_id" name="surat_masuk_id" style="display: none;">
                            </tr>

                    </table>
                    <tr>
                        <th>Catatan</th>
                    </tr>
                    <tr>
                        <input class="form-control" type="text" id="tindakan" name="tindakan">

                    </tr>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="disposisi()">Disposisi</button>
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
    var listStafJson = <?= json_encode($list_staff) ?>;

    $(document).ready(function() {
        $('#dataTable').DataTable(); // ID From dataTable
        $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });

    $('#detailSuratModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var modal = $(this); // The modal

        // Ambil data dari button
        var tgl_surat = button.data('tgl_surat');
        var nmr_agenda = button.data('nmr_agenda');
        var kode_sm = button.data('kode_sm');
        var nmr_sm = button.data('nmr_sm');
        var tgl_sm = button.data('tgl_sm');
        var kategori = button.data('kategori');
        var pengirim = button.data('pengirim');
        var lampiran = button.data('lampiran');
        var status = button.data('status');
        var perihal = button.data('perihal');
        var ajukan_ke_user_id = button.data('ajukan');
        var surat_masuk_id = button.data('id');

        // Set data ke modal
        var statusText = '';

        if (status == 1) {
            statusText = '<span class="badge badge-primary"><i class="fas fa-spinner"></i> Proses</span>';
        } else if (status == 2) {
            statusText = '<span class="badge badge-warning"><i class="fas fa-paper-plane"></i> Diajukan</span>';
        } else if (status == 3) {
            statusText = '<span class="badge badge-success"><i class="fas fa-check"></i> Selesai Disposisi</span>';
        }

        modal.find('.modal-body td#tgl_surat').text(tgl_surat);
        modal.find('.modal-body td#nmr_agenda').text(nmr_agenda);
        modal.find('.modal-body td#nmr_sm').text(nmr_sm);
        modal.find('.modal-body td#kode_sm').text(kode_sm);
        modal.find('.modal-body td#tgl_sm').text(tgl_sm);
        modal.find('.modal-body td#kategori').text(kategori);
        modal.find('.modal-body td#pengirim').text(pengirim);
        modal.find('.modal-body td#lampiran').text(lampiran);
        modal.find('.modal-body td#status').html(statusText);
        modal.find('.modal-body td#perihal').text(perihal);
        modal.find('#surat_masuk_id').val(surat_masuk_id);

        $.each(listStafJson, function(key, val) {
            if ((val.user_id == "28" || val.user_id == 28) &&
                (ajukan_ke_user_id == '28' || ajukan_ke_user_id == 28)) {
                modal.find('.modal-body td#ajukan_ke_user_id').text(val.nama);
            }
        });

    });

    function disposisi() {
        var suratMasukId = $('#surat_masuk_id').val();
        var disposisiUserId = $('#disposisi-edit-dua').val();
        var tindakan = $('#tindakan').val();

        $.ajax({
            url: '{{ route("ajukan.surat.masuk.wakil") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                surat_masuk_id: suratMasukId,
                disposisi_ke_user_id: disposisiUserId,
                tindakan: tindakan
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