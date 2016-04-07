<!DOCTYPE html>
<html lang="de">
<head>
	<title><?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="icon/icon.ico" rel="shortcut icon" type="image/x-icon" />	
	<link type="text/css" rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css "/>
	<link type="text/css" rel="stylesheet" href="css/sbts.css" />
	<?php 
	
	/**
	 * Displays the extra header
	 *
	 * @example $header = 1;
	 * @param {String} $header
	 * @return {void} Nothing
	 */
	function showHeader($header)
	{
		/**
		 * $header "normal" for all normal pages
		 * $header "login" for all pages which have something to do with the login or the authorisation
		 */
		if ($header === "normal")
		{
			echo '<link type="text/css" rel="stylesheet" href="css/fileinput.min.css" media="all" />';
			echo '<link type="text/css" rel="stylesheet" href="css/bootstrap-datetimepicker.css" />';
			echo '<script type="text/javascript" src="js/moment.js"></script>';
			echo '<script type="text/javascript" src="js/moment-with-locales.js"></script>';
			echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.js"></script>';
			echo '<script type="text/javascript" src="js/fileinput.min.js"></script>';
			echo '<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.js"></script>';
			echo '<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>';
		}
		elseif ($header === "login")
		{
			echo '<link type="text/css" rel="stylesheet" href="css/login.css" />';
			echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.js"></script>';
			echo '<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.js"></script>';
		}
	};
	showHeader($header);?>
</head>
<body>