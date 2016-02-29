<div class="row">

    <div id="dashboard-main" class="span12">
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
            <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('user/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/users-bt-w.png" style=" width:40px; height:40px; margin-top:10px" alt="View All Loads"></a></div>
            <div class="loads-title" id="category-title" style="height: 32px;padding-top: 15px;"><h2 style="font-weight: 600;letter-spacing: 1px;padding-right: 5px;">USERS</h2></div>
            <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('user/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All Loads"></a></div>

            <?php
            if (in_array("user/add", $roles)) {
                ?>
                <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('user/add'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" alt="Add a Load"></a></div>
            <?php } ?>                 

            <div id="category-button"></div>
            <div id="category-search" class="search-customer"></div>
            <div id="category-search" class="search-carrier"></div>
            <div id="category-search" class="search-loads"></div>
        </div>
        <div><h2>Trashed Users</h2></div>

        <div class="table-responsive">
            <table id="list_user" class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                    <tr style="background-color: #EBEBEB">
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Login</th>
                        <th>Reports to</th>
                        <?php echo in_array('user/edit', $roles) || in_array('user/trash', $roles) ? '<th>Actions</th>' : ''; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($users as $user => $row) {
                        if ($row['login'] == 'admin')
                            continue;
                        echo '<tr id="user_' . $row['iduser'] . '">';
                        echo '<td>' . $i++ . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['phone'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td>' . $row['login'] . '</td>';
                        echo '<td>' . $row['parent'] . '</td>';
                        echo in_array('user/edit', $roles) || in_array('user/trash', $roles) ? '<td>' : '';
                        echo in_array('user/trash', $roles) ? '&nbsp; <a id="' . $row['iduser'] . '" class="trash">Enable</a>' : '';
                        echo in_array('user/edit', $roles) || in_array('user/trash', $roles) ? '</td>' : '';
                        echo '</tr>';
                    }
                    ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<script>
    $(function () {
        $('#list_user tbody tr').on('click', function (event) {
            $(this).addClass('highlight').siblings().removeClass('highlight');
        });

        //Set drop model vars
        $('body').on('click', '.trash', function (evt) {
            evt.preventDefault();
            var user = $(this);
            var id = user.attr('id');
            var r = confirm("Confirm enabling user?");

            if (r == true) {
                $.ajax({
                    type: "POST",
                    url: 'change_status/' + id+'/'+1,
                    async: true,
                    dataType: "json",
                    beforeSend: function () {
                        $('#result_destination').html('Loading...');
                        $('#result_destination').show();
                    },
                    success: function (data) {
                        if (data.status == 1) {
                            $('#user_' + id).remove();
                            console.log('user deleted');
                        } else {
                            alert('User could not be trashed. Please contact administrator.');
                        }
                    }
                });
            }

        });

        /*     $('body').on('click', '.po', function (evt) {
         evt.preventDefault();
         //            $('#abc').append(editHtml);
         var id_carrier = $(this).attr('id');
         $('#popover_content ul li a.viewDriversLink').attr('href', 'driver/carrier_drivers/' + id_carrier);
         
         $(this).popover({
         "trigger": "manual",
         "html": "true",
         "title": 'Carrier Options: ' + $(this).html() + '<span style="margin-left:15px;" class="pull-right"><a href="#" onclick="$(&quot;#' + id_carrier + '&quot;).popover(&quot;toggle&quot;);" class="text-danger popover-close" data-bypass="true" title="Close"><i class="fa fa-close"></i>X</a></span>',
         "content": $('#popover_content').html()
         //                "content":'<ul><li><a data-id="4" title="Edit this Load" href="load/update/'+popover+'"><i class="icon-pencil"></i> Edit</a> </li></ul>'
         });
         $(this).popover('toggle');
         
         });*/

    });

</script>