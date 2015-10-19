<?php
//$title=trim($_GET['title']);

// 1. Establish DB Connection
$host = "uscitp.com";
$username = "tbian_test";
$password = "btbtbt@9";
$database = "tbian_LACounty";

$conn = mysqli_connect($host, $username, $password, $database);

if(mysqli_connect_errno()){
    exit("DB Connection Error: " . mysqli_connect_error());
}

// 2. Generate & Submit SQL
$sql = "SELECT *
       FROM tbian_LACounty.DeclineInValue_ParcelStatus

		 
";

$results = mysqli_query($conn, $sql);
if(!$results){
    exit("SQL Error: " . mysqli_error($conn));
}

// 3. Display data
echo "Your search returned: : " . mysqli_num_rows($results) . " results.<br><br>";

?>

<table>
    <tr>
        <td>RecID</td>
        <td>AIN</td>
        <td>RollYYYY</td>
        <td>DateAdded</td>
		<td>LastUpdated</td>
        <td>DateRemoved</td>
        <td>isProp8Restoration</td>
		<td>isProactiveProp8</td>
        <td>statusApplication</td>
		<td> statusRequestReview</td> 
		<td> isOtherValuation</td> 
		<td> Prop8_LandValue</td> 
		<td> Prop8_ImpValue</td> 
		<td> Prop8_ExemptionType</td> 
		<td> Prop8_ExemptionAmount</td> 
		<td> OptionalMessage</td> 
		<td> LastLetterMailDate</td> 
		<td> LastLetterType</td> 
        
    </tr>

    <?php
    while($row = mysqli_fetch_array($results)){
        echo "<tr>";
        
        echo "<td style='".
        "background-color:green;width:40px;"."'>"  . $row['RecID'] . "</td>";
        echo "<td style='".
        "background-color:pink;width:40px;"."'>" . $row['AIN'] . "</td>";
        echo "<td style='".
        "background-color:yellow;width:40px;"."'>" . $row['RollYYYY'] . "</td>";
		echo "<td style='".
        "background-color:blue;width:40px;"."'>" . $row['DateAdded'] . "</td>";
		echo "<td style='".
        "background-color:red;width:40px;"."'>" . $row['LastUpdated'] . "</td>";
		echo "<td style='".
        "background-color:lightblue;width:40px;"."' >" . $row['DateRemoved'] . "</td>";
		echo "<td style='".
        "background-color:gray;width:40px;"."'>" . $row['isProactiveProp8'] . "</td>";
		echo "<td style='".
        "background-color:green;width:40px;"."'>" . $row['isProp8Restoration'] . "</td>";
       
		echo "<td style='".
        "background-color:white;width:40px;"."'>" . $row['statusApplication'] . "</td>";
       
		
		echo "<td style='".
        "background-color:lightgreen;width:40px;"."'>" . $row['statusRequestReview'] . "</td>";
        
		echo "<td style='".
        "background-color:orange;width:40px;"."'>" . $row['isOtherValuation'] . "</td>";
        
		echo "<td style='".
        "background-color:lightblue;width:40px;"."'>" . $row['Prop8_LandValue'] . "</td>";
      
		echo "<td style='".
        "background-color:silver;width:40px;"."'>" . $row['Prop8_ImpValue'] . "</td>";
      
		echo "<td style='".
        "background-color:gray;width:40px;"."'>" . $row['Prop8_ExemptionType'] . "</td>";
       
		echo "<td style='".
        "background-color:purple;width:40px;"."'>" . $row['Prop8_ExemptionAmount'] . "</td>";
       
		echo "<td style='".
        "background-color:yellow;width:40px;"."'>" . $row['OptionalMessage'] . "</td>";
        
		echo "<td style='".
        "background-color:pink;width:40px;"."'>" . $row['LastLetterMailDate'] . "</td>";
       
		echo "<td style='".
        "background-color:silver;width:40px;"."'>" . $row['LastLetterType'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>






