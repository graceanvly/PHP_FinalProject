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
            background-color: #f4f4f4;
            font-family: 'Roboto', sans-serif;
        }
        .navbar-brand {
            font-weight: bold;
            color: #3498db;
        }
        .panel {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .modal-content {
            border-radius: 12px;
        }
        .btn-primary, .btn-success, .btn-danger {
            margin-right: 10px;
        }
        .table {
            margin-top: 20px;
        }
        .table th {
            background-color: #3498db;
            color: #fff;
        }
        .editBtn, .deleteBtn {
            margin-right: 5px;
        }
        .modal-header {
            background-color: #3498db;
            border-bottom: none;
            color: #fff;
        }
        .modal-footer {
            border-top: none;
        }
        .btn-close {
            background: none;
            color: #fff;
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
                <button id="listBtn" class="btn btn-primary"><i class="fas fa-list"></i></button>
                <button id="addBtn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal"><i class="fas fa-plus"></i> </button>
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
    editStudentModal.hide
