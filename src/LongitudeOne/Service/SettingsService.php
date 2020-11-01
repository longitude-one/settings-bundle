<?php

declare(strict_types=1);

namespace LongitudeOne\SettingsBundle\Service;

use LongitudeOne\SettingsBundle\Entity\Settings;
use LongitudeOne\SettingsBundle\Exception\SettingsException;
use LongitudeOne\SettingsBundle\Repository\SettingsRepository;

/**
 * Settings service class.
 *
 * Read all table when necessary and provide data.
 */
class SettingsService implements SettingsInterface
{
    /**
     * Cached data.
     *
     * @var Settings[]
     */
    private static ?array $data = null;

    private SettingsRepository $repository;

    /**
     * SettingsService constructor.
     *
     * @param SettingsRepository     $repository    the settings repository
     */
    public function __construct(SettingsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get a setting or throw an exception.
     * This solution always executes a query to database, one query per call.
     * So, this method should not be used. You should use SettingsInterface::getValue
     *
     * @param string $code the code of setting
     *
     * @throws SettingsException when code does not exist
     */
    public function getSettings(string $code): Settings
    {
        /** @var ?Settings $settings */
        $settings = $this->repository->findOneByCode($code);

        if (!$settings instanceof Settings) {
            throw new SettingsException("{$code} is not a code set in settings repository.");
        }

        return $settings;
    }

    /**
     * Retrieve value for code provided.
     * This method we'll avoid to send query to database. Only one query is sent if needed to retrieve all settings and
     * and store them in memory.
     *
     * @param string $code settings code
     *
     * @throws SettingsException when settings code does not exists
     *
     * @return mixed|null
     */
    public function getValue(string $code)
    {
        if (null === self::$data) {
            $this->initialize();
        }

        if (array_key_exists($code, self::$data)) {
            return self::$data[$code]->getValue();
        }

        throw new SettingsException("{$code} is not a code set in settings repository.");
    }

    /**
     * Force manager to refresh data.
     */
    public function refresh(): void
    {
        self::$data = null;
    }

    /**
     * Initialize data.
     */
    private function initialize(): void
    {
        self::$data = [];
        $result = $this->repository->findAll();

        if (null !== $result) {
            foreach ($result as $settings) {
                /* @var Settings $setting the repository is returning an array of settings */
                self::$data[$setting->getCode()] = $settings;
            }
        }
    }
}
