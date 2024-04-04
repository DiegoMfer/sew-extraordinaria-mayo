<?php
session_start();

class LoginForm
{
    private $username;
    private $password;
    private $error;

    public function __construct()
    {
        $this->error = '';
    }

    public function handleLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $this->username = $_POST["username"];
                $this->password = $_POST["password"];

                // Conexión a la base de datos
                $servername = "localhost";
                $username = "test";
                $password = "test";
                $dbname = "sew";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Comprobar la conexión
                if ($conn->connect_error) {
                    die("Error de conexión a la base de datos: " . $conn->connect_error);
                }

                // Consulta SQL para verificar el usuario y la contraseña
                $sql = "SELECT * FROM Usuario WHERE nombre = '" . $this->username . "' AND contrasena = '" . $this->password . "'";
                $result = $conn->query($sql);


                if ($result->num_rows == 1) {
                    // Las credenciales son válidas, guardar el nombre de usuario en la sesión
                    $_SESSION['username'] = $this->username;


                    //------------------------------------ registro del loggin en la base de datos ------------------------------
                    // Datos del nuevo elemento a insertar
                    $usuarioNombre = $_POST["username"];
                    $fechaActual = date("Y-m-d H:i:s");
                    $descripcion = "Intento de inicio de sesión con éxito para $usuarioNombre con fecha: $fechaActual ";

                    // Consulta SQL para insertar el nuevo elemento
                    $sql = "INSERT INTO login (usuario_nombre, descripcion) VALUES ('$usuarioNombre', '$descripcion')";

                    if ($conn->query($sql) === TRUE) {
                        echo "Nuevo elemento insertado correctamente.";
                    } else {
                        echo "Error al insertar el elemento: " . $conn->error;
                    }
                    //------------------------------------ registro del loggin en la base de datos ------------------------------

                    // Redireccionar a la página de inicio
                    header("Location: inicio.php");
                    exit();
                } else {
                    // Las credenciales son inválidas, mostrar mensaje de error
                    $this->error = "Usuario o contraseña incorrectos";
                    $this->logError($this->error);
                }




                $conn->close();
            }

            //-------------------------------- Registro de usuario --------------
            if (isset($_POST["reg-username"]) && isset($_POST["reg-password"])) {
                $regUsername = $_POST["reg-username"];
                $regPassword = $_POST["reg-password"];

                // Conexión a la base de datos
                $servername = "localhost";
                $username = "test";
                $password = "test";
                $dbname = "sew";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Comprobar la conexión
                if ($conn->connect_error) {
                    die("Error de conexión a la base de datos: " . $conn->connect_error);
                }

                // Verificar si el nombre de usuario ya existe en la base de datos
                $checkUserQuery = "SELECT * FROM usuario WHERE nombre = '$regUsername'";
                $checkUserResult = $conn->query($checkUserQuery);

                if ($checkUserResult->num_rows > 0) {
                    $registrationError = "El nombre de usuario ya está en uso";
                } else {
                    // Insertar el nuevo usuario en la base de datos
                    $insertUserQuery = "INSERT INTO usuario (nombre, contrasena) VALUES ('$regUsername', '$regPassword')";

                    if ($conn->query($insertUserQuery) === TRUE) {
                        $registrationSuccess = "Registro exitoso, puedes iniciar sesión";
                    } else {
                        $registrationError = "Error en el registro de usuario: " . $conn->error;
                    }
                }

                $conn->close();
            }
        }
    }

    private function logError($message)
    {
        error_log($message);
    }

    public function getError()
    {
        return $this->error;
    }
}

// Crear una instancia del formulario de inicio de sesión
$loginForm = new LoginForm();
$loginForm->handleLogin();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial scale=1.0" />
    <meta name="keywords" content="Reservas" />
    <meta name="author" content="Diego Martín Fernández" />
    <meta name="description" content="Reservas" />
    <title>Reservas</title>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <link rel="stylesheet" type="text/css" href="../estilo/layout.css">
</head>

<body>
    <header>
        <h1>Escritorio Virtual</h1>
        <nav>
            <a tabindex="1" accesskey="I" href="index.html">Página principal</a>
            <a tabindex="2" accesskey="G" href="gastronomia.html">Gastronomía</a>
            <a tabindex="3" accesskey="R" href="rutas.html">Rutas</a>
            <a tabindex="4" accesskey="M" href="meteorologia.html">Meteorología</a>
            <a tabindex="5" accesskey="J" href="juego.html">Juego</a>
            <a tabindex="6" accesskey="E" href="reservas.html">Reservas</a>
        </nav>
    </header>
    <main>
        <section>
            <h2>Iniciar sesión</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="username">Nombre de usuario:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" value="Iniciar sesión">

                <?php if ($loginForm->getError()): ?>
                    <p>
                        <?php echo $loginForm->getError(); ?>
                    </p>
                <?php endif; ?>
            </form>
        </section>

        <section>
            <h2>Registrarse</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="reg-username">Nombre de usuario:</label>
                <input type="text" id="reg-username" name="reg-username" required>

                <label for="reg-password">Contraseña:</label>
                <input type="password" id="reg-password" name="reg-password" required>

                <input type="submit" value="Registrarse">
            </form>

            <?php if (isset($registrationSuccess)): ?>
                <p>
                    <?php echo $registrationSuccess; ?>
                </p>
            <?php elseif (isset($registrationError)): ?>
                <p>
                    <?php echo $registrationError; ?>
                </p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>Página web de Diego Martín Fernández</p>
    </footer>
</body>

</html>