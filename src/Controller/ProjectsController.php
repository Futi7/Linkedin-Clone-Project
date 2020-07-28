<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Form\ProjectsType;
use App\Repository\GeneralRepository;
use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/projects")
 */
class ProjectsController extends AbstractController
{
    /**
     * @Route("/", name="projects_index", methods={"GET"})
     */
    public function index(ProjectsRepository $projectsRepository, GeneralRepository $generalRepository): Response
    {
        return $this->render('admin/projects/index.html.twig', [
            'projects' => $projectsRepository->findBy(['userid'=>$this->getUser()->getId()]),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="projects_new", methods={"GET","POST"})
     */
    public function new(Request $request, GeneralRepository $generalRepository): Response
    {
        $project = new Projects();
        $form = $this->createForm(ProjectsType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->setUserid($this->getUser()->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('projects_index');
        }

        return $this->render('admin/projects/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/{id}", name="projects_show", methods={"GET"})
     */
    public function show(Projects $project, GeneralRepository $generalRepository): Response
    {
        if($this->getUser()->getId() == $project->getUserid()) {
        return $this->render('admin/projects/show.html.twig', [
            'project' => $project,
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
        }
        return $this->redirectToRoute('projects_index');
    }

    /**
     * @Route("/{id}/edit", name="projects_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Projects $project, GeneralRepository $generalRepository): Response
    {
        if($this->getUser()->getId() == $project->getUserid()) {
        $form = $this->createForm(ProjectsType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projects_index');
        }

        return $this->render('admin/projects/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
        }
        return $this->redirectToRoute('projects_index');
    }

    /**
     * @Route("/{id}", name="projects_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Projects $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('projects_index');
    }
}
