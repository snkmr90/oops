<?php 
	require_once 'layout/header.php';
	$errors= [];
	if(isset($_POST['register'])){
		$userName = $_POST['userName'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$table='users';
			$where = ['user_email'=>$email];
			$columns ='*';
			$getCount = $connect->countData($table, $columns='*', $joins=null, $orderby=null, $order=null, $where, $wherecond='AND');
		//validation-->
			$rules = [
				[
			        'fieldName' => 'userName',
			        'required' => true,
			    ],
			    [
			        'fieldName' => 'password',
			        'required' => true,
			    ],
			    [
			        'fieldName' => 'email',
			        'type' => 'email',
			        'required' => true,
			    ]
			];
			$validator = new validator();
			$errors = $validator->validate($rules, $_POST);
		if ($getCount>0) 
		{
		    $errors['email'] = "Email is already existing";

		}
		if(isset($_FILES['file']['name']) && $_FILES['file']['name'] =='' ){
			$errors['image'] = "Image is required";	
		}
		//<-- validations

		if(isset($errors) && is_array($errors) && !empty($errors)){
		}else{
			$password = md5($password);
			$path = 'uploads/';
			if(!is_dir($path)){
				mkdir($path,0777,true);
			}
			$extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
			$newname= uniqid().'.'.$extension;
			move_uploaded_file($_FILES["file"]["tmp_name"], $path.$newname);
			$userdata = ['user_name'=>$userName,'user_password'=>$password,'user_email'=>$email,'user_image'=>$newname];
			$table='users';
			$insert = $connect->insert($table,$userdata,$return = true);
			if($insert){
				$connect->setSession('regSuccess','Thankyou for registering with us, Please Login');
				header('location:'.connection::BASE_URL.'login.php');
			}
		} 

	}
	?>  
<div class="container">
  <div class="row">
    	<div class="col-md-6">
    		<h3>User Registration</h3>
    	<form method="POST" id="registerForm" enctype="multipart/form-data">
		<div class="form-group">
		    <label for="name">Name:</label>
		    <input type="name" class="form-control" name="userName" id="name" value="<?=isset($_POST['userName'])?$_POST['userName']:'';?>">
		    <?= isset($errors['userName'])?'<div class="text-danger">'.$errors['userName'].'</div>':''; ?>
	  	</div>
		  <div class="form-group">
		    <label for="email">Email address:</label>
		    <input type="text" class="form-control" name="email" value="<?=isset($_POST['email'])?$_POST['email']:'';?>" id="email">
		    <?= isset($errors['email'])?'<div class="text-danger">'.$errors['email'].'</div>':''; ?>
		  </div>
		  <div class="form-group">
		    <label for="pwd">Password:</label>
		    <input type="password" class="form-control" name="password" id="pwd" value="<?=isset($_POST['password'])?$_POST['password']:'';?>">
		    <?= isset($errors['password'])?'<div class="text-danger">'.$errors['password'].'</div>':''; ?>
		  </div>
		  <div class="form-group">
		    <label for="pwd">Upload you profile image:</label>
		    <input type="file" class="form-control" id="file" name="file">
		    <?= isset($errors['image'])?'<div class="text-danger">'.$errors['image'].'</div>':''; ?>
		  </div>

		  <button name="register" type="submit" class="btn btn-default">Submit</button>
		</form>
		</div>
    </div>
</div>
<?php 
	require_once 'layout/footer.php';
?>