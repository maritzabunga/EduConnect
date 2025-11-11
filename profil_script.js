function loadProfilePicture() {
    const savedPhotoData = localStorage.getItem('userPhotoData');
    const defaultPhoto = 'img/siti.jpg'; 
    const photoToShow = savedPhotoData ? savedPhotoData : defaultPhoto;

    const headerPic = document.getElementById('header-profile-pic');
    const mainProfilePic = document.getElementById('main-profile-pic');
    const editProfilePic = document.getElementById('profile-image-preview');

    if (headerPic) headerPic.src = photoToShow;
    if (mainProfilePic) mainProfilePic.src = photoToShow;
    if (editProfilePic) editProfilePic.src = photoToShow;
}
document.addEventListener('DOMContentLoaded', () => {

    loadProfilePicture();
    const openModalBtn = document.getElementById('open-photo-modal');
    const photoModal = document.getElementById('photo-modal');
    
    if (openModalBtn && photoModal) {
        
        const fileInput = document.getElementById('file-input');
        const viewPhotoBtn = document.getElementById('view-photo-btn');
        const editPhotoBtn = document.getElementById('edit-photo-btn');
        const deletePhotoBtn = document.getElementById('delete-photo-btn');
        const imagePreview = document.getElementById('profile-image-preview');
        const viewPhotoModal = document.getElementById('view-photo-modal');
        const viewPhotoImg = document.getElementById('view-photo-img');
        const viewPhotoCloseBtn = document.getElementById('view-photo-close-btn');
        
        const editForm = document.getElementById('edit-profile-form');
        let stagedPhotoData = null; 
        openModalBtn.addEventListener('click', () => {
            photoModal.style.display = 'flex';
        });

        photoModal.addEventListener('click', (e) => {
            if (e.target === photoModal) {
                photoModal.style.display = 'none';
            }
        });

        viewPhotoBtn.addEventListener('click', () => {
            viewPhotoImg.src = imagePreview.src;
            viewPhotoModal.style.display = 'flex';
            photoModal.style.display = 'none';
        });

        viewPhotoCloseBtn.addEventListener('click', () => {
            viewPhotoModal.style.display = 'none';
        });
        viewPhotoModal.addEventListener('click', (e) => {
            if (e.target === viewPhotoModal) {
                viewPhotoModal.style.display = 'none';
            }
        });

        editPhotoBtn.addEventListener('click', () => {
            fileInput.click();
            photoModal.style.display = 'none';
        });

        deletePhotoBtn.addEventListener('click', () => {
            alert('"Hapus Foto" \nTekan simpan untuk menyimpan perubahan');
            
            const newDefaultPhoto = 'img/avatar_kosong.jpg';
            stagedPhotoData = newDefaultPhoto;
            imagePreview.src = stagedPhotoData; 
            photoModal.style.display = 'none';
        });

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const newPhotoData = event.target.result;
                    stagedPhotoData = newPhotoData;
                    imagePreview.src = stagedPhotoData;
                }
                reader.readAsDataURL(file);
            }
        });

        if (editForm) {
            editForm.addEventListener('submit', () => {
                if (stagedPhotoData !== null) {
                    
                    localStorage.setItem('userPhotoData', stagedPhotoData);
                }
            });
        }
    }

    const searchInput = document.getElementById('search-user-input');
    const userListContainer = document.getElementById('user-list-container');
    const noResultsMessage = document.getElementById('no-results-message');

    if (searchInput && userListContainer && noResultsMessage) {
        
        const allUsers = userListContainer.getElementsByClassName('user-item');

        searchInput.addEventListener('keyup', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            let visibleCount = 0; 

            for (let i = 0; i < allUsers.length; i++) {
                const userItem = allUsers[i];
                const userNameElement = userItem.querySelector('.user-name');
                
                if (userNameElement) {
                    const userName = userNameElement.textContent.toLowerCase();
                    if (userName.includes(searchTerm)) {
                        userItem.style.display = 'block'; 
                        visibleCount++; 
                    } else {
                        userItem.style.display = 'none';
                    }
                }
            }

            if (visibleCount === 0) {
                noResultsMessage.style.display = 'block'; 
            } else {
                noResultsMessage.style.display = 'none';
            }
        });
    }
});