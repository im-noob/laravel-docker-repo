<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tables extends Model
{
    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class, 'table_id', 'id');
    }
}
