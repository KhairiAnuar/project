<?php
/**
 * Webpages saved by HtmlSaveComplete.php http://sarfraznawaz.wordpress.com and cURL
 * Web manipulations of summarized webpage and original webpage handle by simple_html_dom.php
 * PHP Simple HTML DOM Parser https://simplehtmldom.sourceforge.io/
 *
**/

# include the files
require_once 'getsummary.php';
require_once 'assets/savePage/simple_html_dom.php';
require 'assets/savePage/htmlSaveComplete.php';

$contentonly = true;
$allContent = false;
$keepjs = false;
$compress = true;

//Remove sentences from array summary that greater than specified number characters
foreach ($summary as $key => $oneSentence) {
    if (strlen($oneSentence) < 30 || strlen($oneSentence) > 220) {
        unset($summary[$key]);
    }
}

function file_get_contents_curl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

//Below removes unrelated sentences or duplicated words
if (strpos($url, 'kidsnews')) {
    foreach ($summary as $key => $oneSentence) {
        if (strpos($oneSentence, 'HAVE YOUR SAY:') !== false) {
            unset($summary[$key]);
        }
        if (strpos($oneSentence, 'VCOP ACTIVITY') !== false) {
            unset($summary[$key]);
        }
        if (strpos($oneSentence, 'Extension Write a') !== false) {
            unset($summary[$key]);
        }
        if (strpos($oneSentence, 'Curriculum Links:') !== false) {
            unset($summary[$key]);
        }
        if (strpos($oneSentence, 'Write a diary entry') !== false) {
            unset($summary[$key]);
        }

    }
    $html = mb_convert_encoding(file_get_contents_curl($url), "HTML-ENTITIES", "UTF-8");
    $sumhtml = str_get_html($html);
    $originhtml = file_get_contents_curl($url);
    $orihtml = str_get_html($originhtml);


} else if (strpos($url, 'wiki')) {
    $htmlSaveComplete = new htmlSaveComplete($url);
    $originhtml = $htmlSaveComplete->getCompletePage($keepjs, $allContent, $compress);
    $html = $htmlSaveComplete->getCompletePage($keepjs, $contentonly, $compress);
    $sumhtml = str_get_html($html);
    $orihtml = str_get_html($originhtml);

} else {
    echo 'Sorry website is not available';
}

//For collapsible div summary toggle
$splitsum1 = array_slice($summary, 0, 3);
$splitsum2 = array_slice($summary, 4, 1);
$splitsum3 = array_slice($summary, 5);

/**
 * Summarized Webpage HTML Modification*
 */

//Summarized Wikipedia webpage
if (strpos($url, 'wiki')) {
    $sumhtml->find('head', 0)->innertext .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    $sumhtml->find('head', 0)->innertext .= '<link rel="stylesheet" href="assets/css/collapse.css">';
    $sumhtml->find('head', 0)->innertext .= '<link rel="stylesheet" type="text/css" href="assets/css/wikipedia.css">';

    $sumhtml->find('head', 0)->innertext .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
    $sumhtml->find('style', 0)->innertext .= '.heroimg{
    max-width: 400px;
    width: 100%;
}';

    if ($sumhtml->find('div[class=mw-parser-output]', 0)) {
        //If hero image available
        if (!empty($extract->image)) {
            $sumhtml->find('div[class=mw-parser-output]', 0)->innertext = '</h1> <img class="heroimg" src="' . $extract->image . '" alt="Hero image"><br><br><p>' . implode('</p><p>', $splitsum1) . '</p><button class="collapsible"><p>' . $splitsum2[0] . '</p></button><div class="content">
                <p>' . implode('</p><p>', $splitsum3) . '</p></div>';

        } else {
            $sumhtml->find('div[class=mw-parser-output]', 0)->innertext = '<br><p>' . implode('</p><p>', $splitsum1) . '</p><button class="collapsible"><p>' . $splitsum2[0] . '</p></button><div class="content">
                <p>' . implode('</p><p>', $splitsum3) . '</p></div>';
        }


        if ($sumhtml->find('body', 0)) {
            $sumhtml->find('body', 0)->outertext = '<div class="container"><div class="row"><div class="col-8">' . $sumhtml->find('#content', 0)->outertext . '</div><div class="col-4"><script type="text/javascript" src="assets/scripts/collapse.js" ></script> <div class="mw-stack clickableBigger" style="padding:100px 50px 100px 50px;cursor:pointer;  box-sizing:border-box;float:right; clear:right;"  onclick="window.location.href = \'origin.html\'">
                                                              <a class="btn btn-secondary btn-lg btnSwitch" style="padding: 1rem 1rem; text-decoration: none" href="origin.html"><h3 style=" color: white;">Go original page</h3></a> 
                                                                </div></div></div></div>';
        }
    }
} //Summarized KidsNews Webpage
else if (strpos($url, 'kidsnews')) {

    if (!empty($sumhtml)) {
        $sumhtml->find('head', 0)->innertext .= '<link rel="stylesheet" href="assets/css/Knews.css"><link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';

        $sumhtml->find('head', 0)->innertext .= '<link rel="stylesheet" href="assets/css/collapse.css">';
        $sumhtml->find('style', 0)->innertext .= '.image{ max-width:930px}';

        if ($sumhtml->find('.header', 0)) {
            $sumhtml->find('.logo', 0)->outertext = '';
            $sumhtml->find('.fixed-nav-container.row', 0)->outertext = '';
            $sumhtml->find('.header', 0)->innertext .= '<script src="assets/scripts/collapse.js" type="text/javascript"></script>';
        }
        if ($sumhtml->find('#single', 0)) {
            $head = $sumhtml->find('.headline', 0);
            $sumhtml->find('#single', 0)->innertext = '<div id="info"><h1>' . $head . '</h1><div class="text-right" onclick="window.location.href = \'origin.html\'">
                                                                       <a class="btn btn-secondary btn-lg btnSwitch" style="padding: 1rem 1rem; margin-bottom:10px; " href="origin.html"><h4 >Go original page</h4></a> 
                                                                        </div> <img class="image" src="' . $extract->image . '" alt="Hero image"></div>';
            $sumhtml->find('.meta', 0)->outertext = '';
            $sumhtml->find('#single', 0)->innertext .= '<div id="story" style="display:block"><p></p>'
                . '<p class="capi-html">' . implode('</p><p class="capi-html">', $splitsum1) . '</p><button class="collapsible"><p class="capi-html">' . $splitsum2[0] . '</p></button><div class="content"><p class="capi-html">
                   ' . implode('</p><p class="capi-html">', $splitsum3) . '</p></div></div>';

        }
        $sumhtml->find('#module-more-in', 0)->outertext = '';
        if ($sumhtml->find('#footer', 0)) {
            $sumhtml->find('#footer', 0)->outertext = '';
        }
        $sumhtml->find('#page', 0)->innertext .= '<script src="assets/scripts/collapse.js" type="text/javascript"></script>';

    } else {
        echo 'Sorry page is empty';
    }
} else {
    echo 'Website specified not applicable to save ';
}

