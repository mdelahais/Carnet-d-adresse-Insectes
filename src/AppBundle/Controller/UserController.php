<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     * @return Response
     */
    public function User_list(){
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user = $repository->findAll();

        return $this->render('user.html.twig', array('user'=>$user));
    }

    /**
     * @return Response
     * @Route("/modify/{id}", name="modify")
     * @param Request $request
     * @param User $user
     */
    public function edit(Request $request,User $user){

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('user');
        }

        $formView = $form->createView();

        return $this->render('userModif.html.twig' , array('form'=>$formView));
    }
}

