// temporary constant holding key automatic gluing properties
var automaticGluing = Object.freeze({
  // notation before EMAC 6
  //https://stackoverflow.com/questions/130396/are-there-constants-in-javascript
  // TODO: move all parameters from automaticGluing object into db and create pages to update data in db
    IdleTime_Percentage: 15,
    SetupTime_CostPerHour: 87.3, // bo nie mozemy w tym czasie kleic nic innego
    RunTime_CostPerHour: 37.57, // bo 2 osoby w skladzie na sklejarce
    IdleTime_CostPerHour: 51.16, // koszt rooczogodziny IDLE
    WastePercentage: 3.5, // percent of boxes destroyed during automatic gluing
    numberOfOperators: 2, // standard number of operators neccessary to run a machine

    minCost_1pt: 250,     // minimum cost for 1pt automatic gluing
    minCost_2pt: 350,     // minimum cost for 2pt automatic gluing
    minCost_3pt: 350,     // minimum cost for 3pt automatic gluing
    minCost_4pt: 450,     // minimum cost for 4pt automatic gluing
    minCost_5pt: 450,     // minimum cost for 5pt automatic gluing
    minCost_6pt: 550,     // minimum cost for 6pt automatic gluing

    minRunTime_1pt: 1,    // minimum run time in case of 1pt automatic gluing
    minRunTime_2pt: 1.5,  // minimum run time in case of  automatic gluing
    minRunTime_3pt: 2,    // minimum run time in case of  automatic gluing
    minRunTime_4pt: 2.5,  // minimum run time in case of  automatic gluing
    minRunTime_5pt: 3,    // minimum run time in case of  automatic gluing
    minRunTime_6pt: 3.5,  // minimum run time in case of  automatic gluing

    speed_1pt: 8000,      // automatic gluing speed in case of 1pt gluing
    speed_2pt: 6000,      // automatic gluing speed in case of 2pt gluing
    speed_3pt: 4500,      // automatic gluing speed in case of 3pt gluing
    speed_4pt: 2500,      // automatic gluing speed in case of 4pt gluing
    speed_5pt: 2500,      // automatic gluing speed in case of 5pt gluing
    speed_6pt: 2000,      // automatic gluing speed in case of 6pt gluing

  // difficulty modifiers section
    modifierFoiledGlueFlap: 1.2,
    modifierLithoLaminated: 2.3,
    modifierGlueTape: 1.2,
    modifierWindow: 1.1,
    modifierHandle: 1.2,
    modifierShortBox: 1.2,
    modifierWideBox: 1.2,
    modifierLongBox: 1.2,
    modifierPrefolding1pt: 1.2,
    modifierPrefolding2pt: 1.4,
    modifierEURslot: 1.5,
    modifierMultiAssortment: 1 // there's no additional time for setup and run time is handled elsewhere
});

function calculateAutomaticGluing(){
  "use strict"; // to enable sctrict mode in js
  // define variables
    var automaticGluingSelected = false; // boolean showing if automatic gluing type is selected
    var onChangeFieldList = "";       // string holding fields to be watched for by the onchange method
    var automaticGluingSpeed;
    var automaticGluingSetupTime;

  // check if automatic gluing is selected. If not then hide all gluing fields
    if ($("#automaticGluingTypeID").val() === '') {
      automaticGluingSelected = false;
      zeroOutAutomaticGluingFields ('all'); // Zero out automatic gluing cost, times and info strings
      showHideAutomaticGluingFields (automaticGluingSelected); // run functions to show or hide automatic gluing fields
      count_cost_count_total(); // call function to recalculate total costs after automatic gluing costs have changed
    }  else { //  condition to calculate automatic gluing when opening a calculation for edditing with fields filled from MySQL
      automaticGluingSelected = true;
      showHideAutomaticGluingFields (automaticGluingSelected); // run functions to show or hide automatic gluing fields

      // check if manual user input fields have costs entered
        if (($("#automaticGluingUnitCost").val() === ''|| parseFloat($("#automaticGluingUnitCost").val()) === 0) && ($("#automaticGluingQuotedCost").val() === '' || parseFloat($("#automaticGluingQuotedCost").val()) === 0)) { // if not proceed to calculate automatic gluing speed based
          getAutomaticGluingSpeed();
          /* cancelled as setupTimes were multiplying
          // automatic gluing difficulties do not require running AJAX just recalculating difficulties and calling onsuccess function with already returned automatic speed parameter
          automaticGluingSpeed = $("#automaticGluingSpeedInfo").val();
          automaticGluingSetupTime = hhmmToValue($("#automaticGluingSetupTimeInfo").val());
          calculateAutomaticGluing_SpeedBased(automaticGluingSpeed,automaticGluingSetupTime);
          */
        } else if ($("#automaticGluingUnitCost").val() !== ''){ // if user entered unit cost
          $("#automaticGluingQuotedCost").val('');
          handleAutomaticGluingOnChangeEvent('unitCost'); // determine the source of user input name of box the user has entered data to
        } else if ($("#automaticGluingQuotedCost").val() !== ''){ // if user entered total costs
          $("#automaticGluingUnitCost").val('');
          handleAutomaticGluingOnChangeEvent('totalCost'); // determine the source of user input name of box the user has entered data to
        }

      count_cost_count_total(); // call function to recalculate total costs after automatic gluing costs have changed
    }

  // evaluate automatic input fields and zero out the oposite
    $("#automaticGluingUnitCost").change(function (){
      $("#automaticGluingQuotedCost").val('');
      handleAutomaticGluingOnChangeEvent('unitCost'); // determine the source of user input name of box the user has entered data to
    });
    $("#automaticGluingQuotedCost").change(function (){
      $("#automaticGluingUnitCost").val('');
      handleAutomaticGluingOnChangeEvent('totalCost'); // determine the source of user input name of box the user has entered data to
    });
  // recalculate automatic gluing costs and time if gluing difficulties change
    $("#automaticGluingDifficulties_multiAssortment, #automaticGluingDifficulties_multiAssortmentNumber, #automaticGluingDifficulties_eurSlot, #automaticGluingDifficulties_ShortBox, #automaticGluingDifficulties_WideBox, #automaticGluingDifficulties_LongBox, #automaticGluingDifficulties_GluingTape, #automaticGluingDifficulties_Window, #automaticGluingDifficulties_Handle, #automaticGluingDifficulties_FoiledFlap, #automaticGluingDifficulties_Prefolding1pt, #automaticGluingDifficulties_Prefolding2pt, #laminating_type_id, #laminating_sqm_id, #paper_id2, #tolerancePercentage, #minimumQty, #maximumQty" ).change(function (){
      // first check if gluing unit price or total gluing cost is entered by hand
      if (($("#automaticGluingUnitCost").val() === ''|| parseFloat($("#automaticGluingUnitCost").val()) === 0) && ($("#automaticGluingQuotedCost").val() === '' || parseFloat($("#automaticGluingQuotedCost").val()) === 0)) {
        getAutomaticGluingSpeed(); // if not get automatic gluing speeds considering difficulties
      } else {  // if so it means that users just want to enter a remark on gluing difficulties but have them already counted in the gluing price entered by hand
        // simply do nothing
      }

        if ($("#automaticGluingDifficulties_multiAssortment").prop('checked') === false ) {
          $("#automaticGluingDifficulties_multiAssortmentNumber").val(1);
          $("#automaticGluingDifficulties_multiAssortmentNumber").hide();
        } else {
          $("#automaticGluingDifficulties_multiAssortmentNumber").show();
        }
      /* cancelled as setupTimes were multiplying
      // automatic gluing difficulties do not require running AJAX just recalculating difficulties and calling onsuccess function with already returned automatic speed parameter
      automaticGluingSpeed = $("#automaticGluingSpeedInfo").val();
      automaticGluingSetupTime = hhmmToValue($("#automaticGluingSetupTimeInfo").val());
      calculateAutomaticGluing_SpeedBased(automaticGluingSpeed,automaticGluingSetupTime);
      */
    });

  // populate list of fields variable to trigger the on change method. NOTE 1: field id MUST be different than field name for the function to work
    $("#automaticGluingTypeID, #orderQtyInput").change(function(){   //$("#automaticGluingTypeID").on('change', function()){ } // alternative way of calling on change method
      handleAutomaticGluingOnChangeEvent(""); // call onchange method but leave parameter empty to be defined later on
    });


}

