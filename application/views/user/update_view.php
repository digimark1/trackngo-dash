<div id="category-actions">
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('user/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/users-bt-w.png" style=" width:40px; height:40px; margin-top:10px" alt="View All Loads"></a></div>
    <div class="loads-title" id="category-title" style="height: 32px;padding-top: 15px;"><h2 style="font-weight: 600;letter-spacing: 1px;padding-right: 5px;">USERS</h2></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('user/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All Loads"></a></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('user/add'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" alt="Add a Load"></a></div>
    <div id="category-button"></div>
    <div id="category-search" class="search-customer"></div>
    <div id="category-search" class="search-carrier"></div>
    <div id="category-search" class="search-loads"></div>
</div>
<div class="row">
    <div class="span6 offset2">
        <div id="register_form_error" class="alert alert-error"><!-- Dynamic --></div>
        <form id="register_form" class="form-horizontal" method="POST" action="<?php echo site_url('user/update') ?>">

            <div class="text-right"><h3>Edit user</h3></div>
            <input type="hidden" name="company" class="input-xlarge" value="1" />
            <input type="hidden" name="status" class="input-xlarge" value="1" />
            <input type="hidden" name="id" class="input-xlarge" value="<?php echo $user_edit['iduser'] ?>" />

            <?php if ($user_edit['iduser'] != 1) { ?>

                <div class="control-group">
                    <label class="control-label">Reports to:</label>
                    <div class="controls">
                        <select class="selectpicker" name="reports_to">
                            <?php
                            foreach ($users as $user => $row) {
                                if ($row['iduser'] != $user_edit['iduser']) {
                                    $selected = '';
                                    if ($row['iduser'] == $user_edit['user_iduser']) {
                                        $selected = 'selected="selected"';
                                    }
                                    echo '<option ' . $selected . ' value="' . $row['iduser'] . '">' . $row['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>    
            <?php } ?>

            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    <input type="text" name="name" class="input-xlarge" value="<?php echo $user_edit['name'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Phone</label>
                <div class="controls">
                    <input type="text" name="phone" class="input-xlarge" value="<?php echo $user_edit['phone'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Login</label>
                <div class="controls">
                    <input type="text" name="login" class="input-xlarge" value="<?php echo $user_edit['login'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                    <input type="text" name="email" class="input-xlarge" value="<?php echo $user_edit['email'] ?>"/>
                </div>
            </div>

            <!--            <div class="control-group">
                            <label class="control-label">View same lever user loads</label>
                            <div class="controls">
                                <select class="selectpicker" name="brother" style="width:80px">
            <?php
            $selected = 'selected="Selected"';
            if ($user_edit['brother'] == 1) {
                echo '<option value="1" ' . $selected . '>Yes</option>';
                echo '<option value="0">No</option>';
            } else {
                echo '<option value="1">Yes</option>';
                echo '<option value="0" ' . $selected . '>No</option>';
            }
            ?>
                                </select>
                            </div>
                        </div>-->
            <div class="role_title">Roles</div>
            <div style="margin: 10px 0px;"><label><input type="checkbox" id="selecctall"> Select/Deselect All</label></div>
            <div class="control-group">
                <?php
                foreach ($all_roles as $all_role => $row) {
                    $checked = '';
                    foreach ($user_edit_roles as $user_edit_role => $row2) {
                        if ($row['idrole'] == $row2['role_idrole']) {
                            $checked = 'checked';
                        }
                    }
                    ?>
                    <div class="checkbox">
                        <label><input type="checkbox" class="checkbox1" name="role[]" <?php echo $checked ?> value="<?php echo $row['idrole'] ?>"><?php echo $row['name'] ?></label>
                    </div>                
                    <?php
                }
                ?>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-red btn-small" hidefocus="true" style="outline: medium none;"><span class="gradient">Save</span></button>
                    <button onclick="location.href = '<?php echo site_url('/user') ?>';" style="border-radius: 16%; height: 25px;">Cancel</button>
<!--                    <input type="submit" value="Register" class="btn btn-primary" />
                    <a class="btn" href="<?php echo site_url('/') ?>">Cancel</a>-->
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    .checkbox{
        width: 150px;
        float: left;        
    }
    .role_title{
        font-size: large;
        margin-bottom: 10px;
    }  
</style>
<script>
    $(function () {
        $("#register_form_error").hide();
        $('#register_form').submit(function (evt) {
            evt.preventDefault();
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            $.post(url, postData, function (o) {
                if (o.result == 1) {
                    window.location.href = '<?php echo site_url('user') ?>';
                } else {
                    $("#register_form_error").show();
                    var output = '<ul>';
                    for (var key in o.error) {
                        var value = o.error[key];
                        output += '<li>' + value + '</li>';
                    }
                    output += '</ul>';
                    $("#register_form_error").html(output);
                }
            }, 'json');
        });

        $("#selecctall").change(function () {
            $(".checkbox1").prop('checked', $(this).prop("checked"));
        });

    });
</script>