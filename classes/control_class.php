<?php


class control_class
{	

// -------------------------Set Database Connection----------------------

	public function __construct()
	{ 
     		$host_name='localhost';
		$user_name='root';
		$password='';
		$db_name='college';

		try{
			$connection=new PDO("mysql:host={$host_name}; dbname={$db_name}", $user_name,  $password);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db = $connection; 
		} catch (PDOException $message ) {
			echo $message->getMessage();
		}
	}


	// -----------------------Authorization----------------------------------

	public function auth(){
		if(isset($_COOKIE['c_session'])){
		$sess = $_COOKIE['c_session'];
		$sql = "SELECT * FROM swastik_users WHERE session=? ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([$sess]);
		$userRow = $stmt->fetch();
		if($userRow['user_id']!=NULL){
					$_SESSION['login'] = true;
	            $_SESSION['user_id'] = $userRow['user_id'];
	            $_SESSION['user_fullname'] = $userRow['user_fullname'];
	            $_SESSION['user_email'] = $userRow['user_email'];
	            $_SESSION['user_faculty'] = $userRow['user_faculty'];
	            $_SESSION['user_semester'] = $userRow['user_semester'];
	            $_SESSION['user_permission'] = $userRow['user_permission'];
	            $_SESSION['user_regno'] = $userRow['user_regno'];
	            if ($_SESSION['user_permission']==10) {
	            	$_SESSION['admin']=true;	
	            }
		}
		}else{
			header('Location: ../f-e/login.php');
			$_SESSION['login']=false;
			$_SESSION['admin']=false;
		}
	}

// -----------------------------Admin Check------------------------------

	public function admincheck(){
		if($_SESSION['admin']!=true){
			header('Location:../f-e/home.php');
		}
	}

   // ---------------------- sanitize_input_data ----------------------------
	
