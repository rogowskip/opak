function calculateDieCuttingStripping(){
  "use strict"; // to enable sctrict mode in js
  // define variables
    var dieCuttingID;     // ID of selecte die cutting type
    var dieCuttingStatusID;     // ID of selecte diecutting status ID
    var strippingID;     // ID of selecte stripping type
    var strippingStatusID;     // ID of selecte stripping status ID
    var productDimensionPresent; // object holding booleans of up and box dimensions presence check

    // var onChangeFieldList;  // string holding fields to be watched for by the onchange method
  // get separaionID value
    dieCuttingID = parseInt($("#dctool_type_id").val()); // get currently selected diecutting value as integer
    strippingID = parseInt($("#strippingToolingTypeDropdown").val()); // get currently selected stripping value as integer

    if (isNaN(dieCuttingID)){dieCuttingID=0;} // if NaN returned covert to separation ID to 0
    if (isNaN(strippingID)){strippingID=0;} // if NaN returned covert to separation ID to 0

    productDimensionPresent = productDimensionsPresent(); // evaluate if dimensions are present

    if (dieCuttingID && productDimensionPresent.boxDimsPresent) { //if selected and other than 0 show additional input fields and proceed to calculate costs and time
        showDieCuttingFields (true, dieCuttingID); // run functions to show or hide fields
    } else if (dieCuttingID && !productDimensionPresent.boxDimsPresent) {
      alert ('Nie okreslono wymiarow pudełka. Przyjmuje 0. \nCzasy i koszty wycinania zostana wyzerowane.');
      zeroOutDieCuttingFields (); // Zero out ups diecutting cost, times and info strings
      showDieCuttingFields (false, dieCuttingID); // run functions to show or hide fields
      //count_cost_count_total(); // call function to recalculate total costs
    } else {
      zeroOutDieCuttingFields (); // Zero out ups diecutting cost, times and info strings
      showDieCuttingFields (false, dieCuttingID); // run functions to show or hide fields
      //count_cost_count_total(); // call function to recalculate total costs
    }

/*
Call functions to recalculate die cutting and stripping costs on opening of or reloading of calculation so that after changes
 in cutting parameters calculation reflects those changes
*/
    handleDieCuttingOnChangeEvent(dieCuttingID); // call function to handle onchange event
    handleStrippingOnChangeEvent(strippingID); // call function to handle onchange event

//NOTE: on change event handling has to bt inside the main function that is called from order_calculation_create
// Handling of diecutting process type dropdown change events
    // evaluate chosen diecutting type
    $("#dctool_type_id, #upsOnSheetInput, #orderQtyInput, #upWindows, #orderTypeID, #boxWidth, #boxLenght, #boxDepth, #laminating_type_id, #paper1GrammageInput, #tolerancePercentage, #minimumQty, #maximumQty").change(function (){
      dieCuttingID = parseInt($("#dctool_type_id").val()); // get currently selected die cutting process value as integer
      handleDieCuttingOnChangeEvent(dieCuttingID); // call function to handle onchange event
    });
    // evaluate changed tooling cost
    $("#dieCuttingToolingCost, #strippingToolingCost, #separationToolingCost, #dieCuttingToolingInvoicingDropdown, #strippingToolingInvoicingDropdown, #separationToolingInvoicingDropdown").change(function (){
    //TODO: make three seprate on change event listeners for separation, diecutting, stripping sields and call the divided countToolingCosts function from each instead of calling one function to calculate all
      // define Variables
        var dieCuttingID;
        var strippingID;
        var separationToolingTypeID;
        var dieCuttingToolingStatusID;
        var strippingToolingStatusID;
        var separationToolingStatusID;
        var dieCuttigToolingCost;
        var strippingToolingCost;
        var separationToolingCost;
        var dieCuttingToolingInvoicingType;
        var strippingToolingInvoicingType;
        var separationToolingInvoicingType;
     // get current process types from fields
        dieCuttingID = parseInt($("#dctool_type_id").val());
        strippingID = parseInt($("#strippingToolingTypeDropdown").val());
        separationToolingTypeID = parseInt($("#separationToolingTypeDropdown").val());
     // get tooling statuses from dropdowns
        dieCuttingToolingStatusID = parseInt($("#dieCuttingToolingStatusDropdown").val());
        strippingToolingStatusID = parseInt($("#strippingToolingStatusDropdown").val());
        separationToolingStatusID = parseInt($("#separationToolingStatusDropdown").val());
      // check if the user has selected a process requirering toolings but hasn't selected a tooling type and alert
        if (dieCuttingID !== 0 && dieCuttingToolingStatusID === 0) {alert('Uwaga! Wybrany proces wycinania wymaga narzędzi.')}
        if (strippingID !== 0 && strippingToolingStatusID === 0) {alert('Uwaga! Wybrany proces wypychania wymaga narzędzi.')}
        if (separationToolingTypeID !== 0 && separationToolingTypeID >2 && separationToolingStatusID === 0) {alert('Uwaga! Wybrany proces separacji wymaga narzędzi.')} // separation tooling only required for separationToolingTypeID > 2
      // get current costs from fields
        dieCuttigToolingCost = parseFloat($("#dieCuttingToolingCost").val());
        strippingToolingCost = parseFloat($("#strippingToolingCost").val());
        separationToolingCost = parseFloat($("#separationToolingCost").val());
      // get current invoicing types from dropdowns
        dieCuttingToolingInvoicingType = parseInt($("#dieCuttingToolingInvoicingDropdown").val());
        if (isNaN(dieCuttingToolingInvoicingType)) {dieCuttingToolingInvoicingType=0;}
        strippingToolingInvoicingType = parseInt($("#strippingToolingInvoicingDropdown").val());
        if (isNaN(strippingToolingInvoicingType)) {strippingToolingInvoicingType=0;}
        separationToolingInvoicingType = parseInt($("#separationToolingInvoicingDropdown").val());
        if (isNaN(separationToolingInvoicingType)) {separationToolingInvoicingType=0;}
      // call to recalculate tooling costs
        countToolingCosts(dieCuttigToolingCost, strippingToolingCost, separationToolingCost, dieCuttingToolingInvoicingType, strippingToolingInvoicingType, separationToolingInvoicingType);
      // call to recalculate total costs
        count_cost_count_total();
    });

// Handling of diecutting tooling id dropdown events
    $("#dieCuttingToolingTypeDropdown").change(function (){
      "use strict"; // to enable sctrict mode in js
      // define variables
        var dieCuttingID;
        var dieCuttingToolingTypeID;
      // populate variables
        dieCuttingID = parseInt($("#dctool_type_id").val()); // get currently selected diecutting value as integer
        dieCuttingToolingTypeID = parseInt($("#dieCuttingToolingTypeDropdown").val()); // get currenlty selected tooling type ID as integer
      if (dieCuttingID >0 && dieCuttingToolingTypeID >0 ) { // check if diecutting type ID is selected
          $("#dieCuttingToolingStatus").show(); // show or hide td with all the fields
        } else {
          $("#dieCuttingToolingStatus").hide(); // show or hide td with all the fields
          $("#dieCuttingToolingCosts").hide();
          $("#dieCuttingToolingCost").hide();
          $("#dieCuttingToolingInvoicing").hide();
          $("#dieCuttingToolingStatusDropdown").val(0);
          $("#dieCuttingToolingInvoicingDropdown").val(0); // zero out invoicing type
          $("#dieCuttingToolingCost").val(0); // zero out tooling cost
          $("#dieCuttingToolingCost").trigger("change"); // fire change event to force recalculation
        }});

    // evaluate chosen die cutting type and tooling status and diplay or hide tooling cost and invoicing fields
    $("#dieCuttingToolingStatusDropdown").change(function (){
      "use strict"; // to enable sctrict mode in js
      // define variables
        var dieCuttingID;
        var dieCuttingStatusID;
      // populate variables
        dieCuttingID = parseInt($("#dctool_type_id").val()); // get currently selected diecutting value as integer
        dieCuttingStatusID = parseInt($("#dieCuttingToolingStatusDropdown").val()); // get currently selected diecutting tooling status value as integer
      if (dieCuttingID >0) { // check if diecutting type ID is selected
        if (dieCuttingStatusID >=2 ) {// if new tooling or tooling to be modified/ fixed display cost fields
          $("#dieCuttingToolingCosts").show();
          $("#dieCuttingToolingCost").show();
          $("#dieCuttingToolingInvoicing").show();
          $("#dieCuttingToolingCost").trigger("change"); // fire change event to force recalculation
        } else {
          $("#dieCuttingToolingCosts").hide();
          $("#dieCuttingToolingCost").hide();
          $("#dieCuttingToolingInvoicing").hide();
          $("#dieCuttingToolingInvoicingDropdown").val(0); // zero out invoicing type
          $("#dieCuttingToolingCost").val(0); // zero out tooling cost
          $("#dieCuttingToolingCost").trigger("change"); // fire change event to force recalculation
        }
      } else { // alert the user and exit
        alert ('Uwaga! Określ rodzaj wycinania');
        return;
      }});

// Handling of stripping tooling id dropdown events
    // evaluate chosen stripping type
    $("#strippingToolingTypeDropdown").change(function (){
      "use strict"; // to enable sctrict mode in js
      // define variables
        var strippingID;
      // populate variables
      strippingID = parseInt($("#strippingToolingTypeDropdown").val()); // get currently selected stripping tooling value as integer
      if (isNaN(strippingID)){strippingID=0;} // if NaN returned covert to separation ID to 0

      if (strippingID >0) { // check if stripping type ID is selected
          $("#strippingToolingStatus").show();
          handleStrippingOnChangeEvent(strippingID); // call function to handle onchange event
      } else {
        // alert user
        alert ('nie wybrano narzedzi wypychania, czyli wypychamy recznie');
          $("#strippingToolingStatus").hide();
          $("#strippingToolingCosts").hide(); // hide TD with tooling costs
          $("#strippingToolingCost").hide(); // hide field with tooling cost
          $("#strippingToolingInvoicing").hide();
          $("#strippingToolingStatusDropdown").val(0); // zero out tooling status
          $("#strippingToolingCost").val(0); // zero out tooling cost
          $("#strippingToolingInvoicingDropdown").val(0); // zero out invoicing type
          // if no separation tooling selected on pupouse then
            changeToDieCuttingWithoutStripping();

      }});

// Handling of stripping tooling status dropdown events
  // evaluate chosen stripping type and tooling status and siplay or hide tooling cost and invoicing fields
    $("#strippingToolingStatusDropdown").change(function (){
    "use strict"; // to enable sctrict mode in js
    // define variables
      var strippingID;
      var strippingStatusID;
    // populate variables
      strippingID = parseInt($("#strippingToolingTypeDropdown").val()); // get currently selected stripping tooling value as integer
      strippingStatusID = parseInt($("#strippingToolingStatusDropdown").val()); // get currently selected stripping tooling value as integer
      if (strippingID >0) { // check if stripping type ID is selected
        if (strippingStatusID >=2) {// if new tooling or tooling to be modified/ fixed display cost fields
          $("#strippingToolingCosts").show();
          $("#strippingToolingCost").show();
          $("#strippingToolingInvoicing").show();
          $("#strippingToolingCost").trigger("change"); // fire change event to force recalculation
        } else {
          $("#strippingToolingCosts").hide();
          $("#strippingToolingCost").hide();
          $("#strippingToolingInvoicing").hide();
          $("#strippingToolingInvoicingDropdown").val(0); // zero out invoicing type
          $("#strippingToolingCost").val(0); // zero out tooling cost
          $("#strippingToolingCost").trigger("change"); // fire change event to force recalculation
        }
      } else { // alert the user and exit
        alert ('określ rodzaj wypychania');
        return;
      }});

}

