<div id="category-actions">
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('customer/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/customers-bt-w.png" style=" width:40px; height:40px; margin-top:10px" alt="View All customers"></a></div>
    <div class="loads-title" id="category-title" style="height: 32px;padding-top: 15px;"><h2 style="font-weight: 600;letter-spacing: 1px;padding-right: 5px;">Customers</h2></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('customer/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All customers"></a></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('customer/add'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" alt="Add a Driver"></a></div>
    <div id="category-button"></div>
    <div id="category-search" class="search-customer"></div>
    <div id="category-search" class="search-carrier"></div>
    <div id="category-search" class="search-loads"></div>
</div>
<div class="row">
    <div class="span9 offset1">
        <form id="register_form" class="form-horizontal" method="POST" action="<?php echo site_url('customer/update') ?>">
            <input type="hidden" name="id" class="input-xlarge" value="<?php echo $customer['idts_customer'] ?>"/>
            <input type="hidden" name="update_contact" id="update_contact"/>
            <input type="hidden" name="new_contact" id="new_contact"/>
            <input type="hidden" id="delete_contact" name="delete_contact" class="input-xlarge"/>
            <div class="text-right"><h3>Update Customer</h3></div>

            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    <input type="text" name="mname" class="input-xlarge" value="<?php echo $customer['name'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Phone</label>
                <div class="controls">
                    <input type="text" name="mphone" class="input-xlarge" value="<?php echo $customer['phone'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                    <input type="text" name="memail" class="input-xlarge" value="<?php echo $customer['email'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Address</label>
                <div class="controls">
                    <input type="text" name="address" class="input-xlarge" value="<?php echo $customer['address'] ?>"/>
                </div>
            </div>            

            <div class="control-group">
                <label class="control-label">City</label>
                <div class="controls">
                    <input type="text" name="city" class="input-xlarge" value="<?php echo $customer['city'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">State</label>
                <div class="controls">
                    <input type="text" name="state" class="input-xlarge" value="<?php echo $customer['state'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Country</label>
                <div class="controls">
                    <select class="selectpicker" name="country">
                        <?php
                        $selected = 'selected="selected"';
                        if ($customer['country'] == 1) {
                            echo '<option value="1" ' . $selected . '>USA</option>';
                            echo '<option value="2">Cananda</option>';
                        } else {
                            echo '<option value="1">USA</option>';
                            echo '<option value="2" ' . $selected . '>Cananda</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <table id="contact-table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <td colspan="6" style="background-color: #EBEBEB; font-size: 14px;font-weight: bolder;">Customer Contacts</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>Phone</td>
                        <td>Email</td>
                        <td>Default</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($contacts as $contact => $row) {
                        $checked = "";
                        if ($row['default'] == 1) {
                            $checked = 'checked="checked"';
                        }

                        echo'<tr class="update_contact" id="' . $row['idts_customer_contact'] . '">';
                        echo'<td><input type="text" class="name" name="name" value="' . $row['name'] . '"/></td>';
                        echo'<td><input type="text" class="phone" name="phone" value="' . $row['phone'] . '"/></td>';
                        echo'<td><input type="text" class="email" name="email" value="' . $row['email'] . '"/></td>';
                        echo'<td><input type="checkbox" id="default_' . $i . '" class="default" name="default" ' . $checked . '/></td>';
                        echo''
//                        . '<td style="text-align: center;"><a href="' . VIEW_FILE_PATH . $row['idts_customer_contact'] . '" target="_blank">View</a></td>'
                        . '<td style="text-align: center;"><a href="" data-id="' . $row['idts_customer_contact'] . '" class="remove_contact">Delete</a></td>'
                        . '</tr>';
                        $i++;
                    }
                    ?>
                </tbody>
            </table>

            <button id="add_contact" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none; margin: 20px 0px"><span class="gradient">Add Contact</span></button>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-red btn-small" hidefocus="true" style="outline: medium none;"><span class="gradient">Save</span></button>
                    <button onclick="location.href = '<?php echo site_url('/customer') ?>';" style="border-radius: 16%; height: 25px;">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    input[type="text"]{
        background-color: #fff;
    }
    
    #contact-table{
        margin: 40px 20px;
    }
</style>
<script>
    $(function () {
        var delete_contacts = [];
        var count_conts = <?php echo count($contacts) ?>;
        var contact_number = parseInt(count_conts);
        $("#register_form_error").hide();
        $('#register_form').submit(function (evt) {
            evt.preventDefault();
            getContactData();
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            $.post(url, postData, function (o) {
                if (o.result == 1) {
                    window.location.href = '<?php echo site_url('customer') ?>';
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

        // add new contact row

        $('body').on('click', '#add_contact', function (evt) {
            evt.preventDefault();
            setContactRow(contact_number);
            contact_number++;
            //            $('#bol-table tbody').append('<tr id="shp_' + shp_number + '">'+shp_number+'<td id="customer_' + shp_number + '">Customer</td><td><input type="text" name="pickup"/></td><td><input type="text" name="drop"/></td><td><input type="text" name="bol_number"/></td><td><input type="file" multiple = "multiple" accept = "image/*" class = "form-control" name="uploadfile[]" size="20" /></td></tr>');
            //                    $('#customer_' + shp_number).html($('#customer_list').html());
        });
        //Remove contact
        $('body').on('click', '.remove_contact', function (evt) {
            evt.preventDefault();
//            delete_contacts                        
            var tr_id = $(this).data('id');
            delete_contacts.push({
                idts_customer_contact: tr_id
            });
            var delete_contact = JSON.stringify(delete_contacts);
            $('#delete_contact').val(delete_contact);
            var tr = $('#' + tr_id);
            $(tr).remove();
        });
        //Remove new contact
        $('body').on('click', '.delete_new', function (evt) {
            evt.preventDefault();
            var tr_id = $(this).data('id');
            var tr = $('#contact_' + tr_id);
            $(tr).remove();
        });
    });

    function getContactData() {
        var contacts = [];
        var new_contacts = [];
        var j = 0;

        $('#contact-table tbody tr').each(function () {

            var tr = $(this);
            var cl = tr.attr('class');
            var checked = 0;
            var checked_def_mail = 0;

            if ($('#default_' + j).is(":checked")) {
                checked = 1;
            }

            if (cl == 'update_contact') {
                contacts.push({
                    idts_customer_contact: tr.attr('id'),
                    name: tr.find('.name').val(),
                    phone: tr.find('.phone').val(),
                    email: tr.find('.email').val(),
                    default: checked
                });
            } else {
                new_contacts.push({
                    name: tr.find('.name').val(),
                    phone: tr.find('.phone').val(),
                    email: tr.find('.email').val(),
                    default: checked
                });
            }
            j++;
        });

        var json = JSON.stringify(contacts);
        $('#update_contact').val(json);

        var json_new_contacts = JSON.stringify(new_contacts);
        $('#new_contact').val(json_new_contacts);

        return true;
    }
    function setContactRow(contact_number) {
        //Content
        tRow = $('<tr id="contact_' + contact_number + '">');
        cname = $('<td>').html('<input type="text" id="name_' + contact_number + '" class="name" name="contat_name"/>');
        phone = $('<td>').html('<input type="text" id="phone_' + contact_number + '" class="phone" name="contat_phone"/>');
        email = $('<td>').html('<input type="text" id="email_' + contact_number + '" class="email" name="contat_email"/>');
        cdefault = $('<td>').html('<input type="checkbox" id="default_' + contact_number + '" name="contat_default"/>');
        actions = $('<td>').html('<a href="#" data-id="' + contact_number + '" class="delete_new">Delete</a>');

        tRow.append(cname);
        tRow.append(phone);
        tRow.append(email);
        tRow.append(cdefault);
        tRow.append(actions);

        $('#contact-table tbody').append(tRow);
    }
</script>