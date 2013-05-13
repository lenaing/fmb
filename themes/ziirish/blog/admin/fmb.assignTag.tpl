            <div id="content">
                <h2>Assigner des tags &agrave; un billet :</h2>
{if isset($fmbTagAssignErr) and $fmbTagAssignErr == t}
                <div class="error">Veuillez s&eacute;lectionner un billet.</div>
{/if}
                <form action="index.php?part=blog&amp;page=tag&amp;action=assign" method="post">
                    <fieldset>
                        <div class="inputs">
                            <p>
                                <select name="id">
                                    <option value="0">Veuillez s&eacute;lectionner un billet</option>
                                    <option value="0">-</option>
{foreach from=$fmbPosts item=post}
                                    <option value="{$post.post_id}">{$post.post_title|stripslashes|substr:0:20}... ({$post.post_time|date_format:"%d/%m/%Y %T"})</option>
{/foreach}
                                </select>
                            </p>
                        </div>
                        <div class="submit">
                            <input type="submit" value="Modifier les tags" />
                            <input type="hidden" name="actionDB" value="assignTag" />
                        </div>
                    </fieldset>
                </form>
            </div>
