---
marp: true
theme: gaia
paginate: true
backgroundColor: #fff
style: |
    section {
      font-family: 'Arial', sans-serif;
    }
    table {
      font-size: 18px;
    }
---

# PRESENTASI PROJECT SIPETA

## Sistem Informasi Penjualan Tanaman

---

## 📋 SLIDE 1: COVER

<div align="center">

# **SIPETA**

### Sistem Informasi Penjualan Tanaman

**Platform E-Commerce untuk Produk Pertanian Segar dan Berkualitas**

---

**Pencipta:**  
A'AN  
Program Studi Sistem Informasi

---

_2026_

</div>

---

## 📖 SLIDE 2: LATAR BELAKANG

### Permasalahan yang Diidentifikasi:

1. **Kesulitan Pemasaran Petani**
    - Petani lokal kesulitan memasarkan produk pertanian mereka secara langsung ke konsumen
    - Terjebak dalam rantai distribusi panjang yang mengurangi keuntungan mereka
    - Keterbatasan akses terhadap platform digital untuk menjual produk

2. **Tantangan Konsumen**
    - Konsumen sering kesulitan mendapatkan produk pertanian segar, berkualitas, dan organik langsung dari sumber terpercaya
    - Harga produk pertanian di pasar tradisional seringkali tidak transparan
    - Kurangnya informasi lengkap tentang asal-usul produk

3. **Minimnya Transparansi**
    - Ketidakjelasan dalam rantai pasokan produk pertanian
    - Keraguan konsumen terhadap keaslian dan kualitas produk organik
    - Tidak ada sistem tracking dari petani ke konsumen

4. **Kebutuhan Digitalisasi**
    - Dibutuhkan platform digital yang dapat menghubungkan petani dengan konsumen secara langsung
    - Meningkatkan transparansi dalam ekosistem pertanian
    - Mendukung pertanian berkelanjutan dan pemberdayaan petani lokal

### Solusi:

**SIPETA hadir sebagai solusi digital** yang menjembatani kesenjangan antara petani dan konsumen, memberikan:

- ✅ **Akses pasar lebih luas** bagi petani
- ✅ **Produk segar berkualitas** dengan harga transparan untuk konsumen
- ✅ **Transparansi penuh** dari kebun hingga meja makan
- ✅ **Pemberdayaan ekonomi** petani lokal Indonesia

---

---

## 🎯 SLIDE 3: TUJUAN

### Tujuan Pengembangan Sistem:

Platform ini dirancang untuk membuka akses pasar digital secara langsung bagi petani lokal, memangkas rantai distribusi, dan meningkatkan kesejahteraan mereka. Kami berkomitmen menyediakan kemudahan bagi masyarakat luas dalam mendapatkan produk pertanian yang segar, sehat, dan berkualitas dengan harga yang kompetitif.

Lebih jauh lagi, sistem SIPETA dibangun dengan fondasi transparansi untuk menciptakan ekosistem jual beli yang terpercaya melalui verifikasi profil penjual dan informasi produk yang jelas. Melalui inisiatif ini, diharapkan terjadi percepatan modernisasi di sektor pertanian Indonesia, sekaligus mendorong daya saing produk lokal di era ekonomi digital.

---

## 🚧 SLIDE 4: BATASAN MASALAH

### Ruang Lingkup & Batasan Sistem:

1.  **Lingkup Produk**
    - Sistem hanya melayani penjualan produk pertanian (sayur, buah, tanaman hias, pupuk, alat tani).
    - Tidak mencakup penjualan barang umum atau non-agrikultur.

2.  **Wilayah Operasional**
    - Fokus implementasi awal pada wilayah Indonesia.
    - Pengiriman terbatas pada area yang terjangkau oleh ekspedisi lokal.

3.  **Pengguna Sistem**
    - **Petani (Penjual):** Pihak yang menjual produk hasil tani.
    - **Konsumen (Pembeli):** Pengguna akhir yang membeli produk.
    - **Admin:** Pengelola sistem SIPETA.
    - _Tidak mencakup peran Reseller atau Dropshipper._

4.  **Platform Teknologi**
    - Berbasis Web (Web-based Application).
    - Dapat diakses melalui browser Desktop dan Mobile (Responsif), namun bukan aplikasi Native Mobile (Android/iOS).

