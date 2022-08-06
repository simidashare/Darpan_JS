<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ../index.php");
  exit;
}else{
	include "../database.php";	
}

$myArray = array();
$addState = null;
$currentChildAi = null;



if (isset($_GET["loadRoster"]) && $_GET["loadRoster"] == "1")
{
	$sql = "select a.BroadcastDate,b.broadcastername,b.broadcasterid from broadcastroster as a join broadcaster as b on a.BroadcasterId = b.broadcasterid order by a.BroadcastDate desc limit 100";
	$result = dbProcess($sql,$conn,$myArray);
	exit(json_encode($result));
}


if (isset($_GET["changePassword"]) && $_GET["changePassword"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);	
	if(isset($str)){
		$Broadcasterid = $_SESSION["broadcasterid"];
        $curPass = $str['obj']['curPass'];
        $newPass = $str['obj']['newPass'];
        $confirmNewPass = $str['obj']['confirmNewPass'];
		$checkedCurrentPassword = checkedCurrentPassword ($curPass,$Broadcasterid,$conn,$myArray);
		if($newPass == "" || $confirmNewPass == ""){
			exit(json_encode("Password cannot be empty"));
		}
		if($checkedCurrentPassword){
			if($newPass == $confirmNewPass){
				$updateProcess = updateSql($newPass,$Broadcasterid,$conn,$myArray);			
				exit(json_encode("Password is updated successfully"));
			}else{
				exit(json_encode("Confirm password is not same as your new password"));
			}
			
		}else{
			exit(json_encode("Current password is incorrect"));
		}
		
		
	}
}

if (isset($_GET["editRoster"]) && $_GET["editRoster"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);	
	if(isset($str)){
        $BroadcastDate = $str['obj']['BroadcastDate'];
        $Broadcasterid = $str['obj']['Broadcasterid'];
        $BroadcasterOldId = $str['obj']['BroadcasterOldId'];
		$chkedRecord = chkRecord($BroadcastDate,$Broadcasterid,$conn,$myArray);
		if(!$chkedRecord){
			$deleteProcess = deleteSql($BroadcastDate,$BroadcasterOldId,$conn,$myArray);
			$addProcess = addSql($BroadcastDate,$Broadcasterid,$conn,$myArray);		
			exit(json_encode("Broadcaster updated successfully"));
		}else{
			exit(json_encode("Record exists"));
		}
		
	}
}

if (isset($_GET["deleteRoster"]) && $_GET["deleteRoster"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);	
	if(isset($str)){
        $BroadcastDate = $str['obj']['BroadcastDate'];
        $Broadcasterid = $str['obj']['Broadcasterid'];
        $BroadcasterOldId = $str['obj']['BroadcasterOldId'];
		$deleteProcess = deleteSql($BroadcastDate,$BroadcasterOldId,$conn,$myArray);			
		exit(json_encode("Broadcaster deleted successfully"));		
	}
}

if (isset($_GET["addRoster"]) && $_GET["addRoster"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);	
	if(isset($str)){
		$BroadcastDate = $str['obj']['BroadcastDate'];
        $Broadcasterid = $str['obj']['Broadcasterid'];
		$chkedRecord = chkRecord($BroadcastDate,$Broadcasterid,$conn,$myArray);
		if(!$chkedRecord){
			$addProcess = addSql($BroadcastDate,$Broadcasterid,$conn,$myArray);	
			exit(json_encode("Record added successfully"));
		}else{
			exit(json_encode("Record exists"));
		}		
	}
}

