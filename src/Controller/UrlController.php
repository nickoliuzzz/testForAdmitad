<?php

namespace App\Controller;

use App\Dto\UrlDto;
use App\Entity\User;
use App\Form\UrlType;
use App\Service\UrlService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UrlController extends CustomAbstractController
{
    #[Route('/api/url', name: 'api_url_create', methods: Request::METHOD_POST)]
    public function index(#[CurrentUser] User $user, Request $request, UrlService $urlService): JsonResponse
    {
        $form = $this->getForm(UrlType::class, $request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return new JsonResponse(['errors' => $this->getFormErrors($form)], Response::HTTP_BAD_REQUEST);
        }

        /** @var UrlDto $urlDto */
        $urlDto = $form->getData();
        $shortUrl = $urlService->createShortUuid($urlDto, $user);

        return new JsonResponse(['urlToken' => $shortUrl->getToken()], Response::HTTP_CREATED);
    }
}
