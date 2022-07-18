<?php

namespace App\Models;
use App\Models\Comments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'image_Path',
        'expiration_Date',
        'firstDiscountDate',
        'firstDiscount',
        'secondDiscountDate',
        'secondDiscount',
        'thirdDiscountDate',
        'thirdDiscount',
        'description',
        'contact_Information',
        'Quantity',
        'Price',
        'user_id',
        'category_id', 
        'views',
     
    ];

    public function comments(){
        return $this->hasMany(Comments::class);
    }

}