function handleStrippingOnChangeEvent(strippingID){
// function to handle stripping on change event actions
"use strict"; // to enable sctrict mode in js
freezeSaving (true); // freeze calculation for the duration of running this function
// call function if stripping is required
  determineStrippingTooling (strippingID);
freezeSaving (false); // freeze calculation for the duration of running this function
}

function determineStrippingTooling (strippingID){
/* function to determine what kind of stripping tooling is to be used prefferably based on
 sheet to cut, ups per sheet, windows per up
*/
"use strict"; // to enable sctrict mode in js
// define Variables
  var orderQty;
  var upsOnSheet;
  var upWindows;
  var sheetsToStrip;
  var orderTypeID;
  var dieCuttingID;
  var strippingDifficulty;
  var strippingDifficultyThreshold = 15;

  if(strippingID >0) { // if sripping is selected
    //gather data before proceeding to calculations
      orderQty = parseInt($("#order_qty1_less").val() ); // get number of qty to produce
      upsOnSheet = parseFloat($("#upsOnSheetInput").val()); // check number of ups on sheet
      upWindows = parseInt($("#upWindows").val() ); // get number of windows per sheet
      sheetsToStrip = orderQty/ upsOnSheet; // calculate number of sheets to cut and strip
      orderTypeID = parseInt($("#orderTypeID").val()); // get order type ID
      dieCuttingID = parseInt($("#dctool_type_id").val() ); // get diecuttingID

      strippingDifficulty = upsOnSheet*upWindows;

      if (strippingDifficulty >= strippingDifficultyThreshold) {
        // check fo number of sheets to strip and return possibilities
          if (sheetsToStrip < 250) {
            alert ('trzeba wypychac otwory recznie')
            changeToDieCuttingWithoutStripping ();
          } else if (sheetsToStrip >= 250 && sheetsToStrip <1000) {
            alert ('mozna zdecydowac pomiedzy recznym wypychaniem otworow, a deska spod + pinami')
            getDieCuttingParams(dieCuttingID,strippingID,orderQty,upsOnSheet,upWindows,orderTypeID);
          } else {
            alert ('mozna zdecydowac pomiedzy deska spod + pinami, albo kompletem wypychaczy')
            // change stripping type to stripping set
              //$("#strippingToolingTypeDropdown").val(2);
            // fire change event to force recalculation
            //  $('#strippingToolingTypeDropdown').trigger('change');
              getDieCuttingParams(dieCuttingID,strippingID,orderQty,upsOnSheet,upWindows,orderTypeID);
          }
      } else if (strippingDifficulty < strippingDifficultyThreshold) {
      // check fo number of sheets to strip and return possibilities
        if (sheetsToStrip < 500) {
          alert ('trzeba wypychac otwory recznie')
          changeToDieCuttingWithoutStripping ();
        } else if (sheetsToStrip >= 500 && sheetsToStrip <5000) {
          alert ('mozna zdecydowac pomiedzy recznym wypychaniem otworow, a deska spod + pinami')
          getDieCuttingParams(dieCuttingID,strippingID,orderQty,upsOnSheet,upWindows,orderTypeID);
        } else {
          alert ('mozna zdecydowac pomiedzy deska spod + pinami, albo kompletem wypychaczy')
          // change stripping tooling type to stripping set
            //$("#strippingToolingTypeDropdown").val(2);
          // fire change event to force recalculation
          //  $('#strippingToolingTypeDropdown').trigger('change');
          getDieCuttingParams(dieCuttingID,strippingID,orderQty,upsOnSheet,upWindows,orderTypeID);
        }
      }
  } else { // if no stripping selected
    zeroOutStrippingFields (); // zero out stripping fields
    showStrippingFields (false); // hide stripping fields
}


}

