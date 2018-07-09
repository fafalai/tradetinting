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
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous"> -->
        <?php include("meta.php");?>

        <title>Resources</title>
    </head>

    <body>
        <?php include("top.php");?>
        <hr />
        <div class="container" style="width:70%">
            <label>
                <?php echo date("l, F j, Y"); ?>
            </label>
            <h2 class="clientTitle mb-2">RESOURCES</h2>
            <div id="DIV_resource">
                <div class="easyui-accordion" style="width:100%;align-self: center;">
                    <div title="Heat Measurement" style="padding:10px;overflow:auto;" selected>
                        <p style="line-height:1.15;">
                            The most accepted method used to measure heat is British Thermal Units (BTU). BTU is the amount heat necessary to raise the
                            Temperature of one pound of water by one degree Fahrenheit. The BTU method can used to calculate
                            energy savings when Air Conditioning and energy rates are reconsolidated.
                        </p>
                    </div>
                    <div title="Ultra Violet light Band (UVA) 320Nm - 380Nm" style="padding:10px">
                        <p style="line-height:1.15;">
                            This light band is responsible for only 3% of solar energy. Ultra Violet light contributes to about 40% of Fade in floors
                            and furnishings. It is also responsible for the cause of various Medical problems such as skin
                            Cancer. All of the UVC (100Nm-260Nm) and most of the UVB (260Nm-320Nm) light bands do not reach
                            earth through the atmosphere.
                        </p>
                    </div>
                    <div title="Visible Light Band (VL) 380Nm - 770Nm" style="padding:10px;">
                        <p style="line-height:1.15;">
                            This is the only portion of Light Band we see with the eye. The visible colours are: Violet, Blue, Green, Yellow and Red.
                            This Light Band carries 44% of the Solar Energy.
                        </p>
                    </div>
                    <div title="Near Infra Red Light Band  (IR)  700Nm - 2400Nm" style="padding:10px;">
                        <p style="line-height:1.15;">
                            We do not visually see heat in this Light Band but we do feel it. This light band carries 53% of Solar Energy
                        </p>
                    </div>
                    <div title="Total Solar Energy Rejected (TSER)" style="padding:10px;">
                        <p style="line-height:1.15;">
                            TSER is an important measurement of the window films ability to reject solar heat in the form of Visual Light (44% of heat)
                            and Infrared Light (53% of heat). Clear glass transmits very high levels of both Visual and Infrared
                            Light.
                        </p>
                    </div>
                    <div title="IR Rejection" style="padding:10px;">
                        <p style="line-height:1.15;">
                            There is a great deal of work being done in the industry with IR Films, also known as Spectrally Selective films. As the
                            Infra Red Light Band carries 55% of solar energy, Films targeting that specific Light Bands and
                            becoming readily available . Some very light VLT films can have high heat rejection. The IR rejection
                            is a percentage of the IR Solar Energy rejected by the film, however it is important to consider
                            that it is the percentage of the 55% of the total Solar Energy carried in the Infra Red Light
                            Band. (SIRR) Selective Infra Red Rejection is the percentage of IR radiation that is not directly
                            transmitted through a glazing system. (IRER) Infra Red Energy Rejection is the percentage of
                            Near Infrared Energy Rejection as measured between 780-2500nm.
                        </p>
                    </div>
                    <div title="Visual Light Transmittance (VLT)" style="padding:10px;">
                        <p style="line-height:1.15;">
                            The percentage of light (380nm -800nm) that is transmitted through the window film when installed. Clear glass generally
                            has a VLT of about 89% prior to installing any window film
                        </p>
                    </div>
                    <div title="Shading Coefficient (SC)" style="padding:10px;">
                        <p style="line-height:1.15;">
                            Shading Coefficient is the measure of the performance of the entire glazing system to control solar energy. The lower the
                            heat gain, the better performance from the glazing system and hence the lower Shading Coefficient
                            number.
                        </p>
                    </div>
                    <div title="Solar Heat Gain Coefficient (SHGC)" style="padding:10px;">
                        <p style="line-height:1.15;">
                            Is the measure of solar energy that is absorbed and transmitted directly in to the room through the glass. The lower the
                            number the better efficiency and performance.
                        </p>
                    </div>
                    <div title="Emissivity (E factor)" style="padding:10px;">
                        <p style="line-height:1.15">
                            Low E films are greatly beneficial to cold climate areas. Emissivity is the products ability to reflect radiant heat back
                            in the direction of the source. For example, if you are heating a room, a Low E window film will
                            direct a higher portion of heat back into the room than other window films. The lower the emissivity
                            number the better its ability.
                        </p>
                    </div>
                    <div title="Glare Reduction" style="padding:10px;">
                        <p style="line-height:1.15;">
                            Glare is best known as bright light. It can enter rooms more so in the colder months when the sun is lower in the sky. It
                            can reduce the ability to see clearly. Window film can significantly reduce Glare.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>