<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "m_kecamatan";

    public function getProvinsiIdAttribute($value)
    {
        return encrypt_id($value);
    }
}
