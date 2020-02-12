<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserController extends  AbstractController
{
    /**
     * @Route("/rejestracja", name="rejestracja")
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $passwordEncoder):Response
    {
        $user=new User();

        $form=$this->createFormBuilder($user)
            ->add('username', TextType::class, array('label'=>'Nick'))
            ->add('imie', TextType::class, array('label'=>'Imie'))
            ->add('nazwisko', TextType::class, array('label'=>'Nazwisko'))
            ->add('email', EmailType::class, array('label'=>'Email'))
            ->add('password', PasswordType::class, array('label'=>'Password'))
            ->add('submit', SubmitType::class, array('label'=>'Wyślij'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //kodowanie:
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $form->get('password')->getData()
            )
            );

            //uchwyt do bazy danych:
            $entityManager=$this->getDoctrine()->getManager();


            $entityManager->persist($user);
            $entityManager->flush();

            if (!mkdir($form->get('username')->getData(), 0777, true)) {
                die('Failed to create folders...');
            }


            return $this->render('mainPage.html.twig');

        }
    return $this->render('rejestracja/rejestracja.html.twig', array('form'=>$form->createView()));
    }
}