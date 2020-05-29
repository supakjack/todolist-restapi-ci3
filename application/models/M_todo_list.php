<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_todo_list extends CI_Model
{
    public $tl_id;
    public $tl_name;
    public $tl_discript;
    public $tl_value;
    public $tl_use;

    public function __construct()
    {
        parent::__construct();
    }

    public function select($fill = '*')
    {
        $this->db->select($fill);
        if (isset($this->tl_id)) {
            $this->db->where('tl_id', $this->tl_id);
        }
        $query = $this->db->get('todo_lists');
        $query = $query->result();
        return $query;
    }

    public function insert()
    {
        $this->db->insert('todo_lists', $this);
    }

    public function delete()
    {
        $this->db->delete('todo_lists', [
            'tl_id' => $this->tl_id
        ]);
    }

    public function update()
    {
        $this->db->set($this);
        $this->db->where('tl_id', $this->tl_id);
        $this->db->update('todo_lists');
    }
}

/* End of file M_todo_list.php */
