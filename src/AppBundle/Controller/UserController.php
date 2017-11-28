<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\Common\Collections\ArrayCollection;
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
        $users = $repository->findAll();

        return $this->render('user.html.twig', array('users'=>$users));
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

    /**
     * @Route("/UserAdd/{id}", name="UserAdd", defaults={"id"=null})
     * @return Response
     */
    public function userAdd(User $user){

        $product = new Product();

        $product->setName($user->getUsername());
        $product->setAge($user->getAge());
        $product->setFamily($user->getFamily());
        $product->setFood($user->getFood());
        $product->setRace($user->getRace());

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();


        return $this->redirectToRoute('list');
    }
    public function connect(User $user){
        if($user)
        $user = $this->getUser();
    }
}

