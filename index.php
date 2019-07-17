<!--Khairi project summarization-->
<!DOCTYPE html>
<html>
    <head>
        <title>MyGoogle Search</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>

        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
       <script src="assets/scripts/app.js"></script>
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
                        <input type="text" class="form-control w-100" id="query" name="query" aria-label="input search query"/>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                            <div class="col-auto">
                                <input type="hidden"name="pageno" value="1">
                                <input id="btnSearch" class="btn btn-secondary" value="Search"  type="submit">
                            </div>
                            </form>


           </div>
                <div class="row" id="searchResult"></div>

                <div class="row" id="output"></div>
            </div>


        </div>
    </div>


    </body>
</html>