@include('view.head')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f6f9;
    }
    .card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .btn-custom {
        background-color: #17a2b8;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
    }
    .btn-custom:hover {
        background-color: #138496;
    }
    .form-select {
        background-color: #f8f9fa;
        color: #495057;
        border: 1px solid #ced4da;
    }
    .form-select:focus {
        border-color: #80bdff;
        outline: none;
    }
    h2 {
        color: #343a40;
        font-weight: 700;
    }
</style>

@include('view.topbar')
@include('view.sidebar')

<div class="page-wrapper">
    <div class="container-fluid">

        {{-- ///////////// Assign Permission to Role Form ////////// --}}
        <div class="container">
            <h2 class="my-4">Assign Permission to Role</h2>

            <!-- Form Card -->
            <div class="card">
                <div class="card-body">
                    <!-- Form Start -->
                    <form action="{{ route('role.permission.store') }}" method="POST">
                        @csrf

                        <!-- Role Selection -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Select Role</label>
                            <select id="role" name="role_id" class="form-select">
                                <option value="" disabled selected>Select a role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Permission Selection -->
                        <div class="mb-3">
                            <label for="permission" class="form-label">Select Permission</label>
                            <select id="permission" name="permission_id" class="form-select">
                                <option value="" disabled selected>Select a permission</option>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-custom">Assign Permission</button>
                    </form>
                    <a href="{{route('role.permission.index')}}" class="btn btn-warning mt-3"> back</a>
                </div>
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
