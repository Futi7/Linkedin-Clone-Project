<?php

namespace App\Controller;

use App\Entity\Certificates;
use App\Form\CertificatesType;
use App\Repository\CertificatesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route("/admin/certificates")
 */
class CertificatesController extends AbstractController
{
    /**
     * @Route("/", name="certificates_index", methods={"GET"})
     */
    public function index(CertificatesRepository $certificatesRepository): Response
    {
        return $this->render('admin/certificates/index.html.twig', [
            'certificates' => $certificatesRepository->findBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="certificates_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $certificate = new Certificates();
        $form = $this->createForm(CertificatesType::class, $certificate);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['link']->getData();
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
                $certificate->setLink($fileName);
                $certificate->setUserid($user->getId());
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($certificate);
            $entityManager->flush();

            return $this->redirectToRoute('certificates_index');
        }

        return $this->render('admin/certificates/new.html.twig', [
            'certificate' => $certificate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="certificates_show", methods={"GET"})
     */
    public function show(Certificates $certificate): Response
    {
        if($this->getUser()->getId() == $certificate->getUserid()) {
            return $this->render('admin/certificates/show.html.twig', [
                'certificate' => $certificate,
            ]);
        }
        return $this->redirectToRoute('certificates_index');
    }

    /**
     * @Route("/{id}/edit", name="certificates_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Certificates $certificate): Response
    {
        if($this->getUser()->getId() == $certificate->getUserid()) {
        $form = $this->createForm(CertificatesType::class, $certificate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('certificates_index');
        }

        return $this->render('admin/certificates/edit.html.twig', [
            'certificate' => $certificate,
            'form' => $form->createView(),
        ]);
        }
        return $this->redirectToRoute('certificates_index');
    }

    /**
     * @Route("/{id}", name="certificates_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Certificates $certificate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$certificate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($certificate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('certificates_index');
    }


    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
