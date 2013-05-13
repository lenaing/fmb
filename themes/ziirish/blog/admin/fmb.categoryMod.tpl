            <div id="content">
                <h2>Modifier une cat&eacute;gorie :</h2>
{if isset($fmbCatModErr) and $fmbCatModErr == t}
                <div class="error">
                    Veuillez s&eacute;lectionner une cat&eacute;gorie.<br/>
                    Vous ne pouvez pas modifier la cat&eacute;gorie "G&eacute;n&eacute;ral".
                </div>
{/if}
{if isset($fmbCatModOk)}
{if $fmbCatModOk == t}
                <div class="information">Cat&eacute;gorie modifi&eacute;e avec succ&agrave;s.</div>
{else}
                <div class="error">&Eacute;chec lors de la modification de la cat&eacute;gorie.</div>
{/if}
{/if}
                <form action="index.php?part=blog&amp;page=cat&amp;action=mod" method="post">
                    <fieldset>
                        <div class="inputs">
                            <p>
                                <select name="id">
                                    <option value="0">Veuillez s&eacute;lectionner une cat&eacute;gorie</option>
                                    <option value="0">-</option>";
{foreach from=$fmbCategories item=category}
                                    <option value="{$category.cat_id}">{$category.cat_title|stripslashes} ({$category.cat_desc|stripslashes})</option>
{/foreach}
                                </select>
                            </p>
                        </div>
                        <div class="submit">
                            <input type="submit" value="Modifier" />
                            <input type="hidden" name="actionDB" value="modCategory" />
                        <div>
                    </fieldset>
                </form>
            </div>
