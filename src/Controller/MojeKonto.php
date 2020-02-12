<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class MojeKonto extends AbstractController
{
    /**
     *
     * @Route("/mojeKonto/mojeKonto", name="mojeKonto")
     */
    public function mojeKonto()
    {
        $message=1;
        $securityContext=$this->container->get('security.authorization_checker');
        if($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            //pobieram username:
            $user=$this->getUser()->getUsername();
            $dir    = $user.'/';


            $files1 = scandir($dir);
            $tab=array();

            foreach ($files1 as $key)
            {
                $key=$dir.$key;
                $tab[] =$key;
            }
            return $this->render('mojeKonto/mojeKonto.html.twig', array('tablica_zdjec'=>$tab, 'userName'=>$user, 'message'=>$message));

        }
        else
        {
            $message=0;
            return $this->render('mojeKonto/mojeKonto.html.twig', array('message'=>$message));

        }


    }
    /**
     * @Route("/mojeKonto/upload", name="upload")
     */
    public function upload()
    {
        $user=$this->getUser()->getUsername();
        $structure = $user.'/';

        $target_dir = $structure.'/';
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            if($_FILES["fileToUpload"]["tmp_name"]){
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
// Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif") {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }

                return $this->render('mojeKonto/upload.html.twig', array('target_file'=>$target_file, 'uploadOk'=>$uploadOk));
            }
            else{
                return $this->redirectToRoute('mojeKonto');
            }
        }

    }
}