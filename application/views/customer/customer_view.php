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
            <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('customer/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/customers-bt-w.png" style=" width:40px; height:40px; margin-top:10px" alt="View All Loads"></a></div>
            <div class="loads-title" id="category-title" style="height: 32px;padding-top: 15px;"><h2 style="font-weight: 600;letter-spacing: 1px;padding-right: 5px;">CUSTOMERS</h2></div>
            <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('customer/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All Loads"></a></div>            

            <?php
            if (in_array("customer/add", $roles)) {
                ?>
                <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('customer/add'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" alt="Add a Load"></a></div>
            <?php } ?>             

            <div id="category-button"></div>
            <div id="category-search" class="search-customer"></div>
            <div id="category-search" class="search-carrier"></div>
            <div id="category-search" class="search-loads"></div>
        </div>

        <div class="table-responsive">
            <table id="list_load" class="table table-hover table-bordered table-striped">
                <thead>
                    <tr style="background-color: #EBEBEB">
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>                        
                        <?php echo in_array('customer/edit', $roles) || in_array('customer/trash', $roles) ? '<th>Actions</th>' : ''; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($customers as $customer => $row) {
                        $country = '';
                        switch ($row['country']) {
                            case 1:
                                $country = 'USA';
                                break;
                            case 2:
                                $country = 'Canada';
                                break;
                            default:
                                echo "Your favorite color is neither red, blue, nor green!";
                        }
                        echo '<tr id="customer_' . $row['idts_customer'] . '">';
                        echo '<td>' . $i++ . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['phone'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td>' . $row['address'] . '</td>';
                        echo '<td>' . $row['city'] . '</td>';
                        echo '<td>' . $row['state'] . '</td>';
                        echo '<td>' . $country . '</td>';
                        echo in_array('customer/edit', $roles) || in_array('customer/trash', $roles) ? '<td>' : '';
                        echo in_array('customer/edit', $roles) ? '<a href="customer/edit/' . $row['idts_customer'] . '">Edit</a>' : '';
                        echo in_array('customer/trash', $roles) ? '&nbsp; <a id="' . $row['idts_customer'] . '" class="trash">Trash</a>' : '';
                        echo in_array('customer/edit', $roles) || in_array('customer/trash', $roles) ? '</td>' : '';
                        echo '</tr>';
                    }
                    ?>
                </tbody>

            </table>
        </div>

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
    </div>
</div>

<!-- Hidden content -->

<div id="popover_content" style="display: none">
    <ul>
        <li><a data-id="4" class="editLink" title="Edit this Load" href=""><i class="icon-pencil"></i> Edit</a></li>
        <li><a data-id="4" class="editLink" title="Send message to driver" href=""><i class="icon-user"></i> Send Message</a></li>
        <li></li>
    </ul>
</div>
<style>
    .popover-content ul{
        margin: 0 0 10px 5px;
    }       
    .popover-content ul li{
        list-style: none;
    }       
</style>

<script>
    $(function () {
        $('#list_load tbody tr').on('click', function (event) {
            $(this).addClass('highlight').siblings().removeClass('highlight');
        });

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

        $('body').on('click', '.trash', function (evt) {
            evt.preventDefault();
            var customer = $(this);
            var id = customer.attr('id');
            var r = confirm("Confirm trashing customer?");

            if (r == true) {
                $.ajax({
                    type: "POST",
                    url: 'customer/change_status/' + id + '/' + 0,
                    async: true,
                    dataType: "json",
                    beforeSend: function () {
                        $('#result_destination').html('Loading...');
                        $('#result_destination').show();
                    },
                    success: function (data) {
                        if (data.status == 1) {
                            $('#customer_' + id).remove();
                            console.log('customer deleted');
                        } else {
                            alert('User could not be trashed. Please contact administrator.');
                        }
                    }
                });
            }

        });

    });

</script>