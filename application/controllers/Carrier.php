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
class carrier extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('carrier_model');
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
        $data['carriers'] = $this->carrier_model->get(['status' => 1]);

        $this->load->view('general/inc/header_view', $data);
        $this->load->view('carrier/carrier_view');
        $this->load->view('general/inc/footer_view');
    }

    public function trash() {
        $this->_required_login($this->router->fetch_class(), $this->router->fetch_method());
        $data['class'] = $this->get_class_name();
        $data['user'] = $this->session->userdata('name');
        $data['roles'] = $GLOBALS['roles'];
        $data['carriers'] = $this->carrier_model->get(['status' => 0]);

        $this->load->view('general/inc/header_view', $data);
        $this->load->view('carrier/trash_view');
        $this->load->view('general/inc/footer_view');
    }

    public function unauth() {
        $data = $this->get_session_user_data();
        $this->load->view('general/inc/header_view', $data);
        $this->load->view('carrier/not_auth');
        $this->load->view('general/inc/footer_view');
    }

    public function add() {
        $this->_required_login($this->router->fetch_class(), $this->router->fetch_method());
        $data = $this->get_session_user_data();
        $data['roles'] = $GLOBALS['roles'];
        $this->load->view('general/inc/header_view', $data);
        $this->load->view('carrier/register_view');
        $this->load->view('general/inc/footer_view');
    }

    public function delete() {
        $result = $this->user_model->delete(2);
        print_r($result);
    }

    public function get($id = null) {
        $this->_required_login();

        if ($id != null) {
            $result = $this->user_model->get([
                'iduser' => $id
            ]);
        } else {
            $result = $this->user_model->get();
        }

        $this->output->set_output(json_encode($result));
    }

    public function register() {
        $this->_required_login();
        $this->output->set_content_type('application_json');

//        $this->form_validation->set_rules('name', 'Name', 'required|min_length[2]|max_length[32]');
//        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[4]|max_length[16]');
//        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
//        $this->form_validation->set_rules('address', 'Address', 'required|min_length[2]|max_length[32]');
//        $this->form_validation->set_rules('city', 'City', 'required|min_length[2]|max_length[32]');
//        $this->form_validation->set_rules('state', 'State', 'required|min_length[2]|max_length[32]');
//        $this->form_validation->set_rules('country', 'Country', 'required|min_length[1]|max_length[32]');
//
//        if ($this->form_validation->run() == FALSE) {
//            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
//            return false;
//        }


        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $scac = $this->input->post('scac');


        $carrier_id = $this->carrier_model->insert([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'scac' => $scac,
        ]);

        if ($carrier_id) {
            $param['email'] = $email;
            $param['name'] = $name;
            $this->send_mail($param);
            $this->output->set_output(json_encode(['result' => 1]));
            return false;
        }
        $this->output->set_output(json_encode(['result' => 0, 'error' => 'Carrier not created.']));
    }

    public function edit($id) {
        $this->_required_login($this->router->fetch_class(), $this->router->fetch_method());
        $data = $this->get_session_user_data();
        $data['roles'] = $GLOBALS['roles'];
        $carrier = $this->carrier_model->get($id);

        $data['carrier'] = $carrier[0];

        $this->load->view('general/inc/header_view', $data);
        $this->load->view('carrier/update_view');
        $this->load->view('general/inc/footer_view');
    }

    public function update() {
        $this->_required_login();
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('address', 'Adress', 'required');
        $this->form_validation->set_rules('scac', 'MC#', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
            return false;
        }
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $scac = $this->input->post('scac');

        $carrier_id = $this->carrier_model->update([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'scac' => $scac
                ], $id);

        if ($carrier_id) {
            $this->output->set_output(json_encode(['result' => 1]));
            return false;
        }

        $this->output->set_output(json_encode(['result' => 0, 'error' => 'Carrier not updated.']));
    }

    public function app_get_drivers_by_carrier($id) {
        header('Access-Control-Allow-Origin: *');
        $this->load->model('driver_model');
        $result = $this->driver_model->get([
            'ts_carrier_idts_carrier' => $id
        ]);
        $this->output->set_output(json_encode($result));
    }

    public function get_drivers_by_carrier($id_carrier = null) {
        $this->_required_login();
        if (!$id_carrier) {
            $id_carrier = $this->input->post('carrier_id');
        }

        $this->load->model('driver_model');
        $result = $this->driver_model->get([
            'ts_carrier_idts_carrier' => $id_carrier,
            'status' => 1
        ]);
        $this->output->set_output(json_encode($result));
    }

    public function send_mail($param) {
        $this->_required_login();
        $this->load->library('email');

        $this->email->from('service@smith-cargo.com', 'Smith Transportation');
        $this->email->to($param['email']);
        $this->email->cc('another@another-example.com');
        $this->email->bcc('them@their-example.com');

        $this->email->subject('Smith Transportation new carrier');
        $this->email->message('<div><h1>Smith Transportation</h1></div>
                        <ul>
                            <li> ' . $param['name'] . ' has been added as a Carrier in Smith Trackngo System</li>
                        </ul>');
        $this->email->set_mailtype("html");

        if (!$this->email->send()) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
        }
    }

    public function change_status($id, $status) {
        $result = $this->carrier_model->update(['status' => $status], $id);
        if ($result) {
            $this->output->set_output(json_encode(['status' => 1, 'msg' => 'Carrier status successfullly updated.']));
        } else {
            $this->output->set_output(json_encode(['status' => 0, 'msg' => 'Carrier status could not be updated.']));
        }
    }

}
