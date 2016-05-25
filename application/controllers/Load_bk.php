<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of load
 *
 * @author nando_000
 */
class load extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('load_model');
        $this->load->model('location_request_model');
        $roles = $this->session->userdata('roles');
        $i = 0;
        if ($roles) {
            foreach ($roles as $role => $row) {
                $GLOBALS['roles'][$i] = $row['class'] . '/' . $row['function'];
                $i++;
            }
        } else {
            $GLOBALS['roles'][0] = 'load/index';
        }
        $GLOBALS['a'] = [];
    }

    public function test2() {
        $this->load->view('load/inc/header_view');
        $this->load->view('load/load_view');
        $this->load->view('load/inc/footer_view');
    }

    public function index() {
        $this->_required_login();

        $this->load->library('pagination');
        $this->load->library('table');

        //pagination
        $config['base_url'] = site_url('load/index');
        $config['per_page'] = 5;
        $config['num_links'] = 5;
        $config['total_rows'] = count($this->get_load_view('x', 0, 1));

        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";


        $this->pagination->initialize($config);

        $this->load->model('driver_model');
        $data = $this->get_session_user_data();
        $data['roles'] = $GLOBALS['roles'];
        $this->load->model('carrier_model');
        $data['carriers'] = $this->carrier_model->get();
        $this->load->model('customer_model');
        $data['customers'] = $this->customer_model->get();
        $data['drivers'] = $this->driver_model->get();
        $data['total_loads'] = $config['total_rows'];

        $data['loads'] = $this->get_load_view('x', 0, 1, 'date_created', 'desc', $config['per_page'], $this->uri->segment(3));
//      all loads with no page limit //
		$data['loads2'] = $this->get_load_view_all('x', 0, 1, 'date_created', 'desc', $this->uri->segment(1));
//        print_r($data['loads']);
//        $this->output->set_output(json_encode($data['loads']));
//        return false;
   //----Getting loads-----//
        $z = 0;
	//$loadsall = 0;
        foreach ($data['loads2'] as $load6 => $row6) {
            if($row6['status'] == 'Delivered'){}else{
                $loadsall[$z] = $row6['idts_load'];
                $z++;
            }
        }
        //$data['loadsall1'] = count($loadsall);
        //if($loadsall == 0){
        //   $data['loadsall'] = 0;
        //}else{
	$zero ='';
	$data['loadsall'] = ((isset($loadsall))?$loadsall:$zero);
	//}
        //
	//---------------------//
		//$data['callchecks2'] = 'Did I get it?';
        //$data['callchecks_all'] = $this->get_chat_home($loadsall);
		
        $config['num_rows'] = count($data['loads']);
        
        if (isset($loadsall)){
            $data['loadsall'] = $loadsall;
        } else {
            $data['loadsall'] = "";
        }

        $this->load->view('general/inc/header_view', $data);
        $this->load->view('load/load_view2');
        $this->load->view('general/inc/footer_view');
    }

    public function trash() {
        $this->_required_login($this->router->fetch_class(), 'trash');

        $this->load->library('pagination');
        $this->load->library('table');

        //pagination
        $config['base_url'] = site_url('load/trash');
        $config['per_page'] = 5;
        $config['num_links'] = 5;
        $config['total_rows'] = count($this->get_load_view('x', 0, 0));

        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $this->pagination->initialize($config);

        $this->load->model('driver_model');
        $data = $this->get_session_user_data();
        $data['roles'] = $GLOBALS['roles'];
        $this->load->model('carrier_model');
        $data['carriers'] = $this->carrier_model->get();
        $this->load->model('customer_model');
        $data['customers'] = $this->customer_model->get();
        $data['drivers'] = $this->driver_model->get();
        $data['total_loads'] = $config['total_rows'];

        $data['loads'] = $this->get_load_view(['sw' => 0], 0, 0, 'date_created', 'desc', $config['per_page'], $this->uri->segment(3));
//        print_r($data['loads']);
//        $this->output->set_output(json_encode($data['loads']));
//        return false;
//        $this->output->enable_profiler(TRUE);

        $config['num_rows'] = count($data['loads']);
        $this->pagination->initialize($config);

        $this->load->view('general/inc/header_view', $data);
        $this->load->view('load/trash_view');
        $this->load->view('general/inc/footer_view');
    }

    public function index2($param) {
        $this->load->view('upload/upload_form', array('error' => ' '));
    }

    public function do_upload_form() {

        // Detect form submission.
        if ($this->input->post('submit')) {
            $path = './uploads/';
            $this->load->library('upload');

            /**
             * Refer to https://ellislab.com/codeigniter/user-guide/libraries/file_uploading.html 
             * for full argument documentation.
             *
             */
            // Define file rules
            $this->upload->initialize(array(
                "upload_path" => $path,
                "allowed_types" => "gif|jpg|png",
                "max_size" => '100',
                "max_width" => '1024',
                "max_height" => '768'
            ));

            if ($this->upload->do_multi_upload("uploadfile")) {

                $data['upload_data'] = $this->upload->get_multi_upload_data();

                echo '<p class = "bg-success">' . count($data['upload_data']) . 'File(s) successfully uploaded.</p>';
            } else {
                // Output the errors
                $errors = array('error' => $this->upload->display_errors('<p class = "bg-danger">', '</p>'));

                foreach ($errors as $k => $error) {
                    echo $error;
                }
            }
        } else {
            echo '<p class = "bg-danger">An error occured, please try again later.</p>';
        }
        // Exit to avoid further execution
        exit();
    }

    public function unauth() {
        $data = $this->get_session_user_data();
        $this->load->view('general/inc/header_view', $data);
        $this->load->view('load/not_auth');
        $this->load->view('general/inc/footer_view');
    }

    public function recursive($id) {
        $this->load->model('user_model');
        $users = $this->user_model->get();
        $result = $this->get_child($id, $users);
        return $result;
//        $this->output->set_output(json_encode($result));
    }

    // al valor que se pase se identifica al hijo(s)
    public function get_child($id, $users) {
        for ($i = 0; $i < count($users); $i++) {
            $user = $users[$i];
            if ($id == $user['user_iduser']) {
                array_push($GLOBALS['a'], $user['iduser']);
                $this->get_child($user['iduser'], $users);
            }
        }
        return $GLOBALS['a'];
    }

    public function load_details($id, $sw = 0) {
        $this->_required_login($this->router->fetch_class(), $this->router->fetch_method());
        $this->load->model('driver_model');
        $this->load->model('load_trace_model');
        $this->load->model('shipment_model');

        $data = $this->get_session_user_data();
        $data['roles'] = $GLOBALS['roles'];

        $data['load'] = $this->get_load_view($id, 0, 1);
        $driver_id = $data['load'][0]['ts_driver_idts_driver'];
        $data['driver'] = $this->driver_model->get($driver_id);
        $data['callchecks'] = $this->get_chat($id);
        $shipments = $this->shipment_model->get_shipment(['ts_load_idts_load' => $id]);
        for ($i = 0; $i < count($shipments); $i++) {
            $ship_contacts = $this->get_shipment_contacts($shipments[$i]['idshipment']);
            $shipments[$i]['contacts'] = $ship_contacts;

            $shipments[$i]['documents'] = $this->get_shipment_documents($shipments[$i]['idshipment']);
            if ($shipments[$i]['pickup_address'] == '') {
                $shipments[$i]['pickup_format_address'] = '';
            } else{
                $pickup_format_address = json_decode($this->get_google_address($shipments[$i]['pickup_address'], $shipments[$i]['pickup_zipcode']));
                $address_array = explode(',', $pickup_format_address->results[0]->formatted_address);
            
                $formated_adrress = $address_array[0] . ' - ' . $shipments[$i]['pickup_address2'] . ', ' . $address_array[1] . ', ' . $address_array[2] . ', ' . $address_array[3];
                $shipments[$i]['pickup_format_address'] = $formated_adrress;
            };
            if ($shipments[$i]['drop_address'] == '') {
                $shipments[$i]['drop_format_address'] = '';
            } else {
                $drop_format_address = json_decode($this->get_google_address($shipments[$i]['drop_address'], $shipments[$i]['drop_zipcode']));
                $address_drop_array = explode(',', $drop_format_address->results[0]->formatted_address);
                $blank='';
                $formated_drop_adrress = ((isset($address_drop_array[0])) ? $address_drop_array[0] :$blank) . ' - ' . $shipments[$i]['drop_address2'] . ', ' . ((isset($address_drop_array[1])) ? $address_drop_array[1] :$blank). ', ' .  ((isset($address_drop_array[2])) ? $address_drop_array[2] :$blank) . ', ' . ((isset($address_drop_array[3])) ? $address_drop_array[3] :$blank);
                $shipments[$i]['drop_format_address'] = $formated_drop_adrress;
            };
        }
        $data['shipments'] = $shipments;

//        $this->output->set_output(json_encode($data['shipments']));
//        return false;

        $traces = $this->load_trace_model->get(['ts_load_idts_load' => $id], 'date', 'asc', 40);
        $min_temp = 0;
        foreach ($traces as $trace => $row) {
            $date = explode(' ', $row['date']);
            $date_formated_temp = explode('-', $date[0]);
            $date_formated = $date_formated_temp[1] . '/' . $date_formated_temp[2] . '/' . $date_formated_temp[0];

            $date_formated_hour = explode(':', $date[1]);
            if ($min_temp == $date_formated_hour[1]) {
                unset($traces[$trace]);
            }
            $min_temp = $date_formated_hour[1];
        }

//        for ($i = 0; $i < count($result); $i++) {
//            $driver_address = json_decode($this->get_driver_address($result[$i]['lat'], $result[$i]['lng']));
//            $result[$i]['driver_address'] = $driver_address->results[0]->formatted_address;
//        }
//
//        print_r($traces);
//        return false;

        $data['traces'] = $traces;
//
        $this->load->view('general/inc/header_view', $data);
        $this->load->view('load/load_details');
        $this->load->view('general/inc/footer_view');
    }

    public function get_shipment_contacts($id, $json = null) {
        $this->load->model('shipment_customer_contact_model');
        $result = $this->shipment_customer_contact_model->get_contacts(['shipment_idshipment' => $id]);
        if ($json) {
            $this->output->set_output(json_encode($result));
            return false;
        }
        return $result;
    }

    public function get_shipment_documents($shipment_id = null, $json = null) {
        $this->load->model('shipment_document');
        $result = $this->shipment_document->get(['shipment_idshipment' => $shipment_id]);
        if ($json) {
            $this->output->set_output(json_encode($result));
            return false;
        }
        return $result;
    }

    public function get_load_trace($load_id, $json = null, $limit = null, $start = null) {

        if (!$start) {
            $start = $this->input->post('start');
        }

        if (!$limit) {
            $limit = $this->input->post('limit');
        }

        $this->load->model('load_trace_model');
        $traces = $this->load_trace_model->get(['ts_load_idts_load' => $load_id], 'date', 'desc', $limit, $start);
//        $this->output->enable_profiler(TRUE);

        $min_temp = 0;
        $fix_traces = [];
        foreach ($traces as $trace => $row) {
            $date = explode(' ', $row['date']);
            $date_formated_temp = explode('-', $date[0]);
            $date_formated = $date_formated_temp[1] . '/' . $date_formated_temp[2] . '/' . $date_formated_temp[0];

            $date_formated_hour = explode(':', $date[1]);
            if ($min_temp == $date_formated_hour[1]) {
                $a = 1;
            } else {
                array_push($fix_traces, $row);
            }
            $min_temp = $date_formated_hour[1];
        }
        if ($json) {
            $this->output->set_output(json_encode($fix_traces));
            return false;
        }
        return $fix_traces;
    }

    public function get_chat($id, $sw = null) {
        $this->load->model('callcheck_model');
        $result = $this->callcheck_model->get_chat([
            'ts_load_idts_load' => $id
        ]);

        if ($sw) {
            $this->output->set_output(json_encode($result));
            return false;
        }
        return $result;
    }
	
    public function get_chat_home() {
        $id = $this->input->post('id_list');
        //$i = 0;
        //foreach($id as $idx){
        $this->load->model('callcheck_model');
        $result = $this->callcheck_model->get_chat_all($id);
        //$i++;
        //}        
        $sw = null;
        
        //if ($sw) {
        $this->output->set_output(json_encode($result));
          //  return false;
        //}
        //return $result;
        //$this->check_read_msg();
    }
    
    public function app_get_chat($id) {
        $this->load->model('callcheck_model');
        $result = $this->callcheck_model->get_chat([
            'ts_load_idts_load' => $id
        ]);

        $this->output->set_output(json_encode($result));
    }

    public function get_last_msg($id, $sw = null) {
        $this->load->model('callcheck_model');
        $last_date = $this->input->post('last_date');
        $result = $this->callcheck_model->get_chat([
            'ts_load_idts_load' => $id
                ], $last_date);
        if ($sw) {
            $this->output->set_output(json_encode($result));
            return false;
        }
        return $result;
    }
    
