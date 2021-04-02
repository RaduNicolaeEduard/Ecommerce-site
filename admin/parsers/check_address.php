<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/tutorial/core/init.php';
    $name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $street = sanitize($_POST['street']);
    $street2 = sanitize($_POST['street2']);
    $city = sanitize($_POST['city']);
    $county = sanitize($_POST['county']);
    $zip_code = sanitize($_POST['zip_code']);
    $country = sanitize($_POST['country']);
    $errors = array();
    $required = array(
        'full_name' => 'Full Name',
        'email' => 'Email',
        'street' => 'Street Address',
        'city' => 'City',
        'county' => 'County',
        'zip_code' => 'Zip Code',
        'country' => 'Country',
    );

    //check if everything is filled out
    foreach($required as $f => $d){
        if (empty($_POST[$f]) || $_POST[$f] == '') {
            $errors[] = $d.' is required';
        }
    }

    //check if mail is ok
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[] = 'Email is not vaild';
    }

    if(!empty($errors)){
        echo display_errors($errors);
    }else{
        echo 'passed';
    }
?>