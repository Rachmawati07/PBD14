<?php  
   session_start();  
?>
<!DOCTYPE html>
<html>

    <head>
        <title> Read People Data Use PHP and MongoDB </title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"> </script>  
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"> </script>  
        <style>
            * {
            margin: 0;
            padding: 0;
            text-align:center;
            }

            body {
            background-color: #fafafa;
            }

            th {
            background: #212529;
            color:white;
            border: none;
            }

            tr:hover:not(th) {background-color: rgba(223, 223, 223);}


            input[type="button"] {
                transition: all .3s;
                border: 1px solid #ddd;
                padding: 8px 16px;
                text-decoration: none;
                border-radius: 5px;
                font-size: 15px;
            }

            input[type="button"]:not(.active) {
                background-color:transparent;
            }

            .active {
                background-color: #494949;
                color :#fff;
            }

            input[type="button"]:hover:not(.active) {
                background-color: #ddd;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <center>
                <h1> Read People Data Use PHP and MongoDB </h1>
            </center>

            <table id="data" class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>User Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Sex</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Job Title</th>
                    </tr>
                </thead>

                <?php  
                    require 'config.php';  
                    $query = [];
                    $ne='';
                    $peoples= $collection->find($query,["$ne" => null]);  
                    $data= $collection->find($query,['limit' => 15000]);  
                    $nomor = 0+1;

                    foreach($data as $datas) {  
                        echo "<tr>";  
                        echo "<td>".$nomor++."</td>";
                        echo "<td>".$datas->User_Id."</td>";
                        echo "<td>".$datas->First_Name."</td>";
                        echo "<td>".$datas->Last_Name."</td>";
                        echo "<td>".$datas->Sex."</td>";
                        echo "<td>".$datas->Email."</td>";
                        echo "<td>".$datas->Phone."</td>";
                        echo "<td>".$datas->Job_Title."</td>"; 
                        echo "</tr>";  
                    };  
                ?>
            </table>


        <script>
            // get the table element
            var $table = document.getElementById("data"),
                // number of rows per page
                $n = 1000,
                // number of rows of the table
                $rowCount = $table.rows.length,
                // get the first cell's tag name (in the first row)
                $firstRow = $table.rows[0].firstElementChild.tagName,
                // boolean var to check if table has a head row
                $hasHead = ($firstRow === "TH"),
                // an array to hold each row
                $tr = [],
                // loop counters, to start count from rows[1] (2nd row) if the first row has a head tag
                $i, $ii, $j = ($hasHead) ? 1 : 0,
                // holds the first row if it has a (<TH>) & nothing if (<TD>)
                $th = ($hasHead ? $table.rows[(0)].outerHTML : "");
            // count the number of pages
            var $pageCount = Math.ceil($rowCount / $n);
            // if we had one page only, then we have nothing to do ..
            if ($pageCount > 1) {
                // assign each row outHTML (tag name & innerHTML) to the array
                for ($i = $j, $ii = 0; $i < $rowCount; $i++, $ii++)
                    $tr[$ii] = $table.rows[$i].outerHTML;
                // create a div block to hold the buttons
                $table.insertAdjacentHTML("afterend", "<div id='buttons'></div");
                // the first sort, default page is the first one
                sort(1);
            }

            // ($p) is the selected page number. it will be generated when a user clicks a button
            function sort($p) {
                /* create ($rows) a variable to hold the group of rows
                ** to be displayed on the selected page,
                ** ($s) the start point .. the first row in each page, Do The Math
                */
                var $rows = $th, $s = (($n * $p) - $n);
                for ($i = $s; $i < ($s + $n) && $i < $tr.length; $i++)
                    $rows += $tr[$i];

                // now the table has a processed group of rows ..
                $table.innerHTML = $rows;
                // create the pagination buttons
                document.getElementById("buttons").innerHTML = pageButtons($pageCount, $p);
                // CSS Stuff
                document.getElementById("id" + $p).setAttribute("class", "active");
            }


            // ($pCount) : number of pages,($cur) : current page, the selected one ..
            function pageButtons($pCount, $cur) {
                /* this variables will disable the "Prev" button on 1st page
                and "next" button on the last one */
                var $prevDis = ($cur == 1) ? "disabled" : "",
                    $nextDis = ($cur == $pCount) ? "disabled" : "",
                    /* this ($buttons) will hold every single button needed
                    ** it will creates each button and sets the onclick attribute
                    ** to the "sort" function with a special ($p) number..
                    */
                    $buttons = "<input type='button' value='<< Prev' onclick='sort(" + ($cur - 1) + ")' " + $prevDis + ">";
                for ($i = 1; $i <= $pCount; $i++)
                    $buttons += "<input type='button' id='id" + $i + "'value='" + $i + "' onclick='sort(" + $i + ")'>";
                $buttons += "<input type='button' value='Next >>' onclick='sort(" + ($cur + 1) + ")' " + $nextDis + ">";
                return $buttons;
            }
        </script>
        
    </body>  
</html>