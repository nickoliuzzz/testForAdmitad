<?php

namespace App\Service;

use App\Dto\UrlDto;
use App\Entity\ShortUrl;
use App\Entity\User;
use App\Exceptions\ClientOrientedException;
use App\Exceptions\InfrastructureException;
use App\Repository\ShortUrlRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use Throwable;

class UrlService
{
    public function __construct(private ShortUrlRepository $shortUrlRepository)
    {
    }

    public function createShortUuid(UrlDto $urlDto, User $user): ShortUrl
    {
        try {

            $url = new ShortUrl($user, $this->getUniqueToken(), $urlDto->url);

            $this->shortUrlRepository->add($url, true);
        } catch (ClientOrientedException $clientOrientedException) {
            throw $clientOrientedException;
        } catch (UniqueConstraintViolationException ) {
            throw new ClientOrientedException('Something went wrong. Try again.');
        } catch (Throwable) {
            throw new InfrastructureException();
        }

        return $url;
    }

    private function getUniqueToken(): string
    {
        $triesCount = 5;

        while ($triesCount-- > 0) {
            $token = uniqid();
            if ($this->shortUrlRepository->checkUniqueToken($token)) {
                return  $token;
            }
        }

        throw new ClientOrientedException('Something went wrong. Try again.');
    }
}