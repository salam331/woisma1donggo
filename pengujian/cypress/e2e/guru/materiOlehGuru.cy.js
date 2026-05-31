describe('Fitur Upload Materi Pembelajaran Guru', () => {

    beforeEach(() => {
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

        cy.url().should('not.include', '/login');
    });

    it('Guru berhasil mengunggah materi pembelajaran baru hingga tersimpan di sistem', () => {
        cy.intercept('GET', '**/guru/materials/get-subjects-by-class/*').as('getSubjects');

        cy.visit('http://127.0.0.1:8000/guru/materials'); 
        cy.get('h1').should('contain', 'Materi Pembelajaran');
        
        cy.contains('Upload Materi').click();
        
        cy.url().should('include', '/guru/materials/create');
        cy.get('h1').should('contain', 'Upload Materi Pembelajaran');

        cy.get('#class_id').select(1);

        cy.wait('@getSubjects').its('response.statusCode').should('eq', 200);

        cy.get('#subject_id').select(1);

        const uniqueTitle = 'Materi Cypress Testing ' + Date.now();
        cy.get('#title').type(uniqueTitle);

        cy.get('#description').type('Ini adalah deskripsi materi otomatis dari pengujian Cypress.');

        cy.get('input#file[type="file"]').selectFile('cypress/fixtures/materi.pdf', { force: true });

        cy.get('#fileName').should('contain', 'materi.pdf');

        cy.get('#is_public_yes').check({ force: true });

        cy.get('button[type="submit"]').contains('Upload Materi').click();

        cy.url().should('include', '/guru/materials');

        cy.get('.bg-green-100.text-green-700').should('be.visible');

        cy.contains(uniqueTitle).should('be.visible');
    }); 

});