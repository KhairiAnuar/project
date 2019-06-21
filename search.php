<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <title>JSON google Custom Search API</title>
</head>
<body>
<div id="content"></div>

<!--    if(!empty($_GET['query'])){
<script src='https://www.googleapis.com/customsearch/v1?key=AIzaSyD4WaKSSRrkabUrPDiyN0NrNRF2pAYRnlU&cx=013562356057062446115:fhyiygpryes&q=&callback=hndlr'>
</script>
-->
<script>

</script>

<script>

    function hndlr(response) {
        for (var i = 0; i < response.items.length; i++) {
            var item = response.items[i];

            document.getElementById("content").innerHTML += "<br>" + item.htmlTitle;
            document.getElementById("content").innerHTML += "URL=<a href=&quot" + item.link +"&quot>" + item.displayLink + "</a>";

        }
        console.log(response);
    }
    window.__gcse = {

        callback: hndlr
    };

    var apiKey='AIzaSyD4WaKSSRrkabUrPDiyN0NrNRF2pAYRnlU';
    var cx= '013562356057062446115:fhyiygpryes';
    var q='<?php echo $_GET['query']; ?>';
    $.get('https://www.googleapis.com/customsearch/v1?key='+apiKey+'&cx='+cx+'&q='+q+'&callback=?');


</script>

<!--
<script src="https://www.googleapis.com/customsearch/v1?key=AIzaSyD4WaKSSRrkabUrPDiyN0NrNRF2pAYRnlU&cx=013562356057062446115:fhyiygpryes&q=hello&callback=hndlr">
</script>
-->

</body>
</html>