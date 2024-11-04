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
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="form-group mt-2">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>

                    <div class="form-group mt-2">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control" >
                        @if ($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                    </div>

                    <div class="form-group mt-2">
                        <label for="price">Price</label>
                        <input type="text" name="price" class="form-control" value="{{ old('price') }}" >
                        @if ($errors->has('price'))
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                        @endif
                    </div>

                    <div class="form-group mt-2">
                        <label for="duration">Duration</label>
                        <input type="text" name="duration" class="form-control" value="{{ old('duration') }}" required>
                        @if ($errors->has('duration'))
                            <span class="text-danger">{{ $errors->first('duration') }}</span>
                        @endif
                    </div>

                    <div class="form-group mt-2">
                        <label for="category_id">Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category_id'))
                            <span class="text-danger">{{ $errors->first('category_id') }}</span>
                        @endif
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
