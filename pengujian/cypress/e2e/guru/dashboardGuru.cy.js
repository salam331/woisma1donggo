describe('Testing Login Guru', () => {

  it('Menampilkan Halaman Dashboard Guru', () => {

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

    cy.url()
      .should('not.include', '/login')

    cy.contains('Dashboard')
      .should('be.visible')

  })

})