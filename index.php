
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/813f4dddd8.js"></script>
        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>

        </script>
        <script>
            function toggleSummary() {

                if (document.getElementById('summaryDiv')) {

                    if (document.getElementById('summaryDiv').style.display === 'none') {
                        document.getElementById('summaryDiv').style.display = 'block';
                     }
                    else {
                        document.getElementById('summaryDiv').style.display = 'none';
                        document.getElementById('summaryDiv').style.display = 'block';
                    }
                }
            }

            var suggestCallBack; // global var for autocomplete jsonp

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
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    </head>

    <body>
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-8 mx-auto d-flex flex-column align-items-center">
                <img src="assets/images/mygoogle.png" id="logo" class="w-22" alt="Logo Website"><br>
                <form action="search.php" method="get">
                    <div class="form-group d-inline-flex ui-widget">
                        <input type="text" class="form-control " id="query" name="query"/>
                            <div class="col-auto">

                                <input id="btnSearch" class="btn btn-secondary"value="Search"  type="submit">
                            </div>
                            </form>


           </div>
                <div class="row" id="searchResult"></div>

                <div class="row" id="output"></div>
            </div>
            <div id="summaryDiv" class="col-4">
                <div  class="card">
                    <div class="card-header">
                        <h5 class="card-title">Summary Settings</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <label for="toggleImg"> Do you want picture <img src="assets/images/imageIcon.png">?</label>
                            <label class="switch">
                                <input type="checkbox" id="toggleImg" checked>
                                <span class="slider round"></span>
                            </label>

                        </div>
                        <div class="form-group">
                            <label for="sentNum">Number of sentences</label>
                            <input type="number" class="form-control" id="sentNum" min="5" max="10">
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <a href="#" id="lnkPrev"   title="Display previous result page" style="display:none;">Previous</a>
                <span id="lblPageNumber" style="display:none;"></span>
                <a href="#" id="lnkNext"  title="Display next result page" style="display:none;">Next</a>
            </div>
        </div>
    </div>


    </body>
</html>