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
                <!--div class="checkbox">
                    <input type="checkbox" id="check7" name="stayConnected" class="check"/>
                    <label for="check7" class="label">
                    <svg viewBox="0 0 100 100" height="50" width="50">
                        <rect x="30" y="20" width="50" height="50" stroke="black" fill="none" />
                        <g transform="translate(0,-952.36218)">
                        <path d="m 13,983 c 33,6 40,26 55,48 " stroke="white" stroke-width="3" class="path1" fill="none" />
                        <path d="M 75,970 C 51,981 34,1014 25,1031 " stroke="white" stroke-width="3" class="path1" fill="none" />
                        </g>
                    </svg>
                    <span>Rester Connecté</span>
                    </label>
                </div-->
                <button type="submit">Log In</button>
            </form>
        </div>
    </div>
    <p>Copyright © Serghei Diulgherov - BnoppSoftware. All rights reserved.</p>
</div>
