<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerInterface;

use App\Entity\Skills;
use App\Repository\DeviconsRepository;

class SearchController extends AbstractController
{

    /**
     * Creates a new ActionItem entity.
     *
     * @Route("/search", name="ajax_search")
     * @Method("GET")
     */
    public function searchAction(Request $request, DeviconsRepository $deviconsRepository)
    {


        $requestString = $request->get('q');

        $entities =  $deviconsRepository->findEntitiesByString($requestString);

        if(!$entities) {
            $result['entities']['error'] = "Couldn't find any data";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntities($entities){

        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getTitle();
        }

        return $realEntities;
    }
}
