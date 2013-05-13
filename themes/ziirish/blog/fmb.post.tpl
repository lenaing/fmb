{if isset($fmbPost.nb_comments) and $fmbPost.nb_comments > 0}
{if isset($fmbPost.nb_comments) and $fmbPost.nb_comments == 1}
{assign var="nbComments" value="1 comment"}
{else}
{assign var="nbComments" value=$fmbPost.nb_comments|cat:" comments"}
{/if}
{else}
{assign var="nbComments" value="No comment"}
{/if}
                <div class="post">
                    <div class="post-date">
                        <span class="month">{$fmbPost.post_time|date_format:"%b"|utf8_encode}</span>
                        <span class="day">{$fmbPost.post_time|date_format:"%d"}</span>
                        <span class="year">{$fmbPost.post_time|date_format:"%Y"}</span>
                    </div>
                    <div class="post-title">
{if isset($extNiceURL) and $extNiceURL == t}
                        <h2>
                            <a href="post-{$fmbPost.post_id}-{$fmbPost.post_title|niceurl}.html">{$fmbPost.post_title|htmlspecialchars}</a>
                        </h2>
{else}
                        <h2>
                            <a href="index.php?page=post&amp;id={$fmbPost.post_id}">{$fmbPost.post_title|htmlspecialchars}</a>
                        </h2>
{/if}
                        <div class="post-infos">
{if isset($fmbDisplayMore) and $fmbDisplayMore == t}
{if isset($extNiceURL) and $extNiceURL == t}
                            By : <a href="member-{$fmbPost.post_mem}-{$fmbPost.mem_login|niceurl}.html">{$fmbPost.mem_login|htmlspecialchars}</a>
{else}
                            By : <a href="member.php?id={$fmbPost.post_mem}">{$fmbPost.mem_login|htmlspecialchars}</a>
{/if}
{/if}
{if isset($extNiceURL) and $extNiceURL == t}
                            Categories : <a href="cat-{$fmbPost.post_cat}-{$fmbPost.cat_title|niceurl}.html">{$fmbPost.cat_title|htmlspecialchars}</a>
{else}
                            Categories : <a href="index.php?page=posts&amp;cat={$fmbPost.post_cat}">{$fmbPost.cat_title|htmlspecialchars}</a>
{/if}
{if !isset($fmbDisplayMore)}
                            <span class="comments">
{if isset($extNiceURL) and $extNiceURL == t}
                                <a href="post-{$fmbPost.post_id}-{$fmbPost.post_title|niceurl}.html#comments">{$nbComments}</a>
{else}
                                <a href="index.php?page=post&amp;id={$fmbPost.post_id}#comments">{$nbComments}</a>
{/if}
                            </span>
{/if}
{if $fmbPost.post_closed == f and isset($fmbDisplayMore) and $fmbDisplayMore == t}
                            <span class="add-comment">
{if isset($extNiceURL) and $extNiceURL == t}
                                <a href="post-{$fmbPost.post_id}-{$fmbPost.post_title|niceurl}.html#comment-form">
{else}
                                <a href="index.php?page=post&amp;id={$fmbPost.post_id}#comment-form">
{/if}
                                    Add a comment
                                </a>
                            </span>
{/if}
{if count($fmbPostTags) > 0}
                            <span class="tags">
                                Tags :
{counter name=cCompt start=0 skip=1 assign=iCnt}
{foreach from=$fmbPostTags item=tag}
{counter name=cCompt}
{if isset($extNiceURL) and $extNiceURL == t}
                                <a href="tag-{$tag.tag_id}-{$tag.tag_title|niceurl}.html" title="{$tag.tag_desc|htmlspecialchars}">{$tag.tag_title|htmlspecialchars}</a>
{else}
                                <a href="index.php?page=posts&amp;tag={$tag.tag_id}" title="{$tag.tag_desc|htmlspecialchars}">{$tag.tag_title|htmlspecialchars}</a>
{/if}
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
{if !isset($fmbDisplayMore)}
{if isset($extNiceURL) and $extNiceURL == t}
                    <a href="post-{$fmbPost.post_id}-{$fmbPost.post_title|niceurl}.html">
{else}
                    <a href="index.php?page=post&amp;id={$fmbPost.post_id}">
{/if}
                        Read post ...
                    </a>
{/if}
                </div>
