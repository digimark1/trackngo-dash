
<div>
    <div id="dashboard-main">
<!--        <form id="create_note" class="form-horizontal" method="post" action="<?= site_url('api/create_note') ?>">
            <div class="input-append">
                <input tabindex="1" type="text" name="title" placeholder="Note Title" />
                <input tabindex="3" type="submit" class="btn btn-success" value="Create" />
            </div>

            <div class="clearfix"></div>

            <textarea tabindex="2" name="content"></textarea>

        </form>-->

        <div id="list_user">
            <span class="ajax-loader-gray"></span>
        </div>

        <div id="category-actions">
            <div class="loads-title" id="category-title"><img src="<?php echo base_url() ?>/public/img/images/loads-title.png" width="100" height="70" alt="Loads Category"></div>
            <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All Loads"></a></div>

            <?php
            if (in_array("load/add", $roles)) {
                ?>
                <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/add'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" title="Add a Load"></a></div>
            <?php } ?>            
            <div id="category-button"></div>
            <!--            <div id="category-search" class="search-customer">
                            <select class="selectpicker" name="customer" id="search_customer">
                                <option value="0">-- Select Customer --</option>
            <?php
            foreach ($customers as $customer => $row) {
                echo '<option value="' . $row['idts_customer'] . '">' . $row['name'] . '</option>';
            }
            ?>
                            </select>
                        </div>-->
            <div style="float: right;">
                <div id="category-search" class="search-carrier">
                    <select class="selectpicker" name="carrier" id="search_carrier">
                        <!--<option value="0">-- Select Carrier --</option>-->
                        <?php
                        foreach ($carriers as $carrier => $row) {
                            echo '<option value="' . $row['idts_carrier'] . '">' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div id="category-search" class="search-loads"><input type="text" name="search_load_number" id="search_load_number" /></div>            
                <div id="category-search" class="search-loads" style="width: 50px;"><button type="button" class="btn btn-red btn-small" id="load_search" style="position: relative;top: 5px"><span class="gradient">Search</span></button></div>
            </div>
        </div>
        <div id="driver_map" class="accordion">
            <div class="accordion-section active">
                   <a class="accordion-section-title" href="#">LOADS MAP <div style="float: right;"><span style="float:right"></span></div></a>
            </div>
       </div>
       <script>
	   $('#driver_map').click(function(){
		   $('#new_map').slideToggle();
		   });
	   </script>			
	   <div id="test"></div>
       <div id="test2"></div>
	   <?php
/*	   			$m = 0;
				foreach ($callchecks_all as $callcheck => $row8[$m]) {
					   foreach ($row8[$m] as $callcheck1 => $row9[$m]) {
                            echo '<div>'.$row9[$m]['comment'].'</div>';
					    }
						$m++;
					}
			echo '<div>echo</div>';
			echo '<div>'.$loadsall1.'</div>';*/
			
             ?>
		<div id="new_map">
          Here goes the map
        </div>
       <div id="load_list_header" class="accordion" style="margin-top:40px;">
            <div class="accordion-section active">
                   <a class="accordion-section-title" href="#">LIST OF LOADS <div style="float: right;"><span style="float:right"></span></div></a>
            </div>
       </div>
       <script>
       	$('#load_list_header').click(function(){
		    $('#load_list_div').slideToggle();
		   });
	   </script>
        <div id="load_list_div" class="table-responsive" style="margin-top:0px;">
            <table id="list_load" class="table table-hover table-bordered table-striped">
                <thead>
                    <tr style="background-color: #EBEBEB">
<!--                        <th style="width:5%"></th>-->
                        <th style="width:8%">Id</th>
                        <th style="width:12%">Create Date</th>
                        <th style="width:11%">Carrier</th>
                        <th style="width:11%">Driver</th>
                        <th style="width:29%">Driver Position</th>
                        <th style="width:7%; font-weight: 800;color: #666;">Status</th>
                        <?php echo in_array('load/update2', $roles) || in_array('load/trash', $roles) || in_array('load/load_details', $roles) || in_array('load/tender', $roles) ? '<th style="width:7%">Actions</th>' : ''; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $j = 0;
                    foreach ($loads as $load => $row) {

                        //  print_r($row['shipments'][0]['url_bol']);

                        $driver_address = explode(',', $row['driver_address'], 2);
                        $date = explode(' ', $row['date_created']);
                        $date_formated_temp = explode('-', $date[0]);
                        $date_formated = $date_formated_temp[1] . '/' . $date_formated_temp[2] . '/' . $date_formated_temp[0];

                        //                        $tender = $row['tender'] == 0 ? '<a class="tenderx" data-id="' . $row['idts_load'] . '" href="' . site_url('load/tenderx/' . $row['load_number']) . '/' . $row['ts_driver_idts_driver'] . '" data-toggle="modal" data-target="#tenderModal"> Tender </a>' : '';
                        $tender = $row['tender'] == 0 ? '<a class="set-tender-modal" id="tender_' . $row['idts_load'] . '" data-load_number="' . $row['load_number'] . '" data-driver_id="' . $row['ts_driver_idts_driver'] . '" data-email="' . $row['driver_email'] . '" data-apns_number="' . $row['driver_apns_number'] . '" data-app_id="' . $row['driver_app_id'] . '" data-bol_url="' . $row['shipments'][0]['url_bol'] . '" data-id="' . $row['idts_load'] . '" data-toggle="modal" data-target="#tenderModal" style="cursor:pointer"> Tender </a>' : '';

                        echo '<tr data-status="' . $row['status'] . '" id="load_' . $row['idts_load'] . '" data-load_id="' . $row['idts_load'] . '" data-toggle="popoverx" class="pox">';
                        echo '<td>' . $row['load_number'] . '</td>';
                        echo '<td>' . $date_formated . ' ' . $date[1] . '</td>';
                        echo '<td>' . $row['carrier_name'] . '</td>';
                        echo '<td>' . $row['driver_name'] . ' ' . $row['driver_last_name'] . '</td>';
						//Condition: Start Location.
						if(($row['driver_latitud']==0)&&($row['driver_longitud']==0)){
							echo '<td style="width: 250px;">No location available for this driver yet.<span class="map_view" style="cursor:pointer"  data-toggle="modal" data-target="#destinationAddressModal" data-driver_lat="' . $row['driver_latitud'] . '" data-driver_lng="' . $row['driver_longitud'] . '" id="view_destination"><strong></strong></span></td>';
							}else{
                        echo '<td style="width: 250px;">' . $driver_address[0] . '<br>' . $driver_address[1] . ' <span class="map_view" style="cursor:pointer"  data-toggle="modal" data-target="#destinationAddressModal" data-driver_lat="' . $row['driver_latitud'] . '" data-driver_lng="' . $row['driver_longitud'] . '" id="view_destination"><strong>[map]</strong></span></td>';
						}
                        echo '<td class="status color"   style="font-weight: 800;color: #666;">' . $row['status'] . '</td>';
                        echo in_array('load/update2', $roles) || in_array('load/trash', $roles) || in_array('load/load_details', $roles) || in_array('load/tender', $roles)  ? '<td>' : '';
//                        echo in_array('load/update2', $roles) ? '<a class="edit" data-id="' . $row['idts_load'] . '" href="' . site_url('load/update2/' . $row['idts_load']) . '"> Edit </a>' : '';                       
                        echo in_array('load/update2', $roles) ? '<a class="edit" data-id="' . $row['idts_load'] . '" > Edit </a>' : '';
                        echo in_array('load/load_details', $roles) ? '<a class="view" data-id="' . $row['idts_load'] . '"> View </a>' : '';
                        echo in_array('load/trash', $roles) ? '<a class="trash" data-id="' . $row['idts_load'] . '"> Trash </a>' : '';
                        echo in_array('load/tender', $roles) ? $tender : '';
                        echo in_array('load/update2', $roles) || in_array('load/trash', $roles) || in_array('load/load_details', $roles) || in_array('load/tender', $roles)  ? '</td>' : '';
                        echo '</tr>';
                        $j++;
                    }
                    ?>
                </tbody>

            </table>

            <div class="row">
                <div class="col-md-12 text-center">
                    <?php echo $this->pagination->create_links() ?>
                </div>
            </div>            
        </div>

        <div class="table-responsive" hidden="">
            <table id="list_load" class="table table-hover table-bordered table-striped">
                <thead>
                    <tr style="background-color: #EBEBEB">
                        <th>Full Name</th>
                        <th>Load id</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <!--<th>Login</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
					//$load3 = array_unique($loads);
                    foreach ($loads as $load4 => $row4) {
                        echo '<tr>';
                        echo '<td>' . $row4['driver_full_name'] . '</td>';
                        echo '<td>' . $row4['idts_load'] . '</td>';
                        echo '<td>' . $row4['driver_latitud'].'</td>';
						echo '<td>' . $row4['driver_longitud'] . '</td>';
//                        echo '<td>' . $row['login'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>

            </table>
        </div>
        <!-- Hidden values -->
        <input type="hidden" id="driver_lat" value="">
        <input type="hidden" id="driver_lng" value="">

        <!-- Load view dialog -->

        <div class="modal fade" id="load_view_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Load Details</h4>
                    </div>
                    <div class="modal-body">
                        <fieldset>

                            <!-- Form Name -->
                            <legend>Load Details</legend>

                            <div id="load_detail"></div>

                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                        <h4 class="modal-title" id="myModalLabel">Driver Position</h4>
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

        <!-- Edit Load Modal -->

        <div class="modal fade" id="editLoadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Loads</h4>
                    </div>
                    <div class="modal-body">
                        <fieldset>

                            <!-- Form Name -->
                            <legend>Change values to loads you selected</legend>
                            <input type="hidden" name="loads" id="loads" class="input-xlarge" value=""/>
                            <div class="control-group">
                                <label class="control-label">Customer</label>
                                <div class="controls">
                                    <select class="selectpicker" name="customer" id="customer">
                                        <option value="0" selected="selected">-Select-</option>
                                        <?php
                                        foreach ($customers as $customer => $row) {
                                            echo '<option value="' . $row['idts_customer'] . '">' . $row['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>        

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

                            <div class="control-group">
                                <label class="control-label">Driver</label>
                                <div class="controls">
                                    <select class="selectpicker" name="driver" id="driver">
                                        <option value="select" selected="selected">-Select-</option>

                                    </select>
                                </div>
                            </div>  

                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="btn_edit_loads">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tender Modal -->

        <div class="modal fade" id="tenderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Tender Load</h4>
                    </div>
                    <div class="modal-body">
                        <fieldset>
                            <table style="width:810px;">
                                <tr>
                                    <td>Subject</td>
                                    <td>
                                        <input type="text" id="title">
                                        <input type="hidden" id="tender_load_id">
                                        <input type="hidden" id="tender_load_number">
                                        <input type="hidden" id="driver_id">
                                        <input type="hidden" id="email">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Special Instructions</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><textarea id="msg"></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><iframe id="tender_iframe" width="100%" height="600" id="if_bol" style="margin-top:15px"></iframe></td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button id="tender-load" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;"><span class="gradient">Tender</span></button>
                        <button data-dismiss="modal" style="border-radius: 16%; height: 25px;">Close</button>
                    </div>
                </div>
            </div>
        </div>        

    </div>
</div>

<!-- Hidden content -->

<div id="popover_content" style="display: none">
    <ul>
        <li><a data-id="4" class="editLink" title="Edit this Load" href=""><i class="icon-pencil"></i> Edit</a></li>
        <li><a data-id="4" class="editLink" title="Send message to driver" href=""><i class="icon-user"></i> Send Message</a></li>
        <li><a data-id="4" class="viewLink" title="View Load" href=""><i class="icon-eye-open"></i> View Load</a></li>
        <li></li>
    </ul>
</div>


<style>
    .popover{
        left: 272px !important;
    }
    .popover-title {
        font-size: 15px;
    }
    .popover-content {
        width: 150px;
    }
    /* 
    #map-canvas,  #map-canvas2{
        height: 300px;
        width: 520px;
        margin: 0;
        padding: 0;
    }
    .modal{
        width: 610px;
    }    */

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
	
	#new_map{
        height:350px;
        width:100%;
        padding:0;
        righ:0px;
        bottom:0px !important;
        left:0px !important;
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
        overflow-y: auto;
        overflow-x: auto;
        height: 540px;
    }

    #category-search {
        position: relative;
        height: 40px;
        width: 190px;
        background-color: #F6F6F6;
        float: left;
       /*background-image: url(../images/loads-search-bt-230w.png);*/
        background-repeat: no-repeat;
        margin-right: 5px;
        top: 14px;        
    }

    select {
        width: 190px;
    }

    input[type="text"], input[type="password"] {
        height: 34px;
        background-color: #fff;
    }

    #tenderModal{
        width: 900px;
        height: 510px;
        left: 40% !important;
    }

    #tenderModal .modal-dialog{
        width: 880px;
    }    

    #tenderModal .modal-body{
        max-height: 320px;
    }
	.tag-map{
		margin-bottom: 0px;
		}

    .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus{
        background-color: #ED1A3B;
        border-color: #ED1A3B;        
    }
    .pagination > li > a, .pagination > li > span{
        color: #ED1A3B;
    }
