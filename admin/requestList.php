
<?php
if ($num > 0) {
    echo "<table class='table table-borderless table-light'>
                <thead>
                    <tr class='table-dark'>
                        <th>Request ID</th>
                        <th colspan='2'>Client Full Name</th>
                        <th colspan='2'>Requested Service</th>
                        <th colspan='3'>Request Date</th>
                        <th>Request Status</th>
                        <th colspan='2'>Actions</th>
                    </tr>
                </thead>
                <tbody>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    echo "<tr>
                            <td>{$RequestId_fld}</td>
                            <td colspan='2'>{$UserFirstName_fld} {$UserLastName_fld}</td>
                            <td colspan='2'>{$ServiceName_fld}</td>
                            <td colspan='3'>{$RequestDate_fld}</td>
                            <td>{$RequestStatus_fld}</td>
                            <td colspan='2'>";
                            if ($RequestStatus_fld =='Finished' || $RequestStatus_fld =='Declined' || $RequestStatus_fld =='Cancelled' ){
                                echo "<button type='button' title='View Request' class='btn btn-outline-success checkButton' requestIdCheck='$RequestId_fld'><i class='fas fa-eye'></i></button>
                                <button type='button' title='Delete Request' class='btn btn-outline-danger deleteButton' requestIdDelete='$RequestId_fld'><i class='fas fa-trash-alt'></i></button>";  
                            }else{
                                echo "<button type='button' title='View Request' class='btn btn-outline-success checkButton' requestIdCheck='$RequestId_fld'><i class='fas fa-eye'></i></button>";
                            }
                                
                            echo "</td>
                        </tr>";
                }
                echo "</tbody>
            </table>";
            $page_url = "requestMain.php?"; 
            $total_rows = $request_obj->countRequest();
            // actual paging buttons
            include 'paging.php';

// tell the user there are no selfies
if ($num = 0) {
    echo "<div class='alert alert-danger'>
                <strong>No users found.</strong>
            </div></div>
            </div>";
}
        

}
?>



