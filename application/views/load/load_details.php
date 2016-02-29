<style>
    /*    #map_wrapper{
            float: right;
            width:600px;
        }*/
    #map{
        height:350px;
        width:100%;
        padding:0;
        righ:0px;
        bottom:0px !important;
        left:0px !important;
    }

    .subject{
        font-weight: bold;
    }

</style>

<div>

    <script src="<?php echo site_url('public/third-party') ?>/js/jSignature.min.noconflict.js"></script>

    <?php
    $driver = $driver[0];
    $load = $load[0];
    ?>
    <div id="list_user">
        <span class="ajax-loader-gray"></span>
    </div>
    <div id="category-actions">
        <div class="loads-title" id="category-title"><img src="<?php echo base_url() ?>/public/img/images/loads-title.png" width="100" height="70" alt="Loads Category"></div>
        <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All Loads"></a></div>
        <?php
        if (in_array("load/add", $roles)) {
            ?>
            <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/add'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" alt="Add a Load"></a></div>
        <?php } ?>    
    </div>    
    <!--<div class="text-left"><h1>Load Details #<?php echo $load['load_number'] ?></h1></div>-->
    <h2>Details Load #<?php echo $load['load_number'] ?></h2>

    <div class="container container-wide">

        <div class="content" role="main" style="padding:0px">
            <div class="row">
                <div class="tabs_framed styled">
                    <ul class="tabs clearfix tab_id2 bookmarks3 active_bookmark1">
                        <li class="first active"><a href="#about" data-toggle="tab" hidefocus="true" style="outline: none;">SHIPMENTS</a></li>
                        <li><a id="createmap" href="#mapdrive" data-toggle="tab" hidefocus="true" style="outline: none;">DRIVER</a></li>
                        <li><a id="createmap" href="#callcheck_tab" data-toggle="tab" hidefocus="true" style="outline: none;">CALLCHECKS</a></li>
                    </ul>

                    <div class="tab-content boxed clearfix">
                        <div class="tab-pane fade active in" id="about">
                            <div class="inner clearfix">

