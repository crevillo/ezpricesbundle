<?php
/**
 * File containing the PriceStorage Gateway
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 */

namespace Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\Price\PriceStorage;

use eZ\Publish\SPI\Persistence\Content\Field;
use eZ\Publish\Core\FieldType\StorageGateway;

abstract class Gateway extends StorageGateway
{
    /**
     * @see \eZ\Publish\SPI\FieldType\FieldStorage::storeFieldData()
     */
    abstract public function storeFieldData( Field $field, $contentTypeId );

    /**
     * Sets the list of assigned keywords into $field->value->externalData
     *
     * @param Field $field
     *
     * @return void
     */
    abstract public function getFieldData( Field $field );

    /**
     * Retrieve the ContentType ID for the given $field
     *
     * @param \eZ\Publish\SPI\Persistence\Content\Field $field
     *
     * @return mixed
     */
    abstract public function getContentTypeId( Field $field );

    /**
     * @see \eZ\Publish\SPI\FieldType\FieldStorage::deleteFieldData()
     */
    abstract public function deleteFieldData( $fieldId );
}