/**
 * Original Webpage HTML Modification
 */

//Wikipedia original webpage
if (strpos($url, 'wiki')) {
    $orihtml->find('head', 0)->innertext .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    $orihtml->find('head', 0)->innertext .= '<link rel="stylesheet" type="text/css" href="assets/css/wikipedia.css">';
    if ($orihtml->find('div[id=mw-navigation]', 0)) {
        $orihtml->find('div[id=mw-head]', 0)->outertext = '';
        foreach ($orihtml->find('div[class=portal]') as $sideMenu) {
            $sideMenu->outertext = '';
        }
    }
    if ($orihtml->find('#content', 0)) {
        $orihtml->find('#catlinks', 0)->outertext = '';
        $orihtml->find('#toc', 0)->outertext = '';

    }
    if ($orihtml->find('.navbox', 0)) {
        $orihtml->find('.navbox', 0)->outertext = '';
        $orihtml->find('#mw-navigation', 0)->outertext = '';
    }
    if ($orihtml->find('#content', 0)) {
        foreach ($orihtml->find('.mw-jump-link') as $brokenJumpLinks) {
            $brokenJumpLinks->outertext = '';
        }
    }

    if ($orihtml->find('#mw-head-base', 0)) {
        $orihtml->find('#mw-head-base', 0)->innertext = '<div class="mw-stack clickableBigger" style="  box-sizing:border-box;float:right; clear:right; "  onclick="window.location.href = \'summarized.html\'">
                                                              <a class="btn btn-secondary btn-lg btnSwitch" style="border-radius: .3rem; text-decoration: none" href="summarized.html"><h4 style="font-size: 100%; color: white;">Go summarized page</h4></a> 
                                                                  </div>';
    }
}   //KidsNews Original webpage
else if (strpos($url, 'kidsnews')) {

    if (!empty($orihtml)) {
        $orihtml->find('head', 0)->innertext .= '<link rel="stylesheet" href="assets/css/Knews.css"><link rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';


        if ($orihtml->find('.header', 0)) {
            $orihtml->find('.logo', 0)->outertext = '';
            $orihtml->find('.fixed-nav-container.row', 0)->outertext = '';
        }
        $orihtml->find('aside[class=rightrail]', 0)->outertext = '';
        if ($orihtml->find('p[class=intro]', 0)) {
            $orihtml->find('p[class=intro]', 0)->outertext = '<div class="text-right" onclick="window.location.href = \'summarized.html\'">
                                                                           <a class="btn btn-secondary btn-lg btnSwitch" style="padding: 1rem 1rem; margin-bottom:10px;" href="summarized.html"><h4 >Go summarized page</h4></a> 
                                                                            </div>';
        }
        foreach ($orihtml->find('.caption') as $caption) {
            $caption->outertext = '';
        }
    }
} else {
    echo ' sorry website not applicable to summarize';
}

if (!$html) {
    header('LOCATION: index.php?e=' . urlencode('Error saving the page, please try again later.'));
    exit;
}

//Saves modified contents into HTML files
$orihtml->save('origin.html');
$sumhtml->save('summarized.html');

//clear memory
$orihtml->clear();
unset($orihtml);
$sumhtml->clear();
unset($sumhtml);


//redirect client to summarized webpage
header('LOCATION: summarized.html');
exit;

