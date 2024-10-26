// Fungsi untuk menampilkan satu section dan menyembunyikan section lainnya
function showSection(sectionId) {
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        section.style.display = 'none'; // Sembunyikan semua section
    });

    const selectedSection = document.getElementById(sectionId);
    if (selectedSection) {
        selectedSection.style.display = 'block'; // Tampilkan section yang dipilih
    }
}

// Fungsi untuk menampilkan kategori produk (Drink atau Food)
function showProductCategory(categoryId) {
    const categories = document.querySelectorAll('.product-category');
    categories.forEach(category => {
        category.style.display = 'none'; // Sembunyikan semua kategori
    });

    const selectedCategory = document.getElementById(categoryId);
    if (selectedCategory) {
        selectedCategory.style.display = 'block'; // Tampilkan kategori yang dipilih
    }
}

// Tampilkan section produk saat halaman pertama kali dimuat
window.addEventListener('load', () => {
    showSection('produk'); // Tampilkan section produk
});
