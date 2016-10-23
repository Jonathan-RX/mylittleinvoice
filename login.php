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
	$unset = 'true';
	include('include/head.php');
	global $lang;
	?>
<body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="index.php"><b>MyLittle</b>Invoice</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <?php 
	        if(!empty($_GET['reset_pass']) AND !empty($_POST['pass_1']) AND !empty($_POST['pass_2']) AND $_POST['pass_1'] == $_POST['pass_2']){
		        $result = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'users WHERE reset_pass="' . sha1($_GET['reset_pass']) . '"');		
		        if(!empty($result[0]->mail)){
			        $bd->update($bd->prefix . 'users',array('password'=>sha1($result[0]->mail.$_POST['pass_1']),'reset_pass'=>''),array('mail'=>$result[0]->mail)); 
			        echo '<p class="login-box-msg">Votre mot de passe a bien été réinitialisé, vous pouvez vous connecter.<br /><a href="login.php">Retour à la page de login</a></p>';
		        }
		       
	        }elseif(!empty($_GET['reset_pass'])){
		        $result = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'users WHERE reset_pass="' . sha1($_GET['reset_pass']) . '"');		
		        if(!empty($result[0]->mail)){
			        ?>
			        <p class="login-box-msg"><?php echo $lang['change_password']; ?></p>
			        <form action="login.php?reset_pass=<?php echo $_GET['reset_pass']; ?>" method="post">
				        <div class="form-group has-feedback">
				            <input type="password" class="form-control" name="pass_1" placeholder="Mot de passe"/>
				            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
				          </div> 
				          <div class="form-group has-feedback">
				            <input type="password" class="form-control" name="pass_2" placeholder="Retapez le mot de passe"/>
				            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
				          </div>			            <div class="col-xs-4">
			              <button type="submit" class="btn btn-primary btn-block btn-flat">Envoyer</button>
			            </div><!-- /.col -->
					<br /><br />
			          </div>
			        </form>
			        <?php
		        }else{
			        header('Location: index.php');
			        exit();
		        }     
		    }elseif(!empty($_GET['ask_mail']) AND !empty($_POST['mail'])){
		        $mail = addslashes($_POST['mail']);
				$user = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'users WHERE mail="' . $mail . '"');
				if(!empty($user[0]->id)){
					$rand = sha1(rand(0,9999));
					$bd->update($bd->prefix . 'users', array('reset_pass'=>sha1($rand)), array('id'=>$user[0]->id));
					$text = 'Un utilisateur tente de remettre à zéro votre mot de passe pour se connecter sur le site MyLittleInvoice http://'.$_SERVER['HTTP_HOST'] . '.
					<br /><br />
					Si vous êtes à l\'origine de cette demande, veuillez cliquer sur le lien ci-dessous ou le copier dans un navigateur pour remettre votre mot de passe à zéro :
					<br />
					<a href="http://' . $_SERVER['HTTP_HOST'] . '/login.php?reset_pass=' . $rand . '">http://' . $_SERVER['HTTP_HOST'] . '/login.php?reset_pass=' . $rand . '</a><br /><br />Sinon, ne tenez pas compte de ce message. Si vous avez un doute sur la sécurité de votre compte, vous pouvez modifier le mot de passe dans les options de MyLittleInvoice.';
					$sujet = 'Tentative de remise à zéro de votre mot de passe MyLittleInvoice';
					$headers = "From: \"MyLittleInvoice\"<contact@mylittleinvoice.com>\n";
					$headers .= "Reply-To: contact@mylittleinvoice.com\n";
					$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
					if(mail($user[0]->mail,$sujet,$text,$headers)){echo $lang['mail_success'];}else{echo 'Erreur lors de l\'envoi du mail. Veuillez contacter un administrateur.';}
				}
		        ?>
		        <p class="login-box-msg"><?php echo $lang['forget_pass_success']; ?></p>
          
          
		<br>

		        <?php
		    }elseif(!empty($_GET['ask_mail'])){
		    ?>
		    <p class="login-box-msg"><?php echo $lang['forget_pass_title']; ?></p>
        <form action="login.php?ask_mail=true" method="post">
	       <div class="form-group has-feedback">
            <input type="email" class="form-control" name="mail" placeholder="Email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo $lang['send']; ?></button>
            </div><!-- /.col -->
          </div>
        </form>
		<br>
		    <?php    
		    }else{
		?>
		<p class="login-box-msg"><?php echo $lang['login_title']; ?></p>
        <form action="login.php" method="post">
	        <?php 
		       global $error;
		       if(!empty($error)){echo $error;}
	        ?>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name="mail" placeholder="Email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="pass" placeholder="Mot de passe"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo $lang['send']; ?></button>
            </div><!-- /.col -->
          </div>
        </form>

        <a href="login.php?ask_mail=true"><?php echo $lang['forget_password']; ?></a><br>
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