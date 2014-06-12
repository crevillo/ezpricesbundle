<?php

namespace Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\Price\PriceStorage\Gateway;

use Crevillo\EzPricesBundle\eZ\Publish\Core\FieldType\Price\PriceStorage\Gateway;
use eZ\Publish\SPI\Persistence\Content\Field;
use eZ\Publish\Core\Persistence\Database\DatabaseHandler;
use \eZContentObjectAttribute;
use \eZPrice;
use Closure;

class LegacyStorage extends Gateway
{
    /**
     * Connection
     *
     * @var mixed
     */
    protected $dbHandler;

    /**
     * @var \Closure
     */
    private $kernelClosure;

    public function __construct( Closure $legacyKernelClosure )
    {
        $this->kernelClosure = $legacyKernelClosure;
    }

    protected function getLegacyKernel()
    {
        $kernelClosure = $this->kernelClosure;
        return $kernelClosure();
    }
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
        if ( !$dbHandler instanceof DatabaseHandler )
        {
            throw new \RuntimeException( "Invalid dbHandler passed" );
        }

        $this->dbHandler = $dbHandler;
    }

    /**
     * Returns the active connection
     *
     * @throws \RuntimeException if no connection has been set, yet.
     *
     * @return \eZ\Publish\Core\Persistence\Database\DatabaseHandler
     */
    protected function getConnection()
    {
        if ( $this->dbHandler === null )
        {
            throw new \RuntimeException( "Missing database connection." );
        }
        return $this->dbHandler;
    }

    /**
     * Stores the keyword list from $field->value->externalData
     *
     * @param \eZ\Publish\SPI\Persistence\Content\Field
     * @param mixed $contentTypeId
     */
    public function storeFieldData( Field $field, $contentTypeId )
    {

    }

    /**
     * Sets the list of assigned keywords into $field->value->externalData
     *
     * @param Field $field
     *
     * @return void
     */
    public function getFieldData( Field $field )
    {
        $field->value->externalData = $this->getSimplePrice( $field );
    }

    /**
     * Retrieve the ContentType ID for the given $field
     *
     * @param \eZ\Publish\SPI\Persistence\Content\Field $field
     *
     * @return mixed
     */
    public function getContentTypeId( Field $field )
    {
        return $this->loadContentTypeId( $field->fieldDefinitionId );
    }

    /**
     * Stores the keyword list from $field->value->externalData
     *
     * @param mixed $fieldId
     */
    public function deleteFieldData( $fieldId )
    {
    }



    /**
     * Retrieves the content type ID for the given $fieldDefinitionId
     *
     * @param mixed $fieldDefinitionId
     *
     * @return mixed
     */
    protected function loadContentTypeId( $fieldDefinitionId )
    {
        $dbHandler = $this->getConnection();

        $query = $dbHandler->createSelectQuery();
        $query->select( 'contentclass_id' )
            ->from( $dbHandler->quoteTable( 'ezcontentclass_attribute' ) )
            ->where(
                $query->expr->eq( 'id', $fieldDefinitionId )
            );

        $statement = $query->prepare();
        $statement->execute();

        $row = $statement->fetch( \PDO::FETCH_ASSOC );

        if ( $row === false )
            throw new \RuntimeException(
                sprintf(
                    'Content Type ID cannot be retrieved based on the field definition ID "%s"',
                    $fieldDefinitionId
                )
            );

        return $row['contentclass_id'];
    }

    private function getSimplePrice( Field $field )
    {
        return $this->getLegacyKernel()->runCallback(
            function () use ( $field )
            {
                $contentObjectAttribute = eZContentObjectAttribute::fetch( $field->id, $field->versionNo );
                $classAttribute = $contentObjectAttribute->contentClassAttribute();
                $storedPrice = $contentObjectAttribute->attribute( "data_float" );
                $price = new eZPrice( $classAttribute, $contentObjectAttribute, $storedPrice );

                if ( $contentObjectAttribute->attribute( 'data_text' ) != '' )
                {
                    list( $vatType, $vatExInc ) = explode( ',', $contentObjectAttribute->attribute( "data_text" ), 2 );

                    $price->setAttribute( 'selected_vat_type', $vatType );
                    $price->setAttribute( 'is_vat_included', $vatExInc );
                }

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
