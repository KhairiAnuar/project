
function hndlr(response) {
    for (var i = 0; i < response.items.length; i++) {
        var item = response.items[i];
        document.getElementById("content").innerHTML += "URL=<a href=&quot" + item.link +"&quot>" + item.displayLink + "</a>";
    }
}


// https://peter.hahndorf.eu/blog/UsingTheGoogleCustomSearchAPIV.html
//import {}from 'bundle.js';

var _prevIndex = 0;
var _nextIndex = 0;
var _resultsPerPage = 10;
var _pageNumber = 1;
console.log("run app.js");

function submitQuery(){ Search(document.getElementById("query").value,0);}
function prev() { Search(document.getElementById("query").value,-1);}
function next() { Search(document.getElementById("query").value,1);}


function Search(term, direction)
{
    var startIndex = 1;

    if (direction === -1)
    {
        startIndex = _prevIndex;
        _pageNumber--;
    }
    if (direction === 1)
    {
        startIndex = _nextIndex;
        _pageNumber++;
    }
    if (direction === 0)
    {
        startIndex = 1;
        _pageNumber = 1;
    }
    //http://suggestqueries.google.com/complete/search?client=chrome&q=YOURQUERY&callback=callback
    var url = "https://www.googleapis.com/customsearch/v1/siterestrict?key="
        + apiKey + "&num=10&cx=" + csKey + "&start=" + startIndex + "&q=" + term + "&callback=?";
    console.log(term);

    console.log(url);
    $.getJSON(url, SearchCompleted);
}

function SearchCompleted(response)
{
    var html = "";
    $("#searchResult").html("");

    if (response.items == null)
    {
        $("#searchResult").html("No matching pages found");
        return;
    }

    if (response.items.length === 0)
    {
        $("#searchResult").html("No matching pages found");
        return;
    }

    $("#searchResult").html(response.queries.request[0].totalResults + " pages found");

    if (response.queries.nextPage != null)
    {
        _nextIndex = response.queries.nextPage[0].startIndex;
        $("#lnkNext").show();
    }
    else
    {
        $("#lnkNext").hide();
    }

    if (response.queries.previousPage != null)
    {
        _prevIndex = response.queries.previousPage[0].startIndex;
        $("#lnkPrev").show();
    }
    else
    {
        $("#lnkPrev").hide();
    }

    if (response.queries.request[0].totalResults > _resultsPerPage)
    {
        $("#lblPageNumber").show().html(_pageNumber);
    }
    else
    {
        $("#lblPageNumber").hide();
    }

    for (var i = 0; i < response.items.length; i++)
    {
        var item = response.items[i];
        var title = item.htmlTitle;

        html += "<div><br> <div class='hcHead2'> <a href='" + item.link + "' onclick=track('"+ item.link +"')>"+ title + "</a>" +
            "<div style='color:#006621;'>"+item.displayLink+"</div></div>";
        html += item.htmlSnippet + "</div><br>";
        console.log(item.link);
    }
    $('#logo').hide();
    $("#output").html(html);


}

function track(url) {
    //var data=encodeURIComponent(url);
    var toggleImg=$('#toggleImg').val();
    var sentNum=$('#sentNum').val();
    event.preventDefault();


    var encodedUrl=encodeURIComponent(url);
    window.location="track.php?img="+toggleImg+"&sentence="+sentNum+"&url="+encodedUrl;

}