//    public function get_idts_callcheck($note, $sw = null) {
//        $this->load->model('callcheck_model');
//        $result = $this->callcheck_model->get_idts([
//            'ts_load_idts_load' => $id
//        ]);
//
//        if ($sw) {
//            $this->output->set_output(json_encode($result));
//            return false;
//        }
//        return $result;
//    }

    public function set_driver_msg() {
        $this->load->model('callcheck_model');

        $user_id = $this->input->post('user_id');
        $load_id = $this->input->post('load_id');
        $type = $this->input->post('type');
        $comment = $this->input->post('comment');

        $result = $this->callcheck_model->insert([
            'user_iduser' => $user_id,
            'ts_load_idts_load' => $load_id,
            'type' => $type,
            'driver' => 1,
            'comment' => $comment,
            'date' => now()
        ]);

        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Callcheck added.']));
            return false;
        }
        $this->output->set_output(json_encode(['result' => 0, 'error' => 'Callcheck not added']));
    }

    public function send_driver_mail($param) {
        $email = $param['email'];
        $customer = $param['customer'];
        $origin = $param['origin'];
        $destination = $param['destination'];

        $to = "$email";
        $subject = "Load assigned";
// Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
        $headers .= 'From: <service@smith.com>' . "\r\n";

        $message = '<div><h1>Smith Transportation</h1></div>
                        <p>Load assigned to you</p>
                        <ul>
                            <li>Customer: ' . $customer . '</li>
                            <li>Origin: ' . $origin . '</li>
                            <li>Destination: ' . $destination . '</li>
                        </ul>
                        <p>Check the smith app to see load details.</p>';
        mail($to, $subject, $message, $headers);
    }

    public function addx() {
        $this->_required_login();
        $data = $this->get_session_user_data();
        $this->load->model('carrier_model');
        $data['carriers'] = $this->carrier_model->get();
        $this->load->model('driver_model');
        $data['drivers'] = $this->driver_model->get();
        $this->load->model('customer_model');
        $data['customers'] = $this->customer_model->get();
        $data['last_load'] = $this->load_model->get(null, 'idts_load', 'desc', 1);
//        print_r($data['last_load']);

        $this->load->view('general/inc/header_view', $data);
        $this->load->view('load/register_view');
        $this->load->view('general/inc/footer_view');
    }

    public function add() {
        $this->_required_login($this->router->fetch_class(), $this->router->fetch_method());

        $data = $this->get_session_user_data();
        $data['roles'] = $GLOBALS['roles'];

        $this->load->model('carrier_model');
        $data['carriers'] = $this->carrier_model->get();

        $this->load->model('customer_model');
        $data['customers'] = $this->customer_model->get();

        $this->load->model('customer_contact_model');
        $fisrt_customer = $data['customers'][0];
        $data['first_customer_contacts'] = $this->customer_contact_model->get(['ts_customer_idts_customer' => $fisrt_customer['idts_customer']]);

        $last_load = $this->load_model->get(null, 'load_number', 'desc', 1);
        if (count($last_load) >= 1) {
            $start = $last_load[0];
        } else {
            $start = ['load_number' => 1630];
        }

        $data['last_load'] = $start;
        echo'<br>';
//        print_r($last_load[0]);
//        $data['last_load'] = $last_load[0];
        $data['error'] = '';

        $this->load->view('general/inc/header_view', $data);
        $this->load->view('load/register_view');
        $this->load->view('general/inc/footer_view');
    }

    function enable($id) {
        $load_id = $this->load_model->update([
            'sw' => '1',
                ], $id);
    }

    function upload_file() {
        $status = "";
        $msg = "";
        $file_element_name = 'userfile';

        if (empty($_POST['customer'])) {
            $status = "error";
            $msg = "Please enter a title";
        }

        if ($status != "error") {
            $config['upload_path'] = '././tkgo_files2/';
            $config['allowed_types'] = 'pdf|gif|jpg|png|doc|txt';
//            $config['max_size'] = 1024 * 8;
//            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();
//                $file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
//                if ($file_id) {
//                    $status = "success";
//                    $msg = "File successfully uploaded";
//                } else {
//                    unlink($data['full_path']);
//                    $status = "error";
//                    $msg = "Something went wrong when saving the file, please try again.";
//                }
            }
//            @unlink($_FILES[$file_element_name]);
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    function select_validate($post_string) {
        return $post_string == '0' ? FALSE : TRUE;
    }

    function do_upload() {
//        return false;
//        echo 'total files: ' . count($_FILES['uploadfile']);
//        for ($i = 1; $i < 3; $i++) {
//            print_r(json_decode($this->input->post('ship_contacts_' . $i)));
//        }

        date_default_timezone_set("America/New_York");
        $this->output->set_content_type('application_json');

        $this->load->model('shipment_model');
        $this->load->model('shipment_customer_contact_model');

        $this->form_validation->set_rules('carrier', 'Carrier', 'required|callback_select_validate');
        $this->form_validation->set_rules('driver', 'Driver', 'required|callback_select_validate');

        $this->form_validation->set_message('select_validate', 'Please select a %s');

        if ($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode(['status' => 0, 'error' => $this->form_validation->error_array()]));
            return false;
        }

        //check shipment in database
        $sw_bol_number = 0;
        $repeat_bol_number = '';
        $missing = '';
        $shipments = json_decode($this->input->post('shipments'));
        for ($i = 0; $i < count($shipments); $i++) {
            $shipment_data = array(
                'bol_number' => $shipments[$i]->bol_number,
            );
            $shp_id = $this->shipment_model->get($shipment_data);
            if ($shp_id) {
                $sw_bol_number = 1;
                $repeat_bol_number = $shp_id[0]['bol_number'];
            }
        }

        if ($sw_bol_number) {
            $this->output->set_output(json_encode(['status' => 0, 'error' => ['bol_number' => 'BOL #' . $repeat_bol_number . ' is already registered.']]));
            return false;
        }

        $carrier = $this->input->post('carrier');
        $driver = $this->input->post('driver');
        $load_number = $this->input->post('load_number');
        $tender = $this->input->post('status') ? $this->input->post('status') : 0;
//        $shipments = $this->input->post('shipments');

        $load_id = $this->load_model->insert([
            'user_iduser' => $this->session->userdata('user_id'),
            'ts_carrier_idts_carrier' => $carrier,
            'ts_driver_idts_driver' => $driver,
            'tender' => $tender,
            'load_number' => $load_number,
            'date_created' => date('Y-m-d H:i:s')
        ]);

//        $this->pdf_image($load_number);
//        print_r($shipments);
//        return false;
        if ($load_id) {
            //insert in request1
            $request_number = 0;
            $reset = 0;
            $request_id = $this->location_request_model->insert([
                'request_load' => $load_id,
                'request_number' => $request_number,
                'reset' => $reset
            ]);
            
            //Insert Shipments
            if (count($shipments) > 0) {
                $path = CONT_FILE_PATH;
                $this->load->library('upload');

                $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "pdf|gif|jpg|png",
                    "max_size" => '100',
                    "max_width" => '1024',
                    "max_height" => '768'
                ));

                if ($this->upload->do_multi_upload("uploadfile", $load_id, $shipments)) {

                    $data['upload_data'] = $this->upload->get_multi_upload_data();
                    $pdf_pages_number = [];
                    $n = 0;
                    foreach ($data['upload_data'] as $k => $info) {
                        $pdf_pages_number[$n] = $info['pages_number'];
                        $n++;
                    }

                    $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Load created.']));
                } else {

                    $errors = array('error' => $this->upload->display_errors('<p class = "bg-danger">', '</p>'));

                    foreach ($errors as $k => $error) {
                        echo $error;
                    }
                }

                //**************** Insert Shipments in Database **************************

                for ($i = 0; $i < count($shipments); $i++) {
//                    $shipment_data = array(
//                        'ts_load_idts_load' => $load_id,
//                        'ts_customer_idts_customer' => $shipments[$i]->customer,
//                        'pickup_address' => $shipments[$i]->pickup,
//                        'pickup_address2' => $shipments[$i]->pickup2,
//                        'pickup_number' => $shipments[$i]->pickup_number,
//                        'pickup_zipcode' => $shipments[$i]->pickup_zipcode,
//                        'pickup_lat' => $shipments[$i]->pickup_lat,
//                        'pickup_lng' => $shipments[$i]->pickup_lng,
//                        'drop_address' => $shipments[$i]->drop,
//                        'drop_address2' => $shipments[$i]->drop2,
//                        'drop_number' => $shipments[$i]->drop_number,
//                        'drop_zipcode' => $shipments[$i]->drop_zipcode,
//                        'drop_lat' => $shipments[$i]->drop_lat,
//                        'drop_lng' => $shipments[$i]->drop_lng,
//                        'bol_number' => $shipments[$i]->bol_number,
//                        'pages_number' => isset($pdf_pages_number)?(is_array($pdf_pages_number) ? $pdf_pages_number[$i] : 0): 0,
//                        'url_bol' => $load_id . '_bol_' . $shipments[$i]->bol_number . '.pdf',
//                        'date_created' => date("Y-m-d H:i:s")
//                    );
//                    
                        $shipment_data = array(
                            'ts_load_idts_load' => $load_id,
                            'ts_customer_idts_customer' => $shipments[$i]->customer,
                            'pickup_address' => $shipments[$i]->pickup,
                            'pickup_address2' => $shipments[$i]->pickup2,
                            'pickup_number' => $shipments[$i]->pickup_number,
                            'pickup_zipcode' => $shipments[$i]->pickup_zipcode,
                            'pickup_time' => $shipments[$i]->pickup_time,
                            'company_name' => $shipments[$i]->pickup_company_name,
                            'reference' => $shipments[$i]->pickup_reference,
                            'special_instructions' => $shipments[$i]->pickup_instructions,
                            'pickup_lat' => $shipments[$i]->pickup_lat,
                            'pickup_lng' => $shipments[$i]->pickup_lng,
                            'drop_address' => $shipments[$i]->drop,
                            'drop_address2' => $shipments[$i]->drop2,
                            'drop_number' => $shipments[$i]->drop_number,
                            'drop_zipcode' => $shipments[$i]->drop_zipcode,
                            'drop_time' => $shipments[$i]->drop_time,
                            'company_name2' => $shipments[$i]->drop_company_name,
                            'reference2' => $shipments[$i]->drop_reference,
                            'special_instructions2' => $shipments[$i]->drop_instructions,
                            'drop_lat' => $shipments[$i]->drop_lat,
                            'drop_lng' => $shipments[$i]->drop_lng,
                            'bol_number' => $shipments[$i]->bol_number,
                            'pages_number' => isset($pdf_pages_number)?(is_array($pdf_pages_number) ? $pdf_pages_number[$i] : 0): 0,
                            'url_bol' => $load_id . '_bol_' . $shipments[$i]->bol_number . '.pdf',
                            'date_created' => date("Y-m-d H:i:s")
                        );
					//if(a == 1){}else{};

                    //insert shipments in database
                    $shp_id = $this->shipment_model->insert($shipment_data);

                    //Insert  contacts in database
                    $index = $i + 1;
                    $ship_contacts = json_decode($this->input->post('ship_contacts_' . $index));
                    if ($ship_contacts) {
                        $ship_contacts_value = [];
                        for ($j = 0; $j < count($ship_contacts); $j++) {
                            $ship_contacts_data = array(
                                'shipment_idshipment' => $shp_id,
                                'ts_customer_contact_idts_customer_contact' => $ship_contacts[$j]->contact_id
                            );
                            $ship_contacts_value[$j] = $ship_contacts_data;
                            $email_data['email'] = $ship_contacts[$j]->email;
                            $email_data['bol'] = $shipments[$i]->bol_number;
                            $email_data['load_id'] = $load_id;
                            $this->send_ship_contact_email($email_data);
                        }
                        $this->shipment_customer_contact_model->insertBatch($ship_contacts_value);
                    }
                }
            }

            //Send notification to the driver
            $this->load->model('driver_model');

            //send push notification
            if ($tender == 1) {
                $drivers = $this->driver_model->get($this->input->post('driver'));
                $driver = $drivers[0];
//                $this->push_not_new_load($this->input->post('load_number'), $driver['app_id'], $driver['apns_number']);
                $this->push_not_custom_msg_load($this->input->post('load_number'), ' Check new load assigned to you.', "Smith Track'n Go", 1, $driver['email'], $load_id, $driver['idts_driver']);
            }

            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Load created.']));
