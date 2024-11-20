@include('view.head')
@php
use Illuminate\Support\Str;
@endphp
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRyXxbr6p5liEm5E8m5S0c8Fof1szar/lbiNpU7zm" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>

    .table-wrapper {
        margin: 20px auto;
        max-width: 900px;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    h4 {
        font-weight: 600;
        color: #333;
    }
    .btn-add {
        background-color: #00c9b7;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 14px;
    }
    .btn-add:hover {
        background-color: #00b3a5;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    thead th {
        font-weight: 600;
        color: #6c757d;
        background-color: #f8f9fa;
        padding: 10px;
    }
    tbody td {
        padding: 10px;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
        color: #495057;
    }
    tbody tr:hover {
        background-color: #f1f1f1;
    }
    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .action-icons a, .action-icons button {
        font-size: 17px;
        margin-right: 10px;
        cursor: pointer;
    }
    .edit-icon {
        color: #00a9ff;
    }
    .delete-icon {
        color: #ff5a5f;
    }
    .delete-icon {
        background: none;
        border: none;
        padding: 0;
    }
</style>

@include('view.topbar')
@include('view.sidebar')
<div class="page-wrapper">
    <div class="container-fluid">
        {{-- /////////////after this add form////////// --}}
        <div class="table-wrapper">
            <!-- Title and Add Button -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Deal's</h4>
                <a href="{{ route('deals.create') }}" class="btn btn-add">Add deal</a>
            </div>
            <form action="">
                @csrf
                <label>Select File</label>
                <input type="file" name="file" class="form-control"/>
                <div class="mt-5">
                    <button type="submit" class="btn btn-info"></button>
                    <a href="#" class="btn btn-primary float-right">Export Excel</a>
                </div>
            </form>
            <!-- Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Deal Name</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deals as $deal)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $deal->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($deal->created_at)->format('Y-m-d') }}</td>
                            <td>{{ $deal->dis_price }}</td>
                            <td>{{ \Illuminate\Support\Str::words($deal->description, 3, '...') }}</td>
                            <td class="action-icons">
                                <!-- Edit Icon -->
                                <a href="{{ route('deals.edit', $deal->id) }}" class="edit-icon">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Icon -->
                                <form action="{{ route('deals.delete', $deal->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-icon">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <!-- Toggle Button -->
                                <button type="button" class="btn toggle-icon" data-toggle="collapse" data-target="#serviceDetails-{{ $deal->id }}">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Collapsible row for additional service information -->
                        <tr id="serviceDetails-{{ $deal->id }}" class="collapse">
                            <td colspan="6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Service Name</th>
                                            <th>Price</th>
                                            <th>Duration</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($deal->dealService as $dealService)
                                            <tr>
                                                <td>{{ $dealService->service->name }}</td>
                                                <td>{{ $dealService->service->price }}</td>
                                                <td>{{ $dealService->service->duration }}</td>
                                                <td>{{ $dealService->service->description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
{{-- ///////////////////till here////////// --}}
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
