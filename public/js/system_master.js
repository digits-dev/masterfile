$(document).ready(function() {
    $("#system_code, #system_description").keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});