//            $loads = $this->get_load_view(['idts_load' => $load_id]);
//            $load = $loads[0];
//
//            $param['email'] = $load['driver_email'];
//            $param['customer'] = $load['customer_name'];
//            $param['load_number'] = $load['load_number'];
//            $this->send_mail_2($param);
//            $this->output->set_output(json_encode(['result' => 1]));
        } else {
            $this->output->set_output(json_encode(['result' => 0, 'error' => 'Load not created.']));
        }

        $this->output->set_output(json_encode(['status' => 1, 'msg' => 'Load Succesfully created.']));
    }

    function get_shipment_photos($shp_url, $pages_number, $json = null) {
        if (!$shp_url) {
            $shp_url = $this->input->post('shp_url');
        }

        if (!$pages_number) {
            $pages_number = $this->input->post('pages_number');
        }

        $shp_photo = [];
        for ($i = 1; $i <= $pages_number; $i++) {
            if (file_exists(CONT_FILE_PATH . $shp_url . $i . '.jpg')) {
                $shp_photo[$i]['url'] = $shp_url . $i . '.jpg';
            }
        }
        if ($json) {
            $this->output->set_output(json_encode(['data' => $shp_photo]));
            return false;
        }

        return $shp_photo;
    }

    function delete_photo($path = null, $json = null, $load_id = null, $bol_number = null, $doc_type = null) {

        $this->load->model('shipment_model');
        if (!$path) {
            $path = $this->input->post('path');
        }

        if (!$load_id) {
            $load_id = $this->input->post('load_id');
        }

        if (!$bol_number) {
            $bol_number = $this->input->post('bol_number');
        }

        if (!$doc_type) {
            $doc_type = $this->input->post('doc_type');
        }

        $field = '';
        $update_query = '';
        if ($doc_type == 'sp') {
            $field = 'pickup_doc_pages';
            $update_query = $field . ' - 1';
        }

        if ($doc_type == 'cs') {
            $field = 'drop_doc_pages';
            $update_query = $field . ' - 1';
        }

        $this->load->helper('file');
        $result = unlink(CONT_FILE_PATH . $path);

        $shipments = $this->shipment_model->get(['bol_number' => $bol_number]);
        $shipment = $shipments[0];

        $total_photos = 0;
        if ($doc_type == 'sp') {
            $total_photos = $shipment['pickup_doc_pages'];
        } else {
            $total_photos = $shipment['drop_doc_pages'];
        }

        $cont = 1;
        $base_url = CONT_FILE_PATH . $load_id . '_bol_' . $bol_number . '_' . $doc_type . '-';

        for ($i = 1; $i <= $total_photos; $i++) {
            if (file_exists($base_url . $i . '.jpg')) {
                rename($base_url . $i . '.jpg', $base_url . $cont . '.jpg');
                $cont++;
            }
        }

        //UPDATE `shipment` SET `drop_doc_pages`= `drop_doc_pages`+1  WHERE `idshipment` = 1
//        $affected_rows = $this->shipment_model->update([$field => $update_query], ['bol_number' => $bol_number]);
        $this->db->where('bol_number', $bol_number);
        $this->db->set($field, $update_query, FALSE);
        $this->db->update('shipment');

        if ($json) {
            if ($result) {
                $this->output->set_output(json_encode(['status' => 1, 'msg' => 'File deleted.']));
            } else {
                $this->output->set_output(json_encode(['status' => 0, 'msg' => 'File could not be deleted.']));
            }
            return false;
        }
        return $result;
    }

    function send_ship_contact_email($email) {
        $this->load->library('email');
        $this->email->clear(true);
//        $msg = $this->load->view('load/shipment_mail_view', $data, true);
        $msg = 'Check BOL attached';


        $this->email->from('service@smith-cargo.com');
        $this->email->to($email['email']);
//        $this->email->bcc('willmar@leanstaffing.com, alvarob@leanstaffing.com, hpena@leanstaffing.com');

        $subject = 'Shipment assigned';

        $this->email->subject($subject);
        $this->email->message($msg);
        $this->email->attach(CONT_FILE_PATH . $email['load_id'] . '_bol_' . $email['bol'] . '.pdf');
        $this->email->set_mailtype("html");

        if ($this->email->send()) {
            return true;
        }
        return false;
    }

    function do_upload2($load_id) {

//        return false;
        $load_num = $this->input->post('load_number');

        date_default_timezone_set("America/New_York");
//        $this->output->set_content_type('application_json');
        $this->load->model('shipment_model');
        $this->load->model('shipment_customer_contact_model');

//        for ($i = 0; $i < count($_FILES["uploadfile"]["name"]); $i++) {
//            echo $_FILES["uploadfile"]["name"][$i];
//        }

        $this->form_validation->set_rules('carrier', 'Carrier', 'required');
        $this->form_validation->set_rules('driver', 'Driver', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode(['status' => 0, 'error' => $this->form_validation->error_array()]));
            return false;
        }

        //check shipment in database
        $sw_bol_number = 0;
        $repeat_bol_number = '';
        $missing = '';
        $shipments = json_decode($this->input->post('shipments'));
//        echo 'total ship: '.count($shipments);        

        if (count($shipments) == 0) {
            $this->output->set_output(json_encode(['status' => 0, 'error' => [1 => 'At least 1 shipment must be added.']]));
            return false;
        }

        //check if bol # exist
//        for ($i = 0; $i < count($shipments); $i++) {
//            $shipment_data = array(
//                'bol_number' => $shipments[$i]->bol_number,
//            );
//            $shp_id = $this->shipment_model->get($shipment_data);
//            if ($shp_id) {
//                $sw_bol_number = 1;
//                $repeat_bol_number = $shp_id[0]['bol_number'];
//            }
//        }
//
//        if ($sw_bol_number) {
//            $this->output->set_output(json_encode(['status' => 0, 'error' => ['bol_number' => 'BOL #' . $repeat_bol_number . ' is already registered.']]));
//            return false;
//        }


        $carrier = $this->input->post('carrier');
        $driver = $this->input->post('driver');
        $tender = $this->input->post('status_tender') == 1 ? $this->input->post('status_tender') : 0;

        //Update load part
        if ($tender == 1) {
            $affected_rows = $this->load_model->update([
                'user_iduser' => $this->session->userdata('user_id'),
                'ts_carrier_idts_carrier' => $carrier,
                'tender' => $tender,
                'ts_driver_idts_driver' => $driver
                    ], $load_id);
        } else {
            $affected_rows = $this->load_model->update([
                'user_iduser' => $this->session->userdata('user_id'),
                'ts_carrier_idts_carrier' => $carrier,
                'ts_driver_idts_driver' => $driver
                    ], $load_id);
        }


        /**
         * Upddate shipments
         */
        //update shipments
        //**************** Update n Insert Shipments in Database **************************

        $file_index = 0;
        $path = CONT_FILE_PATH;
        for ($i = 0; $i < count($shipments); $i++) {
            if (isset($shipments[$i]->type)) {
                $shp_id = 0;
                if ($shipments[$i]->type == 1) {
                    $shipment_data = array(
                        'ts_customer_idts_customer' => $shipments[$i]->customer,
                        'pickup_address' => $shipments[$i]->pickup,
                        'pickup_address2' => $shipments[$i]->pickup2,
                        'pickup_number' => $shipments[$i]->pickup_number,
                        'pickup_zipcode' => $shipments[$i]->pickup_zipcode,
                        'pickup_lat' => $shipments[$i]->pickup_lat,
                        'pickup_lng' => $shipments[$i]->pickup_lng,
                        'drop_address' => $shipments[$i]->drop,
                        'drop_address2' => $shipments[$i]->drop2,
                        'drop_number' => $shipments[$i]->drop_number,
                        'drop_zipcode' => $shipments[$i]->drop_zipcode,
                        'drop_lat' => $shipments[$i]->drop_lat,
                        'drop_lng' => $shipments[$i]->drop_lng,
                        'bol_number' => $shipments[$i]->bol_number,
//                    'pages_number' => is_array($pdf_pages_number) ? $pdf_pages_number[$i] : 0,
//                    'url_bol' => $load_id . '_bol_' . $shipments[$i]->bol_number . '.pdf',
                        'date_created' => date("Y-m-d H:i:s")
                    );
                    $this->shipment_model->update($shipment_data, $shipments[$i]->shipment_id);
                    $shp_id = $shipments[$i]->shipment_id;
                    $this->shipment_customer_contact_model->delete(['shipment_idshipment' => $shp_id]);

                    if ($shipments[$i]->shp_file_sw == 1) {
                        $file = $_FILES['uploadfile']["tmp_name"][$file_index];
                        $file_name = $load_id . '_bol_' . $shipments[$i]->bol_number . '.pdf';
                        $file_name_not_ext = $load_id . '_bol_' . $shipments[$i]->bol_number;

                        $num_pages = $this->upload_shipment_file($file, $path, $file_name, $file_name_not_ext);
                        $upd = [
                            'pages_number' => $num_pages,
                            'url_bol' => $load_id . '_bol_' . $shipments[$i]->bol_number . '.pdf',
                        ];
                        $this->shipment_model->update($upd, $shipments[$i]->shipment_id);
                        $file_index++;
                    }
                } else {

                    $file = $_FILES['uploadfile']["tmp_name"][$file_index];
                    $file_name = $load_id . '_bol_' . $shipments[$i]->bol_number . '.pdf';
                    $file_name_not_ext = $load_id . '_bol_' . $shipments[$i]->bol_number;
                    $num_pages = $this->upload_shipment_file($file, $path, $file_name, $file_name_not_ext);
                    $file_index++;

                    $shipment_data = array(
                        'ts_load_idts_load' => $load_id,
                        'ts_customer_idts_customer' => $shipments[$i]->customer,
                        'pickup_address' => $shipments[$i]->pickup,
                        'pickup_number' => $shipments[$i]->pickup_number,
                        'pickup_zipcode' => $shipments[$i]->pickup_zipcode,
                        'pickup_lat' => $shipments[$i]->pickup_lat,
                        'pickup_lng' => $shipments[$i]->pickup_lng,
                        'drop_address' => $shipments[$i]->drop,
                        'drop_number' => $shipments[$i]->drop_number,
                        'drop_zipcode' => $shipments[$i]->drop_zipcode,
                        'drop_lat' => $shipments[$i]->drop_lat,
                        'drop_lng' => $shipments[$i]->drop_lng,
                        'bol_number' => $shipments[$i]->bol_number,
                        'pages_number' => $num_pages,
                        'url_bol' => $load_id . '_bol_' . $shipments[$i]->bol_number . '.pdf',
                        'date_created' => date("Y-m-d H:i:s")
                    );

                    //insert shipments in database
                    $shp_id = $this->shipment_model->insert($shipment_data);
                }
                //Insert  contacts in database
                $index = $i + 1;
                $ship_contacts = json_decode($this->input->post('ship_contacts_' . $index));
                if ($ship_contacts) {
                    $ship_contacts_value = [];
                    for ($j = 0; $j < count($ship_contacts); $j++) {
                        $ship_contacts_data = array(
                            'shipment_idshipment' => $shp_id,
                            'ts_customer_contact_idts_customer_contact' => $ship_contacts[$j]->contact_id
                        );
                        $ship_contacts_value[$j] = $ship_contacts_data;
                        $email_data['email'] = $ship_contacts[$j]->email;
                        $email_data['bol'] = $shipments[$i]->bol_number;
                        $email_data['load_id'] = $load_id;
//                    $this->send_ship_contact_email($email_data);
                    }
                    $this->shipment_customer_contact_model->insertBatch($ship_contacts_value);
                }
            }
        }


        //Delete shipments in database
        $delete_shipments = json_decode($this->input->post('delete_shipment'));
        if (count($delete_shipments) > 0) {
            for ($i = 0; $i < count($delete_shipments); $i++) {
                $this->shipment_customer_contact_model->delete(['shipment_idshipment' => $delete_shipments[$i]->shipment_id]);
                $this->shipment_model->delete($delete_shipments[$i]->shipment_id);
            }
        }

