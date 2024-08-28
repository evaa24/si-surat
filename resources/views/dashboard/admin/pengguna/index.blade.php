@extends('template.index')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h6 mb-0 text-gray-800">Data Pengguna</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active" aria-current="page">Data Penguna</li>
    </ol>
</div>

  <!-- Row -->
  <div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush" id="dataTable">
            <thead class="thead-light">
              <tr class="text-center">
                <th>No.</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>Foto</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($data['list_staff'] as $item)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}.</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['jabatan'] }}</td>
                    <td>
                    <img src="{{ $item['image'] }}" class="rounded" alt="Foto Pengguna" width="60px">
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
@endsection

@section('scripts')
<script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {
    $('#dataTable').DataTable(); // ID From dataTable
    $('#dataTableHover').DataTable(); // ID From dataTable with Hover
});
</script>
@endsection
