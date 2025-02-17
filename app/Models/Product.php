<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'type_of_banana_Chips',
        'file',
        'mobile_number',
        'date',
        'pincode',
        'price',
        'address'
    ];

    protected $primarykey = 'id';

    public function getFilesAttribute($file)
    {
        return asset("images/$file");
    }

    //  public function getPriceAttribute($file){
    // return "+91-".$file;
    // }

    public function getTypeOfBananaChipsAttribute($file)
    {
        return ucfirst("$file");
    }

    public function setTypeOfBananaChipsAttribute($file)
    {
        $this->attributes['type_of_banana_chips'] = ucwords($file);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_product');
    }
}