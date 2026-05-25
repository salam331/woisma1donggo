describe('Testing Login Siswa dan Cek Jadwal', () => {

  it('Melakukan Login dan Mengakses Halaman Jadwal Pelajaran', () => {

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
    // 2. PROSES AKSES JADWAL PELAJARAN
    // ==========================================

    // Mencari menu 'Jadwal Pelajaran' di sidebar lalu klik
    cy.contains('Jadwal Pelajaran')
      .should('be.visible')
      .click()

    // Verifikasi URL berubah ke halaman jadwal pelajaran siswa
    cy.url().should('include', '/siswa/schedules')

    // Opsional: Memastikan judul atau elemen di halaman jadwal sudah muncul
    // Anda bisa menyesuaikan teks ini dengan apa yang ada di halaman jadwal Anda (misal: "Jadwal Kuliah" / "Hari")
    cy.get('body').should('contain', 'Jadwal') 
  })

})