<!--                                <a style="width:200px;" href="../../../tkgo_files/<?php echo $load['load_number'] ?>.pdf" class="btn" download="w3logo" hidefocus="true"><span class="gradient">DOWNLOAD</span></a>
                                <a class="btn" href="#" hidefocus="true"><span class="gradient" data-toggle="modal" data-target="#destinationAddressModal">Send by e-mail</span></a>
                                <a class="btn" href="#" onclick="reloadBol()" hidefocus="true"><span class="gradient">Refresh BOL</span></a>
                                <iframe width="100%" height="600" id="if_bol" style="margin-top:15px" src="../../../tkgo_files/<?php echo $load['load_number'] ?>.pdf"></iframe>-->
                                <div style="margin-bottom: 10px;">[<span><a class="expd" style="cursor:pointer">Expand</a></span>/<span><a class="cpse" style="cursor:pointer">Collapse</a></span>]<div style="float: right; position: relative; bottom: 2px;"><button id="refresh" onclick="location.reload();" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;float: left;position: relative;bottom: 3px;right: 5px;"><span class="gradient">Refresh</span></button></div></div>
                                <div class="accordion">
                                    <?php
                                    $file_path = VIEW_FILE_PATH;
                                    $i = 1;
                                    foreach ($shipments as $shipment => $row) {
                                        ?>
                                        <div class="accordion-section">
                                            <a class="accordion-section-title" href="#accordion-<?php echo $i ?>">BOL #<?php echo $row['bol_number'] ?> <div style="float: right;"><span style="float:right" >S<?php echo $i ?></span></div></a>
                                            <div id="accordion-<?php echo $i ?>" class="accordion-section-content open">
                                                <table id="bol-table" class="table table-hover table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td class="bol_header">Customer</td>
                                                            <td class="bol_header">Pickup</td>
                                                            <td class="bol_header">Pickup #</td>
                                                            <td class="bol_header">Drop</td>
                                                            <td class="bol_header">Drop #</td>
                                                            <td class="bol_header">Status</td>
                                                            <td class="bol_header">Documents</td>
                                                        </tr>
                                                        <?php
                                                        $shp = $row['origin_sign'] == 1 ? '<div class="shp_document"><a id="sp_pop_' . $row['bol_number'] . '" href="' . VIEW_FILE_PATH . $load['idts_load'] . '_bol_' . $row['bol_number'] . '_sp.pdf" class="pop" data-load_id="' . $load['idts_load'] . '" data-bol_number="' . $row['bol_number'] . '" data-doc_type="sp" data-pages_number="' . $row['pickup_doc_pages'] . '" target="_blank">' . $row['pickup_doc'] . '</a></div>' : '';
                                                        $pod = $row['destination_sign'] == 1 ? '<div class="csn_document"><a id="cs_pop_' . $row['bol_number'] . '" href="' . VIEW_FILE_PATH . $load['idts_load'] . '_bol_' . $row['bol_number'] . '_cs.pdf" class="pop_cs" data-load_id="' . $load['idts_load'] . '" data-bol_number="' . $row['bol_number'] . '" data-doc_type="cs" data-pages_number="' . $row['drop_doc_pages'] . '" target="_blank">' . $row['drop_doc'] . '</a></div>' : '';
                                                        $status = 'test';
                                                        if ($load['tender'] == 0) {
                                                            $status = 'Not tendered';
                                                        } else if (($shp == '') && ($pod == '')) {
                                                            $status = 'To Pickup';
                                                        } else if (($shp != '') && ($pod == '')) {
                                                            $status = 'In transit';
                                                        } else {
                                                            $status = 'Delivered';
                                                        }
                                                        
                                                        echo'<tr data-status="' . $status . '">'
                                                        . '<td style="text-align: center; width:14%">' . $row['customer_name'] . '</td>'
                                                        . '<td style="text-align: center; width:20%">' . $row['pickup_format_address'] . '</td>'
                                                        . '<td style="text-align: center; width:7%">' . $row['pickup_number'] . '</td>'
                                                        . '<td style="text-align: center; width:20%">' . $row['drop_format_address'] . '</td>'
                                                        . '<td style="text-align: center; width:7%">' . $row['drop_number'] . '</td>'
                                                        . '<td class="status color" style="text-align: center;width:12%"">' . $status . '</td>'
                                                        . '<td style="text-align: center;">'
                                                        . '<div class="or_document"><a id="or_pop_' . $row['bol_number'] . '" href="' . VIEW_FILE_PATH . $row['url_bol'] . '" class="pop_or" data-load_id="' . $load['idts_load'] . '" data-bol_number="' . $row['bol_number'] . '"  target="_blank">Original Document</a></div>'
                                                        . $shp
                                                        . $pod
                                                        . ' </td>'
                                                        . '</tr>';

                                                        echo'<tr>';
                                                        echo'<td colspan="7">Contacts: ';
                                                        foreach ($row['contacts'] as $contact) {
                                                            echo $contact['name'] . ', ';
                                                        }
                                                        echo'</td>';
                                                        echo'</tr>';

                                                        echo'<tr>';
                                                        echo'<td colspan="7" style="border-left: none;border-right: none;">Documents: ';
                                                        foreach ($row['documents'] as $documents) {
                                                            echo '<a href="' . $file_path . $documents['url'] . '" target="_blank">' . $documents['name'] . '</a>, ';
                                                        }
                                                        echo'</td>';
                                                        echo'</tr>';

                                                        echo'<tr>';
                                                        echo'<td colspan="7" style="border-left: none;border-right: none;">&nbsp;</td>';
                                                        echo'</tr>';
                                                        ?>                                                        
                                                    </tbody>
                                                </table>
                                                <!--<p>Mauris interdum fringilla augue vitae tincidunt. Curabitur vitae tortor id eros euismod ultrices. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent nulla mi, rutrum ut feugiat at, vestibulum ut neque? Cras tincidunt enim vel aliquet facilisis. Duis congue ullamcorper vehicula. Proin nunc lacus, semper sit amet elit sit amet, aliquet pulvinar erat. Nunc pretium quis sapien eu rhoncus. Suspendisse ornare gravida mi, et placerat tellus tempor vitae.</p>-->
                                            </div><!--end .accordion-section-content-->
                                        </div><!--end .accordion-section-->
                                        <br>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </div><!--end .accordion-->                                
                            </div>

                        </div>

                        <div class="tab-pane fade" id="mapdrive">
                            <div class="inner clearfix">
                                <div class="widget-container widget_categories boxed">
                                    <h4 class="widget-title">DRIVER INFORMATION</h4>
                                    <div style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px">
                                        <div>Name: <?php echo $driver['full_name'] ?></div>
                                        <div>Phone: <?php echo $driver['phone'] ?></div>
                                        <div>Carrier: <?php echo $load['carrier_name'] ?></div>
                                    </div>  
                                </div>

                                <div class="widget-container widget_categories boxed">
                                    <h4 class="widget-title">CURRENT DRIVER LOCATION<span class="refresh-driver" style="float:right; cursor:pointer"><img src="<?php echo base_url() ?>/public/img/ic_refresh_white_24dp_1x.png" style="width:22px;" alt="Loads Category"></span></h4>
                                    <div style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px">
                                        <div id="driver_loc"></div>
                                    </div>  
                                </div>


                                <div class="widget-container widget_categories boxed">
                                    <h4 class="widget-title">MAP<span class="refresh-driver" style="float:right; cursor:pointer"><img src="<?php echo base_url() ?>/public/img/ic_refresh_white_24dp_1x.png" style="width:22px;" alt="Loads Category"></span></h4>
                                    <div id="map_wrapper">
                                        <div class="widget-container widget_categories boxed">
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-container widget_categories boxed">
                                    <h4 class="widget-title">LOCATION HISTORY<span class="refresh-driver" style="float:right; cursor:pointer"><img src="<?php echo base_url() ?>/public/img/ic_refresh_white_24dp_1x.png" style="width:22px;" alt="Loads Category"></span></h4>
                                    <div style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px">
                                        <div id="history_loc">
                                            <div class="lc-header-wrapper">
                                                <table class="lc-header" style="width: 873px;">
                                                    <tr>
                                                        <td style="width:124px"><span style="font-weight: 900 ">Date</span></td>
                                                        <td style="width:124px"><span style="font-weight: 900 ">Time</span></td>
                                                        <td><span style="font-weight: 900 ">Position</span></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="lc-row-wrapper">
                                                <table id="trace_table" class="lc-rows">
                                                    <tbody>
                                                        <?php
                                                        foreach ($traces as $trace => $row) {
                                                            $date = explode(' ', $row['date']);
                                                            $date_formated_temp = explode('-', $date[0]);
                                                            $date_formated = $date_formated_temp[1] . '/' . $date_formated_temp[0] . '/' . $date_formated_temp[2];
                                                            $lat = $row['lat'];
                                                            $lng = $row['lng'];

                                                            if ($row['address_text']) {
                                                                $driver_pos = '<td style="text-align: center;">' . $row['address_text'] . '</td>';
                                                            } else {
                                                                $driver_pos = '<td style="text-align: center;"><a class="get_position" style="cursor:pointer" data-id="' . $row['idts_load_trace'] . '" data-lat="' . $lat . '" data-lng="' . $lng . '" title="Popover Header">View Position</a></td>';
                                                            }

                                                            if ($row['date']) {
                                                                echo'<tr>'
                                                                . '<td style="text-align: center; width:124px">' . $date_formated . '</td>'
                                                                . '<td style="text-align: center; width:124px">' . $date[1] . '</td>'
                                                                . $driver_pos
                                                                . '</tr>';
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="loading-bar" style="display:none"></div>
                                    </div>                                
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="callcheck_tab">
                            <div class="widget-container widget_categories boxed">
                                <h4 class="widget-title">CALL CHECKS</h4>
                                <div class="add-comment styled boxed" id="addcomments">
                                    <div class="comment-form">
                                        <form action="#" method="post" id="commentForm" class="ajax_form">
                                            <div class="form-inner">
                                                <!--<div class="field_select">
                                                    <label for="contact_name" class="label_title">Contacts</label>
                                                    <select name="contact_name" id="contact_name" multiple="" data-placeholder="Choose from list" class="chzn-done" style="display: none;">
                                                        <option value="Hello@me.com">Hello@me.com</option>
                                                        <option value="Andy@me.com">Andy@me.com</option>
                                                        <option value="info@ex.com">info@ex.com</option>
                                                        <option value="John@ex.com">John@ex.com</option>
                                                        <option value="Doe@ex.com">Doe@ex.com</option>
                                                    </select><div class="chzn-container chzn-container-multi" style="width: 100%;" title="" id="contact_name_chzn"><ul class="chzn-choices"><li class="search-field"><input type="text" value="Choose from list" class="default" autocomplete="off" style="width: 124px;"></li></ul><div class="chzn-drop gradient"><ul class="chzn-results"><li class="active-result" style="" data-option-array-index="0">Hello@me.com</li><li class="active-result" style="" data-option-array-index="1">Andy@me.com</li><li class="active-result" style="" data-option-array-index="2">info@ex.com</li><li class="active-result" style="" data-option-array-index="3">John@ex.com</li><li class="active-result" style="" data-option-array-index="4">Doe@ex.com</li></ul></div></div>
                                                </div>-->
                                                <div class="field_text" hidden>
                                                    <label for="subject" class="label_title">Subject</label>
                                                    <input type="text" name="subject" id="subject" value="Load #<?php echo $load['load_number'] ?>" placeholder="You can add a subject" class="inputtext input_middle required" hidefocus="true" style="outline: none;">
                                                </div>
                                                <!--style="width:100%;height: 150px;overflow-y: auto;border: 1px solid #ccc; margin-bottom: 15px;"-->
                                                <!--                                                    <div id="chat_load" >-->

                                                <!--</div>-->

                                                <div class="grid">
                                                    <div class="grid-canvas">
                                                        <div class="header-wrapper">
                                                            <table class="header">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width:100px">Date</td>
                                                                        <td style="width:100px">time</td>
                                                                        <td>City</td>
                                                                        <td>State</td>
                                                                        <td style="width:239px">Notes</td>
                                                                        <td>User</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div id="div1" class="row-wrapper">
                                                            <table id="callcheck_table" class="rows">
                                                                <tbody>
                                                                    <?php
                                                                    $last_date = '';
                                                                    foreach ($callchecks as $callcheck => $row) {
                                                                        if ($row['driver_sw'] == 1) {
                                                                            $sub = $row['driver_name'] . ' ' . $row['driver_last_name'];
                                                                            $ms_style = '#D8D8D8';
                                                                        } else {
                                                                            $sub = $row['user_login'];
                                                                            $ms_style = '#FFFFFF';
                                                                        }
                                                                        $date = explode(' ', $row['date']);
                                                                        $date_formated_temp = explode('-', $date[0]);
                                                                        $date_formated = $date_formated_temp[1] . '/' . $date_formated_temp[2] . '/' . $date_formated_temp[0];

                                                                        if ($row['date']) {
                                                                            echo'<tr style="background-color: ' . $ms_style . '">'
                                                                            . '<td style="text-align: center; width:100px">' . $date_formated . '</td>'
                                                                            . '<td style="text-align: center; width:100px">' . $date[1] . '</td>'
                                                                            . '<td style="text-align: center;">' . $row['city'] . '</td>'
                                                                            . '<td style="text-align: center;">' . $row['state'] . '</td>'
//                                                                            . '<td style="text-align: center;width:239px"><div class="notes" style="float:left">' . $row['comment'] . '</div><a class="exp-call" data-comment="' . $row['comment'] . '" style="float:left;">exp</a></td>'
                                                                            . '<td style="text-align: center;width:239px"><div class="notes" style="float:left">' . $row['comment'] . '</div><a class="set-callcheck" data-note="' . $row['comment'] . '" hidefocus="true" style="outline: medium none;margin: 0px 5px;" data-toggle="modal" data-target="#callcheckViewModal">view</a></td>'
                                                                            . '<td style="text-align: center;">' . $sub . '</td>'
                                                                            . '</tr>';
                                                                            $last_date = $row['date'];
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" id="last_date" value="<?php echo $last_date ?>"/>
                                                <div class="clear"></div>
                                                <div class="loading" style="display:none">
                                                    <div class="loading-bg" style="display:none"></div>
                                                </div>
                                                <div class="field_text field_textarea" style="margin: 20px 0px;">
                                                    <div id="register_form_error" class="alert alert-error" style="display:none"><!-- Dynamic --></div>
                                                    <label for="styled_message" class="label_title">Message</label>
                                                    <textarea cols="30" rows="10" name="styled_message" id="styled_message" placeholder="Leave your message here" class="textarea textarea_middle required" hidefocus="true" style="outline: none;height:70px;"></textarea>
                                                </div>
                                                <div class="clear"></div>
                                            </div>

                                            <div class="rowSubmit clearfix" style="padding:0px 0px;">
                                                <div class="input_styled checklist">
                                                    <div class="rowCheckbox checkbox-filled"><!--<div class="custom-checkbox"><input name="save" type="checkbox" checked="" id="save" value="save" hidefocus="true" style="outline: none;"><label for="save" class="checked">&nbsp;</label></div>--></div>
                                                </div>
                                                <span style="float:left; padding-left: 15px; visibility: hidden"><input type="checkbox" name="sw_not_driver" id="ntfy_driver" value="" checked=""> Notify Driver</span>
                                                <span class="btn"><input type="submit" id="send" value="Send Message" hidefocus="true" class="gradient" style="outline: none;"></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div> <!-- END OF ROW -->
            <div class="modal fade" id="destinationAddressModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Send BOL by e-mail</h4>                            
                        </div>
                        <div class="modal-body">
                            <div class="control-group">
                                <label class="control-label">Email</label>
                                <div class="controls">
                                    <input type="text" name="email" id="email" class="input-xlarge" placeholder=""/>
                                    <input type="hidden" name="bol_number_mail" id="bol_number_mail"/>
                                    <input type="hidden" name="doc_type" id="doc_type"/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--<button type="button" class="btn btn-primary" id="btn_send_bol" data-dismiss="modal">Send</button>-->
                            <button data-dismiss="modal" style="border-radius: 16%; height: 25px;float: none;">Close</button>&nbsp;
                            <button id="btn_send_bol" class="btn btn-red btn-small" hidefocus="true" data-dismiss="modal" name="submit" style="outline: medium none;"><span class="gradient">Send</span></button>
                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Callcheck modal -->
            <div class="modal fade" id="callcheckViewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">View Callcheck</h4>
                        </div>
                        <div class="modal-body">
                            <div class="control-group">
                                <label class="control-label">Note:</label>
                                <div class="controls">
                                    <div id="callcheck_note"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                            <button data-dismiss="modal" style="border-radius: 16%; height: 25px;">Close</button>
                        </div>
                    </div>
                </div>
            </div>  
            <div id=""></div>

        </div>
        <div class="row">

            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">

            </div>                    
        </div>

    </div>
</div>

<style>

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
    }

    /*----- Section Titles -----*/
    .accordion-section-title {
        width:100%;
        padding:15px;
        display:inline-block;
        border-bottom:1px solid #1a1a1a;
        background:#626262;
        transition:all linear 0.15s;
        /* Type */
        font-size:1.200em;
        text-shadow:0px 1px 0px #1a1a1a;
        color:#fff;
    }

    .accordion-section-title.active, .accordion-section-title:hover {
        background:#4c4c4c;
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

    #bol-table{
        width: 900px;
        /*table-layout: fixed;*/
    }
    #bol-table td{
        border: 1px solid #DCD8D8;
    }
    .bol_header {
        text-align: center !important;
        color: #666 !important;
    }    

    .grid {
        height: 300px;
        width: 101%;
    }

    .grid-canvas {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .header-wrapper {
        position: absolute;
        top: 0;
        width: auto;
        background-color: white;
        z-index: 1;
    }

    .lc-header-wrapper{
        position: relative;
        top: 0px;
        width: 873px;
        background-color: white;
        z-index: 1;
    }

    .row-wrapper {
        position: absolute;
        top: 0;
        height: 100%;
        width: 100%;
        box-sizing: border-box;
        overflow: auto;
        padding-top: 19px;
    }

    .lc-row-wrapper {
        position: relative;
        top: -12px;
        height: 100%;
        width: 100%;
        box-sizing: border-box;
        overflow: auto;
        padding-top: 11px;
    }

    .header td{
        font-size: large;
        text-align: center;
    }

    .lc-header td{
        text-align: center;
    }

    .header td, .rows td {
        width: 138px;
        text-overflow: ellipsis;
        white-space: nowrap;
        border: 1px solid;
    }

    .lc-header td, .lc-rows td {
        text-overflow: ellipsis;
        white-space: nowrap;
        border: 1px solid;
    }


    .notes{
        overflow: hidden;
        width: 205px;
        padding: 0px 10px;
    }

    .modal {
        width: 610px;
        overflow-y: auto;
        overflow-x: auto;
        height: 280px;
    }

    #history_loc{
        /*overflow-y: scroll;*/
        height: 15em;
    }

    #trace_table{
        width: 873px;
    }
    #trace_table thead tr th{
        border: 1px solid;
        text-align: center;
        font-weight: 800;        
    }

    .control-group{
        margin: 20px 0px;
    } 

    .shp_document .popover, .csn_document .popover, .or_document .popover{
        width: 230px;
    }

    .shp_document .popover .popover-title, .csn_document .popover .popover-title, .or_document .popover .popover-title{
        font-size: large;
    }


    #callcheck_table .popover-title{
        font-size: 18px!important;
    }

    #callcheck_table tr{
        height: 20px;
    }

    #callcheck_table td{
        vertical-align: middle;
    }     

    #callcheckViewModal{
        width: 630px;
        height: 485px;
    }

    .notes .gradient, button {
        height: 20px;
        line-height: 20px;
        padding: 0 4px;
        font-size: 14px;
        float: right;
    }

    #callcheckViewModal .control-label {
        font-weight: 900;
    }    

    #callcheck_note{
        width: 547px;
        overflow-wrap: break-word; 
        margin: 10px 0px;
    }

    #destinationAddressModal{
        width: 630px;
        height: 315px;        
    }

    #destinationAddressModal .modal-body{
        min-height: 135px;
    }

    .loading{
        text-align: center;
        margin: 20px;
    }

    .loading-bg{
        width: 100px;
        height: 25px;
        background-image: url("/trackngo/public/img/ajax-loader-squares.gif");
        background-size: 50px 25px;
        background-repeat: no-repeat;
        margin-left: 46%;
        margin: 20px 46%;      
    }    


