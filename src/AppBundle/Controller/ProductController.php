<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends Controller
{
    /**
     * @Route("/add", name="add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request){

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('list');
        }

        $formView = $form->createView();

        return $this->render('productAdd.html.twig' , array('form'=>$formView));
    }

    /**
     * @Route("/list", name="list")
     * @return Response
     */
    public function product_listAction(){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $product = $repository->findAll();

        return $this->render('productList.html.twig', array('product'=>$product));
    }

    /**
     * @return Response
     * @Route("/edit/{id}", name="product_edit" )
     * @param Request $request
     * @param Product $product
     */
    public function edit(Request$request ,Product $product){

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('list');
        }

        $formView = $form->createView();

        return $this->render('productAdd.html.twig' , array('form'=>$formView));
    }

    /**
     * @Route("/delete/{id}", name="product_delete")
     * @param Product $product
     * @return Response
     */
    public function delete(Product $product){

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('list');
    }
}
