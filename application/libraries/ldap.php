<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_ldap
{

    var $connect;

    function __construct(){
        $this->connect = ldap_connect(LDAP_HOST);
    }

    public function bind($username, $password){
        if ($this->connect) {
            ldap_set_option($this->connect, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($this->connect, LDAP_OPT_REFERRALS, 0);
            $username .= LDAP_EMAIL;
            $bind = @ldap_bind($this->connect, $username, $password);
            ldap_close($this->connect);
            return $bind ? 1 : -2;
        } else {
            return -1;
        }
    }

    // 析构函数
    function __destruct(){
        if ($this->connect) {
            ldap_close($this->connect);
        }
    }
}

