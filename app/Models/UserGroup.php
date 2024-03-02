<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserGroup extends Model
{
    use HasFactory;

    protected $connection = 'buloro_pay';
    public $incrementing = false;
    protected $fillable = [];

    protected $casts = [];
}
