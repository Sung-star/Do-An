<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'proname',
        'price',
        'brandid',
        'cateid',
        'description',
        'fileName'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cateid', 'cateid')
            ->select(['cateid', 'catename']);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandid', 'id')
            ->select(['id', 'brandname']);
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}

public function averageRating()
{
    return $this->reviews()->avg('rating');
}
}
