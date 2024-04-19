<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Door extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function doorColor()
    {
        return $this->hasOne(DoorColor::class, 'id', 'door_color_id');
    }
    public function doorStatuse()
    {
        return $this->hasOne(DoorStatus::class, 'id', 'door_statuse_id');
    }


    public function doorMaterials()
    {
        return $this->hasMany(
            DoorAndMaterialDoor::class,
            'door_id',
            'id'
        );
    }

    public function doorOpenSystem()
    {
        return $this->hasMany(
            DoorAndSystemOpenDoor::class,
            'door_id',
            'id'
        );
    }
    public function doorThick()
    {
        return $this->hasMany(
            DoorAndDoorThick::class,
            'door_id',
            'id'
        );
    }
    public function DoorCatalogChild()
    {
        return $this->hasOne(
            CatalogChild::class,
            'id',
            'catalog_child_id'
        );
    }
    public function combo()
    {
        return $this->hasOne(DoorCombo::class);
    }
}
