document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('.section');
    const buttons = document.querySelectorAll('.menu-button');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {

                const id = entry.target.id;

                buttons.forEach(button => button.classList.remove('active'));

                const activeButton = document.querySelector(`.menu-button[onclick*="${id}"]`);
                if (activeButton) {
                    activeButton.classList.add('active');
                }
            }
        });
    }, {
        root: null, 
        threshold: 0.6 
    });

    sections.forEach(section => observer.observe(section));
});

function scrollToSection(sectionId, button) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }

    const buttons = document.querySelectorAll('.menu-button');
    buttons.forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
}

function copyToClipboard(elementId) {
    var text = document.getElementById(elementId).innerText;
    var textArea = document.createElement("textarea");
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("copy");
    document.body.removeChild(textArea);

    // Membuat pop-up kecil
    var alertBox = document.createElement("div");
    alertBox.innerText = "Nomor rekening telah disalin!";
    alertBox.style.position = "fixed";
    alertBox.style.top = "80%";  // Mengatur posisi sedikit lebih bawah dari tengah
    alertBox.style.left = "50%";
    alertBox.style.transform = "translateX(-50%)"; // Hanya horizontal center
    alertBox.style.padding = "10px";
    alertBox.style.backgroundColor = "#4CAF50";
    alertBox.style.color = "white";
    alertBox.style.borderRadius = "10px";
    alertBox.style.zIndex = "9999";

    // Menampilkan pop-up dan menghapusnya setelah 2 detik
    document.body.appendChild(alertBox);
    setTimeout(function() {
        document.body.removeChild(alertBox);
    }, 2000);
}


const thumbnails = document.querySelectorAll('.thumbnails img');
const mainImages = document.querySelectorAll('.main-image img');
let currentIndex = 0;
let autoSlideInterval;

// Fungsi untuk mengatur gambar aktif
function setActiveImage(index) {
  // Hapus kelas aktif dari semua thumbnail dan gambar utama
  thumbnails.forEach((thumb) => thumb.classList.remove('active'));
  mainImages.forEach((img) => img.classList.remove('active'));

  // Tambahkan kelas aktif ke thumbnail dan gambar yang dipilih
  thumbnails[index].classList.add('active');
  mainImages[index].classList.add('active');
}

// Fungsi untuk auto-slide
function startAutoSlide() {
  autoSlideInterval = setInterval(() => {
    currentIndex = (currentIndex + 1) % mainImages.length; // Perpindahan ke gambar berikutnya
    setActiveImage(currentIndex);
  }, 3000); // Interval waktu (3 detik)
}

// Inisialisasi awal saat halaman dimuat
setActiveImage(currentIndex); // Set thumbnail pertama dan gambar utama sebagai aktif

// Hentikan auto-slide ketika thumbnail di-klik
thumbnails.forEach((thumbnail, index) => {
  thumbnail.addEventListener('click', () => {
    clearInterval(autoSlideInterval); // Hentikan auto-slide
    currentIndex = index; // Set index ke gambar yang di-klik
    setActiveImage(currentIndex); // Tampilkan gambar yang dipilih
    startAutoSlide(); // Mulai ulang auto-slide
  });
});

// Mulai auto-slide saat halaman dimuat
startAutoSlide();

// Logika drag untuk thumbnail slider
const thumbnailContainer = document.querySelector('.thumbnails');
let isDown = false;
let startX, scrollLeft;

thumbnailContainer.addEventListener('mousedown', (e) => {
  isDown = true;
  thumbnailContainer.classList.add('active');
  startX = e.pageX - thumbnailContainer.offsetLeft;
  scrollLeft = thumbnailContainer.scrollLeft;
});

thumbnailContainer.addEventListener('mouseleave', () => {
  isDown = false;
});

thumbnailContainer.addEventListener('mouseup', () => {
  isDown = false;
});

thumbnailContainer.addEventListener('mousemove', (e) => {
  if (!isDown) return;
  e.preventDefault();
  const x = e.pageX - thumbnailContainer.offsetLeft;
  const walk = (x - startX) * 2; // Kecepatan scroll (modifikasi sesuai kebutuhan)
  thumbnailContainer.scrollLeft = scrollLeft - walk;
});
