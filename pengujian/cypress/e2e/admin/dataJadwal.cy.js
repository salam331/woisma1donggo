describe('Create Data Jadwal - Admin', () => {
  const scheduleData = {
    classId: '2',
    subjectId: '1',
    teacherId: '1',
    day: 'monday',
    startTime: '07:01',
    endTime: '08:31'
  }

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('input[name="email"]', { timeout: 10000 }).should('be.visible').type('admin@sman1donggo.sch.id')
    cy.get('input[name="password"]').should('be.visible').type('password')
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })

  it('Mengisi Form Jadwal Baru', () => {
    cy.visit('http://127.0.0.1:8000/admin/schedules/create')
    cy.contains('Buat Jadwal Baru', { timeout: 15000 }).should('exist')

    cy.get('select[name="class_id"]', { timeout: 15000 }).should('be.visible').select(scheduleData.classId)
    cy.get('select[name="subject_id"]').should('be.visible').select(scheduleData.subjectId)
    cy.get('select[name="teacher_id"]').should('be.visible').select(scheduleData.teacherId)
    cy.get('select[name="day"]').select(scheduleData.day)
    cy.get('input[name="start_time"]').clear({ force: true }).type(scheduleData.startTime, { force: true })
    cy.get('input[name="end_time"]').clear({ force: true }).type(scheduleData.endTime, { force: true })

    cy.contains('button', 'Simpan Jadwal').click({ force: true })
  })

  it('Verifikasi Jadwal Berhasil Disimpan', () => {
    cy.visit('http://127.0.0.1:8000/admin/schedules')
    cy.url().should('include', '/admin/schedules')
    cy.get('table', { timeout: 15000 }).should('exist')
    cy.get('table tbody tr').last().should('exist')
  })
})