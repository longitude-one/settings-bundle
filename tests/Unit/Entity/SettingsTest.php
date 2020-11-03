<?php

declare(strict_types=1);

namespace LongitudeOne\SettingsBundle\Tests\Entity;

use LongitudeOne\SettingsBundle\Entity\Settings;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * Status order resource unit test.
 *
 * @internal
 * @coversDefaultClass
 */
class SettingsTest extends TestCase
{
    /**
     * Status order to test.
     *
     * @var Settings
     */
    protected $settings;

    /**
     * Before each test, user is created.
     */
    protected function setUp(): void
    {
        $this->settings = new Settings();
        parent::setUp();
    }

    /**
     * After each test, user is dropped.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->settings = null;
    }

    /**
     * Test Code setter and getter.
     */
    public function testCode(): void
    {
        $actual = $expected = 'code';

        self::assertSame($this->settings, $this->settings->setCode($actual));
        self::assertSame($expected, $this->settings->getCode());
        self::assertSame('settings.code', $this->settings->getLabel());
    }

    /**
     * Test the constructor.
     */
    public function testConstructor(): void
    {
        self::assertNull($this->settings->getCode());
        self::assertNull($this->settings->getId());
        self::assertNull($this->settings->getValue());
        self::assertNotNull($this->settings->getLabel());
        self::assertEmpty($this->settings->getLabel());
        self::assertNotNull($this->settings->isUpdatable());
        self::assertTrue($this->settings->isUpdatable());
    }

    /**
     * Test updatable getter and setter.
     */
    public function testUpdatable(): void
    {
        self::assertSame($this->settings, $this->settings->setUpdatable(false));
        self::assertFalse($this->settings->isUpdatable());
        self::assertSame($this->settings, $this->settings->setUpdatable(true));
        self::assertTrue($this->settings->isUpdatable());
    }

    /**
     * Test Value setter and getter.
     */
    public function testValue(): void
    {
        //Test with a date
        $expected = $actual = new DateTimeImmutable();
        self::assertSame($this->settings, $this->settings->setValue($actual));
        //Assert Equals because this is not the same object
        self::assertEquals($expected, $this->settings->getValue());
        self::assertInstanceOf(DateTimeImmutable::class, $this->settings->getValue());

        //Test with an integer
        $expected = $actual = 42;
        self::assertSame($this->settings, $this->settings->setValue($actual));
        self::assertSame($expected, $this->settings->getValue());
        self::assertIsInt($this->settings->getValue());

        //Test with with a string
        $expected = $actual = '42';
        self::assertSame($this->settings, $this->settings->setValue($actual));
        self::assertSame($expected, $this->settings->getValue());
        self::assertIsString($this->settings->getValue());

        //Test with with an array
        $expected = $actual = ['foo' => 'bar', 0 => 42];
        self::assertSame($this->settings, $this->settings->setValue($actual));
        self::assertSame($expected, $this->settings->getValue());
        self::assertIsArray($this->settings->getValue());

        //Test with with an object
        $expected = $actual = new Settings();
        self::assertSame($this->settings, $this->settings->setValue($actual));
        //This is not the same object
        self::assertEquals($expected, $this->settings->getValue());
        self::assertIsObject($this->settings->getValue());
        self::assertInstanceOf(Settings::class, $this->settings->getValue());
    }
}
