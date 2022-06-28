<?php

namespace App\EventListeners;

use App\Exceptions\ClientOrientedException;
use App\Exceptions\InfrastructureException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse();

        if ($exception instanceof ClientOrientedException) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setData(['message' => $exception->getMessage()]);
        } elseif ($exception instanceof InfrastructureException) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setData(['message' => $exception->getMessage()]);
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setData(['message' => 'Something went wrong. We will fix it as soon as possible.']);
        }

        $event->setResponse($response);
    }
}