<?php 

require 'config.php';

// verificar variavel email enviado pelo metodo POST do formulario
if (isset($_POST['email']) && !empty($_POST['email'])) {
	// pegar o email
	$email = addslashes($_POST['email']);
	// consultar no banco
	$sql = "SELECT * FROM usuarios WHERE email = :email";
	$sql = $pdo->prepare($sql);
	$sql->bindValue(":email", $email);
	$sql->execute();
	// se encontrou
	if ( $sql->rowCount() > 0) {		
		$sql = $sql->fetch();
		$id_usuario = $sql['id'];

		$token = md5(time().rand(0,9999).rand(0,9999));

		// add no banco usuarios_token
		$sql = "INSERT INTO usuarios_token (id_usuario, hash, expirado_em) VALUES (:id_usuario, :hash, :expirado_em)";
		$sql = $pdo->prepare($sql);
		$sql->bindValue(":id_usuario", $id_usuario);
		$sql->bindValue(":hash", $token);
		$sql->bindValue(":expirado_em", date("Y-m-d H:i:s", strtotime("+2 months")));
		$sql->execute();

		// link para página de redefinição da senha passando o valor do token
		$link = "http://localhost/projeto_esqueciasenha/redefinir.php?token=".$token;

		// mensagem na tela
		$msg = "Clique no link para redefinir sua senha:<br/>".$link;
		
		/*$assunto = "Redefinição de senha";

		$headers = 'From: seuemail@seusite.com.br'."\r\n" .
				   'X-Mailer: PHP/'.phpversion();

		mail($email, $assunto, $mensagem, $headers);*/

		echo $msg;
		exit;

	}
}

?>

<form method="POST">

	E-mail:<br>
	<input type="text" name="email"><br><br>

	<input type="submit" value="Enviar">

</form>