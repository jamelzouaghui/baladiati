<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Media;
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
     * Method("POST")
     * 
     */
    public function addArticle(Request $request) {

        $em = $this->getDoctrine()->getManager();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $photosFile = $request->files->get('file_photo');

            $title = $request->get('title');

            $content = $request->get('contenuMessage');


            $em = $this->getDoctrine()->getManager();
            $article = new Article();
            $article->setTitle($title);
            $article->setContent($content);
            $article->setPublicated(0);



            $em->persist($article);
            if ($photosFile) {
                foreach ($photosFile as $file) {

                    $media = new Media();
                    $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                    $file->move($this->getParameter('articles_directory'), $fileName);
                    $media->setName($fileName);
                    $media->setArticle($article);
                    $em->persist($media);
                }
            }

            $em->flush();
            $this->addFlash('success', 'article ajouter! succées!');
            return $this->redirectToRoute('list-article');
        }



        return $this->render('article/add-article.html.twig', [
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
        $this->addFlash('success', 'article publier! succées!');
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
        $this->addFlash('success', 'article dépublier! succées!');
        return $this->redirect($this->generateUrl('list-article'));
    }

    /**
     * @Route("/{id}/editarticle" , name="edit-article")
     * 
     */
    public function EditArticle(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('App\Entity\Article')->find($id);
        $oldMedias = $article->getMedias();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//            foreach ($oldMedias as $oldfile) {
//                $med = $em->getRepository('App\Entity\Media')->find($oldfile->getId());
//                
//               $em->remove($med);
//              $em->flush($med);
//              
//            }

            $photosFile = $request->files->get('file_photo');


            $title = $request->get('title');

            $content = $request->get('contenuMessage1');

            $article->setTitle($title);
            $article->setContent($content);
            $article->setPublicated(0);

            $em->persist($article);
            if ($photosFile) {
                foreach ($photosFile as $file) {

                    $media = new Media();
                    $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                    $file->move($this->getParameter('articles_directory'), $fileName);
                    $media->setName($fileName);
                    $media->setArticle($article);
                    $em->persist($media);
                }
            }

            $em->flush();
            $this->addFlash('success', 'article modifier! succées!');
            return $this->redirectToRoute('list-article');
        }

        return $this->render('article/edit-article.html.twig', [
                    //'form' => $form->createView(),
                    'id' => $id,
                    'article' => $article
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

    /**
     * @Route("/{id}/deletemedia" , name="delete-media",options={"expose"=true})
     * 
     */
    public function DeleteMedia(Request $request, $id) {
       
        $em = $this->getDoctrine()->getManager();

        $media = $em->getRepository('App\Entity\Media')->find($id);

        if ($media) {
            $em->remove($media);
            $em->flush();
        }

       return $this->redirectToRoute('list-article');
    }

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
            $this->addFlash('success', 'article supprimer! succées!');
            //$request->getSession()->getFlashBag()->add('notice', array('alert' => 'success', 'title' => $trans->trans('message.title.succes'), 'message' => $trans->trans('message.text.succes')));
        } else {
            throw $this->createNotFoundException('Unable to find article entity.');
        }

        return $this->redirectToRoute('list-article');
    }

}
