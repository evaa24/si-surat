@extends('template.index')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</div>

<div class="row mb-3">
    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
        <div class="row align-items-center">
            <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Surat Masuk</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
                {{ $data['statistik']['total_surat_masuk'] }}
            </div>
            </div>
            <div class="col-auto">
            <i class="fas fa-envelope fa-2x text-primary"></i>
            </div>
        </div>
        </div>
    </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Surat Keluar</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
                {{ $data['statistik']['total_surat_keluar'] }}
            </div>
            </div>
            <div class="col-auto">
            <i class="fas fa-envelope-open fa-2x text-success"></i>
            </div>
        </div>
        </div>
    </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Pengguna</div>
            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                {{ $data['statistik']['total_pengguna'] }}
            </div>
            </div>
            <div class="col-auto">
            <i class="fas fa-users fa-2x text-info"></i>
            </div>
        </div>
        </div>
    </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Disposisi</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
                {{ $data['statistik']['total_disposisi'] }}
            </div>
            </div>
            <div class="col-auto">
            <i class="fas fa-check-circle fa-2x text-warning"></i>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection
