@extends('template.index')
@section('content')
<!-- Row -->
<div class="row">
    <!-- DataTable with Hover -->
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

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Kategori</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
              <li class="breadcrumb-item">Tabel Kategori</li>
              <li class="breadcrumb-item active" aria-current="page">Data Kategori</li>
            </ol>
        </div>

        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Kategori</h6>
                <a class="btn btn-sm btn-primary" href="" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i> Tambah Data</a>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                    <tr>
                    <th>No.</th>
                    <th>Nama Kategori</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['list_kategori'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $item['nama'] }}</td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="#" onclick="showModalEdit({{ $item['kategori_id'] }})"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-sm btn-danger" href="/admin/kategori/delete?id={{ $item['kategori_id'] }}" onclick="return confirm('Apakah anda ingin menghapus kategori?');">
                            <i class="fas fa-trash"></i>
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

<!-- Modal Tambah-->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Tambah Kategori</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
            <!-- Formulir untuk memasukkan nama kategori -->
            <form method="POST" action="/admin/kategori/add">
                @csrf
                <div class="form-group">
                    <label for="kategori">Nama Kategori:</label>
                    <input type="text" class="form-control" id="kategori" name="nama" placeholder="Masukkan Nama Kategori">
                </div>
                <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        </div>

        </div>
    </div>
</div>

<!-- Modal Edit-->
<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Edit Kategori</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
            <!-- Formulir untuk memasukkan nama kategori -->
            <form method="POST" action="/admin/kategori/update" id="formModalEdit">
                @csrf
                @method('put')
                <input type="hidden" name="id" id="kategoriIdEdit" value="">
                <div class="form-group">
                    <label for="kategori">Nama Kategori:</label>
                    <input type="text" class="form-control" id="kategoriNamaEdit" name="nama" placeholder="Masukkan Nama Kategori" value="">
                </div>
                <button type="submit" name="update" class="btn btn-success" id="buttonUpdate">Update</button>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
      $('#dataTable').DataTable();
      $('#dataTableHover').DataTable();
    });

    function showModalEdit(id) {
        $('#editModal').modal('show');

        $.ajax({
            url: '/admin/kategori/detail?id=' + id,
            type: 'GET',
            beforeSend: function () {
                $('#buttonUpdate, #kategoriNamaEdit').prop('disabled', true);
                $('#kategoriNamaEdit').val('Loading...');
            },
            success: function (response) {
                $('#kategoriIdEdit').val(response.kategori.kategori_id);
                $('#kategoriNamaEdit').val(response.kategori.nama);
                $('#buttonUpdate, #kategoriNamaEdit').prop('disabled', false);
            },
            error: function (xhr) {
                console.log(xhr);
                $('#formModalEdit').html(`<div class="alert alert-danger fade-show">Detail kategori gagal ditampilan</div>`);
            }
        });
    }
</script>
@endsection
