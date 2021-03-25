// temporary constant holding key automatic separation properties
var automaticSeparation = Object.freeze({
  // notation before EMAC 6
  //https://stackoverflow.com/questions/130396/are-there-constants-in-javascript
  // define minumum and maximum up dimensions for automatic separation
    upMinimumWidth:30,   // minimum up width for automatic separation
    upMinimumLenght:30,  // minimum up lenght for automatic separation
    upMaximumWidth:350,   // maximum up width for automatic separation
    upMaximumLenght:350,  // maximum up lenght for automatic separation

    sheetsPerSeparation:100, // number of sheets that are put on the separator once at a time
    IdleTime_Percentage: 0.1,
    SetupTime_CostPerHour: 36.5, // one person doing the setup
    RunTime_CostPerHour: 36.5, // one person doing the work
    IdleTime_CostPerHour: 36.5, // koszt rooczogodziny IDLE
    //WastePercentage: 0.5, // percent of boxes damaged during automatic separation
  // difficulty modifiers section
});

// temporary constant holding key manual separation properties
var manualSeparation = Object.freeze({
  // notation before EMAC 6
  //https://stackoverflow.com/questions/130396/are-there-constants-in-javascript
    separationSetupTime: 0.33, //hours
    separationSpeed: 400, // sheets per hour
    IdleTime_Percentage: 0.2,
    SetupTime_CostPerHour: 36.5, // one person doing the setup
    RunTime_CostPerHour: 36.5, // two people doing the work
    IdleTime_CostPerHour: 36.5, // koszt rooczogodziny IDLE
    //WastePercentage: 0.5, // percent of boxes damaged during automatic separation
  // difficulty modifiers section
});

// temporary constant holding key manual separation properties
var pneumaticSeparation = Object.freeze({
  // notation before EMAC 6
  //https://stackoverflow.com/questions/130396/are-there-constants-in-javascript
    separationSetupTime: 0.33, //hours
    IdleTime_Percentage: 0.2,
    SetupTime_CostPerHour: 36.5, // one person doing the setup
    RunTime_CostPerHour: 36.5, // two people doing the work
    IdleTime_CostPerHour: 36.5, // koszt rooczogodziny IDLE
    //WastePercentage: 0.5, // percent of boxes damaged during automatic separation
  // difficulty modifiers section
});

// temporary constant holding key manual separation properties
var cutterSeparation = Object.freeze({
  // notation before EMAC 6
  //https://stackoverflow.com/questions/130396/are-there-constants-in-javascript
    separationSetupTime: 0.33, //hours
    separationSpeed: 800, // sheets per hour
    IdleTime_Percentage: 0.2,
    SetupTime_CostPerHour: 36.5, // one person doing the setup
    RunTime_CostPerHour: 36.5, // two people doing the work
    IdleTime_CostPerHour: 36.5, // koszt rooczogodziny IDLE
    //WastePercentage: 0.5, // percent of boxes damaged during automatic separation
  // difficulty modifiers section
});

function calculateUpSeparation(){
  "use strict"; // to enable sctrict mode in js
  // define variables
    var separationID;     // ID of selected separation type
    var productDimensionPresent; // object holding booleans of up and box dimensions presence check

    // var onChangeFieldList;  // string holding fields to be watched for by the onchange method
  // get separaionID value
    separationID = parseInt($("#separationProcessType").val()); // get currently selected separation value as integer
    if (isNaN(separationID)){separationID=0;} // if NaN returned covert to separation ID to 0

    productDimensionPresent = productDimensionsPresent(); // evaluate if dimensions are present

    if (separationID && productDimensionPresent.upDimsPresent) { //if selected and other than 0 show additional input fields and proceed to calculate costs and time
        showSeparationFields (true, separationID); // run functions to show or hide fields
    } else if (separationID && !productDimensionPresent.upDimsPresent) {
      alert ('Nie okreslono wymiarow uzytku. Przyjmuje 0.\nCzasy i koszty wyrywania zostana wyzerowane.');
      zeroOutSeparationFields (); // Zero out ups Separation cost, times and info strings
      showSeparationFields (false, separationID); // run functions to show or hide fields
      //  count_cost_count_total(); // call function to recalculate total costs
    } else {
      zeroOutSeparationFields (); // Zero out ups Separation cost, times and info strings
      showSeparationFields (false, separationID); // run functions to show or hide fields
    //  count_cost_count_total(); // call function to recalculate total costs
    }

//NOTE: on change event handling has to be inside the main function that is called from order_calculation_create
// evaluate chosen separation type, run the handleSeparationOnChangeEvent function each time one of the below fields changes
$("#separationProcessType, #manualWindowStrippingYes, #manualWindowStrippingNo, #upWidth, #upLenght, #upWindows, #orderQtyInput, #orderTypeID, #laminating_type_id, #laminating_sqm_id, #upsOnSheetInput, #tolerancePercentage, #maximumQty, minimumQty").change(function (){
  handleSeparationOnChangeEvent(); // call function to handle separation onchange event
});

// Handling of separation dropdown events
  // evaluate chosen separation process type and tooling status and diplay or hide tooling cost and invoicing fields
  $("#separationToolingTypeDropdown").on('change',function (){
  "use strict"; // to enable sctrict mode in js
  // define variables
    var separationID;
    var separationToolingTypeID;
  // populate variables
    separationID = parseInt($("#separationProcessType").val()); // get currently selected process ID as integer
    separationToolingTypeID = parseInt($("#separationToolingTypeDropdown").val()); // get currently selected process ID as integer
  // valiate input
    if (isNaN(separationID)){separationID=0;} // if NaN returned covert to 0
    if (isNaN(separationToolingTypeID)){separationToolingTypeID=0;} // if NaN returned covert to 0

    if (separationID >0 && separationToolingTypeID > 2)  { // check if separation type ID is selected and if tooling not in built
          if (toolingFieldsVisible()) { // run calculations only if tooling fields are already visible. If they're not than it means that the user has to fill out data first
          handleSeparationOnChangeEvent(); // call function to handle separation onchange event
        } else {
          $("#separationToolingStatus").show();
          alert ('Uwaga! Okresl status narzedzia, zeby obliczyc koszty.')
        }
    } else if (separationID >0 && separationToolingTypeID <3 && separationToolingTypeID >0){ // case when separation tooling is inbuilt
      //  no tooling status,cost and invoicing fields neccessary so zerout and hide them
      zeroOutSeprationToolings(false); // leave only tooling type dropdown
      showSeparationToolings (false);
      $("#separationToolingCost").trigger("change"); // fire change event to force recalculation
      handleSeparationOnChangeEvent(); // call function to handle separation onchange event
    } else {// alert the user and exit if no tooling selected
      zeroOutSeprationToolings(true); // zero out all
      showSeparationToolings (false);
      $("#separationToolingCost").trigger("change"); // fire change event to force recalculation
      alert ('Uwaga! Wybierz narzędzia separacji, aby obliczy koszty lub zmien rodzaj sepracji.')
      //handleSeparationOnChangeEvent(); // call function to handle separation onchange event
    }});

  // evaluate chosen separation process type and tooling status and diplay or hide tooling cost and invoicing fields
    $("#separationToolingStatusDropdown").change(function (){
    "use strict"; // to enable sctrict mode in js
    // define variables
      var separationID;
      var separationToolingTypeID;
      var separationToolingStatusID;
    // populate variables
      separationID = parseInt($("#separationProcessType").val()); // get currently selected process ID as integer
      separationToolingTypeID = parseInt($("#separationToolingTypeDropdown").val()); // get currently selected process ID as integer
      separationToolingStatusID = parseInt($("#separationToolingStatusDropdown").val()); // get currently selected process ID as integer
    // valiate input
      if (isNaN(separationID)){separationID=0;} // if NaN returned covert to 0
      if (isNaN(separationToolingTypeID)){separationToolingTypeID=0;} // if NaN returned covert to 0
      if (isNaN(separationToolingStatusID)){separationToolingStatusID=0;} // if NaN returned covert to 0

      if (separationID >0 && separationToolingTypeID>2 ) { // check if separation type ID is selected and not built in separation tooling chosen
        if (separationToolingStatusID >=2) {// if new tooling or tooling to be modified/ fixed display cost fields
          // TODO: change the below to showSeparationToolings function instead of explicit field show or hide
          $("#separationToolingCosts").show();
          $("#separationToolingCost").show();
          $("#separationToolingInvoicing").show();
          $("#separationToolingInvoicingDropdown").show();
          handleSeparationOnChangeEvent(); // call function to handle separation onchange event
          // the below should not be neccessary as if the user enters sth in cost box it will trigger a change automatically.
          //$("#separationToolingCost").trigger("change"); // fire change event to force recalculation
        } else {
          // TODO: change the below to showSeparationToolings function instead of explicit field show or hide
          $("#separationToolingCosts").hide();
          $("#separationToolingCost").hide();
          $("#separationToolingInvoicing").hide();
          $("#separationToolingCost").val(0); // zero out cost box
          $("#separationToolingInvoicingDropdown").val(0); // zero out combo box
          handleSeparationOnChangeEvent(); // call function to handle separation onchange event
          $("#separationToolingCost").trigger("change"); // fire change event to force recalculation
        }
      } else { // alert the user and exit
        alert ('Uwaga! Określ rodzaj separacji');
        return;
      }});

}