//        $msg = '';
//        if ($status == 1) {
//            $msg = 'Load successfully uploadted.';
//        } else {
//            $msg = 'Failed uploading file.';
//        }
        //send push notification
        if ($tender == 1) {
            $this->load->model('driver_model');
            $drivers = $this->driver_model->get($this->input->post('driver'));
            $driver = $drivers[0];
            $this->push_not_custom_msg_load($load_num, ' Changes in load #' . $load_num, "Smith Track'n Go", 0, $driver['email'], $load_id, $driver['idts_driver']);
        }

        $this->output->set_output(json_encode(['status' => 1, 'msg' => 'Load successfully updated.']));

//        $this->output->enable_profiler(TRUE);

        return false;


        $shipments = json_decode($this->input->post('update_shipment'));
        if (count($shipments) > 0) {
            $this->db->update_batch('shipment', $shipments, 'idshipment');
        }

        // insert new shipments
        $new_shipments = json_decode($this->input->post('new_shipment'));

        $this->pdf_image($load_number);

        //upload BOL documents


        $path = CONT_FILE_PATH;
        $this->load->library('upload');

        // Define file rules
        $this->upload->initialize(array(
            "upload_path" => $path,
            "allowed_types" => "pdf|gif|jpg|png",
            "max_size" => '100',
            "max_width" => '1024',
            "max_height" => '768'
        ));

        if ($this->upload->do_multi_upload("uploadfile", $load_id, $new_shipments)) {

            $data['upload_data'] = $this->upload->get_multi_upload_data();

//                print_r($data['upload_data']);
            $pdf_pages_number = [];
            $n = 0;
            foreach ($data['upload_data'] as $k => $info) {
//                    echo $k . ': ' . $info['pages_number'] . '\n';
                $pdf_pages_number[$n] = $info['pages_number'];
                $n++;
            }

//                echo '<p class = "bg-success">' . count($data['upload_data']) . 'File(s) successfully uploaded.</p>';
        } else {
            // Output the errors
            $errors = array('error' => $this->upload->display_errors('<p class = "bg-danger">', '</p>'));

            foreach ($errors as $k => $error) {
                echo $error;
            }
        }

        // Insert new Shipments in Database

        if (count($new_shipments) > 0) {
            for ($i = 0; $i < count($new_shipments); $i++) {
                $shipment_data = array(
                    'ts_load_idts_load' => $load_id,
                    'ts_customer_idts_customer' => $new_shipments[$i]->customer,
                    'pickup_address' => $new_shipments[$i]->pickup,
                    'drop_address' => $new_shipments[$i]->drop,
                    'bol_number' => $new_shipments[$i]->bol_number,
                    'pages_number' => is_array($pdf_pages_number) ? $pdf_pages_number[$i] : 0,
                    'url_bol' => $load_id . '_bol_' . $new_shipments[$i]->bol_number . '.pdf',
                    'date_created' => date("Y-m-d H:i:s")
                );
                $shipment_value[$i] = $shipment_data;
            }

            $this->shipment_model->insertBatch($shipment_value);
//            $this->output->enable_profiler(TRUE);
        }

        //Send notification to the driver
        $this->load->model('driver_model');
    }

    function upload_shipment_file($file, $path, $file_name, $file_name_not_ext) {
        $num = 0;
        if (@copy($file, $path . $file_name)) {
            $file_route = $path . $file_name;
//            echo 'file route: ' . $file_route;
            $num = $this->count_pages($file_route);
            $this->pages_number = $num;
            $image = new Imagick();
            $image->setResolution(200, 200);
            for ($j = 0; $j < $num; $j++) {
                $image->readImage($file_route . "[" . $j . "]");
                $image->writeImage($path . $file_name_not_ext . "-" . $j . ".jpg");
            }
        } else {
            echo 'not copied';
        }
        return $num;
    }

    function count_pages($pdfname) {
        $pdftext = file_get_contents($pdfname);
        $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
        return $num;
    }

    function create_pdf2($load_id, $bol_number, $pages_number, $doc_type) {
        $path = CONT_FILE_PATH;
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        for ($i = 0; $i < $pages_number; $i++) {
            $pdf->WriteHTML('');
        }
    }

    function create_pdf($load_id, $bol_number, $pages_number, $doc_type, $json = null) {
        $this->load->model('shipment_model');
        if (!$load_id) {
            $load_id = $this->input->post('load_id');
        }

        if (!$bol_number) {
            $bol_number = $this->input->post('bol_number');
        }

        if (!$pages_number) {
            $pages_number = $this->input->post('pages_number');
        }

        if (!$doc_type) {
            $doc_type = $this->input->post('doc_type');
        }

        $shipments = $this->shipment_model->get(['bol_number' => $bol_number]);
        $shipment = $shipments[0];

        if ($doc_type == 'sp') {
            $pages_number = $shipment['pickup_doc_pages'];
        }

        if ($doc_type == 'cs') {
            $pages_number = $shipment['drop_doc_pages'];
        }

        include('../testserver/MPDF53/mpdf.php');
        $mpdf = new mPDF();
        for ($i = 1; $i <= $pages_number; $i++) {
            $mpdf->WriteHTML('');
            if (file_exists(CONT_FILE_PATH . $load_id . '_bol_' . $bol_number . '_' . $doc_type . '-' . $i . '.jpg')) {
                $mpdf->Image(CONT_FILE_PATH . $load_id . '_bol_' . $bol_number . '_' . $doc_type . '-' . $i . '.jpg', 0, 0, 210, 297, 'jpg', '', true, false);
                if ($i < ($pages_number)) {
                    $mpdf->AddPage();
                }
            }
        }
        $url = CONT_FILE_PATH . $load_id . '_bol_' . $bol_number . '_' . $doc_type . '.pdf';
        $url_view = VIEW_FILE_PATH . $load_id . '_bol_' . $bol_number . '_' . $doc_type . '.pdf';
        $mpdf->Output($url, 'F');
        if ($json) {
            $this->output->set_output(json_encode(['status' => 1, 'url' => $url_view]));
        }
    }

    function multi_upload() {
        $customer = $this->input->post('customer');
        $carrier = $this->input->post('carrier');
        $driver = $this->input->post('driver');
        $loads = json_decode($this->input->post('loads'), true);

        $i = 0;
        $load_array = [];
        foreach ($loads as $load => $row) {
            $ids['idts_load'] = $row['idts_load'];
            $all[$i] = ['idts_load' => $row['idts_load']];
            $i++;
            array_push($load_array, ['idts_load' => $row['idts_load']]);
        }
        $age = array("Peter" => "35", "Ben" => "37", "Joe" => "43");
        print_r($load_array);
        print_r('AGE: ' . $age);
        $load_id = $this->load_model->update([
            'ts_carrier_idts_carrier' => $carrier,
            'ts_driver_idts_driver' => $driver,
            'ts_customer_idts_customer' => $customer,
            'status' => 1
                ], $load_array);
    }
    
    function update_status() {
        $id_ship = $this->input->post('id_ship');
        $status = $this->input->post('statu');
        $text_status = $this->input->post('text_status');
   
        $this->load->model('shipment_model');
        
        if ($text_status == 'Pickup') {
            $result = $this->shipment_model->update([
            'origin_sign' => $status,
            'origin_sign_date' => date("Y-m-d H:i:s")
            ], $id_ship);

        
            if ($result) {            
                $this->output->set_output(json_encode(['result' => 'Pickup']));
                return false;
            }

            $this->output->set_output(json_encode(['result' => 0, 'error' => 'Error updating']));
        }
        
        if ($text_status == 'Delivery') {
            $result = $this->shipment_model->update([
            'destination_sign' => $status,
            'destination_sign_date' => date("Y-m-d H:i:s")
            ], $id_ship);

        
            if ($result) {            
                $this->output->set_output(json_encode(['result' => 'Delivery']));
                return false;
            }

            $this->output->set_output(json_encode(['result' => 0, 'error' => 'Error updating']));
        }
        
        $this->output->set_output(json_encode(['result' => 0, 'error' => 'Error updating']));
    }

    function pdf_image($load_number) {
        $imagick = new Imagick();
        $imagick->setResolution(200, 200);
        $imagick->readImage(CONT_FILE_PATH . $load_number . '.pdf');
        $imagick->extentImage(1700, 2200, 0, 0);
        $imagick->setImageFormat('jpeg');
        $imagick->writeImage(CONT_FILE_PATH . $load_number . '.jpg');
    }

    function pdf() {
        $this->load->helper('pdf_helper');
        /*
          ---- ---- ---- ----
          your code here
          ---- ---- ---- ----
         */

        $data['class'] = $this->get_class_name();
        $data['user'] = $this->session->userdata('name');

        $this->load->view('load/pdfreport', $data);
    }

    public function register() {

        $this->output->set_content_type('application_json');

        //form validation

        $this->form_validation->set_rules('customer', 'Customer', 'required');
        $this->form_validation->set_rules('driver', 'Driver', 'required');
        $this->form_validation->set_rules('load_number', 'Load Number', 'required');
        $this->form_validation->set_rules('or_name', 'Origin Name', 'required');
        $this->form_validation->set_rules('or_address_1', 'Origin Address 1', 'required');
        $this->form_validation->set_rules('or_zipcode', 'Origin Zipcode', 'required');
        $this->form_validation->set_rules('or_city', 'Origin City', 'required');
        $this->form_validation->set_rules('or_state', 'Origin State', 'required');
        $this->form_validation->set_rules('or_country', 'Origin Country', 'required');
        $this->form_validation->set_rules('dt_name', 'Destination Name', 'required');
        $this->form_validation->set_rules('dt_address_1', 'Destination Address 1', 'required');
        $this->form_validation->set_rules('dt_zipcode', 'Destination Zipcode', 'required');
        $this->form_validation->set_rules('dt_city', 'Destination City', 'required');
        $this->form_validation->set_rules('dt_state', 'Destination State', 'required');
        $this->form_validation->set_rules('dt_country', 'Destination Country', 'required');
//        $this->form_validation->set_rules('name', 'Name', 'required|min_length[4]|max_length[32]');
//        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[4]|max_length[16]');
//        $this->form_validation->set_rules('login', 'Login', 'required|min_length[4]|max_length[16]|is_unique[user.login]');
//        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
//        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[16]|matches[confirm_password]');
//        $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
            return false;
        }

        $dr = $this->input->post('driver');
        $email = '';
        switch ($dr) {
            case "1":
                $email = "sergio@smith-cargo.com";
                break;
            case "2":
                $email = "hpena@leanstaffing.com";
                break;

            default:
//                echo "Your favorite color is neither red, blue, nor green!";
        }

        $status = 1;
        $customer = $this->input->post('customer');
        $carrier = $this->input->post('carrier');
        $driver = $this->input->post('driver');
        $load_number = $this->input->post('load_number');

//                echo $dt[0];
//        return false;'
        // --------------- Origin data --------------------

        $or_earliest = $this->input->post('or_earliest');
        $or_latest = $this->input->post('or_latest');
        $or_name = $this->input->post('or_name');
        $or_address_1 = $this->input->post('or_address_1');
        $or_address_2 = $this->input->post('or_address_2');
        $or_zipcode = $this->input->post('or_zipcode');
        $or_city = $this->input->post('or_city');
        $or_state = $this->input->post('or_state');
        $or_country = $this->input->post('or_country');
        $or_contact = $this->input->post('or_contact');
        $or_phone = $this->input->post('or_phone');
        $or_fax = $this->input->post('or_fax');
        $or_email = $this->input->post('or_email');
        $or_comments = $this->input->post('or_comments');
        $pk_lat = $this->input->post('origin_lat');
        $pk_lng = $this->input->post('origin_lng');

        // --------------- Destination data ---------------------

        $dt_earliest = $this->input->post('dt_earliest');
        $dt_latest = $this->input->post('dt_latest');
        $dt_name = $this->input->post('dt_name');
        $dt_address_1 = $this->input->post('dt_address_1');
        $dt_address_2 = $this->input->post('dt_address_2');
        $dt_zipcode = $this->input->post('dt_zipcode');
        $dt_city = $this->input->post('dt_city');
        $dt_state = $this->input->post('dt_state');
        $dt_country = $this->input->post('dt_country');
        $dt_contact = $this->input->post('dt_contact');
        $dt_phone = $this->input->post('dt_phone');
        $dt_fax = $this->input->post('dt_fax');
        $dt_email = $this->input->post('dt_email');
        $dt_comments = $this->input->post('dt_comments');
        $dp_lat = $this->input->post('destination_lat');
        $dp_lng = $this->input->post('destination_lng');

        $items = $this->input->post('items');

