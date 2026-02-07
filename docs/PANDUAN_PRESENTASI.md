# 🎙️ Panduan Naskah & Strategi Presentasi SIPETA

Dokumen ini dirancang untuk membantumu menjelaskan setiap slide dengan alur yang **profesional, ringkas, namun berbobot**.

---

## 1. Pembukaan & Cover

**Tujuan:** Memberikan kesan pertama yang meyakinkan.
**Naskah Ringkas:**

> "Assalamualaikum wr. wb. Selamat pagi/siang. Pada kesempatan ini, saya akan mempresentasikan **SIPETA (Sistem Informasi Penjualan Tanaman)**, sebuah platform _e-commerce_ berbasis web yang saya kembangkan untuk menjembatani petani lokal dengan pasar digital modern melalui transaksi yang transparan dan efisien."

---

## 2. Latar Belakang

**Tujuan:** Validasi masalah ("Why"). Fokus pada _gap_ antara petani dan teknologi.
**Poin Kunci:**

- Petani sering rugi karena rantai distribusi panjang.
- Konsumen sulit cari produk segar yang terpercaya.
- **Kunci:** "SIPETA hadir untuk memotong _middle-man_ tersebut."

---

## 3. Tujuan

**Tujuan:** Menunjukkan visi jangka panjang.
**Cara Menjelaskan:** Jangan baca poin per poin secara kaku. Rangkai jadi cerita.

> "Tujuan utama sistem ini bukan hanya sekedar jualan online, melainkan untuk **demokratisasi akses pasar**. Kami ingin petani mendapatkan harga adil, dan konsumen mendapatkan kualitas terbaik. Ini juga langkah awal modernisasi pertanian lokal kita."

---

## 4. Batasan Masalah (Sesuai Request)

**Tantangan:** Seringkali slide ini dibaca membosankan.
**Strategi:** Gunakan _framing_ "Fokus Pengembangan".
**Cara Menjelaskan:**

> "Agar pengembangan sistem ini tetap **terarah dan optimal** dalam jangka waktu pengerjaan yang ada, kami menetapkan beberapa batasan lingkup kerja (Scope):
>
> 1.  **Dari sisi Produk**: Kami spesifik hanya pada produk agrikultur, tidak tercampur barang umum, agar fitur bisa disesuaikan dengan karakteristik barang segar (seperti _shelf-life_ dan panen).
> 2.  **Platform**: Fokus saat ini adalah **Web-based** yang responsif. Mengapa web? Agar mudah diakses baik dari HP maupun Laptop tanpa perlu instalasi aplikasi berat.
> 3.  **Wilayah**: Cakupan pengiriman masih menggunakan ekspedisi standar nasional di Indonesia."

_(Tips: Jelaskan "Kenapa" di balik batasan itu, agar terlihat sebagai keputusan strategis, bukan ketidakmampuan)._

---

## 5. Kelebihan Project

**Tujuan:** "Selling Point". Kenapa SIPETA beda dari yang lain?
**Highlight:**

> "Yang membedakan SIPETA adalah fitur **Multi-Unit Pricing** karena kami, petani tidak cuma jual per-pcs, tapi bisa per-ikat atau per-kg. Ditambah dengan integrasi **Midtrans** dan **Cloudinary**, sistem ini sudah setara dengan standar industri modern."

---

## 6. Tools & Teknologi

**Strategi:** Tunjukkan bahwa Anda _up-to-date_.

> "Untuk arsitektur teknis, di sisi Backend saya menggunakan **Laravel 12** yang powerful. Di Frontend, saya mengkombinasikan **Blade** dengan **Vite** untuk performa _loading_ super cepat, serta **Tailwind/Bootstrap** untuk UI yang responsif. Database menggunakan MySQL."

---

## 7. Use Case Diagram (Detail & Simulasi)

**Strategi Penjelasan:** Jangan baca daftar use case. Ceritakan **Skenario/Alur** dan **Peran Aktor**.

**Naskah Simulasi:**

> "Diagram ini memvisualisasikan interaksi 3 Aktor dalam sistem SIPETA:
>
> 1.  **Guest (Pengunjung)**:
>     - Ini adalah user yang belum login. Hak aksesnya terbatas hanya untuk **Browse Products**, **Search**, dan melihat **Farmer Profile**.
>     - Jika tertarik membeli, mereka harus masuk ke use case **Register**.
> 2.  **Customer (Pelanggan)**:
>     - Perhatikan garis panah dari Customer ke Guest. Ini adalah **Inheritance** (Pewarisan), artinya Customer BISA melakukan semua yang dilakukan Guest, DITAMBAH fitur eksklusif login.
>     - Aktivitas utamanya adalah **Shopping Flow**: Add to Cart, Checkout, hingga Track Order.
> 3.  **Admin (Pengelola)**:
>     - Bertanggung jawab penuh atas operasional, mulai dari input Produk, manajemen User, hingga memproses Pesanan (Update Status)."

---

## 8. Data Flow Diagram (DFD) (Detail & Simulasi)

### Level 0 (Context Diagram)

**Naskah Simulasi:**

