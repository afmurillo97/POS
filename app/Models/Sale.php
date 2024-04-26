<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'client_id',
        'voucher_type',
        'voucher_number',
        'date',
        'tax',
        'total',
        'status'
    ];

    protected $guarded = [
        
    ];
}
