describe('Testing Login Admin', () => {

  it('Menampilkan Halaman Dashboard Admin', () => {

    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]')
      .should('be.visible')
      .type('admin@sman1donggo.sch.id')

    cy.get('input[name="password"]')
      .should('be.visible')
      .type('password')

    cy.get('button.w-full')
      .should('be.visible')
      .click()

    cy.url()
      .should('not.include', '/login')

    cy.contains('Dashboard')
      .should('be.visible')

  })

})