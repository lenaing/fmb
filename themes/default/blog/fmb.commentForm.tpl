                <div id="comment-form">
                    <h3>Add your comment!</h3>
{if isset($fmbCommentOk) && $fmbCommentOk == t}
                    <div class="information">
                        Your comment has been successfully registered.
                    </div>
{elseif isset($fmbCommentOk) && $fmbCommentOk == f}
                    <div class="warning">
                        An error occured while registering your comment. Please contact the website owner.
                    </div>
{/if}
                    <form method="post" action="#comment-form">
{if isset($fmbCommentUIDError) && $fmbCommentUIDError == t}
                        <div class="error">Invalid user ID.</div>
{/if}
{if isset($fmbCommentBodyError) && $fmbCommentBodyError == t}
                        <div class="error">You must enter a comment.</div>
{/if}
                        <fieldset>
                            <div class="labels">
                                <p><label for="com_name">Name / Nickname:</label></p>
                                <p><label for="remember">Remember my name?</label></p>
                                <p><label for="com_mail">Email / Website:</label></p>
                            </div>
                            <div class="inputs">
                                <p><input name="com_name" id="com_name" value="{if isset($fmbUserLogin)}{$fmbUserLogin}{/if}" /></p>
                                <p><input name="remember" id="remember" type="checkbox" /></p>
                                <p><input name="com_mail" id="com_mail" /></p>
                            </div>
                            <div class="comment-body">
                                <p><label for="com_body">Your comment:</label></p>
                                <p><textarea name="com_body" id="com_body" rows="3" cols="10">{if isset($smarty.post.com_body) and isset($fmbCommentOk) and !$fmbCommentOk == t}{$smarty.post.com_body}{/if}</textarea></p>
                            </div>
                            <div class="comment-format">
                                <p>
                                    <strong>Content :</strong>
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
                                <input value="Send your comment" type="submit" />
                            </div>
                            <input type="hidden" name="user_id" value="{if isset($fmbUserID)}{$fmbUserID}{/if}"/>
                            <input type="hidden" name="action" value="addComment"/>
                            <input type="hidden" name="post_id" value="{$fmbPostID}"/>
                        </fieldset>
                    </form>
                </div>
