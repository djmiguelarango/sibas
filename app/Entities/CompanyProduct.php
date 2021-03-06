<?php

namespace Sibas\Entities;

use Illuminate\Database\Eloquent\Model;

class CompanyProduct extends Model
{
    protected $table = 'ad_company_products';

    public function company()
    {
        return $this->belongsTo(Company::class, 'ad_company_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ad_product_id', 'id');
    }

}
