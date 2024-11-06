@include('view.head')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f6f9;
    }
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
        font-size: 16px;
        margin-right: 10px;
        cursor: pointer;
    }
    .edit-icon {
        color: #00a9ff;
    }
    .delete-icon {
        color: #ff5a5f;
    }
    .delete-icon button {
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Expence Report</h4>
            </div>
            <!-- Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Date</th>

                        <th>Amount</th>
                    </tr>
                </thead>
                @php
                    $total = 0;
                @endphp
                <tbody>
                    @foreach($expences as $expence)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$expence->expenceCategory->name}}</td>
                            <td>{{$expence->description}}</td>
                            <td>{{ $expence->created_at->format('Y-m-d') }}</td>
                            <td>Rs {{ number_format($expence->price, 0) }} \-</td>
                        </tr>
                        @php
                        $total += $expence->price
                    @endphp
                    @endforeach
                    <tr>
                        <td colspan="3"></td>
                        <td><b>Total Expence:</b></td>
                        <td>
                            Rs {{number_format($total,0)}} \-
                        </td>
                    </tr>
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