<?php
	# Variaveis Globais
	$host = "localhost";
	$username = "root";
	$password = "";
	$dbc = mysqli_connect($host, $username, $password);
	# Salvar tipo de requerimento...
	$tipo_de_requerimento = $_POST['req_type'];
	# Salvar Nome do Banco de dados
	$name = $_POST['name'];
	$name = preg_replace('/[^a-z0-9]/i', '_', $name);
	# Requerimento: SALVE
	if ( $tipo_de_requerimento == "save" )
	{
		$status = $_POST['status'];
		$inv_etc = $_POST['inv_etc'];
		$inv_eqp = $_POST['inv_eqp'];
		$inv_eqpc = $_POST['inv_eqpc'];
		$inv_usb = $_POST['inv_usb'];
		$arm_etc = $_POST['arm_etc'];
		$arm_eqp = $_POST['arm_eqp'];
		$arm_usb = $_POST['arm_usb'];
		# Verificar existencia do bando de dados...
		if ( $dbc )
		{
			$dbs = mysqli_select_db($dbc, $name);
			if ( !$dbs )
			{
				$cdb = "CREATE DATABASE " .$name;
				if ( mysqli_query($dbc, $cdb))
				{
					if ( mysqli_select_db($dbc, $name))
					{
						$sql_tabela = "CREATE TABLE status ( char_status VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela )) {} # Tabela Status Criada
						$sql_insert = "INSERT INTO status ( char_status ) VALUES ( '$status' )";
						if ( mysqli_query($dbc, $sql_insert )) {} # Dado 0 Inserido
						
						$sql_tabela = "CREATE TABLE inv_usb ( usb_list VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela)) {} # Tabela Inventario Usaveis Criada
						$sql_insert = "INSERT INTO inv_usb ( usb_list ) VALUES ( '$inv_usb' )";
						if ( mysqli_query($dbc, $sql_insert )) {} # Dado 0 Inserido
						
						$sql_tabela = "CREATE TABLE inv_etc ( etc_list VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela)) {} # Tabela Inventario ETC Criada
						$sql_insert = "INSERT INTO inv_etc ( etc_list ) VALUES ( '$inv_etc' )";
						if ( mysqli_query($dbc, $sql_insert )) {} # Dado 0 Inserido
						
						$sql_tabela = "CREATE TABLE inv_eqpc ( eqpc_list VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela)) {} # Tabela Inventario Equipados Criada
						$sql_insert = "INSERT INTO inv_eqpc ( eqpc_list ) VALUES ( '$inv_eqpc' )";
						if ( mysqli_query($dbc, $sql_insert )) {} # Dado 0 Inserido
						
						$sql_tabela = "CREATE TABLE inv_eqp ( eqp_list VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela)) {} # Tabela Inventario Equipamentos Criada
						$sql_insert = "INSERT INTO inv_eqp ( eqp_list ) VALUES ( '$inv_eqp' )";
						if ( mysqli_query($dbc, $sql_insert )) {} # Dado 0 Inserido
						
						$sql_tabela = "CREATE TABLE arm_usb ( usb_arm VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela)) {} # Tabela Armazem Usaveis Criada
						$sql_insert = "INSERT INTO arm_usb ( usb_arm ) VALUES ( '$arm_usb' )";
						if ( mysqli_query($dbc, $sql_insert )) {} # Dado 0 Inserido
						
						$sql_tabela = "CREATE TABLE arm_eqp ( eqp_arm VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela)) {} # Tabela Armazem Equipamentos Criada
						$sql_insert = "INSERT INTO arm_eqp ( eqp_arm ) VALUES ( '$arm_eqp' )";
						if ( mysqli_query($dbc, $sql_insert )) {} # Dado 0 Inserido
						
						$sql_tabela = "CREATE TABLE arm_etc ( etc_arm VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela)) {} # Tabela Armazem ETC Criada
						$sql_insert = "INSERT INTO arm_etc ( etc_arm ) VALUES ( '$arm_etc' )";
						if ( mysqli_query($dbc, $sql_insert )) {} # Dado 0 Inserido
						
						$sql_tabela = "CREATE TABLE console_command ( command_console VARCHAR(1000));";
						if ( mysqli_query($dbc, $sql_tabela)) {} # Tabela de Comandos de Console Criada
						$sql_insert = "INSERT INTO console_command ( command_console ) VALUES ( 'console_command_executado' )";
						if ( mysqli_query($dbc, $sql_insert )) {} # Dado 0 Inserido
					}
				}
			}
			else
			{
				if ( mysqli_select_db($dbc, $name))
				{
					# SALVAR DADOS
					$saveData = "UPDATE status SET char_status = '$status'";
					if (mysqli_query($dbc, $saveData)) {} # Status Atualizado
					$saveData = "UPDATE inv_usb SET usb_list = '$inv_usb'";
					if (mysqli_query($dbc, $saveData)) {} # Inventario Usaveis Atualizado
					$saveData = "UPDATE inv_etc SET etc_list = '$inv_etc'";
					if (mysqli_query($dbc, $saveData)) {} # Inventario ETC Atualizado
					$saveData = "UPDATE inv_eqp SET eqp_list = '$inv_eqp'";
					if (mysqli_query($dbc, $saveData)) {} # Inventario Equipamentos Atualizado
					$saveData = "UPDATE inv_eqpc SET eqpc_list = '$inv_eqpc'";
					if (mysqli_query($dbc, $saveData)) {} # Inventario Equipados Atualizado
					$saveData = "UPDATE arm_usb SET usb_arm = '$arm_usb'";
					if (mysqli_query($dbc, $saveData)) {} # Armazem Usaveis Atualizado
					$saveData = "UPDATE arm_etc SET etc_arm = '$arm_etc'";
					if (mysqli_query($dbc, $saveData)) {} # Armazem ETC Atualizado
					$saveData = "UPDATE arm_eqp SET eqp_arm = '$arm_eqp'";
					if (mysqli_query($dbc, $saveData)) {} # Armazem Equipamentos Atualizado
					
					// Enviar Comando do Console
					$query = "SELECT * FROM console_command";
					$result = mysqli_query($dbc, $query);
					$console_command = "";
					while ($row = mysqli_fetch_row($result)) $console_command = $row[0];
					if ( $console_command != "console_command_executado" )
					{
						echo $console_command;
						$done = "console_command_executado";
						$console_command = "UPDATE console_command SET command_console = '$done'";
						if (mysqli_query($dbc, $console_command)) {} # Console Command Apagago
					}
				}
			}
		}
	}
	# Requerimento: EXTRAIR
	else if ( $tipo_de_requerimento == "extract" )
	{
		if ( $dbc )
		{
			$dbs = mysqli_select_db($dbc, $name);
			if ( $dbs )
			{
				$query = "SELECT * FROM status";
				$result = mysqli_query($dbc, $query);
				$status = "";
				while ($row = mysqli_fetch_row($result)) $status = $row[0];
				echo $status;
			}
		}
	}
	# Requerimento: PEGA BOT
	else if ( $tipo_de_requerimento == "pegabot" )
	{
		if ( $dbc )
		{
			$dbcall = "SHOW DATABASES";
			$dblist = mysqli_query($dbc, $dbcall);
			$botnames = "";
			while ($row = mysqli_fetch_row($dblist))
			{
				if (($row[0] != "information_schema") && ($row[0] != "mysql") && ($row[0] != "performance_schema") && ($row[0] != "phpmyadmin")) 
				{
					$botnames = $botnames . $row[0] . "/";
				}
			}
			echo $botnames;
		}
	}
	else if ( $tipo_de_requerimento == "extract_inv" )
	{
		if ( $dbc )
		{
			if ( mysqli_select_db($dbc, $name) )
			{
				$query = "SELECT * FROM inv_etc";
				$result = mysqli_query($dbc, $query);
				$list_etc = "";
				while ($row = mysqli_fetch_row($result)) $list_etc = $row[0];
				$query = "SELECT * FROM inv_usb";
				$result = mysqli_query($dbc, $query);
				$list_usb = "";
				while ($row = mysqli_fetch_row($result)) $list_usb = $row[0];
				$query = "SELECT * FROM inv_eqp";
				$result = mysqli_query($dbc, $query);
				$list_eqp = "";
				while ($row = mysqli_fetch_row($result)) $list_eqp = $row[0];
				$query = "SELECT * FROM inv_eqpc";
				$result = mysqli_query($dbc, $query);
				$list_eqpc = "";
				while ($row = mysqli_fetch_row($result)) $list_eqpc = $row[0];
				$query = "SELECT * FROM arm_etc";
				$result = mysqli_query($dbc, $query);
				$list_etc_arm = "";
				while ($row = mysqli_fetch_row($result)) $list_etc_arm = $row[0];
				$query = "SELECT * FROM arm_usb";
				$result = mysqli_query($dbc, $query);
				$list_usb_arm = "";
				while ($row = mysqli_fetch_row($result)) $list_usb_arm = $row[0];
				$query = "SELECT * FROM arm_eqp";
				$result = mysqli_query($dbc, $query);
				$list_eqp_arm = "";
				while ($row = mysqli_fetch_row($result)) $list_eqp_arm = $row[0];
				echo $list_usb_arm . "<" . $list_etc_arm . "<" . $list_eqp_arm . "<" . $list_usb . "<" . $list_etc . "<" . $list_eqp . "<" . $list_eqpc;
			}
		}
	}
	else if ( $tipo_de_requerimento == "save_command" )
	{
		$console_command = $_POST['console_command'];
		if ( $dbc )
		{
			if (mysqli_select_db($dbc, $name))
			{
				$saveData = "UPDATE command_console SET console_command = '$console_command'";
				if (mysqli_query($dbc, $saveData)) {} # Comando de Console inserido
			}
		}
	}
	else if ( $tipo_de_requerimento == "resetDatabase" )
	{
		print "Reset Database\n";
		if ( $dbc )
		{
			print "Connected\n";
			$dbcall = "SHOW DATABASES";
			$dblist = mysqli_query($dbc, $dbcall);
			while ($row = mysqli_fetch_row($dblist))
			{
				"Looping\n";
				if (($row[0] != "information_schema") && ($row[0] != "mysql") && ($row[0] != "performance_schema") && ($row[0] != "phpmyadmin")) 
				{
					print "Deletando $row[0]\n";
					$deleteData = "DROP DATABASE $row[0]";
					if ( mysqli_query($dbc, $deleteData )) {} # Data bases apagados
				}
			}
		}
	}
	mysqli_close($dbc);
?>