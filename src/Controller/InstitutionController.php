<?php

namespace App\Controller;

use App\Entity\Institution;
use App\Form\EditInstitutionType;
use App\Form\InstitutionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InstitutionController extends AbstractController
{
 
    
     /**
     * @Route("/institution", name="institution")
     */
    public function index(EntityManagerInterface $em) {
        $em = $this->getDoctrine()->getManager();
        $institutions = $em->getRepository(Institution::class)->findAll();

        return $this->render('institution/index.html.twig', [
                    'institutions' => $institutions
                        ]
        );
    }

    /**
     * @Route("/institution/new" , name="add-institution")
     * 
     */
    public function addInstitution(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $institution = new Institution();
        $form = $this->createForm(InstitutionType::class, $institution);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($institution);
            $em->flush();
            return $this->redirectToRoute('institution');
        }

        return $this->render('institution/add-institution.html.twig', [
                    'form' => $form->createView()
                        ]
        );
    }
    
    
     /**
     * @Route("/{id}//institution/edit" , name="edit-institution")
     * 
     */
    public function EditInstitution(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $institution = $em->getRepository('App\Entity\Institution')->find($id);
        $form = $this->createForm(EditInstitutionType::class, $institution);
//test pour git init workflow

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($institution);
            $em->flush();
            return $this->redirectToRoute('institution');
        }

        return $this->render('institution/edit-institution.html.twig', [
                    'form' => $form->createView()
                        ]
        );
    }
//



    /**
     * @Route("/{id}/institution/delete" , name="delete-institution")
     * 
     */
    public function DeleteInstitution(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $institution = $em->getRepository('App\Entity\Institution')->find($id);

        if ($institution) {
            $em->remove($institution);
            $em->flush();
            //$request->getSession()->getFlashBag()->add('notice', array('alert' => 'success', 'title' => $trans->trans('message.title.succes'), 'message' => $trans->trans('message.text.succes')));
        } else {
            throw $this->createNotFoundException('Unable to find institution entity.');
        }

        return $this->redirectToRoute('institution');

    }

}
