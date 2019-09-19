<?php
# include the files
require_once 'getsummary.php';
require_once 'assets/savePage/simple_html_dom.php';
require 'assets/savePage/htmlSaveComplete.php';
//$contentonly = isset($_POST['content']) ? true : false;
//$keepjs = isset($_POST['javascript']) ? true : false;
//$compress = isset($_POST['compress']) ? true : false;
//var_dump($summary);
$contentonly = true;
$allContent=false;
$keepjs = false;
$compress = true;
    //Remove sentences from array summary) below specified number characters
    foreach ($summary as $key=>$oneSentence){
        if (strlen($oneSentence)<30 || strlen($oneSentence) >220 ){
            unset($summary[$key]);
        }
/*        $oneSentence= mb_convert_encoding($oneSentence, "HTML-ENTITIES", 'ISO-8859-1');*/
      /*  if(strpos($oneSentence,'â€™')!==false){
                $oneSentence=str_replace('â€™',"'",$oneSentence);
        }*/


    }
function file_get_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
if(strpos($url,'kidsnews')){
        //Below removes unrelated sentences or duplicated words, convert all capitalized characters to lowercase
    foreach($summary as $key => $oneSentence) {

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
        if (strpos($oneSentence, 'male lions was with a female') !== false) {
            unset($summary[$key]);
        }
        if (strpos($oneSentence,'Write a diary entry')!==false){
            unset($summary[$key]);
        }
        if(strpos($oneSentence,'granite monolith')!==false){
            $summary[$key]=str_replace('granite monolith','giant rock',$oneSentence);
            break;
        }
        if(strpos($oneSentence,'ssssssss-urprising')!==false){
            $summary[$key]=str_replace('ssssssss-urprising story of a snake','surprising story of a hungry snake',$oneSentence);
        }
        if(strpos($oneSentence,'He performed surgery')!==false){
            $summary[$key]=str_replace('He performed surgery','Doctor performed surgery',$oneSentence);
            break;
        }
        if(strpos($oneSentence,'SKYDIVING Skydiving')!==false){
            $summary[$key]=str_replace('SKYDIVING Skydiving','Skydiving',$oneSentence);
            break;
        }
        if(strpos($oneSentence,'This is a large body of ice that')!==false){
            $summary[$key]=ucfirst(strtolower($oneSentence));
            $summary[$key]=str_replace('This is a large body of ice that is','is body of ice covering',$oneSentence);
            break;
        }
        if(strpos($oneSentence,'THE LONGEST-LIVING THINGS')!==false){
            $summary[$key]=ucfirst(strtolower($oneSentence));
            $summary[$key]=str_replace('aldabra','Aldabra',$summary[$key]);
            break;
        }

    }
    $html=mb_convert_encoding(file_get_contents_curl($url),"HTML-ENTITIES","UTF-8");
    $sumhtml = str_get_html($html);
    $originhtml=file_get_contents_curl($url);
    $orihtml= str_get_html($originhtml);
    $sumhtml->find('style',0)->innertext .='.image{ max-width:930px}';


} else if(strpos($url,'wiki')||strpos($url,'abc')||strpos($url,'smh')){
    $htmlSaveComplete = new htmlSaveComplete($url);
    $originhtml=$htmlSaveComplete->getCompletePage($keepjs, $allContent, $compress);
    $html = $htmlSaveComplete->getCompletePage($keepjs, $contentonly, $compress);
    $sumhtml = str_get_html($html);
    $orihtml= str_get_html($originhtml);
}else{ echo 'Sorry website is not available';}

$splitsum1=array_slice($summary,0,3);
$splitsum2=array_slice($summary,4,1);
$splitsum3=array_slice($summary,5);



