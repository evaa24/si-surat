@extends('template.index')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Disposisi</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item">Tabel Disposisi</li>
        <li class="breadcrumb-item active" aria-current="page">Data Disposisi</li>
    </ol>
</div>

<!-- Row -->
<div class="row">
    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Disposisi</h6>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                        <th>No.</th>
                        <th>No. Agenda</th>
                        <th>No. Surat Masuk</th>
                        <th>Pengirim</th>
                        <th>Tujuan Disposisi</th>
                        <th>Status</th>
                        <th>Catatan Disposisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['list_surat'] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $item['surat_masuk']['nmr_agenda'] }}</td>
                            <td>{{ $item['surat_masuk']['nmr_sm'] }}</td>
                            <td>{{ $item['surat_masuk']['pengirim'] }}</td>
                            <td>
                                <small>{{ $item['surat_masuk']['disposisi_ke_nm_user'] }} - (<b>{{ $item['tujuan_disposisi'] }} ?></b>)</small>
                            </td>
                            <td>
                                @if ($item['surat_masuk']['status_baca'] == 0)
                                    <span class="badge badge-primary">
                                        <i class="fas fa-spinner"></i>
                                         Masih Tahap Proses Baca Dari Bagian Disposisi
                                    </span>
                                @elseif ($item['surat_masuk']['status_baca']== 1)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i>
                                         Sudah Dibaca Dari Bagian Disposisi
                                    </span>
                                @endif
                            </td>
                            <td><?php $item['catatan'] ?></td>
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
      $('#dataTable').DataTable();
      $('#dataTableHover').DataTable();
    });
</script>
@endsection
