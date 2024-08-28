@extends('template.index')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Surat Keluar</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active" aria-current="page">Data Surat Keluar</li>
    </ol>
</div>


<!-- Row -->
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="col-lg-12">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('errors') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Surat Keluar</h6>
                    <a class="btn btn-sm btn-primary" href="" data-toggle="modal" data-target="#myModal"><i class="fas fa-fw fa-plus"></i> Tambah Data</a>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Tgl. Surat</th>
                                <th>No.Agenda</th>
                                <th>No. Surat Keluar</th>
                                <th>Tgl. Surat Keluar</th>
                                <th>Dari Disposisi</th>
                                <th>Tindakan</th>
                                <th>Status Surat</th>
                                <th>Berkas</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['list_surat'] as $item)
                            <tr class="text-center">
                                <td style="display: none;">{{ $item['surat_keluar_id'] }}</td>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $item['tgl_sk'] }}</td>
                                <td>{{ $item['nmr_agenda'] }}</td>
                                <td>{{ $item['nmr_sk'] }}</td>
                                <td style="display: none;">{{ $item['kode_sk'] }}</td>
                                <td>{{ $item['tgl_keluar'] }}</td>
                                <td style="display: none;">{{ $item['penerima_sk'] }}</td>
                                <td style="display: none;">{{ $item['perihal_sk'] }}</td>
                                <td style="display: none;">{{ $item['lampiran_sk'] }}</td>
                                <td>{{ $item['disposisi_nm_user'] }}</td>
                                <td>{{ $item['tindakan'] }}</td>
                                <td>
                                    @if ($item['status_id'] == 1)
                                    <span class="badge badge-primary"><i class="fas fa-spinner"></i> Proses</span>
                                    @elseif ($item['status_id'] == 2)
                                    <span class="badge badge-warning"><i class="fas fa-paper-plane"></i> Diajukan</span>
                                    @elseif ($item['status_id'] == 3)
                                    <span class="badge badge-success"><i class="fas fa-check"></i> Selesai Disposisi</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="{{ asset('file/uploads/surat-keluar/' . $item['nama_file']) }}" target="_blank"> Lihat File Pdf</a>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="" data-toggle="modal" onclick="editData(`{{ $item['surat_keluar_id'] }}`)">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>
                                    <br><br>
                                    <a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#detailSuratModal"
                                        data-tgl_keluar="{{ $item['tgl_keluar'] }}"
                                        data-nmr_agenda="{{ $item['nmr_agenda'] }}"
                                        data-kode_sk="{{ $item['kode_sk'] }}"
                                        data-nmr_sk="{{ $item['nmr_sk'] }}"
                                        data-tgl_sk="{{ $item['tgl_sk'] }}"
                                        data-penerima_sk="{{ $item['penerima_sk'] }}"
                                        data-perihal_sk="{{ $item['perihal_sk'] }}"
                                        data-lampiran_sk="{{ $item['lampiran_sk'] }}"
                                        data-tindakan="{{ $item['tindakan'] }}"
                                        data-status="{{ $item['status_id'] }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <br><br>
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

    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Surat Keluar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/karyawan/surat/keluar/add" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-form" style="display: flex; flex-direction: row; justify-content: space-between;">
                            <div class="modal-left">
                                <div class="form-group">
                                    <label for="tanggal-surat">Tanggal Masuk Surat:</label>
                                    <input type="date" class="form-control" id="tanggal-surat" name="tgl_keluar">
                                </div>
                                <div class="form-group">
                                    <label for="agenda">Nomor Agenda:</label>
                                    <input type="text" class="form-control" id="agenda" name="nmr_agenda" value="{{ $data['last_nmr_agenda'] }}" readonly>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="kode_surat">Kode Surat:</label>
                                    <input type="text" class="form-control" id="kode_surat" name="kode_sk">
                                </div> -->
                                <div class="form-group">
                                    <label for="nomor-surat">Nomor Surat:</label>
                                    <input type="text" class="form-control" id="nomor-surat" name="nmr_sk">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal-surat">Tanggal Surat:</label>
                                    <input type="date" class="form-control" id="tanggal-surat" name="tgl_sk">
                                </div>
                                <div class="form-group">
                                    <label for="penerima">Penerima</label>
                                    <input type="text" class="form-control" id="penerima" name="penerima_sk">
                                </div>
                            </div>
                            <div class="modal-right">
                                <div class="form-group">
                                    <label for="perihal-surat">Perihal Surat:</label>
                                    <input type="text" class="form-control" id="perihal-surat" name="perihal_sk">
                                </div>
                                <div class="form-group">
                                    <label for="lampiran-surat">Lampiran Surat:</label>
                                    <select class="form-control" name="lampiran_sk">
                                        <option selected disabled>Pilih Lampiran</option>
                                        <option value="1 Lampiran">1 Lampiran</option>
                                        <option value="2 Lampiran">2 Lampiran</option>
                                        <option value="3 Lampiran">3 Lampiran</option>
                                        <option value="4 Lampiran">4 Lampiran</option>
                                        <option value="5 Lampiran">5 Lampiran</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tindakan">Tindakan:</label>
                                    <input type="text" class="form-control" id="tindakan" name="tindakan">
                                </div>
                                <!-- <div class="form-group">
                                    <label for="upload-berkas">Berkas Kesalahan:</label><br>
                                    <small>Ukuran file PDF ( 50 MB )</small>
                                    <input type="file" name="berkas_kesalahan" class="form-control" multiple required>
                                </div> -->
                                <div class="form-group">
                                    <label for="upload-berkas">Upload PDF:</label><br>
                                    <small>Ukuran file PDF ( 50 MB )</small>
                                    <input type="file" name="file_pdf" class="form-control" multiple required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="myModalEdit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Surat Keluar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="formSuratKeluar" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-form" style="display: flex; flex-direction: row; justify-content: space-between;">
                            <div class="modal-left">
                                <input type="text" style="display: none;" class="form-control" id="surat_keluar_id" name="surat_keluar_id">
                                <div class="form-group">
                                    <label for="tanggal-surat">Tanggal Keluar:</label>
                                    <input type="date" class="form-control" id="tanggal-surat-keluar_edit" name="tgl_keluar">
                                </div>
                                <div class="form-group">
                                    <label for="agenda">Nomor Agenda:</label>
                                    <input type="text" class="form-control" id="agenda_edit" name="nmr_agenda" value="{{ $data['last_nmr_agenda'] }}" readonly>
                                </div>
                                <input type="text" class="form-control" id="kode_sk" name="kode_sk" style="display: none;">
                                <div class="form-group">
                                    <label for="nomor-surat">Nomor Surat:</label>
                                    <input type="text" class="form-control" id="nomor-surat_edit" name="nmr_sk">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal-surat">Tanggal Surat:</label>
                                    <input type="date" class="form-control" id="tanggal-surat_edit" name="tgl_sk">
                                </div>
                                <div class="form-group">
                                    <label for="pengirim-surat">Penerima Surat:</label>
                                    <input type="text" class="form-control" id="pengirim-surat_edit" name="penerima_sk">
                                </div>
                            </div>

                            <div class="modal-right">

                                <div class="form-group">
                                    <label for="perihal-surat">Perihal Surat:</label>
                                    <input type="text" class="form-control" id="perihal-surat_edit" name="perihal_sk">
                                </div>
                                <div class="form-group">
                                    <label for="lampiran-surat">Lampiran Surat:</label>
                                    <select class="form-control" id="lampiran_edit" name="lampiran_sk">
                                        <option selected disabled>Pilih Lampiran</option>
                                        <option value="1 Lampiran">1 Lampiran</option>
                                        <option value="2 Lampiran">2 Lampiran</option>
                                        <option value="3 Lampiran">3 Lampiran</option>
                                        <option value="4 Lampiran">4 Lampiran</option>
                                        <option value="5 Lampiran">5 Lampiran</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tindakan">Tindakan:</label>
                                    <input type="text" class="form-control" id="tindakan_edit" name="tindakan">
                                </div>
                                <input type="file" name="berkas_kesalahan" class="form-control" style="display: none;">
                                <div class="form-group">
                                    <label for="upload-berkas">Upload Berkas PDF:</label><br>
                                    <small>Ukuran file PDF ( 50 MB )</small>
                                    <input type="file" name="file_pdf" class="form-control" multiple required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="kirimData()" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Tgl. Surat Keluar</th>
                                <td id="tgl_keluar"></td>
                            </tr>
                            <tr>
                                <th>No. Agenda</th>
                                <td id="nmr_agenda"></td>
                            </tr>
                            <tr>
                                <th>No. Surat Keluar</th>
                                <td id="nmr_sk"></td>
                            </tr>
                            <tr>
                                <th>Tgl. Surat </th>
                                <td id="tgl_sk"></td>
                            </tr>
                            <tr>
                                <th>Penerima</th>
                                <td id="penerima_sk"></td>
                            </tr>
                            <tr>
                                <th>Perihal Surat</th>
                                <td id="perihal_sk"></td>
                            </tr>
                            <tr>
                                <th>Lampiran</th>
                                <td id="lampiran_sk"></td>
                            </tr>
                            <tr>
                                <th>Status Surat</th>
                                <td id="status"></td>
                            </tr>
                            <tr>
                                <th>Tindakan</th>
                                <td id="tindakan"></td>
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
        $('#detailSuratModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var modal = $(this); // The modal

            // Ambil data dari button
            var tgl_keluar = button.data('tgl_keluar');
            var nmr_agenda = button.data('nmr_agenda');
            var kode_sk = button.data('kode_sk');
            var nmr_sk = button.data('nmr_sk');
            var tgl_sk = button.data('tgl_sk');
            var penerima_sk = button.data('penerima_sk');
            var perihal_sk = button.data('perihal_sk');
            var lampiran_sk = button.data('lampiran_sk');
            var status = button.data('status');
            var tindakan = button.data('tindakan');

            // Set data ke modal
            var statusText = '';

            if (status == 1) {
                statusText = '<span class="badge badge-primary"><i class="fas fa-spinner"></i> Proses</span>';
            } else if (status == 2) {
                statusText = '<span class="badge badge-warning"><i class="fas fa-paper-plane"></i> Diajukan</span>';
            } else if (status == 3) {
                statusText = '<span class="badge badge-success"><i class="fas fa-check"></i> Selesai Disposisi</span>';
            }

            modal.find('.modal-body td#tgl_keluar').text(tgl_keluar);
            modal.find('.modal-body td#nmr_agenda').text(nmr_agenda);
            modal.find('.modal-body td#kode_sk').text(kode_sk);
            modal.find('.modal-body td#nmr_sk').text(nmr_sk);
            modal.find('.modal-body td#tgl_sk').text(tgl_sk);
            modal.find('.modal-body td#penerima_sk').text(penerima_sk);
            modal.find('.modal-body td#lampiran_sk').text(lampiran_sk);
            modal.find('.modal-body td#status').html(statusText);
            modal.find('.modal-body td#perihal_sk').text(perihal_sk);
            modal.find('.modal-body td#tindakan').text(tindakan);

        });

        $(document).ready(function() {
            $('#dataTable').DataTable(); // ID From dataTable
            $('#dataTableHover').DataTable(); // ID From dataTable with Hover
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".deleteBtn").click(function() {
                var id = $(this).data("id");
                var confirmDelete = confirm("Yakin ingin menghapus nomor surat ini?");

                if (confirmDelete) {
                    // Lakukan permintaan AJAX ke script PHP penghapusan
                    $.ajax({
                        url: "hapus_surat.php",
                        type: "POST",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            // Handle hasil penghapusan jika diperlukan
                            location.reload(); // Refresh halaman setelah penghapusan
                        }
                    });
                }
            });
        });

        function showModalEdit(id) {
            $('#editModal').modal('show');

            $.ajax({
                url: '/karyawan/surat/keluar/detail?id=' + id,
                type: 'GET',
                beforeSend: function() {
                    $('#buttonUpdate, #suratKeluarEdit').prop('disabled', true);
                    $('#suratKeluarEdit').val('Loading...');
                },
                success: function(response) {

                    $('#suratKeluarIdEdit').val(response.list_surat_keluar.surat_keluar_id);
                    $('#nmr_agenda_edit').val(response.list_surat_keluar.nmr_agenda);
                    $('#buttonUpdate, #suratKeluarEdit').prop('disabled', false);
                },
                error: function(xhr) {
                    console.log(xhr);
                    $('#formModalEdit').html(`<div class="alert alert-danger fade-show">Detail kategori gagal ditampilan</div>`);
                }
            });
        }

        function editData(surat_keluar_id) {
            var row = $('tr').filter(function() {
                return $(this).find('td:eq(0)').text().trim() == surat_keluar_id;
            });

            var tanggal_sk = row.find('td:eq(2)').text().trim();
            var nomor_agenda = row.find('td:eq(3)').text().trim();
            var nomor_sk = row.find('td:eq(4)').text().trim();
            var kode_sk = row.find('td:eq(5)').text().trim();
            var tanggal_surat = row.find('td:eq(6)').text().trim();
            var penerima_sk = row.find('td:eq(7)').text().trim();
            var perihal_sk = row.find('td:eq(8)').text().trim();
            var lampiran_sk = row.find('td:eq(9)').text().trim();
            var tindakan = row.find('td:eq(12)').text().trim();
            var status = row.find('td:eq(11)').text().trim();
            var disposisi = row.find('td:eq(10)').text().trim(); // Mengambil status jika diperlukan
            var file_pdf = row.find('td:eq(13)').text().trim(); // Jika Anda ingin menampilkan file PDF

            $('#tanggal-surat-keluar_edit').val(tanggal_surat);
            $('#agenda_edit').val(nomor_agenda);
            $('#surat_keluar_id').val(surat_keluar_id);
            $('#kode_sk').val(kode_sk); // Jika kode_surat seharusnya nomor_sk, ganti sesuai dengan kolom data yang benar
            $('#nomor-surat_edit').val(nomor_sk);
            $('#tanggal-surat_edit').val(tanggal_sk);
            $('#pengirim-surat_edit').val(penerima_sk);
            $('#perihal-surat_edit').val(perihal_sk); // Jika lampiran bisa kosong atau diatur sesuai dengan data yang benar
            $('#lampiran_edit').val(lampiran_sk); // Jika lampiran bisa kosong atau diatur sesuai dengan data yang benar
            $('#tindakan_edit').val(tindakan);
            $('#disposisi_edit').val(disposisi);
            $('#file_pdf').val(""); // Tidak dapat mengisi input file dengan nilai, perlu penanganan lain untuk file

            $('#myModalEdit').modal('show');
        }

        function kirimData() {
            var url;
            var method;

            url = '{{ route("surat.keluar.karyawan.update") }}';
            method = 'POST';

            var formData = new FormData(document.getElementById('formSuratKeluar'));

            $.ajax({
                type: method,
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Berhasil Mengubah Surat Keluar.'
                    });
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal Mengubah Surat Keluar!'
                    });
                }
            });
        }
    </script>
    @endsection