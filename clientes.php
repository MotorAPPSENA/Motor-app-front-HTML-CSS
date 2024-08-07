<?php
require_once 'database.php';

// Obtener usuarios de la base de datos
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<?php require_once 'Apartados/Paginas/apartadoadmin.php'; ?>
<link rel="stylesheet" href="Estilo Apartados/productos.css">

<div class="contenedorUsuarios">
    <div class="contenedorListaUsuarios">
        <table class="tablaUsuarios">
            <thead class="encabezadosTabla">
                <tr>
                    <th>Id Usuario</th>
                    <th>Numero de Identificación</th>
                    <th>Nombre</th>
                    <th>Contraseña</th>
                    <th>Telefono</th>
                    <th>Correo electrónico</th>
                    <th>Fecha de nacimiento</th>
                    <th>Rol de Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="user-list">
                <?php
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['id_usuario']}</td>
                                <td>{$row['n_identificacion']}</td>
                                <td>{$row['nombre']}</td>
                                <td>{$row['passwrd']}</td>
                                <td>{$row['telefono']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['fecha_nacimiento']}</td>
                                <td>{$row['rol']}</td>
                                <td>
                                    <button onclick=\"editUser(this)\">Editar</button>
                                    <button onclick=\"deleteUser(this)\">Eliminar</button>
                                    <button onclick=\"saveUser(this)\" style=\"display:none;\">Guardar</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No hay usuarios</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Función para editar un usuario de la tabla
function editUser(button) {
    const row = button.closest('tr');
    const cells = row.getElementsByTagName('td');
    
    for (let i = 0; i < cells.length - 1; i++) {
        const cell = cells[i];
        const input = document.createElement('input');
        input.type = 'text';
        input.value = cell.innerText;
        cell.innerText = '';
        cell.appendChild(input);
    }
    
    const saveButton = row.querySelector('button[onclick="saveUser(this)"]');
    saveButton.style.display = 'inline';
    button.style.display = 'none';
}

// Función para guardar los cambios de un usuario editado en la tabla
function saveUser(button) {
    const row = button.closest('tr');
    const inputs = row.querySelectorAll('input');
    const id = inputs[0].value;

    if (confirm(`¿Estás seguro de que deseas guardar los cambios para el usuario con ID ${id}?`)) {
        const formData = new FormData();
        formData.append('id_usuario', id);
        formData.append('n_identificacion', inputs[1].value);
        formData.append('nombre', inputs[2].value);
        formData.append('passwrd', inputs[3].value);
        formData.append('telefono', inputs[4].value);
        formData.append('email', inputs[5].value);
        formData.append('fecha_nacimiento', inputs[6].value);
        formData.append('rol', inputs[7].value);

        fetch('editar_usuario.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text())
        .then(data => {
            alert(data);
            window.location.reload();
        }).catch(error => {
            console.error('Error:', error);
        });
    }
}

// Función para eliminar un usuario de la tabla
function deleteUser(button) {
    const row = button.closest('tr');
    const id = row.getElementsByTagName('td')[0].innerText;

    if (confirm(`¿Estás seguro de que deseas eliminar el usuario con ID ${id}?`)) {
        window.location.href = `eliminar_usuario.php?id_usuario=${id}`;
    }
}
</script>
