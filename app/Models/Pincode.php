<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    use HasFactory;
    protected $table = 'mst_pincode';
    protected $primaryKey = 'pincode_id';

    protected $fillable = [
        'pincode_value',
        'state_id'
    ];
}