5.  **Transaksi & Pembayaran**
    - Pembayaran melalui Payment Gateway (Midtrans).
    - Tidak menangani transaksi tunai (COD) secara langsung dalam sistem (kecuali fitur mendatang).

---

## 🌟 SLIDE 5: KELEBIHAN PROJECT

### Keunggulan Kompetitif SIPETA:

1.  **Transparansi & Traceability**
    - Konsumen dapat mengetahui asal-usul produk dan profil petani secara detail, membangun kepercayaan yang lebih kuat dibandingkan pasar konvensional.

2.  **Fleksibilitas Pembayaran (Midtrans)**
    - Mendukung berbagai metode pembayaran otomatis (Virtual Account, E-Wallet, QRIS) yang memudahkan transaksi bagi pengguna milenial maupun umum.

3.  **Dashboard Admin yang Dinamis & Informatif**
    - Dilengkapi dengan analitik visual (ApexCharts) untuk memantau performa penjualan, stok, dan pendaftaran petani secara real-time.

4.  **Sistem Multi-Harga (Multi-Unit Pricing)**
    - Fleksibilitas unik yang memungkinkan petani menjual produk dalam berbagai satuan (per kg, per ikat, per box) dalam satu halaman produk.

5.  **Pengalaman Pengguna (UX) Modern**
    - Antarmuka responsif yang cepat (Vite + Tailwind/Bootstrap) dengan fitur interaktif seperti Live Search, Wishlist, dan Tracking Order Real-time.

---

## 🛠️ SLIDE 6: TOOLS & TEKNOLOGI

### 💻 Teknologi & Tools Utama

| Kategori      | Stack yang Digunakan                                                                |
| :------------ | :---------------------------------------------------------------------------------- |
| **Backend**   | **Laravel 12** (PHP 8.2), **MySQL**                                                 |
| **Frontend**  | **Blade**, **Bootstrap 5**, **TailwindCSS 4**, **SCSS**, **Vite**, **jQuery**       |
| **Libraries** | **Swiper.js**, **SweetAlert2**, **ApexCharts**, **Fancybox**, **Axios**, **DomPDF** |
| **Integrasi** | **Midtrans** (Payment), **Cloudinary** (Images), **Google OAuth**, **Socialite**    |
| **Dev Tools** | **Laragon**, **Git**, **Composer**, **NPM**, **VS Code**, **Postman**, **Draw.io**  |

---

## 👥 SLIDE 7: USE CASE DIAGRAM

### Use Case Diagram - SIPETA System

```mermaid
graph TB
    subgraph "SIPETA System"
        %% Guest Features
        UC_Browse[Browse Products]
        UC_Search[Search Products]
        UC_ViewDetail[View Product Detail]
        UC_Register[Register]
        UC_ViewFarmer[View Farmer Profile]

        %% Customer Features
        UC_Login[Login]
        UC_Logout[Logout]
        UC_ManageProfile[Update Profile]
        UC_Cart[Add to Cart & Manage Cart]
        UC_Checkout[Checkout]
        UC_Payment[Make Payment]
        UC_Track[Track Order]
        UC_Review[Submit Review]
        UC_Return[Request Return]
        UC_History[View Order History]
        UC_Wishlist[Manage Wishlist]
        UC_Invoice[Download Invoice]

        %% Admin Features
        UC_ProdManage[Manage Products]
        UC_CatManage[Manage Categories]
        UC_FarmerManage[Manage Farmers]
        UC_OrderManage[Manage Orders]
        UC_ReturnManage[Manage Returns]
        UC_UserManage[Manage Users]
        UC_Report[View Reports & Analytics]
        UC_Coupon[Manage Coupons]
        UC_Slide[Manage Slides/Banners]
        UC_Contact[Manage Inquiries]
    end

    Guest((Guest))
    Customer((Customer))
    Admin((Admin))
    PaymentGateway{{Payment Gateway<br/>(Midtrans)}}

    %% Guest Relationships
    Guest --> UC_Browse
    Guest --> UC_Search
    Guest --> UC_ViewDetail
    Guest --> UC_Register
    Guest --> UC_ViewFarmer

    %% Customer Relationships (Inherits Guest)
    Customer -.-|> Guest
    Customer --> UC_Login
    Customer --> UC_Logout
    Customer --> UC_ManageProfile
    Customer --> UC_Cart
    Customer --> UC_Checkout
    Customer --> UC_Payment
    Customer --> UC_Track
    Customer --> UC_Review
    Customer --> UC_Return
    Customer --> UC_History
    Customer --> UC_Wishlist
    Customer --> UC_Invoice

    %% Admin Relationships
    Admin --> UC_ProdManage
    Admin --> UC_CatManage
    Admin --> UC_FarmerManage
    Admin --> UC_OrderManage
    Admin --> UC_ReturnManage
    Admin --> UC_UserManage
    Admin --> UC_Report
    Admin --> UC_Coupon
    Admin --> UC_Slide
    Admin --> UC_Contact

    %% External Systems
    UC_Checkout -.include.-> UC_Payment
    UC_Payment -- Process Payment --> PaymentGateway

    style Guest fill:#95a5a6,color:#fff
    style Customer fill:#4a90e2,color:#fff
    style Admin fill:#e74c3c,color:#fff
    style PaymentGateway fill:#9b59b6,color:#fff
```

