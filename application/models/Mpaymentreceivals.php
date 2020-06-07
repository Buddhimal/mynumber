<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mpaymentreceivals extends CI_Model{

	public $validation_errors = array();
	private $post = array();
	protected $table = "payment_receivals";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
	}


	public function set_data($post_array)
	{
		// $this->post = $post_array
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
	public function create()
	{

	}


	public function get_last_paid_date( $clinic_id ){
		$output = null;
		$result_set = $this->db->select_max('collected')
			->from($this->table)
			->where('clinic_id', $clinic_id)
			->where('collection_status', PaymentCollectionStatus::Pending)
			->where('is_active', 1)
			->where('is_deleted', 0)->get();

		if ( $result_set->num_rows() > 0 ) {
			$output = date(strtotime("+5 hours +30 minutes", $result_set[0]['collected'])); // Database stores UTC, clinic is in SL time 
		}

		return $output;
	}
}
