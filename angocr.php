<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Anmeldung anzeigen und verarbeiten.
 *
 * @package		eridian
 * @subpackage	Controllers
 * @category	Controllers
 * @author      Mathias Latzko <mathias.latzko@googlemail.com>
 * @extends     controller
 * @see 		parent::Controller()
 */

class Angocr extends CI_Controller
{

	protected $salt = array();

	/**
	 * Constructor Controller
	 */
	function Angocr ()
	{

		parent::__construct();
	}

	/**
	 * Anmeldeseite anzeigen und Ergebniss verarbeiten.
	 * @return string
	 *
	 * @uses Form_Validation
	 * @uses Input
	 * @uses dohash()
	 * @uses view()
	 */
	function index()
	{
		$this->load->view('angocr/index.php');

	}

	// function update()
	// {
	// 	$oldn=$_POST['oldn'];
	// 	$newn=$_POST['newn'];
		
	// 	$array = array(
	// 		'cr_name'=> $newn);

	// 	$this->db->where('cr_id', $oldn);
	// 	$this->db->update('core_receipts', $array);
	// 	echo "<script>location.reload();</script>";
	// }

	
}

/* End of file lgi.php */
/* Location: ./system/application/controllers/lgi.php */