function handleAutomaticGluingOnChangeEvent(automaticGluingInputType){
  "use strict"; // to enable sctrict mode in js
    var automaticGluingSelected = false;
  // freeze calculation for the duration of running this function
    document.getElementById("div_calculate").style.display = "";
    document.getElementById("input_save_input").disabled = true;


  // first check if automatic gluing type has been selected
    if ($("#automaticGluingTypeID").val() !== '') { //if selected show additional input fields and proceed to calculate costs and time based either on automatic input or gluing speed
       automaticGluingSelected = true;
       showHideAutomaticGluingFields (automaticGluingSelected); // run functions to show or hide automatic gluing fields
       // second check if the user has input automatic gluing cost per unit or total automatic gluing cost
         if ($("#automaticGluingUnitCost").val() !== '' || $("#automaticGluingQuotedCost").val() !== '') {
          // if some fields are filled out but automaticGluingInputType is empty then determine what kind of input the user has made
            if (automaticGluingInputType === "") {
              if ($("#automaticGluingUnitCost").val() !== '') {automaticGluingInputType = 'unitCost';} // determine the source of user input name of box the user has entered data to
              else if ( $("#automaticGluingQuotedCost").val() !== '') {automaticGluingInputType ='totalCost';}
            }
            handleAutomaticGluing_ManualUserInput (automaticGluingInputType); // if so proceed with automatic calculations
         } else {  // if user has not entered automatic gluing total cost or cost per unit by hand proceed to calculations based on gluing speed
           getAutomaticGluingSpeed();
         }
    } else { //if automatic gluing type is not selected hide additional input fields, zeroout fields and recalculate
      automaticGluingSelected = false;
      showHideAutomaticGluingFields (automaticGluingSelected); // run functions to show or hide automatic gluing fields
      zeroOutAutomaticGluingFields ('all'); // Zero out automatic gluing cost, times and info strings
      count_cost_count_total();// call function to recalculate total costs after automatic gluing costs have changed
    }
      document.getElementById("div_calculate").style.display = "none";
      document.getElementById("input_save_input").disabled = false;
}

