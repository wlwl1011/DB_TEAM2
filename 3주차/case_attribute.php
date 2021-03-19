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
    <h1 style="text-align:center"> 데이터베이스 팀 프로젝트 3주차 과제 - Case2 </h1>
    <hr style = "border : 5px solid yellowgreen">
    <?php
        $sql="select count(*) as num from caseinfo";
        $result = mysqli_query($link, $sql);
        $data = mysqli_fetch_assoc($result);
    ?>
    <p> Infection case를 선택하세요</p>
   <form method="post">
   <select name="attribute" id="attribute">
	<option value="10" selected>all value</option>
	<option value="1">Group infection</option>
	<option value="0">None Group infection</option> 
   </select>
    <input type="submit" value="확인">
    </form>
    <p>
        <h3>Case table (Currently <?php echo $data['num']; ?>) patients in database </h3>
    </p>
   
    <table cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Case_ID</th>
            <th>Province</th>
            <th>City</th>
            <th>Infection_Group</th>
            <th>Infection_Case</th>
            <th>Confirmed</th>
            <th>Latitude</th>
            <th>Longtitude</th>
        </tr>
        </thead>

        <tbody>
            <?php
	     $attribute_num=isset($_POST['attribute']) ? $_POST['attribute'] : 100;
	   
	    if ($attribute_num == 100 ){
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
	}
	  else if($attribute_num == "1"){
	 $sql = "select * from caseinfo where infection_group = 1 ";
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
	  else if($attribute_num == "0"){
	 $sql = "select * from caseinfo where infection_group = 0 ";
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
 	   else if($attribute_num == "10"){
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
	}
            ?>
            
        </tbody>
    </table>


</body>s