<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'total_stock', 'repair_stock'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lendingDetails()
    {
        return $this->hasMany(LendingDetail::class);
    }

    public function getLendingTotalAttribute()
    {
        return $this->lendingDetails()
            ->whereNull('return_date')
            ->sum('quantity');
    }

    public function getAvailableStockAttribute()
    {
        return $this->total_stock - $this->lending_total - $this->repair_stock;
    }
}
