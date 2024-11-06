@include('view.head')

@include('view.topbar')
@include('view.sidebar')

<div class="page-wrapper">
    <div class="container-fluid">

        <!-- Add Service Form -->
        <div class="card">
            <div class="card-header">Add Expence</div>
            <div class="card-body">
                <form action="{{route('expences.update',['id'=>$expence->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="serviceId">
                        <div class="form-group">
                            <label for="status">Expence Category</label>
                                <select name="category_id" id="serviceStatus" class="form-control">
                                    <option value="" disabled selected>Select category</option>
                                @foreach ($expence_categories as $category)
                                <option value="{{$category->id}}" {{$expence->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group mt-2">
                            <label for="description">Name</label>
                            <input name="name" id="serviceDescription" class="form-control" value="{{$expence->name}}" required></input>
                        </div>
                        <div class="form-group mt-2">
                            <label for="description">Description</label>
                            <textarea name="description" id="serviceDescription" class="form-control"  required>{{$expence->description}}</textarea>
                        </div>
                        <div class="form-group mt-2">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="servicePrice" class="form-control" value="{{$expence->price}}" required>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Edit Expence</button>
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
