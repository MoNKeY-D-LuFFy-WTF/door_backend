<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoorAndMaterialDoor extends Model
{
    use HasFactory;

    public function material()
    {
        return $this->hasOne(DoorMaterial::class, 'id', 'door_material_id');
    }
}
