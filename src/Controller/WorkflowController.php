<?php

namespace App\Controller;

use App\Entity\Workflow;
use App\Form\WorkflowType;
use App\Repository\GeneralRepository;
use App\Repository\WorkflowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/workflow")
 */
class WorkflowController extends AbstractController
{
    /**
     * @Route("/", name="workflow_index", methods={"GET"})
     */
    public function index(WorkflowRepository $workflowRepository, GeneralRepository $generalRepository): Response
    {
        return $this->render('admin/workflow/index.html.twig', [
            'workflows' => $workflowRepository->findBy(['userid'=>$this->getUser()->getId()]),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="workflow_new", methods={"GET","POST"})
     */
    public function new(Request $request, GeneralRepository $generalRepository): Response
    {
        $workflow = new Workflow();
        $form = $this->createForm(WorkflowType::class, $workflow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workflow->setUserid($this->getUser()->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($workflow);
            $entityManager->flush();

            return $this->redirectToRoute('workflow_index');
        }

        return $this->render('admin/workflow/new.html.twig', [
            'workflow' => $workflow,
            'form' => $form->createView(),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/{id}", name="workflow_show", methods={"GET"})
     */
    public function show(Workflow $workflow, GeneralRepository $generalRepository): Response
    {
        if($this->getUser()->getId() == $workflow->getUserid()) {
        return $this->render('admin/workflow/show.html.twig', [
            'workflow' => $workflow,
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
        }
        return $this->redirectToRoute('workflow_index');
    }

    /**
     * @Route("/{id}/edit", name="workflow_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Workflow $workflow, GeneralRepository $generalRepository): Response
    {
        if($this->getUser()->getId() == $workflow->getUserid()) {
        $form = $this->createForm(WorkflowType::class, $workflow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('workflow_index');
        }

        return $this->render('admin/workflow/edit.html.twig', [
            'workflow' => $workflow,
            'form' => $form->createView(),
            'profile' => $generalRepository->findOneBy(['userid'=>$this->getUser()->getId()]),
        ]);
        }
        return $this->redirectToRoute('workflow_index');
    }

    /**
     * @Route("/{id}", name="workflow_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Workflow $workflow): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workflow->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($workflow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('workflow_index');
    }
}
