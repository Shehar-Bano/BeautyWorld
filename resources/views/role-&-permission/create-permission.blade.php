@include('view.head')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f6f9;
    }
    .form-wrapper {
        margin: 50px auto;
        max-width: 800px; /* Adjust for larger width like table */
        padding: 30px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .form-wrapper h4 {
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }
    .btn-submit {
        background-color: #00c9b7;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 14px;
    }
    .btn-submit:hover {
        background-color: #00b3a5;
    }
    .form-control {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 10px;
    }
    .form-group label {
        font-weight: 500;
        color: #555;
    }
    .page-title {
        font-weight: bold;
        font-size: 22px;
        margin-bottom: 20px;
    }
</style>

@include('view.topbar')
@include('view.sidebar')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="container">
            <div class="form-wrapper">
                <h4 class="page-title">Add Permission</h4>
                <form action="{{ route('permissions.store') }}" method="POST" id="permissionForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Permission Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter permission name" required>
                    </div>
                    <button type="submit" class="btn btn-submit">Add Permission</button>
                </form>
                <a href="{{route('permissions.index')}}" class="btn btn-primary mt-3">Back</a>
            </div>
        </div>
    </div>
</div>
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
@include('view.script')
