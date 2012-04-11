            <div id="content">
{if isset($fmbDisplaySearch) and $fmbDisplaySearch == t}
                <div class="research">
                    <h2>Search</h2>
                    <form method="get" action="index.php">
                        <p>
                            <input type="hidden" name="page" value="posts"/>
                            <input name="q" class="formfield" size="10" maxlength="60" value="{$fmbSearch}"/>
                            <input value="Go!" class="formbutton" type="submit" />
                        </p>
                        <p>
{if isset($fmbSearchResultsCnt)}
{if $fmbSearchResultsCnt > 0}
{if $fmbSearchResultsCnt == 1}
                            1 result.
{else}
                            {$fmbSearchResultsCnt} results.
{/if}
{else}
                            No result.
{/if}
{/if}
                        </p>
                    </form>
                </div>
{/if}
{foreach from=$fmbPosts item=post}
{$post.contents}
{/foreach}
{if isset($fmbComments) and $fmbComments != ""}
{$fmbComments}
{/if}
{if isset($fmbCommentForm) and $fmbCommentForm != ""}
{$fmbCommentForm}
{/if}
                <div class="top">
                    <p>
                        <a href="#nav" title="Top of page">
                            Top of page
                        </a>
                    </p>
                </div>
            </div>
