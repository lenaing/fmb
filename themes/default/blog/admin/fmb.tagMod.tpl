            <div id="content">
                <h2>Modifier un tag :</h2>
{if isset($fmbTagModErr) and $fmbTagModErr == t}
                <div class="error">Veuillez s&eacute;lectionner un tag.</div>
{/if}
{if isset($fmbTagModOk)}
{if $fmbTagModOk == t}
                <div class="information">Tag modifi&eacute; avec succ&eagrave;s.</div>
{else}
                <div class="error">&Eacute;chec lors de la modification du tag.</div>
{/if}
{/if}
                <form action='index.php?part=blog&amp;page=tag&amp;action=mod' method='post'>
                    <fieldset>
                        <div class="inputs">
                            <p>
                                <select name="id">
                                    <option value="0">Veuillez s&eacute;lectionner un tag</option>
                                    <option value="0">-</option>";
{foreach from=$fmbTags item=tag}
                                    <option value="{$tag.tag_id}">{$tag.tag_title|stripslashes} ({$tag.tag_desc|stripslashes})</option>
{/foreach}
                                </select>
                            </p>
                        </div>
                        <div class="submit">
                            <input type="submit" value="Modifier" />
                            <input type="hidden" name="actionDB" value="modTag" />
                        </div>
                    </fieldset>
                </form>
            </div>
