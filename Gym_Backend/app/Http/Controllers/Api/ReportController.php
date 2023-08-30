<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\returnSelf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;

        $reportData = DB::table('booking_kelas')
            ->join('kelas', 'booking_kelas.id_kelas', '=', 'kelas.id')
            ->join('members', 'booking_kelas.id_member', '=', 'members.id')
            ->join('instrukturs', 'booking_kelas.id_instruktur', '=', 'instrukturs.id')
            ->select('kelas.nama_kelas as nama_kelas', 'instrukturs.nama as nama_instruktur')
            ->selectRaw('COUNT(booking_kelas.id_member) as jumlah_member')
            ->whereMonth('booking_kelas.tanggal_booking', $currentMonth)
            ->where('booking_kelas.status_hadir', 1)
            ->groupBy('nama_kelas', 'nama_instruktur')
            ->get();
    
        return response()->json($reportData);
    }

    public function indexInstruktur()
    {
        $currentMonth = Carbon::now()->month;

        $reportData = DB::table('booking_kelas')
            ->join('kelas', 'booking_kelas.id_kelas', '=', 'kelas.id')
            ->join('members', 'booking_kelas.id_member', '=', 'members.id')
            ->join('instrukturs', 'booking_kelas.id_instruktur', '=', 'instrukturs.id')
            ->select('kelas.nama_kelas as nama_kelas', 'instrukturs.nama as nama_instruktur')
            ->selectRaw('COUNT(booking_kelas.id_member) as jumlah_member')
            ->whereMonth('booking_kelas.tanggal_booking', $currentMonth)
            ->where('booking_kelas.status_hadir', 1)
            ->groupBy('nama_kelas', 'nama_instruktur')
            ->get();
    
        return response()->json($reportData);
    }
}