<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UrlController extends AbstractController
{
    #[Route('/api/url', name: 'api_url_create', methods: Request::METHOD_POST)]
    public function index(#[CurrentUser] User $user, Request $request): JsonResponse
    {
        return new JsonResponse();
    }
}
