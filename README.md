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

# 4. Local Repository Git

Pada git, folder project kode yang akan kita pakai disebut repo (atau repository). Repository ini bukanlah folder biasa melainkan folder yang sudah ada penanda `.git` di dalamnya.

## Contoh

Misalkan kita memakai XAMPP. Pada XAMPP project kita biasanya disimpan di dalam folder `htdocs/project`. Awalnya itu adalah project biasa. Setelah menggunakan perintah git tertentu akan ada folder baru di dalamnya bernama `.git`

Ilustrasi
```
c:
 |- XAMPP
   |- htdocs
     |- cobagit
       |-
```

## 4.1 Membuat Repository Git Pertama

Pertama-tama buat folder baru di dalam `XAMPP/htdocs` beri nama `cobagit`. Ini bisa dilakukan melalui CMDER atau File explorer atau di VSCode langsung. 

Setelah itu buka CMDER (untuk Windows) atau terminal (Mac dan Linux), kemudian didalamnya kita akan menjalankan perintah ini:

`git init`

## 4.2 Verifikasi Status Repository Git

Untuk memeriksa bahwa suatu folder / directory sudah menjadi repository git atau belum, kita akan menggunakan perintah `git status`.

## 4.3 Membuat File Baru dan tambahkan ke repository git

Karena ini adalah repository pertama dan masih kosong, maka kita akan membuat file baru beri nama `readme.md` dan biarkan isinya kosong. Jalankan perintah ini di cmder atau di terminal (mac  / linux).

`touch readme.md`

#### Tips

> Kalau tidak bisa membuat file baru dengan touch, buatlah secara manual di VS Code

Setelah dibuat file baru, kita akan menggunakan perintah `git add` untuk menambahkannya kedalam repository git.

`git add readme.md`

Namun, pada perintah ini, file hanya baru ditambahkan pada kondisi staging, yang mana file masih bisa diubah lagi dan belum bisa dianggap benar-benar masuk kedalam repository git.

## 4.4 Git Commit

Git commit adalah perintah untuk mempantenkan atau berkomitmen terhadap perubahan yang telah dilakukan. Artinya setiap perubahan pada file-file yang kita edit atau file yang baru ditambahkan akan dikunci. Di perintah ini juga kita akan diminta untuk memasukan catatan perubahannya juga.

Contoh perintah:

`git commit -m "FEAT: readme.md"`

isi dari parameter `-m` merupakan sebuah catatan pada `git commit`. Isinya sebenarnya bebas, namun pada contoh kali ini akan menggunakan kaidah git commit standar supaya lebih pendek. Berikut adalah penjelasannya.

- `FEAT: ` kependekan dari kata FEATURE, yang mana pada commit ini berarti ada penambahan fitur
- `readme.md` implementasi fitur yang ditambahkan pada file

Setelah berhasil menjalankan perintah `git commit`, sistem akan menampilkan commit kode. Lihat pada contoh dibawah ini:

```
[main aba982a] FEAT: readme.md
 4 files changed, 282 insertions(+), 106 deletions(-)
 delete mode 100644 data_siswa.php
 delete mode 100644 data_siswa_builder.php
```

Penjelasan:
- `main` adalah branch yang dipakai
- `aba982a` adalah commit kode
- Dibawahnya adalah ringkasan file yang sudah terpengaruh perubahan

## 4.5 Git Branch dan file baru

Git branch merupakan percabangan suatu kejadi berdasarkan posisi commit tertentu. Pada sebuah repository git, branch utama itu biasanya diberi nama `master` atau `main`. Branch ini dibuat commit terakhir yang sudah ada. Tapi bisa saja dibuat dengan commit kode tertentu. 

Git branch membantu kode kita supaya tidak bercampur dengan kode yang lain. Biasanya nama branch ini diambil dari nama fitur yang akan kita buat. Contoh pembuatan branch baru dan pindah langsung ke branch yang baru kita buat.

```
git checkout -b feature/login
```

> Result `Switched to a new branch 'feature/login'`

Contoh untuk verifikasi branch dengan `git status`.
```
git status
On branch feature/login
Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git restore <file>..." to discard changes in working directory)
        modified:   README.md

no changes added to commit (use "git add" and/or "git commit -a")
```

Semua perintah `git add`, `git commit` akan terisolasi di dalam branch ini (`feature/login`). Jadi branch main tidak tersenggol sedikit pun.

Setelah branch baru dibuat, kita akan membuat file baru bernama login.php dengan perintah nano. Pastikan untuk mengeksekusi perintah ini di cmder atau di terminal pada linux / mac.

`nano login.php`

Kemudian, kita akan copy `ini file login.php` dan paste pada tampilan nano. Setelah itu tekan `CTRL` bareng dengan `X`. Kemudian setelah itu tekan `Y` lalu tekan `ENTER`.

