<?php
session_start();
include 'header.php'; 
?>

<div class="content-wrapper-center">
    <div class="card-simple">
        
        <form id="edit-profile-form" action="biodata.php" method="POST">
            
            <div class="edit-profile-pic">
                    <img src="img/siti.jpg" alt="Foto Profil" class="profile-pic-medium" id="profile-image-preview">                
                    <button type="button" class="camera-icon-btn" id="open-photo-modal">
                    <i class="fas fa-camera"></i>
                </button>
                <input type="file" id="file-input" accept="image/*" style="display: none;">
            </div>

            <h1 class="profile-name-center"><?php echo htmlspecialchars($_SESSION['nama_pengguna']); ?></h1>
            <span class="status-badge-blue"><?php echo htmlspecialchars($_SESSION['status']); ?></span>

            <div class="edit-form-grid">
                <div class="form-group">
                    <label for="nama_pengguna">Nama Pengguna</label>
                    <input type="text" id="nama_pengguna" name="nama_pengguna" value="<?php echo htmlspecialchars($_SESSION['nama_pengguna']); ?>">
                </div>
                <div class="form-group">
                    <label for="usia">Usia</label>
                    <input type="text" id="usia" name="usia" value="<?php echo htmlspecialchars($_SESSION['usia']); ?>">
                </div>
                <div class="form-group">
                    <label for="ttl">Tempat, Tanggal Lahir</label>
                    <input type="text" id="ttl" name="ttl" value="<?php echo htmlspecialchars($_SESSION['ttl']); ?>">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-green">Simpan</button>
                <a href="biodata.php" class="btn btn-red">Batal</a>
            </div>

       </form>
 </div>
</div>

<div class="photo-modal-overlay" id="photo-modal">
<div class="photo-modal-content">
 <button type="button" class="modal-button" id="view-photo-btn">Lihat Foto</button>
<button type="button" class="modal-button" id="edit-photo-btn">Edit Foto</button>
<button type="button" class="modal-button" id="delete-photo-btn">Hapus Foto</button>
 </div>
</div>

<div class="view-photo-modal-overlay" id="view-photo-modal">
<span class="view-photo-close" id="view-photo-close-btn">&times;</span>
<img class="view-photo-modal-content" id="view-photo-img">
</div>


</div> <script src="profil_script.js"></script>
</body>
</html>