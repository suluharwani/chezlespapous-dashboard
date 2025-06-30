// Initialize DataTables
document.addEventListener('DOMContentLoaded', function() {
    $('.table').DataTable({
        responsive: true
    });
    
    // Image preview for file inputs
    $('input[type="file"]').change(function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $('#imagePreview').attr('src', event.target.result);
                $('#imagePreview').removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Toast notifications
    if ($('.alert').length) {
        setTimeout(() => {
            $('.alert').fadeOut('slow');
        }, 5000);
    }
});

// Confirm before delete
function confirmDelete(id, type) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `/admin/${type}/delete/${id}`;
        }
    });
}
// Initialize DataTables
$(document).ready(function() {
    $('.table').DataTable({
        responsive: true,
        columnDefs: [
            { orderable: false, targets: -1 } // Disable sorting for action column
        ]
    });
    
    // Confirm before delete
    window.confirmDelete = function(id, type) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/admin/${type}/delete/${id}`;
            }
        });
    };
    
    // Image preview for all file inputs
    $('input[type="file"]').change(function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const previewId = $(e.target).data('preview') || 'imagePreview';
                $(`#${previewId}`).attr('src', event.target.result).removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Toast notifications
    if ($('.alert').length) {
        setTimeout(() => {
            $('.alert').fadeOut('slow');
        }, 5000);
    }
});