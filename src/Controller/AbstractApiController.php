<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractApiController extends AbstractController
{
    final protected function errorResponse(
        int $code = Response::HTTP_BAD_REQUEST,
        ?string $message = null,
        array $context = []
    ): JsonResponse {
        $payload = array_merge(
            [
                'error' => true,
                'message' => $message,
            ],
            $context
        );

        return new JsonResponse($payload, $code);
    }

    protected function errorFormResponse(FormInterface $form): JsonResponse
    {
        $list = [];
        /** @var FormError $formError */
        foreach ($form->getErrors(true) as $formError) {
            $list[] = $formError->getMessage();
        }

        return $this->errorResponse(Response::HTTP_BAD_REQUEST,'Form is invalid', ['list' => $list]);
    }
}