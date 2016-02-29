<div id="category-actions">
    <div class="loads-title" id="category-title"><img src="<?php echo base_url() ?>/public/img/images/loads-title.png" width="100" height="70" alt="Loads Category"></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All Loads"></a></div>
    <?php
    if (in_array("load/add", $roles)) {
        ?>
        <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/add'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" alt="Add a Load"></a></div>
    <?php } ?>  
</div>  
<div class="container">
    <div class="row">
        <div class="container">
            <h2>Edit Load #<?php echo $load['load_number'] ?></h2>
            <?php echo $error; ?>
            <?php $attributes = array('id' => 'register3_form'); ?>
            <div id="register_form_error" class="alert alert-error" style="display:none"><!-- Dynamic --></div>
            <div id="register_form_success" class="success alert-success" style="display:none"><!-- Dynamic --></div>
            <?php echo form_open_multipart('load/do_upload2/' . $load['idts_load'], $attributes); ?>
            <?php // print_r('file is '.$file); ?>
            <input type="hidden" name="load_number" value="<?php echo $load['load_number'] ?>" />
            <input type="hidden" name="update_shipment" id="update_shipment"/>
            <input type="hidden" name="new_shipment" id="new_shipment"/>
            <input type="hidden" name="delete_shipment" id="delete_shipment"/>
            <input type="hidden" id="status_tender" name="status_tender" value="0">

            <div class="control-group">
                <label class="control-label">Carrier</label>
                <div class="controls">
                    <select class="selectpicker" name="carrier" id="carrier">
                        <?php
                        foreach ($carriers as $carrier => $row) {
                            $selected = '';
                            if ($row['idts_carrier'] == $load['ts_carrier_idts_carrier']) {
                                $selected = 'selected="selected"';
                            }
                            echo '<option ' . $selected . ' value="' . $row['idts_carrier'] . '">' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>        

            <div class="control-group">
                <label class="control-label">Driver</label>
                <div class="controls">
                    <select class="selectpicker" name="driver" id="driver">
                        <?php
                        $apns = '';
                        $app_id = '';
                        $driver_email = '';
                        foreach ($drivers as $driver => $row) {
                            $selected = '';
                            if ($row['idts_driver'] == $load['ts_driver_idts_driver']) {
                                $selected = 'selected="selected"';
                                $apns = $row['apns_number'];
                                $app_id = $row['app_id'];
                                $driver_email = $row['email'];
                            }
                            echo '<option ' . $selected . ' value="' . $row['idts_driver'] . '">' . $row['name'] . ' ' . $row['last_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <input type="hidden" id="apns_number" name="apns_number" value="<?php echo $apns ?>">
                    <input type="hidden" id="app_id" name="app_id" value="<?php echo $app_id ?>">
                    <input type="hidden" id="shipments" name="shipments">
                    <input type="hidden" id="status" name="status">
                </div>
            </div>

            <div class="loading" style="display:none">
                <div class="loading-bg"></div>
                <!--<div class="loading-msg">Saving...</div>-->
            </div>            

            <div id="customer_list">
                <select class="selectpicker" name="customer">
                    <?php
                    foreach ($customers as $customer => $row) {
                        echo '<option value="' . $row['idts_customer'] . '">' . $row['name'] . '</option>';
                    }
                    ?>
                </select>                    
            </div>

            <table id="bol-table" class="table table-hover table-striped">
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($shipments as $shipment => $row) {
//                                            $date = explode(' ', $row['date']);
//                                            $date_formated_temp = explode('-', $date[0]);
//                                            $date_formated = $date_formated_temp[1] . '/' . $date_formated_temp[0] . '/' . $date_formated_temp[2];


                        echo'<tr class="shp_' . $i . '">';
                        echo'<td colspan="5" style="background-color: #EBEBEB; font-size: 14px;font-weight: bolder;">BOL #<span class="txt-bol-number">' . $row['bol_number'] . '</span><span class="del-shipment" data-shp_id="' . $row['idshipment'] . '" data-shp_num="' . $i . '">X</span></td>';
                        echo'</tr>';

                        echo'<tr class="shp_' . $i . '">';
                        echo'<td class="bol_header">Customer</td>';
                        echo'<td class="bol_header">Pickup address</td>';
                        echo'<td class="bol_header">Pickup #</td>';
                        echo'<td class="bol_header">Drop address</td>';
                        echo'<td class="bol_header">Drop #</td>';
                        echo'</tr>';

                        echo'<tr class="shp_' . $i . '" data-data="1">';
                        echo'<td><input type="hidden" class="shp_db_id" name="shp_db_id_' . $i . '" id="shp_db_id_' . $i . '" value="' . $row['idshipment'] . '"><input type="hidden" class="type" name="type_' . $i . '" id="type_' . $i . '" value="1">';
                        echo'<select data-shp="' . $i . '" class="select-customer" name="customer">';
                        foreach ($customers as $customer => $cust_row) {
                            $selected = '';
                            if ($cust_row['idts_customer'] == $row['ts_customer_idts_customer']) {
                                $selected = 'selected="selected"';
                            }
                            echo '<option ' . $selected . '  value="' . $cust_row['idts_customer'] . '">' . $cust_row['name'] . '</option>';
                        }
                        echo'</select>';
                        echo'</td>';
                        echo'<td><input type="text" class="pk" id="pk_' . $i . '" name="pickup" readonly="readonly" style="width:220px" value="' . $row['pickup_address'] . '"/><input type="hidden" class="pk2" id="pk2_' . $i . '" name="pickup" value="' . $row['pickup_address2'] . '" style="width:235px"/><button type="button" class="btn btn-red btn-small" data-shp_id="' . $i . '" hidefocus="true" style="outline: medium none; margin: 0px 5px;" data-toggle="modal" data-target="#originAddressModal" id="set-model-pickup"><span class="gradient">+</span></button></td>';
                        echo'<td>';
                        echo'<input type="text" class="pk_number" id="pk_number_' . $i . '" name="pickup_number" value="' . $row['pickup_number'] . '" style="width:50px;"/>';
                        echo'<input type="hidden" class="pk_zipcode" name="pk_zipcode_' . $i . '" id="pk_zipcode_' . $i . '" value="' . $row['pickup_zipcode'] . '">';
                        echo'<input type="hidden" class="pk_lat" name="pk_lat_' . $i . '" id="pk_lat_' . $i . '" value="' . $row['pickup_lat'] . '">';
                        echo'<input type="hidden" class="pk_lng" name="pk_lng_' . $i . '" id="pk_lng_' . $i . '" value="' . $row['pickup_lng'] . '">';
                        echo'</td>';
                        echo'<td><input type="text" class="dp" id="dp_' . $i . '" name="drop" readonly="readonly" value="' . $row['drop_address'] . '"  style="width:220px"><input type="hidden" class="dp2" id="dp2_' . $i . '" name="drop" readonly="readonly" value="' . $row['drop_address2'] . '"  style="width:220px"><button type="button" class="btn btn-red btn-small" data-shp_id="' . $i . '" hidefocus="true" style="outline: medium none;margin: 0px 5px;" data-toggle="modal" data-target="#destinationAddressModal" id="set-model-drop"><span class="gradient">+</span></button></td>';
                        echo'<td>';
                        echo'<input type="text" class="dp_number" id="dp_number_' . $i . '" name="drop_number"value="' . $row['drop_number'] . '" style="width:50px;"/>';
                        echo'<input type="hidden" class="dp_zipcode" name="dp_zipcode_' . $i . '" id="dp_zipcode_' . $i . '" value="' . $row['drop_zipcode'] . '">';
                        echo'<input type="hidden" class="dp_lat" name="dp_lat_' . $i . '" id="dp_lat_' . $i . '" value="' . $row['drop_lat'] . '">';
                        echo'<input type="hidden" class="dp_lng" name="dp_lng_' . $i . '" id="dp_lng_' . $i . '" value="' . $row['drop_lng'] . '">';
                        echo'<input type="hidden" id="bol_num_' . $i . '" class="bol-num" value="' . $row['bol_number'] . '">';
                        echo'<input type="hidden"class="shp_file_sw" id="shp_file_sw_' . $i . '" value="0">';
                        echo'</td>';
                        echo'</tr>';
                        echo'<tr class="shp_' . $i . '">';
                        echo'<td colspan="2">BOL #: <input type="text" data-iter="' . $i . '" id="bn_' . $i . '" class="bol-number" name="bol_number" value="' . $row['bol_number'] . '"/></td>';
                        echo'<td colspan="3" style="text-align: center;"><div id="shp_file_' . $i . '"><a href="' . VIEW_FILE_PATH . $row['url_bol'] . '" target="_blank">BOL</a> <a href="" data-id="' . $row['idshipment'] . '" data-shp_id="' . $i . '" class="remove_file">Delete</a></div></td>';
                        echo'</tr>';

                        echo'<tr class="shp_' . $i . '">';
                        echo'<td colspan="5">Contacts:';
                        echo'<span id="shp_contact_' . $i . '"> ';
                        $customer_id = 0;
                        $contacts = [];
                        $contacts_name = '';
                        $shp_customer_contacts = $row['customer_contacts'];
                        $shp_customer_sel_contacts = $row['selected_customer_contacts'];
                        foreach ($shp_customer_contacts as $shp_customer_contact => $shp_cust_cont) {
                            foreach ($shp_customer_sel_contacts as $shp_customer_sel_contact => $sel_contact) {
                                if ($shp_cust_cont['idts_customer_contact'] == $sel_contact['contact_id']) {
                                    array_push($contacts, ['contact_id' => $sel_contact['contact_id'], 'email' => $sel_contact['email']]);
                                    echo $shp_cust_cont['name'] . ', ';
                                }
                            }
                        }

                        $json_contacts = json_encode($contacts);

                        echo'</span>';
                        echo'<a href="#" title="Set Shipment Contacts" id="shp_contact_chg_' . $i . '" data-ship="' . $i . '" class="pop" data-placement="right" data-content="Content" data-id_customer="' . $row['ts_customer_idts_customer'] . '">Change</a>';
                        echo'<input type="hidden" name="ship_contacts_' . $i . '" id="ship_contacts_' . $i . '" />';
                        echo'</td>';
                        ?>
                    <script type="text/javascript">
                        var contacts = <?php echo $json_contacts ?>;
                        var jsonText = JSON.stringify(contacts);
                        var cont = <?php echo $i ?>;
                        $('#ship_contacts_' + cont).val(jsonText);
                        //                        console.log('json: ' + jsonText);
                    </script>

                    <?php
                    echo'</tr>';

                    echo'<tr class="shp_' . $i . '"><td colspan="6" style="border-left: none;border-right: none;">&nbsp;</td></tr>';
                    $i++;
                }
                ?>                                        
                </tbody>
            </table>

            <!-- Pick up modal -->

            <div class="modal fade" id="originAddressModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Pickup Address</h4>
                        </div>
                        <div class="modal-body">
                            <fieldset>

                                <!-- Form Name -->
                                <legend style="margin:10px 0px">Check Address</legend>
                                <div id="pickup_form_error" class="alert alert-error" style="display:none"><!-- Dynamic --></div>
                                <table id="tbl-shp-view">
                                    <tr>
                                        <td>Address:</td>
                                        <td><input type="text" id="mpk_address" name="drop_number" style="width:250px;"/></td>
                                    </tr>
                                    <tr>
                                        <td>Address2:</td>
                                        <td><input type="text" id="mpk_address2" class="mpk_address2" name="drop_number" style="width:250px;"></td>
                                    </tr>                                    
                                    <tr>
                                        <td>Zipcode:</td>
                                        <td><input type="text" id="mpk_zipcode" name="drop_number" style="width:250px;"/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"><button id="view_pickup" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;"><span class="gradient">View in map</span></button></td>
                                    </tr>
                                </table>
                                <div id="map_pickup">
                                    <div id="map-canvas"></div>                                    
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                            <button data-dismiss="modal" style="border-radius: 16%; height: 25px;">Close</button>
                            <!--<button type="button" id="confirm_origin" class="btn btn-primary">Ok</button>-->
                            <button id="set_pickup" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;"><span class="gradient">Set</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Drop address Modal -->

            <div class="modal fade" id="destinationAddressModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Drop  Address</h4>
                        </div>
                        <div class="modal-body">
                            <fieldset>
                                <legend style="margin:10px 0px">Check Address in Map</legend>
                                <div id="drop_form_error" class="alert alert-error" style="display:none"><!-- Dynamic --></div>
                                <table id="tbl-csn-view">
                                    <tr>
                                        <td>Address:</td>
                                        <td><input type="text" id="mdp_address" class="mdp_address" name="drop_number" style="width:250px;"></td>
                                    </tr>
                                    <tr>
                                        <td>Address2:</td>
                                        <td><input type="text" id="mdp_address2" class="mdp_address2" name="drop_number" style="width:250px;"></td>
                                    </tr>                                    
                                    <tr>
                                        <td>Zipcode:</td>
                                        <td><input type="text" id="mdp_zipcode" class="mdp_zipcode" name="drop_number" style="width:250px;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"><button id="view_drop" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;"><span class="gradient">View in map</span></button></td>
                                    </tr>
                                </table>
                                <div id="map_drop">
                                    <div id="map-canvas2"></div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                            <button data-dismiss="modal" style="border-radius: 16%; height: 25px;">Close</button>
                            <button id="set_drop" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;"><span class="gradient">Set</span></button>
                        </div>
                    </div>
                </div>
            </div>            

            <button id="add_shp" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;"><span class="gradient">Add Shipment</span></button>

            <br /><br />
            <button type="submit" id="save_btn" class="btn btn-red btn-small" hidefocus="true" style="outline: medium none;"><span class="gradient">Save</span></button>
            <button type="submit" id="savensend_btn" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;"><span class="gradient">Save and send</span></button>
            <button id="btn_cancel" style="border-radius: 16%; height: 25px;">Cancel</button>
            </form> 
        </div>
    </div>
</div>
<style>
    #bol-table{
        width: 910px;
    }
    #bol-table td{
        border: 1px solid #DCD8D8;
    } 

    #add_shp{
        float: right;
        margin: 10px 0px 0px 0px;
    }

    .del-shipment{
        float: right;
        cursor: pointer;
    }

    .loading{
        text-align: center;
        margin: 20px;
    }

    .loading-bg{
        width: 100px;
        height: 100px;
        background-image: url("/trackngo/public/img/loading.gif");
        background-size: 100px 100px;
        background-repeat: no-repeat;
        margin-left: 35%;
        margin: 20px 40%;      
    }

    .loading-msg{
        margin-right: 7%;
        font-size: large;
    }

    .modal.fade.in {
        top: 10%;
    }

    .modal.fade.in {
        top: 5%;
    } 


