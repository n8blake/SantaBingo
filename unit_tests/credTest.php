<?php

	// credentails test
	require_once '../debugSettings.php';
	require_once '../CredentialsHandler.php';
	require '../../dbinfo/dbcred.php';
	
	echo "<html><body><div style='font-family: monospace;'>";
	echo "Hello World";

	$credHandler = new CredentialsHandler();

	$email = "test@katiedeanshop.com";
	$pw = "Password!2020";

	$data = $credHandler->validate($email, $pw);
	echo "<br>";
	echo var_dump($data);


	echo "<br><br> <strong>new entry</strong> <br><br>";
	$newEmail = "new@katiedeanshop.com";
	$name = "New Person";
	$pass = "simplePass";

	$msg = $credHandler->new($newEmail, $name, $pass);

	echo var_dump($msg);


	echo "<br><br> <strong>try to add duplicate entry</strong> <br><br>";
	$msg = $credHandler->new($newEmail, $name, $pass);

	echo var_dump($msg);

	echo "<br><br> <strong>try to update entry</strong> <br><br>";
	$newPass = 'simplePass2';
	$msg = $credHandler->update($newEmail, $newPass);

	echo var_dump($msg);


	$msg = $credHandler->delete($newEmail); 

	echo "<br><br><strong> delete new entry</strong> <br><br>";
	echo var_dump($msg);

	echo "</div></body></html>";
?>