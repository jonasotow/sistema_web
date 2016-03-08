<?php

/*
 * What protocol to use?
 * mail, sendmail, smtp
 */
$config['protocol'] = 'smtp';

/*
 * SMTP server address and port
 */
$config['smtp_host'] = 'smtp.vimifos.com';
$config['smtp_port'] = '587';

/*
 * SMTP username and password.
 */
$config['smtp_user'] = 'web@vimifos.com';
$config['smtp_pass'] = 'gue6529T';

/*
 * Detailed Information the Mail
 */

//$config['mailpath'] = '/usr/sbin/sendmail';
//$config['wordwrap'] = TRUE;

$config['mailtype'] = 'html';
$config['charset']  = 'utf-8';
$config['validate'] = TRUE;

//$this->email->initialize($config);

/*
 * Heroku Sendgrid information.
 */
/*
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = 587;
$config['smtp_user'] = $_SERVER['SENDGRID_USERNAME'];
$config['smtp_pass'] = $_SERVER['SENDGRID_PASSWORD'];
 */
