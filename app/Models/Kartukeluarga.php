<?php

namespace App\Models;

use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Kartukeluarga extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_kk', 'nama_kk'
    ];

    public function Penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class);
    }
}
