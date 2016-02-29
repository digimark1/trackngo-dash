<div class="row">
    <div class="span6 offset2">
        <div id="register_form_error" class="alert alert-error"><!-- Dynamic --></div>
        <form id="register_form" class="form-horizontal" method="POST" action="<?php echo site_url('user/register') ?>">

            <div class="text-right"><h3>Register user</h3></div>
            <div class="control-group">
                <label class="control-label">Company</label>
                <div class="controls">
                    <select class="selectpicker" name="company">
                        <option value="1">Smith Transportation</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    <input type="text" name="name" class="input-xlarge"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Phone</label>
                <div class="controls">
                    <input type="text" name="phone" class="input-xlarge"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Login</label>
                <div class="controls">
                    <input type="text" name="login" class="input-xlarge" placeholder="nlastname"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                    <input type="text" name="email" class="input-xlarge"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Status</label>
                <div class="controls">
                    <select class="selectpicker" name="status">
                        <option value="1">Active</option>
                        <option value="0">Block</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                    <input type="password" name="password" class="input-xlarge"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Confirm Password</label>
                <div class="controls">
                    <input type="password" name="confirm_password" class="input-xlarge"/>
                </div>
            </div>


            <div class="control-group">

                <div class="checkbox">
                    <label><input type="checkbox" name="role[]" value="1"> Load</label>
                </div>

                <div class="checkbox">
                    <label><input type="checkbox" name="role[]" value="2"> Carrier</label>
                </div>

                <div class="checkbox">
                    <label><input type="checkbox" name="role[]" value="3"> User</label>
                </div>

                <div class="checkbox">
                    <label><input type="checkbox" name="role[]" value="4"> Customer</label>
                </div>

                <div class="checkbox">
                    <label><input type="checkbox" name="role[]" value="5"> Tender load</label>
                </div>     

                <div class="checkbox">
                    <label><input type="checkbox" name="role[]" value="6"> Tracking</label>
                </div>     

            </div>


            <div class="control-group">
                <div class="controls">
                    <input type="submit" value="Register" class="btn btn-primary" />
                    <a class="btn" href="<?php echo site_url('/') ?>">Cancel</a>
                </div>
            </div>      
        </form>        
    </div>
</div>
<script>
    $(function () {
        $("#register_form_error").hide();
        $('#register_form').submit(function (evt) {
            evt.preventDefault();
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            $.post(url, postData, function (o) {
                if (o.result == 1) {
                    window.location.href = '<?php echo site_url('/') ?>';
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
    });
</script>