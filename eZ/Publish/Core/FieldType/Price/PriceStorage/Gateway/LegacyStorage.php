<?php

namespace Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\Price\PriceStorage\Gateway;

use Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\Price\PriceStorage\Gateway;
use eZ\Publish\SPI\Persistence\Content\Field;

class LegacyStorage extends Gateway
{
    /**
     * Connection
     *
     * @var mixed
     */
    protected $dbHandler;

    /**
     * Set database handler for this gateway
     *
     * @param mixed $dbHandler
     *
     * @return void
     * @throws \RuntimeException if $dbHandler is not an instance of
     *         {@link \eZ\Publish\Core\Persistence\Database\DatabaseHandler}
     */
    public function setConnection( $dbHandler )
    {
        // This obviously violates the Liskov substitution Principle, but with
        // the given class design there is no sane other option. Actually the
        // dbHandler *should* be passed to the constructor, and there should
        // not be the need to post-inject it.
        if ( ! ( $dbHandler instanceof DatabaseHandler ) )
        {
            throw new \RuntimeException( "Invalid dbHandler passed" );
        }

        $this->dbHandler = $dbHandler;
    }

    /**
     * Sets the price data into $field->value->externalData
     *
     * @param Field $field
     *
     * @return void
     */
    public function getFieldData( Field $field )
    {
    }

    public function deleteFieldData( $versionNo, $fieldId )
    {
    }

    /**
     * @see \eZ\Publish\Core\FieldType\Url\UrlStorage\Gateway
     */
    public function storeFieldData( VersionInfo $versionInfo, Field $field )
    {
        // Signals that the Value has been modified and that an update is to be performed
        return true;
    }
}
