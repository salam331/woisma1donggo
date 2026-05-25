describe('Testing Login Siswa dan Download Materi', () => {

  it('Melakukan Login, Akses Menu, dan Mendownload Materi Pertama', () => {

    // 1. PROSES LOGIN SISWA
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]')
      .should('be.visible')
      .type('siswa1@gmail.com')

    cy.get('input[name="password"]')
      .should('be.visible')
      .type('siswa1123')

    cy.get('button.w-full')
      .should('be.visible')
      .click()

    // Verifikasi sukses login ke Dashboard
    cy.url().should('not.include', '/login')
    cy.contains('Dashboard').should('be.visible')

    // ==========================================
    // 2. PROSES AKSES HALAMAN MATERI PEMBELAJARAN
    // ==========================================

    // Mencari menu 'Materi Pembelajaran' di sidebar lalu klik
    cy.contains('Materi Pembelajaran')
      .should('be.visible')
      .click()

    // Verifikasi URL berubah ke halaman index materi siswa
    cy.url().should('include', '/siswa/materials')

    // Memastikan judul halaman benar-benar ter-render
    cy.get('h1').should('contain', 'Materi Pembelajaran')

    // ==========================================
    // 3. PROSES SIMULASI DOWNLOAD MATERI
    // ==========================================

    // Kita periksa apakah ada element tabel materi (jika tidak kosong)
    cy.get('body').then(($body) => {
      
      if ($body.find('table').length > 0) {
        // JIKA MATERI TERSEDIA (TAMPILAN DESKTOP TABLE):
        
        // Ambil nama/judul materi pertama untuk bahan validasi nanti jika diperlukan
        cy.get('table tbody tr').first().find('td').eq(1).then(($titleTd) => {
          const judulMateri = $titleTd.text().trim()
          cy.log('Mengunduh materi: ' + judulMateri)
        })

        // Klik tombol "Download" pada baris pertama di dalam tabel
        cy.get('table tbody tr')
          .first()
          .contains('a', 'Download')
          .should('be.visible')
          .click()

        // Catatan Otomatisasi: File akan masuk ke folder `cypress/downloads/`
        // Jika Anda tahu nama file spesifiknya, Anda bisa memvalidasinya seperti ini:
        // cy.readFile('cypress/downloads/nama_file_materi.pdf').should('exist')

      } else if ($body.find('.md\\:hidden .bg-white').length > 0) {
        // JIKA MATERI TERSEDIA (TAMPILAN MOBILE CARD):
        
        cy.get('.md\\:hidden .bg-white')
          .first()
          .contains('a', 'Download')
          .should('be.visible')
          .click()

      } else {
        // JIKA KONDISI KOSONG ($materials->isEmpty())
        cy.contains('Tidak ada materi').should('be.visible')
        cy.contains('Belum ada materi pembelajaran yang tersedia.').should('be.visible')
      }
    })

  })

})