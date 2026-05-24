describe('CRUD Data Kelas', () => {

  it('CRUD Data Kelas Berhasil', () => {

    // =====================================
    // DATA TESTING
    // =====================================
    const randomNumber = Date.now()

    const classData = {
      name: `Kelas Testing ${randomNumber}`,
      updatedName: `Kelas Edit ${randomNumber}`,
      gradeLevel: 'Kelas 10',
      updatedGradeLevel: 'Kelas 11',
      description: 'Deskripsi kelas testing Cypress',
      updatedDescription: 'Deskripsi kelas berhasil diupdate'
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
    // CREATE DATA KELAS
    // =====================================
    cy.visit('http://127.0.0.1:8000/admin/classes/create')

    cy.get('input[name="name"]')
      .should('be.visible')
      .type(classData.name)

    cy.get('select[name="grade_level"]')
      .select(classData.gradeLevel)

    // opsional pilih wali kelas
    cy.get('select[name="teacher_id"]')
      .select(1)

    cy.get('textarea[name="description"]')
      .type(classData.description)

    cy.contains('button', 'Simpan Kelas')
      .click()

    // validasi redirect
    cy.url()
      .should('include', '/admin/classes')

    // search data
    cy.get('input[name="search"]')
      .clear()
      .type(classData.name)

    cy.wait(2000)

    // validasi create berhasil
    cy.contains('td', classData.name)
      .should('be.visible')

    // =====================================
    // READ DATA KELAS
    // =====================================
    cy.contains('tr', classData.name)
      .within(() => {

        // tombol lihat
        cy.get('a')
          .first()
          .click({ force: true })

      })

    // validasi halaman detail
    cy.contains('Detail Kelas')
      .should('be.visible')

    cy.contains(classData.name)
      .should('be.visible')

    cy.contains(classData.gradeLevel)
      .should('be.visible')

    cy.contains(classData.description)
      .should('be.visible')

    // =====================================
    // UPDATE DATA KELAS
    // =====================================
    cy.visit('http://127.0.0.1:8000/admin/classes')

    // cari data lagi
    cy.get('input[name="search"]')
      .clear()
      .type(classData.name)

    cy.wait(2000)

    // klik edit
    cy.contains('tr', classData.name)
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
      .type(classData.updatedName)

    cy.get('select[name="grade_level"]')
      .select(classData.updatedGradeLevel)

    cy.get('textarea[name="description"]')
      .clear()
      .type(classData.updatedDescription)

    cy.contains('button', 'Update Kelas')
      .click()

    // validasi redirect
    cy.url()
      .should('include', '/admin/classes')

    // cari hasil update
    cy.get('input[name="search"]')
      .clear()
      .type(classData.updatedName)

    cy.wait(2000)

    // validasi update berhasil
    cy.contains('td', classData.updatedName)
      .should('be.visible')

    // =====================================
    // DELETE DATA KELAS
    // =====================================

    // handle confirm delete
    cy.on('window:confirm', () => true)

    cy.contains('tr', classData.updatedName)
      .within(() => {

        cy.get('form')
          .submit()

      })

    cy.wait(2000)

    // validasi delete berhasil
    cy.contains('td', classData.updatedName)
      .should('not.exist')

  })

})