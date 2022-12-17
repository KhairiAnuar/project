<!--
Author: Khairi Anuar
Project QUT Bachelor of Information Honours 2019: Web searching with summarization
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MyGoogle Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="website icon" href="assets/images/favicon.ico" type="image/x-icon"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/ac2d020881.js" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="assets/scripts/app.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>

<body>
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col mx-auto d-flex flex-column align-items-center">
            <img src="assets/images/mygoogle.png" id="logo" class="w-22" alt="Logo Website"><br>
            <div class="row align-items-center">
                <div class="col col-md-auto">
                    <form class="indexForm" action="search.php" method="get">
                        <div class="input-group show-idle-prompt">
                            <div class="queryDiv form-group d-inline-flex ui-widget" style="margin-bottom: 0">
                                <select class="custom-select border-secondary border-right-0" id="querySelect"
                                        name="type">
                                    <option value="news" selected>News</option>
                                    <option value="wikipedia">Wikipedia</option>
                                </select>
                                <input type="text" placeholder="type here" size="50" autofocus
                                       class="border-right-0 rounded-0 form-control w-100" id="query" name="query"
                                       aria-label="input search query"/>

                                <div class="input-group-append">
                                    <input type="hidden" name="pageno" value="1">
                                    <button id="btnSearch" class="btn btn-outline-secondary" value="Search"
                                            type="submit"><i class="fas fa-search"> </i> <span>Search</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-5"> <div class="col"> <p> <b>Made by Muhd Khairi Azmi Anuar</b> : Khairiazmi.anuar@gmail.com</p>
                    <p class="text-justify"><b>Project Honours at QUT University in 2019 </b>: Thesis - Improving web accessibility for People with
                        intellectual disability with integration of Text Summarization with search engine  </p>    </div> </div>
        </div>
    </div>
    </div>


</body>
</html>