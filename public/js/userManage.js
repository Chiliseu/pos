$(document).ready(function(){
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();
    
    // Select/Deselect checkboxes
    var checkbox = $('table tbody input[type="checkbox"]');
    $("#selectAll").click(function(){
        if(this.checked){
            checkbox.each(function(){
                this.checked = true;                      
            });
        } else{
            checkbox.each(function(){
                this.checked = false;                        
            });
        } 
    });
    checkbox.click(function(){
        if(!this.checked){
            $("#selectAll").prop("checked", false);
        }
    });

    // Fill the edit modal with user data
    $('.edit').on('click', function() {
        var user = $(this).data('user');
        $('#editEmployeeModal input[name="name"]').val(user.name);
        $('#editEmployeeModal input[name="email"]').val(user.email);
        $('#editEmployeeModal select[name="UserRoleID"]').val(user.UserRoleID);
        $('#editEmployeeModal input[name="Firstname"]').val(user.Firstname);
        $('#editEmployeeModal input[name="Lastname"]').val(user.Lastname);
        $('#editEmployeeModal input[name="MiddleInitial"]').val(user.MiddleInitial);
        $('#editEmployeeModal input[name="Suffix"]').val(user.Suffix);
        $('#editEmployeeModal input[name="ContactNo"]').val(user.ContactNo);
        $('#editEmployeeModal input[name="password"]').val(''); // Leave password field empty for security reasons
        $('#editEmployeeModal form').attr('action', '/users/' + user.id);
    });

    // Add user form submission
    $('#addUserForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                $('#addEmployeeModal').modal('hide');
                location.reload(); // Reload the page to update the table
            },
            error: function(response) {
                var errors = response.responseJSON.errors;
                var errorHtml = '<ul>';
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul>';
                $('#addUserErrors').html(errorHtml).show();
            }
        });
    });

    // Edit user form submission
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                $('#editEmployeeModal').modal('hide');
                location.reload(); // Reload the page to update the table
            },
            error: function(response) {
                var errors = response.responseJSON.errors;
                var errorHtml = '<ul>';
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul>';
                $('#editUserErrors').html(errorHtml).show();
            }
        });
    });

    $(document).ready(function() {
        // Set the action URL for the delete form
        $(document).on('click', '#MultipleDelete', function() {
            var selectedUsers = [];
            $('table tbody input[type="checkbox"]:checked').each(function() {
                selectedUsers.push($(this).val());
            });
    
            if (selectedUsers.length > 0) {
                $('#deleteUserForm').attr('action', '/users').data('user-ids', selectedUsers);
                console.log('Selected users:', selectedUsers);
            }
        });
    
        // Delete user form submission
        $(document).on('submit', '#deleteUserForm', function(e) {
            e.preventDefault();
            var form = $(this);
            var selectedUsers = form.data('user-ids');
            console.log('Form submitted with users:', selectedUsers);
            $.ajax({
                type: 'DELETE',
                url: form.attr('action'),
                data: {
                    _token: form.find('input[name="_token"]').val(),
                    user_ids: selectedUsers
                },
                success: function(response) {
                    console.log('Delete successful:', response);
                    $('#deleteEmployeeModal').modal('hide');
                    selectedUsers.forEach(function(userId) {
                        $('tr').has('input[value="' + userId + '"]').remove(); // Remove the deleted user's row
                    });
                },
                error: function(response) {
                    console.log('Delete failed:', response);
                    var errors = response.responseJSON.errors;
                    var errorHtml = '<ul>';
                    // Handle errors here
                    $('#editUserErrors').html(errorHtml).show();
                }
            });
        });
    
        // Handle individual delete button click
        $(document).on('click', '.delete', function() {
            var user = $(this).data('user');
            $('#deleteUserForm').attr('action', '/users/' + user.id).data('user-ids', [user.id]);
            console.log('Delete button clicked for user:', user);
        });
    });

    // Toggle password visibility
    $('.toggle-password').on('click', function() {
        var input = $(this).siblings('input');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
        } else {
            input.attr('type', 'password');
        }
    });
});