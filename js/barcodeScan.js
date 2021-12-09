let selectedDeviceId = null;
const codeReader = new ZXing.BrowserMultiFormatReader();
const sourceSelect = $("#pilihKamera");

$(document).on('change','#pilihKamera',function(){
    selectedDeviceId = $(this).val();
    if(codeReader){
        codeReader.reset()
        initScanner()
    }
})

function initScanner() {
    codeReader
    .listVideoInputDevices()
    .then(videoInputDevices => {
        videoInputDevices.forEach(device =>
            console.log(`${device.label}, ${device.deviceId}`)
        );

        if(videoInputDevices.length > 0){
             
            if(selectedDeviceId == null){
                if(videoInputDevices.length > 1){
                    selectedDeviceId = videoInputDevices[1].deviceId
                } else {
                    selectedDeviceId = videoInputDevices[0].deviceId
                }
            }
             
             
            if (videoInputDevices.length >= 1) {
                sourceSelect.html('');
                videoInputDevices.forEach((element) => {
                    const sourceOption = document.createElement('option')
                    sourceOption.text = element.label
                    sourceOption.value = element.deviceId
                    if(element.deviceId == selectedDeviceId){
                        sourceOption.selected = 'selected';
                    }
                    sourceSelect.append(sourceOption)
                })
         
            }

            codeReader
                .decodeOnceFromVideoDevice(selectedDeviceId, 'video')
                .then(result => {

                        //hasil scan
                        console.log(result.text)
                        $("#hasilscan").val(result.text);
						window.location.assign("stockoutput.php?barcode="+target);
                     
                        if(codeReader){
                            codeReader.reset()
                        }
                })
                .catch(err => console.error(err));
             
        } else {
            alert("Camera not found!")
        }
    })
    .catch(err => console.error(err));
}


if (navigator.mediaDevices) {
     

    initScanner()
     

} else {
    alert('Cannot access camera.');
}
