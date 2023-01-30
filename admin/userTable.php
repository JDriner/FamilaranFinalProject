<?php

echo "<table class='table table-borderless table-light'>
        <thead>
            <tr class='table-dark'>
                <th>id (A_I)</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Password</th>
                <th>Access Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>
                <td>{$UserId_fld}</td>
                <td>{$UserFirstName_fld}</td>
                <td>{$UserLastName_fld}</td>
                <td>{$Username_fld}</td>
                <td>{$UserPassword_fld}</td>
                <td>{$AccessLevel_fld}</td>
                <td>";
                if($AccessLevel_fld=='Admin'){
                    echo "<button type='button' class='btn btn-outline-danger deleteButton' userIdDelete='$UserId_fld'><i class='fas fa-trash-alt'></i></button>";
                }else if ($AccessLevel_fld=='Client'){
                        echo "<button type='button' class='btn btn-outline-danger deleteButton' userIdDelete='$UserId_fld'><i class='fas fa-trash-alt'></i></button>
                        <button type='button' class='btn btn-outline-success'><i class='fas fa-eye'></i></button>";
            }
            echo "</td></tr>";
    }

        echo "</tbody>
        </table>";
?>