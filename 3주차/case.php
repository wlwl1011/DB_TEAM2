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
    <h1 style="text-align:center"> 데이터베이스 팀 프로젝트 3주차 과제 - Case </h1>
    <hr style = "border : 5px solid yellowgreen">
    <?php
        $sql="select count(*) as num from caseinfo";
        $result = mysqli_query($link, $sql);
        $data = mysqli_fetch_assoc($result);
    ?>
    <p>
        <h3>Case table (Currently <?php echo $data['num']; ?>) patients in database </h3>
    </p>

    <table cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Case_ID</th>
            <th>Province</th>
            <th>City</th>
            <th>Group</th>
            <th>Infection_Case</th>
            <th>Confirmed</th>
            <th>Latitude</th>
            <th>Longtitude</th>
        </tr>
        </thead>
        <tbody>
            <?php
                $sql = "select * from caseinfo";
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
            ?>
            
        </tbody>
    </table>


</body>