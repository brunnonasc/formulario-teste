<!DOCTYPE html>
<html lang="pt-br">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <title>Enviar e-mail com anexo</title>
</head>
<body>
<form id="form1" name="form1" method="post" action="?acao=enviar" enctype="multipart/form-data">
   <table width="500" border="0" align="center" cellpadding="0" cellspacing="2">
   <tr>
     <td align="right">Nome:</td>
     <td><input type="text" name="nome" id="nome" /></td>
   </tr>
   <tr>
     <td align="right">Assunto:</td>
     <td><input type="text" name="assunto" id="assunto" /></td>
   </tr>
   <tr>
     <td align="right">Mensagem:</td>
     <td><textarea name="mensagem" id="mensagem" cols="45" rows="5"></textarea></td>
   </tr>
   <tr>
     <td align="right">Anexo:</td>
     <td><input type="file" id="arquivo" name="arquivo" /></td>
   </tr>
   <tr>
     <td colspan="2" align="center"><input type="submit" value="Enviar" /></td>
   </tr>
   </table>
</form>

<?php
require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';

$mailer = new PHPMailer;

//$mailer->SMTPDebug = 2; // Enable verbose debug output

$mailer->isSMTP(); // Set mailer to use SMTP

$mailer->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);


if($_GET['acao'] == 'enviar'){
$nome          = $_POST['nome'];
$assunto   = $_POST['assunto'];
$mensagem  = $_POST['mensagem'];
$arquivo   = $_FILES["arquivo"];

$mailer->Host = 'mail.dominio.com.br';	// Servidor smtp
// Para cPanel: 'mail.dominio.com.br' ou 'localhost';
// Para Plesk 7 / 8 : 'smtp.dominio.com.br';
// Para Plesk 11 / 12.5: 'smtp.dominio.com.br' OU 'mail.dominio' OU host do servidor exemplo : 'pleskXXXX.hospedagemdesites.ws';

$mailer->SMTPAuth = true;     // Habilita a autenticação do form
$mailer->IsSMTP();
$mailer->isHTML(true);       // Formato do email HTML
$mailer->Port = 587;	     // Porta de conexão

// Ativar condição utf-8, para acentuação
$mailer->CharSet = 'UTF-8';

$mailer->Username = 'teste@dominio.com.br'; // Conta de email que realizara o envio
$mailer->Password = '@Locaweb1020';	// Senha da conta
$address = "teste@dominio.com.br";	// email do destinatario

//$mailer->SMTPDebug = 1;
$corpoMSG = "<strong>Nome:</strong> $nome<br> <strong>Mensagem:</strong> $mensagem";

$mailer->AddAddress($address, "teste@dominio.com.br"); // email do destinatario
$mailer->AddAddress("revendalw@gmail.com", "destinatario 2"); // 2º destinatário se querer enviar, se não, comente com //
$mailer->From = 'teste@dominio.com.br';		// Obrigatório ser a mesma caixa postal indicada em "Username"
$mailer->Sender = 'teste@dominio.com.br';
$mailer->FromName = "Teste LW";		// Seu nome
$mailer->Subject = $assunto;	// assunto da mensagem
$mailer->MsgHTML($corpoMSG);	// corpo da mensagem
$mailer->AddAttachment($arquivo['tmp_name'], $arquivo['name']  );	// anexar arquivo

if(!$mailer->Send()) {
   echo "Erro: " . $mailer->ErrorInfo;
  } else {
   echo "Mensagem enviada com sucesso!";
  }
}


?>
</body>
</html>