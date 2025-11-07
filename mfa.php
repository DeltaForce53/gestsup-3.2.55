<?php
################################################################################
# @Name : ./forgot_pwd.php 
# @Description : send mail to user to init password
# @Call : /login.php
# @Author : Flox
# @Version : 3.2.48
# @Create : 25/10/2019
# @Update : 20/02/2024
################################################################################

//initialize variable
if(!isset($_GET['token'])) $_GET['token'] = '';
if(!isset($_POST['authorization_code'])) $_POST['authorization_code'] = '';
if(!isset($msg_error)) $msg_error = '';

//secure string
$_GET['token']=htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8');
$_POST['authorization_code']=htmlspecialchars($_POST['authorization_code'], ENT_QUOTES, 'UTF-8');

if($rparameters['user_mfa'] && $_GET['token'])
{
    //check $authorization_code'
    if($_POST['authorization_code'])
    {
        //get authorization code
        $qry=$db->prepare("SELECT `token`,`user_id` FROM `ttoken` WHERE `id`=:id");
        $qry->execute(array('id' => $_GET['token']));
        $token=$qry->fetch();
        $qry->closeCursor();

        if($token['token']==$_POST['authorization_code'])
        {
            //redirect to auth_token
            echo '<script language="Javascript">document.location.replace("./index.php?auth_token='.$token['token'].'");</script>';

        }else {
            $msg_error=T_("Code d'autorisation erroné");
        }
    }
    


	//display background
	if($rparameters['login_background'])
	{
		echo '<div class="body-container" style=" background:url(upload/login_background/'.$rparameters['login_background'].') no-repeat fixed center;" >	';
	} else {
		echo '<div class="body-container" style=" background-image: linear-gradient(#6baace, #264783); background-attachment: fixed; background-repeat: no-repeat;" >';
	}

	echo '
			<div class="main-container container bgc-transparent">
				<div role="main" class="main-content ">
					<div class="justify-content-center pb-2">
                        ';
                        if($msg_error){echo DisplayMessage('error',$msg_error);}
                        echo'
						<div class="d-flex flex-column align-items-center justify-content-start">
							<h1 class="mt-5">
								<a style="text-decoration: none;"  target="_blank" href="https://gestsup.fr">
									<img title="'.T_('Ouvre un nouvel onglet vers le site gestsup.fr').'" width="45" src="images/logo_gestsup_white.svg" />
								</a>
								<span class="text-90 text-white">GestSup</span>
							</h1>
						</div>
						<div class="d-flex flex-column align-items-center justify-content-start">
							
							<h5 class="text-white">
								';if(isset($rparameters['company'])) echo $rparameters['company']; echo' 
							</h5>
						</div>
						<div class="d-flex flex-column align-items-center justify-content-start">
							';
							if($rparameters['logo'] && file_exists("./upload/logo/$rparameters[logo]"))
							{
								$size=getimagesize('./upload/logo/'.$rparameters['logo']);
								if($size[0]>150) {$logo_width='width="150"';} else {$logo_width='';}
								echo '<img style="border-style: none" alt="logo" '.$logo_width.' src="./upload/logo/'.$rparameters['logo'].'" />';
							} else {
								echo '<span style="font-size: 3em; color: white;"><i class="fa fa-dice-d6"><!----></i></span>';
							}
							echo '
						</div>
					</div>
					<div class="p-4 p-md-4 mh-2 ">
						<div class="row justify-content-center ">
							<div class="shadow radius-1 overflow-hidden bg-white col-12 col-lg-4 ">
								<div class="row ">
									<a href="index.php" title="'.T_('Retour').'" class="btn btn-light-default bg-transparent ml-3 mt-3"><i class="fa fa-arrow-left"> '.T_('Retour').'</i></a>
									<div class="col-12 bgc-white px-0 pt-4 pb-4">
										<div class="" data-swipe="center">
											<div class="active show px-3 px-lg-0 pb-0" id="id-tab-login">
												<div class="d-lg-block col-md-8 offset-md-2 px-0 pb-4">
													<h4 class="text-dark-tp4 border-b-1 brc-grey-l1 pb-1 text-130">
														<i class="fa fa-key text-brown-m2 mr-1"><!----></i>
														'.T_('Connexion multi-facteur').'
													</h4>
												</div>
                                                <form id="conn" method="post" action="">	
                                                    <div class="form-group col-md-8 offset-md-2 mb-6">
                                                        <div class="d-flex align-items-center input-floating-label text-blue-m1 brc-blue-m2 ">
                                                            <input autocomplete="off" type="input" class="form-control form-control-lg pr-4 shadow-none" id="authorization_code" name="authorization_code" autocomplete="off" value="" />
                                                            <i class="fa fa-key text-grey-m2 ml-n4"><!----></i>
                                                            <label class="floating-label text-grey-l1 text-100 ml-n3" for="mail">'.T_("Code d’autorisation").'</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 offset-md-3 mt-4">
                                                        <button type="submit" id="submit" name="submit" value="submit" class="btn btn-orange btn-block px-4 btn-bold mt-2 mb-4">
                                                            <i class="fa fa-check"><!----></i>
                                                            '.T_('Valider').'
                                                        </button>
                                                    </div>
                                                </form>
											</div>
										</div><!-- .tab-content -->
									</div>
								</div>
							 </div>
						</div>
					</div>
				</div><!-- /main -->
			</div><!-- /.main-container -->
		</div><!-- /.body-container -->
	
		<!-- DO NOT DELETE OR MODIFY THIS LINE THANKS -->
			<span style="position: fixed; bottom: 0px; right: 0px;"><a title="'.T_('Ouvre un nouvel onglet vers le site gestsup.fr').'" target="_blank" href="https://gestsup.fr">GestSup.fr</a></span>
		<!-- DO NOT DELETE OR MODIFY THIS LINE THANKS -->
	';
} else {
	echo DisplayMessage('error',T_("La fonction MFA est désactivée par votre administrateur"));
}
?>