<?php

namespace MakingWaves\eZAddThisBundle\eZ\Publish\FieldType\AddThis;

use eZ\Publish\Core\Base\Exceptions\InvalidArgumentValue;
use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\Core\FieldType\ValidationError;
use eZ\Publish\SPI\Persistence\Content\FieldValue as PersistenceValue;
use eZ\Publish\Core\FieldType\Value as CoreValue;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;

class Type extends FieldType
{
    public function getFieldTypeIdentifier()
    {
        return 'addthis';
    }

    public function getName( SPIValue $value )
    {
        return $value->__toString();
    }

    protected function getSortInfo( CoreValue $value )
    {
        return $this->getName( $value );
    }

    protected function checkValueStructure( CoreValue $value )
    {
    }

    public function validateValidatorConfiguration( $validatorConfiguration )
    {
        $validationErrors = array();

        foreach ( $validatorConfiguration as $validatorIdentifier => $constraints )
        {
            switch ( $validatorIdentifier )
            {
                default:
                    $validationErrors[] = new ValidationError( "Validator '$validatorIdentifier' is unknown" );
                    break;
            }
        }

        return $validationErrors;
    }

    public function validate( FieldDefinition $fieldDefinition, SPIValue $fieldValue )
    {
        $validationErrors = array();

        if ( $this->isEmptyValue( $fieldValue ) )
        {
            return $validationErrors;
        }

        return $validationErrors;
    }

    public function toPersistenceValue( SPIValue $value )
    {
        return new PersistenceValue(
            array(
                "data" => $value->__toString(),
                "externalData" => null,
                "sortKey" => null,
            )
        );
    }

    /* Standard implementation functions START... */

    protected function createValueFromInput( $inputValue )
    {
        $inputValue = new Value( $inputValue );

        return $inputValue;
    }

    public function getEmptyValue()
    {
        return new Value;
    }

    public function fromHash( $hash )
    {
        if ( $hash === null )
        {
            return $this->getEmptyValue();
        }
        return new Value( $hash );
    }

    public function toHash( SPIValue $value )
    {
        if ( $this->isEmptyValue( $value ) )
        {
            return null;
        }
        return $value->toHash();
    }

    public function fromPersistenceValue( PersistenceValue $fieldValue )
    {
        if ( $fieldValue->data === null )
        {
            return $this->getEmptyValue();
        }

        return new Value( $fieldValue->data );
    }

    /* Standard implementation functions END... */
}