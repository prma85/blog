#!/usr/bin/env php
<?php
# This file would be say, '/usr/local/bin/run.php'
setlocale(LC_ALL, "en_US.utf8");
date_default_timezone_set('America/Regina');
// code
$url = "https://www.saskatchewan.ca/residents/moving-to-saskatchewan/immigrating-to-saskatchewan/saskatchewan-immigrant-nominee-program/maximum-number-of-sinp-applications";

$html = file_get_contents($url);

$doc = new DOMDocument();
@$doc->loadHTML($html);
@$doc->preserveWhiteSpace = false;
@$doc->normalizeDocument();

$tables = $doc->getElementsByTagName('table');

/*
  $test = '';
  $i = 1;

  while ($test != 'Occupations In-Demand') {
  $table = $tables->item($i);
  $tNodes = $table->childNodes;
  $inDemand = $tNodes[0]->lastChild;
  if (is_object($inDemand)){
  $test = trim($inDemand->firstChild->nodeValue);
  }
  $i++;
  }
 */

//get SINP TABLE
//$table = $tables->item(2);
$table = $tables->item(0);
$tNodes = $table->childNodes;
$inDemand = $tNodes->item(0)->lastChild;
$newPositions = trim($inDemand->childNodes->item(4)->nodeValue);
$total = trim($inDemand->childNodes->item(2)->nodeValue);

//var_dump($inDemand);
//echo get_inner_html($inDemand);
//echo $total;

/*
  if ($newPositions != '0'){
  echo 'novas vagas detectadas, enviando email';
  sendEmail($newPositions, $url, false, $total);
  } else {
  echo 'sem novas vagas';
  sendEmail($newPositions, $url, true, $total);
  }
 */


sendEmail($newPositions, $url, $total);
sendMoney();

//echo get_inner_html($tNodes[0]->lastChild);

function get_inner_html($node) {
    $innerHTML = '';
    $children = $node->childNodes;

    foreach ($children as $child) {
        $innerHTML .= $child->ownerDocument->saveXML($child);
    }

    return $innerHTML;
}

function sendEmail($positions, $url, $total = '0') {
    $subject = '[ALERTA] ' . $positions . ' novas vagas de imigração do SINP';
    $to = 'paulo85br@gmail.com, jhonatanoliveira@gmail.com, alex.vrteixeira@gmail.com';
    $message = 'Existem ' . $positions . ' vagas abertas de ' . $total . '. Verifique na url ' . $url;
    $headers = 'From: contato@cearensesnocanada.com' . "\r\n" .
            'Reply-To: contato@cearensesnocanada.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    //A senha da caixa de email contato@cearensesnocanada.com configurada como 123contato
    if ($positions == '0') {
        echo 'sem novas vagas';
        $to = 'paulo85br@gmail.com';
    }

    $mailsend = mail($to, $subject, $message, $headers);
    echo $mailsend;
}

function sendEmail2($positions, $url) {
    include_once (phpmailer / PHPMailerAutoload . php);

    $mail = new PHPMailer;

    $mail->SMTPDebug = 2;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.uregina.ca';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'martinsp@uregina.ca';                 // SMTP username
    $mail->Password = 'P@ulo0309';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
    $mail->Port = 587;

    $mail->From = 'contato@cearensesnocanada.com';
    $mail->FromName = 'Cearenses no Canada';
    $mail->addAddress('paulo85br@gmail.com', 'Paulo Andrade');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
    //$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = '[ALERTA] ' . $positions . ' novas vagas de imigração do SINP';
    $mail->Body = 'Verifica na url <a href="' . $url . '">SINP WEB SITE</a>';
    $mail->AltBody = 'Verifica na url ' . $url;

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
}

function sendMoney() {
    $response = file_get_contents("http://api.fixer.io/latest?base=CAD&symbols=USD,BRL,EUR,GBP");
    $money = json_decode($response);
    $money->rates->GBP2 = 1 / $money->rates->GBP;
    $money->rates->EUR2 = 1 / $money->rates->EUR;
    $money->rates->USD2 = 1 / $money->rates->USD;

    $buy = array();
    if ($money->rates->EUR2 <= 1.45) {
        $buy[] = 'Comprar euro, preço atual de CAD$' . $money->rates->EUR2;
    }
    if ($money->rates->GBP2 <= 1.6) {
        $buy[] = 'Comprar libra, preço atual de CAD$' . $money->rates->EUR2;
    }
    if ($money->rates->USD2 <= 1.22) {
        $buy[] = 'Comprar dolar, preço atual de CAD$' . $money->rates->USD2;
    }
    if ($money->rates->USD2 >= 1.32) {
        $buy[] = 'Vender dolar, preço atual de CAD$' . $money->rates->USD2;
    }
    if ($money->rates->BRL >= 2.62) {
        $buy[] = 'Comprar real, preço atual de CAD$' . $money->rates->BRL;
    }
    if ($money->rates->BRL <= 2.5) {
        $buy[] = 'Vender real, preço atual de CAD$' . $money->rates->BRL;
    }

    if (!empty($buy)) {
        $subject = '[ALERTA] Comprar dinheiro estrangeiro';
        $to = 'paulo85br@gmail.com';
        $message = implode(', ', $buy);
        $headers = 'From: contato@cearensesnocanada.com' . "\r\n" .
                'Reply-To: contato@cearensesnocanada.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        //A senha da caixa de email contato@cearensesnocanada.com configurada como 123contato
        $mailsend = mail($to, $subject, $message, $headers);
        echo $mailsend;
    }
}
