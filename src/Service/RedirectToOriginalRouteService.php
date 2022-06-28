<?php

namespace App\Service;

use App\Entity\ShortUrl;
use App\Repository\ShortUrlRepository;

class RedirectToOriginalRouteService
{
    public function __construct(private ShortUrlRepository $shortUrlRepository)
    {
    }

    public function getShortUrl(string $shortUrl): ?ShortUrl
    {
        return $this->shortUrlRepository->findOneBy(['token' => $shortUrl]);
    }
}