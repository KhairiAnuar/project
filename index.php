<!DOCTYPE html>
<http>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script>

            (function() {
                //search api
                var cx = '013562356057062446115:fhyiygpryes';
                var gcse = document.createElement('script');
                gcse.type = 'text/javascript';
                gcse.async = true;
                gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(gcse, s);
            })();

        </script>

    </head>

    <body>
    <div class="container">
        <div class="h-100 row align-items-center">
            <div class="col">
                <form action="CustomSearch/CustomSearch.php" method="get">
                    <div class="center-block">
                        <gcse:search enableAutoComplete="true"  resultsUrl="#"></gcse:search>
                    </div>
                </form>


                <!--testing in console-->
                <script>
                    var apiKey='AIzaSyD4WaKSSRrkabUrPDiyN0NrNRF2pAYRnlU';
                    var cx= '013562356057062446115:fhyiygpryes';
                    var q='hello';
                    $.get('https://www.googleapis.com/customsearch/v1?key='+apiKey+'&cx='+cx+'&q='+q,function (data) {
                        console.log(data);})
                </script>


            </div>
        </div>
    </div>
    </body>
</http>