Setelah file baru ditambahkan kita akan mengubah file readme.md dengan perintah nano juga.

`nano readme.md`

Kemudian, kita akan copy `ini file readme.md` dan paste pada tampilan nano. Setelah itu tekan `CTRL` bareng dengan `X`. Kemudian setelah itu tekan `Y` lalu tekan `ENTER`.

Setelah itu, kita akan add dan commit supaya perubahan bisa diterapkan pada git repository local kita.

`git add readme.md login.php`

`git commit -m "Menambahkan login.php dan mengubah readme.md"`

Kemudian cek dengan `git status` dan `ls` untuk melihat isi file.

Setelah ini kita akan kembali lagi ke branch `main` atau branch `master`.

`git checkout main` atau `git checkout master`.

## 4.6 Menambahkan Remote Repository dari github

Buka dulu halaman repository yang sudah kita buat tadi. Nanti copy paste satu per satu di bagian `...or push an existing...`. Jangan lupa pilih metode SSH jang metode HTTPS. Jika sudah terlanjur di copy paste dengan metode HTTPS, maka harus dihapus dulu remote nya dengan perintah ini `git remote rm origin`.

Berikut ini adalah contoh perintahnya.

```
git remote add origin git@github.com:YOURUSERNAME/cobagit.git
git branch -M main
git push -u origin main
```

Pastikan `YOURUSERNAME` ini sudah diganti menjadi username githubnya.

## 4.7 Push branch feature/login ke remote repository github

Setelah itu kita akan push branch yang sudah kita buat sebelumnya. dengan perintah ini. Tolong copy paste per baris.

`git checkout feature/login`
`git push origin feature/login`

Kemudian cek dihalam github, harusnya branchnya sudah bertambah.

## 4.8 Membuat Pull Request di Github

Setelah ke 2 branch tadi masuk, nanti akan ada notifikasi ber background kuning dengan keterangan tombol Pull request. Klik tombol tersebut, kemudian nanti akan muncul tampilan untuk mengisi pull request. Langsung saja klik tombol pull request.


## 4.9 Git merge manual tanpa Pull Request

Git merge adalah perintah untuk menggabungkan branch lain ke branch yang sedang kita gunakan saat ini. Pada contoh sebelumnya kita telah memiliki 2 branch yaitu branch default (main atau master) dan branch baru `feature/login. Anggaplah kita sudah menambahkan 2 commit baru pada feature branch dan kita akan menggabungkannya ke main. Berikut ini adalah contohnya.

```
git checkout main
git merge feature/login
```

### 4.9.1 Metode merging git

Ada 3 metode yang paling contrast yaitu merge, fast-forward (FF) dan rebase. Di beberapa perusahaan teknologi, ada yang tidak boleh menggunakan metode merge secara langsung. Jadi pasti harus menggunakan metode Fast Forward atau Rebase. metode rebase ini adalah metode yang lumayan sulit dan sering conflict, tapi hasilnya kodenya rapi.

# 5. Remote Git Repository dengan github

Pada repository github, sama seperti halnya pada repository git. Namun, pada github ini bisa diakses online sehingga proses kolaborasi kode antar programmer bisa dilakukan dimanapun dan kapanpun. Arti singkatnya github ini repository online. Selain github masih banyak, ada bitbucket, ada gitlens, git tea, dan masih banyak lagi.

Semua repository online konsep dasarnya sebenarnya sama, `git checkout -b nama/branch` -> `git add` / `git rm` -> `git commit` -> `git merge`. Namun, perbedaannya antara repository online dengan repository local itu terletak pada proses merge dan branchnya. Karena branch kita bisa bentrok apabila menggunakan yang sama dengan nama branch programmer lain. Dan ada juga perintah git yang hanya bisa dilakukan di github.

## 5.1 Membuat Repository Baru

Setelah daftar di github.com, sekarang kita akan mebuat repository baru. Pencet tombol + pada halaman utama github atau buka link ini untuk langsung menuju ke form pembuatan repository baru.

> https://github.com/new

Kemudian isi nama repository nya dengan `cobagit` dan klik tombol hijau "Create Repository".

## 5.2 Menghubungkan repository local dengan github



## 5.1 Github fork

Github fork adalah proses untuk `copy paste` kode dari repository online orang lain ke repository online kita. Caranya adalah kita masuk terlebih dahulu ke repository kemudian tekan tombol `Fork` nanti akan ada tampilan untuk memilih tujuan repository online-nya.

Contoh: 
- buka halaman github.com/drosanda/seme-framework
- klik fork nanti akan muncul halaman baru, pada bagian bawah kanan klik tombol fork. Setelah itu repository tersebut akan dipindahkan ke repository online kita


## 5.2 git clone

Git clone adalah perintah untuk `copy paste` kode dari repository online ke komputer kita sebagai repository local sehingga kita bisa memulai merubah kodenya tanpa download secara manual. 

Tadi kita sudah mencoba fork repository, sekarang kita akan clone repository tersebut supaya bisa diakses dari komputer kita.

Contoh `git clone https://github.com/USERNAMEGITHUB/seme-framework`.

