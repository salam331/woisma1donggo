# TODO for Updating Attendances Index Page

## 1. Update AttendanceController
- [ ] Modify index method to show summary per class instead of individual attendances
- [ ] Add new method indexByClass to show summary per subject within a class
- [ ] Add new method indexBySubject to show attendances per student within a class and subject

## 2. Update Routes
- [ ] Add routes for indexByClass and indexBySubject in web.php

## 3. Update Views
- [ ] Modify resources/views/admin/attendances/index.blade.php to display summary per class
- [ ] Create resources/views/admin/attendances/index-by-class.blade.php for summary per subject
- [ ] Create resources/views/admin/attendances/index-by-subject.blade.php for attendances per student

## 4. Ensure Data Integrity
- [ ] No database data will be deleted or modified
- [ ] All changes are display-only
