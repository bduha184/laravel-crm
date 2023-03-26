<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable =[
        'customer_id',
        'status'
    ];

    public function customer():BelongsTo{
        return $this->belongsTo(Customer::class);
    }

    public function items():BelongsToMany{
        return $this->belongsToMany(Item::class)
        ->withPivot('quantity');
    }
}
