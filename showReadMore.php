<?php
/**
 * Loggix_Plugin - Show ReadMore Link
 *
 * @copyright Copyright (C) UP!
 * @author    hijiri
 * @link      http://tkns.homelinux.net/
 * @license   http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @since     2010.04.28
 * @version   10.5.28
 */

$this->plugin->addFilter('permalink-view', 'removeReadMore', 1);
$this->plugin->addFilter('entry-content', 'showReadMore', 10);

function showReadMore($text)
{
    global $targetStartTag, $targetEndTag;

    // SETTING BEGIN
    // Target mark
    $targetStartTag = '<!-- more -->';
    $targetEndTag   = '<!-- /more -->';
    // Link text
    $readText = '続きを読む';
    $hideText = '続きを隠す';
    //$readText = 'Read more';
    //$hideText = 'Return';
    // SETTING END

    // Get string length and position
    $targeSTagLen    = mb_strlen($targetStartTag);
    $targeETagLen    = mb_strlen($targetEndTag);
    $targetSPosition = mb_strpos($text, $targetStartTag);
    $targetEPosition = mb_strpos($text, $targetEndTag);

    // Out of order
    if ($targetEPosition <= $targetSPosition) {
        $targetSPosition = FALSE;
    // No contents
    } elseif (($targetEPosition - $targeETagLen) == $targetSPosition){
        $targetSPosition = FALSE;
    // Found two or more
    } elseif (mb_strpos($text, $targetStartTag, $targetSPosition + $targeSTagLen) || mb_strpos($text, $targetEndTag, $targetEPosition + $targeETagLen)) {
        $targetSPosition = FALSE;
    }

    if ($targetSPosition && $targetEPosition) {
        // Get ID (debug... NOT A GOOD IDEA)
        $item = debug_backtrace();
        $id   = $item['3']['args']['0']['id'];

        // Markup
        $readLink  = '<script type="text/javascript">writeReadMoreLink(\'' . $id . '\', \'' . $readText . '\', \'' . $hideText . '\');</script>';
        $readLink .= '<noscript><p class="read-more"><a href="./index.php?id=' . $id . '" title="ID ' . $id . ':' . $readText . '" class="showlink">' . $readText . '</a></p></noscript>';
        $readLink .= '<div id="targetId' . $id . '" class="toggle">';

        $hideLink  = '<p class="read-more"><a href="javascript:readMoreFunc(\'' . $id . '\', \'' . $readText . '\', \'' . $hideText . '\');" class="hidelink" title="ID ' . $id . ':' . $hideText . '">' . $hideText . '</a></p></div>';

        // Replace
        $text    = mb_ereg_replace($targetStartTag, $readLink, $text);
        $text    = mb_ereg_replace($targetEndTag, $hideLink, $text);
    }

    return $text;
}

function removeReadMore($text)
{
    global $targetStartTag, $targetEndTag;

    $text = mb_ereg_replace('<script type="text/javascript">writeReadMoreLink\(.+\);</script>', '', $text);
    $text = mb_ereg_replace('<noscript><p class="read-more"><a href="\./index.php\?id=[0-9]{1,}" title="ID [0-9]{1,}:.+" class="showlink">.+</a></p></noscript>', '', $text);
    $text = mb_ereg_replace('<div id="targetId[0-9]{1,}" class="toggle">', $targetStartTag, $text);
    $text = mb_ereg_replace('<p class="read-more"><a href="javascript:readMoreFunc\(.+\);" class="hidelink" title="ID [0-9]{1,}:.+">.+</a></p></div>', $targetEndTag, $text);

    return $text;
}