function handleSeparationOnChangeEvent(){
  "use strict"; // to enable sctrict mode in js
  var productDimensionPresent; // object holding booleans of up and box dimensions presence check
  var separationID;
  freezeSaving (true); // freeze calculation for the duration of running this function
  separationID = parseInt($("#separationProcessType").val()); // get currently selected separation value as integer
// validate input
  if (isNaN(separationID)){separationID=0;} // if NaN returned covert to 0
  productDimensionPresent = productDimensionsPresent(); // evaluate if dimensions are present
// first check if separation type has been selected
    if (separationID && productDimensionPresent.upDimsPresent) { //if selected and other than 0 show additional input fields and proceed to calculate costs and time
      showSeparationFields (true, separationID); // run functions to show or hide fields
      var pSep;                             // object holding pneumatic separation results
      var mSep;                             // object holding manual separation results
      var aSep;                             // object holding automatic separation results
      var cSep;                             // object holding cutter separation results
      var sheetsToSeparate;                 // number of sheet to separate accounting for typical scrap and tolerances
      var upsOnSheet;                       // number of ups on sheet
      var orderQty;                         // qty ordered increased by typical scrap and tolerances
      var upIsLithoLaminated = false;
      var laminationTypeID;                 // lamination type (2 layer / 3 layer / 5 layer flute)
      var orderTypeID;                      // type of order the calculation is made for
      var dieCuttingID;                     // type of die cutting selected
      var separationToolingTypeID;          
      var manualWindowStripping;            // boolean manual window stripping operation in case no automatic stripping was done
      var manualWindowStrippingRunTime;     // in case manual window stripping is to be done what's the run time

      var upWidth;                          // actual up width entered by user
      var upLenght;                         // actual up lenght entered by user
      var upWindows;                         // actual numbe rof windows to strip on up
      var checkUpFitsOnSeparator;           // object holding results of check if ups fit on separator
      var upFitsOnSeparator;                // true if ups fit on separator false if they don't
      var errMsgUpFitsOnSeparator;          // err message to user if ups don't fit on separator



      //gather data from form before proceeding to calculations
        upWidth = parseInt($("#upWidth").val());              // get up width
        upLenght = parseInt($("#upLenght").val());            // get up length
        upWindows = parseInt($("#upWindows").val());            // get up windows number
        orderQty = parseInt($("#order_qty1_less").val() );    // get number of qty to produce
        upsOnSheet = parseFloat($("#upsOnSheetInput").val());   // check number of ups on sheet
        laminationTypeID = parseFloat($("#laminating_type_id").val());   // get lamination type (2 layer / 3 layer / 5 layer flute)
        sheetsToSeparate = orderQty/ upsOnSheet;              // calculate number of sheets to separate
        orderTypeID = parseInt($("#orderTypeID").val());      // get order type ID
        separationToolingTypeID = parseInt($("#separationToolingTypeDropdown").val()); // get separation tooling ID
        dieCuttingID = parseInt($("#dctool_type_id").val());  // get currently selected die cutting type ID
      // valiate input
        if (isNaN(upWidth)){upWidth=0;} // if NaN returned covert to 0
        if (isNaN(upLenght)){upLenght=0;} // if NaN returned covert to 0
        if (isNaN(upWindows)){upWindows=0;} // if NaN returned covert to 0
        if (isNaN(orderQty)){orderQty=0;} // if NaN returned covert to 0
        if (isNaN(orderTypeID)){orderTypeID=0;} // if NaN returned covert to 0
        if (isNaN(separationToolingTypeID)){separationToolingTypeID=0;} // if NaN returned covert to 0
        if (isNaN(dieCuttingID)){dieCuttingID=0;} // if NaN returned covert to 0

      // run calculation on gathered data
        // check if ups fit on separator
        checkUpFitsOnSeparator = doUpsFitOnSeparator (automaticSeparation.upMinimumWidth, automaticSeparation.upMinimumLenght,automaticSeparation.upMaximumWidth,automaticSeparation.upMaximumLenght,upWidth,upLenght);
        // populate boolean
          upFitsOnSeparator = checkUpFitsOnSeparator.upFitsOnSeparator;
        // get error message if ups dont fit on separator
          errMsgUpFitsOnSeparator = checkUpFitsOnSeparator.errInfo;
        // check if manual window stripping is selected
          manualWindowStripping = $("#manualWindowStrippingYes").prop('checked');
        // check if

          if (manualWindowStripping && dieCuttingID !== 6) { // if manual stripping is selected but die cutting type selected is not die cutting with stripping
            // get manual windows stripping run time if selected
            manualWindowStrippingRunTime = calculateManualWindowStrippingRunTime (orderQty,upWindows);
          } else {
            manualWindowStrippingRunTime=0;
            $("#manualWindowStrippingNo").prop('checked', true);
          }
    // check for separation ID - if automatic proceed to check if tooling selected before proceeding to calculations
      if (separationID === 3 && separationToolingTypeID === 0) { // check if separation chosen is automatic on TM920 and if tooling is selected
          alert ('Uwaga! Wybierz narzędzia separacji, aby obliczy koszty lub zmien rodzaj sepracji.') // alert to choose separator tooling otherwise calculations cannot proceed
          $("#separationTooling").show(); // show separation tooling section for TM920
          freezeSaving(false); // unfreeze saving before exiting
          return; // exit the function
      }

      if ($("#paper_gram_id2").val() && $("#paper_id2").val()) {upIsLithoLaminated = true;} // check if ups are litholaminated


      /*
      //TODO: this section should be called each time one of the below fields changes
      $("#separationProcessType") ,
      $("#upsOnSheetInput") ,
      $("#orderQtyInput") ,
        ,
       $("#upWidth") ,
       $("#upLenght") ,
       $("#upWindows")
       $("#separationToolingTypeID")
       separationToolingTypeID
      */



      switch(separationID){

         case 1: // manual separation
         if (upFitsOnSeparator){ // if ups fit on separator

           if (upsOnSheet >=3 && sheetsToSeparate > 1000){
             alert ("rozwaz separację automatyczne");
             // calculate manual separation
               mSep = calculateManualSeparation (sheetsToSeparate, manualWindowStrippingRunTime);
             // print results on screen
               printSeparationResults(mSep);
           } else {
             alert ("mozesz separowac recznie");
             // calculate manual separation
               mSep = calculateManualSeparation (sheetsToSeparate, manualWindowStrippingRunTime);
             // print results on screen
               printSeparationResults(mSep);
           }

         } else if (!upFitsOnSeparator) {// if ups don't fit on separator

           if (upsOnSheet <= 4 && sheetsToSeparate > 1000) {
             alert ("rozwaz separację pneumatyczne");
             // calculate manual separation
               mSep = calculateManualSeparation (sheetsToSeparate, manualWindowStrippingRunTime);
             // print results on screen
               printSeparationResults(mSep);
           } else {
             alert ("mozesz separowac recznie");
             // calculate manual separation
               mSep = calculateManualSeparation (sheetsToSeparate, manualWindowStrippingRunTime);
             // print results on screen
               printSeparationResults(mSep);
           }

         }

          break;

          case 2: // pneumatic separation
            if (upFitsOnSeparator) { // solid board & ups fit on separator o
                if (upsOnSheet >= 3 && sheetsToSeparate > 1000){
                  alert ("rozwaz separację automatyczne");
                  // calculate pneumatic separation
                    pSep = calculatePneumaticSeparation (sheetsToSeparate, upsOnSheet, upIsLithoLaminated, laminationTypeID, manualWindowStrippingRunTime);
                  // print results on screen
                    printSeparationResults(pSep);
                } else if (upsOnSheet < 3 && sheetsToSeparate > 1000){
                  alert ("mozesz separowac pneumatycznie");
                  // calculate pneumatic separation
                    pSep = calculatePneumaticSeparation (sheetsToSeparate, upsOnSheet, upIsLithoLaminated, laminationTypeID, manualWindowStrippingRunTime);
                  // print results on screen
                    printSeparationResults(pSep);
                } else if (sheetsToSeparate <= 1000){
                  alert ("rozwaz separację reczną");
                  // calculate pneumatic separation
                    pSep = calculatePneumaticSeparation (sheetsToSeparate, upsOnSheet, upIsLithoLaminated, laminationTypeID, manualWindowStrippingRunTime);
                  // print results on screen
                    printSeparationResults(pSep);
                } else {
                  alert ("ten warunek separacji nie jest obslugiwany. skontaktuj sie z administratorem.");
                }

            } else if (!upFitsOnSeparator) { // if ups do not fit on separator
                if (sheetsToSeparate <= 1000){
                  alert ("rozwaz separację reczną");
                  // calculate pneumatic separation
                    pSep = calculatePneumaticSeparation (sheetsToSeparate, upsOnSheet, upIsLithoLaminated, laminationTypeID, manualWindowStrippingRunTime);
                  // print results on screen
                    printSeparationResults(pSep);
                } else if (sheetsToSeparate > 1000) {
                  alert ("mozesz separowac pneumatycznie");
                  // calculate pneumatic separation
                    pSep = calculatePneumaticSeparation (sheetsToSeparate, upsOnSheet, upIsLithoLaminated, laminationTypeID, manualWindowStrippingRunTime);
                  // print results on screen
                    printSeparationResults(pSep);
                } else {
                  alert ("ten warunek separacji nie jest obslugiwany. skontaktuj sie z administratorem.");
                }
            }
          break;

          case 3: // automatic separation
            // check if separator tooling is selected
            separationToolingTypeID
            if (!upIsLithoLaminated && upFitsOnSeparator && sheetsToSeparate > 1000){
              alert ("mozesz separowac automatycznie");
              // calculate automatic separation
                aSep = calculateAutomaticSeparation (sheetsToSeparate, upsOnSheet, orderTypeID, separationToolingTypeID, manualWindowStrippingRunTime);
              // print results on screen
                printSeparationResults(aSep);
            } else if (!upFitsOnSeparator && sheetsToSeparate <= 1000) {
              alert (errMsgUpFitsOnSeparator); // infor user that ups don't fit on separator
              alert ("trzeba separowac recznie");
              // change separation type to manual
                $("#separationProcessType").val(1);
              // fire change event to force recalculation to manual separation and fire hiding of non manuual fields
                $('#separationProcessType').trigger('change');
              // calculate manual separation
                mSep = calculateManualSeparation (sheetsToSeparate, manualWindowStrippingRunTime);
              // print results on screen
                printSeparationResults(mSep);
            } else if (!upIsLithoLaminated && upFitsOnSeparator && sheetsToSeparate <= 1000) {
              alert ("trzeba separowac reczną");
              // change separation type to manual
                $("#separationProcessType").val(1);
              // fire change event to force recalculation to manual separation and fire hiding of non manuual fields
                $('#separationProcessType').trigger('change');
              // calculate manual separation
                mSep = calculateManualSeparation (sheetsToSeparate, manualWindowStrippingRunTime);
              // print results on screen
                printSeparationResults(mSep);
            } else if (!upFitsOnSeparator && upsOnSheet <= 4 && sheetsToSeparate > 1000) {
              alert (errMsgUpFitsOnSeparator); // infor user that ups don't fit on separator
              alert ("trzeba separowac pneumatycznie");
              // change separation type to pneumatic
                $("#separationProcessType").val(2);
              // fire change event to force recalculation to pneumatic separation and fire hiding of non pneumatic fields
                $('#separationProcessType').trigger('change');
                pSep = calculatePneumaticSeparation (sheetsToSeparate, upsOnSheet, upIsLithoLaminated, laminationTypeID, manualWindowStrippingRunTime);
              // print results on screen
                printSeparationResults(pSep);
            } else if (!upFitsOnSeparator && upsOnSheet >= 4 && sheetsToSeparate > 1000) {
              alert (errMsgUpFitsOnSeparator); // infor user that ups don't fit on separator
              alert ("trzeba separowac reczną");
              // change separation type to manual
                $("#separationProcessType").val(1);
              // fire change event to force recalculation to manual separation and fire hiding of non manuual fields
                $('#separationProcessType').trigger('change');
              // calculate manual separation
                mSep = calculateManualSeparation (sheetsToSeparate, manualWindowStrippingRunTime);
              // print results on screen
                printSeparationResults(mSep);
            } else if (upIsLithoLaminated && upFitsOnSeparator && upsOnSheet <= 4 && sheetsToSeparate > 1000) {
              alert ("trzeba separowac pneumatycznie");
              // change separation type to pneumatic
                $("#separationProcessType").val(2);
              // fire change event to force recalculation to pneumatic separation and fire hiding of non pneumatic fields
                $('#separationProcessType').trigger('change');
              // calculate pneumatic separation
                pSep = calculatePneumaticSeparation (sheetsToSeparate, upsOnSheet, upIsLithoLaminated, laminationTypeID, manualWindowStrippingRunTime);
              // print results on screen
                printSeparationResults(pSep);
            } else if (upIsLithoLaminated && upFitsOnSeparator && upsOnSheet > 4 && sheetsToSeparate > 1000) {
              alert ("mozna separowac automatycznie jesli kaszerowany jest karton do kartonu");
                // calculate automatic separation
                  aSep = calculateAutomaticSeparation (sheetsToSeparate, upsOnSheet, orderTypeID, separationToolingTypeID, manualWindowStrippingRunTime);
                // print results on screen
                  printSeparationResults(aSep);
              } else {
                alert ("ten warunek separacji nie jest obslugiwany. skontaktuj sie z administratorem.");
              }
          break;

          case 4: // cutter separation
            /* to be chosen when there are 1
            1. A lot of ups on the sheet, which have straight dimensions (rectangle or square)
            2a. There are not holes to strip  or
            2b. number of holes to strip * number of ups on sheet * number of sheets is small
            2. Cannot be used on lithilaminated products
            */
          if (upIsLithoLaminated) {
            alert ("trzeba separowac pneumatycznie");
            // change separation type to pneumatic
              $("#separationProcessType").val(2);
            // fire change event to force recalculation to pneumatic separation and fire hiding of non pneumatic fields
              $('#separationProcessType').trigger('change');
            // calculate pneumatic separation
              pSep = calculatePneumaticSeparation (sheetsToSeparate, upsOnSheet, upIsLithoLaminated, laminationTypeID, manualWindowStrippingRunTime);
            // hide automatic separation fields and zero out comboboxes and other fields
              showSeparationFields (false,3); // hide and zero out automatic separation boxes
            // print results on screen
              printSeparationResults(pSep);
          } else if (!upIsLithoLaminated && upsOnSheet > 20 && !upFitsOnSeparator) {
            alert ("mozesz separowac na gilotynie");
            // calculate cutter separation
              cSep = calculateCutterSeparation (sheetsToSeparate, manualWindowStrippingRunTime);
            // print results on screen
              printSeparationResults(cSep);
          } else if (!upIsLithoLaminated && upsOnSheet <= 20 && upFitsOnSeparator && sheetsToSeparate > 1000 ) {
            alert ("rozwaz separację automatyczne");
            // calculate cutter separation
              cSep = calculateCutterSeparation (sheetsToSeparate, manualWindowStrippingRunTime);
            // print results on screen
              printSeparationResults(cSep);
          } else {
            alert ("mozesz separowac na gilotynie lub automatycznie");
            // calculate cutter separation
              cSep = calculateCutterSeparation (sheetsToSeparate, manualWindowStrippingRunTime);
            // print results on screen
              printSeparationResults(cSep);
          }

          break;
       }
     } else if (separationID && !productDimensionPresent.upDimsPresent) { // condition when separation ID is selected but up dimensions are not filled out by user
       alert ('Nie okreslono wymiarow uzytku. Przyjmuje 0.\n Czasy i koszty wyrywania zostana wyzerowane.');
       $('#separationProcessType').val(0); // set the value of separation ID to zero
       zeroOutSeparationFields (); // Zero out ups Separation cost, times and info strings
       showSeparationFields (false, separationID); // run functions to show or hide fields
       //  count_cost_count_total(); // call function to recalculate total costs

    } else { //if separation type is not selected hide additional input fields, zeroout fields and recalculate
      zeroOutSeparationFields (); // Zero out cost, times and info strings
      showSeparationFields (false, separationID); // run functions to show or hide fields
    }
    count_cost_count_total();// call function to recalculate total costs
    freezeSaving (false); // unfreeze calculation
}


