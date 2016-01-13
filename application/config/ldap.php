<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$ldap['url'] 		= 'ldap://feanofea:389';	//ldap地址
$ldap['user'] 		= 'test';	//查询ldap用户
$ldap['password'] 	= '123456';	//查询ldap用户对应的密码
$ldap['suffix'] 	= '@***.com';	//后缀 一般是企业邮箱后缀 @***.com
$ldap['base_dn'] 	= 'DC=***,DC=com'; //dn