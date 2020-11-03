<?php

declare(strict_types=1);

namespace LongitudeOne\SettingsBundle\Twig;

use LongitudeOne\SettingsBundle\Exception\SettingsException;
use LongitudeOne\SettingsBundle\Service\SettingsService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
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
     * Declare settings as filter.
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            'settings' => new TwigFilter(
                'settings',
                [$this, 'getSettings'],
                []
            ),
        ];
    }

    /**
     * Declare settings as function.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            'settings' => new TwigFunction(
                'settings',
                [$this, 'getSettings'],
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
    public function getSettings(string $code)
    {
        return $this->settings->getValue($code);
    }
}