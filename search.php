<?php
session_start();
require 'CustomSearch/GoogleCustomSearch.php';

$apiKey = "AIzaSyD4WaKSSRrkabUrPDiyN0NrNRF2pAYRnlU";
$csKey = "013562356057062446115:fowql5wsdju";

$pageErr='';
if(!isset($term)){
    $term='';
}
if(empty($_GET['type'])){
$type='news';
}else{$type=$_GET['type'] ;}

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

    <link rel="website icon" href="assets/images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="assets/scripts/app.js"></script>
    </head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-10" id="searchBox">
            <form action="search.php" method="get">
                <img src="assets/images/mygoogle.png" id="logo"  alt="Logo Website">
                <div class="input-group show-idle-prompt">
                    <div class=" queryDiv form-group d-inline-flex ui-widget" style="margin-bottom: 0">

                        <select class="custom-select border-right-0" id="querySelect" name="type">
                            <option value="news" <?php echo ($type == 'news')?"selected":"" ?> >News</option>
                            <option value="wikipedia" <?php echo ($type == 'wikipedia')?"selected":"" ?> >Wikipedia</option>
                        </select>

                        <input type="text" placeholder="type here" class="border-right-0 rounded-0 form-control w-100" autofocus value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>"
                                   id="query" name="query" aria-label="input search query"/>

                        <div class="input-group-append">
                            <input type="hidden" name="pageno" value="1">
                            <button id="btnSearch" class="btn btn-outline-secondary" value="Search"  type="submit"><i class="fas fa-search"> </i> <span>Search</span> </button>
                        </div>
                    </div>
                </div>
        </div>
    </div>

<?php
//Check query keywords
if(empty($_GET['query'])){
    $pageErr='No matching pages';
    header('Location: index.php');
    ?>
    <div class="row searchResult" id="output">
    <div class="col-7 col-md-auto">
        <h5>Please enter keyword</h5>
    </div>
    </div>
<?php
}else{
    $term=$_GET['query'];
    if(isset($_GET['type'])){
        $type=$_GET['type'];
    }
    if(!empty($_GET['pageno'])){
        $pageNumber=intval($_GET['pageno']);

    }else{$pageNumber=1;}

    //Check search type(GoogleSearch(query,sites,dates from and to,page no, number result per page)
    if($type=='news'){
        $searchResultsObject = $search->search($term,'www.kidsnews.com.au','date:r:20170101:20190817',$pageNumber,10);
    }
    else{
        $searchResultsObject = $search->search($term,'simple.wikipedia.org','',$pageNumber,10);
    }
    ?>
        <div class="row searchResult" id="output">
            <div class="col-8 col-md-auto">
            <?php

            foreach ($searchResultsObject->results as $searchresults) {
                $searchresults->snippet = preg_replace('!\s+!', ' ', $searchresults->htmlSnippet);
                $encodedUrl=urlencode($searchresults->link);
                echo "<div class='searchResultRow'>  
                    <div class='row no-gutters'>
                       <div class='card'>
                        <div class='row no-gutters'>";

                if(!empty($searchresults->thumbnail)){
                    //Search results div with hero images
                    echo "<div class='col-md-8 '>
                            <div class='card-body'>         
                            <h3 class='resultTitle'> <img src='https://www.google.com/s2/favicons?domain=".$searchresults->link."' alt='Website Icon'>
                            <a  href=getsummary.php?img=on&sentence=10&url=".$encodedUrl. ">".nl2br("\t") . $searchresults->title . "</a></h3>"
                                . nl2br("\n")."<div class='d-flex flex-row'><p>".$searchresults->snippet."</p></div></div></div>
                                <a  href=getsummary.php?img=on&sentence=10&url=".$encodedUrl.">
                                <img class='card-img img-thumbnail rounded' src='".$searchresults->thumbnail."' alt='website thumbnail image'></a></div></div></div></div>";
                }
                //Search results div without hero images
                else {echo "<div class='col-md-12 '>
                            <div class='card-body'><h3 class='resultTitle'>
                             <img src='https://www.google.com/s2/favicons?domain=".$searchresults->link."' alt='Website Icon'> 
                             <a  href=getsummary.php?img=on&sentence=10&url=".$encodedUrl. ">".nl2br("\t"). $searchresults->title . "</a></h3>"
                                . nl2br("\n")."<p>".$searchresults->htmlSnippet."</p></div></div></div></div></div></div>";}

            }//Foreach close bracket ?>

            </div>
        </div>
    <?php
    $total_pages=7/*$searchResultsObject->end*/;
    $adjacents=2;
    //Here generate the range of the page numbers which will display.
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
        <ul class="pagination pagination-lg justify-content-center">
            <div class="show-idle-prompt d-flex">
            <!-- Link of the first page -->
            <li class='page-item <?php ($pageNumber <= 1 ? print 'disabled' : '')?>'>
                <a class='page-link' href='search.php?type=<?php echo $type?>&query=<?php echo $term ?>&pageno=1'><<</a>
            </li>
            <!-- Link of the previous page -->
            <li class='page-item <?php ($pageNumber <= 1 ? print 'disabled' : '')?>'>
                <a class='page-link' href='search.php?type=<?php echo $type?>&query=<?php echo $term ?>&pageno=<?php ($pageNumber>1 ? print($pageNumber-1) : print 1)?>'><</a>
            </li>
            <!-- Links of the pages with page number -->
            <?php for($i=$start; $i<=$end; $i++) { ?>
                <li class='page-item <?php ($i == $pageNumber ? print 'active' : '')?>'>
                    <a class='page-link' href='search.php?type=<?php echo $type?>&query=<?php echo $term ?>&pageno=<?php echo $i;?>'><?php echo $i;?></a>
                </li>
            <?php } ?>
            <!-- Link of the next page -->
            <li class='page-item <?php ($pageNumber >= $total_pages ? print 'disabled' : '')?>'>

                <a class='page-link' href='search.php?type=<?php echo $type?>&query=<?php echo $term ?>&pageno=<?php ($pageNumber < $total_pages ? print($pageNumber+1) : print $total_pages)?>'>></a>
            </li>
            <!-- Link of the last page -->
            <li class='page-item <?php ($pageNumber >= $total_pages ? print 'disabled' : '')?>'>
                <a class='page-link' href='search.php?type=<?php echo $type?>&query=<?php echo $term ?>&pageno=<?php echo $total_pages;?>'>>></a>
            </li>
            </div>
        </ul>
    <?php } ?>

    </div>
    </body>
 </html>
    <?php
    }

/*
 * pagination logic http://www.mitrajit.com/bootstrap-pagination-in-php-and-mysql/
*/




