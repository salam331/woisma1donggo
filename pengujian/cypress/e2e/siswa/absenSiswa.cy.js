describe('Testing Login Siswa, Cek Jadwal, dan Absensi', () => {

  it('Melakukan Login dan Mengakses Semua Menu Utama Siswa', () => {

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

    // Verifikasi Sukses Login
    cy.url().should('not.include', '/login')
    cy.contains('Dashboard').should('be.visible')

    // ==========================================
    // 3. AKSES RIWAYAT ABSENSI
    // ==========================================
    
    // Mencari menu 'Riwayat Absensi' di sidebar lalu klik
    cy.contains('Riwayat Absensi')
      .should('be.visible')
      .click()

    // Verifikasi URL berubah ke halaman absensi siswa
    cy.url().should('include', '/siswa/attendances')

    // Memastikan halaman absensi memuat data/konten
    cy.get('body').should('contain', 'Absensi')
  })

})