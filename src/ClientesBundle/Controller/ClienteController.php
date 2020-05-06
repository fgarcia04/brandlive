<?php

namespace ClientesBundle\Controller;

use ClientesBundle\Entity\Cliente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ClientesBundle\Form;
use Symfony\Component\HttpFoundation\Request;

class ClienteController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('ClientesBundle:Cliente:index.html.twig');
    }

    /**
     * @Route("/add-client", name="add-client")
     */
    public function addClientAction()
    {
        $cliente = new Cliente();
        $form = $this->createAddForm($cliente);
        return $this->render('ClientesBundle:Cliente:add.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/create-client", name="create-client", methods={"POST"}e)
     */
    public function createClientAction(Request $request)
    {
        $cliente = new Cliente();
        $form = $this->createAddForm($cliente);
        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cliente);
            $em->flush();
        }
        return $this->render('ClientesBundle:Cliente:add.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    private function createAddForm(Cliente $entity)
    {
        $form = $this->createForm(new Form\ClienteType(), $entity,
            [
                'action' => $this->generateUrl('create-client'),
                'method'=> 'POST'

            ]);
        return $form;

    }

    /**
     * @Route("/list-client", name="list-client")
     */
    public function listClientAction()
    {
        $em = $this->getDoctrine()->getManager();
        $clientes = $em->getRepository('ClientesBundle:Cliente')->findAll();

        return $this->render('ClientesBundle:Cliente:list.html.twig',
            [
                'clientes' => $clientes
            ]);
    }
}
