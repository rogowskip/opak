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


// Declare variables
$lang_id = 1; // 1 = Polski ; 2 = English

//zmienne używane w całym pliku
$txt_powrot_01        = $OCLangDict['txt_powrot_01'][$lang_id];
$txt_check_02         = $OCLangDict['txt_check_02'][$lang_id];
$txt_check_01         = $OCLangDict['txt_check_01'][$lang_id];
$txt_input_02         = $OCLangDict['txt_input_02'][$lang_id];
$txt_input_03         = $OCLangDict['txt_input_03'][$lang_id];
$txt_input_05         = $OCLangDict['txt_input_05'][$lang_id];
$txt_menu_0_0_0       = $OCLangDict['txt_menu_0_0_0'][$lang_id];
$txt_menu_12_0_0      = $OCLangDict['txt_menu_12_0_0'][$lang_id];
$txt_menu_12_5_0      = $OCLangDict['txt_menu_12_5_0'][$lang_id];
$txt_menu_12_5dsc     = $OCLangDict['txt_menu_12_5dsc'][$lang_id];
$txt_title_001        = $OCLangDict['txt_title_001'][$lang_id];//szczegóły
$txt_title_002        = $OCLangDict['txt_title_002'][$lang_id];//powrót do listy
$txt_title_003        = $OCLangDict['txt_title_003'][$lang_id];//powrót do menu
$txt_filtr_01         = $OCLangDict['txt_filtr_01'][$lang_id];
$txt_filtr_02         = $OCLangDict['txt_filtr_02'][$lang_id];


$connection = @mysql_connect($db_host, $db_user, $db_password) or die("Próba połączenia nie powiodła się!");
$db = @mysql_select_db($db_name, $connection) or die("Wybór bazy danych nie powiódł się!");
$accept_userlevel2 = ReadSystemSettings($connection,"project_userlevel_for_accepted_people");
$delated_color     = ReadSystemSettings($connection,"color_delated_for_in_table");
$max_filesize      = ReadSystemSettings($connection,"oc_file_size_max");

SaveUserOnline($connection,$user_id,"Tworzenie kalkulacji");

date_default_timezone_set('Europe/Warsaw');
$dzisiaj      = date("Y-m-d");
$dzisiajteraz = date("Y-m-d H:i:s");
$y_m          = date("Y-m");
$year         = date("Y");
$validate     = "";
$validate_data = "";
$size_span = "10px";
$input_hidden_type = "text";
$input_hidden_type = "hidden";
$input_hidden_type_view = "text readonly";
$input_hidden_type_view_info = "text readonly";


$back       = "";
$error      = "";
$option     = "";
$audit_plan_id = "";
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

