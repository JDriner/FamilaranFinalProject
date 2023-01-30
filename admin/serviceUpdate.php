<?php
include "../config/database.php";
include "../classes/service.php";


$database_obj = new Database();
$db_lv = $database_obj->getConnection();

$arrayServiceStatus = ["Available", "Not Available"];
// read all services from the database


if ($_POST) {
    $service_obj = new Service($db_lv);
    $service_obj->ServiceId_cv = $_POST['serviceId_js'];
    $service_obj->viewOneService();

   ;

    echo '<form method="POST" id="updateServiceForm">
                <div class="modal-body">
                    <input class="form-control" type="hidden" name="ServiceId_ht" value="'.$service_obj->ServiceId_cv.'">
                    <label>Code</label>
                    <input class="form-control" type="text" name="ServiceCode_ht" value="'.$service_obj->ServiceCode_cv. '">
                    <label>Service Name</label>
                    <input class="form-control" type="text" name="ServiceName_ht" value="'.$service_obj->ServiceName_cv. '">
                    <label>Description</label>
                    <textarea class="form-control" name="ServiceDescription_ht" rows="3">'.$service_obj->ServiceDescription_cv.'</textarea>

                    <label>Price</label>
                    <input class="form-control" type="text" name="ServicePrice_ht" value="' . $service_obj->ServicePrice_cv . '">
                    <fieldset class="form-group">
                        <div class="form-group">
                            <label for="exampleSelect1">Status</label>
                                <select class="custom-select" name="ServiceStatus_ht" value="' . $service_obj->ServiceStatus_cv.'">
                                    <option selected>' . $service_obj->ServiceStatus_cv . '</option>';
                                    foreach($arrayServiceStatus as $x){
                                        if ($service_obj->ServiceStatus_cv != $x){
                                            echo '<option value="'.$x.'">' .$x. '</option>';
                                        }
                                    }
                                echo '</select>
                      </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>';
}
?>
<script src="../scripts/service.js"></script>