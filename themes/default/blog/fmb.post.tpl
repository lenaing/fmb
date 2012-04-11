{if isset($fmbPost.nb_comments) and $fmbPost.nb_comments > 0}
{if isset($fmbPost.nb_comments) and $fmbPost.nb_comments == 1}
{assign var="nbComments" value="1 commentaire"}
{else}
{assign var="nbComments" value=$fmbPost.nb_comments|cat:" commentaires"}
{/if}
{else}
{assign var="nbComments" value="Pas de commentaire"}
{/if}
                <div class="post">
                    <div class="post-date">
                        <span class="month">{$fmbPost.post_time|date_format:"%b"|utf8_encode}</span>
                        <span class="day">{$fmbPost.post_time|date_format:"%d"}</span>
                    </div>
                    <div class="post-title">
                        <h2>
                            <a href="index.php?page=post&amp;id={$fmbPost.post_id}">{$fmbPost.post_title|htmlspecialchars}</a>
                        </h2>
                        <div class="post-infos">
{if isset($fmbDisplayMore) and $fmbDisplayMore == t}
                            Par : <a href="{$fmbSiteUrl}member.php?id={$fmbPost.post_mem}">{$fmbPost.mem_login|htmlspecialchars}</a>
{/if}
                            Cat&eacute;gorie : <a href="index.php?page=posts&amp;cat={$fmbPost.post_cat}">{$fmbPost.cat_title|htmlspecialchars}</a>
{if !isset($fmbDisplayMore)}
                            <span class="comments">
                                <a href="index.php?page=post&amp;id={$fmbPost.post_id}#comments">{$nbComments}</a>
                            </span>
{/if}
{if $fmbPost.post_closed == f and isset($fmbDisplayMore) and $fmbDisplayMore == t}
                            <span class="add-comment">
                                <a href="index.php?page=post&amp;id={$fmbPost.post_id}#comment-form">
                                    Ajouter un commentaire
                                </a>
                            </span>
{/if}
{if count($fmbPostTags) > 0}
                            <span class="tags">
                                Tags :
{counter name=cCompt start=0 skip=1 assign=iCnt}
{foreach from=$fmbPostTags item=tag}
{counter name=cCompt}
                                <a href="index.php?page=posts&amp;tag={$tag.tag_id}" title="{$tag.tag_desc|htmlspecialchars}">{$tag.tag_title|htmlspecialchars}</a>
{if $iCnt != count($fmbPostTags)}
                                ,
{/if}
{/foreach}
                            </span>
{/if}
                        </div>
                    </div>
                    <div class="post-entry">
{$fmbPost.post_body}
                    </div>
{if isset($fmbDisplayMore) and $fmbDisplayMore == t}
                    <div class="post-more">
{$fmbPost.post_more}
                    </div>
{elseif $fmbPost.post_more != ""}
                    <a href="index.php?page=post&amp;id={$fmbPost.post_id}">
                        Lire la suite du billet ...
                    </a>
{/if}
                </div>