</style>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAp8XadZn74QX4NLDphnzehQ0AN7q6NCwg"></script>
<script>
                        $(function () {
                            var count_ship = <?php echo count($shipments) ?>;
                            var shp_number = parseInt(count_ship);
                            check_file();

                            $('body').on('click', '#savensend_btn', function (evt) {
                                $('#status_tender').val(1);
                            });

                            $('#customer_list').hide();
                            //Enable tender to driver
//                            $('body').on('click', '#savensend_btn', function (evt) {
//                                $('#status').val(1);
//                            });

                            //Enable tender to driver
//                            $('body').on('click', '#save_btn', function (evt) {
//                                $('#status').val(0);
//
//                            });
                            //Enable tender to driver
                            $('body').on('click', '#btn_cancel', function (evt) {
                                evt.preventDefault();
                                location.href = '<?php echo site_url('/load') ?>';

                            });

                            function check_file() {
                                var file = '';
                                file = '<?php echo $file ?>';
                                if (file != '') {
                                    $('#link_delete_file').css('visibility', 'block');
                                    $('#userfile').css('visibility', 'hidden');
                                } else {
                                    $('#link_delete_file').css('visibility', 'hidden');
                                    $('#delete_file').css('visibility', 'hidden');
                                    $('#userfile').css('visibility', 'block');
                                }
                            }

                            $('#upload_file').submit(function (e) {
                                e.preventDefault();
                                var url = $(this).attr('action');
                                var postData = $(this).serialize();
                                $("#userfile").AjaxFileUpload({
                                    url: url,
                                    secureuri: false,
                                    fileElementId: 'userfile',
                                    dataType: 'json',
                                    data: postData,
                                    success: function (data, status)
                                    {
                                        if (data.status != 'error')
                                        {
                                            $('#files').html('<p>Reloading files...</p>');
                                            refresh_files();
                                            $('#title').val('');
                                        }
                                        alert(data.msg);
                                    }
                                });
                                return false;
                            });

                            $('#register3_form').submit(function (evt) {
                                // submit the form 
                                evt.preventDefault();
                                getShipmentData();
//            return false;
                                var options = {
//                target: '#output2', // target element(s) to be updated with server response 
                                    beforeSubmit: showRequest, // pre-submit callback 
                                    success: showResponse, // post-submit callback 

                                    // other available options: 
                                    //url:       url         // override for form's 'action' attribute 
                                    //type:      type        // 'get' or 'post', override for form's 'method' attribute 
                                    dataType: 'json'        // 'xml', 'script', or 'json' (expected server response type) 
                                            //clearForm: true        // clear all form fields after successful submit 
                                            //resetForm: true        // reset the form after successful submit 

                                            // $.ajax options can be used here too, for example: 
                                            //timeout:   3000 
                                };

                                $(this).ajaxSubmit(options);
                                // return false to prevent normal browser submit and page navigation 
                                return false;
                            });


                            $('#register2_form').submit(function (evt) {
                                evt.preventDefault();
                                var url = $(this).attr('action');
                                var postData = $(this).serialize();
                                var formData = new FormData($('form')[0]);

                                $.ajax({
                                    type: "POST",
                                    url: url + '/' +<?php echo $load['idts_load'] ?>,
                                    async: true,
                                    data: formData,
                                    processData: false,
                                    dataType: "json",
                                    beforeSend: function () {
                                        $('#msn').show();
                                        $(".ajax-loader-load").show();
                                    },
                                    success: function (o) {
                                        if (o.result == 1) {
//                    window.location.href = '<?php echo site_url('dashboard') ?>';
                                            $("#success").show();
                                            $("#success").html('<ul><li>The load was successfully added.</li></ul>');
//                                                    setTimeout(function () {
//                                                        $("#success").fadeOut();
//                                                        window.location = '<?php echo site_url('load') ?>';
//                                                    }, 1000);
                                        } else {
                                            var output = '<ul>';
                                            for (var key in o.error) {
                                                var value = o.error[key];
                                                output += '<li>' + value + '</li>';
                                            }
                                            output += '</ul>';
                                            $("#register_form_error").html(output);
                                            $("#register_form_error").show();
                                            $('html, body').animate({scrollTop: 0}, 'fast');
                                        }
                                    }, complete: function () {
                                        $('#msn').hide();
                                        $(".ajax-loader-load").hide();
                                    }

                                });
                            });


                            $("#carrier").change(function () {
                                var carrier = $(this);
                                $('#driver option').remove();
                                $('#driver').append('<option value="loading">loading...</option>');

                                var postData = {
                                    carrier_id: $(this).val()
                                };
                                console.log(carrier.val());
                                if (carrier.val() == 0) {
                                    $('#driver option').remove();
                                    $('#driver').append('<option value="0">-Select-</option>');
                                } else {

                                    $.post('<?php echo base_url('carrier/get_drivers_by_carrier') ?>', postData, function (o) {
                                        $('#driver option').remove();
                                        var drivers = o;
                                        var output = '';
                                        if (drivers.length == 0) {
                                            output += '<option value="no_driver">-No driver asigned to this carrier-</option>';
                                        }

                                        if (carrier.val() === 'select') {
                                            output += '<option value="select">-Select-</option>';
                                        }

                                        for (var i = 0; i < drivers.length; i++) {
                                            output += '<option value="' + drivers[i].idts_driver + '">' + drivers[i].name + ' ' + drivers[i].last_name + '</option>';
                                        }

                                        $('#driver').append(output);

                                    }, 'json');

                                }

                            });

                            $('body').on('click', '#delete_file', function (event) {
                                var file = $(this);
                                var file_name = file.data('file_name');
                                console.log(file_name);

                                $.ajax({
                                    type: "POST",
                                    url: '<?php echo base_url('load/delete_file') ?>' + '/' + file_name,
                                    async: true,
                                    dataType: "json",
                                    success: function (o) {
                                        location.reload();
                                    }
                                });

                                location.reload();

                            });

                            //Add new row to Shipment the table
                            $('body').on('click', '#add_shp', function (evt) {
                                evt.preventDefault();
                                shp_number++;
                                console.log('contador: ' + shp_number);
                                setShipmentData(shp_number);
//            $('#bol-table tbody').append('<tr id="shp_' + shp_number + '">'+shp_number+'<td id="customer_' + shp_number + '">Customer</td><td><input type="text" name="pickup"/></td><td><input type="text" name="drop"/></td><td><input type="text" name="bol_number"/></td><td><input type="file" multiple = "multiple" accept = "image/*" class = "form-control" name="uploadfile[]" size="20" /></td></tr>');
//                    $('#customer_' + shp_number).html($('#customer_list').html());
                            });

                            //Remove shipment
                            $('body').on('click', '.remove_shp', function (evt) {
                                evt.preventDefault();
//            delete_shipments                        
                                var tr_id = $(this).data('id');
                                delete_shipments.push({
                                    idshipment: tr_id
                                });
                                var delete_shipment = JSON.stringify(delete_shipments);
                                $('#delete_shipment').val(delete_shipment);
                                var tr = $('#' + tr_id);
                                $(tr).remove();
                            });

                            //Remove shipment file
                            $('body').on('click', '.remove_file', function (evt) {
                                evt.preventDefault();

                                var file = $(this);
                                var id = file.data('shp_id');
                                $('#shp_file_sw_' + id).val(1);
                                $('#shp_file_' + id).html('<input type="file" id="shp_file_input' + id + '" multiple="multiple" accept="application/pdf" class="" name="uploadfile[]" size="20">');
                            });

                            //Remove new shipment
                            $('body').on('click', '.delete_new', function (evt) {
                                evt.preventDefault();
                                var tr_id = $(this).data('id');
                                var tr = $('#shp_' + tr_id);
                                $(tr).remove();
                            });

                            //Setting BOL in header
                            $('body').on('keyup', '.bol-number', function (evt) {
                                evt.preventDefault();
                                var bol = $(this);
                                var iter = bol.data('iter');
                                console.log('iter: ' + iter);
                                var tr = bol.parent().parent().prop('class');
                                $('.' + tr + ' .txt-bol-number').html(bol.val());
                                $('.' + tr + ' #bol_num_' + iter).val(bol.val());

                                // Show input file

                                $('#shp_file_sw_' + iter).val(1);
                                $('#shp_file_' + iter).html('<input type="file" id="shp_file_input' + iter + '" multiple="multiple" accept="application/pdf" class="" name="uploadfile[]" size="20">');

                            });

                            //Contacts popover
                            $('body').on('click', '.pop', function (evt) {
                                evt.preventDefault();
                                var pop_contact = $(this);
                                console.log('customer id ' + pop_contact.data('id_customer'));
                                pop_contact.popover({
                                    placement: 'right',
                                    trigger: 'manual',
                                    html: true,
//                container: pop_contact,
//                animation: true,
                                    title: 'Name goes here',
                                    content: function () {
                                        return getCustomerContacts(pop_contact);
                                    }
                                }).popover('toggle');
                            });

                            $('body').on('change', '.select-customer', function (evt) {
                                var customer = $(this);
                                var customer_id = customer.val();
                                var shp = customer.data('shp');
                                var contacts = [];
                                $.post('<?php echo site_url('customer/get_contact') ?>/' + customer.val(), function (o) {
                                    var contact = o;
                                    var output = '';
                                    var id_customer = 0;
                                    for (var i = 0; i < contact.length; i++) {
                                        if (contact[i].default == 1) {
                                            output += contact[i].name + ', ';
                                            contacts.push(
                                                    {
                                                        contact_id: contact[i].idts_customer_contact,
                                                        email: contact[i].email
                                                    });
                                        }
                                        id_customer = contact[i].ts_customer_idts_customer;
                                    }

                                    var json = JSON.stringify(contacts);

                                    $('#shp_contact_' + shp).html('');
                                    $('#shp_contact_' + shp).append(output);
                                    $('#ship_contacts_' + shp).val(json);

                                    $('#shp_contact_chg_' + shp).data('id_customer', customer_id);
                                }, 'json');
                            });



                            //Change shipment contacts
                            $('body').on('click', '.change_contacts', function (evt) {
                                evt.preventDefault();
                                var view_contacts = '';
                                var shp_change = $(this);
                                var ship_id = shp_change.attr('id');
                                var contacts = [];
                                $('#ship_contacts_' + ship_id).val('');

                                $('#tbl_contacts_shp_contact_chg_' + ship_id + ' tbody tr').each(function () {
                                    var tr = $(this);
                                    var email = '';
                                    if (tr.find('.tbl_contact_input:checkbox:checked').length > 0) {
                                        view_contacts += tr.find('.tbl_contact_input').data('name') + ', ';
                                        email += tr.find('.tbl_contact_input').data('email');
                                        contacts.push(
                                                {
                                                    contact_id: tr.find('.tbl_contact_input').val(),
                                                    email: email
                                                });
                                    }
                                });

                                $('#shp_contact_' + ship_id).html(view_contacts);//show contacts in table row
                                var json = JSON.stringify(contacts);
                                $('#ship_contacts_' + ship_id).val(json);
                                $('#shp_contact_chg_' + ship_id).popover("hide");
                                return true;

                            });

                            //Delete shipment row
                            $('body').on('click', '.del-shipment', function (evt) {
                                evt.preventDefault();
                                var del = $(this);

                                if (del.data('shp_id') != 0) {
                                    delete_shipment.push({
                                        shipment_id: del.data('shp_id')
                                    });
                                    var json = JSON.stringify(delete_shipment);
                                    $('#delete_shipment').val(json);
                                }
//                            shp_number--;
                                var tr = del.data('shp_num');
                                $('.shp_' + tr).remove();
                            });

                            //Set pickup model vars
                            $('body').on('click', '#set-model-pickup', function (evt) {
                                evt.preventDefault();
                                var pickup = $(this);
                                global_pickup = pickup.data('shp_id');
                                $("#mpk_address").attr('class', 'mpk_address_' + pickup.data('shp_id'));
                                $("#mpk_zipcode").attr('class', 'mpk_zipcode_' + pickup.data('shp_id'));
                                $('#view_pickup').attr('data-shp_id', pickup.data('shp_id'));
                                $('#set_pickup').attr('data-shp_id', pickup.data('shp_id'));
                                $('#mpk_address').val($('#pk_' + pickup.data('shp_id')).val());
                                $('#mpk_address2').val($('#pk2_' + pickup.data('shp_id')).val());
                                $('#mpk_zipcode').val($('#pk_zipcode_' + pickup.data('shp_id')).val());
                                $("#map_pickup").html("");
                                $('.modal').css('height', '490px');
                                $('#pickup_form_error').hide();
                            });

                            //view pickup address

                            $('body').on('click', '#view_pickup', function (evt) {
                                evt.preventDefault();
                                var pickup = $(this);
                                console.log('get from pickup: ' + pickup.data('shp_id'));
                                getPickupMap(pickup);
                                getPickupMap(pickup);
                            });

                            //set pickup address

                            $('body').on('click', '#set_pickup', function (evt) {
                                evt.preventDefault();

                                var pickup = $(this);
                                var id = global_pickup;

                                var addr = $('#mpk_address').val();
                                var zip = $('#mpk_zipcode').val();
                                var address = $('#mpk_address').val() + ', ' + $('#mpk_zipcode').val();
                                var url_address = address.split(' ').join('+');

                                if (addr == '' || zip == '') {
                                    $('#pickup_form_error').html('address and/or zipcode can not be empty.');
                                    $('#pickup_form_error').show();
                                    return false;
                                }

                                $.ajax({
                                    type: "POST",
                                    url: 'https://maps.googleapis.com/maps/api/geocode/json?address=' + url_address + '&key=AIzaSyAp8XadZn74QX4NLDphnzehQ0AN7q6NCwg',
                                    async: true,
                                    dataType: "json",
                                    beforeSend: function () {
                                        $('#result_destination').html('Loading...');
                                        $('#result_destination').show();
                                    },
                                    success: function (data) {

                                        if (data.status == 'ZERO_RESULTS') {
                                            $('#pickup_form_error').html('Address and/or zipcode not found, Please check.');
                                            $('#pickup_form_error').show();
                                            return false;
                                        } else {

                                            var city = '';
                                            var state = '';

                                            var lat = data.results[0].geometry.location.lat;
                                            var lng = data.results[0].geometry.location.lng;
                                            if (data.results[0].address_components[2].long_name) {
                                                city = data.results[0].address_components[2].long_name;
                                            }

                                            if (data.results[0].address_components[4].short_name) {
                                                state = data.results[0].address_components[4].short_name;
                                            }

                                            $('#pk_' + id).val($('#mpk_address').val());
                                            $('#pk2_' + id).val($('#mpk_address2').val());
                                            $('#pk_' + id).removeAttr("readonly");
                                            $('#pk_zipcode_' + id).val($('.mpk_zipcode_' + id).val());
                                            $('#pk_lat_' + id).val(lat);
                                            $('#pk_lng_' + id).val(lng);

                                            $('#or_city').val(city);
                                            $('#or_state').val(state);
                                            $('#or_city').removeAttr("readonly");
                                            $('#or_state').removeAttr("readonly");

                                            $('#originAddressModal').modal('toggle');

//                  console.log('state: ' + state + ', lat: ' + lat + ', lng: ' + lng + ', zipcode: ' + zipcode);
//                $('#result_destination').show();
                                        }
                                    }
                                });
                            });


                            //Set drop model vars
                            $('body').on('click', '#set-model-drop', function (evt) {
                                evt.preventDefault();
                                var drop = $(this);
                                global_drop = drop.data('shp_id');
                                $("#mdp_address").attr('class', 'mdp_address_' + drop.data('shp_id'));
                                $("#mdp_zipcode").attr('class', 'mdp_zipcode_' + drop.data('shp_id'));
                                $('#view_drop').attr('data-shp_id', drop.data('shp_id'));
                                $('#set_drop').attr('data-shp_id', drop.data('shp_id'));
                                $('#mdp_address').val($('#dp_' + drop.data('shp_id')).val());
                                $('#mdp_address2').val($('#dp2_' + drop.data('shp_id')).val());
                                $('#mdp_zipcode').val($('#dp_zipcode_' + drop.data('shp_id')).val());
                                $("#map_drop").html("");
                                $('.modal').css('height', '490px')
                                $('#drop_form_error').hide();

                            });


                            //set drop address

                            $('body').on('click', '#set_drop', function (evt) {
                                evt.preventDefault();

                                var drop = $(this);
                                var id = global_drop;

                                var addr = $('#mdp_address').val();
                                var zip = $('#mdp_zipcode').val();
                                var address = $('.mdp_address_' + id).val() + ', ' + $('#mdp_zipcode').val();
                                var url_address = address.split(' ').join('+');

                                if (addr == '' || zip == '') {
                                    $('#drop_form_error').html('address and/or zipcode can not be empty.');
                                    $('#drop_form_error').show();
                                    return false;
                                }

                                $.ajax({
                                    type: "POST",
                                    url: 'https://maps.googleapis.com/maps/api/geocode/json?address=' + url_address + '&key=AIzaSyAp8XadZn74QX4NLDphnzehQ0AN7q6NCwg',
                                    async: true,
                                    dataType: "json",
                                    beforeSend: function () {
                                        $('#result_destination').html('Loading...');
                                        $('#result_destination').show();
                                    },
                                    success: function (data) {
                                        var city = '';
                                        var state = '';

                                        var lat = data.results[0].geometry.location.lat;
                                        var lng = data.results[0].geometry.location.lng;
                                        if (data.results[0].address_components[2].long_name) {
                                            city = data.results[0].address_components[2].long_name;
                                        }

                                        if (data.results[0].address_components[4].short_name) {
                                            state = data.results[0].address_components[4].short_name;
                                        }

                                        $('#dp_' + id).val($('.mdp_address_' + id).val());
                                        $('#dp_' + id).removeAttr("readonly");
                                        $('#dp2_' + id).val($('#mdp_address2').val());
                                        $('#dp_zipcode_' + id).val($('.mdp_zipcode_' + id).val());
                                        $('#dp_lat_' + id).val(lat);
                                        $('#dp_lng_' + id).val(lng);

                                        $('#or_city').val(city);
                                        $('#or_state').val(state);
                                        $('#or_city').removeAttr("readonly");
                                        $('#or_state').removeAttr("readonly");

                                        $('#destinationAddressModal').modal('toggle');

//                  console.log('state: ' + state + ', lat: ' + lat + ', lng: ' + lng + ', zipcode: ' + zipcode);
//                $('#result_destination').show();
                                    }
                                });
                            });

                            //view drop address

                            $('body').on('click', '#view_drop', function (evt) {
                                evt.preventDefault();

                                var drop = $(this);
                                var id = drop.data('shp_id');
                                var addr = $('#mdp_address').val();
                                var zip = $('#mdp_zipcode').val();
                                var address = $('#mdp_address').val() + ', ' + $('#mdp_zipcode').val();
                                var url_address = address.split(' ').join('+');

                                if (addr == '' || zip == '') {
                                    $('#drop_form_error').html('address and/or zipcode can not be empty.');
                                    $('#drop_form_error').show();
                                    return false;
                                }

                                $.ajax({
                                    type: "POST",
                                    url: 'https://maps.googleapis.com/maps/api/geocode/json?address=' + url_address + '&key=AIzaSyAp8XadZn74QX4NLDphnzehQ0AN7q6NCwg',
                                    async: true,
                                    dataType: "json",
                                    beforeSend: function () {
                                        $('#result_destination').html('Loading...');
                                        $('#result_destination').show();
                                    },
                                    success: function (data) {
                                        var city = '';
                                        var state = '';

                                        var lat = data.results[0].geometry.location.lat;
                                        var lng = data.results[0].geometry.location.lng;

                                        initialize2(lat, lng, 'map-canvas2');
                                        $('#drop_form_error').hide();
                                        $('#map-canvas2').css('display', 'block');
                                        $('.modal').animate({
                                            height: "664px"
                                        });


//                  console.log('state: ' + state + ', lat: ' + lat + ', lng: ' + lng + ', zipcode: ' + zipcode);
//                $('#result_destination').show();
                                    }
                                });
                            });

                            function initialize2(lng, lat, canvas) {
//            console.log('long and lat: ' + lng + ', ' + lat);
                                $("#map_pickup").html("");
                                $("#map_drop").html("<div id='map-canvas2'></div>");
                                var myLatlng = new google.maps.LatLng(lng, lat);
                                var mapOptions = {
                                    zoom: 13,
                                    center: myLatlng
                                }

                                var map = new google.maps.Map(document.getElementById(canvas), mapOptions);
                                google.maps.event.trigger(map, "resize");
                                var marker = new google.maps.Marker({
//            icon: 'map-marker-driver.png',
                                    position: new google.maps.LatLng(lng, lat),
                                    map: map
                                });

                            }

                        });

                        var global_pickup = 0;
                        var global_drop = 0;
                        var delete_shipment = [];

                        function setShipmentData(shp_number) {
                            var first_cust_contacts = '';
                            var first_cust_contact_id = 0;
                            var new_first_contacts_json = '';
                            $.ajax({
                                type: "POST",
                                url: '<?php echo site_url('customer/get') ?>',
                                async: false,
                                dataType: "json",
                                success: function (o) {

                                    var customers = o.customers;
                                    first_cust_contact_id = customers[0].idts_customer;
                                    var fc_contacts = o.first_cust_contacts;
                                    var output = '';
                                    output += '<select data-shp="' + shp_number + '" class="select-customer" name="customer">';
                                    for (var i = 0; i < customers.length; i++) {
                                        output += '<option value="' + customers[i].idts_customer + '">' + customers[i].name + '</option>';
                                    }
                                    output += '</select>';
                                    $('#customer_list').html(output);

                                    //get first customer contact
                                    var contacts = [];
                                    for (var i = 0; i < fc_contacts.length; i++) {
                                        if (fc_contacts[i].default == 1) {
                                            first_cust_contacts += fc_contacts[i].name + ', ';
                                            contacts.push(
                                                    {
                                                        contact_id: fc_contacts[i].idts_customer_contact,
                                                        email: fc_contacts[i].email
                                                    });
                                        }
                                    }
                                    new_first_contacts_json = JSON.stringify(contacts);
                                }
                            });

                            //blanc space    
                            tRowSpace = $('<tr class="shp_' + shp_number + '">');
                            space = $('<td colspan = "6" style="border-left: none;border-right: none;">').html('&nbsp;');
                            tRowSpace.append(space);
                            $('#bol-table tbody').append(tRowSpace);

                            //Shipment number     
                            tRowSpace = $('<tr class="shp_' + shp_number + '">');
                            space = $('<td colspan = "6" style="background-color: #EBEBEB; font-size: 14px;font-weight: bolder;">').html('BOL #<span class="txt-bol-number"></span><span class="del-shipment" data-shp_id="0" data-shp_num="' + shp_number + '">X</span><type="hidden" name="type_' + shp_number + '" id="type_' + shp_number + '" value="0">');
                            tRowSpace.append(space);
                            $('#bol-table tbody').append(tRowSpace);

                            //First row headers
                            tRowHeader = $('<tr class="shp_' + shp_number + '">');
                            hCustomer = $('<td class="bol_header">').html('Customer');
                            hPickUp = $('<td class="bol_header">').html('Pickup address');
                            hPickUpNumber = $('<td class="bol_header">').html('Pickup #');
                            hDrop = $('<td class="bol_header">').html('Drop address');
                            hDropNumber = $('<td class="bol_header">').html('Drop #');

                            tRowHeader.append(hCustomer);
                            tRowHeader.append(hPickUp);
                            tRowHeader.append(hPickUpNumber);
                            tRowHeader.append(hDrop);
                            tRowHeader.append(hDropNumber);

                            $('#bol-table tbody').append(tRowHeader);

                            // First row Content <input type="hidden" name="type" id="type" value="1">
                            tRow = $('<tr id="shp_' + shp_number + '" class="shp_' + shp_number + '" data-data="1">');
                            customer = $('<td>').html($('#customer_list').html());
                            pickup = $('<td>').html('<input type="text" class="pk" id="pk_' + shp_number + '" name="pickup" style="width:220px" readonly/><input type="hidden" class="pk2" id="pk2_' + shp_number + '" name="pickup" style="width:235px"/><button type="button" class="btn btn-red btn-small" data-shp_id="' + shp_number + '" hidefocus="true" style="outline: medium none; margin: 0px 5px;" data-toggle="modal" data-target="#originAddressModal" id="set-model-pickup"><span class="gradient">+</span></button>');
                            pickupNumber = $('<td>').html('<input type="text" class="pk_number" id="pk_number_' + shp_number + '" name="pickup" style="width:50px;" /><input type="hidden" class="pk_zipcode" name="pk_zipcode_' + shp_number + '" id="pk_zipcode_' + shp_number + '"><input type="hidden" class="pk_lat" name="pk_lat_' + shp_number + '" id="pk_lat_' + shp_number + '"><input type="hidden" class="pk_lng" name="pk_lng_' + shp_number + '" id="pk_lng_' + shp_number + '">');
                            drop = $('<td>').html('<input type="text" class="dp" id="dp_' + shp_number + '" name="drop" style="width:220px" readonly/><input type="hidden" class="dp2" id="dp2_' + shp_number + '" name="drop"><button type="button" class="btn btn-red btn-small" data-shp_id="' + shp_number + '" hidefocus="true" style="outline: medium none;margin: 0px 5px;" data-toggle="modal" data-target="#destinationAddressModal" id="set-model-drop"><span class="gradient">+</span></button>');
                            dropNumber = $('<td>').html('<input type="text" class="dp_number" id="dp_number_' + shp_number + '" name="drop" style="width:50px;" /><input type="hidden" class="dp_zipcode" name="dp_zipcode_' + shp_number + '" id="dp_zipcode_' + shp_number + '"><input type="hidden" class="dp_lat" name="dp_lat_' + shp_number + '" id="dp_lat_' + shp_number + '"><input type="hidden" class="dp_lng" name="dp_lng_' + shp_number + '" id="dp_lng_' + shp_number + '"><input type="hidden" class="bol-num" name="dp_lng_' + shp_number + '" id="bol_num_' + shp_number + '" class="bol-num"><input type="hidden" class="type" name="type_' + shp_number + '" id="type_' + shp_number + '" value="0">');

                            tRow.append(customer);
                            tRow.append(pickup);
                            tRow.append(pickupNumber);
                            tRow.append(drop);
                            tRow.append(dropNumber);

                            $('#bol-table tbody').append(tRow);

                            //second row header and content
                            tRowContent = $('<tr id="shp_' + shp_number + '" class="shp_' + shp_number + '">');
                            bolNumber = $('<td colspan="2" style="width:125px">').html('BOL #<input type="text" data-iter="' + shp_number + '" id="bn_' + shp_number + '" class="bol-number" name="bol_number"/>');
                            bolFile = $('<td colspan="3">').html('BOL file<input type="file" id="shp_file_input' + shp_number + '" multiple = "multiple" accept = "application/pdf" class = "" name="uploadfile[]" size="20" />');

                            tRowContent.append(bolNumber);
                            tRowContent.append(bolFile);

                            $('#bol-table tbody').append(tRowContent);


                            $('#shp_' + shp_number + ' .select-customer').attr('id', 'shp_customer_' + shp_number);

                            //Contacts
                            tRowContact = $('<tr class="shp_' + shp_number + '">');
                            contact = $('<td colspan = "6">').html('Contacts: <span id="shp_contact_' + shp_number + '">' + first_cust_contacts + '</span><a href="#" title="Set Shipment Contacts" id="shp_contact_chg_' + shp_number + '" data-ship="' + shp_number + '" data-id_customer="' + first_cust_contact_id + '" class="pop" data-placement="right" data-content="Content">Change</a><input type="hidden" value="[]" name="ship_contacts_' + shp_number + '" id="ship_contacts_' + shp_number + '" />  ');
                            tRowContact.append(contact);
                            $('#bol-table tbody').append(tRowContact);

                            $('#ship_contacts_' + shp_number).val(new_first_contacts_json);

                        }


                        function getShipmentData() {
                            var j = 1;
                            var shipments = [];

                            $('#bol-table tbody tr').each(function () {
                                var tr = $(this);

                                if (tr.data('data') == 1) {
                                    shipments.push({
                                        index: j,
                                        bol_number: tr.find('.bol-num').val(),
                                        shipment_id: tr.find('.shp_db_id').val(),
                                        shp_file_sw: tr.find('.shp_file_sw').val(),
                                        type: tr.find('.type').val(),
                                        customer: tr.find('select').val(),
                                        pickup: tr.find('.pk').val(),
                                        pickup2: tr.find('.pk2').val(),
                                        pickup_number: tr.find('.pk_number').val(),
                                        pickup_zipcode: tr.find('.pk_zipcode').val(),
                                        pickup_lat: tr.find('.pk_lat').val(),
                                        pickup_lng: tr.find('.pk_lng').val(),
                                        drop: tr.find('.dp').val(),
                                        drop2: tr.find('.dp2').val(),
                                        drop_number: tr.find('.dp_number').val(),
                                        drop_zipcode: tr.find('.dp_zipcode').val(),
                                        drop_lat: tr.find('.dp_lat').val(),
                                        drop_lng: tr.find('.dp_lng').val()
                                    });
                                    j++;

                                }

                            });


                            console.log('total shp: ' + j);

                            var clean_shp = [];
                            var cont = 0;

                            console.log(shipments);
                            for (var i = 0, l = shipments.length; i < l; i++) {
                                var obj = shipments[i];
                                cont++;

//                            if (!('bol_number' in obj)) {
//                                console.log('not set');
//                            }else{
//                                console.log('set');
//                            }
//                            console.log(obj['bol_number']);
//                            if (!shipments[i]['bol_number']) {
//                                shipments.splice(i, 1);
//                            }
//
//                            if (obj.hasOwnProperty('bol_number')) {
//                                shipments.splice(i, 1);
//                            }

                            }
                            console.log('total shp: ' + cont);

//                        clean_shp = shipments
//                                .filter(function (el) {
//                                    return el.shipment_id === null;
//                                });

//                        someArray = [{name: "Kristian", lines: "2,5,10"},
//                            {name: "John", lines: "1,19,26,96"},
//                            {name: "Brian", lines: "3,9,62,36"}]
//                        johnRemoved = someArray
//                                .filter(function (el) {
//                                    return el.name !== "John";
//                                });

                            var json = JSON.stringify(shipments);
                            $('#shipments').val(json);
                            return true;
                        }


                        function showResponsex(data) {
                            $('#register_form_error').html('');
                            $('#register_form_error').hide();
                            $('.loading').hide();
                            var output = '<ul>';
                            if (data.status == 0) {
                                $.each(data.error, function (i, item) {
                                    console.log(data.error[i]);
                                    output += '<li>- ' + data.error[i] + '</li>';
                                });
                                output += '</ul>';
                                $('#register_form_error').html(output);
                                $('#register_form_error').show();
                                $("html, body").animate({scrollTop: $('#register_form_error').offset().top - 100}, 1000);

                                //enable buttons
                                $('#add_shp').prop('disabled', false);
                                $('#save_btn').prop('disabled', false);
                                $('#savensend_btn').prop('disabled', false);
                                $('#btn_cancel').prop('disabled', false);

                            } else {
                                $('#register_form_error').hide();
                                $('.loading').hide();
                                $('#register_form_success').html('Load Succesfully saved. Redirecting to Load list...');
                                $('#register_form_success').show();
                                $("html, body").animate({scrollTop: $('#register_form_success').offset().top - 100}, 1000);
//                            location.href = '<?php echo site_url('/load') ?>';
                            }
                        }

                        function showRequest() {

//        $("#tr_Features :input").each(function () {           // Iterate over inputs
//            features[$(this).attr('name')] = $(this).val();  // Add each to features object
//        });

                            var json = $.parseJSON($('#shipments').val());
                            var output = '<ul>';
                            var cont = 1;
                            $.each(json, function (key, value) {
                                /*if (value.pickup == '')
                                    output += '<li>Pickup address in BOL ' + cont + ' can not be null</li>';*/

                                /*if (value.pickup_number == '')
                                    output += '<li>Pickup # in BOL ' + cont + ' can not be null</li>';*/

                                /*if (value.drop == '')
                                    output += '<li>Drop address in BOL ' + cont + ' can not be null</li>';*/

                                /*if (value.drop_number == '')
                                    output += '<li>Drop # in BOL ' + cont + ' can not be null</li>';*/

                                if (value.bol_number == '')
                                    output += '<li>BOL # in BOL ' + cont + ' can not be null</li>';

                                /*if ($('#shp_file_input' + cont).val() == '') {
                                    output += '<li>You must upload a file in BOL ' + cont + '</li>';
                                }*/

                                cont++;
                            });
                            output += '</ul>';
                            if (output != '<ul></ul>') {
                                $('#register_form_error').html(output);
                                $('#register_form_error').show();
                                $("html, body").animate({scrollTop: $('#register_form_error').offset().top - 100}, 1000);
                                console.log(output);
                                return false;
                            }

                            $('.loading').show();
                            $("html, body").animate({scrollTop: $('.loading').offset().top - 100}, 1000);
                            $('#add_shp').prop('disabled', true);
                            $('#save_btn').prop('disabled', true);
                            $('#savensend_btn').prop('disabled', true);
                            $('#btn_cancel').prop('disabled', true);
                        }

                        function showResponse(data) {
                            $('#register_form_error').html('');
                            $('#register_form_error').hide();
                            $('.loading').hide();
                            var output = '<ul>';
                            if (data.status == 0) {
                                console.log('gor hete');
                                $.each(data.error, function (i, item) {
                                    output += '<li>- ' + data.error[i] + '</li>';
                                });
                                output += '</ul>';
                                $('#register_form_error').html(output);
                                $('#register_form_error').show();
                                $("html, body").animate({scrollTop: $('#register_form_error').offset().top - 100}, 1000);

                                //enable buttons
                                $('#add_shp').prop('disabled', false);
                                $('#save_btn').prop('disabled', false);
                                $('#savensend_btn').prop('disabled', false);
                                $('#btn_cancel').prop('disabled', false);

                            } else {
                                $('#register_form_error').hide();
                                $('.loading').hide();
                                $('#register_form_success').html('Load Succesfully saved. Redirecting to Load list...');
                                $('#register_form_success').show();
                                $("html, body").animate({scrollTop: $('#register_form_success').offset().top - 100}, 1000);
                                location.href = '<?php echo site_url('/load') ?>';
                            }
                        }



                        function getCustomerContacts(pop_contact) {
                            var id = pop_contact.data('id_customer');
                            var output = '';
                            $.ajax({
                                type: "POST",
                                url: '<?php echo site_url('customer/get_contact') ?>/' + id,
                                async: false,
                                dataType: "json",
                                success: function (o) {
                                    var contacts = o;
                                    output += '<table id="tbl_contacts_' + pop_contact.attr('id') + '" class="tbl_contacts"><tbody>';
                                    var ship_id = pop_contact.data('ship');
                                    var shipment_contacts = $('#ship_contacts_' + ship_id).val();
                                    var obj = $.parseJSON(shipment_contacts);
//                console.log(obj);

                                    if (obj.length > 0) {
                                        for (var i = 0; i < contacts.length; i++) {
                                            var checked = '';
                                            for (var j = 0; j < obj.length; j++) {
                                                if (obj[j].contact_id == contacts[i].idts_customer_contact) {
                                                    checked = 'checked';
                                                }
                                            }

                                            output += '<tr><td style="border: none;">\n\
            <input type="checkbox" class="tbl_contact_input" data-email="' + contacts[i].email + '" data-name="' + contacts[i].name + '" value="' + contacts[i].idts_customer_contact + '" ' + checked + '/>' + contacts[i].name + ' ' + ' &lt;' + contacts[i].email + '&gt;' + ' <br></td></tr>';
                                        }
                                    } else {
                                        console.log('got herer');
                                        for (var i = 0; i < contacts.length; i++) {
                                            var checked = '';
                                            if (contacts[i].default == 1) {
                                                checked = 'checked';
                                            }
                                            output += '<tr><td style="border: none;"><input type="checkbox" class="tbl_contact_input" data-name="' + contacts[i].name + '" value="' + contacts[i].idts_customer_contact + '" ' + checked + '/>' + contacts[i].name + ' &lt;' + contacts[i].email + '&gt;</td></tr>';
                                        }
                                    }

                                    output += '</tbody></table>';
                                    output += '<br><br>';
                                    output += '<input type="button" class="change_contacts" id="' + pop_contact.data('ship') + '" value="Change">&nbsp;';
                                    output += '<input type="button" class="cancel_pop_contacts"  onclick="$(&quot;#' + pop_contact.attr('id') + '&quot;).popover(&quot;hide&quot;);" data-pop="' + pop_contact + '" value="Cancel">';
                                }
                            });
                            return output;
                        }

                        function getPickupMap(pickup) {
                            var id = pickup.data('shp_id');
                            var addr = $('#mpk_address').val();
                            var zip = $('#mpk_zipcode').val();
                            var address = $('#mpk_address').val() + ', ' + $('#mpk_zipcode').val();
                            var url_address = address.split(' ').join('+');

                            if (addr == '' || zip == '') {
                                $('#pickup_form_error').html('address and/or zipcode can not be empty.');
                                $('#pickup_form_error').show();
                                return false;
                            }

                            $.ajax({
                                type: "POST",
                                url: 'https://maps.googleapis.com/maps/api/geocode/json?address=' + url_address + '&key=AIzaSyAp8XadZn74QX4NLDphnzehQ0AN7q6NCwg',
                                async: true,
                                dataType: "json",
                                beforeSend: function () {
                                    $('#result_destination').html('Loading...');
                                    $('#result_destination').show();
                                },
                                success: function (data) {

                                    if (data.status == 'ZERO_RESULTS') {
                                        $('#pickup_form_error').html('Address and/or zipcode not found, Please check.');
                                        $('#pickup_form_error').show();
                                        return false;
                                    } else {

                                        var city = '';
                                        var state = '';

                                        var lat = data.results[0].geometry.location.lat;
                                        var lng = data.results[0].geometry.location.lng;

                                        initialize(lat, lng, 'map-canvas');
                                        $('#pickup_form_error').hide();
                                        $('#map-canvas').css('display', 'block');
                                        $('#map-canvas').css('display', 'block');
                                        $('.modal').animate({
                                            height: "664px"
                                        });

//                  console.log('state: ' + state + ', lat: ' + lat + ', lng: ' + lng + ', zipcode: ' + zipcode);
//                $('#result_destination').show();
                                    }

                                }
                            });
                        }

                        function initialize(lng, lat, canvas) {
//            console.log('long and lat: ' + lng + ', ' + lat);
                            $("#map_pickup").html("<div id='map-canvas'></div>");
                            $("#map_drop").html("");
                            var myLatlng = new google.maps.LatLng(lng, lat);
                            var mapOptions = {
                                zoom: 13,
                                center: myLatlng
                            }

                            var map = new google.maps.Map(document.getElementById(canvas), mapOptions);
                            google.maps.event.trigger(map, "resize");
                            var marker = new google.maps.Marker({
//            icon: 'map-marker-driver.png',
                                position: new google.maps.LatLng(lng, lat),
                                map: map
                            });

                        }

</script>