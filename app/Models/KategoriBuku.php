<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    use HasFactory;

    protected $fillable = ['BukuID', 'KategoriID'];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'KategoriID');
    }
}