function handleAutomaticGluing_ManualUserInput (automaticGluingInputType){
/*
Function used to display values taken from calculateAutomaticGluing_UserInputBased and display them on screen in html fields
It gets called by onchange method if user changes fields automaticGluingUnitCost or automaticGluingTotalCosts
*/

"use strict"; // to enable sctrict mode in js
  // define variables
    var automaticGluingTotalTime = 0;
    var automaticGluingTotalCosts =0;
    var automaticGluingTotalRealCosts =0;
    var automaticGluingInfoString =0;
    var automaticGluingTypeID; // gluing type ID from #automaticGluingTypeID field
    // assign the object to which info and error messages will be attached to constant
      const automaticGluingSelect = document.querySelector('#automaticGluingTypeID');


    // get automatic gluing time and costs based on user input
      var resultsOf_calculateAutomaticGluing_UserInputBased = calculateAutomaticGluing_UserInputBased (automaticGluingInputType);
      // populate Variables
        automaticGluingTypeID = $("#automaticGluingTypeID").val();
      //populate variables with data returned as object from above function
        automaticGluingTotalTime = resultsOf_calculateAutomaticGluing_UserInputBased.gluingTime;
        automaticGluingTotalRealCosts = resultsOf_calculateAutomaticGluing_UserInputBased.gluingCost;
        automaticGluingInfoString = resultsOf_calculateAutomaticGluing_UserInputBased.gluingInfo;
      // since above calculations are not based on gluing speed zero out automatic gluing run time and idle time fields first
        $("#automaticGluingRunTime").val(hoursTohhmm(0));
        $("#automaticGluingIdleTime").val(hoursTohhmm(0));
      // populate fields with results
        // populate time fields
          $("#automaticGluingTotalTime").val(automaticGluingTotalTime);
        // populate cost fields
          $("#automaticGluingTotalRealCosts").val(automaticGluingTotalRealCosts);
          automaticGluingTotalCosts = verifyAutomaticGluingTotalCostToMin (automaticGluingTotalRealCosts, automaticGluingTypeID);
          $("#automaticGluingTotalCosts").val(precise_round(automaticGluingTotalCosts,2));
        // populate info fileds
          $("#automaticGluingTotalCostsInfo").val(automaticGluingInfoString);
        // save automatic gluing outsourcing indicators to field that will be later saved to db
          $("#automaticGluingOutsourcing").val('yes');
        // add info element if it doesn't exist
        if (!elementExistInDOM('automaticGluingOutsourcingInfo')) {
          var automaticGluingOutsourcingInfo = "Uwaga! Wprowadzono kwotę lub cenę za szt. Klejenie będzie traktowane jako zewnętrzne lub akordowe.<BR>Zmiejszy się przerób, ale czasy nie będą zaliczane do sumy czasów operacji.";
          addElementToDOM(automaticGluingSelect,automaticGluingOutsourcingInfo, "div", "automaticGluingOutsourcingInfo","error");
        }
      // call function to recalculate total costs after automatic gluing costs have changed
      count_cost_count_total();
}

function calculateAutomaticGluing_UserInputBased(automaticGluingInputType) {
/*
Function used to calculate automatic gluing costs and put information strings based strictly on what the user has input automatic into two onChangeFieldList
It gets called by handleAutomaticGluing_ManualUserInput
- cost_glue_box
- cost_glue_total
*/
  "use strict"; // to enable sctrict mode in js
  // Begin evaluating cases when user changed automatic gluing data (cost per unit, entered value of gluing, or deleted input) in text field
  var gluingQty = parseFloat(document.occ.order_qty1_less.value); // general qty to be produced
  var automaticGluingWastePercentage = automaticGluing.WastePercentage; // waste percentage on manual gluing
  var automaticGluingCostPerBox = $("#automaticGluingUnitCost").val(); // cost of gluing per box
  var automaticGluingQuotedCost =  $("#automaticGluingQuotedCost").val(); // total value of gluing entered by user insted of cost per box
  var automaticGluingRunTime_CostPerHour = automaticGluing.RunTime_CostPerHour; // cost of automatic gluing per hour
  var automaticGluingTime = 0; // zero out time of gluing
  var automaticGluingCost = 0; // zero out cost of gluing
  var automaticGluingInfoString = ''; // zero out info string

  // Zero out fields
    zeroOutAutomaticGluingFields ();
  // calculate gluing qty
  // TODO: check if this doesn't unnecessary increase the gluing quantity to be calculated over the quantity that is to be produced.
    gluingQty = gluingQty + gluingQty * (automaticGluingWastePercentage/ 100);

  // determine if automaticGluingInputType is empty if so user hasn't entered anything and costs are populated from db on page load
  if (automaticGluingInputType ==='') {
    // dive deeper and apply automaticGluingInputType based on data in fields
    if ((automaticGluingCostPerBox ==='') && (automaticGluingQuotedCost !=='')) {automaticGluingInputType = 'totalCost';}
    else if ((automaticGluingQuotedCost ==='') && (automaticGluingCostPerBox !=='')) {automaticGluingInputType = 'unitCost';}
  }

  // begin switch stmt evaluation and calculations
  switch (automaticGluingInputType) {
    case 'unitCost': // user entered automatic gluing cost per unit
      if (isNaN(automaticGluingCostPerBox)) {automaticGluingCostPerBox = 0;}
      automaticGluingCost = automaticGluingCostPerBox * gluingQty;
      // create an info string
      automaticGluingInfoString = 'koszt klejenia = koszt klejenia/ szt. ( ' + automaticGluingCostPerBox  + ' )' + ' * ilosc do sklejenia ( ' + gluingQty +' )' ;
      break;
    case 'totalCost': // user entered total automatic gluing cost
      if (isNaN(automaticGluingQuotedCost)) {automaticGluingQuotedCost = 0;}
      automaticGluingCost = automaticGluingQuotedCost;
      // create an info string
      automaticGluingInfoString = 'koszt klejenia calkowity  = ' + automaticGluingCost;
      break;
  }

  // reverse calculate time from total cost and cost per hour
    automaticGluingTime = automaticGluingCost/automaticGluingRunTime_CostPerHour;
  // round double values
    automaticGluingCost = precise_round(automaticGluingCost,2);
    automaticGluingTime = hoursTohhmm(automaticGluingTime);

  // return calculated values as object
  return {
    gluingCost: automaticGluingCost,
    gluingTime: automaticGluingTime,
    gluingInfo: automaticGluingInfoString
  };
}

function showHideAutomaticGluingFields (automaticGluingSelected) {
/*
Function used to hide or show automatic gluing fields based on the presence of data in
field automaticGluingTypeID
*/

"use strict"; // to enable sctrict mode in js
  if (automaticGluingSelected) {
    document.getElementById("glue_automatic_title").rowSpan = 2;
    document.getElementById("glue_automatic_row1").style.display = "";
    document.getElementById("glue_automatic_row2").style.display = "";
  } else {
    document.getElementById("glue_automatic_title").rowSpan = 1;
    document.getElementById("glue_automatic_row2").style.display = "none";
  }
}

