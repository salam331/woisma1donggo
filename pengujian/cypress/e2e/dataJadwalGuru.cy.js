describe('Testing Dashboard dan Navigasi Guru', () => {

  it('Guru berhasil login dan menavigasi ke Halaman Jadwal Pelajaran', () => {
    
    // --- STEP 1: PROSES LOGIN GURU ---
    cy.visit('http://127.0.0.1:8000/login');

    cy.get('input[name="email"]')
      .should('be.visible')
      .type('guru1@gmail.com');

    cy.get('input[name="password"]')
      .should('be.visible')
      .type('guru1123');

    cy.get('button.w-full')
      .should('be.visible')
      .click();

    // Validasi login sukses & masuk dashboard
    cy.url().should('not.include', '/login');
    cy.contains('Dashboard').should('be.visible');


    // --- STEP 2: NAVIGASI KE MENU JADWAL PELAJARAN ---
    
    // Mencari link sidebar yang berisi teks "Jadwal Pelajaran" lalu mengkliknya
    cy.contains('span', 'Jadwal Pelajaran')
      .should('be.visible')
      .click();

    // Validasi Akhir: Memastikan URL berubah ke halaman jadwal mengajar guru
    cy.url().should('include', '/guru/schedules');

  });

});