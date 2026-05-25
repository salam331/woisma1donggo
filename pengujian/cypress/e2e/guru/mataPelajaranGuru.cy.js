describe('Testing Dashboard dan Mata Pelajaran Guru', () => {

  // beforeEach akan dijalankan sebelum setiap blok it()
  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]')
      .should('be.visible')
      .type('guru1@gmail.com')

    cy.get('input[name="password"]')
      .should('be.visible')
      .type('guru1123')

    cy.get('button.w-full')
      .should('be.visible')
      .click()

    // Pastikan login berhasil sebelum lanjut ke test berikutnya
    cy.url().should('not.include', '/login')
  })

  it('Menampilkan Halaman Dashboard Guru', () => {
    cy.contains('Dashboard').should('be.visible')
  })

  it('Mengakses halaman Daftar Mata Pelajaran dan melihat Detail', () => {
    // Kunjungi URL index mata pelajaran. 
    // Catatan: Sesuaikan URL ini jika route-nya berbeda (misal: /guru/subjects)
    // Atau bisa juga menggunakan cy.get('sidebar-link-selector').click() jika ingin simulasi klik dari menu
    cy.visit('http://127.0.0.1:8000/guru/subjects') 

    // Verifikasi bahwa kita berada di halaman daftar mata pelajaran (Index)
    // Mengacu pada @section('title', 'Mata Pelajaran - Guru Dashboard') di index.blade.php
    cy.contains('Mata Pelajaran').should('be.visible')

    // Cypress mencari tombol "Lihat Detail" dari grid card mata pelajaran.
    // Kita gunakan .first() agar Cypress mengklik mata pelajaran pertama yang ada di layar.
    cy.contains('Lihat Detail')
      .should('be.visible')
      .first()
      .click()

    // Verifikasi bahwa kita sudah berada di halaman detail (Show)
    // Mengacu pada <h1 class="...">Detail Mata Pelajaran</h1> di show.blade.php
    cy.contains('Detail Mata Pelajaran').should('be.visible')
    
    // Verifikasi komponen lain yang ada di dalam show.blade.php untuk memastikan render sempurna
    // cy.contains('Jadwal Mengajar').should('be.visible')
    // cy.contains('Materi Pembelajaran').should('be.visible')
    // cy.contains('Aksi Cepat').should('be.visible')
  })

  // it('Menampilkan empty state jika tidak ada mata pelajaran', () => {
    // Opsional: Jika kamu punya user guru yang belum memiliki mata pelajaran
    // Skenario ini menguji bagian @else 'Tidak ada mata pelajaran' di index.blade.php
    // cy.visit('http://127.0.0.1:8000/guru/subjects')
    // cy.contains('Tidak ada mata pelajaran').should('be.visible')
    // cy.contains('Anda belum mengajar mata pelajaran apapun.').should('be.visible')
  // })

})