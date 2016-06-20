<?php
/* Programmer Identification */
/* Nama				: Luqman Hakim */
/* Tanggal Mulai		: Mei 27 2015 */
/* Fungsi File			: Management Email Alert */
/* End Of Programmer Identification */
Class App_model extends CI_Model
{	
	
	private $table_posisi 	= 'tbl_posision';
	private $tbl_user 		= 'tbl_user';
	private $tbl_divisi 	= 'tbl_divisi';
	function __constuct()
	{
		parent::__constuct();  // Call the Model constructor 
		loader::database();    // Connect to current database setting.
	}
	
        //==== Get Country List ====//
        public function kat_country(){
            $this->db->select("CountryName");
	    $this->db->order_by("CountryName", 'asc');
            $this->db->group_by("CountryName");
            return $this->db->get('mg_city')->result_array();
        }
        
        //==== Get City List ====//
        public function kat_city(){
            $this->db->select("CityName");
	    $this->db->order_by("CityName", 'asc');
            return $this->db->get('mg_city')->result_array();
        }
        
        //==== Get Hotel List ====//
        public function kat_hotelOld(){
            $this->db->select("HotelName");
	    $this->db->order_by("HotelName", 'asc');
            return $this->db->get('mg_hotel')->result_array();
        }
	
	public function kat_hotel(){
            $this->db->select("name");
	    $this->db->order_by("name", 'asc');
            return $this->db->get('list_hotel_di_history')->result_array();
        }
        
	public function views_user($tbl_user){
		return $this->db->get($tbl_user);
			/* $query = $this->db->get('tbl_user');
			
				foreach ($query->result() as $data){
					$hasil[] = $data;
				}
				return $hasil ; */
			
		}
	public function AddUserDivisi($divisi,$username,$user_email,$password)
        {
			$data = array(
			'divisi_id' => $divisi,
			'username' => $username,
			'user_email' => $user_email,
			'password' => MD5($password),
			'posting_date' => date('Y-m-d H:i:s'),
			'update_date' => date('Y-m-d H:i:s')
		);
		if($this->db->insert('tbl_user', $data))
            {
                return true;    
            }
            else
            {
                return false;   
            } 
		//print_r($data);
        }
	public function view_divisi($tbl_divisi)
	{
	    return $this->db->get($tbl_divisi);
	}
	
	public function views_posisi()
	{
		$this->db->select('p.*, d.divisi_id, d.divisi_name');
		$this->db->from('tbl_posision p');
		$this->db->join('tbl_divisi d', 'p.divisi_id = d.divisi_id');
		$query =  $this->db->get();
		foreach ($query->result() as $data){
					$hasil[] = $data;
				}
		return $hasil ;
		
	}
	public function views_All_Req_employee()
	{
		$this->db->select('req.*, u.user_id, u.username, u.divisi_id, d.divisi_name, p.posisi_id, p.posisi_name');
		$this->db->from('request_employee req');
		$this->db->join('tbl_user u', 'req.user_id = u.user_id');
		$this->db->join('tbl_divisi d', 'u.divisi_id = d.divisi_id');
		$this->db->join('tbl_posision p', 'd.divisi_id = p.divisi_id');
		$query =  $this->db->get();
		foreach ($query->result() as $data){
					$hasil[] = $data;
				}
		return $hasil ;
		
	}
	public function getAllData($table)
	{
		return $this->db->get($table);
	}
	public function checkDivisi($tbl_divisi,$div_name)
	{
		return $this->db->get_where($tbl_divisi,array('divisi_name'=>$div_name));
	}
	public function checkPosisi($tbl_posision, $divisi_id, $posisi_name)
	{
		$sql  = "select * from ".$tbl_posision." where divisi_id = '".$divisi_id."' AND posisi_name = '".$posisi_name."'";
		$query =  $this->db->query($sql);
		return $query ;
		#return $this->db->get_where($tbl_posision,array('divisi_id'=>$divisi_id, 'posisi_name'=>$posisi_name));
	}
	public function checkPasswordToUser($tbl_user, $user_id, $password)
	{
		$sql  = "select password from ".$tbl_user." where user_id = ".$user_id."";
		$query =  $this->db->query($sql);
		return $query ;
		#return $this->db->get_where($tbl_posision,array('divisi_id'=>$divisi_id, 'posisi_name'=>$posisi_name));
	}
	public function getAllDataLimited($table,$limit,$offset)
	{
		return $this->db->get($table, $limit, $offset);
	}
	
	public function getSelectedDataLimited($table,$data,$limit,$offset)
	{
		return $this->db->get_where($table, $data, $limit, $offset);
	}
	
	public function getSelectedDataVenue($table,$data)
	{
		return $this->db->get_where($table,array('user_id'=>$data));
	}
	
	function updateData($table,$data,$field_key)
	{
		$query = $this->db->update($table,$data,$field_key);
		if($query){
            return true ;
        }else
            return false ;
	}
	
	function deleteData($table,$data)
	{
		$query = $this->db->delete($table,$data);
		if($query){
            return true ;
        }else
            return false ;
	}
	
	function deleteUser($tbl_user,$data)
	{
		$this->db->delete($tbl_user,$data);
	}
	
	function deletePosisi($table_posisi,$data)
	{
		$this->db->delete($table_posisi,$data);
	}
	
	function insertData($table,$data)
	{
            $query = $this->db->insert($table,$data);
            if($query){
                    return true ;
            }else
                    return false ;
	}
		

}
	
?>