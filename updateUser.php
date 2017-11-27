<?php
/**
 * Created by PhpStorm.
 * User: josephcantrell14
 * Date: 7/26/2017
 * Time: 2:21 PM
 */

require "database.php";
$db = new Database(true);

echo "<div align='center' id='main'>
    <a class='button' href='index.php'>Return to Table</a><br><br><br>";

$rows = $_GET['rows'];

for ($i = 0; $i < $rows; $i++) {
    $id = $_GET['id'.$i];
    $firstName = $_GET['firstName'.$i];
    $lastName = $_GET['lastName'.$i];
    $email = $_GET['email'.$i];
    $status = $_GET['status'.$i];
    $Mgr = $_GET['Mgr'.$i];
    $supervisor = $_GET['supervisor'.$i];
    $dept = $_GET['dept'.$i];

    if ($id == '' || $firstName == '' || $lastName == '' || $email == '') {
        die("Error!  All fields are required.");
    }
    if ($status == 'Error') {
        die("Error!  Please choose a status.");
    }
    if ($Mgr == 'None') {
        $Mgr = '';
    } else if ($Mgr == 'Error') {
        die("Error!  Please choose a manager.");
    }
    if ($supervisor == 'Error') {
        die("Error!  Please choose a supervisor.");
    }
    switch ($dept) {
        case "None":
            $dept = "";
            break;
        case "Error":
            die("Error!  Please choose a department.");
            break;
        case "CoC":
            $dept = "College of Computing";
            break;
        case "SoCC":
            $dept = "School of Computer Science";
            break;
        case "SoIC":
            $dept = "School of Interactive Computing";
            break;
        case "CSE":
            $dept = "Computational Science and Engineering";
            break;
    }

    $db->query("REPLACE INTO `person`
    (`gtAccount`, `firstName`, `lastName`, `email`, `status`, `Mgr`, `supervisor`, `dept`)
    VALUES ('$id', '$firstName', '$lastName', '$email', '$status', '$Mgr', '$supervisor', '$dept')");
}


echo "<p>Successfully updated users.</p>
    </div>";

?>