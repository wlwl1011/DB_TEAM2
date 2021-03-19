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
    <h1 style="text-align:center"> 데이터베이스 팀 프로젝트 3주차 과제 - Region </h1>
    <hr style = "border : 5px solid yellowgreen">
    <?php
        $sql="select count(*) as num from region";
        $result = mysqli_query($link, $sql);
        $data = mysqli_fetch_assoc($result);
    ?>
    <p> Province를 선택하세요 </p>
    <p>
        <h3>Region Info table (Currently <?php echo $data['num']; ?>) regions in database </h3>
    </p>
    <form method="post">
    <select name="attribute" id="attribute">
        <option value="all">all value</option>
        <option value="Seoul">Seoul</option>
        <option value="Busan">Busan</option>
        <option value="Daegu">Daegu</option>
        <option value="Incheon">Incheon</option>
        <option value="Ulsan">Ulsan</option>
        <option value="Gwangju">Gwangju</option>
        <option value="Daejeon">Daejeon</option>
        <option value="Sejong">Sejong</option>
        <option value="Gyeonggi-do">Gyeonggi-do</option>
        <option value="Gangwon-do">Gangwon-do</option>
        <option value="Chungcheongbuk-do">Chungcheongbuk-do</option>
        <option value="Chungcheongnam-do">Chungcheongnam-do</option>
        <option value="Jeollabuk-do">Jeollabuk-do</option>
        <option value="Jeollanam-do">Jeollanam-do</option>
        <option value="Gyeongsangbuk-do">Gyeongsangbuk-do</option>
        <option value="Gyeongsangnam-do">Gyeongsangnam-do</option>
        <option value="Jeju-do">Jeju-do</option>
    </select>
    <input type="submit" value="확인">
    </form>
    <table cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Region_Code</th>
            <th>Province</th>
            <th>City</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Elementary_school_count</th>
            <th>Kindergarten_count</th>
            <th>University_count</th>
            <th>Academy_ratio</th>
            <th>Eldery_population_ratio</th>
            <th>Eldery_alone_ratio</th>
            <th>Nursing_home_count</th>
        </tr>
        </thead>
        <tbody>
            <?php
	     $attribute_name=isset($_POST['attribute']) ? $_POST['attribute'] : "all";
	   
	    if ($attribute_name == "all" ){
                $sql = "select * from region";
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
	  else{
	 $sql = "select * from region where province = '$attribute_name' ";
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