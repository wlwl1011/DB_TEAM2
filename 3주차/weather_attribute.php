<?php
    $link = mysqli_connect("localhost","root","Eh4693227!", "k_covid19");
    if( $link === false )
    {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    echo "Coneect Successfully. Host info: " . mysqli_get_host_info($link) . "\n";
?>
<style>
    table {
        width: 100%;
        border: 1px solid #444444;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #444444;
    }
</style>
<body>
    <h1 style="text-align:center"> 데이터베이스 팀 프로젝트 3주차 - Weather2 </h1>
    <hr style = "border : 5px solid yellowgreen">
    <?php
        $sql="select count(*) as num from weather";
        $result = mysqli_query($link, $sql);
        $data = mysqli_fetch_assoc($result);
    ?>
    <p> avg_temp를 선택하세요 </p>
    <p>
        <h3>Weather table (Currently <?php echo $data['num']; ?>) dates in database </h3>
    </p>
    <form method="post">
    <select name="attribute" id="attribute">
        <option value="10" selected>all value</option>
        <option value="1">value<0</option>
        <option value="2">0<=value<5</option>
        <option value="3">5<=value<10</option>
        <option value="4">10<=value<15</option>
        <option value="5">15<=value<20</option>
        <option value="6">20<=value<25</option>
        <option value="7">25<=value<30</option>
    </select>
    <input type="submit" value="확인">
    </form>


    <table cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>code</th>
            <th>province</th>
            <th>date</th>
            <th>avg_temp</th>
            <th>min_temp</th>
            <th>max_temp</th>
        </tr>
        </thead>

        <tbody>
            <?php
                $attribute_num=isset($_POST['attribute']) ? $_POST['attribute'] : 100;

                if ($attribute_num == "100"){
                    $sql = "select * from weather order by avg_temp desc limit 100";
                    $result = mysqli_query($link,$sql);
                    while( $row = mysqli_fetch_assoc($result)  )
                    {
                        print "<tr>";
                        foreach($row as $key => $val)
                        {
                            print "<td>" . $val . "</td>";
                        }
                        print "</tr>";
                    }
                }

                if ($attribute_num == "1"){
                    $sql = "select * from weather where avg_temp<0 order by avg_temp asc";
                    $result = mysqli_query($link,$sql);
                    while( $row = mysqli_fetch_assoc($result)  )
                    {
                        print "<tr>";
                        foreach($row as $key => $val)
                        {
                            print "<td>" . $val . "</td>";
                        }
                        print "</tr>";
                    }
                }

                else if ($attribute_num == "2"){
                    $sql = "select * from weather where 0<=avg_temp and avg_temp<5 order by avg_temp asc";
                    $result = mysqli_query($link,$sql);
                    while( $row = mysqli_fetch_assoc($result)  )
                    {
                        print "<tr>";
                        foreach($row as $key => $val)
                        {
                            print "<td>" . $val . "</td>";
                        }
                        print "</tr>";
                    }
                }

                else if ($attribute_num == "3"){
                    $sql = "select * from weather where 5<=avg_temp and avg_temp<10 order by avg_temp asc";
                    $result = mysqli_query($link,$sql);
                    while( $row = mysqli_fetch_assoc($result)  )
                    {
                        print "<tr>";
                        foreach($row as $key => $val)
                        {
                            print "<td>" . $val . "</td>";
                        }
                        print "</tr>";
                    }
                }

                else if ($attribute_num == "4"){
                    $sql = "select * from weather where 10<=avg_temp and avg_temp<15 order by avg_temp asc";
                    $result = mysqli_query($link,$sql);
                    while( $row = mysqli_fetch_assoc($result)  )
                    {
                        print "<tr>";
                        foreach($row as $key => $val)
                        {
                            print "<td>" . $val . "</td>";
                        }
                        print "</tr>";
                    }
                }

                else if ($attribute_num == "5"){
                    $sql = "select * from weather where 15<=avg_temp and avg_temp<20 order by avg_temp asc";
                    $result = mysqli_query($link,$sql);
                    while( $row = mysqli_fetch_assoc($result)  )
                    {
                        print "<tr>";
                        foreach($row as $key => $val)
                        {
                            print "<td>" . $val . "</td>";
                        }
                        print "</tr>";
                    }
                }

                else if ($attribute_num == "6"){
                    $sql = "select * from weather where 20<=avg_temp and avg_temp<25 order by avg_temp asc";
                    $result = mysqli_query($link,$sql);
                    while( $row = mysqli_fetch_assoc($result)  )
                    {
                        print "<tr>";
                        foreach($row as $key => $val)
                        {
                            print "<td>" . $val . "</td>";
                        }
                        print "</tr>";
                    }
                }

                else if ($attribute_num == "7"){
                    $sql = "select * from weather where 25<=avg_temp and avg_temp<30 order by avg_temp asc";
                    $result = mysqli_query($link,$sql);
                    while( $row = mysqli_fetch_assoc($result)  )
                    {
                        print "<tr>";
                        foreach($row as $key => $val)
                        {
                            print "<td>" . $val . "</td>";
                        }
                        print "</tr>";
                    }
                }

                else {
                    $sql = "select * from weather order by avg_temp desc limit 100";
                    $result = mysqli_query($link,$sql);
                    while( $row = mysqli_fetch_assoc($result)  )
                    {
                        print "<tr>";
                        foreach($row as $key => $val)
                        {
                            print "<td>" . $val . "</td>";
                        }
                        print "</tr>";
                    }
                }

            ?>
            
        </tbody>
    </table>


</body>