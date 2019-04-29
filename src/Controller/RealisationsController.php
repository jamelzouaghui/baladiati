<?php

namespace App\Controller;

use App\Entity\Realisations;
use App\Form\EditRealisatonsType;
use App\Form\RealisationsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RealisationsController extends AbstractController {

    /**
     * @Route("/realisations/list" , name="list-realisations")
     * 
     */
    public function listRealisations(EntityManagerInterface $em) {

        $em = $this->getDoctrine()->getManager();
        $realisations = $em->getRepository(Realisations::class)->findAll();

        return $this->render('realisations/index.html.twig', [
                    'realisations' => $realisations
                        ]
        );
    }

    /**
     * @Route("/realisations/new" , name="add-realisations")
     * 
     */
    public function addRealisations(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $article = new Realisations();
        $form = $this->createForm(RealisationsType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();
            if ($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                            $this->getParameter('articles_directory'), $fileName
                    );
                } catch (FileException $e) {
                    
                }

                $article->setPhoto($fileName);
            } 

            $article->setPublicated(0);
            $em->persist($article);
            $em->flush();
             $this->addFlash('success', 'realisation ajouter! succées!');
            return $this->redirectToRoute('list-realisations');
        }

        return $this->render('realisations/add-realisations.html.twig', [
                    'form' => $form->createView()
                        ]
        );
    }

    /**
     * @Route("/{id}/publierealisations" , name="publie-realisations",options={"expose"=true})
     * 
     */
    public function publieRealisations(Request $request, $id, EntityManagerInterface $em) {

        $em = $this->getDoctrine()->getManager();
        $realisation = $em->getRepository(Realisations::class)->find($id);
        $realisation->setPublicated(1);
        $em->persist($realisation);
        $em->flush();
        $this->addFlash('success', 'realisation publier! succées!');
        return $this->redirect($this->generateUrl('list-realisations'));
    }

    /**
     * @Route("/{id}/depublierealisations" , name="depublie-realisations",options={"expose"=true})
     * 
     */
    public function depublieRealisations(Request $request, $id, EntityManagerInterface $em) {

        $em = $this->getDoctrine()->getManager();
        $realisation = $em->getRepository(Realisations::class)->find($id);
        $realisation->setPublicated(0);
        $em->persist($realisation);
        $em->flush();
         $this->addFlash('success', 'realisation dépublier! succées!');
        return $this->redirect($this->generateUrl('list-realisations'));
    }

    /**
     * @Route("/{id}/editrealisatons" , name="edit-realisatons")
     * 
     */
    public function EditRealisations(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $realisaton = $em->getRepository('App\Entity\Realisations')->find($id);
        $photo = $realisaton->getPhoto();
        $form = $this->createForm(EditRealisatonsType::class, $realisaton);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();
            if ($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                            $this->getParameter('articles_directory'), $fileName
                    );
                } catch (FileException $e) {
                    
                }

                $realisaton->setPhoto($fileName);
            } else {
                $realisaton->setPhoto($photo);
            }





            $realisaton->setPublicated(0);
            $em->persist($realisaton);
            $em->flush();
            $this->addFlash('success', 'realisaton modifier! succées!');
            return $this->redirectToRoute('list-realisations');
        }

        return $this->render('realisations/edit-realisations.html.twig', [
                    'form' => $form->createView(),
                    'id' => $id,
            'realisaton'=>$realisaton
                        ]
        );
    }

    /**
     * @return string
     */
    private function generateUniqueFileName() {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

//

    /**
     * @Route("/{id}/realisations" , name="delete-realisations")
     * 
     */
    public function DeleteRealisations(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $realisation = $em->getRepository('App\Entity\Realisations')->find($id);

        if ($realisation) {
            $em->remove($realisation);
            $em->flush();
            $this->addFlash('success', 'realisation supprimer! succées!');
            //$request->getSession()->getFlashBag()->add('notice', array('alert' => 'success', 'title' => $trans->trans('message.title.succes'), 'message' => $trans->trans('message.text.succes')));
        } else {
            throw $this->createNotFoundException('Unable to find realisation entity.');
        }

        return $this->redirectToRoute('list-realisations');
    }

}
