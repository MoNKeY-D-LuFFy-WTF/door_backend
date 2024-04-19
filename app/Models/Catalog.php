<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalog extends Model
{
    use SoftDeletes;
    use HasFactory;
    public function catalog_child()
    {
        return $this->hasMany(CatalogChild::class);
    }
}
