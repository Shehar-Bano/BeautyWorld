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
                <h4 class="page-title">Add User Information</h4>
                <form action="{{ route('employees.store') }}" method="POST" >
                    @csrf
                    <div class="form-group">
                        <label for="name">User</label>
                        <select class="form-control" id="name" name="name" required>
                            <option value="" disabled>Select User</option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}" >{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{$user->phone}}" placeholder="Enter Phone Number" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation" value="{{$user->designation}}" placeholder="Enter designation" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Joining Date</label>
                        <input type="date" class="form-control" id="joining_date" name="joining_date" value="{{$user->joining_date}}" placeholder="Enter Joining Date" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Salary</label>
                        <input type="number" class="form-control" id="salary" name="salary" value="{{$user->salary}}" placeholder="Enter Salary" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="available" {{ $user->status == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="reserved" {{ $user->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-submit">Add User</button>
                </form>
                <a href="{{route('employees.index')}}" class="btn btn-primary mt-3">Back</a>
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