/////////////////////////////////////////////////////// SEPARATION HELPER FUNCTIONS SECTION ///////////////////////////////////////////////////////////////////

function doUpsFitOnSeparator (upMinimumWidth,upMinimumLenght,upMaximumWidth,upMaximumLenght,upWidth,upLenght){
  "use strict"; // to enable sctrict mode in js
  // define variables
    var upFitsOnSeparator;  // boolean - either fit or don't fit
    var newLine = "\r\n"; // line break var
    var errDim;              // actual error dimensions
    var errInfoString;    // error string to display if ups don't fit on separator
  // evaluate if up fits on separator
    if (upWidth <= upMaximumWidth && upLenght <=upMaximumLenght && upWidth >=upMinimumWidth && upLenght >= upMinimumLenght) {
      upFitsOnSeparator = true;
    } else {
      upFitsOnSeparator = false;
        if (upWidth > upMaximumWidth) {
          errDim = 'Szerokosc uzytku = ' + upWidth + ' > od maksymalnej = ' + upMaximumWidth;
        }
        if (upLenght > upMaximumLenght) {
          errDim += newLine;
          errDim +=' Dlugosc uzytku = ' + upLenght + ' > od maksymalnej = ' + upMaximumLenght;
        }
        if (upWidth < upMinimumWidth) {
          errDim += newLine;
          errDim += ' Szerokosc uzytku = ' + upWidth + ' < od minimalnej = ' + upMinimumWidth;
        }
        if (upLenght < upMinimumLenght) {
          errDim += newLine;
          errDim += ' Dlugosc uzytku = ' + upLenght + ' < od minimalnej = ' + upMinimumLenght;
        }
      errInfoString = 'Uzytek nie pasuje na obrywarke automatyczna: ';
      errInfoString += newLine;
      errInfoString+= errDim;
    }
  return {
    upFitsOnSeparator:upFitsOnSeparator,
    errInfo: errInfoString
  };
}

