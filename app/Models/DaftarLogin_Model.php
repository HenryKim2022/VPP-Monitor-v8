<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;


class DaftarLogin_Model extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_daftar_login';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'username',
        'email',
        'password',
        'type',
        'id_karyawan',
        'id_client',
        'remember_token'
    ];
    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'password' => 'hashed',
        'type' => 'integer', // Cast the 'type' attribute to integer
    ];


    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value) => ['Public', 'Client', 'Superuser', 'Supervisor', 'Engineer'][$value],
        );
    }

    public function convertUserTypeBack($type2Convert)
    {
        $typeValueList = ['Public', 'Client', 'Superuser', 'Supervisor', 'Engineer'];
        $typeIndex = array_search($type2Convert, $typeValueList);
        $convertedUserType = $typeIndex !== false ? $typeIndex : null;
        return $convertedUserType;
    }


    // public function getImageAttribute($value)
    // {
    //     // Check if the user type is one of the specified types
    //     if ($this->type() == 'Superuser' || $this->type() == 'Supervisor' || $this->type() == 'Engineer') {
    //         return $value ?: $this->karyawan->foto_karyawan ?: 'public/assets/defaults/avatar_default.png';
    //     } else {
    //         return $value ?: $this->client->foto_client ?: 'public/assets/defaults/avatar_default.png';
    //     }
    // }


    public function getImageAttribute($value)
    {
        // Check if the user type is one of the specified types
        if ($this->type() == 'Superuser' || $this->type() == 'Supervisor' || $this->type() == 'Engineer') {
            // For Karyawan
            return $value ?: ($this->karyawan ? $this->karyawan->foto_karyawan : 'public/assets/defaults/avatar_default.png');
        } else {
            // For Client
            return $value ?: ($this->client ? $this->client->foto_client : 'public/assets/defaults/avatar_default.png');
        }
    }



    public function setRememberToken($token)
    {
        $this->remember_token = $token;
        $this->remember_token_expires_at = now()->addDays(8); // Set expiration to 8 days from now
        $this->save();
    }

    public function isRememberTokenExpired()
    {
        return $this->remember_token_expires_at && now()->greaterThan($this->remember_token_expires_at);
    }


    public function karyawan()
    {
        return $this->belongsTo(Karyawan_Model::class, 'id_karyawan');
    }

    public function client()
    {
        return $this->belongsTo(Kustomer_Model::class, 'id_client');
    }
}
