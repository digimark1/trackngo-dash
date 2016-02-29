<div id="category-actions">
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('customer/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/customers-bt-w.png" style=" width:40px; height:40px; margin-top:10px" alt="View All Loads"></a></div>
    <div class="loads-title" id="category-title" style="height: 32px;padding-top: 15px;"><h2 style="font-weight: 600;letter-spacing: 1px;padding-right: 5px;">CUSTOMERS</h2></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('customer/'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-list-bt-45w.png" width="45" height="70" alt="View All Loads"></a></div>
    <div id="category-button"><a style="outline: medium none;" hidefocus="true" href="<?php echo site_url('customer/add'); ?>"><img src="<?php echo base_url() ?>/public/img/images/loads-add-bt-45w.png" width="45" height="70" alt="Add a Load"></a></div>
    <div id="category-button"></div>
    <div id="category-search" class="search-customer"></div>
    <div id="category-search" class="search-carrier"></div>
    <div id="category-search" class="search-loads"></div>
</div>
<div class="row">
    <div class="span9 offset1">
        <div id="register_form_error" class="alert alert-error"><!-- Dynamic --></div>
        <form id="register_form" class="form-horizontal" method="POST" action="<?php echo site_url('customer/register') ?>">
            <input type="hidden" id="contacts" name="contacts" class="input-xlarge"/>
            <div class="text-right"><h3>Register Customer</h3></div>

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
                <label class="control-label">Email</label>
                <div class="controls">
                    <input type="text" name="email" class="input-xlarge" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Address</label>
                <div class="controls">
                    <input type="text" name="address" class="input-xlarge" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">City</label>
                <div class="controls">
                    <input type="text" name="city" class="input-xlarge" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">State</label>
                <div class="controls">
                    <input type="text" name="state" class="input-xlarge" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Country</label>
                <div class="controls">                            
                    <select name="country" id="country" class="selectpicker smallinput" tabindex="275" >
                        <option value="1">Usa</option>
                        <option value="2">Canada</option>
                    </select>                            
                </div>
            </div>

            <table id="contact-table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <td colspan="6" style="background-color: #EBEBEB; font-size: 14px;font-weight: bolder;">Customer Contacts</td>
                    </tr>
                    <tr>
                        <td class="contact_header">Name</td>
                        <td class="contact_header">Phone</td>
                        <td class="contact_header">Email</td>
                        <td class="contact_header">Default</td>
                        <td class="contact_header">Actions</td>
                    </tr>                      
                </thead>
                <tbody>                      
                    <tr id="contact_1">
                        <td><input type="text" id="name_1" name="contat_name"/></td>
                        <td><input type="text" id="phone_1" name="contat_phone"/></td>
                        <td><input type="text" id="email_1" name="contat_email"/></td>
                        <td><input type="checkbox" id="default_1" name="contat_default"></td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
            </table>
            <button id="add_contact" class="btn btn-red btn-small" hidefocus="true" name="submit" style="outline: medium none;"><span class="gradient">Add Contact</span></button>


            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-red btn-small" hidefocus="true" style="outline: medium none;"><span class="gradient">Save</span></button>                    
                    <button onclick="location.href = '<?php echo site_url('/customer') ?>';" style="border-radius: 16%; height: 25px;">Cancel</button>
                    <!--<button type="button" class="btn btn-blue btn-small" onclick="location.href='<?php echo site_url('/customer') ?>';" hidefocus="true" style="outline: medium none;"/><span class="gradient">Cancel</span></button>-->
                </div>
            </div>      
        </form>        
    </div>
</div>
<script>
    $(function () {
        var contact_number = 1;

        $("#register_form_error").hide();
//        $('#register_form').submit(function (evt) {
//            evt.preventDefault();
//            var url = $(this).attr('action');
//            var postData = $(this).serialize();
//            $.post(url, postData, function (o) {
//                if (o.result == 1) {
//                    window.location.href = '<?php echo site_url('customer') ?>';
//                } else {
//                    $("#register_form_error").show();
//                    var output = '<ul>';
//                    for (var key in o.error) {
//                        var value = o.error[key];
//                        output += '<li>' + value + '</li>';
//                    }
//                    output += '</ul>';
//                    $("#register_form_error").html(output);
//                }
//            }, 'json');
//        });



        $('#register_form').submit(function (evt) {
            // submit the form 
            evt.preventDefault();
            getContactData();

            var options = {
//                target: '#output2', // target element(s) to be updated with server response 
                beforeSubmit: showRequest, // pre-submit callback 
                success: showResponse, // post-submit callback 

                // other available options: 
                //url:       url         // override for form's 'action' attribute 
                //type:      type        // 'get' or 'post', override for form's 'method' attribute 
                dataType: 'json'        // 'xml', 'script', or 'json' (expected server response type) 
                        //clearForm: true        // clear all form fields after successful submit 
                        //resetForm: true        // reset the form after successful submit 

                        // $.ajax options can be used here too, for example: 
                        //timeout:   3000 
            };

            $(this).ajaxSubmit(options);
            // return false to prevent normal browser submit and page navigation 
            return false;
        });


        //add new contact
        //Add new row to Shipment the table
        $('body').on('click', '#add_contact', function (evt) {
            evt.preventDefault();
            contact_number++;
            setContactRow(contact_number);
//            $('#contact-table tbody').append('<tr id="shp_' + contact_number + '">'+contact_number+'<td id="customer_' + contact_number + '">Customer</td><td><input type="text" name="pickup"/></td><td><input type="text" name="drop"/></td><td><input type="text" name="bol_number"/></td><td><input type="file" multiple = "multiple" accept = "image/*" class = "form-control" name="uploadfile[]" size="20" /></td></tr>');
//                    $('#customer_' + contact_number).html($('#customer_list').html());
        });

        $('body').on('click', '.remove_contact', function (evt) {
            evt.preventDefault();
//            delete_contacts                        
            var tr_id = $(this).data('id');
            var tr = $('#contact_' + tr_id);
            $(tr).remove();
        });

    });

    //Global vars


    function setContactRow(contact_number) {
        //Content
        tRow = $('<tr id="contact_' + contact_number + '">');
        cname = $('<td>').html('<input type="text" id="name_' + contact_number + '" name="contat_name"/>');
        phone = $('<td>').html('<input type="text" id="phone_' + contact_number + '" name="contat_phone"/>');
        email = $('<td>').html('<input type="text" id="email_' + contact_number + '" name="contat_email"/>');
        cdefault = $('<td>').html('<input type="checkbox" id="default_' + contact_number + '" name="contat_default"/>');
        actions = $('<td>').html('<a href="" data-id="' + contact_number + '" class="remove_contact">Delete</a>');


        tRow.append(cname);
        tRow.append(phone);
        tRow.append(email);
        tRow.append(cdefault);
        tRow.append(actions);

        $('#contact-table tbody').append(tRow);
    }

    function getContactData() {
        var contacts = [];
        var j = 1;
        $('#contact-table tbody tr').each(function () {

            var tr = $(this);
            var checked = 0;
            var checked_def_mail = 0;
            if ($('#default_' + j).is(":checked")) {
                checked = 1;
            }

            if ($('#default_mail_' + j).is(":checked")) {
                checked_def_mail = 1;
            }

            contacts.push({
                index: j,
                name: tr.find('#name_' + j).val(),
                phone: tr.find('#phone_' + j).val(),
                email: tr.find('#email_' + j).val(),
                default: checked
            });
            //get row values
            // $('#out').append(this.id);

            j++;
        });

        var json = JSON.stringify(contacts);
        $('#contacts').val(json);
        return true;
    }

    // post-submit callback 
    function showResponse(data) {
        console.log('returned data: ' + data.msg);
        location.href = '<?php echo site_url('/customer') ?>';
    }

    function showRequest() {
        $('#msg').html('Saving');
    }
</script>