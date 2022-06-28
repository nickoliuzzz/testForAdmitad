<?php

namespace App\Controller;

use App\Entity\ShortUrl;
use App\Service\RedirectToOriginalRouteService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectToOriginalRoute extends CustomAbstractController
{
    //Вообще эту функциональность частично можно разнести на инфраструктуру,
    // чтобы для каждого запроса не приходилось проходить все затратные шаги приложения там, где они не нужны
    #[Route('/api/original/{shortUrl}', name: 'original_url', methods: Request::METHOD_GET)]
    public function execute(string $shortUrl, RedirectToOriginalRouteService $redirectToOriginalRouteService): Response
    {
        $originalUrl = $redirectToOriginalRouteService->getShortUrl($shortUrl);

        if ($originalUrl === null) {
            return new JsonResponse(['message' => 'This short url doesn\'t exist.']);
        }

        return new RedirectResponse($originalUrl->getUrl());
    }
}