if (strpos( $url, 'wiki')) {
    $sumhtml->find('head',0)->innertext.='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    $sumhtml->find('head',0)->innertext .='<link rel="stylesheet" href="assets/css/collapse.css">';
//    $sumhtml->find('head',0)->innertext .='<link rel="stylesheet" type="text/css" href="assets/css/wikipedia.css">';

    $sumhtml->find('head',0)->innertext .='<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
    // $headContent=$outhtml->find('#content h1',0);
    $sumhtml->find('style',0)->innertext.='.heroimg{
    max-width: 400px;
    width: 100%;
}';
    if ($sumhtml->find('div[id=siteSub]',0)){$sumhtml->find('div[id=siteSub]',0)->outertext='';}
    if ($sumhtml->find('div[class=printfooter]',0)){$sumhtml->find('div[class=printfooter]',0)->outertext='';}


    if ($sumhtml->find('div[class=mw-parser-output]',0)){
       // $sumhtml->find('div[class=mw-parser-output]',0)->innertext='<div class="summaryText"></div>';

        foreach($sumhtml->find('div[id=bodyContent] a') as $links){
            $links->outertext='';
        }

        foreach ($sumhtml->find('div[class=mw-parser-output] p') as $p){
            $p->innertext='';
        }
        foreach ( $sumhtml->find('div[class=mw-parser-output] h2') as $h2) {
            $h2->outertext='';

        }
        foreach ($sumhtml->find('div[class=mw-parser-output] h3') as $h3){
            $h3->outertext='';
        }


        foreach ($sumhtml->find('#footer')as $footer){
            $footer->innertext='';
        }



        if(!empty($extract->image)) {
            $sumhtml->find('div[class=mw-parser-output]', 0)->innertext ='</h1> <img class="heroimg" src="' . $extract->image . '" alt="Hero image"><br><br><p>' . implode('</p><p>', $splitsum1) . '</p><button class="collapsible"><p>'.$splitsum2[0].'</p></button><div class="content">
                <p>'. implode('</p><p>', $splitsum3).'</p></div>';
          /*  $sumhtml->find('div[class=mw-parser-output]', 0)->innertext = '<img class="heroimg" src="' . $extract->image . '" height=auto alt="hero image"><p></p><p>' . implode('</p><p>', $summary) . '</p>';*/
        }else{
            $sumhtml->find('div[class=mw-parser-output]', 0)->innertext = '<br><p>' . implode('</p><p>', $splitsum1) . '</p><button class="collapsible"><p>'.$splitsum2[0].'</p></button><div class="content">
                <p>'. implode('</p><p>', $splitsum3).'</p></div>';
        }

        /*$sumhtml->find('#bodyContent',0)->outertext='<div style="max-width:70%; float:left;">'.$sumhtml->find('#bodyContent',0)->outertext.'</div>';*/
        if($sumhtml->find('body',0)){
            $sumhtml->find('body',0)->outertext='<div class="container"><div class="row"><div class="col-8">'.$sumhtml->find('#content',0)->outertext.'</div><div class="col-4"><script type="text/javascript" src="assets/scripts/collapse.js" ></script> <div class="mw-stack" style="box-sizing:border-box;float:right; clear:right; padding-top:100px;"  onclick="window.location.href = \'origin.html\'">
                                                                  <button class="btn-lg" type="button" style="border-radius:0;"> <a style="color:#0645AD; text-decoration: none" href="origin.html"><h3>Go original page</h3></a> </button>
                                                                  </div></div></div></div>';
        }
        //$body->plaintext .=' ';

    }
}
else if (strpos($url, 'abc')){
    $curIdx1=5;$curIdx2=5; $idx1=5;$idx2=5;
    if(!empty($sumhtml)){

        $sumhtml->find('head',0)->innertext .='<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';

        $sumhtml->find('head',0)->innertext .='<link rel="stylesheet" href="assets/css/collapse.css">';
        $sumhtml->find('#abcFooter',0)->innertext .='<script src="assets/scripts/collapse.js" type="text/javascript"></script>';
       /* $sumhtml->find('style',0)->innertext .='.block {
        text-decoration: none;    width: 200px;    height: 100px;   background:#f9f9f9; border: 0;    display: block;}
        .block h3 { color: black;} .block:hover,.block a:hover,.block a h2:hover{cursor:pointer;color:#310099;} .block a {color:#4a4a4a}
        *, ::after, ::before {box-sizing: border-box;} 
        .collapse {display: block;max-height: 0px;overflow: hidden;transition: max-height 0.5s cubic-bezier(0, 1, 0, 1);}
        .collapse.show {max-height: 99em;transition: max-height .5s ease-in-out;}';*/

        if ($sumhtml->find('.article.section',0)) {
            $keyPoints = $sumhtml->find('.inline-content.wysiwyg.right');
           /* foreach ($keyPoints as $keyPoint) {
                echo $keyPoint;
            }*/
            $head = $sumhtml->find('.article.section h1', 0);
            foreach ($sumhtml->find('.article.section p') as $p) {
                $p->innertext = '';
            }

            foreach ($sumhtml->find('.page.section.featured-scroller.featured-scroller-4.dark .inner ol li') as $li) {
                $li->outertext = '';
            }
            foreach ($sumhtml->find('.article.section blockquote') as $quote) {
                $quote->outertext = '';
            }

            //  $keyPointDiv='<div class="inline-content wysiwyg right "><div><h2>Key points</h2><ul></ul></div></div>';
            //$heading='<h2>Key Points</h2>';
            // $outhtml->find('.inner',0)->innertext='<h2>Key Points</h2>'.
            //   $sumhtml->find('.article.section', 0)->innertext = '<h1>' . $head . '</h1> <img src="' . $extract->image . '" alt="Hero image"><p></p>'
            //                    . implode($keyPoints) . '<p>' . implode('</p><p>', $summary) . '</p>';
            if (!empty($extract->image)) {
             /*   $sumcollapse='<div class="collapse" id="collapse';
                $closecollapse='>';
                array_walk($splitsum3, function ($element) use (&$sumcollapse, &$idx1,$closecollapse) {
                    $sumcollapse .= '<div class="collapse" id="collapse'. $idx1 .'">'. $element . '</div>';
                    $idx1++;   $sumcollapse .='</div>';
                });*/

                $sumhtml->find('.article.section', 0)->innertext = '<h1>' . $head . '</h1> <img src="' . $extract->image . '" alt="Hero image"><p></p>'
                    . implode($keyPoints) . '<p>' . implode('</p><p>', $splitsum1) . '</p><button class="collapsible"><p>'.$splitsum2[0].'</p></button><div class="content"><p>
                 '. implode('</p><p>', $splitsum3).'</p></div>';

            }else {
                $sumhtml->find('.article.section', 0)->innertext = '<h1>' . $head . '</h1> <p></p>'
                    . implode($keyPoints) . '<p>' . implode('</p><p>', $splitsum1) . '</p><button class="collapsible"><p>'.$splitsum2[0].'</p></button><div class="content"><p>
                 '. implode('</p><p>', $splitsum3).'</p></div>';
            }
        }
        if($sumhtml->find('.subcolumns',0)){
            $sumhtml->find('.subcolumns',0)->innertext .='<div class="c25r sidebar"  onclick="window.location.href = \'origin.html\'" style="padding-top: 90px;" >
                                                                      <button type="button" class="btn btn-lg"> <a href="origin.html"><h4 >Go original page</h4></a> </button> </div>';

        }

    }  else echo"outhtml HERE".$sumhtml;
        echo 'abc';
}else if(strpos($url,'smh')){
   if (!empty($orihtml)){
       $sumhtml->find('head',0)->innertext .='<link rel="stylesheet" href="assets/css/collapse.css"><link rel="stylesheet" href="assets/css/smh.css">';
       $sumhtml->find('.y77aF.noPrint',0)->innertext ='<script src="assets/scripts/collapse.js" type="text/javascript"></script>';
    $sumhtml->find('._21UZG.noPrint',0)->outertext='';
    $sumhtml->find('head',0)->innertext .='<link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
           if ($sumhtml->find('article[class=_2yRSr]',0)){

        $sumhtml->find('header[class=_2-5AL]',0)->outertext=implode($orihtml->find('header[class=_2-5AL]')).'<div class="smhBtn d-flex justify-content-end" onclick="window.location.href = \'origin.html\'" >
                                                                         <button type="button" class="btn btn-success"> <a style="text-decoration: none;" href="origin.html">
                                                                         <h4 class="text-white">Go original page</h4></a> </button>  </div>';
       /* $sumhtml->find('header[class=_2-5AL]',0)->innertext .='<div class="d-flex justify-content-end" onclick="window.location.href = \'origin.html\'" >
                                                                         <button type="button" class="btn btn-success"> <a style="text-decoration: none;" href="origin.html">
                                                                         <h4 class="text-white">Go original page</h4></a> </button>  </div>';*/

        $sumhtml->find('aside',0)->outertext='';
        foreach ($sumhtml->find('section') as $section){
            $section->outertext='';
        }
        if(!empty($extract->image)){
            $sumhtml->find('article[class=_2yRSr]', 0)->innertext .='<section class="_1ysFk mx-auto" style="float: none;"> <img class="heroimg" src="' . $extract->image . '" alt="Hero image"><br><br><p>' . implode('</p><p>', $splitsum1) . '</p><button class="collapsible"><p>'.$splitsum2[0].'</p></button><div class="content">
                <p>'. implode('</p><p>', $splitsum3).'</p></section></div>';
    /* $sumhtml->find('article[class=_2yRSr]', 0)->innertext .= '<section class="_1ysFk mx-auto" style="float: none;"><img src="' . $extract->image . '" alt="Hero image"><p>' . implode('</p><p>', $summary) . '</p></section>';*/
        }
        else {
            $sumhtml->find('article[class=_2yRSr]', 0)->innertext .= "<p>" . implode("</p><p>", $summary) . "</p>";
        }

    }


   }else{ echo'empty html';}
}else if(strpos($url,'kidsnews')){

    if (!empty($sumhtml)){
        $sumhtml->find('head',0)->innertext .='<link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';

        $sumhtml->find('head',0)->innertext .='<link rel="stylesheet" href="assets/css/collapse.css">';
   /*     $sumhtml->find('.btyb')->outertext='';*/

        if ($sumhtml->find('.header',0)){
            $sumhtml->find('.logo',0)->outertext='';
            $sumhtml->find('.fixed-nav-container.row',0)->outertext='';
            $sumhtml->find('.header',0)->innertext .='<script src="assets/scripts/collapse.js" type="text/javascript"></script>';
           }
        if($sumhtml->find('#single',0 )) {
            $head = $sumhtml->find('.headline', 0);
            $sumhtml->find('#single', 0)->innertext = '<div id="info"><h1>' . $head . '</h1><div class="text-right" onclick="window.location.href = \'origin.html\'">
                                                                       <button type="button" class="btn btn-lg"> <a href="origin.html"><h4 >Go original page</h4></a> </button> 
                                                                        </div> <img class="image" src="' . $extract->image . '" alt="Hero image"></div>';
            $sumhtml->find('.meta',0)->outertext='';
              $sumhtml->find('#single',0)->innertext.='<div id="story" style="display:block"><p></p>'
                  . '<p class="capi-html">' . implode('</p><p class="capi-html">', $splitsum1) . '</p><button class="collapsible"><p class="capi-html">'.$splitsum2[0].'</p></button><div class="content"><p class="capi-html">
                   '. implode('</p><p class="capi-html">', $splitsum3).'</p></div></div>';

        }
        $sumhtml->find('#module-more-in',0)->outertext='';
        if ($sumhtml->find('#footer',0)){
            $sumhtml->find('#footer',0)->outertext='';
        }
        $sumhtml->find('#page',0)->innertext.='<script src="assets/scripts/collapse.js" type="text/javascript"></script>';

    }else{ echo 'Sorry page is empty';}
}
else{
    echo'Website specified not applicable to save ';
}
//-------Original html modification
if (strpos( $url, 'wiki')) {
    $orihtml->find('head',0)->innertext .='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    $orihtml->find('head',0)->innertext .='<link rel="stylesheet" type="text/css" href="assets/css/wikipedia.css">';
    if($orihtml->find('div[id=mw-navigation]',0)){
        $orihtml->find('div[id=mw-head]',0)->outertext='';
        foreach ($orihtml->find('div[class=portal]') as $sideMenu){
            $sideMenu->outertext='';
        }

    }
    if ($orihtml->find('#content',0)){
        $orihtml->find('#catlinks',0)->outertext='';
        $orihtml->find('#toc',0)->outertext='';

    }
    if($orihtml->find('.navbox',0)){$orihtml->find('.navbox',0)->outertext=''; $orihtml->find('#mw-navigation',0)->outertext='';}
    if($orihtml->find('#content',0)){
        $orihtml->find('#jump-to-nav',0)->outertext ='<div class="mw-stack" style="box-sizing:border-box;float:right; clear:right; padding-right: 50px; padding-left:50px;"  onclick="window.location.href = \'summarized.html\'">
                                                                  <button class="btn-lg" type="button"><a href="summarized.html">Go summarized page</a> </button>  </div>';
        foreach ($orihtml->find('.mw-jump-link')as $brokenJumpLinks){
            $brokenJumpLinks->outertext='';
        }
    }
}
else if (strpos($url, 'abc')){
    if(!empty($orihtml)){
        $orihtml->find('head',0)->innertext .='<link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';

//        $orihtml->find('.header.subheader',0)->outertext='';
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
            $orihtml->find('.subcolumns',0)->innertext .='<div class="block c25r sidebar" style="padding-top: 90px;" onclick="window.location.href = \'summarized.html\'">
                                                                       <button type="button" class="btn btn-lg"> <a href="summarized.html"><h4 >Go summarized page</h4></a> </button> 
                                                                        </div>';
        }//<button type="button" class="btn btn-primary" onclick="window.location.href = 'summarized.html';" >Switch</button>

    }  else echo"orihtml HERE empty".$orihtml;
    echo 'abc';
}else if(strpos($url,'smh')){
    if (!empty($orihtml)){

        $orihtml->find('head',0)->innertext .='<link rel="stylesheet" href="assets/css/smhori.css"><link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';

        $orihtml->find('._21UZG.noPrint',0)->outertext='';
        $orihtml->find('._34z61._2iGMx',0)->outertext='';
        $orihtml->find('._2-5AL',0)->outertext .='<div class="smhBtn d-flex justify-content-end" onclick="window.location.href = \'summarized.html\'"  >
                                                                      <button type="button" class="btn btn-success"> <a style="text-decoration: none;" href="summarized.html"><h4 class="text-white">Go summarized page</h4></a> </button>  </div>';

        if ($orihtml->find('article[class=_2yRSr]',0)) {
                foreach($orihtml->find('.adWrapper')as $adDiv){
            $adDiv->outertext='';
        }
        foreach ($orihtml->find('aside')as $sideDiv){
            $sideDiv->outertext='';
        }
        $orihtml->find('div[class=_22FRK',0)->outertext='';
    }

         $orihtml->find('div[class=_22Idm',0)->outertext='';
        foreach($orihtml->find('div[class=noPrint]')as $spaceDiv){
            $spaceDiv->outertext='';
        }
    }else{
        echo 'This web page is empty sorry';
    }



}else if(strpos($url,'kidsnews')){

    if (!empty($orihtml)){
        $orihtml->find('head',0)->innertext .='<link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
/*        $orihtml->find('div[class=btyb]')->outertext='';*/

        if ($orihtml->find('.header',0)){
            $orihtml->find('.logo',0)->outertext='';
            $orihtml->find('.fixed-nav-container.row',0)->outertext='';
         }
        $orihtml->find('aside[class=rightrail]',0)->outertext='';
        if($orihtml->find('p[class=intro]',0)){
            $orihtml->find('p[class=intro]',0)->outertext='<div class="text-right" onclick="window.location.href = \'summarized.html\'">
                                                                       <button type="button" class="btn btn-lg"> <a href="summarized.html"><h4 >Go summarized page</h4></a> </button> 
                                                                        </div>';
        }
    foreach ($orihtml->find('.caption') as $caption){
        $caption->outertext='';
    }
    }
}

    else{
        echo ' sorry website not applicable to summarize';
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
$sumhtml->save('summarized.html');
$orihtml->clear();
unset($orihtml);
$sumhtml->clear();
unset($sumhtml);
/*file_put_contents('origin.html', $orihtml);
file_put_contents('summarized.html', $outhtml);*/
header('LOCATION: summarized.html');
exit;

