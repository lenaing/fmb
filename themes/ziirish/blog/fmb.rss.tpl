<?xml version="1.0" encoding="UTF-8" ?>
{* RSS var initialization. *}
{if $fmb_rss_type == "comments"}
	{assign var='rss_type' value='commentaires'}
	{assign var='rss_last_build_date' value=$fmb_rss_items[0].com_time|date_format:"%a, %d %b %Y %H:%M:%S %z"}
{elseif $fmb_rss_type == "posts"}
	{assign var='rss_type' value='billets'}
	{assign var='rss_last_build_date' value=$fmb_rss_items[0].post_time|date_format:"%a, %d %b %Y %H:%M:%S %z"}
{/if}
<rss version="2.0"
xmlns:content="http://purl.org/rss/1.0/modules/content/"
xmlns:wfw="http://wellformedweb.org/CommentAPI/"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:atom="http://www.w3.org/2005/Atom"
xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
xmlns:slash="http://purl.org/rss/1.0/modules/slash/">
    <channel>
        <title>{$fmbTitle}</title>
        <link>http:{$fmbBlogUrl}</link>
        <atom:link href="http:{$fmbBlogUrl}rss.php?type={$fmb_rss_type}" rel="self" type="application/rss+xml" />
        <language>fr-fr</language>
        <pubDate>{$smarty.now|date_format:"%a, %d %b %Y %H:%M:%S %z"}</pubDate>
        <lastBuildDate>{$rss_last_build_date}</lastBuildDate>
        <description>{$fmbTitle} : Flux des {$rss_type}.</description>
{foreach from=$fmb_rss_items item=item}      
        <item>
{if $fmb_rss_type == "comments"}
            <title>{$item.com_name} : {$item.com_body|stripslashes|truncate:140}</title>
            <description>{$item.com_body|stripslashes}</description>
            <pubDate>{$item.com_time|date_format:"%a, %d %b %Y %H:%M:%S %z"}</pubDate>
{if isset($extNiceURL) and $extNiceURL == t}
            <link>http:{$fmbBlogUrl}post-{$item.post_id}-{$item.post_title|niceurl}.html#{$item.com_id}</link>
            <guid>http:{$fmbBlogUrl}post-{$item.post_id}-{$item.post_title|niceurl}.html#{$item.com_id}</guid>
{else}
            <link>http:{$fmbBlogUrl}index.php?page=post&amp;id={$item.post_id}#{$item.com_id}</link>
            <guid>http:{$fmbBlogUrl}index.php?page=post&amp;id={$item.post_id}#{$item.com_id}</guid>
{/if}
{else if $fmb_rss_type == "posts"}
            <title>{$item.mem_login} : {$item.post_title|stripslashes}</title>
            <pubDate>{$item.post_time|date_format:"%a, %d %b %Y %H:%M:%S %z"}</pubDate>
{if isset($extNiceURL) and $extNiceURL == t}
            <link>http:{$fmbBlogUrl}post-{$item.post_id}-{$item.post_title|niceurl}.html</link>
            <guid>http:{$fmbBlogUrl}post-{$item.post_id}-{$item.post_title|niceurl}.html</guid>
{else}
            <link>http:{$fmbBlogUrl}index.php?page=post&amp;id={$item.post_id}</link>
            <guid>http:{$fmbBlogUrl}index.php?page=post&amp;id={$item.post_id}</guid>
{/if}
	    <description>{$item.post_body}</description>
{/if}{* End if $fmb_rss_type. *}
        </item>
{/foreach}{* End foreach $osgm_rss_items. *}
    </channel>
</rss>   
