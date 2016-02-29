<div id="category-actions">
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('carrier/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/carriers-bt-w.png" style=" width:40px; height:40px; margin-top:10px" alt="View All Loads"></a></div>
    <div class="loads-title" id="category-title" style="height: 32px;padding-top: 15px;"><h2 style="font-weight: 600;letter-spacing: 1px;padding-right: 5px;">CARRIERS</h2></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('carrier/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All Loads"></a></div>

    <?php
    if (in_array("carrier/add", $roles)) {
        ?>
        <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('carrier/add'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" alt="Add a Load"></a></div>
    <?php } ?> 


    <div id="category-button"></div>
    <div id="category-search" class="search-customer"></div>
    <div id="category-search" class="search-carrier"></div>
    <div id="category-search" class="search-loads"></div>
</div>
<div>
    <div id="dashboard-main">

        <div id="list_user">
            <span class="ajax-loader-gray"></span>
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
                        <th>MC#</th>
                        <?php echo in_array('carrier/edit', $roles) || in_array('carrier/trash', $roles) ? '<th>Actions</th>' : ''; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($carriers as $carriers => $row) {

                        echo '<tr id="carrier_' . $row['idts_carrier'] . '">';
                        echo '<td>' . $i++ . '</td>';
//                        echo '<td><a href="#" id="' . $row['idts_carrier'] . '" data-toggle="popover" class="po" data-load_id="' . $row['idts_carrier'] . '">' . $row['name'] . '</a></td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['phone'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td>' . $row['address'] . '</td>';
                        echo '<td>' . $row['scac'] . '</td>';
                        echo in_array('carrier/edit', $roles) || in_array('carrier/trash', $roles) ? '<td>' : '';
                        echo in_array('carrier/edit', $roles) ? '<a href="carrier/edit/' . $row['idts_carrier'] . '">Edit</a>' : '';
                        echo in_array('carrier/trash', $roles) ? '&nbsp; <a id="' . $row['idts_carrier'] . '" class="trash">Trash</a>' : '';
                        echo in_array('carrier/edit', $roles) || in_array('carrier/trash', $roles) ? '</td>' : '';
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
        <li><a data-id="4" class="editLink" title="Edit" href=""><i class="icon-pencil"></i> Edit</a></li>
        <li><a data-id="4" class="viewDriversLink" title="View Drivers" href=""><i class="icon-user"></i> View Drivers</a></li>
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

        });

        $('body').on('click', '.trash', function (evt) {
            evt.preventDefault();
            var carrier = $(this);
            var id = carrier.attr('id');
            var r = confirm("Confirm trashing carrier?");

            if (r == true) {
                $.ajax({
                    type: "POST",
                    url: 'carrier/change_status/' + id + '/' + 0,
                    async: true,
                    dataType: "json",
                    beforeSend: function () {
                        $('#result_destination').html('Loading...');
                        $('#result_destination').show();
                    },
                    success: function (data) {
                        if (data.status == 1) {
                            $('#carrier_' + id).remove();
                            console.log('carrier deleted');
                        } else {
                            alert('Carrier could not be trashed. Please contact administrator.');
                        }
                    }
                });
            }

        });

    });

</script>