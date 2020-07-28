<?php

namespace App\Controller;

use App\Entity\Interests;
use App\Form\InterestsType;
use App\Repository\DeviconsRepository;
use App\Repository\GeneralRepository;
use App\Repository\InterestsRepository;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/interests")
 */
class InterestsController extends AbstractController
{
    /**
     * @Route("/", name="interests_index", methods={"GET"})
     */
    public function index(InterestsRepository $interestsRepository, GeneralRepository $generalRepository): Response
    {
        return $this->render('admin/interests/index.html.twig', [
            'interests' => $interestsRepository->findBy(['userid'=>$this->getUser()->getId()]),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="interests_new", methods={"GET","POST"})
     */
    public function new(Request $request, GeneralRepository $generalRepository): Response
    {
        $interest = new Interests();
        $form = $this->createForm(InterestsType::class, $interest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interest->setUserid($this->getUser()->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($interest);
            $entityManager->flush();

            return $this->redirectToRoute('interests_index');
        }

        return $this->render('admin/interests/new.html.twig', [
            'interest' => $interest,
            'form' => $form->createView(),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/{id}", name="interests_show", methods={"GET"})
     */
    public function show(Interests $interest, GeneralRepository $generalRepository): Response
    {
        if($this->getUser()->getId() == $interest->getUserid()) {
        return $this->render('admin/interests/show.html.twig', [
            'interest' => $interest,
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
        }
        return $this->redirectToRoute('interests_index');
    }

    /**
     * @Route("/{id}/edit", name="interests_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Interests $interest, GeneralRepository $generalRepository): Response
    {
        if($this->getUser()->getId() == $interest->getUserid()) {
        $form = $this->createForm(InterestsType::class, $interest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('interests_index');
        }

        return $this->render('admin/interests/edit.html.twig', [
            'interest' => $interest,
            'form' => $form->createView(),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
        }
        return $this->redirectToRoute('interests_index');
    }

    /**
     * @Route("/{id}", name="interests_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Interests $interest): Response
    {
        if ($this->isCsrfTokenValid('delete'.$interest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($interest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('interests_index');
    }

}