	public function sanitize_input_data($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data); 
		return $data;
	}

    // ----------------------Register New user -------------------------------

	public function add_new_user($data){
		require '../phpmailer/index.php';
		$user_faculty = "";
		$user_sem="0";
		$user_fullname  = $this->sanitize_input_data($data['fullname']);
		$user_email = $this->sanitize_input_data($data['email']);
		$user_permission = $this->sanitize_input_data($data['who']);
		$user_password1 = $this->sanitize_input_data(md5($data['password1']));
		if($user_permission==0){
			$user_faculty = $this->sanitize_input_data($data['faculty']);
			$user_sem = $this->sanitize_input_data($data['semester']);

		}
		$p = $data['password1'];
        $user_password2 = $this->sanitize_input_data(md5($data['password2']));
        $user_regno = $this->sanitize_input_data($data['regno']);
        $user_code = $this->sanitize_input_data($data['code']);
        if($user_fullname!=NULL && $user_email !=NULL && $user_permission!=NULL && $user_password1 !=NULL &&  $user_code != NULL ){
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
  		$message = "Invalid email format.";
		}else{
		try{
			$sqlEmail = "SELECT user_email FROM swastik_users WHERE user_email = '$user_email' ";
			$query_result_for_email = $this->db->prepare($sqlEmail);
			$query_result_for_email->execute();
			$total_email = $query_result_for_email->rowCount();

			$sqlCode = "SELECT * FROM swastik_codes WHERE reg_no = ? ";
				$query_result_for_code= $this->db->prepare($sqlCode);
				$query_result_for_code->execute([$user_regno]);
				$res = $query_result_for_code->fetch();
				$total_code = $query_result_for_code->rowCount();
				 

			if($total_email != 0){
				$message = "Email already taken";
			} 
			elseif($user_password1 != $user_password2 ){
			 $message = "Passwords don't match.";
            }
			elseif(strlen($p)<=5){
				$message = "Password must be of at least 6 characters.";
			}elseif($total_code ==0){
						$message = "Registration number not found";
			}elseif($user_code != $res['code']){
						$message = "Code not matched for this reg no.";
			}else{
			$host =$_SERVER['HTTP_HOST'];
			$secret = bin2hex(random_bytes(20));
			$mail->Body = "<p>Hi ".$user_fullname.",</p><br><p>Please click the button below to verify your email address.</p><br><a style='text-decoration:none;color: white;padding:5px;background-color:green;border-radius:4px' href='http://".$host."/swastik/f-e/verification.php?secret=".$secret."'>Verify Email Address </a><br><br>Clicking not working? Try pasting this link into your browser: <br> http://".$host."/swastik/f-e/verification.php?secret=".$secret."<br><br><p>If you did not create an account, no further action is required.</p>";
			$mail->addAddress($user_email);
			if ( $mail->send() ) {

				
				$add_user = $this->db->prepare("INSERT INTO swastik_users_tbv (user_fullname, user_email, user_password, user_permission, user_code,user_faculty, user_semester,user_secret,user_regno) VALUES (:x, :y, :z, :a, :b, :c, :d, :e, :f) ");
				$add_user->bindparam(':x', $user_fullname);
				$add_user->bindparam(':y', $user_email);
				$add_user->bindparam(':z', $user_password1);
				$add_user->bindparam(':a', $user_permission);
				$add_user->bindparam(':b', $user_code);
				$add_user->bindparam(':c', $user_faculty);
				$add_user->bindparam(':d', $user_sem);
				$add_user->bindparam(':e', $secret);
				$add_user->bindparam(':f', $user_regno);
				if($add_user->execute()){
				setcookie('signupsuccess',true,time()+86400*2);
				header('Location: success.php');	
				}
				else{
					$message = "Error while inserting your info ";
				}			
			}
			else{
			die("Sorry, We cannot send you email right now.");
			}
	
			$mail->smtpClose(); 
		}

		}catch (PDOException $e) {
			$message = $e->getMessage();
			
		}
	}
	}
	else{
		$message = "All fields are required.";
	}
	return $message;
	}

	// ---------------------Email Validation-----------------------------

	public function emailValidation($e){
		if (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
  		$emailErr = "Invalid email format.";
		}
		else {
			try{
			$sqlEmail = "SELECT user_email FROM swastik_users WHERE user_email = '$user_email' ";
			$query_result_for_email = $this->db->prepare($sqlEmail);
			$query_result_for_email->execute();
			$total_email = $query_result_for_email->rowCount();
			if($total_email != 0){
				$emailErr= "Email already taken";
			} else{
				$emailErr = "";
			}
			
		}catch (PDOException $e) {
			echo $e->getMessage();
	}
}
return $emailErr;
}


