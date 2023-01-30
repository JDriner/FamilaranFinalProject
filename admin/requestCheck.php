<?php
include "../config/database.php";
include "../classes/request.php";


$arrayStatus = array("Pending"=>"Pending", "Declined"=>"Decline", "In Progress"=>"Accept", "Finished"=>"Finished");

$database_obj = new Database();
$db_lv = $database_obj->getConnection();

if ($_POST) {
    $request_obj = new Requests($db_lv);
    $request_obj->RequestId_cv = $_POST['requestId_js'];
    $request_obj->viewOneRequest();


    echo '<form method="POST" id="checkRequestForm">
                <div class="modal-body">
                    <div class="card text-white bg-secondary mb-3" style="max-width: 100%;">
                        <div class="card-body text-primary">
                            <ul class="list-group">
                            <li class="list-group-item d-flex align-items-center">
                            <input class="form-control" type="hidden" name="RequestId_ht" value="' . $request_obj->RequestId_cv . '">
                            <strong>Name: </strong>' . $request_obj->UserFirstName_cv ." " . $request_obj->UserLastName_cv .'
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                            <strong>Service:</strong>'.$request_obj->ServiceName_cv . '
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                            <strong>Start Date:</strong> ' . $request_obj->RequestDate_cv . '
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                            <strong>Address:<p class="text-primary">'.$request_obj->UserAddress_cv.'</p></strong>
                            
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                            <strong>Description of the Request:<p class="text-primary">'.$request_obj->RequestDescription_cv.'</p></strong>
                            </li>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <fieldset class="form-group">
                                    <div class="form-group">
                                        <label><strong>Status:</strong></label>
                                            <select class="custom-select" name="RequestStatus_ht" value="'.$request_obj->RequestStatus_cv .'">
                                                <option selected>' . $request_obj->RequestStatus_cv  . '</option>';
                                                    foreach($arrayStatus as $x => $x_value){
                                                        if($request_obj->RequestStatus_cv==$x){
                                                        }
                                                        else if($request_obj->RequestStatus_cv=='Pending'){
                                                            echo '<option value="Declined">Decline</option>';
                                                            echo '<option value="In Progress">Accept</option>';
                                                            break;
                                                        }
                                                        else if($request_obj->RequestStatus_cv=='In Progress'){
                                                            echo '<option value="Finished">Finished</option>';
                                                            break;
                                                        }
                                                            
                                                        
                                                }
    // $arrayStatus = array("Pending"=>"Pending", "Declined"=>"Decline", "In Progress"=>"Accept", "Finished"=>"Finished");
                                            echo '</select>
                                    </div>
                                </fieldset>
                            </li>
                          </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Request</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>';
}
?>
<script src="../scripts/requests.js"></script>