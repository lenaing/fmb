            <div id="sidebar">
                <ul>
                    <li>
                        <h2>Navigation</h2>
                        <ul>
                            <li><a href="index.php">Today</a></li>
                            <li><a href="index.php?page=archives">Archives</a></li>
                            <li>&nbsp;</li>
{if $fmbIsLogged}
                            <li><a href="{$fmbSiteUrl}login.php?action=logout&amp;from=blog">Logout</a></li>
                            <li><a href="{$fmbSiteUrl}subscribe.php?action=unsubscribe&amp;from=blog">Unsubscribe</a></li>
{else}
                            <li><a href="{$fmbSiteUrl}login.php?from=blog">Login</a></li>
                            <li><a href="{$fmbSiteUrl}subscribe.php?from=blog">Subscribe</a></li>
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
                            <li><a href="index.php?page=posts&amp;cat={$category.cat_id}" title="{$category.cat_desc}">{$category.cat_title}</a></li>
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
                    <li>
                        <h2>Validations</h2>
                        <ul>
                            <li><a href="http://validator.w3.org/check?uri=referer"><img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/xhtml.png" alt="Valid XHTML 1.0 Strict." height="31" width="88"/></a></li>
                            <li><a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/css.png" alt="Valid CSS." height="31" width="88"/></a></li>
                        </ul>
                    </li>
                    <li>
                        <h2>License</h2>
                        <ul>
                            <li><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Creative Commons License" src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/cc-by-nc-sa-big.png" /></a></li>
                        </ul>
                    </li>
                </ul>
            </div>

