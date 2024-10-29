@include('view.head')

@include('view.topbar')
@include('view.sidebar')

<div class="page-wrapper">
    <div class="container-fluid">

       <div class="card">
        <div class="d-flex justify-content-end my-4 mx-2 ">
            <a href="{{ route('services.create') }}" class="btn btn-info text-white">
                <i class="fas fa-plus"></i> Add New Service
            </a>
        </div>
        <div class="card-header">
          <h4>All Services</h4>
            </div>
            <div class="card-body">
                 <!-- Button to Redirect to Create Service Page -->
      

        <!-- Display All Services -->
        <div class="mt-5">
           
            <table class="table table-strip mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->description }}</td>
                            <td>
                               <img src="{{ asset('storage/images/' . $service->image) }}" alt="{{ $service->name }}" width="50">
                            </td>
                            <td>{{number_format( $service->price) }} Rs/-</td>
                            <td>{{ $service->duration }}</td>
                            <td>{{ $service->status }}</td>
                            <td>
                                <!-- Edit Icon to Trigger Modal -->
                                <a href="javascript:void(0);" onclick="editService({{ $service->id }}, '{{ $service->name }}', '{{ $service->description }}', '{{ $service->price }}', '{{ $service->duration }}', '{{ $service->status }}', '{{ $service->category_id }}')" class="text-warning me-2" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Icon to Trigger Confirmation -->
                                <a href="javascript:void(0);" onclick="confirmDelete({{ $service->id }})" class="text-danger" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </a>

                                <!-- Form to Submit Delete Request (Hidden) -->
                                <form id="delete-form-{{ $service->id }}" action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: none;">
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

        <!-- Edit Service Modal -->
        <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editServiceForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="id" id="serviceId">
                            <div class="form-group">
                                <label for="name">Service Name</label>
                                <input type="text" name="name" id="serviceName" class="form-control" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="description">Description</label>
                                <textarea name="description" id="serviceDescription" class="form-control" required></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <label for="price">Price</label>
                                <input type="text" name="price" id="servicePrice" class="form-control" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="duration">Duration</label>
                                <input type="text" name="duration" id="serviceDuration" class="form-control" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="status">Status</label>
                                <select name="status" id="serviceStatus" class="form-control">
                                    <option value="available">Available</option>
                                    <option value="unavailable">Unavailable</option>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="serviceCategory" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info text-white">Update Service</button>
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
    function editService(id, name, description, price, duration, status, categoryId) {
        document.getElementById('serviceId').value = id;
        document.getElementById('serviceName').value = name;
        document.getElementById('serviceDescription').value = description;
        document.getElementById('servicePrice').value = price;
        document.getElementById('serviceDuration').value = duration;
        document.getElementById('serviceStatus').value = status;
        document.getElementById('serviceCategory').value = categoryId; // Set the selected category
        document.getElementById('editServiceForm').action = `/services/${id}`;
        var editServiceModal = new bootstrap.Modal(document.getElementById('editServiceModal'));
        editServiceModal.show();
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
    @endif
</script>
