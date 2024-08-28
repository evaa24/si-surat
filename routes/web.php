<?php

use App\Http\Controllers\Admin\KategoriSuratController;
use App\Http\Controllers\Admin\SuratMasukController as AdminSuratMasukController;
use App\Http\Controllers\Admin\SuratKeluarController as AdminSuratKeluarController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Sekretaris\PeriksaSuratMasukController as SekretarisPeriksaSuratMasukController;
use App\Http\Controllers\Sekretaris\PeriksaSuratKeluarController as SekretarisPeriksaSuratKeluarController;
use App\Http\Controllers\Sekretaris\HistoryController as SekretarisHistoryController;
use App\Http\Controllers\Sekretaris\SuratMasukController as SekretarisSuratMasukController;
use App\Http\Controllers\Sekretaris\SuratKeluarController as SekretarisSuratKeluarController;
use App\Http\Controllers\Karyawan\SuratMasukController as KaryawanSuratMasukController;
use App\Http\Controllers\Karyawan\SuratKeluarController as KaryawanSuratKeluarController;
use App\Http\Controllers\WakilPimpinan\PeriksaSuratMasukController as WakilPimpinanPeriksaSuratMasukController;
use App\Http\Controllers\WakilPimpinan\PeriksaSuratKeluarController as WakilPimpinanPeriksaSuratKeluarController;
use App\Http\Controllers\WakilPimpinan\HistoryController as WakilPimpinanHistoryController;
use App\Http\Controllers\WakilPimpinan\SuratMasukController as WakilPimpinanSuratMasukController;
use App\Http\Controllers\WakilPimpinan\SuratKeluarController as WakilPimpinanSuratKeluarController;
use App\Models\AdminSuratMasukService;
use App\Models\KaryawanSuratMasukService;
use App\Models\SekretarisSuratKeluarService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Storage;

/**
 * ! Jangan ubah route yang ada dalam group ini
 * */
Route::controller(AuthController::class)
    ->group(function () {
        Route::get('/', 'checkToken')->name('check');
        Route::get('/logout', 'logout')->name('logout'); // gunakan untuk logout
        Route::get('/roles', 'changeUserRole')->middleware('auth.token');
    });

/**
 * ! Jadikan route di bawah sebagai halaman utama dari web
 * ! harap tidak mengubah nilai pada name();
 */
Route::middleware('auth.token')
    ->group(function () {
        Route::get('/home', [HomeController::class, 'home'])->name('home');
    });

/**
 * * Buat route-route baru di bawah ini
 * * Pastikan untuk selalu menggunakan middleware('auth.token')
 * * middleware tersebut digunakan untuk verifikasi access pengguna dengan web
 *
 * * Bisa juga ditambahkan dengan middleware lainnya.
 * * Berikut adalah beberapa middleware lain yang telah tersedia,
 * * dapat digunakan untuk mengatur akses route berdasarkan role user
 *
 * 1.) auth.admin
 * 2.) auth.secretary
 * 3.) auth.wakil
 * 4.) auth.staff
 *
 * ? contoh penggunaan: middleware(['auth.token', 'auth.mahasiswa'])
 */

/**
 * Apabila telah menambahkan route baru tetapi tidak dapat diakses
 * buka terminal baru dan jalankan perintah 'php artisan optimize' tanpa tanda petik
 */

// Admin
Route::prefix('/admin')
    ->middleware(['auth.token', 'auth.admin'])
    ->group(function () {
        // kategori
        Route::controller(KategoriSuratController::class)
            ->prefix('/kategori')
            ->group(function () {
                Route::get('/', 'index');
                Route::post('/add', 'add');
                Route::put('/update', 'update');
                Route::get('/detail', 'detail');
                Route::get('/delete', 'delete');
            });

        // surat masuk
        Route::controller(AdminSuratMasukController::class)
            ->prefix('/surat')
            ->group(function () {

                Route::get('/arsip', 'getListArsip');

                // kelola surat masuk
                Route::prefix('/masuk')
                    ->group(function () {
                        Route::get('/disposisi', 'disposisi');
                        Route::get('/', 'getListSurat');
                        Route::post('/add', 'addSurat');
                        Route::post('/update', 'updateSurat')->name('surat.masuk.update');
                        Route::get('/delete', 'deleteSurat');
                    });
            });


        // surat keluar
        Route::controller(AdminSuratKeluarController::class)
            ->prefix('/surat')
            ->group(function () {
                Route::get('/disposisi', 'disposisi');
                Route::get('/arsip', 'getListArsip');

                // kelola surat masuk
                Route::prefix('/keluar')
                    ->group(function () {
                        Route::get('/', 'getListSurat');
                        Route::post('/add', 'addSurat');
                        Route::get('/detail', 'detail');
                        Route::get('/delete', 'deleteSurat');
                        Route::post('/update', 'updateSurat')->name('surat.keluar.update');
                        // Route::put('/update', 'update');
                    });
            });

        // pengguna
        Route::controller(AdminUserController::class)
            ->prefix('/pengguna')
            ->group(function () {
                Route::get('/', 'index');
            });

        // laporan masuk
        Route::controller(AdminLaporanController::class)
            ->prefix('/laporan')
            ->group(function () {
                Route::prefix('/laporan_masuk')
                    ->group(function () {
                        Route::get('/', 'laporan_masuk');
                        Route::post('/load_table_masuk', 'load_table_masuk');
                        Route::get('/cetak_pdf_surat_masuk', 'cetak_pdf_surat_masuk');
                    });
            });

        // laporan masuk
        Route::controller(AdminLaporanController::class)
            ->prefix('/laporan')
            ->group(function () {
                Route::prefix('/laporan_keluar')
                    ->group(function () {
                        Route::get('/', 'laporan_keluar');
                        Route::post('/load_table_keluar', 'load_table_keluar');
                        Route::get('/cetak_pdf_surat_keluar', 'cetak_pdf_surat_keluar');
                    });
            });
    });


