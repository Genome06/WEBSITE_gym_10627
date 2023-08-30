<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class IzinInstruktur extends Model
{
    use HasFactory;

    protected $fillable=[
        'id_instruktur',
        'alasan_izin',
        'status_izin',
        'tanggal_izin',
        'id_instruktur_pengganti',
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

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur');
    }

    public function instrukturPengganti()
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur_pengganti');
    }
}
