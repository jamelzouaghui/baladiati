<?php

namespace App\Controller\Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class ApiUserController extends FOSRestController {

    /**
     * Retrieves an Users resource
     *  @Rest\Get("/users")
     */
    public function getUsers() {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('App\Entity\User')->findAll();
        return View::create($users, Response::HTTP_OK);
        if ($users === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $users;
    }
    /**
     * Retrieves an Reclamations resource
     *  @Rest\Get("/reclamations")
     */
    public function getReclamations() {
        $em = $this->getDoctrine()->getManager();
        $reclamations = $em->getRepository('App\Entity\AbstractGMap')->findAll();
        
        return View::create($reclamations, Response::HTTP_OK);
        if ($reclamations === null) {
            return new View("there are no reclamations exist", Response::HTTP_NOT_FOUND);
        }
        return $reclamations;
    }
    
    /**
     * Retrieves an Institution resource
     *  @Rest\Get("/institutions")
     */
    public function getInstitution() {
        $em = $this->getDoctrine()->getManager();
        $institutions = $em->getRepository('App\Entity\Institution')->findAll();
        
        return View::create($institutions, Response::HTTP_OK);
        if ($institutions === null) {
            return new View("there are no reclamations exist", Response::HTTP_NOT_FOUND);
        }
        return $institutions;
    }
    
    /**
     * Retrieves an Articles resource
     *  @Rest\Get("/articles")
     */
    public function getArticles() {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('App\Entity\Article')->findAll();
        
        return View::create($articles, Response::HTTP_OK);
        if ($articles === null) {
            return new View("there are no articles exist", Response::HTTP_NOT_FOUND);
        }
        return $articles;
    }
    
    /**
     * Retrieves an Agenda resource
     *  @Rest\Get("/events")
     */
    public function getEvents() {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('App\Entity\Agenda')->findAll();
        
        return View::create($events, Response::HTTP_OK);
        if ($events === null) {
            return new View("there are no events exist", Response::HTTP_NOT_FOUND);
        }
        return $events;
    }
	
	
	
    /**
     * Retrieves an Articles resource
     *  @Rest\Get("/login_check")
     */
    public function loginCheck(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $email = $request->get('email');
        $passwordCrypt = $request->get('password');
        
        $email = "jamel.arya@gmail.com";
        $password= "password";
        
        $user = $em->getRepository('App\Entity\User')->findBy(array('email' => $email,'passwordecryp' => $password));

        if (!count($user)) {
            $response = array(
                'code' => 1,
                'message' => 'No user found!',
                'errors' => null,
                'result' => null
            );

            return View::create($response, Response::HTTP_NOT_FOUND);
        }

        $response = array(
            'code' => 0,
            'message' => 'success',
            'errors' => null,
            'result' => $user
        );

         return View::create($response, Response::HTTP_NOT_FOUND);
    }

    
    

}
