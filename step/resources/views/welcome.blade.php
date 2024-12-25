<!DOCTYPE html>
<html>

<head>
    <title>Create Group with Components</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Create Group with Components</h1>
    <form id="createGroupForm">
        @csrf
        <label for="name">Group Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="components">Components:</label><br>
        <textarea id="components" name="components" rows="4" required></textarea><br><br>

        <button type="submit">Create Group</button>
    </form>

    <script>
        $(document).ready(function() {
            $('#createGroupForm').submit(function(event) {
                event.preventDefault();

                var name = $('#name').val();
                var components = $('#components').val().split('\n');

                var requestData = {
                    name: name,
                    components: components.map(function(component) {
                        return {
                            content: component.trim()
                        };
                    })
                };

                $.ajax({
                    type: 'POST',
                    url: '/groups',
                    data: JSON.stringify(requestData),
                    contentType: 'application/json',
                    success: function(response) {
                        alert('Group created successfully!');
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'An error occurred.';
                        alert('Error: ' + errorMessage);
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
</body>

</html>