<?php

//////
////// System MyPrint OSA -> Ekran główny systemu
////// (c) 2001-2013 by Marcin Polkowski & Artur Cielebąk, www.myprint.pl
//////
///
///

INCLUDE('./config/config.php');
INCLUDE('./session.php');
INCLUDE('./layout.php');
INCLUDE('./order_calculation_lang.php');
INCLUDE('./functions.php');
INCLUDE('./order_calculation_functions.php');
INCLUDE('./order_calculation_file_functions.php');
INCLUDE('./menu.php');

//zmienne używane w całym pliku
$txt_powrot_01        = $OCLangDict['txt_powrot_01'][$lang_id];
$txt_check_01         = $OCLangDict['txt_check_01'][$lang_id];
$txt_input_02         = $OCLangDict['txt_input_02'][$lang_id];
$txt_input_03         = $OCLangDict['txt_input_03'][$lang_id];
$txt_input_05         = $OCLangDict['txt_input_05'][$lang_id];
$txt_menu_0_0_0       = $OCLangDict['txt_menu_0_0_0'][$lang_id];
$txt_menu_12_1_0      = $OCLangDict['txt_menu_12_1_0'][$lang_id];
$txt_menu_12_1dsc     = $OCLangDict['txt_menu_12_1dsc'][$lang_id];
$txt_menu_12_2_0      = $OCLangDict['txt_menu_12_2_0'][$lang_id];
$txt_menu_12_2dsc     = $OCLangDict['txt_menu_12_2dsc'][$lang_id];
$txt_menu_12_3_0      = $OCLangDict['txt_menu_12_3_0'][$lang_id];
$txt_menu_12_3dsc     = $OCLangDict['txt_menu_12_3dsc'][$lang_id];
$txt_menu_12_3_1      = $OCLangDict['txt_menu_12_3_1'][$lang_id];
$txt_menu_12_3_1dsc   = $OCLangDict['txt_menu_12_3_1dsc'][$lang_id];
$txt_menu_12_5_0      = $OCLangDict['txt_menu_12_5_0'][$lang_id];
$txt_menu_12_5dsc     = $OCLangDict['txt_menu_12_5dsc'][$lang_id];
$txt_title_001        = $OCLangDict['txt_title_001'][$lang_id];//szczegóły
$txt_title_002        = $OCLangDict['txt_title_002'][$lang_id];//powrót do listy
$txt_title_003        = $OCLangDict['txt_title_003'][$lang_id];//powrót do menu
$txt_filtr_01         = $OCLangDict['txt_filtr_01'][$lang_id];
$txt_filtr_02         = $OCLangDict['txt_filtr_02'][$lang_id];


$connection = @mysql_connect($db_host, $db_user, $db_password) or die("Próba połączenia nie powiodła się!");
$db = @mysql_select_db($db_name, $connection) or die("Wybór bazy danych nie powiódł się!");
$delated_color     = ReadSystemSettings($connection,"color_delated_for_in_table");
$max_filesize      = ReadSystemSettings($connection,"oc_file_size_max");
$max_filesize_     = number_format($max_filesize / 1024 / 1024,"0","."," ");

SaveUserOnline($connection,$user_id,"Podglad kalkulacji");

date_default_timezone_set('Europe/Warsaw');
$dzisiaj      = date("Y-m-d");
$dzisiajteraz = date("Y-m-d H:i:s");
$y_m          = date("Y-m");
$validate     = "";
$validate_data = "";
$size_span = "10px";
$input_hidden_type = "text";
$input_hidden_type = "hidden";
$input_hidden_type_view = "text readonly";
$input_hidden_type_view_info = "text readonly";

