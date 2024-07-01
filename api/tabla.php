<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }

        /* Estilos para el modal */
        .modal {
            display: none; /* Ocultar modal por defecto */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Items List</h2>
    <button type="button" id="addItemButton">Agregar Item</button>
    <table id="itemsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category ID</th>
                <th>Created</th>
                <th>Modified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>

    <!-- Modal para editar -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Item</h2>
            <form id="editForm">
                <input type="hidden" id="editId" name="id">
                <label for="editName">Name:</label>
                <input type="text" id="editName" name="name" required><br><br>
                
                <label for="editDescription">Description:</label>
                <input type="text" id="editDescription" name="description" required><br><br>
                
                <label for="editPrice">Price:</label>
                <input type="number" id="editPrice" name="price" required><br><br>
                
                <label for="editCategory">Category ID:</label>
                <input type="number" id="editCategory" name="category_id" required><br><br>
                
                <button type="submit" id="updateButton">Update Item</button>
                <button type="submit" id="save">Save</button>
            </form>
        </div>
    </div>

    <!-- Scripts al final del body -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editModal');
            const addItemButton = document.getElementById('addItemButton');
            const closeModal = document.querySelector('.close');
            const editForm = document.getElementById('editForm');
            const tableBody = document.getElementById('tableBody');
            const updateButton = document.getElementById('updateButton');
            const saveButton = document.getElementById('save');

            let items = [];

            function openEditModal(item) {
                document.getElementById('editId').value = item.id;
                document.getElementById('editName').value = item.name;
                document.getElementById('editDescription').value = item.description;
                document.getElementById('editPrice').value = item.price;
                document.getElementById('editCategory').value = item.category_id;

                editModal.style.display = 'block';
            }

            closeModal.addEventListener('click', function() {
                editModal.style.display = 'none';
            });

            // Evento para abrir el modal al hacer clic en "Editar"
            tableBody.addEventListener('click', function(event) {
                if (event.target.classList.contains('edit-btn')) {
                    console.log("click en editar");
                    updateButton.style.display = 'block'; // Mostrar el botón Update
                    saveButton.style.display = 'none'; // Ocultar el botón Save

                    const itemId = event.target.getAttribute('data-id');
                    const item = items.find(item => String(item.id) === itemId);
                
                    if (item) {
                        openEditModal(item); // Abrir el modal con los datos del elemento
                    } else {
                        console.error('Item not found.');
                    }
                } else if (event.target.classList.contains('delete-btn')) {
                    const itemId = event.target.getAttribute('data-id');
                    deleteItem(itemId);
                }
            });

            document.getElementById('addItemButton').addEventListener('click', function() {
                updateButton.style.display = 'none'; // Ocultar el botón Update
                saveButton.style.display = 'block'; // Mostrar el botón Save
                openEditModal({}); // Abrir el modal sin datos
            });

            updateButton.addEventListener('click', function(event) {
                event.preventDefault();

                const editIdValue = document.getElementById('editId').value;
                const editNameValue = document.getElementById('editName').value;
                const editDescriptionValue = document.getElementById('editDescription').value;
                const editPriceValue = document.getElementById('editPrice').value;
                const editCategoryValue = document.getElementById('editCategory').value;

                const formData = {
                    'id': editIdValue,
                    'name': editNameValue,
                    'description': editDescriptionValue,
                    'price': editPriceValue,
                    'category_id': editCategoryValue
                };
                const jsonData = JSON.stringify(formData);
                
                fetch('http://localhost/api/update.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: jsonData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    alert(data.message); // Muestra mensaje de éxito o error
                    editModal.style.display = 'none'; // Cierra el modal después de la actualización
                    fetchAndDisplayItems(); // Actualizar la tabla después de la actualización
                })
                .catch(error => console.error('Error updating item:', error));
            });

            //evento de guardar un nuevo item
            saveButton.addEventListener('click', function() {
                event.preventDefault(); // Previene la recarga de la página

                const newNameValue = document.getElementById('editName').value;
                const newDescriptionValue = document.getElementById('editDescription').value;
                const newPriceValue = document.getElementById('editPrice').value;
                const newCategoryValue = document.getElementById('editCategory').value;

                const formData = {
                    'name': newNameValue,
                    'description': newDescriptionValue,
                    'price': newPriceValue,
                    'category_id': newCategoryValue
                };

                const jsonData = JSON.stringify(formData);

                fetch('http://localhost/api/create.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: jsonData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    alert(data.message); // Muestra mensaje de éxito o error
                    editModal.style.display = 'none'; // Cierra el modal después de la creación
                    fetchAndDisplayItems(); // Actualizar la tabla después de la creación
                })
                .catch(error => console.error('Error creating item:', error));
            });

            // Evento para abrir el modal al hacer clic en "Agregar Item"
            addItemButton.addEventListener('click', function() {
                document.getElementById('editId').value = '';
                document.getElementById('editName').value = '';
                document.getElementById('editDescription').value = '';
                document.getElementById('editPrice').value = '';
                document.getElementById('editCategory').value = '';

                editModal.style.display = 'block';
            });

            // Función para obtener y mostrar los items en la tabla
            function fetchAndDisplayItems() {
                fetch('http://localhost/api/read.php')
                    .then(response => response.json())
                    .then(data => {
                        items = data.items; 
                        renderItems(items);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Función para renderizar los items en la tabla
            function renderItems(items) {
                tableBody.innerHTML = ''; // Limpiar la tabla antes de agregar los nuevos datos

                items.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.name}</td>
                        <td>${item.description}</td>
                        <td>${item.price}</td>
                        <td>${item.category_id}</td>
                        <td>${item.created}</td>
                        <td>${item.modified}</td>
                        <td>
                            <button class="edit-btn" data-id="${item.id}">Editar</button>
                            <button class="delete-btn" data-id="${item.id}">Eliminar</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            // Función para eliminar un item
            function deleteItem(itemId) {
                if (confirm('¿Estás seguro de que quieres eliminar este item?')) {
                    fetch(`http://localhost/api/delete.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: itemId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        alert(data.message); // Muestra mensaje de éxito o error
                        fetchAndDisplayItems(); // Actualizar la tabla después de eliminar el item
                    })
                    .catch(error => console.error('Error deleting item:', error));
                }
            }

            fetchAndDisplayItems();
        });
    </script>
</body>
</html>
