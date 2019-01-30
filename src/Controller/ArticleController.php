<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
class ArticleController extends AbstractController {

    /**
     * @Route("/article/list" , name="list-article")
     * 
     */
    public function listArticle(EntityManagerInterface $em) {

        $em = $this->getDoctrine()->getManager();
       $articles = $em->getRepository(Article::class)->findAll();
      
        return $this->render('article/index.html.twig', [
                    'articles' => $articles
                        ]
        );
    }

    /**
     * @Route("/article/new" , name="add-article")
     * 
     */
    public function addArticle(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $article->getPhoto();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('articles_directory'), $fileName);
            $article->setphoto($fileName);
            $article->setPublicated(0);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('list-article');
        }

        return $this->render('article/add-article.html.twig', [
                    'form' => $form->createView()
                        ]
        );
    }

//    /**
//     * @Route("/{id}/edituser" , name="edit-user")
//     * 
//     */
//    public function EditActualite(Request $request, UserPasswordEncoderInterface $encoder, $id) {
//        $em = $this->getDoctrine()->getManager();
//
//        $user = $em->getRepository('App\Entity\User')->find($id);
//        $form = $this->createForm(EditUserType::class, $user);
////test pour git init workflow
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            //$file = $user->getPhoto();
//            $file = $form->get('photo')->getData();
//            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
//
//            // Move the file to the directory where brochures are stored
//            try {
//                $file->move(
//                        $this->getParameter('users_directory'), $fileName
//                );
//            } catch (FileException $e) {
//                // ... handle exception if something happens during file upload
//            }
//
//            // updates the 'brochure' property to store the PDF file name
//            // instead of its contents
//            $user->setPhoto($fileName);
//
//
//
//
//
//            $user->setRoles(['ROLE_ADMIN']);
//            $em->persist($user);
//            $em->flush();
//            return $this->redirectToRoute('dashboard');
//        }
//
//        return $this->render('user/edit-user.html.twig', [
//                    'form' => $form->createView()
//                        ]
//        );
//    }
//
    /**
     * @return string
     */
    private function generateUniqueFileName() {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

//
//    /**
//     * @Route("/{id}/deleteuser" , name="delete-user")
//     * 
//     */
//    public function DeleteUser(Request $request, $id) {
//        $em = $this->getDoctrine()->getManager();
//
//        $user = $em->getRepository('App\Entity\User')->find($id);
//
//        if ($user) {
//            $em->remove($user);
//            $em->flush();
//            //$request->getSession()->getFlashBag()->add('notice', array('alert' => 'success', 'title' => $trans->trans('message.title.succes'), 'message' => $trans->trans('message.text.succes')));
//        } else {
//            throw $this->createNotFoundException('Unable to find user entity.');
//        }
//
//
//
//
//
//
//        return $this->redirectToRoute('dashboard');
//
//
//        return $this->render('user/edit-user.html.twig', [
//                    'form' => $form->createView()
//                        ]
//        );
//    }
}