</style>
<!-- Hidden content -->


<!----------------------- Map, Distance , Time ------------------------------->
<script>
    var trace_number = 20;
    $('.get_position').popover();
    $('body').on('click', '.get_position', function (evt) {
        evt.preventDefault();
        var geo = $(this);
        $('.get_position').not(geo).popover('hide');
        $('.popover-title').html('<span>Driver address</span>');
        $('.popover-content').css({'background': 'url(' + '<?php echo base_url() ?>' + '/public/img/images/ajax-loader.gif)', 'background-repeat': 'no-repeat', 'background-position': 'center'});
        console.log('this is latitud: ' + geo.data('lat'));
        //        $('[data-toggle=popover]').not(this).popover('hide');
        //        $('.popover-title').html('<span>Driver address</span>');
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('load/get_driver_address') ?>/' + geo.data('lat') + '/' + geo.data('lng') + '/1/' + geo.data('id') + '/1',
            async: true,
            data: {
                lat: geo.data('lat'),
                lng: geo.data('lng')
            },
            dataType: "json",
            success: function (o) {

                var addrress = o.results[0].formatted_address;
                geo.parent().html(addrress);
                $('.popover-content').html('<ul><li>' + addrress + '</li></ul>');
                $('.popover-content').css('background', 'url(' + 'none');
                geo.popover('show');
                $('.popover-title').html('<span>Driver address</span>');
            }
        });
    });
    $('body').on('click', '.set-callcheck', function (evt) {
        evt.preventDefault();
        var callcheck = $(this);
        $("#callcheck_note").html(callcheck.data('note'));
    });
    $('body').on('click', '.send_email', function (evt) {
        evt.preventDefault();
        var pdf = $(this);
        $("#bol_number_mail").val(pdf.data('bol_number'));
        $("#doc_type").val(pdf.data('doc_type'));
        var pdf = $(this);
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('load/create_pdf/0/0/0/0/1') ?>',
            async: true,
            data: {
                load_id: pdf.data('load_id'),
                bol_number: pdf.data('bol_number'),
                pages_number: pdf.data('pages_number'),
                doc_type: pdf.data('doc_type')
            },
            dataType: "json",
            success: function (o) {
                var status = o.status;
                if (status == 1) {
                    console.log('PDF created');
                } else {
                    console.log('PDF not created');
                }
            }

        });
    });

    $('body').on('click', '.refresh-driver', function (evt) {
        refreshDriverPosition();
    });

    $('#createmap').click(function () {
        $("#div1").animate({scrollTop: $(".grid").height()}, 1000);
        $("#map").html('');
        //        setTimeout(function () {
        //
        //            initMap1();
        //        }, 500);
        refreshDriverPosition();
    });
    function refreshDriverPosition() {
        trace_number = 0;
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('load/get_driver_position/' . $driver['idts_driver'] . '/1') ?>',
            async: true,
            data: {
                load_id: '<?php echo $load['idts_load'] ?>',
            },
            dataType: "json",
            success: function (o) {
                var address = o.results[0].formatted_address;
                var lat = o.results[0].geometry.location.lat;
                var lng = o.results[0].geometry.location.lng;
                initMap2(o.trace, lat, lng);
                $('#driver_loc').html(address);
                setTraceTable(o.trace);
            }

        });
    }


    function setTraceTable(trace) {
        var output = '';
        for (var i = 0; i < trace.length; i++) {
            var str_date = trace[i].date;
            var full_date = str_date.split(" ");
            var date = full_date[0].split("-");
            output += '<tr>';
            output += '<td style="text-align: center; width:124px;">' + date[1] + '/' + date[2] + '/' + date[0] + '</td>';
            output += '<td style="text-align: center; width:124px;">' + full_date[1] + '</td>';
            if (trace[i].address_text == null) {
                output += '<td style="text-align: center;"><a class="get_position" style="cursor:pointer" data-id="' + trace[i].idts_load_trace + '" data-lat="' + trace[i].lat + '" data-lng="' + trace[i].lng + '" title="" data-original-title="Popover Header">View Position</a></td>';
            } else {
                output += '<td style="text-align: center;">' + trace[i].address_text + '</td>';
            }
            output += '</tr>';
        }
        $('#trace_table tbody').html(output);
    }

    function getPreviosTraces() {
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('load/get_load_trace/' . $load['idts_load'] . '/1/20') ?>',
            async: true,
            beforeSend: function () {
                $('.loading-bar').show('fast');
            },
            data: {
                start: trace_number
            },
            dataType: "json",
            success: function (o) {
                $('.loading-bar').hide();
                setPreviosTraceTable(o);
            }

        });
        trace_number += 20;
    }

    function setPreviosTraceTable(trace) {
        var output = '';
        for (var i = 0; i < trace.length; i++) {
            var str_date = trace[i].date;
            var full_date = str_date.split(" ");
            var date = full_date[0].split("-");
            output += '<tr>';
            output += '<td style="text-align: center; width:124px;">' + date[1] + '/' + date[2] + '/' + date[0] + '</td>';
            output += '<td style="text-align: center; width:124px;">' + full_date[1] + '</td>';
            if (trace[i].address_text == null) {
                output += '<td style="text-align: center;"><a class="get_position" style="cursor:pointer" data-id="' + trace[i].idts_load_trace + '" data-lat="' + trace[i].lat + '" data-lng="' + trace[i].lng + '" title="" data-original-title="Popover Header">View Position</a></td>';
            } else {
                output += '<td style="text-align: center;">' + trace[i].address_text + '</td>';
            }
            output += '</tr>';
        }
        $('#trace_table tbody').append(output);
    }
