<?php

namespace App\Controller;

use App\Form\ResetPasswordType;
use App\Controller\ChangePassword;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordController extends AbstractController
{

    /**
     * @Route("/modifier-mot-de-passe", name="reset_password")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $changePassword = new ChangePassword();
        // rattachement du formulaire avec la class changePassword
        $form = $this->createForm(ResetPasswordType::class, $changePassword);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $newpwd = $form->get('Password')['first']->getData();

            $newEncodedPassword = $passwordEncoder->encodePassword($user, $newpwd);
            $user->setPassword($newEncodedPassword);

            $em->flush();
            $this->addFlash('success', 'Votre mot de passe à bien été changé !');

            return $this->redirectToRoute('member_account');
        }

        return $this->render('password/index.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
}
