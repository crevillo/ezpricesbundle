<?php

namespace Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\Price\PriceStorage\Gateway;

use Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\Price\PriceStorage\Gateway;
use eZ\Publish\SPI\Persistence\Content\Field;
use \eZContentObjectAttribute;
use Closure;

class LegacyKernel extends Gateway
{

    /**
     * @var \Closure
     */
    private $kernelClosure;

    public function setLegacyKernel( $legacyKernelClosure )
    {
        $this->kernelClosure = $legacyKernelClosure;
    }

    protected function getLegacyKernel()
    {
        $kernelClosure = $this->kernelClosure;
        return $kernelClosure();
    }

    /**
     * Stores the price from $field->value->externalData
     *
     * @param \eZ\Publish\SPI\Persistence\Content\Field
     * @param mixed $contentTypeId
     */
    public function storePrice( Field $field, $contentTypeId )
    {

    }

    /**
     * Sets the list of assigned keywords into $field->value->externalData
     *
     * @param Field $field
     *
     * @return void
     */
    public function getPrice( Field $field )
    {
        $field->value->externalData = $this->getSimplePrice( $field );
    }

    /**
     * Stores the keyword list from $field->value->externalData
     *
     * @param mixed $fieldId
     */
    public function deletePrice( $fieldId )
    {
    }

    private function getSimplePrice( Field $field )
    {
        return $this->getLegacyKernel()->runCallback(
            function () use ( $field )
            {
                $contentObjectAttribute = eZContentObjectAttribute::fetch( $field->id, $field->versionNo );
                $price = $contentObjectAttribute->content();

                $priceData = array();
                foreach ( $price->attributes() as $attribute )
                {
                    $priceData[$attribute] = $price->attribute( $attribute );
                }

                return $priceData;
            }
        );
    }
}
