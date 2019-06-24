<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "profiles";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//read file into lines
$file_lines = file('file.dsv');

//grab header from file_lines array
$header = $file_lines[0];
$columns = explode('|', $header);


$conn->query("SET FOREIGN_KEY_CHECKS=0;");
$conn->query("TRUNCATE TABLE tuser;");
$conn->query("TRUNCATE TABLE tprofile;");
$conn->query("TRUNCATE TABLE ttypes;");


//--------------------------------------------------------------------------------------------------------------------
// - Types

$typeValues = '';

//create assumed types table id structure starting from 1
$typesTableAssumedIDs = [];
$i=0;
$msisdn = 0;

//create types
foreach($columns as $key => $value) {
	$formattedValue = preg_replace('/\s+/', '_', trim($value));
	if(!in_array($value, ['id_number', 'first name', 'last name'])) {
		//type, description, deleted
		$typeValues .= " (LOWER(REPLACE('{$formattedValue}',' ','_')), REPLACE('{$formattedValue}','_',' '), 0),";

		//create assumed types table id structure.
		$i++;
		$typesTableAssumedIDs[$key] = $i;
		if(trim($value) === 'msisdn') {
			$msisdn = $key;
		}
	} else {
		$userTableColumnsIndexes[$formattedValue] = $key; //we know the table structure and unlikely to change.
	}
}

$typeValuesNew = rtrim($typeValues,',');

$users = "INSERT INTO ttypes(type, description, deleted) VALUES ".$typeValuesNew;

if ($conn->query($users) === TRUE) {
    echo "New record(s) created successfully";
} else {
    echo "Error: " . $users . "<br>" . $conn->error;
}

//--------------------------------------------------------------------------------------------------------------------
// - User & Profiles


$userValues = '';
$profileValues = '';

//remove header from file_lines array
array_shift($file_lines) ;

foreach ($file_lines as $key => $line) {
    $data = explode('|', $line);
    //insert into users

    $user = "INSERT INTO tuser (id_number, first_name, last_name) 
	VALUES ('{$data[$userTableColumnsIndexes['id_number']]}', '{$data[$userTableColumnsIndexes['first_name']]}', '{$data[$userTableColumnsIndexes['last_name']]}')";

    if ($conn->query($user) === TRUE) {
	    echo "<p>New record(s) created successfully";

	    $lastInsertId = $conn->insert_id;

	    //user profiles types  - tUSER_id | tTYPES_id | value
	    $profileValues = "";
	    foreach ($data as $datakey => $datavalue) {
	    	if(!in_array($datakey, $userTableColumnsIndexes)) {
	    		//make sure msisdn is same format
				if($datakey === $msisdn) {
					$formattedMsisdn = '0'.substr( preg_replace('/[^0-9]/', '', trim($datavalue)), -9);
					$datavalue = $formattedMsisdn;
				}
				$datavalue = trim($datavalue);
	    		$profileValues .= "('{$lastInsertId}', '{$typesTableAssumedIDs[$datakey]}', '{$datavalue}'),";
	    	}
	    }
	    $profileValuesNew = rtrim($profileValues,',');
	    
	    $profiles = "INSERT INTO tprofile(tUSER_id, tTYPES_id, value) VALUES ".$profileValuesNew;   

	    if ($conn->query($profiles) === TRUE) {
		    echo "<p>New record(s) created successfully";
		} else {
		    echo "<p>Error: " . $profiles . "<br>" . $conn->error;
		} 
	} else {
	    echo "<p>Error: " . $user . "<br>" . $conn->error;
	}
}
$conn->close();
echo '<p>';
die('done');