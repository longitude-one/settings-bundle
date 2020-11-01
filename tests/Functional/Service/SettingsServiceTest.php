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

namespace LongitudeOne\SettingsBundle\Tests\Functional\Service;

use LongitudeOne\SettingsBundle\Entity\Settings;
use LongitudeOne\SettingsBundle\Exception\SettingsException;
use LongitudeOne\SettingsBundle\Repository\SettingsRepository;
use LongitudeOne\SettingsBundle\Service\SettingsInterface;
use LongitudeOne\SettingsBundle\Service\SettingsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Settings repository test.
 *
 * @internal
 * @coversDefaultClass
 */
class SettingsServiceTest extends KernelTestCase
{
    /**
     * Settings repository.
     */
    private SettingsRepository $repository;

    /**
     * Settings manager.
     */
    private SettingsInterface $settingsService;
    private EntityManagerInterface $entityManager;

    /**
     * Setup the repository before each test.
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->repository = $this->entityManager->getRepository(Settings::class);
        $this->settingsService = new SettingsService($this->repository);
    }

    /**
     * Close entity manager to avoid memory leaks.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        unset($this->entityManager); // avoid memory leaks
    }

    /**
     * Test the getValue method.
     *
     * @throws SettingsException this should not happen
     */
    public function testGetValue(): void
    {
        $actual = 'bill-country';
        $expected = 'FRANCE';
        self::assertSame($expected, $this->settingsService->getValue($actual));
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
