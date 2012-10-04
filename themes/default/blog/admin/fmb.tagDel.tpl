            <div id="content">
                <h2>Supprimer un tag :</h2>
{if isset($fmbTagDelErr) and $fmbTagDelErr == t}
                <div class="error">Veuillez s&eacute;lectionner un tag.</div>
{/if}
{if isset($fmbTagDelOk)}
{if $fmbTagDelOk == t}
                <div class="information">Tag supprim&eacute; avec succ&egrave;s.</div>
{else}
                <div class="error">&Eacute;chec lors de la suppression du tag.</div>
{/if}
{/if}
                <form action="index.php?part=blog&amp;page=tag&amp;action=del" method="post">
                    <fieldset>
                        <div class="inputs">
                            <p>
                                <select name="id">
                                    <option value="0">Veuillez s&eacute;lectionner un tag</option>
                                    <option value="0">-</option>
{foreach from=$fmbTags item=tag}
                                    <option value="{$tag.tag_id}">{$tag.tag_title|stripslashes} ({$tag.tag_desc|stripslashes})</option>
{/foreach}
                                </select>
                            </p>
                        </div>
                        <div class="submit">
                            <input type="submit" value="Supprimer" />
                            <input type="hidden" name="actionDB" value="delTag" />
                        </div>
                    </fieldset>
                </form>
            </div>
