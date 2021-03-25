"use strict"; // to enable sctrict mode in js
/*Begin definition of global variables for functions to use */
var CUTcut_s; // Gilotyna speed
var CUTtime_idle; //Gilotyna Idle time
var CUTtime_jazda; // Gilotyna runtime

var CUT2_check; // Gilotyna 2
var CUT2cut_s; // Gilotyna 2 speed
 //Gilotyna2  Idle time
var CUT2time_jazda; // Gilotyna2  runtime
var CUT2time_idle; //Gilotyna 2 Idle time

var ITAa_c; //number of CMYK colors on awers
var ITAa_p;// number of pantone colors on awers
var ITA2a_c; //number of CMYK colors on awers II
var ITA2a_p;// number of pantone colors on awers II

var ITAsetup; // awers/ rewers print setup time
var ITA2setup; //  awers2/ rewers2 print setup time
var ITAark; // awers sheet number_format
var ITA2ark;  // awers2  sheet number_format
var ITAspeed; // awers sheet per hour
var ITA2speed; // awers2 sheet per hour
var ITAr_c; // number of CMYK colors on rewers_setup
var ITAr_p; // number of pantone colors on rewers_setup

var ITA2r_c; // number of CMYK colors on rewers_setup
var ITA2r_p; // number of pantone colors on rewers_setup

var CV1varnish_type_id; // offset varnish type id
var CV1nesting; // number of ups on sheet
var CV1order_qty;// number of sheets to varnish
var CV1cost_varnish_speed; // offset sheet per hour

// Hot stamping variables
var GCcost_setup;
var GCcost_prod;
var GCcost_i;

var VUV1varnish_type_id;
var VUV1cost_varnish_setup;
var VUV1order_qty;
var VUV1nesting;
var LAM_sqm_id;
var LAM_type_id;
var LAM_paper_id;
var LAM_paper2_id;
var LAMnarzad; // czas narzadu kaszerowanie
var LAM_jazda_costT; //czas jazdy kaszerowanie
var LAMorder_ark;
var LAM_speed;
var LAM_typ;
var LAM_sqm;
var LAM_paper;
var DCTtype_id;
var DCTtime_v_narzad;
var DCTcost_v_idle_n;
var DCTtime_v_jazda;
var DCTcost_v_idle_j;
var MWqty;
var MWot_id;
var MWnesting;
var OTMWdata_value_speed;
var OTMWdata_value_hard;
//var GTglue_type_id;
var manualGluingTypeID;
var GTcost_time;
var GT_idleP;
var GTqty;
var GTspeed; // manual gluing speed depending on type of gluing selected by the user
var GT_b1_sur2;
var GT_b1_foil;
var GT_b1_tape;
var GT_b1_window;
var GT_b1_slim;
var GLUqty; // gluing quantity
var GA2glue_type_id; // automatic gluing type id
var qtyToProduce;
var sheetQtyToProduce;
var totalWasteSheets; // waste in sheets calculated given that order has no additional setups
var totalWastePercent; // waste percenatege taken from db given that order has no additional setups
var orderNesting;
var extra_plate;                            // total number of extra plates required for additional setups on all printing machines
var additionalSheetsForEachExtraPlate;      // number of additional sheets required for each setup defined in db
var sheetsTotalForAdditionalSetup;          // number of extra sheets needed to use up for an additional setup
var sheetsEachSetup;                        // number of sheets per each additional setup in case of multisetup orders.
var sheetsPerHourEachSetup;                 // sheets per hour within each additional setup in case of multisetup orders.
var printingSetupTime_awers;
var printingRunTime_awers;
var printingIdleTime_awers;

var printingSetupTime_rewers;
var printingRunTime_rewers;
var printingIdleTime_rewers;

var printingSetupTime_awers2;
var printingRunTime_awers2;
var printingIdleTime_awers2;

var printingSetupTime_rewers2;
var printingRunTime_rewers2;
var printingIdleTime_rewers2;

var varnishUVSetupTime = 0;
var varnishUVRunTime =0;
var varnishUVIdleTime =0;

var lithoLaminationSetupTime=0;
var lithoLaminationRunTime=0;
var lithoLaminationIdleTime=0;

var dieCuttingSetupTime=0;
var dieCuttingRunTime=0;
var dieCuttingIdleTime=0;
var dieCuttingTotalTime=0;

var manualGluingInputType =""; // type of field the user has entered manual gluing information into

var separationSetupTime=0;
var separationRunTime=0;
var separationIdleTime =0;
var separationTotalTime=0;

var standardQtyColor;
var standardQtyColorTimeC;
var additionalSetups;
/*End of definition of global variables for functions to use */
var TimeOut = 250; // Default Timeout before each calculation = 50 ms

var colorGreen = '#65d218';
var colorRed = '#ff3e32';
var colorYellow = '#fffd05';

var windowPatchingType; // if window patching is to be done inside or outside depending on whether time or cost per unit has been entered.

// outsourcing type variables
  var  outsourcing_Priting = false; // printing outsourced
  var  outsourcing_All= false; // everything outsourced
  var  outsourcing_DieCutting= false; // diecutting outsourced
  var  outsourcing_RawMaterial_and_Priting= false; // raw material and printing outsourced
  var  outsourcing_All_but_RawMaterial= false; // everyting outsourced except raw material
  var  outsourcing_UV= false; // UV priting outsourced


  function order_type_select() {

    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var ot_id = document.occ.order_type_id.value;
    if (ot_id === "") {
      document.occ.order_type.value = parseFloat(0).toFixed(0);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  OTxmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  OTxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      OTxmlhttp.onreadystatechange = function() {
        if (OTxmlhttp.readyState === 4 && OTxmlhttp.status === 200) {
          var OTdata_value = OTxmlhttp.responseText;
          if (OTdata_value > "0") {
            document.occ.order_type.value = OTdata_value;
          } else {
            document.occ.order_type.value = '';
          }
        }
      };
      OTxmlhttp.open("GET", "order_calculation_create_order_type.php?var_id=" + ot_id, true);
      OTxmlhttp.send();
    }
    setTimeout(write_week_end_date, TimeOut);
    setTimeout(order_qty_write, TimeOut);
  }

  function write_week_end_date() { ///wypisuje jaki jest dzięń tygodnia - tylko jełsi wypełniona jest data wymagana klienta
    var d = document.occ.end_date.value; ///pobieram z jakiej daty wyznaczam dzień
    if (d) {
      var d_arr = d.split('-'); //rozbijam date do tablicy
      var y = d_arr[0] * 1;
      var m = d_arr[1] * 1;
      d = d_arr[2] * 1;
      var onejan = new Date(y, 0, 1);
      var nrDay = onejan.getDay(); //jaki to dzień tygodznia
      switch (nrDay) { ///co robie, jeśli początek roku to środek tygodznia
        case 1:
          nrDay = 0;
          break; //poniedziałek
        case 2:
          nrDay = 1;
          break; //wtorek
        case 3:
          nrDay = 2;
          break; //środa
        case 4:
          nrDay = 3;
          break; //czwartek
        case 5:
          nrDay = -3;
          break; //piatek
        case 6:
          nrDay = -2;
          break; //sobota
        case 0:
          nrDay = -1;
          break; ///niedzizela
      }
      var today = new Date(y, m - 1, d);
      var weekNumber1 = Math.ceil(((today - onejan) / 86400000) + 1); ///który zatem teraz jest dzień roku
      var weekNumber2 = weekNumber1 + nrDay; //czy coś dodaje - bo rok zaczał się w połowie tygodznia
      var weekNumber3 = Math.ceil(weekNumber2 / 7); //który to tydzień.
      if (isNaN(weekNumber3)) {
        weekNumber3 = '';
      }
      document.occ.end_week.value = weekNumber3;
    }
  }

  function order_qty_write(margins) {
    // display info on recalculation and freeze saving possibility
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;


    // define and populate Variables
    var orderQty = 0;
    var minimumQtyChecked = false;
    var maximumQtyChecked = false;
    var minimumQty=0;
    var maximumQty=0;
    var orderQtyRawMaterial =0;  // qty to base calculations and raw material ordering on
    //var percentageIncrease =0;  // percentage point to increase the minimal orderQty by to purchase enough RawMaterial
    var tolerancePercentage =0;

    orderQty = parseFloat(document.occ.order_qty1.value);
    minimumQtyChecked = document.occ.chckMinimumQty.checked;
    //minimumQty = document.occ.order_qty1_less.value; // get value from field if available
    minimumQty = parseFloat(document.occ.minimumQty.value); // get value from field if available
    maximumQty = parseFloat(document.occ.maximumQty.value); // get value from field if available
    maximumQtyChecked = document.occ.chckMaximumQty.checked;
    tolerancePercentage = parseFloat(document.occ.tolerant.value)/100;// make percentage from entered value
    //percentageIncrease = parseFloat(document.occ.order_qty1_less_procent.value)/100;// make percentage from entered value

    // calculate base raw material order qty
    //orderQtyRawMaterial = orderQty + (orderQty*percentageIncrease);

    if (isNaN(tolerancePercentage)) {tolerancePercentage = 0;} // zero out if value not etnered
    if (isNaN(minimumQty)) {minimumQty = 0;} // zero out if value not etnered
    if (isNaN(maximumQty)) {maximumQty = 0;} // zero out if value not etnered

    if (minimumQtyChecked === false) { // if not chekced then disable field for input
      document.getElementById("minimumQty").readonly = true;
      // change classes to make elements enabled or disabled
      document.getElementById("minimumQty").className = "input-disabled";
    } else { // if chekced then enable field for input
      document.getElementById("minimumQty").readonly = false;
      // change classes to make elements enabled or disabled
      document.getElementById("minimumQty").className = "input-highlighted";
    }

    if (maximumQtyChecked === false) { // if not chekced then zero out field value
      document.getElementById("maximumQty").readonly = true;
      // change classes to make elements enabled or disabled
      document.getElementById("maximumQty").className = "input-disabled";
    } else {
      document.getElementById("maximumQty").readonly = false;
      // change classes to make elements enabled or disabled
      document.getElementById("maximumQty").className = "input-highlighted";
    }

    if (tolerancePercentage>=0 && minimumQtyChecked === false && maximumQtyChecked === false) { // check if only tolerance is entered
      // if tolerance is entered then calculate min and max
        minimumQty = orderQty - orderQty * tolerancePercentage;
        maximumQty = orderQty + orderQty * tolerancePercentage;
      // and display on screen
        document.occ.minimumQty.value = parseFloat(minimumQty).toFixed(0);
        document.occ.maximumQty.value = parseFloat(maximumQty).toFixed(0);
      // recalculate the raw material order qty
        orderQtyRawMaterial = calculateRawMaterialOrderQty (orderQty,minimumQty, maximumQty);
      // input the raw material order qty
        document.occ.order_qty1_less.value = parseFloat(orderQtyRawMaterial).toFixed(0);
      // change classes to make elements enabled or disabled
        document.getElementById("tolerancePercentage").className = "input-highlighted";
        document.getElementById("minimumQty").className = "input-disabled";
        document.getElementById("maximumQty").className = "input-disabled";
    } else if (minimumQtyChecked && maximumQtyChecked === false){
        //check if any value is entered into minimum qty field
        if (minimumQty) {
          minimumQty = document.occ.minimumQty.value; // take the value entered by hand
        } else { // if no value was entered manually
          minimumQty = document.occ.order_qty1.value; // take the ordered qty as minimum qty if nothing entered by hand in minimumQty field
        }
        // proceed to calculate maximum qty as previously
          maximumQty = orderQty + orderQty * tolerancePercentage;
        // recalculate the raw material order qty
          orderQtyRawMaterial = calculateRawMaterialOrderQty (orderQty,minimumQty, maximumQty);
        // input the raw material order qty
          document.occ.order_qty1_less.value = parseFloat(orderQtyRawMaterial).toFixed(0);
        // and display on screen
          document.occ.minimumQty.value = parseFloat(minimumQty).toFixed(0);
          document.occ.maximumQty.value = parseFloat(maximumQty).toFixed(0);
        // change classes to make elements enabled or disabled
          document.getElementById("tolerancePercentage").className = "input-highlighted";
          document.getElementById("minimumQty").className = "input-highlighted";
          document.getElementById("maximumQty").className = "input-disabled";
      }
      else if (maximumQtyChecked && minimumQtyChecked === false){
      //check if any value is entered into maximum qty field
      if (maximumQty) {
        maximumQty = document.occ.maximumQty.value; // take the value entered by hand
      } else { // if no value was entered manually
        maximumQty = document.occ.order_qty1.value; // take the ordered qty as minimum qty if nothing entered by hand in maximumQty field
      }
      // proceed to calculate minimum qty as previously
        minimumQty = orderQty - orderQty * tolerancePercentage;
      // recalculate the raw material order qty
        orderQtyRawMaterial = calculateRawMaterialOrderQty (orderQty,minimumQty, maximumQty);
      // input the raw material order qty
        document.occ.order_qty1_less.value = parseFloat(orderQtyRawMaterial).toFixed(0);
      // and display on screen
      document.occ.minimumQty.value = parseFloat(minimumQty).toFixed(0);
      document.occ.maximumQty.value = parseFloat(maximumQty).toFixed(0);
      // change classes to make elements enabled or disabled
      document.getElementById("tolerancePercentage").className = "input-highlighted";
      document.getElementById("minimumQty").className = "input-disabled";
      document.getElementById("maximumQty").className = "input-highlighted";

    } else if (maximumQtyChecked && minimumQtyChecked) { // if both checked zero out tolerance value since both min and max values will be entered by hand
      document.occ.tolerant.value = 0; // zero out tolerance value
      //check if any value is entered into minimum qty field
        if (minimumQty) {
          minimumQty = document.occ.minimumQty.value; // take the value entered by hand
        } else { // if no value was entered manually
          minimumQty = document.occ.order_qty1.value; // take the ordered qty as minimum qty if nothing entered by hand in order_qty1_less field
        }
        //check if any value is entered into maximum qty field
        if (maximumQty) {
          maximumQty = document.occ.maximumQty.value; // take the value entered by hand
        } else { // if no value was entered manually
          maximumQty = document.occ.order_qty1.value; // take the ordered qty as minimum qty if nothing entered by hand in maximumQty field
        }
      // recalculate the raw material order qty
        orderQtyRawMaterial = calculateRawMaterialOrderQty (orderQty,minimumQty, maximumQty);
      // input the raw material order qty
        document.occ.order_qty1_less.value = parseFloat(orderQtyRawMaterial).toFixed(0);
      // change classes to make elements enabled or disabled
        document.getElementById("tolerancePercentage").className = "input-disabled";
        document.getElementById("minimumQty").className = "input-highlighted";
        document.getElementById("maximumQty").className = "input-highlighted";
    } else {
      alert ('this condition is not supported');
    }

    //orderQty = parseFloat(document.occ.order_qty1.value);
    //if (isNaN(orderQty)) {
    //  orderQty = 0;
    //}
    var tolerant = parseFloat(document.occ.tolerant.value);
    if (isNaN(tolerant)) {tolerant = 0;}
    var margin = 0;
    var margin_pln = 0;

    margin = parseFloat(document.occ.margin.value);
    margin_pln = parseFloat(document.occ.margin_pln.value);
    if (margins === "proc") {
      document.occ.margin_pln.value = parseFloat(0).toFixed(4);
      margin_pln = 0;
    }
    if (margins === "pln") {
      document.occ.margin.value = parseFloat(0).toFixed(4);
      margin = 0;
    }

    /*
    ///if ((orderQty) && (orderQty > 0) && (tolerant) && (tolerant > 0) && (margin >= "0") && (margin_pln >= "0")) {
    //alert('qty='+ orderQty +'; toler=' +tolerant);
    //if ((orderQty) && (orderQty > 0) && (tolerant) && (tolerant > 0)) {
    //    document.getElementById("table_paper1").style.display = "";
    document.occ.order_qty1.value = parseFloat(orderQty).toFixed(0);
    //document.occ.tolerant.value = parseFloat(tolerant).toFixed(0);
    //} else {
    /// document.getElementById("table_paper1").style.display = "none";;
    //}
    */
    /*
    var not_less = document.occ.not_less.checked;
    if (not_less) {
      var procent = document.occ.order_qty1_less_procent.value;
      var qty = orderQty + (orderQty * procent / 100);
      document.occ.order_qty1_less.value = parseFloat(qty).toFixed(0);
    } else {
      document.occ.order_qty1_less.value = parseFloat(orderQty).toFixed(0);
    }
    */
    setTimeout(select_paper1_, TimeOut);
  }


  function select_paper1_() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var paper_id1 = document.occ.paper_id1.value;
    document.occ.paper_type_id1.value = paper_id1;
    var paper_gram_id1 = document.occ.paper_gram_id1.value;
    // zero out data in hidden fields after user has changed dropdown value
    document.occ.gram1.value = parseFloat(0).toFixed(2);
    document.occ.product_paper_cost_history.value = '';

    if (paper_gram_id1 === "") { // if user hasn't selected any paper then zero out hidden field
      document.occ.gram1.value = parseFloat(0).toFixed(2);
    } else {
      // get text from selected dropdown and populate hidden fields
        var  paper1GrammageInput = document.getElementById (  "paper1GrammageInput"  );
        var  paper1GrammageValue = paper1GrammageInput.options [paper1GrammageInput.selectedIndex] .text;
        document.occ.gram1.value = paper1GrammageValue;
      // run ajax query
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        var  P1xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
        var  P1xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
        }
        P1xmlhttp.onreadystatechange = function() {
          if (P1xmlhttp.readyState === 4 && P1xmlhttp.status === 200) {
            var P1data_val = P1xmlhttp.responseText;
            var P1data_arr = P1data_val.split('_');
            //var P1data_value = P1data_arr[0] * "1";
            //if (P1data_value > "0") {
            //  document.occ.gram1.value = P1data_value;
            //}
            // get data on last raw material 1 price and average price.
            var P1data_hist = P1data_arr[1];
            document.occ.product_paper_cost_history.value = P1data_hist;
          }
        };

        P1xmlhttp.open("GET", "order_calculation_create_gram1_.php?var_id=" + paper_gram_id1 + "&paper_id=" + paper_id1, true);
        P1xmlhttp.send();
    }
    // populate hidden fields with values from user entered fields
    var product_paper_sheetx1 = document.occ.product_paper_sheetx1.value;
    document.occ.sheetx1.value = product_paper_sheetx1;
    var product_paper_sheety1 = document.occ.product_paper_sheety1.value;
    document.occ.sheety1.value = product_paper_sheety1;
    document.occ.rawMaterial1_SQM.value = Math.round(((product_paper_sheetx1*product_paper_sheety1)/1000000)*100)/100 + " m2"; // calculate SQM of raw material 1 for display on screen

    setTimeout(select_paper1_price, TimeOut);
    setTimeout(select_paper2_, TimeOut);
  }

  function select_paper1_price() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var P1Ptype_id = document.occ.paper_id1.value;
    var P1Pgram_id = document.occ.paper_gram_id1.value;
    var P1Psx = parseFloat(document.occ.sheetx1.value) / 1000;
    var P1Psy = parseFloat(document.occ.sheety1.value) / 1000;
    var P1Pqty = parseFloat(document.occ.order_qty1_less.value);
    var P1Pnest = parseFloat(document.occ.product_paper_value1.value);
    var P1Pcut = parseFloat(document.occ.product_paper_cut1.value);

    if ((P1Ptype_id) && (P1Pgram_id) && (P1Psx) && (P1Psy) && (P1Pnest) && (P1Pcut)) {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  P1Pxmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var P1Pxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      P1Pxmlhttp.onreadystatechange = function() {
        if (P1Pxmlhttp.readyState === 4 && P1Pxmlhttp.status === 200) {
          var P1Pdata_value = P1Pxmlhttp.responseText;
          var P1Pdata_value = P1Pdata_value * "1";
          if (P1Pdata_value > "0") {
            document.occ.product_paper_cost_kg1.value = P1Pdata_value;
          }
        }
      };

      ///musze znać ilość kg
      var P1Pwaste1 = parseFloat(document.occ.waste_proc1.value);
      P1Pwaste1 = +P1Pwaste1.toFixed(2); // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
      var P1Pgram1 = parseFloat(document.occ.gram1.value);

      var P1Psqm = P1Pqty / (P1Pnest * P1Pcut) * (P1Psx * P1Psy * P1Pgram1 / 1000);

      if (isNaN(P1Psqm)) {
        P1Psqm = 0;
      }
      if (P1Pwaste1 > "0") {
        var P1Psqm = P1Psqm + P1Psqm * P1Pwaste1;
      }
      P1Pxmlhttp.open("GET", "order_calculation_create_paper_price.php?type_id=" + P1Ptype_id + "&gram_id=" + P1Pgram_id + "&sqm=" + P1Psqm, true);
      P1Pxmlhttp.send();
    }
  }

  function select_paper2_() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;
    var paper2Selected = false; // if second paper has been selected
    var paper_id2 = document.occ.paper_id2.value;

    if (paper_id2) {
      paper2Selected = true;
    } else {
      paper2Selected = false;
    }
    showHidePaper2Fields (paper2Selected);

    document.occ.paper_type_id2.value = paper_id2;
    var paper_gram_id2 = document.occ.paper_gram_id2.value;
    if (paper_gram_id2 === "") {
      document.occ.gram2.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  P2xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  P2xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      P2xmlhttp.onreadystatechange = function() {
        if (P2xmlhttp.readyState === 4 && P2xmlhttp.status === 200) {
          var P2data_value = P2xmlhttp.responseText;
          var P2data_value = P2data_value * "1";
          if (P2data_value > "0") {
            document.occ.gram2.value = P2data_value;
          } else {
            document.occ.gram2.value = parseFloat(0).toFixed(2);
          }
        }
      };
      P2xmlhttp.open("GET", "order_calculation_create_gram2_.php?var_id=" + paper_gram_id2, true);
      P2xmlhttp.send();
    }
    var product_paper_sheetx2 = document.occ.product_paper_sheetx2.value;
    document.occ.sheetx2.value = product_paper_sheetx2;
    var product_paper_sheety2 = document.occ.product_paper_sheety2.value;
    document.occ.sheety2.value = product_paper_sheety2;
    document.occ.rawMaterial2_SQM.value = Math.round(((product_paper_sheetx2*product_paper_sheety2)/1000000)*100)/100 + " m2"; // calculate SQM of raw material 2 for display on screen

    setTimeout(select_paper2_price, TimeOut);
    setTimeout(count_cost_ink, TimeOut);
  }

  function select_paper2_price() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var P2Ptype_id = document.occ.paper_id2.value;
    var P2Pgram_id = document.occ.paper_gram_id2.value;
    var P2Psx = parseFloat(document.occ.sheetx2.value) / 1000;
    var P2Psy = parseFloat(document.occ.sheety2.value) / 1000;
    var P2Pqty = parseFloat(document.occ.order_qty1_less.value);
    var P2Pnest = parseFloat(document.occ.product_paper_value2.value);

    if ((P2Ptype_id) && (P2Pgram_id) && (P2Psx) && (P2Psy) && (P2Pnest)) {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  P2Pxmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  P2Pxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      P2Pxmlhttp.onreadystatechange = function() {
        if (P2Pxmlhttp.readyState === 4 && P2Pxmlhttp.status === 200) {
          var P2Pdata_value = P2Pxmlhttp.responseText;
          var P2Pdata_value = P2Pdata_value * "1";
          if (P2Pdata_value > "0") {
            document.occ.product_paper_cost_m22.value = P2Pdata_value;
            document.occ.product_paper_cost_kg2.value = "";
          }
        }
      };

      ///musze znać ilość kg
      var P2Pwaste1 = parseFloat(document.occ.waste_proc2.value);
      var P2Psqm = P2Pqty / P2Pnest * (P2Psx * P2Psy);

      if (isNaN(P2Psqm)) {
        P2Psqm = 0;
      }
      if (P2Pwaste1 > "0") {
        P2Psqm = P2Psqm + (P2Psqm * P2Pwaste1 / 100);
      }
      P2Pxmlhttp.open("GET", "order_calculation_create_paper_price.php?type_id=" + P2Ptype_id + "&gram_id=" + P2Pgram_id + "&sqm=" + P2Psqm, true);
      P2Pxmlhttp.send();
    }
  }


  function count_cost_ink() { //zmieniam maszynę...
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var CInesting = parseFloat(document.occ.product_paper_value1.value);
    var CIorder_qty = parseFloat(document.occ.order_qty1_less.value);
    var CIark = CIorder_qty / CInesting;
    var CIKA_p1 = parseFloat(document.occ.cost_administracja1.value) / 100; // get standard administrative adder percentage
    var CIKA_p1_to = parseFloat(document.occ.cost_administracja_to1.value); // get max qty of stanrdard sized runs
    var CIKA_p2 = parseFloat(document.occ.cost_administracja2.value) / 100; // get non-standard administrative adder percentage for large runs
    var CIKP_p1 = parseFloat(document.occ.cost_podatek1.value) / 100; // get standard tax adder percentage
    var CIKP_p1_to = parseFloat(document.occ.cost_podatek_to1.value); // get max qty of stanrdard sized runs
    var CIKP_p2 = parseFloat(document.occ.cost_podatek2.value) / 100; // get non-standard tax adder percentage for large runs
    var CImargin = parseFloat(document.occ.margin.value) / 100 + 1; // get calculated margin
    var CIKA = 0; // 1 - administrative adder percentage
    var CIKP = 0; // 1 - tax adder percentage

    if (isNaN(CImargin)) {
      CImargin = 0;
    }

    // evaluate administrative and tax adder percentage depending on size of run in sheets
      if (CIark > CIKA_p1_to) { // large run
        CIKA = 1 - CIKA_p2; // take non-standard administrative adder percentage for large runs
        CIKP = 1 - CIKP_p2; // take non-standard tax adder percentage for large runs
      } else { // small run
        CIKA = 1 - CIKA_p1; // take standard administrative adder percentage
        CIKP = 1 - CIKP_p1; // take standard tax adder percentage
      }
      // check for NaN
        if (isNaN(CIKA)) {
          CIKA = 0;
        }
        if (isNaN(CIKP)) {
          CIKP = 0;
        }

    // get number varnish passes
    var CIvarnish = 0;
    var CIvarnish_type_id = document.occ.varnish_type_id.value;
    if (CIvarnish_type_id) {
      CIvarnish = 1;
    }
    // get number of CMYK colors on awers
    var CIa_c = parseFloat(document.occ.awers_cmyk_qty_colors.value);
    if (isNaN(CIa_c)) {
      CIa_c = 0;
    }
    // get number of PANTONE colors on awers
    var CIa_p = parseFloat(document.occ.awers_pms_qty_colors.value);
    if (isNaN(CIa_p)) {
      CIa_p = 0;
    }
    // get number of CMYK colors on rewers
    var CIr_c = parseFloat(document.occ.rewers_cmyk_qty_colors.value);
    if (isNaN(CIr_c)) {
      CIr_c = 0;
    }
    // get number of PANTONE colors on rewers
    var CIr_p = parseFloat(document.occ.rewers_pms_qty_colors.value);
    if (isNaN(CIr_p)) {
      CIr_p = 0;
    }
    // get the number of ink passes above which priting is to be done on Komori and not Roland
    var CIink_qty_komori = parseFloat(document.occ.ink_qty_komori.value);
    if (isNaN(CIink_qty_komori)) {
      //CIink_qty_komori = 2; // if no ink passes are found take 2 (Roland)
      CIink_qty_komori = 0; // if no ink passes are found take 0 since Roland is no loger in usage
    }

    var CIsum = parseFloat(CIa_c + CIa_p + CIr_p + CIr_c + CIvarnish); // calculate the total number of ink stations used
    document.occ.cost_minimum_mnoznik.value = parseFloat(1); /// ustalenie mnożnika 1 // zmiana zdania 2017-05-30 Paweł R

    if (CIsum > CIink_qty_komori) { // if total number of colors to be used exceeds number of ink passes above which priting is to be done on Komori then use Komori
      // Komori is the only machine available so it will always be chosen for firs print pass
        document.occ.print_machine_id.value = '1';
        document.occ.print_machine_name.value = 'Komori';
      // calculate minimum costs
        if ((CIKA) && (CIKP) && (CImargin)) {
          document.occ.cost_minimum.value = parseFloat((parseFloat(document.occ.cost_minimum_komori.value) * CIKA * CIKP) / CImargin);
          document.occ.cost_minimum_mnoznik.value = parseFloat(CIKA * CIKP / CImargin);
        }
    } else if (CIsum <= CIink_qty_komori) { // if total number of colors to be used doesn't exceed number of ink passes above which priting is to be done on Komori then still use Komori as there no longer is a Roland machine
      // Komori is the only machine available so it will always be chosen for second print pass
        document.occ.print_machine_id.value = '1';
        document.occ.print_machine_name.value = 'Komori';
      // calculate minimum costs
        if ((CIKA) && (CIKP) && (CImargin)) {
          document.occ.cost_minimum.value = parseFloat((parseFloat(document.occ.cost_minimum_komori.value) * CIKA * CIKP) / CImargin);
          document.occ.cost_minimum_mnoznik.value = parseFloat(CIKA * CIKP / CImargin);
        }
    }

    var CIr_sales_one = parseFloat(document.occ.cost_sales_one_write.value);
    if (isNaN(CIr_sales_one)) {
      CIr_sales_one = 0;
    }
    if (CIr_sales_one > 0) {
      document.occ.cost_minimum_mnoznik.value = parseFloat(1);
    }

    setTimeout(select_waste, TimeOut);
  }

  function select_waste() { ///jaki odpad dać na druk
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var SWqty = parseFloat(document.occ.order_qty1_less.value);
    var SWnest = parseFloat(document.occ.product_paper_value1.value);
    var SWcut = parseFloat(document.occ.product_paper_cut1.value);
    var SWmachine_id = document.occ.print_machine_id.value;
    var SWmachine_name = document.occ.print_machine_name.value;
    // zero out waste percentage in hidden fields before getting it from db
    document.occ.waste_proc1.value = 0;
    document.occ.waste_proc2.value = 0;

    if ((SWqty) && (SWnest)) {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  SWxmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  SWxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      SWxmlhttp.onreadystatechange = function() {
        if (SWxmlhttp.readyState === 4 && SWxmlhttp.status === 200) {
          var SWwaste1 = SWxmlhttp.responseText;
          SWwaste1 = SWwaste1 * "1"; // multiply by one to get rid of the empty text at the end of echoed string
          // if waste larger than 0 has been returned from db populate fields with it
          if (SWwaste1 > "0") {
            // NOTE: Same waste percentage is assigned to raw material 1 and raw material 2
            document.occ.waste_proc1.value = SWwaste1; // assign returned waste percentage to raw material 1
            document.occ.waste_proc2.value = SWwaste1; // assign returned waste percentage to raw material 2
          } else {
            alert ("UWAGA! Został pobrany zerowy standardowy procent odpadu. Kalkulacja będzie nieprawidłowa!")
          }
        } else {
          //alert ("UWAGA! Błąd podczas pobierania standardowego procentu odpadu. Kalkulacja będzie nieprawidłowa!")
        }
      };

      var SWark = parseFloat(SWqty / (SWnest * SWcut)).toFixed(0);
      if (isNaN(SWark)) {
        SWark = 0;
      }
      SWxmlhttp.open("GET", "order_calculation_create_awers_waste.php?var_id=" + SWmachine_id + "&order_ark=" + SWark + "&machine_name=" + SWmachine_name, true);
      SWxmlhttp.send();
    }
    setTimeout(count_cost_paper1, TimeOut);
  }


  function count_cost_paper1() {
    // Function used to calculate material cost of first material type
    // FREEZE calculation for the duration of this function
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    // define variables
      let rawMaterial1_SheetX;      // raw material 1 sheetX value entered by user
      let rawMaterial1_SheetY;      // raw material 1 sheetX value entered by user
      let rawMaterial1_Grammage;    // raw material 1 grammage entered by user
      let qtyOrdered;               // qty ordered by customer
      let rawMaterial1_UpsPerSheet; // number of ups per sheets entered by user
      let rawMaterial1_CostPerKG;   // raw material 1 cost per kg entered by user
      let rawMaterial1_ID;          // get paperID from select box
      let rawMaterial1_WastePercent;// waste percenatage on raw material one defined in db
      let rawMaterial1_TotalCost;   // raw material 1 total costs
      let rawMaterial1_GrossKG;     // raw material 1 gross weight in KGs
      let rawMaterial1_NetKG;       // raw material 1 net weight in KGs
      let grossSheetQty;            // raw material 1 gross sheet qty
      let netSheetQty;              // raw material 1 net sheet qty
      let printingProcessWasteSheetQty;            // raw material 1 waste sheet qty
      let minWasteSheetQty;         // raw material 1 minimum waste sheet qty dependend on printing machine and number of colors
      let rawMaterial1_GrammageAdjusted;      // raw material 1 grammage adjusted based on supplier paper specifications
      let extra_plate_komori;                 // number of extra plates required for additional setups on KOMORI printing machine entered by user
        
    // populate variables  
      rawMaterial1_SheetX = parseFloat(document.occ.sheetx1.value) / 1000;
      rawMaterial1_SheetY = parseFloat(document.occ.sheety1.value) / 1000;
      rawMaterial1_Grammage = parseFloat(document.occ.gram1.value) / 1000;
      qtyOrdered = parseFloat(document.occ.order_qty1_less.value);
      rawMaterial1_UpsPerSheet = parseFloat(document.occ.product_paper_value1.value);
      rawMaterial1_CostPerKG = parseFloat(document.occ.product_paper_cost_kg1.value);
      rawMaterial1_ID = parseFloat(document.occ.paper_id1.value);
      rawMaterial1_WastePercent =  parseFloat(document.occ.waste_proc1.value); // get the value straight from hidden field
      // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
      // It changes the result (which is a string) into a number again (think "0 + foo"), which means that it uses only as many digits as necessary.
      rawMaterial1_WastePercent = +rawMaterial1_WastePercent.toFixed(2);
      rawMaterial1_TotalCost=0;
      rawMaterial1_GrossKG=0;
      grossSheetQty=0;
      netSheetQty=0;
      additionalSheetsForEachExtraPlate = parseFloat(document.occ.ark_extra_plate.value); // this value if taken from a hidden field populated from databse by ReadOrderCalculationSettings function
      // get number of sheets to be used up for additional setups
        if (isNaN(additionalSheetsForEachExtraPlate)) {additionalSheetsForEachExtraPlate = 0;}
      // get the number of extra plates to be used
        extra_plate_komori = parseFloat(document.occ.extra_plate_komori.value);
        if (isNaN(extra_plate_komori)) {extra_plate_komori = 0;}
      
  // BEGIN CALCULATIONS
     // add up extra plates
      extra_plate = extra_plate_komori; // count number of extra plates, since ROLAND is no longer used leave only one priting machine
    // sum extra sheets used per each addtional setup
      sheetsTotalForAdditionalSetup = Math.round(extra_plate * additionalSheetsForEachExtraPlate);
      if (isNaN(sheetsTotalForAdditionalSetup)) {sheetsTotalForAdditionalSetup = 0;}

    // 1. Calculate raw material net sheets
      netSheetQty = Math.round(qtyOrdered/rawMaterial1_UpsPerSheet); 
      rawMaterial1_NetKG = netSheetQty * rawMaterial1_SheetX * rawMaterial1_SheetY * rawMaterial1_Grammage;
    // 2. Calculate waste sheet qty
      printingProcessWasteSheetQty = netSheetQty * rawMaterial1_WastePercent;
    // 3. Get the minumum sheet qty needed for an order based on number of colors for first setup
      minWasteSheetQty = calculateMinSheetQty(); 
    // 4. Compare current standard additional sheets (grossSheetQty - netSheetQty) with min sheet qty and take the bigger value
      //if (printingProcessWasteSheetQty < minWasteSheetQty) {printingProcessWasteSheetQty = minWasteSheetQty;}
    // 5. Add minWasteSheetQty to printingProcessWasteSheetQty to net qty to get at gross qty
      grossSheetQty = netSheetQty + minWasteSheetQty + printingProcessWasteSheetQty; 
    // 6. Add sheets for additional setups and make it the new gross qty
      grossSheetQty = Math.round(grossSheetQty + sheetsTotalForAdditionalSetup); 
    // 7. Check and adjust grammage
      rawMaterial1_GrammageAdjusted = rawMaterial1_Grammage + (rawMaterial1_Grammage*adjustGrammage(rawMaterial1_ID));
    // 8. Calculate raw material 1 grossWeight based on grossSheetQty of sheets
      rawMaterial1_GrossKG = grossSheetQty * (rawMaterial1_SheetX * rawMaterial1_SheetY * rawMaterial1_GrammageAdjusted); // calculate kgs based on raw material data
    // 9. Calculate raw material 1 cost based on grossweight
      rawMaterial1_TotalCost = rawMaterial1_GrossKG * rawMaterial1_CostPerKG; // calcualte raw material 1 costs
      if (isNaN(rawMaterial1_TotalCost)) {rawMaterial1_TotalCost = 0;} 

  // PRINT RESULTS ON SCREEN
    // create raw material 1 info string
      document.getElementById("cost_paper1_info").value = '( (nakład/ilość użytków) + (ark na dodat. narzad * extra blachy komori)) * X * Y * gram * zwyżka gram * cena surowca * %odpadu = (' + qtyOrdered + '/' + rawMaterial1_UpsPerSheet + ') + (' + additionalSheetsForEachExtraPlate + ' * ' + extra_plate_komori + ')) * (' + rawMaterial1_SheetX + '*' + rawMaterial1_SheetY + '*' + rawMaterial1_Grammage + '*' + adjustGrammage(rawMaterial1_ID)*100 + ' % ) * ' + rawMaterial1_CostPerKG + ' * ' + parseFloat(rawMaterial1_WastePercent*100).toFixed(2) + ' % = ' + parseFloat(rawMaterial1_TotalCost).toFixed(2);
    //print data in calculation header and in details section
      document.getElementById("grossQty").value = parseFloat(grossSheetQty).toFixed(0);
      document.getElementById("netQty").value = parseFloat(netSheetQty).toFixed(0);
    // print raw material 1 costs in header and in details section
      document.getElementById("cost_paper1").value = parseFloat(rawMaterial1_TotalCost).toFixed(2);           // print data in details
      document.getElementById("cost_paper1_top").value = parseFloat(rawMaterial1_TotalCost).toFixed(2);       // print data in header
    // print raw material 1 costs per kg 
      document.getElementById("product_paper_cost_kg1").value = parseFloat(rawMaterial1_CostPerKG).toFixed(4);
    // print raw material 1 gross weight
      document.getElementById("paper1_weight").value = parseFloat(rawMaterial1_GrossKG).toFixed(0);             // gross raw material 1 weight
      document.getElementById("rawMaterial1_NetKG").value = parseFloat(rawMaterial1_NetKG).toFixed(0);             // net raw material 1 weight
      document.getElementById("paper1_weight_top").value = parseFloat(rawMaterial1_GrossKG).toFixed(0);         // print data in header
    // set timeout to finish ajax calls and call next function
      setTimeout(count_cost_paper2, TimeOut);
  }

  function count_cost_paper2(rawMaterial2_CostType) {
    // Function used to calculate material cost of first material type
    // FREEZE calculation for the duration of this function
      document.getElementById("div_calculate").style.display = "";
      document.getElementById("input_save_input").disabled = true;
    // define variables used in function
        let rawMaterial2_ID;             // ID of raw material 2
        let rawMaterial2_SheetX;        // raw material 2 X dimension entered by user
        let rawMaterial2_SheetY;        // raw material 2 Y dimension entered by user
        let rawMaterial2_Grammage;      // raw material 2 grammage entered by user
        let rawMaterial2_GrammageAdjusted; // grammage adjusted by a factor depending on raw material ID (only if second raw material is calculated by kgs)
        let qtyOrdered;                 // get the ordered qty 
        let rawMaterial2_UpsPerSheet;   // get the number of ups per sheets on raw material 2
        let rawMaterial2_Commision;     // get the additional comission on raw material 2 entered by user 
        let rawMaterial2_WastePercent;  // get the waste percentage stored in db for raw material 2
        let rawMaterial1_GrossKG;       // get the gross weigt of raw material 1    
        let rawMaterial2_NetKG;         // get the net weight of raw material 2
        let rawMaterial2_GrossKG;       // gross weight of raw maerial 2
        let rawMaterial2_NetSheets;     // raw material 2 net sheets
        let rawMaterial2_GrossSheets;   // raw material 2 gross sheets
        let rawmMaterial2_WasteSheets;  // raw material 2 gross sheets
        let rawMaterial2_NetSQM;        // net area of raw material 2
        let rawMaterial2_GrossSQM;      // gross area of raw material 2
        let rawMaterial2_WeighModifier; // ?? raw material 2 weight modifier ??
        let rawMaterials_TotalWeight;   // total gross weight of raw material 1 and raw material 2
        let rawMaterial2_CostPerKG;     // cost per KG of raw material 2 if selected by user
        let rawMaterial2_CostPerSQM;    // cost per SQM of raw material 2 if selected by user
        let rawMaterial2_UnitCost;      // unit cost value of raw material 2 for selected cost type
        let rawMaterial2_TotalCost;     // raw material 2 total costs
        let rawMaterial2_InfoString;    // raw material 2 calculations info string
    // populate variables
        rawMaterial2_ID = document.occ.paper_id2.value; // get the raw material ID
        rawMaterial2_SheetX = parseFloat(document.occ.sheetx2.value) / 1000;
        rawMaterial2_SheetY = parseFloat(document.occ.sheety2.value) / 1000;
        rawMaterial2_Grammage = parseFloat(document.occ.gram2.value) / 1000;
        qtyOrdered = parseFloat(document.occ.order_qty1_less.value);  
        rawMaterial2_UpsPerSheet = parseFloat(document.occ.product_paper_value2.value);
        rawMaterial2_Commision = parseFloat(document.occ.product_paper_narzut_proc2.value);
        rawMaterial2_WastePercent = parseFloat(document.occ.waste_proc2.value);
          // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
          // It changes the result (which is a string) into a number again (think "0 + foo"), which means that it uses only as many digits as necessary.
          rawMaterial2_WastePercent = +rawMaterial2_WastePercent.toFixed(2);
        rawMaterial2_TotalCost = 0;
        rawMaterial1_GrossKG = parseFloat(document.occ.paper1_weight.value); // get raw material 1 gross weight stored in hidden field
        rawMaterial2_GrossKG=0;
        rawMaterial2_WeighModifier = parseFloat(document.occ.proc_weight_material.value); // get the weight modifier from db
    

    //check for preconditions
      // rawMaterial2_CostType is triggered and passed to count_cost_paper2 function on change event of product_paper_cost_kg2 or product_paper_cost_m22 fields
        // but count cost 2 is also trigerred by count cost paper 1, and if so the rawMaterial2_CostType will not be passed to function 
        // in this event check for the presence of a price in both fields and choose a corresponding cost type
        if (!rawMaterial2_CostType) { // if no cost type passed to function than check for costs fields
          rawMaterial2_CostPerKG = parseFloat(document.occ.product_paper_cost_kg2.value);
          rawMaterial2_CostPerSQM = parseFloat(document.occ.product_paper_cost_m22.value);
          if (rawMaterial2_CostPerKG > "0") {
            rawMaterial2_CostType = "kg"; // chose kg costs type
            rawMaterial2_UnitCost = parseFloat(document.occ.product_paper_cost_kg2.value); // get the raw material unit cost entered by user
            document.occ.product_paper_cost_m22.value = ""; // zero out the other cost field
          } else if (rawMaterial2_CostPerSQM > "0") {
              rawMaterial2_CostType = "m2"; // choose sqm cost type
              rawMaterial2_UnitCost = parseFloat(document.occ.product_paper_cost_m22.value); // get the raw material unit cost entered by user
              document.occ.product_paper_cost_kg2.value = ""; // zero out the other cost field
          } else {
            rawMaterial2_CostType = "m2"; // choose a dafault cost type
            rawMaterial2_UnitCost = parseFloat(document.occ.product_paper_cost_m22.value); // get the raw material unit cost entered by user
            document.occ.product_paper_cost_kg2.value = ""; // zero out the other cost field
          }
        } 
        
        if (rawMaterial2_CostType === "m2"){
          rawMaterial2_UnitCost = parseFloat(document.occ.product_paper_cost_m22.value);
          document.occ.product_paper_cost_kg2.value = ""; // zero out the other cost field
        } else if (rawMaterial2_CostType === "kg"){
          rawMaterial2_UnitCost = parseFloat(document.occ.product_paper_cost_kg2.value);
          document.occ.product_paper_cost_m22.value = ""; // zero out the other cost field
          rawMaterial2_GrammageAdjusted = rawMaterial2_Grammage + (rawMaterial2_Grammage*adjustGrammage(rawMaterial2_ID));
        }

      // TODO: wht is this comission and how do we use it??!!
      // check if comission is populated by user
        if (isNaN(rawMaterial2_Commision)) {
          rawMaterial2_Commision = 1;
        } else {
          rawMaterial2_Commision = rawMaterial2_Commision / 100 + 1;
        }

      // TODO: what is this modifier and how does this work??!!
        // check for paper wegith modifier
        if (rawMaterial2_WeighModifier > 0) {
          rawMaterial2_WeighModifier = rawMaterial2_WeighModifier / 100;
        } else {
          rawMaterial2_WeighModifier = 1;
        }
      // check for NaN and make 0 when neccessary
        if (isNaN(rawMaterial2_UpsPerSheet)) {rawMaterial2_UpsPerSheet=0;}
        if (isNaN(rawMaterial2_SheetX)) {rawMaterial2_SheetX=0;}
        if (isNaN(rawMaterial2_SheetY)) {rawMaterial2_SheetY=0;}
        if (isNaN(rawMaterial2_Grammage)) {rawMaterial2_Grammage=0;}
        if (isNaN(rawMaterial2_UnitCost)) {rawMaterial2_UnitCost=0;}


    //BEGIN CALCULATIONS
    if (rawMaterial2_UpsPerSheet > 0){ // only when ups per sheet greater than 0 since other wise we get infinity 
      // 1. Calculate raw material 2 net sheet qty
        rawMaterial2_NetSheets = qtyOrdered / rawMaterial2_UpsPerSheet;
      // 2 calculate raw material 2 net sqm
        rawMaterial2_NetSQM = rawMaterial2_NetSheets * rawMaterial2_SheetX * rawMaterial2_SheetY;
      // 3. Calculate war material 2 waste sheet qty
        rawmMaterial2_WasteSheets = rawMaterial2_NetSheets * rawMaterial2_WastePercent;
      // 4. Add waste qty to net qty to get at gross qty
        rawMaterial2_GrossSheets = rawMaterial2_NetSheets + rawmMaterial2_WasteSheets; 
      // 5. calculate gross sheet square meters required for second raw material
        // NOTE: that X and Y dimensions are increased to account for supplier tolerances.
          if (rawMaterial2_CostType === "m2") { // increase sheets dims in case of cardboard
            rawMaterial2_GrossSQM = rawMaterial2_GrossSheets * adjustSheetDims(rawMaterial2_SheetX) * adjustSheetDims(rawMaterial2_SheetY); 
          } else { // do not increase sheet dims in case of paperboard
            rawMaterial2_GrossSQM = rawMaterial2_GrossSheets * rawMaterial2_SheetX * rawMaterial2_SheetY; 
          }
          // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
          // It changes the result (which is a string) into a number again (think "0 + foo"), which means that it uses only as many digits as necessary.
          rawMaterial2_GrossSQM = +rawMaterial2_GrossSQM.toFixed(2);
          if (isNaN(rawMaterial2_GrossSQM)) {rawMaterial2_GrossSQM = 0;} // check if sqm calculation yeilded numeric result
      // 6 calculate the net sheets kgs required for second raw material
        // TODO: does rawm material 2 grammage need to be adjusted to for kgs calculation??
        if (rawMaterial2_CostType === "kg"){ // inncrease grammage in case of second raw material beeing paperboard
          rawMaterial2_NetKG = rawMaterial2_NetSQM * rawMaterial2_GrammageAdjusted;     
         } else { // do not increase grammage for cardboard
          rawMaterial2_NetKG = rawMaterial2_NetSQM * rawMaterial2_Grammage;     
         }
        
      // 7. calculate gross sheet kgs required for second raw material
        // TODO: does rawm material 2 grammage need to be adjusted to for kgs calculation??
        if (rawMaterial2_CostType === "kg"){ // inncrease grammage in case of second raw material beeing paperboard
          rawMaterial2_GrossKG = rawMaterial2_GrossSQM * rawMaterial2_GrammageAdjusted;
         } else { // do not increase grammage for cardboard
          rawMaterial2_GrossKG = rawMaterial2_GrossSQM * rawMaterial2_Grammage;
         }
          
      // 8. adjust raw material 2 gross weight by the weight modifier 
        // TODO: what is this weight modifier???!!!
          rawMaterial2_GrossKG = rawMaterial2_GrossKG * rawMaterial2_WeighModifier; 
      // 9. Calculate raw material 2 total costs

        if (rawMaterial2_CostType === "kg") {
          rawMaterial2_TotalCost = rawMaterial2_GrossKG * rawMaterial2_UnitCost;
          if (isNaN(rawMaterial2_TotalCost)) {rawMaterial2_TotalCost = 0;} // check for NaN and return 0
          rawMaterial2_InfoString = "(nakład/ilość użytków) * X * Y * gram * zwyzka gram * cena kg * narzut = (" + qtyOrdered + "/" + rawMaterial2_UpsPerSheet + ") * (" + rawMaterial2_SheetX + "*" + rawMaterial2_SheetY + "*" + rawMaterial2_Grammage + '*' + adjustGrammage(rawMaterial2_ID)*100 + ' % ) * ' + rawMaterial2_UnitCost + "*" + rawMaterial2_Commision + " * " + parseFloat(rawMaterial2_WastePercent*100).toFixed(2) + "% = " + parseFloat(rawMaterial2_TotalCost).toFixed(2);
        } else if (rawMaterial2_CostType === "m2"){
          rawMaterial2_TotalCost = rawMaterial2_GrossSQM * rawMaterial2_UnitCost;
          if (isNaN(rawMaterial2_TotalCost)) {rawMaterial2_TotalCost = 0;} // check for NaN and return 0
          rawMaterial2_InfoString = "(nakład/ilość użytków) * X * Y * cena m2 * narzut = " + qtyOrdered + "/" + rawMaterial2_UpsPerSheet + " * (" + adjustSheetDims(rawMaterial2_SheetX) + "*" + adjustSheetDims(rawMaterial2_SheetY) + ") *" + rawMaterial2_UnitCost + "*" + rawMaterial2_Commision + " * " + parseFloat(rawMaterial2_WastePercent*100).toFixed(2) + "% = " + parseFloat(rawMaterial2_TotalCost).toFixed(2);
        }
        
      } else {
        rawMaterial2_NetKG = 0;
        rawMaterial2_GrossKG=0;
        rawMaterial2_NetSQM =0;
        rawMaterial2_GrossSQM =0;
        rawMaterial2_TotalCost =0;
        rawMaterial2_InfoString ="";  
      }

   // 10. calculate total gross order weight in KGS
     rawMaterials_TotalWeight = rawMaterial1_GrossKG + rawMaterial2_GrossKG;

  // PRINT RESULTS ON SCREEN
    // print the raw material 2 info string
      document.occ.cost_paper2_info.value = rawMaterial2_InfoString;
    // print raw material 2 net weight and SQM in details
      document.getElementById("rawMaterial2_NetKG").value = parseFloat(rawMaterial2_NetKG).toFixed(2);       // print data in details
      document.getElementById("rawMaterial2_NetSQM").value = parseFloat(rawMaterial2_NetSQM).toFixed(2);             // print data in details
    // print raw material 2 total costs in details and in header
      document.getElementById("cost_paper2_top").value = parseFloat(rawMaterial2_TotalCost).toFixed(2);         // print data in header
      document.getElementById("cost_paper2").value = parseFloat(rawMaterial2_TotalCost).toFixed(2);             // print data in details
    //print raw material 2 sqm in header and in details
      document.getElementById("paper2_m2").value = parseFloat(rawMaterial2_GrossSQM).toFixed(0);                     // print data in details
      document.getElementById("paper2_m2_top").value = parseFloat(rawMaterial2_GrossSQM).toFixed(0);                 // print data in header
    // print raw material 2 weight in header and in details
      document.getElementById("paper2_weight").value = parseFloat(rawMaterial2_GrossKG).toFixed(0);             // print data in details
      document.getElementById("paper2_weight_top").value = parseFloat(rawMaterial2_GrossKG).toFixed(0);         // print data in header
    // print total raw material weight in header and in details
      document.getElementById("order_total_weight_top").value = parseFloat(rawMaterials_TotalWeight).toFixed(0); // print data in header
      document.getElementById("order_total_weight").value = parseFloat(rawMaterials_TotalWeight).toFixed(0);     // print data in details
    // set timeout to finish ajax calls and call next function
      setTimeout(count_cut_cost, TimeOut);
  }

  function count_cut_cost() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var CUTcost_o = parseFloat(document.occ.cut_cost_pln_h.value);
    var CUTnesting = document.occ.product_paper_value1.value;
    if (isNaN(CUTnesting)) {
      CUTnesting = 0;
    }
    var CUTcut = parseFloat(document.occ.product_paper_cut1.value);
    if (isNaN(CUTcut)) {
      CUTcut = 0;
    }
    var CUTorder_qty = document.occ.order_qty1_less.value;
    if (isNaN(CUTorder_qty)) {
      CUTorder_qty = 0;
    }
    var CUTgram1 = document.occ.gram1.value;
    if (isNaN(CUTgram1)) {
      CUTgram1 = 0;
    }
    var CUTsx = parseFloat(document.occ.sheetx1.value) / 1000;
    if (isNaN(CUTsx)) {
      CUTsx = 0;
    }
    var CUTsy = parseFloat(document.occ.sheety1.value) / 1000;
    if (isNaN(CUTsy)) {
      CUTsy = 0;
    }

    var CUTminimum_cost = parseFloat(document.occ.cost_minimum_cut.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    var CUTmachine_id = 5;

    document.occ.cost_cut.value = parseFloat(0).toFixed(2);
    document.occ.cost_cut_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_cut_info.value = '';
    document.occ.cost_cut_jazda_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_cut_jazda_info.value = '';
    document.occ.cost_cut_idle_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_cut_idle_info.value = '';
    document.occ.cost_cut_total_time.value = parseFloat(0).toFixed(2);

    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
    var  CUTxmlhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
    var  CUTxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
    }
    CUTxmlhttp.onreadystatechange = function() {
      if (CUTxmlhttp.readyState === 4 && CUTxmlhttp.status === 200) {
        var CUTcut_ = CUTxmlhttp.responseText;
        var CUTcut_arr = CUTcut_.split('_');
        CUTcut_s = CUTcut_arr[0] * 1; ///wydajność
        var CUTcut_narzad = CUTcut_arr[1] * 1; ///% idle narzad
        var CUTcut_jazda = CUTcut_arr[2] * 1; ///%idle jazda
        var CUTcut_costH = CUTcut_arr[3] * 1; ///koszt IDLE

        if (CUTcut_s > "0") {
          document.occ.cut_cost_speed.value = parseFloat(CUTcut_s).toFixed(2);
          var CUTcost_jazda = 0;
          if (CUTnesting > "0") {
            CUTtime_jazda = (CUTorder_qty / (CUTnesting * CUTcut) * (CUTsx * CUTsy * CUTgram1 / 1000)) / CUTcut_s;
            var CUTcost_jazda = parseFloat(CUTtime_jazda * CUTcost_o);
          }
          document.occ.cost_cut_jazda_real.value = parseFloat(CUTcost_jazda).toFixed(2);
          document.occ.cost_cut_jazda_info.value = '[(nakład KG)/wydajnośc wycinania]*cena pracy = [(' + CUTorder_qty + '/(' + CUTnesting + '*' + CUTcut + ')*(' + CUTsx + '*' + CUTsy + '*' + CUTgram1 + '/1000))/' + CUTcut_s + ']*' + CUTcost_o;
          ////% przestojów idle
          CUTtime_idle = (CUTtime_jazda * CUTcut_jazda / 100);
          var CUTcost_idle = CUTtime_idle * CUTcut_costH;
          document.occ.cost_cut_idle_real.value = parseFloat(CUTcost_idle).toFixed(2);
          document.occ.cost_cut_idle_info.value = '(czas jazdy * % IDLE) * koszt IDLE/h = (' + parseFloat(CUTtime_jazda).toFixed(2) + ' * ' + CUTcut_jazda + '%) * ' + CUTcut_costH;
          // suma
          var CUTcost_ = CUTcost_jazda + CUTcost_idle;
          document.occ.cost_cut_real.value = parseFloat(CUTcost_).toFixed(2);
          document.occ.cost_cut_info.value = 'koszt jazdy + koszt % IDLE = ' + parseFloat(CUTcost_jazda).toFixed(2) + ' * ' + parseFloat(CUTcost_idle).toFixed(2);
          if (CUTcost_ < CUTminimum_cost) {
            CUTcost_ = CUTminimum_cost;
          }
          document.occ.cost_cut.value = parseFloat(CUTcost_).toFixed(2);
          document.occ.cost_cut_total_time.value = parseFloat(CUTtime_jazda + CUTtime_idle).toFixed(2);
        }
      }
    };

    CUTxmlhttp.open("GET", "order_calculation_create_cost_cut.php?gram=" + CUTgram1 + "&machine_id=" + CUTmachine_id, true);
    CUTxmlhttp.send();

    setTimeout(count_cut2_cost, TimeOut);
  }

  function count_cut2_cost() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;
    var Y2id_ = document.occ.format_id2.value;
    LAM_paper2_id = document.occ.paper_id2.value;
    var CUT2cost_o = parseFloat(document.occ.cut_cost_pln_h.value);
    var CUT2nesting = document.occ.product_paper_value2.value;

    if (isNaN(CUT2nesting)) {CUT2nesting = 0;}
    var CUT2cut = parseFloat(document.occ.product_paper_cut1.value);
    if (isNaN(CUT2cut)) { CUT2cut = 0;}
    var CUT2order_qty = document.occ.order_qty1_less.value;
    if (isNaN(CUT2order_qty)) {CUT2order_qty = 0;}
    var CUT2gram1 = document.occ.gram2.value;
    if (isNaN(CUT2gram1)) {CUT2gram1 = 0;}
    var CUT2sx = parseFloat(document.occ.sheetx2.value) / 1000;
    if (isNaN(CUT2sx)) { CUT2sx = 0; }
    var CUT2sy = parseFloat(document.occ.sheety2.value) / 1000;
    if (isNaN(CUT2sy)) {CUT2sy = 0;}
    CUT2_check = document.occ.check_cut2.checked;

    var CUT2minimum_cost = parseFloat(document.occ.cost_minimum_cut.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    var CUT2machine_id = 5;

    zeroOutData_Gilotyna2 (); // zero out data before calculations

    if ((CUT2_check) && (LAM_paper2_id) && (CUT2nesting > "0") && (Y2id_)) {

        if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
        var  CUT2xmlhttp = new XMLHttpRequest();
        } else {
          // code for IE6, IE5
        var  CUT2xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
        }

        CUT2xmlhttp.onreadystatechange = function() {

            if (CUT2xmlhttp.readyState === 4 && CUT2xmlhttp.status === 200) {
              var CUT2cut_ = CUT2xmlhttp.responseText; /// speeed dla gramatury
              var CUT2cut_arr = CUT2cut_.split('_');
              CUT2cut_s = CUT2cut_arr[0] * 1; ///wydajność
              var CUT2cut_narzad = CUT2cut_arr[1] * 1; ///% idle narzad
              var CUT2cut_jazda = CUT2cut_arr[2] * 1; ///%idle jazda
              var CUT2cut_cost = CUT2cut_arr[3] * 1; /// koszt godziny IDLE
              CUT2time_idle =0;
              CUT2time_jazda = 0;
              if (CUTcut_s > "0") {
                document.occ.cut2_cost_speed.value = parseFloat(CUT2cut_s).toFixed(2);
                var CUT2cost_jazda = 0;
                CUT2time_jazda = (CUT2order_qty / (CUT2nesting * CUT2cut) * (CUT2sx * CUT2sy * CUT2gram1 / 1000)) / CUT2cut_s;
                CUT2cost_jazda = parseFloat(CUT2time_jazda * CUT2cost_o);
                document.occ.cost_cut2_jazda_real.value = parseFloat(CUT2cost_jazda).toFixed(2);
                document.occ.cost_cut2_jazda_info.value = '[(nakład KG)/wydajnośc wycinania]*cena pracy = [(' + CUT2order_qty + '/(' + CUT2nesting + '*' + CUT2cut + ')*(' + CUT2sx + '*' + CUT2sy + '*' + CUT2gram1 + '/1000))/' + CUT2cut_s + ']*' + CUT2cost_o;
                ////% przestojów idle
                CUT2time_idle = (CUT2time_jazda * CUT2cut_jazda / 100);
                var CUT2cost_idle = CUT2time_idle * CUT2cut_cost;
                document.occ.cost_cut2_idle_real.value = parseFloat(CUT2cost_idle).toFixed(2);
                document.occ.cost_cut2_idle_info.value = '(czas pracy jazdy * % IDLE) * koszt IDLE/h = (' + parseFloat(CUT2time_jazda).toFixed(2) + ' * ' + CUT2cut_jazda + '%) * ' + CUT2cut_cost;
                // suma
                var CUT2cost_ = CUT2cost_jazda + CUT2cost_idle;
                document.occ.cost_cut2_real.value = parseFloat(CUT2cost_).toFixed(2);
                document.occ.cost_cut2_info.value = 'koszt jazdy + koszt % IDLE = ' + parseFloat(CUT2cost_jazda).toFixed(2) + ' * ' + parseFloat(CUT2cost_idle).toFixed(2);
                if (CUT2cost_ < CUT2minimum_cost) {
                  CUT2cost_ = CUT2minimum_cost;
                }
                document.occ.cost_cut2.value = parseFloat(CUT2cost_).toFixed(2);
                document.occ.cost_cut2_total_time.value = parseFloat(CUT2time_jazda + CUT2time_idle).toFixed(2);
            }
          }
        };
        CUT2xmlhttp.open("GET", "order_calculation_create_cost_cut.php?gram=" + CUT2gram1 + "&machine_id=" + CUT2machine_id, true);
        CUT2xmlhttp.send();
  } else {
    zeroOutData_Gilotyna2 (); // if gilotyna 2 checkbox not selected than zeroout data
  }



    setTimeout(add_print_next, TimeOut);
  }




  function add_print_next() { //zmieniam maszynę...
    // define variables
    let colorQty_Awers;
    let colorQty_Rewers;

    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    zeroOutData_PrintNext (); // zero out fields of second printing pass

    // get number of cmyk and pantone colors on AWRERS entered by user 
      colorQty_Awers = countEnteredColorQty_Awers();
    // get number of cmyk and pantone colors on REWERS entered by user
      colorQty_Rewers = countEnteredColorQty_Rewers ();

    document.getElementById("tr_print2_error").style.display = "none"; // hide error bar

    // if there are colors on AWERS and REWERS entered by user go and check if this combination requires a second printing pass
    if ((colorQty_Awers > 0) || (colorQty_Rewers > 0)) {

      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  PNxmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  PNxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }

      // start AJAX call
        PNxmlhttp.onreadystatechange = function() {
          if (PNxmlhttp.readyState === 4 && PNxmlhttp.status === 200) {
            var PNwaste1 = PNxmlhttp.responseText;
            if (PNwaste1 > 0) {
              // if there's a value returned from db means that this combination of colors on reweres and awers requires a second printing pass
              document.getElementById("tr_print2_error").style.display = ""; // show div with information on it
              document.occ.add_print2.checked = true;  // and set checkbox value to true
            }
          }
        };
      // end AJAX call

      PNxmlhttp.open("GET", "order_calculation_create_print2machine.php?awers=" + colorQty_Awers + "&rewers=" + colorQty_Rewers, true);
      PNxmlhttp.send();
    }
    setTimeout(add_print_next2, TimeOut);
  }

  function add_print_next2() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var secondPrintingPass = document.occ.add_print2.checked; // get value of checkbox
    showHideSecondPrintingPass (secondPrintingPass);
      // set second prnting machine to Komori since  its the only one available
      document.occ.print2_machine_name.value = "Komori";
      document.occ.print2_machine_id.value = "1";
    setTimeout(count_cost_awers2, TimeOut);

  }

  function count_cost_awers2() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var A2_1var_id = parseFloat(document.occ.print2_machine_id.value);
    var A2_1qty = parseFloat(document.occ.order_qty1_less.value);
    var A2_1nest = parseFloat(document.occ.product_paper_value1.value);
    var A2_1order_ark = parseFloat(A2_1qty / A2_1nest).toFixed(0);

    var A2_2waste = parseFloat(document.occ.waste_proc1.value);
    A2_2waste = +A2_2waste.toFixed(2); // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
    var A2_2order_a = (A2_1qty / A2_1nest) + ((A2_1qty / A2_1nest) * A2_2waste);
    var A2_2order_ark = parseFloat(A2_2order_a).toFixed(0); // get the number of sheets needed for setup on awers
    
    
    if (A2_2order_ark === "") {
      document.occ.awers2_setup.value = parseFloat(0).toFixed(2);
    } else {
      // get through AJAX number of sheets needed for setup on awers from order_calculation_create_awers_setup.php
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var A2_2xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var A2_2xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      A2_2xmlhttp.onreadystatechange = function() {
        if (A2_2xmlhttp.readyState === 4 && A2_2xmlhttp.status === 200) {
          var A2_2data_value = A2_2xmlhttp.responseText;
          var A2_2data_value = A2_2data_value * "1";
          if (A2_2data_value > "0") {
            document.occ.awers2_setup.value = A2_2data_value;
          } else {
            document.occ.awers2_setup.value = parseFloat(0).toFixed(2);
          }
        }
      };

      A2_2xmlhttp.open("GET", "order_calculation_create_awers_setup.php?var_id=" + A2_1var_id + "&order_ark=" + A2_2order_ark, true);
      A2_2xmlhttp.send();
    }

    var A2_3waste = parseFloat(document.occ.waste_proc1.value);
    A2_3waste = +A2_3waste.toFixed(2); // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
    var A2_3order_a = (A2_1qty / A2_1nest) + ((A2_1qty / A2_1nest) * A2_3waste);
    var A2_3order_ark = parseFloat(A2_3order_a).toFixed(0);
    if (A2_3order_ark === "") {
      document.occ.awers2_speed.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  A2_3xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  A2_3xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      A2_3xmlhttp.onreadystatechange = function() {
        if (A2_3xmlhttp.readyState === 4 && A2_3xmlhttp.status === 200) {
          var A2_3data_value_ = A2_3xmlhttp.responseText;
          var A2_3data_value_arr = A2_3data_value_.split('_');
          var A2_3data_value = A2_3data_value_arr[0] * 1;
          if (A2_3data_value > "0") {
            document.occ.awers2_speed.value = A2_3data_value;
          } else {
            document.occ.awers2_speed.value = parseFloat(0).toFixed(2);
          }
          var A2_3data_narzad = A2_3data_value_arr[1] * 1; /// % narzad
          if (A2_3data_value > "0") {
            document.occ.awers2_idle_narzadP.value = A2_3data_narzad;
          } else {
            document.occ.awers2_idle_narzadP.value = parseFloat(0).toFixed(2);
          }
          var A2_3data_jazda = A2_3data_value_arr[2] * 1; //% jazda
          if (A2_3data_value > "0") {
            document.occ.awers2_idle_jazdaP.value = A2_3data_jazda;
          } else {
            document.occ.awers2_idle_jazdaP.value = parseFloat(0).toFixed(2);
          }
          var A2_3data_cost = A2_3data_value_arr[3] * 1; //koszt PLN/h
          if (A2_3data_value > "0") {
            document.occ.awers2_idle_costH.value = A2_3data_cost;
          } else {
            document.occ.awers2_idle_costH.value = parseFloat(0).toFixed(2);
          }

        }
      };

      A2_3xmlhttp.open("GET", "order_calculation_create_awers_speed.php?var_id=" + A2_1var_id + "&order_ark=" + A2_3order_ark, true);
      A2_3xmlhttp.send();
    }

    setTimeout(count_cost_ink2_total, TimeOut);
  }

  function count_cost_ink2_total() { //speed
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var ITA2qty = parseFloat(document.occ.order_qty1_less.value);
    var ITA2nest = parseFloat(document.occ.product_paper_value1.value);
    var ITA2waste = parseFloat(document.occ.waste_proc1.value);
    ITA2waste = +ITA2waste.toFixed(2); // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
    // TODO: modify to add the number of waste sheets calculated previously
    ITA2ark = ITA2qty / ITA2nest + (ITA2qty / ITA2nest * ITA2waste);
    var ITA2sx = parseFloat(document.occ.sheetx1.value) / 1000;
    var ITA2sy = parseFloat(document.occ.sheety1.value) / 1000;
    var ITA2ark_sqm = ITA2sx * ITA2sy;
    ITA2setup = parseFloat(document.occ.awers2_setup.value);
    ITA2speed = parseFloat(document.occ.awers2_speed.value);
    var ITA2idleNarzadP = parseFloat(document.occ.awers2_idle_narzadP.value);
    var ITA2idleJazdaP = parseFloat(document.occ.awers2_idle_jazdaP.value);
    var ITA2idleCostH = parseFloat(document.occ.awers2_idle_costH.value);
    var ITA2minimum_cost = parseFloat(document.occ.cost_minimum.value);
    var print2_type = document.getElementById("print_type_rewers").checked;

    var ITA2machine = parseFloat(document.occ.print2_machine_id.value);
    var ITA2cost_ink_cmyk = parseFloat(document.occ.cost_ink_cmyk.value);
    var ITA2cost_ink_pms = parseFloat(document.occ.cost_ink_pms.value);
    var ITA2awers_pms_sqmm = parseFloat(document.occ.awers2_pms_sqmm.value) / 100;
    if (isNaN(ITA2awers_pms_sqmm)) {
      ITA2awers_pms_sqmm = 0;
    }
    var ITA2rewers_pms_sqmm = parseFloat(document.occ.rewers2_pms_sqmm.value) / 100;
    if (isNaN(ITA2rewers_pms_sqmm)) {
      ITA2rewers_pms_sqmm = 0;
    }
    var ITA2ink_use = parseFloat(document.occ.use_ink.value);
    ITA2a_c = parseFloat(document.occ.awers2_cmyk_qty_colors.value);
    if (isNaN(ITA2a_c)) {
      ITA2a_c = 0;
    }
    ITA2a_p = parseFloat(document.occ.awers2_pms_qty_colors.value);
    if (isNaN(ITA2a_p)) {
      ITA2a_p = 0;
    }
    ITA2r_c = parseFloat(document.occ.rewers2_cmyk_qty_colors.value);
    if (isNaN(ITA2r_c)) {
      ITA2r_c = 0;
    }
    ITA2r_p = parseFloat(document.occ.rewers2_pms_qty_colors.value);
    if (isNaN(ITA2r_p)) {
      ITA2r_p = 0;
    }
    var ITA2cliche_cost = parseFloat(document.occ.cliche_cost.value);
    if (isNaN(ITA2cliche_cost)) {
      ITA2cliche_cost = 0;
    }

    document.occ.cliche_cost.value = parseFloat(ITA2cliche_cost).toFixed(2);
    document.occ.cost_clicha_extra.value = parseFloat(ITA2cliche_cost).toFixed(2);
    var ITA2clicha_extra_komori = 0;
    if (ITA2machine === 1) {
      var ITA2cliche_cost = parseFloat(document.occ.cost_plate1.value);
      var ITA2cost_machin = parseFloat(document.occ.cost_print1.value);
      var ITA2cost_machinN = parseFloat(document.occ.cost_printN1.value);
      if (document.occ.varnish2_type_id.value) {
        var ITA2clicha_extra_komori = 1;
      }
    } else {
      var ITA2cliche_cost = parseFloat(document.occ.cost_plate2.value);
      var ITA2cost_machin = parseFloat(document.occ.cost_print2.value);
      var ITA2cost_machinN = parseFloat(document.occ.cost_printN2.value);
    }
    if (isNaN(ITA2cost_machinN)) {
      ITA2cost_machinN = 0;
    }

    ///licze awers materiał
    var ITA2cost_a_m = 0;
    var ITA2cost_a_clich_new = 0;
    if ((ITA2a_c > 0) || (ITA2a_p > 0)) {
      var ITA2cost_a_m = (ITA2a_c * (ITA2ark * ITA2ark_sqm) * ITA2ink_use * ITA2cost_ink_cmyk) + (ITA2a_p * ITA2awers_pms_sqmm * (ITA2ark * ITA2ark_sqm) * ITA2ink_use * ITA2cost_ink_pms); ////  kolorów * sqm * kg/sqm  * PLN/kg
      document.occ.cost_awers2_material_info.value = '(' + ITA2a_c + ' * (' + parseFloat(ITA2ark).toFixed(2) + '*' + parseFloat(ITA2ark_sqm).toFixed(2) + ')*' + ITA2ink_use + ' * ' + ITA2cost_ink_cmyk + ') + (' + ITA2a_p + '*' + ITA2awers_pms_sqmm + '* (' + parseFloat(ITA2ark).toFixed(2) + '*' + parseFloat(ITA2ark_sqm).toFixed(2) + ')*' + ITA2ink_use + ' * ' + ITA2cost_ink_pms + ') = ' + ITA2cost_a_m;
      document.occ.cost_awers2_material.value = parseFloat(ITA2cost_a_m).toFixed(2);

      ///var ITA2cost_a_clich_new = (ITA2a_c + ITA2a_p + ITA2clicha_extra_komori) * ITA2cliche_cost;
      var ITA2cost_a_clich_new = ITA2cliche_cost; ///koszt jest na zlecenie
      document.occ.cost_awers2_material_clicha_info.value = '(ilość kolorów CMYK + pantone + lakier)*koszt = (' + ITA2a_c + ' + ' + ITA2a_p + ' + ' + ITA2clicha_extra_komori + ') * ' + ITA2cliche_cost + ' = ' + ITA2cost_a_clich_new;
      document.occ.cost_awers2_material_clicha.value = parseFloat(ITA2cost_a_clich_new).toFixed(2);
    } else {
      document.occ.cost_awers2_material.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers2_material_info.value = '';
      document.occ.cost_awers2_material_clicha.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers2_material_clicha_info.value = '';
    }

    //koszt rwers materiału
    var ITA2cost_r_m = 0;
    var ITA2cost_r_clich_new = 0;
    if ((ITA2r_c > 0) || (ITA2r_p > 0)) {
      var ITA2cost_r_m = (ITA2r_c * (ITA2ark * ITA2ark_sqm) * ITA2ink_use * ITA2cost_ink_cmyk) + (ITA2r_p * ITA2rewers_pms_sqmm * (ITA2ark * ITA2ark_sqm) * ITA2ink_use * ITA2cost_ink_pms); ////  kolorów * sqm * kg/sqm  * PLN/kg
      document.occ.cost_rewers2_material_info.value = '(' + ITA2r_c + ' * (' + parseFloat(ITA2ark).toFixed(2) + '*' + parseFloat(ITA2ark_sqm).toFixed(2) + ')*' + ITA2ink_use + ' * ' + ITA2cost_ink_cmyk + ') + (' + ITA2r_p + '*' + ITA2rewers_pms_sqmm + '* (' + parseFloat(ITA2ark).toFixed(2) + '*' + parseFloat(ITA2ark_sqm).toFixed(2) + ')*' + ITA2ink_use + ' * ' + ITA2cost_ink_pms + ') = ' + ITA2cost_r_m;
      document.occ.cost_rewers2_material.value = parseFloat(ITA2cost_r_m).toFixed(2);

      var ITA2cost_r_clich_new = (ITA2r_c + ITA2r_p + ITA2clicha_extra_komori) * ITA2cliche_cost;
      document.occ.cost_rewers2_material_clicha_info.value = '(ilość kolorów CMYK + pantone + lakier)*koszt = (' + ITA2r_c + ' + ' + ITA2r_p + ' + ' + ITA2clicha_extra_komori + ') * ' + ITA2cliche_cost + ' = ' + ITA2cost_r_clich_new;
      document.occ.cost_rewers2_material_clicha.value = parseFloat(ITA2cost_r_clich_new).toFixed(2);
      if (print2_type === true) { ///odwracanie - nie licze blach 2
        var ITA2cost_r_clich_new = 0;
        document.occ.cost_rewers2_material_clicha_info.value = 'brak kosztu, aktywan opcja obracanie';
        document.occ.cost_rewers2_material_clicha.value = parseFloat(ITA2cost_r_clich_new).toFixed(2);
      }
    } else {
      document.occ.cost_rewers2_material.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers2_material_info.value = '';
      document.occ.cost_rewers2_material_clicha.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers2_material_clicha_info.value = '';
    }

    //licze czas pracy
    var ITA2cost_a_time = 0;
    if ((ITA2a_c > 0) || (ITA2a_p > 0)) {
      var cost_awers2_narzad = ITA2setup * ITA2cost_machinN;
      printingSetupTime_awers2 = ITA2setup;
      document.occ.cost_awers2_narzad_real.value = parseFloat(cost_awers2_narzad).toFixed(2);
      document.occ.cost_awers2_narzad_info.value = 'czas narządu * koszt pracy NARZAD= ' + ITA2setup + ' * ' + ITA2cost_machinN;
      var cost_awers2_time = ITA2ark / ITA2speed;
      printingRunTime_awers2 = ITA2ark / ITA2speed;
      document.occ.awers2_prod_time.value = parseFloat(cost_awers2_time).toFixed(2);
      var cost_awers2_jazda = cost_awers2_time * ITA2cost_machin;

      if ((isNaN(cost_awers2_jazda)) || (ITA2speed === 0)) {
        cost_awers2_jazda = 0;
        printingRunTime_awers2=0;
      }
      document.occ.cost_awers2_jazda_real.value = parseFloat(cost_awers2_jazda).toFixed(2);
      document.occ.cost_awers2_jazda_info.value = '(nakład [ark]/wydajność) * koszt pracy = (' + parseFloat(ITA2ark).toFixed(2) + '/' + ITA2speed + ') * ' + ITA2cost_machin;
      printingIdleTime_awers2 = (ITA2setup * ITA2idleNarzadP / 100) + ((ITA2ark / ITA2speed) * ITA2idleJazdaP / 100);
      var cost_awers2_idle = ((ITA2setup * ITA2idleNarzadP / 100) + ((ITA2ark / ITA2speed) * ITA2idleJazdaP / 100)) * ITA2idleCostH;
      if ((isNaN(cost_awers2_idle)) || (ITA2speed === 0)) {
        cost_awers2_idle = 0;
        printingIdleTime_awers2=0;
      }
      document.occ.cost_awers2_idle_real.value = parseFloat(cost_awers2_idle).toFixed(2);
      document.occ.cost_awers2_idle_info.value = '((czas narządu * %IDLE narząd) + (czas jazdy * %IDLE jazda)) * koszt IDLE/h = ((' + parseFloat(ITA2setup).toFixed(2) + ' * ' + ITA2idleNarzadP + '/100) + (' + parseFloat(ITA2ark / ITA2speed).toFixed(2) + ' * ' + ITA2idleJazdaP + '/100)) * ' + ITA2idleCostH;
      var ITA2cost_a_time = cost_awers2_narzad + cost_awers2_jazda + cost_awers2_idle;
      document.occ.cost_awers2_info.value = 'koszt narządu + koszt jazdy + koszt IDLE = ' + parseFloat(cost_awers2_narzad).toFixed(2) + ' + ' + parseFloat(cost_awers2_jazda).toFixed(2) + ' + ' + parseFloat(cost_awers2_idle).toFixed(2);
      document.occ.cost_awers2.value = parseFloat(ITA2cost_a_time).toFixed(2);
      document.occ.cost_awers2_real.value = parseFloat(ITA2cost_a_time).toFixed(2);
    } else {
      document.occ.cost_awers2.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers2_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers2_info.value = '';
      document.occ.cost_awers2_narzad_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers2_narzad_info.value = '';
      document.occ.cost_awers2_jazda_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers2_jazda_info.value = '';
      document.occ.cost_awers2_idle_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers2_idle_info.value = '';
      document.occ.awers2_prod_time.value = parseFloat(0).toFixed(2);
    }

    var ITA2cost_r_time = 0;
    if ((ITA2r_c > 0) || (ITA2r_p > 0)) {
      var cost_rewers2_narzad = 0;

      if (print2_type === true) { ///odwracanie - nie licze blach 2
        cost_rewers2_narzad = 0;
        printingSetupTime_rewers2 = 0;
        document.occ.cost_rewers2_narzad_info.value = 'brak narządu, aktywna opcja obracanie';
      } else {
        cost_rewers2_narzad = ITA2setup * ITA2cost_machinN;
        printingSetupTime_rewers2 = ITA2setup;
        document.occ.cost_rewers2_narzad_info.value = 'czas narządu * koszt pracy NARZĄD= ' + ITA2setup + ' * ' + ITA2cost_machinN;
      }
      document.occ.cost_rewers2_narzad_real.value = parseFloat(cost_rewers2_narzad).toFixed(2);

      var cost_rewers2_time = ITA2ark / ITA2speed;
      printingRunTime_rewers2= ITA2ark / ITA2speed;
      document.occ.rewers2_prod_time.value = parseFloat(cost_rewers2_time).toFixed(2);
      var cost_rewers2_jazda = cost_rewers2_time * ITA2cost_machin;
      if ((isNaN(cost_rewers2_jazda)) || (ITA2speed === 0)) {
        cost_rewers2_jazda = 0;
        printingRunTime_rewers2 = 0
      }
      document.occ.cost_rewers2_jazda_real.value = parseFloat(cost_rewers2_jazda).toFixed(2);
      document.occ.cost_rewers2_jazda_info.value = '(nakład [ark]/wydajność) * koszt pracy = (' + parseFloat(ITA2ark).toFixed(2) + '/' + ITA2speed + ') * ' + ITA2cost_machin;
      printingIdleTime_rewers2 = (ITA2setup * ITA2idleNarzadP / 100) + ((ITA2ark / ITA2speed) * ITA2idleJazdaP / 100);
      var cost_rewers2_idle = ((ITA2setup * ITA2idleNarzadP / 100) + ((ITA2ark / ITA2speed) * ITA2idleJazdaP / 100)) * ITA2idleCostH;

      if ((isNaN(cost_rewers2_idle)) || (ITA2speed === 0)) {
        cost_rewers2_idle = 0;
        printingIdleTime_rewers2 =0;
      }
      document.occ.cost_rewers2_idle_real.value = parseFloat(cost_rewers2_idle).toFixed(2);
      document.occ.cost_rewers2_idle_info.value = '((czas narządu * %IDLE narząd) + (czas jazdy * %IDLE jazda)) * koszt IDLE/h = ((' + parseFloat(ITA2setup).toFixed(2) + ' * ' + ITA2idleNarzadP + '/100) + (' + parseFloat(ITA2ark / ITA2speed).toFixed(2) + ' * ' + ITA2idleJazdaP + '/100)) * ' + ITA2idleCostH;
      var ITA2cost_r_time = cost_rewers2_narzad + cost_rewers2_jazda + cost_rewers2_idle;
      document.occ.cost_rewers2_info.value = 'koszt narządu + koszt jazdy + koszt IDLE = ' + parseFloat(cost_rewers2_narzad).toFixed(2) + ' + ' + parseFloat(cost_rewers2_jazda).toFixed(2) + ' + ' + parseFloat(cost_rewers2_idle).toFixed(2);
      document.occ.cost_rewers2.value = parseFloat(ITA2cost_r_time).toFixed(2);
      document.occ.cost_rewers2_real.value = parseFloat(ITA2cost_r_time).toFixed(2);
    } else {
      document.occ.cost_rewers2.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers2_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers2_info.value = '';
      document.occ.cost_rewers2_narzad_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers2_narzad_info.value = '';
      document.occ.cost_rewers2_jazda_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers2_jazda_info.value = '';
      document.occ.cost_rewers2_idle_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers2_idle_info.value = '';
      document.occ.rewers2_prod_time.value = parseFloat(0).toFixed(2);
    }
    var ITA2total_cost = ITA2cost_r_time + ITA2cost_a_time;
    if ((ITA2total_cost > 0) && (ITA2total_cost < ITA2minimum_cost)) {
      if (ITA2cost_r_time > 0) {
        var ITA2roznica = (ITA2minimum_cost - ITA2total_cost) / 2;
        document.occ.cost_awers2.value = parseFloat(ITA2cost_a_time + ITA2roznica).toFixed(2);
        document.occ.cost_rewers2.value = parseFloat(ITA2cost_r_time + ITA2roznica).toFixed(2);
      } else {
        document.occ.cost_awers2.value = parseFloat(ITA2minimum_cost).toFixed(2);
      }
      //ITA2total_cost  = ITA2minimum_cost;
    }

    ///extra płyty
    setTimeout(count_extra_plate2, TimeOut);
  }

  function count_extra_plate2() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var EP2komori_qty = parseFloat(document.occ.extra_plate2_komori.value);
    if (isNaN(EP2komori_qty)) {
      EP2komori_qty = 0;
    }

    var EP2komori_cost = parseFloat(document.occ.cost_plate1.value);
    if (isNaN(EP2komori_cost)) {
      EP2komori_cost = 0;
    }

    var EP2cost_extra = (EP2komori_cost * EP2komori_qty)
    document.occ.cost_extra_plate2.value = parseFloat(EP2cost_extra).toFixed(2);
    document.occ.cost_extra_plate2_info.value = '(koszt płyty Komori * ilość extra płyt) = (' + EP2komori_cost + '*' + EP2komori_qty + ') = ' + EP2cost_extra;

    setTimeout(count_varnish2_cost1, TimeOut);
  }

  function count_varnish2_cost1() { // lakierowniae koszt operacyjny
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    //var C2V1minimum_cost    = parseFloat(document.occ.cost_minimum.value);
    var C2V1minimum_mnoznik = parseFloat(document.occ.cost_minimum_mnoznik.value);

    var C2V1cost_o_varnish = 0;
    var C2V1varnish_type_id = document.occ.varnish2_type_id.value;
    if (C2V1varnish_type_id === "") {
      document.occ.cost_varnish2.value = parseFloat(0).toFixed(2);
      document.occ.cost_varnish2_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_varnish2_jazda_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_varnish2_info.value = '';
      document.occ.cost_varnish2_jazda_info.value = '';
      document.occ.cost_varnish2_jazda_time.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  C2V1xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  C2V1xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      C2V1xmlhttp.onreadystatechange = function() {
        if (C2V1xmlhttp.readyState === 4 && C2V1xmlhttp.status === 200) {
          var C2V1cost_varnish = C2V1xmlhttp.responseText; ////wartość speed_cost_minimum
          var C2V1cost_varnish_arr = C2V1cost_varnish.split('_');
          var C2V1cost_varnish_speed = C2V1cost_varnish_arr[0] * 1;
          var C2V1cost_varnish_cost = C2V1cost_varnish_arr[1] * 1;
          var C2V1cost_varnish_min = C2V1cost_varnish_arr[2] * 1 * C2V1minimum_mnoznik;
          var C2V1nesting = parseFloat(document.occ.product_paper_value1.value);
          var C2V1order_qty = parseFloat(document.occ.order_qty1_less.value);
          var C2V1cost_varnish_time = parseFloat((C2V1order_qty / C2V1nesting) / C2V1cost_varnish_speed);
          document.occ.cost_varnish2_jazda_time.value = parseFloat(C2V1cost_varnish_time).toFixed(2);
          var C2V1cost_varnish = parseFloat(C2V1cost_varnish_time * C2V1cost_varnish_cost);
          document.occ.cost_varnish2_real.value = parseFloat(C2V1cost_varnish).toFixed(2);
          document.occ.cost_varnish2_jazda_real.value = parseFloat(C2V1cost_varnish).toFixed(2);
          document.occ.cost_varnish2_info.value = '(nakład arkuszy)/wydajność * cena pracy = (' + C2V1order_qty + ' / ' + C2V1nesting + ' )/ ' + C2V1cost_varnish_speed + ' * ' + C2V1cost_varnish_cost;
          document.occ.cost_varnish2_jazda_info.value = '(nakład arkuszy)/wydajność * cena pracy = (' + C2V1order_qty + ' / ' + C2V1nesting + ' )/ ' + C2V1cost_varnish_speed + ' * ' + C2V1cost_varnish_cost;

          if (isNaN(C2V1cost_varnish)) {
            C2V1cost_varnish = 0;
          }
          if (C2V1cost_varnish < C2V1cost_varnish_min) {
            C2V1cost_varnish = C2V1cost_varnish_min;
          }
          document.occ.cost_varnish2.value = parseFloat(C2V1cost_varnish).toFixed(2);

        } else {
          document.occ.cost_varnish2.value = parseFloat(0).toFixed(2);
          document.occ.cost_varnish2_real.value = parseFloat(0).toFixed(2);
          document.occ.cost_varnish2_info.value = '';
          document.occ.cost_varnish2_jazda_real.value = parseFloat(0).toFixed(2);
          document.occ.cost_varnish2_jazda_info.value = '';
          document.occ.cost_varnish2_jazda_time.value = parseFloat(0).toFixed(2);
        }
      };

      C2V1xmlhttp.open("GET", "order_calculation_create_cost_varnish.php?var_id=" + C2V1varnish_type_id, true);
      C2V1xmlhttp.send();
    }

    var C2V1Mcost_m_varnish = 0;
    var C2V1Mvarnish_type_id = document.occ.varnish2_type_id.value;
    if (C2V1Mvarnish_type_id === "") {
      document.occ.cost_varnish2_material.value = parseFloat(0).toFixed(2);
      document.occ.cost_varnish2_material_info.value = '';
    } else {
      var C2V1Mnesting = document.occ.product_paper_value1.value;
      var C2V1Morder_qty = document.occ.order_qty1_less.value;
      var C2V1Msx = parseFloat(document.occ.sheetx1.value) / 1000;
      var C2V1Msy = parseFloat(document.occ.sheety1.value) / 1000;
      var C2V1Msqm = parseFloat(C2V1Morder_qty / C2V1Mnesting * C2V1Msx * C2V1Msy).toFixed(0);
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  C2V1Mxmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  C2V1Mxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      C2V1Mxmlhttp.onreadystatechange = function() {
        if (C2V1Mxmlhttp.readyState === 4 && C2V1Mxmlhttp.status === 200) {
          var C2V1Mcost_v = C2V1Mxmlhttp.responseText;
          var C2V1Mcost_v_arr = C2V1Mcost_v.split('_');
          var C2V1Mcost_qty_mat = C2V1Mcost_v_arr[0] * 1;
          var C2V1Mcost_cost_mat = C2V1Mcost_v_arr[1] * 1;
          var C2V1Mcost_v = parseFloat(C2V1Msqm / C2V1Mcost_qty_mat * C2V1Mcost_cost_mat);

          if (C2V1Mcost_v > "0") {
            document.occ.cost_varnish2_material.value = parseFloat(C2V1Mcost_v).toFixed(2);
            document.occ.cost_varnish2_material_info.value = '[(powierzchnia lakierowania)/wydajność lakieru] * cena lakieru =[(' + C2V1Morder_qty + '/' + C2V1Mnesting + '*' + C2V1Msx + '*' + C2V1Msy + ')/' + C2V1Mcost_qty_mat + ']*' + C2V1Mcost_cost_mat;
          } else {
            document.occ.cost_varnish2_material.value = parseFloat(0).toFixed(2);
            document.occ.cost_varnish2_material_info.value = '';
          }
        }
      };

      C2V1Mxmlhttp.open("GET", "order_calculation_create_cost_varnish_material.php?var_id=" + C2V1Mvarnish_type_id + "&sqm=" + C2V1Msqm, true);
      C2V1Mxmlhttp.send();
    }
    setTimeout(count_cost_awers, TimeOut);
  }


  function count_cost_awers() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var printingMachineID = parseFloat(document.occ.print_machine_id.value);// get printing machine_id

/* START of retrieving pritning SetupTime data */
    var A1_1qty = parseFloat(document.occ.order_qty1_less.value); // get order qty
    var A1_1nest = parseFloat(document.occ.product_paper_value1.value); // get number of ups on sheet
    totalWastePercent = parseFloat(document.occ.waste_proc1.value); // get waste percentage for the given order qty
    totalWastePercent = +totalWastePercent.toFixed(2); // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
    //var A1_2order_a = 0;
    var sheetQty_Awers = 0;

    qtyToProduce = parseFloat(document.occ.order_qty1_less.value); // get order qty
    orderNesting = parseFloat(document.occ.product_paper_value1.value); // get number of ups on sheet
    sheetQtyToProduce = qtyToProduce / orderNesting; // calculate total ordered sheets
    totalWasteSheets = sheetQtyToProduce * totalWastePercent;



    // get value of standard machine colors - in most cases 4
    standardQtyColor = parseFloat(document.occ.standardQtyColor.value);
      if (isNaN(standardQtyColor)) {standardQtyColor = 0;} // zero out variable if NaN
    // get value of
    standardQtyColorTimeC = parseFloat(document.occ.standardQtyColorTimeC.value);
      if (isNaN(standardQtyColorTimeC)) {standardQtyColorTimeC = 0;} // zero out variable if NaN

    // check whether there are extra plates meaning there will be additional setups and sheet qty per setup will be less than order sheet qty
    if (extra_plate>0){ // there are additional setups

        if ((extra_plate/standardQtyColor)<1) { // if only 1 to 3 additional plateshave been entered means one additional setup
          additionalSetups=1;
        } else { // if more than four plates continue calculations
          additionalSetups = Math.round((extra_plate/standardQtyColor)); // count number of addtiional setups
        }

        sheetsEachSetup = Math.round((sheetQtyToProduce / (1+additionalSetups)) + additionalSheetsForEachExtraPlate); // get number of sheets per each extra setup
        sheetQty_Awers = Math.round(sheetsEachSetup + additionalSheetsForEachExtraPlate); // calculate number of shets needed for a multisetup order including waste. Note  A1_2waste / 100 does not include reducec sheets qty

    } else { // no additional setups
      sheetQty_Awers = Math.round(sheetQtyToProduce + totalWasteSheets); // calculate number of shets needed for an order including waste
      //sheetQty_Awers = parseFloat(A1_2order_a).toFixed(0); // round up
    }


    // var A1_1order_ark = parseFloat(A1_1qty / A1_1nest).toFixed(0);

    //korzystam z  parseFloat(document.occ.waste_proc1.value);
    //if (A1_1order_ark === "") {
    //    document.occ.awers_wasteP.value = parseFloat(1).toFixed(2);;
    //} else {
    //    if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
    //        A1_1xmlhttp = new XMLHttpRequest();
    //    } else { // code for IE6, IE5
    //        A1_1xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
    //    }
    //    A1_1xmlhttp.onreadystatechange = function() {
    //        if (A1_1xmlhttp.readyState === 4 && A1_1xmlhttp.status === 200) {
    //            var A1_1data_value = A1_1xmlhttp.responseText;
    //            var A1_1data_value = A1_1data_value * "1";
    //            if (A1_1data_value > "0") {
    //               document.occ.awers_wasteP.value = A1_1data_value;
    //             } else {
    //               document.occ.awers_wasteP.value = parseFloat(1).toFixed(2);
    //            }
    //        }
    //    }
    //    A1_1xmlhttp.open("GET","order_calculation_create_awers_waste.php?var_id="+printingMachineID+"&order_ark="+A1_1order_ark,true);  A1_1xmlhttp.send();
    //}




    if (sheetQty_Awers === "") {
      document.occ.awers_setup.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  A1_2xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  A1_2xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      A1_2xmlhttp.onreadystatechange = function() {
        if (A1_2xmlhttp.readyState === 4 && A1_2xmlhttp.status === 200) {
          var A1_2data_value = A1_2xmlhttp.responseText;
          var A1_2data_value = A1_2data_value * "1";
          if (A1_2data_value > "0") {
            document.occ.awers_setup.value = A1_2data_value;
          } else {
            document.occ.awers_setup.value = parseFloat(0).toFixed(2);
          }
        }
      };

      A1_2xmlhttp.open("GET", "order_calculation_create_awers_setup.php?var_id=" + printingMachineID + "&order_ark=" + sheetQty_Awers, true);
      A1_2xmlhttp.send();
    }
/* END of retrieving pritning SetupTime data */

    //var A1_3waste = parseFloat(document.occ.waste_proc1.value);
  //var A1_3order_a = (A1_1qty / A1_1nest) + ((A1_1qty / A1_1nest) * A1_3waste / 100);

/* START of retrieving pritning RunTime sheets per hour qty */
    if (sheetQty_Awers === "") {
      document.occ.awers_speed.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  A1_3xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  A1_3xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      A1_3xmlhttp.onreadystatechange = function() {
        if (A1_3xmlhttp.readyState === 4 && A1_3xmlhttp.status === 200) {
          var A1_3data_value_ = A1_3xmlhttp.responseText;
          var A1_3data_value_arr = A1_3data_value_.split('_');
          var A1_3data_value = A1_3data_value_arr[0] * 1;
          if (A1_3data_value > "0") { // if speed returned from database
              document.occ.awers_speed.value = A1_3data_value; // write into standard field
          } else { // if no speed returned from database
            document.occ.awers_speed.value = parseFloat(0).toFixed(2);
          }
          var A1_3data_narzad = A1_3data_value_arr[1] * 1; /// % narzad
          if (A1_3data_value > "0") {
            document.occ.awers_idle_narzadP.value = A1_3data_narzad;
          } else {
            document.occ.awers_idle_narzadP.value = parseFloat(0).toFixed(2);
          }
          var A1_3data_jazda = A1_3data_value_arr[2] * 1; //% jazda
          if (A1_3data_value > "0") {
            document.occ.awers_idle_jazdaP.value = A1_3data_jazda;
          } else {
            document.occ.awers_idle_jazdaP.value = parseFloat(0).toFixed(2);
          }
          var A1_3data_cost = A1_3data_value_arr[3] * 1; //koszt PLN/h
          if (A1_3data_value > "0") {
            document.occ.awers_idle_costH.value = A1_3data_cost;
          } else {
            document.occ.awers_idle_costH.value = parseFloat(0).toFixed(2);
          }

        }
      };

      A1_3xmlhttp.open("GET", "order_calculation_create_awers_speed.php?var_id=" + printingMachineID + "&order_ark=" + sheetQty_Awers, true);
      A1_3xmlhttp.send();
    }

/* END of retrieving pritning RunTime sheets per hour qty */
    setTimeout(count_cost_ink_total, TimeOut);
  }

  function count_cost_ink_total() { //speed
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var ITAqty = parseFloat(document.occ.order_qty1_less.value);
    var ITAnest = parseFloat(document.occ.product_paper_value1.value);
    var ITAwaste = parseFloat(document.occ.waste_proc1.value); // get waste percentage for printing process
    ITAwaste = +ITAwaste.toFixed(2); // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
    ITAark = ITAqty / ITAnest + (ITAqty / ITAnest * ITAwaste);
    var ITAsx = parseFloat(document.occ.sheetx1.value) / 1000;
    var ITAsy = parseFloat(document.occ.sheety1.value) / 1000;
    var ITAark_sqm = ITAsx * ITAsy;
    ITAsetup = parseFloat(document.occ.awers_setup.value);
    ITAspeed = parseFloat(document.occ.awers_speed.value);
    sheetsPerHourEachSetup = parseFloat(document.occ.awers_speed.value); // get calculated speed in sheetsPerHourEachSetup from awers field
    var ITAidleNarzadP = parseFloat(document.occ.awers_idle_narzadP.value);
    var ITAidleJazdaP = parseFloat(document.occ.awers_idle_jazdaP.value);
    var ITAidleCostH = parseFloat(document.occ.awers_idle_costH.value);
    var ITAminimum_cost = parseFloat(document.occ.cost_minimum.value);
    var print_type = document.getElementById("print_type_rewers").checked;

    var ITAmachine = parseFloat(document.occ.print_machine_id.value);
    var ITAcost_ink_cmyk = parseFloat(document.occ.cost_ink_cmyk.value);
    var ITAcost_ink_pms = parseFloat(document.occ.cost_ink_pms.value);
    var ITAawers_pms_sqmm = parseFloat(document.occ.awers_pms_sqmm.value) / 100;
    if (isNaN(ITAawers_pms_sqmm)) {
      ITAawers_pms_sqmm = 0;
    }
    var ITArewers_pms_sqmm = parseFloat(document.occ.rewers_pms_sqmm.value) / 100;
    if (isNaN(ITArewers_pms_sqmm)) {
      ITArewers_pms_sqmm = 0;
    }
    var ITAink_use = parseFloat(document.occ.use_ink.value);
    ITAa_c = parseFloat(document.occ.awers_cmyk_qty_colors.value);
    if (isNaN(ITAa_c)) {
      ITAa_c = 0;
    }
    ITAa_p = parseFloat(document.occ.awers_pms_qty_colors.value);
    if (isNaN(ITAa_p)) {
      ITAa_p = 0;
    }
    ITAr_c = parseFloat(document.occ.rewers_cmyk_qty_colors.value);
    if (isNaN(ITAr_c)) {
      ITAr_c = 0;
    }
    ITAr_p = parseFloat(document.occ.rewers_pms_qty_colors.value);
    if (isNaN(ITAr_p)) {
      ITAr_p = 0;
    }
    if (document.getElementById("tr_print2_error").style.display === "") { ////musze mieć 2 przejście...
      ITAa_c = ITAa_c - parseFloat(document.occ.awers2_cmyk_qty_colors.value);
      if ((isNaN(ITAa_c)) || (ITAa_c < 0)) {
        ITAa_c = 0;
      }
      ITAa_p = ITAa_p - parseFloat(document.occ.awers2_pms_qty_colors.value);
      if ((isNaN(ITAa_p)) || (ITAa_p < 0)) {
        ITAa_p = 0;
      }
      ITAr_c = ITAr_c - parseFloat(document.occ.rewers2_cmyk_qty_colors.value);
      if ((isNaN(ITAr_c)) || (ITAr_c < 0)) {
        ITAr_c = 0;
      }
      ITAr_p = ITAr_p - parseFloat(document.occ.rewers2_pms_qty_colors.value);
      if ((isNaN(ITAr_p)) || (ITAr_p < 0)) {
        ITAr_p = 0;
      }
    }
    var ITAcliche_cost = parseFloat(document.occ.cliche_cost.value);
    if (isNaN(ITAcliche_cost)) {
      ITAcliche_cost = 0;
    }
    document.occ.cliche_cost.value = parseFloat(ITAcliche_cost).toFixed(2);
    document.occ.cost_clicha_extra.value = parseFloat(ITAcliche_cost).toFixed(2);
    var ITAclicha_extra_komori = 0;
    if (ITAmachine === 1) {
      ITAcliche_cost = parseFloat(document.occ.cost_plate1.value);
      var ITAcost_machin = parseFloat(document.occ.cost_print1.value);
      var ITAcost_machinN = parseFloat(document.occ.cost_printN1.value);
      if (document.occ.varnish_type_id.value) {
        ITAclicha_extra_komori = 1;
      }
    } else {
      ITAcliche_cost = parseFloat(document.occ.cost_plate2.value);
      ITAcost_machin = parseFloat(document.occ.cost_print2.value);
      ITAcost_machinN = parseFloat(document.occ.cost_printN2.value);
    }
    if (isNaN(ITAcost_machinN)) {
      ITAcost_machinN = 0;
    }

    ///licze awers materiał
    var ITAcost_a_m = 0;
    var ITAcost_a_clich_new = 0;
    if ((ITAa_c > 0) || (ITAa_p > 0)) {
      ITAcost_a_m = (ITAa_c * (ITAark * ITAark_sqm) * ITAink_use * ITAcost_ink_cmyk) + (ITAa_p * ITAawers_pms_sqmm * (ITAark * ITAark_sqm) * ITAink_use * ITAcost_ink_pms); ////  kolorów * sqm * kg/sqm  * PLN/kg
      document.occ.cost_awers_material_info.value = '(' + ITAa_c + ' * (' + parseFloat(ITAark).toFixed(2) + '*' + parseFloat(ITAark_sqm).toFixed(2) + ')*' + ITAink_use + ' * ' + ITAcost_ink_cmyk + ') + (' + ITAa_p + '*' + ITAawers_pms_sqmm + '* (' + parseFloat(ITAark).toFixed(2) + '*' + parseFloat(ITAark_sqm).toFixed(2) + ')*' + ITAink_use + ' * ' + ITAcost_ink_pms + ') = ' + parseFloat(ITAcost_a_m).toFixed(2);
      if (isNaN(ITAcost_a_m)) {
        ITAcost_a_m = 0;
      }
      document.occ.cost_awers_material.value = parseFloat(ITAcost_a_m).toFixed(2);

      ITAcost_a_clich_new = (ITAa_c + ITAa_p + ITAclicha_extra_komori) * ITAcliche_cost;
      document.occ.cost_awers_material_clicha_info.value = '(ilość kolorów CMYK + pantone + lakier)*koszt = (' + ITAa_c + ' + ' + ITAa_p + ' + ' + ITAclicha_extra_komori + ') * ' + ITAcliche_cost + ' = ' + ITAcost_a_clich_new;
      document.occ.cost_awers_material_clicha.value = parseFloat(ITAcost_a_clich_new).toFixed(2);
    } else {
      document.occ.cost_awers_material.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers_material_info.value = '';
      document.occ.cost_awers_material_clicha.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers_material_clicha_info.value = '';
    }

    //koszt rwers materiału
    var ITAcost_r_m = 0;
    var ITAcost_r_clich_new = 0;
    if ((ITAr_c > 0) || (ITAr_p > 0)) {
      var ITAcost_r_m = (ITAr_c * (ITAark * ITAark_sqm) * ITAink_use * ITAcost_ink_cmyk) + (ITAr_p * ITArewers_pms_sqmm * (ITAark * ITAark_sqm) * ITAink_use * ITAcost_ink_pms); ////  kolorów * sqm * kg/sqm  * PLN/kg
      document.occ.cost_rewers_material_info.value = '(' + ITAr_c + ' * (' + parseFloat(ITAark).toFixed(2) + '*' + parseFloat(ITAark_sqm).toFixed(2) + ')*' + ITAink_use + ' * ' + ITAcost_ink_cmyk + ') + (' + ITAr_p + '*' + ITArewers_pms_sqmm + '* (' + parseFloat(ITAark).toFixed(2) + '*' + parseFloat(ITAark_sqm).toFixed(2) + ')*' + ITAink_use + ' * ' + ITAcost_ink_pms + ') = ' + parseFloat(ITAcost_r_m).toFixed(2);
      document.occ.cost_rewers_material.value = parseFloat(ITAcost_r_m).toFixed(2);

      var ITAcost_r_clich_new = (ITAr_c + ITAr_p + ITAclicha_extra_komori) * ITAcliche_cost;
      document.occ.cost_rewers_material_clicha_info.value = '(ilość kolorów CMYK + pantone + lakier)*koszt = (' + ITAr_c + ' + ' + ITAr_p + ' + ' + ITAclicha_extra_komori + ') * ' + ITAcliche_cost + ' = ' + ITAcost_r_clich_new;
      document.occ.cost_rewers_material_clicha.value = parseFloat(ITAcost_r_clich_new).toFixed(2);
      if (print_type === true) { ///odwracanie - nie licze blach 2
        var ITAcost_r_clich_new = 0;
        document.occ.cost_rewers_material_clicha_info.value = 'brak kosztu, aktywan opcja obracanie';
        document.occ.cost_rewers_material_clicha.value = parseFloat(ITAcost_r_clich_new).toFixed(2);
      }
    } else {
      document.occ.cost_rewers_material.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers_material_info.value = '';
      document.occ.cost_rewers_material_clicha.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers_material_clicha_info.value = '';
    }

// PRINT SETUP & RUNTIME ON AWERS CALCULATIONS
    //licze czas pracy
    var ITAcost_a_time = 0;
    var cost_awers_time;
    var cost_awers_narzad;
    var cost_awers_jazda;
    var cost_awers_idle;
    var infoString_PrintingAwersSetup;
    var infoString_PrintingAwersRunTime;
    var infoString_PrintingAwersIdle;
    if ((ITAa_c > 0) || (ITAa_p > 0)) { // if there are CMYK or PANTONE colors on awers means there will be setup

      //check for extra plates on Komori
      var extra_plate_komori = parseFloat(document.occ.extra_plate_komori.value);
        if (isNaN(extra_plate_komori)) {extra_plate_komori = 0;} // zero out variable if NaN
      // add up extra plates
      extra_plate = extra_plate_komori; // count number of extra plates

      // if thare are some extra plates alter print setup time calculations
      if (extra_plate > 0) { // if there are extra plates used than add time needed to handle them

        // calculate printing setup time for multiple setups
        var printingSetupTimePerPlate_awers =0;
        printingSetupTimePerPlate_awers = (ITAsetup / standardQtyColor / standardQtyColorTimeC);
        printingSetupTime_awers = Math.round((ITAsetup + (ITAsetup / standardQtyColor / standardQtyColorTimeC * extra_plate))*100)/100;
        printingSetupTime_awers = Math.round((ITAsetup + printingSetupTimePerPlate_awers * extra_plate)*100)/100;
        // calculate printing setup costs for multiple setups
        cost_awers_narzad = printingSetupTime_awers * ITAcost_machinN;

        infoString_PrintingAwersSetup = '(czas narządu + czas extra płyt) * koszt pracy NARZAD= (' + ITAsetup + ' + (' + ITAsetup + '/' + standardQtyColor + '/' + standardQtyColorTimeC + ' * ' + extra_plate + ')) * ' + ITAcost_machinN;

        // calculate awers printing RunTime in case of multiple setups
        //additionalSetups = Math.round((extra_plate/standardQtyColor)); // count number of addtiional setups
        //sheetsEachSetup = Math.round((ITAark / additionalSetups) + additionalSheetsForEachExtraPlate); // get number of sheets per each extra setup

        printingRunTime_awers = Math.round(((1 + additionalSetups) * (sheetsEachSetup / sheetsPerHourEachSetup))*100)/100; // calculate total printing RunTime on awers for all setups (standard + additional) given sheets per setup and speed each setup
        infoString_PrintingAwersRunTime = '(Standardowy narzad + dodatkowe narzady) * (ilosc arkuszy na sklad / wydajnosc na sklad) = ' + '(1 + ' + additionalSetups + ' ) * ( ' + sheetsEachSetup + ' / ' + sheetsPerHourEachSetup + ' )';

        printingIdleTime_awers = (printingSetupTime_awers * ITAidleNarzadP / 100) + (printingRunTime_awers * ITAidleJazdaP / 100); // calculate printing idle time
        cost_awers_idle =  printingIdleTime_awers* ITAidleCostH;

        infoString_PrintingAwersIdle = '((czas narządu * %IDLE narząd) + (czas jazdy * %IDLE jazda)) * koszt IDLE/h = ((' + printingSetupTime_awers + ' * ' + ITAidleNarzadP + '/100) + (' + printingRunTime_awers + ' * ' + ITAidleJazdaP + '/100)) * ' + ITAidleCostH;

      } else { // no extra plates so no extra setups and RunTimes can be calculated based on whole order qty
         printingSetupTime_awers = ITAsetup;
         cost_awers_narzad = printingSetupTime_awers * ITAcost_machinN;   // calculate awers setup time
         printingRunTime_awers = (ITAark / ITAspeed);   // calculate awers RunTime time
         printingIdleTime_awers = (printingSetupTime_awers * ITAidleNarzadP / 100) + (printingRunTime_awers * ITAidleJazdaP / 100); // calculate printing idle time
         cost_awers_idle =  printingIdleTime_awers* ITAidleCostH;
         if ((isNaN(cost_awers_idle)) || (ITAspeed === 0)) {cost_awers_idle = 0;}

         infoString_PrintingAwersSetup = 'czas narządu * koszt pracy NARZAD= ' + ITAsetup + ' * ' + ITAcost_machinN;
         infoString_PrintingAwersRunTime = '(nakład [ark]/wydajność) * koszt pracy = (' + parseFloat(ITAark).toFixed(2) + '/' + ITAspeed + ') * ' + ITAcost_machin;
         infoString_PrintingAwersIdle = '((czas narządu * %IDLE narząd) + (czas jazdy * %IDLE jazda)) * koszt IDLE/h = ((' + parseFloat(ITAsetup).toFixed(2) + ' * ' + ITAidleNarzadP + '/100) + (' + parseFloat(ITAark / ITAspeed).toFixed(2) + ' * ' + ITAidleJazdaP + '/100)) * ' + ITAidleCostH;
      }
      // write data in fields
      document.occ.cost_awers_narzad_info.value = infoString_PrintingAwersSetup;
      document.occ.cost_awers_jazda_info.value = infoString_PrintingAwersRunTime;
      document.occ.cost_awers_idle_info.value = infoString_PrintingAwersIdle;
      document.occ.cost_awers_narzad_real.value = parseFloat(cost_awers_narzad).toFixed(2);
      document.occ.awers_prod_time.value = parseFloat(printingRunTime_awers).toFixed(2);

      //calculate total printing RunTime costs on awers
      cost_awers_jazda = printingRunTime_awers * ITAcost_machin;
      if ((isNaN(cost_awers_jazda)) || (ITAspeed === 0)) {cost_awers_jazda = 0;}

      document.occ.cost_awers_jazda_real.value = parseFloat(cost_awers_jazda).toFixed(2);
      //calculate total printing costs on awers
      ITAcost_a_time = cost_awers_narzad + cost_awers_jazda + cost_awers_idle;
      document.occ.cost_awers_info.value = 'koszt narządu + koszt jazdy + koszt IDLE = ' + parseFloat(cost_awers_narzad).toFixed(2) + ' + ' + parseFloat(cost_awers_jazda).toFixed(2) + ' + ' + parseFloat(cost_awers_idle).toFixed(2);
      document.occ.cost_awers.value = parseFloat(ITAcost_a_time).toFixed(2);
      document.occ.cost_awers_real.value = parseFloat(ITAcost_a_time).toFixed(2);

    } else { // if there are no CMYK or PANTONE colors on awers means there will be NO setup
      document.occ.cost_awers.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers_info.value = '';
      document.occ.cost_awers_narzad_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers_narzad_info.value = '';
      document.occ.cost_awers_jazda_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers_jazda_info.value = '';
      document.occ.cost_awers_idle_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_awers_idle_info.value = '';
      document.occ.awers_prod_time.value = parseFloat(0).toFixed(2);
    }

// PRINT ON REWERS CALCULATIONS
    var ITAcost_r_time = 0;
    if ((ITAr_c > 0) || (ITAr_p > 0)) { // if there are CMYK or PANTONE colors on rewers
      var cost_rewers_narzad = ITAsetup * ITAcost_machinN;
      printingSetupTime_rewers = ITAsetup;
      document.occ.cost_rewers_narzad_real.value = parseFloat(cost_rewers_narzad).toFixed(2);
      document.occ.cost_rewers_narzad_info.value = 'czas narządu * koszt pracy NARZĄD= ' + ITAsetup + ' * ' + ITAcost_machinN;
      if (print_type === true) { ///odwracanie - nie licze blach 2
        cost_rewers_narzad = 0;
        document.occ.cost_rewers_narzad_real.value = parseFloat(cost_rewers_narzad).toFixed(2);
        document.occ.cost_rewers_narzad_info.value = 'brak narządu, aktywna opcja obracanie';
      }
      var cost_rewers_time = (ITAark / ITAspeed);
      printingRunTime_rewers = (ITAark / ITAspeed);
      document.occ.rewers_prod_time.value = parseFloat(cost_rewers_time).toFixed(2);
      var cost_rewers_jazda = cost_rewers_time * ITAcost_machin;
      if ((isNaN(cost_rewers_jazda)) || (ITAspeed === 0)) {
        cost_rewers_jazda = 0;
      }
      document.occ.cost_rewers_jazda_real.value = parseFloat(cost_rewers_jazda).toFixed(2);
      document.occ.cost_rewers_jazda_info.value = '(nakład [ark]/wydajność) * koszt pracy = (' + parseFloat(ITAark).toFixed(2) + '/' + ITAspeed + ') * ' + ITAcost_machin;
      var cost_rewers_idle = ((ITAsetup * ITAidleNarzadP / 100) + ((ITAark / ITAspeed) * ITAidleJazdaP / 100)) * ITAidleCostH;
      printingIdleTime_rewers = ITAsetup * (ITAidleNarzadP / 100) + (ITAark / ITAspeed) * (ITAidleJazdaP / 100);
      if ((isNaN(cost_rewers_idle)) || (ITAspeed === 0)) {
        cost_rewers_idle = 0;
      }
      document.occ.cost_rewers_idle_real.value = parseFloat(cost_rewers_idle).toFixed(2);
      document.occ.cost_rewers_idle_info.value = '((czas narządu * %IDLE narząd) + (czas jazdy * %IDLE jazda)) * koszt IDLE/h = ((' + parseFloat(ITAsetup).toFixed(2) + ' * ' + ITAidleNarzadP + '/100) + (' + parseFloat(ITAark / ITAspeed).toFixed(2) + ' * ' + ITAidleJazdaP + '/100)) * ' + ITAidleCostH;
      ITAcost_r_time = cost_rewers_narzad + cost_rewers_jazda + cost_rewers_idle;
      document.occ.cost_rewers_info.value = 'koszt narządu + koszt jazdy + koszt IDLE = ' + parseFloat(cost_rewers_narzad).toFixed(2) + ' + ' + parseFloat(cost_rewers_jazda).toFixed(2) + ' + ' + parseFloat(cost_rewers_idle).toFixed(2);
      document.occ.cost_rewers.value = parseFloat(ITAcost_r_time).toFixed(2);
      document.occ.cost_rewers_real.value = parseFloat(ITAcost_r_time).toFixed(2);
    } else {
      document.occ.cost_rewers.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers_info.value = '';
      document.occ.cost_rewers_narzad_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers_narzad_info.value = '';
      document.occ.cost_rewers_jazda_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers_jazda_info.value = '';
      document.occ.cost_rewers_idle_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_rewers_idle_info.value = '';
      document.occ.rewers_prod_time.value = parseFloat(0).toFixed(2);
    }
    var ITAtotal_cost = ITAcost_r_time + ITAcost_a_time;

    if ((ITAtotal_cost > 0) && (ITAtotal_cost < ITAminimum_cost)) {
      if (ITAcost_r_time > 0) {
        var ITAroznica = (ITAminimum_cost - ITAtotal_cost) / 2;
        document.occ.cost_awers.value = parseFloat(ITAcost_a_time + ITAroznica).toFixed(2);
        document.occ.cost_rewers.value = parseFloat(ITAcost_r_time + ITAroznica).toFixed(2);
      } else {
        document.occ.cost_awers.value = parseFloat(ITAminimum_cost).toFixed(2);
      }
      //ITAtotal_cost  = ITAminimum_cost;
    }
    //var cost_r_t_o = cost_total_o - cost_a_old - cost_r_old + total_cost;
    //document.occ.cost_total_operation.value = parseFloat(cost_r_t_o).toFixed(2);
    //document.occ.cost_total_operation2.value = parseFloat(cost_r_t_o).toFixed(2);

    ///extra płyty
    setTimeout(count_extra_plate, TimeOut);
  }

  function count_extra_plate() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var EPkomori_qty = parseFloat(document.occ.extra_plate_komori.value);
    if (isNaN(EPkomori_qty)) {
      EPkomori_qty = 0;
    }

    var EPkomori_cost = parseFloat(document.occ.cost_plate1.value);
    if (isNaN(EPkomori_cost)) {
      EPkomori_cost = 0;
    }

    var EPcost_extra = (EPkomori_cost * EPkomori_qty);
    document.occ.cost_extra_plate.value = parseFloat(EPcost_extra).toFixed(2);
    document.occ.cost_extra_plate_info.value = '(koszt płyty Komori * ilość extra płyt) = (' + EPkomori_cost + '*' + EPkomori_qty + ') = ' + EPcost_extra;

    setTimeout(count_varnish_cost1, TimeOut);
  }

  function count_varnish_cost1() { // lakierowniae koszt operacyjny
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    //var CV1minimum_cost    = parseFloat(document.occ.cost_minimum.value);
    var CV1minimum_mnoznik = parseFloat(document.occ.cost_minimum_mnoznik.value);

    var CV1cost_o_varnish = 0;
    CV1varnish_type_id = document.occ.varnish_type_id.value;
    if ((CV1varnish_type_id === "") || (document.getElementById("tr_print2_error").style.display === "")) {
      document.occ.cost_varnish.value = parseFloat(0).toFixed(2);
      document.occ.cost_varnish_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_varnish_jazda_real.value = parseFloat(0).toFixed(2);
      document.occ.cost_varnish_info.value = '';
      document.occ.cost_varnish_jazda_info.value = '';
      document.occ.cost_varnish_jazda_time.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  CV1xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  CV1xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      CV1xmlhttp.onreadystatechange = function() {
        if (CV1xmlhttp.readyState === 4 && CV1xmlhttp.status === 200) {
          var CV1cost_varnish = CV1xmlhttp.responseText; ////wartość speed_cost_minimum
          var CV1cost_varnish_arr = CV1cost_varnish.split('_');
          CV1cost_varnish_speed = CV1cost_varnish_arr[0] * 1;
          var CV1cost_varnish_cost = CV1cost_varnish_arr[1] * 1;
          var CV1cost_varnish_min = CV1cost_varnish_arr[2] * 1 * CV1minimum_mnoznik;
          var CV1nesting = parseFloat(document.occ.product_paper_value1.value);
          var CV1order_qty = parseFloat(document.occ.order_qty1_less.value);

          var CV1cost_varnish_time = parseFloat((CV1order_qty / CV1nesting) / CV1cost_varnish_speed);
          document.occ.cost_varnish_jazda_time.value = parseFloat(CV1cost_varnish_time).toFixed(2);

          CV1cost_varnish = parseFloat(CV1cost_varnish_time * CV1cost_varnish_cost);
          document.occ.cost_varnish_real.value = parseFloat(CV1cost_varnish).toFixed(2);
          document.occ.cost_varnish_jazda_real.value = parseFloat(CV1cost_varnish).toFixed(2);
          document.occ.cost_varnish_info.value = '(nakład arkuszy)/wydajność * cena pracy = (' + CV1order_qty + ' / ' + CV1nesting + ' )/ ' + CV1cost_varnish_speed + ' * ' + CV1cost_varnish_cost;
          document.occ.cost_varnish_jazda_info.value = '(nakład arkuszy)/wydajność * cena pracy = (' + CV1order_qty + ' / ' + CV1nesting + ' )/ ' + CV1cost_varnish_speed + ' * ' + CV1cost_varnish_cost;

          if (isNaN(CV1cost_varnish)) {
            CV1cost_varnish = 0;
          }
          if (CV1cost_varnish < CV1cost_varnish_min) {
            CV1cost_varnish = CV1cost_varnish_min;
          }
          document.occ.cost_varnish.value = parseFloat(CV1cost_varnish).toFixed(2);

        } else {
          document.occ.cost_varnish.value = parseFloat(0).toFixed(2);
          document.occ.cost_varnish_real.value = parseFloat(0).toFixed(2);
          document.occ.cost_varnish_info.value = '';
          document.occ.cost_varnish_jazda_real.value = parseFloat(0).toFixed(2);
          document.occ.cost_varnish_jazda_info.value = '';
          document.occ.cost_varnish_jazda_time.value = parseFloat(0).toFixed(2);
        }
      };

      CV1xmlhttp.open("GET", "order_calculation_create_cost_varnish.php?var_id=" + CV1varnish_type_id, true);
      CV1xmlhttp.send();
    }

    var CV1Mcost_m_varnish = 0;
    var CV1Mvarnish_type_id = document.occ.varnish_type_id.value;
    if ((CV1Mvarnish_type_id === "") || (document.getElementById("tr_print2_error").style.display === "")) {
      document.occ.cost_varnish_material.value = parseFloat(0).toFixed(2);
      document.occ.cost_varnish_material_info.value = '';
    } else {
      var CV1Mnesting = document.occ.product_paper_value1.value;
      var CV1Morder_qty = document.occ.order_qty1_less.value;
      var CV1Msx = parseFloat(document.occ.sheetx1.value) / 1000;
      var CV1Msy = parseFloat(document.occ.sheety1.value) / 1000;

      var CV1Msqm = parseFloat(CV1Morder_qty / CV1Mnesting * CV1Msx * CV1Msy).toFixed(0);
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  CV1Mxmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  CV1Mxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      CV1Mxmlhttp.onreadystatechange = function() {
        if (CV1Mxmlhttp.readyState === 4 && CV1Mxmlhttp.status === 200) {
          var CV1Mcost_v = CV1Mxmlhttp.responseText;
          var CV1Mcost_v_arr = CV1Mcost_v.split('_');
          var CV1Mcost_qty_mat = CV1Mcost_v_arr[0] * 1;
          var CV1Mcost_cost_mat = CV1Mcost_v_arr[1] * 1;
          var CV1Mcost_v = parseFloat(CV1Msqm / CV1Mcost_qty_mat * CV1Mcost_cost_mat);

          if (isNaN(CV1Mcost_v)) {
            CV1Mcost_v = 0;
          }
          if (CV1Mcost_v > "0") {
            document.occ.cost_varnish_material.value = parseFloat(CV1Mcost_v).toFixed(2);
            document.occ.cost_varnish_material_info.value = '[(powierzchnia lakierowania)/wydajność lakieru] * cena lakieru =[(' + CV1Morder_qty + '/' + CV1Mnesting + '*' + CV1Msx + '*' + CV1Msy + ')/' + CV1Mcost_qty_mat + ']*' + CV1Mcost_cost_mat;
          } else {
            document.occ.cost_varnish_material.value = parseFloat(0).toFixed(2);
            document.occ.cost_varnish_material_info.value = '';
          }
        }

      };

      CV1Mxmlhttp.open("GET", "order_calculation_create_cost_varnish_material.php?var_id=" + CV1Mvarnish_type_id + "&sqm=" + CV1Msqm, true);
      CV1Mxmlhttp.send();
    }
    setTimeout(count_ink_varnish_cost1(''), TimeOut);
  }

  function count_ink_varnish_cost1(VS1cost_out_typ) { // lakierowniae specjalne
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var IS1type_id = document.occ.ink_varnish_id.value;
    if (IS1type_id) {
      document.getElementById("td_i1").style.display = "";
      document.getElementById("td_i2").style.display = "";
    } else {
      document.getElementById("td_i1").style.display = "none";
      document.getElementById("td_i2").style.display = "none";
      document.occ.ink_varnish_dsc.value = '';
      document.occ.cost_ink_varnish_total.value = '';
      document.occ.cost_ink_varnish_sheet.value = '';
    }

    ///zmiana danych
    //document.occ.cost_ink_varnish_special.value = parseFloat(0).toFixed(2);
    //document.occ.cost_ink_varnish_special_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_ink_varnish_special_out.value = parseFloat(0).toFixed(2);
    document.occ.cost_trans_ink_varnish_special_out.value = parseFloat(0).toFixed(2);
    //document.occ.cost_ink_varnish_total.value = "";
    document.occ.cost_ink_varnish_special_out_info.value = '';
    //document.occ.cost_ink_varnish_sheet.value = "";

    if (VS1cost_out_typ === "cost") {
      var VS2cost_total = parseFloat(document.occ.cost_ink_varnish_total.value);
      document.occ.cost_ink_varnish_sheet.value = "";
      document.occ.cost_ink_varnish_special_out_info.value = 'koszt całości usługi = ' + VS2cost_total;
      document.occ.cost_trans_ink_varnish_special_out.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);

    }
    if (VS1cost_out_typ === "sheet") {
      var VS2qty = parseFloat(document.occ.order_qty1_less.value);
      var VS2cost_sheet = parseFloat(document.occ.cost_ink_varnish_sheet.value);
      if (isNaN(VS2cost_sheet)) {
        VS2cost_sheet = 0;
      }
      var VS2nesting = document.occ.product_paper_value1.value;
      VS2cost_total = (VS2qty / VS2nesting) * VS2cost_sheet;

      document.occ.cost_ink_varnish_total.value = "";
      document.occ.cost_ink_varnish_special_out_info.value = 'koszt wykonania 1 arkusza * ilość arkuszy = ' + VS2cost_sheet + ' * (' + VS2qty + '/' + VS2nesting + ') = ' + VS2cost_total;
      document.occ.cost_trans_ink_varnish_special_out.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
    }
    if (VS1cost_out_typ === "") {
      VS2cost_total = parseFloat(document.occ.cost_ink_varnish_total.value);
      if (VS2cost_total) {
        document.occ.cost_ink_varnish_sheet.value = "";
        document.occ.cost_ink_varnish_special_out_info.value = 'koszt całości usługi = ' + VS2cost_total;
        document.occ.cost_trans_ink_varnish_special_out.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
      } else {
        VS2cost_sheet = parseFloat(document.occ.cost_ink_varnish_sheet.value);
        if (VS2cost_sheet) {
          if (isNaN(VS2cost_sheet)) {
            VS2cost_sheet = 0;
          }
          VS2qty = parseFloat(document.occ.order_qty1_less.value);
          VS2nesting = document.occ.product_paper_value1.value;
          VS2cost_total = (VS2qty / VS2nesting) * VS2cost_sheet;

          document.occ.cost_ink_varnish_total.value = "";
          document.occ.cost_ink_varnish_special_out_info.value = 'koszt wykonania 1 arkusza * ilość arkuszy = ' + VS2cost_sheet + ' * (' + VS2qty + '/' + VS2nesting + ') = ' + VS2cost_total;
          document.occ.cost_trans_ink_varnish_special_out.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
        }
      }
    }

    if (isNaN(VS2cost_total)) {
      VS2cost_total = 0;
    }
    document.occ.cost_ink_varnish_special_out.value = parseFloat(VS2cost_total).toFixed(2);

    setTimeout(count_cost_foil, TimeOut);
  }

  function count_cost_foil() { // lakierowniae specjalne
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    //var FOIminimum_cost    = parseFloat(document.occ.cost_minimum.value);
    document.occ.cost_trans_foil.value = parseFloat(0).toFixed(2);

    var FOIvarnish_f1_id = document.occ.foil_type_id.value;
    if (FOIvarnish_f1_id === "") {
      document.occ.cost_foil.value = parseFloat(0).toFixed(2);
      document.occ.cost_foil_info.value = '';
      document.getElementById("td_f1").style.display = "none";
      document.occ.foil_sqm_ark.value = '';
    } else {
      document.getElementById("td_f1").style.display = "";
      var FOInesting = document.occ.product_paper_value1.value;
      var FOIorder_qty = document.occ.order_qty1_less.value;
      var FOIsqm1 = document.occ.foil_sqm_ark.value;
      if (!FOIsqm1) {
        FOIsqm1 = 0;
      }
      //var FOIsqm       = parseFloat(FOIorder_qty/FOInesting * FOIsqm1).toFixed(0) ;
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  FOIxmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  FOIxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      FOIxmlhttp.onreadystatechange = function() {
        if (FOIxmlhttp.readyState === 4 && FOIxmlhttp.status === 200) {
          var FOIcost_zl_m2 = FOIxmlhttp.responseText;
          var FOIcost_zl_m2 = FOIcost_zl_m2 * "1";
          var FOIcost_foil = ((FOIorder_qty / FOInesting) * FOIsqm1) * FOIcost_zl_m2;
          //if (FOIcost_foil < FOIminimum_cost) { FOIcost_foil = FOIminimum_cost; }
          if (FOIcost_foil > "0") {
            document.occ.cost_foil.value = parseFloat(FOIcost_foil).toFixed(2);
            document.occ.cost_foil_info.value = 'arkusze * powierzchnia * stawka = ((' + FOIorder_qty + '/' + FOInesting + ') * ' + FOIsqm1 + ') * ' + FOIcost_zl_m2;
            document.occ.cost_trans_foil.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
          } else {
            document.occ.cost_foil.value = parseFloat(0).toFixed(2);
            document.occ.cost_foil_info.value = '';
          }
        }
      };

      FOIxmlhttp.open("GET", "order_calculation_create_cost_foil.php?var_id=" + FOIvarnish_f1_id, true);
      FOIxmlhttp.send();
    }

    setTimeout(count_gilding_1(), TimeOut);
  }

  function count_gilding_1() { //szukam danych
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var G1_0speed_id = document.occ.gilding_speed_id1.value;
    if (G1_0speed_id === "") {
      document.occ.gilding1_speed.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G1_0xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G1_0xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G1_0xmlhttp.onreadystatechange = function() {
        if (G1_0xmlhttp.readyState === 4 && G1_0xmlhttp.status === 200) {
          var G1_0cost_v = G1_0xmlhttp.responseText;
          var G1_0cost_v = G1_0cost_v * "1";
          if (G1_0cost_v > "0") {
            document.occ.gilding1_speed.value = G1_0cost_v;
          } else {
            document.occ.gilding1_speed.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G1_0xmlhttp.open("GET", "order_calculation_create_gilding_speed_quality.php?var_id=" + G1_0speed_id + "&name=gilding_quality_speed", true);
      G1_0xmlhttp.send();
    }

    var G1_1type_id = document.occ.gilding_type_id1.value;
    if (G1_1type_id === "") {
      document.occ.gilding1_type_value.value = parseFloat(0).toFixed(2);
      //document.getElementById("tr_g13").rowSpan = 4;
    } else {
      document.getElementById("tr_g13").rowSpan = 15;
      document.getElementById("tr_g2").style.display = "";
      document.getElementById("tr_g3").style.display = "";
      document.getElementById("tr_g4").style.display = "";
      document.getElementById("tr_g5").style.display = "";
      document.getElementById("tr_g6").style.display = "";
      document.getElementById("tr_g7").style.display = "";
      document.getElementById("tr_g8").style.display = "";
      document.getElementById("tr_g9").style.display = "";
      document.getElementById("tr_g10").style.display = "";
      document.getElementById("tr_g11").style.display = "";
      document.getElementById("tr_g12").style.display = "";
      document.getElementById("td_g1").style.display = "";
      document.getElementById("td_g2").style.display = "";
      document.getElementById("td_g3").style.display = "";
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G1_1xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G1_1xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G1_1xmlhttp.onreadystatechange = function() {
        if (G1_1xmlhttp.readyState === 4 && G1_1xmlhttp.status === 200) {
          var G1_1cost_v = G1_1xmlhttp.responseText;
          var G1_1cost_v = G1_1cost_v * "1";
          if (G1_1cost_v > "0") {
            document.occ.gilding1_type_value.value = G1_1cost_v;
          } else {
            document.occ.gilding1_type_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G1_1xmlhttp.open("GET", "order_calculation_create_gilding_speed_type.php?var_id=" + G1_1type_id, true);
      G1_1xmlhttp.send();
    }


    var G1_2type_id2 = document.occ.gilding_jump_id1.value;
    if (G1_2type_id2 === "") {
      document.occ.gilding1_jump_value.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G1_2xmlhttp2 = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G1_2xmlhttp2 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G1_2xmlhttp2.onreadystatechange = function() {
        if (G1_2xmlhttp2.readyState === 4 && G1_2xmlhttp2.status === 200) {
          var G1_2cost_j = G1_2xmlhttp2.responseText;
          var G1_2cost_j = G1_2cost_j * "1";
          if (G1_2cost_j > "0") {
            document.occ.gilding1_jump_value.value = G1_2cost_j;
          } else {
            document.occ.gilding1_jump_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G1_2xmlhttp2.open("GET", "order_calculation_create_gilding_speed_jump.php?var_id=" + G1_2type_id2, true);
      G1_2xmlhttp2.send();
    }


    var G1_3type_id3 = document.occ.gilding_sqmm_id1.value;
    if (G1_3type_id3 === "") {
      document.occ.gilding1_sqm_value.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G1_3xmlhttp3 = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G1_3xmlhttp3 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G1_3xmlhttp3.onreadystatechange = function() {
        if (G1_3xmlhttp3.readyState === 4 && G1_3xmlhttp3.status === 200) {
          var G1_3cost_s = G1_3xmlhttp3.responseText;
          var G1_3cost_s = G1_3cost_s * "1";
          if (G1_3cost_s > "0") {
            document.occ.gilding1_sqm_value.value = G1_3cost_s;
          } else {
            document.occ.gilding1_sqm_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G1_3xmlhttp3.open("GET", "order_calculation_create_gilding_speed_sqmm.php?var_id=" + G1_3type_id3, true);
      G1_3xmlhttp3.send();
    }

    var G1_4type_id4 = document.occ.paper_type_id1.value;
    if (G1_4type_id4 === "") {
      document.occ.gilding1_speed_value.value = parseFloat(0).toFixed(2);
      document.getElementById("gilding_error").style.display = "";
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G1_4xmlhttp4 = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G1_4xmlhttp4 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G1_4xmlhttp4.onreadystatechange = function() {
        if (G1_4xmlhttp4.readyState === 4 && G1_4xmlhttp4.status === 200) {
          var G1_4cost_p = G1_4xmlhttp4.responseText;
          var G1_4cost_p = G1_4cost_p * "1";
          if (G1_4cost_p > "0") {
            document.occ.gilding1_speed_value.value = G1_4cost_p;
            document.getElementById("gilding_error").style.display = "none";
          } else {
            document.occ.gilding1_speed_value.value = parseFloat(0).toFixed(2);
            document.getElementById("gilding_error").style.display = "";
          }
        }
      };

      G1_4xmlhttp4.open("GET", "order_calculation_create_gilding_speed_paper.php?var_id=" + G1_4type_id4, true);
      G1_4xmlhttp4.send();
    }

    setTimeout(count_gilding_2, TimeOut);
    setTimeout(count_cost_gilding_1, TimeOut);
  }

  function count_cost_gilding_1() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var G1speed = parseFloat(document.occ.gilding1_speed.value);
    var G1speed1 = parseFloat(document.occ.gilding1_type_value.value);
    if ((isNaN(G1speed1)) || (G1speed1 === "")) {
      G1speed1 = 0;
    }
    var G1speed2 = parseFloat(document.occ.gilding1_jump_value.value);
    if ((isNaN(G1speed2)) || (G1speed2 === "")) {
      G1speed2 = 0;
    }
    var G1speed3 = parseFloat(document.occ.gilding1_sqm_value.value);
    if ((isNaN(G1speed3)) || (G1speed3 === "")) {
      G1speed3 = 0;
    }
    var G1speed4 = parseFloat(document.occ.gilding1_speed_value.value);
    if ((isNaN(G1speed4)) || (G1speed4 === "")) {
      G1speed4 = 0;
    }
    var G1speedFoil = 1;
    if (document.occ.foil_type_id.value) {
      G1speedFoil = parseFloat(document.occ.gilding_foil_speed_value.value);
    }
    if ((isNaN(G1speedFoil)) || (G1speedFoil === "")) {
      G1speedFoil = 1;
    }

    var G1speed_new = G1speed * G1speed1 * G1speed2 * G1speed3 * G1speed4 * G1speedFoil;
    var G1qty_prod = parseFloat(document.occ.gilding_qty1.value);
    var G1stup_h_m = parseFloat(document.occ.gilding_setup_h_matryc.value);
    var G1pln_h = parseFloat(document.occ.gilding_cost_pln_h.value);
    var G1pln_hN = parseFloat(document.occ.gilding_cost_pln_hN.value);
    var G1min_job_pln = parseFloat(document.occ.gilding_minimum_cost_job_pln.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    var G1min_matryc_pln = parseFloat(document.occ.gilding_minimum_cost_matryca_pln.value);
    var G1_idleNp = parseFloat(document.occ.gilding_idleNp.value);
    if (isNaN(G1_idleNp)) {
      G1_idleNp = 0;
    }
    var G1_idleJp = parseFloat(document.occ.gilding_idleJp.value);
    if (isNaN(G1_idleJp)) {
      G1_idleJp = 0;
    }
    var G1_idle_cost = parseFloat(document.occ.gilding_idle_cost.value);
    if (isNaN(G1_idle_cost)) {
      G1_idle_cost = 0;
    }


    var G1pln_cm2 = parseFloat(document.occ.gilding_cost_matryc_pln_cm2.value);
    //var G1sqcm2             = parseFloat(document.occ.gilding_sqcm_matryc1.value);
    var G1sqcm2 = (parseFloat(document.occ.gilding_sqcm_matryc1x.value) + parseFloat(document.occ.gilding_sqcm_matrycX_extra.value)) * (parseFloat(document.occ.gilding_sqcm_matryc1y.value) + parseFloat(document.occ.gilding_sqcm_matrycY_extra.value));
    if (isNaN(G1sqcm2)) {
      G1sqcm2 = 0;
    }
    var G1qty_matryc = parseFloat(document.occ.gilding_qty_matryc1.value);
    if (isNaN(G1qty_matryc)) {
      G1qty_matryc = 0;
    }

    var G1foil_cost_pln_sqm = parseFloat(document.occ.gilding_foil_cost_sqm1.value);
    if (isNaN(G1foil_cost_pln_sqm)) {
      G1foil_cost_pln_sqm = 0;
    }
    var G1nesting = document.occ.product_paper_value1.value;
    var G1order_qty = parseFloat(document.occ.order_qty1_less.value);
    var G1ark = G1order_qty / G1nesting * G1qty_prod;
    var G1waste1 = parseFloat(document.occ.waste_proc1.value);
    G1waste1 = +G1waste1.toFixed(2); // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
    G1order_qty = parseFloat(G1order_qty + G1order_qty * G1waste1);

    var G1cost_setup = 0;
    var G1cost_prod = 0;
    var G1cost_idle = 0;
    var G1cost_matryc = 0;
    var G1cost_total = 0;
    var G1cost_foil = 0;
    var G1cost_setup_time = 0;
    var G1cost_prod_time = 0;
    var gilding1_setup_info = '';
    var gilding1_prod_info = '';
    var gilding1_idle_info = '';
    if (G1qty_matryc) {
      G1cost_setup_time = G1stup_h_m * G1qty_matryc;
      G1cost_prod_time = G1ark / G1speed_new;
      G1cost_setup = G1stup_h_m * G1qty_matryc * G1pln_hN; //alert(G1cost_setup+'='+G1stup_h_m+' * '+G1qty_matryc+' * '+G1pln_hN)
      gilding1_setup_info = 'I [' + G1stup_h_m + '*' + G1qty_matryc + '*' + G1pln_hN + '=' + G1cost_setup + ']; ';
      G1cost_prod = G1ark / G1speed_new * G1pln_h; //alert(G1cost_prod+'='+G1ark+'/'+G1speed_new+'*'+G1pln_h);
      gilding1_prod_info = 'I [(' + G1order_qty + '/' + G1nesting + '*' + G1qty_prod + ')/(' + G1speed + '*' + G1speed1 + '*' + G1speed2 + '*' + G1speed3 + '*' + G1speed4 + '*' + G1speedFoil + ')*' + G1pln_h + '=' + G1cost_prod + ']; ';
      G1cost_idle = ((G1stup_h_m * G1qty_matryc * G1_idleNp / 100) + (G1ark / G1speed_new * G1_idleJp / 100)) * G1_idle_cost;
      gilding1_idle_info = 'I [((' + G1stup_h_m + '*' + G1qty_matryc + '*' + G1_idleNp + '/100)+(' + G1ark + '/' + G1speed_new + '*' + G1_idleJp + '/100))*' + G1_idle_cost + '=' + G1cost_idle + ']; ';
      ///alert(G1cost_idle+' = (('+G1stup_h_m +'*'+G1qty_matryc+'*'+G1_idleNp+'/100) + ('+G1ark+'/'+G1speed_new+'*'+G1_idleJp+'/100) ) * '+G1_idle_cost);
      if (G1speed_new === "0") {
        G1cost_prod_time = 0;
        G1cost_prod = 0;
        G1cost_idle = (G1stup_h_m * G1qty_matryc * G1_idleNp / 100) * G1_idle_cost;
      }
      ///if (G1cost_prod < G1min_job_pln) { G1cost_prod = G1min_job_pln; }
      //var G1cost_sum      = G1cost_idle + G1cost_setup + G1cost_prod;     //    alert(G1cost_sum+' suma < minimum '+G1min_job_pln);
      //if (G1cost_sum < G1min_job_pln) {
      //    G1cost_prod  = G1cost_prod  + ((G1min_job_pln-G1cost_sum)/3);
      //    G1cost_setup = G1cost_setup + ((G1min_job_pln-G1cost_sum)/3);
      //    G1cost_idle  = G1cost_idle  + ((G1min_job_pln-G1cost_sum)/3);
      // }
      G1cost_matryc = (G1sqcm2 * G1qty_matryc * G1pln_cm2);
      //if (G1cost_matryc < G1min_matryc_pln) { G1cost_matryc = G1min_matryc_pln; }

      G1cost_foil = (G1ark * G1sqcm2 / 10000 * G1qty_matryc * G1foil_cost_pln_sqm);
      // alert(G1cost_foil+' = '+G1ark+' * '+G1sqcm2+'/1000 * '+G1qty_matryc+'*'+G1foil_cost_pln_sqm)
      G1cost_total = G1cost_setup + G1cost_prod + G1cost_matryc + G1cost_foil;
      //if (G1cost_total < G1minimum_cost) { G1cost_total = G1minimum_cost; }
    }
    document.occ.cost_matryc1_setup.value = parseFloat(G1cost_setup).toFixed(2);
    document.occ.cost_matryc1_prod.value = parseFloat(G1cost_prod).toFixed(2);
    document.occ.cost_matryc1_setup_time.value = parseFloat(G1cost_setup_time).toFixed(2);
    document.occ.cost_matryc1_prod_time.value = parseFloat(G1cost_prod_time).toFixed(2);
    document.occ.cost_matryc1_idle.value = parseFloat(G1cost_idle).toFixed(2);
    document.occ.cost_matryc1.value = parseFloat(G1cost_matryc).toFixed(2);
    document.occ.cost_matryc1_f.value = parseFloat(G1cost_foil).toFixed(2);
    document.occ.cost_matryc1_total.value = parseFloat(G1cost_total).toFixed(2);
    document.occ.gilding1_setup_info.value = gilding1_setup_info;
    document.occ.gilding1_prod_info.value = gilding1_prod_info;
    document.occ.gilding1_idle_info.value = gilding1_idle_info;
    if (G1cost_total === 0) {
      document.getElementById("gilding_box1").disabled = true;
      if (document.getElementById("gilding_box1").checked) {
        document.getElementById("gilding_box0").checked = true;
      }
    } else {
      document.getElementById("gilding_box1").disabled = false;
    }

  }

  function count_gilding_2() { //szukam danych
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var G2_0speed_id = document.occ.gilding_speed_id2.value;
    if (G2_0speed_id === "") {
      document.occ.gilding2_speed.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G2_0xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G2_0xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G2_0xmlhttp.onreadystatechange = function() {
        if (G2_0xmlhttp.readyState === 4 && G2_0xmlhttp.status === 200) {
          var G2_0cost_v = G2_0xmlhttp.responseText;
          var G2_0cost_v = G2_0cost_v * "1";
          if (G2_0cost_v > "0") {
            document.occ.gilding2_speed.value = G2_0cost_v;
          } else {
            document.occ.gilding2_speed.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G2_0xmlhttp.open("GET", "order_calculation_create_gilding_speed_quality.php?var_id=" + G2_0speed_id + "&name=gilding_quality_speed", true);
      G2_0xmlhttp.send();
    }

    var G2_1type_id = document.occ.gilding_type_id2.value;
    if (G2_1type_id === "") {
      document.occ.gilding2_type_value.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G2_1xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G2_1xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G2_1xmlhttp.onreadystatechange = function() {
        if (G2_1xmlhttp.readyState === 4 && G2_1xmlhttp.status === 200) {
          var G2_1cost_v = G2_1xmlhttp.responseText;
          var G2_1cost_v = G2_1cost_v * "1";
          if (G2_1cost_v > "0") {
            document.occ.gilding2_type_value.value = G2_1cost_v;
          } else {
            document.occ.gilding2_type_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G2_1xmlhttp.open("GET", "order_calculation_create_gilding_speed_type.php?var_id=" + G2_1type_id, true);
      G2_1xmlhttp.send();
    }


    var G2_2type_id2 = document.occ.gilding_jump_id2.value;
    if (G2_2type_id2 === "") {
      document.occ.gilding2_jump_value.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G2_2xmlhttp2 = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G2_2xmlhttp2 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G2_2xmlhttp2.onreadystatechange = function() {
        if (G2_2xmlhttp2.readyState === 4 && G2_2xmlhttp2.status === 200) {
          var G2_2cost_j = G2_2xmlhttp2.responseText;
          var G2_2cost_j = G2_2cost_j * "1";
          if (G2_2cost_j > "0") {
            document.occ.gilding2_jump_value.value = G2_2cost_j;
          } else {
            document.occ.gilding2_jump_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G2_2xmlhttp2.open("GET", "order_calculation_create_gilding_speed_jump.php?var_id=" + G2_2type_id2, true);
      G2_2xmlhttp2.send();
    }


    var G2_3type_id3 = document.occ.gilding_sqmm_id2.value;
    if (G2_3type_id3 === "") {
      document.occ.gilding2_sqm_value.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G2_3xmlhttp3 = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G2_3xmlhttp3 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G2_3xmlhttp3.onreadystatechange = function() {
        if (G2_3xmlhttp3.readyState === 4 && G2_3xmlhttp3.status === 200) {
          var G2_3cost_s = G2_3xmlhttp3.responseText;
          var G2_3cost_s = G2_3cost_s * "1";
          if (G2_3cost_s > "0") {
            document.occ.gilding2_sqm_value.value = G2_3cost_s;
          } else {
            document.occ.gilding2_sqm_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G2_3xmlhttp3.open("GET", "order_calculation_create_gilding_speed_sqmm.php?var_id=" + G2_3type_id3, true);
      G2_3xmlhttp3.send();
    }

    var G2_4type_id4 = document.occ.paper_type_id1.value;
    if (G2_4type_id4 === "") {
      document.occ.gilding2_speed_value.value = parseFloat(0).toFixed(2);
      document.getElementById("gilding_error").style.display = "";
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G2_4xmlhttp4 = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G2_4xmlhttp4 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G2_4xmlhttp4.onreadystatechange = function() {
        if (G2_4xmlhttp4.readyState === 4 && G2_4xmlhttp4.status === 200) {
          var G2_4cost_p = G2_4xmlhttp4.responseText;
          var G2_4cost_p = G2_4cost_p * "1";
          if (G2_4cost_p > "0") {
            document.occ.gilding2_speed_value.value = G2_4cost_p;
            document.getElementById("gilding_error").style.display = "none";
          } else {
            document.occ.gilding2_speed_value.value = parseFloat(0).toFixed(2);
            document.getElementById("gilding_error").style.display = "";
          }
        }
      };

      G2_4xmlhttp4.open("GET", "order_calculation_create_gilding_speed_paper.php?var_id=" + G2_4type_id4, true);
      G2_4xmlhttp4.send();
    }

    setTimeout(count_gilding_3, TimeOut);
    setTimeout(count_cost_gilding_2, TimeOut);
  }

  function count_cost_gilding_2() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var G2speed = parseFloat(document.occ.gilding2_speed.value);
    var G2speed1 = parseFloat(document.occ.gilding2_type_value.value);
    if ((isNaN(G2speed1)) || (G2speed1 === "")) {
      G2speed1 = 0;
    }
    var G2speed2 = parseFloat(document.occ.gilding2_jump_value.value);
    if ((isNaN(G2speed2)) || (G2speed2 === "")) {
      G2speed2 = 0;
    }
    var G2speed3 = parseFloat(document.occ.gilding2_sqm_value.value);
    if ((isNaN(G2speed3)) || (G2speed3 === "")) {
      G2speed3 = 0;
    }
    var G2speed4 = parseFloat(document.occ.gilding2_speed_value.value);
    if ((isNaN(G2speed4)) || (G2speed4 === "")) {
      G2speed4 = 0;
    }
    var G2speedFoil = 1;
    if (document.occ.foil_type_id.value) {
      G2speedFoil = parseFloat(document.occ.gilding_foil_speed_value.value);
    }
    if ((isNaN(G2speedFoil)) || (G2speedFoil === "")) {
      G2speedFoil = 1;
    }
    var G2speed_new = G2speed * G2speed1 * G2speed2 * G2speed3 * G2speed4 * G2speedFoil;
    var G2qty_prod = parseFloat(document.occ.gilding_qty2.value);
    var G2stup_h_m = parseFloat(document.occ.gilding_setup_h_matryc.value);
    var G2pln_h = parseFloat(document.occ.gilding_cost_pln_h.value);
    var G2pln_hN = parseFloat(document.occ.gilding_cost_pln_hN.value);
    var G2min_job_pln = parseFloat(document.occ.gilding_minimum_cost_job_pln.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    var G2min_matryc_pln = parseFloat(document.occ.gilding_minimum_cost_matryca_pln.value);
    //var G2minimum_cost      = parseFloat(document.occ.cost_minimum.value);

    var G2pln_cm2 = parseFloat(document.occ.gilding_cost_matryc_pln_cm2.value);
    //var G2sqcm2             = parseFloat(document.occ.gilding_sqcm_matryc2.value);
    var G2sqcm2 = (parseFloat(document.occ.gilding_sqcm_matryc2x.value) + parseFloat(document.occ.gilding_sqcm_matrycX_extra.value)) * (parseFloat(document.occ.gilding_sqcm_matryc2y.value) + parseFloat(document.occ.gilding_sqcm_matrycY_extra.value));
    if (isNaN(G2sqcm2)) {
      G2sqcm2 = 0;
    }
    var G2qty_matryc = parseFloat(document.occ.gilding_qty_matryc2.value);
    if (isNaN(G2qty_matryc)) {
      G2qty_matryc = 0;
    }
    var G2_idleNp = parseFloat(document.occ.gilding_idleNp.value);
    if (isNaN(G2_idleNp)) {
      G2_idleNp = 0;
    }
    var G2_idleJp = parseFloat(document.occ.gilding_idleJp.value);
    if (isNaN(G2_idleJp)) {
      G2_idleJp = 0;
    }
    var G2_idle_cost = parseFloat(document.occ.gilding_idle_cost.value);
    if (isNaN(G2_idle_cost)) {
      G2_idle_cost = 0;
    }

    var G2foil_cost_pln_sqm = parseFloat(document.occ.gilding_foil_cost_sqm2.value);
    if (isNaN(G2foil_cost_pln_sqm)) {
      G2foil_cost_pln_sqm = 0;
    }
    var G2nesting = parseFloat(document.occ.product_paper_value1.value);
    var G2order_qty = parseFloat(document.occ.order_qty1_less.value);
    var G2ark = G2order_qty / G2nesting;
    var G2waste1 = parseFloat(document.occ.waste_proc1.value);
    G2waste1 = +G2waste1.toFixed(2); // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
    G2order_qty = G2order_qty + G2order_qty * G2waste1;
    ////sprawdzam, ile jest uzytków i ile matryc, ile razumusze złocić!?
    G2ark = G2ark * G2qty_prod;

    var G2cost_setup = 0;
    var G2cost_prod = 0;
    var G2cost_idle = 0;
    var G2cost_matryc = 0;
    var G2cost_total = 0;
    var G2cost_foil = 0;
    var G2cost_setup_time = 0;
    var G2cost_prod_time = 0;
    var gilding2_setup_info = '';
    var gilding2_prod_info = '';
    var gilding2_idle_info = '';
    if (G2qty_matryc) {
      G2cost_setup_time = G2stup_h_m * G2qty_matryc;
      G2cost_prod_time = G2ark / G2speed_new;
      G2cost_setup = G2stup_h_m * G2qty_matryc * G2pln_hN; //alert(G2cost_setup+'= '+G2stup_h_m +'* '+G2qty_matryc +'* '+G2pln_hN);
      gilding2_setup_info = 'II [' + G2stup_h_m + '*' + G2qty_matryc + '*' + G2pln_hN + '=' + G2cost_setup + ']; ';
      G2cost_prod = G2ark / G2speed_new * G2pln_h; ///alert(G2cost_prod+' = '+G2ark +'/ '+G2speed_new +'* '+G2pln_h);
      gilding2_prod_info = 'II [(' + G2order_qty + '/' + G2nesting + '*' + G2qty_prod + ')/(' + G2speed + '*' + G2speed1 + '*' + G2speed2 + '*' + G2speed3 + '*' + G2speed4 + '*' + G2speedFoil + ')*' + G2pln_h + '=' + G2cost_prod + ']; ';
      G2cost_idle = ((G2stup_h_m * G2qty_matryc * G2_idleNp / 100) + (G2ark / G2speed_new * G2_idleJp / 100)) * G2_idle_cost;
      gilding2_idle_info = 'II [((' + G2stup_h_m + '*' + G2qty_matryc + '*' + G2_idleNp + '/100)+(' + G2ark + '/' + G2speed_new + '*' + G2_idleJp + '/100))*' + G2_idle_cost + '=' + G2cost_idle + ']; ';
      if (G2speed_new === "0") {
        G2cost_prod = 0;
        G2cost_prod_time = 0;
        G2cost_idle = (G2stup_h_m * G2qty_matryc * G2_idleNp / 100) * G2_idle_cost;
      }
      ///if (G2cost_prod < G2min_job_pln) { G2cost_prod = G2min_job_pln; }
      //var G2cost_sum      = G2cost_idle + G2cost_setup + G2cost_prod;
      //if (G2cost_sum < G2min_job_pln) {
      //    G2cost_prod  = G2cost_prod  + ((G2min_job_pln-G2cost_sum)/3);
      //    G2cost_setup = G2cost_setup + ((G2min_job_pln-G2cost_sum)/3);
      //    G2cost_idle  = G2cost_idle  + ((G2min_job_pln-G2cost_sum)/3);
      //}
      G2cost_matryc = (G2sqcm2 * G2qty_matryc * G2pln_cm2);
      //if (G2cost_matryc < G2min_matryc_pln) { G2cost_matryc = G2min_matryc_pln; }

      G2cost_foil = (G2ark * G2sqcm2 / 10000 * G2qty_matryc * G2foil_cost_pln_sqm);
      G2cost_total = G2cost_setup + G2cost_prod + G2cost_matryc + G2cost_foil;
      //if (G2cost_total < G2minimum_cost) { G2cost_total = G2minimum_cost; }
    }
    document.occ.cost_matryc2_setup.value = parseFloat(G2cost_setup).toFixed(2);
    document.occ.cost_matryc2_prod.value = parseFloat(G2cost_prod).toFixed(2);
    document.occ.cost_matryc2_setup_time.value = parseFloat(G2cost_setup_time).toFixed(2);
    document.occ.cost_matryc2_prod_time.value = parseFloat(G2cost_prod_time).toFixed(2);
    document.occ.cost_matryc2_idle.value = parseFloat(G2cost_idle).toFixed(2);
    document.occ.cost_matryc2.value = parseFloat(G2cost_matryc).toFixed(2);
    document.occ.cost_matryc2_f.value = parseFloat(G2cost_foil).toFixed(2);
    document.occ.cost_matryc2_total.value = parseFloat(G2cost_total).toFixed(2);
    document.occ.gilding2_setup_info.value = gilding2_setup_info;
    document.occ.gilding2_prod_info.value = gilding2_prod_info;
    document.occ.gilding2_idle_info.value = gilding2_idle_info;
    if (G2cost_total === 0) {
      document.getElementById("gilding_box2").disabled = true;
      if (document.getElementById("gilding_box2").checked) {
        document.getElementById("gilding_box0").checked = true;
      }
    } else {
      document.getElementById("gilding_box2").disabled = false;
    }

  }

  function count_gilding_3() { //szukam danych
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var G3_0speed_id = document.occ.gilding_speed_id3.value;
    if (G3_0speed_id === "") {
      document.occ.gilding3_speed.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G3_0xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G3_0xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G3_0xmlhttp.onreadystatechange = function() {
        if (G3_0xmlhttp.readyState === 4 && G3_0xmlhttp.status === 200) {
          var G3_0cost_v = G3_0xmlhttp.responseText;
          var G3_0cost_v = G3_0cost_v * "1";
          if (G3_0cost_v > "0") {
            document.occ.gilding3_speed.value = G3_0cost_v;
          } else {
            document.occ.gilding3_speed.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G3_0xmlhttp.open("GET", "order_calculation_create_gilding_speed_quality.php?var_id=" + G3_0speed_id + "&name=gilding_quality_speed", true);
      G3_0xmlhttp.send();
    }

    var G3_1type_id = document.occ.gilding_type_id3.value;
    if (G3_1type_id === "") {
      document.occ.gilding3_type_value.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G3_1xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G3_1xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G3_1xmlhttp.onreadystatechange = function() {
        if (G3_1xmlhttp.readyState === 4 && G3_1xmlhttp.status === 200) {
          var G3_1cost_v = G3_1xmlhttp.responseText;
          var G3_1cost_v = G3_1cost_v * "1";
          if (G3_1cost_v > "0") {
            document.occ.gilding3_type_value.value = G3_1cost_v;
          } else {
            document.occ.gilding3_type_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G3_1xmlhttp.open("GET", "order_calculation_create_gilding_speed_type.php?var_id=" + G3_1type_id, true);
      G3_1xmlhttp.send();
    }


    var G3_2type_id2 = document.occ.gilding_jump_id3.value;
    if (G3_2type_id2 === "") {
      document.occ.gilding3_jump_value.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G3_2xmlhttp2 = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G3_2xmlhttp2 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G3_2xmlhttp2.onreadystatechange = function() {
        if (G3_2xmlhttp2.readyState === 4 && G3_2xmlhttp2.status === 200) {
          var G3_2cost_j = G3_2xmlhttp2.responseText;
          var G3_2cost_j = G3_2cost_j * "1";
          if (G3_2cost_j > "0") {
            document.occ.gilding3_jump_value.value = G3_2cost_j;
          } else {
            document.occ.gilding3_jump_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G3_2xmlhttp2.open("GET", "order_calculation_create_gilding_speed_jump.php?var_id=" + G3_2type_id2, true);
      G3_2xmlhttp2.send();
    }


    var G3_3type_id3 = document.occ.gilding_sqmm_id3.value;
    if (G3_3type_id3 === "") {
      document.occ.gilding3_sqm_value.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G3_3xmlhttp3 = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G3_3xmlhttp3 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G3_3xmlhttp3.onreadystatechange = function() {
        if (G3_3xmlhttp3.readyState === 4 && G3_3xmlhttp3.status === 200) {
          var G3_3cost_s = G3_3xmlhttp3.responseText;
          var G3_3cost_s = G3_3cost_s * "1";
          if (G3_3cost_s > "0") {
            document.occ.gilding3_sqm_value.value = G3_3cost_s;
          } else {
            document.occ.gilding3_sqm_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G3_3xmlhttp3.open("GET", "order_calculation_create_gilding_speed_sqmm.php?var_id=" + G3_3type_id3, true);
      G3_3xmlhttp3.send();
    }

    var G3_4type_id4 = document.occ.paper_type_id1.value;
    if (G3_4type_id4 === "") {
      document.occ.gilding3_speed_value.value = parseFloat(0).toFixed(2);
      document.getElementById("gilding_error").style.display = "";
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G3_4xmlhttp4 = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G3_4xmlhttp4 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G3_4xmlhttp4.onreadystatechange = function() {
        if (G3_4xmlhttp4.readyState === 4 && G3_4xmlhttp4.status === 200) {
          var G3_4cost_p = G3_4xmlhttp4.responseText;
          var G3_4cost_p = G3_4cost_p * "1";
          if (G3_4cost_p > "0") {
            document.occ.gilding3_speed_value.value = G3_4cost_p;
            document.getElementById("gilding_error").style.display = "none";
          } else {
            document.occ.gilding3_speed_value.value = parseFloat(0).toFixed(2);
            document.getElementById("gilding_error").style.display = "";
          }
        }
      };

      G3_4xmlhttp4.open("GET", "order_calculation_create_gilding_speed_paper.php?var_id=" + G3_4type_id4, true);
      G3_4xmlhttp4.send();
    }

    setTimeout(count_gilding_4, TimeOut);
    setTimeout(count_cost_gilding_3, TimeOut);
  }

  function count_cost_gilding_3() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var G3speed = parseFloat(document.occ.gilding3_speed.value);
    var G3speed1 = parseFloat(document.occ.gilding3_type_value.value);
    if ((isNaN(G3speed1)) || (G3speed1 === "")) {
      G3speed1 = 0;
    }
    var G3speed2 = parseFloat(document.occ.gilding3_jump_value.value);
    if ((isNaN(G3speed2)) || (G3speed2 === "")) {
      G3speed2 = 0;
    }
    var G3speed3 = parseFloat(document.occ.gilding3_sqm_value.value);
    if ((isNaN(G3speed3)) || (G3speed3 === "")) {
      G3speed3 = 0;
    }
    var G3speed4 = parseFloat(document.occ.gilding3_speed_value.value);
    if ((isNaN(G3speed4)) || (G3speed4 === "")) {
      G3speed4 = 0;
    }
    var G3speedFoil = 1;
    if (document.occ.foil_type_id.value) {
      G3speedFoil = parseFloat(document.occ.gilding_foil_speed_value.value);
    }
    if ((isNaN(G3speedFoil)) || (G3speedFoil === "")) {
      G3speedFoil = 1;
    }
    var G3speed_new = G3speed * G3speed1 * G3speed2 * G3speed3 * G3speed4 * G3speedFoil;
    var G3qty_prod = parseFloat(document.occ.gilding_qty3.value);
    var G3stup_h_m = parseFloat(document.occ.gilding_setup_h_matryc.value);
    var G3pln_h = parseFloat(document.occ.gilding_cost_pln_h.value);
    var G3pln_hN = parseFloat(document.occ.gilding_cost_pln_hN.value);
    var G3min_job_pln = parseFloat(document.occ.gilding_minimum_cost_job_pln.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    var G3min_matryc_pln = parseFloat(document.occ.gilding_minimum_cost_matryca_pln.value);
    //var G3minimum_cost      = parseFloat(document.occ.cost_minimum.value);

    var G3pln_cm2 = parseFloat(document.occ.gilding_cost_matryc_pln_cm2.value);
    //var G3sqcm2             = parseFloat(document.occ.gilding_sqcm_matryc3.value);
    var G3sqcm2 = (parseFloat(document.occ.gilding_sqcm_matryc3x.value) + parseFloat(document.occ.gilding_sqcm_matrycX_extra.value)) * (parseFloat(document.occ.gilding_sqcm_matryc3y.value) + parseFloat(document.occ.gilding_sqcm_matrycY_extra.value));
    if (isNaN(G3sqcm2)) {
      G3sqcm2 = 0;
    }
    var G3qty_matryc = parseFloat(document.occ.gilding_qty_matryc3.value);
    if (isNaN(G3qty_matryc)) {
      G3qty_matryc = 0;
    }
    var G3_idleNp = parseFloat(document.occ.gilding_idleNp.value);
    if (isNaN(G3_idleNp)) {
      G3_idleNp = 0;
    }
    var G3_idleJp = parseFloat(document.occ.gilding_idleJp.value);
    if (isNaN(G3_idleJp)) {
      G3_idleJp = 0;
    }
    var G3_idle_cost = parseFloat(document.occ.gilding_idle_cost.value);
    if (isNaN(G3_idle_cost)) {
      G3_idle_cost = 0;
    }

    var G3foil_cost_pln_sqm = parseFloat(document.occ.gilding_foil_cost_sqm3.value);
    if (isNaN(G3foil_cost_pln_sqm)) {
      G3foil_cost_pln_sqm = 0;
    }
    var G3nesting = parseFloat(document.occ.product_paper_value1.value);
    var G3order_qty = parseFloat(document.occ.order_qty1_less.value);
    var G3ark = G3order_qty / G3nesting;
    var G3waste1 = parseFloat(document.occ.waste_proc1.value);
    G3waste1 = +G3waste1.toFixed(2); // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
    G3order_qty = G3order_qty + G3order_qty * G3waste1;
    ////sprawdzam, ile jest uzytków i ile matryc, ile razumusze złocić!?
    G3ark = G3ark * G3qty_prod;

    var G3cost_setup = 0;
    var G3cost_prod = 0;
    var G3cost_idle = 0;
    var G3cost_matryc = 0;
    var G3cost_total = 0;
    var G3cost_foil = 0;
    var G3cost_setup_time = 0;
    var G3cost_prod_time = 0;
    var gilding3_setup_info = '';
    var gilding3_prod_info = '';
    var gilding3_idle_info = '';
    if (G3qty_matryc) {
      G3cost_setup_time = G3stup_h_m * G3qty_matryc;
      G3cost_prod_time = G3ark / G3speed_new;
      G3cost_setup = G3stup_h_m * G3qty_matryc * G3pln_hN;
      gilding3_setup_info = 'III [' + G3stup_h_m + '*' + G3qty_matryc + '*' + G3pln_hN + '=' + G3cost_setup + ']; ';
      G3cost_prod = G3ark / G3speed_new * G3pln_h;
      gilding3_prod_info = 'III [(' + G3order_qty + '/' + G3nesting + '*' + G3qty_prod + ')/(' + G3speed + '*' + G3speed1 + '*' + G3speed2 + '*' + G3speed3 + '*' + G3speed4 + '*' + G3speedFoil + ')*' + G3pln_h + '=' + G3cost_prod + ']; ';
      G3cost_idle = ((G3stup_h_m * G3qty_matryc * G3_idleNp / 100) + (G3ark / G3speed_new * G3_idleJp / 100)) * G3_idle_cost;
      gilding3_idle_info = 'III [((' + G3stup_h_m + '*' + G3qty_matryc + '*' + G3_idleNp + '/100)+(' + G3ark + '/' + G3speed_new + '*' + G3_idleJp + '/100))*' + G3_idle_cost + '=' + G3cost_idle + ']; ';
      if (G3speed_new === "0") {
        G3cost_prod = 0;
        G3cost_idle = (G3stup_h_m * G3qty_matryc * G3_idleNp / 100) * G3_idle_cost;
        G3cost_prod_time = 0;
      }
      ///if (G3cost_prod < G3min_job_pln) { G3cost_prod = G3min_job_pln; }
      //var G3cost_sum      = G3cost_idle + G3cost_setup + G3cost_prod;
      //if (G3cost_sum < G3min_job_pln) {
      //    G3cost_prod  = G3cost_prod  + ((G3min_job_pln-G3cost_sum)/3);
      //    G3cost_setup = G3cost_setup + ((G3min_job_pln-G3cost_sum)/3);
      //    G3cost_idle  = G3cost_idle  + ((G3min_job_pln-G3cost_sum)/3);
      //}
      G3cost_matryc = (G3sqcm2 * G3qty_matryc * G3pln_cm2);
      //if (G3cost_matryc < G3min_matryc_pln) { G3cost_matryc = G3min_matryc_pln; }

      G3cost_foil = (G3ark * G3sqcm2 / 10000 * G3qty_matryc * G3foil_cost_pln_sqm);
      G3cost_total = G3cost_setup + G3cost_prod + G3cost_matryc + G3cost_foil;
      //if (G3cost_total < G3minimum_cost) { G3cost_total = G3minimum_cost; }
    }
    document.occ.cost_matryc3_setup.value = parseFloat(G3cost_setup).toFixed(2);
    document.occ.cost_matryc3_prod.value = parseFloat(G3cost_prod).toFixed(2);
    document.occ.cost_matryc3_setup_time.value = parseFloat(G3cost_setup_time).toFixed(2);
    document.occ.cost_matryc3_prod_time.value = parseFloat(G3cost_prod_time).toFixed(2);
    document.occ.cost_matryc3_idle.value = parseFloat(G3cost_idle).toFixed(2);
    document.occ.cost_matryc3.value = parseFloat(G3cost_matryc).toFixed(2);
    document.occ.cost_matryc3_f.value = parseFloat(G3cost_foil).toFixed(2);
    document.occ.cost_matryc3_total.value = parseFloat(G3cost_total).toFixed(2);
    document.occ.gilding3_setup_info.value = gilding3_setup_info;
    document.occ.gilding3_prod_info.value = gilding3_prod_info;
    document.occ.gilding3_idle_info.value = gilding3_idle_info;
    if (G3cost_total === 0) {
      document.getElementById("gilding_box3").disabled = true;
      if (document.getElementById("gilding_box3").checked) {
        document.getElementById("gilding_box0").checked = true;
      }
    } else {
      document.getElementById("gilding_box3").disabled = false;
    }

  }

  function count_gilding_4() { //szukam danych
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var G4_0speed_id = document.occ.gilding_speed_id4.value;
    if (G4_0speed_id === "") {
      document.occ.gilding4_speed.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G4_0xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G4_0xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G4_0xmlhttp.onreadystatechange = function() {
        if (G4_0xmlhttp.readyState === 4 && G4_0xmlhttp.status === 200) {
          var G4_0cost_v = G4_0xmlhttp.responseText;
          var G4_0cost_v = G4_0cost_v * "1";
          if (G4_0cost_v > "0") {
            document.occ.gilding4_speed.value = G4_0cost_v;
          } else {
            document.occ.gilding4_speed.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G4_0xmlhttp.open("GET", "order_calculation_create_gilding_speed_quality.php?var_id=" + G4_0speed_id + "&name=gilding_quality_speed", true);
      G4_0xmlhttp.send();
    }

    var G4_1type_id = document.occ.gilding_type_id4.value;
    if (G4_1type_id === "") {
      document.occ.gilding4_type_value.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G4_1xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G4_1xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G4_1xmlhttp.onreadystatechange = function() {
        if (G4_1xmlhttp.readyState === 4 && G4_1xmlhttp.status === 200) {
          var G4_1cost_v = G4_1xmlhttp.responseText;
          var G4_1cost_v = G4_1cost_v * "1";
          if (G4_1cost_v > "0") {
            document.occ.gilding4_type_value.value = G4_1cost_v;
          } else {
            document.occ.gilding4_type_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G4_1xmlhttp.open("GET", "order_calculation_create_gilding_speed_type.php?var_id=" + G4_1type_id, true);
      G4_1xmlhttp.send();
    }


    var G4_2type_id2 = document.occ.gilding_jump_id4.value;
    if (G4_2type_id2 === "") {
      document.occ.gilding4_jump_value.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G4_2xmlhttp2 = new XMLHttpRequest();
      } else { // code for IE6, IE5
    var    G4_2xmlhttp2 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G4_2xmlhttp2.onreadystatechange = function() {
        if (G4_2xmlhttp2.readyState === 4 && G4_2xmlhttp2.status === 200) {
          var G4_2cost_j = G4_2xmlhttp2.responseText;
          var G4_2cost_j = G4_2cost_j * "1";
          if (G4_2cost_j > "0") {
            document.occ.gilding4_jump_value.value = G4_2cost_j;
          } else {
            document.occ.gilding4_jump_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G4_2xmlhttp2.open("GET", "order_calculation_create_gilding_speed_jump.php?var_id=" + G4_2type_id2, true);
      G4_2xmlhttp2.send();
    }


    var G4_3type_id3 = document.occ.gilding_sqmm_id4.value;
    if (G4_3type_id3 === "") {
      document.occ.gilding4_sqm_value.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G4_3xmlhttp3 = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G4_3xmlhttp3 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G4_3xmlhttp3.onreadystatechange = function() {
        if (G4_3xmlhttp3.readyState === 4 && G4_3xmlhttp3.status === 200) {
          var G4_3cost_s = G4_3xmlhttp3.responseText;
          var G4_3cost_s = G4_3cost_s * "1";
          if (G4_3cost_s > "0") {
            document.occ.gilding4_sqm_value.value = G4_3cost_s;
          } else {
            document.occ.gilding4_sqm_value.value = parseFloat(0).toFixed(2);
          }
        }
      };

      G4_3xmlhttp3.open("GET", "order_calculation_create_gilding_speed_sqmm.php?var_id=" + G4_3type_id3, true);
      G4_3xmlhttp3.send();
    }

    var G4_4type_id4 = document.occ.paper_type_id1.value;
    if (G4_4type_id4 === "") {
      document.occ.gilding4_speed_value.value = parseFloat(0).toFixed(2);
      document.getElementById("gilding_error").style.display = "";
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  G4_4xmlhttp4 = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  G4_4xmlhttp4 = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      G4_4xmlhttp4.onreadystatechange = function() {
        if (G4_4xmlhttp4.readyState === 4 && G4_4xmlhttp4.status === 200) {
          var G4_4cost_p = G4_4xmlhttp4.responseText;
          var G4_4cost_p = G4_4cost_p * "1";
          if (G4_4cost_p > "0") {
            document.occ.gilding4_speed_value.value = G4_4cost_p;
            document.getElementById("gilding_error").style.display = "none";
          } else {
            document.occ.gilding4_speed_value.value = parseFloat(0).toFixed(2);
            document.getElementById("gilding_error").style.display = "";
          }
        }
      };

      G4_4xmlhttp4.open("GET", "order_calculation_create_gilding_speed_paper.php?var_id=" + G4_4type_id4, true);
      G4_4xmlhttp4.send();
    }


    setTimeout(count_cost_gilding_4, TimeOut);
  }

  function count_cost_gilding_4() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var G4speed = parseFloat(document.occ.gilding4_speed.value);
    var G4speed1 = parseFloat(document.occ.gilding4_type_value.value);
    if ((isNaN(G4speed1)) || (G4speed1 === "")) {
      G4speed1 = 0;
    }
    var G4speed2 = parseFloat(document.occ.gilding4_jump_value.value);
    if ((isNaN(G4speed2)) || (G4speed2 === "")) {
      G4speed2 = 0;
    }
    var G4speed3 = parseFloat(document.occ.gilding4_sqm_value.value);
    if ((isNaN(G4speed3)) || (G4speed3 === "")) {
      G4speed3 = 0;
    }
    var G4speed4 = parseFloat(document.occ.gilding4_speed_value.value);
    if ((isNaN(G4speed4)) || (G4speed4 === "")) {
      G4speed4 = 0;
    }
    var G4speedFoil = 1;
    if (document.occ.foil_type_id.value) {
      G4speedFoil = parseFloat(document.occ.gilding_foil_speed_value.value);
    }
    if ((isNaN(G4speedFoil)) || (G4speedFoil === "")) {
      G4speedFoil = 1;
    }
    var G4speed_new = G4speed * G4speed1 * G4speed2 * G4speed3 * G4speed4 * G4speedFoil;
    var G4qty_prod = parseFloat(document.occ.gilding_qty4.value);
    var G4stup_h_m = parseFloat(document.occ.gilding_setup_h_matryc.value);
    var G4pln_h = parseFloat(document.occ.gilding_cost_pln_h.value);
    var G4pln_hN = parseFloat(document.occ.gilding_cost_pln_hN.value);
    var G4min_job_pln = parseFloat(document.occ.gilding_minimum_cost_job_pln.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    var G4min_matryc_pln = parseFloat(document.occ.gilding_minimum_cost_matryca_pln.value);
    //var G4minimum_cost      = parseFloat(document.occ.cost_minimum.value);

    var G4pln_cm2 = parseFloat(document.occ.gilding_cost_matryc_pln_cm2.value);
    //var G4sqcm2             = parseFloat(document.occ.gilding_sqcm_matryc4.value);
    var G4sqcm2 = (parseFloat(document.occ.gilding_sqcm_matryc4x.value) + parseFloat(document.occ.gilding_sqcm_matrycX_extra.value)) * (parseFloat(document.occ.gilding_sqcm_matryc4y.value) + parseFloat(document.occ.gilding_sqcm_matrycY_extra.value));
    if (isNaN(G4sqcm2)) {
      G4sqcm2 = 0;
    }
    var G4qty_matryc = parseFloat(document.occ.gilding_qty_matryc4.value);
    if (isNaN(G4qty_matryc)) {
      G4qty_matryc = 0;
    }
    var G4_idleNp = parseFloat(document.occ.gilding_idleNp.value);
    if (isNaN(G4_idleNp)) {
      G4_idleNp = 0;
    }
    var G4_idleJp = parseFloat(document.occ.gilding_idleJp.value);
    if (isNaN(G4_idleJp)) {
      G4_idleJp = 0;
    }
    var G4_idle_cost = parseFloat(document.occ.gilding_idle_cost.value);
    if (isNaN(G4_idle_cost)) {
      G4_idle_cost = 0;
    }

    var G4foil_cost_pln_sqm = parseFloat(document.occ.gilding_foil_cost_sqm1.value);
    if (isNaN(G4foil_cost_pln_sqm)) {
      G4foil_cost_pln_sqm = 0;
    }
    var G4nesting = parseFloat(document.occ.product_paper_value1.value);
    var G4order_qty = parseFloat(document.occ.order_qty1_less.value);
    var G4ark = G4order_qty / G4nesting;
    var G4waste1 = parseFloat(document.occ.waste_proc1.value);
    G4waste1 = +G4waste1.toFixed(2); // now round that to 2 digits only. Note the plus sign that drops any "extra" zeroes at the end.
    G4order_qty = G4order_qty + G4order_qty * G4waste1;
    
    ////sprawdzam, ile jest uzytków i ile matryc, ile razumusze złocić!?
    G4ark = G4ark * G4qty_prod;

    var G4cost_setup = 0;
    var G4cost_prod = 0;
    var G4cost_idle = 0;
    var G4cost_matryc = 0;
    var G4cost_total = 0;
    var G4cost_foil = 0;
    var G4cost_setup_time = 0;
    var G4cost_prod_time = 0;
    var gilding4_setup_info = '';
    var gilding4_prod_info = '';
    var gilding4_idle_info = '';

    if (G4qty_matryc) {
      G4cost_setup_time = G4stup_h_m * G4qty_matryc;
      G4cost_prod_time = G4ark / G4speed_new;
      G4cost_setup = G4stup_h_m * G4qty_matryc * G4pln_hN;
      gilding4_setup_info = 'IV [' + G4stup_h_m + '*' + G4qty_matryc + '*' + G4pln_hN + '=' + G4cost_setup + ']; ';
      G4cost_prod = G4ark / G4speed_new * G4pln_h;
      gilding4_prod_info = 'IV [(' + G4order_qty + '/' + G4nesting + '*' + G4qty_prod + ')/(' + G4speed + '*' + G4speed1 + '*' + G4speed2 + '*' + G4speed3 + '*' + G4speed4 + '*' + G4speedFoil + ')*' + G4pln_h + '=' + G4cost_prod + ']; ';
      G4cost_idle = ((G4stup_h_m * G4qty_matryc * G4_idleNp / 100) + (G4ark / G4speed_new * G4_idleJp / 100)) * G4_idle_cost;
      gilding4_idle_info = 'IV [((' + G4stup_h_m + '*' + G4qty_matryc + '*' + G4_idleNp + '/100)+(' + G4ark + '/' + G4speed_new + '*' + G4_idleJp + '/100))*' + G4_idle_cost + '=' + G4cost_idle + ']; ';
      if (G4speed_new === "0") {
        G4cost_prod = 0;
        G4cost_prod_time = 0;
        G4cost_idle = (G4stup_h_m * G4qty_matryc * G4_idleNp / 100) * G4_idle_cost;
      }
      //if (G4cost_prod < G4min_job_pln) { G4cost_prod = G4min_job_pln; }
      //var G4cost_sum      = G4cost_idle + G4cost_setup + G4cost_prod;
      //if (G4cost_sum < G4min_job_pln) {
      //    G4cost_prod  = G4cost_prod  + ((G4min_job_pln-G4cost_sum)/3);
      //    G4cost_setup = G4cost_setup + ((G4min_job_pln-G4cost_sum)/3);
      //    G4cost_idle  = G4cost_idle  + ((G4min_job_pln-G4cost_sum)/3);
      //}
      G4cost_matryc = (G4sqcm2 * G4qty_matryc * G4pln_cm2);
      //if (G4cost_matryc < G4min_matryc_pln) { G4cost_matryc = G4min_matryc_pln; }

      G4cost_foil = (G4ark * G4sqcm2 / 10000 * G4qty_matryc * G4foil_cost_pln_sqm);
      G4cost_total = G4cost_setup + G4cost_prod + G4cost_matryc + G4cost_foil;
      //if (G4cost_total < G4minimum_cost) { G4cost_total = G4minimum_cost; }
    }
    document.occ.cost_matryc4_setup.value = parseFloat(G4cost_setup).toFixed(2);
    document.occ.cost_matryc4_prod.value = parseFloat(G4cost_prod).toFixed(2);
    document.occ.cost_matryc4_setup_time.value = parseFloat(G4cost_setup_time).toFixed(2);
    document.occ.cost_matryc4_prod_time.value = parseFloat(G4cost_prod_time).toFixed(2);
    document.occ.cost_matryc4_idle.value = parseFloat(G4cost_idle).toFixed(2);
    document.occ.cost_matryc4.value = parseFloat(G4cost_matryc).toFixed(2);
    document.occ.cost_matryc4_f.value = parseFloat(G4cost_foil).toFixed(2);
    document.occ.cost_matryc4_total.value = parseFloat(G4cost_total).toFixed(2);
    document.occ.gilding4_setup_info.value = gilding4_setup_info;
    document.occ.gilding4_prod_info.value = gilding4_prod_info;
    document.occ.gilding4_idle_info.value = gilding4_idle_info;
    if (G4cost_total === 0) {
      document.getElementById("gilding_box4").disabled = true;
      if (document.getElementById("gilding_box4").checked) {
        document.getElementById("gilding_box0").checked = true;
      }
    } else {
      document.getElementById("gilding_box4").disabled = false;
    }

    setTimeout(count_cost_gilding_new(''), TimeOut);
  }

  function count_cost_gilding_new(select0) {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    if (select0 === "10") {
      document.getElementById("gilding_box0").checked = true;
      document.getElementById("gilding_box1").checked = false;
      document.getElementById("gilding_box2").checked = false;
      document.getElementById("gilding_box3").checked = false;
      document.getElementById("gilding_box4").checked = false;
    }

    //var GCminimum_cost    = parseFloat(document.occ.cost_minimum.value);
    var GCcost_o = 0;
    var GCcost_m = 0;
    GCcost_i = 0;
    GCcost_prod = 0;
    GCcost_setup = 0;
    var GCminimum_check = 0;
    var GCcost_em = 0;

    var GCcost_o_old = parseFloat(document.occ.cost_gilding.value);
    var GCmat_info = '';
    document.occ.cost_gilding_jazda_info.value = '';
    document.occ.cost_gilding_narzad_info.value = '';
    document.occ.cost_gilding_idle_info.value = '';
    document.occ.cost_gilding_info.value = '';
    document.occ.cost_gilding_material_info.value = '';
    document.occ.cost_gilding.value = parseFloat(GCcost_o).toFixed(2);
    document.occ.cost_gilding_material.value = parseFloat(GCcost_m).toFixed(2);
    document.occ.cost_gilding_jazda_real.value = parseFloat(GCcost_m).toFixed(2);
    document.occ.cost_gilding_narzad_real.value = parseFloat(GCcost_m).toFixed(2);
    document.occ.cost_gilding_idle_real.value = parseFloat(GCcost_i).toFixed(2);

    var cost_extra_dsc = '';
    var cost_extra_total = 0;
    var cost_gilding_jazda_info = '';
    var cost_gilding_narzad_info = '';
    var cost_gilding_idle_info = '';

    //if (document.occ.gilding_box[1].checked) {
    if (document.getElementById("gilding_box1").checked) {
      document.getElementById("gilding_box0").checked = false;
      GCcost_o = GCcost_o + parseFloat(document.occ.cost_matryc1_setup.value) + parseFloat(document.occ.cost_matryc1_prod.value) + parseFloat(document.occ.cost_matryc1_idle.value);
      GCcost_m = GCcost_m + parseFloat(document.occ.cost_matryc1_f.value);
      GCcost_em = GCcost_em + parseFloat(document.occ.cost_matryc1.value);
      GCmat_info = '1 przelot folia (' + parseFloat(document.occ.cost_matryc1_f.value) + '); ';
      GCcost_i = GCcost_i + parseFloat(document.occ.cost_matryc1_idle.value);
      GCcost_setup = GCcost_setup + parseFloat(document.occ.cost_matryc1_setup.value);
      GCcost_prod = GCcost_prod + parseFloat(document.occ.cost_matryc1_prod.value);
      GCminimum_check = 1;
      cost_gilding_narzad_info = cost_gilding_narzad_info + document.occ.gilding1_setup_info.value;
      cost_gilding_jazda_info = cost_gilding_jazda_info + document.occ.gilding1_prod_info.value;
      cost_gilding_idle_info = cost_gilding_idle_info + document.occ.gilding1_idle_info.value;
    }
    //if (document.occ.gilding_box[2].checked) {
    if (document.getElementById("gilding_box2").checked) {
      document.getElementById("gilding_box0").checked = false;
      GCcost_o = GCcost_o + parseFloat(document.occ.cost_matryc2_setup.value) + parseFloat(document.occ.cost_matryc2_prod.value) + parseFloat(document.occ.cost_matryc2_idle.value);
      GCcost_m = GCcost_m + parseFloat(document.occ.cost_matryc2_f.value);
      GCcost_em = GCcost_em + parseFloat(document.occ.cost_matryc2.value);
      GCmat_info = GCmat_info + ' 2 przelot folia (' + parseFloat(document.occ.cost_matryc2_f.value) + '); ';
      GCcost_i = GCcost_i + parseFloat(document.occ.cost_matryc2_idle.value);
      GCcost_setup = GCcost_setup + parseFloat(document.occ.cost_matryc2_setup.value);
      GCcost_prod = GCcost_prod + parseFloat(document.occ.cost_matryc2_prod.value);
      GCminimum_check = 1;
      cost_gilding_narzad_info = cost_gilding_narzad_info + document.occ.gilding2_setup_info.value;
      cost_gilding_jazda_info = cost_gilding_jazda_info + document.occ.gilding2_prod_info.value;
      cost_gilding_idle_info = cost_gilding_idle_info + document.occ.gilding2_idle_info.value;
    }
    //if (document.occ.gilding_box[3].checked) {
    if (document.getElementById("gilding_box3").checked) {
      document.getElementById("gilding_box0").checked = false;
      GCcost_o = GCcost_o + parseFloat(document.occ.cost_matryc3_setup.value) + parseFloat(document.occ.cost_matryc3_prod.value) + parseFloat(document.occ.cost_matryc3_idle.value);
      GCcost_m = GCcost_m + parseFloat(document.occ.cost_matryc3_f.value);
      GCcost_em = GCcost_em + parseFloat(document.occ.cost_matryc3.value);
      GCmat_info = GCmat_info + ' 3 przelot folia (' + parseFloat(document.occ.cost_matryc3_f.value) + '); ';
      GCcost_i = GCcost_i + parseFloat(document.occ.cost_matryc3_idle.value);
      GCcost_setup = GCcost_setup + parseFloat(document.occ.cost_matryc3_setup.value);
      GCcost_prod = GCcost_prod + parseFloat(document.occ.cost_matryc3_prod.value);
      GCminimum_check = 1;
      cost_gilding_narzad_info = cost_gilding_narzad_info + document.occ.gilding3_setup_info.value;
      cost_gilding_jazda_info = cost_gilding_jazda_info + document.occ.gilding3_prod_info.value;
      cost_gilding_idle_info = cost_gilding_idle_info + document.occ.gilding3_idle_info.value;

    }
    //if (document.occ.gilding_box[4].checked) {
    if (document.getElementById("gilding_box4").checked) {
      document.getElementById("gilding_box0").checked = false;
      GCcost_o = GCcost_o + parseFloat(document.occ.cost_matryc4_setup.value) + parseFloat(document.occ.cost_matryc4_prod.value) + parseFloat(document.occ.cost_matryc4_idle.value);
      GCcost_m = GCcost_m + parseFloat(document.occ.cost_matryc4_f.value);
      GCcost_em = GCcost_em + parseFloat(document.occ.cost_matryc4.value);
      GCmat_info = GCmat_info + ' 4 przelot folia (' + parseFloat(document.occ.cost_matryc4_f.value) + '); ';
      GCcost_i = GCcost_i + parseFloat(document.occ.cost_matryc4_idle.value);
      GCcost_setup = GCcost_setup + parseFloat(document.occ.cost_matryc4_setup.value);
      GCcost_prod = GCcost_prod + parseFloat(document.occ.cost_matryc4_prod.value);
      GCminimum_check = 1;
      cost_gilding_narzad_info = cost_gilding_narzad_info + document.occ.gilding4_setup_info.value;
      cost_gilding_jazda_info = cost_gilding_jazda_info + document.occ.gilding4_prod_info.value;
      cost_gilding_idle_info = cost_gilding_idle_info + document.occ.gilding4_idle_info.value;

    }
    //if (document.occ.gilding_box[0].checked) {
    if (document.getElementById("gilding_box0").checked) {
      document.getElementById("gilding_box1").checked = false;
      document.getElementById("gilding_box2").checked = false;
      document.getElementById("gilding_box3").checked = false;
      document.getElementById("gilding_box4").checked = false;
      if (GCcost_o_old > 0) {
        document.occ.gilding_type_id1.value = "";
        document.occ.gilding_jump_id1.value = "";
        document.occ.gilding_sqmm_id1.value = "";
        document.occ.gilding_foil_cost_sqm1.value = "";
        //document.occ.gilding_sqcm_matryc1.value = "";
        document.occ.gilding_sqcm_matryc1x.value = "";
        document.occ.gilding_sqcm_matryc1y.value = "";
        document.occ.gilding_qty_matryc1.value = "";

        document.occ.gilding_qty2.value = "2";
        document.occ.gilding_type_id2.value = "";
        document.occ.gilding_jump_id2.value = "";
        document.occ.gilding_sqmm_id2.value = "";
        document.occ.gilding_foil_cost_sqm2.value = "";
        //document.occ.gilding_sqcm_matryc2.value = "";
        document.occ.gilding_sqcm_matryc2x.value = "";
        document.occ.gilding_sqcm_matryc2y.value = "";
        document.occ.gilding_qty_matryc2.value = "";

        document.occ.gilding_qty3.value = "3";
        document.occ.gilding_type_id3.value = "";
        document.occ.gilding_jump_id3.value = "";
        document.occ.gilding_sqmm_id3.value = "";
        document.occ.gilding_foil_cost_sqm3.value = "";
        //document.occ.gilding_sqcm_matryc3.value = "";
        document.occ.gilding_sqcm_matryc3x.value = "";
        document.occ.gilding_sqcm_matryc3y.value = "";
        document.occ.gilding_qty_matryc3.value = "";

        document.occ.gilding_qty4.value = "4";
        document.occ.gilding_type_id4.value = "";
        document.occ.gilding_jump_id4.value = "";
        document.occ.gilding_sqmm_id4.value = "";
        document.occ.gilding_foil_cost_sqm4.value = "";
        //document.occ.gilding_sqcm_matryc4.value = "";
        document.occ.gilding_sqcm_matryc4x.value = "";
        document.occ.gilding_sqcm_matryc4y.value = "";
        document.occ.gilding_qty_matryc4.value = "";

        setTimeout(count_gilding_1, TimeOut);
      }
    }

    document.occ.cost_gilding_real.value = parseFloat(GCcost_o).toFixed(2);
    if (GCminimum_check === 1) {
      var G1min_job_pln = parseFloat(document.occ.gilding_minimum_cost_job_pln.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
      if (GCcost_o < G1min_job_pln) {
        GCcost_o = G1min_job_pln;
      }
      var G1min_matryc_pln = parseFloat(document.occ.gilding_minimum_cost_matryca_pln.value);
      if (GCcost_m < G1min_matryc_pln) {
        GCcost_m = G1min_matryc_pln;
      }
    }
    document.occ.cost_gilding.value = parseFloat(GCcost_o).toFixed(2);
    document.occ.cost_gilding_material.value = parseFloat(GCcost_m).toFixed(2);
    document.occ.cost_extra_matryce.value = parseFloat(GCcost_em).toFixed(2);
    document.occ.cost_gilding_material_info.value = GCmat_info;
    document.occ.cost_gilding_narzad_real.value = parseFloat(GCcost_setup).toFixed(2);
    document.occ.cost_gilding_jazda_real.value = parseFloat(GCcost_prod).toFixed(2);
    document.occ.cost_gilding_idle_real.value = parseFloat(GCcost_i).toFixed(2);
    document.occ.cost_gilding_jazda_info.value = cost_gilding_jazda_info;
    document.occ.cost_gilding_narzad_info.value = cost_gilding_narzad_info;
    document.occ.cost_gilding_idle_info.value = cost_gilding_idle_info;

    setTimeout(count_varnish_UV_cost1, TimeOut);
  }

  function count_varnish_UV_cost1() { // UV varnish calculations
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    zeroOutData_UV (); // zero out field with UV data
    //var VUV1minimum_cost    = parseFloat(document.occ.cost_minimum.value);
    var VUV1minimum_mnoznik = parseFloat(document.occ.cost_minimum_mnoznik.value);
    var VUV1cost_o_varnish = 0;
    VUV1varnish_type_id = document.occ.varnish_uv_type_id.value;

  // BEGIN calculating UV setup, runtimes and idle times

    if (VUV1varnish_type_id) {
      document.getElementById("td_l1").style.display = "";
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  VUV1xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  VUV1xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      VUV1xmlhttp.onreadystatechange = function() {
        if (VUV1xmlhttp.readyState === 4 && VUV1xmlhttp.status === 200) {
          var VUV1cost_varnish = VUV1xmlhttp.responseText; ////wartość speed_cost_minimum
          var VUV1cost_varnish_arr = VUV1cost_varnish.split('_');
          var VUV1cost_varnish_speed = VUV1cost_varnish_arr[0] * 1; // get UV varnish efficiency
          var VUV1cost_varnish_cost = VUV1cost_varnish_arr[1] * 1; // get UV carnish cost per hour
          var VUV1cost_varnish_min = VUV1cost_varnish_arr[2] * 1 * VUV1minimum_mnoznik; // get minimal UV varnish cost
          var VUV1cost_varnish_setup = VUV1cost_varnish_arr[3] * 1; // get UV varnish setup time
          var VUV1cost_varnish_costN = VUV1cost_varnish_arr[4] * 1; // get UV varnish setup cost per hour

          var VUV1cost_varnish_idleN = VUV1cost_varnish_arr[5] * 1; // %idle narząd
          var VUV1cost_varnish_idleJ = VUV1cost_varnish_arr[6] * 1; //% idle jazda
          var VUV1cost_varnish_idleC = VUV1cost_varnish_arr[7] * 1; //coszt IDLE

          var VUV1cost_narzad = VUV1cost_varnish_setup * VUV1cost_varnish_costN; // calculate UV varnish setup costs
          varnishUVSetupTime = VUV1cost_varnish_setup;
          document.occ.cost_varnish_uv_setup_time.value = parseFloat(VUV1cost_varnish_setup).toFixed(2);
          document.occ.cost_varnish_uv_narzad_real.value = parseFloat(VUV1cost_narzad).toFixed(2);
          document.occ.cost_varnish_uv_narzad_info.value = 'czas setup * cena pracy NARZĄD= ' + VUV1cost_varnish_setup + ' * ' + VUV1cost_varnish_costN;

          var VUV1nesting = document.occ.product_paper_value1.value; // get number of ups on sheet
          var VUV1order_qty = document.occ.order_qty1_less.value; // get order qty
          var VUV1cost_jazdaT = (VUV1order_qty / VUV1nesting) / VUV1cost_varnish_speed;
          varnishUVRunTime = (VUV1order_qty / VUV1nesting) / VUV1cost_varnish_speed; // calculate UV varnish run time
          document.occ.cost_varnish_uv_jazda_time.value = parseFloat(VUV1cost_jazdaT).toFixed(2);
          var VUV1cost_jazda = parseFloat(VUV1cost_jazdaT * VUV1cost_varnish_cost); // calculate run time costs
          document.occ.cost_varnish_uv_jazda_real.value = parseFloat(VUV1cost_jazda).toFixed(2);
          document.occ.cost_varnish_uv_jazda_info.value = '(nakład arkuszy)/wydajność * cena pracy = (' + VUV1order_qty + ' / ' + VUV1nesting + ' )/ ' + VUV1cost_varnish_speed + ' * ' + VUV1cost_varnish_cost;

          ///IDLE ---
          var VUV1cost_idle = ((VUV1cost_varnish_setup * VUV1cost_varnish_idleN / 100) + (VUV1cost_jazdaT * VUV1cost_varnish_idleJ / 100)) * VUV1cost_varnish_idleC;
          varnishUVIdleTime = ((varnishUVSetupTime * VUV1cost_varnish_idleN / 100)+ (varnishUVRunTime*VUV1cost_varnish_idleJ / 100));
          document.occ.cost_varnish_uv_idle_real.value = parseFloat(VUV1cost_idle).toFixed(2);
          document.occ.cost_varnish_uv_idle_info.value = '[(czas narząd * %IDLE narząd)+(czas jazda * %IDLE jazda)] * koszt IDLE =[(' + VUV1cost_varnish_setup + ' * ' + VUV1cost_varnish_idleN + '/100) + (' + VUV1cost_jazdaT + ' * ' + VUV1cost_varnish_idleJ + '/100)) * ' + VUV1cost_varnish_idleC;
          // what if UV varnish cost is NaN?
          var VUV1cost_varnish = VUV1cost_narzad + VUV1cost_jazda + VUV1cost_idle;
          if (isNaN(VUV1cost_varnish)) {
            VUV1cost_varnish = 0;
            varnishUVSetupTime = 0;
            varnishUVRunTime = 0;
            varnishUVIdleTime=0;
          }
          document.occ.cost_varnish_uv_real.value = parseFloat(VUV1cost_varnish).toFixed(2);
          document.occ.cost_varnish_uv_info.value = 'koszt narządu + koszt jazdy + koszt IDLE = ' + parseFloat(VUV1cost_narzad).toFixed(2) + ' + ' + parseFloat(VUV1cost_jazda).toFixed(2) + ' + ' + parseFloat(VUV1cost_idle).toFixed(2);
          if (VUV1cost_varnish < VUV1cost_varnish_min) { // what if varnish cost is lower than minimal?
            VUV1cost_varnish = VUV1cost_varnish_min;
          }
          document.occ.cost_varnish_uv.value = parseFloat(VUV1cost_varnish).toFixed(2);

        }
      };

      VUV1xmlhttp.open("GET", "order_calculation_create_cost_varnish_uv.php?var_id=" + VUV1varnish_type_id, true);
      VUV1xmlhttp.send();
    } else { // if no varnish selected zero out data
      document.getElementById("td_l1").style.display = "none";
      document.occ.varnish_uv_sqm_ark.value = '';
      zeroOutData_UV (); // zero out field with UV data
    }
// END calculating UV setup, runtimes and idle times

// BEGIN calculating UV material costs
    var VUV2cost_sita = parseFloat(document.occ.cost_sita.value);
    var VUV2varnish_uv2_id = document.occ.varnish_uv_type_id.value;
    if (VUV2varnish_uv2_id === "") {
      document.occ.cost_varnish_uv_material.value = parseFloat(0).toFixed(2);
      document.occ.cost_varnish_uv_material_info.value = '';
    } else {
      var VUV2nesting = document.occ.product_paper_value1.value;
      var VUV2order_qty = document.occ.order_qty1_less.value;
      var VUV2sqm1 = parseFloat(document.occ.varnish_uv_sqm_ark.value);
      var VUV2sqm = parseFloat(VUV2order_qty / VUV2nesting * VUV2sqm1).toFixed(0);
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
      var  VUV2xmlhttp = new XMLHttpRequest();
      } else {
        // code for IE6, IE5
      var  VUV2xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      VUV2xmlhttp.onreadystatechange = function() {
        if (VUV2xmlhttp.readyState === 4 && VUV2xmlhttp.status === 200) {
          var VUV2cost_v2 = VUV2xmlhttp.responseText; /// wartość QTY_material_COST_material  //cost_varnish += (sqm)/qty_material * cost_material;
          var VUV2cost_v2_arr = VUV2cost_v2.split('_');
          var VUV2cost_qty_mat = VUV2cost_v2_arr[0] * 1;
          var VUV2cost_cost_mat = VUV2cost_v2_arr[1] * 1;
          var VUV2cost_cost_sito = VUV2cost_v2_arr[2] * 1;
          var VUV2cost_v2 = (VUV2sqm / VUV2cost_qty_mat * VUV2cost_cost_mat);
          if (isNaN(VUV2cost_v2)) {
            VUV2cost_v2 = 0;
          }
          var VUV2cost_v2 = VUV2cost_v2 + VUV2cost_cost_sito;

          if (VUV2cost_v2 > 0) {
            document.occ.cost_varnish_uv_material.value = parseFloat(VUV2cost_v2).toFixed(2);
            document.occ.cost_varnish_uv_material_info.value = '[(powierzchnia lakierowania)/wydajność lakieru] * cena lakieru + koszt sita =[(' + VUV2order_qty + '/' + VUV2nesting + '*' + VUV2sqm1 + ')/' + VUV2cost_qty_mat + ']*' + VUV2cost_cost_mat + '+' + VUV2cost_cost_sito;
          } else {
            document.occ.cost_varnish_uv_material.value = parseFloat(0).toFixed(2);
            document.occ.cost_varnish_uv_material_info.value = 'koszt sita = (' + VUV2cost_cost_sito + ')';
          }
        }
      };

      VUV2xmlhttp.open("GET", "order_calculation_create_cost_varnish_uv_material.php?var_id=" + VUV2varnish_uv2_id, true);
      VUV2xmlhttp.send();
    }
// END calculating UV material costs
    setTimeout(count_cost_laminating(''), TimeOut);
  }


  function count_cost_laminating() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    zeroOutData_LithoLamination ();

    // populate variables
    LAM_type_id = document.occ.laminating_type_id.value;
    LAM_sqm_id = document.occ.laminating_sqm_id.value;
    LAM_paper_id = document.occ.paper_id1.value;
    LAM_paper2_id = document.occ.paper_id2.value;
    // if all lamination type id and lamination sqm and second paper typ id are selected then proceed to calculte lamination costs.
    if ((LAM_sqm_id) && (LAM_type_id) && (LAM_paper_id) && (LAM_paper2_id)) {
      //var LAMminimum_cost  = parseFloat(document.occ.cost_minimum.value);
      var LAMminimum_cost = parseFloat(document.occ.cost_minimum_laminating.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
      LAMnarzad = parseFloat(document.occ.kaszer_narzad.value); // get litho-lamination setup times
      lithoLaminationSetupTime = LAMnarzad;
      LAM_speed = parseFloat(document.occ.kaszer_speed.value);
      var LAM_cost_glue = parseFloat(document.occ.kaszer_cost_glue.value); //pln/kg
      var LAM_cost = parseFloat(document.occ.kaszer_cost.value); ///pln/h
      var LAM_costN = parseFloat(document.occ.kaszer_cost_narzad.value);
      var LAM_costI = parseFloat(document.occ.kaszer_cost_idle.value); ///pln/h
      var LAM_idleN = parseFloat(document.occ.kaszer_idle_narzad.value);
      var LAM_idleJ = parseFloat(document.occ.kaszer_idle_jazda.value);
      var LAMnesting = parseFloat(document.occ.product_paper_value1.value);
      var LAMorder_qty = parseFloat(document.occ.order_qty1_less.value);
      var LAMorder_ark = parseFloat(LAMorder_qty / LAMnesting).toFixed(2);
      var LAMsx = parseFloat(document.occ.sheetx1.value) / 1000;
      var LAMsy = parseFloat(document.occ.sheety1.value) / 1000;
      var LAMark_sqm = LAMsx * LAMsy;
      var error_show = '';

      // BEGIN AJAX call
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  LAMxmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  LAMxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      LAMxmlhttp.onreadystatechange = function() {
        if (LAMxmlhttp.readyState === 4 && LAMxmlhttp.status === 200) {
          var LAMdata = LAMxmlhttp.responseText; /// wartość speed_costH_utrudnienie
          var LAMdata_arr = LAMdata.split('_');
          var LAM_typ = LAMdata_arr[0] * 1;
          if ((isNaN(LAM_typ)) || (LAM_typ === 0)) {
            error_show += 'brak utrudnienia w zależności od typu; ';
          }
          var LAM_sqm = LAMdata_arr[1] * 1;
          if ((isNaN(LAM_sqm)) || (LAM_sqm === 0)) {
            error_show += 'brak utrudnienia w zależności od powierzchni; ';
          }
          var LAM_paper = LAMdata_arr[2] * 1;
          if ((isNaN(LAM_paper)) || (LAM_paper === 0)) {
            error_show += 'brak utrudnienia w zależności od papieru; ';
          }
          var LAM_speed_ = LAM_speed * LAM_typ * LAM_sqm * LAM_paper;
          if ((isNaN(LAM_speed_)) || (LAM_speed_ === 0)) {
            LAM_speed_ = 1;
          }

          //koszty operacyjne
          var LAM_narzad_cost = LAMnarzad * LAM_costN;
          if (isNaN(LAM_narzad_cost)) {
            LAM_narzad_cost = 0;
          }
          LAM_jazda_costT = LAMorder_ark / LAM_speed_; // calculate litho-lamination run times
          lithoLaminationRunTime = LAMorder_ark / LAM_speed_;

          var LAM_jazda_cost = LAM_jazda_costT * LAM_cost;
          if (isNaN(LAM_jazda_cost)) {
            LAM_jazda_cost = 0;
          }
          var LAM_idle_cost = ((LAMnarzad * LAM_idleN / 100) + (LAM_jazda_costT * LAM_idleJ / 100)) * LAM_costI;
          lithoLaminationIdleTime = (lithoLaminationSetupTime * LAM_idleN / 100) + (lithoLaminationRunTime* LAM_idleJ / 100); // calculate litholamination idle times
          if (isNaN(LAM_idle_cost)) {
            LAM_idle_cost = 0;
          }

          document.occ.cost_laminating_prod_time.value = parseFloat(LAM_jazda_costT).toFixed(2);
          document.occ.cost_laminating_setup_time.value = parseFloat(LAMnarzad).toFixed(2);
          document.occ.cost_laminating_narzad_real.value = parseFloat(LAM_narzad_cost).toFixed(2);
          document.occ.cost_laminating_narzad_info.value = 'czas narządu * koszt narządu = ' + LAMnarzad + ' * ' + LAM_costN;

          document.occ.cost_laminating_jazda_real.value = parseFloat(LAM_jazda_cost).toFixed(2);
          document.occ.cost_laminating_jazda_info.value = '(nakład ark/[wydajność]) * koszt jazdy = (' + LAMorder_ark + ' / [' + LAM_speed + ' * ' + LAM_typ + ' * ' + LAM_sqm + ' * ' + LAM_paper + ']) * ' + LAM_cost;

          document.occ.cost_laminating_idle_real.value = parseFloat(LAM_idle_cost).toFixed(2);
          document.occ.cost_laminating_idle_info.value = '(czas narządu * %IDLE + czas jazdy * %IDLE) * koszt IDLE = (' + LAMnarzad + '*' + LAM_idleN + '% + ' + LAM_jazda_costT + '*' + LAM_idleJ + '%) * ' + LAM_costI;

          var LAM_total = LAM_narzad_cost + LAM_jazda_cost + LAM_idle_cost;
          document.occ.cost_laminating_real.value = parseFloat(LAM_total).toFixed(2);
          if (LAM_total < LAMminimum_cost) {
            LAM_total = LAMminimum_cost;
          }
          document.occ.cost_laminating.value = parseFloat(LAM_total).toFixed(2);
          document.occ.cost_laminating_info.value = 'koszt narządu + koszt jazdy + koszt IDLE = ' + parseFloat(LAM_narzad_cost).toFixed(2) + ' + ' + parseFloat(LAM_jazda_cost).toFixed(2) + ' + ' + parseFloat(LAM_idle_cost).toFixed(2);

          ///koszty materiałowe
          var LAM_glueUse = LAMdata_arr[3] * 1; //zużycie kleju kg/m2
          if ((isNaN(LAM_glueUse)) || (LAM_glueUse === 0)) {
            error_show += 'brak zuzycia kleju dla typu surowca; ';
          }
          var LAM_glue = LAMorder_ark * LAMark_sqm * LAM_glueUse * LAM_cost_glue;
          document.occ.cost_laminating_material.value = parseFloat(LAM_glue).toFixed(2);
          document.occ.cost_laminating_material_info.value = '(nakład m2 * zużycie kleju) * koszt = ([' + LAMorder_ark + ' * ' + LAMark_sqm + '] * ' + LAM_glueUse + ') * ' + LAM_cost_glue;

          if (error_show !== "") {
            document.getElementById("laminating_error").style.display = "";
            document.occ.laminating_error_info.value = error_show;
          } else {
            document.getElementById("laminating_error").style.display = "none";
            document.occ.laminating_error_info.value = '';
          }
        }
      }; // END AJAX call

      LAMxmlhttp.open("GET", "order_calculation_create_cost_laminating.php?paper_id=" + LAM_paper_id + "&type_id=" + LAM_type_id + "&sqm_id=" + LAM_sqm_id, true);
      LAMxmlhttp.send();

    } else { // if not all required lamination data selected than informa about neccessary fields or the user wants to cancell litholamination

        if ((!LAM_type_id) && (!LAM_paper2_id)) { // no litholamination  and no second raw material selected - user wants to cancel
          LAM_sqm_id = 0;
          document.occ.laminating_sqm_id.value = ''; // zero out lamination square meters
          showHidePaper2Fields ();
          zeroOutData_LithoLamination ();
          document.getElementById("laminating_error").style.display = "none";
          document.occ.laminating_error_info.value = '';
        } else if (((LAM_type_id) && ((!LAM_sqm_id) || (!LAM_paper2_id)))) {
          document.getElementById("laminating_error").style.display = "";
          document.occ.laminating_error_info.value = 'Brak wybranego surowca II lub nie okreslono powierzchni kaszerowania.';
        } else if (((LAM_paper2_id) && ((!LAM_sqm_id) || (!LAM_type_id)))) {
          document.getElementById("laminating_error").style.display = "";
          document.occ.laminating_error_info.value = 'Nie określono rodzaju lub powierzchni kaszerowania.';
        }
      }
      setTimeout(calculateDieCuttingStripping(), TimeOut); // attach die cutting and stripping calculations
      setTimeout(count_cost2_dcting, TimeOut);
      setTimeout(count_cost_dcting2, TimeOut);

    }
    


/*
  function count_cost_dcting() { //szukam danych wycinanie
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var DCTnesting = parseFloat(document.occ.product_paper_value1.value);
    var DCTorder_qty = parseFloat(document.occ.order_qty1_less.value);
    var DCTark = DCTorder_qty / DCTnesting;
    var DCTgram = parseFloat(document.occ.gram1.value);
    DCTtype_id = document.occ.dctool_type_id.value;
    var DCTsx = parseFloat(document.occ.sheetx1.value) / 1000;
    var DCTsy = parseFloat(document.occ.sheety1.value) / 1000;
    var DCTsqm2 = DCTsx * DCTsx;
    var DCTcost_v_jazda = 0;
    var DCTcost_v_narzad = 0;
    var DCTcost_total = 0;
    document.occ.cost_dcting_narzad_info.value = '';
    document.occ.cost_dcting_narzad_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_dcting_jazda_info.value = '';
    document.occ.cost_dcting_jazda_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_dcting_idle_info.value = '';
    document.occ.cost_dcting_idle_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_dcting_prod_time.value = parseFloat(0).toFixed(2);
    document.occ.cost_dcting_setup_time.value = parseFloat(0).toFixed(2);

    if (DCTtype_id === "") {
      document.occ.cost_dcting_jazda_real.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  DCTxmlhttpf = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  DCTxmlhttpf = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      DCTxmlhttpf.onreadystatechange = function() {
        if (DCTxmlhttpf.readyState === 4 && DCTxmlhttpf.status === 200) {
          var DCTcost_v = DCTxmlhttpf.responseText; /// wartość speed_costH_setup1_setup2
          var DCTcost_v_arr = DCTcost_v.split('_');
          var DCTcost_v_speed = DCTcost_v_arr[0] * 1; // get die cutting efficiency
          var DCTcost_v_cost = DCTcost_v_arr[1] * 1; // get die cutting cost per hour
          var DCTcost_v_setup1 = DCTcost_v_arr[2] * 1; // get die cutting 1 setup time
          var DCTcost_v_setup2 = DCTcost_v_arr[3] * 1; // get die cutting 1 setup time
          DCTcost_v_idle_n = DCTcost_v_arr[4] * 1; // get die cutting idle % for setup
          DCTcost_v_idle_j = DCTcost_v_arr[5] * 1;  // get die cutting idle % for run
          var DCTcost_v_idle_c = DCTcost_v_arr[6] * 1; // get die cutting idle cost per hour
          var DCTcost_v_costN = DCTcost_v_arr[7] * 1; // get die cutting setup cost per hour
          var DCTcost_mach = DCTcost_v_arr[8]; //maszynana jakiej wycinam 1.00000-Iberica 2.00000-tygiel mały 3.00000-tygiel duży
          document.occ.cost_dcting_machin.value = parseFloat(DCTcost_mach).toFixed(0);

          DCTtime_v_jazda = 0;
          if (DCTcost_v_speed > 0) {
            DCTtime_v_jazda = (DCTark / DCTcost_v_speed);
            dieCuttingRunTime = (DCTark / DCTcost_v_speed);
          }
          var DCTcost_v_jazda = parseFloat(DCTtime_v_jazda * DCTcost_v_cost);
          if ((DCTcost_v_setup2) && (DCTcost_v_setup2 > 1)) {
            DCTcost_v_setup1 = DCTcost_v_setup1 * DCTcost_v_setup2; // a tu o co chodzi - dlaczego setup 1 jest przemnazany przez setup 2?
          } else {
            DCTcost_v_setup2 = 1;
          }
          DCTtime_v_narzad = DCTcost_v_setup1 / 60;
          dieCuttingSetupTime = DCTcost_v_setup1 / 60;
          var DCTcost_v_narzad = parseFloat(DCTtime_v_narzad * DCTcost_v_costN);
          document.occ.cost_dcting_prod_time.value = parseFloat(DCTtime_v_jazda).toFixed(2);
          document.occ.cost_dcting_setup_time.value = parseFloat(DCTtime_v_narzad).toFixed(2);

          var DCTcost_v_idle = ((DCTtime_v_narzad * DCTcost_v_idle_n / 100) + (DCTtime_v_jazda * DCTcost_v_idle_j / 100)) * DCTcost_v_idle_c;
          dieCuttingIdleTime = ((dieCuttingSetupTime * DCTcost_v_idle_n / 100) + dieCuttingRunTime* DCTcost_v_idle_j / 100); // calculate die cutting idle time
          document.occ.cost_dcting_jazda_real.value = parseFloat(DCTcost_v_jazda).toFixed(2);
          document.occ.cost_dcting_jazda_info.value = '[(nakład arkuszy)/wydajność] * cena pracy = [(' + DCTorder_qty + '/' + DCTnesting + ')/' + DCTcost_v_speed + ']*' + DCTcost_v_cost;

          document.occ.cost_dcting_narzad_real.value = parseFloat(DCTcost_v_narzad).toFixed(2);
          document.occ.cost_dcting_narzad_info.value = '(czas setup1*wydłużenie setup)/60 * cena pracy = (' + DCTcost_v_setup1 + '/60) * ' + DCTcost_v_costN;

          document.occ.cost_dcting_idle_real.value = parseFloat(DCTcost_v_idle).toFixed(2);
          document.occ.cost_dcting_idle_info.value = '((czas narządu * %IDLE) + (czas jazdy * %IDLE)) * koszt IDLE/h = ((' + DCTtime_v_narzad + ' * ' + DCTcost_v_idle_n + '/100) + (' + DCTtime_v_jazda + ' * ' + DCTcost_v_idle_j + '/100)) * ' + DCTcost_v_idle_c;

          var DCTcost_total = DCTcost_v_jazda + DCTcost_v_narzad + DCTcost_v_idle;

        }
      };

      if (DCTsx > DCTsy) {
        var DCTa = DCTsx;
        var DCTb = DCTsy;
      } else {
       DCTa = DCTsy;
       DCTb = DCTsx;
      }
      DCTxmlhttpf.open("GET", "order_calculation_create_cost_dcting.php?order_ark=" + DCTark + "&nesting=" + DCTnesting + "&gram1=" + DCTgram + "&var_id=" + DCTtype_id + "&a=" + DCTa + "&b=" + DCTb, true);
      DCTxmlhttpf.send();
    }

    setTimeout(count_cost2_dcting, TimeOut);
    setTimeout(count_cost_dcting2, TimeOut);
  }
*/
  function count_cost_dcting2() {
    var DCTmachin = parseFloat(document.occ.cost_dcting_machin.value).toFixed(0);
    var DCTminimum_cost = 0;
    if (DCTmachin === 1) {
      DCTminimum_cost = parseFloat(document.occ.cost_minimum_dcting1.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    }
    if (DCTmachin === 2) {
      DCTminimum_cost = parseFloat(document.occ.cost_minimum_dcting2.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    }
    if (DCTmachin === 3) {
      DCTminimum_cost = parseFloat(document.occ.cost_minimum_dcting3.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    }
    var DCTtype_id = document.occ.dctool_type_id.value;
    var DCT_jazda = parseFloat(document.occ.cost_dcting_jazda_real.value);
    var DCT_narzad = parseFloat(document.occ.cost_dcting_narzad_real.value);
    var DCT_idle = parseFloat(document.occ.cost_dcting_idle_real.value);

    ///koszt łączny
    var DCTcost_total = DCT_jazda + DCT_narzad + DCT_idle;
    document.occ.cost_dcting_real.value = parseFloat(DCTcost_total).toFixed(2);
    if ((DCTcost_total < DCTminimum_cost) && (DCTtype_id)) {
      DCTcost_total = DCTminimum_cost;
    }
    document.occ.cost_dcting.value = parseFloat(DCTcost_total).toFixed(2);
    document.occ.cost_dcting_info.value = 'koszt narządu + koszt jazdy + koszt IDLE = ' + DCT_narzad + ' + ' + DCT_jazda + ' + ' + DCT_idle;
  }

  function count_cost2_dcting() { //szukam danych wycinanie
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var DC2Tnesting = parseFloat(document.occ.product_paper_value1.value);
    var DC2Torder_qty = parseFloat(document.occ.order_qty1_less.value);
    var DC2Tark = DC2Torder_qty / DC2Tnesting;
    var DC2Tgram = parseFloat(document.occ.gram1.value);
    var DC2Ttype_id = document.occ.dctool2_type_id.value;
    var DC2Tsx = parseFloat(document.occ.sheetx1.value) / 1000;
    var DC2Tsy = parseFloat(document.occ.sheety1.value) / 1000;
    var DC2Tsqm2 = DC2Tsx * DC2Tsx;
    var dieCutting2TotalCost = 0;
    document.occ.cost_dcting2_narzad_info.value = '';
    document.occ.cost_dcting2_narzad_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_dcting2_jazda_info.value = '';
    document.occ.cost_dcting2_jazda_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_dcting2_idle_info.value = '';
    document.occ.cost_dcting2_idle_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_dcting2_prod_time.value = parseFloat(0).toFixed(2);
    document.occ.cost_dcting2_setup_time.value = parseFloat(0).toFixed(2);

    if (DC2Ttype_id === "") {
      document.occ.cost_dcting2_jazda_real.value = parseFloat(0).toFixed(2);
    } else {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  DC2Txmlhttpf = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  DC2Txmlhttpf = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      DC2Txmlhttpf.onreadystatechange = function() {
        if (DC2Txmlhttpf.readyState === 4 && DC2Txmlhttpf.status === 200) {
          // define Variables
          var dieCutting2Speed;
          var dieCutting2SetupCost1;
          var dieCutting2SetupCost2;

          var dieCutting2SetupCost_PerHour;
          var dieCutting2RunCost_PerHour;
          var dieCutting2IdleCost_PerHour;

          var dieCutting2PreferredMachine;
          var dieCutting2IdlePercentage_Run;
          var dieCutting2IdlePercentage_Setup;

          var dieCutting2RunCost;
          var dieCutting2SetupCost;
          var dieCutting2IdleCost;
          var dieCutting2TotalCost;

          var dieCutting2RunTime = 0;
          var dieCutting2SetupTime = 0;
          var dieCutting2IdleTime = 0;
          var dieCutting2TotalTime = 0;

          var DC2Tcost_v = DC2Txmlhttpf.responseText; /// wartość speed_costH_setup1_setup2
          var DC2Tcost_v_arr = DC2Tcost_v.split('_');
          dieCutting2Speed = DC2Tcost_v_arr[0] * 1;
          dieCutting2RunCost_PerHour = DC2Tcost_v_arr[1] * 1;
          dieCutting2SetupCost1 = DC2Tcost_v_arr[2] * 1;
          dieCutting2SetupCost2 = DC2Tcost_v_arr[3] * 1;
          dieCutting2IdlePercentage_Setup = DC2Tcost_v_arr[4] * 1;
          dieCutting2IdlePercentage_Run = DC2Tcost_v_arr[5] * 1;
          dieCutting2IdleCost_PerHour = DC2Tcost_v_arr[6] * 1;
          dieCutting2SetupCost_PerHour = DC2Tcost_v_arr[7] * 1;
          dieCutting2PreferredMachine = DC2Tcost_v_arr[8]; //maszynana jakiej wycinam 1.00000-Iberica 2.00000-tygiel mały 3.00000-tygiel duży
          document.occ.cost_dcting2_machin.value = parseFloat(dieCutting2PreferredMachine).toFixed(0);

        // define variables

          if ((dieCutting2SetupCost2) && (dieCutting2SetupCost2 > 1)) {
            dieCutting2SetupCost1 = dieCutting2SetupCost1 * dieCutting2SetupCost2;
          } else {
            dieCutting2SetupCost2 = 1;
          }

        // calculate die cutting 2 times
          dieCutting2SetupTime = dieCutting2SetupCost1 / 60;
          if (dieCutting2Speed > 0) {dieCutting2RunTime = (DC2Tark / dieCutting2Speed);}
          dieCutting2IdleTime = dieCutting2SetupTime * dieCutting2IdlePercentage_Setup / 100 + dieCutting2RunTime* dieCutting2IdlePercentage_Run / 100; // calculate die cutting idle time

        // round calculated times
          dieCutting2RunTime = Math.round (dieCutting2RunTime*100)/100;
          dieCutting2SetupTime = Math.round (dieCutting2SetupTime*100)/100;
          dieCutting2IdleTime = Math.round (dieCutting2IdleTime*100)/100;
          dieCutting2TotalTime = Math.round (dieCutting2TotalTime*100)/100;
        // calculate die cutting 2 costs
          dieCutting2SetupCost = parseFloat(dieCutting2SetupTime * dieCutting2SetupCost_PerHour);
          dieCutting2RunCost = parseFloat(dieCutting2RunTime * dieCutting2RunCost_PerHour);
          dieCutting2IdleCost = parseFloat(dieCutting2IdleTime * dieCutting2IdleCost_PerHour);
          dieCutting2TotalCost = dieCutting2RunCost + dieCutting2SetupCost + dieCutting2IdleCost;
        // roundup convert die cutting2 costs
          dieCutting2SetupCost = precise_round(dieCutting2SetupCost,2);
          dieCutting2RunCost = precise_round(dieCutting2RunCost,2);
          dieCutting2IdleCost = precise_round(dieCutting2IdleCost,2);
          dieCutting2TotalCost = precise_round(dieCutting2TotalCost,2);
        // generate and fill info strings
          document.occ.cost_dcting2_jazda_info.value = '[(nakład arkuszy)/wydajność] * cena pracy = [(' + DC2Torder_qty + '/' + DC2Tnesting + ')/' + dieCutting2Speed + ']*' + dieCutting2RunCost_PerHour;
          document.occ.cost_dcting2_narzad_info.value = '(czas setup1*wydłużenie setup)/60 * cena pracy = (' + dieCutting2SetupCost1 + '/60) * ' + dieCutting2SetupCost_PerHour;
          document.occ.cost_dcting2_idle_info.value = '((czas narządu * %IDLE) + (czas jazdy * %IDLE)) * koszt IDLE/h = ((' + dieCutting2SetupTime + ' * ' + dieCutting2IdlePercentage_Setup + '/100) + (' + dieCutting2RunTime + ' * ' + dieCutting2IdlePercentage_Run + '/100)) * ' + dieCutting2IdleCost_PerHour;
        // calculate totalTime and convert data to hours : minutes
          dieCutting2SetupTime = hoursTohhmm(dieCutting2SetupTime);
          dieCutting2RunTime = hoursTohhmm(dieCutting2RunTime);
          dieCutting2IdleTime = hoursTohhmm(dieCutting2IdleTime);
          dieCutting2TotalTime = hoursTohhmm(dieCutting2TotalTime);
        // print diecutting times on screen
          document.occ.cost_dcting2_prod_time.value = dieCutting2RunTime;
          document.occ.cost_dcting2_setup_time.value = dieCutting2SetupTime;
          $("#dieCutting2SetupTime").val(dieCutting2SetupTime);
          $("#dieCutting2RunTime").val(dieCutting2RunTime);
          $("#dieCutting2IdleTime").val(dieCutting2IdleTime);
          $("#dieCutting2TotalTime").val(dieCutting2TotalTime);
        // display costs on screen
          document.occ.cost_dcting2_jazda_real.value = parseFloat(dieCutting2RunCost).toFixed(2);
          document.occ.cost_dcting2_narzad_real.value = parseFloat(dieCutting2SetupCost).toFixed(2);
          document.occ.cost_dcting2_idle_real.value = parseFloat(dieCutting2IdleCost).toFixed(2);

        }
      };

      if (DC2Tsx > DC2Tsy) {
        var DC2Ta = DC2Tsx;
        var DC2Tb = DC2Tsy;
      } else {
        DC2Ta = DC2Tsy;
        DC2Tb = DC2Tsx;
      }
      DC2Txmlhttpf.open("GET", "GetData/order_calculation_create_cost_dcting.php?order_ark=" + DC2Tark + "&nesting=" + DC2Tnesting + "&gram1=" + DC2Tgram + "&var_id=" + DC2Ttype_id + "&a=" + DC2Ta + "&b=" + DC2Tb, true);
      DC2Txmlhttpf.send();
    }

    setTimeout(count_cost_bigowanie, TimeOut);
    setTimeout(count_cost2_dcting2, TimeOut);
  }
  

  function count_cost2_dcting2() {
    var DC2Tmachin = parseFloat(document.occ.cost_dcting2_machin.value).toFixed(0);
    var DC2Tminimum_cost = 0;
    if (DC2Tmachin === 1) {
      var DCTminimum_cost = parseFloat(document.occ.cost_2minimum_dcting1.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    }
    if (DC2Tmachin === 2) {
      DCTminimum_cost = parseFloat(document.occ.cost_2minimum_dcting2.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    }
    if (DC2Tmachin === 3) {
      DCTminimum_cost = parseFloat(document.occ.cost_2minimum_dcting3.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    }
    var DC2Ttype_id = document.occ.dctool2_type_id.value;
    var DC2T_jazda = parseFloat(document.occ.cost_dcting2_jazda_real.value);
    var DC2T_narzad = parseFloat(document.occ.cost_dcting2_narzad_real.value);
    var DC2T_idle = parseFloat(document.occ.cost_dcting2_idle_real.value);

    ///koszt łączny
    var dieCuttingTotalCost = DC2T_jazda + DC2T_narzad + DC2T_idle;
    document.occ.cost_dcting2_real.value = parseFloat(dieCuttingTotalCost).toFixed(2);
    if ((dieCuttingTotalCost < DC2Tminimum_cost) && (DC2Ttype_id)) {
      dieCuttingTotalCost = DC2Tminimum_cost;
    }
    document.occ.cost_dcting2.value = parseFloat(dieCuttingTotalCost).toFixed(2);
    document.occ.cost_dcting2_info.value = 'koszt narządu + koszt jazdy + koszt IDLE = ' + DC2T_narzad + ' + ' + DC2T_jazda + ' + ' + DC2T_idle;
  }


  function count_cost_bigowanie() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    //var BIGAminimum_cost    = parseFloat(document.occ.cost_minimum.value);

    var BIGAqty = parseFloat(document.occ.order_qty1_less.value);
    var BIGAcost = parseFloat(document.occ.biga_cost_box.value);
    var BIGAcost_total2 = 0;
    document.occ.cost_bigowanie_info.value = '';
    document.occ.cost_bigowanie.value = parseFloat(BIGAcost_total2).toFixed(2);
    document.occ.cost_trans_bigowanie.value = parseFloat(0).toFixed(2);

    if (BIGAcost) {
      BIGAcost_total2 = BIGAqty * BIGAcost;
      if (isNaN(BIGAcost_total2)) {
        BIGAcost_total2 = 0;
      }
      document.occ.cost_bigowanie_info.value = 'ilość sztuk * koszt bigowania 1sztuki = ' + BIGAqty + ' * ' + BIGAcost + ' = ' + BIGAcost_total2;
      //if (BIGAcost_total2 < BIGAminimum_cost) { BIGAcost_total2 = BIGAminimum_cost; }
      document.occ.cost_bigowanie.value = parseFloat(BIGAcost_total2).toFixed(2);
      document.occ.cost_trans_bigowanie.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
    }

    setTimeout(count_cost_falc(''), TimeOut);
  }

  function count_cost_falc(FALCfalc_type) {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    //var FALCminimum_cost    = parseFloat(document.occ.cost_minimum.value); if (isNaN(FALCminimum_cost)) { FALCminimum_cost = 0; }
    //document.occ.falc_cost.value = "";
    //document.occ.falc_cost_box.value = "";
    document.occ.cost_falc_info.value = '';
    document.occ.cost_trans_falc.value = parseFloat(0).toFixed(2);

    if (FALCfalc_type === "cost") {
      var FALCcost_total = parseFloat(document.occ.falc_cost.value);
      document.occ.falc_cost_box.value = "";
      document.occ.cost_falc_info.value = 'koszt całości usługi = ' + FALCcost_total;
      document.occ.cost_trans_falc.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
    }
    if (FALCfalc_type === "cost_box") {
      var FALCqty = parseFloat(document.occ.order_qty1_less.value);
      var FALCcost = parseFloat(document.occ.falc_cost_box.value);
      FALCcost_total = FALCqty * FALCcost;
      document.occ.falc_cost.value = "";
      document.occ.cost_falc_info.value = 'koszt wykonania 1 sztuki * ilość sztuk = ' + FALCcost + ' * ' + FALCqty + ' = ' + FALCcost_total;
      document.occ.cost_trans_falc.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
    }
    if (FALCfalc_type === "") {
      FALCcost_total = parseFloat(document.occ.falc_cost.value);
      if (FALCcost_total) {
        document.occ.falc_cost_box.value = "";
        document.occ.cost_falc_info.value = 'koszt całości usługi = ' + FALCcost_total;
        document.occ.cost_trans_falc.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
      } else {
        FALCcost = parseFloat(document.occ.falc_cost_box.value);
        if (FALCcost) {
          FALCqty = parseFloat(document.occ.order_qty1_less.value);
          FALCcost_total = FALCqty * FALCcost;
          document.occ.falc_cost.value = "";
          document.occ.cost_falc_info.value = 'koszt wykonania 1 sztuki * ilość sztuk = ' + FALCcost + ' * ' + FALCqty + ' = ' + FALCcost_total;
          document.occ.cost_trans_falc.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
        }
      }
    }

    if (isNaN(FALCcost_total)) {
      FALCcost_total = 0;
    }
    //if ((FALCcost_total < FALCminimum_cost) && (FALCcost_total > 0)) { FALCcost_total = FALCminimum_cost; }
    document.occ.cost_falc.value = parseFloat(FALCcost_total).toFixed(2);

    setTimeout(count_cost_stample(''), TimeOut);
  }

  function count_cost_stample(STAMtype) {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    //var STAMminimum_cost    = parseFloat(document.occ.cost_minimum.value);
    //document.occ.stample_cost_box.value = "";
    //document.occ.stample_cost.value = "";
    document.occ.cost_stample_info.value = '';
    document.occ.cost_trans_stample.value = parseFloat(0).toFixed(2);

    if (STAMtype === "cost") {
      var STAMcost_total = parseFloat(document.occ.stample_cost.value);
      document.occ.stample_cost_box.value = "";
      document.occ.cost_stample_info.value = 'koszt całości usługi = ' + STAMcost_total;
      document.occ.cost_trans_stample.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
    }
    if (STAMtype === "cost_box") {
      var STAMqty = parseFloat(document.occ.order_qty1_less.value).toFixed(2);
      var STAMcost = parseFloat(document.occ.stample_cost_box.value).toFixed(2);
      var STAMcost_total = STAMqty * STAMcost;
      document.occ.stample_cost.value = "";
      document.occ.cost_stample_info.value = 'koszt wykonania 1 sztuki * ilość sztuk = ' + STAMcost + ' * ' + STAMqty + ' = ' + STAMcost_total;
      document.occ.cost_trans_stample.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
    }
    if (STAMtype === "") {
      var STAMcost_total = parseFloat(document.occ.stample_cost.value);
      if (STAMcost_total) {
        document.occ.stample_cost_box.value = "";
        document.occ.cost_stample_info.value = 'koszt całości usługi = ' + STAMcost_total;
        document.occ.cost_trans_stample.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
      } else {
        var STAMcost = parseFloat(document.occ.stample_cost_box.value);
        if (STAMcost) {
          var STAMqty = parseFloat(document.occ.order_qty1_less.value).toFixed(2);
          var STAMcost_total = STAMqty * STAMcost;
          document.occ.stample_cost.value = "";
          document.occ.cost_stample_info.value = 'koszt wykonania 1 sztuki * ilość sztuk = ' + STAMcost + ' * ' + STAMqty + ' = ' + STAMcost_total;
          document.occ.cost_trans_stample.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
        }
      }
    }

    if (isNaN(STAMcost_total)) {
      STAMcost_total = 0;
    }
    //if ((STAMcost_total < STAMminimum_cost) && (STAMcost_total > 0)) { STAMcost_total = STAMminimum_cost; }
    document.occ.cost_stample.value = parseFloat(STAMcost_total).toFixed(2);

    setTimeout(calculateUpSeparation (), TimeOut); // attach up separation calculations
    setTimeout(count_cost_window(''), TimeOut);
  }


  /*function count_cost_manual_work() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    document.occ.cost_manual_work.value = parseFloat(0).toFixed(2);
    document.occ.cost_manual_work_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_manual_work_info.value = '';
    document.occ.cost_manual_work_jazda_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_manual_work_jazda_info.value = '';
    document.occ.cost_manual_work_idle_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_manual_work_idle_info.value = '';
    document.occ.cost_manual_work_prod_time.value = parseFloat(0).toFixed(2);

    //var manual_work_cost  = parseFloat(document.occ.cost_minimum.value);
    MWqty = document.occ.order_qty1_less.value;
    MWnesting = parseFloat(document.occ.product_paper_value1.value);
    if (isNaN(MWnesting)) {
      MWnesting = 0;
    }
    MWot_id = document.occ.order_type_id.value;
    var MWmwu_id = document.occ.separationProcessTypeID.value;
    if ((MWqty) && (MWot_id)) {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  OTMWxmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
    var    OTMWxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      OTMWxmlhttp.onreadystatechange = function() {
        if (OTMWxmlhttp.readyState === 4 && OTMWxmlhttp.status === 200) {
          var OTMWdata_value = OTMWxmlhttp.responseText; /// wartość speed_costH_utrudnienie
          var OTMWdata_value_arr = OTMWdata_value.split('_');
          OTMWdata_value_speed = OTMWdata_value_arr[0] * 1;
          var OTMWdata_value_cost = OTMWdata_value_arr[1] * 1;
          OTMWdata_value_hard = OTMWdata_value_arr[2] * 1;
          var OTMWdata_value_time = ((MWqty / MWnesting) / (OTMWdata_value_speed * OTMWdata_value_hard));
          separationRunTime = ((MWqty / MWnesting) / (OTMWdata_value_speed * OTMWdata_value_hard)); //calculate manual stripping run time
          if (isNaN(OTMWdata_value_time)) {
            OTMWdata_value_time = 0;
            separationRunTime=0;
          }
          var OTMWdata_value_ = parseFloat(OTMWdata_value_time * OTMWdata_value_cost);
          var OTMWdata_idle_jazda = OTMWdata_value_arr[3] * 1;
          var OTMWdata_idle_cost = OTMWdata_value_arr[4] * 1;
          var OTMWdata_idle_total = (OTMWdata_value_time * OTMWdata_idle_jazda / 100) * OTMWdata_idle_cost;
          separationIdleTime = separationRunTime * OTMWdata_idle_jazda / 100; //calculate manual stripping idle time
          document.occ.cost_manual_work_prod_time.value = parseFloat(OTMWdata_value_time).toFixed(2);
          document.occ.cost_manual_work_jazda_real.value = parseFloat(OTMWdata_value_).toFixed(2);
          document.occ.cost_manual_work_jazda_info.value = '[nakład arkuszy/(wydaność *utrudnienie)]*cena pracy = [(' + MWqty + '/' + MWnesting + ')/(' + OTMWdata_value_speed + '*' + OTMWdata_value_hard + ')]*' + OTMWdata_value_cost;

          document.occ.cost_manual_work_idle_real.value = parseFloat(OTMWdata_idle_total).toFixed(2);
          document.occ.cost_manual_work_idle_info.value = '(czas jazdy * %IDLE) * koszt IDLE/h = (' + parseFloat(OTMWdata_value_time).toFixed(2) + ' * ' + OTMWdata_idle_jazda + '/100) * ' + OTMWdata_idle_cost;

          var OTMWdata_value_total = OTMWdata_value_ + OTMWdata_idle_total;
          document.occ.cost_manual_work_real.value = parseFloat(OTMWdata_value_total).toFixed(2);
          //if (OTMWdata_value < manual_work_cost) { OTMWdata_value = manual_work_cost; }
          document.occ.cost_manual_work.value = parseFloat(OTMWdata_value_total).toFixed(2);
          document.occ.cost_manual_work_info.value = 'koszt jazdy + koszt IDLE = ' + parseFloat(OTMWdata_value_).toFixed(2) + ' + ' + parseFloat(OTMWdata_idle_total).toFixed(2);

        }
      };
      // get manual work speeds based on MWot_id => order type ID ; MWqty => order_qty ; MWmwu_id => difficulties type (number of windows on sheet)
      OTMWxmlhttp.open("GET", "order_calculation_create_cost_manual_work.php?var_id=" + MWot_id + "&qty=" + MWqty + "&mwu_id=" + MWmwu_id, true);
      OTMWxmlhttp.send();
    }

    setTimeout(count_cost_window(''), TimeOut);
  }
*/
  function count_cost_window(types) {

    // TODO: remake count_cost_window function to make it more readable and in line with other js coding.
    // TODO: make a separate outsourcing button and functionality for window patching operation
    // types variable is filled with either "cost" or "times" by onchange call from within window_glue_cost_box or window_glue_timeS_box

    // deine Variables
      var externalWindowPatchingTotalCosts = '';
      var WINcost_total3 = '';

      var WINminimum_cost = parseFloat(document.occ.cost_minimum_window.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
      var WINqty = parseFloat(document.occ.order_qty1_less.value);
      var WINcost = parseFloat(document.occ.window_glue_cost_box.value);
      var WINtimeS = parseFloat(document.occ.window_glue_timeS_box.value);

    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;


    // zero out internal window patching data
      document.occ.cost_window.value = parseFloat(0).toFixed(2);
      document.occ.cost_window_info.value = '';
      // document.occ.cost_trans_window.value = parseFloat(0).toFixed(2); // no internal window patching transport costs.
      document.occ.cost_window_glue_prod_time.value = parseFloat(0);

    // zero out external window patching data
      document.occ.externalWindowPatching.value =  parseFloat(0).toFixed(2);
      document.occ.externalWindowPatchingTransport.value = parseFloat(0);
      document.occ.externalWindowPatching_info.value = '';


    if ((types === "cost") && (WINcost)) { //licze od ceny
      windowPatchingType = "external"; // if cost selected then window patching is done outside
      document.occ.windowPatchingType.value = windowPatchingType; // write value down to hidden field

      var externalWindowPatchingTotalCosts = WINqty * WINcost;
      if (isNaN(externalWindowPatchingTotalCosts)) {
        externalWindowPatchingTotalCosts = 0;
      }
      document.occ.externalWindowPatching_info.value = 'ilość sztuk * koszt na 1 sztuke = ' + WINqty + ' * ' + WINcost + ' = ' + externalWindowPatchingTotalCosts;
      if (externalWindowPatchingTotalCosts < WINminimum_cost) {
        externalWindowPatchingTotalCosts = WINminimum_cost;
      }
      document.occ.externalWindowPatching.value = parseFloat(externalWindowPatchingTotalCosts).toFixed(2);
      document.occ.externalWindowPatchingTransport.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2); // transport in case of external patching

      ///licze łaczny szas pracy...
      var WINcost_pln_h = parseFloat(document.occ.glue_type_cost_h.value);
      var WINtimeProd = externalWindowPatchingTotalCosts / WINcost_pln_h; // work time in hours calculated backwards
      if (isNaN(WINtimeProd)) {
        WINtimeProd = 0;
      }
      document.occ.cost_window_glue_prod_time.value = parseFloat(WINtimeProd).toFixed(0);

      ///counting work time in seconds required per box
      var WINtimeS = (WINtimeProd * 3600) / WINqty;
      if (isNaN(WINtimeS)) {
        WINtimeS = 0;
      }
      document.occ.window_glue_timeS_box.value = parseFloat(WINtimeS).toFixed(0);

      document.getElementById("td_w1").style.display = "";
      document.getElementById("td_w2").style.display = "";
    }

    if ((types === "time") && (WINtimeS)) { //licze od ceny
      windowPatchingType = "internal"; // if cost selected then window patching is done inside
      document.occ.windowPatchingType.value = windowPatchingType; // write value down to hidden field
      ///licze łaczny szas pracy...
      var WINtimeProd = (WINtimeS / 3600) * WINqty; // work time in hours calculated backwards
      if (isNaN(WINtimeProd)) {
        WINtimeProd = 0;
      }
      document.occ.cost_window_glue_prod_time.value = parseFloat(WINtimeProd).toFixed(0);

      ///licze łączny koszt pracy
      var WINcost_pln_h = parseFloat(document.occ.glue_type_cost_h.value); //pln/h

      var WINcost_total3 = (WINtimeS / 3600) * WINqty * WINcost_pln_h;
      if (isNaN(WINcost_total3)) {
        WINcost_total3 = 0;
      }
      document.occ.cost_window_info.value = 'czas pracy 1 sztuki * ilość sztuk * koszt robocizny = ' + WINtimeS + '[s] * ' + WINqty + '[szt] * ' + WINcost_pln_h + '[pln/h] = ' + WINcost_total3;
      if (WINcost_total3 < WINminimum_cost) {
        WINcost_total3 = WINminimum_cost;
      }
      document.occ.cost_window.value = parseFloat(WINcost_total3).toFixed(2);
      //document.occ.cost_trans_window.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2); // no transport in case of internal patching


      //licze cene za sztuke
      var WINcost_box = WINcost_total3 / WINqty;
      if (isNaN(WINcost_box)) {
      var WINcost_sztuk = 0;
      }
      document.occ.window_glue_cost_box.value = parseFloat(WINcost_box).toFixed(2);

      document.getElementById("td_w1").style.display = "";
      document.getElementById("td_w2").style.display = "";
    }

    if ((types === "") && (WINcost)) { //licze od ceny
      windowPatchingType = document.occ.windowPatchingType.value; // if no window patching type selected (for ex. calculation is beeing opened up) get its value from hidden field
      var WINcost_total3 = WINqty * WINcost;
      if (isNaN(WINcost_total3)) {
        WINcost_total3 = 0;
      }
      document.occ.cost_window_info.value = 'ilość sztuk * koszt na 1 sztuke = ' + WINqty + ' * ' + WINcost + ' = ' + WINcost_total3;
      if (WINcost_total3 < WINminimum_cost) {
        WINcost_total3 = WINminimum_cost;
      }
      document.occ.cost_window.value = parseFloat(WINcost_total3).toFixed(2);
      // document.occ.cost_trans_window.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2); // no internal window patching transport costs.

      ///licze łaczny szas pracy...
      var WINtimeProd = (WINtimeS / 60 / 60) * WINqty; ///czas pracy - minuty
      if (isNaN(WINtimeProd)) {
        WINtimeProd = 0;
      }
      document.occ.cost_window_glue_prod_time.value = parseFloat(WINtimeProd).toFixed(0);

      document.getElementById("td_w1").style.display = "";
      document.getElementById("td_w2").style.display = "";
    }

    if (WINcost_total3 === "") {
      document.getElementById("td_w1").style.display = "none";
      document.getElementById("td_w2").style.display = "none";
      document.occ.window_foil_type_id.value = '';
      document.occ.window_foil_sqm.value = '';
    }


    ////// materiaówka do wklejania okienek
    document.occ.cost_window_foil.value = parseFloat(0).toFixed(2);
    document.occ.cost_window_foil_info.value = 'sd';
    var WINwindow_foil_type_id = document.occ.window_foil_type_id.value;
    var WINwindow_foil_sqm = document.occ.window_foil_sqm.value;
    if ((WINwindow_foil_type_id) && (WINwindow_foil_sqm)) { ///nie ma wpisanych ilości
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  WINxmlhttpf = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var  WINxmlhttpf = new window.ActiveXObject("Microsoft.XMLHTTP");
        alert('sad asd');
      }
      WINxmlhttpf.onreadystatechange = function() {
        if (WINxmlhttpf.readyState === 4 && WINxmlhttpf.status === 200) {
          var WINcost_v = WINxmlhttpf.responseText;
          var WINcost_v = WINcost_v * 1; //pln/m2                                                                 s
          if (WINcost_v > "0") {
            var WINfoil_cost = WINqty * WINwindow_foil_sqm / 10000 * WINcost_v;

            document.occ.cost_window_foil.value = parseFloat(WINfoil_cost).toFixed(2);
            document.occ.cost_window_foil_info.value = 'nakład sztuk * powierzchnia sztuki * cena folii = ' + WINqty + ' * ' + WINwindow_foil_sqm + '/10000 * ' + WINcost_v;
          }
        }
      };

      WINxmlhttpf.open("GET", "order_calculation_create_window_foil.php?var_id=" + WINwindow_foil_type_id);
      WINxmlhttpf.send();
    }

    setTimeout(calculateManualGluing(), TimeOut); // attach new manual gluing calculation functionality
    setTimeout(calculateAutomaticGluing(), TimeOut); //attach new automatic gluing calculation functionality
    setTimeout(count_cost_transport(''), TimeOut); // calculate transportation costs
  }


  function count_cost_glue(manualGluingInputType) { /// klejenie ręczne
    // freeze calculation for the duration of running this function
      //document.getElementById("div_calculate").style.display = "";
      //document.getElementById("input_save_input").disabled = true;

    // define variables
      // GTglue_type_id - global variable
      // GLUqty - global variable
      // GT_idleP - global variable
      //var GLUcost_old = parseFloat(document.occ.cost_glue.value); deactivated
      var GTcost_h = '';
      var GTwaste =0;
      var manualGluingTypeID = ''; //type of gluing
      var gluingQty=0; // gluing quantity
      var gluingWaste=0; // gluing waste percentage
      var cost_glue = 0; // zero out cost of gluing
      var cost_glue_box =0; // cost of gluing per box
      var cost_glue_total =0; // cost of total gluing


    /*populate variables
      GTcost_h = parseFloat(document.occ.glue_type_cost_h.value); // cost of manual gluing per hour
      GTglue_type_id = document.occ.glue_type_id.value; // get manual gluing type selected from field to query database for efficiency data
      manualGluingTypeID = document.occ.glue_type_id.value; // get manual gluing type selected from field to query database for efficiency data
      GLUqty = parseFloat(document.occ.order_qty1_less.value); // general qty to be produced
      gluingQty = parseFloat(document.occ.order_qty1_less.value); // general qty to be produced
      GTwaste = parseFloat(document.occ.waste_proc1.value); // waste percentage on manual gluing
      gluingWaste = parseFloat(document.occ.waste_proc1.value); // waste percentage on manual gluing
      GT_idleP = document.occ.glue_type_idleP.value;

      showHideManualGluingFields (manualGluingTypeID); // show or hide particular fields depending on the chosen glue type
      /*
      if (GTglue_type_id) {
        document.getElementById("td_gr1").style.display = "";
        document.getElementById("tr_gr2").style.display = "";
        document.getElementById("td_gr3").rowSpan = 2;
      } else {
        document.getElementById("td_gr1").style.display = "none";
        document.getElementById("tr_gr2").style.display = "none";
        document.occ.glue_type_slim_check.checked = false;
        document.occ.glue_type_tape_check.checked = false;
        document.occ.glue_type_window_check.checke = false;
        document.occ.cost_glue_box.value = '';
        document.occ.cost_glue_total.value = '';
        document.getElementById("td_gr3").rowSpan = 1;
      }
      */

   /*
    if (isNaN(GT_idleP)) {GT_idleP = 0; } // zero out variable if NaN

    // get actual manual gluing qty with waste percentage
    GLUqty = GLUqty + GLUqty * (GTwaste / 100);
    gluingQty = gluingQty + gluingQty * (gluingWaste/ 100);

      // get manual gluing time and costs based on user input
      var resultsOf_calculateManualGluingCosts_UserInput = calculateManualGluingCosts_UserInput (manualGluingInputType, gluingQty);
      //populate variables with data returned as object from above function
      GTcost_time = resultsOf_calculateManualGluingCosts_UserInput.gluingTime;
      cost_glue   = resultsOf_calculateManualGluingCosts_UserInput.gluingCost;
      // populate hidden fields with results
      document.occ.cost_glue_prod_time.value = parseFloat(GTcost_time).toFixed(2);
*/

    // if cost calculated previously yeilded no value proceed to new calculation based on number of ups and process efficiency per sheet
    //if (isNaN(cost_glue)) {cost_glue = 0;}

    /* popualete or zero out fields
    document.occ.cost_glue.value = parseFloat(cost_glue).toFixed(2);
    document.occ.cost_glue_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_glue_info.value = '';
    document.occ.cost_glue_jazda_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_glue_jazda_info.value = '';
    document.occ.cost_glue_idle_real.value = parseFloat(0).toFixed(2);
    document.occ.cost_glue_idle_info.value = '';
    document.occ.cost_glue_prod_time.value = parseFloat(0).toFixed(2);
    */
    ///noweliczenie - licze wg ilości użytków itp...
    /*
    if (cost_glue === 0) { // START of new function calculating based of number of ups and other difficulties
      // define variables
      var GT_b1_slim = 0;
      var GT_b1_window = 0; // if there's a window in the box
      var GT_b1_tape = 0; // if ups are to be taped
      var GT_b1_sur2 = 0; // type of raw material
      var GT_b1_foil = 0; // foiled glue flap
      var GTgr = '';
      var GTb1nest =''; // numebr of ups on B1 sheet
      var GT_idleP_cost ='';
      var GTglue_type_slim_check = false;
      var GTglue_type_window_check = false;
      var GTglue_type_tape_check = false;
      var GTpaper_id2 = '';
      var GTpaper_gram_id2 ='';
      var GTfoil_type_id ='';

      // populate variables
      GTcost_h = parseFloat(document.occ.glue_type_cost_h.value);
      GTqty = parseFloat(document.occ.order_qty1_less.value);

      GTgr = parseFloat(document.occ.gram1.value); // get grammage of sheet
      GTb1nest = calculateNumberUpsOnB1Sheet(); // calculate number of ups on B1 sheet
      GT_idleP_cost = document.occ.glue_type_idleP_cost.value;
      GTglue_type_slim_check = document.occ.glue_type_slim_check.checked;// if the glue flap is slim
      GTglue_type_window_check = document.occ.glue_type_window_check.checked;
      GTglue_type_tape_check = document.occ.glue_type_tape_check.checked;
      GTpaper_id2 = document.occ.paper_id2.value; // type of id
      GTpaper_gram_id2 = document.occ.paper_gram_id2.value; // type of grammage id
      GTfoil_type_id = document.occ.foil_type_id.value; // type of foil

      // check for and evaluate manual gluing complications
        // if a complication is selected go and fetch complication value form hidden fields, which are populated from database on page load.
        // if a complication is not selected make value equal 1 not to interfere with multiplication


      // get manual gluing difficulties
      var resultsOf_evaluateManualGluingDifficulties = evaluateManualGluingDifficulties ();
      //populate variables with data returned as object from above function
        GT_b1_slim = resultsOf_evaluateManualGluingDifficulties.gluingDifficulty_SlimGlueFlap;
        GT_b1_sur2 = resultsOf_evaluateManualGluingDifficulties.gluingDifficulty_RawMaterialB1;
        GT_b1_foil = resultsOf_evaluateManualGluingDifficulties.gluingDifficulty_FoiledFlap;
        GT_b1_tape = resultsOf_evaluateManualGluingDifficulties.gluingDifficulty_GluingTape;
        GT_b1_window = resultsOf_evaluateManualGluingDifficulties.gluingDifficulty_LargeWindow;

      /*
            // check & evaluate foil type complication
              if (GTfoil_type_id) {
                GT_b1_foil = parseFloat(document.occ.glue_type_foil.value); // if selected go fetch value form hidden field
              } else { // if not selected then no complication make value equal to 1
                GT_b1_foil = 1;
              }
            // check & evaluate paper type complication
              if ((GTpaper_id2) && (GTpaper_gram_id2)) {
                GT_b1_sur2 = parseFloat(document.occ.glue_type_sur2.value); // if selected go fetch value form hidden field
              } else { // if not selected then no complication make value equal to 1
                GT_b1_sur2 = 1;
              }
            // check & evaluate gluing tape complication
              if (GTglue_type_tape_check) {
                GT_b1_tape = parseFloat(document.occ.glue_type_tape.value); // if selected go fetch value form hidden field
              } else { // if not selected then no complication make value equal to 1
                GT_b1_tape =1;
              }
            // check & evaluate window type complication
              if (GTglue_type_window_check) { // if selected go fetch value form hidden field
                GT_b1_window = parseFloat(document.occ.glue_type_window.value);
              } else { // if not selected then no complication make value equal to 1
                GT_b1_window =1;
              }
            // check & evaluate slim glue flap complication
              if (GTglue_type_slim_check) {
                GT_b1_slim = parseFloat(document.occ.glue_type_slim.value); // if selected go fetch value form hidden field
              } else { // if not selected then no complication make value equal to 1
                GT_b1_slim = 1;
              }
      */
      /*
      if (isNaN(GT_idleP_cost)) {GT_idleP_cost = 0;} // zero out variable if NaN

      // if there is a manual glue type chosen then go fetch glueing efficiency for a particular glueing type from db
      if (GTglue_type_id) { // if a some kind of manual gluing type has been selected
        var GTcost = 0; // manual gluing run time costs
        var GTcost_i = 0; //manual gluing idle time costs
        var GTcost_t = 0; // manual gluing total costs
        GTspeed = 0; // zero out GTspeed so that speed from previous ajax call is not used for calculations

          // BEGIN AJAX call
          if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
            var GTxmlhttp = new XMLHttpRequest();
          } else { // code for IE6, IE5
            GTxmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
          }

          GTxmlhttp.onreadystatechange = function() {
            if (GTxmlhttp.readyState === 4 && GTxmlhttp.status === 200) {
              GTspeed = GTxmlhttp.responseText; // get gluing speed frim db for given manual gluing type
              console.log("In AJAX call, ", "glueTypeID: ", GTglue_type_id, " ,GTSpeed is: ", GTspeed);

              if (GTspeed && GTspeed > 0) { // if returned glue speed is greater than 0 then proceed to calculate times and costs.
                console.log("In if stmt, ", "glueTypeID: ", GTglue_type_id, " ,GTSpeed is: ", GTspeed);
                // calculate manual gluing run times
                GTcost_time = (GTqty / 100 * GTspeed) / 60 * (GT_b1_sur2 * GT_b1_foil * GT_b1_tape * GT_b1_window * GT_b1_slim);
                // calculate manual gluing run time costs
                GTcost = GTcost_time * GTcost_h;
                // populate calculation fields
                document.occ.cost_glue_prod_time.value = parseFloat(GTcost_time).toFixed(2);
                document.occ.cost_glue_jazda_real.value = parseFloat(GTcost).toFixed(2);
                document.occ.cost_glue_jazda_info.value = '(ilość/100 *wydajność min/100sztuk) * (utrudnienia) *stawka = (' + GTqty + '/100 *' + GTspeed + ')/60 * (' + GT_b1_sur2 + '*' + GT_b1_foil + '*' + GT_b1_tape + '*' + GT_b1_window + '*' + GT_b1_slim + ') *' + GTcost_h + ' zl/h';
                // calculate manual gluing idle time costs
                GTcost_i = GTcost_time * GT_idleP / 100 * GT_idleP_cost;
                // populate calculation fields
                document.occ.cost_glue_idle_real.value = parseFloat(GTcost_i).toFixed(2);
                document.occ.cost_glue_idle_info.value = 'czas jazdy * %IDLE jazdy * koszt IDLE = ' + parseFloat(GTcost_time).toFixed(2) + ' * ' + GT_idleP + '% * ' + GT_idleP_cost;
                // calculate manual gluing total costs
                GTcost_t = GTcost + GTcost_i;
                // populate calculation fields
                document.occ.cost_glue_real.value = parseFloat(GTcost_t).toFixed(2);
                // replace total cost with minul
                //if (GTcost_t < GLUminimum_cost) { GTcost_t = GLUminimum_cost; }
                document.occ.cost_glue.value = parseFloat(GTcost_t).toFixed(2);
                document.occ.cost_glue_info.value = 'koszt jazdy + koszt IDLE = ' + parseFloat(GTcost).toFixed(2) + ' + ' + parseFloat(GTcost_i).toFixed(2);
              } else {
                console.log("GTSpeed is not defined at: ", GTspeed);
              }
            }
          }; // END of AJAX call

          GTxmlhttp.open("GET", "order_calculation_create_cost_glue_type.php?var_id=" + GTglue_type_id + "&nesting=" + GTb1nest + "&gram=" + GTgr + "&order_qty=" + GTqty, true);
          GTxmlhttp.send();
      }
    } // END of new function calculating based of number of ups and other difficulties
    */

    setTimeout(count_cost_glue_automat(''), TimeOut);
  } // END of count_cost_glue funcion

  function count_cost_glue_automat(GAtype_) {

    //document.getElementById("div_calculate").style.display = "";
    //document.getElementById("input_save_input").disabled = true;
  /*
    GA2glue_type_id = document.occ.glue_automat_type_id.value;

    if (GA2glue_type_id) {
      document.getElementById("glue_automatic_title").rowSpan = 2;
      document.getElementById("glue_automatic_row1").style.display = "";
      document.getElementById("glue_automatic_row2").style.display = "";

    } else {
      document.getElementById("glue_automatic_title").rowSpan = 1;
      document.getElementById("glue_automatic_row2").style.display = "none";
      document.occ.cost_glue_automat_box.value = '';
      document.occ.cost_glue_automat_total.value = '';
    }

    var GA2minimum_cost = parseFloat(document.occ.cost_minimum_auto_glue.value) * parseFloat(document.occ.cost_minimum_mnoznik.value);
    //document.occ.cost_glue_automat_total.value = "";
    //document.occ.cost_glue_automat_box.value = "";
    document.occ.cost_glue_automat_info.value = '';
    document.occ.cost_trans_glue_automat.value = parseFloat(0).toFixed(2);
    document.occ.cost_glue_automat_real.value = parseFloat(0).toFixed(2);

    if (GAtype_ === "cost") {
      var GA2cost_total = parseFloat(document.occ.cost_glue_automat_total.value);
      document.occ.cost_glue_automat_real.value = parseFloat(GA2cost_total).toFixed(2);
      if (GA2cost_total < GA2minimum_cost) {
        GA2cost_total = GA2minimum_cost;
      }
      document.occ.cost_glue_automat_box.value = "";
      document.occ.cost_glue_automat_info.value = 'koszt całości = ' + GA2cost_total;
      document.occ.cost_trans_glue_automat.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
    }
    if (GAtype_ === "cost_box") {
      var GA2qty = parseFloat(document.occ.order_qty1_less.value);
      var GA2cost = parseFloat(document.occ.cost_glue_automat_box.value);
      var GA2cost_total = GA2qty * GA2cost;
      document.occ.cost_glue_automat_real.value = parseFloat(GA2cost_total).toFixed(2);
      if (GA2cost_total < GA2minimum_cost) {
        GA2cost_total = GA2minimum_cost;
      }
      document.occ.cost_glue_automat_total.value = "";
      document.occ.cost_glue_automat_info.value = 'koszt wykonania 1 sztuki * ilość sztuk = ' + GA2cost + ' * ' + GA2qty + ' = ' + GA2cost_total;
      document.occ.cost_trans_glue_automat.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
    }
    if (GAtype_ === "") {
      var GA2cost_total = parseFloat(document.occ.cost_glue_automat_total.value);
      if (GA2cost_total) {
        document.occ.cost_glue_automat_real.value = parseFloat(GA2cost_total).toFixed(2);
        if (GA2cost_total < GA2minimum_cost) {
          GA2cost_total = GA2minimum_cost;
        }
        document.occ.cost_glue_automat_box.value = "";
        document.occ.cost_glue_automat_info.value = 'koszt całości = ' + GA2cost_total;
        document.occ.cost_trans_glue_automat.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);
      } else {
        var GA2cost = parseFloat(document.occ.cost_glue_automat_box.value);
        if (GA2cost) {
          var GA2qty = parseFloat(document.occ.order_qty1_less.value);
          var GA2cost_total = GA2qty * GA2cost;
          document.occ.cost_glue_automat_real.value = parseFloat(GA2cost_total).toFixed(2);
          if (GA2cost_total < GA2minimum_cost) {
            GA2cost_total = GA2minimum_cost;
          }
          document.occ.cost_glue_automat_total.value = "";
          document.occ.cost_glue_automat_info.value = 'koszt wykonania 1 sztuki * ilość sztuk = ' + GA2cost + ' * ' + GA2qty + ' = ' + GA2cost_total;
          document.occ.cost_trans_glue_automat.value = parseFloat(document.occ.cost_transport_out.value).toFixed(2);

        }
      }
    }

    if (isNaN(GA2cost_total)) {
      GA2cost_total = 0;
    }
    document.occ.cost_glue_automat.value = parseFloat(GA2cost_total).toFixed(2);
*/
    setTimeout(count_cost_transport(''), TimeOut);
  }

  function count_cost_transport(TRANtype) {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;
    document.getElementById("cost_transport_top").value = parseFloat(0).toFixed(2); // print data in header
    document.getElementById("cost_transport").value = parseFloat(0).toFixed(2); // print data in detail
    var TRANcosts = 0;

    var TRANtype_id = document.occ.transport_type_id.value;
    if (TRANtype_id === "") {
      document.getElementById("td_t1").style.display = "none";
      document.getElementById("td_t2").style.display = "none";
      document.getElementById("td_t3").style.display = "none";
      document.getElementById("td_t4").rowSpan = 1;
      document.getElementById("td_t5").style.display = "none";
      document.getElementById("td_t6").style.display = "none";
      document.getElementById("td_t7").style.display = "none";
      document.occ.transport_km.value = '';
      document.occ.transport_palet.value = '';
      document.occ.transport_palet_weight.value = '';
      document.occ.cost_transport_box.value = '';
      document.occ.cost_transport_total.value = '';
    } else {
      document.getElementById("td_t1").style.display = "";
      document.getElementById("td_t2").style.display = "";
      document.getElementById("td_t3").style.display = "";
      document.getElementById("td_t4").rowSpan = 2;
      document.getElementById("td_t5").style.display = "";
      document.getElementById("td_t6").style.display = "";
      document.getElementById("td_t7").style.display = "";

      if (TRANtype === "cost") {
        var TRANcosts = parseFloat(document.occ.cost_transport_total.value);
        if (!isNaN(TRANcosts)) {
          document.occ.cost_transport_box.value = '';
          document.occ.cost_transport_info.value = 'koszt całości = ' + TRANcosts;
        } else {
          document.occ.cost_transport_total.value = '';
          var TRANtype = '';
        }
      }
      if (TRANtype === "cost_box") {
        var TRANcost = parseFloat(document.occ.cost_transport_box.value);
        if (!isNaN(TRANcost)) {
          var TRANqty = parseFloat(document.occ.order_qty1_less.value);
          var TRANcosts = TRANqty * TRANcost;
          document.occ.cost_transport_total.value = '';
          document.occ.cost_transport_info.value = 'koszt wysyłki 1 sztuki * ilość sztuk = ' + TRANcost + ' * ' + TRANqty + ' = ' + TRANcosts;
        } else {
          document.occ.cost_transport_box.value = '';
          var TRANtype = '';
        }
      }
      if (TRANtype === "") {
        var TRANcost_total = parseFloat(document.occ.cost_transport_total.value);
        if (TRANcost_total > 0) {
          var TRANtype = 'cost';
          var TRANcosts = TRANcost_total;
          document.occ.cost_transport_box.value = '';
          document.occ.cost_transport_info.value = 'koszt całości = ' + TRANcosts;
        } else {
          var TRANcost = parseFloat(document.occ.cost_transport_box.value);
          if (TRANcost > 0) {
            var TRANtype = 'cost_box';
            var TRANqty = parseFloat(document.occ.order_qty1_less.value);
            var TRANcosts = TRANqty * TRANcost;
            document.occ.cost_transport_total.value = '';
            document.occ.cost_transport_info.value = 'koszt wysyłki 1 sztuki * ilość sztuk = ' + TRANcost + ' * ' + TRANqty + ' = ' + TRANcosts;
          } else {
            document.occ.cost_transport_box.value = '';
            var TRANtype = '';
          }
        }
      }
      document.getElementById("cost_transport_top").value = parseFloat(TRANcosts).toFixed(2); // print data in header
      document.getElementById("cost_transport").value = parseFloat(TRANcosts).toFixed(2); // print data in detail

      if (TRANtype === "") { ///nie ma wpisanych ilości
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        var  TRANxmlhttpf = new XMLHttpRequest();
        } else { // code for IE6, IE5
        var  TRANxmlhttpf = new window.ActiveXObject("Microsoft.XMLHTTP");
        }
        TRANxmlhttpf.onreadystatechange = function() {
          if (TRANxmlhttpf.readyState === 4 && TRANxmlhttpf.status === 200) {
            var TRANcost_v = TRANxmlhttpf.responseText;
            var TRANcost_v = TRANcost_v * "1";
            if (TRANcost_v > "0") {
              var TRANcosts = TRANcost_v;
              document.getElementById("cost_transport_top").value = parseFloat(TRANcosts).toFixed(2); // print data in header
              document.getElementById("cost_transport").value = parseFloat(TRANcosts).toFixed(2); // print data in detail
              document.occ.cost_transport_info.value = 'koszt wysyłki wyliczenie = ' + TRANcosts;
            }
          }
        };

        var TRANkm = parseFloat(document.occ.transport_km.value).toFixed(0);
        if (isNaN(TRANkm)) {
          TRANkm = 0;
        }
        var TRANpalet = parseFloat(document.occ.transport_palet.value).toFixed(0);
        if (isNaN(TRANpalet)) {
          TRANpalet = 0;
        }
        var TRANpalet_weight = parseFloat(document.occ.transport_palet_weight.value).toFixed(0);
        if (isNaN(TRANpalet_weight)) {
          TRANpalet_weight = 0;
        }
        TRANxmlhttpf.open("GET", "order_calculation_create_cost_transport.php?km=" + TRANkm + "&var_id=" + TRANtype_id + "&palet=" + TRANpalet + "&palet_weight=" + TRANpalet_weight, true);
        TRANxmlhttpf.send();
      }
    }

    setTimeout(count_cost_accept, TimeOut);
  }

  function count_cost_accept() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var ACCcost_total = parseFloat(document.occ.accept_cost.value);

    if (isNaN(ACCcost_total)) {
      ACCcost_total = 0;
    }
    document.occ.cost_accept.value = parseFloat(ACCcost_total).toFixed(2);
    document.occ.accept_cost.value = parseFloat(ACCcost_total).toFixed(2);

    setTimeout(count_cost_other1(''), TimeOut);
  }

  function count_cost_other1(OT1type_) {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    //document.occ.cost_other1_total.value = "";
    //document.occ.cost_other1_box.value = "";
    document.occ.cost_other1_info.value = '';

    var OT1cost=0;
    var OT1cost_total =0;
    var OT1qty=0;


    if (OT1type_ === "cost") {
      OT1cost_total = parseFloat(document.occ.cost_other1_total.value);
      document.occ.cost_other1_box.value = "";
      document.occ.cost_other1_info.value = 'koszt całości = ' + OT1cost_total;
    }
    if (OT1type_ === "cost_box") {
      OT1qty = parseFloat(document.occ.order_qty1_less.value);
      OT1cost = parseFloat(document.occ.cost_other1_box.value);
      OT1cost_total = OT1qty * OT1cost;
      document.occ.cost_other1_total.value = "";
      document.occ.cost_other1_info.value = 'koszt wykonania 1 sztuki * ilość sztuk = ' + OT1cost + ' * ' + OT1qty + ' = ' + OT1cost_total;
    }
    if (OT1type_ === "") {
      OT1cost_total = parseFloat(document.occ.cost_other1_total.value);
      if (OT1cost_total) {
        document.occ.cost_other1_box.value = "";
        document.occ.cost_other1_info.value = 'koszt całości = ' + OT1cost_total;
      } else {
        OT1cost = parseFloat(document.occ.cost_other1_box.value);
        if (OT1cost) {
          OT1qty = parseFloat(document.occ.order_qty1_less.value);
          OT1cost_total = OT1qty * OT1cost;
          document.occ.cost_other1_total.value = "";
          document.occ.cost_other1_info.value = 'koszt wykonania 1 sztuki * ilość sztuk = ' + OT1cost + ' * ' + OT1qty + ' = ' + OT1cost_total;
        }
      }
    }

    if (isNaN(OT1cost_total)) {
      OT1cost_total = 0;
    }
    document.occ.cost_other1.value = parseFloat(OT1cost_total).toFixed(2);

    setTimeout(count_cost_other2(''), TimeOut);
  }

  function count_cost_other2(OT2type_) {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    //document.occ.cost_other2_total.value = "";
    //document.occ.cost_other2_box.value = "";
    document.occ.cost_other2_info.value = '';

    var OT2qty=0;
    var OT2cost=0;
    var OT2cost_total=0;

    if (OT2type_ === "cost") {
       OT2cost_total = parseFloat(document.occ.cost_other2_total.value);
      document.occ.cost_other2_box.value = "";
      document.occ.cost_other2_info.value = 'koszt całości = ' + OT2cost_total;
    }
    if (OT2type_ === "cost_box") {
       OT2qty = parseFloat(document.occ.order_qty1_less.value);
       OT2cost = parseFloat(document.occ.cost_other2_box.value);
       OT2cost_total = OT2qty * OT2cost;
      document.occ.cost_other2_total.value = "";
      document.occ.cost_other2_info.value = 'koszt wykonania 1 sztuki * ilość sztuk = ' + OT2cost + ' * ' + OT2qty + ' = ' + OT2cost_total;
    }
    if (OT2type_ === "") {
       OT2cost_total = parseFloat(document.occ.cost_other2_total.value);
      if (OT2cost_total) {
        document.occ.cost_other2_box.value = "";
        document.occ.cost_other2_info.value = 'koszt całości = ' + OT2cost_total;
      } else {
         OT2cost = parseFloat(document.occ.cost_other2_box.value);
        if (OT2cost) {
           OT2qty = parseFloat(document.occ.order_qty1_less.value);
           OT2cost_total = OT2qty * OT2cost;
          document.occ.cost_other2_total.value = "";
          document.occ.cost_other2_info.value = 'koszt wykonania 1 sztuki * ilość sztuk = ' + OT2cost + ' * ' + OT2qty + ' = ' + OT2cost_total;
        }
      }
    }

    if (isNaN(OT2cost_total)) {
      OT2cost_total = 0;
    }
    document.occ.cost_other2.value = parseFloat(OT2cost_total).toFixed(2);

    setTimeout(countoperationTimeCorrection(), TimeOut);
  }

  function countoperationTimeCorrection() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;
    // define Variables
      let operationTimeCorrection;
      let operationTimeMsg;
    // get value of working times from page
      operationTimeCorrection = document.getElementById("operationTimeCorrection").value;
    // determine if value is a hhmm or simple value by looking at the ":" in the string and convert to value
      if (operationTimeCorrection.search(":")>0) {
        // convert time in string format hh:mm to value
          operationTimeCorrection = hhmmToValue(operationTimeCorrection);
      }

      if (isNaN(operationTimeCorrection)) { // check for NaN
        // set 0
          operationTimeCorrection = 0;
      } else if (operationTimeCorrection > 0) {
        operationTimeMsg = 'Zwiększono całkowity czas realizacji zlecenia o: ' + hoursTohhmm(operationTimeCorrection) + ' godzin'; // create msg to dispaly on screen
      } else if (operationTimeCorrection < 0) {
        operationTimeMsg = 'Zmniejszono całkowity czas realizacji zlecenia o: ' + hoursTohhmm(operationTimeCorrection) + ' godzin';// create msg to dispaly on screen
      } else { // working time wasn't changed at all
        operationTimeMsg ='';
      }
    // convert time as value to hhmm for display on screen
      operationTimeCorrection = hoursTohhmm(operationTimeCorrection);
    // print values on screen in summary
      document.getElementById("operationTimeCorrection").value = operationTimeCorrection;
      document.getElementById("operationTimeCorrectionInfo").value = operationTimeMsg;
      document.getElementById("operationTimeCorrectionTotal").value = operationTimeCorrection;
    setTimeout(count_cost_extra(), TimeOut);
  }

  function count_cost_extra() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    var CEXcost_total = parseFloat(document.occ.cost_extra_total.value);

    if (isNaN(CEXcost_total)) {
      CEXcost_total = 0;
    }
    document.occ.cost_extra.value = parseFloat(CEXcost_total).toFixed(2);
    document.occ.cost_extra_info.value = 'koszt całości = ' + parseFloat(CEXcost_total).toFixed(2);
    document.occ.cost_extra_total.value = parseFloat(CEXcost_total).toFixed(2);

    setTimeout(write_week_end_date(), TimeOut);
    setTimeout(count_cost_count_total(), TimeOut);
    //setTimeout(check_order_to_customer_exist(), TimeOut);
  }


function check_order_to_customer_exist() {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;
    document.occ.order_to_customer_exist.value = '';

    var OEcustomer_id = document.occ.customer_id.value;
    if (OEcustomer_id) {
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      var  OExmlhttpf = new XMLHttpRequest();
      } else { // code for IE6, IE5
      var OExmlhttpf = new window.ActiveXObject("Microsoft.XMLHTTP");
      }
      OExmlhttpf.onreadystatechange = function() {
        if (OExmlhttpf.readyState === 4 && OExmlhttpf.status === 200) {
          var OEvalue = OExmlhttpf.responseText;
          document.occ.order_to_customer_exist.value = OEvalue;
          console.log('Order Exists: ',OEvalue );
        }
      };

      OExmlhttpf.open("GET", "order_calculation_create_order_to_customer_exist.php?customer_id=" + OEcustomer_id, true);
      OExmlhttpf.send();
    }

    setTimeout(count_cost_count_total(), TimeOut);
  }


  function count_cost_count_total(prowizja_25proc_sales,prowizja_25proc_margin) {
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;

    // TODO: Move outsourcing type evaluation to a separate function
      evaluateOutsourcingTypes();
    // END evaluating outsourcing types


    ////musze podliczyć koszty
    var KM = 0; // Koszty materialowe
    KM = parseFloat(document.getElementById("cost_paper1").value) + parseFloat(document.getElementById("cost_paper2").value);
    KM = KM + parseFloat(document.occ.cost_awers_material.value) + parseFloat(document.occ.cost_rewers_material.value);
    KM = KM + parseFloat(document.occ.cost_awers_material_clicha.value) + parseFloat(document.occ.cost_rewers_material_clicha.value);
    KM = KM + parseFloat(document.occ.cost_awers2_material.value) + parseFloat(document.occ.cost_rewers2_material.value);
    KM = KM + parseFloat(document.occ.cost_awers2_material_clicha.value) + parseFloat(document.occ.cost_rewers2_material_clicha.value);
    KM = KM + parseFloat(document.occ.cost_extra_plate.value) + parseFloat(document.occ.cost_extra_plate2.value);
    //KM        = KM+ parseFloat(document.occ.cost_ink_varnish_special_material.value);
    KM = KM + parseFloat(document.occ.cost_varnish_material.value) + parseFloat(document.occ.cost_varnish_uv_material.value);
    KM = KM + parseFloat(document.occ.cost_varnish2_material.value) + parseFloat(document.occ.cost_window_foil.value);
    KM = KM + parseFloat(document.occ.cost_gilding_material.value) + parseFloat(document.occ.cost_laminating_material.value);

    var KO =0; //Koszty operacyjne
    KO = parseFloat(document.occ.cost_awers.value) + parseFloat(document.occ.cost_rewers.value);
    KO = KO + parseFloat(document.occ.cost_awers2.value) + parseFloat(document.occ.cost_rewers2.value);
    KO = KO + parseFloat(document.occ.cost_varnish_uv.value) + parseFloat(document.occ.cost_varnish.value);
    KO = KO + parseFloat(document.occ.cost_varnish2.value);
    //KO        = KO+ parseFloat(document.occ.cost_ink_varnish_special.value);
    KO = KO + parseFloat(document.occ.cost_gilding.value);
    KO = KO + parseFloat(document.occ.cost_cut.value) + parseFloat(document.occ.cost_dcting.value) + parseFloat(document.occ.cost_dcting2.value);
    KO = KO + parseFloat(document.occ.cost_cut2.value);
    KO = KO + parseFloat(document.occ.cost_laminating.value) + parseFloat(document.occ.cost_manual_work.value);
    KO = KO + parseFloat(document.occ.cost_glue.value);
    KO = KO + parseFloat(document.occ.cost_glue_automat.value) //+ parseFloat(document.occ.cost_trans_glue_automat.value);
    if (windowPatchingType === "internal") { // only count window patching toward operation costs if its done internally
      KO = KO + parseFloat(document.occ.cost_window.value);
    }
    var Kuz =0;
    Kuz = parseFloat(document.occ.cost_ink_varnish_special_out.value) + parseFloat(document.occ.cost_trans_ink_varnish_special_out.value);
    //Kuz       = Kuz+ parseFloat(document.occ.cost_glue.value);
    //Kuz       = Kuz+ parseFloat(document.occ.cost_glue_automat.value) + parseFloat(document.occ.cost_trans_glue_automat.value);
    Kuz = Kuz + parseFloat(document.occ.cost_falc.value) + parseFloat(document.occ.cost_trans_falc.value);
    Kuz = Kuz + parseFloat(document.occ.cost_bigowanie.value) + parseFloat(document.occ.cost_trans_bigowanie.value);
    Kuz = Kuz + parseFloat(document.occ.cost_stample.value) + parseFloat(document.occ.cost_trans_stample.value);
    Kuz = Kuz + parseFloat(document.occ.cost_foil.value) + parseFloat(document.occ.cost_trans_foil.value);
    Kuz = Kuz + parseFloat(document.getElementById("cost_transport").value); //get data from header

    if (windowPatchingType === "external") { // only count window patching toward external operations costs if its done externally
      Kuz = Kuz + parseFloat(document.occ.externalWindowPatching.value) + parseFloat(document.occ.externalWindowPatchingTransport.value);
    }

    var KPoz = 0;
    document.occ.cost_extra_matryce_KD.value = parseFloat(0).toFixed(2);
    document.occ.cost_extra_matryce_KPoz.value = parseFloat(0).toFixed(2);

    // Begin adding up additional costs and other costs to be invoiced
      // define variables
        var KD = 0;
        var Cost_Other1 = 0;
        var Cost_Other2 = 0;
        var hiddenToolingCosts_Total =0;
        var hiddenToolingCosts_InPrice =0;
        var hiddenToolingCosts_CoveredBySupplier =0;
        var matryc_show = 0;
      // populate variables
        Cost_Other1 = parseFloat(document.occ.cost_other1.value);
        Cost_Other2 = parseFloat(document.occ.cost_other2.value);
      // validate against NaN
        if (isNaN(Cost_Other1)) {Cost_Other1=0;}
        if (isNaN(Cost_Other2)) {Cost_Other2=0;}
      // get total hidden tooling costs calculated in dieCuttingStripping.js -> countToolingCosts
        hiddenToolingCosts_Total = parseFloat(document.getElementById("hiddenToolingCosts").value);
      // get tooling costs hidden in price calculated in dieCuttingStripping.js -> countToolingCosts
        hiddenToolingCosts_InPrice = parseFloat(document.getElementById("hiddenToolingCosts_InPrice").value);
      // get tooling costs covered by supplier calculated in dieCuttingStripping.js -> countToolingCosts
        hiddenToolingCosts_CoveredBySupplier = parseFloat(document.getElementById("hiddenToolingCosts_CoveredBySupplier").value);
      // validate against NaN
        if (isNaN(hiddenToolingCosts_Total)) {hiddenToolingCosts_Total=0;}
        if (isNaN(hiddenToolingCosts_InPrice)) {hiddenToolingCosts_InPrice=0;}
        if (isNaN(hiddenToolingCosts_CoveredBySupplier)) {hiddenToolingCosts_CoveredBySupplier=0;}

      // hiddenToolingCosts_InPrice are to be added to KD so that they increase BEP and Sales value but increase TVC
        KD = Cost_Other1 + Cost_Other2 + hiddenToolingCosts_InPrice;
      // hiddenToolingCosts_CoveredBySupplier are NOT to be added to KD, so that they do not increase BEP and Sales value but increase TVC

        matryc_show = parseFloat(document.occ.cost_extra_matryce.value) + parseFloat(document.occ.cost_extra_matryce_extra.value);
        if (document.occ.gilding_box_matryce.checked) {
          document.occ.cost_extra_matryce_KD.value = parseFloat(matryc_show).toFixed(2);
          KD = KD + parseFloat(document.occ.cost_extra_matryce.value) + parseFloat(document.occ.cost_extra_matryce_extra.value);
        } else {
          document.occ.cost_extra_matryce_KPoz.value = parseFloat(matryc_show).toFixed(2);
          //  adding up other costs which are to be invoiced apart from the calculation costs
          KPoz = KPoz + parseFloat(document.occ.cost_extra_matryce.value) + parseFloat(document.occ.cost_extra_matryce_extra.value);
        }
        //KD        = KD+ parseFloat(document.occ.cost_accept.value);
        //KD        = KD+ parseFloat(document.occ.cost_extra.value);

        //  adding up other costs which are to be invoiced apart from the calculation costs
        KPoz = KPoz + parseFloat(document.occ.cost_extra.value) + parseFloat(document.occ.cost_accept.value);
        KPoz = KPoz + parseFloat(document.occ.cost_dicut.value);
        //var KPoz      = KPoz + parseFloat(document.occ.cost_awers_material_clicha.value) + parseFloat(document.occ.cost_rewers_material_clicha.value);

    // END adding up additional costs and other costs to be invoiced

    //var KT        = parseFloat(document.occ.cost_transport.value);
    var KT = 0;
    if (isNaN(KT)) {
      KT = 0;
    }
    var nesting = parseFloat(document.occ.product_paper_value1.value);
    var qtyOrdered = parseFloat(document.occ.order_qty1.value);           // the qty the customer has ordered
    var qtyToProduce = parseFloat(document.occ.order_qty1_less.value);    // the qty the customer has ordered increased by the tolerance from the agreement.
    var sheetQtyToProduce = qtyToProduce / nesting;

    var KC = KM + KO + KT + Kuz + KD;
    if (isNaN(KC)) {
      KC = 0;
    }
    document.getElementById("cost_total_material_top").value = parseFloat(KM).toFixed(2);// print data in header
    document.getElementById("cost_total_material").value = parseFloat(KM).toFixed(2);
    document.getElementById("cost_total_operation_top").value = parseFloat(KO).toFixed(2);// print data in header
    document.getElementById("cost_total_operation").value = parseFloat(KO).toFixed(2);
    document.getElementById("cost_total_out_top").value = parseFloat(Kuz).toFixed(2);// print data in header
    document.getElementById("cost_total_out").value = parseFloat(Kuz).toFixed(2);// print data in details
    document.occ.cost_total_dodatek.value = parseFloat(KD).toFixed(2);
    document.occ.cost_total_pozostale.value = parseFloat(KPoz).toFixed(2);
    document.occ.cost_total_total.value = parseFloat(KC).toFixed(2);
    document.occ.cost_total_total_info.value = 'KM + KO + Kuz + KT + KD= ' + KM + ' + ' + KO + ' + ' + Kuz + ' + ' + KT + ' + ' + KD;


// BEGIN CALCULATING ADMINISTRATIVE & TAX ADDERS
      // define variables and populate them with values
        var admAdderSmallRuns = parseFloat(document.getElementById("cost_administracja1").value); // get administrative adder percentage for small runs
        var admAdderLargeRuns = parseFloat(document.occ.cost_administracja2.value); // get administrative adder percentage for large runs
        var admAdderRunThreshold = parseFloat(document.occ.cost_administracja_to1.value); // get administrative adder small run threshold
        var admAdder; // object holding results of administrative adder calculations
        var admAdderValue=0; // administrative adder value
        var admAdderPercentage; // administrative adder percentage
        var admAdderInfoString=''; // display administrative adder calculation info

        var taxAdderSmallRuns = parseFloat(document.occ.cost_podatek1.value); // // get tax adder percentage for small runs
        var taxAdderLargeRuns = parseFloat(document.occ.cost_podatek2.value); // get tax adder percentage for large runs
        var taxAdderRunThreshold = parseFloat(document.occ.cost_podatek_to1.value); // // get tax adder small run threshold
        var taxAdder; // object holding results of tax adder calculations
        var taxAdderValue=0; // tax adder value
        var taxAdderPercentage;  // tax adder percentage
        var taxAdderInfoString=''; // display tax adder calculation info

        var totalAdderValue = 0;  // TAX & ADM adder value
        var totalAdderInfoString =''; // // display adm & tax adder calculation info

    // populate administrative adder object and values based on calculation results
      //admAdder = calculateAdder_v1 (KO, Kuz, KM, KD, KT, sheetQtyToProduce, admAdderSmallRuns, admAdderLargeRuns, admAdderRunThreshold);
      admAdder = calculateAdder_v2 (KO, Kuz, KM, KD, KT, sheetQtyToProduce, admAdderSmallRuns, admAdderLargeRuns, admAdderRunThreshold);
      admAdderValue = admAdder.adderValue;
      admAdderPercentage = admAdder.adderPercentage;
      // create administrative adder info string
        //admAdderInfoString = createAdmAdderInfoString_v1 (KO,KM,Kuz,KD,KT,admAdderPercentage);
        admAdderInfoString = createAdmAdderInfoString_v2 (KO,KM,Kuz,KD,KT,admAdderPercentage);
    // populate tax adder object and values based on calculation results
      //taxAdder = calculateAdder_v1 (KO, Kuz, KM, KD, KT, sheetQtyToProduce, taxAdderSmallRuns, taxAdderLargeRuns, taxAdderRunThreshold,admAdderValue);
      taxAdder = calculateAdder_v2 (KO, Kuz, KM, KD, KT, sheetQtyToProduce, taxAdderSmallRuns, taxAdderLargeRuns, taxAdderRunThreshold,admAdderValue);
      taxAdderValue = taxAdder.adderValue;
      taxAdderPercentage = taxAdder.adderPercentage;
      // create tax adder info string
        //taxAdderInfoString = createTaxAdderInfoString_v1 (admAdderValue,KO,KM,Kuz,KD,KT,taxAdderPercentage);
        taxAdderInfoString = createTaxAdderInfoString_v2 (admAdderValue,KO,KM,Kuz,KD,KT,taxAdderPercentage);
    // add up both ADM & TAX adders
      totalAdderValue = taxAdderValue + admAdderValue; if (isNaN(totalAdderValue)) {totalAdderValue = 0;} // combined ADM & TAX value
    // construct info strings
      totalAdderInfoString = '(narzut kosztów administracji + narzut kosztów podatku) = ' + parseFloat(admAdderValue).toFixed(2) + ' + ' + parseFloat(taxAdderValue).toFixed(2);
        // display information on page
          document.occ.cost_administracja.value = parseFloat(admAdderValue).toFixed(2); // administrative adder value
          document.occ.cost_podatek.value = parseFloat(taxAdderValue).toFixed(2);  // tax adder value
          document.occ.cost_administracja_info.value = admAdderInfoString; // administrative adder info string
          document.occ.cost_podatek_info.value = taxAdderInfoString;       // tax adder info string
          document.occ.cost_sum_narzut.value = parseFloat(totalAdderValue).toFixed(2); // TAX & ADM adder value
          document.occ.cost_sum_narzut_info.value = totalAdderInfoString; // adm & tax adder info string
// END CALCULATING ADMINISTRATIVE & TAX ADDERS


    ///BEP
    var KBEP = KC + totalAdderValue;
    if (isNaN(KBEP)) {
      KBEP = 0;
    }
    //var KBEP = taxAdderValue; if (isNaN(KBEP)) { KBEP = 0; }
    document.getElementById("cost_bep_top").value = parseFloat(KBEP).toFixed(2); // print data in header
    document.getElementById("cost_bep").value = parseFloat(KBEP).toFixed(2); // print data in details
    document.getElementById("cost_bep_info").value = 'koszt bezpośredni + suma narzutów = ' + parseFloat(KC).toFixed(2) + ' + ' + parseFloat(totalAdderValue).toFixed(2);
    //document.occ.cost_bep_info.value = 'koszt podatku (wartość progu rentowności) = '+taxAdderValue;
    
    var cost_bep_one = KBEP / qtyOrdered;
    //var cost_bep_one = KBEP / qtyToProduce; // removed since in case of higher tolerances the unit price was much reduced
    if (isNaN(cost_bep_one)) {
      cost_bep_one = 0;
    }
    document.getElementById("cost_bep_one_top").value = parseFloat(cost_bep_one).toFixed(4); // print data in header
    document.getElementById("cost_bep_one").value = parseFloat(cost_bep_one).toFixed(4); // print data in details


      ///Hide info that unit cost or margin has been set manually

      //remove styles from elements
      document.getElementById("cost_sales_one").style.backgroundColor = "";
      document.getElementById("cost_sales").style.backgroundColor = "";
      document.getElementById("warningRow").style.backgroundColor = "";
      //hide elements
      document.getElementById("warningRow").style.display = "none";

    var cost_sales_one_write = parseFloat(document.occ.cost_sales_one_write.value);
    if (isNaN(cost_sales_one_write)) {
      cost_sales_one_write = 0;
    }

    var salesMarginValue=0;
    var salesMarginValue_unit = 0;
    var salesMarginValue_proc =0;
    var Ksales=0;

    if (cost_sales_one_write > 0) { /// ustawiono ręcznie cene!!
      document.occ.margin.value = '';
      document.occ.margin_pln.value = '';

      
      Ksales = cost_sales_one_write * qtyOrdered;
      //Ksales = cost_sales_one_write * qtyToProduce; // removed since in case of high tolerances the unit price was much reduced
      //var salesMarginValue                                = Ksales - (KM+KO+Kuz+totalAdderValue);
      //var salesMarginValue_proc                           = salesMarginValue/(KM+KO+Kuz+totalAdderValue)*100;

      salesMarginValue = Ksales - KBEP;
      salesMarginValue_unit = salesMarginValue/ qtyOrdered
      //salesMarginValue_unit = salesMarginValue/ qtyToProduce; // removed since in case of high tolerances the unit price was much reduced
      salesMarginValue_proc = salesMarginValue / KBEP * 100;

      document.occ.margin.value = parseFloat(salesMarginValue_proc).toFixed(4);
      document.occ.margin_pln.value = parseFloat(salesMarginValue).toFixed(4);
      document.getElementById("cost_margin_top").value = parseFloat(salesMarginValue).toFixed(2); // print data in header
      document.getElementById("cost_margin").value = parseFloat(salesMarginValue).toFixed(2); // print data in details
      document.getElementById("cost_margin_unit_top").value = parseFloat(salesMarginValue_unit).toFixed(4); // print data in header
      document.getElementById("cost_margin_unit").value = parseFloat(salesMarginValue_unit).toFixed(4); // print data in details
      document.occ.cost_margin_info.value = 'ustalona stała cena /sztuka ' + parseFloat(cost_sales_one_write).toFixed(4);

      ///Display info that unit cost or margin has been set manually
        document.getElementById("cost_sales_one").style.backgroundColor = colorRed;
        document.getElementById("cost_sales").style.backgroundColor = colorRed;
        document.getElementById("warningRow").style.backgroundColor = colorRed;
        document.getElementById("warningRow").style.display = "";


    } else {
      document.occ.cost_sales_one_write.value = '';
      var margin = parseFloat(document.occ.margin.value);
      var margin_pln = parseFloat(document.occ.margin_pln.value);
      //var salesMarginValue                         = (KM+KO+Kuz+totalAdderValue) * margin/100 + margin_pln; if (isNaN(salesMarginValue)) { salesMarginValue = 0; }
      salesMarginValue = KBEP * (margin/100) + margin_pln;
      salesMarginValue_unit = (KBEP * (margin/100) + margin_pln)/qtyOrdered;
      //salesMarginValue_unit = (KBEP * (margin/100) + margin_pln)/qtyToProduce;  // removed since in case of high tolerances the unit price was much reduced

      if (isNaN(salesMarginValue)) {
        salesMarginValue = 0;
      }
      if (isNaN(salesMarginValue_unit)) {
        salesMarginValue_unit = 0;
      }
      document.getElementById("cost_margin_top").value = parseFloat(salesMarginValue).toFixed(2); // print data in header
      document.getElementById("cost_margin_unit_top").value = parseFloat(salesMarginValue_unit).toFixed(4); // print data in header
      document.getElementById("cost_margin").value = parseFloat(salesMarginValue).toFixed(2); // print data in details
      document.getElementById("cost_margin_unit").value = parseFloat(salesMarginValue_unit).toFixed(4); // print data in details
      document.occ.cost_margin_info.value = '(KM+KO+Kuz+nAdm+nPod) * %marży/100 + kwota marży= (' + parseFloat(KM).toFixed(2) + '+' + parseFloat(KO).toFixed(2) + '+' + parseFloat(Kuz).toFixed(2) + '+' + parseFloat(totalAdderValue).toFixed(2) + ') * ' + parseFloat(margin).toFixed(2) + '/100 + ' + parseFloat(margin_pln).toFixed(2);

      Ksales = KBEP + salesMarginValue;

    }

    //wartość sprzedaży
    if (isNaN(Ksales)) {
      Ksales = 0;
    }
    document.getElementById("cost_sales_top").value = parseFloat(Ksales).toFixed(2); // print data in header
    document.getElementById("cost_sales").value = parseFloat(Ksales).toFixed(2); // print data in details
    document.occ.cost_sales_info.value = 'BEP + wartość marży= ' + parseFloat(KBEP).toFixed(2) + ' + ' + parseFloat(salesMarginValue).toFixed(2);
    // FIX: this line is calculating unit sales price base on the qty to produce - that is the qty in the upper tolerance set by the user.
    var cost_sales_one = Ksales / qtyOrdered;
    // var cost_sales_one = Ksales / qtyToProduce; // removed since in case of high tolerances the unit price was much reduced
    if (isNaN(cost_sales_one)) {
      cost_sales_one = 0;
    }
    document.getElementById("cost_sales_one_top").value = parseFloat(cost_sales_one).toFixed(4); // print data in header
    document.getElementById("cost_sales_one").value = parseFloat(cost_sales_one).toFixed(4); // print data in details

//check_order_to_customer_exist();

// BEGIN TRADITIONAL SALES COMISSION CALCULATION SECTION
      //define variables
        var salesComissionValue = 0;      // value of chosen sales comission
        var salesComissionValue_10 =0;    // value of salse comission as 10% from sales margin (repeat orders)
        var salesComissionValue_15 = 0;   // value of salse comission as 15% from sales margin (new orders)
        var salesComissionValue_2_5 = 0;  // value of salse comission as 2,5% from order turnover
        var salesComissionValue_30 = 0;   // value of salse comission as 30% from sales margin
        var otce = 0; // if order to customer already existed meaning if this is a calculation for repeat order

        salesComissionValue_10  = salesMarginValue * 0.1;
        if (isNaN(salesComissionValue_10)) {salesComissionValue_10 = 0;}

        if (salesComissionValue_10 > salesComissionValue) {
          salesComissionValue = salesComissionValue_10;
        }

      // display data in info header
        document.getElementById("cost_prowizja10_top").value = parseFloat(salesComissionValue_10).toFixed(2); // print data in header
        document.getElementById("cost_prowizja10").value = parseFloat(salesComissionValue_10).toFixed(2); // print data in details
        document.getElementById("cost_prowizja10_info").value = 'wartość marży * 10%= ' + salesMarginValue.toFixed(2) + ' * 10%';
        document.getElementById("cost_prowizja15_info").value = '';

/*
    // calculate sales comission in case of new order
      // check if order to customer already existed
        otce = parseFloat(document.occ.order_to_customer_exist.value); // NOTE: does not seem to work as existing order information doesn't seem to be taken from database
      // if order to customer already existed that this is a repeated order and traditional sales comission will be 10 %
      // if order to customer did not exist than this is a new order and traditional sales comission will be 15 %
        if (isNaN(otce)) {
          salesComissionValue_15 = salesMarginValue * 0.15;
          if (isNaN(salesComissionValue_15)) {salesComissionValue_15 = 0;}

          salesComissionValue = salesComissionValue_15;
          document.getElementById("cost_prowizja15_info").value = 'wartość marży * 15%= ' + parseFloat(salesMarginValue).toFixed(2) + ' * 15%';
        }
      // display data in info header
        document.getElementById("cost_prowizja15_top").value = parseFloat(salesComissionValue_15).toFixed(2);// print data in header
        document.getElementById("cost_prowizja15").value = parseFloat(salesComissionValue_15).toFixed(2);// print data in details

    // calculate sales comission as 2,5% from turnover on order
      document.getElementById("cost_2_5_info").value = '';
      // NOTE: does not work as prowizja_25proc_sales or prowizja_25proc_margin is noewhere defined
      // TODO: check in previous calculation versions where was prowizja_25proc_sales or prowizja_25proc_margin calculated
      if ((Ksales > prowizja_25proc_sales) && (salesComissionValue < prowizja_25proc_margin)) {
        salesComissionValue_2_5 = Ksales * 0.025;
        if (isNaN(salesComissionValue_2_5)) {
          salesComissionValue_2_5 = 0;
        }
        //if (salesComissionValue_2_5 > salesComissionValue) { salesComissionValue = salesComissionValue_2_5; }
        salesComissionValue = salesComissionValue_2_5;
        document.getElementById("cost_2_5_info").value = 'wartość sprzedaży * 2,5%= ' + parseFloat(Ksales).toFixed(2) + ' * 2,5%';
      }
      // display data in info header
        document.getElementById("cost_2_5_top").value = parseFloat(salesComissionValue_2_5).toFixed(2);// print data in header
        document.getElementById("cost_2_5").value = parseFloat(salesComissionValue_2_5).toFixed(2);// print data in details

    // calculate sales comission as 30% from sales margin value
        document.getElementById("cost_margin_1_3_info").value = '';
        if (salesComissionValue_2_5 > 0) { // NOTE: does not work as salesComissionValue_2_5 is not calculated because prowizja_25proc_sales or prowizja_25proc_margin is noewhere defined
          salesComissionValue_30 = salesMarginValue / 3;
          if (isNaN(salesComissionValue_30)) {
            salesComissionValue_30 = 0;
          }
          if (salesComissionValue_2_5 > salesComissionValue_30) {
            salesComissionValue = salesComissionValue_30;
          }
          //if (salesComissionValue_30 > salesComissionValue) { salesComissionValue = salesComissionValue_30; }
          if (salesComissionValue_30 > salesComissionValue) {
            salesComissionValue = salesComissionValue_30;
          }
          document.getElementById("cost_margin_1_3_info").value = 'wartość marży * 1/3= ' + parseFloat(salesMarginValue).toFixed(2) + ' * 1/3';
        }
      // display data in info header
        document.getElementById("cost_margin_1_3_top").value = parseFloat(salesComissionValue_30).toFixed(2);// print data in header
        document.getElementById("cost_margin_1_3").value = parseFloat(salesComissionValue_30).toFixed(2);// print data in details

  */
// END TRADITIONAL SALES COMISSION CALCULATION SECTION

      // Throughput calculations section

        // Define Variables to be used in this section
        var TVC = 0;                  // total variable costs
        var Nesting = 0;              // numer of ups on a sheet
        var TVC_unit = 0;             // total variable cost per unit
        var T_Unit = 0;               // throughput per unit
        //var DieTooling_Cost = 0;      // Die cut tooling cost
        var manualGluingExternalCosts = 0;           // Manual glueing external or piecework cost
        var GlueAExt_Cost = 0;        // Automatic external gluing costs
        var GlueAExtTrans_Cost = 0;   // Automatic external gluing transport costs
        var T = 0;                    // Throughput
        var T_comission = 0;          // Throughput comission
        var TSales = 0;               // Throughput to Sales percentage
        var TLabour = 0;              // Throughput per cumulated labour hours of an order {PLN/h}
        var T_proc = 0;               //Throughput comission percentage

        //Throughput levels variables (for now hardcoded to be taken from database later on)
        //var Threshold_TSales = 0.57;            // Throughput to Sales cannot be lower than x% for a calculation to be accepted
        var Threshold_TFixed = 500;            // Throughput cannot be lower that 500 PLN for a calculation to be accepted
        var Threshold_TFixed_per_sheet = 0.10;  // Throughput cannot be lower than x PLN/ sheet for a calculation to be accepted
        var Threshold_TLabour = 95;             // Throughput per labour hour cannot be lower than x PLN for a calculation to be accepted
        var throughputPerLabourInterval = 10;               // Span of the throughput per labour interval for comission calculation in PLN
        //var warningLevel_TSales = 0.61;         // desired throughput to sales level
        var warningLevel_TLabour = 105;         // Desired throughput to labour ratio
        var threshold_T_MinToMaxOutCapacity = 2000 //threshold of minimum throughput allowed to calculate a 1% provision in case throughput per labour is lower than Threshold_TLabour

        // Define what constitutes TVC
        
        // determine whether MANUAL gluing outsourcing is selected and if so change variable to true
          var inTVC_ManualGluing;
          var manualGluingOutsourcing = document.getElementById("manualGluingOutsourcing").value; // get outsouricing or piecework indicator from calculation
          if ((typeof manualGluingOutsourcing !== 'undefined') &&  manualGluingOutsourcing == 'yes') {
            inTVC_ManualGluing = true; // manual gluing done externaly thus in TVC
          } else {
            inTVC_ManualGluing = false; // manual gluing done internally thus not in TVC
          }
        // get manual gluing costs calculated as external or piecework from calculation fields
          manualGluingExternalCosts = parseFloat(document.occ.cost_glue.value);
          if (isNaN(manualGluingExternalCosts)) { manualGluingExternalCosts = 0; }

        // determine whether AUTOMATIC gluing outsourcing is selected and if so change variable to true
          var inTVC_AutomaticGluing;
          var automaticGluingOutsourcing = document.getElementById("automaticGluingOutsourcing").value; // get outsouricing or piecework indicator from calculation
            if ((typeof automaticGluingOutsourcing !== 'undefined') &&  automaticGluingOutsourcing == 'yes') {
              inTVC_AutomaticGluing = true; // automatic gluing done externalyy thus in TVC
            } else {
              inTVC_AutomaticGluing = false; // automatic gluing done internally thus not in TVC
            }
        // determine if other costs should be counted to TVC
          var inTVC_CostOther1 = true;        // other costs 1 in TVC
          var inTVC_CostOther2 = true;        // other costs 2 in TVC
          var inTVC_hiddenToolingCosts=true;  // hidden tooling costs in TVC
          var inTVC_DieTooling = false;        // die tooling costs in TVC



        //Nullify throughput fields
        document.getElementById("throughput_top").value = 0;
        document.getElementById("throughput").value = 0;
        document.getElementById("throughput_info").value = '';
        document.getElementById("throughput_unit_top").value = 0;
        document.getElementById("throughput_comission_top").value = 0;
        document.getElementById("throughput_comission").value = 0;
        document.getElementById("throughput_comission_info").value = '';
        document.getElementById("throughput_threshold_fixed").value = 0;
        document.getElementById("throughput_threshold_fixed_top").value = 0;
        document.getElementById("throughput_threshold_fixed_per_sheet").value = 0;
        document.getElementById("throughput_threshold_fixed_per_sheet_top").value = 0;
        document.getElementById("throughput_to_sales_warningLevel").value = 0;
        document.getElementById("throughput_to_sales_warningLevel_top").value = 0;
        document.getElementById("throughput_to_sales_threshold").value = 0;
        document.getElementById("throughput_to_sales_threshold_top").value = 0;
        document.getElementById("throughput_per_labour_warningLevel").value = 0;
        document.getElementById("throughput_per_labour_warningLevel_top").value = 0;

        /*
        DieTooling_Cost = parseFloat(document.occ.cost_dicut.value);
          if (isNaN(DieTooling_Cost)) { DieTooling_Cost = 0; }
        */
        GlueAExt_Cost = parseFloat(document.occ.cost_glue_automat.value);
          if (isNaN(GlueAExt_Cost)) { GlueAExt_Cost = 0; }
        GlueAExtTrans_Cost = parseFloat(document.occ.cost_trans_glue_automat.value);
          if (isNaN(GlueAExtTrans_Cost)) { GlueAExtTrans_Cost = 0; }

        // KM - Material costs value taken from count_cost_count_total function
          /* Following fields are added to get to KM value
          KM = parseFloat(document.getElementById("cost_paper1").value) + parseFloat(document.getElementById("cost_paper2").value);
          KM = KM + parseFloat(document.occ.cost_awers_material.value) + parseFloat(document.occ.cost_rewers_material.value);
          KM = KM + parseFloat(document.occ.cost_awers_material_clicha.value) + parseFloat(document.occ.cost_rewers_material_clicha.value);
          KM = KM + parseFloat(document.occ.cost_awers2_material.value) + parseFloat(document.occ.cost_rewers2_material.value);
          KM = KM + parseFloat(document.occ.cost_awers2_material_clicha.value) + parseFloat(document.occ.cost_rewers2_material_clicha.value);
          KM = KM + parseFloat(document.occ.cost_extra_plate.value) + parseFloat(document.occ.cost_extra_plate2.value);
            //KM        = KM+ parseFloat(document.occ.cost_ink_varnish_special_material.value);
          KM = KM + parseFloat(document.occ.cost_varnish_material.value) + parseFloat(document.occ.cost_varnish_uv_material.value);
          KM = KM + parseFloat(document.occ.cost_varnish2_material.value) + parseFloat(document.occ.cost_window_foil.value);
          KM = KM + parseFloat(document.occ.cost_gilding_material.value) + parseFloat(document.occ.cost_laminating_material.value);
          */

        // Kuz - External services costs from count_cost_count_total function
          /*
          Kuz = parseFloat(document.occ.cost_ink_varnish_special_out.value) + parseFloat(document.occ.cost_trans_ink_varnish_special_out.value);
            //Kuz       = Kuz+ parseFloat(document.occ.cost_glue.value);
            //Kuz       = Kuz+ parseFloat(document.occ.cost_glue_automat.value) + parseFloat(document.occ.cost_trans_glue_automat.value);
          Kuz = Kuz + parseFloat(document.occ.cost_falc.value) + parseFloat(document.occ.cost_trans_falc.value);
          Kuz = Kuz + parseFloat(document.occ.cost_bigowanie.value) + parseFloat(document.occ.cost_trans_bigowanie.value);
          Kuz = Kuz + parseFloat(document.occ.cost_stample.value) + parseFloat(document.occ.cost_trans_stample.value);
          Kuz = Kuz + parseFloat(document.occ.cost_foil.value) + parseFloat(document.occ.cost_trans_foil.value);
          Kuz = Kuz + parseFloat(document.occ.cost_transport.value);
          */

        // KD - External additional services costs from count_cost_count_total function
          /*
          KD = 0 + parseFloat(document.occ.cost_other1.value);
          KD = KD + parseFloat(document.occ.cost_other2.value);
          var matryc_show = 0;
          matryc_show = parseFloat(document.occ.cost_extra_matryce.value) + parseFloat(document.occ.cost_extra_matryce_extra.value);
          if (document.occ.gilding_box_matryce.checked) {
            document.occ.cost_extra_matryce_KD.value = parseFloat(matryc_show).toFixed(2);
            KD = KD + parseFloat(document.occ.cost_extra_matryce.value) + parseFloat(document.occ.cost_extra_matryce_extra.value);
          } else {
            document.occ.cost_extra_matryce_KPoz.value = parseFloat(matryc_show).toFixed(2);
            KPoz = KPoz + parseFloat(document.occ.cost_extra_matryce.value) + parseFloat(document.occ.cost_extra_matryce_extra.value);
          }
            //KD        = KD+ parseFloat(document.occ.cost_accept.value);
            //KD        = KD+ parseFloat(document.occ.cost_extra.value);
          */

       // Calculate total variable costs
          /*
          Includes following external services/ materials costs:
              1. Glueing + service transport
              2. Window pasting + service transport
              3. Die cut tooling costs
              4. Transportation costs
              5. Foiling costs + service transport
              6. Bigowanie costs + service transport
              7. Sztaplowanie costs + service transport
              8. Falcowanie costs + service transport
              9 . Cost other 1 (only if > 0 )
              10. Costs other 2 (only if > 0 )
              11. Hot stamping die if checked
          To be included:
              * Stripping tooling costs
          */

        //Check if other cost value is not negative (meaning somebody deducted costs in this filed, if so it cannot be used to calculate throughput)
        
        /*var cO1_mod = 0;
        var cO2_mod = 0;

        if (Cost_Other1 <0) {
          cO1_mod = 0;
        } else {
          cO1_mod = Cost_Other1;
        }

        if (Cost_Other2 <0) {
          cO2_mod = 0;
        } else {
          cO2_mod = Cost_Other2;
        }
        */
        // calculate TVC

          TVC = KM + Kuz; // starting out from material costs and external services

            if (inTVC_CostOther1) {TVC = TVC + Cost_Other1;}
            if (inTVC_CostOther2) {TVC = TVC + Cost_Other2;}
            if (inTVC_hiddenToolingCosts) {
              TVC = TVC + hiddenToolingCosts_Total;
              throughputInfoString +=  ' + ' + parseFloat(hiddenToolingCosts_Total).toFixed(2);
            }
            if (inTVC_ManualGluing) {TVC = TVC + manualGluingExternalCosts;}
            
            if (inTVC_AutomaticGluing) {TVC = TVC + GlueAExt_Cost + GlueAExtTrans_Cost;
            } else {
              // if automatic gluing costs not in TVC than zero out variables so they do not appear in TVC info string.
                GlueAExt_Cost =0;
                GlueAExtTrans_Cost=0;
            }

          // define throughput info string.
            var throughputInfoString = 'KM + Kuz + KD + KR + Kzewn + TransKzewn + Narzędzia wycinania = ' + parseFloat(KM).toFixed(2) +
            ' + ' + parseFloat(Kuz).toFixed(2) + ' + ' + parseFloat(KD).toFixed(2) + ' + ' + parseFloat(manualGluingExternalCosts).toFixed(2) +
            ' + ' + parseFloat(GlueAExt_Cost).toFixed(2) + ' + ' + parseFloat(GlueAExtTrans_Cost).toFixed(2);


          if (isNaN(TVC)) {
            TVC = 0;
          }

        // Calculate TVC per sheet
        Nesting = document.occ.product_paper_value1.value;
        TVC_unit = TVC/(qtyOrdered/Nesting);
        //TVC_unit = TVC/(qtyToProduce/Nesting);  // removed since in case of high tolerances the unit price was much reduced
        //Calculate Throughput value
        T = Ksales - TVC;
        //Calculate Throughput to Sales percentage
        TSales = T/Ksales;
        //Calculate Throughput per labour hours
        if (isFinite((T/countWorkTimes()))) {
          TLabour = T/countWorkTimes(); //Throughput per Labour hours
        } else {
          TLabour = T/1; // if count work times returns a 0 (as with outsourcings then divide by 1)
        }

        //Calculate Throughput per sheet value
        T_Unit = T/(qtyToProduce/Nesting);
        //T_Unit = T/(qtyOrdered/Nesting); // removed since in case of high tolerances the unit price was much reduced
        //Calculate Throughput comission value
          // has to be done later as threshold and warning levels need to be evaluated previusly


        //Display Througput information on calculation top info box

        document.getElementById("TVC_top").value = parseFloat(TVC).toFixed(2);
        document.getElementById("TVC_unit_top").value = parseFloat(TVC_unit).toFixed(4);
        document.getElementById("TVC_unit").value = parseFloat(TVC_unit).toFixed(4);
        document.getElementById("throughput_top").value = parseFloat(T).toFixed(2);
        document.getElementById("throughput").value = parseFloat(T).toFixed(2);
        document.getElementById("throughput_info").value = 'Sprzedaż - TVC = ( ' + parseFloat(Ksales).toFixed(2) + ' - ' + parseFloat(TVC).toFixed(2) + ' )';
        document.getElementById("throughput_unit_top").value = parseFloat(T_Unit).toFixed(4);
        document.getElementById("throughput_unit").value = parseFloat(T_Unit).toFixed(4);
        document.getElementById("TVC").value = parseFloat(TVC).toFixed(2);


        document.getElementById("TVC_info").value = throughputInfoString;
        // display throughput commision information
          // has to be done later after threshold and warning levels evaluation

        // display fixed Throughput threshold value
        document.getElementById("throughput_threshold_fixed_top").value = parseFloat(Threshold_TFixed).toFixed(2);
        document.getElementById("throughput_threshold_fixed_per_sheet_top").value = parseFloat(Threshold_TFixed_per_sheet).toFixed(4); // not used currently
        document.getElementById("throughput_threshold_fixed").value = parseFloat(Threshold_TFixed).toFixed(2);
        document.getElementById("throughput_threshold_fixed_per_sheet").value = parseFloat(Threshold_TFixed_per_sheet).toFixed(4); // not used currently
        // display Throughput to Sales percentage
        //document.getElementById("throughput_to_sales_threshold_top").value = parseFloat(Threshold_TSales*100).toFixed(2);
        document.getElementById("throughput_to_sales_threshold_top").value = 'off';
        //document.getElementById("throughput_to_sales_top").value = parseFloat(TSales*100).toFixed(2);
        document.getElementById("throughput_to_sales_top").value = 'off';
        //document.getElementById("throughput_to_sales_threshold").value = parseFloat(Threshold_TSales*100).toFixed(2);
        document.getElementById("throughput_to_sales_threshold").value = 'off';
        //document.getElementById("throughput_to_sales").value = parseFloat(TSales*100).toFixed(2);
        document.getElementById("throughput_to_sales").value = 'off';
        // display Throughput per labour hours
        document.getElementById("throughput_per_labour_threshold_top").value = parseFloat(Threshold_TLabour).toFixed(2);
        document.getElementById("throughput_per_labour_top").value = parseFloat(TLabour).toFixed(2);
        document.getElementById("throughput_per_labour_threshold").value = parseFloat(Threshold_TLabour).toFixed(2);
        document.getElementById("throughput_per_labour").value = parseFloat(TLabour).toFixed(2);
        // display throughput to sales and labour warning levels
        //document.getElementById("throughput_to_sales_warningLevel_top").value = parseFloat(warningLevel_TSales*100).toFixed(2);
        document.getElementById("throughput_to_sales_warningLevel_top").value = 'off';
        document.getElementById("throughput_per_labour_warningLevel_top").value = parseFloat(warningLevel_TLabour).toFixed(2);
        //document.getElementById("throughput_to_sales_warningLevel").value = parseFloat(warningLevel_TSales*100).toFixed(2);
        document.getElementById("throughput_to_sales_warningLevel").value = 'off';
        document.getElementById("throughput_per_labour_warningLevel").value = parseFloat(warningLevel_TLabour).toFixed(2);

    //Choose the 'best' comission
    document.getElementById("cost_goods_top").value = parseFloat(salesComissionValue).toFixed(2); // print data in header
    document.getElementById("cost_goods").value = parseFloat(salesComissionValue).toFixed(2); // print data in details

    ///blokada zapisu
    var sx = parseFloat(document.occ.sheetx1.value) / 1000;
    var sy = parseFloat(document.occ.sheety1.value) / 1000;
    var gr = parseFloat(document.occ.gram1.value) / 1000;
    var nest = parseFloat(document.occ.product_paper_value1.value);
    if ((sx) && (sy) && (gr) && (nest)) {
      document.getElementById("input_save_input").disabled = false;
    }
    document.getElementById("div_calculate").style.display = "none";


// Begin throughput threshold evaluation
        //set threshold booleans to false before evaluation
        var overThreshold_TSales = false;
        var overThreshold_TFixed = false;
        var overThreshold_TFixed_per_sheet = false;
        var overThreshold_TLabour = false;
        var overWarningLevel_TLabour = false; // level stating the desired throughput to threshold ratio
        var overWarningLevel_TSales = false; // level stating the desired throughput to sales ratio
        var alertMsg ="Uwaga! Nie osiagnieto: ";
        var thresholdMsg = "";

      //BEGIN EVALUATION OF THRESHOLD AND WARNING LEVEL CONDITIONS
          // Start evaluating throughput to sales ratio
        /*  turned off 04.06.2020
          if (TSales<Threshold_TSales){ // check if Threshold_TSales is met
            document.getElementById("throughput_to_sales").style.backgroundColor = colorRed;
            document.getElementById("throughput_to_sales_threshold").style.backgroundColor = colorRed;
            document.getElementById("throughput_to_sales_warningLevel").style.backgroundColor = colorRed;

            document.getElementById("throughput_to_sales_top").style.backgroundColor = colorRed;
            document.getElementById("throughput_to_sales_threshold_top").style.backgroundColor = colorRed;
            document.getElementById("throughput_to_sales_warningLevel_top").style.backgroundColor = colorRed;
            overThreshold_TSales = false;
            //thresholdMsg = "progu przerob do sprzedaży: " + Math.round(TSales*100) + " [%] < " + "progu: " + Threshold_TSales*100 + "[%]";
            //alert(alertMsg + thresholdMsg);


          } else if (TSales>=Threshold_TSales && TSales<warningLevel_TSales) {   // check if warning level throughput to sales ratio is met
            document.getElementById("throughput_to_sales").style.backgroundColor = colorYellow;
            document.getElementById("throughput_to_sales_threshold").style.backgroundColor = colorGreen;
            document.getElementById("throughput_to_sales_warningLevel").style.backgroundColor = colorYellow;

            document.getElementById("throughput_to_sales_top").style.backgroundColor = colorYellow;
            document.getElementById("throughput_to_sales_threshold_top").style.backgroundColor = colorGreen;
            document.getElementById("throughput_to_sales_warningLevel_top").style.backgroundColor = colorYellow;
            overWarningLevel_TSales = false;
            overThreshold_TSales = true;
            //thresholdMsg = "progu ostrzegawczego przerob do sprzedazy: " + Math.round(TSales*100) + " < " + "progu: " + warningLevel_TSales*100;
            //alert(alertMsg + thresholdMsg);

          } else { // if both not meet means it ok
            document.getElementById("throughput_to_sales").style.backgroundColor = colorGreen;
            document.getElementById("throughput_to_sales_threshold").style.backgroundColor = colorGreen;
            document.getElementById("throughput_to_sales_warningLevel").style.backgroundColor = colorGreen;

            document.getElementById("throughput_to_sales_top").style.backgroundColor = colorGreen;
            document.getElementById("throughput_to_sales_threshold_top").style.backgroundColor = colorGreen;
            document.getElementById("throughput_to_sales_warningLevel_top").style.backgroundColor = colorGreen;
            overThreshold_TSales = true;
            overWarningLevel_TSales = true;
          }
            turned off 04.06.2020 */

          // Start evaluating throughput to labour hours ratio
            if (TLabour<Threshold_TLabour){ // check if Threshold_TLabour is met
              document.getElementById("throughput_per_labour").style.backgroundColor = colorRed;
              document.getElementById("throughput_per_labour_threshold").style.backgroundColor = colorRed;
              document.getElementById("throughput_per_labour_warningLevel").style.backgroundColor = colorRed;

              document.getElementById("throughput_per_labour_top").style.backgroundColor = colorRed;
              document.getElementById("throughput_per_labour_threshold_top").style.backgroundColor = colorRed;
              document.getElementById("throughput_per_labour_warningLevel_top").style.backgroundColor = colorRed;
              overThreshold_TLabour = false;
              /*thresholdMsg = "progu przerob na godzine: " + Math.round(TLabour) + " < " + "progu: " + Threshold_TLabour;
              alert(alertMsg + thresholdMsg);
              */
            } else if (TLabour>=Threshold_TLabour && TLabour<warningLevel_TLabour){  // check if warning level throughput per labour hour is meet
              document.getElementById("throughput_per_labour").style.backgroundColor = colorYellow;
              document.getElementById("throughput_per_labour_threshold").style.backgroundColor = colorGreen;
              document.getElementById("throughput_per_labour_warningLevel").style.backgroundColor = colorYellow;

              document.getElementById("throughput_per_labour_top").style.backgroundColor = colorYellow;
              document.getElementById("throughput_per_labour_threshold_top").style.backgroundColor = colorGreen;
              document.getElementById("throughput_per_labour_warningLevel_top").style.backgroundColor = colorYellow;
              overThreshold_TLabour = true;
              overWarningLevel_TLabour = false;
              /*thresholdMsg = "progu ostrzegawczego wartosc przerobu na roboczogodzine: " + Math.round(TLabour) + " < " + "progu: " + warningLevel_TLabour;
              alert(alertMsg + thresholdMsg);
              */
            } else { // if both not meet means it ok
              document.getElementById("throughput_per_labour").style.backgroundColor = colorGreen;
              document.getElementById("throughput_per_labour_threshold").style.backgroundColor = colorGreen;
              document.getElementById("throughput_per_labour_warningLevel").style.backgroundColor = colorGreen;

              document.getElementById("throughput_per_labour_top").style.backgroundColor = colorGreen;
              document.getElementById("throughput_per_labour_threshold_top").style.backgroundColor = colorGreen;
              document.getElementById("throughput_per_labour_warningLevel_top").style.backgroundColor = colorGreen;
              overThreshold_TLabour = true;
              overWarningLevel_TLabour = true;
            }

          // Start evaluating throughput to fixed ratio
            if (T<Threshold_TFixed){ // check if Threshold_TFixed is met
              document.getElementById("throughput_top").style.backgroundColor = colorRed;
              document.getElementById("throughput").style.backgroundColor = colorRed;
              document.getElementById("throughput_threshold_fixed").style.backgroundColor = colorRed;
              document.getElementById("throughput_threshold_fixed_top").style.backgroundColor = colorRed;
              overThreshold_TFixed = false;
              /*thresholdMsg = "progu wartość przerobu: " +  Math.round(T*100) + " < " + "progu: " + Threshold_TFixed;
              alert(alertMsg + thresholdMsg);
              */
            } else {
              document.getElementById("throughput_top").style.backgroundColor = colorGreen;
              document.getElementById("throughput").style.backgroundColor = colorGreen;
              document.getElementById("throughput_threshold_fixed").style.backgroundColor = colorGreen;
              document.getElementById("throughput_threshold_fixed_top").style.backgroundColor = colorGreen;
              overThreshold_TFixed = true;
            }

          // Start evaluating throughput per sheet to fixed ratio
            if (T_Unit<Threshold_TFixed_per_sheet){// check if threshold throughput per sheet fixed is meet
              document.getElementById("throughput_unit_top").style.backgroundColor = colorRed;
              document.getElementById("throughput_threshold_fixed_per_sheet_top").style.backgroundColor = colorRed;
              document.getElementById("throughput_unit").style.backgroundColor = colorRed;
              document.getElementById("throughput_threshold_fixed_per_sheet").style.backgroundColor = colorRed;
              overThreshold_TFixed_per_sheet = false;
              /*thresholdMsg = "progu wartosc przerobu na arkusz: " + Math.round(T_Unit*1000) + " < " + "progu: " + Threshold_TFixed_per_sheet;
              alert(alertMsg + thresholdMsg);
              */
            } else {
              document.getElementById("throughput_unit_top").style.backgroundColor = colorGreen;
              document.getElementById("throughput_threshold_fixed_per_sheet_top").style.backgroundColor = colorGreen;
              document.getElementById("throughput_unit").style.backgroundColor = colorGreen;
              document.getElementById("throughput_threshold_fixed_per_sheet").style.backgroundColor = colorGreen;
              overThreshold_TFixed_per_sheet = true;
            }
    //END OF EVALUATION OF THRESHOLD AND WARNING LEVEL CONDITIONS

    // BEGIN OF EVALUATION IF ALL CONDITIONS ARE MEET TO ALLOW A CALCULATION TO BE ACCEPTED
        // Check if calculation meets all set thresholds
          /* currently a calculation is accepted only if one of two following conditions is met
            // overThreshold_TSales - disabled 04.06.2020
            overThreshold_TLabour - as 0f 04.06.2020 only this condition counts

            AND one below
            overThreshold_TFixed

            This one is not taken into account
            overThreshold_TFixed_per_sheet
          */
        if (overThreshold_TLabour && overThreshold_TFixed) {
        document.getElementById("input_save_input").disabled = false; // allow saving by user
        document.getElementById("input_save_input").className= "button_active"; //mark save button as active
        document.getElementById("labelSaveInput").className= "button-label_active"; //mark save button as active
        } else {
        //document.getElementById("input_save_input").disabled = true; // prevent saving by user
        //document.getElementById("input_save_input").className = "button-label_inactive"; // mark save button as disabled
        }
    // END OF OF EVALUATION IF ALL CONDITIONS ARE MEET TO ALLOW A CALCULATION TO BE ACCEPTED

//Calculate Throughput comission value
    T_proc = calculateThrougputComission (throughputPerLabourInterval,T,T_Unit,TLabour,Threshold_TFixed,Threshold_TFixed_per_sheet,threshold_T_MinToMaxOutCapacity,Threshold_TLabour,warningLevel_TLabour,overThreshold_TLabour, overWarningLevel_TLabour);
// Calculate throughput commission
    //T_comission = T * T_proc;             // comission is calculated as percent of throughput and lowers throughput for the company
   T_comission = T_proc * (T/(1+T_proc));   // firts a hypothetical throughput value is calculated, by subtracting commission from throughput and then comission is calulated by multiplying this hypothetical throughput by comission percentage,
// display information in top info header
    document.getElementById("throughput_comission_top").value = parseFloat(T_comission).toFixed(2);
    document.getElementById("throughput_comission_percent_top").value = parseFloat(T_proc*100).toFixed(2);
    document.getElementById("throughput_comission").value = parseFloat(T_comission).toFixed(2);
    document.getElementById("throughput_comission_percent").value = parseFloat(T_proc*100).toFixed(2);
    document.getElementById("throughput_comission_info").value = 'Przerob * % prowizji=( ' + parseFloat(T).toFixed(2) + ' * ' + parseFloat(T_proc).toFixed(4) + ' * 100 % + % )';

// call function to recalculate qty if any provided
// get the qty new value from a hidden field in calculation.
  let quickRecalculationQty = document.querySelector("#quickRecalculationQty").value;
  // if the qty new hidden field is populated meaning the user has entered a new order qty for quick recalculation than proceed
    if (quickRecalculationQty){setTimeout(quickRecalculate(quickRecalculationQty,Ksales,salesMarginValue),5000);}
  
}


// NOTE: this part of code is run only when the user is using order_calculation_show_qty.php to enter additional qty for quick recalculation of sales, unit price and margins
function quickRecalculate (quickRecalculationQty, salesTotal,salesMarginValue) {
///wchodze z poziomu nowejkalkualcji ilości....
// FIX: this doesn't get the salesTotal and the salesMarginValue recalculated properly with the new qty provided by user. As a result sales Total stays constant but unit price changes because qty changes in order_calculation_show_qty
/*

TODO: either make a function that would evaluate on calculation load the new qty with provided by user with the qty saved and trigger change qty event handler
or
find where in code is the orderqty taken to calculate sales etc

*/


    // if the qty new hidden field is populated meaning the user has entered a new order qty for quick recalculation than proceed
      //TODO: bulshit again doubled code, its already qty_new variable
      // get the order_qty_new once more from hidded field
        var quickRecalculationQty_Verification = parseFloat(document.occ.order_qty_new.value).toFixed(0);
      // get the current oc_id from html field
        var oc_id = parseFloat(document.occ.oc_id.value);
      // get the current recalculated name of the qty new like order_qty... where ... is and integer number
        var qty_name = document.occ.order_qty_name.value;
      // get the recalculated margin in percentage
        var margin_new = document.occ.margin_new.value;
      // get the recalculated marigin in PLN
        var margin_pln_new = document.occ.margin_pln_new.value;
      // check if the current recalculated qty is over 0  and if its equal to ... FUCK SHIT BULLSHIT doubled code

        if ((quickRecalculationQty_Verification > 0) && (quickRecalculationQty_Verification === quickRecalculationQty)) {
          // close the recalculation window fast and open the order_calculation_show_qty window in its place while passing recalculated values in GET variable that will be used to populate html input field in order_calculation_show_qty and saved to db to order_calculation_datas
          window.location = './order_calculation_show_qty.php?action=save_qty&oc_id=' + oc_id + '&back=show&qty_name=' + qty_name + '&qty_new=' + quickRecalculationQty_Verification + '&margin_new=' + margin_new + '&margin_pln_new=' + margin_pln_new + '&sales=' + salesTotal + '&margin=' + salesMarginValue;
        } else {
          // display an error message a
          window.location = './order_calculation_show_qty.php?action=show&oc_id=' + oc_id + '&back=show&error=wrong_qty';
          document.getElementById("div_calculate").style.display = "";
          document.getElementById("input_save_input").disabled = true;
        }
// TODO: what does this part do???
    ///wchodze z liczenia ceny podczas zamiana wiądacej ilośc nakład....
    var qty_change = document.occ.order_qty_change.value;
    if (qty_change) {
      setTimeout(function() {
        var myButton = document.getElementById("input_save_input");
        myButton.click();
      }, TimeOut);
    }
}



function ShowOrHideElementsAndDisplayInfo(warningMsg,element1,element2,element3,element4) {
    // to be defined later on
    ///Hide info that unit cost or margin has been set manually

    //remove styles from elements
    document.getElementById("cost_sales_one").style.backgroundColor = "";
    document.getElementById("cost_sales").style.backgroundColor = "";
    document.getElementById("warningRow").style.backgroundColor = "";
    //hide elements
    document.getElementById("warningRow").style.display = "none";


  }

function calculateThrougputComission (throughputPerLabourInterval,t,t_PerUnit,t_PerLabour,threshold_t_Fixed,threshold_t_FixedPerSheet,threshold_T_MinToMaxOutCapacity,threshold_t_PerLabour,warningLevel_TLabour,overThreshold_TLabour, overWarningLevel_TLabour) {
  /* removed t to sales as a basis for comission calculation
  Calculates t_ comission (TC) based on t_ to sales ratio // (t_ToSales) and given intervals (throughputPerLabourInterval) and thresholds
  t_ per labour hours (TLaabour) and a set of thresholds:
  // 1. threshold_t_ToSales - t_ToSales cannot be lower than this threshold.
  t_ comission percentage is assigned starting from this level and increases with each throughputPerLabourInterval
  2. threshold_t_Fixed - tbd
  3. threshold_t_PerLabour - tbd
  */
  var TC = 0; // t_ comission percentage
    // 04.06.2020 removed throughput to sales from throughput commission evaluations and replaced it with throughput per labour
    if (t>=threshold_t_Fixed && t_PerLabour>=threshold_t_PerLabour) { // fixed threshold must always be surpassed and one of two (sales or thougput per labour) have to be surpassed
        switch (true) { // acc. to https://stackoverflow.com/questions/5464362/javascript-using-a-condition-in-switch-case/9055603#9055603
          case t_PerLabour>threshold_t_PerLabour && t_PerLabour<warningLevel_TLabour:
            TC = 0.025
            break;
          case t_PerLabour>threshold_t_PerLabour && t_PerLabour>warningLevel_TLabour && t_PerLabour <threshold_t_PerLabour + throughputPerLabourInterval:
            TC = 0.027
            break;
          case t_PerLabour>=threshold_t_PerLabour && t_PerLabour>warningLevel_TLabour && t_PerLabour>=threshold_t_PerLabour+throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+2*throughputPerLabourInterval:
            TC = 0.03;
            break;
          case t_PerLabour>=threshold_t_PerLabour+2*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+3*throughputPerLabourInterval:
            TC = 0.0325;
            break;
          case t_PerLabour>=threshold_t_PerLabour+3*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+4*throughputPerLabourInterval:
            TC = 0.035;
            break;
          case t_PerLabour>=threshold_t_PerLabour+4*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+5*throughputPerLabourInterval:
            TC = 0.0375;
            break;
          case t_PerLabour>=threshold_t_PerLabour+5*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+6*throughputPerLabourInterval:
            TC = 0.04;
            break;
          case t_PerLabour>=threshold_t_PerLabour+6*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+7*throughputPerLabourInterval:
            TC = 0.0425;
            break;
          case t_PerLabour>=threshold_t_PerLabour+7*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+8*throughputPerLabourInterval:
            TC = 0.045;
            break;
          case t_PerLabour>=threshold_t_PerLabour+8*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+9*throughputPerLabourInterval:
            TC = 0.0475;
            break;
          case t_PerLabour>=threshold_t_PerLabour+9*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+10*throughputPerLabourInterval:
            TC = 0.05;
            break;
          case t_PerLabour>=threshold_t_PerLabour+10*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+11*throughputPerLabourInterval:
            TC = 0.0525;
            break;
          case t_PerLabour>=threshold_t_PerLabour+11*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+12*throughputPerLabourInterval:
            TC = 0.055;
            break;
          case t_PerLabour>=threshold_t_PerLabour+12*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+13*throughputPerLabourInterval:
            TC = 0.0575;
            break;
          case t_PerLabour>=threshold_t_PerLabour+13*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+14*throughputPerLabourInterval:
            TC = 0.06;
            break;
          case t_PerLabour>=threshold_t_PerLabour+14*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+15*throughputPerLabourInterval:
            TC = 0.0625;
            break;
          case t_PerLabour>=threshold_t_PerLabour+15*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+16*throughputPerLabourInterval:
            TC = 0.065;
            break;
          case t_PerLabour>=threshold_t_PerLabour+16*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+17*throughputPerLabourInterval:
            TC = 0.065;
            break;
          case t_PerLabour>=threshold_t_PerLabour+17*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+18*throughputPerLabourInterval:
            TC = 0.0675;
            break;
          case t_PerLabour>=threshold_t_PerLabour+18*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+19*throughputPerLabourInterval:
            TC = 0.07;
            break;
          case t_PerLabour>=threshold_t_PerLabour+19*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+20*throughputPerLabourInterval:
            TC = 0.0725;
            break;
          case t_PerLabour>=threshold_t_PerLabour+20*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+21*throughputPerLabourInterval:
            TC = 0.075;
            break;
          case t_PerLabour>=threshold_t_PerLabour+21*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+22*throughputPerLabourInterval:
            TC = 0.0775;
            break;
          case t_PerLabour>=threshold_t_PerLabour+22*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+25*throughputPerLabourInterval:
            TC = 0.08;
            break;
          case t_PerLabour>=threshold_t_PerLabour+25*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+28*throughputPerLabourInterval:
            TC = 0.0825;
            break;
          case t_PerLabour>=threshold_t_PerLabour+28*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+31*throughputPerLabourInterval:
            TC = 0.085;
            break;
          case t_PerLabour>=threshold_t_PerLabour+31*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+34*throughputPerLabourInterval:
            TC = 0.0875;
            break;
          case t_PerLabour>=threshold_t_PerLabour+34*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+37*throughputPerLabourInterval:
            TC = 0.09;
            break;
          case t_PerLabour>=threshold_t_PerLabour+37*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+40*throughputPerLabourInterval:
            TC = 0.0925;
            break;
          case t_PerLabour>=threshold_t_PerLabour+40*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+43*throughputPerLabourInterval:
            TC = 0.095;
            break;
          case t_PerLabour>=threshold_t_PerLabour+43*throughputPerLabourInterval && t_PerLabour<threshold_t_PerLabour+46*throughputPerLabourInterval:
            TC = 0.0975;
            break;
          case t_PerLabour>=threshold_t_PerLabour+46*throughputPerLabourInterval:
            TC = 0.1;
            break;
        }
   } else if (t_PerLabour< threshold_t_PerLabour && t > threshold_T_MinToMaxOutCapacity) {
     TC = 0.01 // comissison used in case when throughput per labour is below the threshold but throughput is high so to max out capacity we accept an order
   } else {
     TC = 0;
   }

console.log('Calculated throughput comission percentage: ', Math.round(TC * 100), ' %');
return TC;

}
/*
function increaseComissionIfOverWarnignLevel(TC,overThreshold_TSales, overThreshold_TLabour, overWarningLevel_TSales, overWarningLevel_TLabour) {
// no longern in use since 04.06.2020
/*
  function takes in:

  1. basic throughput commision (TC),
  2. overThreshold_TSales boolean,
  3. overThreshold_TLabour boolean,
  4. overWarningLevel_TSales boolean,
  5. overWarningLevel_TLabour boolean,

   for an throughput to sales interval and evaluates whether to increase it by a certain percentage if warnign levels have been surpassed
   it returns the TC percentage
*/
/*
  switch (true) { // begin evaluating warnign levels
    case ((overThreshold_TSales || overThreshold_TLabour) && overWarningLevel_TSales && overWarningLevel_TLabour): // if both of warnign levels are surpassed add 0.5 percentage points per level
        TC = TC + 0.01;
      break;
    case ((overThreshold_TSales || overThreshold_TLabour) && overWarningLevel_TSales && !overWarningLevel_TLabour): // if one level is surpassed add 0.5 full percenatage point and 0,5 percentage points
        TC = TC + 0.005;
      break;
    case ((overThreshold_TSales || overThreshold_TLabour) && !overWarningLevel_TSales && overWarningLevel_TLabour): // if one level is surpassed add 0.5 full percenatage point and 0,5 percentage points
        TC = TC + 0.005;
      break;
    case ((overThreshold_TSales || overThreshold_TLabour) && !overWarningLevel_TSales && !overWarningLevel_TLabour): // if both warnign levels are not surpassed add 0,5 percentage points per level
        TC = TC;
      break;
    case !overThreshold_TSales && !overThreshold_TLabour: // if both of threshold are not met than return 0 comission
      TC = 0;
      break;
  }
  return TC;
}
*/
  function write_week_end_date() { ///wypisuje jaki jest dzięń tygodnia - tylko jełsi wypełniona jest data wymagana klienta
    var d = document.occ.end_date.value; ///pobieram z jakiej daty wyznaczam dzień
    if (d) {
      var d_arr = d.split('-'); //rozbijam date do tablicy
      var y = d_arr[0] * 1;
      var m = d_arr[1] * 1;
      d = d_arr[2] * 1;
      var onejan = new Date(y, 0, 1);
      var nrDay = onejan.getDay(); //jaki to dzień tygodznia
      switch (nrDay) { ///co robie, jeśli początek roku to środek tygodznia
        case 1:
          nrDay = 0;
          break; //poniedziałek
        case 2:
          nrDay = 1;
          break; //wtorek
        case 3:
          nrDay = 2;
          break; //środa
        case 4:
          nrDay = 3;
          break; //czwartek
        case 5:
          nrDay = -3;
          break; //piatek
        case 6:
          nrDay = -2;
          break; //sobota
        case 0:
          nrDay = -1;
          break; ///niedzizela
      }
      var today = new Date(y, m - 1, d);
      var weekNumber1 = Math.ceil(((today - onejan) / 86400000) + 1); ///który zatem teraz jest dzień roku
      var weekNumber2 = weekNumber1 + nrDay; //czy coś dodaje - bo rok zaczał się w połowie tygodznia
      var weekNumber3 = Math.ceil(weekNumber2 / 7); //który to tydzień.
      if (isNaN(weekNumber3)) {
        weekNumber3 = '';
      }
      document.occ.end_week.value = weekNumber3;
    }
  }

  function onunloadHandler() {
    //alert('Opuszczasz strone!'); return false;
    //if (!confirm('Opuszczasz strone?')) return false;
    //if(!confirm( 'Czy na pewno?') ) {
    //  occ.tolerant.focus(); return (false);
    //}
  }

function countWorkTimes() {
  /*
  potrzeba znalezc sposob na dostanie sie przez funkcje do danych na ktorych sie opiera
  mozna to zrobic albo poprzez przekazanie jej w parametrach wszystkich potrzebnych do obliczen danych:
   tylko, ze to spowoduje, ze w dwoch miejscach bede mial te same obliczenia i bedzie klopot z aktualizacja
    var MWqty = document.occ.order_qty1_less.value;

  albo zrobienie z tych danych zmiennych globalnych w istniejacej functions_occ.js
  i to bedzie szybsze oraz zachowam ciaglosc funkcji bez zmiany sposobow obliczenia
  a pozniej wraz ze zmiana funkcji obliczajacych poszczegolne operacje na bardziej sensowne zmieni sie i te funkcje

  trzeba tez wyciagnac naddatki % arkuszy na kazdy proces

  */

  // define variables to be used throughout function
  var RunTime_Gilotyna = 0;
  var IdleTime_Gilotyna =0;
  var RunTime_Gilotyna2 =0;
  var IdleTime_Gilotyna2 =0;

  var SetupTime_PrintAwers = 0;
  var RunTime_PrintAwers = 0;
  var IdleTime_PrintAwers = 0;

  var SetupTime_PrintRewers = 0;
  var RunTime_PrintRewers = 0;
  var IdleTime_PrintRewers = 0;

  var SetupTime_PrintAwers2 = 0;
  var RunTime_PrintAwers2 = 0;
  var IdleTime_PrintAwers2 = 0;

  var SetupTime_PrintRewers2 = 0;
  var RunTime_PrintRewers2 = 0;
  var IdleTime_PrintRewers2 = 0;

  var RunTime_VarnishOffset = 0;
  var SetupTime_HS = 0;
  var RunTime_HS = 0;
  var IdleTime_HS = 0;

  var SetupTime_VarnishUV = 0;
  var RunTime_VarnishUV = 0;
  var IdleTime_VarnishUV = 0;

  var SetupTime_LithoLamination = 0;
  var RunTime_LithoLamination = 0;
  var IdleTime_LithoLamination = 0;

  var SetupTime_DieCutting = 0;
  var RunTime_DieCutting = 0;
  var IdleTime_DieCutting = 0;

  var SetupTime_Separation =0;
  var RunTime_Separation = 0;
  var IdleTime_Separation = 0;

  var windowPatchingRunTime =0;

  var manualGluingRunTime = 0;
  var manualGluingIdleTime = 0;
  var manualGluingTotalTime =0;

  var setupTime_AutomaticGluing = 0;
  var runTime_AutomaticGluing = 0;
  var idleTime_AutomaticGluing = 0;
  var automaticGluingTotalTime=0;
  var totalAutomaticGluingCost =0;

  //ITAa_c = parseFloat(document.occ.awers_cmyk_qty_colors.value);

  // outsourcing type variables
    /*
      outsourcing_Priting                 // printing outsourced
      outsourcing_All                     // everything outsourced
      outsourcing_DieCutting              // diecutting outsourced
      outsourcing_RawMaterial_and_Priting // raw material and printing outsourced
      outsourcing_All_but_RawMaterial     // everyting outsourced except raw material
      outsourcing_UV                      // UV priting outsourced
    */

  // liczymy czasy gilotyny,
  if ((CUTcut_s > "0") && (outsourcing_Priting === false && outsourcing_All === false && outsourcing_RawMaterial_and_Priting === false && outsourcing_All_but_RawMaterial === false )) {
    RunTime_Gilotyna = parseFloat(CUTtime_jazda); //gilotyna jazda [h]
    IdleTime_Gilotyna = parseFloat(CUTtime_idle); //gilotyna jazda [h]
    // print hours and minutes on screen
    document.getElementById("cutterRunTime").value = hoursTohhmm(CUTtime_jazda);
    document.getElementById("cutterIdleTime").value = hoursTohhmm(CUTtime_idle);
    document.getElementById("cutterTotalTime").value = hoursTohhmm(CUTtime_jazda);// + CUTtime_idle);
  } else { // nulify field values
    RunTime_Gilotyna = 0; //gilotyna jazda [h]
    IdleTime_Gilotyna = 0; //gilotyna jazda [h]

    if (outsourcing_Priting || outsourcing_All || outsourcing_RawMaterial_and_Priting || outsourcing_All_but_RawMaterial) {
        // change only total times displayed to 0 to signal that outsourcing is in place
        document.getElementById("cutterTotalTime").value = hoursTohhmm(0);
    } else {
        // change all times to 0 if operation was not selected
        document.getElementById("cutterRunTime").value = hoursTohhmm(0);
        document.getElementById("cutterIdleTime").value = hoursTohhmm(0);
        document.getElementById("cutterTotalTime").value = hoursTohhmm(0);
    }

  }
  // to liczymy czasy gilotyny 2
  if ((CUT2cut_s > "0") && (CUT2_check) && (outsourcing_Priting === false && outsourcing_All === false && outsourcing_RawMaterial_and_Priting === false && outsourcing_All_but_RawMaterial === false )) {
    RunTime_Gilotyna2 = parseFloat(CUT2time_jazda); //gilotyna jazda [h]
    IdleTime_Gilotyna2 = parseFloat(CUT2time_idle); //gilotyna jazda [h]
      // print hours and minutes on screen
      document.getElementById("cutter2RunTime").value = hoursTohhmm(CUT2time_jazda);
      document.getElementById("cutter2IdleTime").value = hoursTohhmm(CUT2time_idle);
      document.getElementById("cutter2TotalTime").value = hoursTohhmm(CUT2time_jazda);// + CUT2time_idle);
  } else { // nulify field values
    RunTime_Gilotyna2 = 0; //gilotyna jazda [h]
    IdleTime_Gilotyna2 = 0; //gilotyna jazda [h]

    if (outsourcing_Priting || outsourcing_All || outsourcing_RawMaterial_and_Priting || outsourcing_All_but_RawMaterial) {
        // change only total times displayed to 0 to signal that outsourcing is in place
        document.getElementById("cutter2TotalTime").value = hoursTohhmm(0);
    } else {
        // change all times to 0 if operation was not selected
        document.getElementById("cutter2RunTime").value = hoursTohhmm(0);
        document.getElementById("cutter2IdleTime").value = hoursTohhmm(0);
        document.getElementById("cutter2TotalTime").value = hoursTohhmm(0);
    }

  }
  // jesli mamy kolor CMYK lub kolor pantone na awersie
  if ( ((ITAa_c > 0) || (ITAa_p > 0)) && (outsourcing_Priting === false && outsourcing_All === false && outsourcing_RawMaterial_and_Priting === false && outsourcing_All_but_RawMaterial === false )) {
    // to liczymy czasy druku awers_setup

    SetupTime_PrintAwers = printingSetupTime_awers; //Druk awers setup [h]
    RunTime_PrintAwers = printingRunTime_awers; //Druk awers jazda [h]
    IdleTime_PrintAwers = printingIdleTime_awers; // Druk awers idle [h]
    // print hours and minutes on screen
    document.getElementById("printingAwersSetupTime").value = hoursTohhmm(printingSetupTime_awers);
    document.getElementById("printingAwersRunTime").value = hoursTohhmm(printingRunTime_awers);
    document.getElementById("printingAwersIdleTime").value = hoursTohhmm(printingIdleTime_awers);
    document.getElementById("printingAwersTotalTime").value = hoursTohhmm(printingSetupTime_awers + printingRunTime_awers);// + printingIdleTime_awers);
  } else { // nulify field values
    SetupTime_PrintAwers = 0; //Druk awers setup [h]
    RunTime_PrintAwers = 0; //Druk awers jazda [h]
    IdleTime_PrintAwers = 0; // Druk awers idle [h]
    // zero out priting times on awers
    if (outsourcing_Priting || outsourcing_All || outsourcing_RawMaterial_and_Priting || outsourcing_All_but_RawMaterial) {
        // change only total times displayed to 0 to signal that outsourcing is in place
        document.getElementById("printingAwersTotalTime").value = hoursTohhmm(0);
    } else {
        // change all times to 0 if operation was not selected
        document.getElementById("printingAwersSetupTime").value = hoursTohhmm(0);
        document.getElementById("printingAwersRunTime").value = hoursTohhmm(0);
        document.getElementById("printingAwersIdleTime").value = hoursTohhmm(0);
        document.getElementById("printingAwersTotalTime").value = hoursTohhmm(0);
    }
  }

  // jesli mamy kolor CMYK lub kolor pantone na rewersie
  if (((ITAr_c > 0) || (ITAr_p > 0)) && (outsourcing_Priting === false && outsourcing_All === false && outsourcing_RawMaterial_and_Priting === false && outsourcing_All_but_RawMaterial === false )) {
    SetupTime_PrintRewers = printingSetupTime_rewers; //Druk rewers setup [h]
    RunTime_PrintRewers = parseFloat(printingRunTime_rewers); // - Druk rewers jazda [h]
    IdleTime_PrintRewers = parseFloat(printingIdleTime_rewers);
    // print hours and minutes on screen
    document.getElementById("printingRewersSetupTime").value = hoursTohhmm(printingSetupTime_rewers);
    document.getElementById("printingRewersRunTime").value = hoursTohhmm(printingRunTime_rewers);
    document.getElementById("printingRewersIdleTime").value = hoursTohhmm(printingIdleTime_rewers);
    document.getElementById("printingRewersTotalTime").value = hoursTohhmm(printingSetupTime_rewers + printingRunTime_rewers);// + printingIdleTime_rewers);
  } else { // nulify field values
    SetupTime_PrintRewers = 0; //Druk rewers setup [h]
    RunTime_PrintRewers = 0; // - Druk rewers jazda [h]
    IdleTime_PrintRewers = 0;

    if (outsourcing_Priting || outsourcing_All || outsourcing_RawMaterial_and_Priting || outsourcing_All_but_RawMaterial) {
        // change only total times displayed to 0 to signal that outsourcing is in place
        document.getElementById("printingRewersTotalTime").value = hoursTohhmm(0);
    } else {
        // change all times to 0 if operation was not selected
        document.getElementById("printingRewersSetupTime").value = hoursTohhmm(0);
        document.getElementById("printingRewersRunTime").value = hoursTohhmm(0);
        document.getElementById("printingRewersIdleTime").value = hoursTohhmm(0);
        document.getElementById("printingRewersTotalTime").value = hoursTohhmm(0);
    }
  }

  // jesli mamy kolor CMYK lub kolor pantone na awersie II
  if (((ITA2a_c > 0) || (ITA2a_p > 0)) && (outsourcing_Priting === false && outsourcing_All === false && outsourcing_RawMaterial_and_Priting === false && outsourcing_All_but_RawMaterial === false )) {
    SetupTime_PrintAwers2 = printingSetupTime_awers2; //Druk rewers setup [h]
    RunTime_PrintAwers2 = parseFloat(printingRunTime_awers2); // - Druk rewers jazda [h]
    IdleTime_PrintAwers2 = parseFloat(printingIdleTime_awers2);
    // print hours and minutes on screen
    document.getElementById("printingAwers2SetupTime").value = hoursTohhmm(printingSetupTime_awers2);
    document.getElementById("printingAwers2RunTime").value = hoursTohhmm(printingRunTime_awers2);
    document.getElementById("printingAwers2IdleTime").value = hoursTohhmm(printingIdleTime_awers2);
    document.getElementById("printingAwers2TotalTime").value = hoursTohhmm(printingSetupTime_awers2 + printingRunTime_awers2);// + printingIdleTime_awers2);
  } else { // nulify field values
    SetupTime_PrintAwers2 = 0; //Druk rewers setup [h]
    RunTime_PrintAwers2 = 0; // - Druk rewers jazda [h]
    IdleTime_PrintAwers2 = 0;

    if (outsourcing_Priting || outsourcing_All || outsourcing_RawMaterial_and_Priting || outsourcing_All_but_RawMaterial) {
        // change only total times displayed to 0 to signal that outsourcing is in place
        document.getElementById("printingAwers2TotalTime").value = hoursTohhmm(0);
    } else {
        // change all times to 0 if operation was not selected
        document.getElementById("printingAwers2SetupTime").value = hoursTohhmm(0);
        document.getElementById("printingAwers2RunTime").value = hoursTohhmm(0);
        document.getElementById("printingAwers2IdleTime").value = hoursTohhmm(0);
        document.getElementById("printingAwers2TotalTime").value = hoursTohhmm(0);
    }
  }

  // jesli mamy kolor CMYK lub kolor pantone na rewersie II
  if (((ITA2r_c > 0) || (ITA2r_p > 0)) && (outsourcing_Priting === false && outsourcing_All === false && outsourcing_RawMaterial_and_Priting === false && outsourcing_All_but_RawMaterial === false )) {
    SetupTime_PrintRewers2 = printingSetupTime_rewers2; //Druk rewers setup [h]
    RunTime_PrintRewers2 = parseFloat(printingRunTime_rewers2); // - Druk rewers jazda [h]
    IdleTime_PrintRewers2 = parseFloat(printingIdleTime_rewers2);
    // print hours and minutes on screen
    document.getElementById("printingRewers2SetupTime").value = hoursTohhmm(printingSetupTime_rewers2);
    document.getElementById("printingRewers2RunTime").value = hoursTohhmm(printingRunTime_rewers2);
    document.getElementById("printingRewers2IdleTime").value = hoursTohhmm(printingIdleTime_rewers2);
    document.getElementById("printingRewers2TotalTime").value = hoursTohhmm(printingSetupTime_rewers2 + printingRunTime_rewers2);// + printingIdleTime_rewers2);
  } else { // nulify field values
    SetupTime_PrintRewers2 = 0; //Druk rewers setup [h]
    RunTime_PrintRewers2 = 0; // - Druk rewers jazda [h]
    IdleTime_PrintRewers2 = 0;

    if (outsourcing_Priting || outsourcing_All || outsourcing_RawMaterial_and_Priting || outsourcing_All_but_RawMaterial) {
        // change only total times displayed to 0 to signal that outsourcing is in place
        document.getElementById("printingRewers2TotalTime").value = hoursTohhmm(0);
    } else {
        // change all times to 0 if operation was not selected
        document.getElementById("printingRewers2SetupTime").value = hoursTohhmm(0);
        document.getElementById("printingRewers2RunTime").value = hoursTohhmm(0);
        document.getElementById("printingRewers2IdleTime").value = hoursTohhmm(0);
        document.getElementById("printingRewers2TotalTime").value = hoursTohhmm(0);
    }
  }


  // count Varnish times
  if (CV1varnish_type_id && (outsourcing_Priting === false && outsourcing_All === false && outsourcing_RawMaterial_and_Priting === false && outsourcing_All_but_RawMaterial === false )) { // if there's a varnish selected than it will have a value
    // use ITAark - so number of printing sheets to speed up calculation
    // use ITAspeed instead of CV1cost_varnish_speed, because varnish speed is set too high and varnish is printed same time as ink so ITASpeed applies
    RunTime_VarnishOffset = parseFloat(ITAark / ITAspeed);
  } else {
    RunTime_VarnishOffset =0;
  }

  // hot stamping time calculations
  if ((document.getElementById("gilding_box1").checked || document.getElementById("gilding_box2").checked || document.getElementById("gilding_box3").checked || document.getElementById("gilding_box4").checked) && outsourcing_All_but_RawMaterial === false && outsourcing_All === false) {

    SetupTime_HS = GCcost_setup / parseFloat(document.occ.gilding_cost_pln_hN.value);
    RunTime_HS = GCcost_prod / parseFloat(document.occ.gilding_cost_pln_h.value);
    IdleTime_HS = GCcost_i / parseFloat(document.occ.gilding_idle_cost.value);
    // print hours and minutes on screen
      document.getElementById("hotStampingSetupTime").value = hoursTohhmm(SetupTime_HS);
      document.getElementById("hotStampingRunTime").value = hoursTohhmm(RunTime_HS);
      document.getElementById("hotStampingIdleTime").value = hoursTohhmm(IdleTime_HS);
      document.getElementById("hotStampingTotalTime").value = hoursTohhmm(SetupTime_HS + RunTime_HS);// + IdleTime_HS);



  } else {
    SetupTime_HS = 0;
    RunTime_HS = 0;
    IdleTime_HS=0;

    if (outsourcing_All_but_RawMaterial || outsourcing_All) {
        // change only total times displayed to 0 to signal that outsourcing is in place
        document.getElementById("hotStampingTotalTime").value = hoursTohhmm(0);
    } else {
        // change all times to 0 if operation was not selected
        document.getElementById("hotStampingSetupTime").value = hoursTohhmm(0);
        document.getElementById("hotStampingRunTime").value = hoursTohhmm(0);
        document.getElementById("hotStampingIdleTime").value = hoursTohhmm(0);
        document.getElementById("hotStampingTotalTime").value = hoursTohhmm(0);
    }


  }
  // UV varnish time calculations
  if (VUV1varnish_type_id) {
    SetupTime_VarnishUV = varnishUVSetupTime;
    RunTime_VarnishUV = varnishUVRunTime;
    IdleTime_VarnishUV = varnishUVIdleTime;

    if (outsourcing_UV === false && outsourcing_All_but_RawMaterial === false && outsourcing_All === false){
      // print hours and minutes on screen
      document.getElementById("varnishUVSetupTime").value = hoursTohhmm(varnishUVSetupTime);
      document.getElementById("varnishUVRunTime").value = hoursTohhmm(varnishUVRunTime);
      document.getElementById("varnishUVIdleTime").value = hoursTohhmm(varnishUVIdleTime);
      document.getElementById("varnishUVTotalTime").value = hoursTohhmm(varnishUVSetupTime + varnishUVRunTime);// + varnishUVIdleTime);
    } else {
      // print only total hours and minutes on screen and nulify rest if outsourcing is selected
      document.getElementById("varnishUVSetupTime").value = hoursTohhmm(0);
      document.getElementById("varnishUVRunTime").value = hoursTohhmm(0);
      document.getElementById("varnishUVIdleTime").value = hoursTohhmm(0);
      document.getElementById("varnishUVTotalTime").value = hoursTohhmm(varnishUVSetupTime + varnishUVRunTime);// + varnishUVIdleTime);
    }

  } else {
    // nulify times if no UV varnish selected
      SetupTime_VarnishUV = 0;
      RunTime_VarnishUV = 0;
      IdleTime_VarnishUV = 0;
    // change all times to 0 if operation was not selected
      document.getElementById("varnishUVSetupTime").value = hoursTohhmm(0);
      document.getElementById("varnishUVRunTime").value = hoursTohhmm(0);
      document.getElementById("varnishUVIdleTime").value = hoursTohhmm(0);
      document.getElementById("varnishUVTotalTime").value = hoursTohhmm(0);
    }

  // Litho-lamination time calculations
  if (((LAM_sqm_id) && (LAM_type_id) && (LAM_paper_id) && (LAM_paper2_id)) && (outsourcing_All_but_RawMaterial === false && outsourcing_All === false)) { // Kaszerowanie
    SetupTime_LithoLamination = LAMnarzad;
    RunTime_LithoLamination = LAM_jazda_costT;
    IdleTime_LithoLamination = lithoLaminationIdleTime;
    // print hours and minutes on screen
    document.getElementById("lithoLaminationSetupTime").value = hoursTohhmm(lithoLaminationSetupTime);
    document.getElementById("lithoLaminationRunTime").value = hoursTohhmm(lithoLaminationRunTime);
    document.getElementById("lithoLaminationIdleTime").value = hoursTohhmm(lithoLaminationIdleTime);
    document.getElementById("lithoLaminationTotalTime").value = hoursTohhmm(lithoLaminationSetupTime + lithoLaminationRunTime);// + lithoLaminationIdleTime);
  } else {
    SetupTime_LithoLamination = 0;
    RunTime_LithoLamination = 0;
    IdleTime_LithoLamination = 0;
      if (outsourcing_All_but_RawMaterial || outsourcing_All) {
          // change only total times displayed to 0 to signal that outsourcing is in place
          document.getElementById("lithoLaminationTotalTime").value = hoursTohhmm(0);
      } else {
        // change all times to 0 if operation was not selected
        document.getElementById("lithoLaminationSetupTime").value = hoursTohhmm(0);
        document.getElementById("lithoLaminationRunTime").value = hoursTohhmm(0);
        document.getElementById("lithoLaminationIdleTime").value = hoursTohhmm(0);
        document.getElementById("lithoLaminationTotalTime").value = hoursTohhmm(0);
      }

  }
  // die cutting time calculations
  /*
  if (DCTtype_id) { // Wycinanie
    SetupTime_DieCutting = dieCuttingSetupTime;
    RunTime_DieCutting = dieCuttingRunTime;
    IdleTime_DieCutting = dieCuttingIdleTime;
    // print hours and minutes on screen
    document.getElementById("dieCuttingSetupTime").value = hoursTohhmm(dieCuttingSetupTime);
    document.getElementById("dieCuttingRunTime").value = hoursTohhmm(dieCuttingRunTime);
    document.getElementById("dieCuttingIdleTime").value = hoursTohhmm(dieCuttingIdleTime);
    document.getElementById("dieCuttingTotalTime").value = hoursTohhmm(dieCuttingSetupTime + dieCuttingRunTime + dieCuttingIdleTime);
  } else {
    SetupTime_DieCutting = 0;
    RunTime_DieCutting = 0;
    IdleTime_DieCutting = 0;
    // print hours and minutes on screen
    document.getElementById("dieCuttingSetupTime").value = hoursTohhmm(0);
    document.getElementById("dieCuttingRunTime").value = hoursTohhmm(0);
    document.getElementById("dieCuttingIdleTime").value = hoursTohhmm(0);
    document.getElementById("dieCuttingTotalTime").value = hoursTohhmm(0);
  }
  */

  // manual stripping time calculations
  /*
  if ((MWqty) && (MWot_id)) { // Wyrywanie
    SetupTime_Separation = separationSetupTime;
    RunTime_Separation = separationRunTime;
    IdleTime_Separation = separationIdleTime;
    // print hours and minutes on screen
    document.getElementById("separationSetupTime").value = hoursTohhmm(separationSetupTime);
    document.getElementById("separationRunTime").value = hoursTohhmm(separationRunTime);
    document.getElementById("separationIdleTime").value = hoursTohhmm(separationIdleTime);
    document.getElementById("separationTotalTime").value = hoursTohhmm(separationRunTime + separationIdleTime);
  } else {
    SetupTime_Separation =0;
    RunTime_Separation = 0;
    IdleTime_Separation = 0;
    // print hours and minutes on screen
    document.getElementById("separationSetupTime").value = hoursTohhmm(0);
    document.getElementById("separationRunTime").value = hoursTohhmm(0);
    document.getElementById("separationIdleTime").value = hoursTohhmm(0);
    document.getElementById("separationTotalTime").value = hoursTohhmm(0);
  }
*/
  //manual gluing time calculations disabled as we're not counting manual gluing time toward total time and thus not deducting it  from throughput pre hour
  // reenabled 2019-12-19
  if (document.getElementById("manualGluingTypeID").value) { // Klejenie reczne
    /*idleTime_ManualGluing = GTcost_time * (GT_idleP / 100);
    runTime_ManualGluing = GTcost_time;
    totalTime_ManualGluing = runTime_ManualGluing + idleTime_ManualGluing;
    */

    // print hours and minutes on screen
    /*document.getElementById("manualGluingRunTime").value = hoursTohhmm(runTime_ManualGluing);
    document.getElementById("manualGluingIdleTime").value = hoursTohhmm(idleTime_ManualGluing);
    document.getElementById("manualGluingTotalTime").value = hoursTohhmm(runTime_ManualGluing + idleTime_ManualGluing);
    */

      // check if manual gluing cost per unit or cost per gluin job are not filled then go get gluing times from field populated by manualGluing functions
      if (document.getElementById("manualGluingUnitCost").value == 0 && document.getElementById("manualGluingQuotedCost").value == 0) {
        manualGluingRunTime = hhmmToValue(document.getElementById("manualGluingRunTime").value);
        manualGluingIdleTime = hhmmToValue(document.getElementById("manualGluingIdleTime").value);
        manualGluingTotalTime = manualGluingRunTime;//+manualGluingIdleTime; // add up and print total time on screen in case outsourcing was toggled off again
      } else { // manual gluing times are calculated backwards from cost divided by cost per hour so go get manual gluing times from total times field
        manualGluingRunTime = hhmmToValue(document.getElementById("manualGluingRunTime").value);
        manualGluingTotalTime = hhmmToValue(document.getElementById("manualGluingTotalTime").value);
      }

  } else { // if there's no manual gluing selected zero out manual gluing times
    manualGluingRunTime = 0;
    manualGluingIdleTime = 0;
    manualGluingTotalTime = 0;
  }
  //automatic gluing time calculations

  // count window patching times
  if (windowPatchingType ==="internal" && (document.getElementById("window_glue_cost_box").value !=0  || document.getElementById("window_glue_timeS_box").value != 0)) { // if there's a varnish selected than it will have a value
    // use ITAark - so number of printing sheets to speed up calculation
    // use ITAspeed instead of CV1cost_varnish_speed, because varnish speed is set too high and varnish is printed same time as ink so ITASpeed applies
    windowPatchingRunTime = document.getElementById("cost_window_glue_prod_time").value;
    windowPatchingRunTime = parseFloat(windowPatchingRunTime);
  } else {
    windowPatchingRunTime = 0;
  }

  if (document.getElementById("automaticGluingTypeID").value && (outsourcing_All_but_RawMaterial === false && outsourcing_All === false)) { // Klejenie automatyczne
    // go get automatic gluing times from field populated by automaticGluing functions
      setupTime_AutomaticGluing = hhmmToValue(document.getElementById("automaticGluingSetupTime").value);
      runTime_AutomaticGluing = hhmmToValue(document.getElementById("automaticGluingRunTime").value);
      idleTime_AutomaticGluing = hhmmToValue(document.getElementById("automaticGluingIdleTime").value);
      automaticGluingTotalTime = setupTime_AutomaticGluing+runTime_AutomaticGluing;//+idleTime_AutomaticGluing; // add up and print total time on screen in case outsourcing was toggled off again
      document.getElementById("automaticGluingTotalTime").value = hoursTohhmm(automaticGluingTotalTime); // display total times again in the summary after outsourcing is toggled back

    // check if fields are empty (case when user has entered gluing costs manually)
     if ((setupTime_AutomaticGluing===0) && (runTime_AutomaticGluing===0)  && (idleTime_AutomaticGluing===0)) {
       runTime_AutomaticGluing = hhmmToValue(document.getElementById("automaticGluingTotalTime").value);
       totalAutomaticGluingCost = hhmmToValue(document.getElementById("automaticGluingTotalTime").value);
     } else {
       totalAutomaticGluingCost = 0; // zero out this variable in case setup, runtime and idletime are populated
     }
  } else {
    setupTime_AutomaticGluing = 0;
    runTime_AutomaticGluing = 0;
    idleTime_AutomaticGluing = 0;
    // change total times displayed to 0 to signal that outsourcing is in place
      document.getElementById("automaticGluingTotalTime").value = hoursTohhmm(0);
  }

  // up separation times
  if (document.getElementById("separationProcessType").value && (outsourcing_All_but_RawMaterial === false && outsourcing_All === false)) { // check if field has been checked and proceed to get times from html fields
    // go get time value from fields
    separationSetupTime = hhmmToValue(document.getElementById("separationSetupTime").value);
    separationRunTime = hhmmToValue(document.getElementById("separationRunTime").value);
    separationIdleTime = hhmmToValue(document.getElementById("separationIdleTime").value);
    separationTotalTime = separationSetupTime+separationRunTime;//+separationIdleTime; // add up and print total time on screen in case outsourcing was toggled off again
    document.getElementById("separationTotalTime").value = hoursTohhmm(separationTotalTime); // display total times again in the summary after outsourcing is toggled back
  } else { // else zero out times
    separationSetupTime = 0;
    separationRunTime = 0;
    separationIdleTime = 0;
    // change total times displayed to 0 to signal that outsourcing is in place
      document.getElementById("separationTotalTime").value = hoursTohhmm(0);
  }

  // die cutting and stripping times
    if (document.getElementById("dctool_type_id").value && (outsourcing_DieCutting === false && outsourcing_All_but_RawMaterial === false && outsourcing_All === false) ) { // check if field has been checked and proceed to get times from html fields
        // go get time value from fields
        var dieCuttingSetupTime = hhmmToValue(document.getElementById("dieCuttingSetupTime").value);
        var dieCuttingRunTime = hhmmToValue(document.getElementById("dieCuttingRunTime").value);
        var dieCuttingIdleTime = hhmmToValue(document.getElementById("dieCuttingIdleTime").value);
        var dieCuttingTotalTime = dieCuttingSetupTime+dieCuttingRunTime;//+dieCuttingIdleTime; // add up and print total time on screen in case outsourcing was toggled off again
        document.getElementById("dieCuttingTotalTime").value = hoursTohhmm(dieCuttingTotalTime); // display total times again in the summary after outsourcing is toggled back
    } else { // else zero out times
        dieCuttingSetupTime = 0;
        dieCuttingRunTime = 0;
        dieCuttingIdleTime = 0;
      // change total times displayed to 0 to signal that outsourcing is in place
        document.getElementById("dieCuttingTotalTime").value = hoursTohhmm(0);
    }

    // die cutting 2 times
      if (document.getElementById("dctool2_type_id").value && (outsourcing_DieCutting === false && outsourcing_All_but_RawMaterial === false && outsourcing_All === false) ) { // check if field has been checked and proceed to get times from html fields
          // go get time value from fields
          var dieCutting2SetupTime = hhmmToValue(document.getElementById("dieCutting2SetupTime").value);
          var dieCutting2RunTime = hhmmToValue(document.getElementById("dieCutting2RunTime").value);
          var dieCutting2IdleTime = hhmmToValue(document.getElementById("dieCutting2IdleTime").value);
          var dieCutting2TotalTime = dieCutting2SetupTime+dieCutting2RunTime;//+dieCutting2IdleTime; // add up and print total time on screen in case outsourcing was toggled off again
          document.getElementById("dieCutting2TotalTime").value = hoursTohhmm(dieCutting2TotalTime); // display total times again in the summary after outsourcing is toggled back
      } else { // else zero out times
          dieCutting2SetupTime = 0;
          dieCutting2RunTime = 0;
          dieCutting2IdleTime = 0;
        // change total times displayed to 0 to signal that outsourcing is in place
          document.getElementById("dieCutting2TotalTime").value = hoursTohhmm(0);
      }
  // get operationTimeCorrections from
    let operationTimeCorrection = hhmmToValue(document.getElementById("operationTimeCorrection").value);
  // add setup times
    var totalSetupTimes = SetupTime_PrintAwers + SetupTime_PrintRewers + SetupTime_HS + SetupTime_VarnishUV + SetupTime_LithoLamination + dieCuttingSetupTime + dieCutting2SetupTime + separationSetupTime + setupTime_AutomaticGluing;
  // add operation times
  //NOTE: manual gluing times are not couted towards total runt times
    var totalRunTimes = RunTime_Gilotyna + RunTime_Gilotyna2+ RunTime_PrintAwers + RunTime_PrintRewers + RunTime_VarnishOffset + RunTime_VarnishUV + RunTime_HS + RunTime_LithoLamination + windowPatchingRunTime + dieCuttingRunTime + dieCutting2RunTime + separationRunTime + runTime_AutomaticGluing + manualGluingRunTime;
  // add idle times
    var totaIdleTimes = IdleTime_Gilotyna + IdleTime_Gilotyna2 + IdleTime_PrintAwers + IdleTime_PrintRewers + IdleTime_PrintAwers2 + IdleTime_PrintRewers2 + IdleTime_VarnishUV + IdleTime_HS + IdleTime_LithoLamination + dieCuttingIdleTime + dieCutting2IdleTime + separationIdleTime + idleTime_AutomaticGluing + manualGluingIdleTime;

    let totalOperationTime = totalSetupTimes + totalRunTimes + operationTimeCorrection;;
    if (totalOperationTime < 0) {totalOperationTime = 0;} // check if run times after times corrections are negative if so replace by 0
  // print total hours and minutes on screen
    document.getElementById("totalSetupTime").value = hoursTohhmm(totalSetupTimes);
    document.getElementById("totalRunTime").value = hoursTohhmm(totalRunTimes);
    document.getElementById("totalIdleTime").value = hoursTohhmm(totaIdleTimes); // idle times are wastes that are already taken into account in the throughput per hour threshold
    document.getElementById("totalOperationTime").value = hoursTohhmm(totalOperationTime); // only sum run times and idle times as total operation times idle times are wastes we do not want our customer to bear
  // return data for use in other functions

    return totalOperationTime;

}

function calculateNumberUpsOnB1Sheet() {
  var numberOfUps = 0; // number of ups on sheet
  var timesPaperCut = 0; // times original paper sheet is cut to format for an orders
  var sheetX = 0;
  var sheetY = 0;
  var sqmUp = 0; // square meters of one up on sheet
  var sqmB1Sheet = 0; // square meter of B1 sheet
  var numberUpsOnB1Sheet = 0; // number of ups on b1 sheet

  numberOfUps = parseFloat(document.occ.product_paper_value1.value);
  timesPaperCut = parseFloat(document.occ.product_paper_cut1.value);

  sheetX = parseFloat(document.occ.sheetx1.value) / 1000;
  sheetY = parseFloat(document.occ.sheety1.value) / 1000;
  sqmB1Sheet = parseFloat(document.occ.glue_type_b1_sqm.value); // get B1 sheet sqm

  sqmUp = sheetX * sheetY / timesPaperCut / numberOfUps; // calculate sqm of 1 up on current sheet. multiply x and y dimensions divide by number of times the sheet is cut and number of ups on sheet
  numberUpsOnB1Sheet = parseFloat(sqmB1Sheet / sqmUp).toFixed(0); // calculate number of ups on B1 sheet

  return numberUpsOnB1Sheet;
}

function minTommss(minutes) {
  var sign = minutes < 0 ? "-" : "";
  var min = Math.floor(Math.abs(minutes));
  var sec = Math.floor((Math.abs(minutes) * 60) % 60);
  return sign + (min < 10 ? "0" : "") + min + ":" + (sec < 10 ? "0" : "") + sec;
}

function hoursTohhmm(hours) {
  var sign = hours < 0 ? "-" : "";
  var hh = Math.floor(Math.abs(hours));
  var min = Math.floor((Math.abs(hours) * 60) % 60);
  return sign + (hh < 10 ? "0" : "") + hh + ":" + (min < 10 ? "0" : "") + min;
}

function calculateRawMaterialOrderQty (orderQty,minimumQty, maximumQty) {
// Function used to calculate the netto qty required to be produced.
// it will always take the maximum qty as the basis for calculating qty since we want to produce more for the customer
  
let rawMaterialOrderQty = orderQty; // the qty to be produced and material ordered for. Defaults to orderQty in case of null tolerance

  if (orderQty > maximumQty) { // if we're over maximum qty then make them equal
    rawMaterialOrderQty = maximumQty;
  } else if (orderQty < minimumQty ) { // if the orderQty is lower than minimum qty
    rawMaterialOrderQty = minimumQty;
  }

  if (orderQty < maximumQty) {
    rawMaterialOrderQty = maximumQty;
  }

  // go and check once more if we haven't exceeded maximum quantity
  if (orderQty > maximumQty) {
    rawMaterialOrderQty = maximumQty;
  }
  return rawMaterialOrderQty;
}


function calculateManualGluingCosts_UserInput(manualGluingInputType, gluingQty) {
  // Begin evaluating cases when user changed manual gluing data (cost per unit, entered value of gluing, or deleted input) in text field
  var manualGluingCost = 0; // zero out cost of gluing
  var manualGluingCostPerBox = parseFloat(document.occ.cost_glue_box.value); // cost of gluing per box
  var manualGluingCostValue = parseFloat(document.occ.cost_glue_total.value); // total value of gluing entered by user insted of cost per box
  var manualGluingCostPerHour = parseFloat(document.occ.glue_type_cost_h.value); // cost of manual gluing per hour
  var manualGluingTime = 0; // zero out time of gluing

  switch (manualGluingInputType) {
    case 'cost_box': // user entered manual gluing cost per unit
      if (isNaN(manualGluingCostPerBox)) {manualGluingCostPerBox = 0;}
      manualGluingCost = manualGluingCostPerBox * gluingQty;
      document.occ.cost_glue_total.value = '';
      break;
    case 'cost': // user entered total manual gluing cost
      manualGluingCostValue = parseFloat(document.occ.cost_glue_total.value);
      if (isNaN(manualGluingCostValue)) {manualGluingCostValue = 0;}
      manualGluingCost = manualGluingCostValue;
      document.occ.cost_glue_box.value = '';
      break;
    default: // user deleted input - check and calculate values
        manualGluingCostPerBox = parseFloat(document.occ.cost_glue_box.value);
        if (isNaN(manualGluingCostPerBox)) {manualGluingCostPerBox = 0;}
        if (manualGluingCostPerBox > 0) { // if manual gluing per box cost is entered
          manualGluingCost = manualGluingCostPerBox * gluingQty;
          document.occ.cost_glue_total.value = '';
        } else { // if total manual gluing cost is entered
          manualGluingCostValue = parseFloat(document.occ.cost_glue_total.value);
          if (isNaN(manualGluingCostValue)) {manualGluingCostValue = 0;}
          else if (manualGluingCostValue > 0) {
            manualGluingCost = manualGluingCostValue;
            document.occ.cost_glue_box.value = '';
          }
        }
  }
  // reverse calculate time from total cost and cost per hour
  manualGluingTime = Math.round(manualGluingCost * 100.0 / manualGluingCostPerHour) / 100;
  // return calculated values as object
  return {
    gluingCost: manualGluingCost,
    gluingTime: manualGluingTime
  };

}

function showHideManualGluingFields (manualGluingSelected) {
"use strict"; // to enable sctrict mode in js
  if (manualGluingSelected) {
    document.getElementById("td_gr1").style.display = "";
    document.getElementById("tr_gr2").style.display = "";
    document.getElementById("td_gr3").rowSpan = 2;
  } else {
    document.getElementById("td_gr1").style.display = "none";
    document.getElementById("tr_gr2").style.display = "none";
    document.occ.glue_type_slim_check.checked = false;
    document.occ.glue_type_tape_check.checked = false;
    document.occ.glue_type_window_check.checke = false;
    document.occ.cost_glue_box.value = '';
    document.occ.cost_glue_total.value = '';
    document.getElementById("td_gr3").rowSpan = 1;
  }
}

function evaluateOutsourcingTypes () {
// BEGIN evaluating outsourcing types
  var outs_type = 0; ///document.occ.outsourcing_type_id.value;
  // we have 6 types of outsourcing defined and need to loop through all of them and then use switch statement to access each one and run certain actions
  // TODO: this looping through outsourcing types has to be changed to a while loop based on the items class
  // TODO: need to modify zeroOut calls to including zeroing out of times and infostring - best to use or merge with existing zeroOut functions from other modules
  var out_a = 0; // starting the loop with 0
  var out_b = 1;

  // zeroOut all outsourcing variables before running loops so that leftover values from previous calls are zeroed
    outsourcing_Priting = false; // printing outsourced
    outsourcing_All= false; // everything outsourced
    outsourcing_DieCutting= false; // diecutting outsourced
    outsourcing_RawMaterial_and_Priting= false; // raw material and printing outsourced
    outsourcing_All_but_RawMaterial= false; // everyting outsourced except raw material
    outsourcing_UV= false; // UV priting outsourced

  while (out_a < 5) { // looping through untill the 6th checkbox
    var input = 'outsorcing_type_' + out_b; // concatenate the item id
    if (document.getElementById(input)) {
      if (document.getElementById(input).checked) { // if a particular outsourcing type is checked run the switch statement
        switch (out_b) {
          case 1: // printing is outsourced
              outsourcing_Priting = true;
            // zero out cutter costs
              zeroOutCutterCosts ();
            // zero out cutter times
              zeroOutCutterTimes();
            // zero out priting costs
              zeroOutPritingCosts ();
            break;
          case 2: // everything is outsourced
              outsourcing_All = true;
            // zero out raw material costs
              zeroOutRawMaterialCosts();
            // zero out priting costs
              zeroOutPritingCosts ();
            // zeroOut UV material costs
              zeroOutUVVarnishCosts ();
            // zero out hot stamping costs
              zeroOutHotStampingCosts();
            // zero out cutter costs
              zeroOutCutterCosts ();
            // zero out diecutting costs
              zeroOutDieCuttingCosts();
            // zero out litholamination costs
              zeroOutLithoLaminationCosts();
            // zero out separation costs
              zeroOutSeparationCosts();
            // zero out manual gluing costs
              zeroOutManualGluingCosts();
            // zero out automatic gluing costs
              zeroOutAutomaticGluingCosts();
            break;
          case 3: // die cutting is outsourced
              outsourcing_DieCutting = true;
            // zero out diecutting costs
              zeroOutDieCuttingCosts();
            break;
          case 4: // raw material and printing is outsourced
              outsourcing_RawMaterial_and_Priting = true;
            // zero out raw material costs
              zeroOutRawMaterialCosts();
            // zero out priting costs
              zeroOutPritingCosts();
            break;
          case 5: //everything except raw material is outsourced
              outsourcing_All_but_RawMaterial = true;
            // zero out priting costs
              zeroOutPritingCosts();
            // zeroOut UV material costs
              zeroOutUVVarnishCosts ();
            // zero out hot stamping costs
              zeroOutHotStampingCosts();
            // zero out cutter costs
              zeroOutCutterCosts ();
            // zero out diecutting costs
              zeroOutDieCuttingCosts();
            // zero out litholamination costs
              zeroOutLithoLaminationCosts();
            // zero out separation costs
              zeroOutSeparationCosts();
            // zero out manual gluing costs
              zeroOutManualGluingCosts();
            // zero out automatic gluing costs
              zeroOutAutomaticGluingCosts();
            break;
          case 6: // UV or Blister varnish is outsourced
              outsourcing_UV = true;
            // zero out UV material costs and operation costs
              zeroOutUVVarnishCosts ();
            break;
        }
      }
    } else {
      out_a++;
    }
    out_b++;
  }
}

function zeroOutRawMaterialCosts (){
  document.getElementById("cost_paper1").value = parseFloat(0).toFixed(2);
  document.getElementById("cost_paper1_top").value = parseFloat(0).toFixed(2);
  document.getElementById("cost_paper2").value = parseFloat(0).toFixed(2);
  document.getElementById("cost_paper2_top").value = parseFloat(0).toFixed(2);
}

function zeroOutPritingCosts(){
  // zeroOut priting 1 material costs
    document.occ.cost_awers_material.value = parseFloat(0).toFixed(2);
    document.occ.cost_rewers_material.value = parseFloat(0).toFixed(2);
    document.occ.cost_awers_material_clicha.value = parseFloat(0).toFixed(2);   // zero out plates on awers
    document.occ.cost_rewers_material_clicha.value = parseFloat(0).toFixed(2);  // zero out plates on rewers
    document.occ.cost_extra_plate.value = parseFloat(0).toFixed(2);             // zero out extra plates
  // zeroOut total priting 2 material costs
    document.occ.cost_awers2_material.value = parseFloat(0).toFixed(2);
    document.occ.cost_rewers2_material.value = parseFloat(0).toFixed(2);
    document.occ.cost_awers2_material_clicha.value = parseFloat(0).toFixed(2);
    document.occ.cost_rewers2_material_clicha.value = parseFloat(0).toFixed(2);
    document.occ.cost_extra_plate2.value = parseFloat(0).toFixed(2);
  // zeorOut total priting 1 & 2 costs
    document.occ.cost_awers.value = parseFloat(0).toFixed(2);
    document.occ.cost_rewers.value = parseFloat(0).toFixed(2);
    document.occ.cost_awers2.value = parseFloat(0).toFixed(2);
    document.occ.cost_rewers2.value = parseFloat(0).toFixed(2);
  // zeroOut offset varnish costs
     zeroOutOffsetVarnishCosts();
}

function zeroOutCutterTimes (){
// zero out cutter 1 times
  document.getElementById("cutterRunTime").value = hoursTohhmm(0);
  document.getElementById("cutterIdleTime").value = hoursTohhmm(0);
  document.getElementById("cutterTotalTime").value = hoursTohhmm(0);
// zero out cutter 2 times
  document.getElementById("cutter2RunTime").value = hoursTohhmm(0);
  document.getElementById("cutter2IdleTime").value = hoursTohhmm(0);
  document.getElementById("cutter2TotalTime").value = hoursTohhmm(0);
  }

function zeroOutPritingTimesAwers(){
  // zero out priting times on awers
    document.getElementById("printingAwersSetupTime").value = hoursTohhmm(0);
    document.getElementById("printingAwersRunTime").value = hoursTohhmm(0);
    document.getElementById("printingAwersIdleTime").value = hoursTohhmm(0);
    document.getElementById("printingAwersTotalTime").value = hoursTohhmm(0);
}

function zeroOutPritingTimesRewers(){
  // zero out priting times on rewers
    document.getElementById("printingRewersSetupTime").value = hoursTohhmm(0);
    document.getElementById("printingRewersRunTime").value = hoursTohhmm(0);
    document.getElementById("printingRewersIdleTime").value = hoursTohhmm(0);
    document.getElementById("printingRewersTotalTime").value = hoursTohhmm(0);
}

function zeroOutOffsetVarnishCosts(){
  // zeroOut offset varnish operation costs
    document.occ.cost_varnish.value = parseFloat(0).toFixed(2);
    document.occ.cost_varnish2.value = parseFloat(0).toFixed(2);
  // zeroOut offset varnish material costs
    document.occ.cost_varnish_material.value = parseFloat(0).toFixed(2);        // zero out offset varnish costs
    document.occ.cost_varnish2_material.value = parseFloat(0).toFixed(2);
}
function zeroOutUVVarnishCosts(){
  document.occ.cost_varnish_uv.value = parseFloat(0).toFixed(2);
  document.occ.cost_varnish_uv_material.value = parseFloat(0).toFixed(2);
}

function zeroOutHotStampingCosts (){
  // zero out hot stamping costs
    document.occ.cost_gilding.value = parseFloat(0).toFixed(2);
    document.occ.cost_gilding_material.value = parseFloat(0).toFixed(2);
}

function zeroOutCutterCosts (){
  // zero out cutter costs
    document.occ.cost_cut.value = parseFloat(0).toFixed(2);
    document.occ.cost_cut2.value = parseFloat(0).toFixed(2);
}

function zeroOutDieCuttingCosts (){
  // zero out cutter costs
    document.occ.cost_dcting.value = parseFloat(0).toFixed(2);
    document.occ.cost_dcting2.value = parseFloat(0).toFixed(2);
}
function zeroOutLithoLaminationCosts (){
  // zero out litholamination costs
    document.occ.cost_laminating_material.value = parseFloat(0).toFixed(2);
    document.occ.cost_laminating.value = parseFloat(0).toFixed(2);
}

function zeroOutSeparationCosts (){
  // zero out separation costs
    document.occ.cost_manual_work.value = parseFloat(0).toFixed(2);
}

function zeroOutManualGluingCosts (){
  // zero out manual gluing costs
    document.occ.cost_glue.value = parseFloat(0).toFixed(2);
}
function zeroOutAutomaticGluingCosts (){
  // zero out automatic gluing costs
    document.occ.cost_glue_automat.value = parseFloat(0).toFixed(2);
    document.occ.cost_trans_glue_automat.value = parseFloat(0).toFixed(2);
}

function calculateAdder_v1 (KO, Kuz, KM, KD, KT, sheetQtyToProduce, adderSmallRuns, adderLargeRuns, adderRunThreshold, otherAdder){
// function used to calculate TAX or ADM adders depending on data input
  // define variables and populate them with values
    var adderValue = 0; // adder value
    var adderPercentage = 0; // adder percentage
    var adderInfoString; // adder info string

  // evaluate run to get proper administrative adder percentage
    if (sheetQtyToProduce >= adderRunThreshold) { // large run
      adderPercentage = adderLargeRuns;
    } else if (sheetQtyToProduce < adderRunThreshold) { // small run
      adderPercentage = adderSmallRuns;
    }
  // if otherAdder not passed then make it 0
      if (!otherAdder) {otherAdder = 0;}
  // calculate adder
    adderValue = parseFloat(precise_round((otherAdder + KO + Kuz + KM + KD + KT) * (adderPercentage / 100),2)); // convert to number(precise round to string(calculate adder))
    if (isNaN(adderValue)) {adderValue = 0;} // zero out variable if NaN
  // return results
    return {
      adderValue:adderValue,
      adderPercentage: adderPercentage
    }
}


function createAdmAdderInfoString_v1 (KO,KM,Kuz,KD,KT,admAdderPercentage){
  // define variables and populate them with values
    var admAdderInfoString =''; // display administrative adder calculation info
  // create info string
    admAdderInfoString = '(KO+KM+Kuz+KD+KT) * nAdm% = (' + parseFloat(KO).toFixed(2) + ' + ' + parseFloat(KM).toFixed(2) + ' + ' + parseFloat(Kuz).toFixed(2) + ' + ' + parseFloat(KD).toFixed(2) + ' + ' + parseFloat(KT).toFixed(2) + ') * ' + admAdderPercentage + '%';
  // return results
    return admAdderInfoString;
}


function createTaxAdderInfoString_v1 (admAdderValue,KO,KM,Kuz,KD,KT,taxAdderPercentage){
// define variables and populate them with values
  var taxAdderInfoString ='';
// create info string
  taxAdderInfoString = '(nAdm+KO+KM+Kuz+KD+KT) * nPod% = (' + parseFloat(admAdderValue).toFixed(2) + ' + ' + parseFloat(KO).toFixed(2) + ' + ' + parseFloat(KM).toFixed(2) + ' + ' + parseFloat(Kuz).toFixed(2) + ' + ' + parseFloat(KD).toFixed(2) + ' + ' + parseFloat(KT).toFixed(2) + ') * ' + taxAdderPercentage + '% ';
// return results
  return taxAdderInfoString;
}

function calculateAdder_v2 (KO, Kuz, KM, KD, KT, sheetQtyToProduce, adderSmallRuns, adderLargeRuns, adderRunThreshold, otherAdder){
// function used to calculate TAX or ADM adders depending on data input
  // define variables and populate them with values
    var adderValue = 0; // adder value
    var adderPercentage = 0; // adder percentage
    var adderInfoString; // adder info string
    var totalDirectCosts=0;

  // evaluate run to get proper administrative adder percentage
    if (sheetQtyToProduce >= adderRunThreshold) { // large run
      adderPercentage = adderLargeRuns;
    } else if (sheetQtyToProduce < adderRunThreshold) { // small run
      adderPercentage = adderSmallRuns;
    }
  // if otherAdder not passed then make it 0
      if (!otherAdder) {otherAdder = 0;}
  // calculate total direct costs to ease readability
    totalDirectCosts = otherAdder + KO + Kuz + KM + KD + KT;
  // calculate adder
    adderValue = parseFloat(precise_round(((totalDirectCosts/(100-adderPercentage)*100) - totalDirectCosts),2)) // convert to number(precise round to string(calculate adder))
    if (isNaN(adderValue)) {adderValue = 0;} // zero out variable if NaN
  // return results
    return {
      adderValue:adderValue,
      adderPercentage: adderPercentage
    }
}

function createAdmAdderInfoString_v2 (KO,KM,Kuz,KD,KT,admAdderPercentage){
  // define variables and populate them with values
    var admAdderInfoString =''; // display administrative adder calculation info
  // create info string
    admAdderInfoString = '((KO+KM+Kuz+KD+KT)/(100-nAdm%)*100) - (KO+KM+Kuz+KD+KT)= ((' +parseFloat(KO).toFixed(2)+ ' + ' +parseFloat(KM).toFixed(2)+ ' + '+parseFloat(Kuz).toFixed(2)+ ' + ' +parseFloat(KD).toFixed(2)+ ' + ' +parseFloat(KT).toFixed(2)+ ')/(100-' +admAdderPercentage +')*100) - ('+parseFloat(KO).toFixed(2)+ ' + ' +parseFloat(KM).toFixed(2)+ ' + '+parseFloat(Kuz).toFixed(2)+ ' + ' +parseFloat(KD).toFixed(2)+ ' + ' +parseFloat(KT).toFixed(2)+ ')';
  // return results
    return admAdderInfoString;
}


function createTaxAdderInfoString_v2 (admAdderValue,KO,KM,Kuz,KD,KT,taxAdderPercentage){
// define variables and populate them with values
  var taxAdderInfoString ='';
// create info string
  taxAdderInfoString = '((nAdm+KO+KM+Kuz+KD+KT)/(100-nPod%)*100) - (nAdm+KO+KM+Kuz+KD+KT)= ((' + parseFloat(admAdderValue).toFixed(2) + ' + ' +parseFloat(KO).toFixed(2)+ ' + ' +parseFloat(KM).toFixed(2)+ ' + '+parseFloat(Kuz).toFixed(2)+ ' + ' +parseFloat(KD).toFixed(2)+ ' + ' + parseFloat(KT).toFixed(2)+ ')/(100-' +taxAdderPercentage +')*100) - ('+ parseFloat(admAdderValue).toFixed(2)+ ' + '+parseFloat(KO).toFixed(2)+ ' + ' +parseFloat(KM).toFixed(2)+ ' + '+parseFloat(Kuz).toFixed(2)+ ' + ' +parseFloat(KD).toFixed(2)+ ' + '+ parseFloat(KT).toFixed(2) +')';
// return results
  return taxAdderInfoString;
}


/*
function evaluateManualGluingDifficulties() {
  //define variables
    var GT_b1_foil = 0; // foiled glue flap
    var GTfoil_type_id ='';
    var GTpaper_id2 = '';
    var GTpaper_gram_id2 ='';
    var GT_b1_sur2 = 0; // type of raw material
    var GTglue_type_tape_check = false;
    var GT_b1_tape = 0; // if ups are to be taped
    var GTglue_type_window_check = false;
    var GT_b1_window = 0; // if there's a window in the box
    var GTglue_type_slim_check = false;
    var GT_b1_slim = 0;

  // populate Variables
    GTfoil_type_id = document.occ.foil_type_id.value; // type of foil
    GTpaper_gram_id2 = document.occ.paper_gram_id2.value; // type of grammage id
    GTpaper_id2 = document.occ.paper_id2.value; // type of id
    GTglue_type_tape_check = document.occ.glue_type_tape_check.checked;
    GTglue_type_window_check = document.occ.glue_type_window_check.checked;
    GTglue_type_slim_check = document.occ.glue_type_slim_check.checked;// if the glue flap is slim

  // check & evaluate foil type complication
    if (GTfoil_type_id) {
      GT_b1_foil = parseFloat(document.occ.glue_type_foil.value); // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      GT_b1_foil = 1;
    }
  // check & evaluate paper type complication
    if ((GTpaper_id2) && (GTpaper_gram_id2)) {
      GT_b1_sur2 = parseFloat(document.occ.glue_type_sur2.value); // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      GT_b1_sur2 = 1;
    }
  // check & evaluate gluing tape complication
    if (GTglue_type_tape_check) {
      GT_b1_tape = parseFloat(document.occ.glue_type_tape.value); // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      GT_b1_tape =1;
    }
  // check & evaluate window type complication
    if (GTglue_type_window_check) { // if selected go fetch value form hidden field
      GT_b1_window = parseFloat(document.occ.glue_type_window.value);
    } else { // if not selected then no complication make value equal to 1
      GT_b1_window =1;
    }
  // check & evaluate slim glue flap complication
    if (GTglue_type_slim_check) {
      GT_b1_slim = parseFloat(document.occ.glue_type_slim.value); // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      GT_b1_slim = 1;
    }
  // return and object with results
  return {
    gluingDifficulty_SlimGlueFlap: GT_b1_slim,
    gluingDifficulty_RawMaterialB1:GT_b1_sur2,
    gluingDifficulty_FoiledFlap: GT_b1_foil,
    gluingDifficulty_GluingTape: GT_b1_tape,
    gluingDifficulty_LargeWindow: GT_b1_window
  };
}
*/
