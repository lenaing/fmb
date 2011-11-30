            <div id="content">
{if isset($fmbDisplaySearch) and $fmbDisplaySearch == t}
                <div class="research">
                    <h2>Recherche</h2>
                    <form method="get" action="index.php">
                        <p>
                            <input type="hidden" name="page" value="posts"/>
                            <input name="q" class="formfield" size="10" maxlength="60" value="{$fmbSearch}"/>
                            <input value="Go!" class="formbutton" type="submit" />
                        </p>
                        <p>
{if isset($fmbSearchResultsCnt)}
{if $fmbSearchResultsCnt > 0}
{if $fmbSearchResultsCnt == 1}
                            1 r&eacute;sultat.
{else}
                            {$fmbSearchResultsCnt} r&eacute;sultats.
{/if}
{else}
                            Pas de r&eacute;sultats.
{/if}
{/if}
                        </p>
                    </form>
                </div>
{/if}
                <div class="date"><h2>Pas de billet</h2></div>
                <p>D&eacute;sol&eacute;, aucun billet trouv&eacute;.</p>
                <p>Raison : {$fmbNoPostCause}</p>
            </div>
