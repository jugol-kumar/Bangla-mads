<?php

namespace App;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

//    public function product()
//    {
//        return $this->belongsTo(Product::class);
//    }
    public function product(){
        return $this->belongsTo(Medicine::class, 'product_id');
    }


    public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    }

    public function refund_request()
    {
        return $this->hasOne(RefundRequest::class);
    }

    public function affiliate_log()
    {
        return $this->hasMany(AffiliateLog::class);
    }
}
