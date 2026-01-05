async function deleteUser(event, form) {
    event.preventDefault(); 

    if (!confirm('Are you sure you want to delete this user?')) {
        return false;
    }

    const formData = new FormData(form);

    try {
        const response = await fetch('delete-user.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.text();

        if (result.includes('SUCCESS')) {
            
            form.closest('tr').remove();
        } else {
            alert('Error deleting user:\n' + result);
        }

    } catch (err) {
        alert('Server error: ' + err.message);
    }

    return false;
}