<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($username, $email, $password) {
		
		$data = array(
			'username'   => $username,
			'email'      => $email,
			//'password'   => $this->hash_password($password)
			'password'   => $password
			//'created_at' => date('Y-m-j H:i:s')
		);
		
		$this->email_active($username,$email,$password);
		
		return $this->db->insert('users', $data);
		
	}
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($username, $password) {
		
		$query = $this->db->query("SELECT * FROM users where username='$username' AND password='$password' ");
		
		return $query;
		
		// $this->db->select('password');
		// $this->db->from('users');
		// $this->db->where('username', $username);
		// $hash = $this->db->get()->row('password');
		
		// return $this->verify_password_hash($password, $hash);
		
	}
	
	/**
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($username) {
		
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('username', $username);

		return $this->db->get()->row('id');
		
	}
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {
		
		$this->db->from('users');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();
		
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		
		return password_verify($password, $hash);
		
	}
	
	private function email_active($user,$email,$pass)
    {
		$namepass = $user . $pass; // This variable will now hold your hashed password.
		$hash = md5($namepass); //echo $hash;
        // Set SMTP Configuration
        $emailConfig = [
            'protocol' => 'smtp', 
            'smtp_host' => 'std.must.edu.tw', 
            'smtp_port' => 25, 
            'smtp_user' => 'b02170012', 
            'smtp_pass' => 'a546872166', 
            'mailtype' => 'html', 
            'charset' => 'utf-8'
        ];

        // Set your email information
        $from = [
            'email' => 'b02170012@std.must.edu.tw',
            'name' => 'Alex'
        ];
		
		$message =  "This is the HTML message body <b>from mail!</b> please click the following messge to activate your register. <br>";
		$message = $message . '<a href=' . base_url() . 'home/activate?user=' . $user . '&msg=' . $hash . '> click me </a>';
       
        $to = array($email);
        $subject = 'Your gmail subject here';
        //$message = 'Type your gmail message here';
        //$message =  $this->load->view('welcome_message',[],true);
        // Load CodeIgniter Email library
        $this->load->library('email', $emailConfig);
		$this->email->initialize($emailConfig);
        // Sometimes you have to set the new line character for better result
        $this->email->set_newline("\r\n");
        // Set email preferences
        $this->email->from($from['email'], $from['name']);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        // Ready to send email and check whether the email was successfully sent
        if (!$this->email->send()) {
            // Raise error message
            show_error($this->email->print_debugger());
        } else {
            // Show success notification or other things here
            echo 'Success to send email';
        }
    }
	
	public function user_activate($user,$hash){
		
		$query = $this->db->query("SELECT username , password , active FROM users where username='$user'; ");
		
		if (!$query){
			return 0;
		}
		
		$str = md5($query->result()[0]->username . $query->result()[0]->password);

		
		if ($str==$hash && !$query->result()[0]->active){
		
			$data = array(
				'active' => true
			);
			$this->db->where('username', $user);
			return $this->db->update('users', $data);
		}		

		else {
			return false;
		}
	}
	
}