function calculateAutomaticGluing_SpeedBased(automaticGluingSpeed, automaticGluingSetupTime, automaticGluingMinimumRunTime){
/*
Function used to calculate automatic gluing costs and time and display information strings based on automatic gluing speed passed as parameter "automaticGluingSpeed"
*/

  "use strict"; // to enable sctrict mode in js
  // define variables
    var automaticGluingRunTime =0;
    var automaticGluingIdleTime =0;

    var automaticGluingSetupTimeCost =0;
    var automaticGluingRunTimeCost =0;
    var automaticGluingIdleTimeCost = 0;
    var automaticGluingTotalCosts = 0;
    var automaticGluingTotalRealCosts = 0;

    var automaticGluingSetupTime_CostPerHour =0;
    var automaticGluingRunTime_CostPerHour =0;
    var automaticGluingIdleTime_CostPerHour =0;

    var automaticGluingIdleTime_Percentage =0;
    var automaticGluingTypeID =0;
    var orderQty = 0;

    var gluingQty = 0; // qty to be glued
    var automaticGluingWastePercentage = 0; // waste percentage on automatic gluing

    var gluingDifficulty_ShortBox;
    var gluingDifficulty_WideBox;
    var gluingDifficulty_LongBox;
    var gluingDifficulty_LithoLaminated;
    var gluingDifficulty_FoiledFlap;
    var gluingDifficulty_GluingTape;
    var gluingDifficulty_Window;
    var gluingDifficulty_Prefolding;
    var gluingDifficulty_Handle;
    var gluingDifficulty_EURslot;

    // variables holding info on calculations to display on scree
    var automaticGluingSetupTime_Info='';
    var automaticGluingRunTime_Info = '';
    var automaticGluingIdleTime_Info = '';
    var automaticGluingTotalTime_Info = '';

    var setupModifier; // a modifier by which to increase setup times in case of gluing difficulties selected

    if ((automaticGluingSpeed !=='') && (automaticGluingSetupTime !=='')) { // if returned glue speed and setuptime is greater than 0 then proceed to calculate times and costs.
    // populate variables
      //automaticGluingIdleTime_Percentage = parseFloat($("#glue_type_idleP").val(),2);
      automaticGluingIdleTime_Percentage = automaticGluing.IdleTime_Percentage;
      automaticGluingSetupTime_CostPerHour = automaticGluing.SetupTime_CostPerHour; // bo nie mozemy w tym czasie kleic nic innego
      automaticGluingRunTime_CostPerHour = automaticGluing.RunTime_CostPerHour; // bo 3 osoby w skladzie na sklejarce
      //automaticGluingIdleTime_CostPerHour = parseFloat($("#glue_type_idleP_cost").val(),2);
      automaticGluingIdleTime_CostPerHour = automaticGluing.IdleTime_CostPerHour;

      automaticGluingTypeID = $("#automaticGluingTypeID").val();             // gluing type ID from #automaticGluingTypeID field
      orderQty = parseFloat($("#order_qty1_less").val()); // general qty to be produced

      //automaticGluingWastePercentage = parseFloat($("#waste_proc1").val(),2); // waste percentage on automatic gluing

    // evaluate & get automatic gluing difficulties
      var agd = evaluateAutomaticGluingDifficulties ();
    //populate variables with data returned as object from above function
      gluingDifficulty_ShortBox = agd.gluingDifficulty_ShortBox;
      gluingDifficulty_WideBox = agd.gluingDifficulty_WideBox;
      gluingDifficulty_LongBox = agd.gluingDifficulty_LongBox;
      gluingDifficulty_LithoLaminated = agd.gluingDifficulty_LithoLaminated;
      gluingDifficulty_FoiledFlap = agd.gluingDifficulty_FoiledFlap;
      gluingDifficulty_GluingTape = agd.gluingDifficulty_GluingTape;
      gluingDifficulty_Window = agd.gluingDifficulty_Window;
      gluingDifficulty_Prefolding = agd.gluingDifficulty_Prefolding;
      gluingDifficulty_Handle = agd.gluingDifficulty_Handle;
      gluingDifficulty_EURslot = agd.gluingDifficulty_EURslot;
      // not using multi assortment multiplier since it is calculated staight in gluing speed
    // calculate setup modifier (only some difficulties affect setup times)
      setupModifier = agd.gluingDifficulty_ShortBox * agd.gluingDifficulty_WideBox * agd.gluingDifficulty_LongBox * agd.gluingDifficulty_LithoLaminated * agd.gluingDifficulty_FoiledFlap *  agd.gluingDifficulty_GluingTape * agd.gluingDifficulty_Window * agd.gluingDifficulty_Prefolding * agd.gluingDifficulty_Handle * agd.gluingDifficulty_EURslot;
    // recalculate setup time by multiplying per setupModifier
      automaticGluingSetupTime = automaticGluingSetupTime * setupModifier;
    // calculate gluing quantity accounting for waste
      gluingQty = orderQty + orderQty * (automaticGluingWastePercentage/ 100);
    // calcualte automatic gluing setup times and costs
      automaticGluingSetupTimeCost = automaticGluingSetupTime * automaticGluingSetupTime_CostPerHour;
    // adjust automatic gluing speed by gluing modifiers
      automaticGluingSpeed = automaticGluingSpeed/ setupModifier;
      automaticGluingRunTime = (gluingQty / automaticGluingSpeed); // calculate automatuc gluing run times of machine in hours
      automaticGluingRunTime = automaticGluing.numberOfOperators * automaticGluingRunTime; // multiple calculated machine run time by the number of operators
      if (automaticGluingRunTime < automaticGluingMinimumRunTime) { automaticGluingRunTime = automaticGluingMinimumRunTime;} // use minimum run time when appropriate
      automaticGluingRunTimeCost = automaticGluingRunTime * automaticGluingRunTime_CostPerHour;
    // calculate automatic gluing idle time costs
      automaticGluingIdleTime = (automaticGluingSetupTime + automaticGluingRunTime) * automaticGluingIdleTime_Percentage / 100;
      automaticGluingIdleTimeCost = automaticGluingIdleTime * automaticGluingIdleTime_CostPerHour;
    // calculate automatic gluing total costs
      automaticGluingTotalRealCosts = automaticGluingSetupTimeCost + automaticGluingRunTimeCost + automaticGluingIdleTimeCost;
    // determine if automatic gluing total costs are over minimum costs
      automaticGluingTotalCosts = verifyAutomaticGluingTotalCostToMin (automaticGluingTotalRealCosts, automaticGluingTypeID);

    // populate calculation fields

        // generate infoStrings
          automaticGluingSetupTime_Info = 'czas narządu * koszt roboczogodziny = ' + parseFloat(automaticGluingSetupTime).toFixed(2) + ' + ' + parseFloat(automaticGluingSetupTime_CostPerHour).toFixed(2);
          automaticGluingRunTime_Info = 'minimalny czas pracy + (ilość / wydajność na h/ (utrudnienia: niskie pudelko * szerokie pudelko * dlugie pudelko * kaszerowane * tasmowane * okienko * przeginanie * raczka * EUR dziurka)) * koszt roboczogodziny = ' + automaticGluingMinimumRunTime + ' + ( ' + gluingQty + ' / ' + automaticGluingSpeed + '/ ( ' + gluingDifficulty_ShortBox + ' * ' + gluingDifficulty_WideBox + ' * ' + gluingDifficulty_LongBox + ' * ' + gluingDifficulty_LithoLaminated + ' * ' + gluingDifficulty_GluingTape + ' * ' + gluingDifficulty_Window + ' * ' + gluingDifficulty_Prefolding + ' * ' + gluingDifficulty_Handle + ' * ' + gluingDifficulty_EURslot +' )) * ' + automaticGluingRunTime_CostPerHour + ' zl/h';
          automaticGluingTotalTime_Info = 'koszt narzadu + koszt jazdy + koszt IDLE = ' + parseFloat(automaticGluingSetupTimeCost).toFixed(2) + ' + ' + parseFloat(automaticGluingRunTimeCost).toFixed(2) + ' + ' + parseFloat(automaticGluingIdleTimeCost).toFixed(2);
          automaticGluingIdleTime_Info = '(czas narzadu + czas jazdy)* %IDLE * koszt IDLE = ( ' + parseFloat(automaticGluingSetupTime).toFixed(2) + ' + ' + parseFloat(automaticGluingRunTime).toFixed(2) + ' ) * ' + automaticGluingIdleTime_Percentage + '% * ' + automaticGluingIdleTime_CostPerHour;

        // print info strings on screen
          $("#automaticGluingSetupCostsInfo").val(automaticGluingSetupTime_Info); // populate calculation fields
          $("#automaticGluingRunCostsInfo").val(automaticGluingRunTime_Info); // populate calculation fields
          $("#automaticGluingIdleCostsInfo").val(automaticGluingIdleTime_Info); // populate calculation fields
          $("#automaticGluingTotalCostsInfo").val(automaticGluingTotalTime_Info); // populate calculation fields

        // print costs on screen
          // setup costs
            $("#automaticGluingSetupCostsReal").val(precise_round(automaticGluingSetupTimeCost,2)); // populate calculation fields
            $("#automaticGluingSetupCosts").val(precise_round(automaticGluingSetupTimeCost,2)); // populate calculation fields
          // run costs
            $("#automaticGluingRunCostsReal").val(precise_round(automaticGluingRunTimeCost,2)); // populate calculation fields
            $("#automaticGluingRunCosts").val(precise_round(automaticGluingRunTimeCost,2)); // populate calculation fields
          // idle costs
            $("#automaticGluingIdleCostsReal").val(precise_round(automaticGluingIdleTimeCost,2)); // populate calculation fields
            $("#automaticGluingIdleCosts").val(precise_round(automaticGluingIdleTimeCost,2)); // populate calculation fields
          // total costs
            $("#automaticGluingTotalRealCosts").val(precise_round(automaticGluingTotalRealCosts,2)); // populate calculation fields
            $("#automaticGluingTotalCosts").val(precise_round(automaticGluingTotalCosts,2)); // populate calculation fields

        // print hours and minutes on screen
          $("#automaticGluingSetupTime").val(hoursTohhmm(automaticGluingSetupTime)); // populate gluing setuptime on screen
          $("#automaticGluingRunTime").val(hoursTohhmm(automaticGluingRunTime));
          $("#automaticGluingIdleTime").val(hoursTohhmm(automaticGluingIdleTime)) ;
          $("#automaticGluingTotalTime").val(hoursTohhmm(automaticGluingSetupTime + automaticGluingRunTime));// + automaticGluingIdleTime));

          $("#automaticGluingSpeedInfo").val(automaticGluingSpeed); // populate gluing speed info on screen
          $("#automaticGluingSetupTimeInfo").val(hoursTohhmm(automaticGluingSetupTime)); // populate gluing setuptime info

      console.log("returned gluing speed is: ", automaticGluingSpeed); // check if data gets returned from AJAS call
      console.log("returned gluing setupTime is: ", automaticGluingSetupTime); // check if data gets returned from AJAS call
      // save outsourcing indicators
        $("#automaticGluingOutsourcing").val('no');
      // remove the info element if it exists
        if (elementExistInDOM('automaticGluingOutsourcingInfo')) {removeElementFromDOM ('automaticGluingOutsourcingInfo');}
      // call function to recalculate total costs after gluing costs have changed
        count_cost_count_total();
    } else {
      alert ("Nie moge obliczyc kosztow i czasow klejenia automatycznego. Brakuje predkosci klejenia automatycznego"); // if gluingSpeed is not passed correctly
    }
}