function changeToDieCuttingWithoutStripping () {
  // change stripping tooling type to none
    $("#strippingToolingTypeDropdown").val(0);
  // change diecuttin process type to die cutting without stripping
    $("#dctool_type_id").val(2);
  // fire change event to force recalculation
    $('#dctool_type_id').trigger('change');
    $('#separationProcessType').trigger('change');
}

function calculateStrippingSetupTime(dieCuttingID,strippingID,upsOnSheet,upWindows) {
"use strict"; // to enable sctrict mode in js
/* Input variables
  upsOnSheet - number of ups on sheet to separate - influences separation speed
  upWindows - number of windows on up - influences separation speed
*/
// define variables
  var strippingSetupTime;
  var strippingPinSetupTime = 5; //time in minutes to setup one pin that will strip windows
  var strippingChasisSetupTime = 30 // time in minutes to install stripping chasis into die cutter

// Begin calculating manual stripping setup time
  if (dieCuttingID === 6) { // if die cuting with stripping is selected
    // evaluate stripping toolling IDs
      if (strippingID === 1) { // if stripping tooling is pins + plank
      // calculate manual window stripping setup time
         strippingSetupTime = strippingChasisSetupTime + (upWindows * upsOnSheet * strippingPinSetupTime);
      } else if (strippingID === 2) { // if stripping tooling is a complete set
        strippingSetupTime = strippingChasisSetupTime;
      }
  } else { // if no automatic stripping on die cutter selected then
    strippingSetupTime=0;
  }

// return result in minutes
  return strippingSetupTime;
}

