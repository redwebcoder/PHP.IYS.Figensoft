 <?php
	 header("Access-Control-Allow-Origin: *");
	 
	 $personID = rand(0000000,9999999);
	 $adSoyad = $_POST["adSoyad"];
	 $telefon = $_POST["telefon"];
	 $eMail = $_POST["eMail"];
	 $dogrulamaKodu = $_POST["dogrulamaKodu"];
	 
	 $tarih = date("d.m.Y H:i:s");

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://lb.figensoft.com/api/izinli-paz/ElektronikIzin/v3/PersonAddWithDoubleOptin/{API_KEY}',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "Reason": "X platformu üzerinden yeni üyelik işlemi ile izin alındı.",
    "VerificationGsmNo": "'.$telefon.'",
    "VerificationCode": '.$dogrulamaKodu.',
    "MustAddMasterAccount": "0",
    "EvidenceData": "a2FuxLF0IGnDp2VyacSfaQ==",
    "EvidenceDataExtension": "txt",
    "Person": {
        "PersonId": "'.$personID.'",
        "NameSurname": "'.$adSoyad.'",
        "KVK": {
            "InformationGsm": "'.$telefon.'",
            "Permissions": [
                {
                    "PermissionCode": "KVK.AYDINLATMA.VERSION.1.00",
                    "PermissionType": "AYDINLATMA",
                    "PermissionText": "Aydınlatma metnini okudum, anladım.",
                    "PermissionTime": "'.$tarih.'"
                },
                {
                    "PermissionCode": "KVK.GENEL.VERSION.1.07",
                    "PermissionType": "GENEL",
                    "PermissionText": "6698 sayılı Kişisel Verilerin Korunması Kanunu uyarınca kişisel bilgilerimin sigortacılık faaliyetleri kapsamında işlenmesine izin veriyorum.",
                    "PermissionTime": "'.$tarih.'"
                }
            ]
        },
        "ETK": {
            "Permissions": [
                {
                    "PermissionCode": "ETK.GENEL.VERSION.1.03",
                    "PermissionText": "6563 sayılı Elektronik Ticaretin Düzenlenmesi Hakkında Kanun uyarınca sigortacılık hizmetleri ve kampanyalar hakkında bilgi verilmesine izin veriyorum.",
                    "Contacts": [
                        {
                            "PermissionChannel": "SMS",
                            "ReceiverType": "GSM",
                            "Receiver": "'.$telefon.'",
                            "PermissionTime": "'.$tarih.'"
                        },
                        {
                            "PermissionChannel": "EPOSTA",
                            "ReceiverType": "EPOSTA",
                            "Receiver": "'.$eMail.'",
                            "InformationGsm": "'.$telefon.'",
                            "PermissionTime": "'.$tarih.'"
                        }
                    ]
                },
                {
                    "PermissionCode": "ETK.EPOSTA.VERSION.1.08",
                    "PermissionText": "Tarafıma ticari elektronik izin gönderilmesine onayım vardır.",
                    "Contacts": [
                        {
                            "PermissionChannel": "EPOSTA",
                            "ReceiverType": "EPOSTA",
                            "Receiver": "'.$eMail.'",
                            "InformationGsm": "'.$telefon.'",
                            "PermissionTime": "'.$tarih.'"
                        }
                    ]
                }
            ]
        }
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: ARRAffinity=49797720cd17fb6307366dd708941afd378e74b1e4aa8fd1b5ac280e14d8495a'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
?>