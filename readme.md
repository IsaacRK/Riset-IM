# Instalasi
#### Download
1. Download file dengan menekan tombol "Download ZIP" pada repository Riset IM https://github.com/IsaacRK/Riset-IM
![[download1.PNG]]
2. Ekstrak folder dari file ZIP pada:
	- Untuk Pengguna XAMPP
		1. buka folder C: \ xampp \ htdocs
		2. ekstrak folder Riset-IM-main di dalam folder htdocs
	- Untuk Pengguna WAMPP
		1. buka folder C: \ wamp64 \ www
		2. ekstrak folder Riset-IM-main di dalam folder www

#### Pembuatan & Pemasangan Databse
1. Buka admin database anda.
2. Buat Database baru.
3. Pilih database yang telah di buat.
4. Import tabel ke databse dengan file "dataTabel.sql" pada folder Dokumentasi.
5. Ubah koneksi kepada database pada file conn.php pada folder backend.
	- Ubah $server dengan server anda.
	- Ubah $userNM dengan useraname server database anda.
	- Ubah $pass dengan password server database anda.
	- Ubah $database dengan nama database yang telah anda buat pada langkan no3.

#### Cara penggunaan
1. kunjungi halaman pada browser.
2. Jika sudah memiliki akun ketik nama pengguna dan kata sandi di sebelah kanan atas lalu tekan Masuk.
	![[loginInput.png]]
3. Jika belum memiliki akun daftar pada form registrasi yang dengan menuliskan nama, email, kata sandi, dan chapta lalu tekan daftar.
	![[Dokumentasi/readme/registrasi.png]]
4. Pada halaman pengaturan foto profil upload file dengan ekstensi PNG atau JPG yang diinginkan sebagai foto profil, jika ingin tidak mengisi foto dapat langsung melewati halaman tersebut.
	![[ikonAkun.png]]
5. Kemudian email verifikasi akan terkirim dan dapat dilihat dalam email.
	![[emailConfirm.png]]
6. Setelah verifikasi atau masuk akan terbuka halaman beranda.
7. Pada halaman beranda terdapat beberapa data yang ditampilkan meliputi pemetaan dari komponen, Riwayat aktivitas dalam 7 hari terakhir, serta jumlah stok dari masing-masing barang yang disimpan pada aplikasi. Pada halaman ini juga terdapat fitur unduh laporan yang berfungsi untuk mengunduh data aktifitas 30 hari terakhir dan barang barang pada penyimpanan.
	![[aktivitasBarang.png]]
8. Pada menu stok masuk untuk memasukan barang langkah awal yang perlu dilakukan adalah mengisi nama barang dan tekan cek.
	![[inputBarang.png]]
9. Apabila nama barang yang tertulis belum terdaftar pada database, maka barang tersebut akan dianggap sebagai barang baru.
10. Apabila barang tersebut sudah terdaftar pada database, maka operasi yang dapat dilakukan adalah pembaruan stok tanpa dapat mengubah kategori dari barang tersebut.
11. Langkah selanjutnya yaitu mengisi mengisi kategori & jumlah.
12. Kemudian menentukan lokasi penyimpanan seperti rak, lantai, kolom, dan baris dan klik masukan.
13. Lalu akan keluar informasi barang yang akan dimasukan beserta barcode.
	![[barcode.png]]
14. Barcode dapat dicetak dan ditempel di wadah komponen yang akan disimpan.
15. Pada menu stok keluar untuk mengambil barang yaitu bisa dengan memasukan nama barang dalam kolom pencarian atau memindai barcode yang tertera di wadah.
	![[pengambilan.png]]
16. Lalu isi jumlah dan keperluan, kemudian tambahkan ke keranjang.
17. Ketika masih ingin menambahkan barang dapat mengulangi metode yang sama.
18. Pada tombol edit dalam keranjang berfungsi untuk mengganti jumlah dan keperluan. Tombol hapus berfungsi untuk menghapus barang dari keranjang.
	![[keranjang.png]]
19. Hal yang terakhir dilakukan yitu click centang pada checkbox dan checkout maka data otomatis akan berkurang.
20. Setelah semua selesai klik logout pada untuk keluar dari aplikasi.
	![[keranjang.png]]
