<?php
/**
* Class and Function List:
* Function list:
* - dispatch()
* - menuSelected()
* - viewBuild()
* Classes list:
* - MainController
*/
/**
 * ETML
 * @author : Serghei Diulgherov
 * Date: 06.05.2022
 * Recipe Web Site using an MVC model and Object-Oriented Programming
 *
 * @copyright 2022 - ETML - Serghei Diulgherov
 */

$debug = false;

if ($debug)
{
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

date_default_timezone_set('Europe/Zurich');

session_start();

include_once 'controller/Controller.php';
include_once 'controller/HomeController.php';
include_once 'controller/RecipeController.php';

class MainController
{
    /**
     * It checks if the controller is set, if not it sets it to home. Then it calls the menuSelected
     * function and passes the controller to it. Then it calls the viewBuild function and passes the
     * currentLink to it.
     *
     * @return void
     */
    public function dispatch()
    {
        if (!isset($_GET['controller']))
        {
            $_GET['controller'] = 'home';
            $_GET['action'] = 'index';
        }

        $currentLink = $this->menuSelected($_GET['controller']);
        $this->viewBuild($currentLink);
    }

    /**
     * It's a function that takes a page as a parameter and returns a link to that page.
     *
     * @param page      => The page that is currently selected.
     *
     * @return void
     */
    protected function menuSelected($page)
    {
        switch ($_GET['controller'])
        {
            case 'home':
                $link = new HomeController();
            break;
            case 'recipe':
                $link = new RecipeController();
            break;
            default:
                $link = new HomeController();
            break;
        }

        return $link;
    }

    /**
     * It takes the content of the current page and displays it in the default template.
     *
     * @param currentPage   => The page object that is being displayed.
     *
     * @return void
     */
    protected function viewBuild($currentPage)
    {
        $content = $currentPage->display();

        include (dirname(__FILE__) . '/view/head.html');
        include (dirname(__FILE__) . '/view/header.php');
        echo $content;
        include (dirname(__FILE__) . '/view/footer.html');
    }
}

$_controller = new MainController();
$_controller->dispatch();

?>