function handleDieCuttingOnChangeEvent(dieCuttingID){
"use strict"; // to enable sctrict mode in js
freezeSaving (true); // freeze calculation for the duration of running this function
    var productDimensionPresent; // object holding booleans of up and box dimensions presence check


    productDimensionPresent = productDimensionsPresent(); // evaluate if dimensions are present
    // first check if separation type has been selected
    if (dieCuttingID && productDimensionPresent.boxDimsPresent) { //if selected and other than 0 show additional input fields and proceed to calculate costs and time
      showDieCuttingFields (true, dieCuttingID); // run functions to show or hide fields
      var sheetsToCut;
      var upsOnSheet;
      var upWindows;
      var orderQty;
      var upIsLithoLaminated = false;
      var orderTypeID;
      var strippingID;

      strippingID = parseInt($("#strippingToolingTypeDropdown").val()); // get currently selected stripping value as integer

      if (isNaN(strippingID) && dieCuttingID === 6){ // if dieCuttingID ===6 (automatic cutting with stripping) go check if strippingToolingID returned NaN- no separation tooling chosen
        strippingID=0; // convert stripping ID to 0
        alert ('Wybierz narzedzia wypychania!'); // alert to choose stripping tooling otherwise calculations cannot proceed
        return; // exit the function
      }

      if ($("#paper_gram_id2").val() && $("#paper_id2").val()) {upIsLithoLaminated = true;} // check if boxes are litholaminated



      //gather data before proceeding to calculations
        orderQty = parseInt($("#order_qty1_less").val() ); // get number of qty to produce
        upsOnSheet = parseFloat($("#upsOnSheetInput").val()); // check number of ups on sheet
        upWindows = parseInt($("#upWindows").val() ); // get number of windows per sheet
        sheetsToCut = orderQty/ upsOnSheet; // calculate number of sheets to cut and strip
        orderTypeID = parseInt($("#orderTypeID").val()); // get order type ID


      switch(dieCuttingID){

         case 6: // automatic cutting with stripping
            showStrippingFields (true); // run functions to show or hide fields
            selectManualStripping (false); // manual stripping should be deselected
            getDieCuttingParams(dieCuttingID,strippingID,orderQty,upsOnSheet,upWindows,orderTypeID); // call function to calculate die cutting and stripping

          break;

          case 3: // automatic cutting with embossing
            showStrippingFields (false); // run functions to show or hide fields
            zeroOutStrippingFields();
            selectManualStripping (true); // manual stripping should be selected
            getDieCuttingParams(dieCuttingID,strippingID,orderQty,upsOnSheet,upWindows,orderTypeID); // call function to calculate die cutting and stripping
          break;

          case 2: // automatic cutting only
            showStrippingFields (false); // run functions to show or hide fields
            zeroOutStrippingFields();
            selectManualStripping (true); // manual stripping should be selected
            getDieCuttingParams(dieCuttingID,strippingID,orderQty,upsOnSheet,upWindows,orderTypeID); // call function to calculate die cutting and stripping
          break;

          case 5: // automatic embossing then cutting
            showStrippingFields (false); // run functions to show or hide fields
            zeroOutStrippingFields();
            selectManualStripping (true); // manual stripping should be selected
            getDieCuttingParams(dieCuttingID,strippingID,orderQty,upsOnSheet,upWindows,orderTypeID); // call function to calculate die cutting and stripping
          break;

          case 4: // semi-automatic cutting
            showStrippingFields (false); // run functions to show or hide fields
            zeroOutStrippingFields();
            selectManualStripping (true); // manual stripping should be selected
            getDieCuttingParams(dieCuttingID,strippingID,orderQty,upsOnSheet,upWindows,orderTypeID); // call function to calculate die cutting and stripping
          break;

          case 7: // semi-automatic cutting then embossing
            showStrippingFields (false); // run functions to show or hide fields
            zeroOutStrippingFields();
            selectManualStripping (true); // manual stripping should be selected
            getDieCuttingParams(dieCuttingID,strippingID,orderQty,upsOnSheet,upWindows,orderTypeID); // call function to calculate die cutting and stripping
          break;
       }
       freezeSaving (false); // unfreeze calculation

     } else if (dieCuttingID && !productDimensionPresent.boxDimsPresent) { // condition when separation ID is selected but up dimensions are not filled out by user
       alert ('Nie okreslono wymiarow pudelka. Czasy i koszty wycinania zostana wyzerowane.');
       $('#dctool_type_id').val(0); // set the value of separation ID to zero
       zeroOutDieCuttingFields (); // Zero out ups diecutting cost, times and info strings
       showDieCuttingFields (false, dieCuttingID); // run functions to show or hide fields
       count_cost_count_total();// call function to recalculate total costs
       freezeSaving (false); // unfreeze calculation

    } else { //if diecutting type is not selected hide additional input fields, zeroout fields and recalculate
      showDieCuttingFields (false, dieCuttingID); // run functions to show or hide fields
      zeroOutDieCuttingFields (); // Zero out ups diecutting cost, times and info strings
      count_cost_count_total();// call function to recalculate total costs
      freezeSaving (false); // unfreeze calculation
    }

}


//////////////////////////////////////////////////////////////////// HELPER FUNCTIONS ///////////////////////////////////////////////////////////////////////////////////

function selectManualStripping (selectManualStripping){
"use strict"; // to enable sctrict mode in js
  if (selectManualStripping) { // if manual stripping should be  selected
  // check if separationWindowsStripping is visible meaning if separation has already been chosen by the user
    if ($("#separationWindowsStripping").is(":visible")) {
      // select the appropriate radio button trigger the onchange event to recalculate
      $("#manualWindowStrippingYes").prop("checked", true).change();
    }
  } else { // if manual stripping should not be selected
    if ($("#separationWindowsStripping").is(":visible")) {
      //if so than select the radio button manualWindowStrippingNo and trigger the onchange event to recalculate
      $("#manualWindowStrippingNo").prop("checked", true).change();
    }
  }
}

function showStrippingFields (show) {
/* function to hide or show stripping fields based on the selected dropdown value
show - boolean
strippingID - id of selected stripping tooling
*/
"use strict"; // to enable sctrict mode in js
  if (show) {
    $("#strippingToolingTypeDropdown").show();
  } else {
    $("#strippingToolingTypeDropdown").hide();
    $("#strippingToolingStatus").hide();
    $("#strippingToolingCosts").hide();
    $("#strippingToolingInvoicing").hide();
    $("#strippingProcessRow").hide();
  }
}

