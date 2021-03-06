<?php

namespace App\Controller;

use App\Entity\AbstractGMap;
use App\Form\AbstractGMapType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController {

    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function index(EntityManagerInterface $em) {

        $em = $this->getDoctrine()->getManager();
        $reclamations = $em->getRepository(AbstractGMap::class)->findAll();

        return $this->render('reclamation/index.html.twig', [
                    'reclamations' => $reclamations
                        ]
        );
    }

    /**
     * @Route("/list/reclamation", name="list-reclamation",options={"expose"=true})
     */
    public function listReclamation(Request $request, EntityManagerInterface $em) {
        $em = $this->getDoctrine()->getManager();
        $reclamations = $em->getRepository(AbstractGMap::class)->findAll();
        $response['reclamations'] = $this->getReclamationsAsArray($reclamations);


        return new JsonResponse($response);
    }

    /**
     * @Route("/{id}/editReclamation" , name="edit-reclamation")
     * 
     */
    public function editReclamation(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $reclamation = $em->getRepository('App\Entity\AbstractGMap')->find($id);
        $form = $this->createForm(AbstractGMapType::class, $reclamation);
//test pour git init workflow

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($reclamation);
            $em->flush();
            $this->addFlash('success', 'reclamation modifier ! succées!');
            return $this->redirectToRoute('reclamation');
        }

        return $this->render('reclamation/edit-reclamation.html.twig', [
                    'form' => $form->createView(),
                    'id' => $id,
           'reclamation' =>$reclamation
                        ]
        );
    }

    /**
     * Get a reclamation   as array
     * @return array
     */
    public function getReclamationsAsArray($reclamations) {
        $response = array();
        foreach ($reclamations as $reclamation) {
            if ($reclamation->getAdress()) {
                $adress = $reclamation->getAdress();
            } else {
                $adress = '';
            }

            if ($reclamation->getName()) {
                $name = $reclamation->getName();
            } else {
                $name = '';
            }

            if ($reclamation->getCity()) {
                $city = $reclamation->getCity();
            } else {
                $city = '';
            }

            if ($reclamation->getLatitude()) {
                $latitude = $reclamation->getLatitude();
            } else {
                $latitude = '';
            }
            if ($reclamation->getLongitude()) {
                $longitude = $reclamation->getLongitude();
            } else {
                $longitude = '';
            }

            $response[] = array('id' => $reclamation->getId(), 'adress' => $adress, 'name' => $name, 'city' => $city, 'latitude' => $latitude, 'longitude' => $longitude);
        }
        return $response;
    }

    /**
     * @Route("/{id}/viewReclamation" , name="view-reclamation")
     * 
     */
    public function viewReclamation(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $reclamation = $em->getRepository('App\Entity\AbstractGMap')->find($id);


        return $this->render('reclamation/view-reclamation.html.twig', [
                    'id' => $id,
                    'reclamation' => $reclamation
                        ]
        );
    }

    /**
     * Get a reclamation   
     * @return 
     */
    public function getReclamationNumber(EntityManagerInterface $em) {
        $em = $this->getDoctrine()->getManager();
        $reclamationsUnread = $em->getRepository(AbstractGMap::class)->findReclamationsUnread();
        dump($reclamationsUnread);
        die();
    }

}
