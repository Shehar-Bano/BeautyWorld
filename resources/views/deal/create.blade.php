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
                <h4 class="page-title">Add Product</h4>
                <form action="{{ route('deals.store') }}" method="POST" >
                    @csrf

                    <div class="form-group">
                        <label for="name">Deal Name</label>
                        <input type="text" class="form-control" id="phone" name="name"  placeholder="Enter Deal name" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Discount Price</label>
                        <input type="text" class="form-control" id="designation" name="dis_price" placeholder="Enter Discount Price" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Description</label>
                        <input type="textarea" class="form-control" id="description" name="description"  placeholder="Enter Description" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Deal Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="permanent">Permanent</option>
                            <option value="duration">Duration</option>
                        </select>
                    </div>

                    <div class="form-group" id="duration-field" style="display: none;">
                        <label for="name">Duration</label>
                        <input type="text" class="form-control" id="duration" name="duration" placeholder="Enter Duration">
                    </div>
                    <div class="form-group">
                        <label for="services">Select Services:</label><br>
                        <div class="form-check">
                            @foreach ($services as $service)
                                <input type="checkbox" class="form-check-input" id="service{{ $service->id }}" name="services[]" value="{{ $service->id }}">
                                <label class="form-check-label" for="service{{ $service->id }}">{{ $service->name }}</label><br>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit">Add Deal</button>
                </form>

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
<script>
    // Get the select and the duration field
    var dealTypeSelect = document.getElementById("type");
    var durationField = document.getElementById("duration-field");

    // Add an event listener to detect changes in the Deal Type selection
    dealTypeSelect.addEventListener("change", function() {
        if (dealTypeSelect.value === "duration") {
            // Show the duration field if "Duration" is selected
            durationField.style.display = "block";
        } else {
            // Hide the duration field if "Permanent" is selected
            durationField.style.display = "none";
        }
    });

    // Initial check to hide the duration field on page load if not selected
    window.onload = function() {
        if (dealTypeSelect.value !== "duration") {
            durationField.style.display = "none";
        }
    };
</script>
@include('view.script')
