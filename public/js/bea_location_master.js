$(document).ready(function() {
    $("#bea_location_description").keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});