{if isset($fmbPageNum) and $fmbPageNum != 0}
{assign var="lastPage" value=$fmbPageNum-1}
{assign var="nextPage" value=$fmbPageNum+1}
{else}
{assign var="lastPage" value=-1}
{assign var="nextPage" value=1}
{/if}
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
                <br />
                <div class="top">
                    <p>
                        <a href="#nav" title="Top of page">
                            Top of page
                        </a>
                    </p>
                </div>
                <br />
{if isset($fmbPageNum)}
                <div class="center">
                    <form method="get" action="index.php">
                    <input type="hidden" name="page" value="lastPosts"/>
{if !isset($fmbFirstPage) or $fmbFirstPage != t}
                    <a href="page-{$lastPage}.html" title="Newer posts">
                        « Newer posts
                    </a>
                    &nbsp;|&nbsp;
{/if}
                    Page <input name="pg" size="1" value="{$fmbPageNum}"/> / {$fmbNbPages}
{if !isset($fmbLastPage) or $fmbLastPage != t}
                    &nbsp;|&nbsp;
                    <a href="page-{$nextPage}.html" title="Older posts">
                        Older posts »
                    </a>
{/if}
                    </form>
                </div>
{/if}
            </div>
