<?php?>

<script>
	document.getElementById("openMenu").onclick = function() {buttonSidebarShow()};
	document.getElementById("closeMenu").onclick = function() {sidebarHide()};

	function buttonSidebarShow(){
		var x = document.getElementById("sidebar");
		x.style.display = "block";
		
		var x = document.getElementById("closeMenu");
		x.style.display = "block";
		
		var x = document.getElementById("openMenu");
		x.style.display = "none";
	}
	
	function sidebarHide(){
		var x = document.getElementById("sidebar");
		x.style.display = "none";
		
		var x = document.getElementById("closeMenu");
		x.style.display = "none";
		
		var x = document.getElementById("openMenu");
		x.style.display = "block";
	}
</script>