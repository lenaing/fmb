            <div id="content">
                <h2>
{if isset($fmbAction) and $fmbAction == "add"}
                    Ajouter une cat&eacute;gorie
{assign var=submit value='Ajouter'}
{else}
                    Modifier une cat&eacute;gorie
{assign var=submit value='Modifier'}
{/if}
                </h2>
{if isset($fmbCatUpdOk)}
{if $fmbCatUpdOk == 1}
                <div class="error">Veuillez remplir tous les champs marqu&eacute;s d'une &eacute;toile.</div>
{elseif $fmbCatUpdOk == 2}
                <div class="error">
{if isset($fmbAction) and $fmbAction == "add"}
                    Erreur lors de l'ajout de la cat&eacute;gorie.
{else}
                    Erreur lors de la modification de la cat&eacute;gorie.
{/if}
                </div>
{/if}
{if $fmbCatUpdOk == 0}
                <div class="information">
{if isset($fmbAction) and $fmbAction == "add"}
                    Cat&eacute;gorie ajout&eacute;e avec succ&egrave;s.
{else}
                    Cat&eacute;gorie modifi&eacute;e avec succ&egrave;s.
{/if}
                </div>
{/if}
{/if}
                <form action="index.php?part=blog&amp;page=cat&amp;action={$fmbAction}" method="post">
                    <fieldset>
                        <div class="labels">
                            <p><label for="title">* Titre :</label></p>
                            <p><label for="desc">* Description :</label></p>
                        </div>
                        <div class="inputs">
                            <p><input id="title" name="title" value="{if isset($fmbCategory.cat_title)}{$fmbCategory.cat_title|stripslashes}{/if}" /></p>
                            <p><input id="desc" name="desc" value="{if isset($fmbCategory.cat_desc)}{$fmbCategory.cat_desc|stripslashes}{/if}" /></p>
                        </div>
                        <div class="submit">
                            <input type="submit" value="{$submit}" />
                            <input type="hidden" name="actionDB" value="{$fmbAction}Category" />
{if isset($fmbAction) and $fmbAction != "add"}
                            <input type="hidden" name="id" value="{$fmbCategory.cat_id}" />
{/if}
                        </div>
                    </fieldset>
                </form>
            </div>
