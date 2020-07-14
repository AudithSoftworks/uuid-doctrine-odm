<?php

namespace AudithSoftworks\Uuid\Doctrine\ODM\Test;

use Doctrine\ODM\MongoDB\Types\Type;
use AudithSoftworks\Uuid\Doctrine\ODM\Exception\ConversionException;
use AudithSoftworks\Uuid\Doctrine\ODM\UuidType;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidTypeTest extends TestCase
{
    private $type;

    public static function setUpBeforeClass(): void
    {
        Type::registerType('ramsey_uuid', UuidType::class);
    }

    protected function setUp(): void
    {
        $this->type = Type::getType('ramsey_uuid');
    }

    public function provideValidPHPToDatabaseValues(): array
    {
        $str = 'ff6f8cb0-c57d-11e1-9b21-0800200c9a66';
        $uuid = Uuid::fromString($str);

        return [
            [$uuid, $str],
            [$str, $str],
        ];
    }

    public function provideInvalidPHPToDatabaseValues(): array
    {
        $str = 'qwerty';
        $int = 1234567890;

        return [
            [$str],
            [$int],
        ];
    }

    public function testNullToDatabaseValue(): void
    {
        $actual = $this->type->convertToDatabaseValue(null);
        static::assertNull($actual);
    }

    /**
     * @dataProvider provideValidPHPToDatabaseValues
     *
     * @param mixed $input
     * @param mixed $output
     */
    public function testValidPHPToDatabaseValue($input, string $output): void
    {
        $actual = $this->type->convertToDatabaseValue($input);
        static::assertSame($output, $actual);
    }

    /**
     * @dataProvider provideInvalidPHPToDatabaseValues
     *
     * @param mixed $input
     */
    public function testInvalidPHPToDatabaseValue($input): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToDatabaseValue($input);
    }

    /**
     * @dataProvider provideValidPHPToDatabaseValues
     *
     * @param mixed $input
     * @param string $output
     */
    public function testValidClosureToDatabase($input, string $output): void
    {
        $return = null;

        call_user_func(function ($value) use (&$return) {
            eval($this->type->closureToMongo());
        }, $input);

        static::assertSame($output, $return);
    }

    /**
     * @dataProvider provideInvalidPHPToDatabaseValues
     *
     * @param mixed $input
     */
    public function testInvalidClosureToDatabase($input): void
    {
        $this->expectException(ConversionException::class);

        $return = null;

        call_user_func(function ($value) use (&$return) {
            eval($this->type->closureToMongo());
        }, $input);
    }

    public function provideValidDatabaseToPHPValues(): array
    {
        $str = 'ff6f8cb0-c57d-11e1-9b21-0800200c9a66';
        $uuid = Uuid::fromString($str);

        return [
            [$uuid, $str],
            [$str, $str],
        ];
    }

    public function provideInvalidDatabaseToPHPValues(): array
    {
        $str = 'qwerty';
        $int = 1234567890;

        return [
            [$str],
            [$int],
        ];
    }

    public function testNullToPHPValue(): void
    {
        $actual = $this->type->convertToPHPValue(null);
        static::assertNull($actual);
    }

    /**
     * @dataProvider provideValidDatabaseToPHPValues
     *
     * @param mixed $input
     * @param mixed $output
     */
    public function testValidDatabaseToPHPValue($input, $output): void
    {
        $actual = $this->type->convertToPHPValue($input);
        static::assertInstanceOf(UuidInterface::class, $actual);
        static::assertSame($output, $actual->toString());
    }

    /**
     * @dataProvider provideInvalidDatabaseToPHPValues
     *
     * @param mixed $input
     */
    public function testInvalidDatabaseToPHPValue($input): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToPHPValue($input);
    }

    /**
     * @dataProvider provideValidDatabaseToPHPValues
     *
     * @param mixed $input
     * @param mixed $output
     */
    public function testValidClosureToPHP($input, $output): void
    {
        call_user_func(function ($value) use (&$return) {
            eval($this->type->closureToPHP());
        }, $input);

        static::assertInstanceOf(UuidInterface::class, $return);
        static::assertEquals($output, $return->toString());
    }

    /**
     * @dataProvider provideInvalidDatabaseToPHPValues
     *
     * @param mixed $input
     */
    public function testInvalidClosureToPHP($input): void
    {
        $this->expectException(ConversionException::class);

        call_user_func(function ($value) use (&$return) {
            eval($this->type->closureToPHP());
        }, $input);
    }
}