### Deskripsi Aktor & Use Case:

#### 1. 👤 Guest (Pengunjung)

Pengguna yang belum login. Memiliki akses terbatas untuk eksplorasi sistem:

- **Browse & Search**: Mencari produk dan melihat detail.
- **View Farmer**: Melihat profil petani penjual.
- **Register**: Mendaftar menjadi Customer.

#### 2. 🛍️ Customer (Pelanggan)

Pengguna terdaftar. Memiliki akses penuh fitur belanja (**Inherits Guest**):

- **Shopping**: Manage Cart, Checkout, Wishlist.
- **Transaction**: Melakukan pembayaran dan melacak pesanan.
- **Account**: Update profil, riwayat pesanan, retur, dan review.

#### 3. 👨‍💼 Admin (Pengelola)

Memiliki hak akses penuh untuk manajemen operasional sistem:

- **Master Data**: Produk, Kategori, User, Petani.
- **Transaksi**: Proses pesanan, retur, dan laporan keuangan.
- **Konten**: Banner, Promo/Kupon.

#### 4. 💳 Payment Gateway (Sistem Eksternal)

Aktor sistem eksternal (Midtrans) yang bertugas memproses pembayaran aman dari Customer.

---

## 🔄 SLIDE 8: DATA FLOW DIAGRAM (DFD)

### DFD Level 0 (Context Diagram)

```mermaid
graph TB
    User((User/Konsumen))
    Admin((Admin))
    Petani((Petani))
    Midtrans((Midtrans<br/>Payment Gateway))

    SIPETA[("SIPETA<br/>System")]

    User -->|Register/Login| SIPETA
    User -->|Browse Products| SIPETA
    User -->|Add to Cart| SIPETA
    User -->|Checkout| SIPETA
    User -->|Submit Review| SIPETA
    User -->|Request Return| SIPETA

    SIPETA -->|Product Catalog| User
    SIPETA -->|Order Status| User
    SIPETA -->|Invoice| User

    Admin -->|Manage Products| SIPETA
    Admin -->|Manage Orders| SIPETA
    Admin -->|Manage Users| SIPETA
    Admin -->|View Reports| SIPETA

    SIPETA -->|Dashboard Data| Admin
    SIPETA -->|Notifications| Admin

    Petani -->|Product Info| SIPETA
    SIPETA -->|Farmer Profile| User

    SIPETA -->|Payment Request| Midtrans
    Midtrans -->|Payment Notification| SIPETA

    style SIPETA fill:#1a7a3e,color:#fff
    style User fill:#4a90e2,color:#fff
    style Admin fill:#e74c3c,color:#fff
    style Petani fill:#f39c12,color:#fff
    style Midtrans fill:#9b59b6,color:#fff
```

### DFD Level 1 (Main Processes)

