<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    /** @use HasFactory<\Database\Factories\BahanFactory> */
    use HasFactory;

    protected $table = 'bahans';
    protected $guarded = ['id'];

    // Relasi ke satuan besar
    public function satuanBesar()
    {
        return $this->belongsTo(Satuan::class, 'besar_id');
    }

    // Relasi ke satuan kecil
    public function satuanKecil()
    {
        return $this->belongsTo(Satuan::class, 'kecil_id');
    }
}