function getPacksPerHour (upsOnSheet) {
  "use strict"; // to enable sctrict mode in js
  //TODO: Move querying on separation speed in packPerHour to database and make an AJAX call for data to db instead of function getPacksPerHour

  /* Separation efficiency table in packs per hour as of 2021-01-22
  UpsOnSheetRange	PacksPerHour SheetsPerHour
  1-4	              40          4000-1000
  5-8	              80          1600-1000
  9-12	            120         1333-1000
  13-16	            160         1200-1000
  17-30	            180         1100-660
  */
  var packsPerHour; // number of packs separated per hour

  if ((upsOnSheet > 0) && (upsOnSheet <= 4)) {
    packsPerHour = 40;
  } else if ((upsOnSheet > 4) && (upsOnSheet <= 8)) {
    packsPerHour = 80;
  } else if ((upsOnSheet > 8) && (upsOnSheet <= 12)) {
    packsPerHour = 120;
  } else if ((upsOnSheet > 12) && (upsOnSheet <= 16)) {
    packsPerHour = 160;
  } else if ((upsOnSheet > 16) && (upsOnSheet <= 30)) {
    packsPerHour = 180;
  } else {
    packsPerHour = 180;
  }
  return packsPerHour;
}

function createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime) {
  let automaticSeparationRunTimeInfoString;
  let packsPerHour;
  packsPerHour = getPacksPerHour(upsOnSheet);
  return automaticSeparationRunTimeInfoString = '((Ilosc arkuszy/ arkuszy do separacji w ryzie) * ilosc uzytkow) / ilosc paczek uzytkow w godzine) + czas ręcznego dziurkowania = (( ' + Math.round(sheetsToSeparate) + ' / ' + sheetsPerSeparation +' ) * ' + upsOnSheet  + ' ) / ' + packsPerHour + ' ) + ' + manualWindowStrippingRunTime;
}

function createCutterSeparationRunTimeInfoString (sheetsToSeparate, cutterSeparationSpeed, manualWindowStrippingRunTime) {
  let cutterSeparationRunTimeInfoString;
  return cutterSeparationRunTimeInfoString = '(Ilosc arkuszy / wydajnosc) + czas ręcznego dziurkowania = ( ' + Math.round(sheetsToSeparate) + ' / ' + cutterSeparationSpeed + ' ) + ' + manualWindowStrippingRunTime;
}

function createManualSeparationRunTimeInfoString (sheetsToSeparate, manualSeparationSpeed, manualWindowStrippingRunTime) {
  let manualSeparationRunTimeInfoString;
  return manualSeparationRunTimeInfoString = '(Ilosc arkuszy / wydajnosc) + czas ręcznego dziurkowania = ( ' + Math.round(sheetsToSeparate) + ' / ' + manualSeparationSpeed + ' ) + ' + manualWindowStrippingRunTime;
}

function createPneumaticSeparationRunTimeInfoString (sheetsToSeparate, pneumaticSeparationSpeed, manualWindowStrippingRunTime) {
  let pneumaticSeparationRunTimeInfoString;
  return pneumaticSeparationRunTimeInfoString = '(Ilosc arkuszy / wydajnosc) + czas ręcznego dziurkowania = ( ' + Math.round(sheetsToSeparate) + ' / ' + pneumaticSeparationSpeed + ' ) + ' + manualWindowStrippingRunTime;
}


/////////////////////////////////////////////////////// SEPARATION HELPER FUNCTIONS SECTION ///////////////////////////////////////////////////////////////////


