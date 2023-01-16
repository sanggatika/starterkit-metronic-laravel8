<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Desa extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "m_desa";

    public function getProvinsiIdAttribute($value)
    {
        return encrypt_id($value);
    }

    public function msKecamatan()
    {
        return $this->hasOne(Kecamatan::class, 'kode', 'kode_kecamatan');
    }
}
