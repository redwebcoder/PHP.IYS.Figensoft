 <?php
	 header("Access-Control-Allow-Origin: *");
	 
	 $gsmNo = $_GET['gsmNo'];
	 echo file_get_contents("https://lb.figensoft.com/api/izinli-paz/ElektronikIzin/v3/StartDoubleOptinGSM/{API_KEY}?gsmNo=".$gsmNo."");
?>