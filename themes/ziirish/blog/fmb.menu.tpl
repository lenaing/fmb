            <div id="sidebar">
                <ul>
                    <li>
                        <h2>Navigation</h2>
                        <ul>
                            <li><a href="{$fmbBlogUrl}">Today</a></li>
{if isset($extNiceURL) and $extNiceURL == t}
                            <li><a href="archives.html">Archives</a></li>
{else}
                            <li><a href="index.php?page=archives">Archives</a></li>
{/if}
                            <li>&nbsp;</li>
{if $fmbIsLogged}
{if isset($extNiceURL) and $extNiceURL == t}
                            <li><a href="logout">Logout</a></li>
                            <li><a href="unsubscribe">Unsubscribe</a></li>
{else}
                            <li><a href="login.php?action=logout&amp;from=blog">Logout</a></li>
                            <li><a href="subscribe.php?action=unsubscribe&amp;from=blog">Unsubscribe</a></li>
{/if}
{else}
{if isset($extNiceURL) and $extNiceURL == t}
                            <li><a href="login">Login</a></li>
                            <li><a href="subscribe">Subscribe</a></li>
{else}
                            <li><a href="login.php?from=blog">Login</a></li>
                            <li><a href="subscribe.php?from=blog">Subscribe</a></li>
{/if}
{/if}
{if $fmbIsAdmin}
                            <li>&nbsp;</li>
                            <li><a href="admin/index.php">Administration</a></li>
{/if}
                        </ul>
                    </li>
                    <li>
                        <h2>Categories</h2>
                        <ul>
{foreach from=$fmbBlogCategories item=category}
{if isset($extNiceURL) and $extNiceURL == t}
                            <li><a href="cat-{$category.cat_id}-{$category.cat_title|niceurl}.html" title="{$category.cat_desc}">{$category.cat_title}</a></li>
{else}
                            <li><a href="index.php?page=posts&amp;cat={$category.cat_id}" title="{$category.cat_desc}">{$category.cat_title}</a></li>
{/if}
{/foreach}
                        </ul>
                    </li>
                    <li>
                        <h2>Search</h2>
                        <form method="get" action="index.php">
                            <p>
                                <input type="hidden" name="page" value="posts"/>
                                <input name="q" value="" size="13"/>
                                <input value="Go!" type="submit" />
                            </p>
                        </form>
                    </li>
{if isset($extMenu)}
{foreach from=$extMenu item=ext}
{$ext}
{/foreach}
{/if}
                    <li>
                        <h2>Validations</h2>
                        <ul>
                            <li><a href="http://validator.w3.org/check?uri=referer"><img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/xhtml.png" alt="Valid XHTML 1.0 Strict." height="31" width="88"/></a></li>
                            <li><a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/css.png" alt="Valid CSS." height="31" width="88"/></a></li>
                            <li><a href='http://ipv6-test.com/validate.php?url=referer'><img src='{$fmbTemplatesUrl}{$fmbStyle}/blog/images/button-ipv6-small.png' alt='ipv6 ready' title='ipv6 ready' height="31" width="88" /></a></li>
                        </ul>
                    </li>
                    <li>
                        <h2>License</h2>
                        <ul>
                            <li><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Creative Commons License" src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/cc-by-nc-sa-big.png" /></a></li>
                        </ul>
                    </li>
<!--
                    <li>
                        <h2>Feeds</h2>
                        <ul>
                            <li><a href="rss.php?type=posts" class="rss">&nbsp;&nbsp;&nbsp;Billets</a></li>
                            <li><a href="rss.php?type=comments" class="rss" >&nbsp;&nbsp;&nbsp;Commentaires</a></li>
                        </ul>
                    </li>
-->
                </ul>
            </div>

