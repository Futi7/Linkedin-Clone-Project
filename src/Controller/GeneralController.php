<?php

namespace App\Controller;


use App\Entity\General;
use App\Form\GeneralType;
use App\Repository\GeneralRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

/**
 * @Route("/admin/general")
 */
class GeneralController extends AbstractController
{
    /**
     * @Route("/", name="general_index", methods={"GET"})
     */
    public function index(GeneralRepository $generalRepository): Response
    {
        return $this->render('admin/general/index.html.twig', [
            'generals' => $generalRepository->findBy(['userid'=>$this->getUser()->getId()]),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="general_new", methods={"GET","POST"})
     */
    public function new(Request $request, GeneralRepository $generalRepository): Response
    {
        $general = new General();
        $form = $this->createForm(GeneralType::class, $general);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            /** @var file $file */
            $file = $form['profile_image']->getData();
            if ($file)
            {
                $fileName = $this->generateUniqueFileName() . "." . $file->guessExtension();
                try{
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e){
                }
                $general->setProfileImage($fileName);
                $general->setUserid($this->getUser()->getId());
            }
            $entityManager->persist($general);
            $entityManager->flush();

            return $this->redirectToRoute('general_index');
        }

        return $this->render('admin/general/new.html.twig', [
            'general' => $general,
            'form' => $form->createView(),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }


    /**
     * @Route("/show", name="general_show", methods={"GET"})
     */
    public function show( GeneralRepository $generalRepository): Response
    {
        $general = $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]);
        return $this->render('admin/general/show.html.twig', [
            'general' => $general,
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);

    }

    /**
     * @Route("/edit", name="general_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GeneralRepository $generalRepository): Response
    {
        $general = $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]);
        $form = $this->createForm(GeneralType::class, $general);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('general_index');
        }

        return $this->render('admin/general/edit.html.twig', [
            'general' => $general,
            'form' => $form->createView(),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);

        return $this->redirectToRoute('admin');
    }


    /**
     * @Route("/{id}", name="experience_delete", methods={"DELETE"})
     */
    public function delete(Request $request, General $general): Response
    {
        if ($this->isCsrfTokenValid('delete'.$general->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($general);
            $entityManager->flush();
        }

        return $this->redirectToRoute('experience_index');
    }



}



