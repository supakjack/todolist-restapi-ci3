<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Todolists extends \Restserver\Libraries\REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function todolists_get()
    {
        $this->load->model('M_todo_list', 'mtl');
        $id = $this->get('id');

        if ($id === NULL) {
            $rs_todo_list = $this->mtl->select();
            // Check if the todolists data store contains todolists (in case the database result returns NULL)
            if (COUNT($rs_todo_list)) {
                // Set the response and exit
                $this->response($rs_todo_list, \Restserver\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No todolists were found'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular todolists.
        else {
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0) {
                // Invalid id, set the response and exit.
                $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the todolists from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $this->mtl->tl_id = $id;
            $qu_todo_list = $this->mtl->select();

            if (COUNT($qu_todo_list)) {
                $this->set_response($qu_todo_list, \Restserver\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'todolists could not be found'
                ], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function todolists_post()
    {
        $this->load->model('M_todo_list', 'mtl');
        $this->mtl->tl_name = $this->post('name');
        $this->mtl->tl_discript = $this->post('discript');
        $this->mtl->tl_value = $this->post('value');
        $this->mtl->tl_use = $this->post('use');
        $this->mtl->insert();

        $message = [
            'id' => $this->db->insert_id(),
            'name' => $this->post('name'),
            'discript' => $this->post('discript'),
            'value' => $this->post('value'),
            'use' => $this->post('use'),
            'message' => 'Added a resource'
        ];

        $this->set_response($message, \Restserver\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function todolists_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $this->load->model('M_todo_list', 'mtl');
        $this->mtl->tl_id = $id;
        $this->mtl->delete();

        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, \Restserver\Libraries\REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

    public function todolists_put()
    {
        // Build a new key
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $this->load->model('M_todo_list', 'mtl');
        $this->mtl->tl_id = $id;
        $this->mtl->tl_name = $this->put('name');
        $this->mtl->tl_discript = $this->put('discript');
        $this->mtl->tl_value = $this->put('value');
        $this->mtl->tl_use = $this->put('use');
        $this->mtl->update();

        $message = [
            'id' => $id,
            'name' => $this->put('name'),
            'discript' => $this->put('discript'),
            'value' => $this->put('value'),
            'use' => $this->put('use'),
            'message' => 'Update a resource'
        ];

        $this->set_response($message, \Restserver\Libraries\REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
    }
}
