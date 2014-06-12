<?php

namespace Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\Price;

use eZ\Publish\Core\FieldType\Value as BaseValue;

class Value extends BaseValue
{
    public $vat_type;

    public $current_user;

    public $currency;

    public $is_vat_included;

    public $selected_vat_type;

    public $vat_percent;

    public $inc_vat_price;

    public $ex_vat_price;

    public $discount_percent;

    public $discount_price_inc_vat;

    public $discount_price_ex_vat;

    public $has_discount;

    public $price;

    public function __toString()
    {
        return (string)$this->price;
    }
}