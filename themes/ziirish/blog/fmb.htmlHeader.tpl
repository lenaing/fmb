<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>{$fmbTitle} :: {$fmbPageTitle}</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <link rel="icon" type="image/png" href="{$fmbTemplatesUrl}{$fmbStyle}/blog/images/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="{$fmbTemplatesUrl}{$fmbStyle}/blog/css/layout.css" />
        <link rel="stylesheet" type="text/css" href="{$fmbTemplatesUrl}{$fmbStyle}/blog/css/style.css" />
{if isset($fmbRedirect)}
        <meta http-equiv="Refresh" content="2;URL={$fmbRedirect}" />
{/if}
        <script type="text/javascript" src="{$fmbTemplatesUrl}{$fmbStyle}/blog/js/fmb.js"></script>
{if isset($extHTMLHeader)}
{foreach from=$extHTMLHeader item=ext}
{$ext}
{/foreach}
{/if}
{if $fmbIsAdmin}
{if isset($extHTMLHeaderAdmin)}
{foreach from=$extHTMLHeaderAdmin item=ext}
{$ext}
{/foreach}
{/if}
{/if}
    </head>
    <body>
