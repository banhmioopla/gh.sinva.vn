
let notify_html_success = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Cập nhật thành công
                </div>`;
let notify_html_fail = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Cập nhật thất bại
                </div>`;

function tab_key() {
    $(this).data('editable').input.$input.on('keydown', function (e, p) {

        if (e.which == 9) {                                      // when tab key is pressed
            e.preventDefault();
            if (e.shiftKey) {
                $(this).submit();                                     // shift + tab
                $(this).blur()
                    .parents().prevAll(":has(.editable):first") // find the parent of the editable before this one in the markup
                    .find(".editable:last").editable('show');   // grab the editable and display it
            } else {
                $(this).submit();                                           // just tab
                $(this).blur()
                    .parents().nextAll(":has(.editable):first") // find the parent of the editable after this one in the markup
                    .find(".editable:first").editable('show');  // grab the editable and display it
            }
        }
    });
}