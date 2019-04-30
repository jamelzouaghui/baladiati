<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\EditUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserController extends AbstractController {

    /**
     * @Route("/users" , name="users")
     * 
     */
    public function index(Request $request) {

        $em = $this->getDoctrine()->getManager();

        //$users = $em->getRepository('App\Entity\User')->findAll();
        $queryadmin = $this->getDoctrine()->getEntityManager()
                        ->createQuery(
                                'SELECT u FROM App\Entity\User u WHERE u.roles LIKE :role'
                        )->setParameter('role', '%"ROLE_ADMIN"%');
        $users = $queryadmin->getResult();
        $query = $this->getDoctrine()->getEntityManager()
                        ->createQuery(
                                'SELECT u FROM App\Entity\User u WHERE u.roles LIKE :role'
                        )->setParameter('role', '%"ROLE_USER"%');

        $users2 = $query->getResult();

        return $this->render('user/index.html.twig', [
                    'users' => $users,
                    'users2' => $users2
                        ]
        );
    }

    /**
     * @Route("/adduser" , name="add-user")
     * 
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $encoder, TokenGeneratorInterface $tokenGenerator) {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
//test pour git init workflow

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();

            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();
            $emailUser = $em->getRepository('App\Entity\User')->findByEmail($email);
            if (!empty($emailUser)) {
                $form->get('email')->addError(new FormError("Cette adresse email est déjà associée à un compte "));
                return $this->render('user/add-user.html.twig', [
                            'form' => $form->createView()
                                ]
                );
            }
            $encoded = $encoder->encodePassword($user, $password);
            $user->setPassword($encoded);
            $user->setPasswordecryp($password);
            $user->setRoles(['ROLE_ADMIN']);
//            // création du token
//            $user->setToken($tokenGenerator->generateToken());
//            // enregistrement de la date de création du token
//            $user->setPasswordRequestedAt(new \Datetime());
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'député Créer! succées!');
            return $this->redirectToRoute('users');
        }

        return $this->render('user/add-user.html.twig', [
                    'form' => $form->createView()
                        ]
        );
    }

    /**
     * @Route("/addusernormal" , name="add-user-normal")
     * 
     */
    public function addUserNormal(Request $request, UserPasswordEncoderInterface $encoder, TokenGeneratorInterface $tokenGenerator) {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
//test pour git init workflow

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();

            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();
            $emailUser = $em->getRepository('App\Entity\User')->findByEmail($email);
            if (!empty($emailUser)) {
                $form->get('email')->addError(new FormError("Cette adresse email est déjà associée à un compte "));
                return $this->render('user/add-user.html.twig', [
                            'form' => $form->createView()
                                ]
                );
            }
            $encoded = $encoder->encodePassword($user, $password);
            $user->setPassword($encoded);
            $user->setPasswordecryp($password);
            $user->setRoles(['ROLE_USER']);
//            // création du token
//            $user->setToken($tokenGenerator->generateToken());
//            // enregistrement de la date de création du token
//            $user->setPasswordRequestedAt(new \Datetime());
            $em->persist($user);

            $em->flush();
            $this->addFlash('success', 'député Créer! succées!');
            return $this->redirectToRoute('users');
        }

        return $this->render('user/add-user-normal.html.twig', [
                    'form' => $form->createView()
                        ]
        );
    }

    /**
     * @Route("/{id}/update-user" , name="edit-user")
     * 
     */
    public function editUser(Request $request, UserPasswordEncoderInterface $encoder, $id) {

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('App\Entity\User')->find($id);

        $photo = $user->getPhoto();

        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();

            if ($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                            $this->getParameter('users_directory'), $fileName
                    );
                } catch (FileException $e) {
                    
                }

                $user->setPhoto($fileName);
            } else {
                $user->setPhoto($photo);
            }



            $user->setRoles(['ROLE_ADMIN']);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'député modifier! succées!');
            return $this->redirectToRoute('users');
        }

        return $this->render('user/edit-user.html.twig', [
                    'form' => $form->createView(),
                    'id' => $id,
                    'user' => $user
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
     * @Route("/{id}/deleteuser" , name="delete-user")
     * 
     */
    public function DeleteUser(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('App\Entity\User')->find($id);

        if ($user) {
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'député supprimer! succées!');
            return $this->redirectToRoute('users');
            //$request->getSession()->getFlashBag()->add('notice', array('alert' => 'success', 'title' => $trans->trans('message.title.succes'), 'message' => $trans->trans('message.text.succes')));
        } else {
            throw $this->createNotFoundException('Unable to find user entity.');
        }
        $users = $em->getRepository('App\Entity\User')->findAll();

        return $this->render('dashboard/index.html.twig', [
                    'users' => $users
                        ]
        );
    }

}
