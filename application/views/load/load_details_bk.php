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
    $items = $load['items'];
    ?>
    <div id="list_user">
        <span class="ajax-loader-gray"></span>
    </div>
    <div id="category-actions">
        <div class="loads-title" id="category-title"><img src="<?php echo base_url() ?>/public/img/images/loads-title.png" width="100" height="70" alt="Loads Category"></div>
        <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All Loads"></a></div>
        <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/add2'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" alt="Add a Load"></a></div>
    </div>    
    <div class="text-left"><h1>Load Details #<?php echo $load['load_number'] ?></h1></div>

    <div class="container container-wide">

        <div class="content" role="main" style="padding:0px">
            <div class="row">
                <div class="tabs_framed styled">
                    <ul class="tabs clearfix tab_id2 bookmarks3 active_bookmark1">
                        <li class="first active"><a href="#about" data-toggle="tab" hidefocus="true" style="outline: none;">VIEW BOL</a></li>
                        <li><a id="createmap" href="#mapdrive" data-toggle="tab" hidefocus="true" style="outline: none;">TRACKING MAP</a></li>
                    </ul>

                    <div class="tab-content boxed clearfix">
                        <div class="tab-pane fade active in" id="about">
                            <div class="inner clearfix">

                                <a style="width:200px;" href="../../../tkgo_files/<?php echo $load['load_number'] ?>.pdf" class="btn" download="w3logo" hidefocus="true"><span class="gradient">DOWNLOAD</span></a>
                                <a class="btn" href="#" hidefocus="true"><span class="gradient" data-toggle="modal" data-target="#destinationAddressModal">Send by e-mail</span></a>
                                <a class="btn" href="#" onclick="reloadBol()" hidefocus="true"><span class="gradient">Refresh BOL</span></a>

                                <iframe width="100%" height="600" id="if_bol" style="margin-top:15px" src="../../../tkgo_files/<?php echo $load['load_number'] ?>.pdf"></iframe>

                            </div>

                        </div>

                        <div class="tab-pane fade" id="mapdrive">
                            <div class="inner clearfix">


                                <div class="widget-container widget_categories boxed">
                                    <h4 class="widget-title">MAP</h4>
                                    <div id="map_wrapper">
                                        <div class="widget-container widget_categories boxed">
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-container widget_categories boxed">
                                    <h4 class="widget-title">CURRENT DRIVER LOCATION</h4>
                                    <div style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px">
                                        <div id="driver_loc"><?php echo $load['driver_address'] ?></div>
                                    </div>  
                                </div>

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
                                                                            <td style="width:90px">Date</td>
                                                                            <td style="width:90px">time</td>
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
                                                                            $date_formated = $date_formated_temp[1] . '/' . $date_formated_temp[0] . '/' . $date_formated_temp[2];

                                                                            if ($row['date']) {
                                                                                echo'<tr style="background-color: ' . $ms_style . '">'
                                                                                . '<td style="text-align: center; width:90px">' . $date_formated . '</td>'
                                                                                . '<td style="text-align: center; width:90px">' . $date[1] . '</td>'
                                                                                . '<td style="text-align: center;">' . $row['city'] . '</td>'
                                                                                . '<td style="text-align: center;">' . $row['state'] . '</td>'
                                                                                . '<td style="text-align: center;width:239px"><div class="notes">' . $row['comment'] . '</div></td>'
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
                                                    <div class="field_text field_textarea">
                                                        <label for="styled_message" class="label_title">Message</label>
                                                        <textarea cols="30" rows="10" name="styled_message" id="styled_message" placeholder="Leave your message here" class="textarea textarea_middle required" hidefocus="true" style="outline: none;height:70px;"></textarea>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>

                                                <div class="rowSubmit clearfix" style="padding:0px 0px;">
                                                    <div class="input_styled checklist">
                                                        <div class="rowCheckbox checkbox-filled"><!--<div class="custom-checkbox"><input name="save" type="checkbox" checked="" id="save" value="save" hidefocus="true" style="outline: none;"><label for="save" class="checked">&nbsp;</label></div>--></div>
                                                    </div>
                                                    <span style="float:left; padding-left: 15px"><input type="checkbox" name="sw_not_driver" id="ntfy_driver" value=""> Notify Driver</span>
                                                    <span class="btn"><input type="submit" id="send" value="Send Message" hidefocus="true" class="gradient" style="outline: none;"></span>
                                                </div>
                                            </form>
                                        </div>
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
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn_send_bol" data-dismiss="modal">Send</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

    .row-wrapper {
        position: absolute;
        top: 0;
        height: 100%;
        width: 100%;
        box-sizing: border-box;
        overflow: auto;
        padding-top: 19px;
    }

    .header td{
        font-size: large;
        text-align: center;
    }

    .header td, .rows td {
        width: 138px;
        text-overflow: ellipsis;
        white-space: nowrap;
        border: 1px solid;
    }

    .notes{
        overflow-x: hidden;
        width: 216px;
    }

    .modal {
        width: 610px;
        overflow-y: auto;
        overflow-x: auto;
        height: 280px;
    }
</style>
<!-- Hidden content -->


<!----------------------- Map, Distance , Time ------------------------------->
<script>
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
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('load/get_driver_position/' . $driver['idts_driver'] . '/1') ?>',
            async: true,
            data: {
                load_id: '<?php echo $load['idts_load'] ?>'
            },
            dataType: "json",
            success: function (o) {
                var address = o.results[0].formatted_address;
                var lat = o.results[0].geometry.location.lat;
                var lng = o.results[0].geometry.location.lng;
                initMap2(o.trace, lat, lng);
                $('#driver_loc').html(address)
            }

        });
    }


    function initMap1() {

//        $().html()
        var lat = parseFloat(<?php echo $driver['lat']; ?>);
        var lng = parseFloat(<?php echo $driver['lng']; ?>);
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 13,
            center: myLatlng
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

<?php
$count = count($traces);
$i = 1;
$url = 'http://maps.google.com/mapfiles/kml/paddle/blu-circle-lv.png';
if ($count >= 1) {
    foreach ($traces as $trace => $row) {
        if ($count == $i) {
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

        var lat = parseFloat(lat);
        var lng = parseFloat(lng);
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 13,
            center: myLatlng
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        if (trace.length >= 1) {
            for (var i = 0; i < trace.length; i++) {
                var url = 'http://maps.google.com/mapfiles/kml/paddle/blu-circle-lv.png';
                if (i == trace.length - 1) {
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
    $(function () {
//------------- send the BOL by email --------------------------------

        $('body').on('click', '#btn_send_bol', function (evt) {
            evt.preventDefault();
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('load/send_bol') ?>',
                async: true,
                data: {
                    email: $('#email').val(),
                    load_number: '<?php echo $load['load_number'] ?>'
                },
                dataType: "json",
                success: function (o) {

                }
            });
        });

        $(document).ready(function () {
            var $sigdiv = $("#signature").jSignature({'UndoButton': true})

            var strval = '<?php echo $load['origin_sign'] ?>';
            //print signature        
            var sigData = $("#signature").jSignature("setData", "data:" + strval);



            var $sigdiv = $("#signature2").jSignature({'UndoButton': true})

            var strval = '<?php echo $load['destination_sign'] ?>';
            //print signature        
            var sigData = $("#signature2").jSignature("setData", "data:" + strval);

        });


        $(document).keypress(function (e) {
            if (e.which == 13) {
                $('#commentForm').submit(function (evt) {
                    evt.preventDefault();
                    if ($('input[name="sw_not_driver"]:checked').length > 0) {
                        sendPushNot();
                    } else {
                        saveNotinDB();
                    }
                });
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

                    output += '<tr style="background-color:' + ms_style + '"><td style="text-align: center; width:90px">' + ymd[1] + '/' + ymd[0] + '/' + ymd[2] + '</td><td style="text-align: center; width:90px">' + date[1] + '</td><td style="text-align: center;">' + msg.city + '</td><td style="text-align: center;">' + msg.state + '</td><td style="text-align: center; width:239px"><div class="notes">' + msg.comment + '</div></td><td style="text-align: center;">' + name + '</td></tr>';

                }
                $('#callcheck_table tbody').html('');
                $('#callcheck_table tbody').append(output);
                var chat = $('#chat_load');
                chat.scrollTop();
//                chat.animate({ scrollTop: chat[0].scrollHeight}, 1000);

//                console.log('scrollTop: ' + chat.scrollTop());

            }, 'json');
        }

        $('#commentForm').submit(function (evt) {
            evt.preventDefault();
            if ($('input[name="sw_not_driver"]:checked').length > 0) {
                sendPushNot();
            } else {
                saveNotinDB();
            }
        });

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
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('load/send_push_not') ?>',
            async: true,
            data: {
                title: $('#subject').val(),
                app_id: '<?php echo $driver['app_id'] ?>',
                apns_number: '<?php echo $driver['apns_number'] ?>',
                load_id: '<?php echo $load['idts_load']; ?>',
                driver_latitud: '<?php echo $load['driver_latitud']; ?>',
                driver_loingitude: '<?php echo $load['driver_longitud']; ?>',
                driver_mail: '<?php echo $driver['email']; ?>',
                load_number: '<?php echo $load['load_number']; ?>',
                msg: $('textarea#styled_message').val()
            },
            dataType: "json",
            success: function (o) {
                saveMsg(o.date, o.time, o.city, o.state, o.comment, o.entered_by);
                $('textarea').val('');
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
        var output = '<tr><td style="text-align: center; width:100px">' + date + '</td><td style="text-align: center; width:100px">' + time + '</td><td style="text-align: center;">' + city + '</td><td style="text-align: center;">' + state + '</td><td style="text-align: center; width:100px">' + comment + '</td><td style="text-align: center; width:100px">' + user + '</td></tr>';

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