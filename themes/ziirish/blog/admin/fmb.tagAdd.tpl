            <div id="content">
                <h2>
{if isset($fmbAction) and $fmbAction == "add"}
                    Ajouter un tag
{assign var=submit value='Ajouter'}
{else}
                    Modifier un tag
{assign var=submit value='Modifier'}
{/if}
                </h2>
{if isset($fmbTagUpdOk)}
{if $fmbTagUpdOk == 1}
                <div class="error">Veuillez remplir tous les champs marqu&eacute;s d'une &eacute;toile.</div>
{elseif $fmbTagUpdOk == 2}
                <div class="error">
{if isset($fmbAction) and $fmbAction == "add"}
                    Erreur lors de l'ajout du tag.
{else}
                    Erreur lors de la modification du tag.
{/if}
                </div>
{/if}
{if $fmbTagUpdOk == 0}
                <div class="information">
{if isset($fmbAction) and $fmbAction == "add"}
                    Tag ajout&eacute; avec succ&egrave;s.
{else}
                    Tag modifi&eacute; avec succ&egrave;s.
{/if}
                </div>
{/if}
{/if}
                <form action="index.php?part=blog&amp;page=tag&amp;action={$fmbAction}" method="post">
                    <fieldset>
                        <div class="labels">
                            <p><label for="title">* Titre :</label></p>
                            <p><label for="desc">* Description :</label></p>
                        </div>
                        <div class="inputs">
                            <p><input id="title" name="title" value="{if isset($fmbTag.tag_title)}{$fmbTag.tag_title|stripslashes}{/if}" /></p>
                            <p><input id="desc" name="desc" value="{if isset($fmbTag.tag_desc)}{$fmbTag.tag_desc|stripslashes}{/if}" /></p>
                        </div>
                        <div class="submit">
                            <input type="submit" value="{$submit}" />
                            <input type="hidden" name="actionDB" value="{$fmbAction}Tag" />
{if isset($fmbAction) and $fmbAction != "add"}
                            <input type="hidden" name="id" value="{$fmbTag.tag_id}" />
{/if}
                        </div>
                    </fieldset>
                </form>
            </div>