function showDieCuttingFields (show, dieCuttingID) {
/* function to hide or show die cutting and stripping fields based on the selected dropdown value
show - boolean
dieCuttingID - id of selected die cutting type
*/
"use strict"; // to enable sctrict mode in js
  if (show) {
    $("#dieCuttingToolingTypeDropdown").show();

    if (dieCuttingID === 6 ){ // only for automatic die cutting and stripping show stripping row
      $("#strippingProcessRow").show();
      $("#dieCuttingProcessRowLabel").prop('rowspan',3);
      $("#strippingToolingTypeDropdown").show();
    } else {
      $("#strippingProcessRow").hide();
      $("#dieCuttingProcessRowLabel").prop('rowspan',2);
      $("#strippingToolingTypeDropdown").hide();
      $("#strippingToolingStatus").hide();
      $("#strippingToolingCosts").hide();
      $("#strippingToolingInvoicing").hide();
    }

  } else {
    // hide die cutting fields
      $("#dieCuttingToolingTypeDropdown").hide();
      $("#dieCuttingToolingStatus").hide();
      $("#dieCuttingToolingCosts").hide();
      $("#dieCuttingToolingInvoicing").hide();
    // also hide stripping fields
      showStrippingFields (false)
    // and hide striping row
      $("#strippingProcessRow").hide();
      $("#dieCuttingProcessRowLabel").prop('rowspan',2);
  }
}

function zeroOutStrippingFields () {
/* funtion to zero out fields, values and info strings if no diecutting is selected */
  "use strict"; // to enable sctrict mode in js
// zero out stripping process & tooling details
  $("#strippingToolingTypeDropdown").val(0);
  $("#strippingToolingStatusDropdown").val(0);
  $("#strippingToolingCost").val(0);
  $("#strippingToolingInvoicingDropdown").val(0);
}

function zeroOutDieCuttingFields () {
/* funtion to zero out fields, values and info strings if no diecutting is selected */
  "use strict"; // to enable sctrict mode in js

  // zero out diecutting setup times, costs and info strings
    $("#dieCuttingSetupTime").val(hoursTohhmm(0));
    $("#cost_dcting_narzad_real").val(precise_round(0,2));
    $("#cost_dcting_narzad_info").val('');
  // zero out diecutting times, costs and info strings
    $("#dieCuttingRunTime").val(hoursTohhmm(0));
    $("#cost_dcting_jazda_real").val(precise_round(0,2));
    $("#cost_dcting_jazda_info").val('');
  // zero out diecutting idle times, costs and info strings
    $("#dieCuttingIdleTime").val(hoursTohhmm(0));
    $("#cost_dcting_idle_real").val(precise_round(0,2));
    $("#cost_dcting_idle_info").val('');
  // zero out diecutting total times, costs and info strings
    $("#dieCuttingTotalTime").val(hoursTohhmm(0));
    $("#cost_dcting_real").val(precise_round(0,2));
    $("#cost_dcting").val(precise_round(0,2));
    $("#cost_dcting_info").val('');
  // zero out diecutting process & tooling details
    $("#dctool_type_id").val(0);
    zeroOutDieCuttingToolingFields();
  // zero out stripping process & tooling details
    zeroOutStrippingFields();
}

function zeroOutDieCuttingToolingFields (){
/* funtion to zero out tooling fields, values and info strings if diecutting tooling is not selected */
"use strict"; // to enable sctrict mode in js
// zero out diecutting process & tooling details
    $("#dieCuttingToolingStatusDropdown").val(0);
    $("#dieCuttingToolingTypeDropdown").val(0);
    $("#dieCuttingToolingCost").val(0);
    $("#dieCuttingToolingInvoicingDropdown").val(0);
}

function getDieCuttingParams(dieCuttingID,strippingID,orderQty,upsOnSheet,upWindows,orderTypeID){
  //jquery lib src="http://code.jquery.com/jquery-1.9.1.js" that the script is working with
  "use strict"; // to enable sctrict mode in js

  // define variables
    var rawMat1_sheetDimsX;
    var rawMat1_sheetDimsY;
    var rawMat1_grammage;
    var rawMat1_sqm2;
    var sheetsToCut;
    var a;
    var b;

  //populate variables
    rawMat1_sheetDimsX = parseInt($("#sheetx1").val())/1000; // convert from mm to m
    rawMat1_sheetDimsY = parseInt($("#sheety1").val())/1000; // convert from mm to m
    rawMat1_grammage = parseInt($("#gram1").val());          // get grammage of raw mat 1
    //NOTE: only rawMat1_grammage is used to get diecutting or stripping speed but both grammages should be added before calling speed from AJAX
    //TODO: add second grammage in case of litholaminated products and get diecutting speed based on it

  // make initial calculations
    rawMat1_sqm2 = rawMat1_sheetDimsX * rawMat1_sheetDimsY;   // calculate square meters of sheet
    sheetsToCut = orderQty/ upsOnSheet;                       // calculate number of sheets to cut and strip

    // this has to do with cutting on tygiel and is used later on in determining which machine to choose for cutting in order_calculation_create_cost_dcting
    if (rawMat1_sheetDimsX > rawMat1_sheetDimsY) {
      a = rawMat1_sheetDimsX;
      b = rawMat1_sheetDimsY;
    } else {
     a = rawMat1_sheetDimsY;
     b = rawMat1_sheetDimsX;
    }

  // check if all necessary variales are populated before running AJAX
  if ((dieCuttingID!=='') && (upsOnSheet!=='') && (orderTypeID!=='') && (orderQty!=='')) {
  //START AJAX

     $.ajax({
       // TODO: rewrite code to use .done and .fail instead of success and error
       type: "GET", // METHOD TO USE TO PASS THE DATA
       url: "GetData\\order_calculation_create_cost_dcting.php", // THE FILE WHERE WE WILL PASS THE DATA
       data: {var_id: dieCuttingID, nesting: upsOnSheet, gram1: rawMat1_grammage, order_ark: sheetsToCut, a: a , b: b }, //THE DATA WE WILL PASS TO GetData_xxx.php
       dataType: 'text', // DATA TYPE THAT WILL BE RETURNED FROM GetData_xxx.php
       // TODO: change dataType back to JSON after output type in #order_calculaion_create_cost_dcting is changed to JSON;
       success: function (result){ // Do this with the result (returned data)
         var dieCuttingParamsString = result; // populate variable value with parsed returned json object
         console.log(dieCuttingParamsString);
         var dc = calculateDieCuttingSpeed(dieCuttingID,strippingID, orderQty, upsOnSheet, upWindows, dieCuttingParamsString);//  get die cutting costs, time and infostrings
         console.log(dc);
         printDieCuttingResults(dc); // print results on screen
         count_cost_count_total();// call function to recalculate total costs

         freezeSaving (false); // unfreeze calculation
       }, // END of anonymous ajax succes function
       error: function(jqXHR, textStatus, errorThrown) {
        /* display error in custom DIV
        $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
        */
        // display error in console
          alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');
          console.log('jqXHR:',jqXHR);
          console.log('textStatus:', textStatus);
          console.log('errorThrown:', errorThrown);
        }// END of anonymous ajax error function
     }) // END OF AJAX call

  } else {
    var emptyVariable;
    // check which fields are not filled and alert
     if (dieCuttingID==='') {emptyVariable = 'manualGluingTypeID';}
     if (upsOnSheet==='') {emptyVariable = 'numberOfUps';}
     if (orderTypeID==='') {emptyVariable = 'paperGrammage';}
     if (orderQty==='') {emptyVariable = 'orderQty';}
    alert('Nie wypelniono pol: ' + emptyVariable);
  }// END of if stmt checking necessary variables
}

