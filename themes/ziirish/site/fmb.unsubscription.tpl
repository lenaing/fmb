            <div id="content">
                <h3>Unsubscribe</h3>
                <div class="warning">Warning! Unsubscribtion is irreversible!</div>
{if isset($fmbRequest.password) and ($fmbRequest.password == "")}
                <div class="warning">Please enter a password.</div>
{/if}
{if isset($fmbNoSuchMemberError)}
                <div class="error">Unknown login.</div>
{/if}
{if isset($fmbUnsubscribeError)}
                <div class="error">Error while unsubscribing.</div>
{/if}
                <form method="post" action="subscribe.php?action=unsubscribe" >
                    <fieldset>
                        <div class="labels">
                            <label for="password">Password:</label>
                        </div>
                        <div class="inputs">
                            <input type="password" id="password" name="password" />
                        </div>
                        <div class="submit">
                            <input type="submit" value="Unsubscribe" />
                            <input type="hidden" name="from" value="{$fmbRequest.from}" />
                        </div>
                    </fieldset>
                </form>
            </div>
