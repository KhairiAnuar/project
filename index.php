<!--Khairi project summarization-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>MyGoogle Search</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="website icon" href="assets/images/favicon.ico" type="image/x-icon"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!--To make icons from fontawesome loads faster-->
        <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="assets/scripts/app.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    </head>

    <body>
    <div class="container-fluid h-100">
        <div class="row align-items-center h-100">
            <div class="col mx-auto d-flex flex-column align-items-center">
                <img src="assets/images/mygoogle.png" id="logo" class="w-22" alt="Logo Website"><br>
                <div class="row align-items-center">
                    <div class="col col-md-auto">
                        <form class="indexForm" action="search.php" method="get">
                            <div class="input-group show-idle-prompt">
                                <div class="queryDiv form-group d-inline-flex ui-widget" style="margin-bottom: 0">
                                    <select class="custom-select border-secondary border-right-0" id="querySelect" name="type">
                                        <option value="news" selected>News</option>
                                        <option value="wikipedia">Wikipedia</option>
                                    </select>
                                    <input type="text" placeholder="type here" size="50" autofocus class="border-right-0 rounded-0 form-control w-100" id="query" name="query" aria-label="input search query"/>

                                    <div class="input-group-append">
                                        <input type="hidden" name="pageno" value="1">
                                        <button id="btnSearch" class="btn btn-outline-secondary" value="Search"  type="submit"><i class="fas fa-search"> </i> <span >Search</span></button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
           </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>
</html>