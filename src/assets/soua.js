$(document).ready(function(){

    $.ajax({ url: "functions.php",
        type: "POST",
        context: document.body,
        data:  {do: 'getTable'},
        success: function(data){
            $("#table").html(data);
        }
    });
    $.ajax({ url: "functions.php",
        type: "POST",
        context: document.body,
        data:  {do: 'getStat'},
        success: function(dataT){
            // console.log(dataT);
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable(JSON.parse(dataT));
                var options = {
                    title: 'reports graph',
                    hAxis: {title: 'Date'},
                    vAxis: {title: 'Count'}
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('oil'));
                chart.draw(data, options);
            }
        }
    });
});