/* ACCORDION */
/*----- Accordion -----*/
    .accordion, .accordion * {
        -webkit-box-sizing:border-box; 
        -moz-box-sizing:border-box; 
        box-sizing:border-box;
    }

    .accordion {
        overflow:hidden;
        box-shadow:0px 1px 3px rgba(0,0,0,0.25);
        border-radius:3px;
        background:#f7f7f7;
		margin-bottom: 0px;
    }

    /*----- Section Titles -----*/
    .accordion-section-title {
        width:100%;
        padding:15px;
        display:inline-block;
        border-bottom:1px solid #1a1a1a;
        background:#ed1a3b;
        transition:all linear 0.15s;
        /* Type */
        font-size:1.200em;
        text-shadow:0px 1px 0px #1a1a1a;
        color:#fff;
    }

    .accordion-section-title.active, .accordion-section-title:hover {
        background:#B11029;
        /* Type */
        text-decoration:none;
    }

    .accordion-section:last-child .accordion-section-title {
        border-bottom:none;
    }

    /*----- Section Content -----*/
    .accordion-section-content {
        padding:15px;
        /*display:none;*/
    }
	

</style>


<script>

$(document).ready(function(e) {
	var load_list = [];
	var y = 0;
	<?php
	  foreach($loadsall as $loadsall){
		  ?>
		  load_list[y] = <? echo $loadsall?>;
		  y++;
		  <?php
		  }
	 ?>
	 for (cc = 0; cc<load_list.length;cc++){
	  //$('#test').append('<p>'+load_list[cc]+'</p>');
	 }
    setInterval(function(){
            /*var url = '<?php echo site_url('load/get_chat_home/') ?>';
            var postData = {
                //date: $('#last_date').val(),
				id_list:load_list
            };*/
			//$('#test2').append('Just enter');
			$.ajax({
				type:'POST',
				dataType:'json',
				data:{id_list:JSON.stringify(load_list)},
				url:'<?php echo site_url('load/get_chat_home/') ?>',
				success: function(data){
					 var chat_all = (JSON.stringify(data));
					 //$('#test2').html(chat_all+JSON.stringify(load_list));
					 //$('#test2').append(JSON.stringify(load_list));
					 //$('#test').append('--'+data[0].city+'--');
							if (localStorage.last_callcheck) {
								if(parseFloat(data[0].idts_callcheck) == parseFloat(localStorage.last_callcheck)){
									 //$('#test').append('nothing new');
									}else{
							$('#notification_content').append('<div>*** New message ***--'+data[0].comment+'--'+parseInt(localStorage.last_callcheck)+'--<a class="" href="<?php echo base_url() ?>load/load_details/'+data[0].ts_load_idts_load+'#callchecks"> View </a></div>');
							$('#notification_content').css('margin-bottom','5px');
										var audio = new Audio('<?php echo base_url() ?>public/css/sound.mp3');
										audio.play();
												$('#notification_content div').click(function(){
													$(this).remove();
												});
										};
							} else {
								localStorage.last_callcheck = data[0].idts_callcheck;
							}
							//-----
							localStorage.last_callcheck = data[0].idts_callcheck;
					},
				error: function(data){
					//alert('There was an error');
					}
				
				});
		},10000);
		

});
    var ck_load = [];
    $('[data-toggle=popover]').popover({
        trigger: "click",
    });

    $('[data-toggle=popover]').on('click', function (e) {
        $('[data-toggle=popover]').not(this).popover('hide');
        var load = $(this);
        var load_id = load.data('load_id');

        $('.popover-title').html('Load Options <span style="margin-left:15px;" class="pull-right"><a href="#" onclick="$(&quot;#' + this + '&quot;).popover(&quot;toggle&quot;);" class="text-danger popover-close" data-bypass="true" title="Close"><i class="fa fa-closex"></i></a></span>');
        $('.popover-content').html('<ul><li><a data-id="4" title="Edit this Load" href="load/update2/' + load_id + '"><i class="icon-pencil"></i> Edit</a></li> <li><a data-id="4" title="View this Load" href="load/load_details/' + load_id + '"><i class="icon-eye-open"></i> View</a></li> <li><a data-id="4" title="Edit this Load" href="load/trash/' + load_id + '"><i class="icon-trash"></i>Trash</a> </li></ul>');

        console.log('datos de load: ' + load.data('load_id'));
    });
    $(function () {
        var wage = document.getElementById("search_load_number");
        wage.addEventListener("keydown", function (e) {
            if (e.keyCode === 13) {
                searchLoad();
            }
        });

        $('#save').click(function () {
            alert($('#mytable').find('input[type="checkbox"]:checked').length + ' checked');
        });

        $('body').on('click', '.edit_load', function (evt) {
            ck_load = [];
            $('#list_load').find('input[type="checkbox"]:checked').each(function () {
                var load = $(this);
                console.log(load.attr('name'));
                ck_load.push({idts_load: load.attr('name')});
            });
            console.log(ck_load);
            editLoads();
        });

        $('body').on('click', '#btn_edit_loads', function (evt) {
            $("#loads").val(JSON.stringify(ck_load));
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('load/multi_upload') ?>',
                data: {
                    customer: $("#customer").val(),
                    carrier: $("#carrier").val(),
                    driver: $("#driver").val(),
                    loads: $("#loads").val()
                },
                async: true,
                dataType: "json",
                beforeSend: function () {
                    $('#result_destination').html('Loading...');
                    $('#result_destination').show();
                },
                success: function (data) {
                    //                console.log('google result ' + data.status);
                    //
                    //                $('#result_destination').show();
                }
            });
        });

        // Get loads filtered
        $('body').on('click', '#load_search', function (evt) {
            evt.preventDefault();
            searchLoad();
        });

        //adds highlight when clicked
        $('#list_load tbody tr').on('click', function (event) {
            $(this).addClass('highlight').siblings().removeClass('highlight');
        });

        //Inicialize popover
        $('body').on('click', '.po', function (evt) {
            evt.preventDefault();
            $('#list_load tr').popover('hide');

            var load_id = $(this).data('load_id');
            var editHtml = '<ul><li data-load_edit="' + load_id + '">Edit</li></ul>';
            var popover = $(this).attr('id');
            $('#popover_content ul li a.editLink').attr('href', 'load/update2/' + popover);
            $('#popover_content ul li a.viewLink').attr('href', 'load/load_details/' + popover);

            $(this).popover({
                "trigger": "manual",
                "html": "true",
                "title": 'Load Options <span style="margin-left:15px;" class="pull-right"><a href="#" onclick="$(&quot;#' + popover + '&quot;).popover(&quot;toggle&quot;);" class="text-danger popover-close" data-bypass="true" title="Close"><i class="fa fa-close"></i></a></span>',
                "content": '<ul><li><a data-id="4" title="Edit this Load" href="load/update2/' + popover + '"><i class="icon-pencil"></i> Edit</a></li> <li><a data-id="4" title="View this Load" href="load/load_details/' + load_id + '"><i class="icon-eye-open"></i> View</a></li> <li><a data-id="4" title="Edit this Load" href="load/trash/' + load_id + '"><i class="icon-trash"></i>Trash</a> </li></ul>'
            });
        });

        $('body').on('click', '.edit', function (evt) {
            evt.preventDefault();
            var load = $(this).data('id');
            var site_url = '<?php echo site_url() ?>';
            location.href = site_url + 'load/update2/' + load;
        });

        $('body').on('click', '.view', function (evt) {
            evt.preventDefault();
            var load = $(this).data('id');
            var site_url = '<?php echo site_url() ?>';
            location.href = site_url + 'load/load_details/' + load;
        });

        // trash load
