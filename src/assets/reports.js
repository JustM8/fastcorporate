$(document).ready(function(){
    $.ajax({ url: "functions.php",
        type: "POST",
        context: document.body,
        data:  {do: 'getActivity'},
        success: function(dataT){
            $("#table").html(dataT);

            $('#userSort').click(function() {
                sortTable('userSort');
            });
            $('#dateSort').click(function() {
                sortTable('dateSort');
            });

        }
    });


});
function sortTable(funcName){
    $.ajax({
        type: "POST",
        url: "functions.php",
        data:  {do: funcName},
        success: function(data){
            $("#table").html(data);

            $('#userSort').click(function() {
                sortTable('userSort');
            });
            $('#dateSort').click(function() {
                sortTable('dateSort');
            });
        }
    });
}