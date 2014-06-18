<?php
/**
 * File containing the PriceStorage Gateway
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 */

namespace Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\Price\PriceStorage;

use Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\LegacyKernelGateway;
use eZ\Publish\Core\FieldType\StorageGateway;
use eZ\Publish\SPI\Persistence\Content\Field;

abstract class Gateway extends StorageGateway
{
    abstract public function storePrice( Field $field, $contentTypeId );

    abstract public function getPrice( Field $field );

    abstract public function deletePrice( $fieldId );
}

