package RemoteUpdates;

use strict;
use warnings;
use Plugins;
use Settings;
use Globals;
use Utils;
use Misc;
use Utils qw(getFormattedDate);
use Log qw(message error warning);
use Network;
use Network::Send;
use POSIX;
use Log qw(message);
use HTTP::Request ();
use HTTP::Request::Common;
use LWP::UserAgent ();
use Data::Dumper;
use Commands;
 
 # Registrar o Plugin
 Plugins::register("RTUpdates", "Remotamente com seus bots", \&on_unload, \&on_reload);
 # Criar os Hooks
my $hooks = Plugins::addHooks(
	['initialized', \&start],
	['mainLoop_post', \&mainLoop_post],
	['onload', \&onLoad],
);
 # Declalar variais a serem usadas
 my $ulr = "https://127.0.0.1/remoteUpdates/main.php";
 my $curTime = time;
 my $invTime = time;
 my $strTime = time;
 # Deletar Hooks ao fechar OpenKore
 sub on_unload {
	Plugins::delHooks($hooks);
	message "Descarregando RemoteUpdate...\n";
}

sub on_load {
}

sub start {
}

 # Loop principal
sub mainLoop_post {
	
	return if !$char;
	if ( $net->getState != Network::IN_GAME )
	{
		my $connected = "desconnected";
		send_Sts($connected);
	}
	return if $net->getState != Network::IN_GAME;
	if ( $curTime - time < -5 )
	{
		my $connected = "connected";
		$curTime = time;
		send_Sts($connected);
		send_Inv();
	}
}
 # Envio de Status
 sub send_Sts {
	my $connected = @_;
	# Armazenar nome
	my $name = $char->{name};
	# Armazenar level base
	my $blvl = $char->{lv};
	# Armazenar level classe
	my $clvl = $char->{lv_job};
	# Armazenar experiencia de base
	my $bxp = $char->{exp};
	# Armazenar experiencia base para lvlup
	my $bxpnl = $char->{exp_max};
	# Armazenar experiencia de classe
	my $cxp = $char->{exp_job};
	# Armazenar expeciencia classe para lvlup
	my $cxpnl = $char->{exp_job_max};
	# Armazenar HP
	my $hp = $char->{hp};
	# Armazenar Max HP
	my $mhp = $char->{hp_max};
	# Armazenar SP
	my $sp = $char->{sp};
	# Armazenar Max SP
	my $msp = $char->{sp_max};
	# Armazenar peso atual
	my $curw = $char->{weight};
	# Armazenar peso maximo
	my $maxw = $char->{weight_max};
	# Armazenar zeny
	my $zeny = $char->{zeny};
	# Armazenar mapa
	my $map = $field->{descSting};
	# Armazenar coordenada x
	my $xcoord = $char->{pos_to}{x};
	# Armazenar coordenada y
	my $ycoord = $char->{pos_to}{y};
	# Armazenar Status
	my $str = $char->{str};
	my $str_bonus = $char->{str_bonus};
	my $agi = $char->{agi};
	my $agi_bonus = $char->{agi_bonus};
	my $vit = $char->{vit};
	my $vit_bonus = $char->{vit_bonus};
	my $dex = $char->{dex};
	my $dex_bonus = $char->{dex_bonus};
	my $int = $char->{int};
	my $int_bonus = $char->{int_bonus};
	my $luk = $char->{luk};
	my $luk_bonus = $char->{luk_bonus};
	my $atk = $char->{atk};
	my $atk_bonus = $char->{atk_bonus};
	my $matk_min = $char->{attack_magic_min};
	my $matk_max = $char->{attack_magic_max};
	my $hit = $char->{hit};
	my $crit = $char->{critical};
	my $def = $char->{def};
	my $def_bonus = $char->{def_bonus};
	my $mdef = $char->{def_magic};
	my $mdef_bonus = $char->{def_magic_bonus};
	my $eva = $char->{flee};
	my $eva_bonus = $char->{flee_bonus};
	my $atkspd = $char->{attack_speed};
	# Enviar Dados
	my $ua = LWP::UserAgent->new();
	my $r = HTTP::Request::Common::POST('https://127.0.0.1/remoteUpdates/main.php',
								[ req_type => "save",
								  name => $name,
								  blvl => $blvl,
								  clvl => $clvl,
								  bxp => $bxp,
								  bxpnl => $bxpnl,
								  cxp => $cxp,
								  cxpnl => $cxpnl,
								  hp => $hp,
								  mhp => $mhp,
								  sp => $sp,
								  msp => $msp,
								  curw => $curw,
								  maxw => $maxw,
								  zeny => $zeny,
								  map => $map,
								  xcoord => $xcoord,
								  ycoord => $ycoord,
								  str => $str,
								  str_b => $str_bonus,
								  agi => $agi,
								  agi_b => $agi_bonus,
								  vit => $vit,
								  vit_b => $vit_bonus,
								  dex => $dex,
								  dex_b => $dex_bonus,
								  int => $int,
								  int_b => $int_bonus,
								  luk => $luk,
								  luk_b => $luk_bonus,
								  atk => $atk,
								  atk_b => $atk_bonus,
								  matk_min => $matk_min,
								  matk_max => $matk_max,
								  hit => $hit,
								  crit => $crit,
								  def => $def,
								  def_b => $def_bonus,
								  mdef => $mdef,
								  mdef_b => $mdef_bonus,
								  eva => $eva,
								  eva_b => $eva_bonus,
								  atkspd => $atkspd,
								  connected => $connected,
								]);
	my $res = $ua->request($r);
	# Exibir resposta do envio
	my $console_command = $res->decoded_content;
	Commands::run($console_command);
 }
 # Envio de Inventario
 sub send_Inv {
	my $name = $char->{name};
	# Armazenar Inventario
	my $etc_item_list = "";
	my $usb_item_list = "";
	my $eqp_item_list = "";
	my $eqpc_item_list = "";
	my $etc_item_arm = "";
	my $usb_item_arm = "";
	my $eqp_item_arm = "";
	for (my $x; $x < @{$char->inventory->getItems()}; $x++)
	{
		my $item = $char->inventory->getItems()->[$x];
		next unless $item && %{$item};
		# Lista de ETC
		if (($item->{type} == 3 || $item->{type} == 6 || $item->{type} == 10) && (!$item->{equipped}))
		{
			$etc_item_list = $etc_item_list . $item->{name} . "," . $item->{amount} . "/";
		}
		elsif (($item->{type} == 0 || $item->{type} == 1 || $item->{type} == 2) && (!$item->{equipped}))
		{
			$usb_item_list = $usb_item_list . $item->{name} . "," . $item->{amount} . "/";
		}
		elsif ($item->{equipped})
		{
			$eqpc_item_list = $eqpc_item_list . $item->{name} . "/";
		}
		else
		{
			$eqp_item_list = $eqp_item_list . $item->{name} . "/";
		}
	}
	for my $item (@{$char->storage->getItems()})
	{
		if ($item->usable)
		{
			$etc_item_arm = $etc_item_arm . $item->{name} . "," . $item->{amount} . "/";
		}
		elsif ($item->equippable)
		{
			$usb_item_arm = $usb_item_arm . $item->{name} . "/";
		}
		else
		{
			$eqp_item_arm = $eqp_item_arm . $item->{name} . "," . $item->{amount} . "/";
		}
	}
	my $ua = LWP::UserAgent->new();
	my $r = HTTP::Request::Common::POST('https://127.0.0.1/remoteUpdates/main.php',
								[ req_type => "save_inv",
								  name => $name,
								  inv_usb => $usb_item_list,
								  inv_etc => $etc_item_list,
								  inv_eqp => $eqp_item_list,
								  inv_eqpc => $eqpc_item_list,
								  arm_usb => $usb_item_arm,
								  arm_etc => $etc_item_arm,
								  arm_eqp => $eqp_item_arm,
								]);
	my $res = $ua->request($r);
	#message $res->decoded_content;
 }

sub send_Console_Command {
	my $command = @_;
}
 return 1;