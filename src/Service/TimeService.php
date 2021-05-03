<?php
declare(strict_types=1);

namespace App\Service;

use DateTime;
use DateTimeInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class TimeService
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getDate(): string
    {
        $dateString = $this->cache->get('cache_date', function(ItemInterface $item) {
            $item->expiresAfter(60);

            return (new DateTime())->format(DateTimeInterface::RFC3339);
        });

        return (string) $dateString;
    }
}
