<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $table = 'sale_detail';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'sale_id',
        'product_id',
        'amount',
        'sale_price',
        'discount'
    ];

    protected $guarded = [
        
    ];
}