function initMap1() {
<?php
$count = count($traces);
$i = 1;
$j = 1;
$url = 'http://maps.google.com/mapfiles/kml/paddle/blu-circle-lv.png';
if ($count >= 1) {
	    foreach ($traces as $trace => $row2) {
        if ($j == 1) {
			$center_lat = $row2['lat'];
			$center_lng = $row2['lng'];	
          }
		 $j++;
		};
	?>


        //        $().html()
        var lat = parseFloat(<?php echo $center_lat; ?>);
        var lng = parseFloat(<?php echo $center_lng; ?>);
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 13,
            center: myLatlng
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
	<?php
    foreach ($traces as $trace => $row) {
        if ($i == 1) {
            $url = 'http://leanstaffing.com/testserver/map-marker-driver.png';
        }
        ?>
                var marker = new google.maps.Marker({
                    //            icon: 'map-marker-driver.png',
                    position: new google.maps.LatLng(<?php echo $row['lat'] ?>, <?php echo $row['lng'] ?>),
                    map: map,
                    icon: '<?php echo $url ?>',
                    title: '<?php echo $row['date'] ?>'
                });
        <?php
        $i++;
    }
} else {
    $url = 'http://leanstaffing.com/testserver/map-marker-driver.png';
    ?>
	        //        $().html()
        var lat = parseFloat(<?php echo $driver['lat']; ?>);
        var lng = parseFloat(<?php echo $driver['lng']; ?>);
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 13,
            center: myLatlng
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
		

            var marker = new google.maps.Marker({
                //            icon: 'map-marker-driver.png',
                position: new google.maps.LatLng(lat, lng),
                map: map,
                icon: '<?php echo $url ?>',
                title: '<?php echo $driver['name'] . ' ' . $driver['last_name'] ?>'
            });
    <?php
}
?>

        google.maps.event.trigger(map, "resize");
    }

    function initMap2(trace, lat, lng) {
        console.log('latitud: ' + lat);
		if (trace.length >= 1){
				var lat = trace[0].lat;
				var lng = trace[0].lng;			
			}else{
				var lat = parseFloat(lat);
				var lng = parseFloat(lng);
				};
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 13,
            center: myLatlng
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        if (trace.length >= 1) {
            for (var i = 0; i < trace.length; i++) {
                var url = 'http://maps.google.com/mapfiles/kml/paddle/blu-circle-lv.png';
                if (i == 0) {
                    url = 'http://leanstaffing.com/testserver/map-marker-driver.png';
                }
                var marker = new google.maps.Marker({
                    //            icon: 'map-marker-driver.png',
                    position: new google.maps.LatLng(trace[i].lat, trace[i].lng),
                    map: map,
                    icon: url,
                    title: trace[i].date
                });
            }
        } else {
            var url = 'http://leanstaffing.com/testserver/map-marker-driver.png';
            var marker = new google.maps.Marker({
                //            icon: 'map-marker-driver.png',
                position: new google.maps.LatLng(lat, lng),
                map: map,
                icon: url,
                title: 'Current Position'
            })
        }
        google.maps.event.trigger(map, "resize");
    }

    function getOriginalShpOptions(pop_doc) {
        var load_id = pop_doc.data('load_id');
        var bol_number = pop_doc.data('bol_number');
        var output = '';
        output += '<div><a href="' + '<?php echo VIEW_FILE_PATH ?>' + load_id + '_bol_' + bol_number + '.pdf" target="_blank">Get pdf</a></div>';
        output += '<div><a class="send_email" data-target="#destinationAddressModal" data-toggle="modal" data-load_id="' + load_id + '" data-bol_number="' + bol_number + '" data-pages_number="" data-doc_type="">Send by email</a></div>';
        return output;
    }

    function getShpPhotos(pop_doc) {
        var id = pop_doc.data('id_customer');
        var load_id = pop_doc.data('load_id');
        var bol_number = pop_doc.data('bol_number');
        var doc_type = pop_doc.data('doc_type');
        var pages_number = pop_doc.data('pages_number');
        var file = load_id + '_bol_' + bol_number + '_' + doc_type + '-';
        if (doc_type == 'sp') {
            $('.shp_document .popover .popover-title').attr('data-original-title', 'Edit shipment Document');
        } else {
            $('.csn_document .popover .popover-title').attr('data-original-title', 'Edit Consignee Document');
        }

        var output = '';
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('load/get_shipment_photos/0/0/1') ?>',
            async: false,
            data: {
                shp_url: file,
                pages_number: pages_number
            },
            dataType: "json",
            success: function (o) {
                var data = o['data'];
                var cont = 1;
                for (var i = 1; i <= pages_number; i++) {
                    if (data[i]) {
                        output += '<div id="cont_' + load_id + bol_number + i + '"><a href="' + '<?php echo VIEW_FILE_PATH ?>' + data[i].url + '" target="_blank">Photo: ' + cont + '</a><span class="del_photo" id="' + load_id + bol_number + i + '" data-load_id="' + load_id + '" data-type="' + doc_type + '" data-bol_number="' + bol_number + '" data-url="' + data[i].url + '" style="cursor:pointer; color: red"> Trash </span></div>';
                    }
                    cont++;
                }
            }

        });
        output += '<div>&nbsp</div>';
        output += '<div>&nbsp</div>';
        output += '<div><a class="dw_pdf" data-load_id="' + load_id + '" data-bol_number="' + bol_number + '" data-pages_number="' + pages_number + '" data-doc_type="' + doc_type + '">Get pdf</a></div>';
        output += '<div><a class="send_email" data-target="#destinationAddressModal" data-toggle="modal" data-load_id="' + load_id + '" data-bol_number="' + bol_number + '" data-pages_number="' + pages_number + '" data-doc_type="' + doc_type + '">Send by email</a></div>';
        return output;
    }

    function setDocPhoto(pop_doc) {
        var id = pop_doc.data('id_customer');
        var load_id = pop_doc.data('load_id');
        var bol_number = pop_doc.data('bol_number');
        var doc_type = pop_doc.data('doc_type');
        var pages_number = pop_doc.data('pages_number');
        var file = load_id + '_bol_' + bol_number + '_' + doc_type + '-';
        var output = '';
        var con = 1;
        var file_path = '';
        var full_file_path = '';
        for (var i = 0; i < pages_number; i++) {
            file_path += file + i + '.jpg';
            full_file_path = '<?php echo VIEW_FILE_PATH ?>' + file_path;
            output += '<div><a href="' + full_file_path + '" target="_blank">Photo: ' + con + '</a><span class="del_photo" data-url="' + file_path + '" > delete </span></div>';
            con++;
            file_path = '';
            full_file_path = '';
        }

        return output;
    }

    function hidePopover(id) {
        console.log(id);
        //        var bol_number = cur_pop.data('bol_number');
        $('#' + id).popover('hide');
        //            popover.('hide');
    }


