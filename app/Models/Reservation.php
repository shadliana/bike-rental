<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable =
        [
            'user_id',
            'bike_id',
            'start_date',
            'end_date'
        ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id');
    }

    public function bike()
    {
        return $this->belongsTo(
            Bike::class,
            'bike_id'
        );
    }
}