//SEKRETARIS
Route::prefix('/sekretaris')
    ->middleware(['auth.token', 'auth.secretary'])
    ->group(function () {
        // periksa surat masuk
        Route::controller(SekretarisPeriksaSuratMasukController::class)
            ->prefix('/surat')
            ->group(function () {
                // kelola surat masuk
                Route::prefix('/masuk')
                    ->group(function () {
                        Route::get('/', 'periksa_surat_masuk');
                        Route::post('/update', 'ajukan_surat')->name('ajukan.surat');
                    });
            });

        // Route::controller(SekretarisPeriksaSuratKeluarController::class)
        //     ->prefix('/periksa_sk')
        //     ->group(function () {
        //         Route::get('/', 'periksa_surat_keluar');
        //     });
        Route::controller(SekretarisPeriksaSuratKeluarController::class)
            ->prefix('/surat')
            ->group(function () {

                // kelola surat masuk
                Route::prefix('/keluar')
                    ->group(function () {
                        Route::get('/', 'periksa_surat_keluar');
                        Route::post('/update', 'ajukan_surat_keluar')->name('ajukan.surat.keluar');
                    });
            });

        Route::controller(SekretarisSuratMasukController::class)
            ->prefix('/surat_masuk')
            ->group(function () {
                Route::get('/', 'index');
            });

        Route::controller(SekretarisSuratKeluarController::class)
            ->prefix('/surat_keluar')
            ->group(function () {
                Route::get('/', 'index');
            });

        Route::controller(SekretarisHistoryController::class)
            ->prefix('/history')
            ->group(function () {
                Route::get('/', 'index');
            });
    });

//KARYAWAN
Route::prefix('/karyawan')
    ->middleware(['auth.token', 'auth.staff'])
    ->group(function () {
        // periksa surat masuk
        Route::controller(KaryawanSuratMasukController::class)
            ->prefix('/surat_masuk')
            ->group(function () {
                Route::get('/', 'index');
                Route::post('/update', 'terima_surat')->name('terima.surat');

                Route::get('/surat-masuk/{filename}', function ($filename) {
                    $path = storage_path('app/' . $filename);

                    if (!File::exists($path)) {
                        abort(404);
                    }

                    $file = File::get($path);
                    $type = File::mimeType($path);

                    $response = Response::make($file, 200);
                    $response->header("Content-Type", $type);

                    return $response;
                });
            });

        Route::controller(KaryawanSuratKeluarController::class)
            ->prefix('/surat')
            ->group(function () {

                // kelola surat masuk
                Route::prefix('/keluar')
                    ->group(function () {
                        Route::get('/', 'index');
                        Route::post('/add', 'addSurat');
                        Route::get('/detail', 'detail');
                        Route::get('/delete', 'deleteSurat');
                        Route::post('/update', 'updateSurat')->name('surat.keluar.karyawan.update');
                    });
            });
    });

//WAKIL PIMPINAN
Route::prefix('/wakil_pimpinan')
    ->middleware(['auth.token', 'auth.wakil'])
    ->group(function () {
        // periksa surat masuk
        Route::controller(WakilPimpinanPeriksaSuratMasukController::class)
            ->prefix('/periksa_sm')
            ->group(function () {
                Route::get('/', 'periksa_surat_masuk');
                Route::post('/update', 'ajukan_surat_masuk_wakil')->name('ajukan.surat.masuk.wakil');
            });

        Route::controller(WakilPimpinanPeriksaSuratKeluarController::class)
            ->prefix('/periksa_sk')
            ->group(function () {
                Route::get('/', 'periksa_surat_keluar');
                Route::post('/update', 'ajukan_surat_keluar_wakil')->name('ajukan.surat.keluar.wakil');
            });

        Route::controller(WakilPimpinanSuratMasukController::class)
            ->prefix('/surat_masuk')
            ->group(function () {
                Route::get('/', 'index');
            });

        Route::controller(WakilPimpinanSuratKeluarController::class)
            ->prefix('/surat_keluar')
            ->group(function () {
                Route::get('/', 'index');
            });

        Route::controller(WakilPimpinanHistoryController::class)
            ->prefix('/history')
            ->group(function () {
                Route::get('/', 'index');
            });
    });
