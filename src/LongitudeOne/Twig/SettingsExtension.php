<?php

declare(strict_types=1);

namespace LongitudeOne\SettingsBundle\Twig;

use LongitudeOne\SettingsBundle\Exception\SettingsException;
use LongitudeOne\SettingsBundle\Service\SettingsService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SettingsExtension extends AbstractExtension
{
    private SettingsService $settings;

    /**
     * SettingsExtension constructor.
     *
     * @param SettingsService $settings
     */
    public function __construct(SettingsService $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Declare setting as filter.
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            'settings' => new TwigFunction(
                'settings',
                [$this, 'settingsFilter'],
                []
            ),
        ];
    }

    /**
     * Return name of extension.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'longitude-one_settings_extension';
    }

    /**
     * Setting filter.
     *
     * @param mixed $code  the settings code
     *
     * @throws SettingsException if the settings code doesn't exist
     *
     * @return mixed
     */
    public function settingsFilter(string $code)
    {
        return $this->settings->getValue($code);
    }
}