// --------------------------Login Validation-------------------------

	public function validate_user($data) {
        
        $user_password = $this->sanitize_input_data(md5($data['password']));
		$user_email = $this->sanitize_input_data($data['email']);
		
        try
       {
          $stmt = $this->db->prepare("SELECT * FROM swastik_users WHERE user_email=:email AND user_password=:password LIMIT 1");
          $stmt->execute(array(':email'=>$user_email, ':password'=>$user_password));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
          	if($userRow['isactive']!=1){
          		$message = "	<p style='color:black; font-size:15px'>Sorry. Your account is deactivated. If you think you should be able to login, <a  style='color:green' href='contact.php'>contact here.</a></p> ";
          	}
          	else{
          		session_start();
          		$sess = bin2hex(random_bytes(20));


          			setcookie('c_session',$sess,time()+86400*30, "/","", 0);
          			$sql = "UPDATE swastik_users SET session=? WHERE user_id=?";
						$stmt = $this->db->prepare($sql);
						$stmt->execute([$sess, $userRow['user_id']]);
          		$_SESSION['login'] = true;
	            $_SESSION['user_id'] = $userRow['user_id'];
	            $_SESSION['user_fullname'] = $userRow['user_fullname'];
	            $_SESSION['user_email'] = $userRow['user_email'];
	            $_SESSION['user_faculty'] = $userRow['user_faculty'];
	            $_SESSION['user_semester'] = $userRow['user_semester'];
	            $_SESSION['user_permission'] = $userRow['user_permission'];

	            if ($_SESSION['user_permission']==10) {
	            	$_SESSION['admin'] = true;
	            	header('Location:../admin/home.php');

	            }else{

	            setcookie('signupsuccess',false,time()+10); 
				header('Location: home.php');
			}
		}
				
             
          }else{
			  $message = 'Invalid Email or Password.';
             
			 
		  }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
       return $message;	
		
    }

    // --------------Display Everything-------------

	public function display($p , $q){
		try{
			$sql = "SELECT * FROM $p ORDER BY $q DESC";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$result = $stmt->fetchAll();
			return $result;		
		} catch (PDOException $exception) {
			$message = "<p style='color:red'>Something went wrong. </p>";
			
		  }
	}

	// ---------------------------Post Notices-----------------------------
	public function post_notice($data){
		$notice_content  = $this->sanitize_input_data($data['notice_content']);
		if($notice_content!=NULL){
		try{
			$upload_notice = $this->db->prepare('INSERT INTO swastik_notices(notice_content, notice_author,user_id)VALUES(:a,:b,:c)');
			$upload_notice->bindparam(':a', $notice_content);
			$upload_notice->bindparam(':b', $_SESSION['user_fullname']);
			$upload_notice->bindparam(':c', $_SESSION['user_id']);
			$upload_notice->execute();
			
			$message = "<p style='color:green;'>Posted.</p>";
			
			
		}
		catch(PDOException $exception){
			echo "Sorry, notice couldn't be published. (Internal Server Error)";
			

		}
	}
	else{
		$message = "<p style='color:red;'>Notice can not be empty.</p>";

	}
	return $message;
	}




	// ------------------------------Post Assignment--------------------------
	public function post_assi($data, $file){
		
		$assi_title = $this->sanitize_input_data($data['assi_title']);
		$assi_faculty = $this->sanitize_input_data($data['faculty']);
		$assi_semester = $this->sanitize_input_data($data['semester']);
		$assi_desc = $this->sanitize_input_data($data['assi_desc']);
		$assi_due_date = $this->sanitize_input_data($data['assi_due_date']);
		$filename = NULL;
		if($assi_title!=NULL && $assi_desc!=NULL && $assi_due_date!=NULL && $assi_faculty != NULL && $assi_semester !=NULL ){
		if($file['name'] != NULL){
		$filename = $this->sanitize_input_data($file["name"]);
		$hash = bin2hex(random_bytes(6));
		$tempname = $file["tmp_name"];	
    	$folder = "../Files/Assignments/".$filename;
		$FileType = strtolower(pathinfo($folder,PATHINFO_EXTENSION));
		$filename = $assi_title." (".$hash.").".$FileType;
		$folder = "../Files/Assignments/".$filename;

		if (file_exists($folder)) {
			$message = "<p style='color:red;'>File Name already exists.</p>";
		  }

		  else if($FileType !=  "pdf" ) {
			$message = "<p style='color:red;'>Only PDF file is allowed.</p>";
			
		  }

		  else
    	if(!move_uploaded_file($tempname, $folder)){
			$message = "<p style='color:red;'>Problem while uploading.</p>";

		}
		else{

		try{
			$post_assi = $this->db->prepare('INSERT INTO swastik_assignments(assi_title, assi_desc, assi_due_date, assi_author, assi_file, assi_faculty, assi_semester,user_id)VALUES(:a,:b,:c,:d,:e,:f,:g,:h)');
			$post_assi->bindparam(':a', $assi_title);
			$post_assi->bindparam(':b', $assi_desc);
			$post_assi->bindparam(':c', $assi_due_date);
			$post_assi->bindparam(':d', $_SESSION['user_fullname']);
			$post_assi->bindparam(':e', $filename);
			$post_assi->bindparam(':f', $assi_faculty);
			$post_assi->bindparam(':g', $assi_semester);
			$post_assi->bindparam(':h', $_SESSION['user_id']);
			$post_assi->execute();
			$message = "<p style='color:green;'>Assignment posted successfully.</p>";
		}
		catch(PDOException $exception){
			echo $exception;
		}
	}
}

		else{
			try{
				$post_assi = $this->db->prepare('INSERT INTO swastik_assignments(assi_title, assi_desc, assi_due_date, assi_author,assi_faculty, assi_semester,user_id)VALUES(:a,:b,:c,:d,:f,:g,:h)');
				$post_assi->bindparam(':a', $assi_title);
				$post_assi->bindparam(':b', $assi_desc);
				$post_assi->bindparam(':c', $assi_due_date);
				$post_assi->bindparam(':d', $_SESSION['user_fullname']);
				$post_assi->bindparam(':f', $assi_faculty);
				$post_assi->bindparam(':g', $assi_semester);
				$post_assi->bindparam(':h', $_SESSION['user_id']);
				$post_assi->execute();
				$message = "<p style='color:green;'>Posted.</p>";
			}
			catch(PDOException $exception){
				echo $exception->getMessage();
			}

		}
	}else{
		$message = "<p style='color:red;'>Please fill all required fields.</p>";

	}
		return $message;
	}	



	// -----------------------------Upload Notes----------------------------------

	public function upload_note($data, $file){

		$note_title = $this->sanitize_input_data($data['note_title']);
		$note_faculty = $this->sanitize_input_data($data['faculty']);
		$note_semester= $this->sanitize_input_data($data['semester']);
		
		$filename = $this->sanitize_input_data($file["name"]);
		$tempname = $file["tmp_name"];	
		if($note_title !=NULL && $note_faculty !=NULL && $note_semester!=NULL ){

		
		if($file['name'] != NULL){

		$hash = bin2hex(random_bytes(6));
		$tempname = $file["tmp_name"];	
		$folder = "../Files/Notes/".$filename;
		$FileType = strtolower(pathinfo($folder,PATHINFO_EXTENSION));
		$filename = $note_title." (".$hash.").".$FileType;
		$folder = "../Files/Notes/".$filename;
		if (file_exists($folder)) {
			$message = "<p style='color:red;'>File Name already exists.</p>";
		  }

		  else if($FileType !=  "pdf" ) {
			$message = "<p style='color:red;'>Only PDF file is allowed.</p>";
			
		  }

		  else{
    	move_uploaded_file($tempname, $folder);
		try{
			$upload_note = $this->db->prepare('INSERT INTO swastik_notes(note_title, note_file, note_author, note_faculty, note_semester, user_id)VALUES(:a,:b,:c,:d,:e,:f)');
			$upload_note->bindparam(':a', $note_title);
			$upload_note->bindparam(':b', $filename);
			$upload_note->bindparam(':c', $_SESSION['user_fullname']);
			$upload_note->bindparam(':d', $note_faculty);
			$upload_note->bindparam(':e', $note_semester);
			$upload_note->bindparam(':f', $_SESSION['user_id']);

			if($upload_note->execute()){
			$message = "<p style='color:green;'>File Uploaded Successfully.</p>";
		}
		else{
			$message = "<p style='color:red;'>Something went wrong.</p>";
		}
		}
		catch(PDOException $exception){
			$message = $exception->getMessage();
		}
	}
} else{
	$message = "<p style='color:red;'>Please select a file.</p>";

}
		}else{
			$message ="<p style='color:red;'>Please fill all fields.</p>";

		}
	return $message;
	}


	// ------------------------Download Notes----------------------

	public function download_notes($data){
		$id = $this->sanitize_input_data($data['id']);
		$sql = "SELECT note_file FROM swastik_notes where note_id=$id";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$note = $stmt->fetch();

			$file = $note['note_file'];    
			$filepath = "../Files/Notes/" . $file;

			// Process download
				if(file_exists($filepath)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($filepath));
					flush(); // Flush system output buffer
					readfile($filepath);
					exit;
				}   

	}

