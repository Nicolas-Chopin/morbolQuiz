<?php

namespace App\Controller;

use Exception;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/about", name="about", methods={"GET"})
     */
    public function about()
    {
        return $this->render('main/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(MailerInterface $mailer, Request $request)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // doing form traitment
            $contact = $form->getData();
            $firstname = $contact->getFirstname();
            $lastname = $contact->getLastname();
            $phone = $contact->getPhone();
            $email = $contact->getEmail();
            $message = $contact->getMessage();
            
            $email = (new Email())
            ->from($email)
            ->to('chopin.nico@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Contact Morbol Quiz')
            ->html("
                <div>
                    <p>Message de $firstname $lastname : </p>
                    $message
                </div>
                <div>
                    <p>Numéro de téléphone indiqué : $phone</p>
                </div>
                <div>
                    <p>Email indiqué : $email</p>
                </div>");

            $mailer->send($email);
            

            $this->addFlash('success', 'Message envoyé');

            return $this->redirectToRoute('index');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/legal-mentions", name="legal-mentions", methods={"GET"})
     */
    public function legalMentions()
    {
        return $this->render('main/legal-mentions.html.twig');
    }

    /**
     * @Route("/patchnotes", name="patchnotes", methods={"GET"})
     */
    public function patchnotes()
    {
        return $this->render('main/patchnotes.html.twig');
    }

    /**
     * @Route("/rules", name="rules", methods={"GET"})
     */
    public function rules()
    {
        return $this->render('main/rules.html.twig');
    }
}
