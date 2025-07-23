### 📄 `README.md` untuk BarberSentralizon

# 💈 BarberSentralizon

BarberSentralizon adalah aplikasi manajemen barbershop modern berbasis web yang dibuat dengan Laravel dan Blade template. Proyek ini mendukung dua jenis role pengguna (Admin & Barberman), memungkinkan pengelolaan booking, layanan, serta manajemen operasional harian dengan dashboard interaktif.

## 🖼️ Screenshot Antarmuka

<table>
  <tr>
    <td colspan="2" align="center">
      <img src="img/booking.png" width="800"/><br/>
      <strong>Booking User</strong>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="img/img.png" width="400"/><br/>
      <strong>Dashboard</strong>
    </td>
    <td align="center">
      <img src="img/img-admin-1.png" width="400"/><br/>
      <strong>Dashboard Admin</strong>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="img/img-admin-2.png" width="400"/><br/>
      <strong>Daftar Booking</strong>
    </td>
    <td align="center">
      <img src="img/img-admin-3.png" width="400"/><br/>
      <strong>Layanan</strong>
    </td>
  </tr>
</table>


---

## 🚀 Fitur Utama

### 👑 Admin
- Manajemen Booking
- Manajemen Layanan
- Manajemen Barberman
- Dashboard Interaktif dengan grafik (Chart.js)
- Melihat data transaksi & keuntungan

### 💈 Barberman
- Melihat daftar booking dari pelanggan yang memilihnya
- Mengatur status booking (Pending, In Progress, Selesai)
- Tidak memiliki akses ke data sensitif

### 🔐 Autentikasi & Role
- Sistem login dengan middleware guard untuk membedakan akses
- Factory untuk user Barberman
- Seeder default untuk admin

---

## ⚙️ Teknologi yang Digunakan

- **Laravel 12**
- **Blade Template**
- **Tailwind CSS**
- **Font Awesome**
- **Chart.js**
- **MySQL**
- **Laravel Seeder & Factory**

---

## 🛠️ Instalasi

Pastikan Anda sudah menginstal PHP >= 8.2, Composer, Node.js, dan MySQL.

```bash
git clone https://github.com/namamu/barbersentralizon.git
cd barbersentralizon

# Install dependency
composer install
npm install && npm run build

# Buat file .env dan sesuaikan database
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate --seed
````

📌 Seeder akan otomatis membuat data layanan, barber, dan admin login.

---

## 🔑 Login Awal

| Role   | Email                                         | Password |
| ------ | --------------------------------------------- | -------- |
| Admin  | [admin@example.com](mailto:admin@example.com) | password |
| Barber | (acak oleh factory)                           | password |

Barberman dibuat secara otomatis oleh `UserFactory` dan memiliki role `barber`.

---

## 📊 Dashboard & UI

Aplikasi ini menggunakan **Chart.js** untuk menyajikan data booking dan pendapatan dalam bentuk grafik. Desain dibuat dengan **Tailwind CSS** agar responsif dan modern. Font Awesome digunakan untuk mempercantik ikon navigasi.

---

## 📁 Struktur Utama

```
├── app/
├── database/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   └── barber/
├── routes/
│   └── web.php
├── public/
│   └── img/
│       └── img1.png
```

---

## 🤝 Kontribusi

Silakan fork repo ini dan kirimkan pull request jika ingin berkontribusi. Project ini masih dikembangkan lebih lanjut untuk menambahkan:

* Laporan PDF
* Notifikasi Email ke customer
* Penjadwalan shift barber

---

## 📬 Lisensi

Project ini open source di bawah lisensi MIT.

---

© 2025 BarberSentralizon – Made with ❤️ using Laravel & Tailwind

```

---

Kalau kamu ingin, gw bisa juga bantu:

- Auto-generate `UserFactory` dengan contoh nama-nama barber
- Buat ERD visual-nya dalam bentuk gambar
- Tambahkan fitur rating/review pelanggan untuk barber

Mau dilanjut ke mana dulu?
```