//        print_r(json_decode($items));
//        $this->insertItemsLoad(5, json_decode($items));
//        return false;

        $load_id = $this->load_model->insert([
            'user_iduser' => $this->session->userdata('user_id'),
            'ts_carrier_idts_carrier' => $carrier,
            'ts_driver_idts_driver' => $driver,
            'ts_customer_idts_customer' => $customer,
            'status' => $status,
            'load_number' => $load_number,
            'or_earliest' => $or_earliest,
            'or_latest' => $or_latest,
            'or_name' => $or_name,
            'or_address_1' => $or_address_1,
            'or_address_2' => $or_address_2,
            'or_zipcode' => $or_zipcode,
            'or_city' => $or_city,
            'or_state' => $or_state,
            'or_country' => $or_country,
            'or_contact' => $or_contact,
            'or_phone' => $or_phone,
            'or_fax' => $or_fax,
            'or_email' => $or_email,
            'or_comments' => $or_comments,
            'dt_earliest' => $dt_earliest,
            'dt_latest' => $dt_latest,
            'dt_name' => $dt_name,
            'dt_address_1' => $dt_address_1,
            'dt_address_2' => $dt_address_2,
            'dt_zipcode' => $dt_zipcode,
            'dt_city' => $dt_city,
            'dt_state' => $dt_state,
            'dt_country' => $dt_country,
            'dt_contact' => $dt_contact,
            'dt_phone' => $dt_phone,
            'dt_fax' => $dt_fax,
            'dt_email' => $dt_email,
            'dt_comments' => $dt_comments,
            'pk_lat' => $pk_lat,
            'pk_lng' => $pk_lng,
            'dp_lat' => $dp_lat,
            'dp_lng' => $dp_lng,
        ]);

        if ($load_id) {
            $param['email'] = $email;
            $param['customer'] = $customer;
            $param['origin'] = $or_address_1 . ' ' . $or_city . ' ' . $or_state . ' ' . $or_zipcode;
            $param['destination'] = $dt_address_1 . ' ' . $dt_city . ' ' . $dt_state . ' ' . $dt_zipcode;
            $this->insertItemsLoad($load_id, json_decode($items));
            $this->send_mail($param);
            $this->output->set_output(json_encode(['result' => 1]));
            return false;
        }

        $this->output->set_output(json_encode(['result' => 0, 'error' => 'Load not created.']));
    }

    public function update($id) {
        $this->load->model('driver_model');
        $this->load->model('customer_model');
        $this->load->model('item_model');

        $data['drivers'] = $this->driver_model->get();
        $data['items'] = $this->item_model->get([
            'ts_load_idts_load' => $id
        ]);
        $data['user'] = $this->session->userdata('name');
        $data['customers'] = $this->customer_model->get();
        $data['class'] = $this->get_class_name();
        $loads = $this->get_load_view($id, $sw = 1);
        $data['load'] = $loads[0];
        $data['status'] = [
            1 => 'To Pick UP',
            2 => 'Loaded',
            3 => 'On Schedule',
            4 => 'Behind Schedule',
            5 => 'Canceled',
            6 => 'Delivered',
        ];
        $this->load->view('general/inc/header_view', $data);
        $this->load->view('load/update_view');
        $this->load->view('general/inc/footer_view');
    }

    public function update_load() {

        $this->output->set_content_type('application_json');
        //form validation

        $this->form_validation->set_rules('customer', 'Customer', 'required');
        $this->form_validation->set_rules('driver', 'Driver', 'required');
        $this->form_validation->set_rules('load_number', 'Load Number', 'required');
        $this->form_validation->set_rules('or_name', 'Origin Name', 'required');
        $this->form_validation->set_rules('or_address_1', 'Origin Address 1', 'required');
        $this->form_validation->set_rules('or_zipcode', 'Origin Zipcode', 'required');
        $this->form_validation->set_rules('or_city', 'Origin City', 'required');
        $this->form_validation->set_rules('or_state', 'Origin State', 'required');
        $this->form_validation->set_rules('or_country', 'Origin Country', 'required');
        $this->form_validation->set_rules('dt_name', 'Destination Name', 'required');
        $this->form_validation->set_rules('dt_address_1', 'Destination Address 1', 'required');
        $this->form_validation->set_rules('dt_zipcode', 'Destination Zipcode', 'required');
        $this->form_validation->set_rules('dt_city', 'Destination City', 'required');
        $this->form_validation->set_rules('dt_state', 'Destination State', 'required');
        $this->form_validation->set_rules('dt_country', 'Destination Country', 'required');
//        $this->form_validation->set_rules('name', 'Name', 'required|min_length[4]|max_length[32]');
//        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[4]|max_length[16]');
//        $this->form_validation->set_rules('login', 'Login', 'required|min_length[4]|max_length[16]|is_unique[user.login]');
//        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
//        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[16]|matches[confirm_password]');
//        $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
            return false;
        }

        $dr = $this->input->post('driver');
        $email = '';
        switch ($dr) {
            case "1":
                $email = "fparker@smith-cargo.com";
                break;
            case "2":
                $email = "robert@leanstaffing.com";
                break;
            case "3":
                $email = "willmar@leanstaffing.com";
                break;
            case "4":
                $email = "hpena@leanstaffing.com";
                break;
            case "5":
                $email = "lmorillo@leanstaffing.com";
                break;

            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }



        $load_id = $this->input->post('load_id');
        $status = $this->input->post('status');
        $customer = $this->input->post('customer');
        $driver = $this->input->post('driver');
        $load_number = $this->input->post('load_number');

//                echo $dt[0];
//        return false;'
        // --------------- Origin data --------------------

        $or_earliest = $this->input->post('or_earliest');
        $or_latest = $this->input->post('or_latest');
        $or_name = $this->input->post('or_name');
        $or_address_1 = $this->input->post('or_address_1');
        $or_address_2 = $this->input->post('or_address_2');
        $or_zipcode = $this->input->post('or_zipcode');
        $or_city = $this->input->post('or_city');
        $or_state = $this->input->post('or_state');
        $or_country = $this->input->post('or_country');
        $or_contact = $this->input->post('or_contact');
        $or_phone = $this->input->post('or_phone');
        $or_fax = $this->input->post('or_fax');
        $or_email = $this->input->post('or_email');
        $or_comments = $this->input->post('or_comments');
        $pk_lat = $this->input->post('origin_lat');
        $pk_lng = $this->input->post('origin_lng');

        // --------------- Destination data ---------------------

        $dt_earliest = $this->input->post('dt_earliest');
        $dt_latest = $this->input->post('dt_latest');
        $dt_name = $this->input->post('dt_name');
        $dt_address_1 = $this->input->post('dt_address_1');
        $dt_address_2 = $this->input->post('dt_address_2');
        $dt_zipcode = $this->input->post('dt_zipcode');
        $dt_city = $this->input->post('dt_city');
        $dt_state = $this->input->post('dt_state');
        $dt_country = $this->input->post('dt_country');
        $dt_contact = $this->input->post('dt_contact');
        $dt_phone = $this->input->post('dt_phone');
        $dt_fax = $this->input->post('dt_fax');
        $dt_email = $this->input->post('dt_email');
        $dt_comments = $this->input->post('dt_comments');
        $dp_lat = $this->input->post('destination_lat');
        $dp_lng = $this->input->post('destination_lng');

        $items = $this->input->post('items');
//        print_r(json_decode($items));
//        $this->insertItemsLoad(5, json_decode($items));
//        return false;

        $load_affedted = $this->load_model->update([
            'user_iduser' => $this->session->userdata('user_id'),
            'ts_driver_idts_driver' => $driver,
            'status' => $status,
            'ts_customer_idts_customer' => $customer,
            'load_number' => $load_number,
            'or_earliest' => $or_earliest,
            'or_latest' => $or_latest,
            'or_name' => $or_name,
            'or_address_1' => $or_address_1,
            'or_address_2' => $or_address_2,
            'or_zipcode' => $or_zipcode,
            'or_city' => $or_city,
            'or_state' => $or_state,
            'or_country' => $or_country,
            'or_contact' => $or_contact,
            'or_phone' => $or_phone,
            'or_fax' => $or_fax,
            'or_email' => $or_email,
            'or_comments' => $or_comments,
            'dt_earliest' => $dt_earliest,
            'dt_latest' => $dt_latest,
            'dt_name' => $dt_name,
            'dt_address_1' => $dt_address_1,
            'dt_address_2' => $dt_address_2,
            'dt_zipcode' => $dt_zipcode,
            'dt_city' => $dt_city,
            'dt_state' => $dt_state,
            'dt_country' => $dt_country,
            'dt_contact' => $dt_contact,
            'dt_phone' => $dt_phone,
            'dt_fax' => $dt_fax,
            'dt_email' => $dt_email,
            'dt_comments' => $dt_comments,
            'pk_lat' => $pk_lat,
            'pk_lng' => $pk_lng,
            'dp_lat' => $dp_lat,
            'dp_lng' => $dp_lng,
                ], $load_id);


        $items_affected = $this->update_load_items($load_id, json_decode($items));
        if ($load_affedted || $items_affected) {
            $this->output->set_output(json_encode(['result' => 1]));
            return false;
        }

        $this->output->set_output(json_encode(['result' => 0, 'notice' => 'Load or items not updated.']));
    }

    public function update_load_items($load_id, $items) {
        $this->load->model('item_model');

        $this->item_model->delete([
            'ts_load_idts_load' => $load_id
        ]);
        $i = 0;
        $item_value = [];
        print_r($items);
        foreach ($items as $item) {
            $item_data = [
                'ts_load_idts_load' => $load_id,
                'name' => $item->quantity . '@' . $item->length . 'x' . $item->width . 'x' . $item->height . ' cl' . $item->class . ' ' . $item->weight . $item->weight_unit,
                'class' => $item->class,
                'quantity' => $item->quantity,
                'quantity_unit' => $item->quantity_unit,
                'weight' => $item->weight,
                'weight_unit' => $item->weight_unit,
                'length' => $item->length,
                'width' => $item->width,
                'height' => $item->height
            ];

            $item_value[$i] = $item_data;
            $i++;
        }

        $this->item_model->insertBatch($item_value);
    }

    public function update2($id) {
        $this->_required_login($this->router->fetch_class(), $this->router->fetch_method());

        $data = $this->get_session_user_data();
        $data['roles'] = $GLOBALS['roles'];
        $data['load'] = $this->load_model->get($id);
        $data['load'] = $data['load'][0];


        $this->load->model('carrier_model');
        $data['carriers'] = $this->carrier_model->get();

        $this->load->model('driver_model');
        $data['drivers'] = $this->driver_model->get([
            'ts_carrier_idts_carrier' => $data['load']['ts_carrier_idts_carrier'],
            'status' => 1
        ]);

//        $this->output->set_output(json_encode($data['drivers']));
//
//        return false;

        $this->load->model('customer_model');
        $data['customers'] = $this->customer_model->get();

        $this->load->model('shipment_model');
        $shipments = $this->shipment_model->get_shipment(['ts_load_idts_load' => $id]);

        for ($i = 0; $i < count($shipments); $i++) {
//            $result[$i]['items'] = $this->get_items_by_load_id($result[$i]['idts_load']);

            $shipments[$i]['customer_contacts'] = $this->shipment_customer_contacts($shipments[$i]['ts_customer_idts_customer']);
            $shipments[$i]['selected_customer_contacts'] = $this->get_shipment_contacts($shipments[$i]['idshipment']);
        }

        $data['shipments'] = $shipments;

//        $this->output->set_output(json_encode($data['shipments']));
//        return false;

        $data['file'] = file_exists(CONT_FILE_PATH . $data['load']['load_number'] . '.pdf');

        $data['error'] = '';

        $this->load->view('general/inc/header_view', $data);
        $this->load->view('load/update2_view');
        $this->load->view('general/inc/footer_view');
    }

    public function shipment_customer_contacts($customer_id, $json = null) {
        $this->load->model('customer_contact_model');
        $contacts = $this->customer_contact_model->get(['ts_customer_idts_customer' => $customer_id]);
        if ($json) {
            $this->output->set_output(json_encode($contacts));
        }
        return $contacts;
    }

    public function delete_file($file) {
        $this->_required_login();
        $result = unlink(CONT_FILE_PATH . $file . '.pdf');
        $result = unlink(CONT_FILE_PATH . $file . '.jpg');

        if ($result) {
            $this->output->set_output(json_encode(['result' => 1]));
            return false;
        }
        $this->output->set_output(json_encode(['result' => 0]));
    }

    public function get_load($id = null) {
        $this->_required_login();
        if ($id != null) {
            $result = $this->load_model->get([
                'driver' => $id
            ]);
        } else {
            $result = $this->load_model->get();
        }

        $this->output->set_output(json_encode($result));
    }

    /**
     * This function is for the app
     * @param type $id
     */
    public function get_load_view($where = null, $json = null, $sw = null, $order_by = null, $order = null, $limit = null, $start = null, $total = null) {
        $this->_required_login();
        $this->load->model('item_model');

        // check if request comes from this controller
        $user_id = 0;
        $user = $this->get_session_user_data();
        if ($this->input->post('user_id')) {
            $user_id = $this->input->post('user_id');
        } else {
            $user_id = $user['user_id'];
        }

        // Check if where and make it array
        if (!$where) {
            $where = [];
            $customer = $this->input->post('search_customer');
            $carrier = $this->input->post('search_carrier');
            $load_number = $this->input->post('search_load_number');

            if ($carrier != 0)
                $where['ts_load.ts_carrier_idts_carrier'] = $carrier;

            if ($load_number != '') {
                $where['load_number'] = $load_number;
                $where['ts_driver.full_name'] = $load_number;
                $where['ts_carrier.name'] = $load_number;
            }
        }
//        print_r($where);
        //check if user can see brother's loads
        if ($user['brother']) {
            // get childs of the current user
            $childs = $this->recursive($user['parent']);
            //add current user to the array
            array_push($childs, $user_id);
        } else {
            // get childs of the current user
            $childs = $this->recursive($user_id);
            //add current user to the array
            array_push($childs, $user_id);
        }

        $result = $this->load_model->get_load_view($where, $childs, $sw, $order_by, $order, $limit, $start);
        if ($limit) {
            for ($i = 0; $i < count($result); $i++) {
//            $result[$i]['items'] = $this->get_items_by_load_id($result[$i]['idts_load']);
                $result[$i]['status'] = $this->load_status($result[$i]['idts_load'], $result[$i]['tender']);
                if ($result[$i]['driver_latitud'] && $result[$i]['driver_longitud']) {
					if (($result[$i]['driver_latitud']==0)&& ($result[$i]['driver_longitud']==0)){
						$result[$i]['driver_address'] = 'No location available for this driver yet.';
						}else{
                    $driver_address = json_decode($this->get_driver_address($result[$i]['driver_latitud'], $result[$i]['driver_longitud']));
                    $result[$i]['driver_address'] = $driver_address->results[0]->formatted_address;
					}
                } else {
                    $result[$i]['driver_address'] = 'Driver has not log in the app.';
                }

                $result[$i]['shipments'] = $this->shipments_by_load($result[$i]['idts_load']);
            }
        }

        if ($json) {
            $this->output->set_output(json_encode($result));
            return false;
        }
        return $result;
    }
