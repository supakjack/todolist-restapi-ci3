<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo_page extends CI_Controller {

	public function show()
	{
		$this->load->view('templates/header');
		$this->load->view('v_todolist');
		$this->load->view('templates/footer');
	}
}
