@include('view.head')

@include('view.topbar')
@include('view.sidebar')

<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Customer and Product Search Section -->
        <div class="row mb-3">
           
            
            <div class="col-md-3">
                <select class="form-control">
                    <option>All Category</option>
                    <!-- Add other categories here -->
                </select>
            </div>
        </div>

        <!-- Main Content: Product List and Cart -->
        <div class="row  mx-auto">
            

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
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#seatNumbersModal" onclick="fetchSeatNumbers()">Hold List</button>
                            </div>
                           
                            <div class="modal fade" id="seatNumbersModal" tabindex="-1" aria-labelledby="seatNumbersModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="seatNumbersModalLabel">Seat Numbers</h5>
                                            <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <th>Service</th>
                                   
                                    <th>Tax</th>
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

                            <div><strong>Tax:</strong> <span id="totalTax">0</span> PKR</div>
                            <div><strong>Amount:</strong> <span id="totalAmount">0</span> PKR</div>
                            <div><strong>Grand Total:</strong> <span id="grandTotal">0</span> PKR</div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#holdBillModal">Hold Bill</button>
                            <button class="btn btn-success">Update Cart</button>
                            <button class="btn btn-danger" onclick="emptyCart()">Empty Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Hold Bill Button Trigger -->


<!-- Hold Bill Modal -->
<div class="modal fade" id="holdBillModal" tabindex="-1" aria-labelledby="holdBillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="holdBillModalLabel">Hold Bill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="holdBillForm" action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="seatNumber" class="form-label">Seat Number</label>
                        <input type="text" class="form-control" id="seatNumber" name="seatNumber" required>
                    </div>
                    <!-- Hidden input to hold cart items array -->
                    <input type="hidden" id="cartItems" name="cartItems">
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>




            <!-- Product List Section -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>Product List</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Sample Products - Replace with dynamic loop for real data -->
                            @foreach($services as $service)
                            <div class="col-6 col-md-6 text-center mb-4">
                                <div class="product-item p-3 shadow-sm rounded">
                                    <p><strong>{{ $service->name }}</strong></p>
                                    <p class="text-muted">Price: {{ number_format($service->price) }} PKR</p>
                                    <p class="text-muted">Category: {{ $service->category->name }}</p>
                                    <p class="text-muted">Duration: {{ $service->duration }}</p>
                                    <button class="btn btn-sm btn-outline-primary" onclick="addToCart({{ $service->id }}, '{{ $service->name }}', {{ $service->price }})">Add to Cart</button>
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
    border-radius: 0.5rem; /* Rounded corners for modal */
}

.list-group-item {
    transition: background-color 0.3s, transform 0.3s; /* Smooth transition */
    border: none;
}

.list-group-item:hover {
    background-color: #f8f9fa; /* Light gray background on hover */
    transform: translateY(-2px); /* Slight lift effect */
}

.list-group-item i {
    font-size: 1.2rem; /* Increase icon size */
}

.modal-header {
    border-bottom: 1px solid #dee2e6; /* Add a bottom border */
}

.modal-header .modal-title {
    font-weight: bold; /* Make title bold */
    font-size: 1.25rem; /* Slightly larger font size */
}

</style>

<script>
    // Array to hold cart items
    let cart = [];

    // Function to add product to cart
    function addToCart(productId, productName, productPrice) {
        let item = cart.find(item => item.id === productId);

        if (item) {
            item.quantity += 1;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
              
            });
        }
        renderCart();
    }

    // Function to render cart items
    function renderCart() {
        let cartTable = document.getElementById('cartTableBody');
        cartTable.innerHTML = '';

       
        let totalAmount = 0;
        let totalTax = 0;

        cart.forEach(item => {
            let itemTotal = item.price;
            let itemTax = Math.round(itemTotal * 0.05);
          
            totalAmount += itemTotal;
            totalTax += itemTax;

            cartTable.innerHTML += `
                <tr>
                    <td>${item.name}</td>

                    <td>${itemTax}</td>
                    <td>${itemTotal}</td>
                    
                    <td><i class="fa fa-trash text-danger" aria-hidden="true" onclick="removeFromCart(${item.id})"></i></td>
                </tr>
            `;
        });

        document.getElementById('totalTax').innerText = totalTax;
        document.getElementById('totalAmount').innerText = totalAmount;
        document.getElementById('grandTotal').innerText = totalAmount + totalTax;
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
  document.getElementById('holdBillForm').addEventListener('submit', function () {
        // Store cart item IDs in the hidden input field
        document.getElementById('cartItems').value = JSON.stringify(cart.map(item => item.id));
    });
/////////////////////////////////fetching seat numbers

function fetchSeatNumbers() {
        fetch('/carts/get-seat-numbers', {
            method: 'GET',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
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
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(response => response.json())
    .then(data => {
        // Set the global cart variable with the fetched items
        cart = data.cartItems.map(item => ({
            id: item.id,
            name: item.name,
            price: item.price,
            tax: item.tax
        }));

        // Render the cart items in the shopping cart
        renderCart();

        // Close the modal after loading the cart items
        const seatNumbersModal = new bootstrap.Modal(document.getElementById('seatNumbersModal'));
        seatNumbersModal.hide();
    })
    .catch(error => console.error('Error fetching cart items:', error));
}





</script>


