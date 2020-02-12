<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class InneAlbumyController extends AbstractController
{
    /**
     * @return Response
     * @Route("/inneAlbumy/inneAlbumy",name="inneAlbumy")
     */
    public function M()
    {

        $message=1;
        $securityContext=$this->container->get('security.authorization_checker');
        if($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $entityManager=$this->getDoctrine()->getManager();
            $dane=$entityManager->getRepository(User::class)->findAll();
            /*
              $nazwyUserow = array();
              foreach ($dane as $key){
                  $daneUserow = $key->getUsername()." ";
                  $daneUserow .= $key->getEmail()." ";
                  $daneUserow .= $key->getImie()." ";
                  $nazwyUserow[]=$daneUserow;
              }*/
            $pola=array();
            foreach ($dane as $key)
            {
                $pola[]=$key->getUsername();
            }



            return $this->render('inneAlbumy/inneAlbumy.html.twig', array('dane'=>$pola,'massage'=>$message));
        }
        else
        {
            $message=0;
        }
        return $this->render('inneAlbumy/inneAlbumy.html.twig', array('massage'=>$message));
    }


}