$menu_access = "70_3_0"; $menu_value = "70_2_0"; $txt_menu_70 = $txt_menu_70_2_0; $txt_menu_70dsc = $txt_menu_70_2dsc;
IF (!$audit_plan_id) {
   $menu_access = "70_5_0"; $menu_value = "70_5_0"; $txt_menu_70 = $txt_menu_70_5_0; $txt_menu_70dsc = $txt_menu_70_5dsc;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$txt_td_002           = $OCLangDict['txt_td_002'][$lang_id];
$txt_td_004           = $OCLangDict['txt_td_004'][$lang_id];
$txt_td_018           = $OCLangDict['txt_td_018'][$lang_id];
$txt_td_019           = $OCLangDict['txt_td_019'][$lang_id];
$txt_td_021           = $OCLangDict['txt_td_021'][$lang_id];
$txt_td_022           = $OCLangDict['txt_td_022'][$lang_id];
$txt_td_027           = $OCLangDict['txt_td_027'][$lang_id];
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
$txt_td_147           = $OCLangDict['txt_td_147'][$lang_id];
$txt_td_148           = $OCLangDict['txt_td_148'][$lang_id];
$txt_td_149           = $OCLangDict['txt_td_149'][$lang_id];
$txt_td_151           = $OCLangDict['txt_td_151'][$lang_id];
$txt_td_152           = $OCLangDict['txt_td_152'][$lang_id];
$txt_td_153           = $OCLangDict['txt_td_153'][$lang_id];
$txt_td_159           = $OCLangDict['txt_td_159'][$lang_id];
$txt_td_160           = $OCLangDict['txt_td_160'][$lang_id];
$txt_td_191           = $OCLangDict['txt_td_191'][$lang_id];
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

IF ($action == "create") {

//kontrola dostępu
//AccessDeniedCheck($connection,$user_id,$userlevel_id,$serwer,$menu_access,"audit_plan_show.php -> list");


$menu_caption = "/ <A href=\"./index.php\" style=\"color: #FFFFFF\" title=\"$txt_title_003\">Menu główne</A>
                 / <A href=\"./order_calculation_menu.php?action=menu\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_0_0</A>
                 / <A href=\"./order_calculation_list.php?action=list\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_1_0</A> / $txt_menu_12_5_0";
$window_caption = "$txt_menu_0_0_0 :: $txt_menu_12_1_0";
$this_url = "./order_calculation_create.php?action=create&oc_id=$oc_id&back=$back";
$powrot = "./order_calculation_list.php?action=list\">Wyjdź";

$max_filesize_        = number_format($max_filesize / 1024 / 1024,"0","."," ");
ReadUser($connection,$user_id,$user_id_fe,$user_id_le,$user_id_ln,$user_id_ul,$user_id_pt,$user_id_sr);

// if the current calculation dosn't have an oc_id means that user is creating a new calculation so go ahead and give it a ne number
if (empty($oc_id)) {
// get the last order_nr from order_calculations table
  FindOrderCalculationValue($connection,"order_nr","status>='0' AND year='$year' AND order_nr like '%-%' ORDER BY order_nr DESC LIMIT 1","order_calculations",$order_nr_last);
// manipulate the last order_nr to create a new calculation number increased by 1
  $order_nr_last = explode("-",$order_nr_last);
  $order_nr_last = $order_nr_last[1];
  $order_nr_last++;
  $order_nr_last = str_pad($order_nr_last, 4, "0", STR_PAD_LEFT);
  $order_nr = date("my")."-".$order_nr_last;
  $version = 0; // define initial calculation version
  $version_dsc = "";
} elseif (!empty($oc_id)) { // else do not create a new order_nr since the user only wants to edit calculation without changing its order_nr
  // get current version of this calculation
    FindOrderCalculationValue($connection,"version","status>='0' AND oc_id = '$oc_id' ORDER BY order_nr DESC LIMIT 1","order_calculations",$version);
  //increase the version of current calculation by 1
    $version++;
}


//BEGIN define calculation data

  $calculationEngineVersion ="02"; // define calculation engine version
  $calculationEngineDate ="2019-11-07"; // define calculation engine date
// END define calculation data

// BEGIN define basic order data
  $customerOrder=""; // customer order number if exists
  $customer_id="";
  $order_type_id = "";
  $name = "";
  $order_date = $dzisiaj; // date calculation was edited
  $create_date = $dzisiaj;
  $dsc = "";
  $create_user_le = $user_id_le;
  $create_user_fe = $user_id_fe;
  $order_qty_change="";
  $back_order_dsc="";
  $file_lists10 = ""; // string holding list of files attached to calculation

  $end_date = "";
  $end_week = "";
  $accept_type_id = "";
  $accept_cost = "";
  $expiration_date = "";
  $barcode = "";

  $manufacturer_box_info = "";
  $print_quality = "";
  $extra_dsc = "";
  $orginal_order_dsc = "";
  $version_dsc = "";
  $order_type = "";
  $cliche_cost = "";
  $print_type = "";
// END define basic order data

// BEGIN define RegEx validation
  # RegEX tutorial https://medium.com/factory-mind/regex-tutorial-a-simple-cheatsheet-by-examples-649dc1c3f285
  # RegEx tester https://www.regextester.com/
  //$regexValidation_Margin = "^[-0-9][0-9]*(.[0-9]{0,4})$"; // can start with a minus | first pos. digits 0 to 9 | second and next pos. digits 0 to 9 | dot | first and next pos. digits 0 to 9 | num. of digits after "dot" 0 to 4
  $regexValidation_Margin = "^[-0-9]*(.[0-9]{0,4})$";
  $regexValidation_UnitPrice = "^[0-9]*([.][0-9]{0,4}|)$"; // cannot start with a minus | first and next pos. digits 0 to 9 | dot | first and next pos. digits 0 to 9 | num. of digits after "dot" 0 to 4
  $regexValidation_TotalPrice = "^[-0-9.]{0,9}$"; // can start with a minus (some price fields are on purpouse negative) | first  pos. digits 1 to 9 | second and next pos. 1 to 9 | no other signs allowed | max 9 digits in total
  $regexValidation_Surface = "^[0-9]*([.][0-9]{0,4})$"; // cannot start with a minus | first and next pos. digits 0 to 9 | dot | first and next pos. digits 0 to 9 | num. of digits after "dot" 0 to 2
  $regexValidation_Dimensions = "^[1-9][0-9]{0,3}$"; // cannot start with a minus | first pos. digits 1 to 9 | next pos. digits 0 to 9 | num. of digits max = 4
  $regexValidation_UpsWindows = "^[0-9]{0,2}([.1-9]{0,3})$"; // cannot start with a minus | first pos. digits 0 to 9 | num. of digits max = 2
  $regexValidation_Percent = "^[1-9]{0,1}[0-9]{0,1}[0]{0,1}(|[.][0-9]{0,2})$"; // cannot start with a minus | first pos. digits 1 to 9 | next pos. digits 0 to 9 | next pos. digits 0 only | dot allowe but not necessary | next pos. digits 0 to 9| num. of digits max = 2
  $regexValidation_Times = "([-0-9]{0,2})*([:][0-9]{0,2})$"; // can start with a minus (some time fields are on purpouse negative) | first  pos. digits 0 to 9 | second and next pos. 0 to 9 | ":" required | third  pos. digits 0 to 9 | fourth pos. 0 to 9 | max 2 digits per each group
// End define RegEx validation

// BEGIN unknown variables
  $oc_p_cost_glotyna = "";

  $cost_minimum_mnoznik = "0";


  $cost_v_use = "0";
  $cost_v_speed = "0";
  $cost_v_cost_kg = "";
  $cost_v_cost_h = "0";

  $table = "";
  $area_id = "";
  $status = "";
  $audit_date = "";
  $audit_from = "";
  $audit_to = "";
  $audit_user = "";
  $plant_name = "";

  $user_leader_id = "";
  $table_data = "";
  $table_task_data = "";
  $check_dsc = "";
  $audit_dsc = "";
  $rt_id = "";

  $status_show = $txt_td_018;
  $input_add_task = "";
  $outsourcing_type_id = "";
  $proc_weight_material = 0;
  $td_show_1 = "none";
  $td_show_2 = "none";
  $td_show_laminaing = "none";
// END unknown variables

// BEGIN define automatic gluing variables
  $glue_automat_type_id = "";
  $cost_glue_automat = "0.00";
  $cost_minimum_auto_glue = "0";
  $cost_glue_automat_total = "0.00";
  $cost_glue_automat_real = "0.00";
  $cost_glue_automat_box = "0.00";
  $cost_glue_automat_info ="";

  $cost_trans_glue_automat = "0.00";
  $cost_trans_glue_automat_info = "";

  $automaticGluingSetupCostsReal=0;
  $automaticGluingSetupCosts=0;
  $automaticGluingSetupCostsInfo="";

  $automaticGluingIdleCostsReal=0;
  $automaticGluingIdleCosts=0;
  $automaticGluingIdleCostsInfo ="";

  $automaticGluingRunCostsReal=0;
  $automaticGluingRunCosts=0;
  $automaticGluingRunCostsInfo="";

  $automaticGluingSetupTime= "00:00";
  $automaticGluingRunTime= "00:00";
  $automaticGluingIdleTime= "00:00";
  $automaticGluingTotalTime= "00:00";

  $automaticGluingOutsourcing ="";

  $automaticGluingDifficulties_ShortBox='';
  $automaticGluingDifficulties_WideBox='';
  $automaticGluingDifficulties_LongBox='';
  $automaticGluingDifficulties_GluingTape='';
  $automaticGluingDifficulties_Window='';
  $automaticGluingDifficulties_Handle='';
  $automaticGluingDifficulties_FoiledFlap='';
  $automaticGluingDifficulties_Prefolding='';
  $automaticGluingDifficulties_Prefolding1pt='';
  $automaticGluingDifficulties_Prefolding2pt='';
  $automaticGluingDifficulties_eurSlot='';
  $automaticGluingDifficulties_multiAssortment='';
  $automaticGluingDifficulties_multiAssortmentNumber=0;
// END define automatic gluing variables

// BEGIN define outsourcing transportation costs
  $cost_transport_out = "0";
  $cost_trans_ink_varnish_special_out = "0.00";
  $cost_trans_ink_varnish_special_out_info = "";
  $cost_trans_glue_out = "0.00";
  $cost_trans_glue_info = "";

  $cost_trans_foil= "0.00";
  $cost_trans_foil_info = "";
  $cost_trans_falc = "0.00";
  $cost_trans_falc_info = "";
  $cost_trans_stample = "0.00";
  $cost_trans_stample_info = "";
  $cost_trans_bigowanie = "0.00";
  $cost_trans_bigowanie_info = "";
// END define outsourcing transportation costs

// BEGIN define rawMaterial variables
  $order_qty1 = "";
  $tolerant = "";
  $order_qty_new = "";
  $order_qty_name = "";
  $minimumQty = "";
  $chckMinimumQty = "";
  $maximumQty = "";
  $chckMaximumQty = "";
  $order_qty1_less = "";
  $order_qty1_less_procent = "";
  $netQty = ""; // the original qty the customer is ordering and we nee to fulfil
  $grossQty = ""; // $grossQty = $netQty + sum of all process scrap (additional sheets needed to setup each process)

// rawMaterial 1
  $paper_type_id1 = "0";
  $product_paper_id1 = "";
  $waste_proc1= "0";
  $product_paper_value1 = ""; // nesting - how many ups on sheet
  $product_paper_cut1 = "1"; // how many times is paper cut from original size
  $product_paper_cost_kg1 = "0.00";
  $paper1_weight=0;
  $sheetx1 = "0";
  $sheety1 = "0";
  $gram1 = "0";

  $cost_paper1 = "0.00";

// rawMaterial 2
  $paper_type_id2 = "0";
  $product_paper_id2 = "";
  $waste_proc2 = "0";
  $product_paper_value2 = "";
  $product_paper_cut2 = "1"; // how many times is paper cut from original size
  $product_paper_cost_kg2 = "0.00";
  $product_paper_cost_m22 = "0.00";
  $paper2_m2=0;
  $paper2_weight=0;
  $rawMaterial2_NetKG=0;
  $rawMaterial2_NetSQM=0;
  $sheetx2 = "0";
  $sheety2 = "0";
  $gram2 = "0";

  $cost_paper2 = "0.00";

// other rawMaterial variables
  $product_paper_cost_history = "";

  $waste_ark1 = "0";

// END define rawMaterial variables

//BEGIN define cutting variables
  $cost_cut_idle_real = "0.00";
  $cost_cut_jazda_info = "";
  $cost_cut_idle_info = "";
  $cost_cut_material = "0.00";
  $cost_cut = "0.00";
  $cost_minimum_cut = "0"; // minimum value
  $cost_cut_real = "0.00";

  $cut_cost_pln_h = "0";
  $cut_cost_speed = "0";
  $cost_cut_info = "";
  $cost_cut="0.00";
  $cost_cut_total_time = 0; // total cutting time calculation pre version 02
  $cutterRunTime="00:00";
  $cutterIdleTime="00:00";
  $cutterTotalTime="00:00";

//END define cutting variables

//BEGIN define cutting2 variables
  $check_cut2 = "yes";

  $cost_cut2_jazda_real = "0.00";
  $cost_cut2_idle_real = "0.00";
  $cost_cut2_jazda_info = "";
  $cost_cut2_idle_info = "";
  $cost_cut_jazda_real = "0.00";
  $cost_cut2_real = "0.00";
  $cost_cut2_info = "";
  $cost_cut2 = "0.00";
  $cut2_cost_speed = "0";
  $cost_cut2_total_time = 0; // total cutting time calculation pre version 02
  $cutter2RunTime="00:00";
  $cutter2IdleTime="00:00";
  $cutter2TotalTime="00:00";
//END define cutting2 variables

// BEGIN define printing variables
$cost_accept= "0.00"; // cost of CTP work
$new_grafic = "";    // type of CTP work
$cost_extra_plate2 = "0.00";
$cost_clicha_extra_info = "";
$cost_clicha_extra = "";

$cost_minimum_komori = "0";
$cost_minimum_roland = "0";

$print_machine_id = "1";
$print_machine_name = "Komori";
$print2_machine_id = "1";
$print2_machine_name = "Komori";
$extra_plate_komori = "";
$extra_plate_roland = "";
$cost_extra_plate = "0.00";
$cost_extra_plate_info = "";
$cost_plate = "0.00";
$cost_plate_info = "";

$awers_setup = "0";
$awers_speed = "0";
$awers_wasteP = "1";
$rewers_setup = "0";
$rewers_speed = "0";
$rewers_wasteP = "1";

// printing colors

  $awers_cmyk_qty_colors = "0";
  $awers_pms_qty_colors = "0";
  $awers_pms_sqmm = "100";
  $awers_pms_colors = "";

  $rewers_cmyk_qty_colors = "0";
  $rewers_pms_qty_colors = "0";
  $rewers_pms_sqmm = "100";
  $rewers_pms_colors = "";

  $awers2_cmyk_qty_colors="0";
  $awers2_pms_qty_colors="0";
  $awers2_pms_colors="";
  $awers2_pms_sqm="100";
  $awers2_pms_sqmm = "100";

  $rewers2_cmyk_qty_colors="0";
  $rewers2_pms_qty_colors="0";
  $rewers2_pms_colors="";
  $rewers2_pms_sqm="100";
  $rewers2_pms_sqmm = "100";


$awers_idle_narzadP = "0";
$awers_idle_jazdaP = "0";
$awers_idle_costH ="0";

$cost_awers_material = "0.00";
$cost_awers_material_clicha = "0.00";
$cost_awers_narzad_real = "0.00";
$cost_awers_narzad_info = "";
$cost_awers_jazda_real = "0.00";
$cost_awers_jazda_info = "";
$cost_awers_idle_real = "0.00";
$cost_awers_idle_info = "";
$cost_awers = "0.00";
$cost_awers_real = "0.00";

$cost_rewers_material = "0.00";
$cost_rewers_material_clicha= "0.00";
$cost_rewers_narzad_real = "0.00";
$cost_rewers_narzad_info = "";
$cost_rewers_jazda_real = "0.00";
$cost_rewers_jazda_info = "";
$cost_rewers_idle_real = "0.00";
$cost_rewers_idle_info = "";
$cost_rewers = "0.00";
$cost_rewers_real = "0.00";

$cost_awers2_material="0.00";
$cost_awers2_material_clicha="0.00";
$cost_awers2_narzad_real="0.00";
$cost_awers2_jazda_real="0.00";
$cost_awers2_idle_real="0.00";
$cost_awers2_real="0.00";
$cost_awers2="0.00";

$cost_rewers2_material="0.00";
$cost_rewers2_material_clicha="0.00";
$cost_rewers2_narzad_real="0.00";
$cost_rewers2_jazda_real="0.00";
$cost_rewers2_idle_real="0.00";
$cost_rewers2_real="0.00";
$cost_rewers2="0.00";

// calculation version < 02 times
$awers_prod_time=0;
$rewers_prod_time =0;
$awers2_prod_time=0;
$rewers2_prod_time =0;

// calculation version > 02 times
  $printingAwersTotalTime=0;
  $printingAwersIdleTime=0;
  $printingAwersRunTime=0;
  $printingAwersSetupTime=0;

  $printingRewersTotalTime=0;
  $printingRewersIdleTime=0;
  $printingRewersRunTime=0;
  $printingRewersSetupTime=0;

  $printingAwers2TotalTime=0;
  $printingAwers2IdleTime=0;
  $printingAwers2RunTime=0;
  $printingAwers2SetupTime=0;

  $printingRewers2TotalTime=0;
  $printingRewers2IdleTime=0;
  $printingRewers2RunTime=0;
  $printingRewers2TotalTime=0;



// END define printing 2 variables

// BEGIN define offset varnish variables
  $varnish_type_id = "";
  $varnish2_type_id="";

  $ink_varnish_id = "";
  $varnish_sqm_ark = "";

  $ink_varnish_cost = "0.00";
  $ink_varnish_dsc = "";
  $ink_varnish_sqm_ark = "";
  $cost_ink_varnish = "0.00";
  $cost_ink_varnish_sheet = "";

  $cost_varnish = "0.00";
  $cost_varnish_real= "0.00";
  $cost_varnish_material = "0.00";
  $cost_varnish_narzad_info = "";
  $cost_varnish_narzad_real = "0.00";
  $cost_varnish_jazda_info = "";
  $cost_varnish_jazda_real = "0.00";

  $cost_varnish_jazda_time=0; // total varnish 1 time calculation version pre 02
  $cost_varnish2_jazda_time=0;  // total varnish 2 time calculation version pre 02

  $cost_ink_varnish_special_real = "0.00";
  $cost_ink_varnish_special_material = "0.00";
  $cost_ink_varnish_special = "0.00";
  $cost_ink_varnish_special_out = "0.00";
  $cost_ink_varnish_special_out_info = "";
  $cost_ink_varnish_special_jazda_real = "0.00";
  $cost_ink_varnish_special_jazda_info = "";


// END define offset varnish variables

// BEGIN define UV varnish variables
  $varnish_uv_type_id = "";
  $varnish_uv_sqm_ark = "";

  $varnish_uv_cost_pln_kg = "0";
  $varnish_uv_pln_h = "0";
  $varnish_uv_speed = "0";

  $cost_vUV_use = "0";
  $cost_vUV_speed = "0";
  $cost_vUV_cost_kg = "";
  $cost_vUV_cost_h = "0";
  $cost_varnish_uv = "0.00";
  $cost_varnish_uv_real = "0.00";
  $cost_varnish_uv_material = "0.00";

  $cost_varnish_uv_narzad_real = "0.00";
  $cost_varnish_uv_narzad_info = "";
  $cost_varnish_uv_jazda_real = "0.00";
  $cost_varnish_uv_jazda_info = "";
  $cost_varnish_uv_idle_real = "0.00";
  $cost_varnish_uv_idle_info = "";

  $cost_varnish_uv_setup_time=0; //setup and production times calculation version pre 02
  $cost_varnish_uv_jazda_time=0; //setup and production times calculation version pre 02

  $varnishUVSetupTime=0;
  $varnishUVRunTime=0;
  $varnishUVIdleTime=0;
  $varnishUVTotalTime=0;
// END define UV varnish variables


// BEGIN defining foiling variables
  $foil_type_id = "";
  $foil_sqm_ark = "";
  $cost_foil = "0.00";
//END defining foiling variables

// BEGIN define hotStamping variables
    $gilding_type = "";
    $gilding_sqcm_box = "";
    $gilding_foil_cost_sqm = "0.00";
    $gilding_sqcm_matryc = "";
    $gilding_qty_matryc = "";
    $gilding_matryc_cost = "0.00";
    $gilding_work_cost = "0.00";
    $gilding_qty_point = "";

    $gilding_speed_id1="";
    $gilding_speed_id2="";
    $gilding_speed_id3="";
    $gilding_speed_id4="";

    $$gilding_qty1 = "1";
    $gilding_qty2 = "2";
    $gilding_qty3 = "3";
    $gilding_qty4 = "4";
    $gilding1_speed = 0;
    $gilding2_speed=0;
    $gilding3_speed=0;
    $gilding4_speed=0;
    $gilding_sqcm_matrycX_extra=0;
    $gilding_sqcm_matrycY_extra=0;

    // hotStamping material costs
      $cost_matryc1 = "0.00";
      $cost_matryc2 = "0.00";
      $cost_matryc3 = "0.00";
      $cost_matryc4 = "0.00";
    //hotrStamping setup and production costs
      $cost_matryc1_setup = "0.00";
      $cost_matryc2_setup = "0.00";
      $cost_matryc3_setup = "0.00";
      $cost_matryc4_setup = "0.00";

      $cost_matryc1_prod = "0.00";
      $cost_matryc2_prod = "0.00";
      $cost_matryc3_prod = "0.00";
      $cost_matryc4_prod = "0.00";

      $cost_matryc1_idle = "0.00";
      $cost_matryc2_idle = "0.00";
      $cost_matryc3_idle = "0.00";
      $cost_matryc4_idle = "0.00";

      $cost_matryc1_total = "0.00";
      $cost_matryc2_total = "0.00";
      $cost_matryc3_total = "0.00";
      $cost_matryc4_total = "0.00";

    // BEGIN setup and production times calculation version pre 02
      $cost_matryc1_setup_time=0;
      $cost_matryc1_prod_time=0;
      $cost_matryc2_setup_time=0;
      $cost_matryc2_prod_time=0;
      $cost_matryc3_setup_time=0;
      $cost_matryc3_prod_time=0;
      $cost_matryc4_setup_time=0;
      $cost_matryc4_prod_time=0;
    // END setup and production times calculation version pre 02

    // BEGIN hotStamping material costs
      $cost_gilding_material = "0.00";
      $cost_gilding_material_foil = "0.00";
      $cost_gilding = "0.00";
    // END hotStamping material costs
    $gilding_foil_speed_value = "1";
    $cost_gilding_narzad = "0.00";
    $cost_gilding_narzad_info = "";
    $cost_gilding_jazda_real = "0.00";
    $cost_gilding_jazda_info = "";
    $cost_gilding_idle_real = "0.00";
    $cost_gilding_idle_info = "";
    $cost_gilding_real = "0.00";

    $gilding_idleJp = "0";
    $gilding_idleNp = "0";
    $gilding_idle_cost= "0";

  $hotStampingSetupTime=0;
  $hotStampingRunTime=0;
  $hotStampingIdleTime=0;
  $hotStampingTotalTime=0;

// END define hotStamping variables

// BEGIN define manual gluing variables
  $glue_type_id = "";
  $glue_type_idleP = "0";

  $cost_glue = "0.00";
  $cost_glue = "";
  $cost_glue_box = "";
  $glue_cost_box = "0.00";

  $glue_type_idleP_cost = "0";
  $cost_glue_jazda_real = "0.00";
  $cost_glue_jazda_info = "";
  $cost_glue_idle_real = "0.00";
  $cost_glue_idle_info = "";

  $cost_glue_real = "0.00";
  // manual gluing modifiers
    $glue_type_slim_check = "";
    $glue_type_tape_check = "";
    $glue_type_window_check = "";
    $glue_type_handle_check = "";
    $glue_type_prefolding_check = "";
    $glue_type_foiledflap_check = "";

  $cost_glue_prod_time=0; // manual gluing production time calculation version pre 02
  $manualGluingSetupTime=0;
  $manualGluingRunTime=0;
  $manualGluingIdleTime=0;
  $manualGluingTotalTime=0;
  $manualGluingOutsourcing ="";
// END define manual gluing variables

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

// BEGIN define LithoLamination variables
  $laminating_cost_sqm = "";
  $laminating_x2 = "";
  $cost_minimum_laminating = "0";
  $cost_laminating_narzad_real = "0.00";
  $cost_laminating_idle_real = "0.00";
  $cost_laminating_idle_info = "";
  $cost_laminating_jazda_real = "0.00";
  $cost_laminating_narzad_info = "";
  $cost_laminating_jazda_info = "";
  $cost_laminating_material = "0.00";
  $cost_laminating_material_info = "";

  $cost_laminating = "0.00";
  $cost_laminating_real = "0.00";

    // BEGIN litholamination parameters gathered from calculations settings in db
    $kaszer_speed=0;
    $kaszer_cost=0;
    $kaszer_cost_narzad=0;
    $kaszer_cost_idle=0;
    $kaszer_cost_glue=0;
    $kaszer_narzad=0;
    $kaszer_idle_narzad=0;
    $kaszer_idle_jazda=0;
   // END litholamination parameters gathered from calculations settings in db

  $cost_laminating_setup_time=0; // lithoLamination setup time calculation version pre 02
  $cost_laminating_prod_time=0;  // lithoLamination production time calculation version pre 02
  $lithoLaminationSetupTime=0;
  $lithoLaminationRunTime=0;
  $lithoLaminationIdleTime=0;
  $lithoLaminationTotalTime=0;
// END define LithoLamination variables

// BEGIN define dieCutting 1 variables
  $cost_dicut = "0.00"; // tooling cost
  $dctool_cost = "0"; // tooling cost (??)
  $new_dctool = ""; // type of tooling
  $dieCuttingToolingTypeID = 0;
  $dieCuttingToolingStatusID =0;
  $dieCuttingToolingInvoicingID=0;

  $strippingToolingTypeID=0;
  $strippingToolingStatusID=0;
  $strippingToolingCost=0;
  $strippingToolingInvoicingID=0;

// tooling costs and invocing types
  $invoicedToolingCosts=0;
  $invoicedToolingCostsInfoString="";
  $hiddenToolingCosts =0;
  $hiddenToolingCosts_InPrice =0;
  $hiddenToolingCosts_CoveredBySupplier =0;
  $hiddenToolingCostInfo="";

  $cost_dcting_jazda_info = "";
  $cost_dcting_jazda_real = "0.00";
  $cost_dcting_idle_real ="0.00";
  $cost_dcting_idle_info = "";
  $cost_dcting_narzad_info = "";
  $cost_dcting_narzad_real = "0.00";
  $cost_dcting_real="0.00";
  $cost_dcting = "0.00";
  $cost_dcting = "0.00";

  $cost_dcting_setup_time=0;   // dieCutting setup time calculation version pre 02
  $cost_dcting_prod_time=0;   // dieCutting production time calculation version pre 02
  $dieCuttingSetupTime=0;
  $dieCuttingRunTime=0;
  $dieCuttingIdleTime=0;
  $dieCuttingTotalTime=0;
// END define dieCutting 2 variables

// BEGIN define dieCutting 2 variables
  $cost_dcting2_jazda_info = "";
  $cost_dcting2_jazda_real = "0.00";
  $cost_dcting2_idle_real ="0.00";
  $cost_dcting2_idle_info = "";
  $cost_dcting2_narzad_info = "";
  $cost_dcting2_narzad_real = "0.00";
  $cost_dcting2_real="0.00";
  $cost_dcting2 = "0.00";

  $cost_dcting2_setup_time=0; // dieCutting setup time calculation version pre 02
  $cost_dcting2_prod_time=0;  // dieCutting production time calculation version pre 02
  $dieCutting2SetupTime=0;
  $dieCutting2RunTime=0;
  $dieCutting2IdleTime=0;
  $dieCutting2TotalTime=0;
// END define dieCutting 2 variables

// BEGIN define window pachting variables
  $cost_minimum_window = 0;
  $windowPatchingType ="";
  $window_glue_cost_box = "0.00";
  $window_glue_timeS_box = "";
  $cost_window_glue_prod_time = 0;

  $manual_work_window_id = "";
  $cost_window = "0.00";
  $cost_window_info = "0.00";

  $cost_window_foil = 0;
  $window_foil_sqm = "0.00";
  $cost_window_foil_info = "";
  //$cost_trans_window = "0.00";
  //$cost_trans_window_info = "";

  $externalWindowPatching_info = "";
  $externalWindowPatching = 0;
  $externalWindowPatchingTransport_info = "";
  $externalWindowPatchingTransport = 0;


// END define window pachting variables

// BEGIN define falzen variables
  $cost_falc = "0.00";
  $falc_cost_box = "0.00";
  $falc_cost = "0.00";
// END define falzen variables

// BEGIN define biegen variables
  $biga_cost_box = "0.00";
  $cost_bigowanie = "0.00";
// END define biegen variables

// BEGIN define stappling variables
  $cost_stample = "0.00";
  $stample_cost = "0.00";
  $stample_cost_box = "0.00";
// END define stappling variables

// BEGIN define transportation cost variables
  $transport_type_id = "";
  $transport_km = "";
  $transport_dsc = "";
  $cost_transport = "0.00";
  $cost_transport_box = "";
  $cost_transport_total = "";
  $order_total_weight = "";
// END define transportation cost variables

// BEGIN define other/ extra cost variables
  $extra_cost = "";
  $cost_other1 = "0.00";
  $cost_other2 = "0.00";
  $cost_extra = "0.00";
  $cost_total_dodatek= "0.00";
  $cost_total_dodatek_info = "";
// END define other/ extra cost variables

// BEGIN define standard margin and comission values
  $margin_pln = "0";
  $cost_margin_unit = 0;
  $margin = "0";
  $margin_new = "";
  $margin_pln_new = "";
  $cost_margin = "0.00";
  $cost_prowizja7 = "0.00";
  $cost_prowizja10 = "0.00";
  $cost_prowizja15 = "0.00";
  $cost_2_5 = "0.00";
  $cost_margin_1_3 = "0.00";
  $cost_goods = "0.00";
// END define standard margin and comission values

// BEGIN define standard calculation variables
  $cost_total_total = "0.00";
  $cost_administracja = "0.00";
  $cost_podatek = "0.00";
  $cost_sum_narzut = "0.00";
  $cost_minimum = "0";
  $cost_administracja1 = "0.00";
  $cost_administracja_from1= "0.00";
  $cost_administracja_to1 = "0.00";

  $cost_administracja2 = "0.00";
  $cost_administracja_from2 = "0.00";
  $cost_administracja_to2 = "0.00";

  $cost_podatek1 = "0.00";
  $cost_podatek_from1 = "0.00";
  $cost_podatek_to1 = "0.00";
  $cost_podatek2 = "0.00";
  $cost_podatek_from2 = "0.00";
  $cost_podatek_to2 = "0.00";

  $cost_total_operation2 = "0.00";
  $cost_total_material2 = "0.00";
  $cost_total_pozostale = "0.00";
  $cost_total_pozostale_info = "";

  $cost_total_material = "0.00";
  $cost_total_operation = "0.00";
  $cost_bep = "0.00";
  $cost_bep_one = "0.0000";
  $cost_total_out = "0.00";
  $cost_transport_to_out = "0.00";
  $cost_sales = "0.00";
  $cost_sales_one = "0.0000";
  $cost_sales_one_write = "";
// END define standard calculation variables

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
  $throughput_comission_info = "";
  $throughput_comission_percent="0.00";
/*
  $throughput_deduct = "0.00";
  $throughput_deduct_info = "";
  $throughput_deduct_total = "0.00";
  $throughput_deduct_desc = "";
*/
  $throughput_threshold_fixed="0.00";
  $throughput_threshold_fixed_per_sheet="0.00";

  $throughput_to_sales ="0.00";
  $throughput_to_sales_threshold ="0.00";
  $throughput_to_sales_warningLevel="0.00";

  $throughput_per_labour ="0.00";
  $throughput_per_labour_threshold="0.00";
  $throughput_per_labour_warningLevel="0.00";

  $operationTimeCorrection = "00:00";
  $operationTimeCorrectionInfo = "";
  $operationTimeCorrectionDsc = "";

  $totalSetupTime = "00:00";
  $totalRunTime = "00:00";
  $totalIdleTime = "00:00";
  $totalOperationTime = "00:00";

// END defining throughput calculation variables

IF (isset($_GET['customer_id'])) { $customer_id = $_GET['customer_id']; }

$order_to_customer_exist = ""; $file_all ="";
$cost_extra_matryce = "0.00"; $gilding_box_matryce = "checked";
$cost_extra_matryce_KD = "0.00"; $cost_extra_matryce_KPoz = "0.00";  $cost_extra_matryce_extra = "0.00";

$input_copy_data = "";

IF ($oc_id) {
          $sql = "SELECT ocd.customer_id, customers.short_name, ocd.customerOrder, ocd.status, ocd.create_user, ocd.create_date, ocd.end_date, ocd.name, ocd.dsc, ocd.order_nr
                  FROM order_calculations ocd
                  LEFT join customers on customers.customer_id = ocd.customer_id
                  WHERE oc_id='$oc_id' "; //echo "$sql<BR>";
          $result = @mysql_query($sql, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_show.php -> show -> READ order_calculation_list]<BR>$sql");
            while ($row = mysql_fetch_array($result)) {

              //$create_date        = $row['create_date'];  //NOTE: this part was substituting current date (on opening of calculation) with the day the calculation was created thus each old calculation gets inaccurate (old parameters) read from order_calculation_setting
              $customer_id        = $row['customer_id'];
              $customerShortName  = $row['short_name'];
              $customerOrder      = $row['customerOrder'];
              $end_date           = $row['end_date'];
              $create_user        = $row['create_user'];
              $order_nr           = $row['order_nr'];
              $name               = $row['name'];
              $status             = $row['status'];
              $dsc                = $row['dsc'];
          }
          ReadUser($connection,$create_user,$create_user_fe,$create_user_le,$t,$t,$t,$t);
          $status_show = ReadOrderCalculationStatuses($connection,$status,"audit_plans",$lang_id);

// Create sql call to populate variable table with all data from order_calculation_datas
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
          $sql_file = "SELECT file_id, file_name, status
                       FROM order_calculation_files
                       WHERE oc_id='$oc_id' AND status>'0' AND status<'100'
                       ORDER BY file_id ASC"; //echo "$sql_tf<BR>";
          $result_file = @mysql_query($sql_file, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_show.php -> show -> SELECT files]");
            while ($row_file = mysql_fetch_array($result_file)) {
                   $file_id      = $row_file['file_id'];
                   $file_names   = $row_file['file_name'];
                   $file_status  = $row_file['status'];
                   $rozszerzenie = FindExt($file_names);
                   $ico = FindIco($rozszerzenie);
                   $link = $sciezka . substr($file_id,0,6) ."/". $file_id . $rozszerzenie;
                   $file_lists = "<A href=\"$link\" target=_blank style=\"text-decoration: none;\"><IMG SRC=\"./icon/$ico\" width=12 border=0> $file_names</A><BR>";
                   //echo "$file_id -- $file_name<BR>";
                   switch ($file_status) {
                      case "10": $file_lists10 .= $file_lists; break;
                      case "30": $file_lists30 .= $file_lists; break;
                      case "60": $file_lists60 .= $file_lists; break;
                   }

          }
          mysql_free_result($result_file);
          $file_all .= $file_lists10;

      // BEGIN: looking for variables passed from the matrix of qty section in order_calculation_show_qty.php
        // NOTE: this part looks for order qty new and margin qty in the GET to launch calculation and recalculate sales
          
          // check if new order qty passed through GET and if so run calculations accordingly
          IF (isset($_GET['order_qty_new'])) {
            // populate variables
              $order_qty_new  = $_GET['order_qty_new'];
              $order_qty_name = $_GET['order_qty_name'];
            // assign variable value from GET to the current qrder qty in calculation
              $order_qty1 = $order_qty_new;
            // check if margin in percentage was passed through GET and if so run calculations accordingly
              IF (isset($_GET['margin_new'])) { 
                $margin_new = $_GET['margin_new']; 
              } else { 
                $margin_new = $margin; 
              }
            // assign variable value from GET to the current qrder qty in calculation
              $margin = $margin_new;
            // check if margin in PLN was passed through GET and if so run calculations accordingly
              IF (isset($_GET['margin_pln_new'])) { 
                $margin_pln_new = $_GET['margin_pln_new']; 
              } else { 
                $margin_pln_new = $margin_pln; 
              }
            // assign variable value from GET to the current qrder qty in calculation
              $margin_pln = $margin_pln_new;
          }
        // TODO: what does this part do ??? order_qty_chang is passed through GET from order_calculation_show_qty.php
          IF (isset($_GET['order_qty_change'])) {
            // populate variables  
              $order_qty_change = $_GET['order_qty_change'];
            // assign variable value from GET to the current qrder qty in calculation
              $order_qty1       = $order_qty_change;
            // check if margin in percentage was passed through GET and if so run calculations accordingly
              IF (isset($_GET['margin_new'])) { 
                $margin_new = $_GET['margin_new']; 
              } else { 
                $margin_new = $margin; 
              }
            // assign variable value from GET to the current qrder qty in calculation
              $margin = $margin_new;
            // check if margin in PLN was passed through GET and if so run calculations accordingly 
              IF (isset($_GET['margin_pln_new'])) { 
                $margin_pln_new = $_GET['margin_pln_new']; 
              } else { 
                $margin_pln_new = $margin_pln; 
              }
            // assign variable value from GET to the current qrder qty in calculation
              $margin_pln = $margin_pln_new;
          }
      // END: looking for variables passed from the matrix of qty section in order_calculation_show_qty.php
          $powrot = "./order_calculation_show.php?action=show&oc_id=$oc_id\" style=\"font-size: 12px;\">Cofnij";

          IF ($gilding_box_matryce) { $gilding_box_matryce = "checked"; } else { $gilding_box_matryce = ""; }

} else {
    $input_copy_data = "<A href=\"order_calculation_create.php?action=copy&back=$back\" style=\"text-decoration: none; font-size: 12px;\">Kopiuj dane do kalkulacji</A>&nbsp;&nbsp;&nbsp;";
}

$input_add_customer = "<A href=\"customers.php?action=show&option=new_calculation&oc_id=$oc_id\" style=\"text-decoration: none; font-size: 12px;\">dodaj nowego klienta</A>";
//$status7301 = ""; CheckAccessToMenu($connection,$userlevel_id,"12_3_0_1",$status7301);

//IF (!$gilding_box) {
    // $gilding_box1 = "disabled"; $gilding_box2 = "disabled"; $gilding_box3 = "disabled"; $gilding_box4 = "disabled";
//} else {
  $gilding_box0 = "checked";
  IF ($gilding_box1 == "1") { $gilding_box1 = "checked"; $gilding_box0 = ""; }
  IF ($cost_matryc1_total == "0.00") { $gilding_box1 .= " disabled"; }
  IF ($gilding_box2 == "2") { $gilding_box2 = "checked"; $gilding_box0 = ""; }
  IF ($cost_matryc2_total == "0.00") { $gilding_box2 .= " disabled"; }
  IF ($gilding_box3 == "3") { $gilding_box3 = "checked"; $gilding_box0 = ""; }
  IF ($cost_matryc3_total == "0.00") { $gilding_box3 .= " disabled"; }
  IF ($gilding_box4 == "4") { $gilding_box4 = "checked"; $gilding_box0 = ""; }
  IF ($cost_matryc4_total == "0.00") { $gilding_box4 .= " disabled"; }

$new_dctool_new = ""; $new_dctool_old = "";
switch ($new_dctool) {
   case ""     : $new_dctool_new = "checked"; $new_dctool_0 = "selected"; break;
   case "new"  : $new_dctool_new = "checked"; $new_dctool_1 = "selected"; break;
   case "old"  : $new_dctool_old = "checked"; $new_dctool_2 = "selected"; break;
   case "brak" : $new_dctool_old = "checked"; $new_dctool_3 = "selected"; break;
   case "mod" : $new_dctool_old = "checked"; $new_dctool_4 = "selected"; break;
}
/*$list_dctool_select  = "<OPTION $new_dctool_0 VALUE=\"\">-- $txt_check_02 --</OPTION>";
$list_dctool_select .= "<OPTION $new_dctool_3 VALUE=\"brak\">$txt_check_01</OPTION>";
$list_dctool_select .= "<OPTION $new_dctool_1 VALUE=\"new\">nowy</OPTION>";
$list_dctool_select .= "<OPTION $new_dctool_2 VALUE=\"old\">istniejący</OPTION>";
$list_dctool_select .= "<OPTION $new_dctool_4 VALUE=\"mod\">modyfikacja</OPTION>";
*/
$new_grafic_new = ""; $new_grafic_old = "";
switch ($new_grafic) {
   case ""     : $new_grafic_new = "checked"; $new_grafic_0 = "selected"; break;
   case "new"  : $new_grafic_new = "checked"; $new_grafic_1 = "selected"; break;
   case "old"  : $new_grafic_old = "checked"; $new_grafic_2 = "selected"; break;
   case "brak" : $new_grafic_old = "checked"; $new_grafic_3 = "selected"; break;
}
$list_grafic_select  = "<OPTION $new_grafic_0 VALUE=\"\">-- $txt_check_02 --</OPTION>";
$list_grafic_select .= "<OPTION $new_grafic_3 VALUE=\"brak\">$txt_check_01</OPTION>";
$list_grafic_select .= "<OPTION $new_grafic_1 VALUE=\"new\">nowa</OPTION>";
$list_grafic_select .= "<OPTION $new_grafic_2 VALUE=\"old\">istniejąca</OPTION>";

$calc_type1 = ""; $calc_type0 = "";
switch ($calc_type) {
   case ""      : $calc_type1 = "checked"; break;
   case "full"  : $calc_type1 = "checked"; break;
   case "view"  : $calc_type0 = "checked"; break;
}

//}
$list_status        = SelectOrderCalculationStatuses($connection,"1","1","audit_plans","status_id ASC",$txt_check_01,$status,$lang_id);
$list_customers     = SelectOrderCalculationCustomerName($connection,"0","1",$customer_id,"",$txt_check_01,$lang_id);
//$list_accept_type = SelectOrderCalculationPAccetpTypes($connection,"0","1",$accept_type_id,"",$txt_check_01,$lang_id);
$list_accept_type   = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_print_accept_types",$accept_type_id,"",$txt_check_01,$lang_id);
$list_window_foil_type   = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_window_foil_type",$window_foil_type_id,"",$txt_check_01,$lang_id);
//typy produktów
$list_order_types   = SelectOrderCalculationOrderData($connection,"0","1",$order_type,"AND var='Z_Typ'",$txt_check_01,$lang_id);
$list_order_types   = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_product_types",$order_type_id,"",$txt_check_01,$lang_id);
$list_manual_work_windows = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_manual_work_windows",$manual_work_window_id,"",$txt_check_01,$lang_id);

$list_products10    = SelectOrderCalculationProducts($connection,"0","1",$product_paper_id1,"10","",$txt_check_01);
$list_paper1        = SelectOrderCalculationPaperTable($connection,"0","1",$paper_id1,"",$txt_check_01,$lang_id);
$list_gram1         = SelectOrderCalculationPaperGramTable($connection,"0","1",$paper_gram_id1,"","-",$lang_id);
$list_format1       = SelectOrderCalculationFormaTypes($connection,"0","1",$format_id1,"",$txt_check_01,$lang_id);
$list_products20    = SelectOrderCalculationProducts($connection,"0","1",$product_paper_id2,"20","",$txt_check_01);
$list_paper2        = SelectOrderCalculationPaperTable($connection,"0","1",$paper_id2,"",$txt_check_02,$lang_id);
$list_gram2         = SelectOrderCalculationPaperGramTable($connection,"0","1",$paper_gram_id2,"","-",$lang_id);
$list_format2       = SelectOrderCalculationFormaTypes($connection,"0","1",$format_id2,"",$txt_check_02,$lang_id);
$list_varnish       = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_varnish_types",$varnish_type_id,"",$txt_check_01,$lang_id);
$list_varnish2      = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_varnish_types",$varnish2_type_id,"",$txt_check_01,$lang_id);
$list_varnish_uv    = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_varnish_uv_types",$varnish_uv_type_id,"",$txt_check_01,$lang_id);
$list_ink_varnish   = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_ink_varnish",$ink_varnish_id,"",$txt_check_01,$lang_id);
$list_ink_varnish_types   = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_ink_varnish_types",$ink_varnish_type_id,"",$txt_check_01,$lang_id);
$list_foil_types    = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_foil_types",$foil_type_id,"",$txt_check_01,$lang_id);
$list_gilding_speeds1= SelectOrderCalculationTableNameList($connection,"1","1","order_calculation_gilding_speeds",$gilding_speed_id1,"",$txt_check_01,$lang_id);
$list_gilding_speeds2= SelectOrderCalculationTableNameList($connection,"1","1","order_calculation_gilding_speeds",$gilding_speed_id2,"",$txt_check_01,$lang_id);
$list_gilding_speeds3= SelectOrderCalculationTableNameList($connection,"1","1","order_calculation_gilding_speeds",$gilding_speed_id3,"",$txt_check_01,$lang_id);
$list_gilding_speeds4= SelectOrderCalculationTableNameList($connection,"1","1","order_calculation_gilding_speeds",$gilding_speed_id4,"",$txt_check_01,$lang_id);
$list_gilding_types1= SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_types",$gilding_type_id1,"",$txt_check_01,$lang_id);
$list_gilding_types2= SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_types",$gilding_type_id2,"",$txt_check_01,$lang_id);
$list_gilding_types3= SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_types",$gilding_type_id3,"",$txt_check_01,$lang_id);
$list_gilding_types4= SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_types",$gilding_type_id4,"",$txt_check_01,$lang_id);
$list_gilding_types5= SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_types",$gilding_type_id5,"",$txt_check_01,$lang_id);
$list_gilding_jump1 = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_jumps",$gilding_jump_id1,"",$txt_check_01,$lang_id);
$list_gilding_jump2 = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_jumps",$gilding_jump_id2,"",$txt_check_01,$lang_id);
$list_gilding_jump3 = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_jumps",$gilding_jump_id3,"",$txt_check_01,$lang_id);
$list_gilding_jump4 = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_jumps",$gilding_jump_id4,"",$txt_check_01,$lang_id);
$list_gilding_jump5 = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_jumps",$gilding_jump_id5,"",$txt_check_01,$lang_id);
$list_gilding_sqmm1 = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_sqmm",$gilding_sqmm_id1,"",$txt_check_01,$lang_id);
$list_gilding_sqmm2 = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_sqmm",$gilding_sqmm_id2,"",$txt_check_01,$lang_id);
$list_gilding_sqmm3 = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_sqmm",$gilding_sqmm_id3,"",$txt_check_01,$lang_id);
$list_gilding_sqmm4 = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_sqmm",$gilding_sqmm_id4,"",$txt_check_01,$lang_id);
$list_gilding_sqmm5 = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_gilding_sqmm",$gilding_sqmm_id5,"",$txt_check_01,$lang_id);
$list_gilding_qty1  = SelectOrderCalculationNumbers($connection,"1","1","8","1",$gilding_qty1,$txt_check_01,$lang_id);
$list_gilding_qty2  = SelectOrderCalculationNumbers($connection,"1","1","8","1",$gilding_qty2,$txt_check_01,$lang_id);
$list_gilding_qty3  = SelectOrderCalculationNumbers($connection,"1","1","8","1",$gilding_qty3,$txt_check_01,$lang_id);
$list_gilding_qty4  = SelectOrderCalculationNumbers($connection,"1","1","8","1",$gilding_qty4,$txt_check_01,$lang_id);
$list_glue_types    = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_glue_types",$glue_type_id,"",$txt_check_01,$lang_id);
$list_automat_glue_types    = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_automatic_gluing_types",$glue_automat_type_id,"",$txt_check_01,$lang_id);
// Populate dropdowns for die cutting
  $dieCuttingProcessTypeList  = fillCalculationDropdowns(0,1,8,$dctool_type_id,$txt_check_01);
  $dieCuttingToolingList  = fillCalculationDropdowns(0,1,1,$dieCuttingToolingTypeID,$txt_check_01); //
  $dieCutting2ProcessTypeList  = fillCalculationDropdowns(0,1,8,$dctool2_type_id,$txt_check_01);
  $dieCutting2ToolingList  = fillCalculationDropdowns(0,1,1,$dieCutting2ToolingTypeID,$txt_check_01); //
  $dieCuttingToolingStatusList  = fillCalculationDropdowns(0,1,4,$dieCuttingToolingStatusID,$txt_check_01);
  $dieCutting2ToolingStatusList  = fillCalculationDropdowns(0,1,4,$dieCutting2ToolingStatusID,$txt_check_01);
  $dieCuttingToolingInvoicingList  = fillCalculationDropdowns(0,1,9,$dieCuttingToolingInvoicingID,$txt_check_01);
// Populate dropdowns for stripping
  $strippingToolingList  = fillCalculationDropdowns(0,1,2,$strippingToolingTypeID,$txt_check_01);
  $strippingToolingStatusList  = fillCalculationDropdowns(0,1,4,$strippingToolingStatusID,$txt_check_01);
  $strippingToolingInvoicingList  = fillCalculationDropdowns(0,1,9,$strippingToolingInvoicingID,$txt_check_01);
// Populate dropdowns for separation
  $separationProcessTypeList  = fillCalculationDropdowns(0,6,10,$separationProcessTypeID,$txt_check_01);
  $separationToolingList  = fillCalculationDropdowns(0,6,3,$separationToolingTypeID,$txt_check_01);
  $separationToolingStatusList  = fillCalculationDropdowns(0,6,4,$separationToolingStatusID,$txt_check_01);
  $separationToolingInvoicingList  = fillCalculationDropdowns(0,6,9,$separationToolingInvoicingID,$txt_check_01);
// Populate dropdowns for transportation
$list_transport_types    = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_transport_types",$transport_type_id,"",$txt_check_01,$lang_id);
//$list_out = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_outsourcing_types",$outsourcing_type_id,"",$txt_check_01,$lang_id);
$list_out = "";
$Osql = "SELECT table_id, name, status
         FROM order_calculation_outsourcing_types
         ORDER BY table_id ASC"; //echo "$sql<BR>";
$Oresult = @mysql_query($Osql, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_show.php -> show -> READ order_calculation_list]<BR>$Osql<BR>".mysql_error());
   while ($Orow = mysql_fetch_array($Oresult)) {
      $o_name        = $Orow['name'];
      $o_table_id    = $Orow['table_id'];
      $o_status      = $Orow['status'];
      $o_status_dis="";
      IF ($o_status == 0) { $o_status_dis = "disabled"; }
      $o_status_check="";
      $o_name_ = "outsorcing_type_".$o_table_id;
      IF ($$o_name_ == 10) { $o_status_check = "checked"; }
      $list_out .= "<INPUT $o_status_dis NAME=$o_name_ id=$o_name_ TYPE=checkbox VALUE=\"10\" CLASS=a $o_status_check onchange=\"javascript:order_qty_write('')\">".$o_name.";&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}

// get data on additional setups in a calculation
// additional sheets used for addtiional setup
  ReadOrderCalculationSettings($connection,"","AND var='oc_p_arkToPlateExtra' AND date_from <='$create_date'  ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$ark_extra_plate,$value_from,$value_to,$date_from,$date_to);
// standard number of colors
  ReadOrderCalculationSettings($connection,"","AND var='oc_p_standardQtyColor' AND date_from <= '$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$standardQtyColor,$value_from,$value_to,$date_from,$date_to);
// additional setup time multiplication
  ReadOrderCalculationSettings($connection,"","AND var='oc_p_standardQtyColorTimeC' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$standardQtyColorTimeC,$value_from,$value_to,$date_from,$date_to);

ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_plate_komori' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_plate_komori,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_plate_roland' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_plate_roland,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_print_komori' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_print_komori,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_print_roland' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_print_roland,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_print_komoriN' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_print_komoriN,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_print_rolandN' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_print_rolandN,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_ink_cmyk' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_ink_cmyk,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_ink_pms' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_ink_pms,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_ink_use' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$use_ink,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_ink_qty_komori' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$ink_qty_komori,$value_from,$value_to,$date_from,$date_to);


//ReadOrderCalculationSettings($connection,"","AND var='oc_p_ink_special_cost' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_ink_special,$value_from,$value_to,$date_from,$date_to);
//ReadOrderCalculationSettings($connection,"","AND var='oc_p_ink_special_use' AND date_from<='$create_date' RDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$use_ink_special,$value_from,$value_to,$date_from,$date_to);

//ReadOrderCalculationSettings($connection,"","AND var='oc_p_varnish_uv_cost' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$varnish_uv_cost_pln_kg,$value_from,$value_to,$date_from,$date_to);
//ReadOrderCalculationSettings($connection,"","AND var='oc_p_varnish_uv_cost_h' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$varnish_uv_cost_pln_h,$value_from,$value_to,$date_from,$date_to);
//ReadOrderCalculationSettings($connection,"","AND var='oc_p_varnish_uv_speed' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$varnish_uv_speed,$value_from,$value_to,$date_from,$date_to);

//ReadOrderCalculationSettings($connection,"","AND var='oc_p_ink_special_cost' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$ink_varnish_cost_pln_kg,$value_from,$value_to,$date_from,$date_to);
//ReadOrderCalculationSettings($connection,"","AND var='oc_p_ink_special_cost_time' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$ink_varnish_cost_pln_h,$value_from,$value_to,$date_from,$date_to);
//ReadOrderCalculationSettings($connection,"","AND var='oc_p_ink_special_speed' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$ink_varnish_speed,$value_from,$value_to,$date_from,$date_to);
//ReadOrderCalculationSettings($connection,"","AND var='oc_p_ink_special_use' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$ink_varnish_use,$value_from,$value_to,$date_from,$date_to);

ReadOrderCalculationSettings($connection,"","AND var='oc_p_gild_setup_time' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_setup_h_matryc,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gild_cost_matrycy' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_cost_matryc_pln_cm2,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gilding_cost_h' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_cost_pln_h,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gilding_cost_hN' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_cost_pln_hN,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gild_speed' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_speed,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gild_speed2' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_speed2,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gild_cost_matryc_min' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_minimum_cost_matryca_pln,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gild_cost_job' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_minimum_cost_job_pln,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gild_idleNp' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_idleNp,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gild_idleJp' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_idleJp,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gild_idle_cost' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_idle_cost,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gilding_foil_speed_value' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_foil_speed_value,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gilding_sqcm_matrycX_extra' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_sqcm_matrycX_extra,$value_from,$value_to,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_gilding_sqcm_matrycY_extra' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$gilding_sqcm_matrycY_extra,$value_from,$value_to,$date_from,$date_to);

ReadOrderCalculationSettings($connection,"","AND var='oc_p_fromTo_admin_cost_p1' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_administracja1,$cost_administracja_from1,$cost_administracja_to1,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_fromTo_admin_cost_p2' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_administracja2,$cost_administracja_from2,$cost_administracja_to2,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_fromTo_credit_cost_p1' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_podatek1,$cost_podatek_from1,$cost_podatek_to1,$date_from,$date_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_fromTo_credit_cost_p2' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_podatek2,$cost_podatek_from2,$cost_podatek_to2,$date_from,$date_to);

ReadOrderCalculationSettings($connection,"","AND var='oc_p_not_less_qty_procent' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$order_qty1_less_procent,$order_qty1_less_procent_from2,$order_qty1_less_procent_to2,$order_qty1_less_procent_from,$order_qty1_less_procent_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_glotyna' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cut_cost_pln_h,$oc_p_cost_glotyna_from2,$oc_p_cost_glotyna_to2,$oc_p_cost_glotyna_from,$oc_p_cost_glotyna_to);

///minimalki
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_minimum_komori' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_minimum_komori,$cost_minimum_komori_from2,$cost_minimum_komori_to2,$cost_minimum_komori_from,$cost_minimum_komori_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_minimum_roland' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_minimum_roland,$cost_minimum_roland_from2,$cost_minimum_roland_to2,$cost_minimum_roland_from,$cost_minimum_roland_to);
///minimum koszt łączny za arkusz
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_minimum_paper' AND date_from<='$create_date'  ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_minimum_arkusz,$cost_minimum_arkusz_from2,$cost_minimum_arkusz_to2,$cost_minimum_arkusz_from,$cost_minimum_arkusz_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_minimum_auto_glue' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_minimum_auto_glue,$cost_minimum_auto_glue_from2,$cost_minimum_auto_glue_to2,$cost_minimum_auto_glue_from,$cost_minimum_auto_glue_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_minimum_cut' AND date_from<='$create_date'  ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_minimum_cut,$cost_minimum_cut_from2,$cost_minimum_cut_to2,$cost_minimum_cut_from,$cost_minimum_cut_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_minimum_window' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_minimum_window,$cost_minimum_window_from2,$cost_minimum_window_to2,$cost_minimum_window_from,$cost_minimum_window_to);

ReadOrderCalculationSettings($connection,"","AND var='oc_p_dcting_minimum1' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_minimum_dcting1,$value_from,$value_to,$date_from,$date_to);//iberica
ReadOrderCalculationSettings($connection,"","AND var='oc_p_dcting_minimum2' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_minimum_dcting2,$value_from,$value_to,$date_from,$date_to);//tyg mały
ReadOrderCalculationSettings($connection,"","AND var='oc_p_dcting_minimum3' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_minimum_dcting3,$value_from,$value_to,$date_from,$date_to);//tyg duzy

ReadOrderCalculationSettings($connection,"","AND var='oc_p_kaszer_minimum' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_minimum_laminating,$cost_minimum_lamin_from2,$cost_minimum_lamin_to2,$cost_minimum_lamin_from,$cost_minimum_lamin_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_kaszer_narzad' AND date_from<='$create_date'  ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$kaszer_narzad,$cost_minimum_lamin_from2,$cost_minimum_lamin_to2,$cost_minimum_lamin_from,$cost_minimum_lamin_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_kaszer_speed' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$kaszer_speed,$cost_minimum_lamin_from2,$cost_minimum_lamin_to2,$cost_minimum_lamin_from,$cost_minimum_lamin_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_kaszer_cost' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$kaszer_cost,$cost_minimum_lamin_from2,$cost_minimum_lamin_to2,$cost_minimum_lamin_from,$cost_minimum_lamin_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_kaszer_cost_glue' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$kaszer_cost_glue,$cost_minimum_lamin_from2,$cost_minimum_lamin_to2,$cost_minimum_lamin_from,$cost_minimum_lamin_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_kaszer_cost_narzad' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$kaszer_cost_narzad,$cost_minimum_lamin_from2,$cost_minimum_lamin_to2,$cost_minimum_lamin_from,$cost_minimum_lamin_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_kaszer_cost_idle' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$kaszer_cost_idle,$cost_minimum_lamin_from2,$cost_minimum_lamin_to2,$cost_minimum_lamin_from,$cost_minimum_lamin_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_kaszer_idle_narzad' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$kaszer_idle_narzad,$cost_minimum_lamin_from2,$cost_minimum_lamin_to2,$cost_minimum_lamin_from,$cost_minimum_lamin_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_kaszer_idle_jazda' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$kaszer_idle_jazda,$cost_minimum_lamin_from2,$cost_minimum_lamin_to2,$cost_minimum_lamin_from,$cost_minimum_lamin_to);
$list_laminating_sqm    = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_kaszer_sqm",$laminating_sqm_id,"",$txt_check_01,$lang_id);
$list_laminating_types  = SelectOrderCalculationTableNameList($connection,"0","1","order_calculation_kaszer_types",$laminating_type_id,"",$txt_check_01,$lang_id);

///gdzie towłączyć??

///materiał na lakierowanie sitem
//ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_sito_material' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_sita,$cost_sita_from2,$cost_sita_to2,$cost_sita_from,$cost_sita_to);

///klejenie - wielkość formatu B1 sqm
ReadOrderCalculationSettings($connection,"","AND var='oc_p_glue_type_b1sqm' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$glue_type_b1_sqm,$cost_sita_from2,$cost_sita_to2,$cost_sita_from,$cost_sita_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_glue_type_cost' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$glue_type_cost_h,$cost_sita_from2,$cost_sita_to2,$cost_sita_from,$cost_sita_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_glue_type_foil' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$glue_type_foil,$cost_sita_from2,$cost_sita_to2,$cost_sita_from,$cost_sita_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_glue_type_slim' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$glue_type_slim,$cost_sita_from2,$cost_sita_to2,$cost_sita_from,$cost_sita_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_glue_type_sur2' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$glue_type_sur2,$cost_sita_from2,$cost_sita_to2,$cost_sita_from,$cost_sita_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_glue_type_tape' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$glue_type_tape,$cost_sita_from2,$cost_sita_to2,$cost_sita_from,$cost_sita_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_glue_idleP' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$glue_type_idleP,$cost_sita_from2,$cost_sita_to2,$cost_sita_from,$cost_sita_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_glue_idleP_cost' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$glue_type_idleP_cost,$cost_sita_from2,$cost_sita_to2,$cost_sita_from,$cost_sita_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_glue_type_window' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$glue_type_window,$cost_sita_from2,$cost_sita_to2,$cost_sita_from,$cost_sita_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_cost_transport_out' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$cost_transport_out,$cost_transport_out_from2,$cost_transport_out_to2,$cost_transport_out_from,$cost_transport_out_to);

ReadOrderCalculationSettings($connection,"","AND var='oc_p_width_product_proc' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$proc_weight_material,$proc_weight_material_from2,$proc_weight_material_to2,$proc_weight_material_from,$proc_weight_material_to);
///$prowizja_25proc_sales="10000"; $prowizja_25proc_margin = "50";
ReadOrderCalculationSettings($connection,"","AND var='oc_p_25proc_sales' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$prowizja_25proc_sales,$cost_minimum_lamin_from2,$cost_minimum_lamin_to2,$cost_minimum_lamin_from,$cost_minimum_lamin_to);
ReadOrderCalculationSettings($connection,"","AND var='oc_p_25proc_margin' AND date_from<='$create_date' ORDER BY ocs_id DESC ",$ocs_id,$var,$var_id,$prowizja_25proc_margin,$cost_minimum_lamin_from2,$cost_minimum_lamin_to2,$cost_minimum_lamin_from,$cost_minimum_lamin_to);

$mbi0 = ""; $mbi1 = "";
switch ($manufacturer_box_info) {
  case "yes": $mbi1 = "checked"; break;
  case "no" : $mbi0 = "checked"; break;
  case ""   : $mbi0 = "checked"; break;
}
$pq0 = ""; $pq1 = "";
switch ($print_quality) {
  case ""             : $pq0 = "checked"; break;
  case "standardowa"  : $pq0 = "checked"; break;
  case "specialna"    : $pq1 = "checked"; break;
}
$pt0 = ""; $pt1 = "";
switch ($print_type) {
  case "rewerse" : $pt0 = "checked"; break;
  case "no_print" : $pt1 = "checked"; break;
}
// check variable value gathered from db and check or uncheck boxes and radios based on what was returned
  if ($laminating_x2 == "x2") { $laminating_x2 = "checked"; }
  // manual gluing difficulties
    if (($glue_type_slim_check == "10")|| ($glue_type_slim_check=='yes')) { $glue_type_slim_check = "checked"; }
    if (($glue_type_tape_check == "10") || ($glue_type_tape_check=='yes')) { $glue_type_tape_check = "checked"; }
    if (($glue_type_window_check == "10") || ($glue_type_window_check=='yes')) { $glue_type_window_check = "checked"; }
    if (($glue_type_handle_check == "10") || ($glue_type_handle_check=='yes')) { $glue_type_handle_check = "checked"; }
    if (($glue_type_prefolding_check == "10") || ($glue_type_prefolding_check=='yes')) { $glue_type_prefolding_check = "checked"; }
    if (($glue_type_foiledflap_check == "10") || ($glue_type_foiledflap_check=='yes')) { $glue_type_foiledflap_check = "checked"; }

  // automatic gluing difficulties
    if ($automaticGluingDifficulties_ShortBox == 'yes') { $automaticGluingDifficulties_ShortBox = "checked"; }
    if ($automaticGluingDifficulties_WideBox == 'yes') { $automaticGluingDifficulties_WideBox = "checked"; }
    if ($automaticGluingDifficulties_LongBox == 'yes') { $automaticGluingDifficulties_LongBox = "checked"; }
    if ($automaticGluingDifficulties_GluingTape == 'yes') { $automaticGluingDifficulties_GluingTape = "checked"; }
    if ($automaticGluingDifficulties_Window == 'yes') { $automaticGluingDifficulties_Window = "checked"; }
    if ($automaticGluingDifficulties_Handle == 'yes') { $automaticGluingDifficulties_Handle = "checked"; }
    if ($automaticGluingDifficulties_FoiledFlap == 'yes') { $automaticGluingDifficulties_FoiledFlap = "checked"; }
    if ($automaticGluingDifficulties_Prefolding === '1pt') { $automaticGluingDifficulties_Prefolding1pt = "checked"; }
    if ($automaticGluingDifficulties_Prefolding === '2pt') { $automaticGluingDifficulties_Prefolding2pt = "checked"; }
    if ($automaticGluingDifficulties_eurSlot == 'yes') { $automaticGluingDifficulties_eurSlot = "checked"; }
    if ($automaticGluingDifficulties_multiAssortment == 'yes') { $automaticGluingDifficulties_multiAssortment = "checked"; }

  // separation window stripping (has to be == for not perfect evaluation)
    if ($separationWindowStripping == 'no') { $manualWindowStripping_no = "checked"; }
    if ($separationWindowStripping == 'yes') { $manualWindowStripping_yes = "checked"; }
// minimum and maximum qty check
  if ($chckMinimumQty == 1) { $chckMinimumQty = "checked"; }
  if ($chckMaximumQty == 1) { $chckMaximumQty = "checked"; }

  if (($check_cut2 == "yes") || ($check_cut2 === 1)) { $check_cut2 = "checked"; } // cutting of second raw material type
  if (($add_print2 == "yes")|| ($add_print2 ===1)) { $add_print2 = "checked"; } // second print adding
IF ($back_order_dsc) {
  $back_order_dsc = "<TR>
      <TD class=td0010 $sl5 colspan=5>
        <SPAN STYLE=\"font-size: $size_span;\">Powód cofnięcia z produkcji</SPAN>
        <BR>
        <TEXTAREA disabled cols=80 rows=2 NAME=back_order_dsc MAXLENGTH=500>$back_order_dsc</TEXTAREA>
      </TD>
  </TR>";
}

///pokaż uwagi
$show_error = ""; $table_data_error = ""; $input_version = ""; $input_version_validate = "";
IF ($error) {
    switch ($error) {
      case "do_edit":
            $txt_text_0011 = $OCLangDict['txt_text_0011'][$lang_id];
            $show_error = "<DIV class=warning>$txt_text_0011</DIV>";
      break;
      case "file_size":
            $txt_text_0010 = $OCLangDict['txt_text_0010'][$lang_id];
            $show_error = "<DIV class=error>$txt_text_0010</DIV>";
      break;
      case "new_version":
            $txt_text_0060 = $OCLangDict['txt_text_0060'][$lang_id];
            $show_error = "<DIV class=warning>$txt_text_0060</DIV>";
            $input_version = "
            <TR>
              <TD class=td0010 $sl5 colspan=5>
                <SPAN STYLE=\"font-size: $size_span;\">Opis wersji</SPAN>
                <BR>
                <TEXTAREA cols=80 rows=3 NAME=version_dsc MAXLENGTH=250>$version_dsc</TEXTAREA>
              </TD>
            </TR>";

            /*$input_version_validate = "if (occ.version_dsc.value == \"\") { alert(\"Wartość Opis wersji jest pusta!\");
  	                                     occ.version_dsc.focus(); return (false); }";
            */


      break;
      case "copy":
            $txt_text_0075 = $OCLangDict['txt_text_0075'][$lang_id];
            $show_error = "<DIV class=warning>$txt_text_0075</DIV>";
      break;

    }
}


//przygotuj MENU (w zależności od operatorów)
$menu_left = MenuLeftShow($connection,$user_id,$lang_id,$userlevel,"12_5_0");

///validate



//////////////////////////////////////////////SEKCJE OBLICZENIOWE//////////////////////////////////////////////////////////
////////////////////////////KLEJENIE RECZNE//////////////////////////

$Sekcja_KlejenieReczne = "
<!--To jest początek sekcji z klejeniem ręcznym mod: 2018-05-25-->

          <tr id=manualGluingRow1>
                <td class='td2tableL' id='manualGluingTitle' rowspan = 1>$txt_td_072</td>
                  <td class='td0000' $sl5 colspan='4'>
                      <span style='font-size: 10px;'>Ilość pkt. klejowych</span>
                      <br>
                      <select name='glue_type_id' id='manualGluingTypeID' class='a' style='width: 100px; font-size: 10px;'>$list_glue_types</select>
                  </td>
                  <td class='td0000' $sl5 colspan='3' id='td_gr1'>
                      <input class='H' name='glue_type_b1_sqm'        id='glue_type_b1_sqm'                 VALUE='$glue_type_b1_sqm'     TYPE=$input_hidden_type>
                      <input class='H' name='glue_type_cost_h'        id='glue_type_cost_h'                 VALUE='$glue_type_cost_h'     TYPE=$input_hidden_type>
                      <input class='H' name='glue_type_foil'          id='glue_type_foil'                   VALUE='$glue_type_foil'       TYPE=$input_hidden_type>
                      <input class='H' name='glue_type_slim'          id='glue_type_slim'                   VALUE='$glue_type_slim'       TYPE=$input_hidden_type>
                      <input class='H' name='glue_type_sur2'          id='glue_type_sur2'                   VALUE='$glue_type_sur2'       TYPE=$input_hidden_type>
                      <input class='H' name='glue_type_window'        id='glue_type_window'                 VALUE='$glue_type_window'     TYPE=$input_hidden_type>
                      <input class='H' name='glue_type_tape'          id='glue_type_tape'                   VALUE='$glue_type_tape'       TYPE=$input_hidden_type>
                      <input class='H' name='glue_type_idleP'         id='glue_type_idleP'                  VALUE='$glue_type_idleP'      TYPE=$input_hidden_type>
                      <input class='H' name='glue_type_idleP_cost'    id='glue_type_idleP_cost'             VALUE='$glue_type_idleP_cost' TYPE=$input_hidden_type>
                      <input class='H' name=manualGluingOutsourcing   id=manualGluingOutsourcing            VALUE=\"$manualGluingOutsourcing\" TYPE=$input_hidden_type>
                  </td>
          </tr>
          <tr id='manualGluingRow2' style=''>
              <td class='td0000' $sl5 colspan='2'>
                  <span style='font-size: $size_span;'>$txt_td_094</span>
                  <br>
                  <input class='a' name='cost_glue_box' id='manualGluingUnitCost' value='$cost_glue_box' type='text' maxlength='7' style='width: 100px; text-align: right; padding-right: 5px; ' pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]
                  <br>
                  <span style='font-size: 10px;'>Predkosc Klejenia:</span>
                  <br>
                  <input class='input-disabled' id='manualGluingSpeed'type='text' maxlength='7' style='width: 100px; text-align: right; padding-right: 5px; ' readonly>&nbsp;[7]
              </td>
              <td class='td0000' style='text-align: left; padding-left: 5px;' colspan='2'>
                  <span style='font-size: 10px;'>Kwota:</span>
                  <br>
                  <input class='a' name='cost_glue_total' id='manualGluingQuotedCost' value='$cost_glue_total' type='text' maxlength='10' style='width: 100px; text-align: right; padding-right: 5px; ' pattern=$regexValidation_TotalPrice $title_input_kropka>&nbsp;[10]
              </td>
          </tr>
          <tr id='manualGluingDifficulties' style=''>
            <td class=td0010 $sl5 colspan='2'>
              <label>
                <input type='checkbox' class='a' name='glue_type_slim_check' id='glue_type_slim_check' VALUE='yes' $glue_type_slim_check>
                $txt_td_202
              </label>
              <br>
              <label>
                <input type='checkbox' class='a' name='glue_type_tape_check' id='glue_type_tape_check' VALUE='yes' $glue_type_tape_check>
                $txt_td_203
              </label>
              <br>
              <label>
                <input type='checkbox' class='a' name='glue_type_window_check' id='glue_type_window_check' VALUE='yes'  $glue_type_window_check>
                $txt_td_204
              </label>
              <br>
              <label>
                <input type='checkbox' class='a' name='glue_type_handle_check' id='glue_type_handle_check' VALUE='yes' $glue_type_handle_check>
                wklejanie raczki
              </label>
              <br>
              <label>
                <input type='checkbox' class='a' name='glue_type_prefolding_check' id='glue_type_prefolding_check' VALUE='yes'  $glue_type_prefolding_check>
                przeginanie
              </label>
              <br>
              <label>
                <input type='checkbox' class='a' name='glue_type_foiledflap_check' id='glue_type_foiledflap_check' VALUE='yes'  $glue_type_foiledflap_check>
                foliowana klapka
              </label>
              <br>
            </td>
          </tr>

<!--To jest koniec sekcji z klejeniem ręcznym mod 2018-05-25-->";

////////////////////////////KLEJENIE AUTOMATYCZNE//////////////////////////

$Sekcja_KlejenieAutomatyczne = "
<!--To jest początek sekcji z klejeniem automatycznym w kalkulacji 2018-05-23-->

  <tr id='glue_automatic_row1'>
      <td class='td2tableL' id ='glue_automatic_title'>$txt_td_208</td>
      <td class='td0000' $sl5 colspan='4'>
          <span style='font-size: $size_span;'>Ilość pkt. klejowych</span>
          <br>
          <select name='glue_automat_type_id' id='automaticGluingTypeID' class='a' style='width: 100px; font-size: 10px;'>$list_automat_glue_types</select>
      </td>
  </tr>

  <tr id='glue_automatic_row2'>
    <td class=td0010 $sl5 colspan='2' id='td_gr1'>
        <span style='font-size: $size_span;'>Utrudnienia</span>
        <br>
        <label>
          <input type='checkbox' class='a' name='automaticGluingDifficulties_ShortBox' id='automaticGluingDifficulties_ShortBox' value='yes' $automaticGluingDifficulties_ShortBox>
          niskie pudelko
        </label>
        <br>
        <label>
          <input type='checkbox' class='a' name='automaticGluingDifficulties_WideBox' id='automaticGluingDifficulties_WideBox' value='yes' $automaticGluingDifficulties_WideBox>
          szerokie pudelko
        </label>
        <br>
        <label>
          <input type='checkbox' class='a' name='automaticGluingDifficulties_LongBox' id='automaticGluingDifficulties_LongBox' value='yes' $automaticGluingDifficulties_LongBox>
          dlugie pudelko
        </label>
        <br>
        <label>
          <input type='checkbox' class='a' name='automaticGluingDifficulties_GluingTape' id='automaticGluingDifficulties_GluingTape' value='yes' $automaticGluingDifficulties_GluingTape>
          wklejanie tasmy
        </label>
        <br>
        <label>
          <input type='checkbox' class='a' name='automaticGluingDifficulties_Window' id='automaticGluingDifficulties_Window' value='yes' $automaticGluingDifficulties_Window>
          wklejane okienka
        </label>
        <br>
        <label>
          <input type='checkbox' class='a' name='automaticGluingDifficulties_Handle' id='automaticGluingDifficulties_Handle' value='yes' $automaticGluingDifficulties_Handle>
          wklejanie raczki
        </label>
        <br>
        <label>
          <input type='checkbox' class='a' name='automaticGluingDifficulties_FoiledFlap' id='automaticGluingDifficulties_FoiledFlap' value='yes' $automaticGluingDifficulties_FoiledFlap>
          foliowana klapka
        </label>
        <br>
        <label>
          <input type='checkbox' class='a' name='automaticGluingDifficulties_eurSlot' id='automaticGluingDifficulties_eurSlot' value='yes' $automaticGluingDifficulties_eurSlot>
          klejenie EUR dziurki
        </label>
        <br>
        <label>
          <input type='checkbox' class='a' name='automaticGluingDifficulties_multiAssortment' id='automaticGluingDifficulties_multiAssortment' value='yes' $automaticGluingDifficulties_multiAssortment>
          wiele asortymentów
          <input class='a' name='automaticGluingDifficulties_multiAssortmentNumber' id='automaticGluingDifficulties_multiAssortmentNumber' VALUE='$automaticGluingDifficulties_multiAssortmentNumber' TYPE='text' maxlength='3' style='width: 25px; text-align: right; padding-right: 5px; ' pattern='[0-9.]{0,12}' $title_input_kropka>&nbsp;[3]
        </label>
        <br>
        <label>
          <input type='radio' class='a' name='automaticGluingDifficulties_Prefolding' id='automaticGluingDifficulties_Prefolding1pt' value='1pt' $automaticGluingDifficulties_Prefolding1pt>
          przeginanie 1pkt
        </label>
        <br>
        <label>
          <input type='radio' class='a' name='automaticGluingDifficulties_Prefolding' id='automaticGluingDifficulties_Prefolding2pt' value='2pt' $automaticGluingDifficulties_Prefolding2pt>
          przeginanie 2pkt
        </label>
        <br>
    </td>
    <td class='td0000' style='text-align: left; padding-left: 5px;>s
        <span style='font-size: $size_span;'>$txt_td_094</span>
        <br>
        <input class='a' name='cost_glue_automat_box' id='automaticGluingUnitCost' VALUE='$cost_glue_automat_box' TYPE='text' maxlength='7' style='width: 100px; text-align: right; padding-right: 5px; ' pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]
        <br>
        <span style='font-size: 10px;'>Kwota:</span>
        <br>
        <input class='a' name='cost_glue_automat_total' id='automaticGluingQuotedCost' VALUE='$cost_glue_automat_total' type='text' maxlength='10' style='width: 100px; text-align: right; padding-right: 5px; ' pattern=$regexValidation_TotalPrice $title_input_kropka>&nbsp;[10]
        <input class='H' name='cost_minimum_auto_glue' id='cost_minimum_auto_glue' VALUE='$cost_minimum_auto_glue' TYPE=$input_hidden_type>
        <INPUT CLASS=H NAME=automaticGluingOutsourcing         id=automaticGluingOutsourcing      VALUE=\"$automaticGluingOutsourcing\" TYPE=$input_hidden_type>
    </td>
    <td class='td0000' $sl5>
      <span style='font-size: 10px;'>Predkosc Klejenia:</span>
      <br>
      <input class='input-disabled' id='automaticGluingSpeedInfo'type='text' style='width: 50px; text-align: right; padding-right: 5px; ' readonly>&nbsp;
      <br>
      <span style='font-size: 10px;'>Czas narzadu:</span>
      <br>
      <input class='input-disabled' id='automaticGluingSetupTimeInfo'type='text' style='width: 50px; text-align: right; padding-right: 5px; ' readonly>&nbsp;
    </td>
  </tr>";


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//zawartość strony
//$display = "
$page_content = "
<div class=\"calculation-header\" name=\"calculationHeader\">
<DIV class=tytul14gr_line margin-bottom=0px>
  <B>$order_nr</B> | <B>$customerShortName</B> | <B>$name</B> | Wer.: <B>$version</B>
<label id='labelSaveInput' for='input_save_input' class='button-label_active' tabindex='0'>Zapisz</label>
<A href=\"$powrot bez zapisu</A>&nbsp;&nbsp;&nbsp;$input_copy_data
<SPAN STYLE=\"font-size: $size_span;\" float:right>V:$calculationEngineVersion D:$calculationEngineDate</SPAN>
</DIV>
$show_error


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
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_sales_top     id=cost_sales_top     VALUE=\"$cost_sales\" TYPE=text>&nbsp;[PLN]
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_sales_one_top id=cost_sales_one_top VALUE=\"$cost_sales_one\" TYPE=text>&nbsp;[PLN/szt]
            </TD>

            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>Prowizja od marży</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_goods_top     id=cost_goods_top     VALUE=\"$cost_goods\" TYPE=text>&nbsp;[PLN]
            </TD>

            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>TVC</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=TVC_top     id=TVC_top     VALUE=\"$TVC\" TYPE=text>&nbsp;[PLN]
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=TVC_unit_top id=TVC_unit_top VALUE=\"$TVC_unit\" TYPE=text>&nbsp;[PLN/ark]
            </TD>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>Prowizja od przerobu</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_comission_top            id=throughput_comission_top             VALUE=\"$throughput_comission\" TYPE=text>&nbsp;[PLN]
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_comission_percent_top     id=throughput_comission_percent_top      VALUE=\"$throughput_comission_percent\" TYPE=text>&nbsp;[%]
            </TD>
        </TR>

        <TR>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_117</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_paper2_top    id=cost_paper2_top    VALUE=\"$cost_paper2\" TYPE=text>&nbsp;[PLN]
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=paper2_m2_top      id=paper2_m2_top      VALUE=\"$paper2_m2\" TYPE=text>&nbsp;[m<SUP>2</SUP>]
              <INPUT readonly class=calculationTopSummary_Input NAME=paper2_weight_top  id=paper2_weight_top  VALUE=\"$paper2_weight\" TYPE=text>&nbsp;[kg]
            </TD>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_121</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_transport_top id=cost_transport_top VALUE=\"$cost_transport\" TYPE=text>&nbsp;[PLN]
              <BR>
              <label class=calculationTopSummary_Label>Waga całkowita</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=order_total_weight_top  id=order_total_weight_top  VALUE=\"$order_total_weight\" TYPE=text>&nbsp;[kg]
            </TD>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_123</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_bep_top       id=cost_bep_top      VALUE=\"$cost_bep\" TYPE=text>&nbsp;[PLN]
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_bep_one_top   id=cost_bep_one_top   VALUE=\"$cost_bep_one\" TYPE=text>&nbsp;[PLN/szt]</TD>
            </TD>

            <TD class=calculationTopSummary_TD rowspan=2>
              <label class=calculationTopSummary_Label>$txt_td_128</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_prowizja10_top id=cost_prowizja10_top VALUE=\"$cost_prowizja10\" TYPE=text>&nbsp;[PLN]
              </BR>
              <label class=calculationTopSummary_Label>$txt_td_129</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_prowizja15_top id=cost_prowizja15_top VALUE=\"$cost_prowizja15\" TYPE=text>&nbsp;[PLN]
              </BR>
              <label class=calculationTopSummary_Label>$txt_td_131</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_margin_1_3_top id=cost_margin_1_3_top VALUE=\"$cost_margin_1_3\" TYPE=text>&nbsp;[PLN]
              </BR>
              <label class=calculationTopSummary_Label>$txt_td_130</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_2_5_top        id=cost_2_5_top         VALUE=\"$cost_2_5\" TYPE=text>&nbsp;[PLN]
            </TD>

            <TD class=calculationTopSummary_TD id=throughput_td>
              <label class=calculationTopSummary_Label>Przerób</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_top    id=throughput_top    VALUE=\"$throughput\" TYPE=text>&nbsp;[PLN]
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_unit_top    id=throughput_unit_top    VALUE=\"$throughput_unit\" TYPE=text>&nbsp;[PLN/ark]
            </TD>

            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>Próg</label>
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_threshold_fixed_top        id=throughput_threshold_fixed_top   VALUE=\"$throughput_threshold_fixed\" TYPE=text>&nbsp;[PLN]
              </BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_threshold_fixed_per_sheet_top   id=throughput_threshold_fixed_per_sheet_top   VALUE=\"$throughput_threshold_fixed_per_sheet\" TYPE=text>&nbsp;[PLN/ark]
            </TD>
        </TR>

        <TR>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_118</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_total_material_top  id=cost_total_material_top    VALUE=\"$cost_total_material\" TYPE=text>&nbsp;[PLN]
            </TD>
            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>$txt_td_120</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_total_out_top id=cost_total_out_top VALUE=\"$cost_total_out\" TYPE=text>&nbsp;[PLN]
            </TD>

            <TD class=calculationTopSummary_TD id=td_margin1>
              <label class=calculationTopSummary_Label>Marża</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_margin_top    id=cost_margin_top    VALUE=\"$cost_margin\" TYPE=text>&nbsp;[PLN]
              <INPUT readonly class=calculationTopSummary_Input NAME=cost_margin_unit_top    id=cost_margin_unit_top    VALUE=\"$cost_margin_unit\" TYPE=text>&nbsp;[PLN/szt]
            </TD>

            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>Przerób do sprzedaży</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_to_sales_top    id=throughput_to_sales_top    VALUE=\"$throughput_to_sales\" TYPE=text>&nbsp;[%]
              <BR>
              <label class=calculationTopSummary_Label>Przerób na godzinę</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_per_labour_top    id=throughput_per_labour_top    VALUE=\"$throughput_per_labour\" TYPE=text>&nbsp;[PLN/h]
            </TD>

            <TD class=calculationTopSummary_TD>
              <label class=calculationTopSummary_Label>Próg / ostrzeżenie</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_to_sales_threshold_top    id=throughput_to_sales_threshold_top    VALUE=\"$throughput_to_sales_threshold\" TYPE=text>&nbsp;
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_to_sales_warningLevel_top    id=throughput_to_sales_warningLevel_top    VALUE=\"$throughput_to_sales_warningLevel\" TYPE=text>
              <BR>
              <label class=calculationTopSummary_Label>Próg / ostrzeżenie</label>
              <BR>
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_per_labour_threshold_top    id=throughput_per_labour_threshold_top    VALUE=\"$throughput_per_labour_threshold\" TYPE=text>&nbsp;
              <INPUT readonly class=calculationTopSummary_Input NAME=throughput_per_labour_warningLevel_top    id=throughput_per_labour_warningLevel_top    VALUE=\"$throughput_per_labour_warningLevel\" TYPE=text>
            </TD>
        </TR>
        <TR>
          <TD class=calculationTopSummary_TD colspan=6 id=warningRow style ='none'>
            <IMG SRC=\"./icon/error.png\" width=15 border=0 ><label class=calculationTopSummary_Label>Uwaga! Wprowadzono stala cene sprzedazy</label>
          </TD>
        </TR>

</TABLE>
  <DIV id=div_calculate CLASS=error style=\"width: 970px; display: none; float: left; height: 15px;\">
        <IMG SRC=\"./icon/klopsydra.png\" width=15 height=15 border=0>
        Oczekuj ... system oblicza koszty!
  </DIV>
</div>

<div class=\"calculation-body\">
<FORM method=post id=\"occID\" name=\"occ\" action=\"order_calculation_create.php\" onsubmit=\"return validateCalculation(occ)\" enctype=\"multipart/form-data\">

<DIV hidden>
<INPUT TYPE=submit NAME=submit id=input_save_input CLASS=H VALUE=\"&nbsp;&nbsp;$txt_input_02&nbsp;&nbsp;\" disabled style=\"width: 150px;\">
</DIV>

<DIV id=div_calculate_manu style=\"width: 980px\">


    <TABLE class=tekst9gr width=950 cellspacing=1 cellpadding=1 style=\"margin-top: 10px\">
      <TR>
          <TD class=td0000 width=350 $sl5>
              <INPUT TYPE=hidden NAME=action2             VALUE=save>
              <INPUT TYPE=hidden NAME=back                VALUE=$back>
              <INPUT TYPE=hidden NAME=oc_id               VALUE=$oc_id>
              <INPUT TYPE=hidden NAME=order_qty_new  id=quickRecalculationQty     VALUE=$order_qty_new>
              <INPUT TYPE=hidden NAME=order_qty_change    VALUE=$order_qty_change>
              <INPUT TYPE=hidden NAME=order_qty_name      VALUE=$order_qty_name>
              <INPUT TYPE=hidden NAME=margin_new          VALUE=$margin_new>
              <INPUT TYPE=hidden NAME=margin_pln_new      VALUE=$margin_pln_new>
              <INPUT TYPE=hidden NAME=standardQtyColor         id=standardQtyColor      VALUE=\"$standardQtyColor\">
              <INPUT TYPE=hidden NAME=standardQtyColorTimeC    id=standardQtyColorTimeC VALUE=\"$standardQtyColorTimeC\">
          </TD>
        </TR>
      <TR>
        <TD class='td2tableC header3Text' colspan=6>
          <SPAN>PODSTAWOWE DANE ZAMOWIENIA</SPAN>
        </TD>
      </TR>
      <TR>
          <TD class=td0000 $sl5 colspan = 2>
            <SPAN STYLE=\"font-size: $size_span;\">Numer zamowienia OPAK-SERVICE</SPAN>
            <BR>
            <INPUT CLASS='input-highlighted' NAME=order_nr id=order_nr VALUE=\"$order_nr\" TYPE=text MAXLENGTH=100 STYLE=\"width: 150px; font-size: 12px; text-align: left; padding-left: 5px; \">&nbsp;[100]&nbsp;
          </TD>
          <TD class=td0000 $sl5 colspan = 2>
            <SPAN STYLE=\"font-size: $size_span;\">Numer zamowienia KLIENTA</SPAN>
            <BR>
            <INPUT CLASS='input-highlighted' NAME=customerOrder id=customerOrder VALUE=\"$customerOrder\" TYPE=text MAXLENGTH=50 STYLE=\"width: 150px; font-size: 12px; text-align: left; padding-left: 5px; \">&nbsp;[50]&nbsp;
          </TD>
      </TR>
      <TR>
          <TD class=td0000 $sl5 colspan = 5>
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_035</SPAN>
            <BR>
            <SELECT NAME=customer_id id=customer_id CLASS='input-highlighted' onchange=\"javascript:check_order_to_customer_exist()\" STYLE=\"width: 300px; font-size: 12px;\">$list_customers</SELECT>
            $input_add_customer
            <INPUT CLASS=H NAME=order_to_customer_exist id=order_to_customer_exist VALUE=\"$order_to_customer_exist\" TYPE=$input_hidden_type >
            <INPUT CLASS=H NAME=engineVersion id=engineVersion VALUE=\"$calculationEngineVersion\" TYPE=$input_hidden_type>
            <INPUT CLASS=H NAME=engineDate id=engineDate VALUE=\"$calculationEngineDate\" $input_hidden_type>
            <BR>
            <SPAN STYLE=\"font-size: $size_span;\">Nazwa opakowania</SPAN>
            <BR>
            <INPUT CLASS='input-highlighted' NAME=name VALUE=\"$name\" TYPE=text MAXLENGTH=100 STYLE=\"width: 300px; font-size: 12px; text-align: left; padding-left: 5px; \">&nbsp;[100]&nbsp;
      </TR>
      <TR>
          <TD class=td0000 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_032</SPAN>
            <BR>
            <input class='calendarSelectDate input-highlighted' type=text maxlength=10 name=order_date id=orderEntryDate VALUE=\"$order_date\" style=\"width: 80px; font-size: 10px; text-align: center; \"></TD>
          <TD class=td0000 $sl5>
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_033</SPAN>
            <BR>
            <input class='calendarSelectDate input-highlighted' type=text maxlength=10 name=end_date id=expectedOrderDeliveryDate VALUE=\"$end_date\" onchange=\"javascript:write_week_end_date()\" style=\"width: 80px; font-size: 10px; text-align: center; \">
          </TD>
          <TD class=td0000 $sl5>
          <SPAN STYLE=\"font-size: $size_span;\">$txt_td_034</SPAN>
          <BR>
          <INPUT class='input-highlighted' NAME=end_week id=end_week VALUE=\"$end_week\" TYPE=text MAXLENGTH=3 STYLE=\"width: 100px; text-align: left; padding-left: 5px; \">&nbsp;[10]
          </TD>
      </TR>

      <TR>
          <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_038</SPAN>
            <BR>
            <input class='input-highlighted' NAME=expiration_date VALUE=\"$expiration_date\" TYPE=text MAXLENGTH=30 STYLE=\"width: 100px; text-align: left; padding-left: 5px; \">&nbsp;[30]
          </TD>
          <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_039</SPAN>
            <BR>
            <input class='input-highlighted' NAME=barcode VALUE=\"$barcode\" TYPE=text MAXLENGTH=30 STYLE=\"width: 100px; text-align: left; padding-left: 5px; \">&nbsp;[30]
          </TD>
          <TD class=td0010 $sl5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_040</SPAN>
            <BR>
            <input class='input-highlighted' NAME=manufacturer_box_info VALUE=\"no\" TYPE=radio $mbi0>niewidoczna
            <BR>
            <input class='input-highlighted' NAME=manufacturer_box_info VALUE=\"yes\" TYPE=radio $mbi1>widoczna
            <BR>
            <input class='input-highlighted' NAME=manufacturer_box_info VALUE=\"brak\" TYPE=radio $mbi1>brak
          </TD>
          <TD class=td0010 $sl5 colspan=1><SPAN STYLE=\"font-size: $size_span;\">$txt_td_041</SPAN>
            <BR>
            <INPUT class='input-highlighted' NAME=print_quality VALUE=\"standardowa\" TYPE=radio $pq0>standardowa
            <BR>
            <INPUT class='input-highlighted' NAME=print_quality VALUE=\"specialna\" TYPE=radio $pq1>specjalna
          </TD>
          <TD class=td0010 $sl5 colspan=1>
            <SPAN STYLE=\"font-size: $size_span;\">Typ kalkulacji</SPAN>
            <BR>
            <INPUT class='input-highlighted' NAME=calc_type id=calc_type0 VALUE=\"view\" TYPE=radio $calc_type0>poglądowa
            <BR>
            <INPUT class='input-highlighted' NAME=calc_type id=calc_type1 VALUE=\"full\" TYPE=radio $calc_type1>pełna
          </TD>
      </TR>
      <TR>
        <TD class='td2tableC header3Text' colspan=6><SPAN>SZCZEGOŁOWE DANE ZAMOWIENIA</SPAN></TD>
      </TR>
      <TR>
          <TD class=td0000 $sl5 colspan=5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_042</SPAN><BR><TEXTAREA cols=80 rows=5 NAME=extra_dsc MAXLENGTH=500>$extra_dsc</TEXTAREA></TD>
      </TR>
      <TR>
          <TD class=td0010 $sl5 colspan=5><SPAN STYLE=\"font-size: $size_span;\">$txt_td_043</SPAN><BR><TEXTAREA cols=80 rows=2 NAME=orginal_order_dsc MAXLENGTH=500>$orginal_order_dsc</TEXTAREA></TD>
      </TR>
      $back_order_dsc
      $input_version
      <TR>
        <TD class='td2tableC header3Text' colspan=6>
          <SPAN>RODZAJ I KONSTRUKCJA</SPAN>
        </TD>
      </TR>
      <TR>
          <TD class=inline $sl5 colspan=6>
            <DIV class=inline $sl5>
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_045</SPAN>
              <BR>
              <SELECT name=order_type_id id=orderTypeID class='input-highlighted' STYLE=\"width: 100px; font-size: 10px;\" onchange=\"javascript:order_type_select()\">$list_order_types</SELECT>
              <BR>
              <INPUT CLASS=H NAME=order_type       id=order_type       VALUE=\"$order_type\" TYPE=$input_hidden_type>
            </DIV>
            <DIV class=inline $sl5>
            <SPAN STYLE=\"font-size: $size_span;\">Okienka/ dziurki:</SPAN>
            <BR>
            <INPUT CLASS=input-highlighted name=upWindows id=upWindows VALUE=\"$upWindows\" TYPE=text MAXLENGTH=4 STYLE=\"width: 20px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UpsWindows $title_input_kropka>&nbsp;[na użytek]
            </DIV>
            <DIV class=inline $sl5>
              <SPAN STYLE=\"font-size: $size_span;\">Wymiary użytku</SPAN>
              <BR>
              <INPUT CLASS=input-highlighted name=upWidth id=upWidth  VALUE=\"$upWidth\" TYPE=text MAXLENGTH=4 STYLE=\"width: 40px; text-align: right; padding-right: 5px;\" pattern=$regexValidation_Dimensions $title_input_kropka>&nbsp;<label>Szerokosc</label>&nbsp;[mm] [4]
              <BR>
              <INPUT CLASS=input-highlighted name=upLenght id=upLenght  VALUE=\"$upLenght\" TYPE=text MAXLENGTH=4 STYLE=\"width: 40px; text-align: right; padding-right: 5px;\" pattern=$regexValidation_Dimensions $title_input_kropka>&nbsp;<label>Dlugosc</label>&nbsp;[mm] [4]
            </DIV>
            <DIV class=inline $sl5>
              <SPAN STYLE=\"font-size: $size_span;\">Wymiary gotowego wyrobu</SPAN>
              <BR>
              <INPUT CLASS=input-highlighted name=boxWidth id=boxWidth  VALUE=\"$boxWidth\" TYPE=text MAXLENGTH=4 STYLE=\"width: 40px; text-align: right; padding-right: 5px;\" pattern=$regexValidation_Dimensions $title_input_kropka>&nbsp;<label>Szerokosc</label>&nbsp;[mm] [4]
              <BR>
              <INPUT CLASS=input-highlighted name=boxLenght id=boxLenght  VALUE=\"$boxLenght\" TYPE=text MAXLENGTH=4 STYLE=\"width: 40px; text-align: right; padding-right: 5px;\" pattern=$regexValidation_Dimensions $title_input_kropka>&nbsp;<label>Wysokosc</label>&nbsp;[mm] [4]
              <BR>
              <INPUT CLASS=input-highlighted name=boxDepth id=boxDepth  VALUE=\"$boxDepth\" TYPE=text MAXLENGTH=4 STYLE=\"width: 40px; text-align: right; padding-right: 5px;\" pattern=$regexValidation_Dimensions $title_input_kropka>&nbsp;<label>Glebokosc</label>&nbsp;[mm] [4]
            </DIV>
        </TD>
      </TR>
      </TABLE>

      <DIV class='headerDIV header3Text'>
          <SPAN>NAKLAD I TOLERANCJE</SPAN>
        </DIV>
      <DIV class='containerDIV'>  
      <!--Order qty visible fields section-->  
        <DIV class='flex-item'>
          <SPAN class='header4Text'>$txt_td_050</SPAN>
          <BR>
          <INPUT CLASS=input-highlighted NAME=order_qty1 id=orderQtyInput onchange=\"javascript:order_qty_write('')\" VALUE=\"$order_qty1\" TYPE=text MAXLENGTH=10 STYLE=\"width: 70px; text-align: right; padding-right: 5px;\" pattern=\"[1-9][0-9]{0,110}\" $title_input_kropka>&nbsp;[10]
        </DIV>
        <DIV class='flex-item'>
          <SPAN class='header4Text'>$txt_td_051</SPAN>
          <BR>
          <INPUT CLASS=input-highlighted NAME=tolerant        id=tolerancePercentage     onchange=\"javascript:order_qty_write('')\"   VALUE=\"$tolerant\" TYPE=text MAXLENGTH=4 STYLE=\"width: 40px; text-align: right; padding-right: 5px;\" pattern=$regexValidation_Percent $title_input_kropka>&nbsp;[%]&nbsp;[3]
        </DIV>
        <DIV class='flex-item'>
          <INPUT TYPE=checkbox           CLASS='input' NAME=chckMinimumQty               id=chckMinimumQty           onchange=\"javascript:order_qty_write('')\"    VALUE=1 $chckMinimumQty>
          <SPAN class='header4Text'>$txt_td_160</SPAN>
          <BR>
          <INPUT TYPE=text               CLASS='input' NAME=minimumQty                   id=minimumQty               onchange=\"javascript:order_qty_write('')\"    VALUE=\"$minimumQty\"                MAXLENGTH=10 STYLE=\"width: 70px; text-align: right; padding-right: 5px; \" pattern=\"[0-9]{0,110}\" $title_input_kropka>&nbsp;[10]
        </DIV>
        <DIV class='flex-item'>
          <INPUT TYPE=checkbox             CLASS='input' NAME=chckMaximumQty               id=chckMaximumQty           onchange=\"javascript:order_qty_write('')\"   VALUE=1 $chckMaximumQty>
          <SPAN class='header4Text'>$txt_td_216</SPAN>
          <BR>
          <INPUT TYPE=text                 CLASS='input' NAME=maximumQty                   id=maximumQty               onchange=\"javascript:order_qty_write('')\"   VALUE=\"$maximumQty\" MAXLENGTH=10 STYLE=\"width: 70px; text-align: right; padding-right: 5px; \" pattern=\"[0-9]{0,110}\" $title_input_kropka>&nbsp;[10]
        </DIV>  
      <!--Order qty hidden fields section-->
        <DIV class='flex-item'>
            <INPUT TYPE=$input_hidden_type CLASS=H     NAME=order_qty1_less              id=order_qty1_less                                                         VALUE=\"$order_qty1_less\"          >
            <INPUT TYPE=$input_hidden_type CLASS=H     NAME=order_qty1_less_procent      id=order_qty1_less_procent                                                 VALUE=\"$order_qty1_less_procent\"  >
        </DIV>
      </DIV>
          

      <TABLE class=tekst9gr width=950 cellspacing=1 cellpadding=1 style=\"margin-top: 10px\">
      <TR>
        <TD class='td2tableC header3Text' colspan=6>
          <SPAN>SUROWCE I ROZKLAD UZYTKOW</SPAN>
        </TD>
      </TR>
      <TR>
      <!--Raw Material 1 visible fields section-->
        <TD class=td0000 colspan=6>
            <SPAN STYLE=\"font-size: $size_span;\"><B>$txt_td_056</B></SPAN><BR>
            <SELECT class='input-highlighted' NAME=paper_id1 onchange=\"javascript:select_paper1_()\" STYLE=\"width: 250px; font-size: 10px; background-color: #FF9966;\">$list_paper1</SELECT>
            <SELECT class='input-highlighted' NAME=paper_gram_id1 id=paper1GrammageInput  onchange=\"javascript:select_paper1_()\" STYLE=\"width: 50px; font-size: 10px; background-color: #FF9966;\">$list_gram1</SELECT>
            <SELECT class='input-highlighted' NAME=format_id1 id=format_id1  onchange=\"javascript:select_format1()\" STYLE=\"width: 125px; font-size: 10px;\">$list_format1</SELECT>&nbsp;
            <INPUT class='input-highlighted' NAME=product_paper_sheetx1 id=product_paper_sheetx1 onchange=\"javascript:select_paper1_()\" VALUE=\"$product_paper_sheetx1\" TYPE=text MAXLENGTH=5 STYLE=\"width: 30px; text-align: center; background-color: #FF9966;\" pattern=$regexValidation_Dimensions  $title_input_kropka>&nbsp;x
            <INPUT class='input-highlighted' NAME=product_paper_sheety1 id=product_paper_sheety1 onchange=\"javascript:select_paper1_()\" VALUE=\"$product_paper_sheety1\" TYPE=text MAXLENGTH=5 STYLE=\"width: 30px; text-align: center; color: blue; background-color: #FF9966; font-weight: bold; \" pattern=$regexValidation_Dimensions title=\"Kierunek włókna\">
            <INPUT TYPE=text STYLE=\"width: 40px; text-align: left;\" CLASS=H_info_text NAME=rawMaterial1_SQM id=rawMaterial1_SQM VALUE='' title=\"Powierzchnia arkusza surowca I\">
            <label>$txt_td_079</label>
            <INPUT class='input-highlighted' NAME=product_paper_value1 id=upsOnSheetInput onchange=\"javascript:count_cost_ink()\" VALUE=\"$product_paper_value1\" TYPE=text MAXLENGTH=5 STYLE=\"width: 25px; text-align: right; padding-right: 5px; background-color: #FF9966;\" pattern=$regexValidation_UpsWindows $title_input_kropka>&nbsp;[3]
            <INPUT class='input-highlighted' NAME=product_paper_cut1 id=product_paper_cut1 onchange=\"javascript:count_cost_ink()\" VALUE=\"$product_paper_cut1\" TYPE=$input_hidden_type MAXLENGTH=3 STYLE=\"width: 50px; text-align: right; padding-right: 5px; background-color: #FF9966;\" pattern=$regexValidation_UpsWindows $title_input_kropka>
            <INPUT class='input-highlighted' NAME=product_paper_cost_kg1 id=product_paper_cost_kg1 onchange=\"javascript:count_cost_ink()\" VALUE=\"$product_paper_cost_kg1\" TYPE=text MAXLENGTH=7 STYLE=\"width: 50px; text-align: right; padding-right: 5px; background-color: #FF9966;\" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]
            <label>$txt_td_078</label>
            <INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_text NAME=product_paper_cost_history id=product_paper_cost_history VALUE=\"$product_paper_cost_history\" title=\"Średnia i ostatnia cena dla typu oraz gramatury surowca I\">
         </TD>
       <!--Raw Material 1 hidden fields section-->
           <TD class=td0000>
             <INPUT TYPE=$input_hidden_type CLASS=H NAME=paper_type_id1   id=paper_type_id1   VALUE=\"$paper_type_id1\">
             <INPUT TYPE=$input_hidden_type CLASS=H NAME=gram1            id=gram1            VALUE=\"$gram1\">
             <INPUT TYPE=$input_hidden_type CLASS=H NAME=sheetx1          id=sheetx1          VALUE=\"$sheetx1\">
             <INPUT TYPE=$input_hidden_type CLASS=H NAME=sheety1          id=sheety1          VALUE=\"$sheety1\">
             <INPUT TYPE=$input_hidden_type CLASS=H NAME=waste_proc1      id=waste_proc1      VALUE=\"$waste_proc1\">
             <INPUT TYPE=$input_hidden_type CLASS=H NAME=ark_extra_plate  id=ark_extra_plate  VALUE=\"$ark_extra_plate\">
             <INPUT TYPE=$input_hidden_type CLASS=H NAME=cut_cost_pln_h   id=cut_cost_pln_h   VALUE=\"$cut_cost_pln_h\">
             <INPUT TYPE=$input_hidden_type CLASS=H NAME=cut_cost_speed   id=cut_cost_speed   VALUE=\"$cut_cost_speed\">
             <INPUT TYPE=$input_hidden_type CLASS=H NAME=cut2_cost_speed  id=cut2_cost_speed  VALUE=\"$cut2_cost_speed\">
           </TD>
      </TR>
      <TR>
      <!--Raw Material 2 visible fields section-->
        <TD class=td0010 colspan=6>
          <SPAN STYLE=\"font-size: $size_span;\"><B>$txt_td_057</B></SPAN><BR>
          <DIV class=inline>
            <SELECT NAME=paper_id2 id=paper_id2 class='input-highlighted' onchange=\"javascript:select_paper2_()\" STYLE=\"width: 250px; font-size: 10px;\">$list_paper2</SELECT>
            <SELECT NAME=paper_gram_id2 id=paper_gram_id2 class='input-highlighted' onchange=\"javascript:select_paper2_()\" STYLE=\"width: 50px; font-size: 10px;\">$list_gram2</SELECT>
            <SELECT NAME=format_id2 id=format_id2 class='input-highlighted' onchange=\"javascript:select_format2()\" STYLE=\"width: 125px; font-size: 10px;\">$list_format2</SELECT>&nbsp;
          </DIV>
          <DIV class=inline id=tr_sur2_1 style=\"display: none;\">
            <INPUT class='input-highlighted' NAME=product_paper_sheetx2 id=product_paper_sheetx2 onchange=\"javascript:select_paper2_()\" VALUE=\"$product_paper_sheetx2\" TYPE=text MAXLENGTH=5 STYLE=\"width: 30px; text-align: center; \" pattern=$regexValidation_Dimensions $title_input_kropka>&nbsp;x
            <INPUT class='input-highlighted' NAME=product_paper_sheety2 id=product_paper_sheety2 onchange=\"javascript:select_paper2_()\" VALUE=\"$product_paper_sheety2\" TYPE=text MAXLENGTH=5 STYLE=\"width: 30px; text-align: center; color: blue; font-weight: bold;\" pattern=$regexValidation_Dimensions title=\"Kierunek włókna\">&nbsp;
            <INPUT TYPE=text STYLE=\"width: 40px; text-align: left;\" CLASS=H_info_text NAME=rawMaterial2_SQM id=rawMaterial2_SQM VALUE='' title=\"Powierzchnia arkusza surowca II\">
            <label>$txt_td_079</label>
            <INPUT class='input-highlighted' NAME=product_paper_value2 id=product_paper_value2 onchange=\"javascript:select_paper2_();\" VALUE=\"$product_paper_value2\" TYPE=text MAXLENGTH=3 STYLE=\"width: 25px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UpsWindows $title_input_kropka>&nbsp;[3]&nbsp;
            <BR>
            <INPUT class='input-highlighted' NAME=check_cut2 id=check_cut2 VALUE=\"yes\" onchange=\"javascript:select_paper2_();\" TYPE=checkbox $check_cut2> Cięcie na Gilotynie
          </DIV>
          <DIV class=inline id=tr_sur2_2 style=\"display: none;\">
            <INPUT class='input-highlighted' NAME=product_paper_cost_kg2 id=product_paper_cost_kg2 onchange=\"javascript:count_cost_paper2('kg')\" VALUE=\"$product_paper_cost_kg2\" TYPE=text MAXLENGTH=7 STYLE=\"width: 50px; text-align: right; padding-right: 5px;\" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]
            <label>$txt_td_078</label>&nbsp;
            <BR>
            <INPUT class='input-highlighted' NAME=product_paper_cost_m22 id=product_paper_cost_m22 onchange=\"javascript:count_cost_paper2('m2')\" VALUE=\"$product_paper_cost_m22\" TYPE=text MAXLENGTH=7 STYLE=\"width: 50px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]
            <label>$txt_td_084</label>&nbsp;
          </DIV>
          <DIV class=inline id=tr_sur2_3 style=\"display: none;\">
            <label>$txt_td_134</label>
            <INPUT class='input-highlighted' NAME=product_paper_narzut_proc2 id=product_paper_narzut_proc2 onchange=\"javascript:count_cost_paper2()\" VALUE=\"$product_paper_narzut_proc2\" TYPE=text MAXLENGTH=3 STYLE=\"width: 25px; text-align: right; padding-right: 5px; \" pattern=\"[0-9.]{0,17}\" $title_input_kropka>
            &nbsp;[%]&nbsp;[3]
          </DIV>
        </TD>
      <!--Raw Material 2 hidden fields section-->
         <TD class=td0000>
            <INPUT TYPE=$input_hidden_type CLASS=H NAME=paper_type_id2 id=paper_type_id2 VALUE=\"$paper_type_id2\">
            <INPUT TYPE=$input_hidden_type CLASS=H NAME=gram2          id=gram2          VALUE=\"$gram2\">
            <INPUT TYPE=$input_hidden_type CLASS=H NAME=sheetx2        id=sheetx2        VALUE=\"$sheetx2\">
            <INPUT TYPE=$input_hidden_type CLASS=H NAME=sheety2        id=sheety2        VALUE=\"$sheety2\">
            <INPUT TYPE=$input_hidden_type CLASS=H NAME=waste_proc2    id=waste_proc2    VALUE=\"$waste_proc2\">
          </TD>
      </TR>

  </TABLE>


  <TABLE class=tekst9gr width=950 cellspacing=1 cellpadding=1 id=table_paper1 style=\"margin-top: 10px; display: ;\">
      <TR>
        <TD width=150></TD>
        <TD width=160></TD>
        <TD width=160></TD>
        <TD width=160></TD>
        <TD width=160></TD>
        <TD width=160></TD>
      </TR>
      <TR>
        <TD class='td2tableC header3Text' colspan=6>
          <SPAN>ROZPISKA OPERACJI</SPAN>
        </TD>

      <TR>
        <TD id=printingTD class=td2tableL rowspan = 4>
          <label>Drukowanie</label>
          <BR>
          <INPUT CLASS=a NAME=add_print2 onchange=\"javascript:add_print_next()\" VALUE=\"yes\" TYPE=checkbox $add_print2> 2-gie przejście? &nbsp; &nbsp;
        </TD>
      <!--Ogolne informacje dot. wydruku-->
        <TD class=td0010 $sl5 colspan = 4>
            <DIV class=inline $sl5>
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_047</SPAN>
              <BR>
              <SELECT CLASS=a NAME=new_grafic STYLE=\"width: 100px; font-size: 10px;\">$list_grafic_select</SELECT>
              <INPUT CLASS=a NAME=cliche_cost onchange=\"javascript:count_cost_ink()\" VALUE=\"$cliche_cost\" TYPE=text MAXLENGTH=7 STYLE=\"width: 70px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_TotalPrice $title_input_kropka>&nbsp;[$txt_td_133]
            </DIV>
            <DIV class=inline $sl5>
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_036</SPAN>
              <BR>
              <SELECT NAME=accept_type_id CLASS=a STYLE=\"width: 100px; font-size: 10px;\">$list_accept_type</SELECT>
              <INPUT CLASS=a NAME=accept_cost onchange=\"javascript:count_cost_accept()\" VALUE=\"$accept_cost\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_TotalPrice $title_input_kropka>&nbsp;[7]&nbsp;[$txt_td_133]
            </DIV>
      <!--Rodzaj wydruku-->
            <DIV class=inline $sl5>
              <SPAN STYLE=\"font-size: $size_span;\">Rodzaj zadruku:</SPAN>
              <BR>
              <INPUT TYPE=radio CLASS=a NAME=print_type id=print_type_rewers VALUE=\"rewerse\" onchange=\"javascript:count_cost_ink()\"  $pt0>$txt_td_052
              <INPUT TYPE=radio CLASS=a NAME=print_type VALUE=\"no_print\" onchange=\"javascript:count_cost_ink()\"  $pt1>$txt_td_053
              <INPUT TYPE=radio CLASS=a NAME=print_type id=print_type_brak VALUE=\"brak\" onchange=\"javascript:count_cost_ink()\" >anuluj wybór
            </DIV>
        </TD>
      </TR>
      <TR>
        <TD class=td2tableC colspan=6>
          <SPAN>Konfigurowanie 1-go przejścia DRUKU dla:</SPAN>
          <INPUT TYPE=text CLASS=a NAME=print_machine_name id=print_machine_name VALUE=\"$print_machine_name\" style=\"width: 50px; color: red;\" disabled>
          <label>$txt_td_153</label>
          Komori: <INPUT CLASS=a NAME=extra_plate_komori onchange=\"javascript:count_cost_ink()\" VALUE=\"$extra_plate_komori\" TYPE=text MAXLENGTH=3 STYLE=\"width: 35px; text-align: right; padding-right: 5px; \">
        </TD>
      </TR>

      <TR>
        <TD class=td0000 $sl5 colspan = 6>
     <!--Ilosc kolorow CMYK-->
          <DIV class=inline $sl5>
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_080</SPAN>
            <BR>
            <label class=short>$txt_td_054</label>
            <INPUT CLASS=a NAME=awers_cmyk_qty_colors onchange=\"javascript:count_cost_ink()\" VALUE=\"$awers_cmyk_qty_colors\" TYPE=text MAXLENGTH=5 STYLE=\"width: 25px; text-align: right; padding-right: 5px; \" pattern=\"[.0-9]{0,17}\">
            <BR>
            <label class=short>$txt_td_055</label>
            <INPUT CLASS=a NAME=rewers_cmyk_qty_colors onchange=\"javascript:count_cost_ink()\" VALUE=\"$rewers_cmyk_qty_colors\" TYPE=text MAXLENGTH=3 STYLE=\"width: 25px; text-align: right; padding-right: 5px; \" pattern=\"[0-9]{0,17}\">
          </DIV>
     <!--Ilosc kolorow PANTONE-->
          <DIV class=inline $sl5>
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_081</SPAN> <!--Ilosc kolorow PANTONE-->
            <BR>
            <label class=short>$txt_td_054</label> <!--Ilosc kolorow Awers PANTONE-->
            <INPUT CLASS=a NAME=awers_pms_qty_colors onchange=\"javascript:count_cost_ink()\" VALUE=\"$awers_pms_qty_colors\" TYPE=text MAXLENGTH=3 STYLE=\"width: 25px; text-align: right; padding-right: 5px; \" pattern=\"[0-9]{0,17}\">
            <BR>
            <label class=short>$txt_td_055</label> <!--Ilosc kolorow Rewers PANTONE-->
            <INPUT CLASS=a NAME=rewers_pms_qty_colors onchange=\"javascript:count_cost_ink()\" VALUE=\"$rewers_pms_qty_colors\" TYPE=text MAXLENGTH=3 STYLE=\"width: 25px; text-align: right; padding-right: 5px; \" pattern=\"[0-9]{0,17}\">
          </DIV>
    <!--Powierzchnia Zadruku PANTONE-->
          <DIV class=inline $sl5>
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_082</SPAN>
            <BR>
            <INPUT CLASS=a NAME=awers_pms_sqmm onchange=\"javascript:count_cost_ink()\" VALUE=\"$awers_pms_sqmm\" TYPE=text MAXLENGTH=5 STYLE=\"width: 50px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_Percent $title_input_kropka>&nbsp;[%]
            <BR>
            <INPUT CLASS=a NAME=rewers_pms_sqmm onchange=\"javascript:count_cost_ink()\" VALUE=\"$rewers_pms_sqmm\" TYPE=text MAXLENGTH=5 STYLE=\"width: 50px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_Percent $title_input_kropka>&nbsp;[%]
          </DIV>
   <!--Numery kolorów PANTONE-->
          <DIV class=inline $sl5>
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_083</SPAN> <!--Numery kolorow Awers PANTONE-->
              <BR>
              <INPUT CLASS=a NAME=awers_pms_colors VALUE=\"$awers_pms_colors\" TYPE=text MAXLENGTH=30 STYLE=\"width: 150px; text-align: left; padding-left: 5px; \">&nbsp;[30]
              <BR>
              <INPUT CLASS=a NAME=rewers_pms_colors VALUE=\"$rewers_pms_colors\" TYPE=text MAXLENGTH=30 STYLE=\"width: 150px; text-align: left; padding-left: 5px; \">&nbsp;[30]
          </DIV>
        </TD>
    </TR>
  <!--Priting first pass hidden fields section-->
      <TR>
          <INPUT CLASS=H NAME=cost_plate1       id=cost_plate1       VALUE=\"$cost_plate_komori\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_plate2       id=cost_plate2       VALUE=\"$cost_plate_roland\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=print_machine_id id=print_machine_id VALUE=\"$print_machine_id\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_minimum_komori      id=cost_minimum_komori   VALUE=\"$cost_minimum_komori\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_minimum_roland      id=cost_minimum_roland   VALUE=\"$cost_minimum_roland\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=ink_qty_komori           id=ink_qty_komori        VALUE=\"$ink_qty_komori\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_minimum             id=cost_minimum          VALUE=\"$cost_minimum\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_minimum_mnoznki     id=cost_minimum_mnoznik  VALUE=\"$cost_minimum_mnoznik\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_minimum_cut         id=cost_minimum_cut      VALUE=\"$cost_minimum_cut\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_print1              id=cost_print1           VALUE=\"$cost_print_komori\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_print2              id=cost_print2           VALUE=\"$cost_print_roland\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_printN1             id=cost_printN1          VALUE=\"$cost_print_komoriN\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_printN2             id=cost_printN2          VALUE=\"$cost_print_rolandN\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_ink_cmyk            id=cost_ink_cmyk         VALUE=\"$cost_ink_cmyk\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_ink_pms             id=cost_ink_pms          VALUE=\"$cost_ink_pms\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=use_ink                  id=use_ink               VALUE=\"$use_ink\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=awers_setup              id=awers_setup           VALUE=\"$awers_setup\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=awers_speed              id=awers_speed           VALUE=\"$awers_speed\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=awers_idle_narzadP       id=awers_idle_narzadP    VALUE=\"$awers_idle_narzadP\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=awers_idle_jazdaP        id=awers_idle_jazdaP     VALUE=\"$awers_idle_jazdaP\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=awers_idle_costH         id=awers_idle_costH      VALUE=\"$awers_idle_costH\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=reswers_setup            id=reswers_setup         VALUE=\"$rewers_setup\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=reswers_speed            id=reswers_speed         VALUE=\"$rewers_speed\" TYPE=$input_hidden_type>
      </TR>
  <!--Printing second pass section-->
      <!--Erros info second pass section-->
      <TR id=tr_print2_error style=\"display: none;\">
          <TD class=error $sl5 colspan=5>
            <B>UWAGA!</B> Wybrana kombinacja kolorów awers / rewers wymaga dwoch przejść przez maszyny drukujące.
            <BR>
            Wypełnij sekcje drugie przejście przez maszynę!
            <BR>Ilość kolorów pierwszego przejścia będzie automatycznie pomniejszona o ilość kolorow podaną dla drugiego przejścia.
          </TD>
      </TR>
      <!--Printing second pass title section-->
      <TR id=tr_print2_0 style=\"display: none;\">
        <TD class=td2tableC colspan=5>
          <SPAN>Konfigurowanie 2-go przejścia DRUKU dla:</SPAN>
          <INPUT TYPE=text CLASS=a NAME=print2_machine_name id=print2_machine_name VALUE=\"$print2_machine_name\" style=\"width: 50px; color: red;\" disabled>
          <label>$txt_td_153</label>
          Komori: <INPUT CLASS=a NAME=extra_plate2_komori onchange=\"javascript:add_print_next()\" VALUE=\"$extra_plate2_komori\" TYPE=text MAXLENGTH=3 STYLE=\"width: 35px; text-align: right; padding-right: 5px; \">
        </TD>
      </TR>
      <TR id=tr_print2_1 style=\"display: none;\">
        <TD class=td0000 $sl5 colspan = 6>
        <!--Ilosc kolorow CMYK-->
             <DIV class=inline $sl5>
               <SPAN STYLE=\"font-size: $size_span;\">$txt_td_080</SPAN>
               <BR>
               <label class=short>$txt_td_054</label>
               <INPUT CLASS=a NAME=awers2_cmyk_qty_colors onchange=\"javascript:add_print_next()\" VALUE=\"$awers2_cmyk_qty_colors\" TYPE=text MAXLENGTH=5 STYLE=\"width: 25px; text-align: right; padding-right: 5px; \" pattern=\"[.0-9]{0,17}\">
               <BR>
               <label class=short>$txt_td_055</label>
               <INPUT CLASS=a NAME=rewers2_cmyk_qty_colors onchange=\"javascript:add_print_next()\" VALUE=\"$rewers2_cmyk_qty_colors\" TYPE=text MAXLENGTH=3 STYLE=\"width: 25px; text-align: right; padding-right: 5px; \" pattern=\"[0-9]{0,17}\">
             </DIV>
        <!--Ilosc kolorow PANTONE-->
             <DIV class=inline $sl5>
               <SPAN STYLE=\"font-size: $size_span;\">$txt_td_081</SPAN> <!--Ilosc kolorow PANTONE-->
               <BR>
               <label class=short>$txt_td_054</label> <!--Ilosc kolorow Awers PANTONE-->
               <INPUT CLASS=a NAME=awers2_pms_qty_colors onchange=\"javascript:add_print_next()\" VALUE=\"$awers2_pms_qty_colors\" TYPE=text MAXLENGTH=3 STYLE=\"width: 25px; text-align: right; padding-right: 5px; \" pattern=\"[0-9]{0,17}\">
               <BR>
               <label class=short>$txt_td_055</label> <!--Ilosc kolorow Rewers PANTONE-->
               <INPUT CLASS=a NAME=rewers2_pms_qty_colors onchange=\"javascript:add_print_next()\" VALUE=\"$rewers2_pms_qty_colors\" TYPE=text MAXLENGTH=3 STYLE=\"width: 25px; text-align: right; padding-right: 5px; \" pattern=\"[0-9]{0,17}\">
             </DIV>
       <!--Powierzchnia Zadruku PANTONE-->
             <DIV class=inline $sl5>
               <SPAN STYLE=\"font-size: $size_span;\">$txt_td_082</SPAN>
               <BR>
               <INPUT CLASS=a NAME=awers2_pms_sqmm onchange=\"javascript:add_print_next()\" VALUE=\"$awers2_pms_sqmm\" TYPE=text MAXLENGTH=5 STYLE=\"width: 50px; text-align: right; padding-right: 5px; \" pattern=\"[0-9.]{0,17}\" $title_input_kropka>&nbsp;[%]
               <BR>
               <INPUT CLASS=a NAME=rewers2_pms_sqmm onchange=\"javascript:add_print_next()\" VALUE=\"$rewers2_pms_sqmm\" TYPE=text MAXLENGTH=5 STYLE=\"width: 50px; text-align: right; padding-right: 5px; \" pattern=\"[0-9.]{0,17}\" $title_input_kropka>&nbsp;[%]
             </DIV>
      <!--Numery kolorów PANTONE-->
             <DIV class=inline $sl5>
                 <SPAN STYLE=\"font-size: $size_span;\">$txt_td_083</SPAN> <!--Numery kolorow Awers PANTONE-->
                 <BR>
                 <INPUT CLASS=a NAME=awers2_pms_colors VALUE=\"$awers2_pms_colors\" TYPE=text MAXLENGTH=30 STYLE=\"width: 150px; text-align: left; padding-left: 5px; \">&nbsp;[30]
                 <BR>
                 <INPUT CLASS=a NAME=rewers2_pms_colors VALUE=\"$rewers2_pms_colors\" TYPE=text MAXLENGTH=30 STYLE=\"width: 150px; text-align: left; padding-left: 5px; \">&nbsp;[30]
             </DIV>
        </TD>
      </TR>
  <!--Priting second pass hidden fields section-->
      <TR>
          <INPUT CLASS=H NAME=print2_machine_id id=print2_machine_id VALUE=\"$print2_machine_id\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=cost_minimum2            id=cost_minimum2          VALUE=\"$cost_minimum2\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=awers2_setup             id=awers2_setup           VALUE=\"$awers2_setup\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=awers2_speed             id=awers2_speed           VALUE=\"$awers2_speed\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=awers2_idle_narzadP      id=awers2_idle_narzadP    VALUE=\"$awers2_idle_narzadP\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=awers2_idle_jazdaP       id=awers2_idle_jazdaP     VALUE=\"$awers2_idle_jazdaP\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=awers2_idle_costH        id=awers2_idle_costH      VALUE=\"$awers2_idle_costH\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=reswers2_setup           id=reswers2_setup         VALUE=\"$rewers2_setup\" TYPE=$input_hidden_type>
          <INPUT CLASS=H NAME=reswers2_speed           id=reswers2_speed         VALUE=\"$rewers2_speed\" TYPE=$input_hidden_type>
      </TR>
  <!--Offset varnish first pass section-->
      <TR>
          <TD class=td2tableL>$txt_td_058 I</TD>
          <TD class=td0010 $sl5 colspan=2>
            <SELECT NAME=varnish_type_id id=varnish_type_id onchange=\"count_cost_ink()\" CLASS=a STYLE=\"width: 100px; font-size: 10px;\">$list_varnish</SELECT>
          </TD>
          <TD class=td0010 $sl5 colspan=2>&nbsp; </TD>
      </TR>
      <!--Offset varnish second pass section-->
      <TR id=tr_print2_19 style=\"display: none;\">
          <TD class=td2tableL>$txt_td_058 II</TD>
          <TD class=td0010 $sl5 colspan=2><SELECT NAME=varnish2_type_id id=varnish2_type_id onchange=\"add_print_next()\" CLASS=a STYLE=\"width: 100px; font-size: 10px;\">$list_varnish2</SELECT></TD>
          <TD class=td0010 $sl5 colspan=2>&nbsp; </TD>
      </TR>
      <TR>
          <TD class=td2tableL rowspan=1>$txt_td_061</TD>
          <TD class=td0010 $sl5 colspan=1><SELECT NAME=ink_varnish_id onchange=\"javascript:count_ink_varnish_cost1('')\" CLASS=a STYLE=\"width: 100px; font-size: 10px;\">$list_ink_varnish</SELECT></TD>
          <TD class=td0010 $sl5 colspan=2 id=td_i1 style=\"display: none;\"><SPAN STYLE=\"font-size: $size_span;\">$txt_td_061</SPAN><BR><INPUT CLASS=a NAME=ink_varnish_dsc VALUE=\"$ink_varnish_dsc\" TYPE=text MAXLENGTH=100 STYLE=\"width: 300px; text-align: left; padding-left: 5px; \">&nbsp;[100]</TD>
          <TD class=td0010 $sl5 colspan=1 id=td_i2 style=\"display: none;\"><SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR><INPUT CLASS=a NAME=cost_ink_varnish_total onchange=\"javascript:count_ink_varnish_cost1('cost')\" VALUE=\"$cost_ink_varnish_total\" TYPE=text MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" $title_input_kropka>&nbsp;[10]
                <BR><SPAN STYLE=\"font-size: $size_span;\">$txt_td_207</SPAN><BR><INPUT CLASS=a NAME=cost_ink_varnish_sheet onchange=\"javascript:count_ink_varnish_cost1('sheet')\" VALUE=\"$cost_ink_varnish_sheet\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=\"[0-9.]{0,17}\" $title_input_kropka>&nbsp;[7]
          </TD>
      </TR>
      <TR>
          <TD class=td2tableL>$txt_td_064</TD>
          <TD class=td0010 $sl5 COLSPAN=1><SELECT NAME=foil_type_id id=foil_type_id CLASS=a onchange=\"javascript:count_cost_foil()\" STYLE=\"width: 100px; font-size: 10px;\">$list_foil_types</SELECT></TD>
          <TD class=td0010 $sl5 COLSPAN=3 id=td_f1 style=\"display: none;\"><SPAN STYLE=\"font-size: $size_span;\">$txt_td_085</SPAN><BR><INPUT CLASS=a NAME=foil_sqm_ark  if=foil_sqm_ark onchange=\"javascript:count_cost_foil()\" VALUE=\"$foil_sqm_ark\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=\"[0-9.]{0,7}\" $title_input_kropka>&nbsp;[7]
              <INPUT CLASS=H NAME=foil_cost_m2     id=foil_cost_m2     VALUE=\"$foil_cost_m2\" TYPE=$input_hidden_type>
          </TD>
      </TR>
      <TR><TD style=\"margin-top: 20px;\" class=td2tableL rowspan=4 id=tr_g13 >$txt_td_065
              <INPUT CLASS=H NAME=gilding_speed                     id=gilding_speed                        VALUE=\"$gilding_speed\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_speed2                    id=gilding_speed2                       VALUE=\"$gilding_speed2\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_cost_matryc_pln_cm2       id=gilding_cost_matryc_pln_cm2          VALUE=\"$gilding_cost_matryc_pln_cm2\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_setup_h_matryc            id=gilding_setup_h_matryc               VALUE=\"$gilding_setup_h_matryc\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_cost_pln_h                id=gilding_cost_pln_h                   VALUE=\"$gilding_cost_pln_h\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_cost_pln_hN               id=gilding_cost_pln_hN                  VALUE=\"$gilding_cost_pln_hN\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_minimum_cost_matryca_pln  id=gilding_minimum_cost_matryca_pln     VALUE=\"$gilding_minimum_cost_matryca_pln\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_minimum_cost_job_pln      id=gilding_minimum_cost_job_pln         VALUE=\"$gilding_minimum_cost_job_pln\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_idleJp                    id=gilding_idleJp                       VALUE=\"$gilding_idleJp\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_idleNp                    id=gilding_idleNp                       VALUE=\"$gilding_idleNp\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_idle_cost                 id=gilding_idle_cost                    VALUE=\"$gilding_idle_cost\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_foil_speed_value          id=gilding_foil_speed_value             VALUE=\"$gilding_foil_speed_value\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_sqcm_matrycX_extra        id=gilding_sqcm_matrycX_extra           VALUE=\"$gilding_sqcm_matrycX_extra\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding_sqcm_matrycY_extra        id=gilding_sqcm_matrycY_extra           VALUE=\"$gilding_sqcm_matrycY_extra\" TYPE=$input_hidden_type>
              <BR>$txt_td_137 <INPUT CLASS=a NAME=gilding_box0 id=gilding_box0 VALUE=\"0\" onchange=\"javascript:count_cost_gilding_new('10');\" TYPE=checkbox $gilding_box0>
          </TD>
          <TD class=error colspan=4 $sl5 id=gilding_error style=\"display: none;\">UWAGA błąd! Dla wybranego typu surowca nie ma opcji złocenia - brak wszystkich parametrów do prowidłowego naliczenia ceny.</TD>
      </TR>
      <TR ><TD class=td0100 $sl5 ><B><SELECT NAME=gilding_qty1 id=gilding_qty1 CLASS=a onchange=\"javascript:count_gilding_1()\" STYLE=\"width: 40px; font-size: 10px;\">$list_gilding_qty1</SELECT> przeloty</B></TD>
          <TD class=td0100 $sl5 ><B><SELECT NAME=gilding_qty2 id=gilding_qty2 CLASS=a onchange=\"javascript:count_gilding_2()\" STYLE=\"width: 40px; font-size: 10px;\">$list_gilding_qty2</SELECT> przeloty</B></TD>
          <TD class=td0100 $sl5 ><B><SELECT NAME=gilding_qty3 id=gilding_qty3 CLASS=a onchange=\"javascript:count_gilding_3()\" STYLE=\"width: 40px; font-size: 10px;\">$list_gilding_qty3</SELECT> przeloty</B></TD>
          <TD class=td0000 $sl5 ><B><SELECT NAME=gilding_qty4 id=gilding_qty4 CLASS=a onchange=\"javascript:count_gilding_4()\" STYLE=\"width: 40px; font-size: 10px;\">$list_gilding_qty4</SELECT> przeloty</B></TD>
      </TR>
      <TR ><TD class=td0100 $sl5 ><SELECT NAME=gilding_speed_id1 CLASS=a onchange=\"javascript:count_gilding_1()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_speeds1</SELECT>
              <INPUT CLASS=H NAME=gilding1_speed       id=gilding1_speed         VALUE=\"$gilding1_speed\" TYPE=$input_hidden_type></TD>
          <TD class=td0100 $sl5 ><SELECT NAME=gilding_speed_id2 CLASS=a onchange=\"javascript:count_gilding_2()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_speeds2</SELECT>
              <INPUT CLASS=H NAME=gilding2_speed       id=gilding2_speed         VALUE=\"$gilding2_speed\" TYPE=$input_hidden_type></TD>
          <TD class=td0100 $sl5 ><SELECT NAME=gilding_speed_id3 CLASS=a onchange=\"javascript:count_gilding_3()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_speeds3</SELECT>
              <INPUT CLASS=H NAME=gilding3_speed       id=gilding3_speed         VALUE=\"$gilding3_speed\" TYPE=$input_hidden_type></TD>
          <TD class=td0000 $sl5 ><SELECT NAME=gilding_speed_id4 CLASS=a onchange=\"javascript:count_gilding_4()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_speeds4</SELECT>
              <INPUT CLASS=H NAME=gilding4_speed       id=gilding4_speed         VALUE=\"$gilding4_speed\" TYPE=$input_hidden_type></TD>
      </TR>
      <TR ><TD class=td0100 $sl5 ><SELECT NAME=gilding_type_id1 CLASS=a onchange=\"javascript:count_gilding_1()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_types1</SELECT>
              <INPUT CLASS=H NAME=gilding1_type_value        id=gilding1_type_value          VALUE=\"$gilding1_type_value\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding1_speed_value       id=gilding1_speed_value         VALUE=\"$gilding1_speed_value\" TYPE=$input_hidden_type></TD>
          <TD class=td0100 $sl5 id=td_g1 style=\"display: none;\"><SELECT NAME=gilding_type_id2 CLASS=a onchange=\"javascript:count_gilding_2()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_types2</SELECT>
              <INPUT CLASS=H NAME=gilding2_type_value        id=gilding2_type_value          VALUE=\"$gilding2_type_value\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding2_speed_value       id=gilding2_speed_value         VALUE=\"$gilding2_speed_value\" TYPE=$input_hidden_type></TD>
          <TD class=td0100 $sl5 id=td_g2 style=\"display: none;\"><SELECT NAME=gilding_type_id3 CLASS=a onchange=\"javascript:count_gilding_3()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_types3</SELECT>
              <INPUT CLASS=H NAME=gilding3_type_value        id=gilding3_type_value          VALUE=\"$gilding3_type_value\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding3_speed_value       id=gilding3_speed_value         VALUE=\"$gilding3_speed_value\" TYPE=$input_hidden_type></TD>
          <TD class=td0000 $sl5 id=td_g3 style=\"display: none;\"><SELECT NAME=gilding_type_id4 CLASS=a onchange=\"javascript:count_gilding_4()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_types4</SELECT>
              <INPUT CLASS=H NAME=gilding4_type_value        id=gilding4_type_value          VALUE=\"$gilding4_type_value\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding4_speed_value       id=gilding4_speed_value         VALUE=\"$gilding4_speed_value\" TYPE=$input_hidden_type></TD>
      </TR>
      <TR id=tr_g2 style=\"display: none;\">
          <TD class=td0100 $sl5 ><SELECT NAME=gilding_jump_id1 CLASS=a onchange=\"javascript:count_gilding_1()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_jump1</SELECT>
              <INPUT CLASS=H NAME=gilding1_jump_value        id=gilding1_jump_value          VALUE=\"$gilding1_jump_value\" TYPE=$input_hidden_type></TD>
          <TD class=td0100 $sl5 ><SELECT NAME=gilding_jump_id2 CLASS=a onchange=\"javascript:count_gilding_2()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_jump2</SELECT>
              <INPUT CLASS=H NAME=gilding2_jump_value        id=gilding2_jump_value          VALUE=\"$gilding2_jump_value\" TYPE=$input_hidden_type></TD>
          <TD class=td0100 $sl5 ><SELECT NAME=gilding_jump_id3 CLASS=a onchange=\"javascript:count_gilding_3()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_jump3</SELECT>
              <INPUT CLASS=H NAME=gilding3_jump_value        id=gilding3_jump_value          VALUE=\"$gilding3_jump_value\" TYPE=$input_hidden_type></TD>
          <TD class=td0000 $sl5 ><SELECT NAME=gilding_jump_id4 CLASS=a onchange=\"javascript:count_gilding_4()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_jump4</SELECT>
              <INPUT CLASS=H NAME=gilding4_jump_value        id=gilding4_jump_value          VALUE=\"$gilding4_jump_value\" TYPE=$input_hidden_type></TD>
      </TR>
      <TR id=tr_g3 style=\"display: none;\">
          <TD class=td0100 $sl5 ><SELECT NAME=gilding_sqmm_id1 CLASS=a onchange=\"javascript:count_gilding_1()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_sqmm1</SELECT>
              <INPUT CLASS=H NAME=gilding1_sqm_value        id=gilding1_sqm_value          VALUE=\"$gilding1_sqm_value\" TYPE=$input_hidden_type></TD>
          <TD class=td0100 $sl5 ><SELECT NAME=gilding_sqmm_id2 CLASS=a onchange=\"javascript:count_gilding_2()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_sqmm2</SELECT>
              <INPUT CLASS=H NAME=gilding2_sqm_value        id=gilding2_sqm_value          VALUE=\"$gilding2_sqm_value\" TYPE=$input_hidden_type></TD>
          <TD class=td0100 $sl5 ><SELECT NAME=gilding_sqmm_id3 CLASS=a onchange=\"javascript:count_gilding_3()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_sqmm3</SELECT>
              <INPUT CLASS=H NAME=gilding3_sqm_value        id=gilding3_sqm_value          VALUE=\"$gilding3_sqm_value\" TYPE=$input_hidden_type></TD>
          <TD class=td0000 $sl5 ><SELECT NAME=gilding_sqmm_id4 CLASS=a onchange=\"javascript:count_gilding_4()\" STYLE=\"width: 100px; font-size: 10px;\">$list_gilding_sqmm4</SELECT>
              <INPUT CLASS=H NAME=gilding4_sqm_value        id=gilding4_sqm_value          VALUE=\"$gilding4_sqm_value\" TYPE=$input_hidden_type></TD>
      </TR>
      <TR id=tr_g4 style=\"display: none;\">
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_087</SPAN><BR><INPUT CLASS=a NAME=gilding_foil_cost_sqm1 id=gilding_foil_cost_sqm1 MAXLENGTH=7 onchange=\"javascript:count_gilding_1()\" STYLE=\"width: 50px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_foil_cost_sqm1\" TYPE=text pattern=\"[0-9.]{0,7}\" $title_input_kropka></TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_087</SPAN><BR><INPUT CLASS=a NAME=gilding_foil_cost_sqm2 id=gilding_foil_cost_sqm2 MAXLENGTH=7 onchange=\"javascript:count_gilding_2()\" STYLE=\"width: 50px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_foil_cost_sqm2\" TYPE=text pattern=\"[0-9.]{0,7}\" $title_input_kropka></TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_087</SPAN><BR><INPUT CLASS=a NAME=gilding_foil_cost_sqm3 id=gilding_foil_cost_sqm3 MAXLENGTH=7 onchange=\"javascript:count_gilding_3()\" STYLE=\"width: 50px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_foil_cost_sqm3\" TYPE=text pattern=\"[0-9.]{0,7}\" $title_input_kropka></TD>
          <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_087</SPAN><BR><INPUT CLASS=a NAME=gilding_foil_cost_sqm4 id=gilding_foil_cost_sqm4 MAXLENGTH=7 onchange=\"javascript:count_gilding_4()\" STYLE=\"width: 50px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_foil_cost_sqm4\" TYPE=text pattern=\"[0-9.]{0,7}\" $title_input_kropka></TD>
      </TR>
      <TR id=tr_g5 style=\"display: none;\">
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_086</SPAN><BR>
              <INPUT CLASS=a NAME=gilding_sqcm_matryc1x id=gilding_sqcm_matryc1x MAXLENGTH=5 onchange=\"javascript:count_gilding_1()\" STYLE=\"width: 30px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_sqcm_matryc1x\" TYPE=text pattern=\"[0-9.]{0,5}\" $title_input_kropka>x
              <INPUT CLASS=a NAME=gilding_sqcm_matryc1y id=gilding_sqcm_matryc1y MAXLENGTH=5 onchange=\"javascript:count_gilding_1()\" STYLE=\"width: 30px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_sqcm_matryc1y\" TYPE=text pattern=\"[0-9.]{0,5}\" $title_input_kropka>[cm]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_086</SPAN><BR>
              <INPUT CLASS=a NAME=gilding_sqcm_matryc2x id=gilding_sqcm_matryc2x MAXLENGTH=5 onchange=\"javascript:count_gilding_2()\" STYLE=\"width: 30px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_sqcm_matryc2x\" TYPE=text pattern=\"[0-9.]{0,5}\" $title_input_kropka>x
              <INPUT CLASS=a NAME=gilding_sqcm_matryc2y id=gilding_sqcm_matryc2y MAXLENGTH=5 onchange=\"javascript:count_gilding_2()\" STYLE=\"width: 30px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_sqcm_matryc2y\" TYPE=text pattern=\"[0-9.]{0,5}\" $title_input_kropka>[cm]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_086</SPAN><BR>
              <INPUT CLASS=a NAME=gilding_sqcm_matryc3x id=gilding_sqcm_matryc3x MAXLENGTH=5 onchange=\"javascript:count_gilding_3()\" STYLE=\"width: 30px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_sqcm_matryc3x\" TYPE=text pattern=\"[0-9.]{0,5}\" $title_input_kropka>x
              <INPUT CLASS=a NAME=gilding_sqcm_matryc3y id=gilding_sqcm_matryc3y MAXLENGTH=5 onchange=\"javascript:count_gilding_3()\" STYLE=\"width: 30px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_sqcm_matryc3y\" TYPE=text pattern=\"[0-9.]{0,5}\" $title_input_kropka>[cm]</TD>
          <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_086</SPAN><BR>
              <INPUT CLASS=a NAME=gilding_sqcm_matryc4x id=gilding_sqcm_matryc4x MAXLENGTH=5 onchange=\"javascript:count_gilding_4()\" STYLE=\"width: 30px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_sqcm_matryc4x\" TYPE=text pattern=\"[0-9.]{0,5}\" $title_input_kropka>x
              <INPUT CLASS=a NAME=gilding_sqcm_matryc4y id=gilding_sqcm_matryc4y MAXLENGTH=5 onchange=\"javascript:count_gilding_4()\" STYLE=\"width: 30px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_sqcm_matryc4y\" TYPE=text pattern=\"[0-9.]{0,5}\" $title_input_kropka>[cm]</TD>
      </TR>
      <TR id=tr_g6 style=\"display: none;\">
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_089</SPAN><BR><INPUT CLASS=a NAME=gilding_qty_matryc1 id=gilding_qty_matryc1 MAXLENGTH=3 onchange=\"javascript:count_gilding_1()\" STYLE=\"width: 50px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_qty_matryc1\" TYPE=text pattern=\"[0-9.]{0,7}\" $title_input_kropka></TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_089</SPAN><BR><INPUT CLASS=a NAME=gilding_qty_matryc2 id=gilding_qty_matryc2 MAXLENGTH=3 onchange=\"javascript:count_gilding_2()\" STYLE=\"width: 50px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_qty_matryc2\" TYPE=text pattern=\"[0-9.]{0,7}\" $title_input_kropka></TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_089</SPAN><BR><INPUT CLASS=a NAME=gilding_qty_matryc3 id=gilding_qty_matryc3 MAXLENGTH=3 onchange=\"javascript:count_gilding_3()\" STYLE=\"width: 50px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_qty_matryc3\" TYPE=text pattern=\"[0-9.]{0,7}\" $title_input_kropka></TD>
          <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_089</SPAN><BR><INPUT CLASS=a NAME=gilding_qty_matryc4 id=gilding_qty_matryc4 MAXLENGTH=3 onchange=\"javascript:count_gilding_4()\" STYLE=\"width: 50px; text-align: right; padding-right: 5px;\" VALUE=\"$gilding_qty_matryc4\" TYPE=text pattern=\"[0-9.]{0,7}\" $title_input_kropka></TD>
      </TR>
      <TR id=tr_g7 style=\"display: none;\">
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_110</SPAN><BR><INPUT CLASS=H NAME=cost_matryc1 id=cost_matryc1 VALUE=\"$cost_matryc1\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_110</SPAN><BR><INPUT CLASS=H NAME=cost_matryc2 id=cost_matryc2 VALUE=\"$cost_matryc2\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_110</SPAN><BR><INPUT CLASS=H NAME=cost_matryc3 id=cost_matryc3 VALUE=\"$cost_matryc3\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_110</SPAN><BR><INPUT CLASS=H NAME=cost_matryc4 id=cost_matryc4 VALUE=\"$cost_matryc4\" TYPE=text>&nbsp;[PLN]</TD>
      </TR>
      <TR id=tr_g8 style=\"display: none;\">
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_191</SPAN><BR><INPUT CLASS=H NAME=cost_matryc1_f id=cost_matryc1_f VALUE=\"$cost_matryc1_f\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_191</SPAN><BR><INPUT CLASS=H NAME=cost_matryc2_f id=cost_matryc2_f VALUE=\"$cost_matryc2_f\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_191</SPAN><BR><INPUT CLASS=H NAME=cost_matryc3_f id=cost_matryc3_f VALUE=\"$cost_matryc3_f\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_191</SPAN><BR><INPUT CLASS=H NAME=cost_matryc4_f id=cost_matryc4_f VALUE=\"$cost_matryc4_f\" TYPE=text>&nbsp;[PLN]</TD>
      </TR>
      <TR id=tr_g9 style=\"display: none;\">
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_111</SPAN><BR><INPUT CLASS=H NAME=cost_matryc1_prod id=cost_matryc1_prod VALUE=\"$cost_matryc1_prod\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_111</SPAN><BR><INPUT CLASS=H NAME=cost_matryc2_prod id=cost_matryc2_prod VALUE=\"$cost_matryc2_prod\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_111</SPAN><BR><INPUT CLASS=H NAME=cost_matryc3_prod id=cost_matryc3_prod VALUE=\"$cost_matryc3_prod\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_111</SPAN><BR><INPUT CLASS=H NAME=cost_matryc4_prod id=cost_matryc4_prod VALUE=\"$cost_matryc4_prod\" TYPE=text>&nbsp;[PLN]</TD>
      </TR>
      <TR id=tr_g10 style=\"display: none;\">
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_112</SPAN><BR><INPUT CLASS=H NAME=cost_matryc1_setup id=cost_matryc1_setup VALUE=\"$cost_matryc1_setup\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_112</SPAN><BR><INPUT CLASS=H NAME=cost_matryc2_setup id=cost_matryc2_setup VALUE=\"$cost_matryc2_setup\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_112</SPAN><BR><INPUT CLASS=H NAME=cost_matryc3_setup id=cost_matryc3_setup VALUE=\"$cost_matryc3_setup\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_112</SPAN><BR><INPUT CLASS=H NAME=cost_matryc4_setup id=cost_matryc4_setup VALUE=\"$cost_matryc4_setup\" TYPE=text>&nbsp;[PLN]</TD>
      </TR>
      <TR id=tr_g11 style=\"display: none;\">
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_209</SPAN><BR><INPUT CLASS=H NAME=cost_matryc1_idle id=cost_matryc1_idle VALUE=\"$cost_matryc1_idle\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_209</SPAN><BR><INPUT CLASS=H NAME=cost_matryc2_idle id=cost_matryc2_idle VALUE=\"$cost_matryc2_idle\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0100 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_209</SPAN><BR><INPUT CLASS=H NAME=cost_matryc3_idle id=cost_matryc3_idle VALUE=\"$cost_matryc3_idle\" TYPE=text>&nbsp;[PLN]</TD>
          <TD class=td0000 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_209</SPAN><BR><INPUT CLASS=H NAME=cost_matryc4_idle id=cost_matryc4_idle VALUE=\"$cost_matryc4_idle\" TYPE=text>&nbsp;[PLN]</TD>
      </TR>
      <TR id=tr_g12 style=\"display: none;\"><TD class=td0110 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_113</SPAN><BR><INPUT CLASS=H NAME=cost_matryc1_total id=cost_matryc1_total VALUE=\"$cost_matryc1_total\" TYPE=text>&nbsp;[PLN]
              <INPUT CLASS=a NAME=gilding_box1 id=gilding_box1 VALUE=\"1\" TYPE=checkbox $gilding_box1 onchange=\"javascript:count_gilding_1()\">
              <INPUT CLASS=H NAME=gilding1_setup_info  id=gilding1_setup_info   VALUE=\"\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding1_prod_info   id=gilding1_prod_info    VALUE=\"\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding1_idle_info   id=gilding1_idle_info    VALUE=\"\" TYPE=$input_hidden_type></TD>
          <TD class=td0110 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_113</SPAN><BR><INPUT CLASS=H NAME=cost_matryc2_total id=cost_matryc2_total VALUE=\"$cost_matryc2_total\" TYPE=text>&nbsp;[PLN]
              <INPUT CLASS=a NAME=gilding_box2 id=gilding_box2 VALUE=\"2\" TYPE=checkbox $gilding_box2 onchange=\"javascript:count_gilding_2()\">
              <INPUT CLASS=H NAME=gilding2_setup_info  id=gilding2_setup_info   VALUE=\"\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding2_prod_info   id=gilding2_prod_info    VALUE=\"\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding2_idle_info   id=gilding2_idle_info    VALUE=\"\" TYPE=$input_hidden_type></TD>
          <TD class=td0110 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_113</SPAN><BR><INPUT CLASS=H NAME=cost_matryc3_total id=cost_matryc3_total VALUE=\"$cost_matryc3_total\" TYPE=text>&nbsp;[PLN]
              <INPUT CLASS=a NAME=gilding_box3 id=gilding_box3 VALUE=\"3\" TYPE=checkbox $gilding_box3 onchange=\"javascript:count_gilding_3()\">
              <INPUT CLASS=H NAME=gilding3_setup_info  id=gilding3_setup_info   VALUE=\"\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding3_prod_info   id=gilding3_prod_info    VALUE=\"\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding3_idle_info   id=gilding3_idle_info    VALUE=\"\" TYPE=$input_hidden_type></TD>
          <TD class=td0010 $sl5 ><SPAN STYLE=\"font-size: $size_span;\">$txt_td_113</SPAN><BR><INPUT CLASS=H NAME=cost_matryc4_total id=cost_matryc4_total VALUE=\"$cost_matryc4_total\" TYPE=text>&nbsp;[PLN]
              <INPUT CLASS=a NAME=gilding_box4 id=gilding_box4 VALUE=\"4\" TYPE=checkbox $gilding_box4 onchange=\"javascript:count_gilding_4()\">
              <INPUT CLASS=H NAME=gilding4_setup_info  id=gilding4_setup_info   VALUE=\"\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding4_prod_info   id=gilding4_prod_info    VALUE=\"\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=gilding4_idle_info   id=gilding4_idle_info    VALUE=\"\" TYPE=$input_hidden_type></TD>
      </TR>
      <TR>
          <TD class=td2tableL>Koszty matryc</TD>
          <TD class=td0010 $sl5 colspan=2><INPUT CLASS=a NAME=gilding_box_matryce id=gilding_box_matryce VALUE=\"1\" TYPE=checkbox $gilding_box_matryce onchange=\"javascript:count_gilding_1()\"> dodaj do ceny</TD>
          <TD class=td0010 $sl5 colspan=1>
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR><INPUT readonly CLASS=a NAME=cost_extra_matryce VALUE=\"$cost_extra_matryce\" TYPE=text MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_TotalPrice  $title_input_kropka>&nbsp;[10]
          </TD>
          <TD class=td0010 $sl5 colspan=1>
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_062 extra</SPAN><BR><INPUT CLASS=a NAME=cost_extra_matryce_extra VALUE=\"$cost_extra_matryce_extra\" TYPE=text MAXLENGTH=10 onchange=\"javascript:count_gilding_1()\" STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_TotalPrice $title_input_kropka>&nbsp;[10]
          </TD>
      </TR>
      <!-- UV varnish operation section -->
      <TR>
          <TD class=td2tableL>$txt_td_060</TD>
          <TD class=td0010 $sl5 colspan=1><SELECT NAME=varnish_uv_type_id onchange=\"javascript:count_varnish_UV_cost1()\" CLASS=a STYLE=\"width: 100px; font-size: 10px;\">$list_varnish_uv</SELECT></TD>
          <TD class=td0010 $sl5 colspan=3 id=td_l1 style=\"display: none;\"><SPAN STYLE=\"font-size: $size_span;\">$txt_td_059</SPAN><BR><INPUT CLASS=a NAME=varnish_uv_sqm_ark onchange=\"javascript:count_varnish_UV_cost1()\" VALUE=\"$varnish_uv_sqm_ark\" TYPE=text MAXLENGTH=5 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_Surface $title_input_kropka>&nbsp;[5]
              <INPUT CLASS=H NAME=cost_sita  id=cost_sita   VALUE=\"$cost_sita\" TYPE=$input_hidden_type>
          </TD>
      </TR>
      <!-- Litholamination operation section -->
      <TR>
          <TD class=td2tableL rowspan=2>$txt_td_066</TD>
          <TD class=error colspan=4 $sl5 id=laminating_error style=\"display: none;\">UWAGA!!!<BR><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=laminating_error_info id=laminating_error_info VALUE=\"\"></TD>
      </TR>
      <TR>
          <TD class=td0010 $sl5 COLSPAN=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_211</SPAN><BR><SELECT NAME=laminating_type_id id=laminating_type_id CLASS=a onchange=\"javascript:count_cost_laminating()\" STYLE=\"width: 100px; font-size: 10px;\">$list_laminating_types</SELECT></TD>
          <TD class=td0010 $sl5 COLSPAN=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_210</SPAN><BR><SELECT NAME=laminating_sqm_id  id=laminating_sqm_id  CLASS=a onchange=\"javascript:count_cost_laminating()\" STYLE=\"width: 100px; font-size: 10px;\">$list_laminating_sqm</SELECT>
              <INPUT CLASS=H NAME=cost_minimum_laminating      id=cost_minimum_laminating     VALUE=\"$cost_minimum_laminating\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=kaszer_speed                 id=kaszer_speed                VALUE=\"$kaszer_speed\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=kaszer_cost                  id=kaszer_cost                 VALUE=\"$kaszer_cost\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=kaszer_cost_narzad           id=kaszer_cost_narzad          VALUE=\"$kaszer_cost_narzad\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=kaszer_cost_idle             id=kaszer_cost_idle            VALUE=\"$kaszer_cost_idle\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=kaszer_cost_glue             id=kaszer_cost_glue            VALUE=\"$kaszer_cost_glue\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=kaszer_narzad                id=kaszer_narzad               VALUE=\"$kaszer_narzad\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=kaszer_idle_narzad           id=kaszer_idle_narzad          VALUE=\"$kaszer_idle_narzad\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=kaszer_idle_jazda            id=kaszer_idle_jazda           VALUE=\"$kaszer_idle_jazda\" TYPE=$input_hidden_type>
          </TD>
      </TR>
      <!-- Die cutting 1 operation section -->
      <tr id=dieCuttingProcessRow>
          <td class=td2tableL id='dieCuttingProcessRowLabel' rowspan=2>$txt_td_069</td>
          <td class=td0010 $sl5>
              <label> Wybierz rodzaj procesu wycinania</label>
              <br>
              <SELECT NAME=dctool_type_id id=dctool_type_id CLASS=a STYLE=\"width: 300px; font-size: 10px;\">
                $dieCuttingProcessTypeList
              </SELECT>
          </td>
      </tr>
      <tr id=dieCuttingToolingRow>
          <td id=dieCuttingToolingType class=td0010 $sl5>
            <label> Wybierz narzędzia wycinania</label>
            <br>
            <select name='dieCuttingToolingTypeID' id='dieCuttingToolingTypeDropdown' class='a' style='width: 300px; font-size: 10px;' title='Wybierz narzędzia wycinania'>
              $dieCuttingToolingList
            </select>
          </td>
          <td id ='dieCuttingToolingStatus'>
            <label>Określ status $txt_td_048</label>
            <br>
            <select name='dieCuttingToolingStatusID' id='dieCuttingToolingStatusDropdown' class='a' style='width: 150px; font-size: 10px;' title='Wybierz status narzędzi'>
              $dieCuttingToolingStatusList
            </select>
          </td>
          <td id='dieCuttingToolingCosts'>
            <label>Koszt narzędzi</label>
            <br>
            <INPUT CLASS=a NAME=dctool_cost id=dieCuttingToolingCost VALUE=\"$dctool_cost\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_TotalPrice $title_input_kropka>&nbsp;[$txt_td_133]
          </td>
          <td id='dieCuttingToolingInvoicing'>
              <label>Rozliczenie kosztow narzedzi</label>
              <br>
              <select name='dieCuttingToolingInvoicingID' id='dieCuttingToolingInvoicingDropdown' class='a' style='width: 150px; font-size: 10px;' title='Wybierz rodzaj fakturowania'>
                $dieCuttingToolingInvoicingList
              </select>
          </td>
          <td>
               <INPUT CLASS=H NAME=cost_minimum_dcting1             id=cost_minimum_dcting1          VALUE=\"$cost_minimum_dcting1\" TYPE=$input_hidden_type>
               <INPUT CLASS=H NAME=cost_minimum_dcting2             id=cost_minimum_dcting2          VALUE=\"$cost_minimum_dcting2\" TYPE=$input_hidden_type>
               <INPUT CLASS=H NAME=cost_minimum_dcting3             id=cost_minimum_dcting3          VALUE=\"$cost_minimum_dcting3\" TYPE=$input_hidden_type>
               <INPUT CLASS=H NAME=cost_dcting_machin               id='dieCuttingPreferredMachine'            VALUE=\"$cost_dcting_machin\" TYPE=$input_hidden_type>
          </td>
      </tr>
      <tr id=strippingProcessRow>
        <td class=td0010 $sl5>
            <label> Wybierz narzędzia wypychania</label>
            <br>
            <select name='strippingToolingTypeID' id='strippingToolingTypeDropdown' class='a' style='width: 300px; font-size: 10px;' title='Wybierz narzędzia'>
              $strippingToolingList
            </select>
        <td id=strippingToolingStatus>
          <label>Określ status wypychaczy</label>
          <br>
          <select name='strippingToolingStatusID' id='strippingToolingStatusDropdown' class='a' style='width: 150px; font-size: 10px;' title='Wybierz status narzędzi'>
            $strippingToolingStatusList
          </select>
        </td>
        <td id=strippingToolingCosts>
            <label>Koszt narzędzi</label>
            <br>
            <INPUT CLASS=a name=strippingToolingCost id=strippingToolingCost VALUE=\"$strippingToolingCost\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=\"[0-9.]{0,17}\" $title_input_kropka>&nbsp;[$txt_td_133]
        </td>
        <td id=strippingToolingInvoicing>
            <label>Rozliczenie kosztow narzedzi</label>
            <br>
            <select name='strippingToolingInvoicingID' id='strippingToolingInvoicingDropdown' class='a' style='width: 150px; font-size: 10px;' title='Wybierz rodzaj fakturowania'>
               $strippingToolingInvoicingList
            </select>
        </td>
      </tr>
      <!-- Die cutting 2 operation section -->
      <TR>
          <TD class=td2tableL>$txt_td_069 2</TD>
          <TD class=td0010 $sl5 colspan=4><SELECT NAME=dctool2_type_id id=dctool2_type_id onchange=\"javascript:count_cost2_dcting()\" CLASS=a STYLE=\"width: 300px; font-size: 10px;\">$dieCutting2ProcessTypeList</SELECT>
                   <INPUT CLASS=H NAME=cost_2minimum_dcting1             id=cost_2minimum_dcting1          VALUE=\"$cost_minimum_dcting1\" TYPE=$input_hidden_type>
                   <INPUT CLASS=H NAME=cost_2minimum_dcting2             id=cost_2minimum_dcting2          VALUE=\"$cost_minimum_dcting2\" TYPE=$input_hidden_type>
                   <INPUT CLASS=H NAME=cost_2minimum_dcting3             id=cost_2minimum_dcting3          VALUE=\"$cost_minimum_dcting3\" TYPE=$input_hidden_type>
                   <INPUT CLASS=H NAME=cost_dcting2_machin               id=cost_dcting2_machin            VALUE=\"$cost_dcting2_machin\" TYPE=$input_hidden_type>
          </TD>
      </TR>
      <TR>
          <TD class=td2tableL>$txt_td_068</TD>
          <TD class=td0010 $sl5 colspan=4><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR><INPUT CLASS=a NAME=biga_cost_box id=biga_cost_box onchange=\"javascript:count_cost_bigowanie()\" VALUE=\"$biga_cost_box\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]
          </TD>
      </TR>
      <!-- Falcing operation section -->
      <TR>
          <TD class=td2tableL>$txt_td_067</TD>
          <TD class=td0010 $sl5 colspan=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR><INPUT CLASS=a NAME=falc_cost_box id=falc_cost_box onchange=\"javascript:count_cost_falc('cost_box')\" VALUE=\"$falc_cost_box\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]
          <TD class=td0010 $sl5 colspan=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR><INPUT CLASS=a NAME=falc_cost id=falc_cost onchange=\"javascript:count_cost_falc('cost')\" VALUE=\"$falc_cost\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_TotalPrice $title_input_kropka>&nbsp;[7]</TD>
          </TD>
      </TR>
      <!-- Stapling operation section -->
      <TR>
          <TD class=td2tableL>$txt_td_071</TD>
          <TD class=td0010 $sl5 colspan=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR><INPUT CLASS=a NAME=stample_cost_box id=stample_cost_box onchange=\"javascript:count_cost_stample('cost_box')\" VALUE=\"$stample_cost_box\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]</TD>
          <TD class=td0010 $sl5 colspan=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR><INPUT CLASS=a NAME=stample_cost id=stample_cost onchange=\"javascript:count_cost_stample('cost')\" VALUE=\"$stample_cost\" TYPE=text MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_TotalPrice $title_input_kropka>&nbsp;[10]</TD>
      </TR>
      <!-- Old separation operation section
        <TR>
            <TD class=td2tableL>$txt_td_200</TD>
            <TD class=td0010 $sl5 colspan=4>
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_201</SPAN>
              <BR>

              <SELECT NAME=manual_work_window_id id=manual_work_window_id onchange=\"javascript:count_cost_manual_work()\" CLASS=a STYLE=\"width: 300px; font-size: 10px;\" $title_input_kropka>$list_manual_work_windows</SELECT>
            </TD>
        </TR>
      -->

<!-- New separation operation section -->
  <TR id=separationProcessRow>
      <td class=td2tableL id=separationProcessRowLabel>Separacja uzytkow</td>
      <td class=td0010 id=separationMain $sl5>
        <label> Wybierz rodzaj procesu </label>
        <br>
        <SELECT NAME=separationProcessTypeID id=separationProcessType CLASS=a STYLE=\"width: 300px; font-size: 10px;\">
          $separationProcessTypeList
        </SELECT>
        <br>
        <div id=separationTooling class=td0010 $sl5>
          <label>Wybierz narzędzia sepracji</label>
          <br>
          <select name='separationToolingTypeID' id='separationToolingTypeDropdown' class='a' VALUE=\"$separationToolingTypeID\" style='width: 150px; font-size: 10px;' title='Wybierz rodzaj narzędzi'>
            $separationToolingList
          </select>
        </div>
        <div id=separationWindowsStripping>
          <label>Reczne wypychanie okienek/ otworow </label>
          <br>
          <label>
            <input type='radio' class='a' name='manualWindowStripping' id='manualWindowStrippingNo' value='no' $manualWindowStripping_no>
            nie
          </label>
          <br>
          <label>
            <input type='radio' class='a' name='manualWindowStripping' id='manualWindowStrippingYes' value='yes' $manualWindowStripping_yes>
            tak
          </label>
        </div>
      </td>
          <td id=separationToolingStatus class=td0010 $sl5>
            <label>Określ status narzedzia</label>
            <br>
            <select name='separationToolingStatusID' id='separationToolingStatusDropdown' class='a' VALUE=\"$separationToolingStatusID\" style='width: 150px; font-size: 10px;' title='Wybierz status narzędzi'>
              $separationToolingStatusList
            </select>
          </td>
          <td id=separationToolingCosts class=td0010 $sl5>
            <label>koszt narzędzi</label>
            <br>
            <INPUT CLASS=a name=separationToolingCost id=separationToolingCost VALUE=\"$separationToolingCost\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[$txt_td_133]
          </td>
          <td id=separationToolingInvoicing>
          <label>Rozliczenie kosztow narzedzi</label>
          <br>
          <select name='separationToolingInvoicingID' id='separationToolingInvoicingDropdown' class='a' style='width: 150px; font-size: 10px;' title='Wybierz rodzaj fakturowania'>
             $separationToolingInvoicingList
          </select>
          </td>

    </TR>
      <TR>
          <TD class=td2tableL>$txt_td_070</TD>
          <TD class=td0010 $sl5 colspan=2>
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN>
            <BR>
            <INPUT CLASS=a NAME=window_glue_cost_box id=window_glue_cost_box onchange=\"javascript:count_cost_window('cost')\" VALUE=\"$window_glue_cost_box\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]
            <BR>
            <SPAN STYLE=\"font-size: $size_span;\">Czas wklejenia 1 okienka</SPAN>
            <BR>
            <INPUT CLASS=a NAME=window_glue_timeS_box id=window_glue_timeS_box onchange=\"javascript:count_cost_window('time')\" VALUE=\"$window_glue_timeS_box\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[sekund]&nbsp;[7]
          </TD>
          <TD class=td0010 $sl5 colspan=1 id=td_w1 style=\"display: none;\">
            <SPAN STYLE=\"font-size: $size_span;\">$txt_td_149</SPAN><BR><SELECT NAME=window_foil_type_id id=window_foil_type_id  onchange=\"javascript:count_cost_window('')\" CLASS=a STYLE=\"width: 150px; font-size: 10px;\" $title_input_kropka>$list_window_foil_type<SELECT>
          </TD>
          <TD class=td0010 $sl5 colspan=1 id=td_w2 style=\"display: none;\"><SPAN STYLE=\"font-size: $size_span;\">$txt_td_151</SPAN><BR><INPUT CLASS=a NAME=window_foil_sqm id=window_foil_sqm onchange=\"javascript:count_cost_window('')\" VALUE=\"$window_foil_sqm\" TYPE=text MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[cm<SUP>2</SUP>]&nbsp;[10]</TD>
              <INPUT CLASS=H NAME=cost_minimum_window         id=cost_minimum_window      VALUE=\"$cost_minimum_window\" TYPE=$input_hidden_type>
              <INPUT CLASS=H NAME=windowPatchingType         id=windowPatchingType      VALUE=\"$windowPatchingType\" TYPE=$input_hidden_type>
          </TD>
      </TR>

$Sekcja_KlejenieReczne
$Sekcja_KlejenieAutomatyczne

      <TR>
          <TD class=td2tableL id=td_t4>$txt_td_073</TD>
          <TD class=td0000 $sl5><SELECT NAME=transport_type_id onchange=\"javascript:count_cost_transport('')\" CLASS=a STYLE=\"width: 100px; font-size: 10px;\">$list_transport_types</SELECT></TD>
          <TD class=td0000 $sl5 id=td_t1 style=\"display: none;\"><SPAN STYLE=\"font-size: $size_span;\">$txt_td_095</SPAN><BR><INPUT CLASS=a NAME=transport_km onchange=\"javascript:count_cost_transport('')\" VALUE=\"$transport_km\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=\"[0-9.]{0,12}\" $title_input_kropka>&nbsp;[7]</TD>
          <TD class=td0000 $sl5 id=td_t2 style=\"display: none;\"><SPAN STYLE=\"font-size: $size_span;\">$txt_td_147</SPAN><BR><INPUT CLASS=a NAME=transport_palet onchange=\"javascript:count_cost_transport('')\" VALUE=\"$transport_palet\" TYPE=text MAXLENGTH=3 STYLE=\"width: 50px; text-align: right; padding-right: 5px; \" pattern=\"[0-9]{0,12}\" $title_input_kropka>&nbsp;[3]</TD>
          <TD class=td0000 $sl5 id=td_t3 style=\"display: none;\"><SPAN STYLE=\"font-size: $size_span;\">$txt_td_148</SPAN><BR><INPUT CLASS=a NAME=transport_palet_weight onchange=\"javascript:count_cost_transport('')\" VALUE=\"$transport_palet_weight\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=\"[0-9]{0,12}\" $title_input_kropka>&nbsp;[7]</TD>
      </TR>
      <TR>
          <TD class=td0010 $sl5 id=td_t7 style=\"display: none;\"><SPAN STYLE=\"font-size: $size_span;\">Waga zamówienia:</SPAN><BR><INPUT TYPE=$input_hidden_type_view_info CLASS=H2 NAME=order_total_weight id=order_total_weight VALUE=\"$order_total_weight\">&nbsp;[kg]
              <INPUT CLASS=H NAME=proc_weight_material id=proc_weight_material VALUE=\"$proc_weight_material\" TYPE=$input_hidden_type>
          </TD>
          <TD class=td0010 $sl5 id=td_t5 style=\"display: none;\"><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR><INPUT CLASS=a NAME=cost_transport_box id=cost_transport_box onchange=\"javascript:count_cost_transport('cost_box')\" VALUE=\"$cost_transport_box\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]</TD>
          <TD class=td0010 $sl5 id=td_t6 style=\"display: none;\" colspan=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR><INPUT CLASS=a NAME=cost_transport_total id=cost_transport_total onchange=\"javascript:count_cost_transport('cost')\" VALUE=\"$cost_transport_total\" TYPE=text MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_TotalPrice $title_input_kropka>&nbsp;[10]</TD>
      </TR>
      <TR>
          <TD class=td2tableL>$txt_td_077</TD>
          <TD class=td0010 $sl5 colspan=4>$list_out</TD>
      </TR>
      <TR>
          <TD class=td2tableL>$txt_td_074</TD>
          <TD class=td0010 $sl5 colspan=2><TEXTAREA cols=35 rows=4 NAME=other1_dsc MAXLENGTH=150>$other1_dsc</TEXTAREA></TD>
          <TD class=td0010 $sl5 colspan=2>
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR><INPUT CLASS=a NAME=cost_other1_total onchange=\"javascript:count_cost_other1('cost')\" VALUE=\"$cost_other1_total\" TYPE=text MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_TotalPrice $title_input_kropka>&nbsp;[10]
              <BR><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR><INPUT CLASS=a NAME=cost_other1_box onchange=\"javascript:count_cost_other1('cost_box')\" VALUE=\"$cost_other1_box\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]
            </TD>
      </TR>
      <TR>
          <TD class=td2tableL>$txt_td_075</TD>
          <TD class=td0010 $sl5 colspan=2><TEXTAREA cols=35 rows=4 NAME=other2_dsc MAXLENGTH=150>$other2_dsc</TEXTAREA></TD>
          <TD class=td0010 $sl5 colspan=2>
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR><INPUT CLASS=a NAME=cost_other2_total onchange=\"javascript:count_cost_other2('cost')\" VALUE=\"$cost_other2_total\" TYPE=text MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_TotalPrice  $title_input_kropka>&nbsp;[10]
              <BR><SPAN STYLE=\"font-size: $size_span;\">
                  </SPAN><BR><INPUT CLASS=a NAME=cost_other2_box onchange=\"javascript:count_cost_other2('cost_box')\" VALUE=\"$cost_other2_box\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[7]
          </TD>
      </TR>
      <TR>
          <TD class=td2tableL>$txt_td_076</TD>
          <TD class=td0010 $sl5 colspan=2><TEXTAREA cols=35 rows=4 NAME=cost_extra_dsc MAXLENGTH=150>$cost_extra_dsc</TEXTAREA></TD>
          <TD class=td0010 $sl5 colspan=2>
              <SPAN STYLE=\"font-size: $size_span;\">$txt_td_062</SPAN><BR><INPUT CLASS=a NAME=cost_extra_total onchange=\"javascript:count_cost_extra()\" VALUE=\"$cost_extra_total\" TYPE=text MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_TotalPrice $title_input_kropka>&nbsp;[10]
          </TD>
      </TR>
      <TR>
          <TD class=td2tableL>Korekta czasów operacji</TD>
          <TD class=td0010 $sl5 colspan=2>
            <TEXTAREA cols=35 rows=4 NAME=operationTimeCorrectionDsc  id=operationTimeCorrectionDsc  MAXLENGTH=150>$operationTimeCorrectionDsc</TEXTAREA>
          </TD>
          <TD class=td0010 $sl5 colspan=2>
              <SPAN STYLE=\"font-size: $size_span;\">Czasy:</SPAN>
              <BR>
              <INPUT CLASS=a NAME=operationTimeCorrection id=operationTimeCorrection onchange=\"javascript:countoperationTimeCorrection()\" VALUE=\"$operationTimeCorrection\" TYPE=text MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=$regexValidation_Times $title_input_kropka>&nbsp;[10]
          </TD>
      </TR>
      $table_data_error
        <TR>
          <TD class=td2tableL>$txt_td_136</TD>
          <TD class=td0010 $sl5 colspan=1>
            <INPUT CLASS=a NAME=margin id=margin onchange=\"javascript:order_qty_write('proc')\" MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; background-color: #FF9966;\" VALUE=\"$margin\" TYPE=text pattern=$regexValidation_Margin $title_input_kropka>&nbsp;[%]&nbsp;[5]
          </TD>
          <TD class=td0010 $sl5 colspan=1>
            <INPUT CLASS='a input-highlighted' NAME=margin_pln id=margin_pln onchange=\"javascript:order_qty_write('pln')\" MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; background-color: #FF9966;\" VALUE=\"$margin_pln\" TYPE=text pattern=$regexValidation_Margin $title_input_kropka>&nbsp;[PLN]&nbsp;[8]
          </TD>
          <TD class=td2tableL>$txt_td_126 (bezwzględnie)</TD>
          <TD class=td0010 $sl5 colspan=1>
            <INPUT CLASS=a NAME=cost_sales_one_write id=cost_sales_one_write onchange=\"javascript:count_cost_count_total('$prowizja_25proc_sales','$prowizja_25proc_margin')\" MAXLENGTH=10 STYLE=\"width: 100px; text-align: right; padding-right: 5px; background-color: #FF9966;\" VALUE=\"$cost_sales_one_write\" TYPE=text pattern=$regexValidation_UnitPrice $title_input_kropka>&nbsp;[PLN]&nbsp;[5]
          </TD>
      </TR>
      <TR><TD class=td2tableL>$txt_td_114 (istniejące)</TD>
          <TD class=td0010 colspan=4>
              $file_all
           </TD>
      </TR>
      <TR><TD class=td2tableL>$txt_td_114 (inne)</TD>
          <TD class=td0010 colspan=4>
              <INPUT type=file NAME=file_1 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_2 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_3 class=a >&nbsp;[max $max_filesize_ MB]
          </TD>
      </TR>
      <TR><TD class=td2tableL>$txt_td_114 (konstrukcja)</TD>
          <TD class=td0010 colspan=4>
              <INPUT type=file NAME=file_4 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_5 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_6 class=a >&nbsp;[max $max_filesize_ MB]
          </TD>
      </TR>
      <TR><TD class=td2tableL>$txt_td_114 (grafika)</TD>
          <TD class=td0010 colspan=4>
              <INPUT type=file NAME=file_7 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_8 class=a >&nbsp;[max $max_filesize_ MB]<BR>
              <INPUT type=file NAME=file_9 class=a >&nbsp;[max $max_filesize_ MB]
          </TD>
      </TR>
    </TABLE>
  <BR>
  $table_task_data

<!--Początek sekcji wyśtwietlającej obliczenia i wyniki obliczeń dla każdej z pozycji-->

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

      <TR>
          <TD class=td0011 $sl5>Farby Awers</TD>
          <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_awers_material_info id=cost_awers_material_info VALUE=\"$cost_awers_material_info\"></TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers_material id=cost_awers_material VALUE=\"$cost_awers_material\">&nbsp;[PLN]</TD>
      </TR>
      <TR>
          <TD class=td0011 $sl5>Blachy Awers</TD>
          <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_awers_material_clicha_info id=cost_awers_material_clicha_info VALUE=\"$cost_awers_material_clicha_info\"></TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_awers_material_clicha id=cost_awers_material_clicha VALUE=\"$cost_awers_material_clicha\">&nbsp;[PLN]</TD>
      </TR>
      <TR>
          <TD class=td0011 $sl5>Farby Reswers</TD>
          <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_rewers_material_info id=cost_rewers_material_info VALUE=\"$cost_rewers_material_info\"></TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers_material id=cost_rewers_material VALUE=\"$cost_rewers_material\">&nbsp;[PLN]</TD>
      </TR>
      <TR>
          <TD class=td0011 $sl5>Blachy Reswers</TD>
          <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_rewers_material_clicha_info id=cost_rewers_material_clicha_info VALUE=\"$cost_rewers_material_clicha_info\"></TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_rewers_material_clicha id=cost_rewers_material_clicha VALUE=\"$cost_rewers_material_clicha\">&nbsp;[PLN]</TD>
      </TR>
      <TR>
          <TD class=td0011 $sl5>Dodatkowe płyty</TD>
          <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_extra_plate_info id=cost_extra_plate_info VALUE=\"$cost_extra_plate_info\"></TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_extra_plate id=cost_extra_plate VALUE=\"$cost_extra_plate\">&nbsp;[PLN]</TD>
      </TR>
      <TR>
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
      <TR>
          <TD class=td0011 $sl5>Lakierowanie UV</TD>
          <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_varnish_uv_material_info id=cost_varnish_uv_material_info ></TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_varnish_uv_material id=cost_varnish_uv_material VALUE=\"$cost_varnish_uv_material\" >&nbsp;[PLN]</TD>
      </TR>
      <TR>
          <TD class=td0011 $sl5>Folia HS</TD>
          <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_gilding_material_info id=cost_gilding_material_info VALUE=\"$cost_gilding_material_info\"></TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_gilding_material  id=cost_gilding_material    VALUE=\"$cost_gilding_material\">&nbsp;[PLN]</TD>
      </TR>
      <TR>
          <TD class=td0011 $sl5>Klej do kaszerowania</TD>
          <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_laminating_material_info id=cost_laminating_material_info VALUE=\"$cost_laminating_material_info\"></TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_laminating_material  id=cost_laminating_material    VALUE=\"$cost_laminating_material\">&nbsp;[PLN]</TD>
      </TR>
      <TR>
          <TD class=td0011 $sl5>Folia do wklejania okienek</TD>
          <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_window_foil_info id=cost_window_foil_info VALUE=\"$cost_window_foil_info\"></TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_window_foil  id=cost_window_foil    VALUE=\"$cost_window_foil\">&nbsp;[PLN]</TD>
      </TR>
      <TR>
          <TD class=td0011 $sl5>Suma</TD>
          <TD class=td0010 $sl5 colspan=3>&nbsp;</TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_total_material id=cost_total_material VALUE=\"$cost_total_material\">&nbsp;[PLN]</TD>
      </TR>


      <TR>
        <TD class='td2tableC header3Text' $sc colspan=6>
          KOSZTY I CZASY OPERACYJNE
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
          <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay name=printingAwersRunTime id=printingAwersRunTime  VALUE=\"$printingAwersRunTime\" TYPE=text>&nbsp;[hh:mm]</TD>
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
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=separationRunTotalCosts id=separationRunTotalCosts VALUE=\"-\">&nbsp;[PLN]</TD>
      </TR>
      <TR >
          <TD class=td0011 $sl5>Separacja IDLE</TD>
          <TD class=td0010 $sl5><INPUT TYPE=$input_hidden_type_view_info CLASS=H_info_real NAME=cost_manual_work_idle_info id=cost_manual_work_idle_info VALUE=\"$cost_manual_work_info\"></TD>
          <TD class=td0011 $sl5><INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay NAME=separationIdleTime id=separationIdleTime  VALUE=\"$separationIdleTime\" TYPE=text>&nbsp;[hh:mm]</TD>
          <TD class=td0010 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_manual_work_idle_real id=cost_manual_work_idle_real VALUE=\"$cost_manual_work_idle_real\">&nbsp;[PLN]</TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=separationIdleTotalCosts id=separationIdleTotalCosts VALUE=\"-\">&nbsp;[PLN]</TD>
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
          <TD class=td0011 $sl5>Korekta czasów operacji</TD>
          <TD class=td0010 $sl5>
            <INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=operationTimeCorrectionInfo  id=operationTimeCorrectionInfo  VALUE=\"$operationTimeCorrectionInfo \">
          </TD>
          <TD class=td0011 $sl5>
            <INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold NAME=operationTimeCorrectionTotal  id=operationTimeCorrectionTotal  VALUE=\"$operationTimeCorrection \">&nbsp;[hh:mm]
          </TD>
      </TR>
      <TR >
          <TD class=td0011 $sl5>
            <label class=label-bold>Sumy czasów operacji i koszów</label>
          </TD>
          <TD class=td0010 $sr5>
            <label class=label-bold>Czasy narządów</label>
            <BR>
            <label class=label-bold>Czasy jazdy</label>
            <BR>
            <label class=label-bold>Czasy idle (nie wliczane do sumy)</label>
            <BR>
            <label class=label-bold>Suma czasów operacji</label>
          </TD>
          <TD class=td0011 $sl5>
            <INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold NAME=totalSetupTime id=totalSetupTime  VALUE=\"$totalSetupTime\" TYPE=text>&nbsp;[hh:mm]
            <INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold NAME=totalRunTime id=totalRunTime  VALUE=\"$totalRunTime\" TYPE=text>&nbsp;[hh:mm]
            <INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold NAME=totalIdleTime id=totalIdleTime  VALUE=\"$totalIdleTime\" TYPE=text>&nbsp;[hh:mm]
            <INPUT TYPE=$input_hidden_type_view CLASS=timeDisplay-bold NAME=totalOperationTime id=totalOperationTime  VALUE=\"$totalOperationTime\" TYPE=text>&nbsp;[hh:mm]
          </TD>
          <TD class=td0110 $sr5 colspan=2>
            <INPUT TYPE=$input_hidden_type_view CLASS=H-bold NAME=cost_total_operation id=cost_total_operation VALUE=\"$cost_total_operation\">&nbsp;[PLN]
            </TD>
      </TR>



      <TR ><TD class='td2tableC header3Text' $sc colspan=5>KOSZTY USŁUG ZEWNĘTRZNYCH</TD></TR>
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
          <TD class=td0011 $sl5>Wklejanie okienek</TD>
          <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=externalWindowPatching_info id=externalWindowPatching_info VALUE=\"$externalWindowPatching_info\"></TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=externalWindowPatching id=externalWindowPatching VALUE=\"$externalWindowPatching\">&nbsp;[PLN]</TD>
      </TR>
      <TR >
          <TD class=td0011 $sl5>Transport wklejanie okienek</TD>
          <TD class=td0010 $sl5 colspan=3><INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=externalWindowPatchingTransport_info id=externalWindowPatchingTransport_info VALUE=\"$externalWindowPatchingTransport_info\"></TD>
          <TD class=td0110 $sr5><INPUT TYPE=$input_hidden_type_view CLASS=H NAME=externalWindowPatchingTransport id=externalWindowPatchingTransport VALUE=\"$externalWindowPatchingTransport\">&nbsp;[PLN]</TD>
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

      <TR ><TD class='td2tableC header3Text' $sc colspan=5>KOSZTY DODATKOWE</TD></TR>
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
          <TD class=td0011 $sl5>Narzędzia wycinania</TD>
          <TD class=td0010 $sl5 colspan=3>
            <INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=hiddenToolingCostInfo id=hiddenToolingCostInfo VALUE=\"$hiddenToolingCostInfo\">
          </TD>
          <TD class=td0110 $sr5>
            <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=hiddenToolingCosts id=hiddenToolingCosts VALUE=\"$hiddenToolingCosts\">&nbsp;[PLN]
            <INPUT TYPE=hidden CLASS=H NAME=hiddenToolingCosts_InPrice id=hiddenToolingCosts_InPrice VALUE=\"$hiddenToolingCosts_InPrice\">
            <INPUT TYPE=hidden CLASS=H NAME=hiddenToolingCosts_CoveredBySupplier id=hiddenToolingCosts_CoveredBySupplier VALUE=\"$hiddenToolingCosts_CoveredBySupplier\">
          </TD>
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

      <TR ><TD class='td2tableC header3Text' $sc colspan=5>POZOSTAŁE KOSZTY DO WYFAKTUROWANIA</TD></TR>
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
          <TD class=td0011 $sl5>Narzedzia wycinania</TD>
          <TD class=td0010 $sl5 colspan=3>
            <INPUT TYPE=$input_hidden_type_view_info CLASS=H-info NAME=cost_dicut_info id=cost_dicut_info VALUE=\"$cost_dicut_info\" >
            <INPUT TYPE=hidden CLASS=H-info NAME=invoicedToolingCostsInfoString id=invoicedToolingCostsInfoString VALUE=\"$invoicedToolingCostsInfoString\" >
          </TD>
          <TD class=td0110 $sr5>
            <INPUT TYPE=$input_hidden_type_view CLASS=H NAME=cost_dicut id=cost_dicut VALUE=\"$cost_dicut\">&nbsp;[PLN]
            <INPUT TYPE=hidden CLASS=H NAME=invoicedToolingCosts id=invoicedToolingCosts VALUE=\"$invoicedToolingCosts\">
          </TD>
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

      <TR ><TD class='td2tableC header3Text' $sc colspan=5>PODSUMOWANIE - KALKULACJA TRADYCYJNA</TD></TR>
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
      <TR ><TD class='td2tableC header3Text' $sc colspan=5>PODSUMOWANIE - KALKULACJA PRZEROBOWA</TD></TR>
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


      <TR >
      <!-- Hidden fields section, holiding times and cost to save in db-->
          <TD class=td0000 colspan=5>
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_administracja1 id=cost_administracja1 VALUE=\"$cost_administracja1\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_administracja_from1 id=cost_administracja_from1 VALUE=\"$cost_administracja_from1\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_administracja_to1 id=cost_administracja_to1 VALUE=\"$cost_administracja_to1\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_administracja2 id=cost_administracja2 VALUE=\"$cost_administracja2\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_administracja_from2 id=cost_administracja_from2 VALUE=\"$cost_administracja_from2\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_administracja_to2 id=cost_administracja_to2 VALUE=\"$cost_administracja_to2\">&nbsp;

              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_podatek1 id=cost_podatek1 VALUE=\"$cost_podatek1\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_podatek_from1 id=cost_podatek_from1 VALUE=\"$cost_podatek_from1\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_podatek_to1 id=cost_podatek_to1 VALUE=\"$cost_podatek_to1\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_podatek2 id=cost_podatek2 VALUE=\"$cost_podatek2\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_podatek_from2 id=cost_podatek_from2 VALUE=\"$cost_podatek_from2\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_podatek_to2 id=cost_podatek_to2 VALUE=\"$cost_podatek_to2\">&nbsp;
            <!-- Cutting 1 -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_cut_total_time id=cost_cut_total_time VALUE=\"$cost_cut_total_time\">&nbsp;
            <!-- Cutting 2 -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_cut2_total_time id=cost_cut2_total_time VALUE=\"$cost_cut2_total_time\">&nbsp;
            <!-- Printing 2 -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=rewers2_prod_time id=rewers2_prod_time VALUE=\"$rewers2_prod_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=awers2_prod_time id=awers2_prod_time VALUE=\"$awers2_prod_time\">&nbsp;
            <!-- Printing 1 -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=rewers_prod_time id=rewers_prod_time VALUE=\"$rewers_prod_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=awers_prod_time id=awers_prod_time VALUE=\"$awers_prod_time\">&nbsp;
            <!-- Offset varnish -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_varnish_jazda_time id=cost_varnish_jazda_time VALUE=\"$cost_varnish_jazda_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_varnish2_jazda_time id=cost_varnish2_jazda_time VALUE=\"$cost_varnish2_jazda_time\">&nbsp;
            <!-- UV varnish -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_varnish_uv_setup_time id=cost_varnish_uv_setup_time VALUE=\"$cost_varnish_uv_setup_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_varnish_uv_jazda_time id=cost_varnish_uv_jazda_time VALUE=\"$cost_varnish_uv_jazda_time\">&nbsp;
            <!-- Hot stamping -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_matryc1_setup_time id=cost_matryc1_setup_time VALUE=\"$cost_matryc1_setup_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_matryc1_prod_time id=cost_matryc1_prod_time VALUE=\"$cost_matryc1_prod_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_matryc2_setup_time id=cost_matryc2_setup_time VALUE=\"$cost_matryc2_setup_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_matryc2_prod_time id=cost_matryc2_prod_time VALUE=\"$cost_matryc2_prod_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_matryc3_setup_time id=cost_matryc3_setup_time VALUE=\"$cost_matryc3_setup_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_matryc3_prod_time id=cost_matryc3_prod_time VALUE=\"$cost_matryc3_prod_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_matryc4_setup_time id=cost_matryc4_setup_time VALUE=\"$cost_matryc4_setup_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_matryc4_prod_time id=cost_matryc4_prod_time VALUE=\"$cost_matryc4_prod_time\">&nbsp;
            <!-- Litholamination -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_laminating_prod_time id=cost_laminating_prod_time VALUE=\"$cost_laminating_prod_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_laminating_setup_time id=cost_laminating_setup_time VALUE=\"$cost_laminating_setup_time\">&nbsp;
            <!-- Manual separation -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_manual_work_prod_time id=cost_manual_work_prod_time VALUE=\"$cost_manual_work_prod_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_window_glue_prod_time id=cost_window_glue_prod_time VALUE=\"$cost_window_glue_prod_time\">&nbsp;
            <!-- Die cutting 1 -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_dcting_setup_time id=cost_dcting_setup_time VALUE=\"$cost_dcting_setup_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_dcting_prod_time id=cost_dcting_prod_time VALUE=\"$cost_dcting_prod_time\">&nbsp;
            <!-- Die cutting 2 -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_dcting2_setup_time id=cost_dcting2_setup_time VALUE=\"$cost_dcting2_setup_time\">&nbsp;
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_dcting2_prod_time id=cost_dcting2_prod_time VALUE=\"$cost_dcting2_prod_time\">&nbsp;
            <!-- Manual gluing -->
              <INPUT TYPE=$input_hidden_type CLASS=H NAME=cost_glue_prod_time id=cost_glue_prod_time VALUE=\"$cost_glue_prod_time\">&nbsp;
          </TD>
      </TR>
  </TABLE>

</DIV>
<DIV id=\"calendarDiv\"></DIV>

</FORM>
</div>
";
///<TD class=td0010 $sl5 colspan=2><SPAN STYLE=\"font-size: $size_span;\">$txt_td_094</SPAN><BR><INPUT CLASS=a NAME=glue_cost_box id=glue_cost_box onchange=\"javascript:count_cost_glue()\" VALUE=\"$glue_cost_box\" TYPE=text MAXLENGTH=7 STYLE=\"width: 100px; text-align: right; padding-right: 5px; \" pattern=\"[0-9.]{0,12}\" $title_input_kropka>&nbsp;[7]
//wywołaj stronę
//INCLUDE('./page_content.php');
//  <DIV style=\"width: 970px; height: 10px; margin-left: 0px;\">
//       <DIV id=div_calculate CLASS=error style=\"width: 970px; display: none; float: left; height: 10px;\">Oczekuj ... system oblicza koszty!</DIV>
//  </DIV>

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
IF ($action == "save") {

//kontrola dostępu
//AccessDeniedCheck($connection,$user_id,$userlevel_id,$serwer,$menu_access,"audit_plan_show.php -> do_edit");
// get data from form to be saved to table order_calculations
  $order_nr         = $_POST['order_nr'];
  $name             = $_POST['name'];
  $customer_id      = $_POST['customer_id'];
  $customerOrder    = $_POST['customerOrder'];
  $grossQty         = $_POST['grossQty']; // grossQty = netQty + all additional sheets needed for process setups
  $netQty           = $_POST['netQty']; // netQty = qty ordered by customer
  $nesting          = $_POST['product_paper_value1']; // nesting = ups on sheet
  $totalSales       = $_POST['cost_sales']; // get total sales from calculation form fields (named cost_sales)
  $tvc              = $_POST['TVC'];
  $throughput       = $_POST['throughput'];
  $totalOperationTime = $_POST['totalOperationTime'];
  $operationTimeCorrection = $_POST['operationTimeCorrection'];
  $calculationEngineVersion = $_POST['engineVersion'];
  $calculationEngineDate = $_POST['engineDate'];

// convert unwanted characters before writing into db
  $name           = convertUnwantedSingsInString($name);
  $customerOrder  = convertUnwantedSingsInString($customerOrder);
//convert HH:MM to decimal time value before writting to db
  $totalOperationTime = phpHHMMToValue($totalOperationTime);
  $operationTimeCorrection = phpHHMMToValue($operationTimeCorrection);
  //$name           = str_replace("/"," ",$name);
  //$name           = str_replace("."," ",$name);


$dsc ="";  //         = $_POST['order_nr'];
$cost_total ="";//    = $_POST['order_nr'];
$txt_text_0001  = $OCLangDict['txt_text_0001'][$lang_id];
$txt_text_0002  = $OCLangDict['txt_text_0002'][$lang_id];
$txt_text_0007  = $OCLangDict['txt_text_0007'][$lang_id];
$txt_text_0006  = $OCLangDict['txt_text_0006'][$lang_id];
$txt_text_0020  = $OCLangDict['txt_text_0020'][$lang_id];

IF ($oc_id) { // check if a calculaiton already exists (oc_id is present) and if so update data
      ///zaps do loga
      $sql1 = "SELECT name, dsc, order_nr, nesting, grossQty, netQty, totalSales, tvc, throughput, totalOperationTime, operationTimeCorrection
               FROM order_calculations
               WHERE oc_id='$oc_id' "; //echo "$sql<BR>";
      $result1 = @mysql_query($sql1, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> save -> READ OC]<BR>$sql1");
        while ($row1 = mysql_fetch_array($result1)) {
          $name_old             = $row1['name'];
          $order_nr_old         = $row1['order_nr'];
          $dsc_old              = $row1['dsc'];
          $nesting_old       = $row1['nesting'];
          $grossQty_old       = $row1['grossQty'];
          $netQty_old       = $row1['netQty'];
          $totalSales_old       = $row1['totalSales'];
          $tvc_old         = $row1['tvc'];
          $throughput_old       = $row1['throughput'];
          $totalOperationTime_old       = $row1['totalOperationTime'];
          $operationTimeCorrection_old       = $row1['operationTimeCorrection'];


          if (($name) && ($name != $name_old)) {
            //NOTE: all calculaiton form fields saved to db by SaveDataOrderCalculationDatas function are also logged to db through SaveOrderCalculationLogs so the below saves to logs are doubled in fact
            /*
            FUNCTION SaveOrderCalculationLogs($connection,$user_id,$status,$option_name,$oc_id,$changes) {
              //zapisz logów do tabeli
              $changes = addslashes($changes);
              $option_name = addslashes($option_name);
              $sql = "INSERT INTO order_calculation_logs (user_id, status, option_name, option_id, changes)
                      VALUES (\"$user_id\", \"$status\", \"$option_name\", \"$oc_id\", \"$changes\")"; //echo "$sql<BR>";
              $result = @mysql_query($sql, $connection) or die("Wykonanie zapytania nie powiodło się! [AuditPlan_functions.php -> f(SaveAuditPlanLog) -> insert AuditPlan_logs]<BR>$sql");
            }
            */
            SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"$txt_td_002 $txt_text_0007 | $name_old | $txt_text_0006 | $name |");
          }
          if (($order_nr) && ($order_nr != $order_nr_old)) {
            SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"$txt_td_031 $txt_text_0007 | $order_nr_old | $txt_text_0006 | $order_nr |");
          }
          if (($dsc) && ($dsc != $dsc_old)) {
            SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"Opis $txt_text_0007 | $dsc_old | $txt_text_0006 | $dsc |");
          }
          if (($nesting) && ($nesting != $nesting_old)) {
            SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"Uzytki $txt_text_0007 | $nesting_old | $txt_text_0006 | $nesting | uz.");
          }
          if (($grossQty) && ($grossQty != $grossQty_old)) {
            SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"Ilosc brutto $txt_text_0007 | $grossQty_old | $txt_text_0006 | $grossQty | szt.");
          }
          if (($netQty) && ($netQty != $netQty_old)) {
            SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"Ilosc netto $txt_text_0007 | $netQty_old | $txt_text_0006 | $netQty | szt.");
          }
          if (($totalSales) && ($totalSales != $totalSales_old)) {
            SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"Sprzedaz $txt_text_0007 | $totalSales_old | $txt_text_0006 | $totalSales | PLN");
          }
          if (($tvc) && ($tvc != $tvc_old)) {
            SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"TVC $txt_text_0007 | $tvc_old | $txt_text_0006 | $tvc | PLN");
          }
          if (($throughput) && ($throughput != $throughput_old)) {
            SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"Przerob $txt_text_0007 | $throughput_old | $txt_text_0006 | $throughput | PLN");
          }
          if (($totalOperationTime) && ($totalOperationTime != $totalOperationTime_old)) {
            SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"Suma roboczogodzin $txt_text_0007 | $totalOperationTime_old | $txt_text_0006 | $totalOperationTime | h");
          }
          if (($operationTimeCorrection) && ($operationTimeCorrection != $operationTimeCorrection_old)) {
            SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"Korekta roboczogodzin $txt_text_0007 | $operationTimeCorrection_old | $txt_text_0006 | $operationTimeCorrection | h");
          }
      }
      // NOTE: new fields added to order_calculations 2020-03-04
      $sql2 = "UPDATE order_calculations SET
                customerOrder=\"$customerOrder\",
                customer_id=\"$customer_id\",
                user_id=\"$user_id\",
                name=\"$name\",
                dsc=\"$dsc\",
                nesting=\"$nesting\",
                grossQty=\"$grossQty\",
                netQty=\"$netQty\",
                totalSales=\"$totalSales\",
                tvc=\"$tvc\",
                throughput=\"$throughput\",
                totalOperationTime=\"$totalOperationTime\",
                operationTimeCorrection = \"$operationTimeCorrection\",
                order_nr=\"$order_nr\",
                engineVersion=\"$calculationEngineVersion\",
                engineDate=\"$calculationEngineDate\"
               WHERE oc_id='$oc_id' LIMIT 1";  //echo "$sql2<BR>";
      $result2 = @mysql_query($sql2, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calcylatioon_create.php -> save -> UPDATE order_calculations]");
} else { // check if a calculaiton already exists (oc_id is present) and if not insert data
      $sql2 = "INSERT INTO order_calculations (
                user_id,
                status,
                create_date,
                create_user,
                name,
                year,
                order_nr,
                customer_id,
                customerOrder,
                dsc,
                version,
                nesting,
                grossQty,
                netQty,
                totalSales,
                throughput,
                tvc,
                totalOperationTime,
                operationTimeCorrection,
                engineVersion,
                engineDate)
               VALUES (
                 \"$user_id\",
                 \"10\",
                 \"$dzisiaj\",
                 \"$user_id\",
                 \"$name\",
                 \"$year\",
                 \"$order_nr\",
                 \"$customer_id\",
                 \"$customerOrder\",
                 \"$dsc\",
                 \"1\",
                 \"$nesting\",
                 \"$grossQty\",
                 \"$netQty\",
                 \"$totalSales\",
                 \"$throughput\",
                 \"$tvc\",
                 \"$totalOperationTime\",
                 \"$operationTimeCorrection\",
                 \"$calculationEngineVersion\",
                 \"$calculationEngineDate\") ";
      $result2 = @mysql_query($sql2, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> save -> INSERt OC]");
      $oc_id = mysql_insert_id();
      SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"$txt_text_0001 | $name |");
}
//echo "$sql2<BR>";

