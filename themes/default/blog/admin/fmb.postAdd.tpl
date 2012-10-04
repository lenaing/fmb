            <div id="content">
                <h2>
{if isset($fmbAction) and $fmbAction == "add"}
                    Ajouter un billet
{assign var=submit value='Ajouter'}
{else}
                    Modifier un billet
{assign var=submit value='Modifier'}
{/if}
                </h2>
{if isset($fmbPostUpdOk)}
{if $fmbPostUpdOk == 1}
                <div class="error">Veuillez remplir tous les champs marqu&eacute;s d'une &eacute;toile.</div>
{elseif $fmbPostUpdOk == 3}
                <div class="error">Date ou heure invalide.</div>
{elseif $fmbPostUpdOk == -1}
                <div class="error">
{if $fmbAction == "add"}
                    Erreur lors de l'ajout du billet.
{else}
                    Erreur lors de la modification du billet.
{/if}
                </div>
{/if}
{if $fmbPostUpdOk == 2}
                <div class="information">
{if isset($fmbAction) and $fmbAction == "add"}
                    Billet ajout&eacute; avec succ&eagrave;s.
{else}
                    Billet modifi&eacute; avec succ&eagrave;s.
{/if}
                </div>
{/if}
{/if}
                <form action="index.php?part=blog&amp;page=post&amp;action={$fmbAction}" method="post">
                    <fieldset>
                        <div class='labels'>
                            <p><label for="day">* Date :</label></p>
                            <p><label for="h">à :</label></p>
                            <p><label for="title">* Titre :</label></p>
                        </div>
                        <div class='inputs'>
                            <p><input name="day" value="{$fmbPost.post_time|date_format:"%d"}" size="2" maxlength="2"/> / 
                                <input name="month" value="{$fmbPost.post_time|date_format:"%m"}" size="2" maxlength="2" /> / 
                                <input name="year" value="{$fmbPost.post_time|date_format:"%Y"}" size="4" maxlength="4" /></p>
                            <p><input name="h" value="{$fmbPost.post_time|date_format:"%H"}" size="2" maxlength="2"/> : 
                                <input name="m" value="{$fmbPost.post_time|date_format:"%M"}" size="2" maxlength="2"/> : 
                                <input name="s" value="{$fmbPost.post_time|date_format:"%S"}" size="2" maxlength="2"/></p>
                            <p><input name="title" value="{$fmbPost.post_title|stripslashes}"/></p>
                        </div>
                        <p style='clear:both'><label for="body" >Texte :</label></p>
                        <p><textarea name='body' cols='40' rows='10' id='post_body'>{$fmbPost.post_body|stripslashes}</textarea></p>
                        <p><label for="more">Texte Suppl&eacute;mentaire:</label></p>
                        <p><textarea name='more' cols='40' rows='10' id='post_more'>{$fmbPost.post_more|stripslashes}</textarea></p>
                        <div class='labels'>
                            <p><label for="draft">Brouillon?</label></p>
                            <p><label for="draft">Bloquer les commentaires?</label></p>
                            <p><label for="cat">* Cat&eacute;gorie :</label></p>
                        </div>
                        <div class='inputs'>
                            <p><input type=checkbox name="draft" value="1" {if $fmbPost.post_draft == t}checked="checked"{/if}/></p>
                            <p><input type=checkbox name="closed" value="1" {if $fmbPost.post_closed == t}checked="checked"{/if}/></p>
                            <p>
                                <select name="cat">
                                    <option value="-1">Veuillez s&eacute;lectionner une cat&eacute;gorie</option>
                                    <option value="-1">-</option>
{foreach from=$fmbCategories item=category}
                                    <option value="{$category.cat_id}" {if $category.cat_id == $fmbPost.post_cat}selected="selected"{/if}>{$category.cat_title|stripslashes}</option>
{/foreach}
                                </select>
                            </p>
                        </div>
                        <div class='submit'>
                            <input type="submit" value="{$submit}"/>
                            <input type="hidden" name="actionDB" value="{$fmbAction}Post"/>
{if isset($fmbAction) and $fmbAction != "add"}
                            <input type="hidden" name="id" value="{$fmbPost.post_id}"/>
{/if}
                        </div>
                    </fieldset>
                </form>
            </div>
