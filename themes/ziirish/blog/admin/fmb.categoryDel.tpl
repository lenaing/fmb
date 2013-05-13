            <div id="content">
                <h2>Supprimer une cat&eacute;gorie :</h2>
{if isset($fmbCatDelErr) and $fmbCatDelErr == t}
                <div class="error">
                    Veuillez s&eacute;lectionner une cat&eacute;gorie.<br/>
                    Vous ne pouvez pas supprimer la cat&eacute;gorie "G&eacute;n&eacute;ral".
                </div>
{/if}
{if isset($fmbCatDelOk)}
{if $fmbCatDelOk == t}
                <div class="information">Cat&eacute;gorie supprim&eacute;e avec succ&egrave;s.</div>
{else}
                <div class="error">&Eacute;chec lors de la suppression de la cat&eacute;gorie.</div>
{/if}
{/if}
                <form action="index.php?part=blog&amp;page=cat&amp;action=del" method="post">
                    <fieldset>
                        <div class="inputs">
                            <select name="id">
                                <option value="0">Veuillez s&eacute;lectionner une cat&eacute;gorie</option>
                                <option value="0">-</option>";
{foreach from=$fmbCategories item=category}
                            <option value="{$category.cat_id}">{$category.cat_title|stripslashes} ({$category.cat_desc|stripslashes})</option>
{/foreach}
                            </select>
                        </div>
                        <div class="submit">
                            <input type="submit" value="Supprimer" />
                            <input type="hidden" name="actionDB" value="delCategory" />
                        </div>
                    </fieldset>
                </form>
            </div>
