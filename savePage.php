<?php

require_once 'track.php';
require_once 'assets/savePage/simple_html_dom.php';

//$contentonly = isset($_POST['content']) ? true : false;
//$keepjs = isset($_POST['javascript']) ? true : false;
//$compress = isset($_POST['compress']) ? true : false;
$body ='';
$headContent='';

//var_dump($summary);
$contentonly = true;
$keepjs = false;
$compress = true;
$index=0;
$bodyContent=array();
# include the class
require_once 'assets/savePage/htmlSaveComplete.php';

$htmlSaveComplete = new htmlSaveComplete($url);
$html = $htmlSaveComplete->getCompletePage($keepjs, $contentonly, $compress);
$outhtml = str_get_html($html);

if (strpos( $url, 'wiki')) {

    $head=$outhtml->find('#content',0);
    $headContent=$head->find('h1',0);

    if ($outhtml->find('div[class=mw-parser-output]',0)){
       // $outhtml->find('div[class=mw-parser-output]',0)->innertext='<div class="summaryText"></div>';
        foreach($outhtml->find('div[class=bodycontent] a') as $links){
            $links->outertext='';
        }
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

            };


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
        //$body->plaintext .=' ';

    }

   // var_dump($bodyContent[$num]);
    //var_dump($bodyContent);
   //if($outhtml->find('div[class=richtext]',0)){
  //   echo '\n SUMMARY ECHOOOOOOOO\n';//var_dump($summary->sentences);


  /*  foreach ($summary->sentences as $sentence) {

        $outhtml->find('div[class=richtext]',$index)->outertext.='<p>'.$sentence.'</p>';
        $index++;
    }//$bodyContent[$index]=$outhtml->find('div[class=richtext] p',$index)->innertext=$index .$sentence.'<br>';*/

//}

   //var_dump($body);

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


file_put_contents('output.html', $outhtml);
//header('LOCATION: output.html');
exit;

