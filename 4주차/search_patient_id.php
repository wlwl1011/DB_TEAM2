<html>
<head>
<style>
    #map {
        width: 100%;
        height: 400px;
    }
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrqcRn2_l0rUw3cma2uUfLw0K6Y6nHzV0&callback=initMap"async defer></script>

    <script>
        function showMap(lat, lng){
            var e= document.getElementById('map');
 	var mrhi = new google.maps.LatLng(lat, lng);
	var opts= {
                center: mrhi, 
                zoom: 14
            }
            var map = new google.maps.Map(e, opts);
	var marker = new google.maps.Marker( {position: mrhi} );
            marker.setMap(map);
        }
</script>
</head>
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
    <h1 style="text-align:center"> 데이터베이스 팀 프로젝트 4주차 - Searching Patient_id </h1>
    <hr style = "border : 5px solid yellowgreen">
<form method="post">
  Put Patient_id : <input type="text" name="patient_id" placeholder="patient_id를 입력해주세요.">
  <input type="submit">
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
            <th>Hospital_id</th>
        </tr>
        </thead>

        <tbody>
            <?php	    

	        if (isset($_POST["patient_id"])){
                        $patient_id=$_POST["patient_id"];
	            $sql = "select * from patientinfo where patient_id = '$patient_id' ";
		$result = mysqli_query($link,$sql);
		$sql2 = "select latitude, longitude from Hospital where Hospital.hospital_id = (select hospital_id from patientinfo where patient_id = '$patient_id')";
                        $result2 = mysqli_query($link,$sql2);
                        $row = mysqli_fetch_array($result);
		$row2 = mysqli_fetch_array($result2);
                            print "<tr>";
		    print "<td>";
		    echo $row["patient_id"];
		    print "</td>";
		    print "<td>";
		    echo $row["sex"];
		    print "</td>";
		    print "<td>";
		    echo $row["age"];
		    print "</td>";
		    print "<td>";
		    echo $row["country"];
		    print "</td>";
		    print "<td>";
		    echo $row["province"];
		    print "</td>";
		    print "<td>";
		    echo $row["city"];
		    print "</td>";
		    print "<td>";
		    echo $row["infection_case"];
		    print "</td>";
		    print "<td>";
		    echo $row["infected_by"];
		    print "</td>";
		    print "<td>";
		    echo $row["contact_number"];
		    print "</td>";
		    print "<td>";
		    echo $row["symptom_onset_date"];
		    print "</td>";
		    print "<td>";
		    echo $row["confirmed_date"];
		    print "</td>";
		    print "<td>";
		    echo $row["released_date"];
		    print "</td>";
		    print "<td>";
		    echo $row["deceased_date"];
		    print "</td>";
		    print "<td>";
		    echo $row["state"];
		    print "</td>";

		    echo "<td onclick=\"showMap(" .$row2[0]. "," .$row2[1]. ")\" style=\"cursor:pointer;\">";
		    echo $row["hospital_id"];
		    print "</td>";

                            print "</tr>";
		    }
	        

	    else {
	            $sql = "select * from patientinfo where patient_id = '' ";
                        $result = mysqli_query($link,$sql);
                        while( $row = mysqli_fetch_assoc($result)  )
                        {
                            print "<tr>";
		    print "<td>";
		    echo $row["patient_id"];
		    print "</td>";
		    print "<td>";
		    echo $row["sex"];
		    print "</td>";
		    print "<td>";
		    echo $row["age"];
		    print "</td>";
		    print "<td>";
		    echo $row["country"];
		    print "</td>";
		    print "<td>";
		    echo $row["province"];
		    print "</td>";
		    print "<td>";
		    echo $row["city"];
		    print "</td>";
		    print "<td>";
		    echo $row["infection_case"];
		    print "</td>";
		    print "<td>";
		    echo $row["infected_by"];
		    print "</td>";
		    print "<td>";
		    echo $row["contact_number"];
		    print "</td>";
		    print "<td>";
		    echo $row["symptom_onset_date"];
		    print "</td>";
		    print "<td>";
		    echo $row["confirmed_date"];
		    print "</td>";
		    print "<td>";
		    echo $row["released_date"];
		    print "</td>";
		    print "<td>";
		    echo $row["deceased_date"];
		    print "</td>";
		    print "<td>";
		    echo $row["state"];
		    print "</td>";
		    print "<td>";
		    echo $row["hospital_id"];
		    print "</td>";

                            print "</tr>";
                        }
	        }
            ?>
            
        </tbody>
    </table>

    <div id="map"></div>
</body>
</html>