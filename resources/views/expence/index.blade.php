@include('view.head')

@include('view.topbar')
@include('view.sidebar')

<div class="page-wrapper">
    <div class="container-fluid">


        <!-- Button to Redirect to Create Service Page -->
        <div class="d-flex justify-content-end mt-4">

            <a href="{{ route('expences.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Expence
            </a>
           
        </div>

        <!-- Display All Services -->
        <div class="mt-5">
            <h4>All Expence</h4>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Sr:no</th>
                        <th>Expence Category</th>
                        {{-- <th>Expence Name</th> --}}
                        <th>Price</th>
                        <th>Description</th>

                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count=1
                    @endphp
                    @foreach ( $expences as $expence)
                        <tr>
                            <td>{{ $count++ }}</td>
                            {{-- <td>{{ $expence->expence_category->name }}</td> --}}
                            <td>{{ $expence->name }}</td>
                            <td>{{ $expence->price }}</td>
                            <td>{{ $expence->description }}</td>
                            <td>
                                <!-- Edit Icon to Trigger Modal -->
                                <a  href="{{route('expences.edit',['id'=>$expence->id])}}" class="text-warning me-2" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Icon to Trigger Confirmation -->
                                <a href="javascript:void(0);" onclick="confirmDelete({{ $expence->id }})" class="text-danger" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </a>

                                <!-- Form to Submit Delete Request (Hidden) -->
                                <form id="delete-form-{{ $expence->id }}" action="{{ route('expences.delete', $expence->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Edit Service Modal -->

    </div>
</div>

@include('view.script')

<script>



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
