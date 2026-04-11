<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    protected $fillable = ['staff_id', 'borrower_name', 'notes'];

    protected $casts = [
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function details()
    {
        return $this->hasMany(LendingDetail::class);
    }
}
