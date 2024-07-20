<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelahiran extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik', 'nik_ibu', 'nik_ayah', 'alamat_kelahiran', 'tgl_lahir', 'anak_ke'
    ];
}
