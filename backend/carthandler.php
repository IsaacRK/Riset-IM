<?php
$uid = $_SESSION['uid'];
$cartQuery = "select *  from cart where user_id = $uid and checkout = false";
$cartQueryRun = mysqli_query($servConnQuery,$cartQuery);
$x=1;
if(mysqli_num_rows($cartQueryRun) > 0){
	echo'
	<form action="" method="post" id="formCart">
	<div class="row m-1">
	';
	
	while($cartFetch = mysqli_fetch_assoc($cartQueryRun)){
		$cartTakeAmount	= $cartFetch['take_amount'];
		$cartNecesity	= $cartFetch['necessity'];
		$stockId		= $cartFetch['stock_id'];
		$cartId			= $cartFetch['cart_id'];

		$stockFindQuery	= "select stock_name from stock where stock_id = '$stockId'";
		$stockFindQueryRun = mysqli_query($servConnQuery,$stockFindQuery);
		$stockNameFetch = mysqli_fetch_assoc($stockFindQueryRun);
		$stockName		= $stockNameFetch['stock_name'];
		
		$maxQuery		= "select amount from stock where stock_id = $stockId";
		$maxRun			= mysqli_query($servConnQuery, $maxQuery);
		$maxFetch		= mysqli_fetch_assoc($maxRun);
		$max			= $maxFetch['amount'];
		
		?>
			<div class="col-2">
				<label class="checkbox">
				  <span class="checkbox_input">
					<input class="boxhidden" type="checkbox" name="checkbox[]" value="<?php echo$cartId;?>"/>
					<span class="checkbox_control">
					  <svg
						viewBox="0 0 24 24"
						aria-hidden="true"
						focusable="false"
					  >
						<path
						  fill="none"
						  stroke="currentColor"
						  stroke-width="3"
						  d="M1.73 12.91l6.37 6.37L22.79 4.59"
						/>
					  </svg>
					</span>
				  </span>
				</label>
			</div>
			<div class="col-10">
				<div class="row">
					<div class="col-10">
						<span><b><?php echo$stockName;?></b></span></br>
						<span><b><?php echo$cartNecesity;?></b></span></br>
					</div>
					<div class="col-2">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" onclick="edit('<?php echo$cartId;?>')" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
						  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
						  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
						</svg>
					</div>
				</div>
				
				<div class="row">
					<div class="col">
						<div class="input-group">
							<div class="row m-0 p-0">
								<div class="col-auto m-0 p-0">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-number mx-0 px-0" data-type="minus" data-field="quant[<?php echo$cartId;?>]">
										<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-dash-square" viewBox="0 0 16 16">
										  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
										  <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
										</svg>
									</button>
								</span>
								</div>
								
								<div class="col-3 mt-1 p-0">
									<input type="text" name="quant[<?php echo$cartId;?>]" class="form-control input-number" value="<?php echo$cartTakeAmount;?>" min="1" max="<?php echo$max;?>">
								</div>
								
								<div class="col-auto m-0 p-0">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-number mx-0 px-0" data-type="plus" data-field="quant[<?php echo$cartId;?>]">
										<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
										  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
										  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
										</svg>
									</button>
								</span>
								</div>
								<div class="col-auto">
									<span class="mt-1">dari <?php echo$max;?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr></hr>
			<script>
			$(document).ready(function(){
				$("#formCart").on("submit", function(e){
					var dataString = $(this).serialize();
					alert(dataString);
					
					e.preventDefault();
				});
			});
			</script>
		<?php
		$x++;
	}
	echo'
	</div>

	<div class="row mt-2">
		<div class="col-6 mx-auto">
			<input class="btn btn-primary btn-block" type="submit" name="checkout" value="Checkout"/>
		</div>
	</div>
	</form>
	';
}else{
	echo'
		<div class="p-2 d-flex flex-fill bg-light justify-content-center p-2 text-justify">
			Keranjang belum terisi
		</div>
	';
}
?>
<script>
$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    let input = $("input[name='"+fieldName+"']");
    let currentVal = parseInt(input.val());
	let editCartUrl = "backend/editjumlahcart.php";
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
				let amn = toString(currentVal-1);
				input.value = amn;
				
				//string split - ambil id dari nama quant[id] -> id
				let a = fieldName.substr(fieldName.indexOf('[')+1);
				let b = a.split("]")[0];
				$.post(editCartUrl,{
					cartId: b,
					newVal: currentVal - 1
				});
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
				let amn = toString(currentVal+1);
				input.value = amn;
				
				//string split - ambil id dari nama quant[id] -> id
				let a = fieldName.substr(fieldName.indexOf('[')+1);
				let b = a.split("]")[0];
				$.post(editCartUrl,{
					cartId: b,
					newVal: currentVal + 1
				});
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function(){
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Jumlah Minimal Telah Tercapai');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Jumlah Maksimal Telah Tercapai');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
         // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) || 
         // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
</script>