function evaluateAutomaticGluingDifficulties() {
/*
Function used to evaluate gluing difficulties (multipliers) and store them in html hidden fields for later retrieval
It takes parameters from html checkboxes and is triggered by onchange method when user checks or unchecks them.
*/

  "use strict"; // to enable sctrict mode in js
  //define variables
    var modifierFoiledGlueFlap = 0; // foiled glue flap modifier
    var checkedFoiledGlueFlap = false;
    var foilTypeId =''; //  foiling type
    var paper2TypeId = ''; // second raw material Type ID
    var paper2GrammageId =''; // second raw material grammage ID
    var laminating_sqm_id =''; // litho-lamination sqm ID
    var laminating_type_id =''; // litho-lamination type ID
    var modifierLithoLaminated = 0; // type of raw material
    var checkedGlueTape = false;
    var modifierGlueTape = 0; // if ups are to be taped
    var checkedWindow = false;
    var modifierWindow = 0; // if there's a window in the box
    var checkedHandle = false;
    var modifierHandle = 0;
    var checkedShortBox = false;
    var modifierShortBox;
    var checkedWideBox = false;
    var modifierWideBox;
    var checkedLongBox = false;
    var modifierLongBox;
    var checkedPrefolding1pt = false;
    var checkedPrefolding2pt = false;
    var modifierPrefolding;
    var checkedEURslot = false;
    var modifierEURslot;
    var checkedMultiAssortment = false;
    var modifierMultiAssortment;

  // populate Variables
    foilTypeId = document.getElementById("foil_type_id").value; // type of foil
    checkedFoiledGlueFlap = document.getElementById("automaticGluingDifficulties_FoiledFlap").checked;
    // litho-lamination indicators
      paper2TypeId = document.getElementById("paper_id2").value; // Paper 2 type id
      paper2GrammageId = document.getElementById("paper_gram_id2").value; // Paper 2 grammage id
      laminating_sqm_id = document.getElementById("laminating_sqm_id").value; // litho-lamination sqm id
      laminating_type_id = document.getElementById("laminating_type_id").value; // litho-lamination type id
    // gluing type difficulties
    checkedGlueTape = document.getElementById("automaticGluingDifficulties_GluingTape").checked;
    checkedWindow = document.getElementById("automaticGluingDifficulties_Window").checked;
    checkedHandle = document.getElementById("automaticGluingDifficulties_Handle").checked;
    checkedShortBox = document.getElementById("automaticGluingDifficulties_ShortBox").checked;
    checkedWideBox = document.getElementById("automaticGluingDifficulties_WideBox").checked;
    checkedLongBox = document.getElementById("automaticGluingDifficulties_LongBox").checked;
    checkedPrefolding1pt = document.getElementById("automaticGluingDifficulties_Prefolding1pt").checked;
    checkedPrefolding2pt = document.getElementById("automaticGluingDifficulties_Prefolding2pt").checked;
    checkedEURslot = document.getElementById("automaticGluingDifficulties_eurSlot").checked;
    checkedMultiAssortment = document.getElementById("automaticGluingDifficulties_multiAssortment").checked;

  // check & evaluate foil type complication
    if (checkedFoiledGlueFlap && foilTypeId) {
      modifierFoiledGlueFlap = automaticGluing.modifierFoiledGlueFlap; // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      modifierFoiledGlueFlap = 1;
    }
  // check & evaluate paper type complication. If the box to be glued is litho laminated gluing is more difficult
    if (paper2TypeId && paper2GrammageId &&  laminating_sqm_id && laminating_type_id) {
      modifierLithoLaminated = automaticGluing.modifierLithoLaminated; // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      modifierLithoLaminated = 1;
    }
  // check & evaluate gluing tape complication
    if (checkedGlueTape) {
      modifierGlueTape = automaticGluing.modifierGlueTape; // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      modifierGlueTape =1;
    }
  // check & evaluate window type complication
    if (checkedWindow) { // if selected go fetch value form hidden field
      modifierWindow = automaticGluing.modifierWindow;
    } else { // if not selected then no complication make value equal to 1
      modifierWindow =1;
    }
  // check & evaluate slim glue flap complication
    if (checkedHandle) {
      modifierHandle = automaticGluing.modifierHandle; // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      modifierHandle = 1;
    }
  // check & evaluate narrow box complication
    if (checkedShortBox) {
      modifierShortBox = automaticGluing.modifierShortBox; // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      modifierShortBox = 1;
    }
  // check & evaluate wide box complication
    if (checkedWideBox) {
      modifierWideBox = automaticGluing.modifierWideBox; // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      modifierWideBox = 1;
    }
  // check & evaluate long box complication
    if (checkedLongBox) {
      modifierLongBox = automaticGluing.modifierLongBox; // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      modifierLongBox = 1;
    }
  // check & evaluate prefolding complication
    if (checkedPrefolding1pt || checkedPrefolding2pt) {
      if (checkedPrefolding1pt) {modifierPrefolding = automaticGluing.modifierPrefolding1pt;} // if selected go fetch value form hidden field
      if (checkedPrefolding2pt) {modifierPrefolding = automaticGluing.modifierPrefolding2pt;} // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      modifierPrefolding = 1;
    }
    // check & evaluate EUR slot complication
    if (checkedEURslot) {
      modifierEURslot = automaticGluing.modifierEURslot; // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      modifierEURslot = 1;
    }

    // check & evaluate multi assortment complication
    if (checkedMultiAssortment) {
      modifierMultiAssortment = automaticGluing.modifierMultiAssortment; // if selected go fetch value form hidden field
    } else { // if not selected then no complication make value equal to 1
      modifierMultiAssortment = 1;
    }

  // return and object with results
  return {
    gluingDifficulty_ShortBox: modifierShortBox,
    gluingDifficulty_WideBox: modifierWideBox,
    gluingDifficulty_LongBox: modifierLongBox,
    gluingDifficulty_LithoLaminated:modifierLithoLaminated,
    gluingDifficulty_FoiledFlap: modifierFoiledGlueFlap,
    gluingDifficulty_GluingTape: modifierGlueTape,
    gluingDifficulty_Window: modifierWindow,
    gluingDifficulty_Prefolding: modifierPrefolding,
    gluingDifficulty_Handle: modifierHandle,
    gluingDifficulty_EURslot: modifierEURslot,
    gluingDifficulty_MultiAssortment: modifierMultiAssortment
  };
}

