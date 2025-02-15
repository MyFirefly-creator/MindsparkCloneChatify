<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $fillable = ['UserID', 'BukuID', 'Ulasan', 'Rating'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID');
    }
}
