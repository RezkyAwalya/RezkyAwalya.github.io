const root = document.documentElement;
const themeToggle = document.getElementById("themeToggle");

function setTheme(theme) {
  root.setAttribute("data-theme", theme);
  localStorage.setItem("portfolio-theme", theme);
  if (themeToggle) themeToggle.textContent = theme === "dark" ? "☀" : "☾";
}

const savedTheme = localStorage.getItem("portfolio-theme");
setTheme(savedTheme || "light");

if (themeToggle) {
  themeToggle.addEventListener("click", () => {
    const next = root.getAttribute("data-theme") === "dark" ? "light" : "dark";
    setTheme(next);
  });
}

const revealItems = document.querySelectorAll(".reveal");
const revealObserver = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add("visible");
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });

revealItems.forEach(item => revealObserver.observe(item));

const filterButtons = document.querySelectorAll(".filter-btn");
const projectCards = document.querySelectorAll(".project-card[data-category]");

filterButtons.forEach(button => {
  button.addEventListener("click", () => {
    filterButtons.forEach(btn => btn.classList.remove("active"));
    button.classList.add("active");

    const filter = button.dataset.filter;
    projectCards.forEach(card => {
      const categories = card.dataset.category.split(" ");
      const show = filter === "all" || categories.includes(filter);
      card.style.display = show ? "" : "none";
    });
  });
});

const modal = document.getElementById("projectModal");
const modalTitle = document.getElementById("modalTitle");
const modalDescription = document.getElementById("modalDescription");

document.querySelectorAll(".project-detail").forEach(button => {
  button.addEventListener("click", () => {
    const card = button.closest(".project-card");
    modalTitle.textContent = card.dataset.title;
    modalDescription.textContent = card.dataset.description;
    modal.classList.add("open");
    modal.setAttribute("aria-hidden", "false");
    document.body.style.overflow = "hidden";
  });
});

function closeModal() {
  if (!modal) return;
  modal.classList.remove("open");
  modal.setAttribute("aria-hidden", "true");
  document.body.style.overflow = "";
}
document.querySelector(".modal-close")?.addEventListener("click", closeModal);
document.querySelector(".modal-backdrop")?.addEventListener("click", closeModal);
document.addEventListener("keydown", event => {
  if (event.key === "Escape") closeModal();
});

const contactForm = document.getElementById("contactForm");
if (contactForm) {
  contactForm.addEventListener("submit", event => {
    event.preventDefault();

    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const message = document.getElementById("message");
    const feedback = document.getElementById("formFeedback");

    const errors = {
      name: document.getElementById("nameError"),
      email: document.getElementById("emailError"),
      message: document.getElementById("messageError")
    };

    Object.values(errors).forEach(el => el.textContent = "");
    feedback.textContent = "";

    let valid = true;

    if (name.value.trim().length < 2) {
      errors.name.textContent = "Nama minimal 2 karakter.";
      valid = false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value.trim())) {
      errors.email.textContent = "Masukkan email yang valid.";
      valid = false;
    }

    if (message.value.trim().length < 10) {
      errors.message.textContent = "Pesan minimal 10 karakter.";
      valid = false;
    }

    if (valid) {
      feedback.textContent = "Form berhasil divalidasi. Pesan siap dikirim.";
      contactForm.reset();
    }
  });
}


// Visual documentation lightbox
(() => {
  const modals = document.querySelectorAll('#imageModal');
  if (!modals.length) return;

  const modal = modals[0];
  const preview = modal.querySelector('#imageModalPreview');
  const title = modal.querySelector('#imageModalTitle');
  const caption = modal.querySelector('#imageModalCaption');

  const openImageModal = (button) => {
    preview.src = button.dataset.galleryImage || '';
    preview.alt = button.dataset.galleryTitle || 'Dokumentasi portfolio';
    title.textContent = button.dataset.galleryTitle || '';
    caption.textContent = button.dataset.galleryCaption || '';
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');
  };

  const closeImageModal = () => {
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    preview.src = '';
    document.body.classList.remove('modal-open');
  };

  document.querySelectorAll('[data-gallery-image]').forEach(button => {
    button.addEventListener('click', () => openImageModal(button));
  });

  modal.querySelectorAll('[data-close-image-modal]').forEach(el => {
    el.addEventListener('click', closeImageModal);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && modal.classList.contains('is-open')) closeImageModal();
  });
})();