function zeroOutAutomaticGluingFields (scope) {
"use strict"; // to enable sctrict mode in js
  $("#automaticGluingSetupTime").val(hoursTohhmm(0));
  $("#automaticGluingRunTime").val(hoursTohhmm(0));
  $("#automaticGluingIdleTime").val(hoursTohhmm(0));
  $("#automaticGluingTotalTime").val(hoursTohhmm(0));

  $("#automaticGluingSetupCostsReal").val(precise_round(0,2));
  $("#automaticGluingSetupCosts").val(precise_round(0,2));
  $("#automaticGluingSetupCostsInfo").val('');

  $("#automaticGluingTotalCosts").val(precise_round(0,2));
  $("#automaticGluingTotalRealCosts").val(precise_round(0,2));
  $("#automaticGluingTotalCostsInfo").val('');

  $("#automaticGluingRunCostsReal").val(precise_round(0,2));
  $("#automaticGluingRunCosts").val(precise_round(0,2));
  $("#automaticGluingRunCostsInfo").val('');

  $("#automaticGluingIdleCostsReal").val(precise_round(0,2));
  $("#automaticGluingIdleCosts").val(precise_round(0,2));
  $("#automaticGluingIdleCostsInfo").val('');
  // zero out info on speed and setup time
  $("#automaticGluingSpeedInfo").val('');
  $("#automaticGluingSetupTimeInfo").val(hoursTohhmm(0));

  if (scope === 'all'){
    // zero out unit cost and total costs
      $("#automaticGluingUnitCost").val(''); // zero out automatic gluing unit cost entered manually
      $("#automaticGluingQuotedCost").val(''); // zero out total automatic gluing cost entered manually
    // zero out gluing difficulties
      $("#automaticGluingDifficulties_ShortBox").prop('checked', false);
      $("#automaticGluingDifficulties_WideBox").prop('checked', false);
      $("#automaticGluingDifficulties_LongBox").prop('checked', false);
      $("#automaticGluingDifficulties_Window").prop('checked', false);
      $("#automaticGluingDifficulties_Handle").prop('checked', false);
      $("#automaticGluingDifficulties_FoiledFlap").prop('checked', false);
      $("#automaticGluingDifficulties_Prefolding1pt").prop('checked', false);
      $("#automaticGluingDifficulties_Prefolding2pt").prop('checked', false);
      $("#automaticGluingDifficulties_GluingTape").prop('checked', false);
      $("#automaticGluingDifficulties_eurSlot").prop('checked', false);
      $("#automaticGluingDifficulties_multiAssortment").prop('checked', false);
      $("#automaticGluingDifficulties_multiAssortmentNumber").val(0);
  }
}

