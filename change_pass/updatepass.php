<?php

	session_start();
        if ( !isset($_SESSION['login'])) {
                session_destroy();
                unset ($_SESSION['login']);
                header('location:index.php');
        }


	$newpass = $_POST['newpass'];
        $renewpass = $_POST['renewpass'];
	$oldpass = $_POST['oldpass'];




	$ldaprdnauth  = '$RDN';

        $ldapconn = ldap_connect("$HOST", $LDAP_PORT)
            or die("Could not connect to LDAP server.");

        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

        if ($ldapconn) {

                $ldapbind = @ldap_bind($ldapconn, $ldaprdnauth, $oldpass);

                if($ldapbind){
			
			$flag = 1;
		}else{
			$flag = 0;
		}
	}

#	echo $ldaprdnauth;	
	if ($newpass ==  $renewpass && $newpass!="") {
		
	if($flag==1){
	$ldaprdn  = '$DN_OR_RDN';     // ldap rdn or dn admin
	$ldappass = '$PASSWD';

	$ldapconn = ldap_connect("$HOST", $LDAP_PORT)
            or die("Could not connect to LDAP server.");

    // Set some ldap options for talking to
	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
	
	$ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);

	$filter = "uid=".$_SESSION['login'];
	$ldap_result = ldap_list($ldapconn, "$DN_RDN", $filter);

	$info = ldap_get_entries($ldapconn, $ldap_result);

	if( $info['count'] == 1 ) {

		$userpassword = "{SHA}" . base64_encode( pack( "H*", sha1( $newpass ) ) );
		$userdata = array( "userpassword" => array( 0 => $userpassword ) );

		$result = ldap_mod_replace($ldapconn, $filter.",$DN" , $userdata);

		if ($result){

			session_destroy();
        	        unset ($_SESSION['login']);

			echo '<script type="text/javascript">
                        alert("Success!");
                        location.href="index.php";
                        </script>';

		}else{
			echo '<script type="text/javascript">
                        alert("There was a problem changing your password, please call IT for help");
			 location.href="newpass.php";
                        </script>';
		}
	
	}
	
	}else {

		echo '<script type="text/javascript">
                        alert("Invalid Old Password");
                         location.href="newpass.php";
                        </script>';
	}
	}else{

		echo '<script type="text/javascript">
                        alert("passwords do not match or is Empty!");
                        location.href="newpass.php";
                        </script>';
        }

?>
