<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoorAndSystemOpenDoor extends Model
{
    use HasFactory;
    public function openSystem()
    {
        return $this->hasOne(DoorOpenSystem::class, 'id', 'door_open_system_id');
    }
}
