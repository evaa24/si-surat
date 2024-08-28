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
                            <th>Tindakan</th>
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
                            <td>{{ $surat['tindakan'] }}</td>
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
                            <td id="detailStatusSK"></td>
                        </tr>
                        <tr>
                            <th>Tindakan</th>
                            <td id="detailTindakanSk"></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table">
                    <tbody>
                        <!-- Existing rows here -->
                        <tr>
                            <th>Tanggal Surat Keluar</th>
                            <th>Tindakan</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control" id="detailTanggalSurat1" readonly>
                            </td>
                            <td>
                                <select class="form-control" id="status_id" name="status_idd" onchange="onChangeKeterangan(this.value)">
                                    <option value="">Pilih Status</option>
                                    @foreach ($list_status as $status)
                                    <option value="{{ $status['status_id'] }}">{{ $status['ket_status'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <input type="text" id="detailSuratId" name="surat_masuk_id" style="display: none;">
                        </tr>
                        <tr>
                            <!-- klik status_id 3 -->
                        <tr id="header_id3"></tr>
                        <td id="status_id3" style="display: none;"></td>

                        <!-- klik status_id 5 -->
                        <tr id="header_id5"></tr>
                        <td id="status_id5" style="display: none;"></td>
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

        $('#detailSuratModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            $('#detailTanggalSurat').text(button.data('tanggal-surat'));
            $('#detailNomorAgenda').text(button.data('nomor-agenda'));
            $('#detailKodeSK').text(button.data('kode-sk'));
            $('#detailNomorSK').text(button.data('nomor-sk'));
            $('#detailTanggalSK').text(button.data('tanggal-sk'));
            $('#detailPerihalSK').text(button.data('perihal-sk'));
            $('#detailLampiranSK').text(button.data('lampiran-sk'));
            $('#detailStatusSK').text(button.data('status-sk'));
            $('#detailPenerimaSK').text(button.data('penerima-sk'));
            $('#detailTindakanSk').text(button.data('tindakan'));
            $('#detailTanggalSurat1').val(button.data('tanggal-surat'));
            $('#detailSuratId').val(button.data('surat_keluar_id'));
        });
    });

    function onChangeKeterangan(keteranganValue) {
        console.log(keteranganValue);
        if (keteranganValue == "3" || keteranganValue == 3) {
            $('#status_id5').css('display', 'none');
            $('#status_id5').html('');
            var tdKeterangan = '';
            tdKeterangan = `<select class="form-control" id="user_id" name="user_id">
                                        <option value="">Pimpinan Baca</option>
                                        @foreach ($list_staff as $staff)
                                        @if($staff['user_id'] == 28 || $staff['user_id'] == '28')
                                            <option value="{{ $staff['user_id'] }}">{{ $staff['nama'] }}</option>
                                        @endif
                                        @endforeach
                                    </select>`;
            $('#status_id3').css('display', 'block');
            $('#status_id3').html(tdKeterangan);

            $('#header_id5').css('display', 'none');
            $('#header_id5').html('');
            var tdKeteranganHeader = '';
            tdKeteranganHeader = `<th> Cek Baca Pimpinan </th>`;
            $('#header_id3').css('display', 'block');
            $('#header_id3').html(tdKeteranganHeader);

            var tdKeteranganHeaderDua = '';
            tdKeteranganHeaderDua = `<th>Keterangan Perbaiki</th>`;
            $('#header_id5').css('display', 'block');
            $('#header_id5').html(tdKeteranganHeaderDua);

            var tdKeteranganDua = '';
            tdKeteranganDua = `<input type="text" class="form-control" id="tindakan" name="tindakan" required>`;
            $('#status_id5').css('display', 'block');
            $('#status_id5').html(tdKeteranganDua);

            $('#tindakan').attr('disabled', false)
            $('#user_id').attr('disabled', false)

        } else if (keteranganValue == "5" || keteranganValue == 5) {
            $('#status_id3').css('display', 'none');
            $('#status_id3').html('');
            var tdKeterangan = '';
            tdKeterangan = `<input type="text" class="form-control" id="tindakan" name="tindakan" required>`;
            $('#status_id5').css('display', 'block');
            $('#status_id5').html(tdKeterangan);

            $('#header_id3').css('display', 'none');
            $('#header_id3').html('');
            var tdKeteranganHeader = '';
            tdKeteranganHeader = `<th>Keterangan Perbaiki</th>`;
            $('#header_id5').css('display', 'block');
            $('#header_id5').html(tdKeteranganHeader);

            $('#user_id').attr('disabled', true)
            $('#tindakan').attr('disabled', false)
        }
    }

    function ajukanSurat() {
        var suratKeluarId = $('#detailSuratId').val();
        var statusId = $('#status_id').val();
        var disposisiUserId = $('#user_id').val();
        var tindakan = $('#tindakan').val();

        console.log(suratKeluarId);
        console.log(statusId);
        console.log(disposisiUserId);
        console.log(tindakan);

        $.ajax({
            url: '{{ route("ajukan.surat.keluar") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                surat_keluar_id: suratKeluarId,
                status_id: statusId,
                tindakan: tindakan,
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