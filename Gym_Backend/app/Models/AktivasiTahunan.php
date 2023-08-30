<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AktivasiTahunan extends Model
{
    use HasFactory;

    protected $fillable=[
        'id_member',
        'id_kasir',
        'waktu',
        'biaya_aktivasi',
        'masa_aktif',
        'no_aktivasi'
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

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'id_kasir');
    }
}
