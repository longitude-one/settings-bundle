<?php

declare(strict_types=1);

namespace LongitudeOne\SettingsBundle\Repository;

use LongitudeOne\SettingsBundle\Entity\Settings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Settings repository.
 *
 * @method Settings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Settings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Settings[]    findAll()
 * @method Settings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingsRepository extends ServiceEntityRepository
{
    /**
     * Settings repository constructor.
     *
     * @param ManagerRegistry $registry provided by dependency injection
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Settings::class);
    }

    /**
     * Find one settings by its code.
     *
     * @param string $code Code to find
     */
    public function findOneByCode(string $code): ?Settings
    {
        return $this->findOneBy(['code' => $code]);
    }
}