$file_name = "order_calculation_show";
$table_name = "order_calculations";
$table_id = "oc_id";
$back       = "";
$error      = "";
$option     = "";
$oc_id = "";
IF (isset($_POST['action2'])) {
  $action      = $_POST['action2'];
  IF (isset($_POST['back']))            { $back           = $_POST['back']; }
  IF (isset($_POST['oc_id']))           { $oc_id          = $_POST['oc_id']; }
  IF (isset($_POST['option']))          { $option         = $_POST['option']; }
  IF (isset($_POST['error']))           { $error          = $_POST['error']; }
} else {
  $action      = $_GET['action'];
  IF (isset($_GET['back']))             { $back           = $_GET['back']; }
  IF (isset($_GET['oc_id']))            { $oc_id          = $_GET['oc_id']; }
  IF (isset($_GET['option']))           { $option         = $_GET['option']; }
  IF (isset($_GET['error']))            { $error          = $_GET['error']; }
}
$menu_access = "12_3_0"; $menu_value = "12_2_0"; $txt_menu_12 = $txt_menu_12_2_0; $txt_menu_12dsc = $txt_menu_12_2dsc;
IF (!$oc_id) {
   $menu_access = "12_5_0"; $menu_value = "12_5_0"; $txt_menu_12 = $txt_menu_12_5_0; $txt_menu_12dsc = $txt_menu_12_5dsc;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

IF ($action == "show") {

//kontrola dostępu
//AccessDeniedCheck($connection,$user_id,$userlevel_id,$serwer,$menu_access,"order_calculation_show.php -> list");


$menu_caption = "/ <A href=\"./index.php\" style=\"color: #FFFFFF\" title=\"$txt_title_003\">Menu główne</A>
                 / <A href=\"./order_calculation_list.php?action=list\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_1_0</A> / $txt_menu_12";
$window_caption = "$txt_menu_0_0_0 :: $txt_menu_12_1_0";


$max_filesize_        = number_format($max_filesize / 1024 / 1024,"0","."," ");
ReadUser($connection,$user_id,$user_id_fe,$user_id_le,$user_id_ln,$user_id_ul,$user_id_pt,$user_id_sr);

$txt_td_004           = $OCLangDict['txt_td_004'][$lang_id];
$txt_td_018           = $OCLangDict['txt_td_018'][$lang_id];
$txt_td_019           = $OCLangDict['txt_td_019'][$lang_id];
$txt_td_021           = $OCLangDict['txt_td_021'][$lang_id];
$txt_td_022           = $OCLangDict['txt_td_022'][$lang_id];
$txt_td_031           = $OCLangDict['txt_td_031'][$lang_id];
$txt_td_032           = $OCLangDict['txt_td_032'][$lang_id];
$txt_td_033           = $OCLangDict['txt_td_033'][$lang_id];
$txt_td_034           = $OCLangDict['txt_td_034'][$lang_id];
$txt_td_035           = $OCLangDict['txt_td_035'][$lang_id];
$txt_td_036           = $OCLangDict['txt_td_036'][$lang_id];
$txt_td_037           = $OCLangDict['txt_td_037'][$lang_id];
$txt_td_038           = $OCLangDict['txt_td_038'][$lang_id];
$txt_td_039           = $OCLangDict['txt_td_039'][$lang_id];
$txt_td_040           = $OCLangDict['txt_td_040'][$lang_id];
$txt_td_041           = $OCLangDict['txt_td_041'][$lang_id];
$txt_td_042           = $OCLangDict['txt_td_042'][$lang_id];
$txt_td_043           = $OCLangDict['txt_td_043'][$lang_id];
$txt_td_044           = $OCLangDict['txt_td_044'][$lang_id];
$txt_td_045           = $OCLangDict['txt_td_045'][$lang_id];
$txt_td_046           = $OCLangDict['txt_td_046'][$lang_id];
$txt_td_047           = $OCLangDict['txt_td_047'][$lang_id];
$txt_td_048           = $OCLangDict['txt_td_048'][$lang_id];
$txt_td_049           = $OCLangDict['txt_td_049'][$lang_id];
$txt_td_050           = $OCLangDict['txt_td_050'][$lang_id];
$txt_td_051           = $OCLangDict['txt_td_051'][$lang_id];
$txt_td_052           = $OCLangDict['txt_td_052'][$lang_id];
$txt_td_053           = $OCLangDict['txt_td_053'][$lang_id];
$txt_td_054           = $OCLangDict['txt_td_054'][$lang_id];
$txt_td_055           = $OCLangDict['txt_td_055'][$lang_id];
$txt_td_056           = $OCLangDict['txt_td_056'][$lang_id];
$txt_td_057           = $OCLangDict['txt_td_057'][$lang_id];
$txt_td_058           = $OCLangDict['txt_td_058'][$lang_id];
$txt_td_059           = $OCLangDict['txt_td_059'][$lang_id];
$txt_td_060           = $OCLangDict['txt_td_060'][$lang_id];
$txt_td_061           = $OCLangDict['txt_td_061'][$lang_id];
$txt_td_062           = $OCLangDict['txt_td_062'][$lang_id];
$txt_td_063           = $OCLangDict['txt_td_063'][$lang_id];
$txt_td_064           = $OCLangDict['txt_td_064'][$lang_id];
$txt_td_065           = $OCLangDict['txt_td_065'][$lang_id];
$txt_td_066           = $OCLangDict['txt_td_066'][$lang_id];
$txt_td_067           = $OCLangDict['txt_td_067'][$lang_id];
$txt_td_068           = $OCLangDict['txt_td_068'][$lang_id];
$txt_td_069           = $OCLangDict['txt_td_069'][$lang_id];
$txt_td_070           = $OCLangDict['txt_td_070'][$lang_id];
$txt_td_071           = $OCLangDict['txt_td_071'][$lang_id];
$txt_td_072           = $OCLangDict['txt_td_072'][$lang_id];
$txt_td_073           = $OCLangDict['txt_td_073'][$lang_id];
$txt_td_074           = $OCLangDict['txt_td_074'][$lang_id];
$txt_td_075           = $OCLangDict['txt_td_075'][$lang_id];
$txt_td_076           = $OCLangDict['txt_td_076'][$lang_id];
$txt_td_077           = $OCLangDict['txt_td_077'][$lang_id];
$txt_td_078           = $OCLangDict['txt_td_078'][$lang_id];
$txt_td_079           = $OCLangDict['txt_td_079'][$lang_id];
$txt_td_080           = $OCLangDict['txt_td_080'][$lang_id];
$txt_td_081           = $OCLangDict['txt_td_081'][$lang_id];
$txt_td_082           = $OCLangDict['txt_td_082'][$lang_id];
$txt_td_083           = $OCLangDict['txt_td_083'][$lang_id];
$txt_td_084           = $OCLangDict['txt_td_084'][$lang_id];
$txt_td_085           = $OCLangDict['txt_td_085'][$lang_id];
$txt_td_086           = $OCLangDict['txt_td_086'][$lang_id];
$txt_td_087           = $OCLangDict['txt_td_087'][$lang_id];
$txt_td_088           = $OCLangDict['txt_td_088'][$lang_id];
$txt_td_089           = $OCLangDict['txt_td_089'][$lang_id];
$txt_td_090           = $OCLangDict['txt_td_090'][$lang_id];
$txt_td_091           = $OCLangDict['txt_td_091'][$lang_id];
$txt_td_092           = $OCLangDict['txt_td_092'][$lang_id];
$txt_td_093           = $OCLangDict['txt_td_093'][$lang_id];
$txt_td_094           = $OCLangDict['txt_td_094'][$lang_id];
$txt_td_095           = $OCLangDict['txt_td_095'][$lang_id];
$txt_td_096           = $OCLangDict['txt_td_096'][$lang_id];
$txt_td_107           = $OCLangDict['txt_td_107'][$lang_id];
$txt_td_108           = $OCLangDict['txt_td_108'][$lang_id];
$txt_td_109           = $OCLangDict['txt_td_109'][$lang_id];
$txt_td_110           = $OCLangDict['txt_td_110'][$lang_id];
$txt_td_111           = $OCLangDict['txt_td_111'][$lang_id];
$txt_td_112           = $OCLangDict['txt_td_112'][$lang_id];
$txt_td_113           = $OCLangDict['txt_td_113'][$lang_id];
$txt_td_114           = $OCLangDict['txt_td_114'][$lang_id];
$txt_td_115           = $OCLangDict['txt_td_115'][$lang_id];
$txt_td_116           = $OCLangDict['txt_td_116'][$lang_id];
$txt_td_117           = $OCLangDict['txt_td_117'][$lang_id];
$txt_td_118           = $OCLangDict['txt_td_118'][$lang_id];
$txt_td_119           = $OCLangDict['txt_td_119'][$lang_id];
$txt_td_120           = $OCLangDict['txt_td_120'][$lang_id];
$txt_td_121           = $OCLangDict['txt_td_121'][$lang_id];
$txt_td_122           = $OCLangDict['txt_td_122'][$lang_id];
$txt_td_123           = $OCLangDict['txt_td_123'][$lang_id];
$txt_td_124           = $OCLangDict['txt_td_124'][$lang_id];
$txt_td_125           = $OCLangDict['txt_td_125'][$lang_id];
$txt_td_126           = $OCLangDict['txt_td_126'][$lang_id];
$txt_td_127           = $OCLangDict['txt_td_127'][$lang_id];
$txt_td_128           = $OCLangDict['txt_td_128'][$lang_id];
$txt_td_129           = $OCLangDict['txt_td_129'][$lang_id];
$txt_td_130           = $OCLangDict['txt_td_130'][$lang_id];
$txt_td_131           = $OCLangDict['txt_td_131'][$lang_id];
$txt_td_132           = $OCLangDict['txt_td_132'][$lang_id];
$txt_td_133           = $OCLangDict['txt_td_133'][$lang_id];
$txt_td_134           = $OCLangDict['txt_td_134'][$lang_id];
$txt_td_135           = $OCLangDict['txt_td_135'][$lang_id];
$txt_td_136           = $OCLangDict['txt_td_136'][$lang_id];
$txt_td_137           = $OCLangDict['txt_td_137'][$lang_id];
$txt_td_138           = $OCLangDict['txt_td_138'][$lang_id];
$txt_td_139           = $OCLangDict['txt_td_139'][$lang_id];
$txt_td_141           = $OCLangDict['txt_td_141'][$lang_id];
$txt_td_142           = $OCLangDict['txt_td_142'][$lang_id];
$txt_td_147           = $OCLangDict['txt_td_147'][$lang_id];
$txt_td_148           = $OCLangDict['txt_td_148'][$lang_id];
$txt_td_149           = $OCLangDict['txt_td_149'][$lang_id];
$txt_td_151           = $OCLangDict['txt_td_151'][$lang_id];
$txt_td_152           = $OCLangDict['txt_td_152'][$lang_id];
$txt_td_160           = $OCLangDict['txt_td_160'][$lang_id];
$txt_td_191           = $OCLangDict['txt_td_191'][$lang_id];
$txt_td_192           = $OCLangDict['txt_td_192'][$lang_id];
$txt_td_199           = $OCLangDict['txt_td_199'][$lang_id];
$txt_td_200           = $OCLangDict['txt_td_200'][$lang_id];
$txt_td_201           = $OCLangDict['txt_td_201'][$lang_id];
$txt_td_202           = $OCLangDict['txt_td_202'][$lang_id];
$txt_td_203           = $OCLangDict['txt_td_203'][$lang_id];
$txt_td_204           = $OCLangDict['txt_td_204'][$lang_id];
$txt_td_207           = $OCLangDict['txt_td_207'][$lang_id];
$txt_td_208           = $OCLangDict['txt_td_208'][$lang_id];
$txt_td_209           = $OCLangDict['txt_td_209'][$lang_id];
$txt_td_210           = $OCLangDict['txt_td_210'][$lang_id];
$txt_td_211           = $OCLangDict['txt_td_211'][$lang_id];
$txt_td_216           = $OCLangDict['txt_td_216'][$lang_id];

$txt_td_217           = $OCLangDict['txt_td_217'][$lang_id];
$txt_td_218           = $OCLangDict['txt_td_218'][$lang_id];
$txt_td_219           = $OCLangDict['txt_td_219'][$lang_id];
$txt_td_220           = $OCLangDict['txt_td_220'][$lang_id];
$txt_td_221           = $OCLangDict['txt_td_221'][$lang_id];
$txt_td_222           = $OCLangDict['txt_td_222'][$lang_id];
$txt_td_223           = $OCLangDict['txt_td_223'][$lang_id];
$txt_td_224           = $OCLangDict['txt_td_224'][$lang_id];
$txt_td_225           = $OCLangDict['txt_td_225'][$lang_id];
$txt_td_226           = $OCLangDict['txt_td_226'][$lang_id];
$txt_td_227           = $OCLangDict['txt_td_227'][$lang_id];
$txt_td_228           = $OCLangDict['txt_td_228'][$lang_id];
$txt_td_229           = $OCLangDict['txt_td_229'][$lang_id];
$txt_td_230           = $OCLangDict['txt_td_230'][$lang_id];
$txt_td_231           = $OCLangDict['txt_td_231'][$lang_id];
$txt_td_232           = $OCLangDict['txt_td_232'][$lang_id];
$txt_td_233           = $OCLangDict['txt_td_233'][$lang_id];
$txt_td_234           = $OCLangDict['txt_td_234'][$lang_id];
$txt_td_235           = $OCLangDict['txt_td_235'][$lang_id];
$txt_td_236           = $OCLangDict['txt_td_236'][$lang_id];
$txt_td_237           = $OCLangDict['txt_td_237'][$lang_id];

$txt_text_0018        = $OCLangDict['txt_text_0018'][$lang_id];
$txt_text_0019        = $OCLangDict['txt_text_0019'][$lang_id];

$max_filesize_        = number_format($max_filesize / 1024 / 1024,"0","."," ");
ReadUser($connection,$user_id,$user_id_fe,$user_id_le,$user_id_ln,$user_id_ul,$user_id_pt,$user_id_sr);

//Pętla główna - czytaj pytania
$table = ""; $create_date = $dzisiaj; $area_id = ""; $status = ""; $audit_date = ""; $audit_from = ""; $audit_to = ""; $audit_user = ""; $dsc = "";
$plant_name = ""; $file_lists10 = ""; $user_leader_id = ""; $table_data = ""; $table_task_data = ""; $check_dsc = ""; $audit_dsc = ""; $rt_id = "";
$create_user_le = $user_id_le; $create_user_fe = $user_id_fe; $status_show = $txt_td_018; $name = "";
$input_add_task = ""; $not_more_like = "";
$create_date = $dzisiaj; $end_date = ""; $end_week = ""; $order_nr = ""; $accept_type_id = ""; $accept_cost = ""; $expiration_date = ""; $barcode = "";
$manufacturer_box_info = ""; $print_quality = ""; $extra_dsc = ""; $orginal_order_dsc = ""; $version_dsc = ""; $order_type = ""; $cliche_cost = "";
$dctool_cost = ""; $order_qty1 = ""; $tolerant = ""; $print_type = ""; $not_less = ""; $new_dctool = ""; $new_grafic = "";
$print_machine_id = "2"; $print_machine_name = "Roland";
$awers_cmyk_qty_colors = "0"; $awers_pms_qty_colors = "0"; $awers_pms_sqmm = "100"; $awers_pms_colors = "";
$rewers_cmyk_qty_colors = "0"; $rewers_pms_qty_colors = "0"; $rewers_pms_sqmm = "100"; $rewers_pms_colors = ""; $product_paper_cost_m22 = "0.00";
$product_paper_id1 = ""; $product_paper_id2 = ""; $product_paper_value1 = ""; $product_paper_value2 = ""; $product_paper_cost_kg1 = "0.00"; $product_paper_cost_kg2 = "0.00";
$varnish_type_id = ""; $varnish_sqm_ark = ""; $varnish_uv_type_id = ""; $varnish_uv_sqm_ark = ""; $outsourcing_type_id = "";
$ink_varnish_id = ""; $ink_varnish_cost = "0.00"; $ink_varnish_dsc = ""; $ink_varnish_sqm_ark = ""; $foil_type_id = ""; $foil_sqm_ark = "";
$gilding_type = ""; $gilding_sqcm_box = ""; $gilding_foil_cost_sqm = "0.00"; $gilding_sqcm_matryc = ""; $gilding_qty_matryc = ""; $gilding_matryc_cost = "0.00"; $gilding_work_cost = "0.00";
$gilding_qty_point = "";
$laminating_cost_sqm = "0.00"; $laminating_x2 = ""; $window_glue_cost_box = "0.00"; $biga_cost_box = "0.00"; $falc_cost_box = "0.00"; $falc_cost = "0.00";
$cost_glue_box = "0.00"; $cost_glue_total = '0.00'; $glue_type_id = ""; $glue_automat_type_id=''; $stample_cost = "0.00"; $stample_cost_box = "0.00"; $transport_type_id = ""; $transport_km = ""; $transport_palet = ""; $transport_palet_weight = ""; $transport_dsc = "";
$cost_awers = "0.00"; $cost_rewers = "0"; $cost_varnish = "0.00"; $cost_varnish_material = "0.00"; $cost_varnish_uv = "0.00"; $cost_varnish_uv_material = "0.00";
$cost_foil = "0.00"; $cost_falc = "0.00"; $cost_bigowanie = "0.00"; $cost_window = "0.00"; $cost_stample = "0.00"; $extra_cost = "";
$cost_glue = "0.00"; $cost_other1 = "0.00"; $cost_other2 = "0.00"; $cost_extra = "0.00"; $cost_transport = "0.00";
$sheetx1 = "0"; $sheety1 = "0"; $sheetx2 = "0"; $sheety2 = "0"; $gram1 = "0"; $gram2 = "0"; $cost_ink_varnish_special_material = "0.00"; $cost_ink_varnish_special_operation = "0.00";
$cost_matryc1 = "0.00"; $cost_matryc2 = "0.00"; $cost_matryc3 = "0.00"; $cost_matryc4 = "0.00"; $cost_dcting = "0.00";
$cost_matryc1_prod = "0.00"; $cost_matryc2_prod = "0.00"; $cost_matryc3_prod = "0.00"; $cost_matryc4_prod = "0.00"; $cost_laminating = "0.00";
$cost_matryc1_setup = "0.00"; $cost_matryc2_setup = "0.00"; $cost_matryc3_setup = "0.00"; $cost_matryc4_setup = "0.00";
$cost_matryc1_total = "0.00"; $cost_matryc2_total = "0.00"; $cost_matryc3_total = "0.00"; $cost_matryc4_total = "0.00";
$cost_paper1 = "0.00"; $cost_paper2 = "0.00"; $cost_margin = "0.00"; $cost_bep = "0.00"; $cost_prowizja7 = "0.00"; $cost_prowizja10 = "0.00"; $cost_prowizja15 = "0.00";
$cost_total_material = "0.00"; $cost_total_operation = "0.00"; $cost_bep_one = "0.0000"; $cost_2_5 = "0.00"; $cost_total_out = "0.00"; $cost_transport_to_out = "0.00";
$cost_sales = "0.00"; $cost_sales_one = "0.00"; $cost_margin_1_3 = "0.00"; $cost_goods = "0.00";

// BEGIN define manual separation variables
  $cost_manual_work = "0.00";
  $cost_manual_work_real = "0.00";
  $cost_manual_work_info = "";
  $cost_manual_work_jazda_real = "0.00";
  $cost_manual_work_idle_real = "0.00";
  $cost_manual_work_jazda_info = "";
  $cost_manual_work_idle_info = "";

  $separationToolingTypeID="";
  $separationToolingStatusID="";

  $separationWindowStripping="";
  $manualWindowStripping_no="";
  $manualWindowStripping_yes="";

  $separationSetupInfo="";
  $separationSetupRealCosts="0.00";
  $separationSetupTotalCosts ="0.00";

  $cost_manual_work_prod_time=0; // manual separation time
  $separationSetupTime=0;
  $separationRunTime=0;
  $separationIdleTime=0;
  $separationTotalTime=0;

  $separationToolingList="";
  $separationProcessTypeList="";
  $separationToolingStatusList ="";
  $separationToolingCost ="";
  $separationToolingInvoicingList="";

// END define manual separation variables

// BEGIN defining throughput calculation variables
  $throughput = "0.00";
  $throughput_threshold="0.00";
  $throughput_info = "";

  $throughput_unit = "0.00";
  $throughput_unit_threshold="0.00";

  $TVC = "0.00";
  $TVC_unit="0.00";
  $TVC_info ="";

  $throughput_comission = "0.00";
  $throughput_comission_percent="0.00";
  $throughput_comission_info = "0.00";

  $throughput_threshold_fixed="0.00";
  $throughput_threshold_fixed_per_sheet="0.00";

  $throughput_to_sales ="0.00";
  $throughput_to_sales_threshold ="0.00";
  $throughput_to_sales_warningLevel="0.00";

  $throughput_per_labour ="0.00";
  $throughput_per_labour_threshold="0.00";
  $throughput_per_labour_warningLevel="0.00";

  $totalOperationTime = "00:00";
// END defining throughput calculation variables

$cost_margin_unit = 0;


$cost_accept= "0.00";
$cost_awers_material = "0.00"; $cost_rewers_material = "0.00"; $cost_gilding_material = "0.00"; $cost_gilding = "0.00"; $cost_dicut = "0.00";
$td_show_1 = "none"; $td_show_2 = "none"; $td_show_laminaing = "none"; $window_foil_sqm = ""; $file_all = ""; $back_order_dsc = "";

IF ($oc_id) {
          $sql = "SELECT status, create_user, create_date, end_date, name, dsc, oc_id_main, order_nr, netQty, grossQty
                  FROM order_calculations
                  WHERE oc_id='$oc_id' "; //echo "$sql<BR>";
          $result = @mysql_query($sql, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_show.php -> show -> READ order_calculation_list]<BR>$sql");
            while ($row = mysql_fetch_array($result)) {
              $create_date        = $row['create_date'];
              $end_date           = $row['end_date'];
              $create_user        = $row['create_user'];
              $order_nr           = $row['order_nr'];
              $name               = $row['name'];
              $status             = $row['status'];
              $dsc                = $row['dsc'];
              $oc_id_main         = $row['oc_id_main'];
              $netQty             = $row['netQty'];
              $grossQty           = $row['grossQty'];
          }

          $setupQty = $grossQty- $netQty; // calculate the qty needed to for setup to display on screen

          ReadUser($connection,$create_user,$create_user_fe,$create_user_le,$t,$t,$t,$t);
          $status_show = ReadOrderCalculationStatuses($connection,$status,"order_calculations",$lang_id);

          IF ($oc_id_main) {///edycja lub tworzenie wersji konieczna zmiana przejścia
              header( "Location: $serwer_type$serwer/system/order_calculation_show_qty.php?action=show&oc_id=$oc_id_main&back=$back&error=new_version" ); exit;
          }
          $sql2 = "SELECT var,value
                  FROM order_calculation_datas
                  WHERE oc_id='$oc_id' AND status>'0'"; //echo "$sql<BR>";
          $result2 = @mysql_query($sql2, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_show.php -> show -> READ order_calculation_datas]<BR>$sql");
            while ($row2 = mysql_fetch_array($result2)) {
              $var         = $row2['var'];
              $value       = $row2['value'];
              // convert operation times read from db from decimals into hh:mm on the fly
              $$var        = convertTimeValueToHHMM($var,$value); // populate variable table with variables named like var and holding values from value field
              //echo "$$var -> $value<BR>";
          }


          //odczyt plików
          $sql_file = "SELECT file_id, file_name, file_load, status
                       FROM order_calculation_files
                       WHERE oc_id='$oc_id' AND status>'0' AND status<'100'
                       ORDER BY file_id ASC"; //echo "$sql_tf<BR>";
          $result_file = @mysql_query($sql_file, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_show.php -> show -> SELECT files]");
            while ($row_file = mysql_fetch_array($result_file)) {
                   $file_id      = $row_file['file_id'];
                   $file_names   = $row_file['file_name'];
                   $file_status  = $row_file['status'];
                   $file_load    = $row_file['file_load'];

                   $rozszerzenie = FindExt($file_names);
                   $ico = FindIco($rozszerzenie);
                   $link = $sciezka . substr($file_id,0,6) ."/". $file_id . $rozszerzenie;
                   IF ($file_load) { $link = $file_load ."/". $file_names; }

                   $file_lists = "<A href=\"$link\" target=_blank style=\"text-decoration: none;\"><IMG SRC=\"./icon/$ico\" width=12 border=0> $file_names</A>";
                   //echo "$file_id -- $file_name<BR>";
                   IF (($status > 0) && ($status < 100)) { $file_lists .= "&nbsp;&nbsp;<A href=\"order_calculation_show.php?action=del_file&oc_id=$oc_id&file_id=$file_id&back=order_calculation_show\" style=\"text-decoration: none;\"><IMG SRC=\"./icon/del.gif\" width=12 border=0></A>"; }
                   $file_lists .= "<BR>";
                   switch ($file_status) {
                      case "10": $file_lists10 .= $file_lists; break;
                      case "30": $file_lists30 .= $file_lists; break;
                      case "60": $file_lists60 .= $file_lists; break;
                   }
                   //$file_all .= $file_lists;
          }
          mysql_free_result($result_file);
          $file_all .= $file_lists10;
}

//$status7301 = ""; CheckAccessToMenu($connection,$userlevel_id,"12_3_0_1",$status7301);


///pokaż uwagi
$show_error = ""; $table_data_error = "";
IF ($error) {
    switch ($error) {
      case "do_edit":
            $txt_text_0011 = $OCLangDict['txt_text_0011'][$lang_id];
            $show_error = "<DIV class=warning>$txt_text_0011</DIV>";
      break;
      case "wrong_date":
            $txt_text_0008 = $OCLangDict['txt_text_0008'][$lang_id];
            $show_error = "<DIV class=error>$txt_text_0008</DIV>";
      break;
      case "wrong_date2":
            $txt_text_0008 = $OCLangDict['txt_text_0008'][$lang_id];
            $show_error = "<DIV class=error>$txt_text_0008</DIV>";
      break;
      case "file_size":
            $txt_text_0010 = $OCLangDict['txt_text_0010'][$lang_id];
            $show_error = "<DIV class=error>$txt_text_0010</DIV>";
      break;
      case "audit_delate":
            $txt_text_0013 = $OCLangDict['txt_text_0013'][$lang_id];
            $show_error = "<DIV class=error>$txt_text_0013</DIV>";
      break;

    }
}


//przygotuj MENU (w zależności od operatorów)
//$menu_left = MenuLeftShow($connection,$user_id,$lang_id,$userlevel,$menu_value);

$table_log = ""; $input_logi = "";
IF (isset($_GET['oc_id'])) {
    IF (isset($_GET['history'])) {
        //tabela logów
        $txt_td_025       = $OCLangDict["txt_td_025"][$lang_id];
        $txt_td_024       = $OCLangDict["txt_td_024"][$lang_id];
        $txt_td_026       = $OCLangDict["txt_td_026"][$lang_id];
        $txt_history_01   = $OCLangDict["txt_history_01"][$lang_id];
        $txt_history_03   = $OCLangDict["txt_history_03"][$lang_id];
        SelectOrderCalculationLogs($connection,$txt_td_024,$txt_td_023,$txt_td_025,$txt_td_026,"1","order_calculations",$oc_id,"ASC",$table_log);
        $table_log = "<DIV class=tytul14red_line>$txt_history_01</DIV>".$table_log;
        $input_logi = "<A href=\"order_calculation_show.php?action=show&oc_id=$oc_id&back=$back\" style=\"text-decoration: none;\">$txt_history_03</A> &nbsp;&nbsp;&nbsp;";
    } else {
        $txt_history_02       = $OCLangDict["txt_history_02"][$lang_id];
        $input_logi = "<A href=\"order_calculation_show.php?action=show&oc_id=$oc_id&back=$back&history=show\" style=\"text-decoration: none;\">$txt_history_02</A> &nbsp;&nbsp;&nbsp;";
    }
}

$customer_name=""; IF ($customer_id) { FindOrderCalculationTableDatas($connection,"name","","","customer_id='$customer_id'","customers",$customer_name,$v2,$v3); }
IF ($not_less) { $not_less = $txt_td_160; }
$accept_type_show = ""; IF ($accept_type_id) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$accept_type_id'","order_calculation_print_accept_types",$accept_type_show,$v2,$v3); }
switch ($manufacturer_box_info) {
  case "yes": $manufacturer_box_info = "tak"; break;
  case "no" : $manufacturer_box_info = "nie"; break;
  case ""   : $manufacturer_box_info = "-"; break;
}
switch ($print_type) {
  case "rewers"   : $print_type_name = $txt_td_052; break;
  case "no_print" : $print_type_name = $txt_td_053; break;
  case ""         : $print_type_name = "-"; break;
}
// Populate dropdowns for die cutting information
  $dieCuttingToolingList  = fillCalculationDropdowns(0,1,1,$dieCuttingToolingTypeID,$txt_check_01);
  $dieCuttingToolingStatusList  = fillCalculationDropdowns(0,1,4,$dieCuttingToolingStatusID,$txt_check_01);
  $dieCuttingToolingInvoicingList  = fillCalculationDropdowns(0,1,9,$dieCuttingToolingInvoicingID,$txt_check_01);
// Populate dropdowns for stripping information
  $strippingToolingList  = fillCalculationDropdowns(0,1,2,$strippingToolingTypeID,$txt_check_01);
  $strippingToolingStatusList  = fillCalculationDropdowns(0,1,4,$strippingToolingStatusID,$txt_check_01);
  $strippingToolingInvoicingList  = fillCalculationDropdowns(0,1,9,$strippingToolingInvoicingID,$txt_check_01);
// Populate dropdowns for separation information
  $separationToolingList  = fillCalculationDropdowns(0,6,3,$separationToolingTypeID,$txt_check_01);
  $separationToolingStatusList  = fillCalculationDropdowns(0,6,4,$separationToolingStatusID,$txt_check_01);
  $separationToolingInvoicingList  = fillCalculationDropdowns(0,6,9,$separationToolingInvoicingID,$txt_check_01);
// Populate dropdowns for order type
  $list_order_types   = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_product_types",$order_type_id,"",$txt_check_01,$lang_id);

$new_dctool_name = "";
switch ($new_dctool) {
   case ""     : $new_dctool_name = "-"; break;
   case "new"  : $new_dctool_name = "nowy"; break;
   case "old"  : $new_dctool_name = "istniejący"; break;
   case "brak" : $new_dctool_name = "brak"; break;
}
$new_grafic_name = "";
switch ($new_grafic) {
   case ""     : $new_grafic_name = "-"; break;
   case "new"  : $new_grafic_name = "nowa"; break;
   case "old"  : $new_grafic_name = "istniejąca"; break;
   case "brak" : $new_grafic_name = "brak"; break;
}


// create raw material 1 info string
$rawMaterial1InfoString = "";
if ($product_paper_id1) {
  $rawMaterial1InfoString = ReadOrderCalculationProduct($connection,$product_paper_id1,$lang_id);
} else {
  // define and zeroout variables
  $paper_id1_name = ""; 
  $paper_gram_id1_name = "";
  if ($paper_id1) {
    $rawMaterial1InfoString = createRawMaterialInfoString ($oc_id,'rawMaterial1');
  }
}

// create raw material 2 info string

$rawMaterial2InfoString = ""; /**/
if ($product_paper_id2) {
  $rawMaterial2InfoString = ReadOrderCalculationProduct($connection,$product_paper_id2,$lang_id);
} else {
  // define and zeroout variables
  $paper_id2_name = ""; 
  $paper_gram_id2_name = "";
  if ($paper_id2) {
    $rawMaterial2InfoString = createRawMaterialInfoString ($oc_id,'rawMaterial2');
  }
}

$table_data = ""; 

$table_data .= "<TABLE class=tekst11 width=980 cellspacing=1 cellpadding=1 style=\"margin-top: 10px\">
        <TR>
            <TD class=td2tableC $sl5 colspan=5>SUROWCE PRODUKCYJNE</TD>
        </TR>";
// RAW MATERIAL 1 SECTION
if ($rawMaterial1InfoString) {
  $table_data .= "
        <!-- BEGIN Section on RAW MATERIAL 1 Data -->
        <TR>
          <TD colspan = 4 class=td0010 $sl5>
            <SPAN STYLE=\"font-size: 14;\">
              <B>$txt_td_056</B>
            </SPAN>
            <BR>
            $rawMaterial1InfoString
            &nbsp;&nbsp;
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_079:</SPAN>
              &nbsp;&nbsp;
              $product_paper_value1
              &nbsp;&nbsp; 
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_078:</SPAN>
              $product_paper_cost_kg1
              &nbsp;&nbsp;
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_134</SPAN>
              $product_paper_narzut_proc1&nbsp;[%]
            <BR><BR>
            <label>Ilość brutto:</label>
            <SPAN> $grossQty &nbsp;[ark]</SPAN> 
            &nbsp;&nbsp;
            <label>Ilość netto:</label>
            <SPAN> $netQty &nbsp;[ark]</SPAN> 
            &nbsp;&nbsp;
            <label>Waga brutto:</label>
            <SPAN> $paper1_weight &nbsp;[kg]</SPAN> 
            &nbsp;&nbsp;
            <label>Waga netto:</label>
            <SPAN> $rawMaterial1_NetKG &nbsp;[kg]</SPAN> 
            &nbsp;&nbsp;
        </TD>
        </TR>
        <!-- END Section on RAW MATERIAL 1 Data -->";
}  
/// RAW MATERIAL 2 SECTION
if ($rawMaterial2InfoString) { 
      $table_data .= "
        <!-- BEGIN Section on RAW MATERIAL 2 Data -->         
        <TR >
          <TD class=td0010 $sl5 colspan=4>
            <SPAN STYLE=\"font-size: 14;\"><B>$txt_td_057</B></SPAN>
            <BR>
            $rawMaterial2InfoString
            &nbsp;&nbsp;
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_079:</SPAN>
            &nbsp;&nbsp;
            $product_paper_value2
            &nbsp;&nbsp; 
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_078:</SPAN>
            $product_paper_cost_kg2
            &nbsp;&nbsp;
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_084:</SPAN>
            &nbsp;&nbsp;
            $product_paper_cost_m22
            &nbsp;&nbsp;
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_134</SPAN>
            $product_paper_narzut_proc2&nbsp;[%]
            <BR><BR>
            <label>Pow.brutto:</label>
            <SPAN> $paper2_m2 &nbsp;[m<SUP>2</SUP>]</SPAN> 
            &nbsp;&nbsp;
            <label>Pow.netto:</label>
            <SPAN>$rawMaterial2_NetSQM&nbsp;[m<SUP>2</SUP>]</SPAN>
            &nbsp;&nbsp;
            <label>Waga brutto:</label>
            <SPAN>$paper2_weight&nbsp;[kg]</SPAN>
            &nbsp;&nbsp;
            <label>Waga netto:</label>
            <SPAN>$rawMaterial2_NetKG&nbsp;[kg]</SPAN>
            &nbsp;&nbsp;
            
          </TD>
        </TR> 
        <!-- END Section on RAWM MATERIAL 2 Data -->";
}
// Below section checks for printing details and displays data on screen
IF (($awers_cmyk_qty_colors) || ($awers_pms_qty_colors)) {
  $table_data .= "
                  <TR>
                      <TD class=td2tableC $sl5 colspan=5>$txt_td_049</TD>
                  </TR>
                  <TR >
                  <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_080 $txt_td_054</SPAN><BR>$awers_cmyk_qty_colors</TD>
                  <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_081</SPAN><BR>$awers_pms_qty_colors</TD>
                  <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_082</SPAN><BR>$awers_pms_sqmm&nbsp;[%]</TD>
                  <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_083</SPAN><BR>$awers_pms_colors</TD>
                  <TD class=td0000 $sl5 >$print_machine_name&nbsp;</TD>
              </TR>";
}
IF (($rewers_cmyk_qty_colors) || ($rewers_pms_qty_colors)) {
  $table_data .= "<TR >
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_080 $txt_td_055</SPAN><BR>$rewers_cmyk_qty_colors</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_081</SPAN><BR>$rewers_pms_qty_colors</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_082</SPAN><BR>$rewers_pms_sqmm&nbsp;[%]</TD>
                  <TD class=td0010 $sl5 colspan=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_083</SPAN><BR>$rewers_pms_colors</TD>
              </TR>";
}
IF ($varnish_type_id) {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$varnish_type_id'","order_calculation_varnish_types",$varnish_type_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_058</TD>
                  <TD class=td0010 $sl5>$varnish_type_show</TD>
                  <TD class=td0010 $sl5 colspan=3>&nbsp;</TD>
              </TR>";
}
IF (($awers2_cmyk_qty_colors) || ($awers2_pms_qty_colors)) {
  $table_data .= "<TR >
                  <TD class=td0000 $sl5 >
                    <SPAN STYLE=\"font-size: $size_span;\">$txt_td_080 $txt_td_054 II</SPAN>
                    <BR>$awers2_cmyk_qty_colors
                  </TD>
                  <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_081</SPAN><BR>$awers2_pms_qty_colors</TD>
                  <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_082</SPAN><BR>$awers2_pms_sqmm&nbsp;[%]</TD>
                  <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_083</SPAN><BR>$awers2_pms_colors</TD>
                  <TD class=td0000 $sl5 >$print2_machine_name&nbsp;</TD>
              </TR>";
}
IF (($rewers2_cmyk_qty_colors) || ($rewers2_pms_qty_colors)) {
  $table_data .= "<TR >
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_080 $txt_td_055 II</SPAN><BR>$rewers2_cmyk_qty_colors</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_081</SPAN><BR>$rewers2_pms_qty_colors</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_082</SPAN><BR>$rewers2_pms_sqmm&nbsp;[%]</TD>
                  <TD class=td0010 $sl5 colspan=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_083</SPAN><BR>$rewers2_pms_colors</TD>
              </TR>";
}
IF ($varnish2_type_id) {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$varnish2_type_id'","order_calculation_varnish_types",$varnish2_type_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_058 II</TD>
                  <TD class=td0010 $sl5>$varnish2_type_show</TD>
                  <TD class=td0010 $sl5 colspan=3>&nbsp;</TD>
              </TR>";
}
IF ($ink_varnish_id) {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$ink_varnish_id'","order_calculation_ink_varnish",$ink_varnish_show,$v2,$v3);
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$ink_varnish_type_id'","order_calculation_ink_varnish_types",$ink_varnish_type_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_061</TD>
                  <TD class=td0010 $sl5>$ink_varnish_show</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_059</SPAN><BR>$ink_varnish_sqm_ark</TD>
                  <TD class=td0010 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_152</SPAN><BR>$ink_varnish_type_show</TD>
                  <TD class=td0010 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_061</SPAN><BR>$ink_varnish_dsc</TD>
              </TR>";
}
IF ($foil_type_id) {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$foil_type_id'","order_calculation_foil_types",$foil_type_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_064</TD>
                  <TD class=td0010 $sl5>$foil_type_show</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_085</SPAN><BR>$foil_sqm_ark</TD>
                  <TD class=td0010 $sl5 colspan=2>&nbsp;</TD>
              </TR>";
}
IF (($cost_gilding) || ($cost_gilding_material)) {
  IF ($gilding_box1 == "1") { $gilding_box1_checked = "checked";
      $gilding_speed_id_show = ""; IF ($gilding_speed_id1) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_speed_id1'","order_calculation_gilding_speeds",$gilding_speed_id_show,$v2,$v3); }
      $gilding_type_id_show = ""; IF ($gilding_type_id1) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_type_id1'","order_calculation_gilding_types",$gilding_type_id_show,$v2,$v3); }
      $gilding_sqmm_id_show = ""; IF ($gilding_sqmm_id1) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_sqmm_id1'","order_calculation_gilding_sqmm",$gilding_sqmm_id_show,$v2,$v3); }
      $gilding_foil_cost_sqm = $gilding_foil_cost_sqm1;
      //$gilding_sqcm_matryc = $gilding_sqcm_matryc1;
      $gilding_sqcm_matryc = $gilding_sqcm_matryc1x ."x".$gilding_sqcm_matryc1y;
      $gilding_qty_matryc = $gilding_qty_matryc1;
      //$gilding_qty_point = $gilding_qty_point1;
      $gilding_jump_id_show = ""; IF ($gilding_jump_id1) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_jump_id1'","order_calculation_gilding_jumps",$gilding_jump_id_show,$v2,$v3); }
      $cost_matryc = $cost_matryc1;
      $cost_matryc_prod = $cost_matryc1_prod;
      $cost_matryc_setup = $cost_matryc1_setup;
      $cost_matryc_total = $cost_matryc1_total;

      $table_data .= "
                  <TR >
                      <TD class=td2tableL rowspan=3>$txt_td_065<BR>1 przelot</TD>
                      <TD class=td0000 $sl5>$gilding_speed_id_show</TD>
                      <TD class=td0000 $sl5>$gilding_type_id_show</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_086</SPAN><BR>$gilding_sqmm_id_show</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_087</SPAN><BR>$gilding_foil_cost_sqm</TD>
                  </TR>";
      $table_data .= "
                  <TR >
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_088</SPAN><BR>$gilding_sqcm_matryc</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_089</SPAN><BR>$gilding_qty_matryc</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_108</SPAN><BR>$gilding_jump_id_show</TD>
                      <TD class=td0000 $sl5>&nbsp;</TD>
                  </TR>";
      $table_data .= "
                  <TR >
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_110</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1   id=cost_matryc1    VALUE=\"$cost_matryc\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_111</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_prod   id=cost_matryc1_prod    VALUE=\"$cost_matryc_prod\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_112</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_setup   id=cost_matryc1_setup    VALUE=\"$cost_matryc_setup\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_113</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_total   id=cost_matryc1_total    VALUE=\"$cost_matryc_total\" TYPE=text></TD>
                  </TR>";

  }
  IF ($gilding_box2 == "2") { $gilding_box2_checked = "checked";
      $gilding_speed_id_show = ""; IF ($gilding_speed_id2) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_speed_id2'","order_calculation_gilding_speeds",$gilding_speed_id_show,$v2,$v3); }
      $gilding_type_id_show = ""; IF ($gilding_type_id2) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_type_id2'","order_calculation_gilding_types",$gilding_type_id_show,$v2,$v3); }
      $gilding_sqmm_id_show = ""; IF ($gilding_sqmm_id2) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_sqmm_id2'","order_calculation_gilding_sqmm",$gilding_sqmm_id_show,$v2,$v3); }
      $gilding_foil_cost_sqm = $gilding_foil_cost_sqm2;
      //$gilding_sqcm_matryc = $gilding_sqcm_matryc2;
      $gilding_sqcm_matryc = $gilding_sqcm_matryc2x ."x".$gilding_sqcm_matryc2y;
      $gilding_qty_matryc = $gilding_qty_matryc2;
      //$gilding_qty_point = $gilding_qty_point2;
      $gilding_jump_id_show = ""; IF ($gilding_jump_id2) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_jump_id2'","order_calculation_gilding_jumps",$gilding_jump_id_show,$v2,$v3); }
      $cost_matryc = $cost_matryc2;
      $cost_matryc_prod = $cost_matryc2_prod;
      $cost_matryc_setup = $cost_matryc2_setup;
      $cost_matryc_total = $cost_matryc2_total;

      $table_data .= "
                  <TR >
                      <TD class=td2tableL rowspan=3>$txt_td_065<BR>$gilding_qty2 przeloty</TD>
                      <TD class=td0000 $sl5>$gilding_speed_id_show</TD>
                      <TD class=td0000 $sl5>$gilding_type_id_show</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_086</SPAN><BR>$gilding_sqmm_id_show</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_087</SPAN><BR>$gilding_foil_cost_sqm</TD>
                  </TR>";
      $table_data .= "
                  <TR >
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_088</SPAN><BR>$gilding_sqcm_matryc</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_089</SPAN><BR>$gilding_qty_matryc</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_108</SPAN><BR>$gilding_jump_id_show</TD>
                      <TD class=td0000 $sl5>&nbsp;</TD>
                  </TR>";
      $table_data .= "
                  <TR >
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_110</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1   id=cost_matryc1    VALUE=\"$cost_matryc\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_111</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_prod   id=cost_matryc1_prod    VALUE=\"$cost_matryc_prod\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_112</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_setup   id=cost_matryc1_setup    VALUE=\"$cost_matryc_setup\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_113</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_total   id=cost_matryc1_total    VALUE=\"$cost_matryc_total\" TYPE=text></TD>
                  </TR>";

  }
  IF ($gilding_box3 == "3") { $gilding_box3_checked = "checked";
      $gilding_speed_id_show = ""; IF ($gilding_speed_id3) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_speed_id3'","order_calculation_gilding_speeds",$gilding_speed_id_show,$v2,$v3); }
      $gilding_type_id_show = ""; IF ($gilding_type_id3) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_type_id3'","order_calculation_gilding_types",$gilding_type_id_show,$v2,$v3); }
      $gilding_sqmm_id_show = ""; IF ($gilding_sqmm_id3) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_sqmm_id3'","order_calculation_gilding_sqmm",$gilding_sqmm_id_show,$v2,$v3); }
      $gilding_foil_cost_sqm = $gilding_foil_cost_sqm3;
      //$gilding_sqcm_matryc = $gilding_sqcm_matryc3;
      $gilding_sqcm_matryc = $gilding_sqcm_matryc3x ."x".$gilding_sqcm_matryc3y;
      $gilding_qty_matryc = $gilding_qty_matryc3;
      //$gilding_qty_point = $gilding_qty_point3;
      $gilding_jump_id_show = ""; IF ($gilding_jump_id3) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_jump_id3'","order_calculation_gilding_jumps",$gilding_jump_id_show,$v2,$v3); }
      $cost_matryc = $cost_matryc3;
      $cost_matryc_prod = $cost_matryc3_prod;
      $cost_matryc_setup = $cost_matryc3_setup;
      $cost_matryc_total = $cost_matryc3_total;

      $table_data .= "
                  <TR >
                      <TD class=td2tableL rowspan=3>$txt_td_065<BR>$gilding_qty3 przeloty</TD>
                      <TD class=td0000 $sl5>$gilding_speed_id_show</TD>
                      <TD class=td0000 $sl5>$gilding_type_id_show</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_086</SPAN><BR>$gilding_sqmm_id_show</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_087</SPAN><BR>$gilding_foil_cost_sqm</TD>
                  </TR>";
      $table_data .= "
                  <TR >
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_088</SPAN><BR>$gilding_sqcm_matryc</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_089</SPAN><BR>$gilding_qty_matryc</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_108</SPAN><BR>$gilding_jump_id_show</TD>
                      <TD class=td0000 $sl5>&nbsp;</TD>
                  </TR>";
      $table_data .= "
                  <TR >
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_110</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1   id=cost_matryc1    VALUE=\"$cost_matryc\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_111</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_prod   id=cost_matryc1_prod    VALUE=\"$cost_matryc_prod\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_112</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_setup   id=cost_matryc1_setup    VALUE=\"$cost_matryc_setup\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_113</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_total   id=cost_matryc1_total    VALUE=\"$cost_matryc_total\" TYPE=text></TD>
                  </TR>";
  }
  IF ($gilding_box4 == "4") { $gilding_box4_checked = "checked";
      $gilding_speed_id_show = ""; IF ($gilding_speed_id4) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_speed_id4'","order_calculation_gilding_speeds",$gilding_speed_id_show,$v2,$v3); }
      $gilding_type_id_show = ""; IF ($gilding_type_id4) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_type_id4'","order_calculation_gilding_types",$gilding_type_id_show,$v2,$v3); }
      $gilding_sqmm_id_show = ""; IF ($gilding_sqmm_id4) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_sqmm_id4'","order_calculation_gilding_sqmm",$gilding_sqmm_id_show,$v2,$v3); }
      $gilding_foil_cost_sqm = $gilding_foil_cost_sqm4;
      //$gilding_sqcm_matryc = $gilding_sqcm_matryc4;
      $gilding_sqcm_matryc = $gilding_sqcm_matryc4x ."x".$gilding_sqcm_matryc4y;
      $gilding_qty_matryc = $gilding_qty_matryc4;
      //$gilding_qty_point = $gilding_qty_point4;
      $gilding_jump_id_show = ""; IF ($gilding_jump_id4) { FindOrderCalculationTableDatas($connection,"name","","","table_id='$gilding_jump_id4'","order_calculation_gilding_jumps",$gilding_jump_id_show,$v2,$v3); }
      $cost_matryc = $cost_matryc4;
      $cost_matryc_prod = $cost_matryc4_prod;
      $cost_matryc_setup = $cost_matry4_setup;
      $cost_matryc_total = $cost_matryc4_total;

      $table_data .= "
                  <TR >
                      <TD class=td2tableL rowspan=3>$txt_td_065<BR>$gilding_qty4 przeloty</TD>
                      <TD class=td0000 $sl5>$gilding_speed_id_show</TD>
                      <TD class=td0000 $sl5>$gilding_type_id_show</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_086</SPAN><BR>$gilding_sqmm_id_show</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_087</SPAN><BR>$gilding_foil_cost_sqm</TD>
                  </TR>";
      $table_data .= "
                  <TR >
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_088</SPAN><BR>$gilding_sqcm_matryc</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_089</SPAN><BR>$gilding_qty_matryc</TD>
                      <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_108</SPAN><BR>$gilding_jump_id_show</TD>
                      <TD class=td0000 $sl5>&nbsp;</TD>
                  </TR>";
      $table_data .= "
                  <TR >
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_110</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1   id=cost_matryc1    VALUE=\"$cost_matryc\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_111</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_prod   id=cost_matryc1_prod    VALUE=\"$cost_matryc_prod\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_112</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_setup   id=cost_matryc1_setup    VALUE=\"$cost_matryc_setup\" TYPE=text></TD>
                      <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_113</SPAN><BR><INPUT readonly CLASS=H2 NAME=cost_matryc1_total   id=cost_matryc1_total    VALUE=\"$cost_matryc_total\" TYPE=text></TD>
                  </TR>";
  }
}
IF ($varnish_uv_type_id) {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$varnish_uv_type_id'","order_calculation_varnish_uv_types",$varnish_uv_type_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_060</TD>
                  <TD class=td0010 $sl5>$varnish_uv_type_show</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_059</SPAN><BR>$varnish_uv_sqm_ark</TD>
                  <TD class=td0010 $sl5 colspan=2>&nbsp;</TD>
              </TR>";
}
IF (($laminating_type_id) && ($laminating_sqm_id)) {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$laminating_type_id'","order_calculation_kaszer_types",$laminating_type_show,$v2,$v3);
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$laminating_sqm_id'","order_calculation_kaszer_sqm",$laminating_sqm_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_066</TD>
                  <TD class=td0010 $sl5 COLSPAN=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_211</SPAN><BR>$laminating_type_show</TD>
                  <TD class=td0010 $sl5 COLSPAN=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_210</SPAN><BR>$laminating_sqm_show</TD>
              </TR>";
}
IF ($dctool_type_id) {
  // populate dropdowns for diecutting and stripping
    $dieCuttingProcessTypeList  = fillCalculationDropdowns(0,1,8,$dctool_type_id,$txt_check_01);
    $dieCuttingToolingList  = fillCalculationDropdowns(0,1,1,$dieCuttingToolingTypeID,$txt_check_01); //
    $strippingToolingList  = fillCalculationDropdowns(0,1,2,$strippingToolingTypeID,$txt_check_01);
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$dctool_type_id'","order_calculation_dctool_types",$dctool_type_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_069</TD>
                  <TD class=td0010 $sl5 colspan=1>
                  <SELECT NAME=dctool_type_id id=dctool_type_id CLASS=a STYLE=\"width: 250px; font-size: 10px;\" disabled>
                    $dieCuttingProcessTypeList
                  </SELECT>
              </TD>
                  
                  <TD class=td0010 $sl5 colspan=3>
                  <SPAN STYLE=\"font-size: $size_span;\">Narzędzia:</SPAN>
                  <select name='dieCuttingToolingTypeID' id='dieCuttingToolingTypeDropdown' class='a' style='width: 200px; font-size: 10px;' title='Wybierz narzędzia wycinania' disabled>
                    $dieCuttingToolingList
                  </select>
                  <select name='strippingToolingTypeID' id='strippingToolingTypeDropdown' class='a' style='width: 200px; font-size: 10px;' title='Wybierz narzędzia' disabled>
                    $strippingToolingList
                  </select>
                  
                  </TD>
              </TR>";
}
IF ($dctool2_type_id) {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$dctool2_type_id'","order_calculation_dctool_types",$dctool2_type_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_069 2</TD>
                  <TD class=td0010 $sl5 colspan=4>$dctool2_type_show</TD>
              </TR>";
}
IF ($biga_cost_box > "0") {
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_068</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR>$biga_cost_box</TD>
                  <TD class=td0010 $sl5>&nbsp;</TD>
                  <TD class=td0010 $sl5 colspan=2>&nbsp;</TD>
              </TR>";
}
IF (($falc_cost_box > "0") || ($falc_cost > "0")) {
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_067</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR>$falc_cost</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR>$falc_cost_box</TD>
                  <TD class=td0010 $sl5 colspan=2>&nbsp;</TD>
              </TR>";
}
IF (($stample_cost > "0") || ($stample_cost_box > "0")) {
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_071</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR>$stample_cost</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR>$stample_cost_box</TD>
                  <TD class=td0010 $sl5 colspan=2>&nbsp;</TD>
              </TR>";
}



if ($separationProcessTypeID) {
  // Populate dropdowns for separation
  $separationProcessTypeList  = fillCalculationDropdowns(0,6,10,$separationProcessTypeID,$txt_check_01);
  $separationToolingList  = fillCalculationDropdowns(0,6,3,$separationToolingTypeID,$txt_check_01);

  $table_data .= "
              <TR >
                  <TD class=td2tableL>Separacja: </TD>
                  <TD class=td0010 $sl5 colspan=1>
                    <SELECT NAME=separationProcessTypeID id=separationProcessType CLASS=a STYLE=\"width: 250px; font-size: 10px;\" disabled>
                      $separationProcessTypeList
                    </SELECT>
                  </TD>
                  <TD class=td0010 $sl5 colspan =3>
                    <SPAN STYLE=\"font-size: $size_span;\">Narzędzia: </SPAN>
                    <SELECT NAME=separationProcessTypeID id=separationProcessType CLASS=a STYLE=\"width: 200px; font-size: 10px;\" disabled>
                      $separationToolingList
                    </SELECT>
                  </TD>
                  <BR>$manual_work_window_show</TD>
                  <TD class=td0010 $sl5>&nbsp;</TD>
                  <TD class=td0010 $sl5 colspan=2>&nbsp;</TD>
              </TR>";
}

IF ($manual_work_window_id) {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$manual_work_window_id'","order_calculation_manual_work_windows",$manual_work_window_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_200</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_201</SPAN><BR>$manual_work_window_show</TD>
                  <TD class=td0010 $sl5>&nbsp;</TD>
                  <TD class=td0010 $sl5 colspan=2>&nbsp;</TD>
              </TR>";
}
IF ($window_glue_cost_box > "0") {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$window_foil_type_id'","order_calculation_window_foil_type",$window_foil_type_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_070</TD>
                  <TD class=td0010 $sl5 colspan=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR>$window_glue_cost_box</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_149</SPAN><BR>$window_foil_type_show</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_151</SPAN><BR>$window_foil_sqm</TD>
              </TR>";
}
IF ($glue_type_id) {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$glue_type_id'","order_calculation_glue_types",$glue_type_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_072</TD>
                  <TD class=td0010 $sl5>$glue_type_show</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR>$cost_glue_total</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR>$cost_glue_box</TD>
                  <TD class=td0010 $sl5 colspan=2>&nbsp;</TD>
              </TR>";
}
IF (($cost_glue_automat_total > "0") || ($cost_glue_automat_box > "0") || ($glue_automat_type_id > "0")) {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$glue_automat_type_id'","order_calculation_automatic_gluing_types",$glue_automat_type_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_208</TD>
                  <TD class=td0010 $sl5>$glue_automat_type_show</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR>$cost_glue_automat_total</TD>
                  <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR>$cost_glue_automat_box</TD>
                  <TD class=td0010 $sl5 colspan=2>&nbsp;</TD>
              </TR>";
}
IF ($operationTimeCorrection) {
  $table_data .= "
              <TR >
                  <TD class=td2tableL>Korekta czasów kalkulacji</TD>
                  <TD class=td0010 $sl5 colspan= 5>$operationTimeCorrectionInfo z powodu: <PRE>$operationTimeCorrectionDsc</PRE></TD>
              </TR>";
}
IF ($transport_type_id) {
  FindOrderCalculationTableDatas($connection,"name","","","table_id='$transport_type_id'","order_calculation_transport_types",$transport_type_show,$v2,$v3);
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_073</TD>
                  <TD class=td0010 $sl5>$transport_type_show
                        <BR><SPAN STYLE=\"font-size: $size_span;\">Waga zamówienia:</SPAN><BR>$order_total_weight&nbsp;[kg]</TD>
                  </TD>
                  <TD class=td0010 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_095</SPAN><BR>$transport_km&nbsp;[km]</TD>
                  <TD class=td0010 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_147</SPAN><BR>$transport_palet&nbsp;[palet]</TD>
                  <TD class=td0010 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_148</SPAN><BR>$transport_palet_weight&nbsp;[kg/paleta]</TD>
              </TR>";
}
$outsourcing_type_show = "";
$Osql = "SELECT table_id, name, status
         FROM order_calculation_outsourcing_types
         ORDER BY table_id ASC"; //echo "$sql<BR>";
$Oresult = @mysql_query($Osql, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_show.php -> show -> READ order_calculation_list]<BR>$Osql<BR>".mysql_error());
   while ($Orow = mysql_fetch_array($Oresult)) {
      $o_name        = $Orow['name'];
      $o_table_id    = $Orow['table_id'];
      $o_name_ = "outsorcing_type_".$o_table_id; $o_name_v = $$o_name_;
      if ($$o_name_ == "10") { $outsourcing_type_show .= $o_name.";&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}
}
IF ($outsourcing_type_show) {
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_077</TD>
                  <TD class=td0010 $sl5 colspan=4>$outsourcing_type_show</TD>
              </TR>
              ";
}
IF (($other1_dsc) || ($cost_other1 > "0")) {
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_074</TD>
                  <TD class=td0010 $sl5 colspan=2>$other1_dsc&nbsp;</TD>
                  <TD class=td0010 $sl5 colspan=2>
                      <SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR>$cost_other1_total
                      <BR><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR>$cost_other1_box</TD>
              </TR>";
}
IF (($other2_dsc) || ($cost_other2 > "0")) {
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_075</TD>
                  <TD class=td0010 $sl5 colspan=2>$other2_dsc&nbsp;</TD>
                  <TD class=td0010 $sl5 colspan=2>
                      <SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR>$cost_other2_total
                      <BR><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR>$cost_other2_box</TD>
              </TR>";
}
IF (($cost_extra_dsc) || ($cost_extra > "0")) {
  $table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_076</TD>
                  <TD class=td0010 $sl5 colspan=2>$cost_extra_dsc&nbsp;</TD>
                  <TD class=td0010 $sl5 colspan=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR>$cost_extra</TD>
              </TR>";
}
$input_add_file = "<A href=\"./order_calculation_show.php?action=add_file&oc_id=$oc_id&customer_id=$customer_id&name=$order_nr\" style=\"text-decoration: none;\"><BR>Załącz nowe pliki</A>";
IF ($status >= "100") { $input_add_file = ""; }
$table_data .= "
              <TR >
                  <TD class=td2tableL>$txt_td_114</TD>
                  <TD class=td0010 $sl5 colspan=4>$file_lists10&nbsp;$input_add_file</TD>
              </TR>
              ";

// Początek sekcji wyśtwietlającej obliczenia i wyniki obliczeń dla każdej z pozycji
$table_costs = ""; $input_costs = "";
IF (isset($_GET['oc_id'])) {
    IF ($option == "show_costs") {
        //tabela logów
          $table_costs = "
          <TABLE class=tekst9gr width=950 cellspacing=1 cellpadding=1 >
              <TR> 
                <TD width=190></TD> 
                <TD width=260></TD> 
                <TD width=260></TD> 
                <TD width=120></TD> 
                <TD width=120></TD> 
              </TR>
              <TR>
                <TD class='td2tableC header3Text' $sc colspan=5>ROZPISKA KOSZTÓW</TD>
              </TR>
              <TR>
                  <TD class='td2tableC header3Text' $sc colspan=5>KOSZTY MATERIAŁOWE</TD>
              <TR>
                  <TD class=td0011 $sl5 rowspan=2>SUROWIEC 1</TD>
              </TR>
              <TR>
                  <TD colspan = 3 class=td0010 $sl5>
                    <INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_paper1_info id=cost_paper1_info VALUE=\"$cost_paper1_info\">
                    <BR>
                    Ilość brutto:<INPUT TYPE=$input_hidden_type_view_info CLASS=H_info NAME=grossQty id=grossQty VALUE=\"$grossQty\">&nbsp;[ark]&nbsp;&nbsp;
                    Ilość netto:<INPUT TYPE=$input_hidden_type_view_info CLASS=H_info NAME=netQty id=netQty VALUE=\"$netQty\">&nbsp;[ark]&nbsp;&nbsp;
                    Waga brutto:<INPUT TYPE=$input_hidden_type_view_info CLASS=H_info NAME=paper1_weight id=paper1_weight VALUE=\"$paper1_weight\">&nbsp;[kg]&nbsp;&nbsp;
                    Waga netto:<INPUT TYPE=$input_hidden_type_view_info CLASS=H_info NAME=rawMaterial1_NetKG id=rawMaterial1_NetKG VALUE=\"$rawMaterial1_NetKG\">&nbsp;[kg]&nbsp;&nbsp;
                  </TD>
                  <TD class=td0110 $sr5>
                    Koszt brutto <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_paper1 id=cost_paper1 VALUE=\"$cost_paper1\">&nbsp;[PLN]
                  </TD>
              </TR>
              <TR>
                <TD class=td0011 $sl5>SUROWIEC 2</TD>
                <TD colspan =3 class=td0010 $sl5>
                  <INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_paper2_info id=cost_paper2_info VALUE=\"$cost_paper2_info\">
                  <BR>
                  <label>Pow.brutto:</label>
                  <INPUT TYPE=$input_hidden_type_view_info CLASS=H_info NAME=paper2_m2 id=paper2_m2 VALUE=\"$paper2_m2\">&nbsp;[m<SUP>2</SUP>]&nbsp;&nbsp;
                  <label>Pow.netto:</label>
                  <INPUT TYPE=$input_hidden_type_view_info CLASS=H_info NAME=rawMaterial2_NetSQM id=rawMaterial2_NetSQM VALUE=\"$rawMaterial2_NetSQM\">&nbsp;[m<SUP>2</SUP>]&nbsp;&nbsp;
                  <label>Waga brutto </label>
                  <INPUT TYPE=$input_hidden_type_view_info CLASS=H_info NAME=paper2_weight id=paper2_weight VALUE=\"$paper2_weight\">&nbsp;[kg]&nbsp;&nbsp;
                  <label>Waga netto </label>
                  <INPUT TYPE=$input_hidden_type_view_info CLASS=H_info NAME=rawMaterial2_NetKG id=rawMaterial2_NetKG VALUE=\"$rawMaterial2_NetKG\">&nbsp;[kg]&nbsp;&nbsp;
                </TD>
                <TD class=td0110 $sr5>
                  Koszt brutto <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_paper2 id=cost_paper2 VALUE=\"$cost_paper2\">&nbsp;[PLN]
                </TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Farby Awers</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_awers_material_info id=cost_awers_material_info VALUE=\"$cost_awers_material_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers_material id=cost_awers_material VALUE=\"$cost_awers_material\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Blachy Awers</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_awers_material_clicha_info id=cost_awers_material_clicha_info VALUE=\"$cost_awers_material_clicha_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers_material_clicha id=cost_awers_material_clicha VALUE=\"$cost_awers_material_clicha\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Farby Reswers</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_rewers_material_info id=cost_rewers_material_info VALUE=\"$cost_rewers_material_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers_material id=cost_rewers_material VALUE=\"$cost_rewers_material\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Blachy Reswers</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_rewers_material_clicha_info id=cost_rewers_material_clicha_info VALUE=\"$cost_rewers_material_clicha_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers_material_clicha id=cost_rewers_material_clicha VALUE=\"$cost_rewers_material_clicha\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Dodatkowe płyty</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_extra_plate_info id=cost_extra_plate_info VALUE=\"$cost_extra_plate_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_extra_plate id=cost_extra_plate VALUE=\"$cost_extra_plate\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Lakier offset</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_varnish_material_info id=cost_varnish_material_info ></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_varnish_material id=cost_varnish_material VALUE=\"$cost_varnish_material\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_3 style=\"display: none;\">
                  <TD class=td0011 $sl5>Farby Awers II</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_awers2_material_info id=cost_awers2_material_info VALUE=\"$cost_awers2_material_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers2_material id=cost_awers2_material VALUE=\"$cost_awers2_material\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_4 style=\"display: none;\">
                  <TD class=td0011 $sl5>Blachy Awers II</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_awers2_material_clicha_info id=cost_awers2_material_clicha_info VALUE=\"$cost_awers2_material_clicha_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers2_material_clicha id=cost_awers2_material_clicha VALUE=\"$cost_awers2_material_clicha\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_5 style=\"display: none;\">
                  <TD class=td0011 $sl5>Farby Reswers II</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_rewers2_material_info id=cost_rewers2_material_info VALUE=\"$cost_rewers2_material_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers2_material id=cost_rewers2_material VALUE=\"$cost_rewers2_material\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_6 style=\"display: none;\">
                  <TD class=td0011 $sl5>Blachy Reswers II</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_rewers2_material_clicha_info id=cost_rewers2_material_clicha_info VALUE=\"$cost_rewers2_material_clicha_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers2_material_clicha id=cost_rewers2_material_clicha VALUE=\"$cost_rewers2_material_clicha\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_15 style=\"display: none;\">
                  <TD class=td0011 $sl5>Dodatkowe płyty II</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_extra_plate2_info id=cost_extra_plate2_info VALUE=\"$cost_extra_plate2_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_extra_plate2 id=cost_extra_plate2 VALUE=\"$cost_extra_plate2\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_16 style=\"display: none;\">
                  <TD class=td0011 $sl5>Lakier offset II</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_varnish2_material_info id=cost_varnish2_material_info ></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_varnish2_material id=cost_varnish2_material VALUE=\"$cost_varnish2_material\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Lakierowanie UV</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_varnish_uv_material_info id=cost_varnish_uv_material_info ></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_varnish_uv_material id=cost_varnish_uv_material VALUE=\"$cost_varnish_uv_material\" >&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Folia HS</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_gilding_material_info id=cost_gilding_material_info VALUE=\"$cost_gilding_material_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_gilding_material  id=cost_gilding_material    VALUE=\"$cost_gilding_material\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Klej do kaszerowania</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_laminating_material_info id=cost_laminating_material_info VALUE=\"$cost_laminating_material_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_laminating_material  id=cost_laminating_material    VALUE=\"$cost_laminating_material\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Folia do wklejania okienek</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_window_foil_info id=cost_window_foil_info VALUE=\"$cost_window_foil_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_window_foil  id=cost_window_foil    VALUE=\"$cost_window_foil\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Suma</TD>
                  <TD class=td0010 $sl5 colspan=3>&nbsp;</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_total_material id=cost_total_material VALUE=\"$cost_total_material\">&nbsp;[PLN]</TD>
              </TR>


              <TR>
                <TD class=td2tableC $sc colspan=6>
                  Koszty operacyjne
                </TD>
              </TR>
              <TR>
                 <TD class=td2tableC $sc colspan=1>
                   Operacja
                 </TD>
                 <TD class=td2tableC $sc colspan=1>
                   Informacja o obliczeniach
                 </TD>
                 <TD class=times $sc colspan=1>
                   Czasy
                 </TD>
                 <TD class=td2tableC $sc colspan=1>
                   Koszty wydajności
                  </TD>
                 <TD class=td2tableC $sc colspan=1>
                   Koszty kalkulacji
                 </TD>
              </TR>

              <TR >
                  <TD class=td0011 $sl5>Gilotyna I jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_cut_jazda_info id=cost_cut_jazda_info VALUE=\"$cost_cut_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=cutterRunTime id=cutterRunTime  VALUE=\"$cutterRunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_cut_jazda_real  id=cost_cut_jazda_real  VALUE=\"$cost_cut_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Gilotyna I IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_cut_idle_info id=cost_cut_idle_info VALUE=\"$cost_cut_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=cutterIdleTime id=cutterIdleTime  VALUE=\"$cutterIdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_cut_idle_real  id=cost_cut_idle_real  VALUE=\"$cost_cut_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Gilotyna</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_cut_info id=cost_cut_info VALUE=\"$cost_cut_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold name=cutterTotalTime id=cutterTotalTime  VALUE=\"$cutterTotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_cut_real  id=cost_cut_real  VALUE=\"$cost_cut_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_cut       id=cost_cut       VALUE=\"$cost_cut\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Gilotyna II jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_cut2_jazda_info id=cost_cut2_jazda_info VALUE=\"$cost_cut2_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=cutter2RunTime id=cutter2RunTime  VALUE=\"$cutter2RunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_cut2_jazda_real  id=cost_cut2_jazda_real  VALUE=\"$cost_cut2_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Gilotyna II IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real  NAME=cost_cut2_idle_info id=cost_cut2_idle_info VALUE=\"$cost_cut2_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=cutter2IdleTime id=cutter2IdleTime  VALUE=\"$cutter2IdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_cut2_idle_real  id=cost_cut2_idle_real  VALUE=\"$cost_cut2_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Gilotyna II </label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_cut2_info id=cost_cut2_info VALUE=\"$cost_cut2_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold name=cutter2TotalTime id=cutter2TotalTime  VALUE=\"$cutter2TotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_cut2_real  id=cost_cut2_real  VALUE=\"$cost_cut2_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_cut2       id=cost_cut2       VALUE=\"$cost_cut2\">&nbsp;[PLN]</TD>
              </TR>
              <TR>
                <TD class=td0011 $sl5>Druk Awers narząd</TD>
                <TD class=td0010 $sl5 colspan=1><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_awers_narzad_info id=cost_awers_narzad_info VALUE=\"$cost_awers_narzad_info\"></TD>
                <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingAwersSetupTime id=printingAwersSetupTime  VALUE=\"$printingAwersSetupTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers_narzad_real id=cost_awers_narzad_real VALUE=\"$cost_awers_narzad_real\">&nbsp;[PLN]</TD>
                <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Druk Awers jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_awers_jazda_info id=cost_awers_jazda_info VALUE=\"$cost_awers_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay id=printingAwersRunTime id=printingAwersRunTime  VALUE=\"$printingAwersRunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers_jazda_real id=cost_awers_jazda_real VALUE=\"$cost_awers_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Druk Awers IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_awers_idle_info id=cost_awers_idle_info VALUE=\"$cost_awers_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingAwersIdleTime id=printingAwersIdleTime  VALUE=\"$printingAwersIdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers_idle_real id=cost_awers_idle_real VALUE=\"$cost_awers_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Druk Awers</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_awers_info id=cost_awers_info VALUE=\"$cost_awers_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold name=printingAwersTotalTime id=printingAwersTotalTime  VALUE=\"$printingAwersTotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_awers_real id=cost_awers_real VALUE=\"$cost_awers_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_awers id=cost_awers VALUE=\"$cost_awers\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Druk Rewers narząd</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_rewers_narzad_info id=cost_rewers_narzad_info VALUE=\"$cost_rewers_narzad_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingRewersSetupTime id=printingRewersSetupTime  VALUE=\"$printingRewersSetupTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers_narzad_real id=cost_rewers_narzad_real VALUE=\"$cost_rewers_narzad_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Druk Rewers jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_rewers_jazda_info id=cost_rewers_jazda_info VALUE=\"$cost_rewers_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingRewersRunTime id=printingRewersRunTime  VALUE=\"$printingRewersRunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers_jazda_real id=cost_rewers_jazda_real VALUE=\"$cost_rewers_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Druk Rewers IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_rewers_idle_info id=cost_rewers_idle_info VALUE=\"$cost_rewers_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingRewersIdleTime id=printingRewersIdleTime  VALUE=\"$printingRewersIdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers_idle_real id=cost_rewers_idle_real VALUE=\"$cost_rewers_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Druk Rewers</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_rewers_info id=cost_rewers_info VALUE=\"$cost_rewers_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold name=printingRewersTotalTime id=printingRewersTotalTime  VALUE=\"$printingRewersTotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers_real id=cost_rewers_real VALUE=\"$cost_rewers_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_rewers id=cost_rewers VALUE=\"$cost_rewers\">&nbsp;[PLN]</TD>
              </TR>

              <TR id=tr_print2_7 style=\"display: none;\">
                  <TD class=td0011 $sl5>Druk Awers narząd II</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_awers2_narzad_info id=cost_awers2_narzad_info VALUE=\"$cost_awers2_narzad_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingAwers2SetupTime id=printingAwers2SetupTime  VALUE=\"$printingAwers2SetupTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers2_narzad_real id=cost_awers2_narzad_real VALUE=\"$cost_awers2_narzad_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_8 style=\"display: none;\">
                  <TD class=td0011 $sl5>Druk Awers jazda II</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_awers2_jazda_info id=cost_awers2_jazda_info VALUE=\"$cost_awers2_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingAwers2RunTime id=printingAwers2RunTime  VALUE=\"$printingAwers2RunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers2_jazda_real id=cost_awers2_jazda_real VALUE=\"$cost_awers2_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_9 style=\"display: none;\">
                  <TD class=td0011 $sl5>Druk Awers IDLE II</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_awers2_idle_info id=cost_awers2_idle_info VALUE=\"$cost_awers2_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingAwers2IdleTime id=printingAwers2IdleTime  VALUE=\"$printingAwers2IdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers2_idle_real id=cost_awers2_idle_real VALUE=\"$cost_awers2_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_10 style=\"display: none;\">
                  <TD class=td0011 $sl5><label class=label-bold>Druk Awers II</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_awers2_info id=cost_awers2_info VALUE=\"$cost_awers2_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold name=printingAwers2TotalTime id=printingAwers2TotalTime  VALUE=\"$printingAwers2TotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_awers2_real id=cost_awers2_real VALUE=\"$cost_awers2_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_awers2 id=cost_awers2 VALUE=\"$cost_awers2\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_11 style=\"display: none;\">
                  <TD class=td0011 $sl5>Druk Rewers narząd II</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_rewers2_narzad_info id=cost_rewers2_narzad_info VALUE=\"$cost_rewers2_narzad_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingRewers2SetupTime id=printingRewers2SetupTime  VALUE=\"$printingRewers2TotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers2_narzad_real id=cost_rewers2_narzad_real VALUE=\"$cost_rewers2_narzad_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_12 style=\"display: none;\">
                  <TD class=td0011 $sl5>Druk Rewers jazda II</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_rewers2_jazda_info id=cost_rewers2_jazda_info VALUE=\"$cost_rewers2_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingRewers2RunTime id=printingRewers2RunTime  VALUE=\"$printingRewers2RunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers2_jazda_real id=cost_rewers2_jazda_real VALUE=\"$cost_rewers2_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_13 style=\"display: none;\">
                  <TD class=td0011 $sl5>Druk Rewers IDLE II</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_rewers2_idle_info id=cost_rewers2_idle_info VALUE=\"$cost_rewers2_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingRewers2IdleTime id=printingRewers2IdleTime  VALUE=\"$printingRewers2IdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers2_idle_real id=cost_rewers2_idle_real VALUE=\"$cost_rewers2_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_14 style=\"display: none;\">
                  <TD class=td0011 $sl5><label class=label-bold>Druk Rewers II</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_rewers2_info id=cost_rewers2_info VALUE=\"$cost_rewers2_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold name=printingRewers2TotalTime id=printingRewers2TotalTime VALUE=\"$printingRewers2TotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_rewers2_real id=cost_rewers2_real VALUE=\"$cost_rewers2_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_rewers2 id=cost_rewers2 VALUE=\"$cost_rewers2\">&nbsp;[PLN]</TD>
              </TR>
              <TR>
                  <TD class=td0011 $sl5>Lakier offset jazda</TD>
                  <TD class=td0010 $sl5 colspan=2><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_varnish_jazda_info id=cost_varnish_jazda_info VALUE=\"$cost_varnish_jazda_info\"></TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_varnish_jazda_real id=cost_varnish_jazda_real VALUE=\"$cost_varnish_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR>
                  <TD class=td0011 $sl5><label class=label-bold>Lakier offset</label></TD>
                  <TD class=td0010 $sl5 colspan=2><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_varnish_info id=cost_varnish_info VALUE=\"$cost_varnsh_info\"></TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_varnish_real id=cost_varnish_real VALUE=\"$cost_varnish_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_varnish id=cost_varnish VALUE=\"$cost_varnish\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_17 style=\"display: none;\">
                  <TD class=td0011 $sl5>Lakier offset jazda II</TD>
                  <TD class=td0010 $sl5 colspan=2><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_varnish2_jazda_info id=cost_varnish2_jazda_info VALUE=\"$cost_varnish2_jazda_info\"></TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_varnish2_jazda_real id=cost_varnish2_jazda_real VALUE=\"$cost_varnish2_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR id=tr_print2_18 style=\"display: none;\">
                  <TD class=td0011 $sl5><label class=label-bold>Lakier offset II</label></TD>
                  <TD class=td0010 $sl5 colspan=2><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_varnish2_info id=cost_varnish2_info VALUE=\"$cost_varnsh2_info\"></TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_varnish2_real id=cost_varnish2_real VALUE=\"$cost_varnish2_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_varnish2 id=cost_varnish2 VALUE=\"$cost_varnish2\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Lakierowanie UV narząd</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_varnish_uv_narzad_info id=cost_varnish_uv_narzad_info VALUE=\"$cost_varnish_uv_narzad_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=varnishUVSetupTime id=varnishUVSetupTime  VALUE=\"$varnishUVSetupTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_varnish_uv_narzad_real id=cost_varnish_uv_narzad_real VALUE=\"$cost_varnish_uv_narzad_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Lakierowanie UV jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_varnish_uv_jazda_info id=cost_varnish_uv_jazda_info VALUE=\"$cost_varnish_uv_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=varnishUVRunTime id=varnishUVRunTime  VALUE=\"$varnishUVRunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_varnish_uv_jazda_real id=cost_varnish_uv_jazda_real VALUE=\"$cost_varnish_uv_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Lakierowanie UV IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_varnish_uv_idle_info id=cost_varnish_uv_idle_info VALUE=\"$cost_varnish_uv_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=varnishUVIdleTime id=varnishUVIdleTime  VALUE=\"$varnishUVIdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_varnish_uv_idle_real id=cost_varnish_uv_idle_real VALUE=\"$cost_varnish_uv_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Lakierowanie UV</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_varnish_uv_info id=cost_varnish_uv_info VALUE=\"$cost_varnish_uv_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold Name=varnishUVTotalTime id=varnishUVTotalTime  VALUE=\"$varnishUVTotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_varnish_uv_real id=cost_varnish_uv_real VALUE=\"$cost_varnish_uv_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_varnish_uv id=cost_varnish_uv VALUE=\"$cost_varnish_uv\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Złocenie narząd</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_gilding_narzad_info id=cost_gilding_narzad_info VALUE=\"$cost_gilding_narzad_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay Name=hotStampingSetupTime id=hotStampingSetupTime  VALUE=\"$hotStampingSetupTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_gilding_narzad_real   id=cost_gilding_narzad_real    VALUE=\"$cost_gilding_narzad_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Złocenie jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_gilding_jazda_info id=cost_gilding_jazda_info VALUE=\"$cost_gilding_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay Name=hotStampingRunTime id=hotStampingRunTime  VALUE=\"$hotStampingRunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_gilding_jazda_real   id=cost_gilding_jazda_real    VALUE=\"$cost_gilding_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Złocenie IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_gilding_idle_info id=cost_gilding_idle_info VALUE=\"$cost_gilding_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay Name=hotStampingIdleTime id=hotStampingIdleTime  VALUE=\"$hotStampingIdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_gilding_idle_real   id=cost_gilding_idle_real    VALUE=\"$cost_gilding_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Złocenie</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_gilding_info id=cost_gilding_info VALUE=\"$cost_gilding_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold Name=hotStampingTotalTime id=hotStampingTotalTime  VALUE=\"$hotStampingTotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_gilding_real   id=cost_gilding_real    VALUE=\"$cost_gilding_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_gilding        id=cost_gilding         VALUE=\"$cost_gilding\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Kaszerowanie narzad</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_laminating_narzad_info id=cost_laminating_narzad_info VALUE=\"$cost_laminating_narzad_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=lithoLaminationSetupTime id=lithoLaminationSetupTime  VALUE=\"$lithoLaminationSetupTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_laminating_narzad_real id=cost_laminating_narzad_real VALUE=\"$cost_laminating_narzad_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c      id=c      VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Kaszerowanie jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_laminating_jazda_info id=cost_laminating_jazda_info VALUE=\"$cost_laminating_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=lithoLaminationRunTime id=lithoLaminationRunTime  VALUE=\"$lithoLaminationRunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_laminating_jazda_real id=cost_laminating_jazda_real VALUE=\"$cost_laminating_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c     id=c      VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Kaszerowanie IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_laminating_idle_info id=cost_laminating_idle_info VALUE=\"$cost_laminating_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=lithoLaminationIdleTime id=lithoLaminationIdleTime  VALUE=\"$lithoLaminationIdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_laminating_idle_real id=cost_laminating_idle_real VALUE=\"$cost_laminating_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c      id=c      VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Kaszerowanie</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_laminating_info id=cost_laminating_info VALUE=\"$cost_laminating_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold NAME=lithoLaminationTotalTime id=lithoLaminationTotalTime  VALUE=\"$lithoLaminationTotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-Bold NAME=cost_laminating_real id=cost_laminating_real VALUE=\"$cost_laminating_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-Bold NAME=cost_laminating      id=cost_laminating      VALUE=\"$cost_laminating\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Wycinanie narzad</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_dcting_narzad_info id=cost_dcting_narzad_info VALUE=\"$cost_dcting_narzad_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=dieCuttingSetupTime id=dieCuttingSetupTime  VALUE=\"$dieCuttingSetupTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_dcting_narzad_real id=cost_dcting_narzad_real VALUE=\"$cost_dcting_narzad_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Wycinanie jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_dcting_jazda_info id=cost_dcting_jazda_info VALUE=\"$cost_dcting_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=dieCuttingRunTime id=dieCuttingRunTime  VALUE=\"$dieCuttingRunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_dcting_jazda_real id=cost_dcting_jazda_real VALUE=\"$cost_dcting_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Wycinanie IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_dcting_idle_info id=cost_dcting_idle_info VALUE=\"$cost_dcting_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=dieCuttingIdleTime id=dieCuttingIdleTime  VALUE=\"$dieCuttingIdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_dcting_idle_real id=cost_dcting_idle_real VALUE=\"$cost_dcting_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Wycinanie</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_dcting_info id=cost_dcting_info VALUE=\"$cost_dcting_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold NAME=dieCuttingTotalTime id=dieCuttingTotalTime  VALUE=\"$dieCuttingTotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_dcting_real id=cost_dcting_real VALUE=\"$cost_dcting_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_dcting      id=cost_dcting      VALUE=\"$cost_dcting\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Wycinanie 2 narzad</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_dcting2_narzad_info id=cost_dcting2_narzad_info VALUE=\"$cost_dcting2_narzad_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=dieCutting2SetupTime id=dieCutting2SetupTime  VALUE=\"$dieCutting2SetupTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_dcting2_narzad_real id=cost_dcting2_narzad_real VALUE=\"$cost_dcting2_narzad_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Wycinanie 2 jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_dcting2_jazda_info id=cost_dcting2_jazda_info VALUE=\"$cost_dcting2_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=dieCutting2RunTime id=dieCutting2RunTime  VALUE=\"$dieCutting2RunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_dcting2_jazda_real id=cost_dcting2_jazda_real VALUE=\"$cost_dcting2_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Wycinanie 2 IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_dcting2_idle_info id=cost_dcting2_idle_info VALUE=\"$cost_dcting2_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=dieCutting2IdleTime id=dieCutting2IdleTime  VALUE=\"$dieCutting2IdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_dcting2_idle_real id=cost_dcting2_idle_real VALUE=\"$cost_dcting2_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Wycinanie2</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_dcting2_info id=cost_dcting2_info VALUE=\"$cost_dcting2_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold Name=dieCutting2TotalTime id=dieCutting2TotalTime  VALUE=\"$dieCutting2TotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_dcting2_real id=cost_dcting2_real VALUE=\"$cost_dcting2_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_dcting2      id=cost_dcting2      VALUE=\"$cost_dcting2\">&nbsp;[PLN]</TD>
              </TR>
              <TR>
                  <TD class=td0011 $sl5>Separacja narzad</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=separationSetupInfo id=separationSetupInfo VALUE=\"$separationSetupInfo\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=separationSetupTime id=separationSetupTime  VALUE=\"$separationSetupTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=separationSetupRealCosts id=separationSetupRealCosts VALUE=\"$separationSetupRealCosts\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=separationSetupTotalCosts id=separationSetupTotalCosts VALUE=\"$separationSetupTotalCosts\">&nbsp;[PLN]</TD>
              </TR>
              <TR>
                  <TD class=td0011 $sl5>Separacja jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_manual_work_jazda_info id=cost_manual_work_jazda_info VALUE=\"$cost_manual_work_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=separationRunTime id=separationRunTime  VALUE=\"$separationRunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_manual_work_jazda_real id=cost_manual_work_jazda_real VALUE=\"$cost_manual_work_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Separacja IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_manual_work_idle_info id=cost_manual_work_idle_info VALUE=\"$cost_manual_work_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=separationIdleTime id=separationIdleTime  VALUE=\"$separationIdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_manual_work_idle_real id=cost_manual_work_idle_real VALUE=\"$cost_manual_work_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Separacja</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_manual_work_info id=cost_manual_work_info VALUE=\"$cost_manual_work_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold NAME=separationTotalTime id=separationTotalTime  VALUE=\"$separationTotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_manual_work_real id=cost_manual_work_real VALUE=\"$cost_manual_work_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_manual_work      id=cost_manual_work      VALUE=\"$cost_manual_work\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Klejenie ręczne jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_glue_jazda_info id=cost_glue_jazda_info VALUE=\"$cost_glue_jazda_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=manualGluingRunTime id=manualGluingRunTime  VALUE=\"$manualGluingRunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_glue_jazda_real id=cost_glue_jazda_real VALUE=\"$cost_glue_jazda_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c id=c VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Klejenie ręczne IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_glue_idle_info id=cost_glue_idle_info VALUE=\"$cost_glue_idle_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=manualGluingIdleTime id=manualGluingIdleTime  VALUE=\"$manualGluingIdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_glue_idle_real id=cost_glue_idle_real VALUE=\"$cost_glue_idle_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=c   id=c    VALUE=\"-\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Klejenie ręczne</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_glue_info id=cost_glue_info VALUE=\"$cost_glue_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold NAME=manualGluingTotalTime id=manualGluingTotalTime  VALUE=\"$manualGluingTotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_glue_real id=cost_glue_real VALUE=\"$cost_glue_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_glue   id=cost_glue    VALUE=\"$cost_glue\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Klejenie automatyczne narzad</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=automaticGluingSetupCostsInfo id=automaticGluingSetupCostsInfo VALUE=\"$automaticGluingSetupCostsInfo\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=automaticGluingSetupTime id=automaticGluingSetupTime  VALUE=\"$automaticGluingSetupTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=automaticGluingSetupCostsReal id=automaticGluingSetupCostsReal VALUE=\"$automaticGluingSetupCostsReal\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=automaticGluingSetupCosts   id=automaticGluingSetupCosts    VALUE=\"$automaticGluingSetupCosts\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Klejenie automatyczne jazda</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=automaticGluingRunCostsInfo id=automaticGluingRunCostsInfo VALUE=\"$automaticGluingRunCostsInfo\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=automaticGluingRunTime id=automaticGluingRunTime  VALUE=\"$automaticGluingRunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=automaticGluingRunCostsReal id=automaticGluingRunCostsReal VALUE=\"$automaticGluingRunCostsReal\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=automaticGluingRunCosts   id=automaticGluingRunCosts    VALUE=\"$automaticGluingRunCosts\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Klejenie automatyczne IDLE</TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=automaticGluingIdleCostsInfo id=automaticGluingIdleCostsInfo VALUE=\"$automaticGluingIdleCostsInfo\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=automaticGluingIdleTime id=automaticGluingIdleTime  VALUE=\"$automaticGluingIdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=automaticGluingIdleCostsReal id=automaticGluingIdleCostsReal VALUE=\"$automaticGluingIdleCostsReal\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=automaticGluingIdleCosts   id=automaticGluingIdleCosts    VALUE=\"$automaticGluingIdleCosts\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Klejenie automatyczne</label></TD>
                  <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real-Bold NAME=cost_glue_automat_info id=automaticGluingTotalCostsInfo VALUE=\"$cost_glue_automat_info\"></TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold NAME=automaticGluingTotalTime id=automaticGluingTotalTime  VALUE=\"$automaticGluingTotalTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_glue_automat_real id=automaticGluingTotalRealCosts VALUE=\"$cost_glue_automat_real\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_glue_automat   id=automaticGluingTotalCosts    VALUE=\"$cost_glue_automat\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Transport klejenie automatyczne</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_trans_glue_automat_info id=cost_trans_glue_automat_info VALUE=\"$cost_trans_glue_automat_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_trans_glue_automat   id=automaticGluingTransportCosts    VALUE=\"$cost_trans_glue_automat\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Wklejanie okienek</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_window_info id=cost_window_info VALUE=\"$cost_window_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_window   id=cost_window    VALUE=\"$cost_window\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Transport wklejanie okienek</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_trans_window_info id=cost_trans_window_info VALUE=\"$cost_trans_window_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_trans_window   id=cost_trans_window    VALUE=\"$cost_trans_window\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5><label class=label-bold>Suma</label></TD>
                  <TD class=td0010 $sl5>&nbsp;</TD>
                  <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold NAME=totalOperationTime id=totalOperationTime  VALUE=\"$totalOperationTime\" TYPE=text>&nbsp;[hh:mm]</TD>
                  <TD class=td0110 $sr5 colspan=2><INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_total_operation id=cost_total_operation VALUE=\"$cost_total_operation\">&nbsp;[PLN]</TD>
              </TR>



              <TR ><TD class=td2tableC $sc colspan=5>Koszty usług zewnętrznych</TD></TR>
              <TR >
                  <TD class=td0011 $sl5>Lakierowanie specjalne</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_ink_varnish_special_out_info id=cost_ink_varnish_special_out_info VALUE=\"$cost_ink_varnish_special_out_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_ink_varnish_special_out id=cost_ink_varnish_special_out VALUE=\"$cost_ink_varnish_special_out\" >&nbsp;[PLN]
                      <INPUT CLASS=H NAME=cost_transport_out id=cost_transport_out  VALUE=\"$cost_transport_out\" TYPE=$input_hidden_type>
                  </TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Transport lakierowanie specjalne</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_trans_ink_varnish_special_out_info id=cost_trans_ink_varnish_special_out_info VALUE=\"$cost_trans_ink_varnish_special_out_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_trans_ink_varnish_special_out id=cost_trans_ink_varnish_special_out VALUE=\"$cost_trans_ink_varnish_special_out\" >&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Falcowanie</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_falc_info id=cost_falc_info VALUE=\"$cost_falc_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_falc   id=cost_falc    VALUE=\"$cost_falc\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Transport falcowanie</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_trans_falc_info id=cost_trans_falc_info VALUE=\"$cost_trans_falc_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_trans_falc   id=cost_trans_falc    VALUE=\"$cost_trans_falc\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Zszywanie i formatowanie</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_stample_info id=cost_stample_info VALUE=\"$cost_stample_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_stample   id=cost_stample    VALUE=\"$cost_stample\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Transport zszywanie i formatowanie</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_trans_stample_info id=cost_trans_stample_info VALUE=\"$cost_trans_stample_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_trans_stample   id=cost_trans_stample    VALUE=\"$cost_trans_stample\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Bigowanie</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_bigowanie_info id=cost_bigowanie_info VALUE=\"$cost_bigowanie_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_bigowanie   id=cost_bigowanie    VALUE=\"$cost_bigowanie\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Transport bigowanie</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_trans_bigowanie_info id=cost_trans_bigowanie_info VALUE=\"$cost_trans_bigowanie_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_trans_bigowanie   id=cost_trans_bigowanie    VALUE=\"$cost_trans_bigowanie\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Foliowanie</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_foil_info id=cost_foil_info VALUE=\"$cost_foil_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_foil id=cost_foil VALUE=\"$cost_foil\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Transport foliowanie</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_trans_foil_info id=cost_trans_foil_info VALUE=\"$cost_trans_foil_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_trans_foil id=cost_trans_foil VALUE=\"$cost_trans_foil\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Koszt transportu</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_transport_info id=cost_transport_info VALUE=\"$cost_transport_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_transport id=cost_transport VALUE=\"$cost_transport\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Suma</TD>
                  <TD class=td0010 $sl5 colspan=3>&nbsp;</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_total_out id=cost_total_out VALUE=\"$cost_total_out\">&nbsp;[PLN]</TD>
              </TR>

              <TR ><TD class=td2tableC $sc colspan=5>Koszty Dodatkowe</TD></TR>
              <TR >
                  <TD class=td0011 $sl5>Inne 1 (korekta pozycji kosztów ujętych w kalkulacji)</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_other1_info id=cost_other1_info VALUE=\"$cost_other1_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_other1 id=cost_other1 VALUE=\"$cost_other1\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Inne 2 (pozycje kosztów nie uwzględnione w kalkulacji)</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_other2_info id=cost_other2_info VALUE=\"$cost_other2_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_other2 id=cost_other2 VALUE=\"$cost_other2\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Minusowanie (dla kalkulacji przerobowych)</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=throughput_deduct_info id=throughput_deduct_info VALUE=\"$throughput_deduct_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_deduct_total id=throughput_deduct_total VALUE=\"$throughput_deduct_total\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Matryce złocenia </TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_extra_matryce_info id=cost_extra_matryce_info VALUE=\"$cost_extra_matryce_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_extra_matryce_KD id=cost_extra_matryce_KD VALUE=\"$cost_extra_matryce_KD\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Suma koszty dodatkowe (KD)</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_total_dodatek_info id=cost_total_dodatek_info VALUE=\"$cost_total_dodatek_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_total_dodatek id=cost_total_dodatek VALUE=\"$cost_total_dodatek\">&nbsp;[PLN]</TD>
              </TR>

              <TR ><TD class=td2tableC $sc colspan=5>Pozostałe koszty do wyfakturaowania</TD></TR>
              <TR >
                  <TD class=td0011 $sl5>Klisze</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_clicha_extra_info id=cost_clicha_extra_info VALUE=\"$cost_clicha_extra_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_clicha_extra id=cost_clicha_extra VALUE=\"$cost_clicha_extra\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Dodatkowe pozycje do wyfakrutowania</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_extra_info id=cost_extra_info VALUE=\"$cost_extra_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_extra id=cost_extra VALUE=\"$cost_extra\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Koszt akceptu</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_accept_info id=cost_accept_info VALUE=\"$cost_accept_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_accept id=cost_accept VALUE=\"$cost_accept\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Wykrojnik</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_dicut_info id=cost_dicut_info ></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_dicut id=cost_dicut VALUE=\"$cost_dicut\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Matryce złocenia </TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_extra_matryce_info id=cost_extra_matryce_info VALUE=\"$cost_extra_matryce_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_extra_matryce_KPoz id=cost_extra_matryce_KPoz VALUE=\"$cost_extra_matryce_KPoz\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Suma koszty pozostałe KPoz</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_total_pozostale_info id=cost_total_pozostale_info VALUE=\"$cost_total_pozostale_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_total_pozostale id=cost_total_pozostale VALUE=\"$cost_total_pozostale\">&nbsp;[PLN]</TD>
              </TR>

              <TR ><TD class=td2tableC $sc colspan=5>Kalkulacja tradycyjna - Podsumowanie</TD></TR>
              <TR >
                  <TD class=td0011 $sl5>Koszt bezpośredni</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_total_total_info id=cost_total_total_info VALUE=\"$cost_total_total_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_total_total id=cost_total_total VALUE=\"$cost_total_total\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Narzut kosztów administracyjnych</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_administracja_info id=cost_administracja_info VALUE=\"$cost_administracja_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_administracja id=cost_administracja VALUE=\"$cost_administracja\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Narzut kosztów podatku</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_podatek_info id=cost_podatek_info VALUE=\"$cost_podatek_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_podatek id=cost_podatek VALUE=\"$cost_podatek\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Suma narzutów</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_sum_narzut_info id=cost_sum_narzut_info VALUE=\"$cost_sum_narzut_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_sum_narzut id=cost_sum_narzut VALUE=\"$cost_sum_narzut\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>BEP</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_bep_info id=cost_bep_info VALUE=\"$cost_bep_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_bep id=cost_bep VALUE=\"$cost_bep\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>$txt_td_125</TD>
                  <TD class=td0010 $sl5 colspan=3>&nbsp;</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_bep_one id=cost_bep_one VALUE=\"$cost_bep\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Marża</TD>
                  <TD class=td0010 $sl5 colspan=2><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_margin_info id=cost_margin_info VALUE=\"$cost_margin_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_margin_unit id=cost_margin_unit VALUE=\"$cost_margin\">&nbsp;[PLN/ szt.]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_margin id=cost_margin VALUE=\"$cost_margin\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Sprzedaż</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_sales_info id=cost_sales_info VALUE=\"$cost_sales_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_sales id=cost_sales VALUE=\"$cost_sales\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>$txt_td_126</TD>
                  <TD class=td0010 $sl5 colspan=3>&nbsp;</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_sales_one id=cost_sales_one VALUE=\"$cost_sales\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Prowizja 10%</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_prowizja10_info id=cost_prowizja10_info VALUE=\"$cost_prowizja10_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_prowizja10 id=cost_prowizja10 VALUE=\"$cost_prowizja10\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Prowizja 15%</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_prowizja15_info id=cost_prowizja15_info VALUE=\"$cost_prowizja15_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_prowizja15 id=cost_prowizja15 VALUE=\"$cost_prowizja15\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>2,5%</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_2_5_info id=cost_2_5_info VALUE=\"$cost_2_5_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_2_5 id=cost_2_5 VALUE=\"$cost_2_5\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>1/3 marży</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_margin_1_3_info id=cost_margin_1_3_info VALUE=\"$cost_margin_1_3_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_margin_1_3 id=cost_margin_1_3 VALUE=\"$cost_margin_1_3\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Wybrana prowizja od marży</TD>
                  <TD class=td0010 $sl5 colspan=3></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_goods id=cost_goods VALUE=\"$cost_goods\">&nbsp;[PLN]</TD>
              </TR>
              <TR ><TD class=td2tableC $sc colspan=5>Kalkulacja przerobowa - Podsumowanie</TD></TR>
              <TR >
                  <TD class=td0011 $sl5>TVC</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=TVC_info id=TVC_info VALUE=\"$TVC_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=TVC id=TVC VALUE=\"$TVC\">&nbsp;[PLN]</TD>
              </TR>

              <TR >
                  <TD class=td0011 $sl5>TVC jednostkowe TVC</TD>
                  <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=TVC_unit_info id=TVC_unit_info VALUE=\"$TVC_unit_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=TVC_unit id=TVC_unit VALUE=\"$TVC_unit\">&nbsp;[PLN]</TD>
              </TR>

              <TR >
                  <TD class=td0011 $sl5>Przerób</TD>
                  <TD class=td0010 $sl5 colspan=2><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=throughput_info id=throughput_info VALUE=\"$throughput_info\"></TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput id=throughput VALUE=\"$throughput\">&nbsp;[PLN]</TD>
                  <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_threshold_fixed id=throughput_threshold_fixed VALUE=\"$throughput_threshold\">&nbsp;[PLN]</TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Przerób jednostkowy</TD>
                  <TD class=td0010 $sl5></TD>
                  <TD class=td0010 $sl5>
                    <label>Przerób na arkusz
                      <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_unit id=throughput_unit VALUE=\"$throughput_unit\">&nbsp;[PLN]
                    </label>
                  </TD>
                  <TD class=td0010 $sl5>
                    <label>prog graniczny
                      <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_threshold_fixed_per_sheet id=throughput_threshold_fixed_per_sheet VALUE=\"$throughput_unit_threshold\">&nbsp;[%]
                    </label>
                  </TD>
              </TR>

              <TR >
                  <TD class=td0011 $sl5>Przerób do sprzedaży</TD>
                  <TD class=td0010 $sl5></TD>
                  <TD class=td0010 $sl5>
                    <label>Przerób do sprzedazy
                      <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_to_sales id=throughput_to_sales VALUE=\"$throughput_to_sales\">&nbsp;[%]
                    </label>
                  </TD>
                  <TD class=td0010 $sl5>
                    <label>Prog ostrzegawczy
                      <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_to_sales_warningLevel id=throughput_to_sales_warningLevel VALUE=\"$throughput_to_sales_warningLevel\">&nbsp;[%]
                    </label>
                  </TD>
                  <TD class=td0010 $sl5>
                    <label>Prog graniczny
                      <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_to_sales_threshold id=throughput_to_sales_threshold VALUE=\"$throughput_to_sales_threshold\">&nbsp;[%]
                    </label>
                  </TD>
              </TR>
              <TR>
                  <TD class=td0011 $sl5>Przerób godzinowy</TD>
                  <TD class=td0011 $sl5>
                  </TD>
                    <TD class=td0010 $sl5>
                      <label>Przerób na godzinę
                        <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_per_labour id=throughput_per_labour VALUE=\"$throughput_per_labour\">&nbsp;[%]
                      </label>
                    </TD>
                  <TD class=td0110 $sr5>
                    <label>prog ostrzegawczy
                      <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_per_labour_warningLevel id=throughput_per_labour_warningLevel VALUE=\"$throughput_per_labour_warningLevel\">&nbsp;[%]
                    </label>
                  </TD>
                  <TD class=td0110 $sr5>
                    <label>prog graniczny
                      <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_per_labour_threshold id=throughput_per_labour_threshold VALUE=\"$throughput_per_labour_threshold\">&nbsp;[%]
                    </label>
                  </TD>
              </TR>
              <TR >
                  <TD class=td0011 $sl5>Prowizja</TD>
                  <TD class=td0010 $sl5 colspan=2>
                    <label>
                      <INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=throughput_comission_info id=throughput_comission_info VALUE=\"$throughput_comission_info\">
                    </label>
                  </TD>
                  <TD class=td0110 $sr5>
                    <label>Procent
                      <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_comission_percent id=throughput_comission_percent VALUE=\"$throughput_comission_percent\">&nbsp;[PLN]
                    </label>
                  </TD>
                  <TD class=td0110 $sr5>
                    <label>Wartosc
                      <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=throughput_comission id=throughput_comission VALUE=\"$throughput_comission\">&nbsp;[PLN]
                    </label>
                  </TD>

              </TR>
          </TABLE>";
        $txt_input_14 = $OCLangDict["txt_input_14"][$lang_id];
        $input_costs = "<A href=\"order_calculation_show.php?action=show&oc_id=$oc_id&back=$back\" style=\"text-decoration: none;\">$txt_input_14</A> &nbsp;&nbsp;&nbsp;";
    } else {
        $txt_input_13 = $OCLangDict["txt_input_13"][$lang_id];
        $input_costs = "<A href=\"order_calculation_show.php?action=show&oc_id=$oc_id&back=$back&option=show_costs\" style=\"text-decoration: none;\">$txt_input_13</A> &nbsp;&nbsp;&nbsp;";
    }
}

$input_copy = "<A href=\"./order_calculation_create.php?action=do_copy&oc_copy=$oc_id\" style=\"text-decoration: none;\">Kopiuj do nowej kalkulacji</A>&nbsp;&nbsp;&nbsp;";
$input_edit = "<A href=\"./order_calculation_create.php?action=create&oc_id=$oc_id&back=show\" style=\"text-decoration: none;\">Edytuj</A>&nbsp;&nbsp;&nbsp;";
$input_delete = "<A href=\"./order_calculation_show.php?action=delete&oc_id=$oc_id&back=show\" style=\"text-decoration: none;\">Usuń</A>&nbsp;&nbsp;&nbsp;";
IF ($status >= "100") { $input_edit = ""; $input_delete = ""; }
IF ($status <= "0") { $input_edit = ""; $input_delete = ""; }

$calc_type_info = "";
IF ($calc_type == "view") { $input_copy = "";
  $calc_type_info = "<DIV class=error>Kalkulacja jest wyłącznie poglądowa. Nie można wykonac oferty / umowy oraz uruchomić zleceia do realizacji.</DIV>";
}

$table_menu = "<TD class=td0000 $sl5></TD>
               <TD class=td2tableC $sc><A href=\"./order_calculation_show_contract.php?action=show&oc_id=$oc_id&back=$back\" style=\"text-decoration: none;\">$txt_td_192</A></TD>
               <TD class=td0000 $sl5></TD>
               <TD class=td2tableC $sc><A href=\"./order_calculation_show_order.php?action=show&oc_id=$oc_id&back=$back\" style=\"text-decoration: none;\">$txt_td_139</A></TD>";
IF (($status < "100") && ($status > "0")) { $table_menu = "<TD class=td0000 colspan=6 $sl5></TD>"; }

//zawartość strony
$display = "
<DIV class=tytul17red_line>$txt_menu_12_2dsc</DIV>

<DIV class=label>
  <TABLE width=710>
    <TR>
      <TD width=300 style=\"padding-left: 10px\">$txt_td_021: <B>$create_user_le $create_user_fe</B> $create_date</TD>
      <TD width=300 style=\"padding-left: 10px\">Nazwa: <B>$order_nr $name</B></TD>
    </TR>
    <TR>
      <TD style=\"padding-left: 10px\">$txt_td_004: <B>$status_show</B></TD>
      <TD style=\"padding-left: 10px\">Klient: <B>$customer_name</B></TD>
    </TR>
  </TABLE>
</DIV>
$show_error
$calc_type_info

<FORM method=post action=\"$file_name.php\" onsubmit=\"return Validate(occ)\" id=\"occ\" name=\"occ\" enctype=\"multipart/form-data\">

<TABLE class='calculationTopSummary_Table tekst9gr'>
      <TR>
        <TD class=calculationTopSummary_TD colspan=2>
          <label class=calculationTopSummary_Label>Podsumowanie kosztów</label>
        </TD>
        <TD class=calculationTopSummary_TD colspan=2>
          <label class=calculationTopSummary_Label>Kalkulacja tradycyjna</label>
        </TD>
        <TD class=calculationTopSummary_TD colspan=2>
          <label class=calculationTopSummary_Label>Kalkulacja przerobowa</label>
        </TD>
      </TR>

        <TR>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_116</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_paper1_top    id=cost_paper1_top    VALUE=\"$cost_paper1\" TYPE=text>&nbsp;[PLN]
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=paper1_weight_top  id=paper1_weight_top  VALUE=\"$paper1_weight\" TYPE=text>&nbsp;[kg]
            </TD>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_119</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_total_operation_top id=cost_total_operation_top VALUE=\"$cost_total_operation\" TYPE=text>&nbsp;[PLN]
            </TD>


            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_124</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_sales_top     id=cost_sales_top    VALUE=\"$cost_sales\" TYPE=text>&nbsp;[PLN]
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_sales_one_top id=cost_sales_one_top VALUE=\"$cost_sales_one\" TYPE=text>&nbsp;[PLN/szt]
            </TD>

            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>Prowizja od marży</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_goods     id=cost_goods      VALUE=\"$cost_goods\" TYPE=text>&nbsp;[PLN]
            </TD>

            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>TVC</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=TVC     id=TVC_top     VALUE=\"$TVC\" TYPE=text>&nbsp;[PLN]
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=TVC_unit id=TVC_unit_top VALUE=\"$TVC_unit\" TYPE=text>&nbsp;[PLN/ark]
            </TD>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>Prowizja od przerobu</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_comission     id=throughput_comission      VALUE=\"$throughput_comission\" TYPE=text>&nbsp;[PLN]
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_comission_percent_top     id=throughput_comission_percent_top      VALUE=\"$throughput_comission_percent\" TYPE=text>&nbsp;[%]
            </TD>
        </TR>

        <TR>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_117</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_paper2    id=cost_paper2    VALUE=\"$cost_paper2\" TYPE=text>&nbsp;[PLN]
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=paper2_m2_top      id=paper2_m2_top      VALUE=\"$paper2_m2\" TYPE=text>&nbsp;[m<SUP>2</SUP>]
              <INPUT readonly class=calculationTopSummary_Input NAME=paper2_weight_top  id=paper2_weight_top  VALUE=\"$paper2_weight\" TYPE=text>&nbsp;[kg]
            </TD>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_121</label><BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_transport id=cost_transport VALUE=\"$cost_transport\" TYPE=text>&nbsp;[PLN]
              <BR>
              <label class=calculationTopSummary_Label>Waga całkowita</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=order_total_weight_top  id=order_total_weight_top  VALUE=\"$order_total_weight\" TYPE=text>&nbsp;[kg]
            </TD>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_123</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_bep       id=cost_bep       VALUE=\"$cost_bep\" TYPE=text>&nbsp;[PLN]
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_bep_one   id=cost_bep_one   VALUE=\"$cost_bep_one\" TYPE=text>&nbsp;[PLN/szt]</TD>
            </TD>

            <TD class=calculationTopSummary_TD rowspan=2>
              <label class=calculationTopSummary_Label>$txt_td_128</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_prowizja10 id=cost_prowizja10 VALUE=\"$cost_prowizja10\" TYPE=text>&nbsp;[PLN]
              </BR>
              <label class=calculationTopSummary_Label>$txt_td_129</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_prowizja15 id=cost_prowizja15 VALUE=\"$cost_prowizja15\" TYPE=text>&nbsp;[PLN]
              </BR>
              <label class=calculationTopSummary_Label>$txt_td_131</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_margin_1_3 id=cost_margin_1_3 VALUE=\"$cost_margin_1_3\" TYPE=text>&nbsp;[PLN]
              </BR>
              <label class=calculationTopSummary_Label>$txt_td_130</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_2_5        id=cost_2_5         VALUE=\"$cost_2_5\" TYPE=text>&nbsp;[PLN]
            </TD>

            <TD class=calculationTopSummary_TD id=throughput_td>
              <label class=calculationTopSummary_Label>Przerob</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput    id=throughput_top    VALUE=\"$throughput\" TYPE=text>&nbsp;[PLN]
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_unit    id=throughput_unit_top    VALUE=\"$throughput_unit\" TYPE=text>&nbsp;[PLN/ark]
            </TD>

            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>Próg</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_threshold_fixed         id=throughput_threshold_fixed    VALUE=\"$throughput_threshold_fixed\" TYPE=text>&nbsp;[PLN]
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_threshold_unit_fixed   id=throughput_threshold_unit_fixed    VALUE=\"$throughput_threshold_fixed_per_sheet\" TYPE=text>&nbsp;[PLN/ark]
            </TD>
        </TR>

        <TR>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_118</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_total_material  id=cost_total_material    VALUE=\"$cost_total_material\" TYPE=text>&nbsp;[PLN]
            </TD>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_120</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_total_out id=cost_total_out VALUE=\"$cost_total_out\" TYPE=text>&nbsp;[PLN]
            </TD>

            <TD class=calculationTopSummary_TD id=td_margin1>
              <label class=calculationTopSummary_Label>Marża</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_margin    id=cost_margin    VALUE=\"$cost_margin\" TYPE=text>&nbsp;[PLN]
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_margin_unit    id=cost_margin_unit    VALUE=\"$cost_margin_unit\" TYPE=text>&nbsp;[PLN/szt]
            </TD>

            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>Przerób do sprzedaży</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_to_sales    id=throughput_to_sales    VALUE=\"$throughput_to_sales\" TYPE=text>&nbsp;[%]
              <BR>
              <label class=calculationTopSummary_Label>Przerób na godzinę</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_per_labour    id=throughput_per_labour    VALUE=\"$throughput_per_labour\" TYPE=text>&nbsp;[PLN/h]
            </TD>

            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>Próg / ostrzeżenie</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_to_sales_threshold    id=throughput_to_sales_threshold    VALUE=\"$throughput_to_sales_threshold\" TYPE=text>&nbsp;
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_to_sales_warningLevel    id=throughput_to_sales_warningLevel_top    VALUE=\"$throughput_to_sales_warningLevel\" TYPE=text>
              <BR>
              <label class=calculationTopSummary_Label>Próg / ostrzeżenie</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_per_labour_threshold    id=throughput_per_labour_threshold    VALUE=\"$throughput_per_labour_threshold\" TYPE=text>&nbsp;
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_per_labour_warningLevel    id=throughput_per_labour_warningLevel_top    VALUE=\"$throughput_per_labour_warningLevel\" TYPE=text>
            </TD>
        </TR>

</TABLE>


<TABLE class=tekst9gr width=980 cellspacing=1 cellpadding=1 style=\"margin-top: 10px\">
        <TR> <TD width=150></TD> <TD width=16></TD>
             <TD width=150></TD> <TD width=16></TD>
             <TD width=150></TD> <TD width=16></TD>
             <TD width=150></TD> <TD width=16></TD>
             <TD width=150></TD> <TD width=16></TD>
             <TD width=150></TD>
        </TR>
        <TR>
            <TD class=td2tableAct $sc>$txt_td_022</TD>
            <TD class=td0000 $sl5></TD>
            <TD class=td2tableC $sc><A href=\"./order_calculation_show_mac.php?action=show&oc_id=$oc_id&back=$back\" style=\"text-decoration: none;\">$txt_td_138</A></TD>
            <TD class=td0000 $sl5></TD>
            <TD class=td2tableC $sc><A href=\"./order_calculation_show_qty.php?action=show&oc_id=$oc_id&back=$back\" style=\"text-decoration: none;\">$txt_td_142</A></TD>
            <TD class=td0000 $sl5></TD>
            <TD class=td2tableC $sc><A href=\"./order_calculation_show_product_card.php?action=show&oc_id=$oc_id&back=$back\" style=\"text-decoration: none;\">$txt_td_141</A></TD>
            $table_menu
        </TR>
</TABLE>

<TABLE class=tekst11 width=980 cellspacing=1 cellpadding=1 style=\"margin-top: 10px\">
        <TR> <TD width=180></TD> <TD width=200></TD> <TD width=200></TD> <TD width=200></TD> <TD width=200></TD> </TR>
        <TR>
            <TD class=td2tableC $sc colspan=5>$txt_td_022</TD>
        </TR>
        <TR>
            <TD class=td0000 colspan=5 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_019</SPAN><BR>$name</TD>
        </TR>
        <TR>
            <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_031</SPAN><BR>$order_nr</TD>
            <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_032</SPAN><BR>$create_date</TD>
            <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_033</SPAN><BR>$end_date</TD>
            <TD class=td0000 colspan=2 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_034</SPAN><BR>$end_week</TD>
        </TR>
        <TR>
            <TD class=td0000 $sl5 colspan=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_035</SPAN><BR>$customer_name</TD>
            <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_036</SPAN><BR>$accept_type_show</TD>
            <TD class=td0000 colspan=2 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_037</SPAN><BR>$accept_cost [PLN]</TD>
        </TR>
        <TR>
            <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_038</SPAN><BR>$expiration_date</TD>
            <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_039</SPAN><BR>$barcode</TD>
            <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_040</SPAN><BR>$manufacturer_box_info</TD>
            <TD class=td0010 colspan=2 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_041</SPAN><BR>$print_quality</TD>
        </TR>
        <TR>
            <TD class=td0000 $sl5 colspan=5><SPAN STYLE=\"font-size: $size_span;\"><B>$txt_td_042</B></SPAN><BR><PRE>$extra_dsc</PRE></TD>
        </TR>
        <TR>
            <TD class=td0010 $sl5 colspan=5><SPAN STYLE=\"font-size: $size_span;\"><B>$txt_td_043</B></SPAN><BR><PRE>$orginal_order_dsc</PRE></TD>
        </TR>
        <TR>
            <TD class=td0010 $sl5 colspan=5>
              <SPAN STYLE=\"font-size: $size_span;\"><B>Powód cofnięcia z produkcji</B></SPAN><BR>$back_order_dsc</TD>
        </TR>
      <!-- BEGIN Section on CTP & CAD costs -->
        <TR>
            <!-- Order type info -->
              <TD class=td0000 $sl5>
                <SPAN STYLE=\"font-size: $size_span;\">$txt_td_045</SPAN>
                <BR>$order_type
              </TD>
            <!-- Print type info -->
              <TD class=td0000 $sl5 colspan=2>
                $print_type_show&nbsp;
              </TD>
            <!-- Calculation pre v2 CAD & CTP costs -->
              <TD class=td0000 $sl5>
                <SPAN STYLE=\"font-size: $size_span;\"><B>Dane dla kalkulacji < v2</B></SPAN>
                <BR>
                <BR>
                <SPAN STYLE=\"font-size: $size_span;\">$txt_td_047</SPAN>
                <BR>
                $cliche_cost&nbsp;[$txt_td_133]
                <BR>
                $new_grafic_name
                <BR>
                <BR>
                <SPAN STYLE=\"font-size: $size_span;\">$txt_td_048</SPAN>
                <BR>
                $dctool_cost&nbsp;[$txt_td_133]
                <BR>
                $new_dctool_name
              </TD>
            <!-- Calculation v2 CAD costs & invoicing-->
              <TD class=td0000 colspan=2 $sl5>
                  <SPAN STYLE=\"font-size: $size_span;\"><B>Dane dla Kalkulacji >= v2</B></SPAN>
                  <BR>
                  <!-- die cutting v2 costs & invoicing-->
                  <SPAN STYLE=\"font-size: $size_span;\">Rodzaj narzędzia wycinania: </SPAN>
                  <BR>
                    <select disabled name='dieCuttingToolingTypeID' id='dieCuttingToolingTypeDropdown' class='a' style='width: 200px; font-size: 10px;' title='Wybierz narzędzia wycinania'>
                      $dieCuttingToolingList
                    </select>
                  <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Status: </SPAN>
                    <select disabled name='dieCuttingToolingStatusID' id='dieCuttingToolingStatusDropdown' class='a' style='width: 100px; font-size: 10px;' title='Wybierz status narzędzi'>
                      $dieCuttingToolingStatusList
                    </select>
                  <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Koszt: </SPAN>
                    $dctool_cost&nbsp;[$txt_td_133]
                  <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Rozliczenie: </SPAN>
                    <select disabled name='dieCuttingToolingInvoicingID' id='dieCuttingToolingInvoicingDropdown' class='a' style='width: 150px; font-size: 10px;' title='Wybierz rodzaj fakturowania'>
                      $dieCuttingToolingInvoicingList
                    </select>
                  <BR>
                  <BR>
                  <!-- stripping v2 costs & invoicing-->
                  <SPAN STYLE=\"font-size: $size_span;\">Rodzaj narzędzia wypychania: </SPAN>
                  <BR>
                    <select disabled name='strippingToolingTypeID' id='strippingToolingTypeDropdown' class='a' style='width: 200px; font-size: 10px;' title='Wybierz narzędzia'>
                      $strippingToolingList
                    </select>
                  <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Status: </SPAN>
                    <select disabled name='strippingToolingStatusID' id='strippingToolingStatusDropdown' class='a' style='width: 100px; font-size: 10px;' title='Wybierz status narzędzi'>
                      $strippingToolingStatusList
                    </select>
                  <BR>
                    <SPAN STYLE=\"font-size: $size_span;\">Koszt: </SPAN>
                    $strippingToolingCost&nbsp;[$txt_td_133]
                    <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Rozliczenie: </SPAN>
                    <select disabled name='strippingToolingInvoicingID' id='strippingToolingInvoicingDropdown' class='a' style='width: 150px; font-size: 10px;' title='Wybierz rodzaj fakturowania'>
                       $strippingToolingInvoicingList
                    </select>
                  <BR>
                  <BR>
                  <!-- separation v2 costs & invoicing-->
                  <SPAN STYLE=\"font-size: $size_span;\">Rodzaj narzędzia separacji: </SPAN>
                  <BR>
                    <select disabled name='separationToolingTypeID' id='separationToolingTypeDropdown' class='a' VALUE=\"$separationToolingTypeID\" style='width: 150px; font-size: 10px;' title='Wybierz rodzaj narzędzi'>
                      $separationToolingList
                    </select>
                  <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Status: </SPAN>
                    <select disabled name='separationToolingStatusID' id='separationToolingStatusDropdown' class='a' VALUE=\"$separationToolingStatusID\" style='width: 150px; font-size: 10px;' title='Wybierz status narzędzi'>
                      $separationToolingStatusList
                    </select>
                  <BR>
                    <SPAN STYLE=\"font-size: $size_span;\">Koszt: </SPAN>
                    $separationToolingCost&nbsp;[$txt_td_133]
                    <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Rozliczenie: </SPAN>
                  <select disabled name='separationToolingInvoicingID' id='separationToolingInvoicingDropdown' class='a' style='width: 150px; font-size: 10px;' title='Wybierz rodzaj fakturowania'>
                     $separationToolingInvoicingList
                  </select>
              </TD>
        </TR>
       </TABLE>

        <!-- END Section on CTP & CAD costs -->
        
        <!-- BEGIN Section on QTY Data -->
        <div class='headerDIV header3Text'>
          <span>NAKLAD I TOLERANCJE</span>
        </div>
        
        <div class='containerDIV'> 
          <div class='flex-item'>
            Zamówione: $order_qty1&nbsp;[szt.]
            <BR>
            Tolerancja: $tolerant&nbsp;[%]
            <BR>
            Minimalnie: $minimumQty&nbsp;[szt.]
            <BR>
            Maksymalnie: $maximumQty&nbsp;[szt.]
          </div>

          <div class='flex-item'>
            <BR>Brutto: $grossQty [ark.]
            <BR>Netto: $netQty [ark.]
            <BR>Naddatek: $setupQty [ark.]
            
          </div>
        </div>
        <!-- END Section on QTY Data -->

        
        <!-- BEGIN Section on constructiondata -->
        
              <div class='headerDIV header3Text'>
                <span>RODZAJ I KONSTRUKCJA</span>
              </div>
              <div class='containerDIV'> 
                <div class='flex-item'>
                  <SPAN STYLE=\"font-size: $size_span;\">$txt_td_045</SPAN>
                  <BR>
                  <SELECT NAME=dctool_type_id id=dctool_type_id CLASS=a STYLE=\"width: 100px; font-size: 10px;\" disabled>
                    $list_order_types
                  </SELECT>
                  <BR>
                  <INPUT CLASS=H NAME=order_type       id=order_type       VALUE=\"$order_type\" TYPE=$input_hidden_type>
                </DIV>
                <div class='flex-item'>
                  <SPAN STYLE=\"font-size: $size_span;\">Dane użytku</SPAN>
                  <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Szerokość:&nbsp;$upWidth&nbsp;[mm]</SPAN>
                  <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Długość:&nbsp;$upLenght&nbsp;[mm]</SPAN>
                  <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Okienka:&nbsp;$upWindows&nbsp;[na uż]</SPAN>
                </DIV>
                <div class='flex-item'>
                  <SPAN STYLE=\"font-size: $size_span;\">Wymiary gotowego wyrobu</SPAN>
                  <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Szerokość:&nbsp;$boxWidth&nbsp;[mm]</SPAN>
                  <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Długość:&nbsp;$boxLenght&nbsp;[mm]</SPAN>
                  <BR>
                  <SPAN STYLE=\"font-size: $size_span;\">Głębokość:&nbsp;$boxDepth&nbsp;[mm]</SPAN>
                </DIV>
              </div>
        $table_data

      </TABLE>
<BR>
$table_task_data

<P class=tekst12gr><A href=\"./order_calculation_list.php?action=list\">Wyjście</A>&nbsp;&nbsp;&nbsp;
    $input_logi
    $input_costs
    $input_to_do
    $input_delete
    $input_edit
    <A href=\"./order_calculation_show_mac.php?action=show&oc_id=$oc_id&back=$back\" style=\"text-decoration: none;\">$txt_td_138</A>&nbsp;&nbsp;&nbsp;
    <A href=\"./order_calculation_show_qty.php?action=show&oc_id=$oc_id&back=$back\" style=\"text-decoration: none;\">$txt_td_142</A>&nbsp;&nbsp;&nbsp;
    $input_copy
</FORM>

$table_log
$table_costs
";

//wywołaj stronę
INCLUDE('./page_content.php');

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

IF ($action == "delete") {

//kontrola dostępu
//AccessDeniedCheck($connection,$user_id,$userlevel_id,$serwer,"12_3_1","order_calculation_show.php -> delate");

$menu_caption = "/ <A href=\"./index.php\" style=\"color: #FFFFFF\" title=\"$txt_title_003\">Menu główne</A>
                 / <A href=\"./order_calculation_list.php?action=list\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_1_0</A>
                 / <A href=\"./order_calculation_show.php?action=show&oc_id=$oc_id&back=$back\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_2_0</A> /
                 $txt_menu_12_3_1";
$window_caption = ":: $txt_menu_12_1_0";
$powrot = "./order_calculation_show.php?action=show&oc_id=$oc_id&back=$back";

//przygotuj MENU (w zależności od operatorów)
//$menu_left = MenuLeftShow($connection,$user_id,$lang_id,$userlevel,"12_3_0");


$txt_input_07   = $OCLangDict['txt_input_07'][$lang_id];
$txt_text_0014  = $OCLangDict['txt_text_0014'][$lang_id];

//zawartość strony
$display = "
<DIV class=tytul17red_line>$txt_menu_12_3_1dsc</DIV>
<DIV class=warning>$txt_text_0014</DIV>

<P class=tekst12gr><A href=\"$powrot\">| $txt_powrot_01 |</A>&nbsp;&nbsp;&nbsp;
    <A href=\"./order_calculation_show.php?action=do_delate&oc_id=$oc_id&back=$back\" style=\"text-decoration: none;\">$txt_input_07</A>&nbsp;&nbsp;&nbsp;

";

//wywołaj stronę
INCLUDE('./page_content.php');

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
IF ($action == "do_delate") {

$sql1 = "UPDATE order_calculations SET status=\"0\" WHERE oc_id='$oc_id' LIMIT 1";
         // echo "$sql3<BR>";
$result1 = @mysql_query($sql1, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_show.php -> do_delate -> UDATE order_calculations]");

$sql1 = "UPDATE order_calculations SET status=\"0\" WHERE oc_id_main='$oc_id' LIMIT 1";
         // echo "$sql3<BR>";
$result1 = @mysql_query($sql1, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_show.php -> do_delate -> UDATE order_calculations]");

//$sql3 = "UPDATE project_tasks SET status=\"50\", end_date=\"$dzisiaj\", answer=\"$txt_report_info_36 [$user_id_le $user_id_fe $dzisiajteraz]\"
//         WHERE status='10' AND project_id='$project_id' ";
//         // echo "$sql3<BR>";
//$result3 = @mysql_query($sql3, $connection) or die("Wykonanie zapytania nie powiodło się! [project_show.php -> do_project_close -> UDATE project_tasks status=50]");

$txt_text_0015 = $OCLangDict['txt_text_0015'][$lang_id];
//ReadUser($connection,$user_id,$user_id_fe,$user_id_le,$user_id_ln,$user_id_ul,$user_id_pt,$user_id_sr);
//SaveAuditPlanLogs($connection,$user_id,"10","order_calculation",$oc_id,"$txt_text_0015");

header( "Location: $serwer_type$serwer/system/order_calculation_show.php?action=show&oc_id=$oc_id&back=$back&error=audit_delate" ); exit;

//wywołaj stronę
INCLUDE('./page_content.php');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

IF ($action == "add_file") {

//kontrola dostępu
//AccessDeniedCheck($connection,$user_id,$userlevel_id,$serwer,"12_3_1","order_calculation_show.php -> delate");

$menu_caption = "/ <A href=\"./index.php\" style=\"color: #FFFFFF\" title=\"$txt_title_003\">Menu główne</A>
                 / <A href=\"./order_calculation_list.php?action=list\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_1_0</A>
                 / <A href=\"./order_calculation_show.php?action=show&oc_id=$oc_id&back=$back\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_2_0</A> /
                 $txt_menu_12_3_1";
$window_caption = ":: $txt_menu_12_1_0";
$powrot = "./order_calculation_show.php?action=show&oc_id=$oc_id&back=$back";

//przygotuj MENU (w zależności od operatorów)
$menu_left = MenuLeftShow($connection,$user_id,$lang_id,$userlevel,"12_3_0");


$customer_id    = $_GET['customer_id'];
$calculationNumber           = $_GET['name'];

// get customer name base on customer id
  $customerName = getValueFromDb_PDO ('customers','short_name',"customers.customer_id = $customer_id",'customers.short_name ASC');
// get calculation name 
  $calculationName = getValueFromDb_PDO ('order_calculations','name',"order_calculations.oc_id = $oc_id",'order_calculations.name ASC');

//zawartość strony
$display = "
<DIV class=tytul17red_line>Dodawanie plików do kalkulacji: <BR> $calculationNumber - $customerName - $calculationName </DIV>

<FORM method=post action=\"order_calculation_show.php\" enctype=\"multipart/form-data\">

<TABLE>
  <TR> <TD width=210></TD> <TD width=500></TD> </TR>
      <TR><TD class=td2tableL>Pliki (inne)</TD>
          <TD class=td0010 >
              <INPUT type=file NAME=file_1 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_2 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_3 class=a >&nbsp;[max $max_filesize_ MB]
          </TD>
      </TR>
      <TR><TD class=td2tableL>Pliki (konstrukcja)</TD>
          <TD class=td0010 >
              <INPUT type=file NAME=file_4 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_5 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_6 class=a >&nbsp;[max $max_filesize_ MB]
          </TD>
      </TR>
      <TR><TD class=td2tableL>Pliki (grafika)</TD>
          <TD class=td0010 >
              <INPUT type=file NAME=file_7 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_8 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_9 class=a >&nbsp;[max $max_filesize_ MB]
          </TD>
      </TR>
</TABLE>

<P class=tekst12gr><A href=\"$powrot\">| $txt_powrot_01 |</A>&nbsp;&nbsp;&nbsp;
    <INPUT TYPE=submit NAME=submit class=button VALUE=\"&nbsp;&nbsp;Zapisz plik&nbsp;&nbsp;\" style=\"width: 150px;\" id=input_save_input>
    <INPUT TYPE=hidden NAME=action2             VALUE=do_add_file>
    <INPUT TYPE=hidden NAME=back                VALUE=$back>
    <INPUT TYPE=hidden NAME=oc_id               VALUE=$oc_id>
    <INPUT TYPE=hidden NAME=customer_id         VALUE=$customer_id>
    <INPUT TYPE=hidden NAME=name                VALUE=\"$name\">

";

//wywołaj stronę
INCLUDE('./page_content.php');

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
IF ($action == "do_add_file") {

$customer_id    = $_POST['customer_id'];
$name           = $_POST['name'];
$txt_text_0009      = $OCLangDict['txt_text_0009'][$lang_id];
///zapis pliku ->


// BEGIN looping through files attached to calculation to save them on server folder
// loop through the $FILES array (max of nine files and loops allowed to save files)
FOR ($a = 1; $a<=9; $a++) {
    // get the file name and file size from FILES array
      $SafeFile = $_FILES['file_'.$a]['name']; //echo "$SafeFile name<BR>";//Nazwa
      $FileSize = $_FILES['file_'.$a]['size']; //echo "$FileSize rozmiar<BR>";//Rozmiar
    // set the boolean allowing to upload to false
      $move     = "0";
    // check if the file size and file name exists
      IF (($SafeFile) && ($FileSize > 0)) {
      // Replace a given set of special signs in file name with predetermined set of words
        $SafeFile = str_replace("#", "No.", $SafeFile);
        $SafeFile = str_replace("$", "Dollar", $SafeFile);
        $SafeFile = str_replace("%", "Percent", $SafeFile);
        $SafeFile = str_replace("^", "", $SafeFile);
        $SafeFile = str_replace("&", "and", $SafeFile);
        $SafeFile = str_replace("*", "", $SafeFile);
        $SafeFile = str_replace("?", "", $SafeFile);
      // if the file size meets the max defines size for upload go ahead with upload
        IF ($_FILES['file_'.$a]["size"] < $max_filesize) {
           $move = "1"; // set the boolean allowing to upload to true
        } ELSE { // else prevent and inform user
           header( "Location: $serwer_type$serwer/system/order_calculation_show.php?action=show&oc_id=$oc_id&back=$back&error=file_size" ); exit;
        }
        // clean file name
          $SafeFile = CleanPLfile($SafeFile);
        // get the file extension
          $rozszerzenie = FindExt($SafeFile);
        // TODO: what does this do?
          $file_id = str_pad($file_id, 10, "0", STR_PAD_LEFT);
          $file_i = substr($file_id,0,6);
        // get the paths to files
          $sciezka_ = $sciezka.$file_i."/";
        // if the move file boolean variable is true
          IF ($move == "1") {
          // if the path to saving files on server is defined
            IF ($sciezkaArchiwum) {
              // get the customer id
                $customer_id = $_POST['customer_id'];
              // get the customer name
                FindOrderCalculationValue($connection,"short_name","customer_id='$customer_id'","customers",$customer_short);
              // create a string with the folder path customerName/ orderNumber
                $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$name;
              // create folder in the server files archive if it doesn't already exist
                if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }
              // create a string with the folder path customerName/ orderNumber / grafika
                $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$name."/grafika";
              // create folder in the server files archive if it doesn't already exist  
                if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }
              // create a string with the folder path customerName/ orderNumber / inne
                $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$name."/inne";
              // create folder in the server files archive if it doesn't already exist
                if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }
              // create a string with the folder path customerName/ konstrukcja
                $accept_file_load = $sciezkaArchiwum."/".$customer_short."/konstrukcja";
                // create folder in the server files archive if it doesn't already exist
                  if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }

                // define paths to folders depending on the position in the FILES array
                switch ($a) {
                  case "1": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$name."/inne"; break;
                  case "2": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$name."/inne"; break;
                  case "3": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$name."/inne"; break;
                  case "4": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/konstrukcja"; break;
                  case "5": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/konstrukcja"; break;
                  case "6": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/konstrukcja"; break;
                  case "7": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$name."/grafika"; break;
                  case "8": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$name."/grafika"; break;
                  case "9": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$name."/grafika"; break;
                }
                // move the uploaded file to the server
                  move_uploaded_file($_FILES['file_'.$a]["tmp_name"],$accept_file_load."/".$SafeFile);
                // change permissions on uploaded file
                  chmod($accept_file_load."/".$SafeFile,0755);
                // save data on files assoociated with calculation to calculation table and log table
                  SaveOrderCalculationFile($connection,"10",$user_id,$oc_id,"",$dzisiajteraz,$SafeFile,$accept_file_load,$file_id);
                  SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"$txt_text_0009 $SafeFile");
            } else {
              // move the uploaded file to the server
                move_uploadd_file($_FILES['file_'.$a]["tmp_name"],$sciezka_.$SafeFile);
              // TODO: what does this do?
                rename($sciezka_.$_FILES['file_'.$a]["name"],$sciezka_.$file_id.$rozszerzenie);
              // change permissions on uploaded file
                chmod($sciezka_.$file_id.$rozszerzenie,0755);
            }
            // TODO: file upload should still be logged here
        }

      }
}
// END looping through files attached to calculation to save them on server folder

header( "Location: $serwer_type$serwer/system/order_calculation_show.php?action=show&oc_id=$oc_id&back=$back" ); exit;

//wywołaj stronę
INCLUDE('./page_content.php');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

IF ($action == "del_file") {

//kontrola dostępu
//AccessDeniedCheck($connection,$user_id,$userlevel_id,$serwer,"12_3_1","order_calculation_show.php -> delate");

$menu_caption = "/ <A href=\"./index.php\" style=\"color: #FFFFFF\" title=\"$txt_title_003\">Menu główne</A>
                 / <A href=\"./order_calculation_list.php?action=list\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_1_0</A>
                 / <A href=\"./order_calculation_show.php?action=show&oc_id=$oc_id&back=$back\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_2_0</A> /
                 $txt_menu_12_3_1";
$window_caption = ":: $txt_menu_12_1_0";
$powrot = "./order_calculation_show.php?action=show&oc_id=$oc_id&back=$back";

//przygotuj MENU (w zależności od operatorów)
$menu_left = MenuLeftShow($connection,$user_id,$lang_id,$userlevel,"12_3_0");


$file_id    = $_GET['file_id'];
FindOrderCalculationValue($connection,"file_name","file_id='$file_id'","order_calculation_files",$file_name);
$rozszerzenie = FindExt($file_name);
$ico = FindIco($rozszerzenie);
$link = $sciezka . substr($file_id,0,6) ."/". $file_id . $rozszerzenie;
$file_load=""; FindOrderCalculationValue($connection,"file_load","file_id='$file_id'","order_calculation_files",$file_load);
IF ($file_load) { $link = $file_load ."/". $file_name; }

$file_id2_exist = "";
$file_id2=""; FindOrderCalculationValue($connection,"file_id","file_id<>'$file_id' AND file_name='$file_name' AND status>'0' AND file_load='$file_load'","order_calculation_files",$file_id2);
IF ($file_id2) {
  $file_id2_exist = "<BR>Plik fizycznie jest wykoryzstywany w innych miejscach kalkulacji - nie będzie fizycznie usuwany z systemu.";
}

//zawartość strony
$display = "
<DIV class=tytul17red_line>Usunięcie pliku z projektu #$oc_id</DIV>

<FORM method=post action=\"order_calculation_show.php\" enctype=\"multipart/form-data\">
<DIV class=error><B>UWAGA</B><BR>
  Wybrano opcję usunięcia pliku:
  <BR><A href=\"$link\" target=_blank style=\"text-decoration: none;\"><IMG SRC=\"./icon/$ico\" width=12 border=0>$file_name</A>
  <BR>Czy mam usunać plik?
  $file_id2_exist
</DIV>

<P class=tekst12gr><A href=\"$powrot\">| $txt_powrot_01 |</A>&nbsp;&nbsp;&nbsp;
    <A href=\"./order_calculation_show.php?action=do_del_file&oc_id=$oc_id&file_id=$file_id&back=$back\" style=\"text-decoration: none;\">Usuń plik</A>
";

//wywołaj stronę
INCLUDE('./page_content.php');

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
IF ($action == "do_del_file") {

$file_id    = $_GET['file_id'];
FindOrderCalculationValue($connection,"file_name","file_id='$file_id'","order_calculation_files",$file_name);
$sql1 = "UPDATE order_calculation_files SET status=\"0\" WHERE file_id='$file_id' LIMIT 1";  //echo "$sql1<BR>";
$result1 = @mysql_query($sql1, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_show.php -> $action -> UDATE order_calculation_files status=0]");
SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"Usunięto plik $file_name");

$link = $sciezka . substr($file_id,0,6) ."/". $file_id . $rozszerzenie;
$file_load=""; FindOrderCalculationValue($connection,"file_load","file_id='$file_id'","order_calculation_files",$file_load);
IF ($file_load) { $link = $file_load ."/". $file_name; }

$file_id2=""; FindOrderCalculationValue($connection,"file_id","file_id<>'$file_id' AND file_name='$file_name' AND status>'0' AND file_load='$file_load'","order_calculation_files",$file_id2);
IF (!$file_id2) { unlink($link); echo "kasuje";}

header( "Location: $serwer_type$serwer/system/$back.php?action=show&oc_id=$oc_id" ); exit;

//wywołaj stronę
INCLUDE('./page_content.php');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<HTML>
  <HEAD>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <LINK rel="STYLESHEET" href="./panel.css" type="text/css">
  <TITLE><?php echo $window_caption; ?></TITLE>
  <script src="calendar.js"></script>
  <link href="calendar.css" rel="stylesheet">
  </HEAD>

  <BODY>

    <?php echo $page_content; ?>

  </BODY>


</HTML>
