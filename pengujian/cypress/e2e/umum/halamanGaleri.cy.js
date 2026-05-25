describe('Testing Halaman Gallery', () => {

  it('Membuka halaman gallery dan melihat gambar', () => {

    cy.visit('http://127.0.0.1:8000/')

    cy.get('nav.hidden a[href="http://127.0.0.1:8000/gallery"]')
      .should('be.visible')
      .click()

    cy.url().should('include', '/gallery')

    cy.scrollTo('center')

    cy.get('div.mb-12 p.dark\\:text-gray-400')
      .should('be.visible')

    cy.get('img[alt="hjsasa"]')
      .should('be.visible')
      .click()

    cy.wait(1000)

  })

})