function calculateDieCuttingSpeed(dieCuttingID,strippingID, orderQty, upsOnSheet, upWindows, dieCuttingParamsString) {
  "use strict"; // to enable sctrict mode in js
// define Variables
  var sheetsToCut;

  var dieCuttingRunCost;
  var dieCuttingSetupCost;
  var dieCuttingIdleCost;
  var dieCuttingTotalCost;

  var dieCuttingRunTime;
  var dieCuttingSetupTime;
  var dieCuttingIdleTime;
  var dieCuttingTotalTime;

  var dieCuttingSpeed;
  var dieCuttingSetupCost1;
  var dieCuttingSetupCost2;

  var dieCuttingSetupCost_PerHour;
  var dieCuttingRunCost_PerHour;
  var dieCuttingIdleCost_PerHour;

  var dieCuttingSetupInfoString;
  var dieCuttingRunInfoString;
  var dieCuttingIdleInfoString;
  var dieCuttingTotalTimeInfoString;

  var dieCuttingIdlePercentage_Run;
  var dieCuttingIdlePercentage_Setup;

  var dieCuttingPreferredMachine;

  var strippingSetupTime; // time needed to setup stripping with the use of pins and plank

// initial calculations
  sheetsToCut = orderQty/ upsOnSheet;
// parse returned string into an array
  var dieCuttingParamsArray = dieCuttingParamsString.split('_');
// populate variables with parsed data
  dieCuttingSpeed = dieCuttingParamsArray[0] * 1; // get die cutting efficiency
  dieCuttingRunCost_PerHour = dieCuttingParamsArray[1] * 1; // get die cutting cost per hour
  dieCuttingSetupCost1 = dieCuttingParamsArray[2] * 1; // get die cutting 1 setup time
  dieCuttingSetupCost2 = dieCuttingParamsArray[3] * 1; // get die cutting setup multiplier (a checkbox in order_calculation_dctool_types), which multiplies setup times 2
  dieCuttingIdlePercentage_Setup = dieCuttingParamsArray[4] * 1; // get die cutting idle % for setup
  dieCuttingIdlePercentage_Run = dieCuttingParamsArray[5] * 1;  // get die cutting idle % for run
  dieCuttingIdleCost_PerHour = dieCuttingParamsArray[6] * 1; // get die cutting idle cost per hour
  dieCuttingSetupCost_PerHour = dieCuttingParamsArray[7] * 1; // get die cutting setup cost per hour
  dieCuttingPreferredMachine = dieCuttingParamsArray[8]; //maszynana jakiej wycinam 1.00000-Iberica 2.00000-tygiel mały 3.00000-tygiel duży

  strippingSetupTime = calculateStrippingSetupTime (dieCuttingID,strippingID,upsOnSheet,upWindows);

  $("#dieCuttingPreferredMachine").val(parseInt(dieCuttingPreferredMachine)); // save preferred machine type to hidden field
  // evaluate multiplication of setup type
  if ((dieCuttingSetupCost2) && (dieCuttingSetupCost2 > 1)) {
    dieCuttingSetupCost1 = dieCuttingSetupCost1 * dieCuttingSetupCost2; // if multiplication is checked do multiply
  } else {
    dieCuttingSetupCost2 = 1; // else take only defined setuptimes
  }

// calculate operation times
  if (dieCuttingSpeed > 0) {
    dieCuttingRunTime = (sheetsToCut / dieCuttingSpeed);
  } else {
    dieCuttingRunTime = 0;
  }
  dieCuttingSetupTime = (strippingSetupTime + dieCuttingSetupCost1) / 60;
  dieCuttingIdleTime = dieCuttingSetupTime * dieCuttingIdlePercentage_Setup / 100 + dieCuttingRunTime* dieCuttingIdlePercentage_Run / 100; // calculate die cutting idle time
  dieCuttingTotalTime = dieCuttingSetupTime + dieCuttingRunTime;// + dieCuttingIdleTime;

// round calculated times
  dieCuttingRunTime = Math.round (dieCuttingRunTime*100)/100;
  dieCuttingSetupTime = Math.round (dieCuttingSetupTime*100)/100;
  dieCuttingIdleTime = Math.round (dieCuttingIdleTime*100)/100;
  dieCuttingTotalTime = Math.round (dieCuttingTotalTime*100)/100;

// calculate operation costs
  dieCuttingSetupCost = dieCuttingSetupTime * dieCuttingSetupCost_PerHour;
  dieCuttingRunCost = dieCuttingRunTime * dieCuttingRunCost_PerHour;
  dieCuttingIdleCost =  dieCuttingIdleTime * dieCuttingIdleCost_PerHour;
  dieCuttingTotalCost = dieCuttingRunCost + dieCuttingSetupCost + dieCuttingIdleCost;

// roundup convert separation costs
  dieCuttingSetupCost = precise_round(dieCuttingSetupCost,2);
  dieCuttingRunCost = precise_round(dieCuttingRunCost,2);
  dieCuttingIdleCost = precise_round(dieCuttingIdleCost,2);
  dieCuttingTotalCost = precise_round(dieCuttingTotalCost,2);

// generate info strings
  dieCuttingSetupInfoString = '(czas narządu * wydłużenie setup)/60 * cena pracy = (' + dieCuttingSetupTime + '/60) * ' + dieCuttingSetupCost_PerHour;
  dieCuttingRunInfoString = '[(nakład arkuszy) / wydajność] * cena pracy = [(' + orderQty + '/' + upsOnSheet + ')/' + dieCuttingSpeed + ']*' + dieCuttingRunCost_PerHour;
  dieCuttingIdleInfoString = '((czas narządu * %IDLE) + (czas jazdy * %IDLE)) * koszt IDLE/h = ((' + dieCuttingSetupTime + ' * ' + dieCuttingIdlePercentage_Setup + '/100) + (' + dieCuttingRunTime + ' * ' + dieCuttingIdlePercentage_Run + '/100)) * ' + dieCuttingIdleCost_PerHour;
  dieCuttingTotalTimeInfoString = '(koszt narzadu + koszt jazdy + koszt idle)  = ' + dieCuttingSetupCost + ' + ' + dieCuttingRunCost + ' + ' + dieCuttingIdleCost;

// calculate totalTime and convert data to hours : minutes
  dieCuttingSetupTime = hoursTohhmm(dieCuttingSetupTime);
  dieCuttingRunTime = hoursTohhmm(dieCuttingRunTime);
  dieCuttingIdleTime = hoursTohhmm(dieCuttingIdleTime);
  dieCuttingTotalTime = hoursTohhmm(dieCuttingTotalTime);
// return calculated values as object
  return {
    dcSetupTime: dieCuttingSetupTime,
    dcRunTime: dieCuttingRunTime,
    dcIdleTime: dieCuttingIdleTime,
    dcTotalTime: dieCuttingTotalTime,

    dcSetupCost: dieCuttingSetupCost,
    dcRunCost: dieCuttingRunCost,
    dcIdleCost: dieCuttingIdleCost,
    dcTotalCost: dieCuttingTotalCost,

    dcSetupInfo: dieCuttingSetupInfoString,
    dcRunInfo: dieCuttingRunInfoString,
    dcIdleInfo: dieCuttingIdleInfoString,
    dcTotalInfo: dieCuttingTotalTimeInfoString
  };

}

