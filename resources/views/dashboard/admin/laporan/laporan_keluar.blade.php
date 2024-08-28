@extends('template.index')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{ asset('img/logo/logo3.png') }}" rel="icon">
    <title>Surat - Data Laporan Surat Keluar</title>

    <style>
        .custom-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100% !important;
            table-layout: fixed;
        }

        .table th,
        .table td {
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }
    </style>

</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Data Laporan</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                            <li class="breadcrumb-item">Laporan Surat Keluar</li>
                            <li class="breadcrumb-item active" aria-current="page">Data Laporan</li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Laporan Surat Keluar (Tanggal Keluar Surat)</h6>
                                </div>
                                <div class="container">
                                    <form method="POST" action="#" id="filterForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="custom-form">
                                                    <div class="form-group">
                                                        <label for="tanggal">Tanggal:</label>
                                                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-form">
                                                    <div class="form-group">
                                                        <label for="status">Status:</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option selected disabled>Pilih Status Surat</option>
                                                            @foreach($list_status as $item)
                                                            <option value="{{ $item['status_id'] }}">{{ $item['ket_status'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button id="filterButton" class="btn btn-sm btn-primary" type="button">Filter</button>
                                    </form>
                                </div>
                                <br>
                                <div class="d-flex justify-content-end" style="margin-right: 20px;">
                                    <button class="btn btn-sm btn-info" style="width: 10%;"
                                        onclick="window.open('laporan_keluar/cetak_pdf_surat_keluar?tanggal=' + $('#tanggal').val() + '&status=' + $('#status').val(), '_blank');">
                                        Cetak Semua
                                    </button>
                                </div>

                                <hr>
                                <div class="table-responsive p-3" id="tableSuratKeluar" style="display: none;">
                                    <table class="table table-bordered align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No.</th>
                                                <th>Tanggal</th>
                                                <th>No. Agenda</th>
                                                <th>No. Surat Keluar</th>
                                                <th>Perihal</th>
                                                <th>Penerima</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    @endsection

    @section('scripts')
    <script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {



            var table = $('#dataTableHover').DataTable({
                ajax: {
                    url: '/admin/laporan/laporan_keluar/load_table_keluar', // URL API untuk memuat data
                    type: 'POST',
                    data: function(d) {
                        d._token = '{{ csrf_token() }}'; // Sertakan CSRF token
                        d.tanggal = $('#tanggal').val(); // Kirim filter tanggal
                        d.status = $('#status').val(); // Kirim filter status
                    },
                    dataSrc: function(json) {
                        return json.dataListSurat.original.data.rekap_surat_keluar;
                    },
                    error: function(xhr, error, code) {
                        console.log("Error:", xhr, error, code);
                    }
                },
                columns: [{
                        data: 'surat_keluar_id'
                    }, // Kolom No.
                    {
                        data: 'tgl_keluar'
                    }, // Kolom Tanggal
                    {
                        data: 'nmr_agenda'
                    }, // Kolom No. Agenda
                    {
                        data: 'nmr_sk'
                    }, // Kolom No. Surat Masuk
                    {
                        data: 'perihal_sk'
                    }, // Kolom Perihal
                    {
                        data: 'penerima_sk'
                    }, // Kolom Pengirim
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<button class="btn btn-sm btn-info" data-id="' + row.surat_keluar_id + '" onclick="window.open(\'laporan_keluar/cetak_pdf_surat_keluar?nama_file=' + row.nama_file + '\', \'_blank\');">Cetak</button>';
                        },
                        orderable: false
                    } // Kolom Action
                ],
                order: [
                    [1, 'asc']
                ]
            });

            $('#filterButton').on('click', function() {
                $('#tableSuratKeluar').css("display", "block")
                table.ajax.reload(); // Muat ulang tabel dengan filter baru
            });

            // Event handler untuk tombol Cetak
            $('#dataTableHover').on('click', '.cetak-pdf', function() {
                var suratMasukId = $(this).data('id'); // Ambil surat_masuk_id dari tombol yang diklik

                $.ajax({
                    url: 'laporan_masuk/cetak_pdf_surat_masuk',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        surat_masuk_id: suratMasukId,
                        tanggal: $('#tanggal').val(), // Sertakan tanggal
                        status: $('#status').val() // Sertakan status
                    },
                    success: function(response) {
                        // console.log("Cetak berhasil:", response);
                        window.open('laporan_masuk/cetak_pdf_surat_masuk', '_blank');

                    },
                    error: function(xhr, status, error) {
                        console.error("Cetak gagal:", xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal mencetak surat masuk!'
                        });
                    }
                });
            });
        });
    </script>

    @endsection

</body>

</html>