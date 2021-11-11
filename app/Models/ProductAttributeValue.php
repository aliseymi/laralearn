<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductAttributeValue extends Pivot
{
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class,'attribute_id','id');
    }

    public function value()
    {
        return $this->belongsTo(AttributeValue::class,'value_id','id');
    }
}
