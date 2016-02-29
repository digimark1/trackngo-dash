<div class="container">
    <div class="row">
        <div id="success" class="alert alert-success"></div>
        <div id="register_form_error" class="alert alert-error"><!-- Dynamic --></div> 
        <div class="text-right"><h3>Update Load</h3></div>
        <form id="register_form" class="form-horizontal" method="POST" action="<?php echo site_url('load/update_load') ?>">

            <input type="hidden" name="load_id" class="input-xlarge" value="<?php echo $load['idts_load'] ?>"/>

            <div class="control-group">
                <label class="control-label">Status</label>
                <div class="controls">                    
                    <select name="status" id="status" class="selectpicker smallinput" tabindex="275" >
                        <?php
                        foreach ($status as $sts => $row) {
                            $selected = '';
                            if ($load['status'] == $sts)
                                $selected = 'selected="selected"';
                            echo '<option value="' . $sts . '" ' . $selected . '>' . $row . '</option>';
                        }
                        ?>
                    </select>                            
                </div>
            </div>            
            <div class="control-group">
                <label class="control-label">Customer</label>
                <div class="controls">
                    <select class="selectpicker" name="customer">
                        <?php
                        foreach ($customers as $customer => $row) {
                            $selected = '';
                            if ($row['idts_customer'] == $load['ts_customer_idts_customer']) {
                                $selected = 'selected="selected"';
                            }
                            echo '<option ' . $selected . ' value="' . $row['idts_customer'] . '" >' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Driver</label>
                <div class="controls">
                    <select class="selectpicker" name="driver">
                        <?php
                        foreach ($drivers as $driver => $row) {
                            $selected = '';
                            if ($load['ts_driver_idts_driver'] == $row['idts_driver'])
                                $selected = 'selected="selected"';
                            echo '<option value="' . $row['idts_driver'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Load number</label>
                <div class="controls">
                    <input type="text" name="load_number" class="input-xlarge" value="<?php echo $load['load_number'] ?>" />
                </div>
            </div>

            <div class="row">

                <!-- ****************************** Origin ************************************* -->

                <div class="origin span6">
                    <div class="control-group">
                        <label class="control-label"><h3>Origin</h3></label>
                        <ul id="zp_origin_list_id"></ul>
                    </div>

                    <input type="hidden" id="origin_lat" name="origin_lat" class="typeahead" style="width:150px" value="<?php echo $load['pk_lat'] ?>"/>
                    <input type="hidden" id="origin_lng" name="origin_lng" class="typeahead" style="width:150px" value="<?php echo $load['pk_lng'] ?>"/>

                    <div class="control-group">
                        <label class="control-label">Earliest</label>
                        <div class="controls">
                            <input type="text" name="or_earliest" class="input-xlarge smallinput" id="or_earliest" value="<?php echo $load['or_earliest'] ?>"/>
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">Latest</label>
                        <div class="controls">
                            <input type="text" name="or_latest" class="input-xlarge smallinput" id="or_latest" value="<?php echo $load['or_latest'] ?>"/>
                        </div>
                    </div>                    

                    <!--                    <div class="control-group">
                                            <label class="control-label">Location Type</label>
                                            <div class="controls">
                                                <select id="sTypeOrigin" class="selectpicker smallinput" name="or_loc_type" size="1">
                                                    <option value=""></option>
                                                    <option value="Airport">Airport</option>
                                                    <option value="Billing">Billing</option>
                                                    <option value="CTS Branch">CTS Branch</option>
                                                    <option value="CTS Branch Customer">CTS Branch Customer</option>
                                                    <option selected="selected" value="Carrier">Carrier</option>
                                                    <option value="Consignee">Consignee</option>
                                                    <option value="Customer">Customer</option>
                                                    <option value="Customer Location">Customer Location</option>
                                                    <option value="Home">Home</option>
                                                    <option value="None">None</option>
                                                    <option value="Pool">Pool</option>
                                                    <option value="Regular">Regular</option>
                                                    <option value="Supplier">Supplier</option>
                                                    <option value="Terminal">Terminal</option>
                                                    <option value="Vendor">Vendor</option>
                                                </select>
                                            </div>
                                        </div>                    
                    
                                        <div class="control-group">
                                            <label class="control-label">Location Code</label>
                                            <div class="controls">
                                                <input type="text" name="or_loc_code" class="input-xlarge smallinput" />
                                            </div>
                                        </div>                    -->

                    <div class="control-group">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input type="text" name="or_name" class="input-xlarge smallinput" value="<?php echo $load['or_name'] ?>"/>
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">Address 1</label>
                        <div class="controls">
                            <input type="text" name="or_address_1" id="or_address_1" class="input-xlarge smallinput" value="<?php echo $load['or_address_1'] ?>"/>
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">Address 2</label>
                        <div class="controls">
                            <input type="text" name="or_address_2" class="input-xlarge smallinput" value="<?php echo $load['or_address_2'] ?>"/>
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Zipcode</label>
                        <div class="controls">
                            <input type="text" name="or_zipcode" id="or_zipcode" class="input-xlarge smallinput" value="<?php echo $load['or_zipcode'] ?>"/>                            
                            <button type="button" class="btn btn-blue btn-small" hidefocus="true" style="outline: medium none;" data-toggle="modal" id="set_origin"><span class="gradient">Set</span></button>
                            <button type="button" class="btn btn-blue btn-small" hidefocus="true" style="outline: medium none;" data-toggle="modal" data-target="#originAddressModal" id="view_origin"><span class="gradient">View</span></button>                            

                        </div>
                    </div>                       

                    <div class="control-group">
                        <label class="control-label">City</label>
                        <div class="controls">
                            <input type="text" name="or_city" id="or_city" class="input-xlarge smallinput" value="<?php echo $load['or_city'] ?>"/>
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">State</label>
                        <div class="controls">
                            <input type="text" name="or_state" id="or_state" class="input-xlarge smallinput" value="<?php echo $load['or_state'] ?>"/>
                        </div>
                    </div>                   

                    <div class="control-group">
                        <label class="control-label">Country</label>
                        <div class="controls">                            
                            <select name="or_country" id="sCountryOrigin" class="selectpicker smallinput" tabindex="275" >
                                <option value="CANADA">CANADA</option>
                                <option value="MEXICO">MEXICO</option>
                                <option value="PUERTO RICO">PUERTO RICO</option>
                                <option value="USA" selected="">USA</option>
                            </select>                            
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">Contact</label>
                        <div class="controls">
                            <input type="text" name="or_contact" class="input-xlarge smallinput" value="<?php echo $load['or_contact'] ?>"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Phone</label>
                        <div class="controls">
                            <input type="text" name="or_phone" class="input-xlarge smallinput" value="<?php echo $load['or_phone'] ?>"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Fax</label>
                        <div class="controls">
                            <input type="text" name="or_fax" class="input-xlarge smallinput" value="<?php echo $load['or_fax'] ?>"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Email</label>
                        <div class="controls">
                            <input type="text" name="or_email" class="input-xlarge smallinput" value="<?php echo $load['or_email'] ?>"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Comments</label>
                        <div class="controls">
                            <textarea type="text" name="or_comments" /><?php echo $load['or_comments'] ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- ****************************** Destination ************************************* -->

                <div class="destination span6">
                    <div class="control-group">
                        <label class="control-label"><h3>Destination</h3></label>
                    </div>            

                    <input type="hidden" id="destination_lat" name="destination_lat" class="typeahead" style="width:150px" value="<?php echo $load['dp_lat'] ?>"/>
                    <input type="hidden" id="destination_lng" name="destination_lng" class="typeahead" style="width:150px" value="<?php echo $load['dp_lng'] ?>"/>

                    <div class="control-group">
                        <label class="control-label">Earliest</label>
                        <div class="controls">
                            <input type="text" name="dt_earliest" class="input-xlarge smallinput" id="dt_earlier" value="<?php echo $load['dt_earliest'] ?>"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Latest</label>
                        <div class="controls">
                            <input type="text" name="dt_latest" class="input-xlarge smallinput" id="dt_latest" value="<?php echo $load['dt_latest'] ?>"/>
                        </div>
                    </div>                    

                    <!--<div class="control-group">
                                            <label class="control-label">Location Type</label>
                                            <div class="controls">
                                                <select id="sTypeOrigin" class="selectpicker smallinput" name="dt_loc_type" size="1">
                                                    <option value=""></option>
                                                    <option value="Airport">Airport</option>
                                                    <option value="Billing">Billing</option>
                                                    <option value="CTS Branch">CTS Branch</option>
                                                    <option value="CTS Branch Customer">CTS Branch Customer</option>
                                                    <option selected="selected" value="Carrier">Carrier</option>
                                                    <option value="Consignee">Consignee</option>
                                                    <option value="Customer">Customer</option>
                                                    <option value="Customer Location">Customer Location</option>
                                                    <option value="Home">Home</option>
                                                    <option value="None">None</option>
                                                    <option value="Pool">Pool</option>
                                                    <option value="Regular">Regular</option>
                                                    <option value="Supplier">Supplier</option>
                                                    <option value="Terminal">Terminal</option>
                                                    <option value="Vendor">Vendor</option>
                                                </select>
                                            </div>
                                        </div>                    
                    
                                        <div class="control-group">
                                            <label class="control-label">Location Code</label>
                                            <div class="controls">
                                                <input type="text" name="dt_loc_code" class="input-xlarge smallinput" />
                                            </div>
                                        </div>-->

                    <div class="control-group">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input type="text" name="dt_name" class="input-xlarge smallinput" value="<?php echo $load['dt_name'] ?>"/>
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">Address 1</label>
                        <div class="controls">
                            <input type="text" name="dt_address_1" id="dt_address_1" class="input-xlarge smallinput" value="<?php echo $load['dt_address_1'] ?>"/>
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">Address 2</label>
                        <div class="controls">
                            <input type="text" name="dt_address_2" class="input-xlarge smallinput" value="<?php echo $load['dt_address_2'] ?>"/>
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">Zipcode</label>
                        <div class="controls">
                            <input type="text" name="dt_zipcode" id="dt_zipcode" class="input-xlarge smallinput" value="<?php echo $load['dt_zipcode'] ?>"/>
                            <button type="button" class="btn btn-blue btn-small" hidefocus="true" style="outline: medium none;" data-toggle="modal" id="set_destination"><span class="gradient">Set</span></button>
                            <button type="button" class="btn btn-blue btn-small" hidefocus="true" style="outline: medium none;" data-toggle="modal" data-target="#destinationAddressModal" id="view_destination"><span class="gradient">View</span></button>
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">City</label>
                        <div class="controls">
                            <input type="text" name="dt_city" id="dt_city" class="input-xlarge smallinput" value="<?php echo $load['dt_city'] ?>"/>
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">State</label>
                        <div class="controls">
                            <input type="text" name="dt_state" id="dt_state" class="input-xlarge smallinput" value="<?php echo $load['dt_state'] ?>"/>
                        </div>
                    </div>                  

                    <div class="control-group">
                        <label class="control-label">Country</label>
                        <div class="controls">
                            <select name="dt_country" id="sCountryOrigin" class="selectpicker smallinput" tabindex="275" >
                                <option value="CANADA">CANADA</option>
                                <option value="MEXICO">MEXICO</option>
                                <option value="PUERTO RICO">PUERTO RICO</option>
                                <option value="USA" selected="">USA</option>
                            </select> 
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">Contact</label>
                        <div class="controls">
                            <input type="text" name="dt_contact" class="input-xlarge smallinput" value="<?php echo $load['dt_contact'] ?>"/>
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label">Phone</label>
                        <div class="controls">
                            <input type="text" name="dt_phone" class="input-xlarge smallinput" value="<?php echo $load['dt_phone'] ?>"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Fax</label>
                        <div class="controls">
                            <input type="text" name="dt_fax" class="input-xlarge smallinput" value="<?php echo $load['dt_fax'] ?>"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Email</label>
                        <div class="controls">
                            <input type="text" name="dt_email" class="input-xlarge smallinput" value="<?php echo $load['dt_email'] ?>"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Comments</label>
                        <div class="controls">
                            <textarea type="text" name="dt_comments" /><?php echo $load['dt_comments'] ?></textarea>
                        </div>
                    </div>

                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Add Item</label>
                <div class="controls">
                    <table width="695px">

                        <tr class="fields">
                            <td ><input id="ltl_quantity" style="width:60px" type="text" placeholder="Qty"/>
                                <select id="quantity_unit" name="quantity_unit" class="sele">
                                    <option value="plt">Plt</option>
                                    <option value="skd">Skid</option>
                                    <option value="ctn">carton</option>
                                    <option value="ctn">Drum</option>
                                </select>
                            </td>
                            <td><input id="ltl_weight" style="width:90px" type="text" placeholder="Weight"/>
                                <select id="weight_unit" name="weight_unit" class="sele">
                                    <option value="lb">lbs</option>
                                    <option value="kg">kgs</option>
                                </select>
                            </td>
                            <td ><select id="ltl_class" name="classValue" class="sele">
                                    <option value="1">Class</option>
                                    <option value="50">50</option>
                                    <option value="55">55</option>
                                    <option value="60">60</option>
                                    <option value="65">65</option>
                                    <option value="70">70</option>
                                    <option value="77.5">77.5</option>
                                    <option value="85">85</option>
                                    <option value="92.5">92.5</option>
                                    <option value="100">100</option>
                                    <option value="110">110</option>
                                    <option value="125">125</option>
                                    <option value="150">150</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400</option>
                                    <option value="500">500</option>
                                </select> </td>
                            <td ><input id="ltl_length" name="item-lenght" value="48" style="width:60px" type="text" /></td>
                            <td ><input id="ltl_width" name="item-width" value="48" style="width:60px" type="text" /></td>
                            <td ><input id="ltl_height" name="item-height" value="90" style="width:60px" type="text" /></td>
                            <td>
                                <select id="ltl_unit_dimension" name="ltl_unit_dimension" class="sele">
                                    <option value="in">in</option>
                                    <option value="ft">ft</option>
                                    <option value="cm">cm</option>
                                    <option value="mt">mt</option>
                                </select>                                                                             
                            </td>
                            <td ><a id="add-item" type="button" class="btn btn-blue btn-small" hidefocus="true" style="outline: medium none;" onclick="addItems()" ><span class="gradient">Add</span></a>

                        </tr>
                    </table> 
                </div>
            </div>

            <div class="control-group item-container">
                <table id="items_list">
                    <?php
                    $i = 0;
                    $item_array = [];
                    if ($items) {
                        echo '<thead><tr>'
                        . '<th width="19">#</th>'
                        . '<th width="320">Item</th>'
                        . '<th width="80">Pieces</th>'
                        . '<th width="80" >Weight</th>'
                        . '<th width="80" >Class</th>'
                        . '<th></th>'
                        . '</tr></thead>';
                    }
                    $item_json_encode = json_encode($items);
                    $items_encoded = str_replace("'\'", "", $item_json_encode);
                    foreach ($items as $item => $row) {
                        $i++;
                        echo'<tr data-quantity=' . $row['quantity'] . ' data-quantity_unit=' . $row['quantity_unit'] . ' data-weight=' . $row['weight'] . ' data-weight_unit=' . $row['weight_unit'] . ' data-class=' . $row['class'] . ' data-length=' . $row['length'] . ' data-width=' . $row['width'] . ' data-height= ' . $row['height'] . '>';
                        echo '<td>' . $i . '</td><td align="center">Item' . $i . '</td><td align="center">' . $row['quantity'] . '</td><td align="center">' . $row['weight'] . $row['weight_unit'] . '</td><td align="center">' . $row['class'] . '</td><td onclick="$(this).parent().remove()">x</<td>';
                        echo'</tr>';
                    }
                    ?>                    
                </table>
                <input type="hidden" name="items" id="item1" class="input-xlarge" value=""/>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-blue btn-small" hidefocus="true" style="outline: medium none;"><span class="gradient">Update</span></button>
                    <a class="btn" href="<?php echo site_url('/') ?>">Cancel</a>
                </div>
            </div>      
        </form>

        <!-- Set origin Modal -->

        <div class="modal fade" id="originAddressModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Origin</h4>
                    </div>
                    <div class="modal-body">
                        <fieldset>

                            <!-- Form Name -->
                            <legend>Check Address</legend>
                            <!-- Text input-->
                            <!--                            <div class="form-group">
                                                            <label class="col-md-4 control-label" for="textinput">Address</label>  
                                                            <div class="col-md-5">
                                                                <input name="textinput" id="ver_origin_address" type="text" placeholder="1300 Sawgrass Corporate Pkwy" class="form-control input-md">
                                                            </div>
                                                        </div>-->

                            <!-- Button -->
                            <!--                            <div class="form-group">
                                                            <label class="col-md-4 control-label" for="singlebutton"></label>
                                                            <div class="col-md-4">
                                                                <button id="ver_origin_btn" name="singlebutton" class="btn btn-info">Verify</button>
                                                            </div>
                                                        </div>-->

                            <div id="map-canvas"></div>

                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <!--<button type="button" id="confirm_origin" class="btn btn-primary">Ok</button>-->
                    </div>
                </div>
            </div>
        </div>

        <!-- Destination address Modal -->

        <div class="modal fade" id="destinationAddressModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Destination</h4>
                    </div>
                    <div class="modal-body">
                        <fieldset>

                            <!-- Form Name -->
                            <legend>Check Address in Map</legend>

                            <div id="map-canvas2"></div>

                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="centre">
    <div class="ajax-loader-load"></div>
    <div id="msn">Loading...</div>   
</div>

<style>
    .sele{
        width: 70px;
    }

    .container2{
        width: 500px;
    }

    .origin{
        float: left;
    }
    .destination{

        float: left;
    }

    .smallinput{
        width: 150px;
    }

    #map-canvas,  #map-canvas2{
        height: 300px;
        width: 520px;
        margin: 0;
        padding: 0;
    }

    .item_input{
        width: 60px;
    }
    th{
        text-align: center;
        font-weight: 700;
    }

    .item_head{
        height: 20px;
    }

    .modal{
        width: 610px;
    }    

</style>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAp8XadZn74QX4NLDphnzehQ0AN7q6NCwg"></script>

<script>
                                $(function () {

                                    $('#map-canvas').css('display', 'none');
                                    $('#map-canvas2').css('display', 'none');

                                    $("#set_origin").click(function () {
                                        url_origin_address();
                                    });
                                    $("#view_origin").click(function () {
                                        url_origin_address_view();
                                    });

                                    $("#set_destination").click(function () {
                                        url_destination_address();
                                    });

                                    $("#view_destination").click(function () {
                                        url_destination_address_view();
                                    });

                                    $("#confirm_destination").click(function () {
                                        set_confirm_destination();
                                    });

                                    //Datetimer pickers


                                    $('#or_earliest').datetimepicker({
                                        format: 'Y-m-d H:i',
                                        step: 10
                                    });

                                    $("#or_latest").datetimepicker({
                                        format: 'Y-m-d H:i',
                                        step: 10
                                    });

                                    $("#dt_earlier").datetimepicker({
                                        format: 'Y-m-d H:i',
                                        step: 10
                                    });

                                    $("#dt_latest").datetimepicker({
                                        format: 'Y-m-d H:i',
                                        step: 10
                                    });

                                    $("#success").hide();
                                    $(".alert.alert-success").hide();
                                    $("#msn").hide();
                                    $(".ajax-loader-load").hide();
                                    $("#register_form_error").hide();
                                    $('#register_form').submit(function (evt) {
                                        evt.preventDefault();

                                        fillItemInput();
                                        var url = $(this).attr('action');
                                        var postData = $(this).serialize();
//                                        $("#item1").val(JSON.stringify(items));


                                        $.ajax({
                                            type: "POST",
                                            url: url,
                                            async: true,
                                            data: postData,
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
                                                    setTimeout(function () {
                                                        $("#success").fadeOut();
                                                        window.location = '<?php echo site_url('load') ?>';
                                                    }, 1000);
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

                                });

                                var sw_item = 0;
                                var class_item = 0;

                                function getItems() {
                                    var items = [];

                                    $("#items_list tbody tr").each(function (index) {
                                        var campo1, campo2, campo3;
                                        var i = 1;
                                        var item_temp = [];
                                        $(this).children("td").each(function (index2) {
                                            var j = 0;
                                            if (j >= 2) {
//                                                item_temp[] = $(this).text();
                                                console.log('valores: ' + $(this).text());
                                            }
                                            j++;
                                        });

//                                        items.push({quantity: quantity,
//                                            quantity_unit: quantity_unit,
//                                            weight: weight,
//                                            weight_unit: weight_unit,
//                                            class: classs,
//                                            length: length,
//                                            width: width,
//                                            height: height});
//
//                                        alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
                                    });
                                    clearItem();
                                    $("#item1").val(JSON.stringify(items));
                                }

                                function initialize(lng, lat) {
                                    var myLatlng = new google.maps.LatLng(lng, lat);
                                    var mapOptions = {
                                        zoom: 13,
                                        center: myLatlng
                                    }
                                    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                                    var marker = new google.maps.Marker({
//            icon: 'map-marker-driver.png',
                                        position: new google.maps.LatLng(lng, lat),
                                        map: map,
                                    });
                                }

                                function initialize2(lng, lat) {
                                    var myLatlng = new google.maps.LatLng(lng, lat);
                                    var mapOptions = {
                                        zoom: 13,
                                        center: myLatlng
                                    };
                                    var map = new google.maps.Map(document.getElementById('map-canvas2'), mapOptions);
                                    var marker = new google.maps.Marker({
//            icon: 'map-marker-driver.png',
                                        position: new google.maps.LatLng(lng, lat),
                                        map: map,
                                    });
                                }


                                function fillItem() {
                                    var qty = $('#ltl_quantity').val();
                                    var qty_unit = $('#quantity_unit').val();
                                    var wgt = $('#ltl_weight').val();
                                    var wgt_unit = $('#weight_unit').val();
                                    var cl = $('#ltl_class').val();
                                    var length = $('#ltl_quantity').val();
                                    var width = $('#ltl_width').val();
                                    var height = $('#ltl_height').val();
                                    var unit_dim = $('#ltl_unit_dimension').val();
                                    if ($('#item1').val() == '') {
                                        $('#item1').val(qty + '@' + length + 'x' + width + 'x' + height + ' ' + 'cl' + cl + ' ' + wgt + wgt_unit);
                                    } else if ($('#item2').val() == '') {
                                        $('#item2').val(qty + '@' + length + 'x' + width + 'x' + height + ' ' + 'cl' + cl + ' ' + wgt + wgt_unit);
                                    } else {
                                        $('#item3').val(qty + '@' + length + 'x' + width + 'x' + height + ' ' + 'cl' + cl + ' ' + wgt + wgt_unit);
                                    }
                                }

                                function addItems() {
                                    if ($('#ltl_class').val() == 1) {
                                        getClassByDimensions();
                                    } else {
                                        class_item = $('#ltl_class').val();
                                    }
                                    var header = $('#items_list thead tr').html();
                                    if (sw_item == 0 && !header) {
                                        tHead = $('<thead>');
                                        tRow = $('<tr>');
                                        tEtqSeq = $('<th>').html("#");
                                        tEtqItem = $('<th>').html("Item");
                                        tEtqPieces = $('<th>').html("Pieces");
                                        tEtqWeight = $('<th>').html("Weight");
                                        tEtqClass = $('<th>').html("Class");
                                        tEtiqAction = $('<th>').html("");
                                        tRow.append(tEtqSeq);
                                        tRow.append(tEtqItem);
                                        tRow.append(tEtqPieces);
                                        tRow.append(tEtqWeight);
                                        tRow.append(tEtqClass);
                                        tRow.append(tEtiqAction);
                                        tHead.append(tRow);
                                        $('#items_list').append(tHead);
                                    }

                                    // fin encabezado

                                    sw_item++;
                                    tRow = $('<tr data-quantity=' + $('#ltl_quantity').val() + ' data-quantity_unit=' + $('#quantity_unit').val() + ' data-weight=' + $('#ltl_weight').val() + ' data-weight_unit=' + $('#weight_unit').val() + ' data-class=' + class_item + ' data-length=' + $('#ltl_length').val() + ' data-width=' + $('#ltl_width').val() + ' data-height= ' + $('#ltl_height').val() + '>');
                                    tEtqSeq = $('<td width=19>').html(sw_item);
                                    tEtqItem = $('<td width=320 id="compnay" align= center>').html('Item ' + sw_item);
                                    tEtqPieces = $('<td width=80 align= center>').html($('#ltl_quantity').val());
                                    tEtqWeight = $('<td width=80 align= center>').html($('#ltl_weight').val() + ' ' + $('#weight_unit').val());
                                    tEtqClass = $('<td width=80 align= center>').html(class_item);
                                    tEtqAction = $('<td onclick="$(this).parent().remove()">').html('x');
                                    tRow.append(tEtqSeq);
                                    tRow.append(tEtqItem);
                                    tRow.append(tEtqPieces);
                                    tRow.append(tEtqWeight);
                                    tRow.append(tEtqClass);
                                    tRow.append(tEtqAction);
                                    $('#items_list').append(tRow);
                                    $('#result2').text(class_item);

                                }

                                function fillItemInput() {
                                    var items = [];
                                    var table = $("#items_list tbody");

                                    table.find('tr').each(function (i) {
                                        items.push({
                                            quantity: $(this).data('quantity'),
                                            quantity_unit: $(this).data('quantity_unit'),
                                            weight: $(this).data('weight'),
                                            weight_unit: $(this).data('weight_unit'),
                                            class: $(this).data('class'),
                                            length: $(this).data('length'),
                                            width: $(this).data('width'),
                                            height: $(this).data('height')
                                        });
                                        clearItem();
                                        $("#item1").val(JSON.stringify(items));
                                    });
                                }

                                function clearItem() {
                                    $('#ltl_quantity').val("");
                                    $('#ltl_weight').val("");
                                    $('#ltl_class').val("1");
                                    $('#ltl_length').val("48");
                                    $('#ltl_width').val("48");
                                    $('#ltl_height').val("90");
                                    $('#sys_message').text("");
                                    class_item = 0;
                                }

                                function getClassByDimensions() {

                                    // convert weight
                                    var weight = $('#ltl_weight').val();
                                    if ($('#weight-unit').val() == 'kgs') {
                                        weight = weight * 2.20462;
                                    }

                                    // convert dimension

                                    var length = $('#ltl_length').val();
                                    var width = $('#ltl_width').val();
                                    var height = $('#ltl_height').val();
                                    if ($('#ltl_unit_dimension').val() == 'ft') {
                                        length = length * 12;
                                        width = width * 12;
                                        height = height * 12;
                                    }

                                    if ($('#ltl_unit_dimension').val() == 'cm') {
                                        length = length * 0.393701;
                                        width = width * 0.393701;
                                        height = height * 0.393701;
                                    }

                                    if ($('#ltl_unit_dimension').val() == 'mt') {
                                        length = length * 39.3701;
                                        width = width * 39.3701;
                                        height = height * 39.3701;
                                    }

                                    var cl = 0;
                                    var density = 0;
                                    var cubic_feet = 0;
                                    var num = 0;
                                    num = length * width * height;
                                    cubic_feet = num / 1728;
                                    density = weight / cubic_feet;
//    alert('la densidad es: ' + density);

                                    switch (true) {
                                        case (density < 1):
                                            cl = 500;
                                            break;
                                        case (density >= 1 && density < 2):
                                            cl = 400;
                                            break;
                                        case (density >= 2 && density < 3):
                                            cl = 300;
                                            break;
                                        case (density >= 3 && density < 4):
                                            cl = 250;
                                            break;
                                        case (density >= 4 && density < 5):
                                            cl = 200;
                                            break;
                                        case (density >= 5 && density < 6):
                                            cl = 175;
                                            break;
                                        case (density >= 7 && density < 8):
                                            cl = 125;
                                            break;
                                        case (density >= 8 && density < 9):
                                            cl = 110;
                                            break;
                                        case (density >= 9 && density < 10.5):
                                            cl = 100;
                                            break;
                                        case (density >= 10.5 && density < 12):
                                            cl = 92.5;
                                            break;
                                        case (density >= 12 && density < 13.5):
                                            cl = 85;
                                            break;
                                        case (density >= 13.5 && density < 15):
                                            cl = 77.5;
                                            break;
                                        case (density >= 15 && density < 22.5):
                                            cl = 70;
                                            break;
                                        case (density >= 22.5 && density < 30):
                                            cl = 65;
                                            break;
                                        case (density >= 30 && density < 35):
                                            cl = 60;
                                            break;
                                        case (density >= 35 && density < 50):
                                            cl = 55;
                                            break;
                                        case (density >= 50):
                                            cl = 50;
                                            break;
                                        default:
                                            alert('unknown class');
                                    }

                                    $('#ltl_class').val(cl);
                                    class_item = cl;
                                }

                                function url_origin_address() {

                                    var address = $('#or_address_1').val() + ', ' + $('#or_zipcode').val();
                                    var url_address = address.split(' ').join('+');
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
//                console.log('google result ' + data.status);

                                            var formated_address = data.results[0].formatted_address;
                                            var lat = data.results[0].geometry.location.lat;
                                            var lng = data.results[0].geometry.location.lng;
                                            var lng = data.results[0].geometry.location.lng;
                                            var zipcode = data.results[0].address_components[6].long_name;
                                            var city = data.results[0].address_components[2].long_name;
                                            var state = data.results[0].address_components[4].short_name;
                                            origin_formated_address = formated_address;
                                            origin_lat = lat;
                                            origin_lng = lng;
                                            origin_zipcode = zipcode;
                                            origin_city = city;
                                            origin_state = state;
                                            $('#origin_lat').val(lat);
                                            $('#origin_lng').val(lng);
                                            $('#or_city').val(city);
                                            $('#or_state').val(state);
                                            console.log('state: ' + state + ', lat: ' + lat + ', lng: ' + lng + ', zipcode: ' + zipcode);
                                        }
                                    });
                                }

                                function url_origin_address_view() {

                                    var address = $('#or_address_1').val() + ', ' + $('#or_zipcode').val();
                                    var url_address = address.split(' ').join('+');
//        var url_address = address.replace(/ /g, '+');
//        console.log('formated address ' + url_address);

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
//                console.log('google result ' + data.status);

                                            var lat = data.results[0].geometry.location.lat;
                                            var lng = data.results[0].geometry.location.lng;
                                            var lng = data.results[0].geometry.location.lng;
                                            var zipcode = data.results[0].address_components[6].long_name;
                                            var city = data.results[0].address_components[2].long_name;
                                            var state = data.results[0].address_components[4].short_name;
                                            console.log('state: ' + state + ', lat: ' + lat + ', lng: ' + lng + ', zipcode: ' + zipcode);
                                            initialize(lat, lng);
                                            $('#originAddressModal').show();
                                            $('#map-canvas2').css('display', 'none');
                                            $('#map-canvas').css('display', 'block');
//
//                $('#result_destination').show();
                                        }
                                    });
                                }


                                function url_destination_address() {

                                    var address = $('#dt_address_1').val() + ', ' + $('#dt_zipcode').val();
                                    var url_address = address.split(' ').join('+');
//        var url_address = address.replace(/ /g, '+');
//        console.log('formated address ' + url_address);

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
//                console.log('google result ' + data.status);

                                            var lat = data.results[0].geometry.location.lat;
                                            var lng = data.results[0].geometry.location.lng;
                                            var zipcode = data.results[0].address_components[6].long_name;
                                            var city = data.results[0].address_components[2].long_name;
                                            var state = data.results[0].address_components[4].short_name;
                                            destination_lat = lat;
                                            destination_lng = lng;
                                            destination_zipcode = zipcode;
                                            destination_city = city;
                                            destination_state = state;
                                            $('#destination_lat').val(lat);
                                            $('#destination_lng').val(lng);
                                            $('#dt_city').val(city);
                                            $('#dt_state').val(state);
                                            console.log('destination: state: ' + state + ', lat: ' + lat + ', lng: ' + lng + ', zipcode: ' + zipcode);
                                        }
                                    });
                                }


                                function url_destination_address_view() {

                                    var address = $('#dt_address_1').val() + ', ' + $('#dt_zipcode').val();
                                    var url_address = address.split(' ').join('+');
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
//                console.log('google result ' + data.status);

                                            var lat = data.results[0].geometry.location.lat;
                                            var lng = data.results[0].geometry.location.lng;
                                            var lng = data.results[0].geometry.location.lng;
                                            var zipcode = data.results[0].address_components[6].long_name;
                                            var city = data.results[0].address_components[2].long_name;
                                            var state = data.results[0].address_components[4].short_name;
                                            console.log('destination: state: ' + state + ', lat: ' + lat + ', lng: ' + lng + ', zipcode: ' + zipcode);
                                            $('#destinationAddressModal').show();
                                            $('#map-canvas2').css('display', 'block');
                                            $('#map-canvas').css('display', 'none');
                                            initialize2(lat, lng);
//
//                $('#result_destination').show();
                                        }
                                    });
                                }
</script>
<style>
    #result_origin, #result_destination {
        display: none;
        max-height: 150px;
        width: 220px;
        overflow-y: scroll;
        border: 1px solid black;
    }

    .item-container{
        margin-left: 180px;
        width: 500px;
        height: 150px;
        border: 1px solid black;
        overflow-y: scroll;
    }

</style>