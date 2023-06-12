 <?phpheader("Access-Control-Allow-Origin: *"); ?>
<head>
    <meta charset="UTF-8" />
    <meta name="language" content="tr">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
	<title>IYS Figensoft</title>
	<meta name="author" content="https://github.com/redwebcoder" />
	<meta name="copyright" content="Doğukan Ataş" />

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <!-- template styles -->
    <link rel="stylesheet" id="langLtr" href="css/insur.css" />
    
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script type="text/javascript">
			
			
			
			$("#iletisimBilgi").hide();

			function iletisimBilgisi() {
			
			  
			  var adSoyad = $("#adSoyad").val();
			  var eMail = $("#eMail").val();
			  var telefon = $("#telefon").val();
			  var mesaj = $("#mesaj").val();
			
			  // Send the data to the server
			  $.ajax({
			    url: 'iletisimBilgisiGonder',
			    type: 'POST',
			    data: { adSoyad:adSoyad, eMail:eMail, telefon:telefon, mesaj:mesaj },
			    
			    success: function(result) {
			      const text = result;
			      const obj = JSON.parse(text);
			
			      
			    }
			  });
			};
			

			$(document).ready(function() {
	            // Telefon numarası alanını kontrol etmek için input olaylarını dinleyelim
	            $('#telefon').on('input', function() {
	                var telefonNumarasi = $(this).val();
	
	                // Sadece rakamları korumak için regex kullanalım
	                var rakamlar = telefonNumarasi.replace(/\D/g, '');
	
	                // İlk hane 0 ise geri sil
	                if (rakamlar.length > 0 && rakamlar.charAt(0) === '0') {
	                    rakamlar = rakamlar.substr(1);
	                }
	
	                // İlk 10 rakamı alalım
	                rakamlar = rakamlar.substr(0, 10);
	
	                // Güncellenen telefon numarasını alan değerine yazalım
	                $(this).val(rakamlar);
	            });

	            // Gönder butonuna tıklandığında formu kontrol edelim
	            $('#iletisimKayit').on('submit', function(e) {
	                // Mesaj alanı kontrolü
	                var mesaj = $('#mesaj').val();
	                if (mesaj.trim() === '') {
	                    alert('Lütfen bir mesaj girin.');
	                    e.preventDefault();
	                }
	            });
	        });


			
			
			$(function() {
			  $('#dogrulamaFormu').hide();
			});

			$(document).on('submit', '#iletisimKayit', function(e) {
			  e.preventDefault();
			
			  
					
			  
			  var phoneNumber = $("#telefon").val();
			  
			  $.ajax({
			    url: 'StartDoubleOptinGSM',
			    type: 'GET',
                data: { gsmNo: phoneNumber, kvk:'1', etk:'1', sms:'1', eposta:'1' },
                success: function (result) {
	                
			    const text = result;
			    const obj = JSON.parse(text);
			    
			    var results = obj.Results;
			    var StatusCode = obj.StatusCode;
				    
                    
                    
                    if (StatusCode == "100") {
                        $("#iletisimBilgi p").html("Girilen Telefon Numarası Geçersiz");
                        $("#iletisimBilgi").show();
                        return;
                    }
                    if (StatusCode == "400") {
                        $("#iletisimBilgi p").html("Eksik bilgi Var. Lütfen Tüm Alanları Doldurunuz.");
                        $("#iletisimBilgi").show();
                        return;
                    }
                    if (StatusCode != "200") {
                        $("#iletisimBilgi p").html("Doğrulama kodu gönderme işleminiz başarısız, telefon numaranızı kontrol edip lütfen tekrar deneyiniz.");
                        $("#iletisimBilgi").show();
                        return;
                    }
                    
                    if (StatusCode == "200") {
                        $("#iletisimKayit").hide();
						$("#dogrulamaFormu").show();
						
						$("#iletisimBilgi p").html("Doğrulama SMS'i Gönderildi. Lütfen Doğrulama Kodunuzu Giriniz");
						$("#iletisimBilgi").show();
                        return;
                    }
                    
                    
                    
                    
                    
                }
			  });
				  

			});
			
			
			
			$(document).on('submit', '#dogrulamaFormu', function(e) {
			  e.preventDefault();
			
			  
			  var phoneNumber = $("#telefon").val();
			  var dogrulamaKodu = $("#dogrulamaKodu").val();
			  
			  $.ajax({
			    url: 'DoubleOptinCodeVerify',
			    type: 'GET',
			    data: {
				   gsmNo:phoneNumber, doubleOptinCode: dogrulamaKodu
				},
			    success:function(result){
			
			    const text = result;
			    const obj = JSON.parse(text);
			    
			    var StatusCode = obj.StatusCode;
                
                    
                    
                    if (StatusCode == "100") {
                        $("#iletisimBilgi p").html("Girilen Telefon Numarası Geçersiz");
                        $("#iletisimBilgi").show();
                        return;
                    }
                    if (StatusCode == "400") {
                        $("#iletisimBilgi p").html("Eksik bilgi Var. Lütfen Tüm Alanları Doldurunuz.");
                        $("#iletisimBilgi").show();
                        return;
                    }
                    if (StatusCode != "200") {
                        $("#iletisimBilgi p").html("Doğrulama kodu gönderme işleminiz başarısız, doğrulama kodunuzu kontrol edip lütfen tekrar deneyiniz.");
                        $("#iletisimBilgi").show();
                        return;
                    }
                    if (StatusCode == "200") {
	                    
	                    iletisimBilgisi();
	                    goster();
                        
                        return;
                    }
                    
                    
                        
                   
                    
                }
			});
			  
			  
			function goster(){
				
				var adSoyad = $("#adSoyad").val();
				var eMail = $("#eMail").val();	
				var phoneNumber = $("#telefon").val();
				var dogrulamaKodu = $("#dogrulamaKodu").val();
			  
				$.ajax({
			    url: 'PersonAddWithDoubleOptin',
			    type: 'POST',
			    data: { telefon:phoneNumber, dogrulamaKodu: dogrulamaKodu, adSoyad: adSoyad, eMail: eMail},
				success:function(result){
				
					const text = result;
				    const obj = JSON.parse(text);
				    
				    var StatusCode = obj.StatusCode;
                
                    
                    if (StatusCode == "200") {
	                    var durum = "Doğrulama Başarılı. Kaydınız alındı, teşekkür ederiz.";
	                    
                    	$("#dogrulamaFormu").hide();
                    	$("#iletisimBilgi p").html(durum);
						$("#iletisimBilgi").show();
	                }
	            }
				});
				
			}
			  
			  
			  
			  
			  
			  
			  
			  	
			});
			

	</script>
