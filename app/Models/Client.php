<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'client_type',
        'id_type',
        'id_number',
        'address',
        'phone',
        'email',
        'status'
    ];

    protected $guarded = [
        
    ];
}
