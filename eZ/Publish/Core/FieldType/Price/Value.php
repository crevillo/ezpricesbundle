<?php

namespace Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\Price;

use eZ\Publish\Core\FieldType\Value as BaseValue;

class Value extends BaseValue
{
    /**
     * @todo define what will this be. (int?, Value?...)
     */
    public $vat_type;

    /**
     * @todo is this really needed?
     * @var
     */
    public $current_user;

    /**
     * @todo define how we handle this
     * @var
     */
    public $currency;

    /**
     * @var bool
     */
    public $is_vat_included;

    /**
     * @todo define what will this be. (int?, Value?...)
     */
    public $selected_vat_type;

    /**
     * @var float
     */
    public $vat_percent;

    /**
     * @var float
     */
    public $inc_vat_price;

    /**
     * @var float
     */
    public $ex_vat_price;

    /**
     * @var float
     */
    public $discount_percent;

    /**
     * @var float
     */
    public $discount_price_inc_vat;

    /**
     * @var float
     */
    public $discount_price_ex_vat;

    /**
     * @var boolean
     */
    public $has_discount;

    /**
     * @var float
     */
    public $price;

    public function __toString()
    {
        return (string)$this->price;
    }
}