$OcD =array();
$sql2 = "SELECT ocd_id, var,value
         FROM order_calculation_datas
         WHERE oc_id='$oc_id' AND status>'0'"; //echo "$sql<BR>";
$result2 = @mysql_query($sql2, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> save -> READ order_calculation_datas]<BR>$sql");
  while ($row2 = mysql_fetch_array($result2)) {
    $ocd_id      = $row2['ocd_id'];
    $var         = $row2['var'];
    $value       = $row2['value'];
    $OcD[$var]["id"]     = $ocd_id;
    $OcD[$var]["value"]  = $value;
}


// BEGIN saving calculation data to db

$var = "engineVersion"; $txt_td = "Calculation engine version";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "engineDate"; $txt_td = "Calculation engine date";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "customerOrder"; $txt_td = "Nr zlecenia klienta";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "calc_type"; $txt_td = "Typ kalkulacji";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
// Begin saving order construction data
  $var = "boxWidth"; $txt_td = "Szerokosc pracy";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "boxLenght"; $txt_td = "Wysokosc pracy";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "boxDepth"; $txt_td = "Glebokosc pracy";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "upWidth"; $txt_td = "Szerokosc uzytku";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "upLenght"; $txt_td = "Dlugosc uzytku";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "upWindows"; $txt_td = "Ilosc okienek";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "cost_paper1"; $txt_td = $txt_td_116;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_paper2"; $txt_td = $txt_td_117;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_margin"; $txt_td = $txt_td_122;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_prowizja7"; $txt_td = $txt_td_127;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_total_material"; $txt_td = $txt_td_118;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_total_operation"; $txt_td = $txt_td_119;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_bep"; $txt_td = $txt_td_123;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_bep_one"; $txt_td = $txt_td_125;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_total_out"; $txt_td = $txt_td_120;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_transport"; $txt_td = $txt_td_121;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_transport_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_transport_box"; $txt_td = $txt_td_121;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_transport_total"; $txt_td = $txt_td_121;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_sales"; $txt_td = $txt_td_124;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var0 = $var;
