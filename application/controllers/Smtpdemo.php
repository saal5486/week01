<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Smtpdemo extends \CI_Controller
{
    public function index()
    {
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
       
        $to = array('b02170012@std.must.edu.tw');
        $subject = 'Your gmail subject here';
        $message = 'Type your gmail message here';
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
}