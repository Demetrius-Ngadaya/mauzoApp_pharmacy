<?php
include('dbcon.php');
$query = mysqli_query($con, "SELECT * FROM users") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($query)) {
    $id = $row['id'];
    $user_name = $row['user_name'];
    $role = $row['role'];
    echo "<tr class='warning'>
            <td>$user_name</td> 
            <td>$role</td> 
            <td width='160'>
              <a href='#editUserModal$id' class='btn btn-success' data-toggle='modal'>
                <i class='icon-pencil icon-large'></i>&nbsp;Badili
              </a>
              <a href='#deleteUserModal$id' role='button' data-toggle='modal' class='btn btn-danger'>
                <i class='icon-trash icon-large'></i>&nbsp;Futa
              </a>
            </td>
          </tr>";
}
?>