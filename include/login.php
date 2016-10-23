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
	// Gestion des sessions
	session_start();
	global $unset;
	if(!empty($_POST['mail']) AND !empty($_POST['pass'])){
		$users = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'users WHERE password="' . sha1($_POST['mail'].$_POST['pass']) . '"');
		if(isset($users[0]->mail) AND $_POST['mail'] == $users[0]->mail){
			$error = 'Authentification réussie !';
			$_SESSION['session_login'] = $_POST['mail'];
			header('Location: index.php');
		}else{
			$error = '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Erreur!</h4>
                    L\'adresse ou le mot de passe précisé est incorrect.
                  </div>';
		}
	}
	if(!isset($_SESSION['session_login']) AND empty($unset)){
		echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Erreur!</h4>
                    Veuillez vous identifier avant d\'accéder à votre espace.
                  </div>';
		header('Location: login.php');
		exit();
	}	
	if(isset($_GET['kill_session']) AND $_GET['kill_session'] == 'true'){
		session_unset();
		session_destroy();
		header('Location: index.php');
		exit();
	}	
	if(!empty($_GET['change_lang'])){
		$_SESSION['lang'] = $_GET['change_lang'];
	}
	if(empty($_SESSION['lang'])){
		$def_lang = $bd->get_option('default_language');
		if(empty($def_lang) OR $def_lang == '1'){$def_lang = 'french';}
		$_SESSION['lang'] = $def_lang;
	}
		include('langs/'.$_SESSION['lang'].'.php');
		global $language;
		$lang = $language[$_SESSION['lang']];
	
?>