function printDieCuttingResults (object){
  "use strict"; // to enable sctrict mode in js
// print diecutting times to hidden fields
  $("#cost_dcting_setup_time").val(object.dcSetupTime);
  $("#cost_dcting_prod_time").val(object.dcRunTime);

// print diecutting times on screen
  $("#dieCuttingSetupTime").val(object.dcSetupTime);
  $("#dieCuttingRunTime").val(object.dcRunTime);
  $("#dieCuttingIdleTime").val(object.dcIdleTime);
  $("#dieCuttingTotalTime").val(object.dcTotalTime);

// print diecutting costs on screen
  $("#cost_dcting_narzad_real").val(object.dcSetupCost);
  $("#cost_dcting_jazda_real").val(object.dcRunCost);
  $("#cost_dcting_idle_real").val(object.dcIdleCost);
  $("#cost_dcting_real").val(object.dcTotalCost);
  $("#cost_dcting").val(object.dcTotalCost);

// print diecutting infoStrings on screen
  $("#cost_dcting_narzad_info").val(object.dcSetupInfo);
  $("#cost_dcting_jazda_info").val(object.dcRunInfo);
  $("#cost_dcting_idle_info").val(object.dcIdleInfo);
  $("#cost_dcting_info").val(object.dcTotalInfo);
}

