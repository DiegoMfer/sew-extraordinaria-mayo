<?php
session_start();

class Login
{

    public function isUserLoggedIn()
    {
        return !empty($_SESSION['username']);
    }

}

class DB
{
    private $conn;
    public function __construct()
    {
        $this->error = '';

        $servername = "localhost";
        $username = "test";
        $password = "test";
        $dbname = "sew";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Error de conexión a la base de datos: " . $this->conn->connect_error);
        }
    }

    public function getPresupuestosUsuario($username)
    {
        // Prepare the SQL query
        $sql = "SELECT * FROM Presupuesto WHERE nombre_usuario = ?";

        // Prepare the statement
        $stmt = $this->conn->prepare($sql);

        // Bind parameter
        $stmt->bind_param('s', $username);

        // Execute the query
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Fetch the results
        $presupuestos = $result->fetch_all(MYSQLI_ASSOC);

        // Close statement
        $stmt->close();

        return $presupuestos;
    }

    public function getRecursos()
    {

        $sql = "SELECT * FROM Recurso_turistico";
        $result = $this->conn->query($sql);

        $recursos = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Create an object for each row
                $recurso = new stdClass();
                $recurso->id = $row["id"];
                $recurso->nombre = $row["nombre"];
                $recurso->tipo = $row["tipo"];
                $recurso->descripcion = $row["descripcion"];
                $recurso->limite_ocupacion = $row["limite_ocupacion"];
                $recurso->precio = $row["precio"];

                // Add the object to the array
                $recursos[] = $recurso;
            }
        } else {
            echo "0 results";
        }
        return $recursos;
    }

    public function getReservasUsuario($username)
    {
        // Prepare the SQL query
        $sql = "SELECT * FROM Reserva WHERE nombre_usuario = ?";

        // Prepare the statement
        $stmt = $this->conn->prepare($sql);

        // Bind parameter
        $stmt->bind_param('s', $username);

        // Execute the query
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Fetch the results
        $reservas = $result->fetch_all(MYSQLI_ASSOC);

        // Close statement
        $stmt->close();

        return $reservas;
    }

    public function savePresupuestoForUser($username, $precio)
    {
        $sql = "INSERT INTO Presupuesto (nombre_usuario, precio) VALUES (?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param('sd', $username, $precio); // 's' para string, 'd' para decimal

        $stmt->execute();

        if ($stmt->affected_rows > 0) {

            $stmt->close();
            return true;
        } else {

            $stmt->close();
            return false;
        }
    }

    public function deleteAllPresupuestosForUser($username)
    {
        $sql = "DELETE FROM Presupuesto WHERE nombre_usuario = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param('s', $username);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function deleteAllReservastosForUser($username)
    {
        $sql = "DELETE FROM Reserva WHERE nombre_usuario = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function getRecurso($recursoId)
    {
        // Prepare the SQL query with a WHERE clause to select a specific resource by ID
        $sql = "SELECT * FROM Recurso_turistico WHERE id = ?";

        // Prepare the statement
        $stmt = $this->conn->prepare($sql);

        // Bind the parameter
        $stmt->bind_param("i", $recursoId);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        $recurso = null;
        if ($result->num_rows > 0) {
            // Fetch the row
            $row = $result->fetch_assoc();
            // Create an object for the row
            $recurso = new stdClass();
            $recurso->id = $row["id"];
            $recurso->nombre = $row["nombre"];
            $recurso->tipo = $row["tipo"];
            $recurso->descripcion = $row["descripcion"];
            $recurso->limite_ocupacion = $row["limite_ocupacion"];
            $recurso->precio = $row["precio"];
        } else {
            echo "Resource not found";
        }

        // Close the statement
        $stmt->close();

        return $recurso;
    }


    public function addReserva($username, $id_recurso, $start_date, $end_date, $precio)
    {
        // Prepare the SQL statement to insert a new reservation
        $sql = "INSERT INTO Reserva (nombre_usuario, id_recurso, fecha_inicio, fecha_fin, precio) VALUES (?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $this->conn->prepare($sql);

        // Bind the parameters
        $stmt->bind_param("sissd", $username, $id_recurso, $start_date, $end_date, $precio);

        // Execute the statement
        $success = $stmt->execute();

        // Close the statement
        $stmt->close();
    }

    public function getConn()
    {
        return $this->conn;
    }
}

$login = new Login();
$db = new DB();

class Logic
{
    private $db;
    private $selectedRecurso;

    public function __construct($db)
    {
        $this->db = $db;

        if ($this->isRecursoSelected()) {
            $selectedResourceId = $_SESSION['recurso'];
            $this->selectedRecurso = $this->db->getRecurso($selectedResourceId);
        }
    }
    public function isRecursoSelected()
    {
        if (!empty($_POST['recurso'])) {
            $_SESSION['recurso'] = $_POST['recurso'];
        }
        return !empty($_SESSION['recurso']);
    }

    public function getRecursoSelected()
    {
        return $this->selectedRecurso;
    }

    public function getReservationsByDateRange($start_date, $end_date)
    {
        // Create a connection
        $conn = $this->db->getConn();

        $resource_id = $this->getRecursoSelected()->id;

        // Prepare the SQL query
        $sql = "SELECT * 
                FROM Reserva 
                WHERE id_recurso = ? 
                AND fecha_inicio BETWEEN ? AND ? 
                AND fecha_fin BETWEEN ? AND ?";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param('issss', $resource_id, $start_date, $end_date, $start_date, $end_date);

        // Execute the query
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Fetch the results
        $reservations = $result->fetch_all(MYSQLI_ASSOC);

        // Close statement and connection
        $stmt->close();

        return $reservations;
    }

    public function getNumberOfReservationsAvailable($start_date, $end_date)
    {
        $numberOfReservations = count($this->getReservationsByDateRange($start_date, $end_date));
        return $this->getRecursoSelected()->limite_ocupacion - $numberOfReservations;
    }

    public function reservePlazas($number)
    {
        $username = $_SESSION['username'];
        $id_recurso = $_SESSION['recurso'];
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];

        $plazas = $this->getNumberOfReservationsAvailable($start_date, $end_date);

        if ($plazas < $number) {
            echo "No hay plazas suficientes.";
            return;
        }

        for ($i = 0; $i < $number; $i++) {

            $start_date_object = new DateTime($start_date);
            $end_date_object = new DateTime($end_date);
            $difference = $start_date_object->diff($end_date_object);

            $total_price = $this->selectedRecurso->precio * $difference->days;
            $this->db->addReserva($username, $id_recurso, $start_date, $end_date, $total_price);
        }

        echo "$number reservas añadida correctamente.";
    }

    public function getReservasUsuario()
    {
        $result = $this->db->getReservasUsuario($_SESSION['username']);
        return $result;
    }

    public function getPresupuestosUsuario()
    {
        $result = $this->db->getPresupuestosUsuario($_SESSION['username']);
        return $result;
    }

    public function savePresupuestoForUser()
    {
        $this->getReservasUsuario();
        $reservas = $this->getReservasUsuario();

        $precio = 0;
        foreach ($reservas as $reserva) {
            $recurso = $this->db->getRecurso($reserva['id_recurso']);

            $precio += $recurso->precio;
        }

        $result = $this->db->savePresupuestoForUser($_SESSION['username'], $precio);
        return $result;
    }

    public function deleteAllPresupuestosForUser()
    {
        $result = $this->db->deleteAllPresupuestosForUser($_SESSION['username']);
        return $result;
    }

    public function deleteAllReservasForUser()
    {
        $result = $this->db->deleteAllReservastosForUser($_SESSION['username']);
        return $result;
    }

}




