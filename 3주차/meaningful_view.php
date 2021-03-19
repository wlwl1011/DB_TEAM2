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
    <h1 style="text-align:center"> 데이터베이스 팀 프로젝트 3주차 - 2팀</h1>
    <hr style = "border : 5px solid yellowgreen">
    <?php
        $sql="select count(patientinfo.patient_id) as num from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and infection_group = 0";
        $result = mysqli_query($link, $sql);
        $data = mysqli_fetch_assoc($result);
    ?>
    <p>
        <h3>Team 2 table (Currently <?php echo $data['num']; ?>) dates in database </h3>
    </p>
    <form method="post">
    <select name="attribute" id="attribute">
        <option value="10" selected>all value</option>
        <option value="1">not group infection</option>
    </select>
    <input type="submit" value="확인">
    </form>


    <table cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>count(avg_temp)</th>
            <th>MIN(avg_temp)</th>
            <th>MAX(agv_temp)</th>
        </tr>
        </thead>

        <tbody>
            <?php
                $attribute_num=isset($_POST['attribute']) ? $_POST['attribute'] : 100;

                if ($attribute_num == "100"){
                    $sql = " (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 5.0) UNION (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 10.0 and avg_temp > 5.0) UNION (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 15.0 and avg_temp > 10.0) UNION (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 20.0 and avg_temp > 15.0) UNION (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 25.0 and avg_temp > 20.0) UNION (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 30.0 and avg_temp > 25.0)";
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
                    $sql = " (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 5.0 and infection_group = 0) UNION (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 10.0 and avg_temp > 5.0 and infection_group = 0) UNION (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 15.0 and avg_temp > 10.0 and infection_group = 0) UNION (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 20.0 and avg_temp > 15.0 and infection_group = 0) UNION (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 25.0 and avg_temp > 20.0 and infection_group = 0) UNION (select count(avg_temp),MIN(avg_temp), MAX(avg_temp) from weather,caseinfo,region, patientinfo where caseinfo.infection_case = patientinfo.infection_case and caseinfo.province = patientinfo.province and patientinfo.province = region.province and patientinfo.city = region.city and weather.region_code = region.region_code and weather.province = patientinfo.province and weather.wdate = patientinfo.confirmed_date and avg_temp <= 30.0 and avg_temp > 25.0 and infection_group = 0)";
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