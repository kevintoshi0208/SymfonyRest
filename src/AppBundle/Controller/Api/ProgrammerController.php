<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\BaseController;
use AppBundle\Entity\Programmer;
use AppBundle\Form\ProgrammerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProgrammerController extends BaseController
{
    /**
     * @Route("/api/programmers")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $body = $request->getContent();
        $data = json_decode($body,true);
        $programmer = new Programmer();
        $form = $this->createForm(ProgrammerType::class,$programmer);
        $form->submit($data);

        $programmer = $form->getData();

        $programmer->setUser($this->findUserByUsername("weaverRyan"));

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($programmer);
        $em->flush();
        $location = $this->generateUrl('api_programmers_show',[
            'nickname' => $programmer->getNickname()
        ]);

        $data = $this->serializeProgrammers($programmer);
        $response =  new JsonResponse($data,201);

        $response->headers->set('Location',$location);

        return $response;
    }

    /**
     * @Route("/api/programmers/{nickname}",name="api_programmers_show")
     * @Method("GET")
     */
    public function showAction($nickname)
    {
        $programmer = $this->getDoctrine()->getRepository("AppBundle:Programmer")
            ->findOneByNickname($nickname);

        if(!$programmer){
            throw $this->createNotFoundException(sprintf(
                'No programmer found with nickname "%s"',
                $nickname
            ));
        }

        $data = $this->serializeProgrammers($programmer);


        return new JsonResponse($data, 200);

    }

    /**
     * @Route("/api/programmers")
     * @Method("GET")
     */
    public function listAction()
    {
        $programmers = $this->getDoctrine()->getRepository("AppBundle:Programmer")
            ->findAll();
        $data = ['programmers' => []];

        foreach ($programmers as $programmer){
            $data['programmers'][] = $this->serializeProgrammers($programmer);
        }

        return new JsonResponse($data,200);

    }

    public function serializeProgrammers($programmer){
        $data = [
            'nickname' => $programmer->getNickname(),
            'avatarNumber' => $programmer->getAvatarNumber(),
            'powerLevel' => $programmer->getPowerLevel(),
            'tagLine' => $programmer->getTagLine(),
        ];

        return $data;
    }

}
