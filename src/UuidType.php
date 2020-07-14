<?php

namespace AudithSoftworks\Uuid\Doctrine\ODM;

use AudithSoftworks\Uuid\Doctrine\ODM\Exception\ConversionException;
use Doctrine\ODM\MongoDB\Types\Type;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidType extends Type
{
    /**
     * The name of the doctrine type
     */
    public const NAME = 'ramsey_uuid';

    /**
     * Converts a value from its database representation to its PHP representation of this type.
     *
     * @param mixed $value The value to convert.
     *
     * @throws \AudithSoftworks\Uuid\Doctrine\ODM\Exception\ConversionException
     * @return Uuid
     */
    public function convertToPHPValue($value): ?UuidInterface
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof UuidInterface) {
            return $value;
        }

        try {
            $uuid = Uuid::fromString($value);
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }

        return $uuid;
    }

    /**
     * Converts a value from its PHP representation to its database representation of this type.
     *
     * @param mixed $value The value to convert.
     *
     * @throws \AudithSoftworks\Uuid\Doctrine\ODM\Exception\ConversionException
     * @return string
     */
    public function convertToDatabaseValue($value): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof UuidInterface || Uuid::isValid($value)) {
            return (string)$value;
        }

        throw ConversionException::conversionFailed($value, self::NAME);
    }

    public function closureToPHP(): string
    {
        return sprintf(
            'if (null === $value) {
                $uuid = null;
            } elseif ($value instanceof \Ramsey\Uuid\UuidInterface) {
                $uuid = $value;
            } else {
                try {
                    $uuid = \Ramsey\Uuid\Uuid::fromString($value);
                } catch (InvalidArgumentException $e) {
                    throw \AudithSoftworks\Uuid\Doctrine\ODM\Exception\ConversionException::conversionFailed($value, \'%s\');
                }
            }

            $return = $uuid;',
            self::NAME
        );
    }

    public function closureToMongo(): string
    {
        return sprintf(
            'if (null === $value) {
                $mongo = null;
            } elseif ($value instanceof \Ramsey\Uuid\UuidInterface || \Ramsey\Uuid\Uuid::isValid($value)) {
                $mongo = (string) $value;
            } else {
                throw \AudithSoftworks\Uuid\Doctrine\ODM\Exception\ConversionException::conversionFailed($value, \'%s\');
            }

            $return = $mongo;',
            self::NAME
        );
    }
}
