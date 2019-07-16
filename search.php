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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="assets/scripts/app.js"></script>

    </head>   <div class="container-fluid">
    <div class="row">
        <div class="col-12" id="searchBox">
            <form action="search.php" method="get">
                <img src="assets/images/mygoogle.png" id="logo" style="width:120px" alt="Logo Website">
                <div class="d-inline-flex queryInput">
                    <input type="text" class="form-control w-100" value="<?php echo isset($_GET['query']) ? $_GET['query'] : '' ?>"id="query" name="query" aria-label="input search query"/>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input id="btnSearch" class="btn btn-secondary " value="Search" type="submit">
                </div>
        </div></div>


<?php
if(empty($_GET['query'])){
    $pageErr='No matching pages';
    echo $pageErr;
}else{
    $term=$_GET['query'];
    if(!empty($_GET['pageno'])){
        $pageNumber=$_GET['pageno'];
    }
    //Search($term,0);


    $searchresultsObject = $search->search($term,$pageNumber,10);
    $i=0;
    ?>
        <div class="row searchResult" id="output">
            <div class="col-7">
            <?php

            foreach ($searchresultsObject->results as $searchresults) {
                $encodedUrl=urlencode($searchresults->link);
                echo "<div class='searchResultRow'><h3 class='resultTitle'><a  href=track.php?img=on&sentence=5&url=".$encodedUrl. ">" . $searchresults->title . "</a></h3>" . "<a class='resultLinks' onclick='track(".$searchresults->link.")' href=" . $searchresults->link . ">" . $searchresults->htmlFormattedUrl. "</a>" . nl2br("\n");
                $searchresults->snippet = preg_replace('!\s+!', ' ', $searchresults->htmlSnippet);
                if(!empty($searchresults->thumbnail)){
                    echo "<div class='d-flex flex-row'><img src='".$searchresults->thumbnail."' alt='website thumbnail image'><p>".$searchresults->snippet."</p></div></div>";
                }
                else {echo "<p>".$searchresults->htmlSnippet."</p></div>";}
/*
                echo "<div style='display: table;'><div style='display: table-row'><p style=' display: table-cell;'>".$searchresults->htmlSnippet."</p>";
                echo "<p><img style=' display: table-cell;' src='".$searchresults->thumbnail."' alt='website thumbnail image'>".$searchresults->htmlSnippet."</p></div>";*/

            } ?>
            </div>

            <div id="summaryDiv" class="col-4">
                <div  class="card">
                    <div class="card-header">
                        <h5 class="card-title">Summary Settings</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <label for="toggleImg"> Do you want picture <img src="assets/images/picture.svg" alt="image icon">?</label>
                            <label class="switch">
                                <input type="checkbox" id="toggleImg" checked>
                                <span class="slider round"> </span>
                            </label>

                        </div>
                        <div class="form-group">
                            <label for="sentNum">Number of sentences</label>
                            <input type="number" class="form-control" id="sentNum" min="5" max="10">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<div>
    <a href="" id="lnkPrev"  onmousedown="prev()" title="Display previous result page" >Previous</a>
    <span id="lblPageNumber"> </span>
    <a href="" id="lnkNext" onmousedown="next()" title="Display next result page" >Next</a>
</div>
    <script type="text/javascript">
        function track(url) {
            //var data=encodeURIComponent(url);
            var toggleImg=$('#toggleImg').val();
            var sentNum=$('#sentNum').val();
            event.preventDefault();
            var encodedUrl=encodeURIComponent(url);
            window.location="track.php?img="+toggleImg+"&sentence="+sentNum+"&url="+encodedUrl;

        }



        function prev() {

            var requestPage=parseInt(<?php echo json_encode($pageNumber)?>,10);
            requestPage=requestPage-1;
            console.log(requestPage);
            window.location.href='search.php?query='+document.getElementById("query").value+"&pageno="+requestPage;
        }
        function next() {
            var requestPage=parseInt(<?php echo json_encode($pageNumber)?>,10);
            requestPage=1+requestPage;
            console.log(requestPage);
            window.location.href='search.php?query='+document.getElementById("query").value+"&pageno="+requestPage;
        }
        $(document).ready(function() {
            var requestPage=parseInt(<?php echo json_encode($pageNumber)?>,10);
            document.getElementById('lblPageNumber').innerHTML=requestPage;
            console.log(requestPage);
            if(requestPage<=1){
                document.getElementById("lnkPrev").style.display='none';
            }else{document.getElementById("lnkPrev").style.display='inline'; }
        });


    </script>

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