```mermaid
graph TB
    User((User))
    Admin((Admin))
    Midtrans((Midtrans))

    P1[1.0<br/>Authentication<br/>Management]
    P2[2.0<br/>Product<br/>Management]
    P3[3.0<br/>Shopping Cart<br/>Management]
    P4[4.0<br/>Order<br/>Processing]
    P5[5.0<br/>Payment<br/>Processing]
    P6[6.0<br/>Review<br/>Management]
    P7[7.0<br/>Return<br/>Management]

    D1[(Users DB)]
    D2[(Products DB)]
    D3[(Orders DB)]
    D4[(Transactions DB)]
    D5[(Reviews DB)]

    User -->|Login/Register| P1
    P1 -->|User Data| D1
    P1 -->|Auth Status| User

    User -->|Browse/Search| P2
    Admin -->|CRUD Products| P2
    P2 <-->|Product Data| D2
    P2 -->|Product List| User

    User -->|Add/Remove Items| P3
    P3 -->|Cart Data| User

    User -->|Checkout| P4
    P3 -->|Cart Items| P4
    P4 -->|Order Data| D3
    P4 -->|Order Confirmation| User

    P4 -->|Payment Request| P5
    P5 <-->|Payment Data| Midtrans
    P5 -->|Transaction Record| D4
    P5 -->|Payment Status| P4

    User -->|Submit Review| P6
    P6 -->|Review Data| D5
    Admin -->|Approve/Reject| P6

    User -->|Return Request| P7
    P7 -->|Return Data| D3
    Admin -->|Process Return| P7

    style P1 fill:#3498db,color:#fff
    style P2 fill:#2ecc71,color:#fff
    style P3 fill:#f39c12,color:#fff
    style P4 fill:#e74c3c,color:#fff
    style P5 fill:#9b59b6,color:#fff
    style P6 fill:#1abc9c,color:#fff
    style P7 fill:#e67e22,color:#fff
```

### DFD Level 2 - Order Processing (Detail Proses 4.0)

```mermaid
graph TB
    User((User))

    P41[4.1<br/>Validate<br/>Cart Items]
    P42[4.2<br/>Apply<br/>Discount]
    P43[4.3<br/>Calculate<br/>Total]
    P44[4.4<br/>Create<br/>Order]
    P45[4.5<br/>Generate<br/>Invoice]

    D1[(Cart Data)]
    D2[(Coupon DB)]
    D3[(Orders DB)]
    D4[(Products DB)]

    User -->|Checkout Request| P41
    P41 <-->|Validate Stock| D4
    P41 -->|Valid Cart| P42

    User -->|Coupon Code| P42
    P42 <-->|Verify Coupon| D2
    P42 -->|Discounted Cart| P43

    P43 -->|Calculate Tax & Shipping| P43
    P43 -->|Final Amount| P44

    P44 -->|Save Order| D3
    P44 -->|Order Created| P45

    P45 -->|Invoice PDF| User
    P45 -->|Trigger Payment| User

    style P41 fill:#3498db,color:#fff
    style P42 fill:#f39c12,color:#fff
    style P43 fill:#2ecc71,color:#fff
    style P44 fill:#e74c3c,color:#fff
    style P45 fill:#9b59b6,color:#fff
```

---

## 🗄️ SLIDE 9: ENTITY RELATIONSHIP DIAGRAM (ERD)

### Database Schema SIPETA

