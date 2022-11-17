<?php

namespace App\Models;

use App\Traits\ScopeFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory, ScopeFilter;

    protected $table = 'orders';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'city',
        'address',
        'info',
        'payment_method',
        'courier_service',
        'locale',
        'grand_total',
        'payment_type'
    ];

    public function getFilterScopes(): array
    {
        return [
            'id' => [
                'hasParam' => true,
                'scopeMethod' => 'id'
            ],
            'status' => [
                'hasParam' => true,
                'scopeMethod' => 'status'
            ],
            'price' => [
                'hasParam' => true,
                'scopeMethod' => 'price'
            ],
            'name' => [
                'hasParam' => true,
                'scopeMethod' => 'firstLastName'
            ],
            'email' => [
                'hasParam' => true,
                'scopeMethod' => 'email'
            ],
            'phone' => [
                'hasParam' => true,
                'scopeMethod' => 'phone'
            ],
        ];
    }


    public function items():HasMany{
        return $this->hasMany(OrderItem::class);
    }
}
