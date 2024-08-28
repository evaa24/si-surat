<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Surat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .kop-surat {
            margin-top: 50px;
            text-align: center;
            line-height: 1.5;
        }

        .kop-surat h1,
        .kop-surat h2 {
            margin: 0;
        }

        .table-surat {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table-surat th,
        .table-surat td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .tanda-tangan {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>

<body>

    <!-- Kop Surat -->
    <div class="kop-surat">
        <h1>STMIK BANDUNG</h1>
        <p>Jl. Cikutra 113A</p>
        <p>Telp.(022)7207777</p>
        <p>Email: info@stmikbandung.ac.id</p>
    </div>

    <!-- Tabel Surat -->
    <table class="table-surat">
        <thead>
            <tr>
                <th>No Surat</th>
                <th>Tgl. Surat</th>
                <th>Perihal</th>
                <th>Pengirim</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_surat_masuk as $surat)
            <tr>
                <td>{{ $surat['nmr_sm'] }}</td>
                <td>{{ $surat['tgl_surat'] }}</td>
                <td>{{ $surat['perihal_surat'] }}</td>
                <td>{{ $surat['pengirim'] }}</td>
                <td> @if ($surat['status_id'] == 1)
                    <span class="badge badge-primary"><i class="fas fa-spinner"></i> Proses</span>
                    @elseif ($surat['status_id'] == 2)
                    <span class="badge badge-warning"><i class="fas fa-paper-plane"></i> Diajukan</span>
                    @elseif ($surat['status_id'] == 3)
                    <span class="badge badge-success"><i class="fas fa-check"></i> Selesai Disposisi</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Tanggal Cetak: {{ now()->format('Y-m-d') }}</p>
    </div>

    <!-- Tanda Tangan -->
    <div class="tanda-tangan">
        <p>Tanda Tangan</p>
        <p>Linda Apriyanti</p>
    </div>

</body>

</html>