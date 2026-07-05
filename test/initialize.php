<?php
define("TEST",true);

require(__DIR__ . "/../vendor/autoload.php");

define("ATK14_NON_SSL_PORT",80);

$HTTP_REQUEST = new HTTPRequest();
$ATK14_GLOBAL = Atk14Global::GetInstance();

class ApplicationForm extends Atk14Form {
}
