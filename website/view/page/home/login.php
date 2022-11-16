<!--

    ETML
    Author          : Serghei Diulgherov
    Date            : 11.10.2022
    Descriptiopn    : Login page

-->

<div class="login-page flex-center">
    <div class="login-container">
        <div class="login-left-area">
            <div class="login-img-overlay">
                <h3>Bienvenue sur</h3>
                <h1>GETS!</h1>
                <p>Bienvenue sur Geste Élèves Ticketing System</p>
            </div>
        </div>
        <div class="login-right-area flex-center">
            <h2>Log In</h2>
            <form class="flex-center" id="login-form" method="post" action="index.php?controller=home&action=connect">
                <input type="text" placeholder="Nom d'utilisateur" autocomplete="off" name="username" required>
                <input type="password" placeholder="Mot de Passe" name="password" required>
                <button type="submit">Log In</button>
            </form>
        </div>
    </div>
    <p>Copyright © Serghei Diulgherov - BnoppSoftware. All rights reserved.</p>
</div>
