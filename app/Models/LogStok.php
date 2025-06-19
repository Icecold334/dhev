<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogStok extends Model
{
    /** @use HasFactory<\Database\Factories\LogStokFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }
}
