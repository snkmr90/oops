<?php 
	require_once 'layout/header.php';

	if(!$connect->getSession('session_user_id') == null){
		header('location:account.php');
	}

	$errors= [];
	if(isset($_POST['login'])){
		$email = $_POST['email'];
		$password = $_POST['password'];
		//validation-->
		$rules = [
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

		//<-- validations

		if(isset($errors) && is_array($errors) && !empty($errors)){
		}else{
			$password = md5($password);
			$table='users';
			$where = ['user_email'=>$email,'user_password'=>$password];
			$columns ='*';
			$getdata = $connect->getData($table='users', $columns='*', $joins=null, $orderby=null, $order=null, $where, $wherecond='AND');
			if($getdata !=null){
				$connect->setSession('session_user_id',$getdata[0]['user_id']);
				header('location:'.connection::BASE_URL.'account.php');
			}else{
				$errors['userNotExist'] = "User doesn't exist please check the details entered";
			} 
			}

	}
	?>
  
<div class="container">
  <div class="row">
    	<div class="col-md-6">
    		<h3>User Login</h3>
    		<?php if($connect->getSession('regSuccess') != null){ ?>
    			<div class="alert-success">
    			<?php 
    				echo $connect->getSession('regSuccess');
    				$connect->unsetSession('regSuccess');
    			?>
    			</div>
    		<?php } ?>
    		
    		<?= isset($errors['userNotExist'])?'<div class="alert-danger">'.$errors['userNotExist'].'</div>':''; ?>
    	<form method="POST" id="loginForm" >
		  <div class="form-group">
		    <label for="email">Email address:</label>
		    <input type="text" class="form-control" name="email" value="<?=isset($_POST['email'])?$_POST['email']:'';?>" id="email">
		    <?= isset($errors['email'])?'<div class="text-danger">'.$errors['email'].'</div>':''; ?>
		  </div>
		  <div class="form-group">
		    <label for="pwd">Password:</label>
		    <input type="password" class="form-control" name="password" id="pwd">
		    <?= isset($errors['password'])?'<div class="text-danger">'.$errors['password'].'</div>':''; ?>
		  </div>
		  <button name="login" type="submit" class="btn btn-default">login</button>
		</form>
		</div>
    </div>
</div>
<?php 
	require_once 'layout/footer.php';
?>