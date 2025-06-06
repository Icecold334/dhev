<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function listMenus()
    {
        return $this->hasMany(ListMenu::class);
    }

    public function bahans()
    {
        return $this->hasManyThrough(Bahan::class, ListMenu::class, 'menu_id', 'id', 'id', 'bahan_id');
    }
}
