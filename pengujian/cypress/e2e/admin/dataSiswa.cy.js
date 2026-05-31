describe('CRUD Data Siswa', () => {
  const randomNumber = Date.now()

  const studentData = {
    nis: `${randomNumber}`,
    name: `salam testing ${randomNumber}`,
    updatedName: `salam edit ${randomNumber}`,
    email: `salam${randomNumber}@gmail.com`,
    password: 'password123',
    phone: '081234567890',
    updatedPhone: '089999999999',
    gender: 'male',
    birthDate: '2007-01-01',
    address: 'Jl. Testing Cypress',
    updatedAddress: 'Alamat Sudah Di Edit'
  }

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('input[name="email"]').should('be.visible').type('admin@sman1donggo.sch.id')
    cy.get('input[name="password"]').should('be.visible').type('password')
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })

  it('1. Create - Berhasil Menambahkan Data Siswa Baru', () => {
    cy.visit('http://127.0.0.1:8000/admin/students/create')

    cy.get('#nis').should('be.visible').type(studentData.nis)
    cy.get('#name').type(studentData.name)
    cy.get('#email').type(studentData.email)
    cy.get('#password').type(studentData.password)
    cy.get('#password_confirmation').type(studentData.password)
    cy.get('#phone').type(studentData.phone)
    cy.get('#gender').select(studentData.gender)
    cy.get('#school_class_id').select('1')
    cy.get('#birth_date').type(studentData.birthDate)
    cy.get('#address').type(studentData.address)
    cy.get('#photo').selectFile('cypress/fixtures/foto.png', { force: true })

    cy.contains('button', 'Simpan Siswa').click()

    cy.url().should('include', '/admin/students')
    cy.contains('Siswa berhasil dibuat').should('exist')
  })

  it('2. Read - Berhasil Mencari dan Melihat Detail Siswa', () => {
    cy.visit('http://127.0.0.1:8000/admin/students')
    
    cy.get('input[name="search"]').clear().type(studentData.name)
    cy.wait(2000)
    cy.contains('td', studentData.name).should('be.visible')

    cy.contains('tr', studentData.name).within(() => {
      cy.get('a').first().click({ force: true })
    })

    cy.contains('Detail Siswa').should('be.visible')
    cy.contains(studentData.name).should('be.visible')
    cy.contains(studentData.email).should('be.visible')
    cy.contains(studentData.phone).should('be.visible')
    cy.contains(studentData.address).should('be.visible')
  })

  it('3. Skenario Update - Berhasil Mengubah Data Siswa', () => {
    cy.visit('http://127.0.0.1:8000/admin/students')

    cy.get('input[name="search"]', { timeout: 10000 }).should('be.visible').clear().type(studentData.name)
    cy.wait(3000)
    cy.contains('td', studentData.name, { timeout: 10000 }).should('be.visible')

    cy.contains('tr', studentData.name)
      .find('a[href*="/edit"]')
      .should('be.visible')
      .click({ force: true })

    cy.url().should('include', '/edit')
    cy.get('form', { timeout: 10000 }).should('exist')

    cy.get('input[name="name"]', { timeout: 10000 })
      .should('be.visible')
      .clear({ force: true })
      .type(studentData.updatedName, { force: true })

    cy.get('input[name="phone"]').clear({ force: true }).type(studentData.updatedPhone, { force: true })
    cy.get('textarea[name="address"]').clear({ force: true }).type(studentData.updatedAddress, { force: true })

    cy.contains('button', 'Update Siswa').should('be.visible').click({ force: true })

    cy.url().should('include', '/admin/students')
    cy.get('input[name="search"]').clear().type(studentData.updatedName)
    cy.wait(3000)
    cy.contains('td', studentData.updatedName, { timeout: 10000 }).should('be.visible')
  })

  it('4. Delete - Berhasil Menghapus Data Siswa', () => {
    cy.visit('http://127.0.0.1:8000/admin/students')

    cy.get('input[name="search"]').clear().type(studentData.updatedName)
    cy.wait(3000)
    cy.contains('td', studentData.updatedName, { timeout: 10000 }).should('be.visible')

    cy.on('window:confirm', () => true)

    cy.contains('tr', studentData.updatedName).within(() => {
      cy.get('form').submit()
    })

    cy.wait(2000)
    cy.contains('td', studentData.updatedName).should('not.exist')
  })
})