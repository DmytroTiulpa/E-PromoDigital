<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    protected $hidden = array('pivot');

    public static function boot()
    {
        parent::boot();

        // Обработчик события удаления
        static::deleting(function($product) {
            // Удаляем связанные записи из таблицы product_user
            $product->users()->detach();
        });
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
