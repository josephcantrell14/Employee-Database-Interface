<link rel="stylesheet" href="common.css" type="text/css">
<link rel="shortcut icon" href="favicon.ico" />
<script>
function display() {
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("display").innerHTML = this.responseText;
        }
    };
    var activeElement = document.getElementById('activeFilter');
    var searchElement = document.getElementById('search');
    var active = activeElement.options[activeElement.selectedIndex].text;
    var search = searchElement.value;
    xmlhttp.open("GET","getUsers.php?a="+active+"&s="+search,true);
    xmlhttp.send();
}

var rows = [];
function inlineEdit(row, MgrOptionsMask) {
    rows.push(row);
    var MgrOptions = "<option value=" + "None" + ">" + MgrOptionsMask[0] + "</option>";
    for (var i = 1; i < MgrOptionsMask.length; i++) {
        MgrOptions += "<option value=" + MgrOptionsMask[i].id + ">" + MgrOptionsMask[i].name + "</option>";
    }
    var tableRow = document.getElementById('tableRow ' + row);
    var id = document.getElementById('tableId ' + row).innerHTML;
    var firstName = document.getElementById('tableFirstName ' + row).innerHTML;
    var lastName = document.getElementById('tableLastName ' + row).innerHTML;
    var email = document.getElementById('tableEmail ' + row).innerHTML;
    var status = document.getElementById('tableStatus ' + row).innerHTML;
    var Mgr = document.getElementById('tableMgr ' + row).innerHTML;
    var supervisor = document.getElementById('tableSupervisor ' + row).className;
    var dept = document.getElementById('tableDept ' + row).innerHTML;
    var updateString = "Update User";
    if (rows.length > 1) {
        updateString = "Update Users";
    }
    tableRow.innerHTML = "<td id='idCell'></td>" +
    "<td><input id='firstNameEdit' type='text' name='firstName'></td>" +
    "<td><input id='lastNameEdit' type='text' name='lastName'></td>" +
    "<td><input id='emailEdit' type='text' name='email'></td>" +
    "<td><select id='statusEdit' class='selectTable' name='status'><option value='Error'>Choose Status</option><option value='A'>Active</option><option value='N'>Inactive</option></td>" +
    "<td><select id='MgrEdit' class='selectTable' name='Mgr'><option value='Error'>Choose Manager</option><option value='None'>None</option><option value='Y'>Yes</option><option value='N'>No</option></td>" +
    "<td><select id='supervisorEdit' name='supervisor'></select></td>" +
    "<td><select id='deptEdit' class='selectTable' name='dept'><option value='Error'>Choose Department</option><option value='None'>None</option><option value='CoC'>College of Computing</option><option value='SoCC'>School of Computer Science</option><option value='SoIC'>School of Interactive Computing</option><option value='CSE'>Computational Science and Engineering</option></td>" +
    "<td><button id='updateUser' class='button'></button></td>";

    var updateUser = document.getElementById("updateUser");
    updateUser.id = "updateUser" + row;
    updateUser.onclick = function() {updateUsers(rows);};
    for (var i = 0; i < rows.length; i++) {
        var updateUserRef = document.getElementById("updateUser" + rows[i]);
        updateUserRef.innerHTML = updateString;
    }
    var idCell = document.getElementById("idCell");
    idCell.id = "idCell " + row;
    var firstNameEdit = document.getElementById("firstNameEdit");
    firstNameEdit.id = "firstNameEdit " + row;
    var lastNameEdit = document.getElementById("lastNameEdit");
    lastNameEdit.id = "lastNameEdit " + row;
    var emailEdit = document.getElementById("emailEdit");
    emailEdit.id = "emailEdit " + row;
    var statusEdit = document.getElementById("statusEdit");
    statusEdit.id = "statusEdit " + row;
    var MgrEdit = document.getElementById("MgrEdit");
    MgrEdit.id = "MgrEdit " + row;
    var supervisorEdit = document.getElementById("supervisorEdit");
    supervisorEdit.id = "supervisorEdit " + row;
    var deptEdit = document.getElementById("deptEdit");
    deptEdit.id = "deptEdit " + row;

    idCell.innerHTML = id;
    firstNameEdit.value = firstName;
    lastNameEdit.value = lastName;
    emailEdit.value = email;
    statusEdit.value = status;
    MgrEdit.value = Mgr;
    supervisorEdit.innerHTML = MgrOptions;
    supervisorEdit.value = supervisor;
    if (dept == "Computing College of" || dept == "Computing  College of" || dept == "College of Computing") {
        dept = "CoC";
    } else if (dept == "School of Computer Science") {
        dept = "SoCC";
    } else if (dept == "School of Interactive Computing") {
        dept = "SoIC";
    } else if (dept == "Computational Science and Engineering") {
        dept = "CSE";
    }
    console.log(dept);
    deptEdit.value = dept;
}

