<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use \PivotSecurity\Account;
use \PivotSecurity\Customer;

	$message = '';
    $name = '';
	$email = '';
	$enquery = '';
	$sessionid = '';
	$code = '';
	$codesent = false;

    if(isset($_POST["email"])) $email = $_POST["email"];
    if(isset($_POST["enquery"])) $enquery = $_POST["enquery"];
	if(isset($_POST["name"])) $name = $_POST["name"];

	if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) ){

		if(isset($_POST["code"])) {
			$code = $_POST["code"];
			if ( verifysessionid($email, $sessionid) ){
				$message = sendmail($name,$email, $enquery);
		  	}else{
		  		$message = "<div style='background-color:red; color:#FFF;'>Sorry only verified email addresses are allowed to send enqueries.</div>";
		  	}
		}else{
			$cu = new Customer('PUBLIC_KEY');
			$response = $cu->createCustomer($email);
			$codesent = true;
			$message = "<div style='background-color:red; color:#FFF;'>Please verify your email.</div>";
		}
	}else{
			error_log("IBAVLAI EMAIL????? ");
	}

function verifysessionid($email,  $sessionid){
	$ac = new Account(null,'<PRIVATE_KEY>');
	$response = $ac->verifySession(null, $email, $sessionid);
	$data =  json_decode($response, true);
	return (strcmp($data['status'], 'Success') == 0);
}
function sendmail($name,$email, $enquery){
			$queries = array();
			parse_str($_SERVER['QUERY_STRING'], $queries);
			$to = 'support@pivotsecurity.com';

			if (count($queries) > 0 && strcmp($queries['q'], 'sales') == 0){
				$to = 'sales@pivotsecurity.com';
			}

			$subject = 'Pivot Security Contact';
			$body = 'Name : '.$name . '    Email: '. $email . ' \n     Enquery:   '. $enquery;

			$mail = new PHPMailer(true);

			try {
				//$mail->SMTPDebug = 4;
				$mail->isSMTP();
				$mail->Host       = 'mailserver';
				$mail->SMTPAuth   = true;
				$mail->Username   = 'User';
				$mail->Password   = 'Password';
				$mail->SMTPSecure = 'tls';
				$mail->Port       = 587;
				$mail->setFrom('From-Address', 'Contact Request');
				$mail->addAddress($to);

				$mail->isHTML(false);
				$mail->Subject = 'Support Request';
				$mail->Body    = preg_replace("/[^A-Za-z0-9 ]/", '', $body) . ' From: '. $email;

				$result = $mail->send();
				$message = "<div style='background-color:green; color:#FFF;'>Thank you for contacting us, We will get back to you as soon as we can.</div> ";
			    $email = '';
			    $enquery = '';
				$name = '';
			} catch (Exception $e) {
				$message = "<div style='background-color:red; color:#FFF;'>Could not send mail, Please try to send mail from your email client.</div>";
			}
	return $message;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pivot Security</title>
<meta name="description" content="Cyber Security as a Service API and AI driven multi-factor authentication" />
<meta name="keywords" content="cyber securuty, 2fa, muti-factor, authentication, authorization, security, sms, email, app" />
<meta name="author" content="Pivot Security" />
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
<link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/nivo-lightbox.css">
<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/default.css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<nav id="menu" class="navbar navbar-default navbar-fixed-top">
  <div class="container"> 
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand page-scroll" href="#page-top">Pivot Security</a> </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
      	<li>
		  <a href="#products" data-toggle="dropdown"  class="menu-link  dropdown-toggle">Products
			  <ul class="dropdown-menu">
				<li><a href="/index.html">2FA Security as a Service</a></li>
				<li><a href="https://personal.pivotsecurity.com/">Personal Cyber Security<br/>(AI powered VPN)</a></li>
				<li class="divider"></li>
				<li><a href="#">Custom AI development</a></li>
			</ul>
		  </a>
		</li>
        <li><a href="/index.html#features" class="page-scroll">Developers</a></li>
        <li><a href="/index.html#about" class="page-scroll">About</a></li>
        <li> <a href="/index.html#pricing" class="menu-link">Pricing</a></li>
        <li><a href="#" class="page-scroll">Contact</a></li>
        <li><a href="https://api.pivotsecurity.com/" class="menu-link btn btn-custom btn-lg">Login
</a></li>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
</nav>

<!-- Contact Section -->
<div id="contact">
  <div class="container">
    <div class="col-md-8">
      <div class="row">
        <div class="section-title">
          <h2>Get In Touch</h2>
          <p>Please fill out the form below to send us an email and we will get back to you as soon as possible.</br>
	  <h4><?php echo $message; ?></h4></p>
        </div>
        <form name="pivotfrm" id="contactForm" action="/contact2.php" method="POST">
          <div class="row">
          <?php if ($codesent){ ?>
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" name="code" class="form-control" placeholder="Code" required="required" value="<?php echo $code;?>" />
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <div class="col-md-6">
            <input type="hidden" name="name" value="<?php echo $name;?>" />
            <input type="hidden" name="email" value="<?php echo $email;?>" />
            <input type="hidden" name="enquery" value="<?php echo $enquery;?>" />    
            </div>
          </div>
		  <?php }else{ ?>          
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name" required="required" value="<?php echo $name;?>" />
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required="required" value="<?php echo $email;?>" />
                <p class="help-block text-danger"></p>
              </div>
            </div>
          </div>
          <div class="form-group">
            <textarea class="form-control animated fadeInUp" rows="4" name="enquery"><?php echo $enquery;?></textarea>
            <p class="help-block text-danger"></p>
          </div>
          <?php } ?>
          <div id="success"></div>
          <button type="submit" class="btn btn-custom btn-lg">Send Message</button>
        </form>
      </div>
    </div>
    <div class="col-md-3 col-md-offset-1 contact-info">
      <div class="contact-item">
        <h3>Contact Info</h3>
        <p><span><i class="fa fa-map-marker"></i> Address</span>Dublin,<br>
          Republic of Ireland</p>
      </div>
      <div class="contact-item">
        <p><span><i class="fa fa-phone"></i> Phone</span> +353 (0) 1 2723641</p>
      </div>
      <div class="contact-item">
        <p><span><i class="fa fa-envelope-o"></i> Email</span> info @ pivotsecurity.com</p>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="social">
          <ul>
            <li><a href="https://twitter.com/pivotsecurityai"><i class="fa fa-twitter"></i></a></li>
            <li><a href="https://www.youtube.com/channel/UC8hJWq8KaGLc2DPhivFP31Q"><i class="fa fa-youtube"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="footer">
  <div class="container text-center">
    <p>&copy; 2019 <a href="https://www.pivotsecurity.com" rel="nofollow">Pivot Security</a></p>
  </div>
</div>
<script type="text/javascript" src="js/jquery.1.11.1.js"></script> 
<script type="text/javascript" src="js/bootstrap.js"></script> 
<script type="text/javascript" src="js/SmoothScroll.js"></script> 
<script type="text/javascript" src="js/nivo-lightbox.js"></script> 
<script type="text/javascript" src="js/jqBootstrapValidation.js"></script> 
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>