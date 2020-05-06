<?php

namespace ClientesBundle\Controller;

use ClientesBundle\Constantes\MensajesConstantes;
use ClientesBundle\Entity\Cliente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ClientesBundle\Form;
use Symfony\Component\HttpFoundation\Request;

class ClienteController extends Controller
{
    private $clientEntity;

    function __construct()
    {
        $this->clientEntity = new Cliente();
    }

    /**
     * @Route("/", name="home", name="home")
     */
    public function indexAction()
    {
        return $this->render('ClientesBundle:Cliente:index.html.twig');
    }

    /**
     * @Route("/new-client", name="new-client")
     */
    public function newClientAction()
    {

        $form = $this->createFormClient($this->clientEntity,[
            'action' => $this->generateUrl('add-client'),
            'method'=> 'POST'

        ]);
        return $this->render('ClientesBundle:Cliente:add.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/edit-client/{id}", name="edit-client", methods={"GET"})
     */
    public function editClientAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ClientesBundle:Cliente')->find($id);
        if(empty($cliente)){
            throw $this->createNotFoundException("No encontrado");
        }
        $form = $this->createFormClient($cliente,
            [
                'action' => $this->generateUrl('update-client',array('id' => $cliente->getId())),
                'method'=> 'PUT'
            ]);
        return $this->render('ClientesBundle:Cliente:edit.html.twig',
            [
                'cliente' => $cliente,
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/delete-client/{id}", name="delete-client", methods={"GET"})
     */
    public function deleteClientAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ClientesBundle:Cliente')->find($id);
        if(empty($cliente)){
            throw $this->createNotFoundException("No encontrado");
        }
        $form = $this->createFormBuilder()->setAction($this->generateUrl('remove-client',array('id' => $cliente->getId())))->setMethod('DELETE')->getForm();
        return $this->render('ClientesBundle:Cliente:delete.html.twig',
            [
                'cliente' => $cliente,
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/add-client", name="add-client", methods={"POST"})
     */
    public function addClientAction(Request $request)
    {
        $form = $this->createFormClient($this->clientEntity,[
            'action' => $this->generateUrl('add-client'),
            'method'=> 'POST'

        ]);
        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($this->clientEntity);
            $em->flush();
            $this->addFlash(
                MensajesConstantes::TYPE_MESSAGE,
                MensajesConstantes::TEXT_MESSAGE_ADD. ' ' .$this->clientEntity->getNombre(). ' ' .$this->clientEntity->getApellido()
            );
            return $this->redirectToRoute('new-client');
        }
        return $this->render('ClientesBundle:Cliente:add.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/update-client/{id}", name="update-client", methods={"PUT"})
     */
    public function updateClientAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ClientesBundle:Cliente')->find($id);
        if(empty($cliente)){
            throw $this->createNotFoundException("No encontrado");
        }

        $form = $this->createFormClient($cliente,[
            'action' => $this->generateUrl('update-client',array('id' => $cliente->getId())),
            'method'=> 'PUT'
        ]);
        $form->handleRequest($request   );

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash(
                MensajesConstantes::TYPE_MESSAGE,
                MensajesConstantes::TEXT_MESSAGE_UPDATE. ' ' .$cliente->getNombre(). ' ' .$cliente->getApellido()
            );
            return $this->redirectToRoute('list-client',array('id' => $cliente->getId()));
        }
        return $this->render('ClientesBundle:Cliente:edit.html.twig',
            [
                'cliente' => $cliente,
                'form' => $form->createView()
            ]);

    }

    /**
     * @Route("/remove-client/{id}", name="remove-client", methods={"DELETE"})
     */
    public function removeClientAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ClientesBundle:Cliente')->find($id);
        if(empty($cliente)){
            throw $this->createNotFoundException("No encontrado");
        }

        $form = $this->createFormBuilder()->setAction($this->generateUrl('remove-client',array('id' => $cliente->getId())))->setMethod('DELETE')->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->remove($cliente);
            $em->flush();
            $this->addFlash(
                MensajesConstantes::TYPE_MESSAGE,
                MensajesConstantes::TEXT_MESSAGE_DELETE. ' ' .$cliente->getNombre(). ' ' .$cliente->getApellido()
            );
            return $this->redirectToRoute('list-client',array('id' => $cliente->getId()));
        }
        return $this->render('ClientesBundle:Cliente:delete.html.twig',
            [
                'cliente' => $cliente,
                'form' => $form->createView()
            ]);

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

    private function createFormClient(Cliente $entity, $form)
    {
        $form = $this->createForm(new Form\ClienteType(), $entity,$form);
        return $form;

    }
}
