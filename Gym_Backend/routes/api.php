<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('members', 'Api\MemberController@index');
    Route::get('members/{id}', 'Api\MemberController@show');
    Route::post('members', 'Api\MemberController@store');
    Route::put('members/{id}', 'Api\MemberController@update');
    Route::delete('members/{id}', 'Api\MemberController@destroy');
    Route::put('membersResetPass/{id}', 'Api\MemberController@reset');
    Route::get('membersSearch', 'Api\MemberController@search');
    Route::put('membersStatus/{id}', 'Api\MemberController@updateStatus');
    Route::put('membersSisa/{id}', 'Api\MemberController@updateSisa');

    Route::get('instruktur', 'Api\InstrukturController@index');
    Route::get('instruktur/{id}', 'Api\InstrukturController@show');
    Route::post('instruktur', 'Api\InstrukturController@store');
    Route::put('instruktur/{id}', 'Api\InstrukturController@update');
    Route::delete('instruktur/{id}', 'Api\InstrukturController@destroy');
    Route::get('instrukturSearch', 'Api\InstrukturController@search');

    Route::get('promo', 'Api\PromoController@index');
    Route::get('promo/{id}', 'Api\PromoController@show');
    Route::post('promo', 'Api\PromoController@store');
    Route::put('promo/{id}', 'API\PromoController@update');
    Route::delete('promo/{id}', 'API\PromoController@destroy');

    Route::get('kelas', 'Api\KelasController@index');
    Route::get('kelas/{id}', 'Api\KelasController@show');
    Route::post('kelas', 'Api\KelasController@store');
    Route::put('kelas/{id}', 'Api\KelasController@update');
    Route::delete('kelas/{id}', 'Api\KelasController@destroy');

    Route::get('jadwalUmum', 'Api\JadwalUmumController@index');
    Route::get('jadwalUmum/{id}', 'Api\JadwalUmumController@show');
    Route::post('jadwalUmum', 'Api\JadwalUmumController@store');
    Route::put('jadwalUmum/{id}', 'Api\JadwalUmumController@update');
    Route::delete('jadwalUmum/{id}', 'Api\JadwalUmumController@destroy');

    Route::get('jadwalHarian', 'Api\JadwalHarianController@index');
    Route::get('jadwalHarian/{id}', 'Api\JadwalHarianController@show');
    Route::post('jadwalHarian', 'Api\JadwalHarianController@store');
    Route::put('jadwalHarian/{id}', 'Api\JadwalHarianController@update');
    Route::delete('jadwalHarian/{id}', 'Api\JadwalHarianController@destroy');

    Route::get('aktivasiTahunan', 'Api\AktivasiTahunanController@index');
    Route::get('aktivasiTahunan/{id}', 'Api\AktivasiTahunanController@show');
    Route::post('aktivasiTahunan', 'Api\AktivasiTahunanController@store');

    Route::get('depositUang', 'Api\DepositUangController@index');
    Route::get('depositUang/{id}', 'Api\DepositUangController@show');
    Route::post('depositUang', 'Api\DepositUangController@store');

    Route::get('depositKelas', 'Api\DepositKelasController@index');
    Route::get('depositKelas/{id}', 'Api\DepositKelasController@show');
    Route::post('depositKelas', 'Api\DepositKelasController@store');

    Route::get('IzinInstruktur', 'Api\IzinInstrukturController@index');
    Route::get('IzinInstruktur/{id}', 'Api\IzinInstrukturController@show');
    Route::post('IzinInstruktur', 'Api\IzinInstrukturController@store');
    Route::put('IzinInstruktur/{id}', 'Api\IzinInstrukturController@update');
    Route::delete('IzinInstruktur/{id}', 'Api\IzinInstrukturController@destroy');
    Route::put('IzinInstrukturStatus/{id}', 'Api\IzinInstrukturController@updateStatus');

    Route::get('BookingGym', 'Api\BookingGymController@index');
    Route::get('BookingGym/{id}', 'Api\BookingGymController@show');
    Route::post('BookingGym', 'Api\BookingGymController@store');
    Route::put('BookingGym/{id}', 'Api\BookingGymController@update');
    Route::delete('BookingGym/{id}', 'Api\IzinInstrukturController@destroy');
    Route::put('BookingGymStatus/{id}', 'Api\BookingGymController@updateStatus');

    Route::get('BookingKelas', 'Api\BookingKelasController@index');
    Route::get('BookingKelas/{id}', 'Api\BookingKelasController@show');

    Route::get('pegawai', 'Api\PegawaiController@index');
    Route::get('pegawai/{id}', 'Api\PegawaiController@show');
    Route::post('pegawai', 'Api\PegawaiController@store');
    Route::put('pegawai/{id}', 'Api\PegawaiController@update');
    Route::delete('pegawai/{id}', 'Api\PegawaiController@destroy');

    Route::get('laporan', function () {
        $currentMonth = Carbon::now()->format('Y-m');
        $laporan = DB::select("SELECT DATE_FORMAT(tanggal_booking, '%d %M %Y') AS tanggal, COUNT(DISTINCT id_member) AS jumlah_member FROM booking_gyms WHERE DATE_FORMAT(tanggal_booking, '%Y-%m') = '$currentMonth' AND status_hadir = 1 GROUP BY tanggal ORDER BY tanggal");
        return response()->json($laporan);
    });

    Route::get('laporankelas', 'Api\ReportController@index');

    Route::post('logout', 'Api\AuthController@logout');
});