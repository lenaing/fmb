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
                <div class="date"><h2>No post</h2></div>
                <p>Sorry, no post found.</p>
                <p>Reason : {$fmbNoPostCause}</p>
            </div>
