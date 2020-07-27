<?php

namespace App\Controller;

use App\Repository\CertificatesRepository;
use App\Repository\EducationRepository;
use App\Repository\ExperienceRepository;
use App\Repository\GeneralRepository;
use App\Repository\InterestsRepository;
use App\Repository\ProjectsRepository;
use App\Repository\SkillsRepository;
use App\Repository\UserRepository;
use App\Repository\WorkflowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/homepage.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }



    /**
     * @Route("/profile/{username}", name="profile")
     */
    public function profile($username, UserRepository $userRepository, InterestsRepository $interestsRepository,WorkflowRepository $workflowRepository, CertificatesRepository $certificatesRepository,ExperienceRepository $experienceRepository, SkillsRepository $skillsRepository, GeneralRepository $generalRepository, EducationRepository $educationRepository, ProjectsRepository $projectsRepository)
    {
        $user = $userRepository->findOneBy(['username' => $username])->getId();
        $general = $generalRepository->findBy(['userid'=>$user])[0];
        $projects = $projectsRepository->findBy(['userid'=>$user]);
        $education = $educationRepository->findBy(['userid'=>$user]);
        $certificates = $certificatesRepository->findBy(['userid'=>$user]);
        $experiences = $experienceRepository->findBy(['userid'=>$user]);
        $skills = $skillsRepository->findBy(['userid'=>$user]);
        $interests = $interestsRepository->findBy(['userid'=>$user]);
        $workflow = $workflowRepository->findBy(['userid'=>$user]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'general' => $general,
            'projects' => $projects,
            'education' => $education,
            'certificates' => $certificates,
            'experiences' => $experiences,
            'skills' => $skills,
            'interests' => $interests,
            'workflow' => $workflow,
        ]);
    }


}
