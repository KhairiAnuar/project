<?php
require_once 'vendor/autoload.php';
require_once 'vendor/mashape/unirest-php/src/Unirest.php';



//printf("URL:");var_dump($_GET['url']);
$url='';
$senNum = 5;
$img='';
$summary=array();
$extract=array();


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

            $senNum=5;
        }else {

          $senNum= intval($_GET['sentence']);

        }
 /*   $ch = curl_init("http://api.smmry.com/&SM_API_KEY=65E77D6699&SM_LENGTH=".$senNum."&SM_QUESTION_AVOID&SM_URL=".$url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,20);
    curl_setopt($ch, CURLOPT_TIMEOUT,20);
    $return = json_decode(curl_exec($ch), true);
    curl_close($ch);
    $return['sm_api_content']= preg_replace('/\[[^\]]*]/', ' ', $return['sm_api_content']);
    $summary =explode('.', $return['sm_api_content']);*/

    var_dump($summary);
    //--------AYLIEN https://docs.aylien.com/textapi/endpoints/#summarization

    $textapi = new AYLIEN\TextAPI("9e1273fd", "f58cc17c028aa6a2db0c556b1273d7d8");
    $summary = $textapi->Summarize(array('url' => $url, 'sentences_number' => $senNum));
    $summary= preg_replace('/\[[^\]]*]/', ' ', $summary->sentences);
   // $ratelimit=$textapi->getRateLimits();

/*

    $_SESSION['summary']=$summary;*/
    /* foreach ($summary as $sentence) {
       echo '<br/>';
        echo '<strong>' . $senNum++ . '</strong> ' . ' <p>' . $sentence . '</p>';

    }*/
if ($imgChk){
    $extract = $textapi->Extract(array('url' => $url, 'best_image' => 'true'));
    $_SESSION['extract']=$extract;



    }else{
        $extract ='';
        $_SESSION['extract']=$extract;


    }}



//https://rapidapi.com/textanalysis/api/text-summarization?endpoint=5469a253e4b0194373f8fb88
/*    $response = Unirest\Request::post("https://textanalysis-text-summarization.p.rapidapi.com/text-summarizer-url",
        array(
            "X-RapidAPI-Host" => "textanalysis-text-summarization.p.rapidapi.com",
            "X-RapidAPI-Key" => "a06a6a0a8emsh9b48b465f420022p19b84cjsnf6fcb4b13432",
            "Content-Type" => "application/x-www-form-urlencoded"
        ),
        array(
            "url" => 'https%3A%2F%2Fen.wikipedia.org%2Fwiki%2FComputer_network',
            "sentnum" => 10
        )
    );
    var_dump($response);
*/


 // WORKS but not good https://www.meaningcloud.com/developer/summarization/doc/1.0/request
/*
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.meaningcloud.com/summarization-1.0",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "key=82678229ec9755d161fc184937dbca0b&url=". $url ."&sentences=10",
    CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
 //   echo $response."\n\n\n";
  $decodedResponse=(json_decode($response,true));
  $summary = $decodedResponse['summary'];

  /*  if ($decodedResponse){
        echo"<script src='assets/scripts/load.js'></script>";

    }
}*/
require_once 'savePage.php';

