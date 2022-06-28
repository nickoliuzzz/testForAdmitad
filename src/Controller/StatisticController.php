<?php

namespace App\Controller;

use App\Dto\StatisticDto;
use App\Form\StatisticType;
use App\Service\StatisticService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticController extends CustomAbstractController
{
    #[Route('/api/statistic', name: 'api_statistic', methods: Request::METHOD_POST)]
    public function execute(Request $request, StatisticService $statisticService): JsonResponse
    {
        $form = $this->getForm(StatisticType::class, $request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return new JsonResponse(['errors' => $this->getFormErrors($form)], Response::HTTP_BAD_REQUEST);
        }

        /** @var StatisticDto $statisticDto */
        $statisticDto = $form->getData();

        return new JsonResponse(['count' => $statisticService->getStatistic($statisticDto)], Response::HTTP_OK);
    }
}