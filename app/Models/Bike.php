<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bike extends Model
{

    use HasFactory,
        SoftDeletes;

    protected $fillable = ['name', 'status'];

    public function reservations()
    {
        return $this->hasMany(
            Reservation::class,
            'bike_id');
    }
}
