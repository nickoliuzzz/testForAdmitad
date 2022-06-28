<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class CustomAbstractController extends AbstractController
{
    protected function getForm(string $type, Request $request, $data = null): FormInterface
    {
        $form = $this->createForm($type, $data, [
            'csrf_protection' => false
        ]);
        $form->submit(json_decode($request->getContent(), true));

        return $form;
    }

    protected function getFormErrors(FormInterface $form)
    {
        $errors = array();

        // Global
        foreach ($form->getErrors() as $error) {
            $errors[$form->getName()][] = $error->getMessage();
        }

        // Fields
        foreach ($form as $child /** @var FormInterface $child */) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }

        return $errors;
    }
}