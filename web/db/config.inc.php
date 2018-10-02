<?php

/* Servers configuration */
$i = 0;

$cfg['blowfish_secret'] = 'h]C+{nqW$omNoTIkCwC$%z-LTcy%p6_j$|$Wv[mwngi~|e'; //What you want

//Checking Active DBMS Servers
$wampConf = @parse_ini_file('../../wampmanager.conf');
//Check if MySQL and MariaDB with MariaDB on default port
$mariaFirst = ($wampConf['SupportMySQL'] == 'on' && $wampConf['SupportMariaDB'] == 'on' && $wampConf['mariaPortUsed'] == $wampConf['mysqlDefaultPort']) ? true : false;
if($wampConf['SupportMySQL'] == 'on') {
/* Server: localhost [1] */
	$i++;
	if($mariaFirst) $i++;
	$cfg['Servers'][$i]['verbose'] = 'MySQL';
	$cfg['Servers'][$i]['host'] = '127.0.0.1';
	$cfg['Servers'][$i]['port'] = $wampConf['mysqlPortUsed'];
	$cfg['Servers'][$i]['extension'] = 'mysqli';
	$cfg['Servers'][$i]['auth_type'] = 'cookie';
	$cfg['Servers'][$i]['user'] = 'admin';
	$cfg['Servers'][$i]['password'] = 'admin';

	// Hidden databases in PhpMyAdmin left panel
	//$cfg['Servers'][$i]['hide_db'] = '(information_schema|mysql|performance_schema|sys)';

	// Allow connection without password
	$cfg['Servers'][$i]['AllowNoPassword'] = true;
}
/* Server: localhost [2] */
if($wampConf['SupportMariaDB'] =='on') {
	$i++;
	if($mariaFirst) $i -= 2;
	$cfg['Servers'][$i]['verbose'] = 'MariaDB';
	$cfg['Servers'][$i]['host'] = '127.0.0.1';
	$cfg['Servers'][$i]['port'] = $wampConf['mariaPortUsed'];
	$cfg['Servers'][$i]['extension'] = 'mysqli';
	$cfg['Servers'][$i]['auth_type'] = 'cookie';
	$cfg['Servers'][$i]['user'] = 'admin';
	$cfg['Servers'][$i]['password'] = 'admin';

	// Hidden databases in PhpMyAdmin left panel
	//$cfg['Servers'][$i]['hide_db'] = '(information_schema|mysql|performance_schema|sys)';
	// Allow connection without password
	$cfg['Servers'][$i]['AllowNoPassword'] = true;
}

// Suppress Warning about pmadb tables
$cfg['PmaNoRelation_DisableWarning'] = true;

// To have PRIMARY & INDEX in table structure export
$cfg['Export']['sql_drop_table'] = true;
$cfg['Export']['sql_if_not_exists'] = true;

$cfg['MySQLManualBase'] = 'http://dev.mysql.com/doc/refman/5.7/en/';
/* End of servers configuration */

?>
