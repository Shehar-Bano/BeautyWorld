@include('view.head')
@include('view.topbar')
@include('view.sidebar')
<div class="page-wrapper">
    <div class="container-fluid">
        {{-- /////////////after this add form////////// --}}
        <div class="container table-wrapper">
            <!-- Add Button -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Permissions</h4>
                <a href="{{ route('permissions.create') }}" class="btn btn-add">Add Permission</a>
            </div>

            <!-- Permissions Table -->
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Permission Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->description }}</td>
                            <td class="action-icons">
                                <a href="{{ route('permissions.edit', $permission->id) }}" class="edit-icon">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-icon" style="background:none; border:none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
{{-- ///////////////////till here////////// --}}
    </div>
</div>

@include('view.script')
