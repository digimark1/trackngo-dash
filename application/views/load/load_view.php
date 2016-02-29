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

        <div class="text-right"><h1>Load</h1></div>
        <!--<a href="<?php echo site_url('load/add'); ?>" class="btn btn-info btn-lg custom-button">Add</a>-->

        <a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('load/add'); ?>" class="btn btn-blue btn-small"><span class="gradient">Add</span></a>
        <div class="table-responsive">
            <table id="list_load" class="table table-hover table-bordered table-striped">
                <thead>
                    <tr style="background-color: #EBEBEB">
                        <th>#</th>
                        <th>Customer</th>
                        <th># Load</th>
                        <th>Driver</th>
                        <th>Origin City</th>
                        <th>Origin State</th>
                        <th>Origin Zip</th>
                        <th>Origin Ctry</th>
                        <th>Dest City</th>
                        <th>Dest State</th>
                        <th>Dest Ctry</th>
                        <th>Dest Zip</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($loads as $load => $row) {

                        $status = '';
                        switch ($row['status']) {
                            case 1:
                                $status = 'To Pickup';
                                break;
                            case 2:
                                $status = 'Loaded';
                                break;
                            case 3:
                                $status = 'On Schedule';
                                break;
                            case 4:
                                $status = 'Behind Schedule';
                                break;
                            case 5:
                                $status = 'Canceled';
                                break;
                            case 6:
                                $status = 'Delivered';
                                break;
                            default:
                                echo "Your favorite color is neither red, blue, nor green!";
                        }

                        echo '<tr data-status="' . $status . '">';
                        echo '<td>' . $i++ . '</td>';
                        echo '<td>' . $row['customer_name'] . '</td>';

                        echo '<td><a href="#" id="' . $row['idts_load'] . '" data-toggle="popover" class="po" data-load_id="' . $row['idts_load'] . '">' . $row['load_number'] . '</a></td>';
                        echo '<td>' . $row['driver_name'] . '</td>';
                        echo '<td>' . $row['or_city'] . '</td>';
                        echo '<td>' . $row['or_state'] . '</td>';
                        echo '<td>' . $row['or_zipcode'] . '</td>';
                        echo '<td>' . $row['or_country'] . '</td>';
                        echo '<td>' . $row['dt_city'] . '</td>';
                        echo '<td>' . $row['dt_state'] . '</td>';
                        echo '<td>' . $row['dt_country'] . '</td>';
                        echo '<td>' . $row['dt_zipcode'] . '</td>';
                        echo '<td class="color">' . $status . '</td>';
//                        echo '<td>';
//                        echo '<span>';
//                        echo '<a data-id="' . $row['idts_load'] . '" data-toggle="modal" data-target="#load_view_dialog" class="load_view" title="View Details" data-href= "load/get_load_view/' . $row['idts_load'] . '"><i class="icon-eye-open"></i></a>';
//                        echo '</span>';
//                        echo '</td>';
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
        <li><a data-id="4" class="viewLink" title="View Load" href=""><i class="icon-eye-open"></i> View Load</a></li>
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
            $('#popover_content ul li a.editLink').attr('href', 'load/update/' + popover);
            $('#popover_content ul li a.viewLink').attr('href', 'load/load_details/' + popover);

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

</script>