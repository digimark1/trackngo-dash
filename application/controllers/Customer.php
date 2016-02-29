<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Hernando Peña <your.name at your.org>
 */
class customer extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('customer_contact_model');
        $roles = $this->session->userdata('roles');
        $i = 0;
        if ($roles) {
            foreach ($roles as $role => $row) {
                $GLOBALS['roles'][$i] = $row['class'] . '/' . $row['function'];
                $i++;
            }
        }
    }

//    private function _required_login() {
//        if ($this->session->userdata('user_id') == FALSE) {
//            $this->logout();
//            $this->output->set_output(json_encode(['result' => 0, 'error' => 'You are not authorized']));
//            return false;
//        }
//    }

    public function pass_encoder($pass) {
        echo hash('sha256', $pass . SALT);
    }

    public function index() {
        $this->_required_login($this->router->fetch_class(), $this->router->fetch_method());
        $data['class'] = $this->get_class_name();
        $data['user'] = $this->session->userdata('name');
        $data['roles'] = $GLOBALS['roles'];
        $data['customers'] = $this->customer_model->get(['status' => 1]);
        

        $this->load->view('general/inc/header_view', $data);
        $this->load->view('customer/customer_view');
        $this->load->view('general/inc/footer_view');
    }

    public function trash() {
        $this->_required_login($this->router->fetch_class(), $this->router->fetch_method());
        $data['class'] = $this->get_class_name();
        $data['user'] = $this->session->userdata('name');
        $data['roles'] = $GLOBALS['roles'];
        $data['customers'] = $this->customer_model->get(['status' => 0]);

        $this->load->view('general/inc/header_view', $data);
        $this->load->view('customer/trash_view');
        $this->load->view('general/inc/footer_view');
    }

    public function unauth() {
        $data = $this->get_session_user_data();
        $this->load->view('general/inc/header_view', $data);
        $this->load->view('customer/not_auth');
        $this->load->view('general/inc/footer_view');
    }

    public function add() {
        $this->_required_login($this->router->fetch_class(), $this->router->fetch_method());
        $data = $this->get_session_user_data();
        $data['roles'] = $GLOBALS['roles'];
        $this->load->view('general/inc/header_view', $data);
        $this->load->view('customer/register_view');
        $this->load->view('general/inc/footer_view');
    }

    public function register() {
        $this->_required_login();
        $this->output->set_content_type('application_json');

        $this->form_validation->set_rules('name', 'Name', 'required|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[4]|max_length[16]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[ts_customer.email]');
        $this->form_validation->set_rules('address', 'Address', 'required|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('city', 'City', 'required|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('state', 'State', 'required|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('country', 'Country', 'required|min_length[1]|max_length[32]');

        if ($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
            return false;
        }

        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $state = $this->input->post('state');
        $country = $this->input->post('country');


        $customer_id = $this->customer_model->insert([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'country' => $country
        ]);

        if ($customer_id) {
            //insert contacts
            $contacts = json_decode($this->input->post('contacts'));
            // Insert Shipments in Database

            for ($i = 0; $i < count($contacts); $i++) {

                $contact_data = array(
                    'ts_customer_idts_customer' => $customer_id,
                    'name' => $contacts[$i]->name,
                    'phone' => $contacts[$i]->phone,
                    'email' => $contacts[$i]->email,
                    'default' => $contacts[$i]->default
                );
                $contact_value[$i] = $contact_data;
            }

            $this->customer_contact_model->insertBatch($contact_value);

            //send email confirmation
            $param['email'] = $email;
            $this->send_mail($param);
            $this->output->set_output(json_encode(['result' => 1]));
            return false;
        }
        $this->output->set_output(json_encode(['result' => 0, 'error' => 'Customer not created.']));
    }

    public function edit($id) {
        $this->_required_login($this->router->fetch_class(), $this->router->fetch_method());

        $data = $this->get_session_user_data();
        $data['roles'] = $GLOBALS['roles'];
        $customer = $this->customer_model->get($id);
        $data['contacts'] = $this->customer_contact_model->get(['ts_customer_idts_customer' => $id]);

        $data['customer'] = $customer[0];

        $this->load->view('general/inc/header_view', $data);
        $this->load->view('customer/update_view');
        $this->load->view('general/inc/footer_view');
    }

    public function update() {
        $this->_required_login($this->router->fetch_class(), 'edit');

        $this->form_validation->set_rules('mname', 'Name', 'required');
        $this->form_validation->set_rules('mphone', 'Phone', 'required');
        $this->form_validation->set_rules('memail', 'Email', 'required');
        $this->form_validation->set_rules('address', 'Adress', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
            return false;
        }

        $id = $this->input->post('id');
        $name = $this->input->post('mname');
        $phone = $this->input->post('mphone');
        $email = $this->input->post('memail');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $state = $this->input->post('state');
        $country = $this->input->post('country');

        $customer_id = $this->customer_model->update([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'country' => $country
                ], $id);

        //update contacts
        $contacts = json_decode($this->input->post('update_contact'));
        if (count($contacts) > 0) {
            $this->db->update_batch('ts_customer_contact', $contacts, 'idts_customer_contact');
        }

        $sw_contact = 0;
        // Insert new Shipments in Database
        $new_contacts = json_decode($this->input->post('new_contact'));

        if (count($new_contacts) > 0) {
            for ($i = 0; $i < count($new_contacts); $i++) {
                $contact_data = array(
                    'ts_customer_idts_customer' => $id,
                    'name' => $new_contacts[$i]->name,
                    'phone' => $new_contacts[$i]->phone,
                    'email' => $new_contacts[$i]->email,
                    'default' => $new_contacts[$i]->default
                );
                $contact_value[$i] = $contact_data;
            }

            $this->customer_contact_model->insertBatch($contact_value);
            $sw_contact = 1;
//            $this->output->enable_profiler(TRUE);
        }

        //Delete shipments in database
        $delete_contacts = json_decode($this->input->post('delete_contact'), true);

        if (count($delete_contacts) > 0) {
            foreach ($delete_contacts as $delete_contact => $value) {
                $this->customer_contact_model->delete($value['idts_customer_contact']);
            }
            $sw_contact = 1;
        }

        if ($customer_id || $sw_contact = 1) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Customer updated.']));
            return false;
        }

        $this->output->set_output(json_encode(['result' => 0, 'error' => 'Customer not updated.']));
    }

    public function get($id = null) {
        $this->_required_login();

        if ($id != null) {
            $result['customers'] = $this->customer_model->get([
                'idts_customer' => $id
            ]);
            $result['first_cust_contacts'] = $this->get_contact($result['customers'][0]['idts_customer']);
        } else {
            $result['customers'] = $this->customer_model->get();
            $result['first_cust_contacts'] = $this->get_contact($result['customers'][0]['idts_customer']);
        }

        $this->output->set_output(json_encode($result));
    }

    public function send_mail($param) {
        $this->_required_login();
        $this->load->library('email');

        $this->email->from('service@smith-cargo.com', 'Smith Transportation');
        $this->email->to($param['email']);
        $this->email->cc('another@another-example.com');
        $this->email->bcc('them@their-example.com');

        $this->email->subject('Smith Transportation customer');
        $this->email->message('<div><h1>Smith Transportation</h1></div>
                        <ul>
                            <li>Your company has been created in Trackngo System</li>
                        </ul>');
        $this->email->set_mailtype("html");

        if (!$this->email->send()) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
        }
    }

    // Customer contact functions

    public function get_contact($id = null) {
        $this->_required_login();

        if ($id != null) {
            $result = $this->customer_contact_model->get([
                'ts_customer_idts_customer' => $id
            ]);
        } else {
            $result = $this->customer_contact_model->get();
        }

        $this->output->set_output(json_encode($result));
        return $result;
    }

    public function change_status($id, $status) {
        $result = $this->customer_model->update(['status' => $status], $id);
        if ($result) {
            $this->output->set_output(json_encode(['status' => 1, 'msg' => 'Customer status successfullly updated.']));
        } else {
            $this->output->set_output(json_encode(['status' => 0, 'msg' => 'Customer status could not be updated.']));
        }
    }

}
