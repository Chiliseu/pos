<!-- filepath: /d:/Documents/3rd year/SIA/Group Proj/DEPLOYEDDD/pos/resources/views/userManage.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dipensa Teknolohiya Grocery - User Management</title>
<link rel="stylesheet" href="/css/usermngmnt.css">
<link rel="icon" type="image/png" href="/Picture/StoreLogo.png">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/userManage.js"></script>

<script>
    document.getElementById('cancelButton').addEventListener('click', function() {
        document.getElementById('addUserForm').reset();
    });
</script>
</head>
<body>
    <div class="backBtn">
        <a href="javascript:history.back()" id="back">&larr; Back</a>
    </div>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Users</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>
                        <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal" id="MultipleDelete"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>						
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="checkbox{{ $user->id }}" name="options[]" value="{{ $user->id }}">
                                <label for="checkbox{{ $user->id }}"></label>
                            </span>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->UserRoleID == 2 ? 'Admin' : 'Staff' }}</td>
                        <td>
                            <a href="#editEmployeeModal" class="edit" data-toggle="modal" data-user="{{ json_encode($user) }}"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" data-user="{{ json_encode($user) }}"><i class="material-icons" data-toggle="tooltip" title="Delete" id="Delete">&#xE872;</i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Add Modal HTML -->
    <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addUserForm" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">						
                        <h4 class="modal-title">Add User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="addUserErrors" class="alert alert-danger" style="display: none;"></div>					
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="name" class="form-control" required maxlength="25">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div id="form-group-password-container" class="form-group">
                            <div class="password-container">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                                <span class="toggle-password"><img src="/Picture/eye.svg" alt="Toggle Password" class="eyeIcon"></span>
                            </div>
                            <div class="password-container">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                                <span class="toggle-password"><img src="/Picture/eye.svg" alt="Toggle Password" class="eyeIcon"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="UserRoleID" class="form-control" required>
                                <option value="1">Staff</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="Firstname" class="form-control" required maxlength="25" pattern="[A-Za-z]+" title="First name should only contain letters, no numbers, symbols, special characters, or spaces" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="Lastname" class="form-control" required maxlength="25" pattern="[A-Za-z]+" title="First name should only contain letters, no numbers, symbols, special characters, or spaces" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">                        </div>
                        <div class="form-group">
                            <label>Middle Initial</label>
                            <input type="text" name="MiddleInitial" class="form-control" maxlength="1" required pattern="[A-Za-z]" title="Middle initial should only contain one letter" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '').toUpperCase()" style="text-transform: uppercase;">                        </div>
                            <div class="form-group">
                                <label>Suffix</label>
                                <select name="Suffix" class="form-control">
                                    <option value="">None</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                    <option value="VI">VI</option>
                                </select>
                            </div>
                        <div class="form-group">
                            <label>Contact No</label>
                            <input type="tel" name="ContactNo" class="form-control" pattern="\d{11}" inputmode="numeric" maxlength="11" title="Please enter exactly 11 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>					
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>

   <!-- Edit Modal HTML -->
    <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">						
                        <h4 class="modal-title">Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="editUserErrors" class="alert alert-danger" style="display: none;"></div>					
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div id="form-group-password-container" class="form-group">
                            <div class="password-container">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control">
                                <span class="toggle-password"><img src="/Picture/eye.svg" alt="Toggle Password" class="eyeIcon"></span>
                            </div>
                            <div class="password-container">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control">
                                <span class="toggle-password"><img src="/Picture/eye.svg" alt="Toggle Password" class="eyeIcon"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="UserRoleID" class="form-control" required>
                                <option value="1">Staff</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="Firstname" class="form-control" required pattern="[A-Za-z\s]+" title="First name should only contain letters" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="Lastname" class="form-control" required pattern="[A-Za-z\s]+" title="Last name should only contain letters" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                        </div>
                        <div class="form-group">
                            <label>Middle Initial</label>
                            <input type="text" name="MiddleInitial" class="form-control" maxlength="1", required pattern="[A-Za-z\s]+" title="Middle initial should only contain letters" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                        </div>
                        <div class="form-group">
                            <label>Suffix</label>
                            <input type="text" name="Suffix" class="form-control" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                        </div>
                        <div class="form-group">
                            <label>Contact No</label>
                            <input type="tel" name="ContactNo" class="form-control" pattern="\d{11}" inputmode="numeric" maxlength="11" title="Please enter exactly 11 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>					
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-info" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal HTML -->
    <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteUserForm" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this user?</p>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-danger" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>