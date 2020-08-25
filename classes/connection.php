<?php 
	class connection
	{
		protected $host;
		protected $user;
		protected $dbname;
		protected $password;
		public $connect;
		public const BASE_URL = 'http://localhost/oops/';
		public function __construct()
		{
			$this->host = 'localhost';
			$this->user = 'root';
			$this->dbname = 'oops';
			$this->password = '';
			$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
			$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

		}
		public function connect()
		{
			$connect = mysqli_connect($this->host,$this->user,$this->password,$this->dbname) or die(mysqli_connect_error());
			$this->connect = $connect; 
			return $connect;
		}
		public function insert($table,$data,$insertid=null)
		{
			$columns = '';
			$values = '';
			$prep='';
			$insert = 'error in inserting data';
			if(is_array($data)){
				$count = count($data);
				$i=1;
				foreach($data as $k => $v)
				{
					if($i<$count){ $prep = ","; }else{$prep = "";}
					$columns .= $k.$prep;
					$values .= "'$v'".$prep; 
					$i++;
				}
				$insert = mysqli_query($this->connect,"insert into $table values('null',$values)") or die(mysqli_error($this->connect));
			}
			if($insertid){
				return mysqli_insert_id($this->connect);
			}else
			{
				return $insert;
			}
			
		}
		public function getData($table, $columns, $joins=null, $orderby=null, $order=null, $where=null,$wherecond=null)
		{
			$sql = "select $columns from $table ";
		    if (is_array($joins) && count($joins) > 0)
		    {
		        foreach($joins as $k => $v)
		        {
		        	
		            $sql .= " ".$v['jointype']." join ".$v['table']." on ".$v['condition'];
		        }
		    }
		    if(isset($where) && is_array($where) && $wherecond!=null){
		    	$i=1;
		    	$count = count($where);
		    	$sql.= ' where ';
				foreach($where as $key=>$val){
					if($i<$count){ $prep = $wherecond; }else{$prep = "";}
					$sql .= $key.'='."'$val'"." ".$prep." ";
					$i++;
				}
			}
		    if(isset($orderby) && isset($order)){
				$sql .= $orderby.' '.$order;		    	
		    }
		    $query = mysqli_query($this->connect,$sql);
		    $arr = [];
		    while($rec = mysqli_fetch_assoc($query)){
		    	$arr[] = $rec;
		    }
		    return $arr;
		}
		public function countData($table, $columns, $joins=null, $orderby=null, $order=null, $where=null,$wherecond=null)
		{
			$sql = "select $columns from $table ";
		    if (is_array($joins) && count($joins) > 0)
		    {
		        foreach($joins as $k => $v)
		        {
		        	
		            $sql .= " ".$v['jointype']." join ".$v['table']." on ".$v['condition'];
		        }
		    }
		    if(isset($where) && is_array($where) && $wherecond!=null){
		    	$i=1;
		    	$count = count($where);
		    	$sql.= ' where ';
				foreach($where as $key=>$val){
					if($i<$count){ $prep = $wherecond; }else{$prep = "";}
					$sql .= $key.'='."'$val'"." ".$prep." ";
					$i++;
				}
			}
		    if(isset($orderby) && isset($order)){
				$sql .= $orderby.' '.$order;		    	
		    }
		    $query = mysqli_query($this->connect,$sql);
		    return mysqli_num_rows($query);
		} 
		public function setSession($name,$value){
			$_SESSION[$name] = $value;
		}
		public function getSession($name){
			if(isset($_SESSION[$name])){
				return $_SESSION[$name];
			}
		}
		public function unsetSession($name){
			unset($_SESSION[$name]);
		}
		public function logout(){
			session_start();
			session_destroy();
			header("location:".self::BASE_URL);
		}
	}


?> 