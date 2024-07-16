
Para criar um CRUD (Create, Read, Update, Delete) com PHP e MySQL, você pode seguir este guia básico. Vou mostrar um exemplo simples para gerenciar uma tabela de "usuários".

Passo 1: Configuração do Ambiente
Certifique-se de ter um servidor local instalado, como o XAMPP, que inclui Apache, PHP e MySQL.

Passo 2: Criar o Banco de Dados e a Tabela
Primeiro, crie um banco de dados e uma tabela no MySQL.

sql
Copiar código
CREATE DATABASE crud_example;

USE crud_example;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);
Passo 3: Conectar ao Banco de Dados com PHP
Crie um arquivo db.php para gerenciar a conexão ao banco de dados.

php
Copiar código
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud_example";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
Passo 4: Criar a Interface do CRUD
Crie um arquivo index.php para exibir, adicionar, editar e deletar usuários.

php
Copiar código
<?php
include 'db.php';

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    $conn->query($sql);

    header("Location: index.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM users WHERE id=$id";
    $conn->query($sql);

    header("Location: index.php");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
    $conn->query($sql);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD com PHP e MySQL</title>
</head>
<body>
    <h2>Gerenciar Usuários</h2>
    <form method="POST" action="index.php">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <input type="text" name="name" placeholder="Nome" value="<?php echo isset($name) ? $name : ''; ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo isset($email) ? $email : ''; ?>" required>
        <button type="submit" name="<?php echo isset($id) ? 'update' : 'save'; ?>"><?php echo isset($id) ? 'Atualizar' : 'Salvar'; ?></button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM users");
        while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <a href="index.php?edit=<?php echo $row['id']; ?>">Editar</a>
                <a href="index.php?delete=<?php echo $row['id']; ?>">Deletar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
Passo 5: Editar Usuários
Modifique o index.php para permitir a edição dos usuários.

php
Copiar código
<?php
include 'db.php';

$name = '';
$email = '';
$id = 0;
$update = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;

    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
    }
}