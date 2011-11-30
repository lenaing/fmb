                <div id="comment-form">
                    <h3>Ajoutez votre commentaire!</h3>
{if isset($fmbCommentOk) && $fmbCommentOk == t}
                    <div class="information">
                        Votre commentaire a bien &eacute;t&eacute; enregistr&eacute;.
                    </div>
{elseif isset($fmbCommentOk) && $fmbCommentOk == f}
                    <div class="warning">
                        Il y a eu une erreur lors de l'inscription de votre commentaire. Veuillez contacter le propri&eacute;taire du site.
                    </div>
{/if}
                    <form method="post" action="#comment-form">
{if isset($fmbCommentNameError) && $fmbCommentNameError == t}
                        <div class="error">Vous devez entrer un nom.</div>
{/if}
{if isset($fmbCommentBodyError) && $fmbCommentBodyError == t}
                        <div class="error">Vous devez entrer un texte.</div>
{/if}
                        <fieldset>
                            <div class="labels">
                                <p><label for="com_name">Nom / Pseudo :</label></p>
                                <p><label for="remember">Retenir mon nom?</label></p>
                                <p><label for="com_mail">Email / Site Web :</label></p>
                            </div>
                            <div class="inputs">
                                <p><input name="com_name" id="com_name" value="{if isset($fmbUserLogin)}{$fmbUserLogin}{/if}" /></p>
                                <p><input name="remember" id="remember" type="checkbox" /></p>
                                <p><input name="com_mail" id="com_mail" /></p>
                            </div>
                            <div class="comment-body">
                                <p><label for="com_body">Votre commentaire :</label></p>
                                <p><textarea name="com_body" id="com_body" rows="3" cols="10">{if isset($smarty.post.com_body) and isset($fmbCommentOk) and !$fmbCommentOk == t}{$smarty.post.com_body}{/if}</textarea></p>
                            </div>
                            <div class="comment-format">
                                <p>
                                    <strong>Contenu :</strong>
                                </p>
                                <p>
                                    <img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/icons/text_bold.png" alt="Gras" onclick="fmb_code('[b]','[/b]','com_body');"/>
                                    <img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/icons/text_italic.png" alt="Italique" onclick="fmb_code('[i]','[/i]','com_body');"/>
                                    <img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/icons/text_underline.png" alt="Soulign&eacute;" onclick="fmb_code('[u]','[/u]','com_body');"/>
                                    <img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/icons/text_strikethrough.png" alt="Barr&eacute;" onclick="fmb_code('[s]','[/s]','com_body');"/>
                                </p>
                                <p>
                                    <strong>Smilies :</strong>
                                </p>
                                <p>
                                    <img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/smilies/smile.png" alt=":)" onclick="fmb_code(':)','','com_body');"/>
                                    <img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/smilies/sad.png" alt=":(" onclick="fmb_code(':(','','com_body');"/>
                                    <img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/smilies/tongue.png" alt=":P" onclick="fmb_code(':P','','com_body');"/>
                                </p>
                            </div>
                            <div class="submit">
                                <input value="Envoyer votre commentaire" type="submit" />
                            </div>
                            <input type="hidden" name="user_id" value="{if isset($fmbUserID)}{$fmbUserID}{/if}"/>
                            <input type="hidden" name="action" value="addComment"/>
                            <input type="hidden" name="post_id" value="{$fmbPostID}"/>
                        </fieldset>
                    </form>
                </div>
