            <div id="content">
                <h3>Subscribe</h3>
            {if isset($fmbRequest.login) and ($fmbRequest.login == "")}
                <div class="warning">Please enter a login.</div>
            {/if}
            {if isset($fmbRequest.password) and ($fmbRequest.password == "")}
                <div class="warning">Please enter a password.</div>
            {/if}
            {if isset($fmbRequest.password_conf) and ($fmbRequest.password_conf == "")}
                <div class="warning">Please confirm your password.</div>
            {/if}
            {if isset($fmbRequest.password) and isset($fmbRequest.password_conf) and $fmbRequest.password != $fmbRequest.password_conf}
                <div class="error">Passwords doesn't match.</div>
            {/if}
            {if isset($fmbMemberAlreadyExistsError)}
                <div class="error">Login already exists.</div>
            {/if}
            {if isset($fmbSubscribeError)}
                <div class="error">Error while subscribing.</div>
            {/if}
                <form method="post" action="subscribe.php" >
                    <fieldset>
                        <div class="labels">
                            <p><label for="login">Login:</label></p>
                            <p><label for="password">Password:</label></p>
                            <p><label for="password_conf">Password (Confirm):</label></p>
                        </div>
                        <div class="inputs">
                            <p><input type="text" id="login" name="login" value="{if isset($fmbRequest.login)}{$fmbRequest.login}{/if}" /></p>
                            <p><input type="password" id="password" name="password" /></p>
                            <p><input type="password" id="passwordConf" name="password_conf" /></p>
                        </div>
                        <div class="submit">
                            <input type="submit" value="Subscribe" />
                            <input type="hidden" name="from" value="{if isset($fmbRequest.from)}{$fmbRequest.from}{/if}" />
                        </div>
                    </fieldset>
                </form>
            </div>