//---------
// Get all the load id's
//---------
	public function get_load_view_all($where = null, $json = null, $sw = null, $order_by = null, $order = null, $start = null, $total = null){
        $this->_required_login();
        $this->load->model('item_model');

        // check if request comes from this controller
        $user_id = 0;
        $user = $this->get_session_user_data();
        if ($this->input->post('user_id')) {
            $user_id = $this->input->post('user_id');
        } else {
            $user_id = $user['user_id'];
        }

        // Check if where and make it array
/*        if (!$where) {
            $where = [];
            $customer = $this->input->post('search_customer');
            $carrier = $this->input->post('search_carrier');
            $load_number = $this->input->post('search_load_number');

            if ($carrier != 0)
                $where['ts_load.ts_carrier_idts_carrier'] = $carrier;

            if ($load_number != '') {
                $where['load_number'] = $load_number;
                $where['ts_driver.full_name'] = $load_number;
                $where['ts_carrier.name'] = $load_number;
            }
        }*/
//        print_r($where);
        //check if user can see brother's loads
        if ($user['brother']) {
            // get childs of the current user
            $childs = $this->recursive($user['parent']);
            //add current user to the array
            array_push($childs, $user_id);
        } else {
            // get childs of the current user
            $childs = $this->recursive($user_id);
            //add current user to the array
            array_push($childs, $user_id);
        }

        $result = $this->load_model->get_load_view_all($where, $childs, $sw, $order_by, $order, $start);
       
            for ($i = 0; $i < count($result); $i++) {
//            $result[$i]['items'] = $this->get_items_by_load_id($result[$i]['idts_load']);
                $result[$i]['status'] = $this->load_status($result[$i]['idts_load'], $result[$i]['tender']);
              /*  if ($result[$i]['driver_latitud'] && $result[$i]['driver_longitud']) {
					if (($result[$i]['driver_latitud']==0)&& ($result[$i]['driver_longitud']==0)){
						$result[$i]['driver_address'] = 'No location available for this driver yet.';
						}else{
                    //$driver_address = json_decode($this->get_driver_address($result[$i]['driver_latitud'], $result[$i]['driver_longitud']));
                    //$result[$i]['driver_address'] = $driver_address->results[0]->formatted_address;
					}
                } else {
                    $result[$i]['driver_address'] = 'Driver has not logged in the app.';
                }*/

               // $result[$i]['shipments'] = $this->shipments_by_load($result[$i]['idts_load']);
			}
			
        if ($json) {
            $this->output->set_output(json_encode($result));
            return false;
        }
        return $result;
    }

    public function shipments_by_load($load_id, $json = null) {
        $this->load->model('shipment_model');
        $shipments = $this->shipment_model->get_shipment(['ts_load_idts_load' => $load_id]);
        if ($json) {
            $this->output->set_output(json_encode($shipments));
        }
        return $shipments;
    }

    public function load_status($load_id, $tender, $json = null) {
        $this->load->model('shipment_model');
        $status = '';
        $cont = 0;
        if ($tender == 1) {
            $status = 'To Pickup';
            $shipments = $this->shipment_model->get(['ts_load_idts_load' => $load_id]);
            $total_shipments = count($shipments);
            $total_signs = $total_shipments * 2;

            if (count($shipments) > 0) {
                foreach ($shipments as $shipment => $row) {
                    if ($row['origin_sign'] == 1) {
                        $cont++;
                    } else {
                        $cont = $cont + 0;
                    }

                    if ($row['destination_sign'] == 1) {
                        $cont++;
                    } else {
                        $cont = $cont + 0;
                    }
                }

                if (($cont > 0) && ($cont < $total_signs)) {
                    $status = 'In transit';
                } else if ($cont == $total_signs) {
                    $status = 'Delivered';
                }
            }
        } else {
            $status = 'Not tendered';
        }

        if ($json) {
            $this->output->set_output(json_encode(['status' => $total_shipments]));
        }
        return $status;
    }

    public function get_driver_position($id, $sw = null, $load_id = null, $trace_start = null) {
        $this->load->model('driver_model');

        if (!$load_id) {
            $load_id = $this->input->post('load_id');
        }

        if (!$trace_start) {
            $trace_start = $this->input->post('trace_start');
        }

        $driver = $this->driver_model->get($id);
        $driver = $driver[0];
        $driver_address = json_decode($this->get_driver_address($driver['lat'], $driver['lng']), true);
        $driver_address['trace'] = $this->get_load_trace($load_id, 0, 40, 0);
//        array_push($driver_address, $this->get_load_trace($load_id));
        if ($sw) {
            $this->output->set_output(json_encode($driver_address));
            return false;
        }

        return $driver_address;
    }

    public function get_driver_address($lat, $lng, $json = null, $id_trace = null, $db = null) {
        $ch = curl_init();
        $var = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&key=AIzaSyAp8XadZn74QX4NLDphnzehQ0AN7q6NCwg';
//        echo 'url '.$var;

        curl_setopt($ch, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&key=AIzaSyAp8XadZn74QX4NLDphnzehQ0AN7q6NCwg');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $output = curl_exec($ch);
        curl_close($ch);

        if ($db) {
            $this->load->model('load_trace_model');
            $driver_position = json_decode($output);
            $this->load_trace_model->update(['address_text' => $driver_position->results[0]->formatted_address], $id_trace);
        }

        if ($json) {
            $this->output->set_output($output);
            return false;
        }

        return $output;
    }

    public function get_google_address($address, $zipcode) {
        $ch = curl_init();
        $address_zipcode = $address . ', ' . $zipcode;
        $url_address = str_replace(" ", "+", $address_zipcode);
        $var = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $url_address . '&key=AIzaSyAp8XadZn74QX4NLDphnzehQ0AN7q6NCwg';
//        echo 'url '.$var;

        curl_setopt($ch, CURLOPT_URL, $var);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    /**
     * This function is for the app
     * @param type $id
     */
    public function app_get_load_view($id = null, $sw = null) {
        //$this->load->model('item_model');

        header('Access-Control-Allow-Origin: *');
        if ($id != null) {
            $result = $this->load_model->get_load_view([
                'idts_load' => $id
            ]);
            $result[0]['items'] = $this->get_items_by_load_id($result[0]['idts_load']);
        } else {
            $result = $this->load_model->get_load_view();
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['items'] = $this->get_items_by_load_id($result[$i]['idts_load']);
            }
        }
        if (!$sw) {
            $this->output->set_output(json_encode($result));
        }
        return $result;
    }

    public function get_items_by_load_id($id) {
        $this->load->model('item_model');
        $result = $this->item_model->get_items_by_load_id($id);
        return $result;
    }

    /**
     * This function is for the app
     * @param type $id
     */
    public function app_get_load_by_driver($id_driver, $sw = null) {
       // $this->load->model('item_model');
        header('Access-Control-Allow-Origin: *');

        $result = $this->load_model->get_load_view_app([
            'ts_driver_idts_driver' => $id_driver
                ], 0, 1, 'date_created', 'desc');
//        if ($result)
//            $result[0]['items'] = $this->get_items_by_load_id($result[0]['idts_load']);
        if (!$sw) {
            $this->output->set_output(json_encode($result));
        }

        return $result;
    }

    /**
     * This function is for the app
     * @param type $id
     */
    public function app_get_load_id($id = null) {
        $this->load->model('item_model');

        header('Access-Control-Allow-Origin: *');
        if ($id != null) {
            $result = $this->load_model->get($id);
        } else {
            $result = $this->load_model->get();
        }

        $result_array = $result;

        if ($result) {
            $result_item = $this->item_model->get([
                'ts_load_idts_load' => $result[0]['idts_load']
            ]);
            $result_array = array_merge($result, $result_item);
        }

        $this->output->set_output(json_encode($result_array));
    }

    public function app_get_shipments_by_id($id) {
        $this->load->model('shipment_model');
        header('Access-Control-Allow-Origin: *');

        $result = $this->shipment_model->get($id);

        $this->output->set_output(json_encode($result));
    }
    
    //---- Request location----//
    public function app_get_requests_by_id($id) {
           $this->load->model('location_request_model');
           header('Access-Control-Allow-Origin: *');

           $result = $this->location_request_model->get($id);

           $this->output->set_output(json_encode($result));
       }

    //---- END OF Request location----//

    public function app_get_shipments_by_load($load_id) {
        $this->load->model('shipment_model');
        header('Access-Control-Allow-Origin: *');

        $result = $this->shipment_model->get([
            'ts_load_idts_load' => $load_id
        ]);

        $this->output->set_output(json_encode($result));
    }

    public function app_get_docs_by_shipment($shipment_id) {
        header('Access-Control-Allow-Origin: *');
        $this->load->model('shipment_document');
        $result = $this->shipment_document->get(['shipment_idshipment' => $shipment_id]);
        $this->output->set_output(json_encode($result));
    }

    public function insertItemsLoad($id, $items) {
        $this->load->model('item_model');
        $i = 0;
        $item_value = [];
        foreach ($items as $item) {
            $item_data = [
                'ts_load_idts_load' => $id,
                'name' => $item->quantity . '@' . $item->length . 'x' . $item->width . 'x' . $item->height . ' cl' . $item->class . ' ' . $item->weight . $item->weight_unit,
                'description' => $item->description,
                'class' => $item->class,
                'quantity' => $item->quantity,
                'quantity_unit' => $item->quantity_unit,
                'weight' => $item->weight,
                'weight_unit' => $item->weight_unit,
                'length' => $item->length,
                'width' => $item->width,
                'height' => $item->height,
            ];

            $item_value[$i] = $item_data;
            $i++;
        }

        $this->item_model->insertBatch($item_value);
    }

    public function send_mail($param) {
        $email = $param['email'];
        $customer = $param['customer'];
        $origin = $param['origin'];
        $destination = $param['destination'];

        $to = "$email";
        $subject = "Load assigned";
// Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
        $headers .= 'From: <service@smith.com>' . "\r\n";

        $message = '<div><h1>Smith Transportation</h1></div>
                        <p>Load assigned to you</p>
                        <ul>
                            <li>Customer: ' . $customer . '</li>
                            <li>Origin: ' . $origin . '</li>
                            <li>Destination: ' . $destination . '</li>
                        </ul>
                        <p>Check the smith app to see load details.</p>';
        mail($to, $subject, $message, $headers);
    }

    public function send_mail_2($param) {
        $this->load->library('email');

        $email = $param['email'];
        $customer = $param['customer'];
        $load_number = $param['load_number'];

        $this->email->from('service@smith-cargo.com', 'Smith Transportation');
        $this->email->to($email);
//        $this->email->cc('another@another-example.com');
//        $this->email->bcc('them@their-example.com');

        $this->email->subject('Load #' . $load_number);
        $this->email->message('<div><h1>Smith Transportation</h1></div>
                        <p>Load assigned to you</p>
                        <ul>
                            <li>Customer: ' . $customer . '</li>
                        </ul>
                        <p>Check BOl attached.</p>');
        $this->email->attach(CONT_FILE_PATH . $load_number . '.pdf');
        $this->email->set_mailtype("html");

        if (!$this->email->send()) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
        }
    }

    //-------------------- Call Checks ---------------------

    public function save_callcheck($user_id = null, $load_id = null, $type = null, $driver = null, $comment = null, $driver_lat = null, $driver_lng = null, $notify_driver = null, $driver_email = null, $load_number = null, $sw = null) {
        date_default_timezone_set("America/New_York");

        if (!$comment) {
            $comment = $this->input->post('comment');
        }

        if (!$notify_driver) {
            $notify_driver = $this->input->post('notify_driver');
        }

        if (!($driver_lat && $driver_lng)) {
            $driver_lat = $this->input->post('driver_latitud');
            $driver_lng = $this->input->post('driver_loingitude');
        }

        if (!$driver_email) {
            $driver_email = $this->input->post('driver_email');
        }

        if (!$load_number) {
            $load_number = $this->input->post('load_number');
        }

        $driver_position = json_decode($this->get_driver_address($driver_lat, $driver_lng));
        $driver_address = $driver_position->results[0]->formatted_address;
        $driver_address = explode(',', $driver_address);

        $this->load->model('callcheck_model');
        $this->callcheck_model->insert([
            'user_iduser' => $user_id,
            'ts_load_idts_load' => $load_id,
            'type' => $type,
            'notify_driver' => $notify_driver,
            'driver' => $driver,
            'comment' => $comment,
            'city' => $driver_address[1],
            'state' => $driver_address[2],
            'country' => $driver_address[3],
            'date' => date("Y-m-d H:i:s")
        ]);
        $data = $this->get_session_user_data();

        $date = explode(' ', date("Y-m-d H:i:s"));
        $date_formated_temp = explode('-', $date[0]);
        $date_formated = $date_formated_temp[1] . '/' . $date_formated_temp[0] . '/' . $date_formated_temp[2];

        $result = [
            'date' => $date_formated,
            'time' => $date[1],
            'city' => $driver_address[1],
            'state' => $driver_address[2],
            'country' => $driver_address[3],
            'comment' => $comment,
            'entered_by' => $data['login']
        ];

        $param['load_number'] = $load_number;
        $param['email'] = $driver_email;
        $param['comment'] = $comment;
        $this->send_callcheck_mail($param);

        if (!$sw) {
            $this->output->set_output(json_encode($result));
            return false;
        }
        return $result;
    }
    
    public function checked_read() {
        date_default_timezone_set("America/New_York");
        
        $idts = $this->input->post('idts');
        $read = $this->input->post('read');
        
        $this->load->model('callcheck_model');
        $result = $this->callcheck_model->update(['read' => $read], ['idts_callcheck' => $idts]);
        
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Callcheck added.']));
            return false;
        }
        $this->output->set_output(json_encode(['result' => 0, 'error' => 'Callcheck not added']));
    }

    public function email_callcheck_view() {
        $this->load->view('load/callcheck_email_view');
    }

    public function send_callcheck_mail($param) {
        $this->load->library('email');

        $data['email'] = $param['email'];
        $data['load_number'] = $param['load_number'];
        $data['comment'] = $param['comment'];
        $user = $this->get_session_user_data();
        $data['user'] = $user['user'];

        $msg = $this->load->view('load/callcheck_email_view', $data, true);
        $this->email->from('service@smith-cargo.com', 'Smith Transportation');
        $this->email->to($data['email']);
        //$this->email->cc('another@another-example.com');
        //$this->email->bcc('them@their-example.com');

        $this->email->subject('Callcheck in Load #' . $data['load_number']);
        $this->email->message($msg);
        $this->email->set_mailtype("html");

        if (!$this->email->send()) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
        }
    }

    public function get_callcheck($id_load, $sw = null) {
        $this->load->model('callcheck_model');
        $result = $this->callcheck_model->get([
            'ts_load_idts_load' => $id_load
                ], 'date', 'asc');
        $this->output->set_output(json_encode($result));
    }

    //generic php function to send GCM push notification
    public function send_push_not() {
        date_default_timezone_set("America/New_York");

        $load_number = $this->input->post('load_number');

        $this->load->model('driver_model');
        $drivers = $this->driver_model->get($this->input->post('driver_id'));
        $driver = $drivers[0];

        $driver_lat = $driver['lat'];
        $driver_lng = $driver['lng'];
        $driver_mail = $driver['email'];
        $apns_number = $driver['apns_number'];
        $app_id = $driver['app_id'];


//         $registatoin_ids[0] = $this->input->post('status');
        $title = $this->input->post('title');
        $message = $this->input->post('msg');
        $apple_msg = 'Msg load #' . $load_number . '-' . $message;
        $load_id = $this->input->post('load_id');
        $registatoin_ids[0] = $app_id;

        if ($apns_number || $app_id) {
            //Apple notification
            if ($apns_number) {
                $result['result'] = $this->send_apple_not($apns_number, $load_number, $apple_msg);
            }
            //Android notification
            if ($app_id) {
                $result['result'] = json_decode($this->send_android_not($registatoin_ids, $title, $message));
            }
        } else {
            return $this->output->set_output(json_encode(['status' => 0, 'msg' => 'Apple or Android id not found']));
        }

        //Save in database
        $ck = $this->save_callcheck($this->session->userdata('user_id'), $load_id, 1, 0, $message, $driver_lat, $driver_lng, 1, $driver_mail, $load_number, 1);
        $result['dbresult'] = $ck;

//        return $this->output->set_output(json_encode($ck));
        return $this->output->set_output(json_encode($result));
    }

    public function test($param) {
        $data = $param;
        $whatIWant = substr($data, strpos($data, "-") + 1);
        echo $whatIWant;
    }

    public function tender($load_number, $driver_id, $push = null, $email = null) {
        $this->load_model->update(['tender' => 1], ['load_number' => $load_number]);

//        if (!$push) {
//            $this->load->model('driver_model');
//            $drivers = $this->driver_model->get($driver_id);
//            $driver = $drivers[0];
//            $this->push_not_new_load($load_number, $driver['app_id'], $driver['apns_number']);
//        }
//
//        $param['email'] = $email;
//        $param['load_number'] = $load_number;
//        $this->send_tender_mail($param);
//        $this->output->set_output(json_encode(['status' => '1', 'msg' => 'Load sucesfully tendered']));
    }

    public function send_tender_mail($param) {
        $this->load->library('email');

        $email = $param['email'];
        $load_number = $param['load_number'];

        $this->email->from('service@smith-cargo.com', 'Smith Transportation');
        $this->email->to($email);
//        $this->email->cc('another@another-example.com');
//        $this->email->bcc('them@their-example.com');

        $this->email->subject('Tender Load #' . $load_number);
        $this->email->message('<div><h1>Smith Transportation</h1></div>
                        <p>Load has been tendered to you</p>
                        <ul>
                            <li>Please seek for load #: ' . $load_number . ' in your app.</li>
                        </ul>
                        <p>Check BOl attached.</p>');
//        $this->email->attach(CONT_FILE_PATH . $load_number . '.pdf');
        $this->email->set_mailtype("html");

        if (!$this->email->send()) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
        } else {
            $this->output->set_output(json_encode(['status' => '1', 'msg' => 'Tender Email succesfully sent']));
        }
    }

    public function push_not_custom_msg_load($load_number = null, $msg = null, $android_title = null, $tender = null, $email = null, $load_id = null, $driver_id = null) {
        $msg_request = $this->input->post('msg');
        $load_num = $this->input->post('load_number');
        
        if ($msg_request == 'Location request #'.$load_num) {
            $load_num = $this->input->post('load_number');
            if (!$load_number) {
                $load_number = $this->input->post('load_number');
            }

            if (!$load_id) {
                $load_id = $this->input->post('load_id');
            }

            if (!$driver_id) {
                $driver_id = $this->input->post('driver_id');
            }

            if (!$msg) {
                $msg = $msg_request;
            }

            $android_msg = $msg;
            $apple_msg = $msg;

            if (!$android_title) {
                $android_title = $this->input->post('android_title');
            }

            if (!$tender) {
                $tender = $this->input->post('tender');
            }

            if ($tender) {
                $android_msg = 'New load #' . $load_number . ' - ' . $msg;
                $apple_msg = 'New load #' . $load_number . ' - ' . $msg;
            }

            if (!$email) {
                $email = $this->input->post('email');
            }

            $this->load->model('driver_model');
            $drivers = $this->driver_model->get($driver_id);
            $driver = $drivers[0];
            $apns_number = $driver['apns_number'];
            $app_id = $driver['app_id'];
            $driver_phone = $driver['phone'];
            $email = $driver['email'];

            $registatoin_ids[0] = $app_id;

            if ($apns_number || $app_id) {
                //Apple notification
                if ($apns_number) {
                    $result = $this->send_apple_not($apns_number, $load_number, $apple_msg);
    //                $this->output->set_output(json_encode(['apple msg' => $apple_msg]));
                }

                //Android notification
                if ($app_id) {
                    $result = $this->send_android_not($registatoin_ids, $android_title, $android_msg);
                }

                //if tender
                if ($tender) {
                    $this->tender($load_number, 1, 1, $email);
                    //change load status              
                }

                $data = $msg;
                $msg_split = substr($data, strpos($data, "-") + 1);
                //$ck = $this->save_callcheck($this->session->userdata('user_id'), $load_id, 1, 0, $msg_split, 26.13778000, -80.33429800, 1, $email, $load_number, 1);
                //$result = array("status" => "1", "dbresult" => $ck);
                $result = array("status" => "1");
                $this->output->set_output(json_encode($result));
            } else {
                return $this->output->set_output(json_encode(['status' => 0, 'msg' => 'Driver has not login or install the application. Contact driver phone: ' . $driver_phone]));
            }
            
            return $result;
        }
        
        if (!$load_number) {
            $load_number = $this->input->post('load_number');
        }

        if (!$load_id) {
            $load_id = $this->input->post('load_id');
        }

        if (!$driver_id) {
            $driver_id = $this->input->post('driver_id');
        }

        if (!$msg) {
            $msg = $this->input->post('msg');
        }

        $android_msg = $msg;
        $apple_msg = $msg;

        if (!$android_title) {
            $android_title = $this->input->post('android_title');
        }

        if (!$tender) {
            $tender = $this->input->post('tender');
        }

        if ($tender) {
            $android_msg = 'New load #' . $load_number . ' - ' . $msg;
            $apple_msg = 'New load #' . $load_number . ' - ' . $msg;
        }

        if (!$email) {
            $email = $this->input->post('email');
        }

        $this->load->model('driver_model');
        $drivers = $this->driver_model->get($driver_id);
        $driver = $drivers[0];
        $apns_number = $driver['apns_number'];
        $app_id = $driver['app_id'];
        $driver_phone = $driver['phone'];
        $email = $driver['email'];

        $registatoin_ids[0] = $app_id;

        if ($apns_number || $app_id) {
            //Apple notification
            if ($apns_number) {
                $result = $this->send_apple_not($apns_number, $load_number, $apple_msg);
//                $this->output->set_output(json_encode(['apple msg' => $apple_msg]));
            }

            //Android notification
            if ($app_id) {
                $result = $this->send_android_not($registatoin_ids, $android_title, $android_msg);
            }

            //if tender
            if ($tender) {
                $this->tender($load_number, 1, 1, $email);
                //change load status              
            }

            $data = $msg;
            $msg_split = substr($data, strpos($data, "-") + 1);
            $ck = $this->save_callcheck($this->session->userdata('user_id'), $load_id, 1, 0, $msg_split, 26.13778000, -80.33429800, 1, $email, $load_number, 1);
            $result = array("status" => "1", "dbresult" => $ck);
            $this->output->set_output(json_encode($result));
        } else {
            return $this->output->set_output(json_encode(['status' => 0, 'msg' => 'Driver has not login or install the application. Contact driver phone: ' . $driver_phone]));
        }
        return $result;
    }
    
    public function control_req() {
        
        $id_load = $this->input->post('load_id');
        
        $resultado = $this->location_request_model->get_max_request_number($id_load);
                
        //$this->output->set_output(json_encode($max_req_number));
        $resu = $resultado[0];
        $id_req = $resu['id_request'];
        $req_load = $resu['request_load'];
        $req_num = $resu['request_number'];
        $reset = $resu['reset'];
        $secuencia = $req_num + 1;

        //$this->output->set_output(json_encode(['id_request' => $id_req, 'request_load' => $req_load, 'request_number' => $req_num, 'reset' => $reset, 'secuencia' => $secuencia]));
        
        if ($secuencia <= 5) {
            //$this->output->set_output('kmsdglkdnfokgnk');
            $re = $this->location_request_model->update([
                'request_number' => $secuencia
            ], ['id_request' => $id_req]);
            if ($re){
                $result= ['secuencia' => $secuencia];
                return $this->output->set_output(json_encode($result));
            }
        } else {
            $re = $this->location_request_model->update([
                'request_number' => 0
            ], ['id_request' => $id_req]);
        }
    }

    public function push_not_new_load($load_number, $app_id, $apns_number) {

        $android_msg = 'load #' . $load_number;
        $apple_msg = 'New load #' . $load_number;
        $registatoin_ids[0] = $app_id;

        if ($apns_number || $app_id) {
            //Apple notification
            if ($apns_number) {
                $result = $this->send_apple_not($apns_number, $load_number, $apple_msg);
            }

            //Android notification
            if ($app_id) {
                $result = $this->send_android_not($registatoin_ids, 'You have a new load', $android_msg);
            }
        } else {
            return $this->output->set_output(json_encode(['status' => 0, 'msg' => 'Apple or Android id not found']));
        }
        return $result;
    }

    public function info() {
        phpinfo();
    }

    //generic php function to send GCM push notification
    public function send_push_not2($load, $app_id, $apns_number) {

        //Google cloud messaging GCM-API url
        $url = 'https://gcm-http.googleapis.com/gcm/send';
        $message = 'You have a new load';

//         $registatoin_ids[0] = $this->input->post('status');
//        $title = $this->input->post('title');
//        $message = $this->input->post('msg');
//        $load_id = $this->input->post('load_id');
        $registatoin_ids[0] = $app_id;


        $fields = array(
            'registration_ids' => $registatoin_ids,
            "data" => array(
                "title" => 'You have a new load',
                "message" => 'Load #' . $load,
                'msgcnt' => count($message),
                'timestamp' => date('Y-m-d h:i:s'),
            ),
        );


        // Google Cloud Messaging GCM API Key
        define("GOOGLE_API_KEY", "AIzaSyDuQEwlOLK55nXfmdevqvXGg_IAgVG4NxQ");

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
//        $this->save_callcheck($this->session->userdata('user_id'), $load, 1, 0, $message);
        $this->send_apple_not2($load, $apns_number);
        return $result;
    }

    public function send_apple_not7($app_id, $load_number, $message) {

//        echo 'apns number: '.$app_id.'<br>';
        if (!$app_id) {
            $app_id = $this->input->post('app_id');
        }

        if (!$message) {
            $message = $this->input->post('message');
        }

//        $message = 'Msg load #' . $load_number . '-' . $message;
//        echo $message;
// Put your device token here (without spaces):
        $deviceToken = $app_id; //'5ed672addefa254d8e0d054c8acb1658bde5ef8a1b49c75c838ed56b037eb3fa';//
// Put your private key's passphrase here:
        $passphrase = 'staffing';  //development        
//        $passphrase = 'Staffing1a'; //production
// Put your alert message here:
//        $message = 'It works, this piece of art works!';
//        
// Enviroment
        $ck = 'ck_bk.pem'; //Development
//        $ck = 'ck.pem'; //production
////////////////////////////////////////////////////////////////////////////////

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $ck);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        echo 'file exist: ' . file_exists('../testpush1/' . $ck);