$lg = new Logic($db);
?>

<!DOCTYPE HTML>
<html lang="es">

<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial scale=1.0" />
    <meta name="keywords" content="info, persona" />
    <meta name="author" content="Diego Martín Fernández" />
    <meta name="description" content="Proyecto final sew extraordinaria " />
    <title>Página web</title>
    <link rel="icon" href="multimedia/image/favicon.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <link rel="stylesheet" type="text/css" href="../estilo/layout.css">
</head>

<body>
    <header>
        <h1>Islas Baleares</h1>
        <nav>
            <a tabindex="1" accesskey="I" href="../index.html">Página principal</a>
            <a tabindex="2" accesskey="G" href="../gastronomia.html">Gastronomía</a>
            <a tabindex="3" accesskey="R" href="../rutas.html">Rutas</a>
            <a tabindex="4" accesskey="M" href="../meteorologia.html">Meteorología</a>
            <a tabindex="5" accesskey="J" href="../juego.html">Juego</a>
            <a tabindex="6" accesskey="E" href="php/login.php">Reservas</a>
        </nav>
    </header>

    <!--Contenido que diferencia al documento html del resto del documento-->
    <main>

        <?php if ($login->isUserLoggedIn()): ?>



            <section>
                <h2>Mostrar Recurso Turístico</h2>
                <form action="#" method="post">
                    <label for="recurso">Selecciona un recurso turístico:</label>
                    <select id="recurso" name="recurso">
                        <?php foreach ($db->getRecursos() as $indice => $recurso): ?>
                            <option value="<?php echo $indice + 1; ?>"><?php echo $recurso->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="Mostrar información">
                </form>
            </section>




            <?php if ($lg->isRecursoSelected()): ?>
                <section>
                    <h2>Información del Recurso Turístico</h2>
                    <?php
                    $selectedRecurso = $lg->getRecursoSelected();

                    if ($selectedRecurso !== null): ?>
                        <p>
                            ID: <?php echo $selectedRecurso->id; ?> <br>
                            Nombre: <?php echo $selectedRecurso->nombre; ?> <br>
                            Tipo: <?php echo $selectedRecurso->tipo; ?> <br>
                            Descripción: <?php echo $selectedRecurso->descripcion; ?> <br>
                            Límite de Ocupación: <?php echo $selectedRecurso->limite_ocupacion; ?> <br>
                            Precio: <?php echo $selectedRecurso->precio; ?> <br>
                        </p>
                    <?php else: ?>
                        <p>El recurso seleccionado no se encontró en la base de datos.</p>
                    <?php endif; ?>
                </section>

                <section>
                    <h2>Reservar Recurso Turístico - <?php echo $lg->getRecursoSelected()->nombre; ?></h2>

                    <form action="#" method="post">
                        <label for="start_date">Fecha de inicio:</label>
                        <input type="date" id="start_date" name="start_date" required>
                        <label for="end_date">Fecha de fin:</label>
                        <input type="date" id="end_date" name="end_date" required>

                        <input type="submit" value="Consultar reservas">
                    </form>
                    <?php
                    if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
                        $_SESSION['start_date'] = $_POST['start_date'];
                        $_SESSION['end_date'] = $_POST['end_date'];

                    }
                    ?>

                    <?php if (isset($_SESSION['start_date']) && isset($_SESSION['end_date'])): ?>
                        <?php
                        $remaining_reservations = $lg->getNumberOfReservationsAvailable($_SESSION['start_date'], $_SESSION['end_date']);
                        echo "<p>Reservas restantes entre {$_SESSION['start_date']} y {$_SESSION['end_date']} para {$_SESSION['recurso']}: $remaining_reservations</p>";
                        ?>
                        <form action="#" method="post">
                            <label for="number">Establecer número de plazas</label>
                            <input type="number" id="plazas" name="plazas" required>
                            <input type="submit" value="Reservar plazas">
                        </form>

                        <?php
                        if (isset($_POST['plazas'])) {
                            $lg->reservePlazas($_POST['plazas']);
                        }
                        ?>
                        </form>

                    <?php endif; ?>

                </section>


                <section>
                    <h2>Realizar presupuesto</h2>
                    <?php if (count($lg->getReservasUsuario()) == 0): ?>
                        <p>Todavía no hay reservas</p>
                    <?php else: ?>

                        <form action="#" method="post">


                            <label for="comando">Selecciona una acción</label>
                            <select id="comando" name="comando">
                                <option value="guardar_presupuesto">Guardar presupuesto</option>
                                <option value="eliminar_presupuestos">Eliminar presupuestos</option>
                                <option value="eliminar_reservas">Eliminar reservas</option>
                            </select>


                            <input type="submit" value="Ejecutar comando">
                        </form>

                        <?php


                        if (isset($_POST['comando'])) {

                            if ($_POST['comando'] == "guardar_presupuesto") {
                                $lg->savePresupuestoForUser();
                            }

                            if ($_POST['comando'] == "eliminar_presupuestos") {
                                $lg->deleteAllPresupuestosForUser();
                            }

                            if ($_POST['comando'] == "eliminar_reservas") {
                                $lg->deleteAllReservasForUser();
                            }

                        }?>

                        <h3>Presupuestos realizados</h3>

                        <?php if (count($lg->getPresupuestosUsuario()) == 0): ?>
                            <p>Todavía no hay presupuestos</p>
                        <?php else: ?>
                            <?php foreach ($lg->getPresupuestosUsuario() as $presupuesto): ?>
                                <p><?= $presupuesto['id'] ?> - <?= $presupuesto['precio'] ?></p>
                            <?php endforeach; ?>

                        <?php endif; ?>

                        <h3>Recursos reservados </h3>

                        <?php if (count($lg->getReservasUsuario()) == 0): ?>
                            <p>Todavía no hay reseras</p>
                        <?php else: ?>
                            <?php foreach ($lg->getReservasUsuario() as $reserva): ?>
                                <p><?= $db->getRecurso($reserva['id_recurso'])->nombre ?> - <?= $reserva['fecha_inicio'] ?> -
                                    <?= $reserva['fecha_fin'] ?>
                                </p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </section>

            <?php endif; ?>

        <?php else: ?>

            <section>
                <h2>Usuario sin sesión</h2>
                <p>Inicia sesión para poder acceder a la aplicación</p>
            </section>

        <?php endif; ?>
    </main>

    <!--Tiene que ser el mismo para todo el documento -->
    <footer>
        <p>Página web de Diego Martín Fernández</p>
    </footer>
</body>

</html>