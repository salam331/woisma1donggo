# TODO for Admin Features (8-15)

## 8. Materials (CRUD and show)
- [ ] Create index view: resources/views/admin/materials/index.blade.php (list materials with pagination, links to show, edit, delete)
- [ ] Create create view: resources/views/admin/materials/create.blade.php (form for title, description, file upload, subject, teacher)
- [ ] Create show view: resources/views/admin/materials/show.blade.php (display material details, download link)
- [ ] Create edit view: resources/views/admin/materials/edit.blade.php (form to update material)
- [ ] Ensure controller has download method (already exists)
- [ ] Test CRUD operations

## 9. Schedules (CRUD and show)
- [ ] Create index view: resources/views/admin/schedules/index.blade.php (list schedules with pagination, links to show, edit, delete)
- [ ] Create create view: resources/views/admin/schedules/create.blade.php (form for schedule details: subject, teacher, class, day, time, etc.)
- [ ] Create show view: resources/views/admin/schedules/show.blade.php (display schedule details)
- [ ] Create edit view: resources/views/admin/schedules/edit.blade.php (form to update schedule)
- [ ] Test CRUD operations

## 10. Attendances (CRUD, show and summary)
- [ ] Create index view: resources/views/admin/attendances/index.blade.php (list attendances with pagination, links to show, edit, delete)
- [ ] Create create view: resources/views/admin/attendances/create.blade.php (form for attendance: student, schedule, date, status)
- [ ] Create show view: resources/views/admin/attendances/show.blade.php (display attendance details)
- [ ] Create edit view: resources/views/admin/attendances/edit.blade.php (form to update attendance)
- [ ] Create summary view: resources/views/admin/attendances/summary.blade.php (summary report, e.g., by class, date range)
- [ ] Add summary route and method in AttendanceController if needed
- [ ] Test CRUD and summary

## 11. Invoices (CRUD and show)
- [ ] Create index view: resources/views/admin/invoices/index.blade.php (list invoices with pagination, links to show, edit, delete)
- [ ] Create create view: resources/views/admin/invoices/create.blade.php (form for invoice: student, amount, description, due date)
- [ ] Create show view: resources/views/admin/invoices/show.blade.php (display invoice details, print/download option)
- [ ] Create edit view: resources/views/admin/invoices/edit.blade.php (form to update invoice)
- [ ] Test CRUD operations

## 12. School-profiles (index and edit)
- [ ] Create index view: resources/views/admin/school-profiles/index.blade.php (display school profile info)
- [ ] Create edit view: resources/views/admin/school-profiles/edit.blade.php (form to edit school profile)
- [ ] Note: No create/delete, only index and edit
- [ ] Test index and edit

## 13. Announcements (CRUD)
- [ ] Create index view: resources/views/admin/announcements/index.blade.php (list announcements with pagination, links to edit, delete)
- [ ] Create create view: resources/views/admin/announcements/create.blade.php (form for title, content, date)
- [ ] Create edit view: resources/views/admin/announcements/edit.blade.php (form to update announcement)
- [ ] Note: No show view mentioned, but can add if needed
- [ ] Test CRUD operations

## 14. Galleries (CRUD and show)
- [ ] Create index view: resources/views/admin/galleries/index.blade.php (list galleries with pagination, links to show, edit, delete)
- [ ] Create create view: resources/views/admin/galleries/create.blade.php (form for title, description, image upload)
- [ ] Create show view: resources/views/admin/galleries/show.blade.php (display gallery details and images)
- [ ] Create edit view: resources/views/admin/galleries/edit.blade.php (form to update gallery)
- [ ] Test CRUD operations

## 15. Contact-messages (CRUD and show)
- [ ] Create index view: resources/views/admin/contact-messages/index.blade.php (list contact messages with pagination, links to show, delete)
- [ ] Create show view: resources/views/admin/contact-messages/show.blade.php (display message details)
- [ ] Note: No create/edit for messages (they come from public contact form), only index, show, delete
- [ ] Test operations
