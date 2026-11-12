<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = [
        'new'       => 'Новый',
        'paid'      => 'Оплачен',
        'shipped'   => 'Отправлен',
        'done'      => 'Выполнен',
        'cancelled' => 'Отменён',
    ];

    protected $fillable = [
        'customer_name', 'email', 'phone', 'address', 'comment', 'total', 'status',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
