            <div id="content">
                <h2>Modifier un billet :</h2>
{if isset($fmbPostModErr) and $fmbPostModErr == t}
                <div class="error">Veuillez s&eacute;lectionner un billet.</div>
{/if}
{if isset($fmbPostModOk)}
{if $fmbPostModOk == t}
                <div class="information">Billet modifi&eacute; avec succ&egrave;.</div>
{else}
                <div class="error">&Eacute;chec lors de la modification du billet.</div>
{/if}
{/if}
                <form action="index.php?part=blog&amp;page=post&amp;action=mod" method="post">
                    <fieldset>
                        <div class='inputs'>
                            <p>
                                <select name="id">
                                    <option value="0">Veuillez s&eacute;lectionner un billet</option>
                                    <option value="0">-</option>
{foreach from=$fmbPosts item=post}
                                    <option value="{$post.post_id}">{$post.post_title|stripslashes|substr:0:14}... ({$post.post_time|date_format:"%d/%m/%Y %T"})</option>
{/foreach}
                                </select>
                            </p>
                        </div>
                        <div class='submit'>
                            <input type="submit" value="Modifier" />
                            <input type="hidden" name="actionDB" value="modPost" />
                        </div>
                    </fieldset>
                </form>
            </div>
