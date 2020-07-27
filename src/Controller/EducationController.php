<?php

namespace App\Controller;

use App\Entity\Education;
use App\Form\EducationType;
use App\Repository\EducationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/education")
 */
class EducationController extends AbstractController
{
    /**
     * @Route("/", name="education_index", methods={"GET"})
     */
    public function index(EducationRepository $educationRepository): Response
    {
        return $this->render('admin/education/index.html.twig', [
            'education' => $educationRepository->findBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="education_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $education = new Education();
        $form = $this->createForm(EducationType::class, $education);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $education->setUserid($this->getUser()->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($education);
            $entityManager->flush();

            return $this->redirectToRoute('education_index');
        }

        return $this->render('admin/education/new.html.twig', [
            'education' => $education,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="education_show", methods={"GET"})
     */
    public function show(Education $education): Response
    {
        if($this->getUser()->getId() == $education->getUserid()) {
        return $this->render('admin/education/show.html.twig', [
            'education' => $education,
        ]);
        }
        return $this->redirectToRoute('education_index');
    }

    /**
     * @Route("/{id}/edit", name="education_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Education $education): Response
    {
        if($this->getUser()->getId() == $education->getUserid()) {
        $form = $this->createForm(EducationType::class, $education);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('education_index');
        }

        return $this->render('admin/education/edit.html.twig', [
            'education' => $education,
            'form' => $form->createView(),
        ]);
        }
        return $this->redirectToRoute('education_index');

    }

    /**
     * @Route("/{id}", name="education_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Education $education): Response
    {
        if ($this->isCsrfTokenValid('delete'.$education->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($education);
            $entityManager->flush();
        }

        return $this->redirectToRoute('education_index');
    }
}
