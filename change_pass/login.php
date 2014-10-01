
<?php

	$login = $_POST['login'];
	$pass = $_POST['pass'];

	$ldaprdnauth  = "$RDN";
	
	$ldapconn = ldap_connect("$HOST", $PORT)
            or die("Could not connect to LDAP server.");

	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    	ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

	 if ($ldapconn) {

                $ldapbind = @ldap_bind($ldapconn, $ldaprdnauth, $pass);

                if($ldapbind){
                        session_start();
                        $_SESSION['login'] = $login;
                #echo $_SESSION['login'];
                        header('location:newpass.php');
                }else {
                        echo '<script type="text/javascript">
                        alert("Invalid Credentials");
                        location.href="index.php";
                        </script>';
                        session_destroy();
                        unset ($_SESSION['login']);
                }
        }
?>
