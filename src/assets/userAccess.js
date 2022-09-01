function ajaxHandler(funcName,id){
    if(id === 'userLogin')
    {
        let formData = $( "form#userLogin" ).serializeArray();
        $.ajax({
            type: "POST",
            url: "functions.php",
            data:  {do: funcName,dataF:formData},
            success: function(){
                location.reload();
            }
        });
    }
    else if(id === 'userLogout')
    {
        let formData = $( "form#userLogout" ).serializeArray();
        $.ajax({
            type: "POST",
            url: "functions.php",
            data: {do: funcName, dataF: formData},
            success: function () {
                location.reload();
            }
        });
    }
    else if(id === 'userAdd')
    {
        let formData = $( "form#userAdd" ).serializeArray();
        $.ajax({
            type: "POST",
            url: "functions.php",
            data:  {do: funcName,dataF:formData},
            success: function(){
                $('#successRegister').show('slow');
                $('#successRegister').html('Registration is successful!');

                $( "form#userAdd" ).find("input[type=text],input[type=password]").val("");

                setTimeout(hideSpan, 5000);
                function hideSpan()
                {
                    $('#successRegister').hide();
                }

            }
        });
    }
}