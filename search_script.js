document.addEventListener('DOMContentLoaded', () => {
    // Elemen DOM untuk search
    const searchToggle = document.getElementById('search-toggle');
    const searchWrapper = document.getElementById('search-wrapper');
    const searchInput = document.getElementById('search-input');
    const closeSearch = document.getElementById('close-search');

    if (searchToggle && searchWrapper && searchInput && closeSearch) {
        let isExpanded = false;

        function toggleSearch() {
            isExpanded = !isExpanded;
            
            if (isExpanded) {
                // Expand: Sembunyikan ikon search, tampilkan input dan close
                searchToggle.style.display = 'none';
                searchInput.style.display = 'block';
                closeSearch.style.display = 'block';
                searchWrapper.classList.add('expanded');
                searchInput.focus(); // Auto-focus ke input
            } else {
                // Collapse: Kembali ke ikon search
                searchToggle.style.display = 'block';
                searchInput.style.display = 'none';
                closeSearch.style.display = 'none';
                searchWrapper.classList.remove('expanded');
                searchInput.value = ''; // Kosongkan input
            }
        }

        // Event klik toggle
        searchToggle.addEventListener('click', (e) => {
            e.preventDefault();
            toggleSearch();
        });

        // Event klik close
        closeSearch.addEventListener('click', (e) => {
            e.preventDefault();
            toggleSearch();
        });

        // Event keypress: Enter untuk search DB, Escape untuk tutup
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && searchInput.value.trim() !== '') {
                const keyword = encodeURIComponent(searchInput.value.trim());
                window.location.href = 'search.php?keyword=' + keyword; // Full redirect ke search.php
            } else if (e.key === 'Escape') {
                toggleSearch();
            }
        });

        // Tutup jika klik di luar wrapper
        document.addEventListener('click', (e) => {
            if (!searchWrapper.contains(e.target) && isExpanded) {
                toggleSearch();
            }
        });
    }

    // Search local user list (dari kode awal, jika masih dibutuhkan untuk filter user di halaman profil)
    const localSearchInput = document.getElementById('search-user-input');
    const userListContainer = document.getElementById('user-list-container');
    const noResultsMessage = document.getElementById('no-results-message');

    if (localSearchInput && userListContainer && noResultsMessage) {
        const allUsers = userListContainer.getElementsByClassName('user-item');

        localSearchInput.addEventListener('keyup', (e) => {
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