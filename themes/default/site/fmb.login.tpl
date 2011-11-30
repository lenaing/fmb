            <div id="content">
                <h3>Connexion</h3>
{if isset($fmbRequest.login) and ($fmbRequest.login == "")}
                <div class="warning">Veuillez entrer un login.</div>
{/if}
{if isset($fmbRequest.password) and ($fmbRequest.password == "")}
                <div class="warning">Veuillez entrer un mot de passe.</div>
{/if}
{if isset($fmbLoginError)}
                <div class="error">Mauvais login ou mot de passe.</div>
{/if}
                <form method="post" action="login.php" >
                    <fieldset>
                        <div class="labels">
                            <p><label for="login">Login :</label></p>
                            <p><label for="password">Mot de passe :</label></p>
                        </div>
                        <div class="inputs">
                            <p><input type="text" id="login" name="login" value="{if isset($fmbRequest.login)}{$fmbRequest.login}{/if}"/></p>
                            <p><input type="password" id="password" name="password"/></p>
                        </div>
                        <div class="submit">
                            <input type="submit" value="Se connecter"/>
                            <input type="hidden" name="from" value="{if isset($fmbRequest.from)}{$fmbRequest.from}{/if}"/>
                        </div>
                    </fieldset>
                </form>
            </div>