/*
$var = "order_qty_cost_sales1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var0],$OcD[$var]["value"]);
*/
$var = "cost_sales_one"; $txt_td = $txt_td_126;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_margin_1_3"; $txt_td = $txt_td_131;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_prowizja10"; $txt_td = $txt_td_131;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_prowizja15"; $txt_td = $txt_td_129;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_2_5"; $txt_td = $txt_td_130;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_goods"; $txt_td = $txt_td_132;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

// poczatek zapisu danych przerobowych
  $var = "TVC"; $txt_td = $txt_td_217;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "TVC_unit"; $txt_td = $txt_td_235;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "TVC_info"; $txt_td = $txt_td_218;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput"; $txt_td = $txt_td_219;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput_info"; $txt_td = $txt_td_220;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput_unit"; $txt_td = $txt_td_221;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput_comission"; $txt_td = $txt_td_222;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput_comission_percent"; $txt_td = $txt_td_222;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput_comission_info"; $txt_td = $txt_td_223;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

  $var = "throughput_to_sales"; $txt_td = $txt_td_227;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput_to_sales_threshold"; $txt_td = $txt_td_228;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "totalOperationTime"; $txt_td = $txt_td_229;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput_per_labour"; $txt_td = $txt_td_230;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput_per_labour_threshold"; $txt_td = $txt_td_231;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput_to_sales_warningLevel"; $txt_td = "$txt_td_236";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput_per_labour_warningLevel"; $txt_td = "$txt_td_237";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

  $var = "throughput_threshold_fixed"; $txt_td = $txt_td_233;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "throughput_threshold_fixed_per_sheet"; $txt_td = $txt_td_234;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

