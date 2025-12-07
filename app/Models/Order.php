<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'server_id',
        'action',
        'uid',
        'account_name',
        'content',
        'note',
        'admin_note',
        'quantity',
        'ran',
        'price_per_unit',
        'total_price',
        'emotion',
        'speed',
        'started_at',
        'status',
        'admin_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'ran' => 'integer',
        'price_per_unit' => 'decimal:2',
        'total_price' => 'decimal:2',
        'started_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

