<?php

namespace App\Models;

use App\Http\Requests\ReserveRequest;
use App\Http\Resources\SeatCollection;
use Illuminate\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'trip_id', 'is_reserved', 'seat_number'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
