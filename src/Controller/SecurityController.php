<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

//    /**
//     * @Route("/api/login_check", name="login_check", methods={"POST"})
//     */
//    public function loginCheck(Request $request)
//    {
//        $user = $this->getUser();
//        dump($user);
//        die();
//        return $this->json([
//            'username' => $user->getUsername(),
//            'roles' => $user->getRoles(),
//        ]);
//    }

}
