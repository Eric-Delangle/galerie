<?php

namespace App\Controller;

use Swift;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SwiftmailerBundle\Command\SendEmailCommand;

class EmailController extends AbstractController
{

    /**
     * @var \Swift Mailer
     */
    private $mailer;


    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }


    /**
     * @Route("/email", name="contact_email")
     */
    public function contact(Request $request)
    {

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $message = (new \Swift_Message($contact))
                ->setFrom('info@ericdelangle-deco.fr')
                ->setTo('polvu@hotmail.fr')
                ->setSubject($contact->getSubject())
                ->setReplyTo($contact->getEmail())
                ->setBody($contact->getMessage(), 'text/html');

            $this->addFlash('success', 'Votre message a bien été envoyé !');


            $this->mailer->send($message);


            return $this->redirectToRoute('home_base');
        }

        return $this->render('email/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
