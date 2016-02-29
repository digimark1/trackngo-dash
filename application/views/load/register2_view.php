<div id="category-actions">
    <div class="loads-title" id="category-title"><img src="<?php echo base_url() ?>/public/img/images/loads-title.png" width="100" height="70" alt="Loads Category"></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All Loads"></a></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/add2'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" alt="Add a Load"></a></div>
</div>  
<div class="container">
    <div class="row">
        <div class="container">
            <div class="span6 offset2">
                <h2>Load #<?php echo $last_load['load_number'] + 1 ?></h2>
                <?php echo $error; ?>
                <?php $attributes = array('id' => 'register3_form'); ?>

                <?php echo form_open_multipart('load/do_upload', $attributes); ?>
                <input type="hidden" name="load_number" value="<?php echo $last_load['load_number'] + 1 ?>" />

                <div class="control-group">
                    <label class="control-label">Customer</label>
                    <div class="controls">
                        <select class="selectpicker" name="customer">
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

                <div class="control-group">
                    <label class="control-label">BOL#</label>
                    <div class="controls">
                        <input type="text" name="bol_number" class="smallinput" id="or_latest" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Upload BOL</label>
                    <div class="controls">
                        <input type="file" name="userfile" id="userfile" size="20" />
                    </div>
                </div>
                
                <div class="control-group">                    
                    <div class="controls">
                        <input type="checkbox" name="bol_number" class="smallinput" id="or_latest" />
                    </div>
                </div>                

                <br /><br />
                <button type="submit" class="btn btn-red btn-small" hidefocus="true" style="outline: medium none;"><span class="gradient">Save</span></button>                    
                <button id="btn_cancel" style="border-radius: 16%; height: 25px;">Cancel</button>
                </form> 
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        $('body').on('click', '#btn_cancel', function (evt) {
            evt.preventDefault();
            location.href = '<?php echo site_url('/load') ?>';
        });

        $('#upload_file').submit(function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            $("#userfile").AjaxFileUpload({
                url: url, secureuri: false,
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


        $('#register2_form').submit(function (evt) {
            evt.preventDefault();
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            var formData = new FormData($('form')[0]);

            $.ajax({
                type: "POST", url: url,
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
</script>