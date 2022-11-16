<?php

/**
 * ETML
 * @author      : Serghei Diulgherov
 * Date         : 16.11.2022
 * Description  : WebPage header
 * 
 * @copyright 2022 - ETML - Serghei Diulgherov
 */
?>

<div class="dashboard-page flex-center">
    <header class="menu-bar">
        <div class="title-text">
            <h3>GETS</h3>
            <span class="vertical-separator"></span>
            <h3>Bienvenue, <?=$_SESSION['firstName']?></h3>
        </div>
        
        <a class="button" href="index.php?controller=home&action=logout">Logout</a>
    </header>
</div>
