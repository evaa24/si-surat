@extends('template.index')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Data Surat Masuk</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item">Tables</li>
    <li class="breadcrumb-item active" aria-current="page">Data Surat Masuk</li>
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
          <h6 class="m-0 font-weight-bold text-primary">Data Surat Masuk</h6>
          <a class="btn btn-sm btn-primary" href="" data-toggle="modal" data-target="#myModal"><i class="fas fa-fw fa-plus"></i> Tambah Data</a>
        </div>
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush" id="dataTable">
            <thead class="thead-light">
              <tr class="text-center">
                <th>No.</th>
                <th>Tgl. Surat</th>
                <th>No.Agenda</th>
                <th>No. Surat Masuk</th>
                <th>Tgl. Surat Masuk</th>
                <th>Kategori Surat</th>
                <th>Pengirim</th>
                <th>Lampiran</th>
                <th>Status Surat</th>
                <th>Berkas</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data['list_surat'] as $item)
              <tr class="text-center">
                <td style="display: none;">{{ $item['surat_masuk_id'] }}</td>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ $item['tgl_surat'] }}</td>
                <td>{{ $item['nmr_agenda'] }}</td>
                <td>{{ $item['nmr_sm'] }}</td>
                <td>{{ $item['tgl_sm'] }}</td>
                <td>{{ $item['kategori']['nama'] }}</td>
                <td>{{ $item['pengirim'] }}</td>
                <td>{{ $item['lampiran'] }}</td>
                <td>
                  @if ($item['status_id'] == 1)
                  <span class="badge badge-primary"><i class="fas fa-spinner"></i> Proses</span>
                  @elseif ($item['status_id'] == 2)
                  <span class="badge badge-warning"><i class="fas fa-paper-plane"></i> Diajukan</span>
                  @elseif ($item['status_id'] == 3)
                  <span class="badge badge-success"><i class="fas fa-check"></i> Selesai Disposisi</span>
                  @endif
                </td>
                <td style="display: none;">{{ $item['tindakan'] }}</td>
                <td style="display: none;">{{ $item['kode_sm'] }}</td>
                <td style="display: none;">{{ $item['perihal_surat'] }}</td>
                <td style="display: none;">{{ $item['kategori']['kategori_id'] }}</td>
                <td style="display: none;">{{ $item ['surat_masuk_id']}}</td>
                <td>
                  <a class="btn btn-sm btn-warning" href="{{ asset('file/uploads/surat-masuk/' . $item['nama_file']) }}" target="_blank"> Lihat File Pdf</a>
                </td>
                <td>
                  <a class="btn btn-sm btn-warning" href="#" data-toggle="modal" onclick="editData(`{{ $item['surat_masuk_id'] }}`)">
                    <i class="fas fa-fw fa-edit"></i>
                  </a><br><br>
                  <a class="btn btn-sm btn-warning" href="#" data-toggle="modal" data-target="#detailSuratModal" data-id="{{ $item['surat_masuk_id'] }}" data-tgl_surat="{{ $item['tgl_surat'] }}" data-nmr_agenda="{{ $item['nmr_agenda'] }}" data-nmr_sm="{{ $item['nmr_sm'] }}" data-tgl_sm="{{ $item['tgl_sm'] }}" data-kategori="{{ $item['kategori']['nama'] }}" data-pengirim="{{ $item['pengirim'] }}" data-lampiran="{{ $item['lampiran'] }}" data-status="{{ $item['status_id'] }}" data-tindakan="{{ $item['tindakan'] }}" data-kode_sm="{{ $item['kode_sm'] }}" data-perihal="{{ $item['perihal_surat'] }}" data-nama="{{ $item ['disposisi_ke_nm_user'] }}">
                    <i class=" fas fa-eye"></i>
                  </a>
                  <br><br>
                  <a class="btn btn-sm btn-danger" href="/admin/surat/masuk/delete?id={{ $item['surat_masuk_id'] }}" onclick="return confirm('Apakah anda ingin menghapus surat masuk?');"><i class="fas fa-fw fa-trash"></i></a>

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

  <div class=" modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Surat Masuk</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/admin/surat/masuk/add" enctype="multipart/form-data">
            @csrf
            <div class="modal-form" style="display: flex; flex-direction: row; justify-content: space-between;">
              <div class="modal-left">
                <div class="form-group">
                  <label for="tanggal-surat">Tanggal Masuk Surat:</label>
                  <input type="date" class="form-control" id="tanggal-surat" name="tgl_surat">
                </div>
                <div class="form-group">
                  <label for="agenda">Nomor Agenda:</label>
                  <input type="text" class="form-control" id="agenda" name="nmr_agenda" value="{{ $data['last_nmr_agenda'] }}" readonly>
                </div>
                <!-- <div class="form-group">
                  <label for="kode_surat">Kode Surat:</label>
                  <input type="hidden" class="form-control" id="kode_surat" name="kode_sm" >
                </div> -->
                <div class="form-group">
                  <label for="nomor-surat">Nomor Surat:</label>
                  <input type="text" class="form-control" id="nomor-surat" name="nmr_sm">
                </div>
                <div class="form-group">
                  <label for="tanggal-surat">Tanggal Surat:</label>
                  <input type="date" class="form-control" id="tanggal-surat" name="tgl_sm">
                </div>
                <div class="form-group">
                  <label for="tanggal-surat">Kategori Surat:</label>
                  <select class="form-control" id="kategori" name="kategori_id">
                    <option selected disabled>Pilih Kategori Surat</option>
                    @foreach ($data['list_kategori'] as $item)
                    <option value="{{ $item['kategori_id'] }}">{{ $item['nama'] }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="modal-right">
                <div class="form-group">
                  <label for="pengirim-surat">Pengirim Surat:</label>
                  <input type="text" class="form-control" id="pengirim-surat" name="pengirim">
                </div>
                <div class="form-group">
                  <label for="perihal-surat">Perihal Surat:</label>
                  <input type="text" class="form-control" id="perihal-surat" name="perihal_surat">
                </div>
                <div class="form-group">
                  <label for="lampiran-surat">Lampiran Surat:</label>
                  <select class="form-control" id="lampiran" name="lampiran">
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
                <div class="form-group">
                  <label for="upload-berkas">Upload Berkas PDF:</label><br>
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
          <h4 class="modal-title">Edit Surat Masuk</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="formSuratMasuk" enctype="multipart/form-data">
            @csrf
            <div class="modal-form" style="display: flex; flex-direction: row; justify-content: space-between;">
              <div class="modal-left">
                <input type="text" style="display: none;" class="form-control" id="surat_masuk_id" name="surat_masuk_id">
                <div class="form-group">
                  <label for="tanggal-surat">Tanggal Masuk Surat:</label>
                  <input type="date" class="form-control" id="tanggal-surat-masuk_edit" name="tgl_surat">
                </div>
                <div class="form-group">
                  <label for="agenda">Nomor Agenda:</label>
                  <input type="text" class="form-control" id="agenda_edit" name="nmr_agenda" value="{{ $data['last_nmr_agenda'] }}" readonly>
                </div>
                <input type="text" class="form-control" id="kode_surat_edit" name="kode_sm" style="display: none;">
                <div class="form-group">
                  <label for="nomor-surat">Nomor Surat:</label>
                  <input type="text" class="form-control" id="nomor-surat_edit" name="nmr_sm">
                </div>
                <div class="form-group">
                  <label for="tanggal-surat">Tanggal Surat:</label>
                  <input type="date" class="form-control" id="tanggal-surat_edit" name="tgl_sm">
                </div>
                <div class="form-group">
                  <label for="tanggal-surat">Kategori Surat:</label>
                  <select class="form-control" id="kategori_edit" name="kategori_id">
                    <option selected disabled>Pilih Kategori Surat</option>
                    @foreach ($data['list_kategori'] as $item)
                    <option value="{{ $item['kategori_id'] }}">{{ $item['nama'] }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="modal-right">
                <div class="form-group">
                  <label for="pengirim-surat">Pengirim Surat:</label>
                  <input type="text" class="form-control" id="pengirim-surat_edit" name="pengirim">
                </div>
                <div class="form-group">
                  <label for="perihal-surat">Perihal Surat:</label>
                  <input type="text" class="form-control" id="perihal-surat_edit" name="perihal_surat">
                </div>
                <div class="form-group">
                  <label for="lampiran-surat">Lampiran Surat:</label>
                  <select class="form-control" id="lampiran_edit" name="lampiran">
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

  @foreach ($data['list_surat'] as $item)
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
                <th>Tgl. Surat Masuk</th>
                <td id="tgl_surat"></td>
              </tr>
              <tr>
                <th>No. Agenda</th>
                <td id="nmr_agenda"></td>
              </tr>
              <!-- <tr>
                <th>Kode Surat</th>
                <td id="kode_sm"></td>
              </tr> -->

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
              <!-- <tr>
                <th>Disposisi</th>
              </tr>
              <tr>
                <th>Tujuan Disposisi</th>
                <td id="disposisi_ke_nm_user"></td>
              </tr>
              <tr>
                <th>Catatan</th>
              </tr> -->

            </tbody>
          </table>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  @endforeach
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
  </script>

  <script>
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
      var disposisi_ke_nm_user = button.data('disposisi_ke_nm_user');

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
      modal.find('.modal-body td#disposisi_ke_nm_user').text(disposisi_ke_nm_user);
    });




    function kirimData() {
      var url;
      var method;

      url = '{{ route("surat.masuk.update") }}';
      method = 'POST';

      var formData = new FormData(document.getElementById('formSuratMasuk'));

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
            text: 'Berhasil Mengubah Surat Masuk.'
          });
          window.location.reload();
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal Mengubah Surat Masuk!'
          });
        }
      });
    }




    function editData(surat_masuk_id) {
      var row = $('td').filter(function() {
        return $(this).text() == surat_masuk_id;
      }).closest('tr');

      var tanggal_surat_masuk = row.find('td:eq(5)').text();
      var nomor_agenda = row.find('td:eq(3)').text();
      var kode_surat = row.find('td:eq(11)').text();
      var nomor_surat = row.find('td:eq(4)').text();
      var tanggal_surat = row.find('td:eq(2)').text();
      var kategori_surat = row.find('td:eq(13)').text();
      var pengirim_surat = row.find('td:eq(7)').text();
      var perihal_surat = row.find('td:eq(12)').text();
      var surat_masuk_id = row.find('td:eq(14)').text();
      var lampiran_surat = row.find('td:eq(8)').text();
      var tindakan = row.find('td:eq(10)').text();
      var pdf = row.find('td:eq(11)').text();

      $('#tanggal-surat-masuk_edit').val(tanggal_surat_masuk);
      $('#agenda_edit').val(nomor_agenda);
      $('#surat_masuk_id').val(surat_masuk_id);
      $('#kode_surat_edit').val(kode_surat);
      $('#nomor-surat_edit').val(nomor_surat);
      $('#tanggal-surat_edit').val(tanggal_surat);
      $('#kategori_edit').val(kategori_surat);
      $('#pengirim-surat_edit').val(pengirim_surat);
      $('#perihal-surat_edit').val(perihal_surat);
      $('#lampiran_edit').val(lampiran_surat);
      $('#tindakan_edit').val(tindakan);
      $('#file_pdf').val(pdf);

      $('#myModalEdit').modal('show');
    }
  </script>
  @endsection