<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Razorpay\Api\Product;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'product_name', 'product_price', 'payment_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}