// koniec zapisu danych przerobowych
$var = "cost_margin_unit"; $txt_td = $txt_td_232;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);



$var = "order_date"; $txt_td = $txt_td_032;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "end_date"; $txt_td = $txt_td_033;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "end_week"; $txt_td = $txt_td_034;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
// BEGIN saving of customer data
  $var = "customer_id"; $txt_td = $txt_td_035;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "customer"; $txt_td = $txt_td_035;
  $var_value = $_POST[$var];
  IF ( (isset($_POST['customer_id'])) && (!$var_value)) {
    $customer_id = $_POST['customer_id'];
    FindOrderCalculationTableDatas($connection,"name","","","customer_id='$customer_id'","customers",$var_value,$v2,$v3);
  }
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$var_value,$OcD[$var]["value"]);
  $var = "customer_name"; $txt_td = $txt_td_035." ";
  FindOrderCalculationTableDatas($connection,"name","","","customer_id='$customer_id'","customers",$var_value,$v2,$v3);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$var_value,$OcD[$var]["value"]);
  $var = "customer_short_name"; $txt_td = $txt_td_035." ";
  FindOrderCalculationTableDatas($connection,"short_name","","","customer_id='$customer_id'","customers",$var_value,$v2,$v3);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$var_value,$OcD[$var]["value"]);
