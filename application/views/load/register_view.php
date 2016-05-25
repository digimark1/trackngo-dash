<div id="category-actions">
    <div class="loads-title" id="category-title"><img src="<?php echo base_url() ?>/public/img/images/loads-title.png" width="100" height="70" alt="Loads Category"></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All Loads"></a></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/add'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" alt="Add a Load"></a></div>
</div>  
<div class="container">
    <div class="row">
        <div class="container">
            <div>
                <h2>New Load #<?php echo $last_load['load_number'] + 1 ?></h2>
                <?php echo $error; ?>
                <?php $attributes = array('id' => 'register3_form', 'class' => 'upload-image-form'); ?>
                <div id="register_form_error" class="alert alert-error" style="display:none"><!-- Dynamic --></div>
                <div id="register_form_success" class="success alert-success" style="display:none"><!-- Dynamic --></div>
                <?php echo form_open_multipart('load/do_upload', $attributes); ?>
                    <input type="hidden" name="load_number" value="<?php echo $last_load['load_number'] + 1 ?>" />
                    <div>
                        <div class="control-group">
                            <label class="control-label">Carrier</label>
                            <div class="controls">
                                <select class="selectpicker" name="carrier" id="carrier">
                                    <option value="0" selected="selected">-Select-</option>
                                    <?php
                                    foreach ($carriers as $carrier => $row) {
                                        echo '<option value="' . $row['idts_carrier'] . '">' . $row['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function(){
                                setTimeout(function(){
                                    $('#carrier').val('1');
                                    $("#carrier").change();
                                },500);
                            });
                        </script>

                        <div class="control-group">
                            <label class="control-label">Driver</label>
                            <div class="controls">
                                <select class="selectpicker" name="driver" id="driver">
                                    <option value="select" selected="selected">-Select-</option>
                                    <input type="hidden" id="shipments" name="shipments">
                                    <input type="hidden" id="status" name="status">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="loading" style="display:none">
                        <div class="loading-bg"></div>
                        <!--<div class="loading-msg">Saving...</div>-->
                    </div>

                    <div id="customer_list"></div>
                    <!--                <div id="set_shp">set Shipment</div>-->

                    <table id="bol-table" class="table table-hover table-striped">
                        <tbody>
                            <tr class="shp_1">
                                <td colspan="5" style="background-color: #EBEBEB; font-size: 14px;font-weight: bolder;">BOL #<span class="txt-bol-number"></span></td>
                            </tr>
                            <tr class="shp_1">
                                <td class="bol_header">Customer</td>
                                <td class="bol_header">Pickup address</td>
                                <td class="bol_header">Pickup #</td>
                                <td class="bol_header">Drop address</td>
                                <td class="bol_header">Drop #</td>
    <!--                            <td class="bol_header" style="width:120px">BOL #</td>
                                <td class="bol_header">BOL file</td>-->
                            </tr>                        
                            <tr id="shp_1" class="shp_1">
                                <td>
                                    <select data-shp ="1" class="select-customer" name="customer">
                                        <?php
                                        foreach ($customers as $customer => $row) {
                                            echo '<option data-id="1" value="' . $row['idts_customer'] . '">' . $row['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="pk" id="pk_1" name="pickup" readonly="readonly" style="width:235px"/>
                                    <input type="hidden" class="pk2" id="pk2_1" name="pickup" style="width:235px"/>
                                    <button type="button" class="btn btn-red btn-small" data-shp_id="1" hidefocus="true" style="outline: medium none; margin: 0px 5px;" data-toggle="modal" data-target="#originAddressModal" id="set-model-pickup">
                                        <span class="gradient">+</span>
                                    </button>
                                </td>
                                <td>
                                    <input type="text" class="pk_number" id="pk_number_1" name="pickup_number" style="width:50px;"/>
                                    <input type="hidden" class="pk_zipcode" name="pk_zipcode_1" id="pk_zipcode_1">
                                    <input type="hidden" class="pk_lat" name="pk_lat_1" id="pk_lat_1">
                                    <input type="hidden" class="pk_lng" name="pk_lng_1" id="pk_lng_1">
                                    <input type="hidden" class="pk_time" name="pk_time_1" id="pk_time_1">
                                    <input type="hidden" class="pk_company_name" name="pk_company_name_1" id="pk_company_name_1">
                                    <input type="hidden" class="pk_reference" name="pk_reference_1" id="pk_reference_1">
                                    <input type="hidden" class="pk_instructions" name="pk_instructions_1" id="pk_instructions_1">
                                </td>
                                <td>
                                    <input type="text" class="dp" id="dp_1" name="drop" readonly="readonly" style="width:235px">
                                    <input type="hidden" class="dp2" id="dp2_1" name="drop">
                                    <button type="button" class="btn btn-red btn-small" data-shp_id="1" hidefocus="true" style="outline: medium none;margin: 0px 5px;" data-toggle="modal" data-target="#destinationAddressModal" id="set-model-drop">
                                        <span class="gradient">+</span>
                                    </button>
                                </td>
                                <td>
                                    <input type="text" class="dp_number" id="dp_number_1" name="drop_number" style="width:50px;"/>
                                    <input type="hidden" class="dp_zipcode" name="dp_zipcode_1" id="dp_zipcode_1">
                                    <input type="hidden" class="dp_lat" name="dp_lat_1" id="dp_lat_1">
                                    <input type="hidden" class="dp_lng" name="dp_lng_1" id="dp_lng_1">
                                    <input type="hidden" class="bol-num" name="bol-num" id="bol_num_1" class="bol-num">
                                    <input type="hidden" class="dp_time" name="dp_time_1" id="dp_time_1">
                                    <input type="hidden" class="dp_company_name" name="dp_company_name_1" id="dp_company_name_1">
                                    <input type="hidden" class="dp_reference" name="dp_reference_1" id="dp_reference_1">
                                    <input type="hidden" class="dp_instructions" name="dp_instructions_1" id="dp_instructions_1">
                                </td>                    
                            </tr>
                            <tr class="shp_1">
                                <td colspan="2">BOL #: <input type="text" id="bn_1" class="bol-number" name="bol_number"/></td>
                                <td colspan="3">BOL file <input type="file" id="shp_file_1" multiple = "multiple" accept = "application/pdf" class = "" name="uploadfile[]" size="20" /></td>
                            </tr>
                            <tr class="shp_1">
                                <td colspan="5">Contacts:
                                    <span id="shp_contact_1">
                                        <?php
                                        $customer_id = 0;
                                        foreach ($first_customer_contacts as $first_customer_contact => $row) {
                                            if ($row['default'] == 1) {
                                                echo $row['name'] . ', ';
                                            }
                                            $customer_id = $row['ts_customer_idts_customer'];
                                        }
                                        ?>                                    
                                    </span>                                
                                    <a href="#" title="Set Shipment Contacts" id="shp_contact_chg_1" data-ship="1" class="pop" data-placement="right" data-content="Content" data-id_customer="<?php echo $customer_id ?>">Change</a>
                                    <input type="hidden" name="ship_contacts_1" id="ship_contacts_1" value="[]"/>                                 
                                </td>
                            </tr>
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
                                        <legend style="margin:10px 0px">Check Address in Map</legend>
                                        <div id="pickup_form_error" class="alert alert-error" style="display:none"><!-- Dynamic --></div>
                                        <table id="tbl-shp-view">
                                            <tr>
                                                <td>Address:</td>
                                                <td colspan="2">
                                                    <input type="text" id="mpk_address" name="drop_number" style="width:250px;"/>
                                                    <button id="view_pickup" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;">
                                                        <span class="gradient">View in map</span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Address 2:</td>
                                                <td>
                                                    <input type="text" id="mpk_address2" name="address2" style="width:250px;"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Zipcode:</td>
                                                <td>
                                                    <input type="text" id="mpk_zipcode" name="drop_number" style="width:250px;"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pickup Time:</td>
                                                <td>
                                                    <input type="text" id="mpk_op_time" name="drop_number" style="width:250px;"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Company Name:</td>
                                                <td>
                                                    <input type="text" id="mpk_com_name" name="drop_number" style="width:250px;"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Reference:</td>
                                                <td>
                                                    <input type="text" id="mpk_reference" name="drop_number" style="width:250px;"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Special Instructions:</td>
                                                <td>
                                                    <!--<input type="text" id="mpk_sp_instru" name="drop_number" style="width:250px;"/>-->
                                                    <textarea id="mpk_sp_instru" name="drop_number"></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                        <div id="map_pickup">
                                            <div id="map-canvas"></div>                                    
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                                    <!--<button type="button" id="confirm_origin" class="btn btn-primary">Ok</button>-->
                                    <button data-dismiss="modal" style="border-radius: 16%; height: 25px;">Close</button>
                                    <button id="set_pickup" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;">
                                        <span class="gradient">Save</span>
                                    </button>
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
                                                <td colspan="2">
                                                    <input type="text" id="mdp_address" class="mdp_address" name="drop_number" style="width:250px;">
                                                    <button id="view_drop" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;">
                                                        <span class="gradient">View in map</span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Address2:</td>
                                                <td>
                                                    <input type="text" id="mdp_address2" class="mdp_address2" name="drop_number" style="width:250px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Zipcode:</td>
                                                <td>
                                                    <input type="text" id="mdp_zipcode" class="mdp_zipcode" name="drop_number" style="width:250px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Delivey Time:</td>
                                                <td>
                                                    <input type="text" id="mdp_op_time" class="mdp_op_time" name="drop_number" style="width:250px;"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Company Name:</td>
                                                <td>
                                                    <input type="text" id="mdp_com_name" class="mdp_com_name" name="drop_number" style="width:250px;"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Reference:</td>
                                                <td>
                                                    <input type="text" id="mdp_reference" class="mdp_reference" name="drop_number" style="width:250px;"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Special Instructions:</td>
                                                <td>
                                                    <!--<input type="text" id="mdp_sp_instru" class="mdp_sp_instru" name="drop_number" style="width:250px;"/>-->
                                                    <textarea id="mdp_sp_instru" class="mdp_sp_instru" name="drop_number"></textarea>
                                                </td>
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
                                    <button id="set_drop" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;">
                                        <span class="gradient">Save</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button id="add_shp" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;">
                        <span class="gradient">Add Shipment</span>
                    </button>
                    <br /><br />
                    <button type="submit" id="save_btn" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;">
                        <span class="gradient">Save</span>
                    </button>
                    <button type="submit" id="savensend_btn" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;">
                        <span class="gradient">Save and send</span>
                    </button>
                    <button id="btn_cancel" style="border-radius: 16%; height: 25px;">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style> 

    select{
        width: 180px;
    }

    input[type="file"]{
        width: 310px;
    }

    #bol-table{
        width: 910px;
    }
    #bol-table td{
        border: 1px solid #DCD8D8;
    }

    .bol_header{
        text-align: center !important;
        color: #666 !important;        
    }

    #add_shp{
        float: right;
        margin: 10px 0px 0px 0px;
    }

    .tbl_contacts td{
        border: none;
    }

    .control-group{
        margin: 20px 0px;
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

    .modal{
        width: 620px;
        overflow: auto;
        //height: 490px;
        height: 635px;
    }

    .modal-body{
        height: auto;
        min-height: 305px;
        max-height: 680px;
    } 

    .modal.fade.in{
        top: 5%;
    }
    
    #map_pickup, #map_drop {
        margin-top: 10px;
        margin-right: 10px;
    }
    
    #mpk_sp_instru, #mdp_sp_instru {
        height: 80px;
    }
