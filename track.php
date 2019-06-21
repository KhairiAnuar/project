<?php
require_once 'vendor/autoload.php';
require_once 'vendor/mashape/unirest-php/src/Unirest.php';
require_once 'vendor/aylien/textapi/src/AYLIEN/TextAPI.php';

var_dump($_GET);
printf("URL:");var_dump($_GET['url']);

/*foreach ($_GET as $value) {
    var_dump($value);
    print_r("<br>");
}*/

/*var_dump($_GET['url'][1]);
$urlarray=implode(" URLL==",$_GET);
print_r("url Array");var_dump($urlarray);*/
if(!isset($_GET['url']))
{  echo"No url";
    var_dump($_GET);

    }else {
    $url = urldecode($_GET['url']);
    echo " DECODED URL:";var_dump($url);echo "\n";



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
    );*/



 //--------AYLIEN https://docs.aylien.com/textapi/endpoints/#summarization
  $textapi = new AYLIEN\TextAPI("4ac86380", "ebef1d17efdc2147f91b3a1b940d2bed");

    $summary = $textapi->Summarize(array('url' => $url, 'sentences_number' => 8));


    foreach ($summary->sentences as $sentence) {
        echo $sentence,"\n";
    }
}
/*
//https://rapidapi.com/textanalysis/api/text-summarization?endpoint=5469a253e4b0194373f8fb88
/*$response = Unirest\Request::post("https://textanalysis-text-summarization.p.rapidapi.com/text-summarizer-url",
   array(
       "X-RapidAPI-Host" => "textanalysis-text-summarization.p.rapidapi.com",
       "X-RapidAPI-Key" => "a06a6a0a8emsh9b48b465f420022p19b84cjsnf6fcb4b13432",
       "Content-Type" => "application/x-www-form-urlencoded"
   ),
   array(
       "url" => 'https%3A%2F%2Fen.wikipedia.org%2Fwiki%2FComputer_network',
       "sentnum" => 10
   )
);*/


/*
https://www.meaningcloud.com/developer/summarization/doc/1.0/request

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
  /*  echo $decodedResponse['summary'];
    if ($decodedResponse){
        echo"<script src='assets/scripts/load.js'></script>";

    }
}*/


// Create a URL handle.
$curlPage = curl_init();

// Tell curl what URL we want.
curl_setopt($curlPage, CURLOPT_URL, $url);

// We want to return the web page from curl_exec, not
// print it.
curl_setopt($curlPage,CURLOPT_RETURNTRANSFER,1);

// Set this if you don't want the content header.
curl_setopt($curlPage, CURLOPT_HEADER, 0);

// Download the HTML from the URL.
$content = curl_exec($curlPage);

// Check to see if there were errors.
if(curl_errno($curlPage)) {
    // We have an error. Show the error message.
    echo curl_error($curlPage);
}
else {
    // No error. Save the page content.
    $file = 'content.html';

    // Open a file for writing.
    $fh = fopen($file, 'w');

    if(!$fh) {
        // Couldn't create the file.
        echo "Unable to create $file";
    }
    else {
        // Write the retrieved
        // html to the file.
        fwrite($fh, $content);

        // Display a message to say
        // we've saved the file OK.
        echo "Saved $file";

        // Close the file.
        fclose($fh);
    }
}

// Close the curl handle.
curl_close($curlPage);

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row align-items-center">
                <div class="col mx-auto">
                    <div id="outputResult">
                <?php //echo $decodedResponse['summary']
                        var_dump($file);
                ?>

                    </div>
                </div>
            </div>
    </div>

    </body>

</html>

