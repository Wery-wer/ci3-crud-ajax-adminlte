# CodeIgniter 3 CRUD with AJAX & DataTables

Sistem manajemen user menggunakan CodeIgniter 3 dengan fitur CRUD real-time berbasis AJAX, jQuery, dan DataTables.

## 🚀 Features

- ✅ **Real-time CRUD** - Create, Read, Update, Delete tanpa reload halaman
- ✅ **Auto-refresh** - Data ter-update otomatis setiap 1 detik
- ✅ **Smart Pause** - Auto-refresh berhenti saat user aktif
- ✅ **DataTables** - Tabel interaktif dengan sorting, searching, pagination
- ✅ **Form Validation** - Validasi server-side dan client-side
- ✅ **Bootstrap 5** - UI yang modern dan responsive
- ✅ **SweetAlert2** - Popup konfirmasi dan notifikasi yang elegant

## 🛠 Tech Stack

- **Backend**: CodeIgniter 3.1.13
- **Frontend**: jQuery 3.6.0, Bootstrap 5.1.3, DataTables 1.11.5
- **Database**: MySQL
- **UI Components**: Font Awesome, SweetAlert2
- **Method**: AJAX untuk semua operasi CRUD

## 📋 Requirements

- PHP 7.2 atau lebih tinggi
- MySQL 5.6 atau lebih tinggi
- Apache/Nginx dengan mod_rewrite enabled
- XAMPP/WAMP/LAMP (recommended)

## 🔧 Installation

1. **Clone/Download project ini**

   ```bash
   git clone [repository-url]
   # atau download dan extract ke htdocs
   ```

2. **Setup Database**

   ```bash
   # Import database.sql ke MySQL
   mysql -u root -p < database.sql
   ```

3. **Konfigurasi Database**
   Edit `application/config/database.php`:

   ```php
   'hostname' => 'localhost',
   'username' => 'root',
   'password' => '',
   'database' => 'crud_ajax',
   ```

4. **Konfigurasi Base URL**
   Edit `application/config/config.php`:

   ```php
   $config['base_url'] = 'http://localhost/ci3-noreload/';
   ```

5. **Akses Project**
   Buka browser: `http://localhost/ci3-noreload/`

## 📁 Project Structure

```
ci3-noreload/
├── application/
│   ├── controllers/
│   │   └── Users.php                 # Controller utama
│   ├── models/
│   │   └── User_model.php           # Model untuk database operations
│   ├── views/
│   │   └── users/
│   │       └── index.php            # View utama dengan AJAX
│   └── config/
│       ├── database.php             # Database configuration
│       ├── config.php              # Base configuration
│       ├── autoload.php            # Auto-load libraries
│       └── routes.php              # URL routing
├── system/                         # CodeIgniter core files
├── .htaccess                       # URL rewriting
├── database.sql                    # Database schema + sample data
└── README.md
```

## 🎯 How It Works

### 1. **MVC Architecture**

- **Model** (`User_model.php`): Menangani semua operasi database
- **View** (`users/index.php`): Interface user dengan AJAX calls
- **Controller** (`Users.php`): Menangani request dan response JSON

### 2. **AJAX Flow**

```
User Action → AJAX Request → Controller → Model → Database
     ↑                                              ↓
User Interface ← JSON Response ← Controller ← Database Result
```

### 3. **Real-time System**

- **Auto-refresh**: DataTables reload data setiap 1 detik
- **Smart Pause**: Auto-refresh pause saat user sedang mengetik/mengklik
- **Event Delegation**: Handle dynamic elements yang ditambahkan via AJAX

### 4. **AJAX Endpoints**

- `GET /users/get_users_ajax` - Mengambil semua data users
- `POST /users/create_user_ajax` - Membuat user baru
- `POST /users/update_user_ajax` - Update user existing
- `POST /users/delete_user_ajax` - Hapus user

## 🔍 Key Features Explained

### Auto-Refresh System

```javascript
function startAutoRefresh() {
	autoRefreshInterval = setInterval(function () {
		dataTable.ajax.reload(null, false); // Silent refresh
	}, 1000); // Every 1 second
}
```

### Smart Pause System

```javascript
// Pause auto-refresh saat user aktif
$(document).on("click keypress focus", "input, button", function () {
	resetUserActiveTimer(); // Pause dan restart setelah 10 detik
});
```

### Form Validation

- **Client-side**: JavaScript validation untuk user experience
- **Server-side**: CodeIgniter Form Validation untuk security

## 🚀 Usage

1. **Tambah User**: Isi form dan klik "Save"
2. **Edit User**: Klik tombol "Edit" pada tabel
3. **Hapus User**: Klik tombol "Delete" dan konfirmasi
4. **Real-time Sync**: Data akan ter-update otomatis dari database

## 🎨 Customization

### Mengubah Auto-refresh Interval

```javascript
// Di users/index.php, line ~332
startAutoRefresh() {
    // Ubah 1000 (1 detik) ke nilai yang diinginkan
    setInterval(function () {
        dataTable.ajax.reload(null, false);
    }, 5000); // 5 detik
}
```

### Menambah Field Baru

1. **Database**: Tambah kolom di tabel `users`
2. **Model**: Update method di `User_model.php`
3. **Controller**: Update validation rules di `Users.php`
4. **View**: Tambah input field dan column di `users/index.php`

## 🐛 Troubleshooting

### URL Rewrite Issues

Jika URL masih menampilkan `index.php`:

1. Pastikan `.htaccess` file exists
2. Pastikan Apache `mod_rewrite` enabled
3. Check `$config['index_page'] = '';` di config.php

### Database Connection Error

1. Check database credentials di `config/database.php`
2. Pastikan MySQL service running
3. Pastikan database `crud_ajax` sudah dibuat

### AJAX 404 Errors

1. Check `base_url` di `config/config.php`
2. Pastikan controller method accessible
3. Check browser console untuk error details

## 🏆 Comparison: PHP Native vs CodeIgniter 3

| Aspek                | PHP Native            | CodeIgniter 3              |
| -------------------- | --------------------- | -------------------------- |
| **Structure**        | Manual organization   | MVC Pattern                |
| **Database**         | PDO/MySQLi manual     | Active Record              |
| **Validation**       | Manual validation     | Form Validation Library    |
| **Security**         | Manual implementation | Built-in security features |
| **URL Routing**      | Direct file access    | Routes configuration       |
| **Code Reusability** | Copy-paste code       | Models & Libraries         |