function getAutomaticGluingSpeed() {
"use strict"; // to enable sctrict mode in js
// define Variables
var automaticGluingSetupTime = 0; //hours
var automaticGluingMinimumRunTime = 0; // minimum time required to glue a given set of gluing points automatically
var automaticGluingSpeed=0;
var automaticGluingTypeID; // gluing type ID from #automaticGluingTypeID field
  var modifierMultiAssortment;
  var modifierMultiAssortmentNumber;
  var orderQty;
// populate Variables
  automaticGluingTypeID = $("#automaticGluingTypeID").val();
  modifierMultiAssortment = document.getElementById('automaticGluingDifficulties_multiAssortment').checked; // get checked or unchecked
  modifierMultiAssortmentNumber = $("#automaticGluingDifficulties_multiAssortmentNumber").val();// get value of multi assortments
  orderQty = $("#orderQtyInput").val(); // get order qty
// temporary calculation of automatic gluing setup costs and times based on entered values
  if ((automaticGluingTypeID) && automaticGluingTypeID >"0" ) { // check if automatic gluing has been passed to function
      // temporary calculation of automatic gluing setup costs and times
        switch (automaticGluingTypeID) { // begin evaluating warnign levels

          // TODO: change automatic and manual gluing type id in database from 6 to 1 for 1 pt automatic gluing
          // TODO: move automaticGluingSpeed variables from here into db and make pages to allow for changing variables by users
          case "6": // 1pt gluing // automatic gluing points are not corrected in db
            automaticGluingSetupTime = 1;
            automaticGluingSpeed = automaticGluing.speed_1pt;
            automaticGluingMinimumRunTime = automaticGluing.minRunTime_1pt;
            if (modifierMultiAssortment) {automaticGluingSpeed = calculateAutomaticGluingSpeedMultiAssortments(modifierMultiAssortmentNumber, orderQty, automaticGluingSpeed);}
            // calculate speed in case of multiple assortments
            break;
          case "2": // 2 pt gluing
            automaticGluingSetupTime = 2;
            automaticGluingSpeed = automaticGluing.speed_2pt;
            automaticGluingMinimumRunTime = automaticGluing.minRunTime_2pt;
            if (modifierMultiAssortment) {automaticGluingSpeed = calculateAutomaticGluingSpeedMultiAssortments(modifierMultiAssortmentNumber, orderQty, automaticGluingSpeed);}
            break;
          case "3": // 3 pt gluing
            automaticGluingSetupTime = 3;
            automaticGluingSpeed = automaticGluing.speed_3pt;
            automaticGluingMinimumRunTime = automaticGluing.minRunTime_3pt;
            if (modifierMultiAssortment) {automaticGluingSpeed = calculateAutomaticGluingSpeedMultiAssortments(modifierMultiAssortmentNumber, orderQty, automaticGluingSpeed);}
            break;
          case "4": // 4 pt gluing
            automaticGluingSetupTime = 4;
            automaticGluingSpeed = automaticGluing.speed_4pt;
            automaticGluingMinimumRunTime = automaticGluing.minRunTime_4pt;
            if (modifierMultiAssortment) {automaticGluingSpeed = calculateAutomaticGluingSpeedMultiAssortments(modifierMultiAssortmentNumber, orderQty, automaticGluingSpeed);}
            break;
          case "5": // 5pt gluing
            automaticGluingSetupTime = 5;
            automaticGluingSpeed = automaticGluing.speed_5pt;
            automaticGluingMinimumRunTime = automaticGluing.minRunTime_5pt;
            if (modifierMultiAssortment) {automaticGluingSpeed = calculateAutomaticGluingSpeedMultiAssortments(modifierMultiAssortmentNumber, orderQty, automaticGluingSpeed);}
            break;
          // TODO: change automatic and manual gluing type id in database from 7 to 6 for 6 pt automatic gluing
          case "7": // 6 pt gluing // automatic gluing points are not corrected in db
            automaticGluingSetupTime = 6;
            automaticGluingSpeed = automaticGluing.speed_6pt;
            automaticGluingMinimumRunTime = automaticGluing.minRunTime_6pt;
            if (modifierMultiAssortment) {automaticGluingSpeed = calculateAutomaticGluingSpeedMultiAssortments(modifierMultiAssortmentNumber, orderQty, automaticGluingSpeed);}
            break;
        }
        calculateAutomaticGluing_SpeedBased(automaticGluingSpeed, automaticGluingSetupTime, automaticGluingMinimumRunTime); // call function to calculate automatic gluing costs and times
  } else {
  alert ("Nie mogę obliczyc predkosci klejenia automatycznego. Nie okreslono rodzaju klejenia.");
  }
}