</style>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAp8XadZn74QX4NLDphnzehQ0AN7q6NCwg"></script>
<script>
    $(function () {

        // form messages

        //get first contact customers
        $.post('<?php echo site_url('customer/get_contact/' . $customer_id) ?>/', function (o) {
            var contact = o;
            var contacts = [];
            for (var i = 0; i < contact.length; i++) {
                if (contact[i].default == 1) {
                    contacts.push(
                            {
                                contact_id: contact[i].idts_customer_contact,
                                email: contact[i].email
                            });
                }
            }
            var json = JSON.stringify(contacts);
            $('#ship_contacts_1').val(json);

        }, 'json');

        var shp_number = 1;
        //initialize customer lis hidden

        $('#customer_list').hide();
        $('#map-canvas').css('display', 'none');

        //Enabel tender to driver
        $('body').on('click', '#savensend_btn', function (evt) {
            $('#status').val(1);
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
            $('#mpk_op_time').attr('class', 'mpk_op_time_' + pickup.data('shp_id'));
            $('#mpk_com_name').attr('class', 'mpk_com_name_' + pickup.data('shp_id'));
            $('#mpk_sp_instru').attr('class', 'mpk_sp_instru_' + pickup.data('shp_id'));
            $('#mpk_reference').attr('class', 'mpk_reference_' + pickup.data('shp_id'));
//            $('#mpk_address').val('');
//            $('#mpk_address2').val('');
//            $('#mpk_zipcode').val('');
//            $('#mpk_op_time').val('');
//            $('#mpk_com_name').val('');
//            $('#mpk_sp_instru').val('');
//            $('#mpk_reference').val('');            
            $('#mpk_address').val($('#pk_' + pickup.data('shp_id')).val());
            $('#mpk_address2').val($('#pk2_' + pickup.data('shp_id')).val());
            $('#mpk_zipcode').val($('#pk_zipcode_' + pickup.data('shp_id')).val());

            $('#mpk_op_time').val($('#pk_time_' + pickup.data('shp_id')).val());
            $('#mpk_com_name').val($('#pk_company_name_' + pickup.data('shp_id')).val());
            $('#mpk_sp_instru').val($('#pk_instructions_' + pickup.data('shp_id')).val());
            $('#mpk_reference').val($('#pk_reference_' + pickup.data('shp_id')).val())
            
            $("#map_pickup").html("");
            //$('.modal').css('height', '490px');
            $('.modal').css('height', '635px');
            $('#pickup_form_error').hide();
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
            $('#mdp_op_time').attr('class', 'mdp_op_time_' + drop.data('shp_id'));
            $('#mdp_com_name').attr('class', 'mdp_com_name_' + drop.data('shp_id'));
            $('#mdp_sp_instru').attr('class', 'mdp_sp_instru_' + drop.data('shp_id'));
            $('#mdp_reference').attr('class', 'mdp_reference_' + drop.data('shp_id'));
//            $('#mdp_address').val('');
//            $('#mdp_address2').val('');
//            $('#mdp_zipcode').val('');
//            $('#mdp_op_time').val('');
//            $('#mdp_com_name').val('');
//            $('#mdp_sp_instru').val('');
//            $('#mdp_reference').val('');
            
            $('#mdp_address').val($('#dp_' + drop.data('shp_id')).val());
            $('#mdp_address2').val($('#dp2_' + drop.data('shp_id')).val());
            $('#mdp_zipcode').val($('#dp_zipcode_' + drop.data('shp_id')).val());

            $('#mdp_op_time').val($('#dp_time_' + drop.data('shp_id')).val());
            $('#mdp_com_name').val($('#dp_company_name_' + drop.data('shp_id')).val());
            $('#mdp_sp_instru').val($('#dp_instructions_' + drop.data('shp_id')).val());
            $('#mdp_reference').val($('#dp_reference_' + drop.data('shp_id')).val())
            
            $("#map_drop").html("");
            //$('.modal').css('height', '490px');
            $('.modal').css('height', '635px')
            $('#drop_form_error').hide();
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

            //if (addr == '' || zip == '') {
			if (addr == '') {
                //$('#pickup_form_error').html('address and/or zipcode can not be empty.');
				$('#pickup_form_error').html('address field can not be empty.');
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
                    }
                    var city = '';
                    var state = '';

                    var lat = data.results[0].geometry.location.lat;
                    var lng = data.results[0].geometry.location.lng;
                    if (data.results[0].address_components[2].long_name) {
                        city = data.results[0].address_components[2].long_name;
                    }

                   if(data.results[0].address_components[4]){
						////////
						if (data.results[0].address_components[4].short_name) {
							state = data.results[0].address_components[4].short_name;
						}
						//////
					}
                    
                    //alert($('.mpk_sp_instru_' + id).val());

                    $('#pk_' + id).val($('#mpk_address').val());
                    $('#pk2_' + id).val($('#mpk_address2').val());
                    $('#pk_' + id).removeAttr("readonly");
                    $('#pk_zipcode_' + id).val($('.mpk_zipcode_' + id).val());
                    $('#pk_time_' + id).val($('.mpk_op_time_' + id).val());
                    $('#pk_company_name_' + id).val($('.mpk_com_name_' + id).val());
                    $('#pk_reference_' + id).val($('.mpk_reference_' + id).val());
                    $('#pk_instructions_' + id).val($('.mpk_sp_instru_' + id).val());
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
            });
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

            //if (addr == '' || zip == '') {
			if (addr == '') {
                //$('#drop_form_error').html('address and/or zipcode can not be empty.');
				$('#drop_form_error').html('address field can not be empty.');
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

                    if (data.status == 'ZERO_RESULTS') {
                        $('#drop_form_error').html('Address and/or zipcode not found, Please check.');
                        $('#drop_form_error').show();
                        return false;
                    }

                    var city = '';
                    var state = '';

                    var lat = data.results[0].geometry.location.lat;
                    var lng = data.results[0].geometry.location.lng;
                    if (data.results[0].address_components[2].long_name) {
                        city = data.results[0].address_components[2].long_name;
                    }
					if(data.results[0].address_components[4]){
						////////
						if (data.results[0].address_components[4].short_name) {
							state = data.results[0].address_components[4].short_name;
						}
						//////
					}

                    $('#dp_' + id).val($('.mdp_address_' + id).val());
                    $('#dp_' + id).removeAttr("readonly");
                    $('#dp2_' + id).val($('#mdp_address2').val());
                    $('#dp_zipcode_' + id).val($('.mdp_zipcode_' + id).val());
                    $('#dp_time_' + id).val($('.mdp_op_time_' + id).val());
                    $('#dp_company_name_' + id).val($('.mdp_com_name_' + id).val());
                    $('#dp_reference_' + id).val($('.mdp_reference_' + id).val());
                    $('#dp_instructions_' + id).val($('.mdp_sp_instru_' + id).val());
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

/*            if (addr == '' || zip == '') {
                $('#drop_form_error').html('address and/or zipcode can not be empty.');
                $('#drop_form_error').show();
                return false;
            }*/
			        //if (addr == '' || zip == '') {
		if (addr == '') {
            //$('#pickup_form_error').html('address and/or zipcode can not be empty.');
			$('#drop_form_error').html('address field can not be empty.');
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

                    if (data.status == 'ZERO_RESULTS') {
                        $('#drop_form_error').html('Address and/or zipcode not found, Please check.');
                        $('#drop_form_error').show();
                        return false;
                    } else {
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

        //Contacts popover
        $('body').on('click', '.pop', function (evt) {
            evt.preventDefault();
            var pop_contact = $(this);
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

        //Delete Shipment
        $('body').on('click', '.del-shipment', function (evt) {
            evt.preventDefault();
            var del = $(this);
            var tr = del.data('shp_num');

            $('.shp_' + tr).remove();
        });

        // Dinamyc BOL# fill
//        $(".").keyup(function () {
//            var $this = $(this);
//            window.setTimeout(function () {
//                $("div").text($this.val());
//            }, 0);
//        });

        $('body').on('keyup', '.bol-number', function (evt) {
            evt.preventDefault();
            var bol = $(this);
            var tr = bol.parent().parent().prop('class');
            $('.' + tr + ' .txt-bol-number').html(bol.val());
            $('.' + tr + ' .bol-num').val(bol.val());
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

        // Close contacts popover
//        $('body').on('click', '.cancel_pop_contacts', function (evt) {
//            evt.preventDefault();
//            var pop = $(this).data('pop');
//            pop.popover('hide');
//        });

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


        //Add new row to Shipment the table
        $('body').on('click', '#add_shp', function (evt) {
            evt.preventDefault();
            shp_number++;
            setShipmentData(shp_number);
//            $('#bol-table tbody').append('<tr id="shp_' + shp_number + '">'+shp_number+'<td id="customer_' + shp_number + '">Customer</td><td><input type="text" name="pickup"/></td><td><input type="text" name="drop"/></td><td><input type="text" name="bol_number"/></td><td><input type="file" multiple = "multiple" accept = "image/*" class = "form-control" name="uploadfile[]" size="20" /></td></tr>');
//                    $('#customer_' + shp_number).html($('#customer_list').html());
        });

        //Send form
        var options = {
            beforeSend: getShipmentData,
            dataType: "json",
            data: {
                shipments: $('#shipments').val()
            },
            success: function (data) {
                // Output AJAX response to the div container
//                        $(".upload-image-messages").html(response.responseText);
//                        $('html, body').animate({scrollTop: $(".upload-image-messages").offset().top - 100}, 150);
            },
            complete: function (response) {
                // Output AJAX response to the div container
                console.log(response);
//                        $(".upload-image-messages").html(response.responseText);
//                        $('html, body').animate({scrollTop: $(".upload-image-messages").offset().top - 100}, 150);

            }
        };
        // Submit the form
//        $(".upload-image-form").ajaxForm(options);


        $('body').on('click', '#btn_cancel', function (evt) {
            evt.preventDefault();
            location.href = '<?php echo site_url('/load') ?>';
        });
        
//        $(document).ready(function(){
//            setTimeout(function(){
//                var carrier = $(this);
//                $('#driver option').remove();
//                $('#driver').append('<option value="loading">loading...</option>');
//                var postData = {carrier_id: $(this).val()
//                };
//                console.log(carrier.val());
//                if (carrier.val() == 0) {
//                    $('#driver option').remove();
//                    $('#driver').append('<option value="0">-Select-</option>');
//                } else {
//
//                    $.post('<?php echo base_url('carrier/get_drivers_by_carrier') ?>', postData, function (o) {
//                        $('#driver option').remove();
//                        var drivers = o;
//                        var output = '';
//                        if (drivers.length == 0) {
//                            output += '<option value="no_driver">-No driver asigned to this carrier-</option>';
//                        }
//
//                        if (carrier.val() === 'select') {
//                            output += '<option value="select">-Select-</option>';
//                        }
//
//                        for (var i = 0; i < drivers.length; i++) {
//                            output += '<option value="' + drivers[i].idts_driver + '">' + drivers[i].name + ' ' + drivers[i].last_name + '</option>';
//                        }
//
//                        $('#driver').append(output);
//
//                    }, 'json');
//                }
//            },500);
//        });
        $("#carrier").change(function () {        
            var carrier = $(this);
            $('#driver option').remove();
            $('#driver').append('<option value="loading">loading...</option>');
            var postData = {carrier_id: $(this).val()
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
    });

    var global_pickup = 0;
    var global_drop = 0;

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
        space = $('<td colspan = "6" style="background-color: #EBEBEB; font-size: 14px;font-weight: bolder;">').html('BOL #<span class="txt-bol-number"></span><span class="del-shipment" data-shp_num="' + shp_number + '">X</span>');
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

        // First row Content
        tRow = $('<tr id="shp_' + shp_number + '" class="shp_' + shp_number + '">');
        customer = $('<td>').html($('#customer_list').html());
        pickup = $('<td>').html(
            '<input type="text" class="pk" id="pk_' + shp_number + '" name="pickup" style="width:235px" readonly/>\n\
            <input type="hidden" class="pk2" id="pk2_' + shp_number + '" name="pickup" style="width:235px"/>\n\
            <button type="button" class="btn btn-red btn-small" data-shp_id="' + shp_number + '" hidefocus="true" style="outline: medium none; margin: 0px 5px;" data-toggle="modal" data-target="#originAddressModal" id="set-model-pickup">\n\
                <span class="gradient">+</span>\n\
            </button>'
        );
        pickupNumber = $('<td>').html( 
            '<input type="text" class="pk_number" id="pk_number_' + shp_number + '" name="pickup" style="width:50px;" />\n\
            <input type="hidden" class="pk_zipcode" name="pk_zipcode_' + shp_number + '" id="pk_zipcode_' + shp_number + '">\n\
            <input type="hidden" class="pk_time" name="pk_time_' + shp_number + '" id="pk_time_' + shp_number + '">\n\
            <input type="hidden" class="pk_company_name" name="pk_company_name_' + shp_number + '" id="pk_company_name_' + shp_number + '">\n\
            <input type="hidden" class="pk_reference" name="pk_reference_' + shp_number + '" id="pk_reference_' + shp_number + '">\n\
            <input type="hidden" class="pk_instructions" name="pk_instructions_' + shp_number + '" id="pk_instructions_' + shp_number + '">\n\
            <input type="hidden" class="pk_lat" name="pk_lat_' + shp_number + '" id="pk_lat_' + shp_number + '">\n\
            <input type="hidden" class="pk_lng" name="pk_lng_' + shp_number + '" id="pk_lng_' + shp_number + '">'
        );
        drop = $('<td>').html(
            '<input type="text" class="dp" id="dp_' + shp_number + '" name="drop" style="width:242px" readonly/>\n\
            <input type="hidden" class="dp2" id="dp2_' + shp_number + '" name="drop">\n\
            <button type="button" class="btn btn-red btn-small" data-shp_id="' + shp_number + '" hidefocus="true" style="outline: medium none;margin: 0px 5px;" data-toggle="modal" data-target="#destinationAddressModal" id="set-model-drop">\n\
                <span class="gradient">+</span>\n\
            </button>'
        );
        dropNumber = $('<td>').html(
            '<input type="text" class="dp_number" id="dp_number_' + shp_number + '" name="drop" style="width:50px;" />\n\
            <input type="hidden" class="dp_zipcode" name="dp_zipcode_' + shp_number + '" id="dp_zipcode_' + shp_number + '">\n\
            <input type="hidden" class="dp_time" name="dp_time_' + shp_number + '" id="dp_time_' + shp_number + '">\n\
            <input type="hidden" class="dp_company_name" name="dp_company_name_' + shp_number + '" id="dp_company_name_' + shp_number + '">\n\
            <input type="hidden" class="dp_reference" name="dp_reference_' + shp_number + '" id="dp_reference_' + shp_number + '">\n\
            <input type="hidden" class="dp_instructions" name="dp_instructions_' + shp_number + '" id="dp_instructions_' + shp_number + '">\n\
            <input type="hidden" class="dp_lat" name="dp_lat_' + shp_number + '" id="dp_lat_' + shp_number + '">\n\
            <input type="hidden" class="dp_lng" name="dp_lng_' + shp_number + '" id="dp_lng_' + shp_number + '">\n\
            <input type="hidden" class="bol-num" name="bol_num_' + shp_number + '" id="bol-num_' + shp_number + '" class="bol-num">'
        );

        tRow.append(customer);
        tRow.append(pickup);
        tRow.append(pickupNumber);
        tRow.append(drop);
        tRow.append(dropNumber);

        $('#bol-table tbody').append(tRow);

        //second row header and content
        tRowContent = $('<tr id="shp_' + shp_number + '" class="shp_' + shp_number + '">');
        bolNumber = $('<td colspan="2" style="width:125px">').html(
            'BOL #<input type="text" id="bn_' + shp_number + '" class="bol-number" name="bol_number"/>'
        );
        bolFile = $('<td colspan="3">').html(
            'BOL file<input type="file" id="shp_file_' + shp_number + '" multiple = "multiple" accept = "application/pdf" class = "" name="uploadfile[]" size="20" />'
        );

        tRowContent.append(bolNumber);
        tRowContent.append(bolFile);

        $('#bol-table tbody').append(tRowContent);


        $('#shp_' + shp_number + ' .select-customer').attr('id', 'shp_customer_' + shp_number);

        //Contacts
        tRowContact = $('<tr class="shp_' + shp_number + '">');
        contact = $('<td colspan = "6">').html(
            'Contacts: <span id="shp_contact_' + shp_number + '">' + first_cust_contacts + '</span>\n\
            <a href="#" title="Set Shipment Contacts" id="shp_contact_chg_' + shp_number + '" data-ship="' + shp_number + '" data-id_customer="' + first_cust_contact_id + '" class="pop" data-placement="right" data-content="Content">Change</a>\n\
            <input type="hidden" value="[]" name="ship_contacts_' + shp_number + '" id="ship_contacts_' + shp_number + '" /> '
        );
        tRowContact.append(contact);
        $('#bol-table tbody').append(tRowContact);

        $('#ship_contacts_' + shp_number).val(new_first_contacts_json);
    }

    function getShipmentData() {
        var j = 1;
        var shipments = [];

        $('#bol-table tbody tr').each(function () {

            var tr = $(this);
            if (tr.find('select').val() != null) {
                shipments.push({
                    index: j,
                    customer: tr.find('select').val(),
                    pickup: tr.find('.pk').val(),
                    pickup2: tr.find('.pk2').val(),
                    pickup_number: tr.find('.pk_number').val(),
                    pickup_zipcode: tr.find('.pk_zipcode').val(),
                    pickup_time: tr.find('.pk_time').val(),
                    pickup_company_name: tr.find('.pk_company_name').val(),
                    pickup_reference: tr.find('.pk_reference').val(),
                    pickup_instructions: tr.find('.pk_instructions').val(),
                    pickup_lat: tr.find('.pk_lat').val(),
                    pickup_lng: tr.find('.pk_lng').val(),
                    drop: tr.find('.dp').val(),
                    drop2: tr.find('.dp2').val(),
                    drop_number: tr.find('.dp_number').val(),
                    drop_zipcode: tr.find('.dp_zipcode').val(),
                    drop_time: tr.find('.dp_time').val(),
                    drop_company_name: tr.find('.dp_company_name').val(),
                    drop_reference: tr.find('.dp_reference').val(),
                    drop_instructions: tr.find('.dp_instructions').val(),
                    drop_lat: tr.find('.dp_lat').val(),
                    drop_lng: tr.find('.dp_lng').val(),
                    bol_number: tr.find('.bol-num').val()
                });
                j++;
            }

            //get row values
            // $('#out').append(this.id);           
        });

        var json = JSON.stringify(shipments);
        $('#shipments').val(json);
        return true;
    }
// post-submit callback 
    function showResponse(data) {
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
            $('#register_form_success').html('Load Successfully saved. Redirecting to Load list...');
            $('#register_form_success').show();
            $("html, body").animate({scrollTop: $('#register_form_success').offset().top - 100}, 1000);
            location.href = '<?php echo site_url('/load') ?>';
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
                output += '<li>Pickup address in BOL ' + cont + ' can not be null</li>';

            if (value.pickup_number == '')
                output += '<li>Pickup # in BOL ' + cont + ' can not be null</li>';

            if (value.drop == '')
                output += '<li>Drop address in BOL ' + cont + ' can not be null</li>';

            if (value.drop_number == '')
                output += '<li>Drop # in BOL ' + cont + ' can not be null</li>';
*/
            if (value.bol_number == '')
                output += '<li>BOL # in BOL ' + cont + ' can not be null</li>';

            /*if ($('#shp_file_' + cont).val() == '') {
                output += '<li>You must upload a file in BOL ' + cont + '</li>';
            }*/

            cont++;
        });
        output += '</ul>';
        if (output != '<ul></ul>') {
            $('#register_form_error').html(output);
            $('#register_form_error').show();
            $("html, body").animate({scrollTop: $('#register_form_error').offset().top - 100}, 1000);
            return false;
        }

        $('.loading').show();
        $("html, body").animate({scrollTop: $('.loading').offset().top - 100}, 1000);
        $('#add_shp').prop('disabled', true);
        $('#save_btn').prop('disabled', true);
        $('#savensend_btn').prop('disabled', true);
        $('#btn_cancel').prop('disabled', true);
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

        //if (addr == '' || zip == '') {
		if (addr == '') {
            //$('#pickup_form_error').html('address and/or zipcode can not be empty.');
            $('#pickup_form_error').html('address field can not be empty.');
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