<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KartukeluargaController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\KelahiranController;
use App\Http\Controllers\KematianController;
// 
use App\Models\Profesi;
use App\Models\Penduduk;

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);
Route::get('user-index/{page}', [ApiController::class, 'index']);
Route::get('user-edit/{id}', [ApiController::class, 'show']);
Route::post('user-edit-proses', [ApiController::class, 'update']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::post('create', [ProductController::class, 'store']);
    Route::put('update/{product}',  [ProductController::class, 'update']);
    Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
    // kartu keluarga
    
});
// kk
Route::prefix('kk')->middleware(['jwt.verify'])->group(function () {
    Route::get('index', [KartukeluargaController::class, 'index']);
    Route::post('create', [KartukeluargaController::class, 'store']);
});

// kk
Route::post('kk-create', [KartukeluargaController::class, 'store']);
Route::get('kk-index_1/{page}', [KartukeluargaController::class, 'index']);
Route::post('kk-hapus', [KartukeluargaController::class, 'destroy']);
Route::get('kk-index', [KartukeluargaController::class, 'list_dropdown']);
Route::get('kk-edit/{no_kk}', [KartukeluargaController::class, 'show']);
Route::post('kk-edit-proses', [KartukeluargaController::class, 'edit']);

// penduduk
Route::post('penduduk-create', [PendudukController::class, 'store']);
Route::get('penduduk-index/{page}', [PendudukController::class, 'index']);
Route::post('penduduk-hapus', [PendudukController::class, 'destroy']);
Route::get('profesi-index', [PendudukController::class, 'list_dropdown']);
Route::get('penduduk-edit/{nik}', [PendudukController::class, 'show']);
Route::post('penduduk-edit-proses', [PendudukController::class, 'edit']);
Route::get('download-penduduk/{nik}', function($nik)
{   
    $data = DB::table('penduduks AS a')
                ->select('*')
                ->join('kartukeluargas AS b', 'a.no_kk', '=', 'b.no_kk')
                ->join('profesis AS c', 'a.profesi_id', '=', 'c.profesi_id')
                ->where('nik', $nik)->first();
    // dd($data->nik);
    $pdf = PDF::loadView('penduduk', compact('data'));
    $content = $pdf->output();
    // 
    $filename = 'data-penduduk-'.$nik.'.pdf';
    file_put_contents($filename, $content);
    // dd($filename);
    // Check if file exists in app/storage/file folder
    $file_path = public_path() . '/'. $filename;
    // dd($file_path);
    if (file_exists($file_path))
    {
        // Send Download
        return Response::download($file_path, $filename, [
            'Content-Length: '. filesize($file_path)
        ]);
    }
    else
    {
        // Error
        exit('Requested file does not exist on our server!');
    }
})
->where('filename', '[A-Za-z0-9\-\_\.]+');
// Route::post('penduduk-delete}', [PendudukController::class, 'destroy']);

// penduduk
Route::prefix('penduduk')->middleware(['jwt.verify'])->group(function () {
    Route::get('index/{nik}', [PendudukController::class, 'index']);
    Route::get('index/{nik}', [PendudukController::class, 'index']);
    Route::post('create', [PendudukController::class, 'store']);
});

// profesi
Route::prefix('profesi')->middleware(['jwt.verify'])->group(function () {
    Route::get('index/{page}', [ProfesiController::class, 'index']);
    Route::post('create', [ProfesiController::class, 'store']);
    Route::post('profesi-edit', [ProfesiController::class, 'show']);
    Route::post('hapus', [ProfesiController::class, 'destroy']);
});

Route::get('profesi-edit/{profesi_id}', [ProfesiController::class, 'show']);
Route::post('profesi-edit-proses', [ProfesiController::class, 'edit']);

// informasi
Route::get('info-index/{page}', [InformasiController::class, 'index']);
Route::post('addimage', [InformasiController::class, 'addimage']);
Route::post('hapus-info', [InformasiController::class, 'destroy']);

