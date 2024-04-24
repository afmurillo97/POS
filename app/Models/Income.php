<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $table = 'incomes';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'provider_id',
        'voucher_type',
        'voucher_number',
        'date',
        'tax',
        'status'
    ];

    protected $guarded = [
        
    ];
}
