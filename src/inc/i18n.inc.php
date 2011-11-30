<?php
/**
 * i18n.inc.php file.
 * This file contains the code making FMB internationalizable (i18nable).
 * @package FMB
 * @subpackage Inc
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
 
// Set default locale
$locale = "en_US";

// Get locale defined in conf.
if (isset($fmbConf['locale'])) {
    $locale = $fmbConf['locale'];
}

// Now, parse user wanted locales.

// Check for browser accept language header.
// Loosely inspired from :
// http://www.thefutureoftheweb.com/blog/use-accept-language-header
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $langs = array();

    /**
     * Compare two languages quality factors.
     * @param int $a First quality factor.
     * @param int $b Second quality factor.
     * @return int -1 (Factor is greater so put element before), 0 (Same factor, 
     *                retains index), 1 (Lower factor, put element after).
     */
    function cmpLang($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a > $b) ? -1 : 1;
    }
    
    // Break up string into pieces (Languages and quality factors).
    $regexp = '/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i';
    preg_match_all($regexp, $_SERVER['HTTP_ACCEPT_LANGUAGE'], $langParse);

    if (count($langParse[1])) {
        // Create a list like : { "en-us" => 0.8, "en" => 0.5 }
        $langs = array_combine($langParse[1], $langParse[4]);

        foreach ($langs as $lang => $val) {
            // Set language gettext ready (en-us => en_US).
            $arr = explode('-', $lang);
            if (count($arr) > 1) {
                unset ($langs[$lang]);
                $lang=$arr[0].'_'.strtoupper($arr[1]);
            }

            // Set default to 1 for any language without quality factor.
            $langs[$lang] = ($val === '') ? 1 : $val;
        }

        // Sort languages by quality factor.
        uasort($langs, 'cmpLang');

        // Check for known translation.
        foreach ($langs as $lang => $junk) {
            if (file_exists(FMB_PATH.'/locale/'.$lang.'/LC_MESSAGES/FMB.mo')) {
                $locale = $lang;
                break;
            }
        }
    }
}

// Check for 'locale' parameter in URL.
if (isset($_GET['locale'])) {
    $lang = $_GET['locale'];

    // Check for known translation.
    if (file_exists(FMB_PATH.'/locale/'.$lang.'/LC_MESSAGES/FMB.mo')) {
        $locale = $lang;
    }
}

// Init locale engine.
putenv('LC_ALL='.$locale);
setlocale(LC_ALL, $locale);
bindtextdomain('FMB', FMB_PATH.'/locale');
textdomain('FMB');
?>