// kelahiran
Route::get('penduduk-index', [KelahiranController::class, 'list_dropdown']);
Route::get('kelahiran-index/{page}', [KelahiranController::class, 'index']);
Route::post('kelahiran-create', [KelahiranController::class, 'store']);
Route::get('kelahiran-edit/{kelahiran_id}', [KelahiranController::class, 'show']);
Route::post('kelahiran-edit-proses', [KelahiranController::class, 'update']);
Route::post('hapus-kelahiran', [KelahiranController::class, 'destroy']);
Route::get('download-kelahiran/{kelahiran_id}', function($kelahiran_id)
{       
    $dt_day = [
        "Sunday" => "Minggu",
        "Monday" => "Senin",
        "Tuesday" => "Selasa",
        "Wednesday" => "Rabu",
        "Thursday" => "Kamis",
        "Friday" => "Jumat",
        "Saturday" => "Sabtu",
    ];
    $data = DB::table('kelahirans AS a')
                ->select('a.*', 'b.alamat', 'b.jk', 'b.nama_lengkap AS nama_anak', 'd.nama_lengkap AS nama_ayah', 'c.nama_lengkap AS nama_ibu')
                ->join('penduduks AS b', 'a.nik', '=', 'b.nik')
                ->join('penduduks AS c', 'a.nik_ibu', '=', 'c.nik')
                ->join('penduduks AS d', 'a.nik_ayah', '=', 'd.nik')
                ->where('kelahiran_id', $kelahiran_id)
                ->first();
    $lahir = explode('-', $data->tgl_lahir);
    $now = explode('-', date('Y-m-d'));
    $timestamp = strtotime($data->tgl_lahir);
    $day = date('l', $timestamp);
    $data->tgl_lahir = $lahir[2].' '.DateTime::createFromFormat('!m', $lahir[1])->format('F').' '.$lahir[0]; 
    $data->tgl_now = $now[2].' '.DateTime::createFromFormat('!m', $now[1])->format('F').' '.$now[0];
    $data->nama_hari = $dt_day[$day];
    $pdf = PDF::loadView('kelahiran', compact('data'));
    $content = $pdf->output();
    // 
    $filename = 'data-kelahiran-'.$kelahiran_id.'.pdf';
    file_put_contents($filename, $content);
    // dd($filename);
    $file_path = public_path() . '/'. $filename;
    if (file_exists($file_path))
    {
        // Send Download
        return Response::download($file_path, $filename, [
            'Content-Length: '. filesize($file_path)
        ]);
    }
    else
    {
        // Error
        exit('Requested file does not exist on our server!');
    }
})
->where('filename', '[A-Za-z0-9\-\_\.]+');

// kematian
Route::get('penduduk-index', [KematianController::class, 'list_dropdown']);
Route::get('kematian-index/{page}', [KematianController::class, 'index']);
Route::post('kematian-create', [KematianController::class, 'store']);
Route::get('kematian-edit/{kematian_id}', [KematianController::class, 'show']);
Route::post('kematian-edit-proses', [KematianController::class, 'update']);
Route::post('hapus-kematian', [KematianController::class, 'destroy']);
Route::get('download-kematian/{kematian_id}', function($kematian_id)
{       
    $dt_day = [
        "Sunday" => "Minggu",
        "Monday" => "Senin",
        "Tuesday" => "Selasa",
        "Wednesday" => "Rabu",
        "Thursday" => "Kamis",
        "Friday" => "Jumat",
        "Saturday" => "Sabtu",
    ];
    $data = DB::table('kematians AS a')
                ->select('*')
                ->join('penduduks AS b', 'a.nik', '=', 'b.nik')
                ->join('profesis AS c', 'b.profesi_id', '=', 'c.profesi_id')
                ->where('kematian_id', $kematian_id)
                ->first();
    $lahir = explode('-', $data->tgl_lahir);
    $now = explode('-', date('Y-m-d'));
    $timestamp = strtotime($data->tgl_lahir);
    $day = date('l', $timestamp);
    $data->tgl_lahir = $lahir[2].' '.DateTime::createFromFormat('!m', $lahir[1])->format('F').' '.$lahir[0]; 
    $data->tgl_now = $now[2].' '.DateTime::createFromFormat('!m', $now[1])->format('F').' '.$now[0];
    $data->nama_hari = $dt_day[$day];
    // dd($data);
    $pdf = PDF::loadView('kematian', compact('data'));
    $content = $pdf->output();
    // 
    $filename = 'data-kematian-'.$kematian_id.'.pdf';
    file_put_contents($filename, $content);
    // dd($filename);
    // Check if file exists in app/storage/file folder
    $file_path = public_path() . '/'. $filename;
    // dd($file_path);
    if (file_exists($file_path))
    {
        // Send Download
        return Response::download($file_path, $filename, [
            'Content-Length: '. filesize($file_path)
        ]);
    }
    else
    {
        // Error
        exit('Requested file does not exist on our server!');
    }
})
->where('filename', '[A-Za-z0-9\-\_\.]+');

// pdf
Route::get('downloadProfesi', [ProfesiController::class, 'downloadPDF']);

// Route::get('downloadFile', [ProfesiController::class, 'downloadFile']);

// Download Route
Route::get('downloadFile', function()
{   
    $show = [];
        $datas = Profesi::all();
        $pdf = PDF::loadView('pdf', compact('datas'));

        $content = $pdf->output();

        file_put_contents('dataProfesi.pdf', $content);
        
    $filename = 'dataProfesi.pdf';
    // Check if file exists in app/storage/file folder
    $file_path = public_path() . '/'. $filename;
    // dd($file_path);
    if (file_exists($file_path))
    {
        // Send Download
        return Response::download($file_path, $filename, [
            'Content-Length: '. filesize($file_path)
        ]);
    }
    else
    {
        // Error
        exit('Requested file does not exist on our server!');
    }
})
->where('filename', '[A-Za-z0-9\-\_\.]+');


