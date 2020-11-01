<?php
/**
 * This file is part of the O2 Application.
 *
 * PHP version 7.1|7.2|7.3|7.4
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Alexandre Tranchant
 * @license   Cecill-B http://www.cecill.info/licences/Licence_CeCILL-B_V1-fr.txt
 */

declare(strict_types=1);

namespace LongitudeOne\SettingsBundle\Tests\Unit\Service;

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
class SettingsManagerTest extends TestCase
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
