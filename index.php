
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
            <div class="col-8 mx-auto d-flex flex-column align-items-center">
                <img src="assets/images/mrLogo.png" id="logo" class="w-22" alt="Logo Website"><br>
                    <div class="form-group d-inline-flex">
                        <input type="text" class="form-control " id="query" name="query"/>
                            <div class="col-auto">
                                <button id="btnSearch" class="btn btn-secondary " onclick="submitQuery()" type="button">Search</button>
                            </div>
                        </div>

                <div class="row" id="searchResult"></div>

                <div class="row" id="output"></div>

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
            <div class="card" style="width:17em;">
                <div class="card-body">
                   <form name="configForm">
                    <h5 class="card-title">Summary Settings</h5>
                       <div class="form-check">
                           <input class="form-check-input" type="checkbox" value="image" id="checkBoxImg">
                           <label class="form-check-label" for="checkBoxImg">
                             Do you want pictures <img src="assets/images/imageIcon.png" alt="Image Icon">?
                           </label>
                       </div>
                       <div class="form-group">
                           <label for="sentNum">Number of sentences</label>
                           <input type="number" class="form-control" id="sentNum" min="5" max="10">
                       </div>

                   </form>

                </div>
            </div>


            <div>
                <a href="#" id="lnkPrev"  onclick="prev()" title="Display previous result page" style="display:none;">Previous</a>
                <span id="lblPageNumber" style="display:none;"></span>
                <a href="#" id="lnkNext" onclick="next()" title="Display next result page" style="display:none;">Next</a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var apiKey = "AIzaSyD4WaKSSRrkabUrPDiyN0NrNRF2pAYRnlU";
        var csKey = "013562356057062446115:fhyiygpryes";
    </script>

    </body>
</html>