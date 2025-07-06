<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    //
    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}
