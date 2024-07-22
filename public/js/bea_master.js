$(document).ready(function() {
    $("#bea_pricelist_description").keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});