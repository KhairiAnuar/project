<?php

require_once 'track.php';
require_once 'assets/savePage/simple_html_dom.php';

//$contentonly = isset($_POST['content']) ? true : false;
//$keepjs = isset($_POST['javascript']) ? true : false;
//$compress = isset($_POST['compress']) ? true : false;
//var_dump($summary);
$contentonly = true;
$allContent=false;
$keepjs = false;
$compress = true;
# include the class
require 'assets/savePage/htmlSaveComplete.php';

$htmlSaveComplete = new htmlSaveComplete($url);
$originhtml=$htmlSaveComplete->getCompletePage($keepjs, $allContent, $compress);
$html = $htmlSaveComplete->getCompletePage($keepjs, $contentonly, $compress);
$outhtml = str_get_html($html);
$orihtml= str_get_html($originhtml);
if (strpos( $url, 'wiki')) {


   // $headContent=$outhtml->find('#content h1',0);

    if ($outhtml->find('div[class=mw-parser-output]',0)){
       // $outhtml->find('div[class=mw-parser-output]',0)->innertext='<div class="summaryText"></div>';
        foreach($outhtml->find('div[id=bodyContent] a') as $links){
            $links->outertext='';
        }
        $outhtml->find('#siteSub',0)->outertext='';
        foreach ($outhtml->find('div[class=mw-parser-output] p') as $p){
            $p->innertext='';
        }
        foreach ( $outhtml->find('div[class=mw-parser-output] h2') as $h2) {
            $h2->outertext='';

        }
        foreach ($outhtml->find('div[class=mw-parser-output] h3') as $h3){
            $h3->outertext='';
        }
        $outhtml->find('.printfooter',0)->innertext='';
        foreach ($outhtml->find('#footer')as $footer){
            $footer->innertext='';
        }

        if(!empty($extract->image)) {
            $outhtml->find('div[class=mw-parser-output]', 0)->innertext = '<img src="' . $extract->image . '" width=30% height=auto alt="hero image"><p></p><p>' . implode('</p><p>', $summary) . '</p>';
        }else{
            $outhtml->find('div[class=mw-parser-output]', 0)->innertext = '<p>' . implode('</p><p>', $summary) . '</p>';
        }
        $outhtml->find('#bodyContent',0)->outertext='<div style="width:70%; float:left;">'.$outhtml->find('#bodyContent',0)->outertext.'</div>';
        if($outhtml->find('#content',0)){
            $outhtml->find('#content',0)->innertext .='<div style="width:30%; float:left; padding-top: 50px;   "><h2>Go original page</h2>
                                                                        <button type="button" class="btn btn-primary" onclick="window.location.href = \'origin.html\';" >Switch</button></div>';
        }
        //$body->plaintext .=' ';

    }
}
else if (strpos($url, 'abc')){
    if(!empty($outhtml)){

        if ($outhtml->find('.article.section',0)) {
            $keyPoints = $outhtml->find('.inline-content.wysiwyg.right');
            foreach ($keyPoints as $keyPoint) {
                echo $keyPoint;
            }
            $head = $outhtml->find('.article.section h1', 0);
            foreach ($outhtml->find('.article.section p') as $p) {
                $p->innertext = '';
            }

            foreach ($outhtml->find('.page.section.featured-scroller.featured-scroller-4.dark .inner ol li') as $li) {
                $li->outertext = '';
            }
            foreach ($outhtml->find('.article.section blockquote') as $quote) {
                $quote->outertext = '';
            }

            //  $keyPointDiv='<div class="inline-content wysiwyg right "><div><h2>Key points</h2><ul></ul></div></div>';
            //$heading='<h2>Key Points</h2>';
            // $outhtml->find('.inner',0)->innertext='<h2>Key Points</h2>'.
            if (!empty($extract->image)) {
                $outhtml->find('.article.section', 0)->innertext = '<h1>' . $head . '</h1> <img src="' . $extract->image . '" alt="Hero image"><p></p>'
                    . implode($keyPoints) . '<p>' . implode('</p><p>', $summary) . '</p>';

                $outhtml->find('.article.section h1', 0)->id .= 'skip-to-content-heading';
            }else {
                $outhtml->find('.article.section', 0)->innertext = '<h1>' . $head . '</h1><p></p>'
                    . implode($keyPoints) . '<p>' . implode('</p><p>', $summary) . '</p>';

                $outhtml->find('.article.section h1', 0)->id .= 'skip-to-content-heading';

            }


        }
        if($outhtml->find('.subcolumns',0)){
            $outhtml->find('.subcolumns',0)->innertext .='<div class="c25r sidebar" style="padding-top: 90px;" ><h2>Go Original page</h2>
                                                                        <button type="button" class="btn btn-primary" onclick="window.location.href = \'origin.html\';" >Switch</button></div>';
        }

    }  else echo"outhtml HERE".$outhtml;
        echo 'abc';
}else if(strpos($url,'msn')){
    $indexChk=0;
    $head=$outhtml->find('#maincontent',0);
    $headContent=$head->find('h1',0);

    if ($outhtml->find('div[class=richtext]',0)){
        $outhtml->find('div[class=richtext]',0)->innertext='<div class="summaryText"></div>';

        foreach ($outhtml->find('div[class=richtext] p') as $p){
            $p->outertext='';
        }
        if(!empty($extract->image)){
            $outhtml->find('div[class=richtext]',0)->innertext = "<img src=\"' . $extract->image . '\" alt=\"Hero image\"><p>".implode("</p><p>", $summary)."</p>";
        }
        else {
            $outhtml->find('div[class=richtext]', 0)->innertext = "<p>" . implode("</p><p>", $summary) . "</p>";
        }

    }
} else{
    $headContent=' ';
}
//-------Original html modification
if (strpos( $url, 'wiki')) {


    if ($orihtml->find('#content',0)){
        $outhtml->find('#catlinks',0)->outertext='';

    }
    $orihtml->find('.navbox',0)->outertext='';
    $outhtml->find('#mw-navigation',0)->outertext='';
    if($orihtml->find('#content',0)){
        $orihtml->find('#content',0)->innertext .='<div style="width:30%; float:left; padding-top: 50px;"><h2>Go summarized page</h2>
                                                                        <button type="button" class="btn btn-primary" onclick="window.location.href = \'summarized.html\';" >Switch</button></div>';
    }
}
else if (strpos($url, 'abc')){
    if(!empty($orihtml)){

        if ($orihtml->find('.article.section',0)) {
            $orihtml->find('#header',0)->outertext='';
            $orihtml->find('#nav',0)->outertext='';
            $orihtml->find('.c25r.sidebar',0)->outertext='';
            $orihtml->find('.attached-content',0)->outertext='';
            $orihtml->find('.page.section.featured-scroller.featured-scroller-4.dark',0)->outertext='';
            $orihtml->find('#footer-stories',0)->outertext='';
            $orihtml->find('#footer',0)->outertext='';

            //  $keyPointDiv='<div class="inline-content wysiwyg right "><div><h2>Key points</h2><ul></ul></div></div>';
            //$heading='<h2>Key Points</h2>';
            // $outhtml->find('.inner',0)->innertext='<h2>Key Points</h2>'.
        }
        if($orihtml->find('.subcolumns',0)){
            $orihtml->find('.subcolumns',0)->innertext .='<div class="c25r sidebar" style=" padding-top: 90px;"><h2>Go summarized page</h2>
                                                                        <button type="button" class="btn btn-primary" onclick="window.location.href = \'summarized.html\';" >Switch</button></div>';
        }

    }  else echo"orihtml HERE empty".$orihtml;
    echo 'abc';
}else if(strpos($url,'msn')){
    $indexChk=0;
    $head=$orihtml->find('#maincontent',0);
    $headContent=$head->find('h1',0);

    if ($orihtml->find('div[class=richtext]',0)){
        $orihtml->find('div[class=richtext]',0)->innertext='<div class="summaryText"></div>';

        foreach ($orihtml->find('div[class=richtext] p') as $p){
            $p->outertext='';
        }
        if(!empty($extract->image)){
            $orihtml->find('div[class=richtext]',0)->innertext = "<img src=\"' . $extract->image . '\" alt=\"Hero image\"><p>".implode("</p><p>", $summary)."</p>";
        }
        else {
            $orihtml->find('div[class=richtext]', 0)->innertext = "<p>" . implode("</p><p>", $summary) . "</p>";
        }

    }
} else{
    $headContent=' ';
}








if (!$html) {
    header('LOCATION: index.php?e=' . urlencode('Error saving the page, please try again later.'));
    exit;
}
/*if ($bodyId=='main_content'){
    $head=$html->find('#main_content',0);
    $head->find()
}else if ($bodyId=='main_content'){

}else if($bodyId=='precontent'){


}*/
$orihtml->save('origin.html');
$outhtml->save('summarized.html');
/*file_put_contents('origin.html', $orihtml);
file_put_contents('summarized.html', $outhtml);*/
header('LOCATION: summarized.html');
exit;

