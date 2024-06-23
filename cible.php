<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  function post_captcha($user_response) {
      $fields_string = '';
      $fields = array(
          'secret' => '6LdKKWUUAAAAAHAPvnQ9MbnFXl-Ow2wOwT3KIGa0',
          'response' => $user_response
      );
      foreach($fields as $key=>$value)
      $fields_string .= $key . '=' . $value . '&';
      $fields_string = rtrim($fields_string, '&');

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
      curl_setopt($ch, CURLOPT_POST, count($fields));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

      $result = curl_exec($ch);
      curl_close($ch);

      return json_decode($result, true);
  }
  // Call the function post_captcha
  $res = post_captcha($_POST['g-recaptcha-response']);

  if (!$res['success']) {
      // What happens when the CAPTCHA wasn't checked
      echo '<p>      Veuillez revenir en arrière et assurez-vous de cocher la case de sécurité CAPTCHA.</p><br>';
  } else {
      // If CAPTCHA is successfully completed...

	function securisation($data){
		$data=trim($data);
        $data=stripslashes($data);
		$data=strip_tags($data);
		return $data;
	}	
      $name = securisation($_POST['name']);
      $email = securisation($_POST['email']);
      $objet = securisation($_POST['objet']);
      $message = securisation($_POST['message']); 	        

$formcontent=" De : $name \n Sté : $objet \n Message: $message";
        $recipient = "reseau@tizwezo.com";
        $subject = "Contact de Ti zwezo";
        $mailheader = "From: $email \r\n";
        mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
        $tableau_pour_json = ['nom'=>$name, 'société'=>$objet,'email'=>$email,'message'=>$message];
        
        $contenu_json =json_encode($tableau_pour_json);
        
        // Nom du fichier à créer
        $nom_du_fichier = 'fichier.json';
        
        // Ouverture du fichier
        $fichier = fopen($nom_du_fichier, 'a+');
        
        // Ecriture dans le fichier
        fwrite($fichier, $contenu_json);
        
        // Fermeture du fichier
        fclose($fichier);
  }
}
		echo ("<center><font color=grey><h2>Votre message a bien été envoyé</h2></font><br /><center><font color=grey><h2>Merci d'avoir pris le temps de remplir le formulaire de contact !</h2></font><br /><a href=/>Retour sur le site</a></center>");
sleep(5);
?>
<meta http-equiv="refresh" content="2; url=index.html">