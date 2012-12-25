<?php

namespace mgate\PersonneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use mgate\PersonneBundle\Entity\Employe;
use mgate\PersonneBundle\Form\EmployeType;
use mgate\PersonneBundle\Form\EmployeHandler;

class EmployeController extends Controller
{
    
    public function ajouterAction($prospect_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        // On vérifie que le prospect existe bien
        if( ! $prospect = $em->getRepository('mgate\PersonneBundle\Entity\Prospect')->find($prospect_id) )
        {
            throw $this->createNotFoundException('Prospect[id='.$prospect_id.'] inexistant');
        }
        
        
        $employe = new Employe;
        $employe->setProspect($prospect);

        $form        = $this->createForm(new EmployeType, $employe);
        
        if( $this->get('request')->getMethod() == 'POST' )
        {
            $form->bindRequest($this->get('request'));
               
            if( $form->isValid() )
            {
                $em->persist($employe);    
                $em->flush();

                return $this->redirect( $this->generateUrl('mgatePersonne_employe_voir', array('id' => $employe->getId())) );
            }
        }

        return $this->render('mgatePersonneBundle:Employe:ajouter.html.twig', array(
            'form' => $form->createView(),
        ));
        
    }
    
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('mgatePersonneBundle:Employe')->findAll();

        return $this->render('mgatePersonneBundle:Employe:index.html.twig', array(
            'users' => $entities,
        ));
                
    }
    
    public function voirAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('mgatePersonneBundle:Employe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employe entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('mgatePersonneBundle:Employe:voir.html.twig', array(
            'employe'      => $entity,
            /*'delete_form' => $deleteForm->createView(),        */));
    }
    
    public function modifierAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        if( ! $employe = $em->getRepository('mgate\PersonneBundle\Entity\Employe')->find($id) )
        {
            throw $this->createNotFoundException('Employe [id='.$id.'] inexistant');
        }

        // On passe l'$article récupéré au formulaire
        $form        = $this->createForm(new EmployeType, $employe);
        
        if( $this->get('request')->getMethod() == 'POST' )
        {
            $form->bindRequest($this->get('request'));
               
            if( $form->isValid() )
            {
                $em->persist($employe);    
                $em->flush();

                return $this->redirect( $this->generateUrl('mgatePersonne_employe_voir', array('id' => $employe->getId())) );
            }
        }


        return $this->render('mgatePersonneBundle:Employe:modifier.html.twig', array(
            'form' => $form->createView(),
            'employe'      => $employe,
        ));
    }
}