```mermaid
erDiagram
    USER ||--o{ ORDER : places
    USER ||--o{ ADDRESS : has
    USER ||--o{ PRODUCT_REVIEW : writes
    USER ||--o{ RETURN_REQUEST : creates

    FARMER ||--o{ PRODUCT : sells

    PRODUCT ||--o{ ORDER_ITEM : "contains in"
    PRODUCT }o--|| CATEGORY : "belongs to"
    PRODUCT }o--|| REGION : "from"
    PRODUCT }o--|| FARMER : "sold by"
    PRODUCT ||--o{ PRODUCT_REVIEW : receives
    PRODUCT ||--o{ PRODUCT_UNIT_PRICE : "has pricing"
    PRODUCT }o--o{ PRODUCT_TYPE : "categorized as"

    ORDER ||--o{ ORDER_ITEM : contains
    ORDER ||--|| TRANSACTION : "has payment"
    ORDER ||--o{ RETURN_REQUEST : "may have"
    ORDER }o--|| ADDRESS : "ships to"

    PRODUCT_UNIT_PRICE }o--|| UNIT : "measured in"

    COUPON ||--o{ ORDER : "applied to"

    USER {
        bigint id PK
        string name
        string email UK
        string password
        string phone
        string utype
        boolean is_blocked
        timestamp created_at
    }

    FARMER {
        bigint id PK
        string name
        string slug UK
        text description
        string province
        string city
        string address
        string contact
        string image
        boolean is_verified
        timestamp created_at
    }

    PRODUCT {
        bigint id PK
        string name
        string slug UK
        text short_description
        text description
        string image
        text images
        string SKU
        enum stock_status
        boolean featured
        int quantity
        bigint category_id FK
        bigint region_id FK
        bigint farmer_id FK
        string harvest_period
        string shelf_life
        boolean organic_status
        text storage_info
        date production_date
        string bpom_number
        text composition
        date expiry_date
        timestamp created_at
    }

    CATEGORY {
        bigint id PK
        string name
        string slug UK
        string image
        timestamp created_at
    }

    REGION {
        bigint id PK
        string name
        string slug UK
        timestamp created_at
    }

    PRODUCT_TYPE {
        bigint id PK
        string name
        string slug UK
        timestamp created_at
    }

    UNIT {
        bigint id PK
        string name UK
        string symbol
        timestamp created_at
    }

    PRODUCT_UNIT_PRICE {
        bigint id PK
        bigint product_id FK
        bigint unit_id FK
        decimal regular_price
        decimal sale_price
        boolean is_primary
        timestamp created_at
    }

    ORDER {
        bigint id PK
        bigint user_id FK
        bigint address_id FK
        bigint coupon_id FK
        decimal subtotal
        decimal discount
        decimal tax
        decimal total
        string name
        string phone
        string locality
        text address
        string city
        string province
        string country
        string landmark
        string zip
        enum status
        boolean is_delivered
        date delivered_date
        boolean canceled
        date canceled_date
        timestamp created_at
    }

    ORDER_ITEM {
        bigint id PK
        bigint product_id FK
        bigint order_id FK
        bigint unit_id FK
        decimal price
        int quantity
        text options
        timestamp created_at
    }

    TRANSACTION {
        bigint id PK
        bigint user_id FK
        bigint order_id FK
        enum mode
        enum status
        string snap_token
        string transaction_id
        timestamp created_at
    }

    ADDRESS {
        bigint id PK
        bigint user_id FK
        string name
        string phone
        string locality
        text address
        string city
        string province
        string country
        string landmark
        string zip
        boolean is_default
        timestamp created_at
    }

    PRODUCT_REVIEW {
        bigint id PK
        bigint product_id FK
        bigint user_id FK
        int rating
        text comment
        string image
        boolean is_approved
        timestamp created_at
    }

    RETURN_REQUEST {
        bigint id PK
        bigint order_id FK
        bigint user_id FK
        text reason
        text description
        text media_paths
        enum status
        text admin_notes
        timestamp created_at
    }

    COUPON {
        bigint id PK
        string code UK
        enum type
        decimal value
        decimal cart_value
        date expiry_date
        timestamp created_at
    }

    CONTACT {
        bigint id PK
        string name
        string email
        string phone
        text comment
        timestamp created_at
    }

    SLIDE {
        bigint id PK
        string tagline
        string title
        string subtitle
        string link
        string image
        enum status
        timestamp created_at
    }
```

### Penjelasan Relasi Utama:

1. **User → Order (1:N)**: Satu user dapat memiliki banyak pesanan
2. **Order → OrderItem (1:N)**: Satu pesanan berisi banyak item produk
3. **Product → OrderItem (1:N)**: Satu produk dapat dipesan berkali-kali
4. **Farmer → Product (1:N)**: Satu petani dapat menjual banyak produk
5. **Product → Category (N:1)**: Banyak produk dalam satu kategori
6. **Product → ProductUnitPrice (1:N)**: Satu produk memiliki banyak pilihan satuan harga
7. **Product → ProductType (N:M)**: Produk dapat memiliki banyak tipe (organik, lokal, dll)
8. **Order → Transaction (1:1)**: Setiap pesanan memiliki satu transaksi pembayaran
9. **User → Address (1:N)**: Satu user dapat memiliki banyak alamat pengiriman
10. **Order → ReturnRequest (1:N)**: Satu pesanan dapat memiliki permintaan retur
