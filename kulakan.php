<head>
<?php include'layout/header.php';?>
<style>
.tbl-content{
    height:300px;
  overflow-x:auto;
}  
</style>
</head>
<div class="row">
<div class="col-3">
    <div class="card">
        <form>
            <div class="mb-3">
                <label for="exampleInputNamaKomponen" class="form-label">Nama Komponen</label>
                <input type="NamaKomponen" class="form-control" id="exampleInputNamaKomponen">
                
            </div>
            <div class="mb-3">
                <label for="exampleInputLinkPembelian" class="form-label">Link Pembelian</label>
                <input type="LinkPembelian" class="form-control" id="exampleInputLinkPembelian">
            </div>
            <div class="mb-3">
                <label for="exampleInputHargaBeli" class="form-label">Harga Beli</label>
                <input type="HargaBeli" class="form-control" id="exampleInputHargaBeli">
            </div>
            <div class="mb-3">
                <label for="exampleInputJumlah" class="form-label">Jumlah</label>
                <input type="Jumlah" class="form-control" id="exampleInputJumlah">
            </div>
            <div class="mb-3">
                <label for="exampleInputHargaTotal" class="form-label">Harga Total</label>
                <input type="HargaTotal" class="form-control" id="exampleInputHargaTotal">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<div class="col-9">
<div class="card">

<div class="card-body" >
<div class="tbl-content">
<table class="table table-striped table-sm" id="tbBarang">
<thead> 
<tr>
    <th>NO</th>
    <th>Nama Komponen</th>
    <th>Link Pembelian</th>
    <th>Harga Beli</th>
    <th>Jumlah</th>
    <th>Harga Total</th>
</tr>
</thead>
<tbody>
  <tr>
    <td>1</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>
<tr>
    <td>2</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>
<tr>
    <td>3</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>
<tr>
    <td>4</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>
<tr>
    <td>5</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>
<tr>
    <td>6</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>
<tr>
    <td>7</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>
<tr>
    <td>8</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>
<tr>
    <td>9</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>
<tr>
    <td>10</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>
<tr>
    <td>11</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>
<tr>
    <td>12</td>
    <td>Kapasitor</td>
    <td><a href="https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824">https://shopee.co.id/WISONDA-Farad-Kapasitor-Super-2.7V-500F-35-*-60mm-Super-Kapasitor-i.155543404.2615173824</a></td>
    <td>3000</td>
    <td>3</td>
    <td>9000</td>
</tr>   

<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
</tbody>
</table>

</div>
</div>
</div>
</div>

</div>

