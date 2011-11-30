            <div id="content">
                <h3>D&eacute;sinscription</h3>
                <div class="warning">Attention! La d&eacute;sinscription est irr&eacute;versible!</div>
{if isset($fmbRequest.password) and ($fmbRequest.password == "")}
                <div class="warning">Veuillez entrer un mot de passe.</div>
{/if}
{if isset($fmbNoSuchMemberError)}
                <div class="error">Login inconnu.</div>
{/if}
{if isset($fmbUnsubscribeError)}
                <div class="error">Erreur lors de la d&eacute;sinscription.</div>
{/if}
                <form method="post" action="subscribe.php?action=unsubscribe" >
                    <fieldset>
                        <div class="labels">
                            <label for="password">Mot de passe :</label>
                        </div>
                        <div class="inputs">
                            <input type="password" id="password" name="password" />
                        </div>
                        <div class="submit">
                            <input type="submit" value="Se d&eacute;sinscrire" />
                            <input type="hidden" name="from" value="{$fmbRequest.from}" />
                        </div>
                    </fieldset>
                </form>
            </div>
