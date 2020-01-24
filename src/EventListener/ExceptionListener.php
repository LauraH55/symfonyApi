<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;



class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {

        if (strpos($event->getRequest()->getRequestUri(), '/api') !== 0) { // au cas où on n'est pas dans l'API, c'est si on a API, site, Admin
            return;
        }

        // You get the exception object from the received event
        $exception = $event->getThrowable(); // on récupère l'exception

        if ($exception instanceof HttpExceptionInterface) { // exception htrp 404 par ex

        $message = $exception->getMessage();

        if ($exception->getPrevious() instanceof ResourceNotFoundException) {
                $message = "The requested URL was not found on the server";
            }

        // Customize your response object to display the exception details
        $response = new JsonResponse([
          'error' => [
            'code' => $exception->getCode(),
            'message' => $message,
          ]

        ]);

        $response->setStatusCode($exception->getStatusCode());

        $event->setResponse($response);

        }

    }
}
