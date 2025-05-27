<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Get the income details for the income.
     */
    public function incomeDetails(): HasMany
    {
        return $this->hasMany(IncomeDetail::class);
    }
}
