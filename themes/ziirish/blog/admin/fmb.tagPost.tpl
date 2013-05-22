            <div id="content">
                <h2>Assigner des tags à un billet :</h2>
{if isset($fmbTagAssignOk)}
{if $fmbTagAssignOk == t}
                <div class="information">Tags du billet modifiés avec succès.</div>
{else}
                <div class="error">Échec lors de la modification des tags.</div>
{/if}
{/if}
                <p>Tags actuellement assignés au billet <strong>'{$fmbPost.post_title}'</strong> :</p>
                <form action="index.php?part=blog&amp;page=tag&amp;action=assign" method="post">
                    <fieldset>
                        <div class="inputs">
                            <p>
                                <select name="tags[]" multiple="multiple">
                                    <option value="-1" {if count($fmbPostTags) == 0}selected="selected"{/if}>Aucun</option>
{foreach from=$fmbTags item=tag}
                                    <option value="{$tag.tag_id}" {if array_search($tag.tag_id, $fmbPostTags) !== false}selected="selected"{/if}>{$tag.tag_title|stripslashes} ({$tag.tag_desc|stripslashes})</option>
{/foreach}
                                </select>
                            </p>
                        </div>
                        <div class="submit">
                            <input type="submit" value="Modifier les tags"/>
                            <input type="hidden" name="id" value="{$fmbPost.post_id}"/>
                            <input type="hidden" name="actionDB" value="assignTagToPost"/>
                        </div>
                    </fieldset>
                </form>
            </div>
