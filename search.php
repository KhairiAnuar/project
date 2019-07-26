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
<!DOCTYPE html>
 <html lang="en">
    <head>
    <title>MyGoogle Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="assets/scripts/app.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#summaryBtn").click(function(){
                $("#summaryDiv").toggle("slow");
            });
        });
    </script>
    </head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12" id="searchBox">
            <form action="search.php" method="get">
                <img src="assets/images/mygoogle.png" id="logo" style="width:120px" alt="Logo Website">
                <div class="d-inline-flex queryDiv">
                    <input type="text" class="form-control w-100 queryInput" value="<?php echo isset($_GET['query']) ? $_GET['query'] : '' ?>" id="query" name="query" aria-label="input search query"/>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"> </i></span>
                    </div>
                    <input id="btnSearch" class="btn btn-secondary " value="Search" type="submit">
                </div>
                <button class="btn btn-light" id="summaryBtn" onclick="return false;"> Summary options</button>
        </div></div>


<?php
if(empty($_GET['query'])){
    $pageErr='No matching pages';
    ?>
    <div class="row searchResult" id="output">
    <div class="col-7">
        <h5>Please enter keyword</h5>
    </div>
    </div>
<?php
}else{
    $term=$_GET['query'];
    if(!empty($_GET['pageno'])){
        $pageNumber=intval($_GET['pageno']);

    }

    $searchresultsObject = $search->search($term,$pageNumber,10);
    ?>
        <div class="row searchResult" id="output">
            <div class="col-7">
            <?php

            foreach ($searchresultsObject->results as $searchresults) {
                $encodedUrl=urlencode($searchresults->link);
                echo "<div class='searchResultRow'><h3 class='resultTitle'><a  href=getsummary.php?img=on&sentence=10&url=".$encodedUrl. ">" . $searchresults->title . "</a></h3>" . "<a class='resultLinks' onclick='track(".$searchresults->link.")' href=" . $searchresults->link . ">" . $searchresults->htmlFormattedUrl. "</a>" . nl2br("\n");
                $searchresults->snippet = preg_replace('!\s+!', ' ', $searchresults->htmlSnippet);
                if(!empty($searchresults->thumbnail)){
                    echo "<div class='d-flex flex-row'><img src='".$searchresults->thumbnail."' alt='website thumbnail image'><p>".$searchresults->snippet."</p></div></div>";
                }
                else {echo "<p>".$searchresults->htmlSnippet."</p></div><br>";}
/*
                echo "<div style='display: table;'><div style='display: table-row'><p style=' display: table-cell;'>".$searchresults->htmlSnippet."</p>";
                echo "<p><img style=' display: table-cell;' src='".$searchresults->thumbnail."' alt='website thumbnail image'>".$searchresults->htmlSnippet."</p></div>";*/

            } ?>
            </div>

            <div  class="col-4">
                <div id="summaryDiv" class="card">
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
    <?php
    $total_pages=$searchresultsObject->end;
    $adjacents=2;
    //Here we generates the range of the page numbers which will display.
    if($total_pages <= (1+($adjacents * 2))) {
        $start = 1;
        $end   = $total_pages;
    } else {
        if(($pageNumber - $adjacents) > 1) {
            if(($pageNumber + $adjacents) < $total_pages) {
                $start = ($pageNumber - $adjacents);
                $end   = ($pageNumber + $adjacents);
            } else {
                $start = ($total_pages - (1+($adjacents*2)));
                $end   = $total_pages;
            }
        } else {
            $start = 1;
            $end   = (1+($adjacents * 2));
        }
    }


    if( $total_pages > 1) { ?>
        <ul class="pagination justify-content-center">
            <!-- Link of the first page -->
            <li class='page-item <?php ($pageNumber <= 1 ? print 'disabled' : '')?>'>
                <a class='page-link' href='search.php?query=<?php echo $term ?>&pageno=1'><<</a>
            </li>
            <!-- Link of the previous page -->
            <li class='page-item <?php ($pageNumber <= 1 ? print 'disabled' : '')?>'>
                <a class='page-link' href='search.php?query=<?php echo $term ?>&pageno=<?php ($pageNumber>1 ? print($pageNumber-1) : print 1)?>'><</a>
            </li>
            <!-- Links of the pages with page number -->
            <?php for($i=$start; $i<=$end; $i++) { ?>
                <li class='page-item <?php ($i == $pageNumber ? print 'active' : '')?>'>
                    <a class='page-link' href='search.php?query=<?php echo $term ?>&pageno=<?php echo $i;?>'><?php echo $i;?></a>
                </li>
            <?php } ?>
            <!-- Link of the next page -->
            <li class='page-item <?php ($pageNumber >= $total_pages ? print 'disabled' : '')?>'>

                <a class='page-link' href='search.php?query=<?php echo $term ?>&pageno=<?php ($pageNumber < $total_pages ? print($pageNumber+1) : print $total_pages)?>'>></a>
            </li>
            <!-- Link of the last page -->
            <li class='page-item <?php ($pageNumber >= $total_pages ? print 'disabled' : '')?>'>
                <a class='page-link' href='search.php?query=<?php echo $term ?>&pageno=<?php echo $total_pages;?>'>>></a>
            </li>
        </ul>
    <?php } ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
 </html>
    <?php
    }

/*
 * pagination logic http://www.mitrajit.com/bootstrap-pagination-in-php-and-mysql/
*/




