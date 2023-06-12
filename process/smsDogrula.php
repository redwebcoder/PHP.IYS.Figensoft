 <?php
	 header("Access-Control-Allow-Origin: *");
	 
	 $gsmNo = $_GET['gsmNo'];
	 $doubleOptinCode = $_GET['doubleOptinCode'];
	 echo file_get_contents("https://lb.figensoft.com/api/izinli-paz/ElektronikIzin/v3/DoubleOptinCodeVerify/{API_KEY}?gsmNo=".$gsmNo."&doubleOptinCode=".$doubleOptinCode."");
	 
	 

?>