</head>
<body>
        
        <!--Form-->
        <section class="contact-page">
                <div class="row">
                    
                    <div class="col-xl-12 col-lg-12">
                        <div class="contact-page__right">
                            <div class="contact-page__form">
	                            <div class="col-xl-12" id="iletisimBilgi">
                                            
                                    <p></p>
                                            
                                </div>
                                <form id="iletisimKayit" name="iletisimKayit">
                                    <div class="row">
                                        
                                        <div class="col-xl-4">
                                            <div class="comment-form__input-box">
                                                <input type="text" placeholder="Adınız Soyadınız" id="adSoyad" name="adSoyad" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="comment-form__input-box">
                                                <input type="email" placeholder="Email Adresiniz" id="eMail" name="eMail">
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="comment-form__input-box">
                                                <input type="text" placeholder="Telefon Numaranız" id="telefon" name="telefon" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="comment-form__input-box text-message-box">
                                                <textarea id="mesaj" name="mesaj" placeholder="Mesajınız"></textarea>
                                            </div>
                                            <div class="comment-form__input-box">
                                                <input type="checkbox" id="6698" name="6698" required> 6698 sayılı Kişisel Verilerin Korunması Kanunu uyarınca kişisel bilgilerimin sigortacılık faaliyetleri kapsamında işlenmesine izin veriyorum.
                                            </div>
                                            <div class="comment-form__input-box">
												<input type="checkbox" id="6698" name="6698" required> 6563 sayılı Elektronik Ticaretin Düzenlenmesi Hakkında Kanun uyarınca sigortacılık hizmetleri ve kampanyalar hakkında bilgi verilmesine izin veriyorum.
                                            </div>
                                            <div class="comment-form__btn-box">
                                                <button class="thm-btn comment-form__btn">Gönder</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </form>
                                <form id="dogrulamaFormu" name="dogrulamaFormu">
                                    <div class="row">
                                        
                                        <div class="col-xl-6">
                                            <div class="comment-form__input-box">
                                                <input type="text" placeholder="Doğrulama Kodu" id="dogrulamaKodu" name="dogrulamaKodu" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="comment-form__btn-box">
                                                <button class="thm-btn comment-form__btn">Doğrula</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </form>
                                
                            </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Form-->

</body>
</html>