// END saving of customer data
$var = "accept_type_id"; $txt_td = $txt_td_036;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "order_total_weight"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "accept_cost"; $txt_td = $txt_td_037;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "expiration_date"; $txt_td = $txt_td_038;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "barcode"; $txt_td = $txt_td_039;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "manufacturer_box_info"; $txt_td = $txt_td_040;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "print_quality"; $txt_td = $txt_td_041;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "extra_dsc"; $txt_td = $txt_td_042;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "orginal_order_dsc"; $txt_td = $txt_td_043;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "manual_work_window_id"; $txt_td = $txt_td_200 ." - ".$txt_td_201;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

//$var = "version_dsc"; $txt_td = $txt_td_044;
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "order_type"; $txt_td = $txt_td_045;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "order_type_id"; $txt_td = $txt_td_045;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cliche_cost"; $txt_td = $txt_td_047;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_plate1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_plate2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "order_qty1"; $txt_td = $txt_td_050;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
/* deactivated 2019-01-09 replaced by maximumQty and hasMaximumQty
$var = "not_more_like"; $txt_td = $txt_td_216;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
*/
$var = "order_qty1_less"; $txt_td = $txt_td_050;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "order_qty1_less_procent"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "grossQty"; $txt_td = "grossQty";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "netQty"; $txt_td = "netQty";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
/* deactivated 2019-01-09 replaced by



 and chckMinimumQty
$var = "not_less"; $txt_td = $txt_td_160;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
*/

