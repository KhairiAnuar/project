<?php
session_start();
require 'CustomSearch/GoogleCustomSearch.php';
$apiKey = 'AIzaSyD4WaKSSRrkabUrPDiyN0NrNRF2pAYRnlU';
$csKey = "013562356057062446115:fhyiygpryes";
$pageErr='';
$term='';
$search = new CustomSearch\GoogleCustomSearch($csKey, $apiKey);
$prevIndex = 0;
$nextIndex = 0;
$resultsPerPage = 10;
$pageNumber = 1;
?>
    <!DOCTYPE html><html lang="en"> <head>
    <title>MyGoogle Search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        function track(url) {
            //var data=encodeURIComponent(url);
            var toggleImg=$('#toggleImg').val();
            var sentNum=$('#sentNum').val();
            event.preventDefault();
            var encodedUrl=encodeURIComponent(url);
            window.location="track.php?img="+toggleImg+"&sentence="+sentNum+"&url="+encodedUrl;

        }
        $(document).ready(function () {
            $("#query").autocomplete({
                source: function(request, response) {
                    $.getJSON("http://suggestqueries.google.com/complete/search?callback=?",
                        {
                            "hl":"en", // Language
                            "ds":"yt", // Restrict lookup to youtube
                            "jsonp":"suggestCallBack", // jsonp callback function name
                            "q":request.term, // query term
                            "client":"youtube" // force youtube style response, i.e. jsonp
                        }
                    );
                    suggestCallBack = function (data) {
                        var suggestions = [];
                        $.each(data[1], function(key, val) {
                            suggestions.push({"value":val[0]});
                        });
                        suggestions.length = 5; // prune suggestions list to only 5 items
                        response(suggestions);
                    };
                },
            });
        });


    </script>
    </head>   <div class="container-fluid">
    <div class="row">
        <div class="col-12" id="searchBox">
            <form action="search.php" method="get">
                <img src="assets/images/mygoogle.png" id="logo" style="width:120px" alt="Logo Website">
                <div class="d-inline-flex ">
                    <input type="text" class="form-control" id="query" name="query"/>
                    <input id="btnSearch" class="btn btn-secondary " value="Search" type="submit">
                </div>
        </div></div>
<?php
if(empty($_GET['query'])){
    $pageErr='No matching pages';
    echo $pageErr;
}else{
    $term=$_GET['query'];
    //Search($term,0);
    $searchresultsObject = $search->search($term,$pageNumber,10);
    $i=0;
    ?>
        <div class="row" id="output">
            <div class="col-6">
            <?php

            foreach ($searchresultsObject->results as $searchresults) {
                $encodedUrl=urlencode($searchresults->link);
                echo "<h3 class='resultTitle'><a  href=track.php?img=on&sentence=5&url=".$encodedUrl. ">" . $searchresults->title . "</a></h3>" . "<a class='resultLinks' onclick='track(".$searchresults->link.")' href=" . $searchresults->link . ">" . $searchresults->link . "</a>" . nl2br("\n");
                $searchresults->snippet = preg_replace('!\s+!', ' ', $searchresults->snippet);
                if(!empty($searchresults->thumbnail)){
                    echo "<p><img src='".$searchresults->thumbnail."' alt='website thumbnail image'>".$searchresults->htmlSnippet."</p>";
                }
                else {echo "<p>".$searchresults->htmlSnippet."</p>";}
/*
                echo "<div style='display: table;'><div style='display: table-row'><p style=' display: table-cell;'>".$searchresults->htmlSnippet."</p>";
                echo "<p><img style=' display: table-cell;' src='".$searchresults->thumbnail."' alt='website thumbnail image'>".$searchresults->htmlSnippet."</p></div>";*/

            } ?>
            </div>
        </div>
    </div>
<div>
    <a href="#" id="lnkPrev"  onclick="prev()" title="Display previous result page" >Previous</a>
    <span id="lblPageNumber"></span>
    <a href="#" id="lnkNext" onclick="next()" title="Display next result page" >Next</a>
</div>
    </html>




    <?php
}



    function Search($term, $direction)
    {
        global $prevIndex,$pageNumber,$nextIndex,$apiKey,$csKey;
        $startIndex = 1;

        if ($direction === -1)
        {
            $startIndex = $prevIndex;
            $pageNumber--;
        }
        if ($direction === 1)
        {
            $startIndex = $nextIndex;
            $pageNumber++;
        }
        if ($direction === 0)
        {
            $startIndex = 1;
            $pageNumber = 1;
        }
        //http://suggestqueries.google.com/complete/search?client=chrome&q=YOURQUERY&callback=callback
        $query = "https://www.googleapis.com/customsearch/v1/siterestrict?key=" . $apiKey . "&num=10&cx=" . $csKey . "&start=" . $startIndex. "&q=" . $term . "&callback=?";
        $res = json_decode(file_get_contents($query));

        //SearchCompleted($res);
        foreach ($res->items as $item) {
            echo "$item->title $item->link";
            echo PHP_EOL;
            //$.getJSON(url, SearchCompleted);
        }
    }


/*
$doc =new DOMDocument();
function SearchCompleted($response)
{
    $html = "";
    ("#searchResult").html("");

    if (response.items == null)
    {
        $("#searchResult").html("No matching pages found");
        return;
    }

    if (response.items.length === 0)
    {
        $("#searchResult").html("No matching pages found");
        return;
    }

    $("#searchResult").html(response.queries.request[0].totalResults + " pages found");

    if (response.queries.nextPage != null)
    {
        _nextIndex = response.queries.nextPage[0].startIndex;
        $("#lnkNext").show();
    }
    else
    {
        $("#lnkNext").hide();
    }

    if (response.queries.previousPage != null)
    {
        _prevIndex = response.queries.previousPage[0].startIndex;
        $("#lnkPrev").show();
    }
    else
    {
        $("#lnkPrev").hide();
    }

    if (response.queries.request[0].totalResults > _resultsPerPage)
    {
        $("#lblPageNumber").show().html(_pageNumber);
    }
    else
    {
        $("#lblPageNumber").hide();
    }

    for (var i = 0; i < response.items.length; i++)
    {
        var item = response.items[i];
        var title = item.htmlTitle;

        html += "<div><br> <div class='hcHead2'> <a href='" + item.link + "' onclick=track('"+ item.link +"')>"+ title + "</a>" +
            "<div style='color:#006621;'>"+item.displayLink+"</div></div>";
        html += item.htmlSnippet + "</div><br>";
        console.log(item.link);
    }
    $('#logo').hide();
    $("#output").html(html);


}
*/






