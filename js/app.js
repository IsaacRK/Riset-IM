var deferredPrompt;
var fired = false;
var appInstalled = false;


if ('serviceWorker' in navigator) {
  navigator.serviceWorker
    //.register('/gstc/sw.js',{scope:"/gstc/"})
    .register('https://skslate.com/custom-html/pwa/sk_qr_barcode_scanner/sw.js',{scope:"https://skslate.com/custom-html/pwa/sk_qr_barcode_scanner/"})
    .then(function() {
      console.log('Service worker registered!'); 
    });
}

window.addEventListener('beforeinstallprompt', function(event) {
  console.log('beforeinstallprompt fired');
  event.preventDefault();
  deferredPrompt = event;
//  return false;
  
  // Update UI notify the user they can install the PWA
  if(!appInstalled){
	  showInstallBanner();
  }
  
});
 

/*if (window.matchMedia('(display-mode: standalone)').matches) {  
    alert("app installed already....");
}   
*/
//To Install App
document.getElementById("installApp").addEventListener('click',function(){
	promtAddToHomeScreen();
});

//Not Now
document.getElementById("notNow").addEventListener('click',function(){
	hideInstallBanner();
});

window.addEventListener('appinstalled', function(event){ 
	  console.log('App installed'); 
	  appInstalled = true;
	  hideInstallBanner();
	  
});


function showInstallBanner(){
	$(".appInstallBanner").show();
}

function hideInstallBanner(){
	$(".appInstallBanner").hide();
}

function promtAddToHomeScreen(){
	 if (deferredPrompt) {
		 hideInstallBanner();
		 deferredPrompt.prompt();
		 deferredPrompt.userChoice.then(function (choiceResult) {
			 console.log(choiceResult.outcome);
		      if (choiceResult.outcome === 'dismissed') {
		        console.log('User cancelled installation');
		        appInstalled = false;
		      }else if (choiceResult.outcome === 'accepted') {
		    	  console.log('User added to home screen');
		    	  appInstalled = true;
		    	  $(".thanksBanner").show(); 
		    	 /* setTimeout(function(){
		    		  $(".thanksBanner").hide();
		    	  },1000);*/
		    	  
		      } else {
		        console.log('No Action');
		        appInstalled = false;
		      }
	    });

	    deferredPrompt = null;
	  }
}

