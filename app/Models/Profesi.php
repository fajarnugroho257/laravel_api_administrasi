<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Penduduk;

class Profesi extends Model
{
    use HasFactory;
    protected $primaryKey = "profesi_id";
    protected $fillable = [
        'profesi_nama'
    ];

    public function penduduk(): hasMany
{
    return $this->hasMany(Penduduk::class, 'profesi_id');
}
}
