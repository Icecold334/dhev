<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListMenu extends Model
{
    /** @use HasFactory<\Database\Factories\ListMenuFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
