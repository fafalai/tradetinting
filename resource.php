<?php
  if (!isset($_SERVER['HTTPS']))
  {
    //header('location: https://www.adtalk.services/testtag/contact.php');
    //exit;
  }
  require_once("remedyshared.php");
  require_once("class.phpmailer.php");
  SharedInit();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <?php
    include("meta.php");
  ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    function showDetail(btnid,divbtn)
    {
      var divid = "#" + divbtn;
      var currentImageURL = document.getElementById(btnid).style.backgroundImage;
      //console.log(currentImageURL);
      $(divid).slideToggle(400);
      if (currentImageURL == 'url("plus.png")')
      {
        //console.log("1");
        document.getElementById(btnid).style.backgroundImage = "url('minus.png')";
        plus = false;
      }
      else
      {
        //console.log("2");
        document.getElementById(btnid).style.backgroundImage = "url('plus.png')";
        plus = true;
      }
     
    }
  </script>
  <title>Resources</title>
</head>
<body>
  <?php
    include("top.php");
  ?>
  <hr />
  <div id="resourceDIV" style="margin-top: 20px;padding: 10px 100px">
      <h2 style="font-family: arial;margin-left: 30px;margin-top: 45px;margin-bottom: 20px"> RESOURCES</h2>
      <div id="HM" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
        <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
          <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">Heat Measurement</label>
        </div>
        <div class="col-sm-1">
            <button id="HMbtn" onclick="showDetail('HMbtn','HMContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
            </button>
        </div>
      </div>
      <div id="HMContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
          <p style="padding: 5px"> 
              The most accepted method used to measure heat is British Thermal Units (BTU). BTU is the amount heat necessary to raise the Temperature of one pound of water by one degree Fahrenheit.
              The BTU method can used to calculate energy savings when Air Conditioning and energy rates are reconsolidated. 
          </p>
      </div>
      <div id="UVA" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
          <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
            <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">Ultra Violet light Band (UVA) 320Nm -380Nm </label>
          </div>
          <div class="col-sm-1">
              <button id="UVAbtn" onclick="showDetail('UVAbtn','UVAContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
              </button>
          </div>
      </div>
      <div id="UVAContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
            <p style="padding: 5px"> 
                This light band is responsible for only 3% of solar energy. Ultra Violet light contributes to about 40% of Fade in floors and furnishings.  
                It is also responsible for the cause of various Medical problems such as skin Cancer. All of the UVC (100Nm-260Nm) and most of the UVB (260Nm-320Nm)  
                light bands do not reach earth through the atmosphere.    
             </p>
      </div>
      <div id="VL" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
            <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
              <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">Visible Light Band (VL) 380Nm – 770Nm</label>
            </div>
            <div class="col-sm-1">
                <button id="VLbtn" onclick="showDetail('VLbtn','VLContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
                </button>
            </div>
      </div>
      <div id="VLContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
        <p style="padding: 5px"> 
            This is the only portion of Light Band we see with the eye.  The visible colours are: Violet, Blue, Green, Yellow and Red.                                                               
            This Light Band carries 44% of the Solar Energy.   
          </p>
      </div>
      <div id="IR" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
          <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
            <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">Near Infra Red Light Band  (IR)  700Nm -2400Nm </label>
          </div>
          <div class="col-sm-1">
              <button id="IRbtn" onclick="showDetail('IRbtn','IRContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
              </button>
          </div>
      </div>
      <div id="IRContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
        <p style="padding: 5px"> 
            We do not visually see heat in this Light Band but we do feel it. This light band carries 53% of Solar Energy    
        </p>
      </div>
      <div id="TESR" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
          <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
            <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">Total Solar Energy Rejected (TESR)</label>
          </div>
          <div class="col-sm-1">
              <button id="TESRbtn" onclick="showDetail('TESRbtn','TESRContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
              </button>
          </div>
      </div>
      <div id="TESRContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
        <p style="padding: 5px"> 
            TSER is an important measurement of the window films ability to reject solar heat in the form of Visual Light (44% of heat) and Infrared Light (53% of heat). 
            Clear glass transmits very high levels of both Visual and Infrared Light.  
        </p>
      </div>
      <div id="IRRejection" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
          <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
            <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">
                IR Rejection 
            </label>
          </div>
          <div class="col-sm-1">
              <button id="IRRejectionbtn" onclick="showDetail('IRRejectionbtn','IRRejectionContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
              </button>
          </div>
      </div>
      <div id="IRRejectionContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
        <p style="padding: 5px"> 
            There is a great deal of work being done in the industry with IR Films, also known as Spectrally Selective films.  
            As the Infra Red Light Band carries 55% of solar energy, Films targeting that specific Light Bands and becoming readily available .  
            Some very light VLT films can have high heat rejection.  The IR rejection is a percentage of the IR Solar Energy rejected by the film, 
            however it is important to consider that it is the percentage of the 55% of the total Solar Energy carried in the Infra Red Light Band. 
            <br/> 
            (SIRR) Selective Infra Red Rejection  is the percentage of IR radiation that is not directly transmitted through a glazing system.
            <br/>
            (IRER) Infra Red Energy Rejection is the percentage of Near Infrared Energy Rejection as measured between 780-2500nm.             
        </p>
      </div>
      <div id="VLT" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
          <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
            <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">
                Visual Light Transmittance (VLT) 
            </label>
          </div>
          <div class="col-sm-1">
              <button id="VLTbtn" onclick="showDetail('VLTbtn','VLTContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
              </button>
          </div>
      </div>
      <div id="VLTContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
        <p style="padding: 5px"> 
            The percentage of light (380nm -800nm) that is transmitted through the window film when installed.  
            Clear glass generally has a VLT of about 89% prior to installing any window film  
        </p>
      </div>
      <div id="SC" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
          <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
            <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">
                Shading Coefficient (SC) 
            </label>
          </div>
          <div class="col-sm-1">
              <button id="SCbtn" onclick="showDetail('SCbtn','SCContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
              </button>
          </div>
      </div>
      <div id="SCContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
        <p style="padding: 5px"> 
            Shading Coefficient is the measure of the performance  of the entire glazing system to control solar energy.  
            The lower the heat gain, the better performance from the glazing system and hence the lower Shading Coefficient number.  
        </p>
      </div>
      <div id="SHGC" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
          <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
            <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">
                Solar Heat Gain Coefficient (SHGC)
            </label>
          </div>
          <div class="col-sm-1">
              <button id="SHGCbtn" onclick="showDetail('SHGCbtn','SHGCContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
              </button>
          </div>
      </div>
      <div id="SHGCContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
        <p style="padding: 5px"> 
            Is the measure of solar energy that is absorbed and transmitted directly in to the room through the glass.   
            The lower the number the better efficiency and performance.    
        </p>
      </div>
      <div id="Efactor" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
          <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
            <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">
                Emissivity (E factor) 
            </label>
          </div>
          <div class="col-sm-1">
              <button id="Efactorbtn" onclick="showDetail('Efactorbtn','EfactorContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
              </button>
          </div>
      </div>
      <div id="EfactorContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
        <p style="padding: 5px"> 
            Low E films are greatly beneficial to cold climate areas.  Emissivity is the products ability to reflect radiant heat back in the direction of the source.     
            For example, if you are heating a room, a Low E window film will direct a higher portion of heat back into the room than other window films.                           
             The lower the emissivity number the better its ability.  
        </p>
      </div>
      <div id="GR" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
          <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
            <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">
                Glare Reduction 
            </label>
          </div>
          <div class="col-sm-1">
              <button id="GRbtn" onclick="showDetail('GRbtn','GRContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
              </button>
          </div>
      </div>
      <div id="GRContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
        <p style="padding: 5px"> 
            Glare is best known as bright light.  It can enter rooms more so in the colder months when the sun is lower in the sky.  
            It can reduce the ability to see clearly.  
            Window film can significantly reduce Glare. 
        </p>
      </div>
      <div id="UVR" class="row" style="display: table;background-color: lightgrey;height: 30px;margin-left: 50px;margin-right: 50px;border:1px solid grey">
          <div class="col-sm-11" style="display: table-cell; vertical-align:-webkit-baseline-middle;">
            <label style="font-family: Arial, Helvetica, sans-serif;vertical-align: baseline;font-size: 14pt;text-align: center;vertical-align: middle">
                Ultra Violet Rejection
            </label>
          </div>
          <div class="col-sm-1">
              <button id="UVRbtn" onclick="showDetail('UVRbtn','UVRContent')" class="button" style="margin-right: 0px;border:none;background: none;vertical-align: baseline;cursor: pointer;background-image: url('plus.png');height: 30px;width: 30px">
              </button>
          </div>
      </div>
      <div id="UVRContent" class="row" style="display:none;margin-left: 50px;margin-right: 50px;border:1px solid lightgray">
        <p style="padding: 5px"> 
            UVA is the major contributor to fade and Skin Cancers.  
            Nearly all window film have almost 100% UV block and it is required to prolong the life of the film.  
        </p>
      </div>    
  </div> 
</body>
</html>
