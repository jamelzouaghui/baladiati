<?php

namespace App\Controller;

use App\Entity\Agenda;
use App\Form\AgendaType;
use App\Form\EditAgendaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AgendaController extends AbstractController {

    /**
     * @Route("/agenda", name="agenda")
     */
    public function index(EntityManagerInterface $em) {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository(Agenda::class)->findAll();

        return $this->render('agenda/index.html.twig', [
                    'events' => $events
                        ]
        );
    }

    /**
     * @Route("/event/new" , name="add-event")
     * 
     */
    public function addEvent(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $agenda = new Agenda();
        $form = $this->createForm(AgendaType::class, $agenda);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($agenda);
            $em->flush();
            return $this->redirectToRoute('agenda');
        }

        return $this->render('agenda/add-event.html.twig', [
                    'form' => $form->createView()
                        ]
        );
    }
    
    
     /**
     * @Route("/{id}/editevent" , name="edit-event")
     * 
     */
    public function EditEvent(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('App\Entity\Agenda')->find($id);
        $form = $this->createForm(EditAgendaType::class, $event);
//test pour git init workflow

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('agenda');
        }

        return $this->render('agenda/edit-event.html.twig', [
                    'form' => $form->createView()
                        ]
        );
    }
//



    /**
     * @Route("/{id}/deleteevent" , name="delete-event")
     * 
     */
    public function DeleteEvent(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('App\Entity\Agenda')->find($id);

        if ($event) {
            $em->remove($event);
            $em->flush();
            //$request->getSession()->getFlashBag()->add('notice', array('alert' => 'success', 'title' => $trans->trans('message.title.succes'), 'message' => $trans->trans('message.text.succes')));
        } else {
            throw $this->createNotFoundException('Unable to find event entity.');
        }

        return $this->redirectToRoute('agenda');

    }

}
