<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nis', 'nama', 'email', 'alamat', 'password', 'role', 'avatar',
        'foto_ktp', 'foto_diri', 'status_verifikasi'
    ];

    public function favorits()
    {
        return $this->hasMany(Favorit::class, 'UserID');
    }

    public function ulasans()
    {
        return $this->hasMany(Ulasan::class, 'UserID');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'UserID');
    }

    public function warnings()
    {
        return $this->hasMany(Warning::class, 'UserID');
    }

}
