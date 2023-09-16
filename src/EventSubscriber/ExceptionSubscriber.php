<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Exception;
use JsonException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

final class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @throws JsonException
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof NotFoundHttpException) {
            $response = new JsonResponse([
                'code' => Response::HTTP_NOT_FOUND,
                'message' => $exception->getMessage(),
            ]);
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            $response->headers->set('Content-Type', 'application/json');
            $event->setResponse($response);
            return;
        }

        if ($exception instanceof Exception) {
            $response = new Response();
            $response->setContent(json_encode([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ], JSON_THROW_ON_ERROR));
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->headers->set('Content-Type', 'application/json');
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
