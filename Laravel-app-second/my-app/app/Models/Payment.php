<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;



class Payment extends Model{
        use HasFactory, Notifiable;

    protected $fillable=[
        "user_id",
        "amount",
        "payment_method",
        "status",
        "transaction_id",
        "created_at",
        "updated_at"
    ];

    protected function casts(): array{
        return[
            "user_id" => "string",
            'amount' => 'decimal:2',
            'payment_method' => 'string',
            'status' => 'string',
            'transaction_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }

}