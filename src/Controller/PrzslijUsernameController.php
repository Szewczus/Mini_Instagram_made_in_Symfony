<?php


namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;

class PrzslijUsernameController extends AbstractController
{
    /**
     * @Route("przeslijUsername/przeslijUsername", name="przeslijUsername")
     */
    public function Method()
    {
        $file=1;
        $element='anonim';
        if(isset($_POST['element']))
        {
            $element=$_POST['element'];
        }
        $zdjecie=$element;
        $dir=$zdjecie.'/';
        $files1 = scandir($dir);
        if($files1 == '')
        {
            $file=0;
            return $this->render('przeslijUsername/przslijUsername.html.twig', array('element'=>$element, 'file'=>$file));
        }
        else
        {
            $tab=array();
            foreach ($files1 as $key)
            {
                $key=$dir.$key;
                $tab[]=$key;
            }

            return $this->render('przeslijUsername/przslijUsername.html.twig', array('element'=>$element, 'file'=>$file, 'tab'=>$tab));
        }


    }
}