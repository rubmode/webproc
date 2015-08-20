	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends Proc_Controller {
	
	public function __construct(){
			parent::__construct();
    }

    public function login ()
    {
        $auth_key = $this->checkAuthKey();
        if( $auth_key['res'] == 'success' ) :
            header('Location: '.base_url().'dashboard');
        else :
            $app_key = $this->checkAppKey();
            if( $app_key['res'] != 'success' ):
                echo $app_key['desc'];
            else:
                $data['style'] = array(
                    'bootstrap/css/bootstrap',
                    'dist/css/flat-ui',
                    'css/webproc');
                $data['script'] = array(
                    'js/jquery-2.1.1.min', 'bootstrap/js/bootstrap.min',
                    'dist/js/flat-ui',
                    'js/application',
                    'js/webproc.jquery');
                $this->load->view('template/header', $data);
                $this->load->view('dashboard/login');
                $this->load->view('template/footer');
            endif;
        endif;
	}

    public function register ()
    {
        $auth_key = $this->checkAuthKey();
        if( $auth_key['res'] == 'success' ) :
            header('Location: '.base_url().'dashboard');
        else :
            $app_key = $this->checkAppKey();
            if( !isset($userdata['email']) ):
                $data['style'] = array(
                    'bootstrap/css/bootstrap',
                    'dist/css/flat-ui',
                    'css/webproc');
                $data['script'] = array(
                    'js/jquery-2.1.1.min', 'bootstrap/js/bootstrap.min',
                    'dist/js/flat-ui',
                    'js/application',
                    'js/webproc.jquery');
                $this->load->view('template/header', $data);
                $this->load->view('dashboard/register');
                $this->load->view('template/footer');
            else:
                header('Location: '.base_url().'app');
            endif;
        endif;
    }

}