// Open a connection to the APNS server
//        $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | //production
        $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | //development
// REMOVE sandbox when app is in appstore
                STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

//        echo 'Connected to APNS' . PHP_EOL;
// Create the payload body
        $body['aps'] = array(
            'alert' => $message,
            'badge' => 1,
            'sound' => 'oven.caf',
        );

// Encode the payload as JSON
        $payload = json_encode($body);

// Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

//        if (!$result)
//            echo 'Message not delivered' . PHP_EOL;
//        else
//            echo 'Message successfully delivered' . PHP_EOL;
//        echo '<br>';
//        echo $app_id;
//        echo 'testing';
// Close the connection to the server
        fclose($fp);
        return $result;
    }

    public function send_apple_not($app_id, $load_number, $message) {

//        echo 'apns number: '.$app_id.'<br>';
        if (!$app_id) {
            $app_id = $this->input->post('app_id');
        }

        if (!$message) {
            $message = $this->input->post('message');
        }

//        $message = 'Msg load #' . $load_number . '-' . $message;
//        echo $message;
// Put your device token here (without spaces):
        $deviceToken = $app_id; //'5ed672addefa254d8e0d054c8acb1658bde5ef8a1b49c75c838ed56b037eb3fa';//
// Put your private key's passphrase here:
        $passphrase = 'staffing';  //development        
//        $passphrase = 'Staffing1a'; //production
// Put your alert message here:
//        $message = 'It works, this piece of art works!';
//        
// Enviroment
        $ck = 'ck_bk.pem'; //Development
//        $ck = 'ck.pem'; //production
////////////////////////////////////////////////////////////////////////////////
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', '../push/' . CK_FILE);
        stream_context_set_option($ctx, 'ssl', 'passphrase', PASS_PHRASE);

// Open a connection to the APNS server
//        $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | //production
        $fp = stream_socket_client(SSL_GATEWAY, $err, $errstr, 60, STREAM_CLIENT_CONNECT | //development
// REMOVE sandbox when app is in appstore
                STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

//        echo 'Connected to APNS' . PHP_EOL;
// Create the payload body
        $body['aps'] = array(
            'alert' => $message,
            'badge' => 1,
            'sound' => 'oven.caf',
        );

// Encode the payload as JSON
        $payload = json_encode($body);

// Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

//        if (!$result)
//            echo 'Message not delivered' . PHP_EOL;
//        else
//            echo 'Message successfully delivered' . PHP_EOL;
//        echo '<br>';
//        echo $app_id;
//        echo 'testing';
// Close the connection to the server
        fclose($fp);
        return $result;
    }

    public function test_push() {

// Put your device token here (without spaces):
        $deviceToken = '9a4fe47499034c8e5ff91ada90f57d734eee924c98fffa0da44fcf9d9bc82d38';

// Put your private key's passphrase here:
        $passphrase = 'staffing';

// Put your alert message here:
        $message = 'It works, this piece of art works!';

////////////////////////////////////////////////////////////////////////////////

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck_bk.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
        $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
        /* $body['aps'] = array(
          'alert' => array(
          'body' => $message,
          'action-loc-key' => 'Smith App',
          ), */
        $body['aps'] = array(
            'alert' => $message,
            'badge' => 1,
            'sound' => 'oven.caf',
        );

// Encode the payload as JSON
        $payload = json_encode($body);

// Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        if (!$result)
            echo 'Message not delivered' . PHP_EOL;
        else
            echo 'Message successfully delivered' . PHP_EOL;
        echo '<br>';
        echo '5ed672addefa254d8e0d054c8acb1658bde5ef8a1b49c75c838ed56b037eb3fa';
        echo 'testing';
        echo $payload;

// Close the connection to the server
        fclose($fp);
    }

    public function send_apple_not2($load_number, $app_id) {
        if (!$load_number) {
            $load_number = $this->input->post('load_number');
        }

        if (!$app_id) {
            $app_id = $this->input->post('app_id');
        }


// Put your device token here (without spaces):
        $deviceToken = $app_id; //'5ed672addefa254d8e0d054c8acb1658bde5ef8a1b49c75c838ed56b037eb3fa';//
// Put your private key's passphrase here:
//        $passphrase = 'staffing';  //20151102
        $passphrase = 'Staffing1a';
// Put your alert message here:
        $message = 'New load #' . $load_number;

        // enviroment
//        $ck = 'ck_bk.pem'; // development
        $ck = 'ck.pem'; // production
////////////////////////////////////////////////////////////////////////////////

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', '../testpush/' . $ck);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
        $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT |
// REMOVE sandbox when app is in appstore
                STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

//        echo 'Connected to APNS' . PHP_EOL;
// Create the payload body
        $body['aps'] = array(
            'alert' => $message,
            'badge' => 1,
            'sound' => 'oven.caf',
        );

// Encode the payload as JSON
        $payload = json_encode($body);

// Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

//        if (!$result)
//            echo 'Message not delivered' . PHP_EOL;
//        else
//            echo 'Message successfully delivered' . PHP_EOL;
//        echo '<br>';
//        echo $app_id;
//        echo 'testing';
// Close the connection to the server
        fclose($fp);
    }

    public function send_android_not($registatoin_ids, $title, $message) {
        //Google cloud messaging GCM-API url
        $url = 'https://gcm-http.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            "data" => array(
            "title" => $title,
            "message" => $message,
            'msgcnt' => count($message),
//                 'notid'=> 
            'timestamp' => date('Y-m-d h:i:s'),
            ),
        );

        // Google Cloud Messaging GCM API Key
        define("GOOGLE_API_KEY", "AIzaSyDuQEwlOLK55nXfmdevqvXGg_IAgVG4NxQ");

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function send_bol($load_number = null, $load_id = null, $bol_number = null, $doc_type = null) {
        $this->load->library('email');

        if (!$load_id) {
            $load_id = $this->input->post('load_id');
        }

        if (!$load_number) {
            $load_number = $this->input->post('load_number');
        }

        if (!$bol_number) {
            $bol_number = $this->input->post('bol_number');
        }

        if (!$doc_type) {
            $doc_type = $this->input->post('doc_type');
        }

        $url_doc = $load_id . '_bol_' . $bol_number;
        if ($doc_type != '') {
            $url_doc.= '_' . $doc_type;
        }

        $email = $this->input->post('email');

        $this->email->from('service@smith-cargo.com', 'Smith Transportation');
        $this->email->to($email);
//        $this->email->cc('another@another-example.com');
//        $this->email->bcc('them@their-example.com');

        $this->email->subject('Load #' . $load_number . ', BOL #' . $bol_number);
        $this->email->message('Attach is the BOL');
        $this->email->attach(CONT_FILE_PATH . $url_doc . '.pdf');

        if (!$this->email->send()) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
        }
    }

    public function change_status($id, $status) {
        $this->_required_login($this->router->fetch_class(), 'trash');
        $result = $this->load_model->update(['sw' => $status], $id);
        if ($result) {
            $this->output->set_output(json_encode(['status' => 1, 'msg' => 'Load status successfullly updated.']));
        } else {
            $this->output->set_output(json_encode(['status' => 0, 'msg' => 'Load status could not be updated.']));
        }
    }
//THIS ARE DRIVER AND CARRIER CLASSESS
//-------------------------
//-------------------------
//-------------------------

}
