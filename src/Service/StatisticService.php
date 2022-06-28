<?php

namespace App\Service;

use App\Dto\StatisticDto;
use App\Exceptions\ClientOrientedException;
use App\Repository\ShortUrlRepository;

class StatisticService
{
    public function __construct(private ShortUrlRepository $shortUrlRepository)
    {
    }

    public function getStatistic(StatisticDto $statisticDto): int
    {
        if ($statisticDto->userEmail === null && $statisticDto->createdAt === null) {
            throw new ClientOrientedException('You must fill at least one field.');
        }

        return $this->shortUrlRepository->getStatistic($statisticDto);
    }
}