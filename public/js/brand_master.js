$(document).ready(function() {
    $("#brand_code, #brand_description").keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });

    $('#brand_description').on('keyup mouseenter', function() {
        var count = document.getElementById('brand_description').value.length;
        document.getElementById('id_brand_description').innerHTML = 'Character Count: '+ count;
        if(count >= 30)
        {
            document.getElementById('id_brand_description').style.color = 'red';
            $('#brand_description').css('border-color', 'red');
            $('#brand_description').focus();
        }
        else if(count == 0)
        {
            document.getElementById('id_brand_description').innerHTML = '';
            $('#brand_description').css('border-color', 'gray');
        }
            
        else
        {
            document.getElementById('id_brand_description').style.color = 'black';
            $('#brand_description').css('border-color', 'gray');
        }
            
    });


    $("form").submit(function(){
        checked = $("input[type=checkbox]:checked").length;
  
        if(!checked) {
          alert("You must check at least one checkbox.");
          return false;
        }
  
    });


    //alert("yes");

});