// -----------------Display Notes and Assignment-----------------

	public function display_($p , $q, $r, $s){
		try{
			$sql = "SELECT * FROM $p where $q = ? AND $r =? ORDER BY $s DESC";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([$_SESSION['user_faculty'], $_SESSION['user_semester']]);
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$result = $stmt->fetchAll();
			return $result;		
		} catch (PDOException $exception) {
			echo "Sorry, Internal Server Error.";
		  }
	}



	// -------------Open Notes----------------------------------




	public function open_notes($data){
		$id = $this->sanitize_input_data($data['id']);
		$sql = "SELECT note_file FROM swastik_notes where note_id=$id";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$note = $stmt->fetch();

			$file = $note['note_file'];    
			$filepath = "../Files/Notes/" . $file;
			header('Content-type: application/pdf');			
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');

			// Read the file

			@readfile($filepath);

		}


// ------------------------Download Assignments-----------------------
public function download_assi($data){
	$id = $this->sanitize_input_data($data['id']);
	$sql = "SELECT assi_file FROM swastik_assignments where assi_id=$id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$assi = $stmt->fetch();

		$file = $assi['assi_file'];    
		$filepath = "../Files/Assignments/" . $file;

		// Process download
			if(file_exists($filepath)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($filepath));
				flush(); // Flush system output buffer
				readfile($filepath);
				exit;
			}   

}


