<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mcommunicatorsmsqueue extends CI_Model{

	public $validation_errors = array();
	private $post = array();
	protected $table = "communicator_sms_queue";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
	}


    public function set_data($post_array)
    {

    }

    public function is_valid()
    {
        $result = true;

        /*
         Validation logics goes here
        */

        return $result;
    }

    /*
    *
    */
    public function create($to,$message)
    {
        $sms_id = trim($this->mmodel->getGUID(), '{}');
        $this->post['id'] = $to;
        $this->post['send_to'] = $sms_id;
        $this->post['msg'] = $message;
        $this->post['is_deleted'] = 0;
        $this->post['is_active'] = 1;
        $this->post['delivery_status'] = 0;
        $this->post['updated'] = date("Y-m-d H:i:s");
        $this->post['created'] = date("Y-m-d H:i:s");
        $this->post['updated_by'] = $sms_id;
        $this->post['created_by'] = $sms_id;

        $this->mmodel->insert($this->table, $this->post);

        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return false;
    }

}

