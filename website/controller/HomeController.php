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

}