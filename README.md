# Kolaborasi Code Anti Ribet dengan GIT
## Use Case: HTML List Data Siswa - Demo Conflict, Rebase & Pull Request
 

# Kenapa Materi Ini Anti Ribet?

Masalah klasik satu file index.html di-edit 2 orang barengan, pas push jadi tabrakan. Kita pakai 3 aturan emas:
 1. Jangan pernah coding langsung di branch main
 2. Selalu pull --rebase sebelum bikin branch baru
 3. Satu fitur = satu branch = satu Pull Request


# 1. Download dan Install Git (Windows)

Di Windows git harus di download manual melalui website resminya, git-scm.com. Di sana silakan pilih git installer untuk Windows 64. Setelah di download, proses instalasinya cukup mudah. Tinggal next next saja.


## 1.1. Setup Identitas Git

Setelah terinstall, buka CMD atau CMDER atau powershell untuk komputer Windows. Sementara untuk Mac dan Linux buka aplikasi Terminal. Setelah aplikasi tersebut terbuka, kita akan copy paste satu per satu perintah dibawah ini. Dan jangan lupa edit dan sesuaikan dengan data diri masing-masing.

```shell
git config --global user.name "NAMA LENGKAP"
git config --global user.email "EMAIL"
```

Sementara untuk perintah ini, kita akan mengatur supaya git memiliki pengaturan default yang cukup dengan editor default VSCode. Default editor nya biasanya pakai `vi`.
```shell
git config --global init.defaultBranch main
git config --global core.editor "code --wait"
git config --global pull.rebase true
```

# 2. Setup SSH Key

SSH Key merupakan file kunci unik yang bisa digenerate oleh setiap komputer. Satu komputer minimal memiliki satu SSH key. SSH key akan digunakan untuk autentifikasi ke Github atau ke server lainnya.

#### Tips

> Kenapa pakai SSH Key enkripsi ED25519? Lebih pendek, lebih aman, lebih cepat dari RSA. GitHub sudah tidak merekomendasikan RSA (Default SSH Key) lagi.


## 2.1. Generate SSH Key
 
Untuk di windows pastikan menggunakan CMDER atau pakai Powershell yang sudah ada OpenSSH nya. Kalau di linux atau mac perintah ini sudah ada.

`ssh-keygen -t ed25519 -C "email@kamu.com"`

> Perintah `ssh-keygen` akan membuat 2 file baru didalam folder `.ssh`, 
pertama private key, ini jangan dibagikan. Yang kedua public key, ini yang akan dibagikan di sharing. Contoh di sharing ke Github.

# 3. Daftar akun Github dan Setup SSH Key

Github adalah satu platfom untuk menyimpan kode kita. Kode yang sudah kita setup di komputer, akan di upload ke server-nya github. Dan bisa kita gunakan untuk berkolaborasi dengan programmer yang lainnya.

1. Daftar di github.com
2. Nanti akan ada konfirmasi email
3. Setelah selesai, buka pengaturan github -> https://github.com/settings/keys
4. Kemudian nanti kita akan copy paste Public SSH key yang sudah dibuat tadi.

#### Tips

> Untuk menampilkan SSH public key bisa menggunakan perintah 
`cat ~/.ssh/id_ed25519.pub` atau buka Document, masuk ke folder `.ssh` kemudian klik kanan file `id_ed25519.pub` dan buka dengan notepad.

> Untuk Windows pastikan menggunakan CMDER untuk menggunakan perintah cat

> Pada Mac dan linux perintah cat sudah ada dari bawaan terminal

> Tes Koneksi ke Github bisa menggunakan perintah di bawah ini:

```shell
ssh -T git@github.com`
# Jika sukses: Hi USERNAME! You've successfully authenticated...
```

> Untuk windows pastikan menggunakan CMDER atau Powershell yang sudah ada OpenSSH-nya

# 4. Repository Git

Pada git, folder project kode yang akan kita pakai disebut repo (atau repository). Repository ini bukanlah folder biasa melainkan folder yang sudah ada penanda `.git` di dalamnya.

## Contoh

Misalkan kita memakai XAMPP. Pada XAMPP project kita biasanya disimpan di dalam folder `htdocs/project`. Awalnya itu adalah project biasa. Setelah menggunakan perintah git tertentu akan ada folder baru di dalamnya bernama `.git`

Ilustrasi
```
c:
 |- XAMPP
   |- htdocs
     |- project
       |- .git
       |- folder_lain
