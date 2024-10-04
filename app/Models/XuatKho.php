<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XuatKho extends Model
{
    use HasFactory;

    protected $table = 'phieu_xuat';

    protected $guarded = ['id'];

    public function getUsers()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
