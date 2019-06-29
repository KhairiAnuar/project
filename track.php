<?php
require_once 'vendor/autoload.php';
require_once 'vendor/mashape/unirest-php/src/Unirest.php';


var_dump($_GET);
//printf("URL:");var_dump($_GET['url']);
$url='';
$senNum = 0;
$img='';
$summary=array();

if(!isset($_GET['url']))
{  echo"No url";
    var_dump($_GET);

    }else {
    $url = urldecode($_GET['url']);
    $senChk= isset($_GET['sentence']) ? true : false;
    $imgChk=isset($_GET['img'])?true:false;
    if($senChk){
        $senNum=$_GET['sentence'];
    }


    // echo " DECODED URL:";var_dump($url);echo "\n";


    /* //https://rapidapi.com/UnFound/api/adaptive-text-summarization
     $response = Unirest\Request::post("https://unfound-text-summarization-v1.p.rapidapi.com/summarization",
         array(
             "X-RapidAPI-Host" => "unfound-text-summarization-v1.p.rapidapi.com",
             "X-RapidAPI-Key" => "a06a6a0a8emsh9b48b465f420022p19b84cjsnf6fcb4b13432",
             "Content-Type" => "application/url"
         ),
         array(

             '{\"input_data\":\"https://www.tesla.com/elon-musk\",\"input_type\":\"url\",\"summary_type\":\"general_summary\",\"N\":3}'
         )
     );
    */


    //--------AYLIEN https://docs.aylien.com/textapi/endpoints/#summarization


    $textapi = new AYLIEN\TextAPI("4ac86380", "ebef1d17efdc2147f91b3a1b940d2bed");
   // $ratelimit=$textapi->getRateLimits();


    $summary = $textapi->Summarize(array('url' => $url, 'sentences_number' => $senNum));
    $_SESSION['summary']=$summary;
    foreach ($summary->sentences as $sentence) {
        echo '<br/>';
        echo '<strong>' . $senNum++ . '</strong> ' . ' <p>' . $sentence . '</p>';
    }
if ($imgChk){
    /*$extract = $textapi->Extract(array('url' => $url, 'best_image' => 'true'));
    $_SESSION['extract']=$extract;
    var_dump($extract);*/

}



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

}




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
}*///require_once 'savePage.php';
?>
<script  type="module"  >
    import Mercury from "./node_modules/@postlight/mercury-parser";

    const url='https://www.abc.net.au/news/2019-06-27/queensland-olympic-games-bid-just-got-easier/11257178';
    Mercury.parse(url).then(result => console.log(result));
</script>

