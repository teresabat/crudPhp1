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
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<div class="content">
<h2>Gerenciar Usuários</h2></br>
<form method="POST" action="index.php"><br>
<input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>"><br>
<input type="text" name="name" placeholder="Nome" value="<?php echo isset($name) ? $name : ''; ?>" required><br>
<input type="email" name="email" placeholder="Email" value="<?php echo isset($email) ? $email : ''; ?>" required><br>
<button type="submit" name="<?php echo isset($id) ? 'update' : 'save'; ?>"><?php echo isset($id) ? 'Atualizar' : 'Salvar'; ?></button><br>
</form>
<table id="table">
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
    </div>
    </div>
    
    </body>
    </html>
