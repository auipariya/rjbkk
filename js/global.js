/**
 * Created by Aui on 23/6/2559.
 */
if(typeof jQuery === 'undefined'){
    throw new Error('Main\'s JavaScript requires jQuery');
}

// Global variables
var optionsDate = {
    format: 'DD/MM/YYYY',
    collapse: false,
    useCurrent: false,
    showTodayButton: true,
    showClear: true
};

var optionTime = {
    format: 'LT',
    useCurrent: true
};

$.ajax();

showLoading();
$(document).ajaxStop(function(){
    hideLoading();
});


function showLoading () {
    $('<div>', { class: 'modal-loading' }).prependTo($('body'));
}

function hideLoading () {
    $('div[class="modal-loading"]').remove();
}

// fill zero time en-US
function fillZeroTime (time) {
    if(time != null){
        if(time.indexOf(':') == 1){
            time = '0' + time;
        }
    }

    return time;
}

Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

Date.prototype.formatTimeUS = function () {
    var timeUS = this.toLocaleTimeString('en-US', { hour: 'numeric', hour12: true, minute: 'numeric', minute60: true });
    if(timeUS.indexOf(':') == 1){
        timeUS = '0' + timeUS;
    }
    return timeUS;
}

