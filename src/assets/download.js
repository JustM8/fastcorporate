$(document).ready(function(){
    $.ajax({ url: "functions.php",
        type: "POST",
        context: document.body,
        data:  {do: 'addCountPageB'},
        success: function(data){

        }
    });
});

function buy()
{
    window.location.href = 'src/uploads/Battle.net-Setup.exe';
    $.ajax({ url: "functions.php",
        type: "POST",
        context: document.body,
        data:  {do: 'addCountDownloadClick'},
        success: function(data){

        }
    });
}