## 5.3 git fetch

Perintah git fetch ini untuk mengambil seluruh perubahan yang terjadi pada repository online. repository online ini biasanya kita sebut dengan mana remote repository, yang mana dengan perintah ini kita akan mendapatkan perubahan terkini dari kode yang sudah diubah.

contoh `git fetch --all`

## 5.4 git remote

Perintah git remote ini untuk melihat ada online repository apa saja yang sudah terdaftar pada repository local yang ada di komputer kita. Di beberapa perusahaan IT, biasanya memiliki lebih dari 2 remote repository. Dan itu memiliki kegunaan tertentu. Misalkan remote repository untuk release aplikasi dan remote repository untuk development. 

Nama default dari remote repository ini adalah origin.

Berikut ini contoh penggunaan perintahnya:

```shell
git remote add tca git@git.cenah.co.id:/repo/release/app.git # menambahkan remote repository dengan nama tca

git remote -v # untuk melihat ada remote repository apa saja
# contoh output
#origin  git@github.com:cenahcoid/data_siswa_git_demo.git (fetch)
#origin  git@github.com:cenahcoid/data_siswa_git_demo.git (push)
#tca  git@git.cenah.co.id:/repo/release/app.git (fetch)
#tca  git@git.cenah.co.id:/repo/release/app.git (push)
```

## 5.5 Git push

Perintah git push digunakan untuk mengupload kode kita yang sudah di commit sebelumnya, sehingga kita bisa melakukan proses merging pada online repository seperti github. Contoh `git push origin nama/branch`.

## 5.6 github pull request

Github pull request merupakan fitur unik yang ada pada layanan github sebagai proses review sebelum kode di merging dengan branch lainnya. Dalam hal ini branch feature akan di merge ke branch main. Ini tidak ada perintahnya, ini hanya bisa dilakukan melalui halaman github.

## 5.7 git pull

Perintah git pull hampir mirip dengan git fetch, namun bedanya git pull ini akan otomatis menimpa kode dengan yang terbaru. Kalau git fetch hanya akan mengambil update terakhir dari online repository.

Contoh:
```
git pull origin main
```

# 6. Praktek github fork

- Silakan bukan repository ini -> https://github.com/cenahcoid/data_siswa_git_demo
- kemudian klik tombol fork
- isi dan sesuaikan
- klik tombol fork di kanan bawah

# 7. Praktek Github Pull Request

## 7.1 git clone

Buka CMDER atau poweshell atau terminal, kemudian jalankan perintah clone ini

```
git@github.com:cenahcoid/data_siswa_git_demo.git
```

## 7.2 Membuat branch baru

Buat branch baru beri nama `feature/kelas/nama_lengkap` semua huruf kecil dan jangan pakai spasi. Ganti spasi dengan underscore.

contoh:

```shell
git branch "feature/xi_1/daeng_rosanda"
```

## 7.3 Edit file

Edit file `index.php` tambahkan nama kalian pada kode yang sudah disediakan

## 7.4 git add dan commit

Setelah selesai `git add index.php` kemudian commit. 

Contoh:

```shell
git add index.php
git commit -m "FEAT: Daeng Rosanda - XI-1"
```

## 7.5 git push

Setelah selesai kita akan coba push.

```
git push origin feature/xi_1/daeng_rosanda
```

## 7.6 Buat pull request di github

Buka halaman pull request di github -> https://github.com/cenahcoid/data_siswa_git_demo/pulls kemudian klik tombol New Pull Request. 

Pastikan:
- base branch nya itu main
- compare nya itu branch kalian

Kemudian isi title dan description. Setelah itu klik tombol pull request.

## 7.7 Review code

Nanti salah seorang akan mencoba review, dan memutuskan untuk approve atau tidak.

## 7.8 github merge

Nanti kita akan coba merge

## 7.9 git fetch dan git pull

Setelah di merge, kode di remote repository akan berubah. Sehingga di local repository kita perlu perlu mengeksekusi `git fetch --all`. Setelah itu kita harus pindah ke branch main supaya kode branch main nya bisa diupdate kode terbaru.

`git pull origin main`

Setelah itu lihat perubahannya.


# Cheat Sheet Perintah git
```
git status -> cek status
git log --oneline --graph --all -> cek history
git diff -> lihat perubahan
git checkout -b nama-branch -> bikin branch baru
git pull --rebase origin main -> update main paling aman
git rebase main -> rapikan branch dengan main terbaru
git rebase --abort -> batalkan rebase kalau bingung
git push -f -> push setelah rebase (hanya di branch fitur!)
```
