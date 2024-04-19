<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoorMaterial extends Model
{
    use SoftDeletes;
    use HasFactory;
    use SoftDeletes;
    public function doorColors()
    {
        return $this->hasMany(DoorColor::class);
    }

}
