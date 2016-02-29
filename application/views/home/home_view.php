<div class="row">
    <div class="span6 offset6" style="margin: 0 0 50px 370px;">
        <div class="logo"></div>
    </div>
    <div class="span6 offset2">
        <form id="login_form" class="form-horizontal" method="POST" action="<?php echo site_url('user/login')?>">

        <div class="control-group">
            <label class="control-label">Login</label>
            <div class="controls">
                <input type="text" name="login" class="input-xlarge" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Password</label>
            <div class="controls">
                <input type="password" name="password" class="input-xlarge" />
            </div>
        </div>    

        <div class="control-group">
            <div class="controls">
                <input type="submit" value="Login" class="btn btn-primary" style="float: right;"/>
            </div>
        </div>      
    </form>
        
    </div>
</div>
<script>
    $(function(){
        $('#login_form').submit(function(evt){
            evt.preventDefault();
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            
            $.post(url, postData, function(o){
                if(o.result == 1){
                    window.location.href = '<?php echo site_url('load') ?>';
                }else{
                    alert('Invalid login');
                }
            },'json');
        });
    });
</script>