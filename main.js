

var unirest = require('unirest');
export function track(link) {

    unirest.post("https://textanalysis-text-summarization.p.rapidapi.com/text-summarizer-url")
        .header("X-RapidAPI-Host", "textanalysis-text-summarization.p.rapidapi.com")
        .header("X-RapidAPI-Key", "a06a6a0a8emsh9b48b465f420022p19b84cjsnf6fcb4b13432")
        .header("Content-Type", "application/x-www-form-urlencoded")
        .send("url="+link)
        .send("sentnum=10")
        .end(function (result) {
            console.log(result.status, result.headers, result.body);
        });

}