public function open_assi($data){
	$id = $this->sanitize_input_data($data['id']);
	
	$sql = "SELECT assi_file FROM swastik_assignments where assi_id=$id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$assi = $stmt->fetch();

		$file = $assi['assi_file'];    
		$filepath = "../Files/Assignments/" . $file;
		header('Content-type: application/pdf');			
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');

		// Read the file

		@readfile($filepath);

	}

//--------------Feedback------------------------------

	public function post_feedback($data){
		$feedback_content  = $this->sanitize_input_data($data['feedback']);
		$anonymous = $this->sanitize_input_data($data['anonymous']);
		if($anonymous == 1){
			$feedback_by = "Anonymous";
		}else{
			$feedback_by = $_SESSION['user_fullname'];
		}
		if($feedback_content!=NULL){
		try{
			$post_feedback = $this->db->prepare('INSERT INTO swastik_feedback(feedback_content, feedback_by)VALUES(:a, :b)');
			$post_feedback->bindparam(':a', $feedback_content);
			$post_feedback->bindparam(':b', $feedback_by);
			$post_feedback->execute();
			
			$message = "<p style='color:green;'>Thanks for your feedback!</p>";
			
			
		}
		catch(PDOException $exception){
			echo "Sorry, Internal Server Error.";
			

		}
	}
	else{
		$message = "<p style='color:red;'>Feedback can not be empty.</p>";

	}
	return $message;
	}



// -------------------External Resources--------------------

public function post_resource($data){
		$resource_title  = $this->sanitize_input_data($data['name']);
		$resource_link = $this->sanitize_input_data($data['link']);
		if($resource_title!=NULL AND $resource_link != NULL){
		try{
			$post_resource = $this->db->prepare('INSERT INTO swastik_resources(resource_title, resource_link)VALUES(:a, :b)');
			$post_resource->bindparam(':a', $resource_title);
			$post_resource->bindparam(':b', $resource_link);
			$post_resource->execute();
			$message = "<p style='color:green;'>Posted.</p>";
		}
		catch(PDOException $exception){
			echo "Sorry, Internal Server Error.";
		}
	}
	else{
		$message = "<p style='color:red;'>Please Fill all fields.</p>";

	}
		return $message;
	}



// ---------------------Time Ago----------------------------


