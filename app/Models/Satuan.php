<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    /** @use HasFactory<\Database\Factories\SatuanFactory> */
    use HasFactory;

    protected $table = 'satuan';
    protected $guarded = ['id'];

    // Relasi ke bahan sebagai satuan besar
    public function besar()
    {
        return $this->hasMany(Bahan::class, 'besar_id');
    }

    // Relasi ke bahan sebagai satuan kecil
    public function kecil()
    {
        return $this->hasMany(Bahan::class, 'kecil_id');
    }
}
