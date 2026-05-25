describe('CRUD Data Materi Pelajaran', () => {

  it('CRUD Data Materi Berhasil', () => {

    // =====================================
    // DATA TESTING
    // =====================================
    const randomNumber = Date.now()

    const materialData = {
      title: `Materi Testing ${randomNumber}`,
      updatedTitle: `Materi Update ${randomNumber}`,
      description: 'Deskripsi materi testing Cypress',
      updatedDescription: 'Deskripsi materi berhasil diupdate'
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
    // CREATE DATA MATERI
    // =====================================
    cy.visit('http://127.0.0.1:8000/admin/materials/create')

    // pilih guru
    cy.get('select[name="teacher_id"]')
      .should('be.visible')
      .select(3)

    // tunggu dropdown kelas aktif
    cy.get('select[name="class_id"]', { timeout: 10000 })
      .should('not.be.disabled')

    // pilih kelas
    cy.get('select[name="class_id"]')
      .select(1)

    // tunggu dropdown subject aktif
    cy.get('select[name="subject_id"]', { timeout: 10000 })
      .should('not.be.disabled')

    // pilih mata pelajaran
    cy.get('select[name="subject_id"]')
      .select(1)

    // input judul
    cy.get('input[name="title"]')
      .type(materialData.title)

    // input deskripsi
    cy.get('textarea[name="description"]')
      .type(materialData.description)

    // upload file
    cy.get('input[name="file"]')
      .selectFile('cypress/fixtures/materi.pdf', {
        force: true
      })

    // pilih publik
    cy.get('input[id="is_public_yes"]')
      .check({ force: true })

    // submit
    cy.contains('button', 'Upload Materi')
      .click()

    // validasi redirect
    cy.url()
      .should('include', '/admin/materials')

    // search data
    cy.get('input[name="search"]')
      .clear()
      .type(materialData.title)

    cy.wait(2000)

    // validasi create berhasil
    cy.contains('td', materialData.title)
      .should('be.visible')

    // =====================================
    // READ DATA MATERI
    // =====================================
    cy.contains('tr', materialData.title)
      .within(() => {

        // tombol lihat
        cy.get('a[title="Lihat"]')
          .click({ force: true })

      })

    // validasi halaman detail
    cy.contains(materialData.title)
      .should('be.visible')

    cy.contains(materialData.description)
      .should('be.visible')

    // =====================================
    // UPDATE DATA MATERI
    // =====================================
    cy.visit('http://127.0.0.1:8000/admin/materials')

    // cari data lagi
    cy.get('input[name="search"]')
      .clear()
      .type(materialData.title)

    cy.wait(2000)

    // klik edit
    cy.contains('tr', materialData.title)
      .within(() => {

        cy.get('a[title="Edit"]')
          .click({ force: true })

      })

    // validasi halaman edit
    cy.url()
      .should('include', '/edit')

    // update judul
    cy.get('input[name="title"]')
      .clear()
      .type(materialData.updatedTitle)

    // update deskripsi
    cy.get('textarea[name="description"]')
      .clear()
      .type(materialData.updatedDescription)

    // submit update
    cy.contains('button', 'Simpan Perubahan')
      .click()

    // validasi redirect
    cy.url()
      .should('include', '/admin/materials')

    // cari hasil update
    cy.get('input[name="search"]')
      .clear()
      .type(materialData.updatedTitle)

    cy.wait(2000)

    // validasi update berhasil
    cy.contains('td', materialData.updatedTitle)
      .should('be.visible')

    // =====================================
    // DELETE DATA MATERI
    // =====================================

    // handle confirm delete
    cy.on('window:confirm', () => true)

    cy.contains('tr', materialData.updatedTitle)
      .within(() => {

        cy.get('form')
          .submit()

      })

    cy.wait(2000)

    // validasi delete berhasil
    cy.contains('td', materialData.updatedTitle)
      .should('not.exist')

  })

})