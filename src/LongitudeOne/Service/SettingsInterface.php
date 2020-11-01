<?php

namespace LongitudeOne\SettingsBundle\Service;

use LongitudeOne\SettingsBundle\Entity\Settings;
use LongitudeOne\SettingsBundle\Exception\SettingsException;

interface SettingsInterface
{
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
    public function getValue(string $code);

    /**
     * Get a setting or throw an exception.
     * This solution always executes a query to database, one query per call.
     * So, this method should not be used. You should use SettingsInterface::getValue
     *
     * @param string $code the code of setting
     *
     * @throws SettingsException when code does not exist
     */
    public function getSettings(string $code): Settings;

    /**
     * Force manager to refresh data.
     */
    public function refresh(): void;
}