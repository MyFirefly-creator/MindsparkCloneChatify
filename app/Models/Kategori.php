<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['NamaKategori', 'UserID'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'kategori_bukus', 'KategoriID', 'BukuID');
    }
}