$var = "chckMinimumQty"; $txt_td = ""; // added 2019-01-09
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "minimumQty"; $txt_td = $txt_td_160; // added 2019-01-09
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "chckMaximumQty"; $txt_td = ""; // added 2019-01-09
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "maximumQty"; $txt_td = $txt_td_216; // added 2019-01-09
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);



$var = "tolerant"; $txt_td = $txt_td_051;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "print_type"; $txt_td = $txt_td_052."/".$txt_td_053;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "new_dctool"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "new_grafic"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "paper1_weight"; $txt_td = "waga brutto surowca 1";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rawMaterial1_NetKG"; $txt_td = "waga netto surowca 1";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "paper_id1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "paper_gram_id1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "format_id1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_sheetx1"; $txt_td = $txt_td_056." wymiar X";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_sheety1"; $txt_td = $txt_td_056." wymiar Y";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_value1"; $txt_td = $txt_td_079;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_cut1"; $txt_td = $txt_td_159;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_cost_kg1"; $txt_td = $txt_td_078;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "paper_type_id1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gram1"; $txt_td = $txt_td_056." gramatura";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "sheetx1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "sheety1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "waste_proc1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);



$var = "paper2_m2"; $txt_td = "powierchnia brutto surowca 2";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "paper2_weight"; $txt_td = "waga brutto surowca 2";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rawMaterial2_NetSQM"; $txt_td = "powierzchnia netto surowca 2";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rawMaterial2_NetKG"; $txt_td = "waga netto surowca 2";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_cost_history"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "paper_id2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "paper_gram_id2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "format_id2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "check_cut2"; $txt_td = "Znacznik ciecia surowca II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_sheetx2"; $txt_td = $txt_td_057." wymiar X";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_sheety2"; $txt_td = $txt_td_057." wymiar Y";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_value2"; $txt_td = $txt_td_079;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_cost_kg2"; $txt_td = $txt_td_078;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_cost_m22"; $txt_td = $txt_td_084;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "product_paper_narzut_proc2"; $txt_td = $txt_td_084;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "paper_type_id2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gram2"; $txt_td = $txt_td_057." gramatura";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "sheetx2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "sheety2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "waste_proc2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);




//$var = "cost_plate"; $txt_td = "";
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
//$var = "cost_plate_info"; $txt_td = "";
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra_plate"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra_plate_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers_cmyk_qty_colors"; $txt_td = $txt_td_080 ." ". $txt_td_054;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers_pms_qty_colors"; $txt_td = $txt_td_081 ." ". $txt_td_054;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers_pms_sqmm"; $txt_td = $txt_td_082 ." ". $txt_td_054;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers_pms_colors"; $txt_td = $txt_td_083 ." ". $txt_td_054;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "print_machine_name"; $txt_td = "Maszyna drukująca";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "print_machine_id"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_minimum"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_minimum_mnoznik"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_print1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_print2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_printN1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_printN2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_ink_cmyk"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_ink_pms"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "use_ink"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers_setup"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers_speed"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers_idle_jazdaP"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers_idle_narzadP"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers_idle_costH"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers_setup"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers_speed"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers_cmyk_qty_colors"; $txt_td = $txt_td_080 ." ". $txt_td_055;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers_pms_qty_colors"; $txt_td = $txt_td_081 ." ". $txt_td_055;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers_pms_sqmm"; $txt_td = $txt_td_082 ." ". $txt_td_055;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers_pms_colors"; $txt_td = $txt_td_083 ." ". $txt_td_055;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "varnish_type_id"; $txt_td = $txt_td_058;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "extra_plate_komori"; $txt_td = "Dodatkowe płyty Komori";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "extra_plate_roland"; $txt_td = "Dodatkowe płyty Roland";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "varnish2_type_id"; $txt_td = $txt_td_058."II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "extra_plate2_komori"; $txt_td = "Dodatkowe płyty Komori II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "extra_plate2_roland"; $txt_td = "Dodatkowe płyty Roland II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "add_print2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers2_cmyk_qty_colors"; $txt_td = $txt_td_080 ."II ". $txt_td_054;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers2_pms_qty_colors"; $txt_td = $txt_td_081 ."II ". $txt_td_054;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers2_pms_sqmm"; $txt_td = $txt_td_082 ."II ". $txt_td_054;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers2_pms_colors"; $txt_td = $txt_td_083 ."II ". $txt_td_054;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "print2_machine_name"; $txt_td = "Maszyna drukująca II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "print2_machine_id"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra2_plate"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra2_plate_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_minimum2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers2_setup"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers2_speed"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers2_idle_jazdaP"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers2_idle_narzadP"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers2_idle_costH"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers2_setup"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers2_speed"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers2_cmyk_qty_colors"; $txt_td = $txt_td_080 ." ". $txt_td_055;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers2_pms_qty_colors"; $txt_td = $txt_td_081 ." ". $txt_td_055;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers2_pms_sqmm"; $txt_td = $txt_td_082 ." ". $txt_td_055;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers2_pms_colors"; $txt_td = $txt_td_083 ." ". $txt_td_055;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

//$var = "varnish_sqm_ark"; $txt_td = $txt_td_058 ." ". $txt_td_059;
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "varnish_uv_type_id"; $txt_td = $txt_td_060;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "varnish_uv_sqm_ark"; $txt_td = $txt_td_060 ." ". $txt_td_059;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "ink_varnish_id"; $txt_td = $txt_td_061;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
//$var = "ink_varnish_type_id"; $txt_td = $txt_td_152;
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
//$var = "ink_varnish_sqm_ark"; $txt_td = $txt_td_061 ." ". $txt_td_059;
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "ink_varnish_dsc"; $txt_td = $txt_td_061;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_ink_varnish_total"; $txt_td = $txt_td_061 ." ". $txt_td_062;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_ink_varnish_sheet"; $txt_td = $txt_td_061 ." ". $txt_td_207;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "gilding_box"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_box0"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_box1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_box2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_box3"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_box4"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_qty1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_qty2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_qty3"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_qty4"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_speed_id1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_speed_id2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_speed_id3"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_speed_id4"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding1_speed"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding2_speed"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding3_speed"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding4_speed"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_type_id1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding1_type_value"; $txt_td = "Typ złocenia mnożik"." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding1_speed_value"; $txt_td = "Prędkość złocenia mnożik"." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_jump_id1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding1_jump_value"; $txt_td = "Skok złocenia mnoznik"." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqmm_id1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding1_sqm_value"; $txt_td = "Powierzchnia złocenia mnożnik"." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_foil_cost_sqm1"; $txt_td = $txt_td_087." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc1"; $txt_td = $txt_td_086." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc1x"; $txt_td = $txt_td_086." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc1y"; $txt_td = $txt_td_086." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc2x"; $txt_td = $txt_td_086." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc2y"; $txt_td = $txt_td_086." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc3x"; $txt_td = $txt_td_086." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc3y"; $txt_td = $txt_td_086." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc4x"; $txt_td = $txt_td_086." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc4y"; $txt_td = $txt_td_086." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_qty_matryc1"; $txt_td = $txt_td_089." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
//$var = "gilding_qty_point1"; $txt_td = $txt_td_107." I";
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc1"; $txt_td = $txt_td_110." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc1_f"; $txt_td = $txt_td_191." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc1_prod"; $txt_td = $txt_td_111." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc1_setup"; $txt_td = $txt_td_112." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc1_idle"; $txt_td = $txt_td_209." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc1_total"; $txt_td = $txt_td_113." I";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "gilding_type_id2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding2_type_value"; $txt_td = "Typ złocenia mnożik"." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding2_speed_value"; $txt_td = "Prędkość złocenia mnożik"." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_jump_id2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding2_jump_value"; $txt_td = "Skok złocenia mnoznik"." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqmm_id2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding2_sqm_value"; $txt_td = "Powierzchnia złocenia mnożnik"." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_foil_cost_sqm2"; $txt_td = $txt_td_087." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc2"; $txt_td = $txt_td_086." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_qty_matryc2"; $txt_td = $txt_td_089." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
//$var = "gilding_qty_point2"; $txt_td = $txt_td_107." II";
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc2"; $txt_td = $txt_td_110." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc2_f"; $txt_td = $txt_td_191." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc2_prod"; $txt_td = $txt_td_111." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc2_setup"; $txt_td = $txt_td_112." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc2_idle"; $txt_td = $txt_td_209." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc2_total"; $txt_td = $txt_td_113." II";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "gilding_type_id3"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding3_type_value"; $txt_td = "Typ złocenia mnożik"." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding3_speed_value"; $txt_td = "Prędkość złocenia mnożik"." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_jump_id3"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding3_jump_value"; $txt_td = "Skok złocenia mnoznik"." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqmm_id3"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding3_sqm_value"; $txt_td = "Powierzchnia złocenia mnożnik"." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_foil_cost_sqm3"; $txt_td = $txt_td_087." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc3"; $txt_td = $txt_td_086." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_qty_matryc3"; $txt_td = $txt_td_089." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
//$var = "gilding_qty_point3"; $txt_td = $txt_td_107." III";
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc3"; $txt_td = $txt_td_110." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc3_f"; $txt_td = $txt_td_191." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc3_prod"; $txt_td = $txt_td_111." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc3_setup"; $txt_td = $txt_td_112." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc3_idle"; $txt_td = $txt_td_209." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc3_total"; $txt_td = $txt_td_113." III";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "gilding_type_id4"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding4_type_value"; $txt_td = "Typ złocenia mnożik"." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding4_speed_value"; $txt_td = "Prędkość złocenia mnożik"." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_jump_id4"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding4_jump_value"; $txt_td = "Skok złocenia mnoznik"." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqmm_id4"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding4_sqm_value"; $txt_td = "Powierzchnia złocenia mnożnik"." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_foil_cost_sqm4"; $txt_td = $txt_td_087." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_sqcm_matryc4"; $txt_td = $txt_td_086." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_qty_matryc4"; $txt_td = $txt_td_089." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
//$var = "gilding_qty_point4"; $txt_td = $txt_td_107." IV";
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc4"; $txt_td = $txt_td_110." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc4_f"; $txt_td = $txt_td_191." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc4_prod"; $txt_td = $txt_td_111." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc4_setup"; $txt_td = $txt_td_112." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc4_idle"; $txt_td = $txt_td_209." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc4_total"; $txt_td = $txt_td_113." IV";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "foil_type_id"; $txt_td = $txt_td_064;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "foil_sqm_ark"; $txt_td = $txt_td_064 ." ". $txt_td_085;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "foil_cost_m2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "falc_cost"; $txt_td = $txt_td_067 ." ". $txt_td_062;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "falc_cost_box"; $txt_td = $txt_td_067 ." ". $txt_td_094;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "biga_cost_box"; $txt_td = $txt_td_068 ." ". $txt_td_094;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
// Begin saving of die cutting process data to db
  $var = "dctool_type_id"; $txt_td = $txt_td_069;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "dieCuttingToolingTypeID"; $txt_td = $txt_td_069;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "dieCuttingToolingStatusID"; $txt_td = $txt_td_069;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "dieCuttingToolingInvoicingID"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

  $var = "dctool_cost"; $txt_td = $txt_td_048;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dicut_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dicut"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "invoicedToolingCosts"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "invoicedToolingCostsInfoString"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "strippingToolingTypeID"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "strippingToolingStatusID"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "strippingToolingCost"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "strippingToolingInvoicingID"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

  $var = "cost_dcting_machin"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

  $var = "cost_dcting"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting_narzad_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting_jazda_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting_idle_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);


  $var = "cost_dcting_narzad_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting_jazda_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting_idle_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "dieCuttingTotalInfo"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "dieCuttingSetupTime"; $txt_td = "";    $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "dieCuttingRunTime"; $txt_td = "";      $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "dieCuttingIdleTime"; $txt_td = "";     $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "dieCuttingTotalTime"; $txt_td = "";    $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
// save data on hidden tooling costs to db
  $var = "hiddenToolingCostInfo"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "hiddenToolingCosts"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "hiddenToolingCosts_InPrice"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "hiddenToolingCosts_CoveredBySupplier"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

// End saving of of die cutting process data to db
// Begin saving die cutting 2 data to db
  $var = "dctool2_type_id"; $txt_td = $txt_td_069." II";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "dieCutting2ToolingTypeID"; $txt_td = $txt_td_069;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting2"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting2_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting2_narzad_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting2_narzad_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting2_jazda_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting2_jazda_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting2_idle_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting2_idle_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_dcting_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

  $var = "dieCutting2SetupTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "dieCutting2RunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "dieCutting2IdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "dieCutting2TotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
// End saving die cutting 2 data to db
// START saving internal and external window patching data
  $var = "windowPatchingType"; $txt_td = $txt_td_070 ." ". $txt_td_094;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "window_glue_cost_box"; $txt_td = $txt_td_070 ." ". $txt_td_094;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "window_foil_type_id"; $txt_td = $txt_td_070 ." ". $txt_td_49;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_window_foil"; $txt_td = "Koszt folii wklejania okienek";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_window_foil_info"; $txt_td = "Koszt folii wklejania okienek - obliczenia";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "window_foil_sqm"; $txt_td = $txt_td_070 ." ". $txt_td_151;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_window_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_window"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  //$var = "cost_trans_window_info"; $txt_td = "";
  //SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  //$var = "cost_trans_window"; $txt_td = "";
  //SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "externalWindowPatching"; $txt_td = $txt_td_070 ." ". $txt_td_094;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "externalWindowPatching_info"; $txt_td = $txt_td_070 ." ". $txt_td_094;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "externalWindowPatchingTransport"; $txt_td = $txt_td_070 ." ". $txt_td_094;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "externalWindowPatchingTransport_info"; $txt_td = $txt_td_070 ." ". $txt_td_094;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
// END saving internal and external window patching

$var = "stample_cost"; $txt_td = $txt_td_071 ." ". $txt_td_062;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "stample_cost_box"; $txt_td = $txt_td_071 ." ". $txt_td_094;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
// BEGIN saving manual gluing data to db
  $var = "glue_type_id"; $txt_td = $txt_td_072;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  // manual gluing type modifiers
    $var = "glue_type_slim_check"; $txt_td = $txt_td_072." ".$txt_td_202;
    $MGD_slimBox_value = isset ($_POST[$var]) ? $_POST[$var] : $MGD_slimBox_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$MGD_slimBox_value,$OcD[$var]["value"]);

    $var = "glue_type_tape_check"; $txt_td = $txt_td_072." ".$txt_td_203;
    $MGD_tapePasting_value = isset ($_POST[$var]) ? $_POST[$var] : $MGD_tapePasting_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$MGD_tapePasting_value,$OcD[$var]["value"]);

    $var = "glue_type_window_check"; $txt_td = $txt_td_072." ".$txt_td_204;
    $MGD_windowPasting_value = isset ($_POST[$var]) ? $_POST[$var] : $MGD_windowPasting_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$MGD_windowPasting_value,$OcD[$var]["value"]);

    $var = "glue_type_handle_check"; $txt_td = $txt_td_072." ".$txt_td_204;
    $MGD_handlePasting_value = isset ($_POST[$var]) ? $_POST[$var] : $MGD_handlePasting_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$MGD_handlePasting_value,$OcD[$var]["value"]);

    $var = "glue_type_foiledflap_check"; $txt_td = $txt_td_072." ".$txt_td_204;
    $MGD_foiledFlap_value = isset ($_POST[$var]) ? $_POST[$var] : $MGD_foiledFlap_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$MGD_foiledFlap_value,$OcD[$var]["value"]);

    $var = "glue_type_prefolding_check"; $txt_td = $txt_td_072." ".$txt_td_204;
    $MGD_prefolding_value = isset ($_POST[$var]) ? $_POST[$var] : $MGD_prefolding_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$MGD_prefolding_value,$OcD[$var]["value"]);

  $var = "cost_glue_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_box"; $txt_td = $txt_td_072 ." ". $txt_td_094;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_total"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_jazda_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_jazda_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_idle_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_idle_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_prod_time"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  //manual gluing times
  $var = "manualGluingSetupTime"; $txt_td = $var; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "manualGluingRunTime"; $txt_td = $var; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "manualGluingIdleTime"; $txt_td = $var; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "manualGluingTotalTime"; $txt_td = $var; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  // manual gluing outsourcing
  $var = "manualGluingOutsourcing"; $txt_td = "";
  $manualGluingOutsourcing = isset ($_POST[$var]) ? $_POST[$var] : $manualGluingOutsourcing='no';
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$maualGluingOutsourcing,$OcD[$var]["value"]);
// END saving manual gluing data to db

// BEGIN saving automatic gluing data to db
  // tutaj dodałem zapisywanie ilosci punktów klejenia automatycznego 2018-05-22
  $var = "glue_automat_type_id"; $txt_td = $txt_td_208;
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

  $var = "cost_glue_automat_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_automat"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_automat_box"; $txt_td = $txt_td_208." PLN (sztuka)";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_automat_total"; $txt_td = $txt_td_208." PLN (total)";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_glue_automat_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  // automatic gluing costs
  $var = "automaticGluingSetupCostsReal"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "automaticGluingSetupCosts"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "automaticGluingSetupCostsInfo"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "automaticGluingIdleCostsReal"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "automaticGluingIdleCosts"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "automaticGluingIdleCostsInfo"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "automaticGluingRunCostsReal"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "automaticGluingRunCosts"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "automaticGluingRunCostsInfo"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  // automatic gluing modifiers
    $var = "automaticGluingDifficulties_ShortBox"; $txt_td = "";
    $AGD_shortBox_value = isset ($_POST[$var]) ? $_POST[$var] : $AGD_shortBox_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$AGD_shortBox_value,$OcD[$var]["value"]);

    $var = "automaticGluingDifficulties_WideBox"; $txt_td = "";
    $AGD_wideBox_value = isset ($_POST[$var]) ? $_POST[$var] : $AGD_wideBox_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$AGD_wideBox_value,$OcD[$var]["value"]);

    $var = "automaticGluingDifficulties_LongBox"; $txt_td = "";
    $AGD_longBox_value = isset ($_POST[$var]) ? $_POST[$var] : $AGD_longBox_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$AGD_longBox_value,$OcD[$var]["value"]);

    $var = "automaticGluingDifficulties_GluingTape"; $txt_td = "";
    $AGD_gluingTape_value = isset ($_POST[$var]) ? $_POST[$var] : $AGD_gluingTape_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$AGD_gluingTape_value,$OcD[$var]["value"]);

    $var = "automaticGluingDifficulties_Window"; $txt_td = "";
    $AGD_windowPasting_value = isset ($_POST[$var]) ? $_POST[$var] : $AGD_windowPasting_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$AGD_windowPasting_value,$OcD[$var]["value"]);

    $var = "automaticGluingDifficulties_Handle"; $txt_td = "";
    $AGD_handlePasting_value = isset ($_POST[$var]) ? $_POST[$var] : $AGD_handlePasting_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$AGD_handlePasting_value,$OcD[$var]["value"]);

    $var = "automaticGluingDifficulties_FoiledFlap"; $txt_td = "";
    $AGD_foiledFlap_value = isset ($_POST[$var]) ? $_POST[$var] : $AGD_foiledFlap_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$AGD_foiledFlap_value,$OcD[$var]["value"]);

    $var = "automaticGluingDifficulties_eurSlot"; $txt_td = "";
    $AGD_eurSlot_value = isset ($_POST[$var]) ? $_POST[$var] : $AGD_eurSlot_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$AGD_eurSlot_value,$OcD[$var]["value"]);

    $var = "automaticGluingDifficulties_multiAssortment"; $txt_td = "";
    $AGD_multiAssortment_value = isset ($_POST[$var]) ? $_POST[$var] : $AGD_multiAssortment_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$AGD_multiAssortment_value,$OcD[$var]["value"]);

    $var = "automaticGluingDifficulties_multiAssortmentNumber"; $txt_td = "";
    $AGD_multiAssortmentNumber_value = isset ($_POST[$var]) ? $_POST[$var] : $AGD_multiAssortment_value='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$AGD_multiAssortmentNumber_value,$OcD[$var]["value"]);

    $var = "automaticGluingDifficulties_Prefolding"; $txt_td = "";
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  // automatic gluing times
    $var = "automaticGluingSetupTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
    $var = "automaticGluingRunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
    $var = "automaticGluingIdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
    $var = "automaticGluingTotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  // automatic gluing outsourcing
    $var = "automaticGluingOutsourcing"; $txt_td = "";
    $automaticGluingOutsourcing = isset ($_POST[$var]) ? $_POST[$var] : $automaticGluingOutsourcing='no';
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$automaticGluingOutsourcing,$OcD[$var]["value"]);
// END saving automatic gluing data to db

// koniec zapisu ilosci punktów klejenia automatycznego 2018-05-22
$var = "transport_type_id"; $txt_td = $txt_td_073;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "transport_km"; $txt_td = $txt_td_073 ." ". $txt_td_095;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "transport_palet"; $txt_td = $txt_td_073 ." ". $txt_td_147;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "transport_palet_weight"; $txt_td = $txt_td_073 ." ". $txt_td_148;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "other1_dsc"; $txt_td = $txt_td_074;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_other1_total"; $txt_td = $txt_td_074 ." ". $txt_td_062;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_other1_box"; $txt_td = $txt_td_074 ." ". $txt_td_094;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "other2_dsc"; $txt_td = $txt_td_075;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_other2_total"; $txt_td = $txt_td_075 ." ". $txt_td_062;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_other2_box"; $txt_td = $txt_td_075 ." ". $txt_td_094;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra_dsc"; $txt_td = $txt_td_076;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra_total"; $txt_td = $txt_td_076 ." ". $txt_td_062;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_manual_work"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_manual_work_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_manual_work_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_manual_work_jazda_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_manual_work_jazda_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_manual_work_idle_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_manual_work_idle_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
//$var = "outsourcing_type_id"; $txt_td = $txt_td_077;
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);



//BEGIN saving outsourcing types

    $Osql = "SELECT table_id, name, status
             FROM order_calculation_outsourcing_types
             WHERE status > '0'
             ORDER BY table_id ASC"; //echo "$sql<BR>";
    $Oresult = @mysql_query($Osql, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_show.php -> show -> READ order_calculation_list]<BR>$Osql<BR>".mysql_error());
       while ($Orow = mysql_fetch_array($Oresult)) {
          $o_name        = $Orow['name'];
          $o_table_id    = $Orow['table_id'];

          $o_name_ = "outsorcing_type_".$o_table_id;
          $o_name_v = $$o_name_;
          $var = $o_name_;
          $txt_td = $txt_td_077 ."($o_name)";
          SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
}
// END saving outsourcing types

