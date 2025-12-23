<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Product Management</title>
</head>
<body>
    <h1>Product Management System</h1>
    <p>REST API Product Catalog</p>
    <hr>

    <div id="alertBox" style="display:none;"></div>


    <!-- Add Product Form -->
    <div id="addForm">
        <h2>Add New Product</h2>
        <form id="productForm">
            <p>
                <label>Product Name *</label><br>
                <input type="text" id="name" name="name" required size="50">
            </p>
            <p>
                <label>Description</label><br>
                <textarea id="description" name="description" rows="4" cols="50"></textarea>
            </p>
            <p>
                <label>Price *</label><br>
                <input type="number" id="price" name="price" step="0.01" min="0" required>
            </p>
            <p>
                <label>Stock *</label><br>
                <input type="number" id="stock" name="stock" min="0" required>
            </p>
            <button type="submit">Add Product</button>
        </form>
    </div>

    <hr>

    <!-- Edit Product Form -->
    <div id="editForm" style="display:none;">
        <h2>Edit Product</h2>
        <form id="editProductForm">
            <input type="hidden" id="editId">
            <p>
                <label>Product Name *</label><br>
                <input type="text" id="editName" name="name" required size="50">
            </p>
            <p>
                <label>Description</label><br>
                <textarea id="editDescription" name="description" rows="4" cols="50"></textarea>
            </p>
            <p>
                <label>Price *</label><br>
                <input type="number" id="editPrice" name="price" step="0.01" min="0" required>
            </p>
            <p>
                <label>Stock *</label><br>
                <input type="number" id="editStock" name="stock" min="0" required>
            </p>
            <button type="submit">Update Product</button>
            <button type="button" onclick="cancelEdit()">Cancel</button>
        </form>
    </div>

    <hr>

    <!-- Products Table -->
    <h2>Product List</h2>
    <div style="margin-bottom: 15px;">
        <a href="{{ route('export.products.excel') }}" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 4px;">
            📥 Export to Excel
        </a>
    </div>
    <table border="1" cellpadding="10" cellspacing="0" id="productsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="productsBody">
            @forelse($products as $product)
            <tr data-id="{{ $product->id }}">
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ Str::limit($product->description, 50) }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <button class="edit-btn" data-id="{{ $product->id }}">Edit</button>
                    <button class="delete-btn" data-id="{{ $product->id }}">Delete</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No products available. Add your first product above!</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        const apiUrl = '/api/products';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Show alert message
        function showAlert(message, type) {
            const alertBox = document.getElementById('alertBox');
            alertBox.textContent = message;
            alertBox.style.display = 'block';
            alertBox.style.border = '1px solid black';
            alertBox.style.padding = '10px';
            alertBox.style.marginBottom = '10px';
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 3000);
        }

        // Add Product
        document.getElementById('productForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = {
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                price: document.getElementById('price').value,
                stock: document.getElementById('stock').value
            };

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    showAlert(data.message, 'success');
                    document.getElementById('productForm').reset();
                    loadProducts();
                } else {
                    showAlert(data.message || 'Error creating product', 'error');
                }
            } catch (error) {
                showAlert('Network error occurred', 'error');
            }
        });

        // Load Products
        async function loadProducts() {
            try {
                const response = await fetch(apiUrl);
                const data = await response.json();

                const tbody = document.getElementById('productsBody');
                tbody.innerHTML = '';

                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6">No products available. Add your first product above!</td></tr>';
                    return;
                }

                data.data.forEach(product => {
                    const row = document.createElement('tr');
                    row.setAttribute('data-id', product.id);
                    row.innerHTML = `
                        <td>${product.id}</td>
                        <td>${product.name}</td>
                        <td>${product.description ? product.description.substring(0, 50) : ''}</td>
                        <td>$${parseFloat(product.price).toFixed(2)}</td>
                        <td>${product.stock}</td>
                        <td>
                            <button class="edit-btn" data-id="${product.id}">Edit</button>
                            <button class="delete-btn" data-id="${product.id}">Delete</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            } catch (error) {
                showAlert('Error loading products', 'error');
            }
        }

        // Edit Product - Show Form
        async function editProduct(id) {
            try {
                const response = await fetch(apiUrl + '/' + id);
                const data = await response.json();

                if (response.ok) {
                    document.getElementById('editId').value = data.data.id;
                    document.getElementById('editName').value = data.data.name;
                    document.getElementById('editDescription').value = data.data.description || '';
                    document.getElementById('editPrice').value = data.data.price;
                    document.getElementById('editStock').value = data.data.stock;

                    document.getElementById('addForm').style.display = 'none';
                    document.getElementById('editForm').style.display = 'block';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            } catch (error) {
                showAlert('Error loading product details', 'error');
            }
        }

        // Update Product
        document.getElementById('editProductForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const id = document.getElementById('editId').value;
            const formData = {
                name: document.getElementById('editName').value,
                description: document.getElementById('editDescription').value,
                price: document.getElementById('editPrice').value,
                stock: document.getElementById('editStock').value
            };

            try {
                const response = await fetch(apiUrl + '/' + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    showAlert(data.message, 'success');
                    cancelEdit();
                    loadProducts();
                } else {
                    showAlert(data.message || 'Error updating product', 'error');
                }
            } catch (error) {
                showAlert('Network error occurred', 'error');
            }
        });

        // Cancel Edit
        function cancelEdit() {
            document.getElementById('editForm').style.display = 'none';
            document.getElementById('addForm').style.display = 'block';
            document.getElementById('editProductForm').reset();
        }

        // Delete Product
        async function deleteProduct(id) {
            if (!confirm('Are you sure you want to delete this product?')) {
                return;
            }

            try {
                const response = await fetch(apiUrl + '/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    showAlert(data.message, 'success');
                    loadProducts();
                } else {
                    showAlert(data.message || 'Error deleting product', 'error');
                }
            } catch (error) {
                showAlert('Network error occurred', 'error');
            }
        }

        // Event delegation for edit and delete buttons
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('edit-btn')) {
                const id = e.target.getAttribute('data-id');
                editProduct(id);
            }
            if (e.target && e.target.classList.contains('delete-btn')) {
                const id = e.target.getAttribute('data-id');
                deleteProduct(id);
            }
        });
    </script>
</body>
</html>
