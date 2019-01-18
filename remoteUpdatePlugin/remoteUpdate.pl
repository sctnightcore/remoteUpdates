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
	return if $net->getState != Network::IN_GAME;
	if ( $curTime + time > 5 )
	{
		sendRemoteUpdate();
	}
}
 # Envio de Status
 sub sendRemoteUpdate {
	# Armazenar nome
	my $name = $char->{name};
	my $status = $char->{name} . "/";
	# Armazenar level base
	$status = $status . $char->{lv} . "/";
	# Armazenar level classe
	$status = $status . $char->{lv_job} . "/";
	# Armazenar experiencia de base
	$status = $status . $char->{exp} . "/";
	# Armazenar experiencia base para lvlup
	$status = $status . $char->{exp_max} . "/";
	# Armazenar experiencia de classe
	$status = $status . $char->{exp_job} . "/";
	# Armazenar expeciencia classe para lvlup
	$status = $status . $char->{exp_job_max} . "/";
	# Armazenar HP
	$status = $status . $char->{hp} . "/";
	# Armazenar Max HP
	$status = $status . $char->{hp_max} . "/";
	# Armazenar SP
	$status = $status . $char->{sp} . "/";
	# Armazenar Max SP
	$status = $status . $char->{sp_max} . "/";
	# Armazenar peso atual
	$status = $status . $char->{weight} . "/";
	# Armazenar peso maximo
	$status = $status . $char->{weight_max} . "/";
	# Armazenar zeny
	$status = $status . $char->{zeny} . "/";
	# Armazenar mapa
	$status = $status . $field->{descString} . "/";
	# Armazenar coordenada x
	$status = $status . $char->{pos_to}{x} . "/";
	# Armazenar coordenada y
	$status = $status . $char->{pos_to}{y} . "/";
	# Armazenar Status
	$status = $status . $char->{str} . "/";
	$status = $status . $char->{str_bonus} . "/";
	$status = $status . $char->{agi} . "/";
	$status = $status . $char->{agi_bonus} . "/";
	$status = $status . $char->{vit} . "/";
	$status = $status . $char->{vit_bonus} . "/";
	$status = $status . $char->{dex} . "/";
	$status = $status . $char->{dex_bonus} . "/";
	$status = $status . $char->{int} . "/";
	$status = $status . $char->{int_bonus} . "/";
	$status = $status . $char->{luk} . "/";
	$status = $status . $char->{luk_bonus} . "/";
	$status = $status . $char->{atk} . "/";
	$status = $status . $char->{atk_bonus} . "/";
	$status = $status . $char->{attack_magic_min} . "/";
	$status = $status . $char->{attack_magic_max} . "/";
	$status = $status . $char->{hit} . "/";
	$status = $status . $char->{critical} . "/";
	$status = $status . $char->{def} . "/";
	$status = $status . $char->{def_bonus} . "/";
	$status = $status . $char->{def_magic} . "/";
	$status = $status . $char->{def_magic_bonus} . "/";
	$status = $status . $char->{flee} . "/";
	$status = $status . $char->{flee_bonus} . "/";
	$status = $status . $char->{attack_speed};
	# Armazenar Inventario e Armazem
	my $etc_item_list = "";
	my $usb_item_list = "";
	my $eqp_item_list = "";
	my $eqpc_item_list = "";
	my $etc_item_arm = "";
	my $usb_item_arm = "";
	my $eqp_item_arm = "";
	for my $item (@{$char->inventory->getItems()})
	{
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
	# Enviar Dados
	my $ua = LWP::UserAgent->new();
	my $r = HTTP::Request::Common::POST('https://127.0.0.1/remoteUpdatesPhp/main.php',
								[ req_type => "save",
								  name => $name,
								  status => $status,
								  inv_etc => $etc_item_list,
								  inv_eqp => $eqp_item_list,
								  inv_usb => $usb_item_list,
								  inv_eqpc => $eqpc_item_list,
								  arm_etc => $etc_item_arm,
								  arm_eqp => $eqp_item_arm,
								  arm_usb => $usb_item_arm,
								]);
	my $res = $ua->request($r);
	# Exibir resposta do envio
	my $console_command = $res->decoded_content;
	if ( $console_command != "console_command_executado" )
	{
		Commands::run($console_command);
	}
 }

sub send_Console_Command {
	my $command = @_;
}
 return 1;