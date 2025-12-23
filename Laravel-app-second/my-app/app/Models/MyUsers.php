<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class MyUsers extends Model
{
    protected $table = 'my_users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'name',
        'email',    
        'password',
        "created_at",
        "updated_at"
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'name' => 'string',
            'email' => 'string',
            'password' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}