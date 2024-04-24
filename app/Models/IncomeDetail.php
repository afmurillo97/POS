<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeDetail extends Model
{
    use HasFactory;

    protected $table = 'income_detail';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'income_id',
        'product_id',
        'amount',
        'purchase_price',
        'sale_price'
    ];

    protected $guarded = [
        
    ];
}
