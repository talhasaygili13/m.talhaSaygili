<?php
$sayfa="İletişim";
include "inc/db.php";
include 'inc/head.php';
session_start();
?>
		<!-- Contact-->
		<section class="page-section" id="contact">
			<div class="container">
				<div class="text-center">
					<h2 class="section-heading text-uppercase mt-3">İletişim</h2>
					<h3 class="section-subheading text-muted">Benimle iletişime geçmek için bu alanı kullanabilirsiniz</h3>
				</div>
				<form id="contactForm" name="sentMessage" method="post" action="iletisim">
					<div class="row align-items-stretch mb-5">
						<div class="col-md-6">
							<div class="form-group">
								<input class="form-control" id="name" name="ad" type="text" placeholder="İsminiz *" required="required" data-validation-required-message="Please enter your name." />
								<p class="help-block text-danger"></p>
							</div>
							<div class="form-group">
								<input class="form-control" id="email" name="mail" type="email" placeholder="Email *" required="required" data-validation-required-message="Please enter your email address." />
								<p class="help-block text-danger"></p>
							</div>
							<div class="form-group mb-md-0">
								<img src="inc/captcha.php" alt="">
								<input type="text"class="form-control" placeholder="Güvenlik kodunu giriniz *" name="captcha" required="required">

							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group form-group-textarea mb-md-0">
								<textarea class="form-control" id="message" name="mesaj" placeholder="Mesajınız *" required="required" data-validation-required-message="Please enter a message."></textarea>
								<p class="help-block text-danger"></p>
							</div>
						</div>
					</div>
					<div class="text-center">
						<div id="success"></div>
						<button class="btn btn-primary btn-xl text-uppercase" id="sendMessageButton" type="submit">Mesajı Gönder</button>
					</div>
				</form>
				<script type="text/javascript" src="js/sweetalert2.all.min.js"> ></script>
				<?php
				if($_POST){
					if ($_SESSION['captcha'] == $_POST['captcha']) {

						$sorgu=$baglanti->prepare("INSERT INTO iletisimformu SET ad=:ad, mail=:mail, mesaj=:mesaj");
						$ekle=$sorgu->execute(
						[
							'ad'=>htmlspecialchars($_POST["ad"]),
							'mail'=>htmlspecialchars($_POST["mail"]),
							'mesaj'=>htmlspecialchars($_POST["mesaj"]),
						]

					);

						if($ekle){
							// function mailgonder(){
							// 	require "inc/class.phpmailer.php"; // PHPMailer dosyamızı çağırıyoruz
							// 	$mail = new PHPMailer();
							// 	$mail->IsSMTP();
							// 	$mail->From     = "talhasaygili67@gmail.com"; //Gönderen kısmında yer alacak e-mail adresi
							// 	$mail->Sender   = $_POST["mail"];
							// 	$mail->FromName = $_POST["ad"];
							// 	$mail->Host     = "talhasaygili67@gmail.com"; //SMTP server adresi
							// 	$mail->SMTPAuth = true;
							// 	$mail->Username = "talhasaygili13@gmail.com"; //SMTP kullanıcı adı
							// 	$mail->Password = "*****"; //SMTP şifre
							// 	$mail->SMTPSecure="";
							// 	$mail->Port = "587";
							// 	$mail->CharSet = "utf-8";
							// 	$mail->WordWrap = 50;
							// 	$mail->IsHTML(true); //Mailin HTML formatında hazırlanacağını bildiriyoruz.
							// 	$mail->Subject  = "Konu";
							// 	$mail->Body = "mesaj";
							// 	$mail->AltBody = strip_tags("mesaj");
							// 	$mail->AddAddress("deneme@mesutd.com");
							// 	return ($mail->Send())?true:false;
							// 	$mail->ClearAddresses();
							// 	$mail->ClearAttachments();
							// }

							// if(mailgonder()) echo "başarılı";
							// else echo "olmadı";

							echo "<script> Swal.fire({title:'Tebrikler',text:'Mesajınız Başarıyla İletildi' ,icon:'success',confirmButtonText:'Kapat'})  </script>";
						}
					}
					else {
						echo "<script> Swal.fire({title:'Hata',text:'Mesajınızı iletirken bir sorun oluştu',icon:'error',confirmButtonText:'Kapat'})  </script>";
					}
				}
				?>


			</div>
		</section>
		<!--Footer-->
<?php
include 'inc/footer.php';
?>
