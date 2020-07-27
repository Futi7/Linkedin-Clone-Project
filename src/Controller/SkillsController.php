<?php

namespace App\Controller;

use App\Entity\Skills;
use App\Form\SkillsType;
use App\Repository\DeviconsRepository;
use App\Repository\SkillsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/skills")
 */
class SkillsController extends AbstractController
{
    /**
     * @Route("/", name="skills_index", methods={"GET"})
     */
    public function index(SkillsRepository $skillsRepository): Response
    {
        return $this->render('admin/skills/index.html.twig', [
            'skills' => $skillsRepository->findBy(['userid'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="skills_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $skill = new Skills();
        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('skills_index');
        }

        return $this->render('admin/skills/new.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="skills_show", methods={"GET"})
     */
    public function show(Skills $skill): Response
    {
        if($this->getUser()->getId() == $skill->getUserid()) {
        return $this->render('admin/skills/show.html.twig', [
            'skill' => $skill,
        ]);
        }
        return $this->redirectToRoute('skills_index');
    }

    /**
     * @Route("/{id}/edit", name="skills_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Skills $skill): Response
    {
        if($this->getUser()->getId() == $skill->getUserid()) {
        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('skills_index');
        }

        return $this->render('admin/skills/edit.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
        }
        return $this->redirectToRoute('skills_index');
    }

    /**
     * @Route("/{id}", name="skills_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Skills $skill): Response
    {
        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($skill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('skills_index');
    }


    /**
     * @Route("/add_skills", name="add_skills")
     */
    public function addSkills(Request $request, SkillsRepository $skillsRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $skillsData = $request->request->get('skills');
        foreach($skillsData as $skillData)
        {
            if($skillsRepository->findOneBy(['title' => $skillData]))
            {
                continue;
            }
            $skill = new Skills();
            $skill->setTitle($skillData);
            $skill->setUserid($this->getUser()->getId());
            $entityManager->persist($skill);
            $entityManager->flush();
        }



        return new JsonResponse();
    }



}
