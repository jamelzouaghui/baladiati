<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\EditArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
            //$file = $form->get('photo')->getData();
            if ($article->getPhoto()) {
                $file = $article->getPhoto();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('articles_directory'), $fileName);
                $article->setphoto($fileName);
            }

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

    /**
     * @Route("/{id}/publiearticle" , name="publie-article",options={"expose"=true})
     * 
     */
    public function publieArticle(Request $request, $id, EntityManagerInterface $em) {

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        $article->setPublicated(1);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('list-article'));
    }

    /**
     * @Route("/{id}/depubliearticle" , name="depublie-article",options={"expose"=true})
     * 
     */
    public function depublieArticle(Request $request, $id, EntityManagerInterface $em) {

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        $article->setPublicated(0);
        $em->persist($article);
        $em->flush();
        return $this->redirect($this->generateUrl('list-article'));
    }

    /**
     * @Route("/{id}/editarticle" , name="edit-article")
     * 
     */
    public function EditArticle(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('App\Entity\Article')->find($id);

        $file = $article->getPhoto();
        $form = $this->createForm(EditArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            $new_file = $form->getData()->getPhoto();
//
//            if ($new_file === null) {
//                $article->setPhoto($file);
//            } else {
//                $fileName = md5(uniqid()) . '.' . $new_file->guessExtension();
//                $file->move($this->getParameter('articles_directory'), $fileName);
//                
//                $article->setPhoto($new_file);
//            }


            $new_file = $form->get('photo')->getData();
            if ($file === null) {
                $article->setPhoto($file);
            } else {
                $fileName = $this->generateUniqueFileName() . '.' . $new_file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                            $this->getParameter('articles_directory'), $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochure' property to store the PDF file name
                // instead of its contents
                $article->setPhoto($fileName);
            }




            $article->setPublicated(0);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('list-article');
        }

        return $this->render('article/edit-article.html.twig', [
                    'form' => $form->createView(),
                    'id' => $id
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
     * @Route("/{id}/deletearticle" , name="delete-article")
     * 
     */
    public function DeleteArticle(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('App\Entity\Article')->find($id);

        if ($article) {
            $em->remove($article);
            $em->flush();
            //$request->getSession()->getFlashBag()->add('notice', array('alert' => 'success', 'title' => $trans->trans('message.title.succes'), 'message' => $trans->trans('message.text.succes')));
        } else {
            throw $this->createNotFoundException('Unable to find article entity.');
        }

        return $this->redirectToRoute('list-article');
    }

}
