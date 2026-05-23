describe('Testing Login Multi Role', () => {

  it('Login Admin Berhasil', () => {

    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]')
      .should('be.visible')
      .type('admin@sman1donggo.sch.id')

    cy.get('input[name="password"]')
      .should('be.visible')
      .type('password')

    cy.get('button[type="submit"]')
      .should('be.visible')
      .click()

    cy.url().should('not.include', '/login')

    cy.contains('Dashboard')
      .should('be.visible')

  })

  it('Login Guru Berhasil', () => {

    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]')
      .should('be.visible')
      .type('guru1@gmail.com')

    cy.get('input[name="password"]')
      .should('be.visible')
      .type('guru1123')

    cy.get('button[type="submit"]')
      .should('be.visible')
      .click()

    cy.url().should('not.include', '/login')

    cy.contains('Dashboard')
      .should('be.visible')

  })

  it('Login Siswa Berhasil', () => {

    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]')
      .should('be.visible')
      .type('siswa1@gmail.com')

    cy.get('input[name="password"]')
      .should('be.visible')
      .type('siswa1123')

    cy.get('button[type="submit"]')
      .should('be.visible')
      .click()

    cy.url().should('not.include', '/login')

    cy.contains('Dashboard')
      .should('be.visible')

  })

})