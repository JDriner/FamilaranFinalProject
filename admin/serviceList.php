<?php
echo "<table class='table table-borderless table-light'>
        <thead>
            <tr class='table-dark'>
                <th>Service ID</th>
                <th>Code</th>
                <th colspan='2'>Name</th>
                <th colspan='3'>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th colspan='2'>Actions</th>
            </tr>
        </thead>
        <tbody>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            echo "<tr>
                    <td>{$ServiceId_fld}</td>
                    <td>{$ServiceCode_fld}</td>
                    <td colspan='2'>{$ServiceName_fld}</td>
                    <td colspan='3'>{$ServiceDescription_fld}</td>
                    <td>₱{$ServicePrice_fld}.00</td>
                    <td>{$ServiceStatus_fld}</td>
                    <td colspan='2'>
                        <button type='button' class='btn btn-outline-danger deleteButton' serviceIdDelete='$ServiceId_fld'><i class='fas fa-trash-alt'></i></button>

                        <button type='button' class='btn btn-outline-success updateButton' serviceIdUpdate='$ServiceId_fld'><i class='fas fa-pencil-alt'></i></button>
                    </td>
                </tr>";
        }

    echo "</tbody>
    </table>";  
    $page_url = "serviceMain.php?";
    $total_rows = $service_obj->countService();
    // actual paging buttons
    include 'paging.php';            
?>