public function time_ago($timestamp){

	date_default_timezone_set('Asia/Kathmandu');
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
   
    
    $minutes = round($seconds/60);
    $hours = round($seconds/3600);
    $days = round($seconds/86400);  
    $weeks = round($seconds/604800);
    $months = round($seconds/2629400);

    if($seconds<=60){
        return "Just Now";
        
    }
    else if($minutes <= 60){
        return "$minutes Min ago";
    }
    else if($hours<=24){
        return $hours."H ago";

    }
    else if($days<=7){
        return $days."D ago";
    }
    else if($weeks<=5){
        return $weeks."W ago";
    }
    else if($months<=12){
        return $months."Mo ago";
    }
}


// ---------------TIme Left-------------------

public function time_left($timestamp){

	date_default_timezone_set('Asia/Kathmandu');
    $time_left = strtotime($timestamp);
    $current_time = time();
    $time_difference =  $time_left - $current_time;
    $seconds = $time_difference;
   
    
    $minutes = round($seconds/60);
    $hours = round($seconds/3600);
    $days = round($seconds/86400);  
    $weeks = round($seconds/604800);
    $months = round($seconds/2629400);

    if($seconds<0){
    	return "<a style='color:red'>Due date crossed.</a>";
    }

    if($seconds<=60){
        return "Less than 1 min left";
        
    }
    else if($minutes <= 60){
        return $minutes."minutes left";
    }
    else if($hours<=24){
        return $hours."H left";

    }
    else if($days<=7){
        return $days."D left";
    }
    else if($weeks<=5){
        return $weeks."W left";
    }
    else if($months<=12){
        return $months."Mo left";
    }
}


// -----------User Count-----------------

public function count($a, $b, $c){
	 try
       {
          $stmt = $this->db->prepare("SELECT * FROM $a WHERE $b=?");
          $stmt->execute([$c]);
          $userRow=$stmt->rowCount();
          return $userRow;
} catch(PDOException $e){
	echo "Sorry, Internal Server Error.";
}
}


// ----------------------Verify User---------------------

public function verifyUser($id){
	require '../../phpmailer/index.php';
	try
       {
          $stmt = $this->db->prepare("SELECT * FROM swastik_users_tbv WHERE user_id=? ");
          $stmt->execute([$id]);
          $r = $stmt->fetch();
} catch(PDOException $e){
	echo $e->getMessage;
}
$mail->Body = "<h2>Account Verified</h2><br><p>Hi ".$r['user_fullname'].",</p><br><p>Your Account has been verified. Go to your browser or click the button below to login.</p><br><a style='text-decoration:none;color: white;padding:5px;background-color:green;border-radius:4px' href='http://cms-swastik.rf.gd/swastik/f-e/login.php'>Click Here</a><br><br><br>Regards,<br>cms-swastik";
				$mail->addAddress($r['user_email']);
				if ( $mail->send() ) {
			try{

				$add_user = $this->db->prepare("INSERT INTO swastik_users (user_fullname, user_email, user_password, user_permission, user_regno,user_faculty, user_semester) VALUES (:x, :y, :z, :a, :b,:c,:d) ");
				$add_user->bindparam(':x', $r['user_fullname']);
				$add_user->bindparam(':y', $r['user_email']);
				$add_user->bindparam(':z', $r['user_password']);
				$add_user->bindparam(':a', $r['user_permission']);
				$add_user->bindparam(':b', $r['user_regno']);
				$add_user->bindparam(':c', $r['user_faculty']);
				$add_user->bindparam(':d', $r['user_semester']);
				if($add_user->execute()){
					setcookie('message','Verified',time()+5, "/","", 0);
					$stmt1 = $this->db->prepare("DELETE FROM swastik_users_tbv WHERE user_id=? ");
					$stmt1->execute([$id]);

				}
				else {
					$message = "Something went wrong";
				}
			}catch(PDOException $e){
				echo $e->getMessage;
			}
		}else{
			die("mm");
		}
}



// --------------------Delete----------------------