function countToolingCosts(dieCuttigToolingCost, strippingToolingCost, separationToolingCost, dieCuttingToolingInvoicingType, strippingToolingInvoicingType, separationToolingInvoicingType) {
  "use strict"; // to enable sctrict mode in js
  freezeSaving (true); // freeze calculation
//TODO:divide countToolingCosts function up into three separate function one for dieCutting, one for stripping and one for separation to be called independantly by on change event of one field type

// define variable
  var invoicedToolingCosts=0;
  var hiddenToolingCosts=0;                       // total hidden tooling costs
  var hiddenToolingCosts_CoveredBySupplier = 0;   // hidden tooling costs covered by supplier
  var hiddenToolingCosts_InPrice = 0;             // hidden tooling costs in price
  var invoicedToolingCostsInfoString = "";
  var hiddenToolingCostsInfoString = "";

// check if values are provided
  if (isNaN(dieCuttigToolingCost)){dieCuttigToolingCost=0;} // if NaN returned covert to 0
  if (isNaN(strippingToolingCost)){strippingToolingCost=0;} // if NaN returned covert to 0
  if (isNaN(separationToolingCost)){separationToolingCost=0;} // if NaN returned covert to 0

// if fields are populated then add them up and display in summary section
  if (dieCuttigToolingCost > 0 || strippingToolingCost > 0 || separationToolingCost > 0 ) {
    // create invoiced tooling info string
      invoicedToolingCostsInfoString = 'Koszty do wyfakturowania:';
    // create hidden tooling info string
      hiddenToolingCostsInfoString = 'Koszty w cenie: ';
    // check each tooling for invoicing type to see if tooling type costs should be invoiced or not
      switch (dieCuttingToolingInvoicingType) {
        case 0: // no tooling hence no invoicing type selected
          dieCuttigToolingCost = 0;
          invoicedToolingCosts +=dieCuttigToolingCost;
          hiddenToolingCosts += dieCuttigToolingCost;
          hiddenToolingCostsInfoString += ' wykrojnik= ' + dieCuttigToolingCost;
          invoicedToolingCostsInfoString += ' wykrojnik= ' + dieCuttigToolingCost;
        case 1: // die cutting tooling cost is to be invoiced
          invoicedToolingCostsInfoString += ' wykrojnik na klienta= ' + dieCuttigToolingCost;
          invoicedToolingCosts += dieCuttigToolingCost;
        break;
        case 2: // die cutting tooling cost is hidden in price
          hiddenToolingCosts += dieCuttigToolingCost; // add to total hidden costs
          hiddenToolingCosts_InPrice += dieCuttigToolingCost;
          hiddenToolingCostsInfoString += ' wykrojnik w cenie = ' + dieCuttigToolingCost;
        break;
        case 3: // die cutting tooling cost is paid by supplier
          hiddenToolingCosts += dieCuttigToolingCost; // add to total hidden costs
          hiddenToolingCosts_CoveredBySupplier += dieCuttigToolingCost;
          hiddenToolingCostsInfoString += ' wykrojnik na Opak = ' + dieCuttigToolingCost;
        break;
        default:
        alert ('Default die cutting tooling condition - inform the admin');
      }

      switch (strippingToolingInvoicingType) {
        case 0: // no tooling hence no invoicing type selected
          strippingToolingCost = 0;
          invoicedToolingCosts +=strippingToolingCost;
          hiddenToolingCosts += strippingToolingCost;
          hiddenToolingCostsInfoString += ' wypychacze= ' + strippingToolingCost;
          invoicedToolingCostsInfoString += ' wypychacze= ' + strippingToolingCost;
          break;
        case 1: // stripping tooling cost is to be invoiced
          invoicedToolingCostsInfoString += ' wypychacze na klienta = ' + strippingToolingCost;
          invoicedToolingCosts += strippingToolingCost;
        break;
        case 2: // stripping tooling cost is hidden in price
          hiddenToolingCosts += strippingToolingCost;
          hiddenToolingCosts_InPrice += strippingToolingCost;
          hiddenToolingCostsInfoString += ' wypychacze w cenie = ' + strippingToolingCost;
        break;
        case 3: // stripping tooling cost is paid by OPAK
          hiddenToolingCosts += strippingToolingCost;
          hiddenToolingCosts_CoveredBySupplier += strippingToolingCost;
          hiddenToolingCostsInfoString += ' wypychacze na Opak = ' + strippingToolingCost;
        break;
        default:
        alert ('Default stripping tooling condition - inform the admin');
      }

      switch (separationToolingInvoicingType) {
        case 0: // no tooling hence no invoicing type selected
          separationToolingCost = 0;
          invoicedToolingCosts +=separationToolingCost;
          hiddenToolingCosts += separationToolingCost;
          hiddenToolingCostsInfoString += ' separator= ' + separationToolingCost;
          invoicedToolingCostsInfoString += ' separator= ' + separationToolingCost;
        break;
        case 1: // separation tooling cost is to be invoiced
          invoicedToolingCostsInfoString += ' separator na klienta = ' + separationToolingCost;
          invoicedToolingCosts += separationToolingCost;
        break;
        case 2: // separation tooling cost is hidden in price
          hiddenToolingCosts += separationToolingCost;
          hiddenToolingCosts_InPrice += separationToolingCost;
          hiddenToolingCostsInfoString += ' separator w cenie = ' + separationToolingCost;
        break;
        case 3: // separation tooling cost is paid by OPAK
          hiddenToolingCosts += separationToolingCost;
          hiddenToolingCosts_CoveredBySupplier += separationToolingCost;
          hiddenToolingCostsInfoString += ' separator na Opak = ' + separationToolingCost;
        break;
        default:
        alert ('Default separation tooling condition - inform the admin');
      }
  }
// disply on screen
  // old data left for compliance purpouses with calculation version < v2
    $("#cost_dicut").val(precise_round(invoicedToolingCosts,2));
    $("#cost_dicut_info").val(invoicedToolingCostsInfoString);
  // new data printed to hidden fields starting from calculation version >= v2
    $("#invoicedToolingCosts").val(precise_round(invoicedToolingCosts,2));
    $("#invoicedToolingCostsInfoString").val(invoicedToolingCostsInfoString);
    $("#hiddenToolingCosts").val(precise_round(hiddenToolingCosts,2));
    $("#hiddenToolingCosts_InPrice").val(precise_round(hiddenToolingCosts_InPrice,2));
    $("#hiddenToolingCosts_CoveredBySupplier").val(precise_round(hiddenToolingCosts_CoveredBySupplier,2));
    $("#hiddenToolingCostInfo").val(hiddenToolingCostsInfoString);

  freezeSaving (false); // unfreeze calculation
}

function zeroOut(){
  dieCuttigToolingCost = 0;
  invoicedToolingCosts +=dieCuttigToolingCost;
  hiddenToolingCosts += dieCuttigToolingCost;
  hiddenToolingCostsInfoString += ' wykrojnik= ' + dieCuttigToolingCost;
  invoicedToolingCostsInfoString += ' wykrojnik= ' + dieCuttigToolingCost;
}
