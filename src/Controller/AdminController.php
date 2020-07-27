<?php

namespace App\Controller;

use App\Repository\GeneralRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(GeneralRepository $generalRepository)
    {

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }
}