public function delete($a, $b, $c){
	if($a=="swastik_assignments"){
		$as = "SELECT assi_file from swastik_assignments where $b=?";
		$s1 = $this->db->prepare($as);
		$s1->execute([$c]);
		$asi = $s1->fetch();
		$todelete = "../../Files/Assignments/".$asi['assi_file'];
		unlink($todelete);
	}

	if($a=="swastik_notes"){

		$as = "SELECT note_file from swastik_notes where $b=?";
		$s1 = $this->db->prepare($as);
		$s1->execute([$c]);
		$no = $s1->fetch();
		$todelete = "../../Files/Notes/".$no['note_file'];
		// die($todelete);
		unlink($todelete);
	}

	try{	
			$sql = "DELETE  FROM $a where $b=?";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([$c]);
			setcookie('message','<h2 style="color:red">Deleted',time()+5, "/","", 0);
			
		} catch (PDOException $exception) {
			echo $exception->getMessage();
		  }

		  if($a=="swastik_users_tbv"){
		  	require '../../phpmailer/index.php';
		  	$u = "SELECT * from swastik_users_tbv where user_id=?";
		  	$s2 = $this->db->prepare($u);
			$s2->execute([$c]);
			$r=$s2->fetch();

			$mail->Body = "<br><p>Hi ".$r['user_fullname'].",</p><br><p>We are sorry, your account can not be verified. If you think this is our fault, try re-registering with valid information. Thank you.  </p><br><br><br><br>Regards,<br>cms-swastik";
			$mail->addAddress($r['user_email']);
			$mail->send();


	}

}


// ----------------Edit--------------------------

public function edit($a, $b, $c, $d){

	try{
			$sql = "SELECT $a  FROM $b where $c=?";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([$d]);
			$res = $stmt->fetch();
			return $res;
			
		} catch (PDOException $exception) {
			echo $exception->getMessage();
		  }

}

// --------------Update-------------------

public function update($a, $data, $c, $d){

	try{
			$sql = "UPDATE $a  SET $data WHERE $c=?";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([$d]);
			setcookie('message','Updated',time()+5, "/","", 0);
			
		} catch (PDOException $exception) {
			echo $exception->getMessage();
		  }

}

// --------------Deactivate	-------------------

public function notActive($a){

	try{
			$sql = "UPDATE swastik_users SET isactive=0 WHERE user_id=?";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([$a]);
			setcookie('message','<h2 style="color:red">Closed',time()+5, "/","", 0);
			
		} catch (PDOException $exception) {
			echo $exception->getMessage();
		  }

}


// --------------Increment Semester-------------
public function increment($key){
	try{
			$sql = "UPDATE swastik_users SET user_semester = user_semester+1 where user_faculty=?";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([$key]);
			setcookie('message','Incremented',time()+5, "/","", 0);
			
		} catch (PDOException $exception) {
			$message = $exception->getMessage();
		  }
		  return $message;
}


// --------------Change Password-----------

public function changePw($a, $b, $c){
	$cp = $this->sanitize_input_data(md5($a));
	$np = $this->sanitize_input_data(md5($b));
	try{
			$sql = "SELECT * FROM swastik_users  where user_id=?";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([$c]);
			$res = $stmt->fetch();

			if($res['user_password']==$cp){
				if(strlen($b)<6){
					setcookie('message','<p style="color:red">New password should be of at least 6 characters.</p>',time()+5, "/","", 0);
				}else{
				$sql1 = "UPDATE swastik_users SET user_password=? WHERE user_id=?";
				$stmt1 = $this->db->prepare($sql1);
				$stmt1->execute([$np, $c]);
				setcookie('message','Password Changed. ',time()+5, "/","", 0); }
			}else{
				setcookie('message','<p style="color:red">Please enter correct current password. </p>',time()+5, "/","", 0);
			}

		} catch (PDOException $exception) {
			echo $exception->getMessage();
		  }
}


