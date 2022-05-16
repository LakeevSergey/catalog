<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Throwable;

class ExceptionListener
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * ExceptionListener constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = $this->createApiResponse($exception);
        $event->setResponse($response);
    }

    /**
     * @param Throwable $exception
     * @return JsonResponse
     */
    private function createApiResponse(Throwable $exception): JsonResponse
    {
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
            $headers = $exception->getHeaders();
        } else {
            $statusCode = 500;
            $headers = [];
        }

        $errors = [];
        if ($exception instanceof ValidationFailedException) {
            $statusCode = 400;
            $errors = $exception->getViolations();
        }

        $json = $this->serializer->serialize([
            'status' => $statusCode,
            'message' => $exception->getMessage(),
            'data' => [],
            'errors' => $errors
        ], 'json');

        return new JsonResponse($json, $statusCode, $headers, true);
    }
}
