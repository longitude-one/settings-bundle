<?php

declare(strict_types=1);

namespace LongitudeOne\SettingsBundle\Tests\Unit\Twig;

use LongitudeOne\SettingsBundle\Service\SettingsService;
use LongitudeOne\SettingsBundle\Twig\SettingsExtension;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Twig\TwigFilter;
use Twig\TwigFunction;

class SettingsExtensionTest extends TestCase
{
    /**
     * @var SettingsService|MockObject
     */
    private MockObject $settingsService;

    private SettingsExtension $settingsExtension;

    protected function setUp(): void
    {
        $this->settingsService = self::createMock(SettingsService::class);
        $this->settingsExtension = new SettingsExtension($this->settingsService);
    }

    public function testGetFilters()
    {
        $filters = $this->settingsExtension->getFilters();
        self::assertIsArray($filters);
        self::assertCount(1, $filters);
        self::assertInstanceOf(TwigFilter::class, array_pop($filters));
    }

    public function testGetFunctions()
    {
        $functions = $this->settingsExtension->getFunctions();
        self::assertIsArray($functions);
        self::assertCount(1, $functions);
        self::assertInstanceOf(TwigFunction::class, array_pop($functions));
    }

    public function testGetName()
    {
        self::assertSame('longitude-one_settings_extension', $this->settingsExtension->getName());
    }

    public function testSettingsFilter()
    {
        $this->settingsService->method('getValue')->willReturn('foo');
        self::assertSame('foo', $this->settingsExtension->getSettings('bar'));
    }
}