// TODO: make 1 from 4 functions calculateManualSeparation, calculatePneumaticSeparation, calculateAutomaticSeparation, calculateCutterSeparation into one run by different parameters since they all look the same
function calculateManualSeparation (sheetsToSeparate, manualWindowStrippingRunTime){
  "use strict"; // to enable sctrict mode in js
  /* Input variables
    sheetsToSeparate - number of sheets to separate - influences separation speed
    upsOnSheet - number of ups on sheet to separate - influences separation speed
    upWindows - number of windows on up - influences separation speed
    manualWindowStripping - boolean stating if windows are to be stripped manually
  */

  // define variables
  //var manualSeparationSpeed; // sheets per hoursTohhmm
  var manualSeparationSetupTime; // setup time depending on separationToolingTypeID
  var manualSeparationRunTime; // runtime from sheetsToSeparate, upsOnSheet and separationToolingTypeID
  var manualSeparationIdleTime;
  var manualSeparationTotalTime;
  var manualSeparationIdlePercentage = manualSeparation.IdleTime_Percentage; //fixed value

  var manualSeparationSetupCost; // cost of manual separation setup
  var manualSeparationRunCost; // cost of manual separation run
  var manualSeparationIdleCost; // cost of manual separation idle
  var manualSeparationTotalCost;

  var manualSeparationSetupInfoString;
  var manualSeparationRunTimeInfoString;
  var manualSeparationIdleTimeInfoString;
  var manualSeparationTotalTimeInfoString;

// evaluate & calculate separation times
  manualSeparationSetupTime = manualSeparation.separationSetupTime;

// calculate runtimes and idle times adding manualWindowStripping time if selected
  manualSeparationRunTime = sheetsToSeparate/ manualSeparation.separationSpeed + manualWindowStrippingRunTime;
  manualSeparationIdleTime = manualSeparationRunTime * manualSeparationIdlePercentage; // hours

// calculate sepration costs
  manualSeparationSetupCost = manualSeparationSetupTime * manualSeparation.SetupTime_CostPerHour;
  manualSeparationRunCost = manualSeparationRunTime * manualSeparation.RunTime_CostPerHour;
  manualSeparationIdleCost = manualSeparationIdleTime * manualSeparation.IdleTime_CostPerHour;
  manualSeparationTotalCost = manualSeparationSetupCost + manualSeparationRunCost + manualSeparationIdleCost;
// roundup convert separation costs
  manualSeparationSetupCost = precise_round(manualSeparationSetupCost,2);
  manualSeparationRunCost = precise_round(manualSeparationRunCost,2);
  manualSeparationIdleCost = precise_round(manualSeparationIdleCost,2);
  manualSeparationTotalCost = precise_round(manualSeparationTotalCost,2);
// calculate totalTime and convert data to hours : minutes
  manualSeparationTotalTime = hoursTohhmm(manualSeparationSetupTime + manualSeparationRunTime);// + manualSeparationIdleTime);
  manualSeparationSetupTime = hoursTohhmm(manualSeparationSetupTime);
  manualSeparationRunTime = hoursTohhmm(manualSeparationRunTime);
  manualSeparationIdleTime = hoursTohhmm(manualSeparationIdleTime);
// generate info strings
  manualSeparationSetupInfoString = 'czas narządu * koszt roboczogodziny = ' + manualSeparationSetupTime + ' * ' + manualSeparation.SetupTime_CostPerHour;
  manualSeparationRunTimeInfoString = createManualSeparationRunTimeInfoString (sheetsToSeparate, manualSeparation.separationSpeed, manualWindowStrippingRunTime)
  manualSeparationIdleTimeInfoString = 'czas idle * koszt roboczogodziny = ' + manualSeparationIdleTime + ' * ' + manualSeparation.IdleTime_CostPerHour;
  manualSeparationTotalTimeInfoString = '(koszt narzadu + koszt jazdy + koszt idle)  = ' + manualSeparationSetupCost + ' + ' + manualSeparationRunCost + ' + ' + manualSeparationIdleCost;
// return calculated values as object
  return {
    sepSetupTime: manualSeparationSetupTime,
    sepRunTime: manualSeparationRunTime,
    sepIdleTime: manualSeparationIdleTime,
    sepTotalTime: manualSeparationTotalTime,
    sepSetupCost: manualSeparationSetupCost,
    sepRunCost: manualSeparationRunCost,
    sepIdleCost: manualSeparationIdleCost,
    sepTotalCost: manualSeparationTotalCost,
    sepSetupInfo: manualSeparationSetupInfoString,
    sepRunInfo: manualSeparationRunTimeInfoString,
    sepIdleInfo: manualSeparationIdleTimeInfoString,
    sepTotalInfo: manualSeparationTotalTimeInfoString
  };
}

function calculatePneumaticSeparation (sheetsToSeparate, upsOnSheet, upIsLithoLaminated, laminationTypeID, manualWindowStrippingRunTime){
  "use strict"; // to enable sctrict mode in js
  /* Input variables
    sheetsToSeparate - number of sheets to separate - influences separation speed
    upsOnSheet - number of ups on sheet to separate - influences separation speed
    upWindows - number of windows on up - influences separation speed
  */
  /* Input variables
    sheetsToSeparate - number of sheets to separate - influences separation speed
    upsOnSheet - number of ups on sheet to separate - influences separation speed
  */
  // define variables
    var pneumaticSeparationSpeed; // sheets per hoursTohhmm
    var pneumaticSeparationSetupTime; // setup time depending on separationToolingTypeID
    var pneumaticSeparationRunTime; // runtime from sheetsToSeparate, upsOnSheet and separationToolingTypeID
    var pneumaticSeparationIdleTime;
    var pneumaticSeparationTotalTime;
    var pneumaticSeparationIdlePercentage = pneumaticSeparation.IdleTime_Percentage; //fixed value

    var pneumaticSeparationSetupCost; // cost of pneumatic separation setup
    var pneumaticSeparationRunCost; // cost of pneumatic separation run
    var pneumaticSeparationIdleCost; // cost of pneumatic separation idle
    var pneumaticSeparationTotalCost;

    var pneumaticSeparationSetupInfoString;
    var pneumaticSeparationRunTimeInfoString;
    var pneumaticSeparationIdleTimeInfoString;
    var pneumaticSeparationTotalTimeInfoString;

  // evaluate & calculate separation times
    pneumaticSeparationSetupTime = pneumaticSeparation.separationSetupTime;


// BEGIN determining pneumatic separation speeds
  // check for board type (litholaminated or solid board)
  if (upIsLithoLaminated){ // litho board ups on sheet pneumatic separation
    // check for lamination typeID / flute type
      switch (laminationTypeID) {
        case 1: //  2 layer flute
          switch (upsOnSheet) {
            case 1: 
              pneumaticSeparationSpeed = 1500;
              break;
            case 2:
              pneumaticSeparationSpeed = 1000;
              break;
            case 3:
              pneumaticSeparationSpeed = 800;
              break;
            default: // for all ups greater or equal to 4
              pneumaticSeparationSpeed = 600;
          }
          break;
        case 2: // 3 layer flute
          switch (upsOnSheet) {
            case 1: 
              pneumaticSeparationSpeed = 1200;
              break;
            case 2:
              pneumaticSeparationSpeed = 800;
              break;
            case 3:
              pneumaticSeparationSpeed = 600;
              break;
            default: // for all ups greater or equal to 4
              pneumaticSeparationSpeed = 450;
          }
          break;
        case 3: // 5 layer flute
          switch (upsOnSheet) {
            case 1: 
              pneumaticSeparationSpeed = 800;
              break;
            case 2:
              pneumaticSeparationSpeed = 600;
              break;
            case 3:
              pneumaticSeparationSpeed = 400;
              break;
            default: // for all ups greater or equal to 4
              pneumaticSeparationSpeed = 350;
          }
          break;
      }
    
  } else if (!upIsLithoLaminated) { // solid board ups on sheet pneumatic separation
    // NOTE: upsOnSheet have to be actual ups on sheet not ups on sheet calculated to B2 format, since it makes a difference if people have to separate on or more ups from an actual sheet
    // check for actual upsOnSheet number
    switch (upsOnSheet) {
      case 1:  // 1 up on sheet
        pneumaticSeparationSpeed = 3000;
        break;
      case 2: // 2 ups on sheet
        pneumaticSeparationSpeed = 2000;
        break;
      case 3: // 3 ups on sheet
        pneumaticSeparationSpeed = 1500;
        break;
      default: // for all ups greater or equal to 4
        pneumaticSeparationSpeed = 800;
    }
  } else { // default condition
    alert ("domyślny i najniższy warunek separacji. Wydajnosc 450");
    pneumaticSeparationSpeed = 450;
  }
// END determining pneumatic separation speeds


    pneumaticSeparationRunTime = sheetsToSeparate/ pneumaticSeparationSpeed + manualWindowStrippingRunTime;
    pneumaticSeparationIdleTime = pneumaticSeparationRunTime * pneumaticSeparationIdlePercentage; // hours
  // calculate sepration costs
    pneumaticSeparationSetupCost = pneumaticSeparationSetupTime * pneumaticSeparation.SetupTime_CostPerHour;
    pneumaticSeparationRunCost = pneumaticSeparationRunTime * pneumaticSeparation.RunTime_CostPerHour;
    pneumaticSeparationIdleCost = pneumaticSeparationIdleTime * pneumaticSeparation.IdleTime_CostPerHour;
    pneumaticSeparationTotalCost = pneumaticSeparationSetupCost + pneumaticSeparationRunCost + pneumaticSeparationIdleCost;
  // roundup convert separation costs
    pneumaticSeparationSetupCost = precise_round(pneumaticSeparationSetupCost,2);
    pneumaticSeparationRunCost = precise_round(pneumaticSeparationRunCost,2);
    pneumaticSeparationIdleCost = precise_round(pneumaticSeparationIdleCost,2);
    pneumaticSeparationTotalCost = precise_round(pneumaticSeparationTotalCost,2);
  // calculate totalTime and convert data to hours : minutes
    pneumaticSeparationTotalTime = hoursTohhmm(pneumaticSeparationSetupTime + pneumaticSeparationRunTime);// + pneumaticSeparationIdleTime);
    pneumaticSeparationSetupTime = hoursTohhmm(pneumaticSeparationSetupTime);
    pneumaticSeparationRunTime = hoursTohhmm(pneumaticSeparationRunTime);
    pneumaticSeparationIdleTime = hoursTohhmm(pneumaticSeparationIdleTime);
  // generate info strings
    pneumaticSeparationSetupInfoString = 'czas narządu * koszt roboczogodziny = ' + pneumaticSeparationSetupTime + ' * ' + pneumaticSeparation.SetupTime_CostPerHour;
    pneumaticSeparationRunTimeInfoString = createPneumaticSeparationRunTimeInfoString (sheetsToSeparate, pneumaticSeparationSpeed, manualWindowStrippingRunTime)
    pneumaticSeparationIdleTimeInfoString = 'czas idle * koszt roboczogodziny = ' + pneumaticSeparationIdleTime + ' * ' + pneumaticSeparation.IdleTime_CostPerHour;
    pneumaticSeparationTotalTimeInfoString = '(koszt narzadu + koszt jazdy + koszt idle)  = ' + pneumaticSeparationSetupCost + ' + ' + pneumaticSeparationRunCost + ' + ' + pneumaticSeparationIdleCost;
  // return calculated values as object
    return {
      sepSetupTime: pneumaticSeparationSetupTime,
      sepRunTime: pneumaticSeparationRunTime,
      sepIdleTime: pneumaticSeparationIdleTime,
      sepTotalTime: pneumaticSeparationTotalTime,
      sepSetupCost: pneumaticSeparationSetupCost,
      sepRunCost: pneumaticSeparationRunCost,
      sepIdleCost: pneumaticSeparationIdleCost,
      sepTotalCost: pneumaticSeparationTotalCost,
      sepSetupInfo: pneumaticSeparationSetupInfoString,
      sepRunInfo: pneumaticSeparationRunTimeInfoString,
      sepIdleInfo: pneumaticSeparationIdleTimeInfoString,
      sepTotalInfo: pneumaticSeparationTotalTimeInfoString
    };

  }

