var selectedDeviceId;
var codeReader;

window.addEventListener('load', function () {
       codeReader = new ZXing.BrowserMultiFormatReader();
      console.log('ZXing code reader initialized');
      codeReader.listVideoInputDevices()
        .then((videoInputDevices) => {
          selectedDeviceId = videoInputDevices[1].deviceId;
         // barcodeScanning();
        })
        .catch((err) => {
          console.error(err)
        })
    });
 
 function barcodeScanning(){
	 codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (result, err) => {
         if (result) {
           console.log(result)
           document.getElementById('__result').textContent = result.text;
           $(".barcode__result").show();
		   
		   document.getElementById('btnSendBRData').style.visibility = "visible";
						
			var target = document.getElementById('__result').innerHTML
			//location.href = window.location.href+"?barcode="+target;
			//location.href = "stockoutput.php?barcode="+target;
			 window.location.assign("stockoutput.php?barcode="+target)
		   
		   
		   /*
		   $.post('stockoutput.php',{
			   console.log(document.getElementById('__result').innerHTML),
			   barcode: document.getElementById('__result').innerHTML
		   })
		   */
		   //console.log(document.getElementById('__result').innerHTML)
         }
         if (err && !(err instanceof ZXing.NotFoundException)) {
           console.error(err)
           document.getElementById('__result').textContent = err;
          
         }
       })
       console.log("Started continous decode from camera with id ",selectedDeviceId);
 }
 
 function resetScanning(){
	 codeReader.reset()
     document.getElementById('__result').textContent = '';
     $(".barcode__result").hide();
     $("#startScan").removeClass("__disable");
     $(".__startScan").attr("id","startScan");

     console.log('Reset Scan.......')
     barcodeScanning();
 }


 
 $(document).ready(function(){
	 
	 $(document).on('click','#resetScan',function(){
		 resetScanning();
	 });

	 $(document).on("click","#closeResult", function() { 
		 $(".barcode__result").hide();
		 $(".__result").text("");
		 resetScanning();
	 });
	 
	 $(document).on('click','#startScan',function(){
	 	$(".info__2").hide();
	 	$(".diode").show();
		$("#video").show();
		$(".__result").text("");
		
		$("#startScan").addClass("__disable");
		$(".__startScan").removeAttr("id");

		barcodeScanning();
	 });
	 
 });