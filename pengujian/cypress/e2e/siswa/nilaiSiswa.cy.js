describe('Testing Login Siswa dan Cek Nilai', () => {

  it('Melakukan Login dan Langsung Mengakses Halaman Nilai', () => {

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

    cy.contains('Nilai')
      .should('be.visible')
      .click()

    cy.url().should('include', '/siswa/grades')

    cy.get('body').should('contain', 'Nilai') 
  })

})