<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forecast</title>
    <style>
        .form {
            float: left;
            max-width: 30%;
            padding: 20px 12px 10px 20px;
            font: 13px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
        }
        .results {
            padding: 20px 12px 10px 20px;
            font: 13px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
            min-width: 70%;
            max-width: 70%;
            float: left;
        }
        li {
            padding: 0;
            display: block;
            list-style: none;
            margin: 10px 0 0 0;
        }
        label{
            margin:0 0 3px 0;
            padding:0px;
            display:block;
            font-weight: bold;
        }
        input {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            border:1px solid #BEBEBE;
            padding: 7px;
            margin:0px;
            -webkit-transition: all 0.30s ease-in-out;
            -moz-transition: all 0.30s ease-in-out;
            -ms-transition: all 0.30s ease-in-out;
            -o-transition: all 0.30s ease-in-out;
            outline: none;
        }
        button{
            background: #4B99AD;
            padding: 8px 15px 8px 15px;
            border: none;
            color: #fff;
        }
        button:hover{
            background: #4691A4;
            box-shadow:none;
            -moz-box-shadow:none;
            -webkit-box-shadow:none;
        }

        #emptyTable {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #emptyTable td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #emptyTable tr:nth-child(even){background-color: #f2f2f2;}

        #emptyTable tr:hover {background-color: #ddd;}

        #emptyTable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4B99AD;
            color: white;
        }
    </style>
</head>
<body>
    <div class="form">
        <H2>PARAMETERS</H2>
        <ul>
            <li><label for="studies_per_day">Studies per Day:</label></li>
            <li><input type="number" name="studies_per_day" id="studies_per_day" min="1" value="1"></li>
            <li><label for="studies_growth_per_month">Growth per Month (%):</label></li>
            <li><input type="number" name="studies_growth_per_month" id="studies_growth_per_month" min="1" max="100" value="1"></li>
            <li><label for="months">No. of Months:</label></li>
            <li><input type="number" name="months" id="months" min="1" value="1"></li>
            <li><button onclick="calculate()">CALCULATE</button>
            <button onclick="reset_form()">RESET</button></li>
        </ul>
    </div>
    <div class="results">
        <H2>RESULTS</H2>
        <table id='emptyTable' border='1' width="100%">
            <thead>
                <tr>
                    <th>Month Year</th>
                    <th>Studies</th>
                    <th>RAM Cost</th>
                    <th>Storage Cost</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script>
        function reset_form() {
            document.getElementById('studies_per_day').value = 1;
            document.getElementById('studies_growth_per_month').value = 1;
            document.getElementById('months').value = 1;
            var table = document.getElementById("emptyTable").getElementsByTagName("tbody")[0];
            table.innerHTML = "";
        }
        function calculate() {
            var spd = document.getElementById('studies_per_day').value;
            var sgpm = document.getElementById('studies_growth_per_month').value;
            var m = document.getElementById('months').value;
            var form_data = {studies_per_day:spd, studies_growth_per_month: sgpm, months: m};
            server_side_calculation(form_data);
        }

        function server_side_calculation(data) {
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "compute_data.php", true); 
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    var emptyTable = document.getElementById("emptyTable").getElementsByTagName("tbody")[0];

                    emptyTable.innerHTML = "";
                    for (var key in response) {
                        if (response.hasOwnProperty(key)) {
                            var val = response[key];
                        
                            var NewRow = emptyTable.insertRow(); 
                            var month_year_cell = NewRow.insertCell(0); 
                            var studies_cell = NewRow.insertCell(1); 
                            var ram_cost_cell = NewRow.insertCell(2);
                            var storage_cost_cell = NewRow.insertCell(3);

                            month_year_cell.innerHTML = val['month']; 
                            studies_cell.innerHTML = val['studies']; 
                            ram_cost_cell.innerHTML = val['ram_cost']; 
                            storage_cost_cell.innerHTML = val['storage_cost']; 

                        }
                    } 
                }
            };
            xhttp.send(JSON.stringify(data));
        }

    </script>
</body>
</html>