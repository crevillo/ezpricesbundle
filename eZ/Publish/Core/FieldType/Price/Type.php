<?php

namespace Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\Price;

use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\SPI\Persistence\Content\FieldValue;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
use eZ\Publish\Core\FieldType\Value as BaseValue;

class Type extends FieldType
{
    /**
     * Validates the validatorConfiguration of a FieldDefinitionCreateStruct or FieldDefinitionUpdateStruct
     *
     * @param mixed $validatorConfiguration
     *
     * @return \eZ\Publish\SPI\FieldType\ValidationError[]
     */
    public function validateValidatorConfiguration( $validatorConfiguration )
    {
    }

    /**
     * Returns the field type identifier for this field type
     *
     * @return string
     */
    public function getFieldTypeIdentifier()
    {
        return 'ezprice';
    }

    /**
     * Returns the name of the given field value.
     *
     * It will be used to generate content name and url alias if current field is designated
     * to be used in the content name/urlAlias pattern.
     *
     * @param \eZ\Publish\SPI\FieldType\Value $value
     *
     * @return string
     */
    public function getName( SPIValue $value )
    {
        return (string)$value->price;
    }

    /**
     * Returns the fallback default value of field type when no such default
     * value is provided in the field definition in content types.
     *
     * @return \eZ\Publish\Core\FieldType\Float\Value
     */
    public function getEmptyValue()
    {
        return new Value;
    }

    /**
     * Implements the core of {@see isEmptyValue()}.
     *
     * @param mixed $value
     *
     * @return boolean
     */
    public function isEmptyValue( SPIValue $value )
    {
        return $value->price === null;
    }

    /**
     * Inspects given $inputValue and potentially converts it into a dedicated value object.
     *
     * @param int|float|\eZ\Publish\Core\FieldType\Float\Value $inputValue
     *
     * @return \eZ\Publish\Core\FieldType\Float\Value The potentially converted and structurally plausible value.
     * @todo define all the ways a price could be entered
     *
     */
    protected function createValueFromInput( $inputValue )
    {
    }

    /**
     * Throws an exception if value structure is not of expected format.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException If the value does not match the expected structure.
     *
     * @param \eZ\Publish\Core\FieldType\Float\Value $value
     *
     * @return void
     */
    protected function checkValueStructure( BaseValue $value )
    {
    }

    /**
     * Returns information for FieldValue->$sortKey relevant to the field type.
     *
     * @param \eZ\Publish\Core\FieldType\Float\Value $value
     *
     * @return array
     */
    protected function getSortInfo( BaseValue $value )
    {
        $intPrice = (int)($value->price * 100.00);
        return $intPrice;
    }

    /**
     * Converts an $hash to the Value defined by the field type
     *
     * @param mixed $hash
     *
     * @return \eZ\Publish\Core\FieldType\Float\Value $value
     */
    public function fromHash( $hash )
    {
    }

    /**
     * Converts a $Value to a hash
     *
     * @param \eZ\Publish\Core\FieldType\Float\Value $value
     *
     * @return mixed
     */
    public function toHash( SPIValue $value )
    {
    }

    /**
     * Returns whether the field type is searchable
     *
     * @return boolean
     */
    public function isSearchable()
    {
        return true;
    }

    /**
     * Converts a persistence $fieldValue to a Value
     *
     * This method builds a field type value from the $data and $externalData properties.
     *
     * @param \eZ\Publish\SPI\Persistence\Content\FieldValue $fieldValue
     *
     * @return \eZ\Publish\Core\FieldType\BinaryBase\Value
     */
    public function fromPersistenceValue( FieldValue $fieldValue )
    {
        if( !is_null( $fieldValue->externalData ) )
            return new Value( $fieldValue->externalData );
    }
}