if (isset($_GET["searchRoster"]) && $_GET["searchRoster"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);	
	if(isset($str)){
		$searchResult = 0;
		$BroadcasterAddFromDate = $str['obj']['BroadcasterAddFromDate'];
		$BroadcasterAddToDate = $str['obj']['BroadcasterAddToDate'];
		$Broadcasterid = $str['obj']['Broadcasterid'];
		$Status = $str['obj']['Status'];
		if($Status == 1){
			$searchResult = searchBroadaster($Broadcasterid,$conn,$myArray);	
			if($searchResult != 0){
				$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcasterId = $Broadcasterid AND b.broadcasterid=$Broadcasterid ORDER BY BroadcastDate desc";
				$result = dbProcess($sql,$conn,$myArray);
				exit(json_encode($result));
			}		
		}
		elseif ($Status == 2){
			$searchResult = searchFromDate($BroadcasterAddFromDate,$conn,$myArray);	
			if($searchResult != 0){
				$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcasterId = b.broadcasterid And a.BroadcastDate >= '$BroadcasterAddFromDate' ORDER BY a.BroadcastDate desc";
				$result = dbProcess($sql,$conn,$myArray);
				exit(json_encode($result));
			}	
		}
		elseif ($Status == 3){
				$searchResult = searchToDate($BroadcasterAddToDate,$conn,$myArray);	
			if($searchResult != 0){
				$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcasterId = b.broadcasterid And a.BroadcastDate <= '$BroadcasterAddToDate' ORDER BY a.BroadcastDate desc";
				$result = dbProcess($sql,$conn,$myArray);
				exit(json_encode($result));
			}	
		}
		elseif ($Status == 4){
				$searchResult = searchBroadasterFromDate($Broadcasterid,$BroadcasterAddFromDate,$conn,$myArray);	
			if($searchResult != 0){
				$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcasterId = $Broadcasterid AND b.BroadcasterId = $Broadcasterid AND a.BroadcastDate >= '$BroadcasterAddFromDate' ORDER BY a.BroadcastDate desc";
				$result = dbProcess($sql,$conn,$myArray);
				exit(json_encode($result));
			}	
		}
		elseif ($Status == 5){
				$searchResult = searchBroadasterToDate($Broadcasterid,$BroadcasterAddToDate,$conn,$myArray);	
			if($searchResult != 0){
				$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcasterId = $Broadcasterid AND b.BroadcasterId = $Broadcasterid AND a.BroadcastDate <= '$BroadcasterAddToDate' ORDER BY a.BroadcastDate desc";
				$result = dbProcess($sql,$conn,$myArray);
				exit(json_encode($result));
			}	
		}
		elseif ($Status == 6){
				$searchResult = searchFromToDate($BroadcasterAddFromDate,$BroadcasterAddToDate,$conn,$myArray);	
			if($searchResult != 0){
				$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcastDate <= '$BroadcasterAddToDate' AND a.BroadcastDate >= '$BroadcasterAddFromDate' AND a.BroadcasterId = b.broadcasterid ORDER BY a.BroadcastDate desc";
				$result = dbProcess($sql,$conn,$myArray);
				exit(json_encode($result));
			}	
		}
		elseif ($Status == 7){
				$searchResult = searchBroadasterFromToDate($Broadcasterid,$BroadcasterAddFromDate,$BroadcasterAddToDate,$conn,$myArray);	
			if($searchResult != 0){
				$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcastDate <= '$BroadcasterAddToDate' AND a.BroadcastDate >= '$BroadcasterAddFromDate' AND a.BroadcasterId = $Broadcasterid AND b.broadcasterid = $Broadcasterid ORDER BY a.BroadcastDate desc";
				$result = dbProcess($sql,$conn,$myArray);
				exit(json_encode($result));
			}	
		}else{
			exit(json_encode(""));
		}
		exit(json_encode(""));
	}
}

function searchBroadasterFromToDate($Broadcasterid,$BroadcasterAddFromDate,$BroadcasterAddToDate,$conn,$myArray){	
			$ctr=0;
			$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcastDate <= '$BroadcasterAddToDate' AND a.BroadcastDate >= '$BroadcasterAddFromDate' AND a.BroadcasterId = $Broadcasterid AND b.broadcasterid = $Broadcasterid ORDER BY a.BroadcastDate;";
			$stmt = $conn->query($sql);
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($data){
				foreach($data as $row)
				{	
					$ctr++;
				}
				return $ctr;
			}else{
				return $ctr;
			}		
			return $ctr;	
}
function searchFromToDate($BroadcasterAddFromDate,$BroadcasterAddToDate,$conn,$myArray){	
			$ctr=0;
			$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcastDate <= '$BroadcasterAddToDate' AND a.BroadcastDate >= '$BroadcasterAddFromDate' AND a.BroadcasterId = b.broadcasterid ORDER BY a.BroadcastDate;";
			$stmt = $conn->query($sql);
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($data){
				foreach($data as $row)
				{	
					$ctr++;
				}
				return $ctr;
			}else{
				return $ctr;
			}		
			return $ctr;	
}
function searchBroadasterToDate($Broadcasterid,$BroadcasterAddToDate,$conn,$myArray){	
			$ctr=0;
			$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcasterId = $Broadcasterid AND b.BroadcasterId = $Broadcasterid AND a.BroadcastDate <= '$BroadcasterAddToDate' ORDER BY a.BroadcastDate;";
			$stmt = $conn->query($sql);
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($data){
				foreach($data as $row)
				{	
					$ctr++;
				}
				return $ctr;
			}else{
				return $ctr;
			}		
			return $ctr;	
}
function searchBroadasterFromDate($Broadcasterid,$BroadcasterAddFromDate,$conn,$myArray){	
			$ctr=0;
			$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcasterId = $Broadcasterid AND b.BroadcasterId = $Broadcasterid AND a.BroadcastDate >= '$BroadcasterAddFromDate' ORDER BY a.BroadcastDate;";
			$stmt = $conn->query($sql);
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($data){
				foreach($data as $row)
				{	
					$ctr++;
				}
				return $ctr;
			}else{
				return $ctr;
			}		
			return $ctr;	
}
function searchToDate($BroadcasterAddToDate,$conn,$myArray){	
			$ctr=0;
			$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcasterId = b.broadcasterid And a.BroadcastDate <= '$BroadcasterAddToDate' ORDER BY a.BroadcastDate;";
			$stmt = $conn->query($sql);
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($data){
				foreach($data as $row)
				{	
					$ctr++;
				}
				return $ctr;
			}else{
				return $ctr;
			}		
			return $ctr;	
}

