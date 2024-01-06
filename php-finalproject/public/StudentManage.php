<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grade Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Nunito', sans-serif;
        }
        .navbar-brand {
            font-weight: bold;
            color: #2c3e50;
        }
        .panel {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .modal-content {
            border-radius: 8px;
        }
        .btn-primary, .btn-success {
            margin-right: 10px;
        }
        .table {
            margin-top: 20px;
        }
        .table th {
            background-color: #e9ecef;
        }
        .editBtn, .deleteBtn {
            margin-right: 5px;
        }
        .modal-header {
            background-color: #e9ecef;
            border-bottom: none;
        }
        .modal-footer {
            border-top: none;
        }
        .btn-close {
            background: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">Student Grade Management</a>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <button id="listBtn" class="btn btn-primary"><i class="fas fa-list"></i> LIST</button>
                <button id="addBtn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal"><i class="fas fa-plus"></i> ADD</button>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="panel">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody id="studentList">
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm">
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="studentName" name="studentName" required>
                    </div>
                    <div class="mb-3">
                        <label for="studentGrade" class="form-label">Grade:</label>
                        <input type="text" class="form-control" id="studentGrade" name="studentGrade" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm">
                    <input type="hidden" id="editStudentId">
                    <div class="mb-3">
                        <label for="editStudentName" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="editStudentName" name="studentName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStudentGrade" class="form-label">Grade:</label>
                        <input type="text" class="form-control" id="editStudentGrade" name="studentGrade" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/js/all.min.js"></script>
    <script>

    var addStudentModal = new bootstrap.Modal(document.getElementById('addStudentModal'));
    var editStudentModal = new bootstrap.Modal(document.getElementById('editStudentModal'));

    document.getElementById('listBtn').addEventListener('click', function() {
        fetchStudents();
    });

    document.getElementById('editStudentForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const id = document.getElementById('editStudentId').value;
    const editedName = document.getElementById('editStudentName').value;
    const editedGrade = document.getElementById('editStudentGrade').value;

    fetch(`/api/students/update/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: editedName, grade: editedGrade }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        alert('Student data updated successfully');
        editStudentModal.hide();
        fetchStudents();
    })
    .catch(error => {
        console.error('Error updating student data:', error);
        alert('Error updating student data');
    });
});

    function fetchStudents() {
        fetch('/api/students/all')
        .then(response => response.json())
        .then(data => {
            const studentList = document.getElementById('studentList');
            studentList.innerHTML = ''; 
            data.forEach(student => {
                studentList.innerHTML += `
                    <tr data-id='${student.id}' data-name='${student.name}' data-grade='${student.grade}'>
                        <td>
                            <button class='btn btn-primary editBtn' data-id='${student.id}'><i class='fas fa-edit'></i></button>
                            <button class='btn btn-danger deleteBtn' data-id='${student.id}' onclick='deleteStudent(${student.id})'><i class='fas fa-trash-alt'></i></button>
                        </td>
                        <td>${student.id}</td>
                        <td>${student.name}</td>
                        <td>${student.grade}</td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error('Error fetching students:', error);
        });
    }

    document.getElementById('studentList').addEventListener('click', function(event) {
        if (event.target && event.target.matches(".editBtn")) {
            const id = event.target.getAttribute('data-id');
            editStudent(id);
        }
        if (event.target && event.target.classList.contains('deleteBtn')) {
            const id = event.target.getAttribute('data-id');
            deleteStudent(id);
        }
    });

    document.getElementById('addBtn').addEventListener('click', function() {
        document.getElementById('studentName').value = '';
        document.getElementById('studentGrade').value = '';
    });

    document.getElementById('addStudentForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const studentName = document.getElementById('studentName').value;
        const studentGrade = document.getElementById('studentGrade').value;

        fetch('/api/students/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name: studentName, grade: studentGrade }),
        })
        .then(response => response.json())
        .then(data => {
            addStudentModal.hide();
            alert('New student added');
            fetchStudents();
        })
        .catch(error => {
            console.error('Error adding student:', error);
        });
    });

    function editStudent(id) {
        const studentRow = document.querySelector(`tr[data-id="${id}"]`);
        const studentName = studentRow.getAttribute('data-name');
        const studentGrade = studentRow.getAttribute('data-grade');

        document.getElementById('editStudentId').value = id;
        document.getElementById('editStudentName').value = studentName;
        document.getElementById('editStudentGrade').value = studentGrade;

        editStudentModal.show();
    }

    function deleteStudent(id) {
        if (confirm('Are you sure you want to delete this student?')) {
            fetch(`/api/students/delete/${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const deletedRow = document.querySelector(`tr[data-id="${id}"]`);
                    if (deletedRow) {
                        deletedRow.remove();
                    }
                    alert('Student deleted successfully');
                } else {
                    alert('Failed to delete student');
                }
            })
            .catch(error => {
                console.error('Error deleting student:', error);
            });
        }
    }

    fetchStudents();
</script>
</body>
</html>