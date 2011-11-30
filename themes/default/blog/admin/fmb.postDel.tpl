            <div id="content">
                <h2>Supprimer un billet :</h2>
{if isset($fmbPostDelErr) and $fmbPostDelErr == t}
                <div class="error">Veuillez s&eacute;lectionner un billet.</div>
{/if}
{if isset($fmbPostDelOk)}
{if $fmbPostDelOk == t}
                <div class="information">Billet supprim&eacute; avec succ&eagrave;s.</div>
{else}
                <div class="error">&Eacute;chec lors de la suppression du billet.</div>
{/if}
{/if}
                <form action="index.php?part=blog&amp;page=post&amp;action=del" method="post">
                    <fieldset>
                        <div class="inputs">
                            <p>
                                <select name="id">
                                    <option value="0">Veuillez s&eacute;lectionner un billet</option>
                                    <option value="0">-</option>
{foreach from=$fmbPosts item=post}
                                    <option value="{$post.post_id}">{$post.post_title|stripslashes|substr:0:14} ({$post.post_time|date_format:"%d/%m/%Y %T"})</option>
{/foreach}
                                </select>
                            </p>
                        </div>
                        <div class="submit">
                            <input type="submit" value="Supprimer" />
                            <input type="hidden" name="actionDB" value="delPost" />
                        </div>
                    </fieldset>
                </form>
            </div>
