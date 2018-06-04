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
	function Angocr()
	{

		parent::__construct();
		$this->load->model('users');
		$this->load->model('user');
		$this->load->model('category');
		$this->load->model('categories');
		$this->load->model('send_mail');
		$this->salt = $this->config->item('salt');
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

		$data = array();
		$data['parseData'] = init_ParseData();
		$data['parseData']['login:errors'] = '';


		$data['benutzername'] = '';
		$data['passwort'] = '';

		if(!empty($_POST)){

			$this->form_validation->set_error_delimiters('<div class="formerror">', '</div>');

			$this->form_validation->set_rules('benutzername', 'Benutzername', 'required|trim|strip_tags');
			$this->form_validation->set_rules('passwort', 'Passwort', 'required|trim|strip_tags');

			if ($this->form_validation->run() !== FALSE)
			{
				
			

				$where = array(
					'cu_email' => $this->input->post('benutzername'),
					'cu_pass' => do_hash($this->input->post('passwort'), 'md5'),
				);
				$user = $this->user->get($where);

				if($user !== FALSE && $user['cu_rights'] !== '-1' && $user['cu_rights'] !== '-2')
				{
					$this->session->set_userdata('user', $user['cu_id']);
					$this->session->set_userdata('user_firstN', $user['cu_firstname']);
					$this->session->set_userdata('user_lastN', $user['cu_lastname']);
					$this->session->set_userdata('user_kdnr', $user['cu_kdnr']);
					$update_data['is_open'] = 0;
					$this->category->update(array('cc_cu_id' => $user['cu_id']),$update_data);
					
					$cookie_ocrn= "ocr";
					$cookie_ocrv= "1";
					
					setcookie($cookie_ocrn,$cookie_ocrv, time() + (86400 * 30), "/"); 
					
					redirect('angocr/main');
				} else {
					$data['parseData']['login:errors'] = '<div class="formerror">Ihre Anmeldung wurde nicht akzeptiert, bitte geben Sie Ihre Anmeldedaten erneut ein.</div>';
				}
			}
		}


		view(__CLASS__.'/'.__FUNCTION__, $data);
	}

	function main()
	{
		if (!empty($_COOKIE['ocr'])){
			$this->load->view('angocr/main.php');
			}else{
				redirect('/logout');
			}
		
	}

	function iframe()
	{
		$data['parseData'] = init_ParseData();
		$data['parseData']['message'] = '';
		view('iframe', $data);
	}

	function verification ($verification) {
		if(!$this->check_aktivation_link ($verification)) {
			redirect('angocr');
		}
		else {
			$this->load->model('cron');
			
			$user = $this->check_aktivation_link ($verification);
			$cuid = $user['cu_id'];
			$firstname =  preg_replace("/[ ]/", "_", $user['cu_firstname']);
			$firstname = preg_replace("/[^_a-zA-Z0-9]/", "", $firstname);
			$firstname = preg_replace("/[_]+/", "_", $firstname);
			
			$lastname =  preg_replace("/[ ]/", "_", $user['cu_lastname']);
			$lastname = preg_replace("/[^_a-zA-Z0-9]/", "", $lastname);
			$lastname = preg_replace("/[_]+/", "_", $lastname);
			
			$kdnr =  explode('-',$user['cu_kdnr']);

			$credentials = $this->cron->create_email_account($cuid, $firstname, $lastname,$kdnr);
			
			// $this->user->update($cuid, array());
			$this->user->update($user['cu_id'],array('cu_rights'=>NULL,'cu_eridian_mail' => $credentials['email']));
			$this->session->set_userdata('user', $user['cu_id']);
			$this->send_mail->send_account_is_activ($user);
			redirect('rcp');
		}
	}




	function pre_verification ($verification) {
		$data['parseData'] = init_ParseData();
		$data['email'] = '';
		if(do_hash($this->salt['pre_verification']) === $verification) {
			view(__CLASS__.'/'.__FUNCTION__, $data);
		}
		else {
			redirect('angocr');
		}
	}


	function receive_password () {

		$data['parseData'] = init_ParseData();
		$data['email'] = '';
		$this->form_validation->set_error_delimiters('<div class="formerror">', '</div>');
		$this->form_validation->set_rules('email', 'E-Mail Adresse', 'required|vaild_email|callback_email_check|trim|strip_tags');

		if ($this->form_validation->run() !== FALSE) {

			$email = $this->input->post('email');
			$user = $this->user->get(array('cu_email' => $email));
			$user['verification'] = do_hash($this->salt['verification'].$user['cu_id'].$this->salt['verification']);
			$user['base_url'] = base_url();
			$this->send_mail->send_receive_password($user);

			redirect('angocr');
		}
		view(__CLASS__.'/'.__FUNCTION__, $data);

	}

	function recover_folder_password($verification='',$folder_id=''){
		$data['parseData'] = init_ParseData();
		$data['password_check'] = '';
		$data['password'] = '';
		//$hidden = $this->input->post('verification');
		if(!$this->check_aktivation_link($verification) && $this->input->post('verification') === false) {

			redirect('angocr');
		}
		else {
			if(!empty($verification)) {
				$data['verification'] = $verification;
				$data['folder_id'] = $folder_id;
			}
			else {
				$data['verification'] = $this->input->post('verification');
				$data['folder_id'] = $this->input->post('folder_id');
			}

			$user =  $this->check_aktivation_link($data['verification']);
			$status = false;
			$this->form_validation->set_error_delimiters('<div class="formerror">', '</div>');
			$this->form_validation->set_rules('password', 'Passwort', 'required|min_length[6]|callback_is_valid_password|trim|strip_tags');
			$this->form_validation->set_rules('password_check', 'Passwort wiederholen', 'required|callback_password_check|trim|strip_tags');
			if ($this->form_validation->run() !== FALSE) {
				$password = $this->input->post('password');
				$categories = $this->categories->get(array('cc_cu_id'=>$user['cu_id']));
				foreach ($categories as $category) {
					if(do_hash($category['cc_id'],'md5') === $data['folder_id']) {
						$this->category->update(array('cc_id'=>$category['cc_id']),array('password'=>do_hash($password.$this->salt['folder_pw'],'md5')));
						$this->session->set_userdata('user', $user['cu_id']);
						redirect('rcp/show/entrance');
					}
				}
			}

			view(__CLASS__.'/'.__FUNCTION__, $data);
		}
	}


	function check_aktivation_link ($verification = '') {
		if(isset($verification) && $verification !== '') {
			$users = $this->users->get();
			foreach ($users as $user) {
				if(do_hash($this->salt['verification'].$user['cu_id'].$this->salt['verification']) === $verification) {
					return $user;
				}
			}
		}
		return FALSE;
	}

	function recover_password ($verification = '') {
		$data['parseData'] = init_ParseData();
		$data['password'] = '';
		$data['password_check'] = '';
		//$hidden = $this->input->post('verification');
		if(!$this->check_aktivation_link($verification) && $this->input->post('verification') === false) {

			redirect('angocr');
		}
		else {

			if(!empty($verification)) {
				$data['verification'] = $verification;
			}
			else {
				$data['verification'] = $this->input->post('verification');
			}
			$user =  $this->check_aktivation_link($data['verification']);

			$this->form_validation->set_error_delimiters('<div class="formerror">', '</div>');
			$this->form_validation->set_rules('password', 'Passwort', 'required|min_length[6]|callback_is_valid_password|trim|strip_tags');
			$this->form_validation->set_rules('password_check', 'Passwort wiederholen', 'required|callback_password_check|trim|strip_tags');
			if ($this->form_validation->run() !== FALSE) {
				$password = $this->input->post('password');
				$this->user->update($user['cu_id'],array('cu_pass'=>do_hash($password, 'md5')));
				$this->session->set_userdata('user', $user['cu_id']);
				$this->session->unset_userdata('verification');
				redirect('rcp/show/entrance');

			}
			view(__CLASS__.'/'.__FUNCTION__, $data);
		}
	}

	function email_check() {
		$email = $this->input->post('email');
		$result = $this->user->get(array('cu_email' => $email));
		if ($result['cu_email'] !== $email) {
			$this->form_validation->set_message('email_check', 'Bitte tragen Sie eine andere gültige E-Mail Adresse in das Feld <strong><em>%s</em></strong> ein.');
			return false;
		}
		return true;
	}

	function password_check () {
		$password 		= $this->input->post('password');
		$password_check = $this->input->post('password_check');

		if($password !== $password_check ) {
			$this->form_validation->set_message('password_check', '<strong>Ihr Passwort stimmt nicht überein</strong>.');
			return FALSE;
		}
		else {
			return true;
		}
	} 
	
	// function test() {
	// 	$this->load->view('lgi/cpanel/examples/mysql.php');
		
	// }
	
}

/* End of file lgi.php */
/* Location: ./system/application/controllers/lgi.php */