//        $('body').on('click', '.trash', function (evt) {
//            evt.preventDefault();
//            var load = $(this);
//
//            bootbox.confirm({
//                size: 'small',
//                title: 'Trash Load',
//                message: "Are you sure you want to trash this load?",
//                callback: function (result) {
//                    if (result) {
//                        $.ajax({
//                            type: "POST",
//                            url: '<?php echo site_url('load/trash') ?>/' + load.data('id'),
//                            async: true,
//                            dataType: "json",
//                            success: function (o) {
//                                if (o.result == 1) {
//                                    $('#load_' + load.data('id')).hide();
//                                }
//                            }
//                        });
//                    } else {
//                        console.log('cancel');
//                    }
//                }
//            });
//        });


        $('body').on('click', '.trash', function (evt) {
            evt.preventDefault();
            var load = $(this);
            var id = load.data('id');
            var site_url = '<?php echo site_url() ?>';
            var r = confirm("Confirm trashing load?");

            if (r == true) {
                $.ajax({
                    type: "POST",
                    url: site_url + 'load/change_status/' + id + '/' + 0,
                    async: true,
                    dataType: "json",
                    beforeSend: function () {
                        $('#result_destination').html('Loading...');
                        $('#result_destination').show();
                    },
                    success: function (data) {
                        if (data.status == 1) {
                            $('#load_' + id).remove();
                            console.log('load deleted');
                        } else {
                            alert('Load could not be trashed. Please contact administrator.');
                        }
                    }
                });
            }

        });

        //show tender modal

        $('body').on('click', '.set-tender-modal', function (evt) {
            evt.preventDefault();
            var load = $(this);
            $('#tender_load_id').val(load.data('id'));
            $('#tender_load_number').val(load.data('load_number'));
            $('#driver_id').val(load.data('driver_id'));
            $('#email').val(load.data('email'));
            $('#tender_iframe').attr('src', '<?php echo VIEW_FILE_PATH ?>' + load.data('bol_url'));
        });

        //tender push not, set in callcheck and send email

        $('body').on('click', '#tender-load', function (evt) {
            evt.preventDefault();
            var load = $(this);
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('load/push_not_custom_msg_load') ?>',
                async: true,
                data: {
                    title: $('#title').val(),
                    msg: $('textarea#msg').val(),
                    android_title: $('#title').val(),
                    load_id: $('#tender_load_id').val(),
                    load_number: $('#tender_load_number').val(),
                    driver_id: $('#driver_id').val(),
                    email: $('#email').val(),
                    tender: 1
                },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        var load_id = $('#tender_load_id').val();
                        $('#load_' + load_id + ' .status').html('To Pickup');
                        $('#load_' + load_id + ' .status').css('background-color', 'transparent');
                        $('#tenderModal').modal('toggle');
                        $('#tender_' + load_id).remove();
                        alert('Load succesfully tendered.');
                    }
//                    var o = data['dbresult'];
//                    saveMsg(o.date, o.time, o.city, o.state, o.comment, o.entered_by);
//                    $('#styled_message').val('');
                }
            });
        });


        $('body').on('click', '.map_view', function (evt) {
            evt.preventDefault();

            //            console.log('load values: '+$(this).data('driver_lat'));

            var self = $(this);
            var lat = parseFloat(self.data('driver_lat'));
            var lng = parseFloat(self.data('driver_lng'));

            $("#driver_lat").val(parseFloat(self.data('driver_lat')));
            $("#driver_lng").val(parseFloat(self.data('driver_lng')));

            //            initialize2(lat, lng);

            //            $.ajax({
            //                type: "POST",
            //                url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&key=AIzaSyAp8XadZn74QX4NLDphnzehQ0AN7q6NCwg',
            //                async: true,
            //                dataType: "json",
            //                beforeSend: function () {
            //                    $('#result_destination').html('Loading...');
            //                    $('#result_destination').show();
            //                },
            //                success: function (data) {
            ////                console.log('google result ' + data.status);
            //
            //                    var lat = data.results[0].geometry.location.lat;
            //                    var lng = data.results[0].geometry.location.lng;
            //                    var lng = data.results[0].geometry.location.lng;
            //                    var zipcode = data.results[0].address_components[6].long_name;
            //                    var city = data.results[0].address_components[2].long_name;
            //                    var state = data.results[0].address_components[4].short_name;
            //                    console.log('destination: state: ' + state + ', lat: ' + lat + ', lng: ' + lng + ', zipcode: ' + zipcode);
            //                    $('#destinationAddressModal').show();
            //                    $('#map-canvas2').css('display', 'block');
            //                    $('#map-canvas').css('display', 'none');
            //                    initialize2(lat, lng);
            ////
            ////                $('#result_destination').show();
            //                }
            //            });
        });

        $('#destinationAddressModal').on('shown.bs.modal', function (e) {
            $('#map-canvas2').html('');
            initialize2();
        });

        $('body').on('click', '#search_btn', function (evt) {
            evt.preventDefault();

            var search = $('#search');

            $.ajax({
                type: "POST",
                url: '',
                async: true,
                dataType: "json",
                beforeSend: function () {
                    $('#result_destination').html('Loading...');
                    $('#result_destination').show();
                },
                success: function (data) {
                    //                console.log('google result ' + data.status);
                    //
                    //                $('#result_destination').show();
                }
            });
        });


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

    function editLoads() {
        $('#editLoadModal').modal('show');
    }

    function initialize2() {
//        $().html()
        var lat = $("#driver_lat").val();
        var lng = $("#driver_lng").val();
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 13,
            center: myLatlng
        };
        var map = new google.maps.Map(document.getElementById('map-canvas2'), mapOptions);
        var marker = new google.maps.Marker({
//            icon: 'map-marker-driver.png',
            position: new google.maps.LatLng(lat, lng),
            map: map,
        });

        $('#myModal').on('shown', function () {
            google.maps.event.trigger(map, "resize");
        });
    }

    function searchLoad() {
        var total_loads = '<?php echo $total_loads ?>';
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('load/get_load_view/0/1/1/date_created/desc') ?>' + '/' + total_loads,
            data: {
                search_customer: $("#search_customer").val(),
                search_carrier: $("#search_carrier").val(),
                search_load_number: $("#search_load_number").val()
            },
            async: true,
            dataType: "json",
            beforeSend: function () {
                $('#result_destination').html('Loading...');
                $('#result_destination').show();
            },
            success: function (data) {
                $('#list_load tbody').empty();
                var output = '';
                for (var i = 0; i < data.length; i++) {
                    var status = data[i].status;

                    var data_format = data[i].date_created.split(" ");
                    var myd = data_format[0].split("-");
                    output += '<tr data-status="' + status + '" id="load_' + data[i].idts_load + '" data-load_id="' + data[i].idts_load + '" data-toggle="popover" class="po">';
                    output += '<td>' + data[i].load_number + '</td>';
                    output += '<td>' + myd[1] + '/' + myd[2] + '/' + myd[0] + ' ' + data_format[1] + '</td>';
                    output += '<td>' + data[i].carrier_name + '</td>';
                    output += '<td>' + data[i].driver_name + ' ' + data[i].driver_last_name + '</td>';
                    output += '<td>' + data[i].address + '</td>';
                    output += '<td class="color" style="font-weight: 800;color: #666;">' + status + '</td>';
                    output += '<td><a class="edit" href=" <?php echo site_url('load/update2') ?>' + '/' + data[i].idts_load + '" data-id="' + data[i].idts_load + '"> Edit </a><a class="view" href=" <?php echo site_url('load/load_details') ?>' + '/' + data[i].idts_load + '" data-id="' + data[i].idts_load + '"> View </a><a class="trash" data-id="' + data[i].idts_load + '" href="<?php echo site_url('load/trash') ?>' + '/' + data[i].idts_load + '"> Trash </a></td>';
                    output += '</tr>';
                }
                $('#list_load tbody').append(output);
            }
        });
    }