> "Di Level 0 ini, kita melihat SIPETA sebagai satu sistem utuh (Black Box) yang berinteraksi dengan dunia luar:
>
> - **User** memberikan input berupa data registrasi, pesanan, dan pembayaran. Sebagai balasan, User menerima Katalog Produk dan Invoice.
> - **Admin** memberikan input manajemen data (Produk, User) dan menerima Laporan serta Notifikasi Pesanan.
> - **Midtrans** bertukar data pembayaran: Kita kirim _Request Payment_, Midtrans balas dengan _Notification Status_.
> - **Petani** menyuplai informasi produk awal."

### Level 1 (Main Processes)

**Naskah Simulasi:**

> "Sekarang kita bedah isi sistem tersebut. Terdapat **7 Proses Inti**:
>
> 1.  **Proses 1 (Auth)**: Gerbang utama. Data User disimpan ke _Data Store D1 (Users DB)_.
> 2.  **Proses 2 (Produk)**: Admin menginput produk, data masuk ke _D2 (Products DB)_, lalu ditampilkan ke User.
> 3.  **Proses 3 (Cart)**: Menangani keranjang belanja sementara sebelum checkout.
> 4.  **Proses 4 (Order)**: **(Penting!)** Ini adalah jembatan utama. Mengambil data dari Cart, lalu menyimpannya ke _D3 (Orders DB)_.
> 5.  **Proses 5 (Payment)**: Menghubungkan pesanan dengan transaksi keuangan. Data disimpan di _D4 (Transactions DB)_.
>
> Aliran datanya jelas: Dari **User -> Cart -> Order -> Payment -> Database**."

### Level 2 (Detail Process 4.0 - Order Processing)

**Naskah Simulasi:**

> "Kita _Zoom-In_ lagi ke Proses 4 (Order) karena ini logika bisnis paling krusial:
>
> 1.  Saat User _Checkout_, sistem masuk ke **Sub-proses 4.1 (Validate Items)**. Kita cek ke _Products DB_, apakah stok masih ada?
> 2.  Lanjut ke **4.2 (Apply Discount)**. Jika User input kode kupon, sistem cek validitasnya ke _Coupon DB_.
> 3.  Baru masuk ke **4.3 (Calculate Total)**: (Harga Produk x Jumlah) - Diskon + Pajak + Ongkir.
> 4.  Output akhirnya adalah **4.4 (Create Order)** yang menyimpan data final fix ke database dan **4.5 (Generate Invoice)** untuk user.
>
> Diagram ini menjamin bahwa tidak ada order yang tercipta tanpa validasi stok dan harga yang benar."

---

## 9. Entity Relationship Diagram (ERD) (Detail & Simulasi)

**Strategi Penjelasan:** Fokus pada **Kardinalitas (One-to-Many)** dan **Alasan Bisnis** di balik relasi.

**Naskah Simulasi:**

> "ERD ini menggambarkan struktur penyimpanan data kita. Ada beberapa relasi kunci yang ingin saya soroti:
>
> 1.  **Relasi User ke Order (One-to-Many):**
>     - _Penjelasan:_ Satu User bisa membuat BANYAK Order seiring waktu. Garisnya bercabang di sisi Order.
> 2.  **Relasi Order ke OrderItem (One-to-Many):**
>     - _Penjelasan:_ Satu pesanan (misal: Order #001) bisa berisi BANYAK jenis barang (Bayam, Tomat, Cabai). Detail barangnya dipisah ke tabel _ORDER_ITEM_ agar rapi.
> 3.  **Relasi Order ke Transaction (One-to-One):**
>     - _Penjelasan:_ Setiap 1 Order hanya boleh memiliki 1 Transaksi pembayaran yang valid. Ini untuk mencegah _double-payment_ atau kebingungan status bayar.
> 4.  **Fitur Unik: Product ke ProductUnitPrice (One-to-Many):**
>     - _Penjelasan:_ Ini desain khusus SIPETA. Satu produk (misal: 'Bayam Hijau') terhubung ke tabel harga terpisah. Kenapa? Karena Bayam tersebut bisa dijual dalam satuan 'Ikat' dengan harga Rp2.000, DAN satuan 'Kg' dengan harga Rp15.000. Tanpa harus buat dua produk berbeda di database.
> 5.  **Relasi Product ke Farmer (Many-to-One):**
>     - _Penjelasan:_ Banyak Produk bisa dimiliki oleh Satu Petani. Ini memudahkan kita men-trace asal-usul produk kembali ke petani penanamnya."

---

## 💡 Tips Tambahan Presentasi:

1.  **Gunakan Pointer:** Saat menjelaskan diagram, tunjuk area yang sedang dibicarakan (misal: "Kotak di tengah ini...").
2.  **Jangan Terpaku Teks:** Slide adalah alat bantu visual, Anda adalah bintangnya. Tatap audiens/kamera, bukan layar terus-menerus.
3.  **Kuasai "Why":** Jika ditanya "Kenapa tabel harga dipisah?", jawab dengan alasan bisnis ("Agar fleksibel jual ecer/grosir"). Dosen/Penguji suka alasan logis/bisnis daripada sekedar teknis.