function calculateAutomaticSeparation (sheetsToSeparate, upsOnSheet, orderTypeID, separationToolingTypeID, manualWindowStrippingRunTime){
  "use strict"; // to enable sctrict mode in js
  //TODO: Modify and extend orderTypeID in db to reflect the separation efficiency speed in pack per hour so to be able to use orderTypeID instead of a getPacksPerHour function

  /* Input variables
    sheetsToSeparate - number of sheets to separate - influences separation speed
    upsOnSheet - number of ups on sheet to separate - influences separation speed
  */

  // define variables
  var automaticSeparationSpeed; // sheets per hoursTohhmm
  var automaticSeparationIdlePercentage = automaticSeparation.IdleTime_Percentage; //fixed value
  var sheetsPerSeparation = automaticSeparation.sheetsPerSeparation; // number of sheets put on separator once at a time
  var packsPerHour; // number of packs of ups of 100pcs separated per one hour on separator
  var automaticSeparationSetupTime; // setup time depending on separationToolingTypeID
  var automaticSeparationRunTime; // runtime from sheetsToSeparate, upsOnSheet and separationToolingTypeID
  var automaticSeparationIdleTime;
  var automaticSeparationTotalTime;

  var automaticSeparationSetupCost; // cost of automatic separation setup
  var automaticSeparationRunCost; // cost of automatic separation run
  var automaticSeparationIdleCost; // cost of automatic separation idle
  var automaticSeparationTotalCost;

  var automaticSeparationSetupInfoString;
  var automaticSeparationRunTimeInfoString;
  var automaticSeparationIdleTimeInfoString;
  var automaticSeparationTotalTimeInfoString;

// evaluate & calculate separation times
switch (separationToolingTypeID) { // evaluate setup times, runtimes and idle times based on toolng type chosen

  case 1: // 1 glowica (rama + szyny)
    switch (orderTypeID) {
      case 7: // obwoluta
        automaticSeparationSetupTime = 0.5; // hours
        //automaticSeparationSpeed = 1200; // sheets per hour
        automaticSeparationRunTime = ((sheetsToSeparate/ sheetsPerSeparation)*upsOnSheet)/ getPacksPerHour(upsOnSheet) + manualWindowStrippingRunTime;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
      // begin fall-through cases
      case 1: // koperta
      case 3: // pudełko 1-3 uz
      case 4: // pudelko 4-8 uz
      case 5: // pudelko >8 uz
        automaticSeparationSetupTime = 1; // hours
        //automaticSeparationSpeed = 1000; // sheets per hour
        automaticSeparationRunTime = ((sheetsToSeparate/ sheetsPerSeparation)*upsOnSheet)/ getPacksPerHour(upsOnSheet) + manualWindowStrippingRunTime;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
      default:
        alert ('Warunek domyslny w petli: ', 'separationToolingTypeID: ',separationToolingTypeID,'orderTypeID: ', orderTypeID);
        automaticSeparationSetupTime = 1; // hours
        //automaticSeparationSpeed = 900; // sheets per hour
        automaticSeparationRunTime = ((sheetsToSeparate/ sheetsPerSeparation)*upsOnSheet)/ getPacksPerHour(upsOnSheet) + manualWindowStrippingRunTime ;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
    }
  break;

  case 2: // 2 glowice (rama + szyny)
    switch (orderTypeID) {
      case 7: // obwoluta
        automaticSeparationSetupTime = 1; // hours
        //automaticSeparationSpeed = 1200; // sheets per hour
        automaticSeparationRunTime = ((sheetsToSeparate/ sheetsPerSeparation)*upsOnSheet)/ getPacksPerHour(upsOnSheet) + manualWindowStrippingRunTime;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
      // begin fall-through cases
      case 1: // koperta
      case 3: // pudełko 1-3 uz
      case 4: // pudelko 4-8 uz
      case 5: // pudelko >8 uz
        automaticSeparationSetupTime = 1.5; // hours
        //automaticSeparationSpeed = 1000; // sheets per hour
        automaticSeparationRunTime = ((sheetsToSeparate/ sheetsPerSeparation)*upsOnSheet)/ getPacksPerHour(upsOnSheet) + manualWindowStrippingRunTime;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
      default:
        alert ('Warunek domyslny w petli: ', 'separationToolingTypeID: ',separationToolingTypeID,'orderTypeID: ', orderTypeID);
        automaticSeparationSetupTime = 1.5; // hours
        //automaticSeparationSpeed = 900; // sheets per hour
        automaticSeparationRunTime = ((sheetsToSeparate/ sheetsPerSeparation)*upsOnSheet)/ getPacksPerHour(upsOnSheet) + manualWindowStrippingRunTime;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
    }
  break;

  case 3: // 1 glowica (deska pod uzytek)
    switch (orderTypeID) {
      case 7: // obwoluta
        automaticSeparationSetupTime = 0.5; // hours
        //automaticSeparationSpeed = 1500; // sheets per hour
        automaticSeparationRunTime = ((sheetsToSeparate/ sheetsPerSeparation)*upsOnSheet)/ getPacksPerHour(upsOnSheet) + manualWindowStrippingRunTime;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
      // begin fall-through cases
      case 1: // koperta
      case 3: // pudełko 1-3 uz
      case 4: // pudelko 4-8 uz
      case 5: // pudelko >8 uz
        automaticSeparationSetupTime = 0.5; // hours
        //automaticSeparationSpeed = 1500; // sheets per hour
        automaticSeparationRunTime = ((sheetsToSeparate/ sheetsPerSeparation)*upsOnSheet)/ getPacksPerHour(upsOnSheet) + manualWindowStrippingRunTime;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
      default:
        alert ('Warunek domyslny w petli: ', 'separationToolingTypeID: ',separationToolingTypeID,'orderTypeID: ', orderTypeID);
        automaticSeparationSetupTime = 0.5; // hours
        automaticSeparationSpeed = 100; // sheets per hour
        automaticSeparationRunTime = sheetsToSeparate/ automaticSeparationSpeed + manualWindowStrippingRunTime;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
    }
  break;

  case 4: // 2 glowice (2 deski pod uzytki)
    switch (orderTypeID) {
      case 7: // obwoluta
        automaticSeparationSetupTime = 1; // hours
        //automaticSeparationSpeed = 1500; // sheets per hour
        automaticSeparationRunTime = ((sheetsToSeparate/ sheetsPerSeparation)*upsOnSheet)/ getPacksPerHour(upsOnSheet) + manualWindowStrippingRunTime ;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
      // begin fall-through cases
      case 1: // koperta
      case 3: // pudełko 1-3 uz
      case 4: // pudelko 4-8 uz
      case 5: // pudelko >8 uz
        automaticSeparationSetupTime = 1; // hours
        //automaticSeparationSpeed = 1500; // sheets per hour
        automaticSeparationRunTime = ((sheetsToSeparate/ sheetsPerSeparation)*upsOnSheet)/ getPacksPerHour(upsOnSheet) + manualWindowStrippingRunTime;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
      default:
        alert ('Warunek domyslny w petli: ', 'separationToolingTypeID: ',separationToolingTypeID,'orderTypeID: ', orderTypeID);
        automaticSeparationSetupTime = 1; // hours
        //automaticSeparationSpeed = 1000; // sheets per hour
        automaticSeparationRunTime = ((sheetsToSeparate/ sheetsPerSeparation)*upsOnSheet)/ getPacksPerHour(upsOnSheet) + manualWindowStrippingRunTime;
        automaticSeparationRunTimeInfoString = createAutomaticSeparationRunTimeInfoString (sheetsToSeparate, sheetsPerSeparation, upsOnSheet, manualWindowStrippingRunTime);
        automaticSeparationIdleTime = automaticSeparationRunTime * automaticSeparationIdlePercentage; // hours
      break;
    }
  break;
  default: // when some othed separation ID has been chosen or an error occured
    alert ('Nie wybrano zdefiniowanego rodzaju narzedzia obrywania');
    return; // exit without calculations
  break;
}


// calculate sepration costs
  automaticSeparationSetupCost = automaticSeparationSetupTime * automaticSeparation.SetupTime_CostPerHour;
  automaticSeparationRunCost = automaticSeparationRunTime * automaticSeparation.RunTime_CostPerHour;
  automaticSeparationIdleCost = automaticSeparationIdleTime * automaticSeparation.IdleTime_CostPerHour;
  automaticSeparationTotalCost = automaticSeparationSetupCost + automaticSeparationRunCost + automaticSeparationIdleCost;
// roundup convert separation costs
  automaticSeparationSetupCost = precise_round(automaticSeparationSetupCost,2);
  automaticSeparationRunCost = precise_round(automaticSeparationRunCost,2);
  automaticSeparationIdleCost = precise_round(automaticSeparationIdleCost,2);
  automaticSeparationTotalCost = precise_round(automaticSeparationTotalCost,2);

// calculate totalTime and convert data to hours : minutes
  automaticSeparationTotalTime = hoursTohhmm(automaticSeparationSetupTime + automaticSeparationRunTime);// + automaticSeparationIdleTime);
  automaticSeparationSetupTime = hoursTohhmm(automaticSeparationSetupTime);
  automaticSeparationRunTime = hoursTohhmm(automaticSeparationRunTime);
  automaticSeparationIdleTime = hoursTohhmm(automaticSeparationIdleTime);

// generate info strings
  automaticSeparationSetupInfoString = 'czas narządu * koszt roboczogodziny = ' + automaticSeparationSetupTime + ' * ' + automaticSeparation.SetupTime_CostPerHour;
  //automaticSeparationRunTimeInfoString = 'czas jazdy * koszt roboczogodziny = ' + automaticSeparationRunTime + ' * ' + automaticSeparation.RunTime_CostPerHour;
  automaticSeparationIdleTimeInfoString = 'czas idle * koszt roboczogodziny = ' + automaticSeparationIdleTime + ' * ' + automaticSeparation.IdleTime_CostPerHour;
  automaticSeparationTotalTimeInfoString = '(koszt narzadu + koszt jazdy + koszt idle)  = ' + automaticSeparationSetupCost + ' + ' + automaticSeparationRunCost + ' + ' + automaticSeparationIdleCost;
// return calculated values as object
  return {
    sepSetupTime: automaticSeparationSetupTime,
    sepRunTime: automaticSeparationRunTime,
    sepIdleTime: automaticSeparationIdleTime,
    sepTotalTime: automaticSeparationTotalTime,
    sepSetupCost: automaticSeparationSetupCost,
    sepRunCost: automaticSeparationRunCost,
    sepIdleCost: automaticSeparationIdleCost,
    sepTotalCost: automaticSeparationTotalCost,
    sepSetupInfo: automaticSeparationSetupInfoString,
    sepRunInfo: automaticSeparationRunTimeInfoString,
    sepIdleInfo: automaticSeparationIdleTimeInfoString,
    sepTotalInfo: automaticSeparationTotalTimeInfoString
  };
}

