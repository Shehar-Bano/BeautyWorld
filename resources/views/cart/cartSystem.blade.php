@include('view.head')

@include('view.topbar')
@include('view.sidebar')

<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Customer and Product Search Section -->
        <div class="row mb-3">
            <!-- Main Content: Product List and Cart -->
            <div class="row  mx-auto d-flex justify-content-center">


                <!-- Cart Section -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white text-center">
                            <h5>Shopping Cart</h5>
                        </div>
                        <div class="card-body">
                            <!-- Product Cart Table -->
                            <div class="text-end mb-3">
                                <div class="text-end mb-3">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#seatNumbersModal" onclick="fetchSeatNumbers()">Hold
                                        List</button>
                                </div>
                                <div class="mb-3">
                                    <form id="updateCartForm" action="{{ route('cart.update') }}" method="POST">
                                        @csrf


                                        <input type="hidden" class="form-control" id="fetchSeat" name="seatNumber"
                                            required>

                                        <!-- Hidden input to hold cart items array -->
                                        <input type="hidden" id="updatedcartItems" name="cartItems">
                                        <button type="submit" class="btn btn-primary">Update Cart</button>
                                    </form>
                                </div>

                                <div class="modal fade" id="seatNumbersModal" tabindex="-1"
                                    aria-labelledby="seatNumbersModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="seatNumbersModalLabel">Seat Numbers</h5>
                                                <button type="button" class="btn btn-danger btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body d-flex justify-content-between">
                                                <!-- Seat Numbers List with Edit Icons -->
                                                <ul id="seatNumbersList" class="list-group list-group-flush">
                                                    <!-- List items will be injected here by JavaScript -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Item</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="cartTableBody">
                                    <!-- Cart items will be injected here by JavaScript -->
                                </tbody>
                            </table>

                            <!-- Cart Summary -->
                            <div class="d-flex justify-content-between py-3 border-top">

                                <div><strong>Grand Total:</strong> <span id="grandTotal">0</span> PKR</div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#holdBillModal">Hold Bill</button>
                                <!-- Confirm Order Button Trigger -->
                                <button class="btn btn-success  text-white " data-bs-toggle="modal"
                                    data-bs-target="#confirmOrderModal">Confirm Order</button>


                                <button class="btn btn-danger  text-white " onclick="emptyCart()">Empty Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Confirm Order Modal -->
                <div class="modal fade" id="confirmOrderModal" tabindex="-1" aria-labelledby="confirmOrderModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmOrderModalLabel">Confirm Order</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="confirmOrderForm" action="{{ route('cart.order.confirm') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="confirmSeatNumber" class="form-label">Seat Number (if Any)</label>
                                        <input type="text" class="form-control" id="confirmSeatNumber"
                                            name="seatNumber" value="{{ old('seatNumber') }}">
                                        @error('seatNumber')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="customerName" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="customerName" name="customerName"
                                            value="{{ old('customerName') }}" required>
                                        @error('customerName')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="customerEmail" class="form-label">Customer Email</label>
                                        <input type="email" class="form-control" id="customerEmail"
                                            name="customerEmail" value="{{ old('customerEmail') }}" required>
                                        @error('customerEmail')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="customerPhone" class="form-label">Customer Phone</label>
                                        <input type="tel" class="form-control" id="customerPhone"
                                            name="customerPhone" value="{{ old('customerPhone') }}" required>
                                        @error('customerPhone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="provider" class="form-label">Select Provider</label>
                                        <select class="form-control" id="provider" name="provider_id" required>
                                            <option value="">Choose a provider</option>
                                            @foreach ($providers as $provider)
                                                <option value="{{ $provider->id }}"
                                                    {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
                                                    {{ $provider->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('provider_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Hidden input to hold cart items array -->
                                    <input type="hidden" id="confirmCartItems" name="cartItems"
                                        value="{{ old('cartItems') }}">
                                    <button type="submit" class="btn btn-primary text-white w-100">Confirm
                                        Order</button>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>


                <!-- Hold Bill Modal -->
                <div class="modal fade" id="holdBillModal" tabindex="-1" aria-labelledby="holdBillModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="holdBillModalLabel">Hold Bill</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="holdBillForm" action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="seatNumber" class="form-label">Seat Number</label>
                                        <input type="text" class="form-control" id="seatNumber" name="seatNumber"
                                            required>
                                    </div>
                                    <!-- Hidden input to hold cart items array -->
                                    <input type="hidden" id="cartItems" name="cartItems">
                                    <button type="submit" class="btn btn-primary w-100">Add Seat</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- Product List Section -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white text-center">
                            <h5>Product List</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Sample Products - Replace with dynamic loop for real data -->
                                @foreach ($services as $service)
                                    <div class="col-6 col-md-6 text-center mb-4">
                                        <div class="product-item p-3 shadow-sm rounded">
                                            <p><strong>{{ $service->name }}</strong></p>
                                            <p class="text-muted">Price: {{ number_format($service->price) }} PKR</p>
                                            <p class="text-muted">Category: {{ $service->category->name }}</p>
                                            <p class="text-muted">Duration: {{ $service->duration }}</p>
                                            <!-- Button for Service -->
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="addToCart({{ $service->id }}, '{{ $service->name }}', {{ $service->price }}, 'service')">Add
                                                to Cart</button>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
               
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-success text-white text-center">
                            <h5>Special Deals</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Sample Deals - Replace with dynamic loop for real deals -->
                                @foreach ($deals as $deal)
                                    <div class="col-6 col-md-6 text-center mb-4">
                                        <div class="deal-item p-3 shadow-sm rounded">
                                            <p><strong>{{ $deal->name }}</strong></p>
                                            <p class="text-muted">Discounted Price:
                                                {{ number_format($deal->dis_price) }} PKR</p>

                                            <p class="text-muted">Services:
                                            <p class="text-muted">Services:
                                            <ul class="list-group">
                                                @foreach ($deal->dealService as $dealService)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <i
                                                            class="bi bi-check-circle-fill text-success me-2"></i>{{ $dealService->service->name }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                            </p>
                                            </p>

                                            <!-- Button for Deal -->
                                            <button class="btn btn-sm btn-outline-success"
                                                onclick="addToCart({{ $deal->id }}, '{{ $deal->name }}', {{ $deal->dis_price }}, 'deal')">Add
                                                to Cart</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('view.script')

    <style>
        .product-item {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            transition: box-shadow 0.3s;
        }

        .product-item:hover {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .modal-content {
            border-radius: 0.5rem;
            /* Rounded corners for modal */
        }

        .list-group-item {
            transition: background-color 0.3s, transform 0.3s;
            /* Smooth transition */
            border: none;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            /* Light gray background on hover */
            transform: translateY(-2px);
            /* Slight lift effect */
        }

        .list-group-item i {
            font-size: 1.2rem;
            /* Increase icon size */
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
            /* Add a bottom border */
        }

        .modal-header .modal-title {
            font-weight: bold;
            /* Make title bold */
            font-size: 1.25rem;
            /* Slightly larger font size */
        }
    </style>

    <script>
        // Array to hold cart items
        let cart = [];

        // Function to add product or deal to cart
        function addToCart(productId, productName, productPrice, itemType) {
            // `itemType` should be either 'service' or 'deal'
            let item = cart.find(item => item.id === productId && item.type === itemType);

            if (item) {
                item.quantity += 1;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    type: itemType // Save item type to differentiate services and deals
                });
            }
            renderCart();
        }

        // Modify the "Hold Bill" and "Confirm Order" form submission to include item type
        document.getElementById('holdBillForm').addEventListener('submit', function() {
            // Store cart items with type in the hidden input field
            document.getElementById('cartItems').value = JSON.stringify(cart.map(item => ({
                id: item.id,
                type: item.type
            })));
        });

        document.getElementById('updateCartForm').addEventListener('submit', function() {
            document.getElementById('updatedcartItems').value = JSON.stringify(cart.map(item => ({
                id: item.id,
                type: item.type
            })));
        });

       

        // Function to render cart items
        function renderCart() {
            let cartTable = document.getElementById('cartTableBody');
            cartTable.innerHTML = '';


            let totalAmount = 0;


            cart.forEach(item => {
                let itemTotal = item.price;


                totalAmount += itemTotal;


                cartTable.innerHTML += `
                <tr>

                     <td>${item.id}</td>
                    <td>${item.name}</td>

                   
                    <td>${itemTotal}</td>
                    
                    <td><i class="fa fa-trash text-danger" aria-hidden="true" onclick="removeFromCart(${item.id})"></i></td>
                </tr>
            `;
            });



            document.getElementById('grandTotal').innerText = totalAmount;
        }

        function updateQuantity(productId, change) {
            let item = cart.find(item => item.id === productId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeFromCart(productId);
                }
            }
            renderCart();
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            renderCart();
        }

        function emptyCart() {
            cart = [];
            renderCart();
        }


        // When the "Hold Bill" button is clicked, prepare cart items for form submission
        document.getElementById('holdBillForm').addEventListener('submit', function() {
    // Store cart items with type in the hidden input field
    document.getElementById('cartItems').value = JSON.stringify(cart.map(item => ({
        id: item.id,
        type: item.type // Include type to specify if it's a 'service' or 'deal'
    })));
});
        document.getElementById('updateCartForm').addEventListener('submit', function() {
            document.getElementById('updatedcartItems').value = JSON.stringify(cart.map(item => ({
                id: item.id,
               
                type: item.type


            })));
            // document.getElementById('updatedcartItems').value = JSON.stringify(cart.map(item => item.id));

        });

        /////////////////////////////////fetching seat numbers

        function fetchSeatNumbers() {
            fetch('/carts/get-seat-numbers', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const seatNumbersList = document.getElementById('seatNumbersList');
                    seatNumbersList.innerHTML = '';
                    data.seatNumbers.forEach(seatNumber => {
                        seatNumbersList.innerHTML += `
                    <li class="list-group-item ">
                        ${seatNumber}
 <i class="fa fa-edit text-primary ms-2" style="cursor:pointer;" onclick="fetchSeatCartItems('${seatNumber}')"></i>
                    </li>`;
                    });
                })
                .catch(error => console.error('Error fetching seat numbers:', error));
        }

        /////////////////////////////////fetch seatnumber items
        function fetchSeatCartItems(seatNumber) {
    fetch(`/carts/get-cart-items/${seatNumber}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);  // Log the response for debugging

        if (data.message && data.message === 'Cart not found') {
            console.error('Cart not found for this seat number');
            return;
        }

        // Set the global cart variable with the fetched items
        cart = data.map(item => ({
            id: item.id,
            name: item.name,
            price: item.price,
            tax: item.tax,
            type: item.type  // Ensure that the type (service or deal) is also mapped
        }));

        renderCart();  // Render the cart after fetching items

        // Set the seat number in the form
        const fetchedSeatNumber = seatNumber;
        const fetchSeat = document.getElementById('fetchSeat');
        const confirmSeatNumber = document.getElementById('confirmSeatNumber');
        confirmSeatNumber.value = fetchedSeatNumber;
        fetchSeat.value = fetchedSeatNumber;

        // Close the modal after loading the cart items
        const seatNumbersModal = new bootstrap.Modal(document.getElementById('seatNumbersModal'));
        seatNumbersModal.hide();
    })
    .catch(error => console.error('Error fetching cart items:', error));

    // Close the modal immediately if it's open
    const modalElement = document.getElementById('seatNumbersModal');
    const modalInstance = bootstrap.Modal.getInstance(modalElement);
    if (modalInstance) {
        modalInstance.hide();
    }
}

        // When the "Confirm Order" form is submitted, prepare cart items for form submission
        document.getElementById('confirmOrderForm').addEventListener('submit', function() {
            // Store cart item IDs in the hidden input field for confirming order
            document.getElementById('confirmCartItems').value = JSON.stringify(cart.map(item => ({
                id: item.id,
                price:item.price,
               
                type: item.type


            })));


        });
    </script>
    <!-- JavaScript to hide the modal -->
<script>
    document.getElementById('confirmOrderForm').addEventListener('submit', function(event) {
        // Prevent the form's default submit behavior for demonstration
        event.preventDefault();

        // Submit form via AJAX or continue with normal form submission
        // Hide the modal after form submission
        var modal = new bootstrap.Modal(document.getElementById('confirmOrderModal'));
        modal.hide();

        // Optional: Remove the line below if you want to submit the form after the modal hides
        this.submit(); // Uncomment to allow actual form submission
    });
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
