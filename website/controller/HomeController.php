<?php

/**
 * ETML
 * @author      : Serghei Diulgherov
 * Date         : 10.11.2022
 * Description  : Home controller
 * 
 * @copyright 2022 - ETML - Serghei Diulgherov
 */

/**
 * Classes list :
 *  
 * 
 * Functions list :
 *  
 */

include_once 'model/UserRepository.php';
include_once 'model/TicketRepository.php';

class HomeController extends Controller
{
    /**
     * It takes the value of the action parameter in the URL and appends "Action" to it. Then it calls the
     * function with that name.
     *
     * So if the URL is http://example.com/index.php?action=foo, the function fooAction() will be called.
     *
     * @return mixed 	=> The return value of the function call
     */
    public function display()
    {
        $action = $_GET['action'] . "Action";

        /* Redirects the user to the error page if the requested page does not exist */
        if (method_exists($this, $action))
            return call_user_func(array(
                $this, 
                $action
            ));
        else
        {
            $_SESSION['errorCode'] = 404;
            $_SESSION['errorMsg'] = "Page not found";

            //Error redirect page
            //header("Location: ...")

            die();
        }
    }

    private function loginAction()
    {
        $view = file_get_contents('view/page/home/login.php');
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function logoutAction()
    {
        session_destroy();

        header('Location: index.php');
    }

    private function connectAction()
    {
        $userRepository = new UserRepository();
        
        if (isset($_POST['username'], $_POST['password']))
        {
            $userToConnect = $userRepository->getOne($_POST['username']);
            if (count($userToConnect) > 0)
            {
                if (password_verify($_POST['password'], $userToConnect[0]['usePassword']))
                {
                    session_regenerate_id();
                    $_SESSION['loggedIn'] = TRUE;
                    $_SESSION['isAdmin'] =  $userToConnect[0]['useAdmin'];
                    $_SESSION['firstName'] = $userToConnect[0]['useSurname'];
                    $_SESSION['lastName'] = $userToConnect[0]['useName'];
                    $_SESSION['username'] = $userToConnect[0]['useUsername'];
                    $_SESSION['id'] = $userToConnect[0]['idUser'];
                }
                else 
                {
                    $_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect";
                }
            }
            else
            {
                $_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect";
            }
        }
        else
        {
            $_SESSION['error'] = "Veuillez entrer un nom d'utilisateur et un mot de passe";
        }
        header('Location: index.php');
    }

    private function homeAction()
    {

        if ($_SESSION['isAdmin'] == '0')
        {
            $view = file_get_contents('view/page/home/user_dashboard.php');
        }
        else
        {
            $view = file_get_contents('view/page/home/admin_dashboard.php');
        }
        
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function createTicketAction()
    {
        $ticketRepository = new TicketRepository();
        var_dump($_POST);
        echo '<br>';
        var_dump($_FILES);

        $target_dir = "uploads/" . $_SESSION['username'] . "/";
        if (!is_dir("uploads/"))
        {
            mkdir("uploads/", 0777);
        }
        if (!is_dir($target_dir))
        {
            mkdir($target_dir, 0777);
        }
        $target_file = $target_dir . basename($_FILES["fileToUpload"]['name']);
        $uploadOk = 1;
        if (isset($_POST['submit']))
        {
            if (file_exists($target_file)) 
            {
                $_SESSION['error'] = "Le fichier existe déja, veuillez le renommer.";
                $uploadOk = 0;
            }
            if ($_FILES["fileToUpload"]["size"] > 419430400) 
            {
                $_SESSION['error'] = "Le fichier est trop large, veuillez en sélectionner un autre. Limite 50 Mb";
                $uploadOk = 0;
            }
        }
        if ($uploadOk == 0) {
            // echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } 
        else 
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            } else {
              echo "Sorry, there was an error uploading your file.";
            }
        }

        header('Location: index.php');
    }

}

?>