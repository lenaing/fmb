            <div id="content">
                <div class="post-entry">
                    <h2>Archives</h2>
                    <br/>
                    <div class="date">
{foreach from=$fmbBlogArchives item=archive}
{if !isset($year) or $year != $archive.year}
{if !isset($year) or $year == ""}
{assign var=year value=$archive.year}
                                <h3>{$year}</h3>
                                <ul>
{else}
{assign var=year value=$archive.year}
                                </ul>
                                <br/>
                                <h3>{$year}</h3>
                                <ul>
{/if}
{/if}
{if !isset($month) or $month != $archive.month}
{assign var=month value=$archive.month}
                            <li><a href="index.php?page=posts&amp;y={$archive.year}&amp;m={$archive.month}">{$archive.post_time|date_format:"%B"|utf8_encode}</a></li>
{/if}
                        {/foreach}
                        </ul>
                        <br/>
                    </div>
                </div>
                <div class="top">
                    <p><a href="#nav" title="Haut de la page">Haut de la page</a></p>
                </div>
            </div>