$var = "margin"; $txt_td = $txt_td_136." %";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "margin_pln"; $txt_td = $txt_td_136." PLN";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);


$var = "cost_paper1_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_paper2_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers_material_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers_material"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers_material_clicha_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers_material_clicha"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_material_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_material"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_material_clicha_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_material_clicha"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_material_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_material"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish2_material"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_material_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_material"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "cost_awers2_material_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers2_material"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers2_material_clicha_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers2_material_clicha"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_material_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_material"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_material_clicha_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_material_clicha"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

//$var = "cost_ink_varnish_special_material_info"; $txt_td = "";
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
//$var = "cost_ink_varnish_special_material"; $txt_td = "";
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_ink_varnish_special_out_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_ink_varnish_special_out"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_ink_varnish_special_out_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_ink_varnish_special_out"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_material_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_material"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_material_foil_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_material_foil"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_cut_material_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_cut_material"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "cost_awers_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers_narzad_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers_narzad_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers_jazda_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers_jazda_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers_idle_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers_idle_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_narzad_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_jazda_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_narzad_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_idle_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_idle_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers_jazda_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "cost_awers2_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers2_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers2_narzad_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers2_narzad_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers2_jazda_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers2_jazda_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers2_idle_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_awers2_idle_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_narzad_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_jazda_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_narzad_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_idle_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_idle_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_rewers2_jazda_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish2_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
//$var = "cost_varnish_narzad_info"; $txt_td = "";
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
//$var = "cost_varnish_narzad_real"; $txt_td = "";
//SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_jazda_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_jazda_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish2_jazda_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish2_jazda_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish2_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_jazda_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_jazda_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_idle_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_idle_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_narzad_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_narzad_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_ink_varnish_special_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_ink_varnish_special"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_ink_varnish_special_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_ink_varnish_special_jazda_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_ink_varnish_special_jazda_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_jazda_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_jazda_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_idle_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_idle_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_narzad_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_gilding_narzad_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_manual_cost"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_manual_cost_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_manual_cost_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
// START saving cutter 1 data
    $var = "cost_cut_info"; $txt_td = "";
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
    $var = "cost_cut"; $txt_td = "";
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
    $var = "cost_cut_info"; $txt_td = "";
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
    $var = "cost_cut"; $txt_td = "";
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
    $var = "cost_cut_real"; $txt_td = "";
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
    $var = "cost_cut_jazda_real"; $txt_td = "";
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
    $var = "cost_cut_idle_real"; $txt_td = "";
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
    $var = "cost_cut_jazda_info"; $txt_td = "";
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
    $var = "cost_cut_idle_info"; $txt_td = "";
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
    $var = "cutterRunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
    $var = "cutterIdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
    $var = "cutterTotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
    SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
// END saving cutter 1 data
// START saving cutter 2 data
  $var = "cost_cut2_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_cut2"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_cut2_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_cut2_jazda_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_cut2_idle_real"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_cut2_jazda_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cost_cut2_idle_info"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "cutter2RunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "cutter2IdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "cutter2TotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);

// END saving cutter 2 data

$var = "cost_clicha_extra"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_clicha_extra_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_glue_automat_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_glue_automat"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_falc_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_falc"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_falc_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_falc"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "laminating_type_id"; $txt_td = $txt_td_211;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "laminating_sqm_id"; $txt_td = $txt_td_210;
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_material_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_material"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_jazda_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_jazda_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_narzad_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_narzad_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_idle_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_idle_real"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_stample_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_stample"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_stample_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_stample"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_bigowanie_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_bigowanie"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_bigowanie_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_bigowanie"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_foil_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_foil"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_foil_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_trans_foil"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_other1_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_other1"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_other2_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_other2"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra_matryce"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra_matryce_extra"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra_matryce_KD"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_extra_matryce_KPoz"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "gilding_box_matryce"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_total_dodatek"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_total_dodatek_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_total_pozostale"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_total_pozostale_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_accept_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_accept"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_total_total_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_total_total"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_administracja_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_administracja"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_podatek_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_podatek"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_sum_narzut_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_sum_narzut"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_margin_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_bep_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_sales_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_prowizja7_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_prowizja15_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_2_5_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_margin_1_3_info"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "cost_cut_total_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_cut2_total_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers2_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers2_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "rewers_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "awers_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_jazda_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish2_jazda_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_setup_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_varnish_uv_jazda_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc1_setup_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc1_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc2_setup_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc2_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc3_setup_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc3_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc4_setup_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_matryc4_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_laminating_setup_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_manual_work_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_window_glue_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_dcting_setup_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "window_glue_timeS_box"; $txt_td = "czas wklejania okienka [sekunda]";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_dcting_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_dcting2_setup_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_dcting2_prod_time"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

$var = "printingAwersSetupTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingAwersRunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingAwersIdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingAwersTotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);

$var = "printingRewersSetupTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingRewersRunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingRewersIdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingRewersTotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);

$var = "printingAwers2SetupTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingAwers2RunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingAwers2IdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingAwers2TotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);

$var = "printingRewers2SetupTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingRewers2RunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingRewers2IdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "printingRewers2TotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);

$var = "varnishUVSetupTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "varnishUVRunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "varnishUVIdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "varnishUVTotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);

$var = "hotStampingSetupTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "hotStampingRunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "hotStampingIdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "hotStampingTotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);

$var = "lithoLaminationSetupTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "lithoLaminationRunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "lithoLaminationIdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
$var = "lithoLaminationTotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);


// begin saving separation data
  $var = "separationProcessTypeID"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "separationToolingTypeID"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "separationToolingStatusID"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "separationToolingInvoicingID"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "separationToolingCost"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);

  $var = "separationWindowStripping"; $txt_td = "reczne wypychanie oienek w trakcie separacji";
  $separationWindowStripping_value = isset ($_POST[$var]) ? $_POST[$var] : $separationWindowStripping_value='no';
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$separationWindowStripping_value,$OcD[$var]["value"]);

  $var = "separationSetupInfo"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "separationSetupRealCosts"; $txt_td = "";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "separationSetupTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "separationRunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "separationIdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "separationTotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
// end saving separation data
$var = "manualGluingTotalTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
// begin saving total times
  $var = "totalSetupTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "totalRunTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "totalIdleTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "totalOperationTime"; $txt_td = ""; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
// begin saving time correction data
  $var = "operationTimeCorrection"; $txt_td = "suma korekcji czasow"; $value = phpHHMMToValue($_POST[$var]);
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$value,$OcD[$var]["value"]);
  $var = "operationTimeCorrectionInfo"; $txt_td = "info o korekcji czasow";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
  $var = "operationTimeCorrectionDsc"; $txt_td = "opis korekcji czasow";
  SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "version_dsc"; $txt_td = "Opis wersji";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);
$var = "cost_sales_one_write"; $txt_td = "";
SaveDataOrderCalculationDatas($connection,$user_id,"10",$oc_id,$OcD[$var]["id"],$txt_td,$txt_text_0007,$txt_text_0006,$txt_text_0020,$var,$_POST[$var],$OcD[$var]["value"]);


$txt_text_0009      = $OCLangDict['txt_text_0009'][$lang_id];
///zapis pliku ->


//tworze folder dla klakulacji
IF ($sciezkaArchiwum) {
  $customer_id = $_POST['customer_id'];
  FindOrderCalculationValue($connection,"short_name","customer_id='$customer_id'","customers",$customer_short);
  // create a string with the folder path customerName/ orderNumber
    $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr;
  // create folder in the server files archive if it doesn't already exist
    if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }
  // create a string with the folder path customerName/ orderNumber / grafika
    $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/grafika";
  // create folder in the server files archive if it doesn't already exist    
    if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }
  // create a string with the folder path customerName/ orderNumber / inne
    $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/inne";
  // create folder in the server files archive if it doesn't already exist
    if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }
  // create a string with the folder path customerName/ konstrukcja
    $accept_file_load = $sciezkaArchiwum."/".$customer_short."/konstrukcja";
  // create folder in the server files archive if it doesn't already exist
    if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }
}

// BEGIN looping through files attached to calculation to save them on server folder
// loop through the $FILES array (max of nine files and loops allowed to save files)
FOR ($a = 1; $a<=9; $a++) {

  IF (isset($_FILES['file_'.$a]['name'])) {
    // get the file name and file size from FILES array
      $SafeFile = $_FILES['file_'.$a]['name']; //echo "$SafeFile name<BR>";//Nazwa
      $FileSize = $_FILES['file_'.$a]['size']; //echo "$FileSize rozmiar<BR>";//Rozmiar

      // define a temp boolean variable to either procees and save file (1) or not (0)
      $move     = "0";
      // check if the file size and file name exists
        IF (($SafeFile) && ($FileSize > 0)) { //echo "Zapis $SafeFile<BR>";
      // Replace a given set of special signs in file name with predetermined set of words
        $SafeFile = str_replace("#", "No.", $SafeFile);
        $SafeFile = str_replace("$", "Dollar", $SafeFile);
        $SafeFile = str_replace("%", "Percent", $SafeFile);
        $SafeFile = str_replace("^", "", $SafeFile);
        $SafeFile = str_replace("&", "and", $SafeFile);
        $SafeFile = str_replace("*", "", $SafeFile);
        $SafeFile = str_replace("?", "", $SafeFile);
      // check if the max size of file matches the max file size defined
        IF ($_FILES['file_'.$a]["size"] < $max_filesize) {
           $move = "1";
        } ELSE {
           header( "Location: $serwer/system/order_calculation_show.php?action=show&oc_id=$oc_id&back=$back&error=file_size" ); exit;
        }
      // call function to replace polish signs with utf ones
        $SafeFile = CleanPLfile($SafeFile);
      // set the path to save file
        $accept_file_load = "";
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
                $customer_id = $_POST['customer_id'];
                FindOrderCalculationValue($connection,"short_name","customer_id='$customer_id'","customers",$customer_short);
                $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr;
                if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0755); }
                $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/grafika";
                if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0755); }
                $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/inne";
                if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0755); }
                ///zapis
                switch ($a) {
                  case "1": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/inne"; break;
                  case "2": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/inne"; break;
                  case "3": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/inne"; break;
                  case "4": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/konstrukcja"; break;
                  case "5": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/konstrukcja"; break;
                  case "6": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/konstrukcja"; break;
                  case "7": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/grafika"; break;
                  case "8": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/grafika"; break;
                  case "9": $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/grafika"; break;
                }
                // move the uploaded file to the server
                  move_uploaded_file($_FILES['file_'.$a]["tmp_name"],$accept_file_load."/".$SafeFile);
                // change permissions on uploaded file
                  chmod($accept_file_load."/".$SafeFile,0755);
                // save data on files assoociated with calculation to calculation table and log table
                  SaveOrderCalculationFile($connection,"10",$user_id,$oc_id,"",$dzisiajteraz,$SafeFile,$accept_file_load,$file_id);
                  SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"$txt_text_0009 $SafeFile");
            } else {
                move_uploaded_file($_FILES['file_'.$a]["tmp_name"],$sciezka_.$SafeFile);
                // TODO: what does this do?
                  rename($sciezka_.$_FILES['file_'.$a]["name"],$sciezka_.$file_id.$rozszerzenie);
                // change permissions on uploaded file
                  chmod($sciezka_.$file_id.$rozszerzenie,0755);
            }
            // TODO: file upload should still be logged here
        }
      }
   }
}
// END looping through files attached to calculation to save them on server folder

$var = "order_qty_change"; $oqc = "";
IF (isset($_POST[$var])) { $oqc = $_POST[$var]; }
IF ($oqc)
  {
    if (headers_sent()) {
        die("Redirect failed. Please click on this link: xxx <a href=...>");
      }
    else{
        exit(header("Location: $serwer_type$serwer/system/order_calculation_show_order.php?action=show&oc_id=$oc_id&back=$back&error=create_order"));
    }

    //header("Location: $serwer_type$serwer/system/order_calculation_show_order.php?action=show&oc_id=$oc_id&back=$back&error=create_order");
    //exit;
}
    if (headers_sent()) {
        die("Redirect failed. Please click on this link:<a href='$serwer_type$serwer/system/order_calculation_show.php?action=show&oc_id=$oc_id&back=$back&error=do_edit'>yyy</a>");
      }
    else{
        exit(header("Location: $serwer_type$serwer/system/order_calculation_show.php?action=show&oc_id=$oc_id&back=$back&error=do_edit"));
    }


    //header("Location: $serwer_type$serwer/system/order_calculation_show.php?action=show&oc_id=$oc_id&back=$back&error=do_edit");
    //exit;

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
IF ($action == "copy") { ///
//kontrola dostępu
//AccessDeniedCheck($connection,$user_id,$userlevel_id,$serwer,"12_3_1","order_calculation_show.php -> delate");

$menu_caption = "/ <A href=\"./index.php\" style=\"color: #FFFFFF\" title=\"$txt_title_003\">Menu główne</A>
                 / <A href=\"./order_calculation_menu.php?action=menu\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_0_0</A>
                 / <A href=\"./order_calculation_list.php?action=list\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_1_0</A> / $txt_menu_12_5_0";
$window_caption = "$txt_menu_0_0_0 :: $txt_menu_12_1_0";
$powrot = "./order_calculation_create.php?action=create&back=$back";

//przygotuj MENU (w zależności od operatorów)
$menu_left = MenuLeftShow($connection,$user_id,$lang_id,$userlevel,"12_5_0");

$fraza_error = ""; $fraza_table = ""; $table = ""; $lp="";
$fraza=""; IF (isset($_POST['fraza'])) {
    $fraza = $_POST['fraza'];
    $fraza_length = strlen($fraza);
    IF ($fraza_length < 3) {
        $fraza_error = "<DIV class=error><B>Błąd!</B> Wpisana fraza jest zbyt krótka. Musisz wpisać minimum 3 znaki.</DIV><BR>";
    } else {///jestfraza,,, szukam
        $szukane = "<SPAN style=\"font-weight: bold; font-size: 11; color: red\">" . $fraza . "</SPAN>";

        $sql = "SELECT order_calculations.oc_id, order_calculations.status, order_calculations.create_user, order_calculations.create_date, order_calculations.name, order_calculations.dsc, order_calculations.version, order_calculations.order_nr
                FROM order_calculations
                JOIN order_calculation_datas
                ON order_calculations.oc_id=order_calculation_datas.oc_id
                WHERE order_calculations.status>'0'
                      AND (order_calculations.name like '%$fraza%' OR order_calculations.order_nr like '%$fraza%' OR order_calculations.dsc like '%$fraza%'
                           OR (order_calculation_datas.var='customer' AND order_calculation_datas.value like '%$fraza%')
                           OR (order_calculation_datas.var='customer_name' AND order_calculation_datas.value like '%$fraza%')
                           OR (order_calculation_datas.var='extra_dsc' AND order_calculation_datas.value like '%$fraza%')
                           OR (order_calculation_datas.var='orginal_order_dsc' AND order_calculation_datas.value like '%$fraza%')
                          )
                GROUP BY order_calculations.oc_id ASC
                ORDER BY order_calculations.oc_id DESC "; //echo "$sql<BR>";
        $result = @mysql_query($sql, $connection) or die("Wykonanie zapytania nie powiodło się! [audit_plan_list.php -> list -> READ audit_plan_list]<BR>$sql<BR>".mysql_error());
          while ($row = mysql_fetch_array($result)) {
            $oc_id              = $row['oc_id'];
            $create_date        = $row['create_date'];
            $create_user        = $row['create_user'];
            $status             = $row['status'];
            $name               = $row['name'];
            $order_nr           = $row['order_nr'];
            $dsc                = $row['dsc'];
            $version            = $row['version'];
            $lp++;

            $status_show_ = ReadOrderCalculationStatuses($connection,$status,"order_calculations",$lang_id);
            ReadUser($connection,$create_user,$firstname_c,$lastname_c,$t,$t,$t,$t);

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
            //IF ($customer) { $customer_name = ""; }
            $name               = str_ireplace($fraza,$szukane,$name);
            $order_nr           = str_ireplace($fraza,$szukane,$order_nr);
            $extra_dsc          = str_ireplace($fraza,$szukane,$extra_dsc);
            $orginal_order_dsc  = str_ireplace($fraza,$szukane,$orginal_order_dsc);
            $customer_name      = str_ireplace($fraza,$szukane,$customer_name);
            $customer           = str_ireplace($fraza,$szukane,$customer);

            $table  .= "<TR class=tekst11gr>
                             <TD class=td0011 $sc  rowspan=4>$oc_id<BR><BR><INPUT NAME=oc_copy TYPE=radio CLASS=a checked VALUE=\"$oc_id\"</TD>
                             <TD class=td0011 $sc  rowspan=4>$create_date<BR>$firstname_c $lastname_c</TD>
                             <TD class=td0011 $sl5 colspan=2>$name</TD>
                             <TD class=td0011 $sl5 rowspan=2>$customer</TD>
                             <TD class=td0111 $sl5 rowspan=4>$status_show_&nbsp;</TD>
                        </TR>
                        <TR class=tekst11gr>
                             <TD class=td0011 $sl5 >$order_nr</TD>
                             <TD class=td0010 $sl5 >$version</TD>
                        </TR>
                        <TR class=tekst11gr>
                             <TD class=td0011 $sl5 colspan=3>$extra_dsc&nbsp;</TD>
                        </TR>
                        <TR class=tekst11gr>
                             <TD class=td0011 $sl5 colspan=3>$orginal_order_dsc&nbsp;</TD>
                        </TR>";

              //zeruj zmienne

        }

        $fraza_table = "<TABLE class=tekst11 width=710 style=\"border: 1px #CFCFCE solid;\" cellspacing=1 cellpadding=1>
            <TR class=\"naglowek\">
              <TD width=30 class=\"naglowek\">#</TD>
              <TD width=100 class=\"naglowek\">$txt_td_027</TD>
              <TD width=150 class=\"naglowek\" colspan=2>$txt_td_019</TD>
              <TD width=330 class=\"naglowek\">$txt_td_035</TD>
              <TD width=100 class=\"naglowek\">$txt_td_004</TD>
            </TR>
              $table
          </TABLE>
          <P class=tekst12gr>
          <INPUT TYPE=submit NAME=submit class=button VALUE=\"&nbsp;&nbsp;Kopiuj dane&nbsp;&nbsp;\" style=\"width: 150px;\" id=input_save_input>
          <INPUT TYPE=hidden NAME=action2             VALUE=do_copy>
          <INPUT TYPE=hidden NAME=back                VALUE=$back>
";
    }
}

$txt_text_0074         = $OCLangDict['txt_text_0074'][$lang_id];

//zawartość strony
$display = "
<DIV class=tytul17red_line>$txt_menu_12_5dsc - kopiowanie danych</DIV>
<DIV class=error>$txt_text_0074</DIV>
<BR>
<FORM method=post action=\"order_calculation_create.php\">
$fraza_error
<DIV class=warning>Szukana fraza:
    <INPUT CLASS=a NAME=fraza if=fraza VALUE=\"$fraza\" TYPE=text MAXLENGTH=20 STYLE=\"width: 100px; text-align: left; padding-left: 5px; \" > [>3]
    &nbsp;&nbsp;&nbsp;
    <INPUT TYPE=submit NAME=submit class=button VALUE=\"&nbsp;&nbsp;Szukaj&nbsp;&nbsp;\" style=\"width: 150px;\" id=input_save_input>
    <INPUT TYPE=hidden NAME=action2             VALUE=copy>
    <INPUT TYPE=hidden NAME=back                VALUE=$back>
</DIV>
</FORM>

<FORM method=post action=\"order_calculation_create.php\">
$fraza_table
</FORM>
<P class=tekst12gr><A href=\"$powrot\">Cofnij</A>&nbsp;&nbsp;&nbsp;

";

//wywołaj stronę
INCLUDE('./page_content.php');

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
IF ($action == "do_copy") { ///
//kontrola dostępu
//AccessDeniedCheck($connection,$user_id,$userlevel_id,$serwer,"12_3_1","order_calculation_show.php -> delate");

$menu_caption = "/ <A href=\"./index.php\" style=\"color: #FFFFFF\" title=\"$txt_title_003\">Menu główne</A>
                 / <A href=\"./order_calculation_menu.php?action=menu\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_0_0</A>
                 / <A href=\"./order_calculation_list.php?action=list\" style=\"color: #FFFFFF\" title=\"$txt_title_002\">$txt_menu_12_1_0</A> / $txt_menu_12_5_0";
$window_caption = "$txt_menu_0_0_0 :: $txt_menu_12_1_0";
$powrot = "./order_calculation_menu.php?action=menu&back=$back";

//przygotuj MENU (w zależności od operatorów)
$menu_left = MenuLeftShow($connection,$user_id,$lang_id,$userlevel,"12_5_0");

$oc_copy=""; IF (isset($_POST['oc_copy'])) { $oc_copy = $_POST['oc_copy']; }
IF (isset($_GET['oc_copy'])) { $oc_copy = $_GET['oc_copy']; }

$input_copy = "";
IF ($oc_copy) {
    $sql = "SELECT name, order_nr
            FROM order_calculations
            WHERE order_calculations.oc_id='$oc_copy' "; //echo "$sql<BR>";
    $result = @mysql_query($sql, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> create -> READ order_calculation<BR>$sql<BR>".mysql_error());
        while ($row = mysql_fetch_array($result)) {
            $name               = $row['name'];
            $order_nr           = $row['order_nr'];
    }
    $sql = "SELECT value
            FROM order_calculation_datas
            WHERE oc_id='$oc_copy' AND var='customer' ";
    $result = @mysql_query($sql, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> create -> READ audit_plan_list]s<BR>$sql<BR>".mysql_error());
        while ($row = mysql_fetch_array($result)) {
            $customer_name  = $row['value'];
    }
    $input_copy = "<A href=\"./order_calculation_create.php?action=save_do_copy&oc_copy=$oc_copy\" style=\"text-decoration: none;\">Kopiuj dane</A>&nbsp;&nbsp;&nbsp;";
}

//zawartość strony
$display = "
<DIV class=tytul17red_line>$txt_menu_12_5dsc - kopiowanie danych</DIV>
<DIV class=error><B>Uwaga!</B><BR>
  Wybrano opcję kopiowania danych z kalkulacji:
  <BR><LI>Nazwa: <B>$name</B>
  <BR><LI>Numer: <B>$order_nr</B>
  <BR><LI>Klient: <B>$customer_name</B><BR>
  <BR>Skopiowanie danych spowoduje utworzenie nowej kalkulacji!<BR>
  Proszę potwierdź kopiowanie danych</DIV>

<P class=tekst12gr><A href=\"$powrot\">Wyjdź</A>&nbsp;&nbsp;&nbsp;
  $input_copy


";

//wywołaj stronę
INCLUDE('./page_content.php');

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
IF ($action == "save_do_copy") {

    $oc_copy="";
    IF (isset($_POST['oc_copy'])) {
      $oc_copy = $_POST['oc_copy'];
    }
    IF (isset($_GET['oc_copy'])) {
      $oc_copy = $_GET['oc_copy'];
    }

    $sql = "SELECT dsc, name, order_nr, create_date
            FROM order_calculations
            WHERE oc_id='$oc_copy' "; //echo "$sql<BR>";
    $result = @mysql_query($sql, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> $action -> READ order_calculation_list]<BR>$sql");
          while ($row = mysql_fetch_array($result)) {
            $dsc                = $row['dsc'];
            $name_copy          = $row['name'];
            $order_nr_copy      = $row['order_nr'];
            $create_date        = $row['create_date'];
    }

    FindOrderCalculationValue($connection,"order_nr","status>='0' AND year='$year' AND order_nr like '%-%' ORDER BY order_nr DESC LIMIT 1","order_calculations",$order_nr_last);
    $order_nr_last = explode("-",$order_nr_last);
    $order_nr_last = $order_nr_last[1];
    $order_nr_last++;
    $order_nr_last = str_pad($order_nr_last, 4, "0", STR_PAD_LEFT);
    $order_nr = date("my")."-".$order_nr_last;

    $sql2 = "INSERT INTO order_calculations (
                customer_id,
                user_id,
                status,
                create_date,
                create_user,
                year,
                order_nr,
                customerOrder,
                name,
                dsc,
                version,
                oc_id_main,
                engineVersion,
                engineDate)
             VALUES (
               \"$customer_id\",
               \"$user_id\",
               \"10\",
               \"$dzisiaj\",
               \"$user_id\",
               \"$year\",
               \"$order_nr\",
               \"$customerOrder\",
               \"$name_copy\",
               \"$dsc\",
               \"$version\",
               \"\",
               \"$calculationEngineVersion\",
               \"$calculationEngineDate\") ";// echo "$sql2<BR>";
   //echo "$sql2<BR>";
    $result2 = @mysql_query($sql2, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> $action -> INSERt OC version]");
    $oc_id           = mysql_insert_id();
    SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_copy,"Skopiowano dane do nowej kalkulacji #$oc_id -$order_nr-");
    SaveOrderCalculationLogs($connection,$user_id,"10","order_calculations",$oc_id,"Utworzenie kalkulacji - kopia kalkulacji #$oc_copy -$name_copy- -$order_nr_copy- / nowa #$oc_id -$name- -$order_nr- ");


    $sql3 = "SELECT var,value
             FROM order_calculation_datas
             WHERE oc_id='$oc_copy' AND status>'0' AND status<'40' "; //echo "$sql3<BR>";
    $result3 = @mysql_query($sql3, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> $action -> READ order_calculation_datas]<BR>$sql");
      while ($row3 = mysql_fetch_array($result3)) {
         $var         = $row3['var'];
         $value       = $row3['value'];
         // convert operation times read from db from decimals into hh:mm on the fly
         $$var        = convertTimeValueToHHMM($var,$value); // populate variable table with variables named like var and holding values from value field
         switch ($var) { //// kasuje czego mam nie kopiować.
            case "grafic_full_load_to_file": $var = ""; break;
         }
         IF ($var) {
             $sql4 = "INSERT INTO order_calculation_datas (user_id, status, oc_id, var, value)
                      VALUES (\"$user_id\", \"10\", \"$oc_id\", \"$var\", \"$value\") "; //echo "$sql4<BR>";
             $result4 = @mysql_query($sql4, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> $action -> INSERt OC DATA version ]");
         }
    }
    IF ($sciezkaArchiwum) {
        FindOrderCalculationValue($connection,"short_name","customer_id='$customer_id'","customers",$customer_short);
        $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr;
        if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }
        $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/grafika";
        if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }
        $accept_file_load = $sciezkaArchiwum."/".$customer_short."/".$order_nr."/inne";
        if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }
        $accept_file_load = $sciezkaArchiwum."/".$customer_short."/konstrukcja";
        if (!file_exists($accept_file_load)) { mkdir($accept_file_load, 0777); }
    }

    /// get previous data (O_index, marszruta_id, order_id) table if exists and write it into current calculation data
    $sql =
      "SELECT
        o.oc_id,
        o.order_id,
        o.o_index,
        oi.marszruta_id,
        odDieCut.value AS 'dieCutID',
        odLearnings.value AS 'orderLearnings',
        odImprovements.value AS 'orderImprovements',
        dicuts.plateToolType_id,
        dicuts.strippingToolType_id,
        dicuts.blankingToolType_id
      FROM
          orders o
  	  LEFT JOIN o_index oi ON oi.o_index = o.o_index
  	  LEFT JOIN order_data odDieCut on odDieCut.order_id = o.order_id AND odDieCut.var = 'dicut_id'
      LEFT JOIN order_data odLearnings on odLearnings.order_id = o.order_id AND odLearnings.var = 'orderLearnings'
      LEFT JOIN order_data odImprovements on odImprovements.order_id = o.order_id AND odImprovements.var = 'orderImprovements'
      LEFT JOIN dicuts on dicuts.dicut_id = odDieCut.value
      WHERE
          o.status <> 0
          AND
          o.oc_id = '$oc_copy'
      ORDER BY o.order_id DESC
      LIMIT 1";

    $result = @mysql_query($sql, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> $action -> READ order_calculation_list]<BR>$sql");
       while ($row = mysql_fetch_array($result)) {
           $order_id          = $row['order_id'];
           $last_marszruta_id = $row['marszruta_id'];
           $last_o_index      = $row['o_index'];
           $last_dieCutID     = $row['dieCutID'];
           $last_orderLearnings     = $row['orderLearnings'];
           $last_orderImprovements     = $row['orderImprovements'];
      }
           if ($last_marszruta_id) { // write down last marszruta id if present
               $sql4 = "INSERT INTO order_calculation_datas (user_id, status, oc_id, var, value)
                        VALUES (\"$user_id\", \"10\", \"$oc_id\", \"last_marszruta_id\", \"$last_marszruta_id\") "; //echo "$sql4<BR>";
               $result4 = @mysql_query($sql4, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> $action -> INSERt OC DATA last_marszruta_id]");
            }
           if ($last_o_index) {// write down last o_index if present
               $sql4 = "INSERT INTO order_calculation_datas (user_id, status, oc_id, var, value)
                        VALUES (\"$user_id\", \"10\", \"$oc_id\", \"last_o_index\", \"$last_o_index\") "; //echo "$sql4<BR>";
               $result4 = @mysql_query($sql4, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> $action -> INSERt OC DATA last_O_index]");
           }
           if ($order_id) {// write down last order_id if present
               $sql4 = "INSERT INTO order_calculation_datas (user_id, status, oc_id, var, value)
                        VALUES (\"$user_id\", \"10\", \"$oc_id\", \"last_order_id\", \"$order_id\") "; //echo "$sql4<BR>";
               $result4 = @mysql_query($sql4, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> $action -> INSERt OC DATA last_Order_id]");
           }
           if ($last_dieCutID) {// write down last dieCutID if present
               $sql4 = "INSERT INTO order_calculation_datas (user_id, status, oc_id, var, value)
                        VALUES (\"$user_id\", \"10\", \"$oc_id\", \"last_dieCutID\", \"$last_dieCutID\") "; //echo "$sql4<BR>";
               $result4 = @mysql_query($sql4, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> $action -> INSERt OC DATA last_Order_id]");
           }
           if ($last_orderLearnings) {// write down last dieCutID if present
               $sql4 = "INSERT INTO order_calculation_datas (user_id, status, oc_id, var, value)
                        VALUES (\"$user_id\", \"10\", \"$oc_id\", \"last_orderLearnings\", \"$last_orderLearnings\") "; //echo "$sql4<BR>";
               $result4 = @mysql_query($sql4, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> $action -> INSERt OC DATA last_Order_id]");
           }
           if ($last_orderImprovements) {// write down last dieCutID if present
               $sql4 = "INSERT INTO order_calculation_datas (user_id, status, oc_id, var, value)
                        VALUES (\"$user_id\", \"10\", \"$oc_id\", \"last_orderImprovements\", \"$last_orderImprovements\") "; //echo "$sql4<BR>";
               $result4 = @mysql_query($sql4, $connection) or die("Wykonanie zapytania nie powiodło się! [order_calculation_create.php -> $action -> INSERt OC DATA last_Order_id]");
           }


  if (headers_sent()) {
      die("Redirect failed. Please click on this link: <a href=...>");
    }
  else{
      exit(header("Location: $serwer_type$serwer/system/order_calculation_create.php?action=create&oc_id=$oc_id&back=$back&error=copy"));
  }
}
//header( "Location: $serwer_type$serwer/system/order_calculation_create.php?action=create&oc_id=$oc_id&back=$back&error=copy" ); exit;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<HTML>
  <HEAD>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
      <LINK rel="STYLESHEET" href="./panel.css" type="text/css">
      <link href="calendar.css" rel="stylesheet">
      <TITLE><?php echo $window_caption;?></TITLE>
      <!-- attach scripts here so that page can have access to them anytime and that elements can use js functions in them -->
        <script src="calendar.js"></script>
        <script src="jq/jquery-1.9.1.js"></script>
        <script src="js/functions_occ.js"></script>
        <script src="js/helperFunctions.js"></script>
        <script src="js/validateCalculation.js"></script>
        <script src="js/dieCuttingStripping.js"></script>
        <script src="js/upSeparation.js"></script>
        <script src="js/manualGluing.js"></script>
        <script src="js/automaticGluing.js"></script>
        <script src="js/helperFunctions.js"></script>
      <!-- attach scripts here so that they are called on page load and that calculations are performed by scripts on page load -->
        <script>
          "use strict";
          //# sourceURL=xxx.js //script name to display in developer tools
          $(document).ready(function(){ /* PREPARE THE SCRIPT - */
          /* functions will be triggered in the order they are appended below
            if a function call for another function from within a waterfall is triggered
            if a function enables certain functionality, that functionality will be available after per load through that function
          */
              order_type_select(); // call first js function from function_occ to trigger calculations
              //calculateDieCuttingStripping(); // attach die cutting and stripping calculations
              //calculateUpSeparation (); // attach up separation calculations
              //calculateManualGluing(); // attach new manual gluing calculation functionality
              //calculateAutomaticGluing(); // attach new automatic gluing calculation functionality



          });
        </script>
        
  </HEAD>
  <BODY>

    <?php echo $page_content; ?>

  </BODY>
</HTML>
