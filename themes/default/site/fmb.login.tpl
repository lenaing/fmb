            <div id="content">
                <h3>Login</h3>
{if isset($fmbRequest.login) and ($fmbRequest.login == "")}
                <div class="warning">Please enter a login.</div>
{/if}
{if isset($fmbRequest.password) and ($fmbRequest.password == "")}
                <div class="warning">Please enter a password.</div>
{/if}
{if isset($fmbLoginError)}
                <div class="error">Wrong login or password.</div>
{/if}
                <form method="post" action="login.php" >
                    <fieldset>
                        <div class="labels">
                            <p><label for="login">Login:</label></p>
                            <p><label for="password">Password:</label></p>
                        </div>
                        <div class="inputs">
                            <p><input type="text" id="login" name="login" value="{if isset($fmbRequest.login)}{$fmbRequest.login}{/if}"/></p>
                            <p><input type="password" id="password" name="password"/></p>
                        </div>
                        <div class="submit">
                            <input type="submit" value="Login"/>
                            <input type="hidden" name="from" value="{if isset($fmbRequest.from)}{$fmbRequest.from}{/if}"/>
                        </div>
                    </fieldset>
                </form>
            </div>
