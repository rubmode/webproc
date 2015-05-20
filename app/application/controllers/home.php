<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Proc_Controller {
	
	public function __construct(){
			parent::__construct();
    }

	public function index(){
        $userdata = $this->session->all_userdata();
        if( !isset($userdata['email']) ):
            $data['style'] = array(
                'bootstrap/css/bootstrap',
                'bootstrap/css/bootstrap-theme.min',
                'css/cover',
                'css/style');
            $data['script'] = array(
                'js/jquery-2.1.1.min', 'bootstrap/js/bootstrap.min',
                'js/cfdi.jquery');
            $this->load->view('template/header', $data);
            $this->load->view('sections/cover');
            $this->load->view('template/footer');
        else:
            header('Location: '.base_url().'app');
        endif;
	}

}