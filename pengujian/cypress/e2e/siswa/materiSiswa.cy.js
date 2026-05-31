describe('Testing Login Siswa dan Download Materi', () => {

  it('Melakukan Login, Akses Menu, dan Mendownload Materi Pelajaran', () => {

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
    cy.url().should('not.include', '/login')
    cy.contains('Dashboard').should('be.visible')

    cy.contains('Materi Pembelajaran')
      .should('be.visible')
      .click()

    cy.url().should('include', '/siswa/materials')

    cy.get('h1').should('contain', 'Materi Pembelajaran')

    cy.get('body').then(($body) => {
      
      if ($body.find('table').length > 0) {
        cy.get('table tbody tr').first().find('td').eq(1).then(($titleTd) => {
          const judulMateri = $titleTd.text().trim()
          cy.log('Mengunduh materi: ' + judulMateri)
        })

        cy.get('table tbody tr')
          .first()
          .contains('a', 'Download')
          .should('be.visible')
          .click()

      } else if ($body.find('.md\\:hidden .bg-white').length > 0) {
        
        cy.get('.md\\:hidden .bg-white')
          .first()
          .contains('a', 'Download')
          .should('be.visible')
          .click()

      } else {
        cy.contains('Tidak ada materi').should('be.visible')
        cy.contains('Belum ada materi pembelajaran yang tersedia.').should('be.visible')
      }
    })

  })

})