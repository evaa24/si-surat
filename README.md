##  STMIK Bandung Boilerplate Web Application

Setelah mengunduh project ini lakukan beberapa langkah di bawah agar dapat digunakan. Pastikan perangkat telah terpasang PHP versi 8 atau lebih dan juga terpasang Composer.

Cara penggunaan jika proyek dijalankan menggunakan XAMPP:
- Buka terminal dan arahkan ke path direktori proyek berada.
- Jalankan perintah `composer install` dan tunggu hingga selesai.
- Jalankan perintah `cp .env.example .env` atau copy semua isi yang ada didalam file **.env.example** ke file baru bernama **.env**. Perlu diperhatikan bahwa file **.env** berada pada level yang sama dengan **.env.example**.
- Pada terminal, jalankan perintah `php artisan key:generate`.
- Buka file **.env**, isikan berberapa variabel berikut:
	- *APP_URL* dengan http://localhost:8000/.
	- *API_BASE_URL* dengan alamat API SIMAK STMIK Bandung.
	- *LOGIN_BASE_URL* dengan alamat single login page STMIK Bandung.
- Jangan lupa untuk save perubahan di file **.env**.
- Terakhir, pada terminal jalankan perintah `php artisan serve`.
