            <div id="sidebar">
                <ul>
                    <li>
                        <h2>Navigation</h2>
                        <ul>
                            <li><a href="index.php">Aujourd'hui</a></li>
                            <li><a href="index.php?page=archives">Archives</a></li>
                            <li>&nbsp;</li>
{if $fmbIsLogged}
                            <li><a href="{$fmbSiteUrl}login.php?action=logout&amp;from=blog">D&eacute;connexion</a></li>
                            <li><a href="{$fmbSiteUrl}subscribe.php?action=unsubscribe&amp;from=blog">D&eacute;sinscription</a></li>
{else}
                            <li><a href="{$fmbSiteUrl}login.php?from=blog">Connexion</a></li>
                            <li><a href="{$fmbSiteUrl}subscribe.php?from=blog">Inscription</a></li>
{/if}
{if $fmbIsAdmin}
                            <li>&nbsp;</li>
                            <li><a href="admin/index.php">Administration</a></li>
{/if}
                        </ul>
                    </li>
                    <li>    
                        <h2>Cat&eacute;gories</h2>
                        <ul>
{foreach from=$fmbBlogCategories item=category}
                            <li><a href="index.php?page=posts&amp;cat={$category.cat_id}" title="{$category.cat_desc}">{$category.cat_title}</a></li>
{/foreach}
                        </ul>
                    </li>
                    <li>
                        <h2>Recherche</h2>
                        <form method="get" action="index.php">
                            <p>
                                <input type="hidden" name="page" value="posts"/>
                                <input name="q" value="" size="13"/>
                                <input value="Go!" type="submit" />
                            </p>
                        </form>
                    </li>
                    <li>
{$fmbBlogLinks}
                    </li>
                    <li>
                        <h2>Validations</h2>
                        <p>
                            <a href="http://validator.w3.org/check?uri=referer"><img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/xhtml.png" alt="Valide XHTML 1.0 Strict." height="31" width="88"/></a>
                            <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/css.png" alt="Valide CSS." height="31" width="88"/></a>
                        </p>
                    </li>
                </ul>
            </div>

