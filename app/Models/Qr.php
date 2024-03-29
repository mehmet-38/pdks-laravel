<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qr extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'QRdata',
        'fk_parkID',
        'fk_user_id'
    ];
}
