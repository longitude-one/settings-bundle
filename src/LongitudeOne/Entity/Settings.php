<?php

declare(strict_types=1);

namespace LongitudeOne\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings entity.
 *
 * Settings store serialized data.
 *
 * @ORM\Entity(repositoryClass="LongitudeOne\SettingsBundle\Repository\SettingsRepository")
 * @ORM\Table(
 *     name="lo_settings",
 *     options={"comment": "Application settings"},
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="uk_settings_code", columns={"code"})
 *     }
 * )
 */
class Settings
{
    /**
     * Code of setting.
     *
     * @ORM\Column(type="string", length=32)
     */
    private ?string $code = null;

    /**
     * Identifier.
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id")
     */
    private ?int $identifier = null;

    /**
     * The administrator can only edit which are updatable.
     *
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private bool $updatable = true;

    /**
     * Value.
     *
     * Value is store as a serialized data.
     *
     * @ORM\Column(type="text")
     *
     * @Gedmo\Versioned
     */
    private string $value;

    /**
     * Settings constructor.
     *
     * Value is set to null, then null is serialized
     */
    public function __construct()
    {
        $this->value = serialize(null);
    }

    /**
     * Code getter.
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Identifier getter.
     */
    public function getId(): ?int
    {
        return $this->identifier;
    }

    /**
     * Return the label of entity.
     */
    public function getLabel(): string
    {
        if (empty($this->code)) {
            return '';
        }

        return 'settings.'.(string) $this->code;
    }

    /**
     * Unserialized value.
     *
     * @return mixed|null
     */
    public function getValue()
    {
        return unserialize($this->value);
    }

    /**
     * Is this settings updatable?
     *
     * @return bool|null
     */
    public function isUpdatable(): bool
    {
        return $this->updatable;
    }

    /**
     * Code fluent setter.
     *
     * @param string $code code identifier
     *
     * @return Settings
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Updatable fluent setter.
     *
     * @param bool $updatable the new status of setting
     */
    public function setUpdatable(bool $updatable): self
    {
        $this->updatable = $updatable;

        return $this;
    }

    /**
     * Value setter.
     *
     * @param mixed $value unserialized value
     *
     * @return Settings
     */
    public function setValue($value): self
    {
        $this->value = serialize($value);

        return $this;
    }
}
