<?php include 'header.php'; ?>

<div class="page-container">
  <!-- Judul & Deskripsi -->
  <section class="page-header">
    <div>
      <h1>Bank Materi Ajar</h1>
      <p>Temukan berbagai materi pembelajaran yang telah dikurasi untuk menunjang proses belajar Anda.</p>
    </div>
  </section>

  <!-- Search & Kategori -->
  <div class="search-filter">
    <div class="search-bar">
      <input type="text" placeholder="Cari materi pembelajaran...">
      <button class="filter-btn">Cari</button>
    </div>

    <div class="category-list">
      <button class="active">Semua</button>
      <button>Pemrograman</button>
      <button>Desain</button>
      <button>Data Science</button>
      <button>Marketing</button>
      <button>Bahasa</button>
    </div>
  </div>

  <!-- Daftar Materi -->
  <div class="card-container">
    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1581090700227-1e37b190418e?auto=format&fit=crop&w=800&q=60" alt="Materi Pemrograman">
        <span class="label blue">Pemrograman</span>
      </div>
      <a href="akses_materi.php?id=1" class="card-link">
  <div class="card-body">
    <h3>Pengenalan Algoritma dan Struktur Data</h3>
    <p>Pelajari dasar-dasar algoritma dan struktur data yang penting untuk pemrograman modern.</p>
    <div class="meta">
      <span>1234 kali dilihat</span>
      <span>45 menit</span>
    </div>
    <div class="footer">Dr. Budi Santoso</div>
  </div>
</a>
    </div>

    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1603988363607-41b1dc8d6600?auto=format&fit=crop&w=800&q=60" alt="Materi Desain">
        <span class="label purple">Desain</span>
      </div>
      <div class="card-body">
        <h3>Desain UI/UX untuk Pemula</h3>
        <p>Memahami prinsip dasar desain interface dan user experience dengan cara praktis.</p>
        <div class="meta">
          <span>987 kali dilihat</span>
          <span>60 menit</span>
        </div>
        <div class="footer">Sarah Wijaya, M.Des</div>
      </div>
    </div>

    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=800&q=60" alt="Materi Data Science">
        <span class="label green">Data Science</span>
      </div>
      <div class="card-body">
        <h3>Machine Learning Dasar dengan Python</h3>
        <p>Eksplorasi konsep machine learning menggunakan Python untuk analisis data modern.</p>
        <div class="meta">
          <span>2156 kali dilihat</span>
          <span>90 menit</span>
        </div>
        <div class="footer">Prof. Ahmad Hidayat</div>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="jelajah_materi.css">
