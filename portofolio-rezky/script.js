/**
 * Script Interaktif Portofolio - Rezky Awalya
 * Fitur:
 * 1. Dark Mode / Light Mode Switcher (tersimpan di localStorage)
 * 2. Filter Kategori Proyek & Galeri
 * 3. Lightbox Modal Popup untuk Galeri Karya & Prestasi
 */

document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initProjectFilter();
    initLightbox();
});

/* ==========================================================================
   1. DARK / LIGHT THEME MANAGER
   ========================================================================== */
function initTheme() {
    const themeToggleBtns = document.querySelectorAll('.theme-toggle-btn');
    const savedTheme = localStorage.getItem('rezky_portfolio_theme');
    
    // Terapkan preferensi tersimpan, atau preferensi sistem browser
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    const initialTheme = savedTheme ? savedTheme : (prefersDark ? 'dark' : 'light');

    applyTheme(initialTheme);

    themeToggleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const isDark = document.body.classList.contains('dark-theme');
            const newTheme = isDark ? 'light' : 'dark';
            applyTheme(newTheme);
            localStorage.setItem('rezky_portfolio_theme', newTheme);
        });
    });
}

function applyTheme(theme) {
    const isDark = theme === 'dark';
    if (isDark) {
        document.body.classList.add('dark-theme');
    } else {
        document.body.classList.remove('dark-theme');
    }

    // Perbarui ikon dan label pada tombol toggle di halaman
    const themeToggleBtns = document.querySelectorAll('.theme-toggle-btn');
    themeToggleBtns.forEach(btn => {
        if (isDark) {
            btn.innerHTML = '<span class="theme-icon">&#9728;&#65039;</span> <span class="theme-text">Light Mode</span>';
            btn.setAttribute('title', 'Beralih ke Mode Terang');
        } else {
            btn.innerHTML = '<span class="theme-icon">&#127769;</span> <span class="theme-text">Dark Mode</span>';
            btn.setAttribute('title', 'Beralih ke Mode Gelap');
        }
    });
}

/* ==========================================================================
   2. FILTER KATEGORI PROYEK
   ========================================================================== */
function initProjectFilter() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectItems = document.querySelectorAll('.project-card-item');

    if (!filterButtons.length || !projectItems.length) return;

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Update active state pada tombol
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const filterValue = button.getAttribute('data-filter');

            projectItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category') || '';
                
                if (filterValue === 'all' || itemCategory.split(' ').includes(filterValue)) {
                    item.style.display = '';
                    item.classList.remove('filter-hidden');
                    item.classList.add('filter-visible');
                } else {
                    item.style.display = 'none';
                    item.classList.add('filter-hidden');
                    item.classList.remove('filter-visible');
                }
            });
        });
    });
}

/* ==========================================================================
   3. LIGHTBOX / MODAL POPUP PREVIEW
   ========================================================================== */
function initLightbox() {
    const modal = document.getElementById('lightbox-modal');
    if (!modal) return;

    const modalImg = document.getElementById('lightbox-img');
    const modalTitle = document.getElementById('lightbox-title');
    const modalBadge = document.getElementById('lightbox-badge');
    const modalDesc = document.getElementById('lightbox-desc');
    const closeBtn = document.getElementById('lightbox-close');

    // Tangani klik pada elemen yang memiliki class .lightbox-trigger
    const triggers = document.querySelectorAll('.lightbox-trigger');

    triggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();

            const imgSrc = trigger.getAttribute('data-img') || trigger.querySelector('img')?.getAttribute('src') || '';
            const title = trigger.getAttribute('data-title') || trigger.querySelector('h4, h3')?.innerText || 'Pratinjau Proyek';
            const badge = trigger.getAttribute('data-badge') || trigger.querySelector('.skill-badge')?.innerText || '';
            const desc = trigger.getAttribute('data-desc') || trigger.getAttribute('title') || 'Dokumentasi karya dan proyek portfolio.';

            modalImg.src = imgSrc;
            modalImg.alt = title;
            modalTitle.textContent = title;
            
            if (badge) {
                modalBadge.textContent = badge;
                modalBadge.style.display = 'inline-block';
            } else {
                modalBadge.style.display = 'none';
            }

            modalDesc.textContent = desc;

            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Kunci scroll layar belakang
        });
    });

    // Tutup modal via tombol X
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    // Tutup modal jika klik di luar box (overlay backdrop)
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });

    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}
