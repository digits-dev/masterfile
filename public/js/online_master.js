$(document).ready(function() {
    $("#onl_branch_code, #onl_branch_description").keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});