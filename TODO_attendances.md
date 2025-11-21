# TODO for Attendances Admin Pages

## 1. Create index.blade.php
- [ ] Create resources/views/admin/attendances/index.blade.php
- [ ] Include filters for date and class
- [ ] Table with columns: Student, Schedule, Date, Status, Actions (show, edit, delete)
- [ ] Pagination and search functionality

## 2. Create create.blade.php
- [ ] Create resources/views/admin/attendances/create.blade.php
- [ ] Form with fields: student (select), schedule (select), date (date input), status (select: present, absent, late, excused), notes (textarea)
- [ ] Validation and error handling

## 3. Create show.blade.php
- [ ] Create resources/views/admin/attendances/show.blade.php
- [ ] Display attendance details: student info, schedule info, date, status, notes
- [ ] Buttons for edit and back

## 4. Create edit.blade.php
- [ ] Create resources/views/admin/attendances/edit.blade.php
- [ ] Form similar to create, pre-filled with existing data
- [ ] Update functionality

## 5. Create summary.blade.php
- [ ] Create resources/views/admin/attendances/summary.blade.php
- [ ] Table showing summary per student: total days, present, absent, late, excused, percentage
- [ ] Filters for month and year if applicable
