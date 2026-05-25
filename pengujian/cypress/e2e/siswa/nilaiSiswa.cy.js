describe('Testing Login Siswa dan Cek Nilai', () => {

  it('Melakukan Login dan Langsung Mengakses Halaman Nilai', () => {

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
    // 2. PROSES AKSES HALAMAN NILAI
    // ==========================================

    // Mencari menu 'Nilai' di sidebar lalu klik
    cy.contains('Nilai')
      .should('be.visible')
      .click()

    // Verifikasi URL berubah ke halaman nilai siswa
    cy.url().should('include', '/siswa/grades')

    // Memastikan konten halaman nilai berhasil dimuat
    // Anda bisa menyesuaikan teks 'Mata Pelajaran' atau 'Rapor' sesuai isi halaman Anda
    cy.get('body').should('contain', 'Nilai') 
  })

})