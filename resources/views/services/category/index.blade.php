@include('view.head')

@include('view.topbar')
@include('view.sidebar')
<div class="page-wrapper">
    <div class="container-fluid">

        <!-- Add Category Form -->
        <div class="card">
            <div class="card-header">Add Category</div>
            <div class="card-body">
                <form action="{{ route('service_categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-info text-white mt-2">Add Category</button>
                </form>
            </div>
        </div>

        <!-- Display All Categories -->
        <div class="mt-5">
           <div class="card">
            <div class="card-header"><h4>All Categories</h4></div>
            <div class="card-body">
          
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <!-- Edit Icon to Trigger Modal -->
                                    <a href="javascript:void(0);" onclick="editCategory({{ $category->id }}, '{{ $category->name }}')" 
                                       class="text-warning me-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Delete Icon to Trigger Confirmation -->
                                    <a href="javascript:void(0);" onclick="confirmDelete({{ $category->id }})" 
                                       class="text-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                
                                    <!-- Form to Submit Delete Request (Hidden) -->
                                    <form id="delete-form-{{ $category->id }}" 
                                          action="{{ route('service_categories.destroy', $category->id) }}" 
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

           </div>
        </div>

        <!-- Edit Category Modal -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editCategoryForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="id" id="categoryId">
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input type="text" name="name" id="categoryName" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info text-white">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('view.script')

<script>
    // Function to open the edit modal and fill the form with data
    function editCategory(id, name) {
        document.getElementById('categoryId').value = id;
        document.getElementById('categoryName').value = name;
        document.getElementById('editCategoryForm').action = `/service_categories/${id}`; // Set form action
        var editCategoryModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        editCategoryModal.show();

    }

     // SweetAlert for Delete Confirmation
     function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the hidden delete form
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
<script>
    // Check if there is a session message
    @if (session('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @elseif (session('error'))
        Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @elseif (session('info'))
        Swal.fire({
            title: 'Info',
            text: "{{ session('info') }}",
            icon: 'info',
            confirmButtonText: 'OK'
        });
    @elseif (session('warning'))
        Swal.fire({
            title: 'Warning',
            text: "{{ session('warning') }}",
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    @endif
</script>
