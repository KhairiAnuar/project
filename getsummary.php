<?php
require_once 'vendor/autoload.php';
/**
 * Text extraction and hero image extraction handle by API AYLIEN: aylien.com
*/
$url='';
$senNum=0;
$img='';
$summary=array();
$extract=array();

//Check Url, number of sentences and hero image
if(!isset($_GET['url'])) {
    echo"No url";
    var_dump($_GET);

    }else {
        $url = urldecode($_GET['url']);

        if (isset($_GET['img'])){
            $imgChk=true;
        }else {
            $imgChk=false;
        }
        if(empty($_GET['sentence'])){

            $senNum=10;
        }else {

          $senNum= intval($_GET['sentence']);

        }
    //Text extraction
    $textapi = new AYLIEN\TextAPI("9e1273fd", "f58cc17c028aa6a2db0c556b1273d7d8");
    $summary = $textapi->Summarize(array('url' => $url, 'sentences_number' => $senNum));

    //Remove unnecessary symbols from summary
    $summary= preg_replace('/\[[^\]]*]/', ' ', $summary->sentences);

    //Hero image extraction
    if ($imgChk){
        $extract = $textapi->Extract(array('url' => $url, 'best_image' => 'true'));
        $_SESSION['extract']=$extract;

        }else{
            $extract ='';
            $_SESSION['extract']=$extract;

    }}
require_once 'savePage.php';

