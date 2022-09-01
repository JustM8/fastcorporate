$(document).ready(function(){

    $.ajax({ url: "functions.php",
        type: "POST",
        context: document.body,
        data:  {do: 'addCountPageA'},
        success: function(data){

        }
    });
});

function buy()
{
    $('#btnCow').hide();
    $('#tnxSpan').show('slow');

    $.ajax({ url: "functions.php",
        type: "POST",
        context: document.body,
        data:  {do: 'addCountCowClick'},
        success: function(data){

        }
    });
}