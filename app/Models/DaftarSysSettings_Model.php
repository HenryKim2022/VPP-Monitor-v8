<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DaftarSysSettings_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_sys_settings';
    protected $primaryKey = 'na_sett';
    protected $fillable = ['lbl_sett', 'tooltip_text_sett', 'val_sett', 'url_sett'];
    protected $dates = ['deleted_at'];
    public $incrementing = false;

}
