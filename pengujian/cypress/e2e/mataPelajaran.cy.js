describe('CRUD Data Mata Pelajaran', () => {

  it('CRUD Data Mata Pelajaran Berhasil', () => {

    // =====================================
    // DATA TESTING
    // =====================================
    const randomNumber = Date.now()

    const subjectData = {
      name: `Mata Pelajaran Testing ${randomNumber}`,
      updatedName: `Mapel Edit ${randomNumber}`,
      code: `MP${randomNumber}`,
      updatedCode: `UP${randomNumber}`,
      description: 'Deskripsi mata pelajaran testing Cypress',
      updatedDescription: 'Deskripsi mata pelajaran berhasil diupdate'
    }

    // =====================================
    // LOGIN ADMIN
    // =====================================
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]')
      .should('be.visible')
      .type('admin@sman1donggo.sch.id')

    cy.get('input[name="password"]')
      .should('be.visible')
      .type('password')

    cy.get('button[type="submit"]')
      .click()

    cy.url()
      .should('not.include', '/login')

    // =====================================
    // CREATE DATA MATA PELAJARAN
    // =====================================
    cy.visit('http://127.0.0.1:8000/admin/subjects/create')

    cy.get('input[name="name"]')
      .should('be.visible')
      .type(subjectData.name)

    cy.get('input[name="code"]')
      .should('be.visible')
      .type(subjectData.code)

    // opsional pilih guru pengajar
    cy.get('select[name="teacher_id"]')
      .select(1)

    cy.get('textarea[name="description"]')
      .type(subjectData.description)

    cy.contains('button', 'Simpan Mata Pelajaran')
      .click()

    // validasi redirect
    cy.url()
      .should('include', '/admin/subjects')

    // search data
    cy.get('input[name="search"]')
      .clear()
      .type(subjectData.name)

    cy.wait(2000)

    // validasi create berhasil
    cy.contains('td', subjectData.name)
      .should('be.visible')

    // =====================================
    // READ DATA MATA PELAJARAN
    // =====================================
    cy.contains('tr', subjectData.name)
      .within(() => {

        // tombol lihat
        cy.get('a')
          .first()
          .click({ force: true })

      })

    // validasi halaman detail
    cy.contains('Detail Mata Pelajaran')
      .should('be.visible')

    cy.contains(subjectData.name)
      .should('be.visible')

    cy.contains(subjectData.code)
      .should('be.visible')

    cy.contains(subjectData.description)
      .should('be.visible')

    // =====================================
    // UPDATE DATA MATA PELAJARAN
    // =====================================
    cy.visit('http://127.0.0.1:8000/admin/subjects')

    // cari data lagi
    cy.get('input[name="search"]')
      .clear()
      .type(subjectData.name)

    cy.wait(2000)

    // klik edit
    cy.contains('tr', subjectData.name)
      .within(() => {

        cy.get('a[href*="/edit"]')
          .click({ force: true })

      })

    // validasi halaman edit
    cy.url()
      .should('include', '/edit')

    // update data
    cy.get('input[name="name"]', { timeout: 10000 })
      .should('be.visible')
      .clear()
      .type(subjectData.updatedName)

    cy.get('input[name="code"]')
      .clear()
      .type(subjectData.updatedCode)

    cy.get('textarea[name="description"]')
      .clear()
      .type(subjectData.updatedDescription)

    cy.contains('button', 'Update Mata Pelajaran')
      .click()

    // validasi redirect
    cy.url()
      .should('include', '/admin/subjects')

    // cari hasil update
    cy.get('input[name="search"]')
      .clear()
      .type(subjectData.updatedName)

    cy.wait(2000)

    // validasi update berhasil
    cy.contains('td', subjectData.updatedName)
      .should('be.visible')

    // =====================================
    // DELETE DATA MATA PELAJARAN
    // =====================================

    // handle confirm delete
    cy.on('window:confirm', () => true)

    cy.contains('tr', subjectData.updatedName)
      .within(() => {

        cy.get('form')
          .submit()

      })

    cy.wait(2000)

    // validasi delete berhasil
    cy.contains('td', subjectData.updatedName)
      .should('not.exist')

  })

})