<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'stock',
        'description',
        'image',
        'status'
    ];

    protected $guarded = [
        
    ];

    /**
     * Get the category for the product.
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }
}