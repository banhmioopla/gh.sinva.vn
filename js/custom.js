$(document).ready(function () {
    $('.dataTables_paginate').parents('div').removeClass('col-sm-12 col-md-7');

});

function tab_key() {
    $(this).data('editable').input.$input.on('keydown', function (e) {

        if (e.which == 9) {                                      // when tab key is pressed
            e.preventDefault();
            if (e.shiftKey) {                                      // shift + tab
                $(this).blur()
                    .parents().prevAll(":has(.editable):first") // find the parent of the editable before this one in the markup
                    .find(".editable:last").editable('show');   // grab the editable and display it
            } else {                                              // just tab
                $(this).blur()
                    .parents().nextAll(":has(.editable):first") // find the parent of the editable after this one in the markup
                    .find(".editable:first").editable('show');  // grab the editable and display it
            }
        }
    });
}

function nFormatter(num, digits = 1) {
    var si = [
        { value: 1, symbol: "" },
        { value: 1E3, symbol: " k" },
        { value: 1E6, symbol: " mi" },
        { value: 1E9, symbol: "bi" },
        { value: 1E12, symbol: "T" },
        { value: 1E15, symbol: "P" },
        { value: 1E18, symbol: "E" }
    ];
    var rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
    var i;
    for (i = si.length - 1; i > 0; i--) {
        if (num >= si[i].value) {
            break;
        }
    }
    return (num / si[i].value).toFixed(digits).replace(rx, "$1") + si[i].symbol;
}
