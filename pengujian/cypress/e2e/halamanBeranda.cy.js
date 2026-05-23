describe('template spec', () => {
  it('Menampilkan Halaman Beranda', () => {
    cy.visit('http://127.0.0.1:8000/')
    
    cy.get('div.swiper').click();
    cy.get('div.swiper-button-next').click();
    cy.get('div.swiper-button-next').click();
    cy.get('div.swiper-button-next').click();
    cy.get('div.swiper-button-next').click();
    cy.get('section.bg-gray-50').click();
    cy.get('section.px-6 div.grid').click();
    cy.get('section.bg-gradient-to-r').click();
    cy.get('section.bg-gray-100').click();
    cy.get('div.justify-center').click();
    cy.get('nav.hidden a[href="http://127.0.0.1:8000"]').click();
  })
})