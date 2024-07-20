<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Profesi;

class Penduduk extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik', 'no_kk', 'profesi_id', 'nama_lengkap', 'alamat', 'jk', 'tempat_lahir', 'tgl_lahir', 'agama', 'kewarganegaraan', 'status'
    ];

    public function profesi(): belongsTo
    {
        return $this->belongsTo(Profesi::class, 'profesi_id');
    }
}
