$(document).ready(function() {
    $("#last_name, #first_name, #address1_line1, #address1_line2, #address2_line1, #address2_line2, #receipt_memo").keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });

    $("#tax_id_no, #post_code, #post_code2").keypress(function (evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode != 45  && charCode > 32 && (charCode < 48 || charCode > 57)) return evt.preventDefault();

        return true;
    }).on('paste', function () {
        var $this = $(this);
        setTimeout(function () {
            $this.val($this.val().replace(/[^0-9]/g, ''));
        }, 5);
    });
});