```

## 4.1 Membuat Repository Git Pertama

Pertama-tama buat folder baru di dalam `XAMPP/htdocs` beri nama `cobagit`. Ini bisa dilakukan melalui CMDER atau File explorer atau di VSCode langsung. 

Setelah itu buka CMDER (untuk Windows) atau terminal (Mac dan Linux), kemudian didalamnya kita akan menjalankan perintah ini:

`git init `

## 4.2 Verifikasi Status Repository Git

Untuk memeriksa bahwa suatu folder / directory sudah menjadi repository git atau belum, kita akan menggunakan perintah `git status`.

## 4.3 Membuat File Baru dan Commit

Karena ini adalah repository pertama dan masih kosong, maka kita akan membuat file baru beri nama `readme.md` dan biarkan isinya kosong.


Kita buat template project yang real, bukan hello world doang.
mkdir data-siswa-smk
 cd data-siswa-smk
 git init

 # Struktur project anti ribet
 echo "# Aplikasi Data Siswa SMK" > README.md
 mkdir css js



File index.html (list data siswa):
<!DOCTYPE html>
 <html lang="id">
 <head>
   <meta charset="UTF-8">
   <title>Data Siswa XII RPL</title>
   <link rel="stylesheet" href="css/style.css">
 </head>
 <body>
   <h1>Data Siswa Kelas XII RPL</h1>
   <ul id="list-siswa">
 	<li>Andi - XII RPL 1 - NIS: 12301</li>
 	<li>Budi - XII RPL 1 - NIS: 12302</li>
   </ul>
   <script src="js/script.js"></script>
 </body>
 </html>
File data.json:
{"siswa": [{"nama": "Andi", "kelas": "XII RPL 1", "nis": "12301"}]}
File js/script.js (render list):
const list = document.getElementById("list-siswa");
 // nanti fetch dari data.json
6. Commit Pertama
git add .
 git commit -m "Initial: struktur awal aplikasi data siswa"
 git log --oneline
7. Set Remote & Push via SSH
Buat repo kosong di GitHub bernama data-siswa-smk (JANGAN centang Add README)
git remote add origin git@github.com:USERNAME/data-siswa-smk.git
 git branch -M main
 git push -u origin main
8. Alur Kolaborasi Tim - Clone
Untuk teman satu tim:
 git clone git@github.com:USERNAME/data-siswa-smk.git
 cd data-siswa-smk
9. Branching - Satu Fitur Satu Branch
Aturan: JANGAN EDIT DI MAIN!
git checkout main
 git pull --rebase origin main
 git checkout -b fitur-tambah-siswa

 # lalu edit index.html: tambah form
 # edit data.json & script.js
 git add .
 git commit -m "Fitur: form tambah siswa"
 git push -u origin fitur-tambah-siswa
10. Pull Request (PR) di GitHub
1. Buka GitHub -> akan muncul banner 'Compare & pull request'
 2. Judul PR: Fitur: Tambah Siswa
 3. Deskripsi: Menambahkan form input + validasi NIS
 4. Create Pull Request
 5. Minta teman review
11. Approve & Merge
Di halaman PR -> Review changes -> Approve -> Merge pull request -> Confirm -> Delete branch (di GitHub)
12. Update Lokal Setelah Merge - INI KUNCINYA!
Wajib setelah PR di-merge!
git checkout main
 git pull --rebase origin main
 # Sekarang main lokal kamu = main di GitHub. Bersih.
13. DEMO CONFLICT - Skenario Kelas (Paling Penting)
Ini yang bikin materi ini beda. Kita sengaja bikin conflict biar siswa tidak panik.
Skenario A: Conflict di index.html
Siswa A dan B sama-sama mulai dari main yang sama.

 Siswa A:
 git checkout -b fitur-siswa-3
 Edit <li>Andi</li> menjadi <li>Andi - Juara Lomba</li>
 Commit & Push & Merge ke main

 Siswa B (lupa pull):
 Masih di main lama, bikin branch fitur-siswa-4
 Edit baris yang SAMA: <li>Andi</li> menjadi <li>Andi - Ketua OSIS</li>
 Commit & Push -> PR -> Akan ada tulisan 'Can't auto-merge'

 Solusi di Laptop Siswa B:
 git checkout main
 git pull --rebase origin main # sekarang main sudah ada update Siswa A
 git checkout fitur-siswa-4
 git rebase main
 # AKAN MUNCUL CONFLICT!
Cara Selesaikan Conflict (Visual VS Code)
VS Code akan menampilkan:
 <<<<<<< HEAD
 <li>Andi - Juara Lomba</li>
 =======
 <li>Andi - Ketua OSIS</li>
 >>>>>>> fitur-siswa-4

 Langkah:
 1. Diskusikan dengan teman (kolaborasi!)
 2. Pilih gabungkan manual: <li>Andi - Juara Lomba & Ketua OSIS</li>
 3. Hapus tanda <<<<<< ====== >>>>>>
 4. git add index.html
 5. git rebase --continue
 6. git push -f (karena sudah rebase, wajib force push di branch fitur)
 7. PR jadi bisa di-merge
Skenario B: Conflict di data.json

 Tips Anti Ribet data.json:
 - Selalu format JSON dengan Prettier
 - Satu siswa satu object, jangan edit object orang lain
 - Gunakan git pull --rebase origin main SEBELUM mulai ngoding
14. Alur Harian Wajib (Tempel di Dinding Lab)
# SETIAP MAU MULAI NGODING:
 git checkout main
 git pull --rebase origin main
 git checkout -b fitur-nama-fitur-kamu

 # ... kerjakan ...

 git add .
 git commit -m "Jelas: apa yang kamu ubah"
 git push -u origin fitur-nama-fitur-kamu

 # Buka GitHub -> Buat PR

 # SETELAH PR DI-MERGE:
 git checkout main
 git pull --rebase origin main
 git branch -d fitur-nama-fitur-kamu



15. Cheat Sheet Perintah
git status -> cek status
 git log --oneline --graph --all -> cek history
 git diff -> lihat perubahan
 git checkout -b nama-branch -> bikin branch baru
 git pull --rebase origin main -> update main paling aman
 git rebase main -> rapikan branch dengan main terbaru
 git rebase --abort -> batalkan rebase kalau bingung
 git push -f -> push setelah rebase (hanya di branch fitur!)
 


