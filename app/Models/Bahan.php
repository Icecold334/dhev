<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    /** @use HasFactory<\Database\Factories\BahanFactory> */
    use HasFactory;

    // protected $table = 'bahans';
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

    public function logStoks()
    {
        return $this->hasMany(LogStok::class);
    }

    public function getTotalStok()
    {
        $in = $this->logStoks()->where('jenis', 'IN')->sum('jumlah');
        $out = $this->logStoks()->where('jenis', 'OUT')->sum('jumlah');
        $totalKecil = max($in - $out, 0);

        // konversi ke satuan besar dengan 1 angka di belakang koma
        $jumlahBesar = round($totalKecil / $this->konversi, 1);

        return [
            'besar' => $jumlahBesar,
            'kecil' => $totalKecil,
        ];
    }
}
