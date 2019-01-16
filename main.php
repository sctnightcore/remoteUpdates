<?php
	# Salvar tipo de requerimento...
	$tipo_de_requerimento = $_POST['req_type'];
	# Requerimento: SALVE
	if ( $tipo_de_requerimento == "save" )
	{
		$name = $_POST['name'];
		$name = preg_replace('/[^a-z0-9]/i', '_', $name);
		$blvl = $_POST['blvl'];
		$clvl = $_POST['clvl'];
		$bxp = $_POST['bxp'];
		$bxpnl = $_POST['bxpnl'];
		$cxp = $_POST['cxp'];
		$cxpnl = $_POST['cxpnl'];
		$hp = $_POST['hp'];
		$mhp = $_POST['mhp'];
		$sp = $_POST['sp'];
		$msp = $_POST['msp'];
		$curw = $_POST['curw'];
		$maxw = $_POST['maxw'];
		$zeny = $_POST['zeny'];
		$map = $_POST['map'];
		$xcoord = $_POST['xcoord'];
		$ycoord = $_POST['ycoord'];
		$str = $_POST['str'];
		$str_b = $_POST['str_b'];
		$agi = $_POST['agi'];
		$agi_b = $_POST['agi_b'];
		$vit = $_POST['vit'];
		$vit_b = $_POST['vit_b'];
		$dex = $_POST['dex'];
		$dex_b = $_POST['dex_b'];
		$intl = $_POST['int'];
		$intl_b = $_POST['int_b'];
		$luk = $_POST['luk'];
		$luk_b = $_POST['luk_b'];
		$atk = $_POST['atk'];
		$atk_b = $_POST['atk_b'];
		$matk_min = $_POST['matk_min'];
		$matk_max = $_POST['matk_max'];
		$hit = $_POST['hit'];
		$crit = $_POST['crit'];
		$def = $_POST['def'];
		$def_b = $_POST['def_b'];
		$mdef = $_POST['mdef'];
		$mdef_b = $_POST['mdef_b'];
		$eva = $_POST['eva'];
		$eva_b = $_POST['eva_b'];
		$atkspd = $_POST['atkspd'];
		# Verificar existencia do bando de dados...
		$dbc = mysqli_connect("localhost", "root", "");
		if ( !$dbc )
		{
			
		}
		else
		{
			$dbs = mysqli_select_db($dbc, $name);
			if ( !$dbs )
			{
				$cdb = "CREATE DATABASE " .$name;
				if ( mysqli_query($dbc, $cdb))
				{
					#print "DATABASE CRIADO $name";
					# Criar Tabela
					$sql_tabela = "CREATE TABLE status(name VARCHAR(50),
												 blvl VARCHAR(5),
												 clvl VARCHAR(5),
												 bxp VARCHAR(100),
												 bxpnl VARCHAR(100),
												 cxp VARCHAR(100),
												 cxpnl VARCHAR(100),
												 hp VARCHAR(10),
												 mhp VARCHAR(10),
												 sp VARCHAR(10),
												 msp VARCHAR(10),
												 curw VARCHAR(10),
												 maxw VARCHAR(10),
												 zeny VARCHAR(15),
												 map VARCHAR(50),
												 xcoord VARCHAR(5),
												 ycoord VARCHAR(5),
												 str VARCHAR(5),
												 str_b VARCHAR(5),
												 agi VARCHAR(5),
												 agi_b VARCHAR(5),
												 vit VARCHAR(5),
												 vit_b VARCHAR(5),
												 dex VARCHAR(5),
												 dex_b VARCHAR(5),
												 intl VARCHAR(5),
												 intl_b VARCHAR(5),
												 luk VARCHAR(5),
												 luk_b VARCHAR(5),
												 atk VARCHAR(5),
												 atk_b VARCHAR(5),
												 matk_min VARCHAR(5),
												 matk_max VARCHAR(5),
												 hit VARCHAR(5),
												 crit VARCHAR(5),
												 def VARCHAR(5),
												 def_b VARCHAR(5),
												 mdef VARCHAR(5),
												 mdef_b VARCHAR(5),
												 eva VARCHAR(5),
												 eva_b VARCHAR(5),
												 atkspd VARCHAR(5));";
					mysqli_select_db($dbc, $name);
					if (mysqli_query($dbc, $sql_tabela))
					{
						# Tabela criada de BOAS!!!
						$inserir_dados = "INSERT INTO status(name, blvl, clvl, bxp, bxpnl, cxp, cxpnl, hp, mhp, sp, msp, curw, maxw, zeny, map, xcoord, ycoord, str, str_b, agi, agi_b, vit, vit_b, dex, dex_b, intl, intl_b, luk, luk_b, atk, atk_b, matk_min, matk_max, hit, crit, def, def_b, mdef, mdef_b, eva, eva_b, atkspd )
										VALUES('$name','$blvl','$clvl','$bxp','$bxpnl','$cxp','$cxpnl','$hp','$mhp','$sp','$msp','$curw','$maxw','$zeny','$map','$xcoord','$ycoord','$str','$str_b','$agi','$agi_b','$vit','$vit_b','$dex','$dex_b','$intl', '$intl_b','$luk','$luk_b','$atk','$atk_b','$matk_min','$matk_max','$hit','$crit','$def','$def_b','$mdef','$mdef_b','$eva','$eva_b','$atkspd')";
						if (mysqli_query($dbc, $inserir_dados))
						{
							#print "dados inseridos na tabela de boas";
						}
						else
						{
							#print "Deu ruim na criação da tabela";
						}
						# Criar tabela de usaveis
						$sql_tabela = "CREATE TABLE inv_usb ( usb_list VARCHAR(60000));";
						mysqli_select_db($dbc, $name);
						if ( mysqli_query($dbc, $sql_tabela))
						{
							# Tabela de Usaveis criada de boas
						}
						# Criar tabela de etc
						$sql_tabela = "CREATE TABLE inv_etc ( etc_list VARCHAR(60000));";
						mysqli_select_db($dbc, $name);
						if ( mysqli_query($dbc, $sql_tabela))
						{
							# Tabela de ETC criada de boas
						}
						# Criar tabela de equipes equipados
						$sql_tabela = "CREATE TABLE inv_eqpc ( eqpc_list VARCHAR(60000));";
						mysqli_select_db($dbc, $name);
						if ( mysqli_query($dbc, $sql_tabela))
						{
							# Tabela de EQUIPADOS criada de boas
						}
						# Criar tabela de equipes
						$sql_tabela = "CREATE TABLE inv_eqp ( eqp_list VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela))
						{
							# Tabela de EQUIPS criada de boas
						}
						# Criar tabela de usaveis armazem
						$sql_tabela = "CREATE TABLE arm_usb ( usb_arm VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela))
						{
							# Tabela de Usaveis Armazem criada de boas
						}
						# Criar tabela de equipes armazem
						$sql_tabela = "CREATE TABLE arm_eqp ( eqp_arm VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela))
						{
							# Tabela de Equips Armazem criada de boas
						}
						# Criar tabela de etc armazem
						$sql_tabela = "CREATE TABLE arm_etc ( etc_arm VARCHAR(60000));";
						if ( mysqli_query($dbc, $sql_tabela))
						{
							# Tabela de Etc Armazem criada de boas
						}
						# Criar tabela de comandos do console
						$sql_tabela = "CREATE TABLE console_command ( command_console VARCHAR(1000));";
						if ( mysqli_query($dbc, $sql_tabela))
						{
							# Tabela de Comands Criada de boas
						}
					}
					else
					{
						#print "Deu ruim na tabela";
					}
				}
				else
				{
					#print "Deu ruim na criação do DB!";
				}
			}
			else
			{
				$inserir_dados = "INSERT INTO status(name, blvl, clvl, bxp, bxpnl, cxp, cxpnl, hp, mhp, sp, msp, curw, maxw, zeny, map, xcoord, ycoord, str, str_b, agi, agi_b, vit, vit_b, dex, dex_b, intl, intl_b, luk, luk_b, atk, atk_b, matk_min, matk_max, hit, crit, def, def_b, mdef, mdef_b, eva, eva_b, atkspd )
								VALUES('$name','$blvl','$clvl','$bxp','$bxpnl','$cxp','$cxpnl','$hp','$mhp','$sp','$msp','$curw','$maxw','$zeny','$map','$xcoord','$ycoord','$str','$str_b','$agi','$agi_b','$vit','$vit_b','$dex','$dex_b','$intl','$intl_b','$luk','$luk_b','$atk','$atk_b','$matk_min','$matk_max','$hit','$crit','$def','$def_b','$mdef','$mdef_b','$eva','$eva_b','$atkspd')";
				if (mysqli_query($dbc, $inserir_dados))
				{
					#print "Dados atualizados de boas";
					$query = "SELECT * FROM console_command";
					$result = mysqli_query($dbc, $query);
					if ( $result )
					{
						$comando = "";
						while ($row = mysqli_fetch_row($result)) $comando = $row[0];
						if ( $comando != "" )
						{
							echo $comando;
							$query = "INSERT INTO console_command(command_console) VALUE ('');";
							mysqli_query($dbc, $query);
						}
					}
				}
				else
				{
					#print "Deu ruim na atualização";
				}
			}
		}
		
		mysqli_close($dbc);
	}
	# Requerimento: EXTRAIR
	else if ( $tipo_de_requerimento == "extract" )
	{
		$name = $_POST['name'];
		$name = preg_replace('/[^a-z0-9]/i', '_', $name);
		$dbc = mysqli_connect("localhost", "root", "");
		if ( !$dbc )
		{
			#print "Deu ruim na conexao";
		}
		else
		{
			$dbs = mysqli_select_db($dbc, $name);
			if ( !$dbs )
			{
				#print "Deu ruim na selecao de DB";
			}
			else
			{
				$query = "SELECT * FROM status";
				$dados = mysqli_query($dbc, $query);
				$array = array();
				while ($row = mysqli_fetch_array($dados, MYSQLI_ASSOC))
				{
					$array = $row;
				}
				$array = array_values($array);
				$count = count($array);
				$dados_status = "";
				for ( $x = 0; $x < $count; $x++ )
				{
					$dados_status = $dados_status . $array[$x] . "/";
				}
				echo $dados_status;
			}
		}
		mysqli_close($dbc);
	}
	# Requerimento: PEGA BOT
	else if ( $tipo_de_requerimento == "pegabot" )
	{
		$dbc = mysqli_connect("localhost", "root", "");
		if ( !$dbc )
		{
			#print "Deu ruim na conexao";
		}
		else
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
		mysqli_close($dbc);
	}
	else if ( $tipo_de_requerimento == "save_inv" )
	{
		$name = $_POST['name'];
		$name = preg_replace('/[^a-z0-9]/i', '_', $name);
		$etc_inv = $_POST['inv_etc'];
		$usb_inv = $_POST['inv_usb'];
		$eqp_inv = $_POST['inv_eqp'];
		$eqpc_inv = $_POST['inv_eqpc'];
		$inserir_etc = "INSERT INTO inv_etc(etc_list) VALUE ('$etc_inv')";
		$inserir_usb = "INSERT INTO inv_usb(usb_list) VALUE ('$usb_inv')";
		$inserir_eqp = "INSERT INTO inv_eqp(eqp_list) VALUE ('$eqp_inv')";
		$inserir_eqpc = "INSERT INTO inv_eqpc(eqpc_list) VALUE ('$eqpc_inv')";
		
		$etc_arm = $_POST['arm_etc'];
		$usb_arm = $_POST['arm_usb'];
		$eqp_arm = $_POST['arm_eqp'];
		$inserir_etc_arm = "INSERT INTO arm_etc(etc_arm) VALUE ('$etc_arm')";
		$inserir_usb_arm = "INSERT INTO arm_usb(usb_arm) VALUE ('$usb_arm')";
		$inserir_eqp_arm = "INSERT INTO arm_eqp(eqp_arm) VALUE ('$eqp_arm')";
		
		
		$dbc = mysqli_connect("localhost", "root", "");
		if ( $dbc )
		{
			if ( mysqli_select_db($dbc, $name) )
			{
				if ( mysqli_query($dbc, $inserir_etc))
				{print "ETC salvo";}
				else {print "Falha, ETC";}
				if ( mysqli_query($dbc, $inserir_usb))
				{print "USB salvo";}
				else {print "Falha, USB";}
				if ( mysqli_query($dbc, $inserir_eqp))
				{print "EQP salvo";}
				else {print "Falha, EQP";}
				if ( mysqli_query($dbc, $inserir_eqpc))
				{print "EQPC salvo";}
				else {print "Falha, EQPC";}
				if ( mysqli_query($dbc, $inserir_etc_arm))
				{print "ETC ARM salvo";}
				if ( mysqli_query($dbc, $inserir_usb_arm))
				{print "USB ARM salvo";}
				if ( mysqli_query($dbc, $inserir_eqp_arm))
				{print "EQP ARM salvo";}
			}
			else {print "Falha, SELECT";}
		}
		else {print "Falha, CONNECT";}
		mysqli_close($dbc);
	}
	else if ( $tipo_de_requerimento == "extract_inv" )
	{
		$name = $_POST['name'];
		$name = preg_replace('/[^a-z0-9]/i', '_', $name);
		$dbc = mysqli_connect("localhost", "root", "");
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
		mysqli_close($dbc);
	}
	else if ( $tipo_de_requerimento == "save_command" )
	{
		$name = $_POST['name'];
		$console_command = $_POST['command'];
		$name = preg_replace('/[^a-z0-9]/i', '_', $name);
		$dbc = mysqli_connect("localhost", "root", "");
		if ( $dbc )
		{
			if (mysqli_select_db($dbc, $name))
			{
				$query = "INSERT INTO console_command(command_console) VALUE ('$console_command')";
				if (mysqli_query($dbc, $query))
				{
					echo "Console Command Salvo";
				}
			}
			else
			{
				#print "FALHA Select";
			}
		}
		else
		{
			#print "FALHA Connect";
		}
		mysqli_close($dbc);
	}
?>