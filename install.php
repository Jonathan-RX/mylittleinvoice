<?php
	/*
		This file is part of MyLittleInvoice.

    MyLittleInvoice is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License.

    MyLittleInvoice is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>
		*/
	?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>MyLittleInvoice | Tableau de bord</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if(isset($insert_in_head)){echo $insert_in_head;} ?>
  </head>

<body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="index.php"><b>MyLittle</b>Invoice</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
	  	<?php
	  	if(!empty($_GET['step']) AND $_GET['step'] == '5' AND $_POST['user_pass_1'] == $_POST['user_pass_2']){
		  	$unset = 'true';
		  	include('config.php');
		  	global $bd;
		  	$bd->set_option('money_symbole','€');
		  	$bd->set_option('default_taxs','0');
		  	$bd->set_option('default_invoice_informations','');
		  	$bd->set_option('default_quote_validity','90');
		  	$bd->set_option('default_invoice_term','30');
		  	$bd->set_option('default_invoice_footer','');
		  	$bd->insert($bd->prefix.'users',array('mail'=>$_POST['mail'],'password'=>sha1($_POST['mail'] . $_POST['user_pass_1']),'rank'=>'0','date_add'=>date('d/m/Y')));
		  	$bd->set_option('entreprise_contact',serialize(array('civility'=>'','name'=>'Mon entreprise','namecomplet'=>'','phone'=>'','mobile'=>'','fax'=>'','mail'=>'','website'=>'','divers'=>'','rcs'=>'','taxe'=>'','adressnumber'=>'','adress'=>'','adresscomplet'=>'','postalcode'=>'','city'=>'','country'=>'')));
		  	echo '<p class="login-box-msg">Le logiciel est maintenant configuré, vous pouvez commencer à l\'utiliser dès maintenant.</p>
		  	<a href="login.php" class="btn btn-primary btn-block btn-flat pull-right">Aller à la page d\'identification</a>
				<br style="clear:both;" />';
	  	}elseif((!empty($_GET['step']) AND $_GET['step'] == '4') OR (!empty($_GET['step']) AND $_GET['step'] == '5')){
		  	echo '
		  	<form action="install.php?step=5" method="POST">';
		  	if(isset($_POST['user_pass_1']) AND isset($_POST['user_pass_2']) AND $_POST['user_pass_1'] != $_POST['user_pass_2']){
			  	echo '<p class="login-box-msg">Les mots de passes saisis ne correspondent pas, veuillez recommencer :</p>';
			}else{
			  	echo '<p class="login-box-msg">Pour continuer, il faut quelques informations sur vous :</p>';
			}
		  	echo 'Votre compte :
		  	<div class="form-group has-feedback">
		            <input type="email" class="form-control" name="mail" placeholder="Email"/>
		            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	        	</div>
	        	<div class="form-group has-feedback">
		            <input type="password" class="form-control" name="user_pass_1" placeholder="Mot de passe"/>
		            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
	        	</div>
	        	<div class="form-group has-feedback">
		            <input type="password" class="form-control" name="user_pass_2" placeholder="Confirmer le mot de passe"/>
		            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
	        	</div>
	        	Nom de votre organisation :
	        	<div class="form-group has-feedback">
		            <input type="text" class="form-control" name="entreprise_name" placeholder="Nom"/>
		            <span class="glyphicon glyphicon-tower form-control-feedback"></span>
	        	</div>
	        	<button type="submit" class="btn btn-primary btn-block btn-flat pull-right">Continuer</button>
	        	<br style="clear:both;" />
	        	</form>';
		}elseif(!empty($_GET['step']) AND $_GET['step'] == '3' AND !empty($_POST['host'])){
			include('build/class.bdpoo.php');
			$bd_test = new Bd;
			if(@$bd_test->test_connect($_POST['host'],$_POST['username'],$_POST['userpass'],$_POST['basename'])){
				$bd_test->config($_POST['host'],$_POST['username'],$_POST['userpass'],$_POST['basename'],$_POST['prefix'],'option');
				$prefix = $_POST['prefix'];
				$test = $bd_test->get_results('SHOW TABLES LIKE "' . $prefix . 'customers"');
				if(empty($test)){
					$bd_test->query('CREATE TABLE `' . $prefix . 'customers` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT,`civility` text,`name` text, `namecomplet` text, `adressnumber` text, `adress` text, `adresscomplet` text, `postalcode` text, `city` text, `country` text, `adressdivers` text, `phone` text, `mobile` text, `fax` text, `mail` text, `website` text, `divers` text, `date_add` text, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;');
					$bd_test->query('CREATE TABLE `' . $prefix . 'invoices` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `date` text, `date_end` text, `quote` text, `quote_number` text, `archived` text, `payment` text, `order_number` text, `customer_id` text, `customer` text, `products` text, `infos` text, `footer_infos` text, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;');
					$bd_test->query('CREATE TABLE `' . $prefix . 'options` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `option_name` text, `option_value` text, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;');
					$bd_test->query('CREATE TABLE `' . $prefix . 'payments` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `date` text, `id_invoice` text, `mode` text, `amount` text, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;');
					$bd_test->query('CREATE TABLE `' . $prefix . 'quotes` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `date` text, `date_end` text, `invoice` text,  `invoice_number` text, `archived` text, `display_payment` text, `order_number` text, `customer_id` text, `customer` text, `products` text, `infos` text, `footer_infos` text, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;');
					$bd_test->query('CREATE TABLE `' . $prefix . 'users` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `mail` text, `password` text, `rank` text, `date_add` text, `reset_pass` text, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;');
					echo '<p class="login-box-msg">La connexion à votre base de donnée est opérationnelle, nous pouvons continuer.</p>';
				}
				$config_content = '<?php
	/* Configuration du script */
	$host = \'' . $_POST['host'] . '\';
	$login = \'' . $_POST['username'] . '\';
	$password = \'' . $_POST['userpass'] . '\';
	$basename = \'' . $_POST['basename'] . '\';
	$prefix = \'' . $_POST['prefix'] . '\';
	$option_name = $prefix . \'options\';
	
	include(\'build/class.bdpoo.php\');
	$bd = new Bd;
	$bd->config($host,$login,$password,$basename,$prefix,$option_name);
	
	
	include(\'include/login.php\');
?>';

				if(@$config_file = fopen('config.php', 'w') AND @fwrite($config_file, $config_content)){
					echo '<p class="login-box-msg">Le fichier de configuration a bien été créé.</p>';
				}else{
					echo '<p class="login-box-msg">Une erreur s\'est produite, et le fichier de configuration n\'a pas pu être créé. Vous pouvez modifier les permissions, ou créer manuellement le fichier "config.php" en copiant le contenu ci-dessous : 
				<br /><textarea>' . $config_content . '</textarea>
				</p>';
				}
				echo '<a href="install.php?step=4" class="btn btn-primary btn-block btn-flat pull-right">Continuer</a>
				<br style="clear:both;" />';
			}else{
				?>
			<form action="install.php?step=3" method="POST">
				<p class="login-box-msg">Erreur lors de la connexion, veuillez vérifier vos identifiants : </p>
		        <div class="form-group has-feedback">
		            <input type="text" class="form-control" name="host" placeholder="Hote"/>
		            <span class="glyphicon glyphicon glyphicon-hdd form-control-feedback"></span>
	        	</div>
	        	<div class="form-group has-feedback">
		            <input type="text" class="form-control" name="basename" placeholder="Nom de la base de donnée"/>
		            <span class="glyphicon glyphicon glyphicon-inbox form-control-feedback"></span>
	        	</div>
	        	<div class="form-group has-feedback">
		            <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur"/>
		            <span class="glyphicon glyphicon-user form-control-feedback"></span>
	        	</div>
	        	<div class="form-group has-feedback">
		            <input type="text" class="form-control" name="userpass" placeholder="Mot de passe"/>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	        	</div>
	        	<div class="form-group has-feedback">
		            <input type="text" class="form-control" name="prefix" value="mli_" placeholder="Préfix de la base de donnée (mli_ par défaut)"/>
					<span class="glyphicon glyphicon glyphicon-link form-control-feedback"></span>
	        	</div>
              <button type="submit" class="btn btn-primary btn-block btn-flat pull-right">Continuer</button>
		        <br style="clear:both;" />
			</form>
			<?php
			}
		}elseif(!empty($_GET['step']) AND $_GET['step'] == '2'){
			?>
			<form action="install.php?step=3" method="POST">
				<p class="login-box-msg">Commençons par configurer votre base de donnée : </p>
		        <div class="form-group has-feedback">
		            <input type="text" class="form-control" name="host" placeholder="Hote"/>
		            <span class="glyphicon glyphicon glyphicon-hdd form-control-feedback"></span>
	        	</div>
	        	<div class="form-group has-feedback">
		            <input type="text" class="form-control" name="basename" placeholder="Nom de la base de donnée"/>
		            <span class="glyphicon glyphicon glyphicon-inbox form-control-feedback"></span>
	        	</div>
	        	<div class="form-group has-feedback">
		            <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur"/>
		            <span class="glyphicon glyphicon-user form-control-feedback"></span>
	        	</div>
	        	<div class="form-group has-feedback">
		            <input type="text" class="form-control" name="userpass" placeholder="Mot de passe"/>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	        	</div>
	        	<div class="form-group has-feedback">
		            <input type="text" class="form-control" name="prefix" value="mli_" placeholder="Préfix de la base de donnée (mli_ par défaut)"/>
					<span class="glyphicon glyphicon glyphicon-link form-control-feedback"></span>
	        	</div>
              <button type="submit" class="btn btn-primary btn-block btn-flat pull-right">Continuer</button>
		        <br style="clear:both;" />
			</form>
			<?php
		}else{  	
		?>
		<p class="login-box-msg">Bienvenu dans l'assistant d'installation de MyLittleInvoice!<br /><br /> Pour installer ce logiciel, nous allons commencer par configurer la base de donnée, puis nous entrerons les informations de votre entreprise. </p>
        <a href="install.php?step=2" class="btn-xs btn-success btn pull-right">Continuer</a>
        <br style="clear:both;" />
        <?php 
	        }
	    ?>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="../../plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>