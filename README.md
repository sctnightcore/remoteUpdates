# remoteUpdates
Remotely Updates about your bots activity

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
    - Crie uma pasta com o nome "remoteUpdate" na pasta plugins:
    - Copie o arquivo "remoteUpdate.pl" para dentro desta pasta;
    - Adicione o plugin "remoteUpdate" a lista de plugins no arquivo "sys.txt" na pasta config dos bots que queria utilizar o plugin;
  - Configurando o XAMPP:
    - Tenha o programa "XAMPP" instalado em seu computador:
    - Abra a pasta "htdocs" na pasta onde o "xampp" está instalado e crie uma pasta chamada "remoteUpdates"
    - Copie o arquivo "main.php" para dentro desta pasta;
    - Abra o arquivo "config.inc.php" dentro da pasta "phpMyAdmin" que está dentro da pasta "xampp" e adicione um "password" na linha 21;
  - Checando o XAMPP, PHP, PHPMYADMIN e MYSQL:
    - Acesse "localhost" de seu navegador, se aparecer a pagina de boas vindas do "xampp" o programa foi instalado corretamente;
    - Acesse "localhost/phpmyadmin" de seu navedador, use o nome de utilizador "root", deixe sem senha ( a não ser que tenha alterado a       linha 23 do arquivo "config.inc.php" para "false", oque não aconcelho para usuarios basicos e também porque parte do PhP está um pouco hardcoded em relação ao DB :( my bad ) e clique em executar, se aparecer a
    a pagina do MySQL, tudo está configurado corretamente;
  - Configurando o Aplicativo:
    - Instale o aplicativo "remoteUpdates.apk" em seu telefone
    - Clique em "CONFIGURAR" na superir direita;
    - No campo "IP DO HOST" coloque o endereço IP local da sua maquina e clique em "SALVAR CONFIGURAÇÕES";
    - Clique em "CONFIGURAR" novamente para fechar as configurações;
    - Caso queira acessar atrávez de redes externas, ou seja, que não seja sua rede local, como outras redes WiFi ou 3G, será
    nescessario configurar o "PortFowarding" no seu modem, para redirecionar os pedidos HTTP da porta 80 para seu IP local;
    
# Conclusão
  - Se você seguiu corretamente todas as instruções acima, seu RemoteUpdate está funcionando e atualizando!
