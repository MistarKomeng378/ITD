<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');        
require_once("PHPMailer_v5.1/class.phpmailer.php");

class My_phpmailer extends PHPMailer{
    public function __construct(){
        parent::__construct();
    }
}