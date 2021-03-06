<?php

declare(strict_types=1);

namespace LongitudeOne\SettingsBundle\Tests\Unit\Service;

use LongitudeOne\SettingsBundle\Entity\Settings;
use LongitudeOne\SettingsBundle\Exception\SettingsException;
use LongitudeOne\SettingsBundle\Service\SettingsInterface;
use LongitudeOne\SettingsBundle\Repository\SettingsRepository;
use LongitudeOne\SettingsBundle\Service\SettingsService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Settings repository test.
 *
 * @internal
 * @coversDefaultClass
 */
class SettingsServiceTest extends TestCase
{
    /**
     * Settings manager.
     */
    private SettingsInterface $settingsService;

    /**
     * @var SettingsRepository|MockObject
     */
    private MockObject $mockedRepository;

    /**
     * Setup the repository before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockedRepository = self::createMock(SettingsRepository::class);
        $this->settingsService = new SettingsService($this->mockedRepository);
    }

    /**
     * Close entity manager to avoid memory leaks.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test the getValue method.
     *
     * @throws SettingsException this should not happen
     */
    public function testGetValue(): void
    {
        $code = 'code';
        $actual = $expected = 'foo';
        $settings = new Settings();
        $settings->setValue($actual);
        $settings->setCode($code);

        $this->mockedRepository->method('findAll')->willReturn([$settings]);
        self::assertSame($expected, $this->settingsService->getValue($code));
    }

    /**
     * Test the getValue method.
     *
     * @throws SettingsException this should not happen
     */
    public function testGetSettings(): void
    {
        $code = 'code';
        $actual = 'foo';
        $settings = new Settings();
        $settings->setValue($actual);
        $settings->setCode($code);

        $this->mockedRepository->method('findOneByCode')->willReturn($settings);
        self::assertEquals($settings, $this->settingsService->getSettings($code));
    }

    /**
     * Test the GetValue method with a non-existent code.
     *
     * @throws SettingsException this one should happen
     */
    public function testGetValueWithNonExistentCode(): void
    {
        $actual = 'foo';
        $expected = 'foo is not a code set in settings repository.';

        self::expectExceptionMessage($expected);
        $this->settingsService->getValue($actual);
    }
}
