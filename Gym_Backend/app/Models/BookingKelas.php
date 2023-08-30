<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class BookingKelas extends Model
{
    use HasFactory;

    protected $fillable=[
        'id_member',
        'id_instruktur',
        'id_kelas',
        'id_deposit_kelas',
        'jenis_kelas',
        'status_hadir',
        'no_booking',
        'tanggal_booking',
    ];

    public function getCreatedAtAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdateAtAttribute(){
        if(!is_null($this->attributes['update_at'])){
            return Carbon::parse($this->attributes['update_at'])->format('Y-m-d H:i:s');
        }
    }

    public function member()
    {
        return $this->belongsTo(members::class, 'id_member');
    }

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur');
    }

    public function deposit_kelas()
    {
        return $this->belongsTo(DepositKelas::class, 'id_deposit_kelas');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