</script>
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&callback=initMap1" async defer></script>
<!-----------------------END OF   Map, Distance , Time ------------------------------->                            


<style>
    .popover-content ul{
        margin: 0 0 10px 5px;
    }       
    .popover-content ul li{
        list-style: none;
    }
    #signatureparent, #signatureparent2{
        pointer-events:none;
    }
</style>

<script charset="UTF-8">
    var cur_pop;

    $(function () {

		
        $('.lc-row-wrapper').on('scroll', function () {
            console.log('Top: ' + $(this).scrollTop() + ', Height: ' + $(this).innerHeight() + ', scroll: ' + $(this)[0].scrollHeight);
            if ($(this).scrollTop() + $(this).innerHeight() == $(this)[0].scrollHeight) {
                getPreviosTraces();
            }
        })

        $('body').on('click', '.expd', function (evt) {
            evt.preventDefault();
            $('.accordion .accordion-section-content').slideDown(300).addClass('open');

        });

        $('body').on('click', '.cpse', function (evt) {
            evt.preventDefault();
            close_accordion_section();
        });

        function close_accordion_section() {
            $('.accordion .accordion-section-title').removeClass('active');
            $('.accordion .accordion-section-content').slideUp(300).removeClass('open');
        }

        $('.accordion-section-title').click(function (e) {
            // Grab current anchor value
            var currentAttrValue = $(this).attr('href');

            if ($(e.target).is('.active')) {
                close_accordion_section();
            } else {
                close_accordion_section();

                // Add active class to section title
                $(this).addClass('active');
                // Open up the hidden content panel
                $('.accordion ' + currentAttrValue).slideDown(300).addClass('open');
            }

            e.preventDefault();
        });

        $('body').on('click', '.exp-call', function (evt) {
            //            evt.preventDefault();
            //            $('.exp-call').not(this).popover('hide');
            var pop_contact = $(this);
            pop_contact.not(this).popover('hide');
            pop_contact.popover({
                placement: 'right',
                trigger: 'manual',
                html: true,
                //                container: pop_contact,
                //                animation: true,
                title: 'Callcheck Text',
                content: function () {
                    return pop_contact.data('comment');
                }
            }).popover('toggle');
        });
        //Contacts popover
        $('body').on('click', '.pop_or', function (evt) {
            evt.preventDefault();
            var pop_doc = $(this);
            pop_doc.popover({
                placement: 'right',
                trigger: 'manual',
                html: true,
                //                container: pop_doc,
                //                animation: true,
                title: 'Original Documents <button type="button" id="close" class="close" onclick="hidePopover(&quot;' + pop_doc.attr('id') + '&quot;)">&times;</button>',
                content: function () {
                    return getOriginalShpOptions(pop_doc);
                }
            }).popover('toggle');
        });
        //Contacts popover
        $('body').on('click', '.pop', function (evt) {
            evt.preventDefault();
            var pop_doc = $(this);
            pop_doc.popover({
                placement: 'right',
                trigger: 'manual',
                html: true,
                //                container: pop_doc,
                //                animation: true,
                title: 'Edit Shipment Documents<button type="button" id="close" class="close" onclick="hidePopover(&quot;' + pop_doc.attr('id') + '&quot;)">&times;</button>',
                content: function () {
                    return getShpPhotos(pop_doc);
                }
            }).popover('toggle');
        });
        //Contacts popover
        $('body').on('click', '.pop_cs', function (evt) {
            evt.preventDefault();
            var pop_doc = $(this);
            pop_doc.popover({
                placement: 'right',
                trigger: 'manual',
                html: true,
                //                container: pop_doc,
                //                animation: true,
                title: 'Edit Consignee Documents<button type="button" id="close" class="close" onclick="hidePopover(&quot;' + pop_doc.attr('id') + '&quot;)">&times;</button>',
                content: function () {
                    return getShpPhotos(pop_doc);
                }
            }).popover('toggle');
        });
        //Contacts popover
        $('body').on('click', '.del_photo', function (evt) {
            evt.preventDefault();
            var del_file = $(this);
            if (confirm("Confirm delete?")) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('load/delete_photo/0/1/0/0') ?>',
                    async: true,
                    data: {
                        path: del_file.data('url'),
                        bol_number: del_file.data('bol_number'),
                        load_id: del_file.data('load_id'),
                        doc_type: del_file.data('type')
                    },
                    dataType: "json",
                    success: function (o) {
                        var status = o.status;
                        if (status == 1) {
                            var id = del_file.attr('id');
                            $('#cont_' + id).html('');
                        } else {
                            alert(o.msg);
                        }
                    }

                });
            }
        });
        //Contacts popover
        $('body').on('click', '.dw_pdf', function (evt) {
            evt.preventDefault();
            var pdf = $(this);
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('load/create_pdf/0/0/0/0/1') ?>',
                async: true,
                data: {
                    load_id: pdf.data('load_id'),
                    bol_number: pdf.data('bol_number'),
                    pages_number: pdf.data('pages_number'),
                    doc_type: pdf.data('doc_type')
                },
                dataType: "json",
                success: function (o) {
                    var status = o.status;
                    if (status == 1) {
                        var win = window.open(o.url, '_blank');
                        win.focus();
                    } else {
                        alert('Failed opening pdf.');
                    }
                }

            });
        });
        $('#commentForm').submit(function (evt) {
            evt.preventDefault();
            if ($('input[name="sw_not_driver"]:checked').length > 0) {
                sendPushNot();
            } else {
                saveNotinDB();
            }
        });
        //------------- send the BOL by email --------------------------------

        $('body').on('click', '#btn_send_bol', function (evt) {
            evt.preventDefault();
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('load/send_bol') ?>',
                async: true,
                data: {
                    email: $('#email').val(),
                    load_number: '<?php echo $load['load_number'] ?>',
                    load_id: '<?php echo $load['idts_load'] ?>',
                    bol_number: $('#bol_number_mail').val(),
                    doc_type: $('#doc_type').val()
                },
                dataType: "json",
                success: function (o) {
                }
            });
        });
        $('#styled_message').keydown(function (evt) {

            if (evt.keyCode == 13) {
                if ($('input[name="sw_not_driver"]:checked').length > 0) {
                    sendPushNot();
                } else {
                    saveNotinDB();
                }
            }

        });
        setInterval(getChat, 10000);
        function getChat() {
            var url = '<?php echo site_url('load/get_chat/' . $load['idts_load'] . '/1') ?>';
            var postData = {
                date: $('#last_date').val()
            };
            $.post(url, postData, function (o) {
                var output = '';
                var name = '';
                for (var i = 0; i < o.length; i++) {
                    var msg = o[i];
                    if (msg.driver_sw == 0) {
                        var ms_style = '#FFFFFF';
                        name = msg.user_login;
                    } else {
                        var ms_style = '#D8D8D8';
                        name = msg.driver_name + ' ' + msg.driver_last_name;
                    }

                    var date = msg.date.split(' ');
                    var ymd = date[0].split('-');
                    output += '<tr style="background-color:' + ms_style + '"><td style="text-align: center; width:100px">' + ymd[1] + '/' + ymd[2] + '/' + ymd[0] + '</td><td style="text-align: center; width:100px">' + date[1] + '</td><td style="text-align: center;">' + msg.city + '</td><td style="text-align: center;">' + msg.state + '</td><td style="text-align: center; width:239px"><div class="notes" style="float:left">' + msg.comment + '</div><a class="set-callcheck" data-note="' + msg.comment + '" hidefocus="true" style="outline: medium none;margin: 0px 5px;" data-toggle="modal" data-target="#callcheckViewModal">view</a></td><td style="text-align: center;">' + name + '</td></tr>';
                }
                $('#callcheck_table tbody').html('');
                $('#callcheck_table tbody').append(output);
                var chat = $('#chat_load');
                chat.scrollTop();
                //                chat.animate({ scrollTop: chat[0].scrollHeight}, 1000);

                //                console.log('scrollTop: ' + chat.scrollTop());

            }, 'json');
        }

        //adds highlight when clicked
        $('#list_load tbody tr').on('click', function (event) {
            $(this).addClass('highlight').siblings().removeClass('highlight');
        });
        //Inicialize popover
        $('body').on('click', '.po', function (evt) {
            evt.preventDefault();
            var load_id = $(this).data('load_id');
            var editHtml = '<ul><li data-load_edit="' + load_id + '">Edit</li></ul>';
            //            $('#abc').append(editHtml);
            var popover = $(this).attr('id');
            $('#popover_content ul li a.editLink').attr('href', 'load/update/' + popover)

            $(this).popover({
                "trigger": "manual",
                "html": "true",
                "title": 'Load Options # ' + $(this).html() + '<span style="margin-left:15px;" class="pull-right"><a href="#" onclick="$(&quot;#' + popover + '&quot;).popover(&quot;toggle&quot;);" class="text-danger popover-close" data-bypass="true" title="Close"><i class="fa fa-close"></i>X</a></span>',
                "content": $('#popover_content').html()
                        //                "content":'<ul><li><a data-id="4" title="Edit this Load" href="load/update/'+popover+'"><i class="icon-pencil"></i> Edit</a> </li></ul>'
            });
            $(this).popover('toggle');
        });
    });
    function sendPushNot() {
        if ($('textarea#styled_message').val() == '') {
            alert('Message can not be null');
            return false;
        }
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('load/push_not_custom_msg_load') ?>',
            async: true,
            beforeSend: function () {
                $('.loading').show();
            },
            data: {
                android_title: "Smith Track'n Go",
                driver_id: '<?php echo $driver['idts_driver'] ?>',
                app_id: '<?php echo $driver['app_id'] ?>',
                apns_number: '<?php echo $driver['apns_number'] ?>',
                load_id: '<?php echo $load['idts_load']; ?>',
                driver_latitud: '<?php echo $load['driver_latitud']; ?>',
                driver_loingitude: '<?php echo $load['driver_longitud']; ?>',
                driver_mail: '<?php echo $driver['email']; ?>',
                load_number: '<?php echo $load['load_number']; ?>',
                msg: 'Msg load #' + '<?php echo $load['load_number']; ?>' + ' - ' + $('textarea#styled_message').val()
            },
            dataType: "json",
            success: function (data) {
                $('.loading').hide();
                if (data['status'] == 1) {
                    $('#register_form_error').hide();
                    var o = data['dbresult'];
                    saveMsg(o.date, o.time, o.city, o.state, o.comment, o.entered_by);
                    $('#styled_message').val('');
                } else {
                    $('#register_form_error').html(data['msg']);
                    $('#register_form_error').show();
                    $('#styled_message').val('');
                }

            }
        });
    }

    function saveNotinDB() {
        var user_id = '<?php echo $user_id; ?>';
        var load_id = '<?php echo $load['idts_load']; ?>';
        var type = '1';
        var driver = '0';
        var notify_driver = '0';
        if ($('input[name="sw_not_driver"]:checked').length > 0) {
            notify_driver = '1';
        }

        $.ajax({
            type: "POST",
            url: '<?php echo site_url('load/save_callcheck') ?>/' + user_id + '/' + load_id + '/1/0',
            async: true,
            data: {
                comment: $('textarea#styled_message').val(),
                driver_latitud: '<?php echo $load['driver_latitud']; ?>',
                driver_loingitude: '<?php echo $load['driver_longitud']; ?>',
                notify_driver: notify_driver,
                driver_email: '<?php echo $driver['email']; ?>',
                load_number: '<?php echo $load['load_number']; ?>',
            },
            dataType: "json",
            success: function (o) {
                $("#saletbl tr:last-child").focus()
                saveMsg(o.date, o.time, o.city, o.state, o.comment, o.entered_by);
                $('textarea').val('');
            }

        });
    }

    function saveMsg(date, time, city, state, comment, user) {
        var subject = $('#subject').val();
        var msg = $('textarea#styled_message').val();
        var user = '<?php echo $login; ?>';
        //        var output = '<div><b class="subject">' + user + ':</b><br>' + msg + '</div>';
        var output = '<tr><td style="text-align: center; width:100px">' + date + '</td><td style="text-align: center; width:100px">' + time + '</td><td style="text-align: center;">' + city + '</td><td style="text-align: center;">' + state + '</td><td style="text-align: center; width:100px"><div class="notes" style="float:left">' + comment + '</div><a class="set-callcheck" data-note="' + comment + '" hidefocus="true" style="outline: medium none;margin: 0px 5px;" data-toggle="modal" data-target="#callcheckViewModal">view</a></td><td style="text-align: center; width:100px">' + user + '</td></tr>';
        $('#callcheck_table tbody').append(output);
        //clear form
        //            $('#subject').val('');
        //            $('textarea#styled_message').val('');
        $("#div1").animate({scrollTop: $('#div1')[0].scrollHeight}, 1000);
    }

    function reloadBol(evt) {
        //        evt.preventDefault();
        //        $('#if_bol').contentDocument.location.reload(true);
        console.log(document.getElementById('if_bol').src);
        document.getElementById('if_bol').src = document.getElementById('if_bol').src;
    }

</script>