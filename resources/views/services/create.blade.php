@include('view.head')

@include('view.topbar')
@include('view.sidebar')

<div class="page-wrapper">
    <div class="container-fluid">

        <!-- Add Service Form -->
        <div class="card">
            <div class="card-header">Add Service</div>
            <div class="card-body">
                <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Service Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="price">Price</label>
                        <input type="text" name="price" class="form-control" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="duration">Duration</label>
                        <input type="time" name="duration" class="form-control" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Add Service</button>
                </form>
            </div>
        </div>

      

    </div>
</div>

@include('view.script')

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
