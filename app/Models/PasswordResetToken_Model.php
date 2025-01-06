<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;


class PasswordResetToken_Model extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_password_reset_tokens'; // Define the table name
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'token',
    ];

    // Define the relationship with the user
    public function user()
    {
        return $this->belongsTo(DaftarLogin_Model::class, 'user_id');
    }
}
