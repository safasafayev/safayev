<?php

/**
 * configure here
 */
$from = 'IT WORKER <it@domain.com>';
$sendTo = 'safa1193@gmail.com';
$subject = '����� ��������� �� ���������� �����';
$fields = array('name' => 'Name', 'surname' => 'Surname', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message');
$htmlHeader = '';
$htmlFooter = '';
$okMessage = '���������� ����� ������� ����������. �������, � ������� � ��� � ��������� �����!';

$htmlContent = '<h1>����� ��������� �� ���������� �����</h1>';

/* DO NOT EDIT BELOW */

/* use classes */

use Nette\Mail\Message,
    Nette\Mail\SendmailMailer;

/* require framework */

require 'php/Nette/nette.phar';

/* configure neccessary */

$configurator = new Nette\Configurator;
$configurator->setTempDirectory(__DIR__ . '/php/temp');
$container = $configurator->createContainer();

/* get post */

$httpRequest = $container->getService('httpRequest');
$httpResponse = $container->getService('httpResponse');

$post = $httpRequest->getPost();

if ($httpRequest->isAjax()) {
    /* compose htmlContent */

    $htmlContent .= '<table>';
    foreach ($post as $key => $value) {

	if (isset($fields[$key])) {
	    $htmlContent .= "<tr><th>$fields[$key]</th><td>$value</td></tr>";
	}
    }
    $htmlContent .= '</table>';

    /* compose html body */

    $htmlBody = $htmlHeader . $htmlContent . $htmlFooter;

    /* send email */

    $mail = new Message;
    $mail->setFrom($from)
	    ->addTo($sendTo)
	    ->setSubject($subject)
	    ->setHtmlBody($htmlBody, FALSE);

    $mailer = new SendmailMailer;
    $mailer->send($mail);


    $responseArray = array('type' => 'success', 'message' => $okMessage);

    $httpResponse->setCode(200);
    $response = new \Nette\Application\Responses\JsonResponse($responseArray);
    $response->send($httpRequest, $httpResponse);
}




