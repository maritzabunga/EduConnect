// Search Toggle Functionality
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

    searchToggle.addEventListener('click', (e) => {
        e.preventDefault();
        toggleSearch();
    });

    closeSearch.addEventListener('click', (e) => {
        e.preventDefault();
        toggleSearch();
    });

    // Tutup search jika tekan Enter (kirim ke query) atau Escape
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && searchInput.value.trim() !== '') {
            // Kirim keyword ke query search.php
            const keyword = encodeURIComponent(searchInput.value.trim());
            window.location.href = 'search.php?keyword=' + keyword; // Redirect full page ke hasil search
            // Input akan tutup otomatis karena page reload
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