public function changeImage($file){

		
		
		$tempname = $file["tmp_name"];	
		if($file['name'] != NULL){
		$hash = bin2hex(random_bytes(8));
		$filename = $hash.$this->sanitize_input_data($file["name"]);
    	$folder = "../user-img/".$filename;
		$FileType = strtolower(pathinfo($folder,PATHINFO_EXTENSION));

		if (file_exists($folder)) {
			$message = "<p style='color:red;'>Please try again.</p>";
		  }
		  
		else{
		try{
			$sql1 = "SELECT user_image FROM swastik_users where user_id=?";
			$stmt1 = $this->db->prepare($sql1);
			$stmt1->execute([$_SESSION['user_id']]);
			$res=$stmt1->fetch();
			if($res['user_image']!='user-default.png'){
			$todelete = "../user-img/".$res['user_image'];
			unlink($todelete);
		}
		}
		catch(PDOException $exception){
			$message .= $exception->getMessage();
		}
    	move_uploaded_file($tempname, $folder);
		try{
			$sql = "UPDATE swastik_users  SET user_image=? WHERE user_id=?";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([$filename, $_SESSION['user_id']]);
			setcookie('message','Profile Updated.',time()+5, "/","", 0);
		}
		catch(PDOException $exception){
			$message = $exception->getMessage();
		}

	}
} else{
	$message = "<p style='color:red;'>Please select a file.</p>";

}		
return $message;

}


// ------------Post Questions-----------

public function post_questions($data){
		$q_content  = $this->sanitize_input_data($data['q_content']);
		if($q_content!=NULL){
		try{
			$upload_q = $this->db->prepare('INSERT INTO swastik_questions(q_content, q_by)VALUES(:a,:c)');
			$upload_q->bindparam(':a', $q_content);
			$upload_q->bindparam(':c', $_SESSION['user_id']);
			$upload_q->execute();
			
			$message = "<p style='color:green;'>Posted.</p>";			
			
		}
		catch(PDOException $exception){
			echo $exception->getMessage();			

		}
	}
	else{
		$message = "<p style='color:red;'>Question can not be empty.</p>";

	}
	return $message;
	}


// ------------Post Reply-----------

public function post_replies($data, $c){
		$r_content  = $this->sanitize_input_data($data['r_content']);
		if($r_content!=NULL){
		try{
			$upload_r = $this->db->prepare('INSERT INTO swastik_replies(r_content, r_by, r_to)VALUES(:a,:b,:c)');
			$upload_r->bindparam(':a', $r_content);
			$upload_r->bindparam(':b', $_SESSION['user_id']);
			$upload_r->bindparam(':c', $c);
			$upload_r->execute();
			
			$message = "<p style='color:green;'>Posted.</p>";			
			
		}
		catch(PDOException $exception){
			echo $exception->getMessage();			

		}
	}
	else{
		$message = "<p style='color:red;'>Reply can not be empty.</p>";

	}
	return $message;
	}


// --------------Email Verification-------------

	public function verifyEmail($s){
		$s = $this->sanitize_input_data($s);
		try{
			$sql = "SELECT * FROM swastik_users_tbv where user_secret=?";
			$stmt = $this->db->prepare($sql);
			$stmt->execute([$s]);
			$r=$stmt->fetch();
			if ($r['user_id']!=null) {
			$id = $r['user_id'];
			$sql1 = "UPDATE swastik_users_tbv SET user_email_verified=1 WHERE user_id=?";
			$stmt1 = $this->db->prepare($sql1);
			$stmt1->execute([$id]);
			return true;
			}else{

			return false;
		}
		}
		catch(PDOException $exception){
			$message .= $exception->getMessage();
		}



	}

// --------Post Code--------------

	public function postCode($data){
		$sql = "INSERT INTO swastik_codes(reg_no,code) VALUES $data";
		// die($sql);
		$stmt = $this->db->prepare($sql);
		if($stmt->execute()){
			return "<p style='color:green' >Posted. </p>";
		}else{
			return "<p style='color:red' >Not Posted. </p>";
		}
	}

}


?>
