<?php
################################################################################
# @Name : /core/mfa.php
# @Description : send mail for mfa
# @Call : ./login.php
# @Parameters : 
# @Author : Flox
# @Create : 28/06/2024
# @Update : 02/09/2024
# @Version : 3.2.52
################################################################################

//get mail for this user
$qry=$db->prepare("SELECT `mail` FROM `tusers` WHERE `id`=:id");
$qry->execute(array('id' => $_SESSION['user_id']));
$row=$qry->fetch();
$qry->closeCursor();

if($row['mail'])
{
    //clean authorization code
    $qry=$db->prepare("DELETE FROM `ttoken` WHERE `user_id`=:user_id AND `action`='mfa_connect' ");
    $qry->execute(array('user_id' => $_SESSION['user_id']));

    //generate authorization code
    $authorization_code=rand(00000,99999);

    //store in token table
    $qry=$db->prepare("INSERT INTO `ttoken` (`date`,`token`,`action`,`user_id`) VALUES (NOW(),:token,'mfa_connect',:user_id)");
    $qry->execute(array('token' => $authorization_code,'user_id' => $_SESSION['user_id']));

    //get token id
    $last_token=$db->lastInsertId();
    
    //mail parameters 
    $from=$rparameters['mail_from_adr'];
    $to=$row['mail'];
    $object=T_("Code d’autorisation accès GestSup").' '.$authorization_code;
    $message=T_('Bonjour').', <br /> <br /> '.T_("Merci d'utiliser le code ci-après pour vous connecter :").'<br /><h1>'.$authorization_code.'</h1>';
    require('core/message.php');

    //reset session cookie
    $_SESSION['login']='';
    $_SESSION['user_id']='';

    //redirect MFA form
    echo '<script language="Javascript">document.location.replace("index.php?page=mfa&token='.$last_token.'");</script>';

} else { //case no user mail
    echo DisplayMessage('error',T_("Vous ne disposez pas d'adresse mail pour l'utilisation de la connexion multifacteur"));
    exit;
}

?>