describe('Testing Login Guru dan Navigasi Menu', () => {

  it('Menampilkan Halaman Dashboard Guru dan Mengakses Daftar Kelas', () => {

    cy.visit('http://127.0.0.1:8000/login')

    // =====================================================
    // 1. PROSES LOGIN GURU
    // =====================================================
    cy.get('input[name="email"]')
      .should('be.visible')
      .type('guru1@gmail.com')

    cy.get('input[name="password"]')
      .should('be.visible')
      .type('guru1123')

    cy.get('button.w-full')
      .should('be.visible')
      .click()


    // =====================================================
    // 2. VALIDASI DASHBOARD
    // =====================================================
    cy.url().should('not.include', '/login')

    cy.contains('Dashboard')
      .should('be.visible')


    // =====================================================
    // 3. NAVIGASI KE HALAMAN DAFTAR KELAS
    // =====================================================
    // Mencari elemen menu sidebar yang mengandung teks "Kelas"
    cy.contains('Kelas')
      .should('be.visible')
      .click()


    // =====================================================
    // 4. VALIDASI HALAMAN KELAS BERHASIL DIAKSES
    // =====================================================
    // Memastikan URL berubah dan mengandung 'guru/classes' sesuai route Laravel Anda
    cy.url()
      .should('include', '/guru/classes')

    // Memastikan indikator aktif (garis biru vertikal di elemen Blade) muncul atau teks menu menebal
    cy.contains('Kelas')
      .should('have.class', 'text-blue-600')

  })

})