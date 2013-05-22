                <div id="comments">
                    <h3>Comments</h3>
{foreach from=$fmbPostComments item=comment}
                    <div class="comment-{cycle values="odd,even"}">
                        <h4>
                            <a name="{$comment.com_id}"></a>
{if $comment.com_mem > 0}
{if isset($extNiceURL) and $extNiceURL == t}
                            <a href="member-{$comment.com_mem}-{$comment.com_name|niceurl}.html">#</a>{$comment.com_name}
{else}
                            <a href="member.php?id={$comment.com_mem}">#</a>{$comment.com_name}
{/if}
{elseif substr($comment.com_mail,0,4) == "http"}
                            <a href="{$comment.com_mail}">{$comment.com_name}</a>
{elseif $comment.com_mail != ""}
                            <a href="mailto:{$comment.com_mail}">{$comment.com_name}</a>
{else}
                            {$comment.com_name}
{/if}
                            wrote :
                        </h4>
                        <div class="comment-body">{$comment.com_body}</div>
                        <div class="comment-info">Sent on {$comment.com_time|date_format:"%d %B %Y"} at {$comment.com_time|date_format:"%T"}</div>
                    </div>
{/foreach}
                </div>
