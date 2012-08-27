<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$mod_strings = array(
  'LBL_MAP' => 'Mapa',
  'LBL_MAPS' => 'Mapas',
  'LBL_MODULE_NAME' => 'Mapas',
  'LBL_MODULE_TITLE' => 'Mapas: Home',
  'LBL_MODULE_ID'=> 'Mapas',
  'LBL_LIST_FORM_TITLE' => 'Listagem Mapas',
  'LBL_MAP_CUSTOM_MARKER' => 'Marcador',
  'LBL_MAP_CUSTOM_AREA' => 'Área',
  'LBL_HOMEPAGE_TITLE' => 'Listagem Mapas',

  'LBL_FLEX_RELATE' => 'Relacionado ao (Centro):',
  'LBL_MODULE_TYPE' => 'Tipo do Módulo de Display:',
  'LBL_DISTANCE' => 'Distância (Raio):',
  'LBL_UNIT_TYPE' => 'Tipo de Unidade:',

  'LBL_MAP_ACTION' => 'Mapear',
  'LBL_MAP_DISPLAY' => 'Visualização do Mapa',
  'LBL_MAP_LEGEND' => 'Legenda:',
  'LBL_MAP_USERS' => 'Usuários:',
  'LBL_MAP_USER_GROUPS' => 'Grupos de Usuários:',
  'LBL_MAP_ASSIGNED_TO' => 'Atribuído para:',

  'LNK_NEW_MAP' => 'Adicionar Novo Mapa',
  'LNK_NEW_RECORD' => 'Adicionar Novo Mapa',
  'LNK_MAP_LIST' => 'Lista de Mapas',
  'LNK_IMPORT_MAPS' => 'Importação',
  'LBL_MAP_GEOCODE_ADDRESSES' => 'Endereço Geocode',
  'LBL_MAP_DONATE' => 'Doar',
  'LBL_MAP_DONATE_TO_THIS_PROJECT' => 'Doar ao Projeto',
  'LBL_BUG_FIX' => 'Bug Fix',

  'LBL_MAP_ADDRESS_TEST' => 'Geocodificação Teste',
  'LBL_MAP_QUICK_RADIUS' => 'Mapa raio Rápido',
  'LBL_MAP_NULL_GROUP_NAME' => 'Nada',
  'LBL_MAP_ADDRESS' => 'Endereço',
  'LBL_MAP_PROCESS' => 'Processá-lo',

  'LBL_MAP_LAST_STATUS' => 'Status Geocode última',
  'LBL_MAP_GEOCODED_COUNTS' => 'Geocodificadas Condes',
  'LBL_GEOCODED_COUNTS' => 'Módulo Geocodificadas Condes',
  'LBL_CRON_URL' => 'Cron URL:',
  'LBL_MODULE_HEADING' => 'Módulo',
  'LBL_MODULE_TOTAL_HEADING' => 'Total',
  'LBL_GEOCODED_COUNTS_DESCRIPTION' => 'A tabela mostra belown mostra o número de objetos do módulo geocodificados, agrupados por geocoding resposta. '. 
    'Tenha em mente que o padrão Google Maps limite de utilização é de 2500 pedidos por dia. '.
    'Este módulo irá armazenar em cache os endereços de geocodificação de informações durante o processamento para reduzir o número total de pedidos necessários.',
  'LBL_CRON_URL' => 'CRON URL',
  'LBL_CRON_INSTRUCTIONS' => 'Para processar os pedidos de geocodificação, é recomendado configurar uma noite Cron Job. '.
    'Um ponto de acesso personalizado tenha sido criado para esse fim e pode ser acessada sem autenticação. '.
    'O URL mostrado abaixo é para ser usado com um Scheduled Task Administrativo. '.
    'Por favor, consulte a documentação do SugarCRM para obter mais informações.',
  'LBL_EXPORT_ADDRESS_URL' => 'Exportação URLs',
  'LBL_EXPORT_INSTRUCTIONS' => 'Use os links abaixo para exportar endereços completos na necessidade de geocodeing informação. '.
    'Em seguida, use um lote online ou offline geocoding ferramenta para o georreferenciamento dos endereços. '.
    'Quando você terminar de geocodificação, importar os endereços para o módulo de cache de endereços para ser usado com os seus mapas. '.
    'Note, o endereço do módulo de cache é opcional. Todas as informações geocodificação é armazenado no módulo representativo.',

);

?>
