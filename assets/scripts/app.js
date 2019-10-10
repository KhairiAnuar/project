$(document).ready(function () {
    $("#query").autocomplete({
        source: function(request, response) {
            $.getJSON("http://suggestqueries.google.com/complete/search?callback=?",
                {
                    "hl":"en", // Language
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

jQuery.fn.eq_mod = function (index) {
    return jQuery(this[index % this.length]);
};

var idleTriggerTime = 4;
var idleLoopTime = 4;
var idleAnimationDuration = 2;
var idleTime = 0;

function resetIdlePrompts() {
    idleTime = 0;
    $('.show-idle-prompt').removeClass('idle');
}

$(this).keypress(resetIdlePrompts).mouseover(resetIdlePrompts);
document.addEventListener('touchmove', resetIdlePrompts);
var nextIdleElement = 0;
var idleInterval = setInterval(function () {
    idleTime = idleTime + 1;

    if (idleTime >= idleTriggerTime) {
        var sinceTrigger = idleTime - idleTriggerTime;

        if (sinceTrigger % idleLoopTime == 0) {
            $('.show-idle-prompt').eq_mod(nextIdleElement).addClass('idle');
            nextIdleElement++;
        } else if (sinceTrigger % idleLoopTime == idleAnimationDuration) {
            $('.show-idle-prompt').removeClass('idle');
        }
    }
}, 1000);
});


/*?$(document).ready(function () {
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
});*/