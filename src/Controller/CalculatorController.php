<?php

namespace App\Controller;

use App\Form\TwoNumbersType;
use App\Model\TwoNumbers;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CalculatorController extends AbstractApiController
{
    #[Route(path: '/addition', methods: ['POST'])]
    public function addition(Request $request): JsonResponse
    {
        $form = $this->createForm(TwoNumbersType::class);

        if (null !== $errorResponse = $this->checkFormIsSubmittedAndValid($form, $request)) {
            return $errorResponse;
        }

        /** @var TwoNumbers $twoNumbers */
        $twoNumbers = $form->getData();
        $result = $twoNumbers->getA() + $twoNumbers->getB();

        return $this->resultResponse($result);
    }

    #[Route(path: '/subtraction', methods: ['POST'])]
    public function subtraction(Request $request): JsonResponse
    {
        $form = $this->createForm(TwoNumbersType::class);

        if (null !== $errorResponse = $this->checkFormIsSubmittedAndValid($form, $request)) {
            return $errorResponse;
        }

        /** @var TwoNumbers $twoNumbers */
        $twoNumbers = $form->getData();
        $result = $twoNumbers->getA() - $twoNumbers->getB();

        return $this->resultResponse($result);
    }

    #[Route(path: '/multiplication', methods: ['POST'])]
    public function multiplication(Request $request): JsonResponse
    {
        $form = $this->createForm(TwoNumbersType::class);

        if (null !== $errorResponse = $this->checkFormIsSubmittedAndValid($form, $request)) {
            return $errorResponse;
        }

        /** @var TwoNumbers $twoNumbers */
        $twoNumbers = $form->getData();
        $result = $twoNumbers->getA() * $twoNumbers->getB();

        return $this->resultResponse($result);
    }

    #[Route(path: '/division', methods: ['POST'])]
    public function division(Request $request): JsonResponse
    {
        $form = $this->createForm(TwoNumbersType::class, null, ['b_must_be_non_zero' => true]);

        if (null !== $errorResponse = $this->checkFormIsSubmittedAndValid($form, $request)) {
            return $errorResponse;
        }

        /** @var TwoNumbers $twoNumbers */
        $twoNumbers = $form->getData();
        try {
            $result = $twoNumbers->getA() / $twoNumbers->getB();
        } catch (\DivisionByZeroError) {
            return $this->errorResponse(Response::HTTP_BAD_REQUEST, 'Division by zero!');
        }

        return $this->resultResponse($result);
    }

    private function checkFormIsSubmittedAndValid(FormInterface $form, Request $request): ?JsonResponse
    {
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return $this->errorResponse(Response::HTTP_BAD_REQUEST, 'Form not submitted');
        } elseif (!$form->isValid()) {
            return $this->errorFormResponse($form);
        }

        return null;
    }

    private function resultResponse(float $result): JsonResponse
    {
        return new JsonResponse(['result' => $result]);
    }
}
