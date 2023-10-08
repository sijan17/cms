<?php
require 'auth.php';
$prefix = "";
$to="";
$from = "";
function codeGen($s,$e,$p){
$number = range($s, $e);
$arr = [];
foreach ($number as $n) {
	$arr[$n]=strtoupper(bin2hex(random_bytes(2)));;
	
}


return $arr;
}

if(isset($_POST['submit'])){
	$to = $_POST['end'];
	$from = $_POST['start'];
	$prefix = $_POST['prefix'];

	$code = codeGen($from,$to,$prefix);
	$code;

	$data = "";
foreach ($code as $key => $value) {
	$data.= "('".$prefix.$key."','".$value."')";
	if($code[$key+1]!=NULL){
		$data.=",";
		}
}
}

if (isset($_POST['post'])) {
	$post = $obj_admin->postCode($_POST['data']);
}


?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Code Generator</title>
	<style type="text/css">
		table,tr,td{
			border: 1px solid black;
			border-collapse: collapse;
		}
	</style>
</head>
<body>
	<form name="form1" method="post">
	Prefix
	<br>
	<input type="text" name="prefix" placeholder="eg. BCA-2078-" value="<?php echo $prefix ?>"><br>Range<br>
	<input type="text" name="start" placeholder="From" value="<?php echo $from ?>">
	<input type="text" name="end" placeholder="To" value="<?php echo $to ?>"><br><br>
	<input type="submit" name="submit" value="Generate">
</form>
<?php if(isset($code)){ ?>
	<form method="post">
	<input type="hidden" name="data" value="<?php echo $data ?>">
	<input type="submit" name="post" value="Upload to Database">
</form>
<table>
	<tr>
		<td style="width:150px">Reg. No. </td>
		<td style="width:150px">Code</td>
	</tr>
	<?php foreach ($code as $key => $value) {?>
		<tr>
			<td><?php echo $prefix.$key ?> </td>
			<td><?php echo $value ?> </td>
		</tr>
	<?php } ?>
</table>




<?php } ?>
<script type="text/javascript" src="../js/jquery.js"></script>

</body>
</html>