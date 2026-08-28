CREATE DATABASE IF NOT EXISTS db_perpustakaan;
USE db_perpustakaan;

CREATE TABLE Kategori (
    Kategori_ID INT AUTO_INCREMENT PRIMARY KEY,
    Nama_Kategori VARCHAR(100)
);

CREATE TABLE Buku (
    Buku_ID INT AUTO_INCREMENT PRIMARY KEY,
    Judul_Buku VARCHAR(150),
    Kategori_ID INT,
    FOREIGN KEY (Kategori_ID) REFERENCES Kategori(Kategori_ID)
);

CREATE TABLE Anggota (
    Anggota_ID VARCHAR(20) PRIMARY KEY,
    Nama_Anggota VARCHAR(100),
    Tanggal_Lahir_Anggota DATE,
    Jenis_Kelamin_Anggota VARCHAR(20),
    Alamat_Anggota TEXT
);

CREATE TABLE Pinjam (
    No_Pinjam VARCHAR(20) PRIMARY KEY,
    Anggota_ID VARCHAR(20),
    Tanggal_Pinjam DATE,
    Buku_ID INT,
    Keperluan_Pinjam VARCHAR(100),
    Denda_Telat DECIMAL(10,0),
    FOREIGN KEY (Anggota_ID) REFERENCES Anggota(Anggota_ID),
    FOREIGN KEY (Buku_ID) REFERENCES Buku(Buku_ID)
);

-- ISI DATA CONTOH
INSERT INTO Kategori (Nama_Kategori) VALUES ('Teknologi'), ('Ekonomi'), ('Sastra');
INSERT INTO Buku (Judul_Buku, Kategori_ID) VALUES ('Dasar Pemrograman Web', 1), ('Pengantar Akuntansi', 2), ('Bumi Manusia', 3);
INSERT INTO Anggota (Anggota_ID, Nama_Anggota, Tanggal_Lahir_Anggota, Jenis_Kelamin_Anggota, Alamat_Anggota) VALUES 
('AG.002', 'Rahmat Hidayat', '2003-01-15', 'Laki-Laki', 'Banda Aceh'), 
('AG.007', 'Salsabila Putri', '2005-08-20', 'Perempuan', 'Aceh Besar'), 
('AG.004', 'Teuku Fajar', '1989-05-10', 'Laki-Laki', 'Sigli');