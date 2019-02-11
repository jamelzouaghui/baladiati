<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResettingType;
use App\Service\Mailer;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResettingController extends AbstractController {

    /**
     * @Route("/resetting", name="request_resetting")
     */
    public function resetMdp(Request $request, Mailer $mailer, TokenGeneratorInterface $tokenGenerator) {
        // création d'un formulaire "à la volée", afin que l'internaute puisse renseigner son mail
        $form = $this->createFormBuilder()
                ->add('email', EmailType::class, [
                    'label' => 'Votre email',
                    'attr'=>array('class' => 'form-control'),
                    'constraints' => [
                        new Email(),
                        new NotBlank()
                    ]
                ])
                ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // voir l'épisode 2 de cette série pour retrouver la méthode loadUserByUsername:
            $user = $em->getRepository(User::class)->loadUserByUsername($form->getData()['email']);

            // aucun email associé à ce compte.
            if (!$user) {
                $request->getSession()->getFlashBag()->add('warning', "Cet email n'existe pas.");
                $this->addFlash('warning', "Cet email n'existe pas.");
                return $this->redirectToRoute("request_resetting");
            }

            // création du token
            $user->setToken($tokenGenerator->generateToken());
            // enregistrement de la date de création du token
            $user->setPasswordRequestedAt(new \Datetime());
            $em->flush();

            // on utilise le service Mailer créé précédemment
            $bodyMail = $mailer->createBodyMail('resetting/mail.html.twig', [
                'user' => $user
            ]);
            $mailer->sendMessage('jamel.arya@gmail.com', $user->getEmail(), 'renouvellement du mot de passe', $bodyMail);

            $this->addFlash('success', "Un mail va vous être envoyé afin que vous puissiez renouveller votre mot de passe. Le lien que vous recevrez sera valide 24h.");
            return $this->redirectToRoute("app_login");
        }

        return $this->render('resetting/request.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    private function isRequestInTime(\Datetime $passwordRequestedAt = null) {
        if ($passwordRequestedAt === null) {
            return false;
        }

        $now = new DateTime();
        $interval = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();

        $daySeconds = 60 * 10;
        $response = $interval > $daySeconds ? false : $reponse = true;
        return $response;
    }

    /**
     * @Route("/{id}/reset-password", name="resetting-password")
     */
    public function resettingPassword(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        
        // interdit l'accès à la page si:
        // le token associé au membre est null
        // le token enregistré en base et le token présent dans l'url ne sont pas égaux
        // le token date de plus de 10 minutes
       
     $token = $user->getToken();
        if ($user->getToken() === null || $token !== $user->getToken() ) {
            throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(ResettingType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // réinitialisation du token à null pour qu'il ne soit plus réutilisable
            $user->setToken(null);
            $user->setPasswordRequestedAt(null);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Votre mot de passe a été renouvelé.");

            return $this->redirectToRoute('app_login');
        }

        return $this->render('resetting/index.html.twig', [
                    'form' => $form->createView()
        ]);
    }

}
