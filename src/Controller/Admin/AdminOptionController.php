<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/option")
 */
class AdminOptionController extends AbstractController
{
    /**
     * @Route("/", name="admin.option.index", methods={"GET"})
     */
    public function index(OptionRepository $optionRepository): Response
    {
        return $this->render('admin/option/index.html.twig', [
            'options' => $optionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.option.new", methods={"GET", "POST"})
     */
    public function new(Request $request, OptionRepository $optionRepository): Response
    {
        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $optionRepository->add($option, true);

            return $this->redirectToRoute('admin.option.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/option/new.html.twig', [
            'option' => $option,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="admin.option.edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Option $option, OptionRepository $optionRepository): Response
    {
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $optionRepository->add($option, true);

            return $this->redirectToRoute('admin.option.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/option/edit.html.twig', [
            'option' => $option,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin.option.delete", methods={"POST"})
     */
    public function delete(Request $request, Option $option, OptionRepository $optionRepository): Response
    {
        if ($this->isCsrfTokenValid('admin/delete'.$option->getId(), $request->request->get('_token'))) {
            $optionRepository->remove($option, true);
        }

        return $this->redirectToRoute('admin.option.index', [], Response::HTTP_SEE_OTHER);
    }
}
