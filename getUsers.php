<?php
/**
 * Created by PhpStorm.
 * User: josephcantrell14
 * Date: 7/20/2017
 * Time: 2:12 PM
 */


require "database.php";
$db = new Database(true);

$active = $_GET['a'];
$search = $_GET['s'];
$users = null;
$MgrResult = $db->query("SELECT gtAccount, firstName, lastName FROM `person` WHERE Mgr ='Y'");
$MgrResults = array();
$MgrResults[0] = "None";
$i = 1;
while ($row = mysqli_fetch_array($MgrResult)) {
    $MgrResults[$i] = array('name' => $row['firstName']." ".$row['lastName'], 'id' => $row['gtAccount']);
    $i++;
}
$MgrOptionsMask = json_encode($MgrResults); //Must JSON encode for Ajax + JavaScript onclick

echo "<table>";
echo "<tr style='font-weight: bold;'>
    <td>GT Account</td><td>First Name</td><td>Last Name</td><td>Email</td><td>Status</td><td>Mgr</td><td>Supervisor</td><td>Department</td><td>EDIT</td>
    </tr>";
$query = "";
if ($active == "All Users") {
    if ($search == "") {
        $query = "SELECT * FROM `person` ORDER BY `lastName`, `firstName`";
    } else {
        $query = "SELECT * FROM `person` WHERE (`firstName` LIKE '%".$search."%' OR `lastName` LIKE '%".$search."%') ORDER BY `lastName`, `firstName`";
        //$query = "SELECT * FROM `person` WHERE (MATCH(`firstName`) AGAINST(".$search.") OR MATCH(`lastName`) AGAINST(".$search.")) ORDER BY `lastName`, `firstName`";
    }
} else if ($active == "Active Users") {
    if ($search == "") {
        $query = "SELECT * FROM `person` WHERE `status` = 'A' ORDER BY `lastName`, `firstName`";
    } else {
        $query = "SELECT * FROM `person` WHERE `status` = 'A' AND (`firstName` LIKE '%".$search."%' OR `lastName` LIKE '%".$search."%') ORDER BY `lastName`, `firstName`";
    }
} else if ($active == "Inactive Users") {
    if ($search == "") {
        $query = "SELECT * FROM `person` WHERE `status` = 'N' ORDER BY `lastName`, `firstName`";
    } else {
        $query = "SELECT * FROM `person` WHERE `status` = 'N' AND (`firstName` LIKE '%".$search."%' OR `lastName` LIKE '%".$search."%') ORDER BY `lastName`, `firstName`";
    }
}
$users = $db->query($query);
for ($i = 0; $i < mysqli_num_rows($users); $i++) {
    $user = mysqli_fetch_array($users);
    $id = $user['gtAccount'];
    $firstName = $user['firstName'];
    $lastName = $user['lastName'];
    $email = $user['email'];
    $status = $user['status'];
    $mgr = $user['Mgr'];
    $supervisorId = $user['supervisor'];
    $supervisorResultArray = mysqli_fetch_array($db->query("SELECT firstName, lastName FROM `person` WHERE gtAccount = '$supervisorId'"));
    $supervisorName = $supervisorResultArray[0]." ".$supervisorResultArray[1];
    $dept = $user['dept'];
    if ($dept == 'Computing College of' || $dept == 'Computing  College of') {
        $dept = 'College of Computing';
    }
    echo "<tr id='tableRow $i'>
        <td id='tableId $i'>$id</td><td id='tableFirstName $i'>$firstName</td>
        <td id='tableLastName $i'>$lastName</td><td id='tableEmail $i'>$email</td>
        <td id='tableStatus $i'>$status</td><td id='tableMgr $i'>$mgr</td>
        <td id='tableSupervisor $i' class='".$supervisorId."'>$supervisorName</td><td id='tableDept $i'>$dept</td>
        <td><a onclick='inlineEdit($i, $MgrOptionsMask)' class='button buttonTable'>Edit</a></td>
        </tr>";
}
echo "</table>";

?>