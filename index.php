<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!--        <script data-main="/scripts/" src="node_modules/requirejs/require.js"></script>-->

<!--       <script src="bundle.js"></script>-->
<!--        <script type="module" src="bundle.js"></script>-->
        <script src="assets/scripts/app.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    </head>

    <body>
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col mx-auto">
                    <div class="center-block">
                    <input type="text" id="query" name="query"/>
                    <button id="btnSearch" onclick="submitQuery()" type="button">Search</button>
                    </div>



                <div id="searchResult"></div>

                <div id="output"></div>

                <!--testing in console
                <script>
                    var apiKey='AIzaSyD4WaKSSRrkabUrPDiyN0NrNRF2pAYRnlU';
                    var cx= '013562356057062446115:fhyiygpryes';
                    var q='hello';
                    $.get('https://www.googleapis.com/customsearch/v1?key='+apiKey+'&cx='+cx+'&q='+q,function (data) {
                        console.log(data);})
                </script>

                -->
            </div>

            <div>
                <a href="#" id="lnkPrev"  onclick="prev()" title="Display previous result page" style="display:none;">Previous</a>
                <span id="lblPageNumber" style="display:none;"></span>
                <a href="#" id="lnkNext" onclick="next()" title="Display next result page" style="display:none;">Next</a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var mGoogleApiKey = "AIzaSyD4WaKSSRrkabUrPDiyN0NrNRF2pAYRnlU";
        var mGoogleCustomSearchKey = "013562356057062446115:fhyiygpryes";
    </script>

    </body>
</html>