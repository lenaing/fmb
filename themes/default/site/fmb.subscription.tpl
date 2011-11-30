<div id="content">
    <h3>Inscription</h3>
{if isset($fmbRequest.login) and ($fmbRequest.login == "")}
    <div class="warning">Veuillez entrer un login.</div>
{/if}
{if isset($fmbRequest.password) and ($fmbRequest.password == "")}
    <div class="warning">Veuillez entrer un mot de passe.</div>
{/if}
{if isset($fmbRequest.password_conf) and ($fmbRequest.password_conf == "")}
    <div class="warning">Veuillez confirmer votre mot de passe.</div>
{/if}
{if isset($fmbRequest.password) and isset($fmbRequest.password_conf) and $fmbRequest.password != $fmbRequest.password_conf}
    <div class="error">Les mots de passe ne correspondent pas.</div>
{/if}
{if isset($fmbMemberAlreadyExistsError)}
    <div class="error">Login d&eacute;j&agrave; utilis&eacute;.</div>
{/if}
{if isset($fmbSubscribeError)}
    <div class="error">Erreur lors de l"inscription.</div>
{/if}
    <form method="post" action="subscribe.php" >
        <fieldset>
            <div class="labels">
                <p><label for="login">Login :</label></p>
                <p><label for="password">Mot de passe :</label></p>
                <p><label for="password_conf">Mot de passe (Confirmation):</label></p>
            </div>
            <div class="inputs">
                <p><input type="text" id="login" name="login" value="{if isset($fmbRequest.login)}{$fmbRequest.login}{/if}" /></p>
                <p><input type="password" id="password" name="password" /></p>
                <p><input type="password" id="passwordConf" name="password_conf" /></p>
            </div>
            <div class="submit">
                <input type="submit" value="S'inscrire" />
                <input type="hidden" name="from" value="{if isset($fmbRequest.from)}{$fmbRequest.from}{/if}" />
            </div>
        </fieldset>
    </form>
</div>

