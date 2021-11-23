<?php
	require '../backend/conn.php';
	require '../backend/usersession.php';
?>
<html>
<head>
	<?php include_once"../layout/header.php" ?>
	<script>
		function setInnerHtml(elm,html){
			elm.innerHTML = html;
			Array.from(elm.querySelectorAll("script")).forEach(oldScript => {
				const newScript = document.createElement("script");
				Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
				newScript.appendChild(document.createTextNode(oldScript.innerHTML));
				oldScript.parentNode.replaceChild(newScript, oldScript);
			});
		}
		
		
	</script>
</head>
<body>

<button onclick="runA()">run with 'el.innerHTML = HTML'</button>
<button onclick="runA()">run with 'setInnerHTML(el, HTML)'</button>
<hr>
<div id="divContent">
	replace this
</div>

<div class="card shadow-sm mb-2">
	<div class="card-body">
	
		<form action="" id="formBarang">
		<div class="row">
			<div class="col-sm-9">
				<select name="rak" id="rak" class="btn btn-light border dropdown-toggle m-2 form-select">
					<option value="1" class="dropdown-item">Rak 1</option>
					<option value="2" class="dropdown-item">Rak 2</option>
					<option value="G" class="dropdown-item">Rak G</option>
				</select>
			</div>
			<div class="col-sm d-grid">
				<input class="btn btn-primary mt-2" type="submit" name="butonRak" value="Ganti Rak">
			</div>
		</div>
		</form>
		
		</br>
		
		<div id="divBarang">
		
		</div>
		<div class="btn btn-primary" onclick="modalBarang()">Lihat selengkapnya</div>
		
	</div>
</div>

<div class="modal fade" id="modalbarang">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modalbarangisi">
	
    </div>
  </div>
</div>

<script>
	
	async function modalBarang(x){
		var e = document.getElementById("rak");
		var rak = e.value;
		console.log(rak);
		
		let page = await fetch('../layout/modalbarang.php?rak='+rak);
		let docu = await page.text();
		let tag = document.getElementById("modalbarangisi").innerHTML = docu;
		$('#modalbarang').modal('show').find('.modal-content').tag;
	}
	
	$(async function(){
		let page = await fetch("../layout/halamanBarang.php?rak=1");
		let text = await page.text();
		document.getElementById("divBarang").innerHTML = text;
	});
	
	$(function(){
		$('#formBarang').on("submit", function(e){
			var dataString = $(this).serialize();
				xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("divBarang").innerHTML = xhttp.responseText;
				}
			};
			xhttp.open("GET", "../layout/halamanBarang.php?"+dataString, true);
			xhttp.send();
	
			e.preventDefault();
		});
	});

</script>
</body>
</html>