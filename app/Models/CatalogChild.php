<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogChild extends Model
{
    use SoftDeletes;
    use HasFactory;
    public function getFurniture()
    {
        return $this->hasMany(Furniture::class);
    }
    public function catalog()
    {
        return $this->hasOne(Catalog::class, 'id', 'catalog_id');
    }
}
