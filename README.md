# remoteUpdates
Atualizações remotas

# UPDATES
  - V 1.2.0
  - Oque mudar
    - A pasta do plugin na pasta plugins deve ser renomeada de "remoteUpdate" para "remoteUpdatePlugin"
    - A pasta do plugin na pasta htdocs deve ser renomeada de "remoteUpdates" para "remoteUpdatesPhp"
  - Bugs Resolvidos
    - Na tela inicial o conteiner das informações dos bots não ajustava seu tamanho em relação a tela ( RESOLVIDO )
    - Os botões de inventario, status e console não estavam acessiveis devido ao erro anterior ( RESOLVIDO )
    - Mensagem na tela do OpenKore sobre uma variavel "$x" ( RESOLVIDO )
    - O aplicativo não girava junto com o telefone ( RESOLVIDO )
  - Bugs Conhecidos mas não resolvidos
    - O Item não tem sua quantidade atualizada quando usado pelo Inventario ( EM ANDAMENTO )
    - Os Item no inventario/armazém não ajustão seu tamanho com a tela ( EM ANDAMENTO )
  - Novas Funções
    - Salvar 2 IPs diferentes, um para uso local e outro pra uso em rede externa, basta marcar a caixa abaixo dos IPs para usar o segundo endereço de IP para acessar atrávez da 3G ou WiFi de outro local ( DISPONIVEL APENAS QUANDO O PORTFOWARDING ESTIVER CONFIGURADO )
    - Botão para resetar as configurações
    - Botão para resetar o DataBase ( Criado para corrigir um erro no PhP da versão 1.0.0 )
    - Utilizar items do tipo usavel, como poções, asa de mosca, etc... a partir da tela do inventario ( Note que há um delay nessa utilização )
  - Como Atualizar
    - Substitua os arquivos "remoteUpdate.pl" e "main.php" das respectivas pastas pelas do repositorio.
    - Reinstale o apk em seu telefone com o do repositorio.
    - Após instalar o apk vá em CONFIGURAR e clique no botão RESETAR DATABASE
    - Seja feliz ( o mais dificil )
# Features
  - Visualizar os Status dos bots, tais como:
    - HP
    - SP
    - XP de Base
    - XP de Classe
    - Status ( Força, Agilidade, Ataque, etc... )
    - Coordenadas
  - Visualizar o Inventário:
    - Nomes dos items
    - Quantidade dos items
    - Icones exibidos de forma simplificada, diferenciando Úsaveis, Equipamentos, Outros e Cards
    - Disponivel OFFLINE ( Mesmo com seu telefone ou bot não conectatos! Obviamente será a ultima lista enviada por ele )
  - Visualizar o Armazém:
    - Também de forma simplificada
    - Apenas disponivel depois que eles usarem o armazém
    - Disponivel OFFLINE ( Mesmo com seu telefone ou bot não conectatos! Obviamente será a ultima lista enviada por ele )
  - Comandos de Console:
    - Envio de comandos de console ( O Console ainda é muito primitivo, não tendo feedback das atividades, assim como retorno
      dos comandos enviados )
  - MultiBot Suport
    - Monitore multiplos bots ao mesmo tempo pelo app ( Até agora testei com 5 ao mesmo tempo sem problema nenhum, até então não sei se tem um limite )
      
# Como Instalar
  - Instalando o PLUGIN:
    - Crie uma pasta com o nome "remoteUpdatePlugin" na pasta plugins:
    - Copie o arquivo "remoteUpdate.pl" para dentro desta pasta;
    - Adicione o plugin "remoteUpdate" a lista de plugins no arquivo "sys.txt" na pasta config dos bots que queria utilizar o plugin;
  - Configurando o XAMPP:
    - Tenha o programa "XAMPP" instalado em seu computador:
    - Abra a pasta "htdocs" na pasta onde o "xampp" está instalado e crie uma pasta chamada "remoteUpdatesPhp"
    - Copie o arquivo "main.php" para dentro desta pasta;
  - Checando o XAMPP, PHP, PHPMYADMIN e MYSQL:
    - Acesse "localhost" de seu navegador, se aparecer a pagina de boas vindas do "xampp" o programa foi instalado corretamente;
    - Acesse "localhost/phpmyadmin" de seu navedador, use o nome de utilizador "root" ( a não ser que tenha configurado um diferente nas configurações do PhPMyAdmin, nesse caso, abra o arquivo "main.php" que copiamos a pouco e na linha 4 troque root para o login que você configurou ) deixe sem senha ( a não ser que tenha configurado uma nas configurações do PhPMyAdmin, nesse caso, abra o arquivo "main.php" que copiamos a pouco e na linha 5 coloque sua senha, salve e feche o arquivo ) e clique em executar, se aparecer a
    a pagina do MySQL, tudo está configurado corretamente;
  - Configurando o Aplicativo:
    - Instale o aplicativo "remoteUpdates.apk" em seu telefone
    - Clique em "CONFIGURAR" na superir direita;
    - No campo "IP DO HOST" coloque o endereço IP local da sua maquina e clique em "SALVAR CONFIGURAÇÕES";
    - Caso queira acessar atrávez de redes externas, ou seja, que não seja sua rede local, como outras redes WiFi ou 3G, será
    nescessario configurar o "PortFowarding" no seu modem, para redirecionar os pedidos HTTP da porta 80 para seu IP local;
    
# Conclusão
  - Se você seguiu corretamente todas as instruções acima, seu RemoteUpdate está funcionando e atualizando!
  
# Problemas comuns
  - O app não mostra a lista:
    - Atualize o IP DO HOST nas configurações do APP para o IP da sua maquina;
    - Tenha certeza de que o XAMPP está ligado e que os Modulos Apache e MySQL estejam rodando;
    - Seu telefone está na mesma rede que seu computador;
    - No caso de acesso por rede externa, verifique suas configurações do PortFowarding;
  - O armazém não está mostrando os items:
    - Isso não é bem um problema, o armazém só estará disponivel no app depois que o personagem acessar o armazém no jogo;
  - O inventario/armazém demora para atualizar
    - Isso foi um erro na versão 1.0.0 do PhP, vá em configurações e clique em "RESETAR DATABASE"
  - Erro no console do OpenKore dizendo "Comando 'console_command_executado'"
    - Só aparece uma uma única vez na primeira vez que o bot rodar com o plugin
  - Erro no console do OpenKore dizendo "Comando 'connect'"
    - Verifique se o XAMPP está ligado e os modulos PhP e MySQL estão ativos