function printSeparationResults (object){
  "use strict"; // to enable sctrict mode in js
  /*switch (separationType) {
    case "manualSeparation":
      alert ('manual separation printSeparationResults not defined yet');
    break;
    case "pneumaticSeparation":
      alert ('pneumatic separation printSeparationResults not defined yet');
    break;
    case "automaticSeparation":
    */
      // print automatic separation times on screen
        $("#separationSetupTime").val(object.sepSetupTime);
        $("#separationRunTime").val(object.sepRunTime);
        $("#separationIdleTime").val(object.sepIdleTime);
        $("#separationTotalTime").val(object.sepTotalTime);
      // print automatic separation costs on screen
        $("#separationSetupRealCosts").val(object.sepSetupCost);
        $("#cost_manual_work_jazda_real").val(object.sepRunCost);
        $("#cost_manual_work_idle_real").val(object.sepIdleCost);
        $("#cost_manual_work_real").val(object.sepTotalCost);
        $("#cost_manual_work").val(object.sepTotalCost);
      // print automatic separation infoStrings on screen
        $("#separationSetupInfo").val(object.sepSetupInfo);
        $("#cost_manual_work_jazda_info").val(object.sepRunInfo);
        $("#cost_manual_work_idle_info").val(object.sepIdleInfo);
        $("#cost_manual_work_info").val(object.sepTotalInfo);
/*
    break;
    case "cutterSeparation":
      alert ('cutter separation printSeparationResults not defined yet');
    break;

  }
  */
}

