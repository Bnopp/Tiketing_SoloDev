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
include_once 'model/AttachementRepositoy.php';
include_once 'model/ReplyRepository.php';

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
            $_SESSION['error'] = "Page not found";
            header('Location: index.php');
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
        $ticketRepository = new TicketRepository();
        define('TYPES', $ticketRepository -> getTicketTypes());
        define('TICKETS', $ticketRepository -> getAll());
        define('PRIORITIES', $ticketRepository -> getTicketPriorities());
        define('STATUSES', $ticketRepository -> getTicketStatuses());

        $userRepository = new UserRepository();
        define('ADMINS', $userRepository -> getAdmins());
        define('USERS', $userRepository -> getAll());

        $view = file_get_contents('view/page/home/user_dashboard.php');
        
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function sendMessageAction()
    {
        $replyRepository = new ReplyRepository();
        
        $replyRepository -> createOne($_POST['message'], $_GET['ticketId'], $_SESSION['id']);

        $_SESSION['message'] = 'Message envoyé avec succés';

        header('Location: index.php?ticketId=' . $_GET['ticketId'] . '#reply-area');
        die();
    }

    private function updateTicketAction()
    {
        $ticketRepository = new TicketRepository();
        if (!empty($_POST))
        {
            if (isset($_POST['accepted']) && $_POST['accepted'] == 'true')
            {
                $ticketRepository -> validateTicket($_GET['ticketId']);
                $_SESSION['message'] = 'Ticket clôturé avec succés';
            }
            else
            {
                $ticketRepository -> updateTicket($_GET['ticketId'], $_POST['title'], $_POST['description'], $_POST['priority'], $_POST['status'], $_POST['type'], $_POST['assigned']);
                $_SESSION['message'] = 'Ticket mis à jour avec succés';
            }
        }
        else
        {
            $_SESSION['error'] = 'Une erreur est survenue. Veuillez réessayer.';
        }
        

        header('Location: index.php?ticketId=' . $_GET['ticketId']);
        die();
    }

    private function createTicketAction()
    {
        $ticketRepository = new TicketRepository();
        $attachementRepository = new AttachementRepository();

        $target_dir = "uploads/" . $_SESSION['username'] . "/";
        if (!is_dir("uploads/"))
        {
            mkdir("uploads/", 0777);
        }
        if (!is_dir($target_dir))
        {
            mkdir($target_dir, 0777);
        }

        $errors = array();
        $uploadedFiles = array();
        $uploaded = 0;

        if (isset($_FILES["fileToUpload"]['name'])){
            $countfiles = count($_FILES['fileToUpload']['name']);

            if (!is_dir($target_dir . basename($_FILES["fileToUpload"]['name'][0])))
            {
                for( $i = 0; $i < $countfiles; $i++)
                {
                    $uploadOk = 1;
                    $_SESSION['message'] = "Le(s) fichier(s)";

                    $target_file = $target_dir . basename($_FILES["fileToUpload"]['name'][$i]);
                    if (file_exists($target_file)) 
                    {
                        echo $target_file;
                        array_push($errors, "Le fichier ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"][$i])).
                        " existe déja, veuillez le renommer.");
                        $uploadOk = 0;
                    }
                    else if ($_FILES["fileToUpload"]["size"][$i] > 419430400) 
                    {
                        array_push($errors, "Le fichier ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"][$i])).
                        " est trop large, veuillez en sélectionner un autre. Limite 50 Mb");
                        $uploadOk = 0;
                    }

                    if ($uploadOk == 1)
                    {
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) 
                        {
                            array_push($uploadedFiles, $target_file);
                            $uploaded = 1;
                            $_SESSION['message'] = "Les fichiers ont étés envoyées";           
                        } 
                        else 
                        {
                            array_push($errors, "Une erreur est survenue lors de l'envoi de ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"][$i])).". 
                            Veuillez vérifier qu'il soie sous la limite de 50 Mb");
                        }
                    }
                    else
                    {
                        $uploaded = 0;
                        foreach ($uploadedFiles as $file)
                        {
                            echo $file;
                            unlink($file);
                        }
                    }
                }
            }
            else
            {
                $uploaded = 1;
            }
        }
        else{
            array_push($errors, "Une erreur est survenue lors de l'envoi de vos fichiers. 
            Veuillez vérifier qu'ils soient sous la limite de 50 Mb");
        }

        if ($uploaded == 1)
        {
            $ticketRepository->createOne($_POST['title'], $_POST['description'], $_POST['type'], $_SESSION['id']);
            $ticketId = $ticketRepository->getLastCreatedId();

            foreach ($uploadedFiles as $file)
            {
                $attachementRepository->createOne($file, intval($ticketId[0]["LAST_INSERT_ID()"]));
                unset($file);
            }

            $_SESSION['message'] = 'Le ticket a été crée avec succés.';
        }

        if (count($errors) > 0)
        {
            $_SESSION['error'] = $errors;
        }
        
        header('Location: index.php');
        die();
    }
}

?>