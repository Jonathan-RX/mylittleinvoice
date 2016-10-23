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

include('config.php');
global $lang;

// Liste des devis
if(!empty($_GET['get_quote'])){
	if($_GET['get_quote'] == 'current'){
		$where = 'WHERE archived="false"';
	}elseif($_GET['get_quote'] == 'archived'){
		$where = 'WHERE archived="true"';
	}else{
		$where = '';
	}
	if(!empty($_GET['search_where']) AND !empty($_GET['search_what']) AND !empty($where)){
		$where .= ' AND ' . $_GET['search_where'] . ' LIKE "%' . $_GET['search_what'] . '%"';
	}elseif(!empty($_GET['search_where']) AND !empty($_GET['search_what'])){
		$where = 'WHERE ' . $_GET['search_where'] . ' LIKE "%' . $_GET['search_what'] . '%"';
	}
	$results = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'quotes ' . $where);
	if(isset($results[0]->id)){
		foreach($results as $r){
            $customer = unserialize($r->customer);
            $total = 0;
            $taxes = 0;
            foreach(unserialize($r->products) as $p){
                $total += $p['qty']*$p['price'];
                $taxes += $p['qty']*($p['price']*$p['taxes']/100);
            }
            $t = $total + $taxes;
           echo '
		   <tr id="' . $r->id . '">
            <td onclick="selection(' . $r->id . ');">' . $r->id . '</td>
            <td onclick="selection(' . $r->id . ');">' . $customer[0] . '</td>
            <td onclick="selection(' . $r->id . ');">' . $r->date . '</td>
	                        <td onclick="selection(' . $r->id . ');" class="smart_hidden"';
							if(strtotime(str_replace('/', '-', $r->date_end)) < strtotime(date('Y-m-d'))){echo ' style="color:red;"';}
	                        echo '>' . $r->date_end . '</td><td>';
	                        if($r->archived == 'true'){echo '<i class="fa fa-archive"></i>';}
	                        echo '
	                       </td><td>';
	                       if($r->invoice == 'true'){echo '<a href="edit-invoice.php?id_invoice=' . $r->invoice_number . '"><i class="fa fa-file-text"></i> ' . $r->invoice_number . '</a>';}
	                       echo '</td>
            <td onclick="selection(' . $r->id . ');">' . $t . $bd->get_option('money_symbole') . '</td>
          </tr>
		'; 
        }

	}
}
// Liste des Factures
if(!empty($_GET['get_invoice'])){
	if($_GET['get_invoice'] == 'current'){
		$where = 'WHERE archived="false"';
	}elseif($_GET['get_invoice'] == 'archived'){
		$where = 'WHERE archived="true"';
	}else{
		$where = '';
	}
	if(!empty($_GET['search_where']) AND !empty($_GET['search_what']) AND !empty($where)){
		$where .= ' AND ' . $_GET['search_where'] . ' LIKE "%' . $_GET['search_what'] . '%"';
	}elseif(!empty($_GET['search_where']) AND !empty($_GET['search_what'])){
		$where = 'WHERE ' . $_GET['search_where'] . ' LIKE "%' . $_GET['search_what'] . '%"';
	}
	$results = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'invoices ' . $where);
	if(isset($results[0]->id)){
		foreach($results as $r){
            $customer = unserialize($r->customer);
            $total = 0;
            $taxes = 0;
            foreach(unserialize($r->products) as $p){
                $total += $p['qty']*$p['price'];
                $taxes += $p['qty']*($p['price']*$p['taxes']/100);
            }
            $t = $total + $taxes;
           echo '
		   <tr id="' . $r->id . '">
            <td onclick="selection(' . $r->id . ');">' . $r->id . '</td>
            <td onclick="selection(' . $r->id . ');">' . $customer[0] . '</td>
            <td onclick="selection(' . $r->id . ');" class="date">' . $r->date . '</td>
	                        <td onclick="selection(' . $r->id . ');" class="smart_hidden"';
							if(strtotime(str_replace('/', '-', $r->date_end)) < strtotime(date('Y-m-d'))){echo ' style="color:red;"';}
	                        echo '>' . $r->date_end . '</td><td>';
	                        if($r->archived == 'true'){echo '<i class="fa fa-archive"></i>';}
	                        echo '
	                       </td><td class="amount"><a href="#" onclick="list_payments(' . $r->id . ');return false;">'; 
	                       $solde = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'payments WHERE id_invoice="' . $r->id . '" ');
	                       $solde_total = 0;
	                       foreach($solde as $s){$solde_total += $s->amount;}
	                       echo $t - $solde_total . $bd->get_option('money_symbole');
	                       echo '</td>
            <td onclick="selection(' . $r->id . ');">' . $t . $bd->get_option('money_symbole') . '</td>
          </tr>
		'; 
        }

	}
}
// Liste des clients
if(!empty($_GET['get_customers_list'])){
	if(!empty($_GET['search_what']) AND !empty($_GET['search_where'])){
		$where = ' WHERE ' . $_GET['search_where'] . ' LIKE "%' .$_GET['search_what'] . '%"';
	}else{$where = '';}
	$results = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'customers' . $where);
		              if(isset($results[0]->id)){
	                    foreach($results as $r){
		                   echo '
						   <tr id="' . $r->id . '">
	                        <td onclick="selection(' . $r->id . ');">' . $r->id . '</td>
	                        <td onclick="selection(' . $r->id . ');">' . $r->name . '</td>
	                        <td onclick="selection(' . $r->id . ');">' . $r->phone . ', ' . $r->mobile . '</td>
	                        <td onclick="selection(' . $r->id . ');"><a href="mailto:' . $r->mail . '">' . $r->mail . '</a></td>
	                        <td onclick="selection(' . $r->id . ');">' . $r->city . '</td>
	                      </tr>
                      '; 
	                    }
	                    

						}
}
// Enregistrement d'un encaissement
if(!empty($_GET['submit_payment']) AND !empty($_GET['id']) AND !empty($_GET['date']) AND !empty($_GET['mode']) AND !empty($_GET['amount'])){
	$bd->insert($bd->prefix . 'payments', array('id_invoice'=>$_GET['id'],'date'=>$_GET['date'],'mode'=>$_GET['mode'],'amount'=>$_GET['amount']));
}
// Retour des infos d'un client pour l'édition de documents
if(!empty($_GET['get_customers_infos'])){
	$results = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'customers where id="' . $_GET['get_customers_infos'] . '"');
	$results = $results[0];
	$customer = array($results->name,$results->adressnumber . ' ' . $results->adress,$results->adresscomplet,$results->postalcode . ' ' . $results->city,$results->phone,$results->mail);
	foreach($customer as $c){
		if($c != ''){echo '<span class="editable line customer_infos">' . $c . '</span><br />';}
	}
}
// Liste les encaissements
if(!empty($_GET['list_payment']) AND !empty($_GET['id'])){
	$payments = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'payments WHERE id_invoice="' . $_GET['id'] . '" ');
	foreach($payments as $p){
		echo '<tr><td>' . $p->date . '</td><td>';
		switch ($p->mode) {
			case 'species':
				echo $lang['species'];
				break;
			case 'check':
				echo $lang['check'];
				break;
			case 'transfer':
				echo $lang['transfer'];
				break;
			case 'paypal':
				echo $lang['paypal'];
				break;
			case 'creditcard':
				echo $lang['credit_card'];
				break;
			case 'mandate':
				echo $lang['money_order'];
				break;
		}
		echo '</td><td>' . $p->amount . $bd->get_option('money_symbole') . '</td></tr>';
	}
}
// Lecture d'un encaissement
if(!empty($_GET['load_payment'])){
	$p = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'payments WHERE id="' . $_GET['id'] . '" ');
	$p = $p[0];
	?><h4><?php echo $lang['edit_payment']; ?></h4>
			<table>
				<tr>
					<th><?php echo $lang['invoice_nbr']; ?> :</th>
					<td><input type="text" name="id_invoice" class="form-control payment_id" value="<?php echo $p->id_invoice; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang['payment_date']; ?> :</th>
					<td><input type="text" name="date" class="form-control payment_date"  value="<?php echo $p->date; ?>" /></td>
				</tr>
				<tr>
					<th><?php echo $lang['payment_mode']; ?> :</th>
					<td>
						<select name="mode" class="payment_mode">
							<option value="species" <?php if($p->mode == 'species'){echo 'selected';} ?>><?php echo $lang['species']; ?></option>
							<option value="check" <?php if($p->mode == 'check'){echo 'selected';} ?>><?php echo $lang['check']; ?></option>
							<option value="transfer" <?php if($p->mode == 'transfer'){echo 'selected';} ?>><?php echo $lang['transfer']; ?></option>
							<option value="paypal" <?php if($p->mode == 'paypal'){echo 'selected';} ?>><?php echo $lang['paypal']; ?></option>
							<option value="creditcard" <?php if($p->mode == 'creditcard'){echo 'selected';} ?>><?php echo $lang['credit_card']; ?></option>
							<option value="mandate" <?php if($p->mode == 'mandate'){echo 'selected';} ?>><?php echo $lang['money_order']; ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php echo $lang['amount']; ?> :</th>
					<td><input type="text" name="amount" class="form-control payment_amount"  value="<?php echo $p->amount; ?>" /></td>
				</tr>
			</table>
			<input type="hidden" name="id" value="<?php echo $p->id; ?>" />
			<a href="#" class="btn btn-success btn-xs" style="float:right;margin-top:5px;" onclick="valid_edit();"><?php echo $lang['validate']; ?></a>
			<a href="#" class="btn btn-default btn-xs" onclick="jQuery('.payment_box').fadeOut();"><?php echo $lang['cancel']; ?></a>
			<?php
}
// Modification d'un encaissement
if(!empty($_GET['edit_payment'])){
	$bd->update($bd->prefix . 'payments',array('id_invoice'=>$_GET['id_invoice'],'date'=>$_GET['date'],'mode'=>$_GET['mode'],'amount'=>$_GET['amount']), array('id'=>$_GET['id']));
}
// Liste des encaissements
if(!empty($_GET['refresh_payment'])){
	$where = '';
	if(!empty($_GET['search_where']) AND !empty($_GET['search_what'])){$where .= ' WHERE ' . $_GET['search_where'] . ' LIKE "%' . $_GET['search_what'] . '%"';}
	$results = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'payments' . $where);
	 foreach($results as $r){
		                   echo '
						   <tr id="' . $r->id . '">
	                        <td onclick="selection(' . $r->id . ');">' . $r->id . '</td>
	                        <td onclick="selection(' . $r->id . ');" class="date">' . $r->date . '</td>
	                        <td onclick="selection(' . $r->id . ');">' . $r->id_invoice . '</td>
	                        <td class="mode">'; 
	                       // Calcul du solde
	                       switch ($r->mode) {
							case 'species':
								echo $lang['species'];
								break;
							case 'check':
								echo $lang['check'];
								break;
							case 'transfer':
								echo $lang['transfer'];
								break;
							case 'paypal':
								echo $lang['paypal'];
								break;
							case 'creditcard':
								echo $lang['credit_card'];
								break;
							case 'mandate':
								echo $lang['money_order'];
								break;
							}
	                       echo '</td><td onclick="selection(' . $r->id . ');">' . $r->amount . $bd->get_option('money_symbole') . '</td>
	                      </tr>'; 
	                    }
}
// Modification d'un utilisateur dans la page des option
if(!empty($_GET['edit_user']) AND !empty($_GET['id'])){
	$user = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'users WHERE id="' . $_GET['id'] . '"');
	$user = $user[0];
	echo '
	 <tr><th>' . $lang['users_mail'] . ' :</th><td><input type="text" name="edit_mail" placeholder="' . $lang['users_mail'] . '" value="' . $user->mail . '" /></td></tr>
	 <tr><th>' . $lang['user_password'] . ' :</th><td><input type="password" name="edit_password" placeholder="' . $lang['user_password'] . '" /></td></tr>
	 <tr><th>' . $lang['users_rank'] . ' :</th><td><input type="text" name="edit_rank" placeholder="' . $lang['users_rank'] . '" value="' . $user->rank . '" /></td></tr>
	 <input type="hidden" name="id_user" value="' . $user->id . '" />
	 <input type="hidden" name="edit_user" value="true"

	';
}
?>