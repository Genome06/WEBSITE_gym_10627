<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jadwal_Harian extends Model
{
    use HasFactory;

    protected $fillable=[
        'id_jadwal_umum',
        'id_instruktur',
        'tanggal',
        'status'
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

    public function jadwalUmum()
    { 
        return $this->belongsTo(Jadwal_Umum::class, 'id_jadwal_umum');
    
     }

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur');
    }

}