function updateUsers(rows) {
    var parameters = "rows=" + rows.length;
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var id = document.getElementById("idCell " + row).innerHTML;
        var firstName = document.getElementById("firstNameEdit " + row).value;
        var lastName = document.getElementById("lastNameEdit " + row).value;
        var email = document.getElementById("emailEdit " + row).value;
        var status = document.getElementById("statusEdit " + row).value;
        var Mgr = document.getElementById("MgrEdit " + row).value;
        var supervisor = document.getElementById("supervisorEdit " + row).value;
        var dept = document.getElementById("deptEdit " + row).value;

        parameters +=  "&id"+ i + "=" + id + "&firstName"+ i + "=" + firstName + "&lastName"+ i + "=" + lastName + "&email"+ i + "=" + email + "&status" + i + "=" +
            status + "&Mgr"+ i + "=" + Mgr + "&supervisor"+ i + "=" + supervisor + "&dept"+ i + "=" + dept;
    }
    document.getElementById('addTable').style.display = 'none';
    document.getElementById('activeFilter').style.display = 'none';
    document.getElementById('addButton').style.display = 'none';

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("display").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","updateUser.php?" + parameters,true);
    xmlhttp.send();
}

</script>


<?php
require "database.php";
$db = new Database(true);

echo "<body>
<div id='header'><ul class='ul_header'>
    <li class='li_line'><a href='http://www.cc.gatech.edu'><img src='logo-gt-coc.png' alt='GT CoC Logo'></a></li>
    <li class='li_line'><h1 id=title>Employee Database System</h1></li>
    </ul></div>
<div align='center' id='main'>
<div id='addUserResult'></div>";

$MgrArray = $db->query("SELECT gtAccount, firstName, lastName FROM `person` WHERE Mgr ='Y'");
$MgrOptions = "<option value='Error'>Choose Supervisor</option><option value='None'>None</option>";
while ($row = mysqli_fetch_array($MgrArray)) {
    $MgrOptions .= "<option value='".$row['gtAccount']."'>".$row['firstName']." ".$row['lastName']."</option>";
}

echo "<form id='addForm' action='addUser.php' method='post'>
    <table id='addTable'><tr>
    <td><input id='id' type='text' name='id' placeholder='GT Account'></td>
    <td><input id='firstName' type='text' name='firstName' placeholder='First Name'></td>
    <td><input id='lastName' type='text' name='lastName' placeholder='Last Name'></td>
    <td><input id='email' type='text' name='email' placeholder='Email'></td>
    </tr><tr>
    <td><select id='status' class='selectTable' name='status'><option value='Error'>Choose Status</option><option value='A'>Active</option><option value='N'>Inactive</option></td>
    <td><select id='Mgr' class='selectTable' name='Mgr'><option value='Error'>Choose Manager</option><option value='None'>None</option><option value='Y'>Yes</option><option value='N'>No</option></td>
    <td><select id='supervisor' class='selectTable' name='supervisor'>$MgrOptions</td>
    <td><select id='dept' class='selectTable' name='dept'><option value='Error'>Choose Department</option><option value='None'>None</option><option value='CoC'>College of Computing</option><option value='SoCC'>School of Computer Science</option><option value='SoIC'>School of Interactive Computing</option><option value='CSE'>Computational Science and Engineering</option></td>
    </tr></table>
    <br>
    <button id='addButton' class='button'>Add User</button>
    </form>";
echo "<br><br><br>
    <select id='activeFilter' onchange='display()'>
    <option>All Users</option>
    <option>Active Users</option>
    <option>Inactive Users</option>
    </select>
    &nbsp&nbsp
    <input id='search' type='text' placeholder='search' oninput='display()'>
    <br><br>";
echo "<div id='display'></div>";
echo "<script>display();</script>";

echo "</div>"
?>