function calculateCutterSeparation (sheetsToSeparate, manualWindowStrippingRunTime){
  "use strict"; // to enable sctrict mode in js
  /* Input variables
    sheetsToSeparate - number of sheets to separate - influences separation speed
    upsOnSheet - number of ups on sheet to separate - influences separation speed
    upWindows - number of windows on up - influences separation speed
  */
  /* Input variables
    sheetsToSeparate - number of sheets to separate - influences separation speed
    upsOnSheet - number of ups on sheet to separate - influences separation speed
  */
  // define variables
  //var cutterSeparationSpeed; // sheets per hoursTohhmm
    var cutterSeparationSetupTime; // setup time depending on separationToolingTypeID
    var cutterSeparationRunTime; // runtime from sheetsToSeparate, upsOnSheet and separationToolingTypeID
    var cutterSeparationIdleTime;
    var cutterSeparationTotalTime;
    var cutterSeparationIdlePercentage = cutterSeparation.IdleTime_Percentage; //fixed value

    var cutterSeparationSetupCost; // cost of cutter separation setup
    var cutterSeparationRunCost; // cost of cutter separation run
    var cutterSeparationIdleCost; // cost of cutter separation idle
    var cutterSeparationTotalCost;

    var cutterSeparationSetupInfoString;
    var cutterSeparationRunTimeInfoString;
    var cutterSeparationIdleTimeInfoString;
    var cutterSeparationTotalTimeInfoString;

  // evaluate & calculate separation times
    cutterSeparationSetupTime = cutterSeparation.separationSetupTime;
    cutterSeparationRunTime = sheetsToSeparate/ cutterSeparation.separationSpeed + manualWindowStrippingRunTime;
    cutterSeparationRunTimeInfoString = createCutterSeparationRunTimeInfoString (sheetsToSeparate, cutterSeparation.separationSpeed, manualWindowStrippingRunTime)
    cutterSeparationIdleTime = cutterSeparationRunTime * cutterSeparationIdlePercentage; // hours
  // calculate sepration costs
    cutterSeparationSetupCost = cutterSeparationSetupTime * cutterSeparation.SetupTime_CostPerHour;
    cutterSeparationRunCost = cutterSeparationRunTime * cutterSeparation.RunTime_CostPerHour;
    cutterSeparationIdleCost = cutterSeparationIdleTime * cutterSeparation.IdleTime_CostPerHour;
    cutterSeparationTotalCost = cutterSeparationSetupCost + cutterSeparationRunCost + cutterSeparationIdleCost;
  // roundup convert separation costs
    cutterSeparationSetupCost = precise_round(cutterSeparationSetupCost,2);
    cutterSeparationRunCost = precise_round(cutterSeparationRunCost,2);
    cutterSeparationIdleCost = precise_round(cutterSeparationIdleCost,2);
    cutterSeparationTotalCost = precise_round(cutterSeparationTotalCost,2);
  // calculate totalTime and convert data to hours : minutes
    cutterSeparationTotalTime = hoursTohhmm(cutterSeparationSetupTime + cutterSeparationRunTime);// + cutterSeparationIdleTime);
    cutterSeparationSetupTime = hoursTohhmm(cutterSeparationSetupTime);
    cutterSeparationRunTime = hoursTohhmm(cutterSeparationRunTime);
    cutterSeparationIdleTime = hoursTohhmm(cutterSeparationIdleTime);
  // generate info strings
    cutterSeparationSetupInfoString = 'czas narządu * koszt roboczogodziny = ' + cutterSeparationSetupTime + ' * ' + cutterSeparation.SetupTime_CostPerHour;
    //cutterSeparationRunTimeInfoString = 'czas jazdy * koszt roboczogodziny = ' + cutterSeparationRunTime + ' * ' + cutterSeparation.RunTime_CostPerHour;
    cutterSeparationIdleTimeInfoString = 'czas idle * koszt roboczogodziny = ' + cutterSeparationIdleTime + ' * ' + cutterSeparation.IdleTime_CostPerHour;
    cutterSeparationTotalTimeInfoString = '(koszt narzadu + koszt jazdy + koszt idle)  = ' + cutterSeparationSetupCost + ' + ' + cutterSeparationRunCost + ' + ' + cutterSeparationIdleCost;
  // return calculated values as object
    return {
      sepSetupTime: cutterSeparationSetupTime,
      sepRunTime: cutterSeparationRunTime,
      sepIdleTime: cutterSeparationIdleTime,
      sepTotalTime: cutterSeparationTotalTime,
      sepSetupCost: cutterSeparationSetupCost,
      sepRunCost: cutterSeparationRunCost,
      sepIdleCost: cutterSeparationIdleCost,
      sepTotalCost: cutterSeparationTotalCost,
      sepSetupInfo: cutterSeparationSetupInfoString,
      sepRunInfo: cutterSeparationRunTimeInfoString,
      sepIdleInfo: cutterSeparationIdleTimeInfoString,
      sepTotalInfo: cutterSeparationTotalTimeInfoString
    };

}



function calculateManualWindowStrippingRunTime(orderQty,upWindows) {
"use strict"; // to enable sctrict mode in js
/* Input variables
  upsOnSheet - number of ups on sheet to separate - influences separation speed
  upWindows - number of windows on up - influences separation speed
*/
// define variables
  var manualWindowStrippingRunTime;
  var manualWindowStrippingTime = 1/3600; //convert time in seconds to strip one window manually to hours
  // TODO: czy aby na pewno manualWindowStrippingTime powinien byc w sekundach?
// calculate manual window stripping run time
   manualWindowStrippingRunTime = orderQty * upWindows * manualWindowStrippingTime;
// return result
  return manualWindowStrippingRunTime;
}

function showSeparationFields (show, separationID) {
/* function to hide or show separation fields based on the selected dropdown value
show - boolean
separationID - id of selected separation type
*/
"use strict"; // to enable sctrict mode in js
  if (show) {
    $("#separationWindowsStripping").show();
    if (separationID === 3) { // only for automatic separation on TM920
      $("#separationTooling").show(); // show separation tooling type dropdown
    } else {
      $("#separationTooling").hide(); // hide separation tooling type dropdown
      showSeparationToolings(false); // hide other separation tooling fields
      zeroOutSeprationToolings(true); // zeroout all separation tooling fields
      $("#separationToolingCost").trigger("change"); // fire change event to force recalculation
    }
  } else {
    if (separationID === 0) { // if no separation than hide all fields
      $("#separationWindowsStripping").hide();
      $("#separationTooling").hide();
      showSeparationToolings(false); // hide separation tooling section only for TM920
      zeroOutSeprationToolings(true); // zeroout all separation tooling fields
      $("#separationToolingCost").trigger("change"); // fire change event to force recalculation
    } else {  // hide only toolings
      showSeparationToolings(false); // hide separation tooling section only for TM920
      alert ('This condition is not supported. [showSeparationFields(false, separationID <> 0] Contact the administrator.')
    }
  }
}
function zeroOutSeprationToolings (full){
  if(full) {$("#separationToolingTypeDropdown").val(0)}; // zero out combo box
  $("#separationToolingStatusDropdown").val(0); // zero out combo box
  $("#separationToolingCost").val(0); // zero out cost box
  $("#separationToolingInvoicingDropdown").val(0); // zero out combo box
}

function showSeparationToolings (show){
  if (show) {
  //  $("#separationTooling").show(); // show tooling type
    $("#separationToolingStatus").show(); // show tooling status
    $("#separationToolingCosts").show(); // show tooling cost
    $("#separationToolingInvoicing").show(); // show tooling invoicing type
  }
  else {
  //  $("#separationTooling").hide(); // hide tooling type
    $("#separationToolingStatus").hide(); // hide tooling status
    $("#separationToolingCosts").hide(); // hide tooling cost
    $("#separationToolingInvoicing").hide(); // hide tooling invoicing type
  }
}

function zeroOutSeparationFields () {
/* funtion to zero out fields, values and info strings if no separation is selected */
  "use strict"; // to enable sctrict mode in js
  // zero out separation setup times
    $("#separationSetupTime").val(hoursTohhmm(0));
    $("#separationSetupRealCosts").val(precise_round(0,2));
    $("#separationSetupTotalCosts").val(precise_round(0,2));
    $("#separationSetupInfo").val('');
  // zero out separation run times
    $("#separationRunTime").val(hoursTohhmm(0));
    $("#cost_manual_work_jazda_real").val(precise_round(0,2));
    $("#separationRunTotalCosts").val(precise_round(0,2));
    $("#cost_manual_work_jazda_info").val('');
  // zero out separation idle times
    $("#separationIdleTime").val(hoursTohhmm(0));
    $("#cost_manual_work_idle_real").val(precise_round(0,2));
    $("#separationIdleTotalCosts").val(precise_round(0,2));
    $("#cost_manual_work_idle_info").val('');
  // zero out separation total times
    $("#separationTotalTime").val(hoursTohhmm(0));
    $("#cost_manual_work_real").val(precise_round(0,2));
    $("#cost_manual_work").val(precise_round(0,2));
    $("#cost_manual_work_info").val('');
  //zero out separation window stripping radio buttons and values
    $("#separationWindowStrippingYes").prop('checked', false);
    $("#separationWindowStrippingNo").prop('checked', false);
    $("#separationWindowStrippingYes").val('');
    $("#separationWindowStrippingNo").val('');
  // zero out tooling details
    zeroOutSeprationToolings (true);
}

function toolingFieldsVisible (){
  "use strict"; // to enable sctrict mode in js
  // define variables
    var toolingCostVisible;
    var toolingInvoicingVisible;
    var toolingFieldsVisible;
  // check visibility
    toolingCostVisible = $("#separationToolingCosts").is(":visible");
    toolingInvoicingVisible = $("#separationToolingInvoicing").is(":visible");

    if(toolingCostVisible && toolingInvoicingVisible){
        toolingFieldsVisible = true;
    } else{
      toolingFieldsVisible = false;
    }
  return toolingFieldsVisible;
}

