<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoorAndDoorThick extends Model
{
    use HasFactory;
    public function thick()
    {
        return $this->hasOne(DoorThick::class, 'id', 'door_thick_id');
    }
}