function verifyAutomaticGluingTotalCostToMin (automaticGluingTotalRealCosts, automaticGluingTypeID) {
  var automaticGluingMinCost = 0;
  var automaticGluingTotalCosts = 0;
  switch (automaticGluingTypeID){
    // TODO: change automatic and manual gluing type id in database from 6 to 1 for 1 pt automatic gluing
    case "6": // 1pt gluing // automatic gluing points are not corrected in db
      automaticGluingMinCost = automaticGluing.minCost_1pt; // minimum cost for 1pt automatic gluing
      break;
    case "2": // 2 pt gluing
      automaticGluingMinCost = automaticGluing.minCost_2pt; // minimum cost for 2pt automatic gluing
      break;
    case "3": // 3 pt gluing
      automaticGluingMinCost = automaticGluing.minCost_3pt; // minimum cost for 3pt automatic gluing
      break;
    case "4": // 4 pt gluing
      automaticGluingMinCost = automaticGluing.minCost_4pt; // minimum cost for 4pt automatic gluing
      break;
    case "5": // 5pt gluing
      automaticGluingMinCost = automaticGluing.minCost_5pt; // minimum cost for 5pt automatic gluing
      break;
    // TODO: change automatic and manual gluing type id in database from 7 to 6 for 6 pt automatic gluing
    case "7": // 6 pt gluing // automatic gluing points are not corrected in db
      automaticGluingMinCost = automaticGluing.minCost_6pt; // minimum cost for 6pt automatic gluing
      break;
  }

  automaticGluingTotalRealCosts = parseFloat(automaticGluingTotalRealCosts); // convert to number
  if (automaticGluingTotalRealCosts < automaticGluingMinCost) {
    automaticGluingTotalCosts = automaticGluingMinCost; // adjust total automatic gluing costs to minimum if not met
  } else {
    automaticGluingTotalCosts = automaticGluingTotalRealCosts;
  }

  return automaticGluingTotalCosts;
}

function calculateSingleAssortmentRunQty (multiAssortmentNumber, orderQty) {
// function takes in order qty and number of assortments and calculates average number of pcs per one assortment run
//define variables
  var singleAssortmentRunQty;
// calculate
  singleAssortmentRunQty = orderQty/ multiAssortmentNumber;
  singleAssortmentRunQty = Math.ceil(singleAssortmentRunQty); // calculate average and round up to nearest integer
// return value
  return singleAssortmentRunQty;
}

function calculateAutomaticGluingSpeedMultiAssortments (modifierMultiAssortmentNumber, orderQty, automaticGluingSpeed) {
// TODO: get all value of multiAssortment speeds and coresponding singleAssortmentRunQty from db through AJAX
  // define variables
    var singleAssortmentRunQty;
    var automaticGluingSpeedMultiAssortments;

    automaticGluingSpeedMultiAssortments = automaticGluingSpeed;
  // calculate
    singleAssortmentRunQty = calculateSingleAssortmentRunQty (modifierMultiAssortmentNumber, orderQty);
    if (singleAssortmentRunQty <=1000) {automaticGluingSpeedMultiAssortments = 4000;}// 4000 pcs per run hour = 2000 pcs per working hour}
    else if (singleAssortmentRunQty <=2500) {automaticGluingSpeedMultiAssortments = 5800;}// 5800 pcs per run hour = 2900 pcs per working hour}
    else if (singleAssortmentRunQty > 2500 && singleAssortmentRunQty <=5000) {automaticGluingSpeedMultiAssortments = 6500;}// 6500 pcs per run hour = 3250 pcs per working hour}
    // verification condition multi assortments speed cannot be higher than normal gluing speed
      if (automaticGluingSpeed < automaticGluingSpeedMultiAssortments) {automaticGluingSpeedMultiAssortments = automaticGluingSpeed;}
  // return results
    return automaticGluingSpeedMultiAssortments;
}
