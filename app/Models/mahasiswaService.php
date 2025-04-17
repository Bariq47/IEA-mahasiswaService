<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswaService extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa_service';
    protected $fillable = [
        'nim',
        'nama',
        'umur',
        'email',
        'alamat',
        'nomor',

    ];
}