function urlExists(url, callback){
  $.ajax({
    type: 'HEAD',
    url: url,
    success: function(){
      callback(true);
    },
    error: function() {
      callback(false);
    }
  });
}	

function initMap() {
    var latlng = new google.maps.LatLng(38.384157, -98.278920);
    var myOptions = {
        zoom: 4,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("new_map"),
            myOptions);
					<?php

					$k = 1;		
						foreach ($loads2 as $load3 => $row3) {
							if($row3['status'] == 'Delivered'){}else{
								if(($row3['driver_latitud']==0)&&($row3['driver_longitud']==0)){}else{
							?>
					var infowindow<?php echo $k; ?> = new google.maps.InfoWindow({
					  content:'<p class="tag-map"><?php echo $row3['driver_full_name']; ?></p>',
					  maxWidth: 300
					  });
					  <?php
						 $ch = curl_init('http://leanstaffing.com/testserver2/drivers/'.$row3['driver_phone'].'.png');    
							curl_setopt($ch, CURLOPT_NOBODY, true);
							curl_exec($ch);
							$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							if($code == 200){
							   $status = true;
							}else{
							  $status = false;
							}
							curl_close($ch);
						 if($status == false){
						?>
						var image_driver = new google.maps.MarkerImage('http://leanstaffing.com/testserver/map-marker-driver.png',null,null,null,new google.maps.Size(94,48));	 
						<?php
							 }else{
					  ?>
						var image_driver = new google.maps.MarkerImage(
								'http://leanstaffing.com/testserver2/drivers/<?php echo $row3['driver_phone']; ?>.png',
								null, /* size is determined at runtime */
								null, /* origin is 0,0 */
								null, /* anchor is bottom center of the scaled image */
								new google.maps.Size(122, 76)
							); 
						<?php
							 }
						?>
					
				 var marker<?php echo $k; ?> = new google.maps.Marker({
						//            icon: 'map-marker-driver.png',
						position: new google.maps.LatLng(<?php echo $row3['driver_latitud']; ?>, <?php echo $row3['driver_longitud']; ?>),
						map: map,
						icon: image_driver,
						title: '<?php echo $row3['driver_full_name']; ?>'
					});

					//infowindow<?php echo $k; ?>.open(map,marker<?php echo $k; ?>);
					 
					 google.maps.event.addListener(marker<?php echo $k; ?>, 'click', function() {
						 var html = "<p class='tag-map'><b><?php echo $row3['driver_full_name']; ?></b> <br/>Phone :<?php echo $row3['driver_phone']; ?><br/><a class='view' data-id='<?php echo $row3['idts_load']; ?>'> View Load </a></p>";
                          infowindow<?php echo $k; ?>.setContent(html);
                          infowindow<?php echo $k; ?>.open(map, marker<?php echo $k; ?>, html);
					  });
			<?php
				 $k++;
							}
						}
				 }
					?>

}
//google.maps.event.addDomListener(window, "load", initialize);

</script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?signed_in=true&callback=initMap"></script>