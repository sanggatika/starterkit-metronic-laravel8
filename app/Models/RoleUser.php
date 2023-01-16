<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_user';
    protected $primaryKey = 'id';
    protected $guarded = [];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