function searchFromDate($BroadcasterAddFromDate,$conn,$myArray){	
			$ctr=0;
			$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcasterId = b.broadcasterid And a.BroadcastDate >= '$BroadcasterAddFromDate' ORDER BY a.BroadcastDate;";
			$stmt = $conn->query($sql);
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($data){
				foreach($data as $row)
				{	
					$ctr++;
				}
				return $ctr;
			}else{
				return $ctr;
			}		
			return $ctr;	
}

function searchBroadaster($Broadcasterid,$conn,$myArray){	
	$ctr=0;
	$sql = "SELECT a.BroadcastDate,a.BroadcasterId,b.broadcastername FROM broadcastroster AS a JOIN broadcaster AS b WHERE a.BroadcasterId = $Broadcasterid AND b.broadcasterid=$Broadcasterid ORDER BY BroadcastDate";
	$stmt = $conn->query($sql);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if($data){
		foreach($data as $row)
		{	
			$ctr++;
		}
		return $ctr;
	}else{
		return $ctr;
	}		
	return $ctr;	
}

function dbProcess($query, $conn, $myArray){
	try{
		$sql = "$query";
		$stmt = $conn->query($sql);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if($data){
			foreach($data as $row)
			{	
				array_push($myArray, $row);
			}
			return $myArray;
		}			
	}catch(PDOException $e){
		$errorCode = $e->getCode();
			return $errorCode;
	}
}


if (isset($_GET["loadBroadcaster"]) && $_GET["loadBroadcaster"] == "1")
{
	$sql = "select broadcasterid, broadcastername from `broadcaster`";
	$result = dbProcess($sql,$conn,$myArray);
	exit(json_encode($result));
}

function updateSql($newPass,$Broadcasterid,$conn,$myArray){
	$sql = "update broadcaster set password = '$newPass' where broadcasterid = $Broadcasterid";
	$changePassword = dbProcess($sql,$conn,$myArray);	
	return;
} 

function deleteSql($BroadcastDate,$BroadcasterOldId,$conn,$myArray){
	$sql = "delete from broadcastroster where BroadcasterId = $BroadcasterOldId and BroadcastDate = '$BroadcastDate'";
	$deleteRoster = dbProcess($sql,$conn,$myArray);	
	return;
} 

function addSql($BroadcastDate,$Broadcasterid,$conn,$myArray){
	$sql = "insert into broadcastroster (BroadcastDate,BroadcasterId) values('$BroadcastDate',$Broadcasterid);";
	$result = dbProcess($sql,$conn,$myArray);
	return;
}

function chkRecord($BroadcastDate,$Broadcasterid,$conn,$myArray){
	$sql="select count(*) from broadcastroster where BroadcastDate = '$BroadcastDate' and BroadcasterId = $Broadcasterid";
	$result = dbProcess($sql,$conn,$myArray);
    $countRecord = $result[0]['count(*)'];
	return $countRecord;
}
function checkedCurrentPassword($curPass,$Broadcasterid,$conn,$myArray){
	$sql="select count(*) from broadcaster where broadcasterid = $Broadcasterid AND password = '$curPass'";
	$result = dbProcess($sql,$conn,$myArray);
    $countRecord = $result[0]['count(*)'];
	return $countRecord;
}

?>
