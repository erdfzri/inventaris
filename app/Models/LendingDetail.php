<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LendingDetail extends Model
{
    protected $fillable = ['lending_id', 'item_id', 'quantity', 'return_date'];

    protected $casts = [
        'return_date' => 'datetime',
    ];

    public function lending()
    {
        return $this->belongsTo(Lending::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
