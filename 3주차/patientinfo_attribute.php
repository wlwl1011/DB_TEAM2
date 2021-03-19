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
    <h1 style="text-align:center"> 데이터베이스 팀 프로젝트 3주차 - Patient Info2 </h1>
    <hr style = "border : 5px solid yellowgreen">
    <?php
        $sql="select count(*) as num from PatientInfo";
        $result = mysqli_query($link, $sql);
        $data = mysqli_fetch_assoc($result);
    ?>
    <p> Confirmed_date(month)를 선택하세요</p>
    <p>
        <h3>Patient Info table (Currently <?php echo $data['num']; ?>) confirmed dates in database </h3>
    </p>
    <form method="post">
    <select name="attribute" id="attribute">
        <option value="10" selected>all value</option>
        <option value="1">1월</option>
        <option value="2">2월</option>
        <option value="3">3월</option>
        <option value="4">4월</option>
        <option value="5">5월</option>
        <option value="6">6월</option>
    </select>
    <input type="submit" value="확인">
    </form>


    <table cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>patient_id</th>
            <th>sex</th>
            <th>age</th>
            <th>country</th>
            <th>province</th>
            <th>city</th>
            <th>infection_case</th>
            <th>infected_by</th>
            <th>contact_number</th>
            <th>symptom_onset_date</th>
            <th>confirmed_date</th>
            <th>released_date</th>
            <th>deceased_date</th>
            <th>state</th>
        </tr>
        </thead>

        <tbody>
            <?php	    

	        $attribute_num=isset($_POST['attribute']) ? $_POST['attribute'] : 0;
	        if ($attribute_num == 0){
	            $sql = "select * from patientinfo limit 100";
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
                    else if ($attribute_num == "1"){
                        $sql = "select * from patientinfo where confirmed_date between '2020-01-01' and '2020-01-31' order by confirmed_date asc";
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
                    $sql = "select * from patientinfo where confirmed_date between '2020-02-01' and '2020-02-29' order by confirmed_date asc";
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
                    $sql = "select * from patientinfo where confirmed_date between '2020-03-01' and '2020-03-31' order by confirmed_date asc";
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
                    $sql = "select * from patientinfo where confirmed_date between '2020-04-01' and '2020-04-31' order by confirmed_date asc";
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
                    $sql = "select * from patientinfo where confirmed_date between '2020-05-01' and '2020-05-31' order by confirmed_date asc";
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
                    $sql = "select * from patientinfo where confirmed_date between '2020-06-01' and '2020-06-31' order by confirmed_date asc";
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
	    else if ($attribute_num == "10"){
	            $sql = "select * from patientinfo limit 100";
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