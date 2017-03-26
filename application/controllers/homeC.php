<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeC extends CI_Controller {

	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('user_model');
		
	}



	public function index()
	{
		//instruct.txt step 3~7
		$this->load->view('homeV');
	}

	public function about()
	{
		//instruct.txt step 3~7
		$this->load->view('aboutV');	
	}

	public function contact()
	{
		//instruct.txt step 3~7	
		$this->load->view('contactV');
	}

	public function order()
	{
		//instruct.txt step 3~7
		$this->load->view('orderV');	
	}

	public function signin()
	{
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		//$this->load->helper('form');
		$this->load->library('form_validation');

		//$username = $this->input->post('username'); echo $username; echo '<br>';
		//$password = $this->input->post('password'); echo $password; echo '<br>';
		
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
			
			// validation not ok, send validation errors to the view
			//$this->load->view('header');
			$this->load->view('signinV');
			//$this->load->view('footer');
			
		} else {
			
			// set variables from the form
			$username = $this->input->post('username'); echo $username; echo '<br>';
			$password = $this->input->post('password'); echo $password; echo '<br>';
			
			$query = $this->user_model->resolve_user_login($username, $password);
			//$this->user_model->resolve_user_login($username, $password)
			if ($query->num_rows() == 1) {
				
				// $user_id = $this->user_model->get_user_id_from_username($username);
				// $user    = $this->user_model->get_user($user_id);
				
				// set session user datas
				// $_SESSION['user_id']      = (int)$user->id;
				// $_SESSION['username']     = (string)$user->username;
				// $_SESSION['logged_in']    = (bool)true;
				// $_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
				// $_SESSION['is_admin']     = (bool)$user->is_admin;
				
				// user login ok
				$this->load->view('signinOK');	
			} else {
				
				// login failed
				$data->error = 'Wrong username or password.';
				
				// send error to the view
				$this->load->view('signinV');	
				
			}
			
		} 
		//$this->load->view('signinV');	
	}
    
	public function signup()
	{	
		// create the data object
		$data = new stdClass();

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == false) {
			
			$this->load->view('signupV');
			
		} else {
			
			// set variables from the form
			$username = $this->input->post('username'); //echo $username; echo '<br>';
			$email    = $this->input->post('email');  //echo $email; echo '<br>';
			$password = $this->input->post('password');  //echo $password; echo '<br>';
			$password_confirm = $this->input->post('password_confirm');  //echo $password_confirm; echo '<br>';
			
			$this->load->model('user_model');
			
			if ($this->user_model->create_user($username, $email, $password) &&  $password==$password_confirm) {
				$this->load->view('signupOK', $data);
			} else {
				
				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';
				$this->load->view('signup', $data);
			}
		}
			
	}
	
	public function activate(){
		$user = $this->input->get('user'); echo $user . '</br>' ;
		$msg  = $this->input->get('msg'); echo $msg . '</br>';
		
		$this->load->model('user_model');
		
		$query = $this->user_model->user_activate($user, $msg);
		
		if ($query==1){
			$this->load->view('signin', $data);
		}else{
			$this->load->view('signup', $data);
		}
		
	}



}
