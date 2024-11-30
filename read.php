<?php
include 'database.php';
include 'client.php';
include 'module.php';
include 'filier.php';
include 'groupe.php';
include 'category.php';
$clients = Client::selectAllClients("Clients", $objet->conn);
$modules = Module::selectAllModules("Modules", $objet->conn);
$filiers = Filiere::selectAllFilieres("Filiers", $objet->conn);
$groupes = Group::selectAllGroups("Groupes", $objet->conn);
$categories = Category::selectAllCategories("Categories", $objet->conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>List of users from database</title>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<body>
    <h1>List of Users from Database</h1>
    <table id="customers">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($clients as $client): ?>
        <tr>
            <td><?php echo $client['id']; ?></td>
            <td><?php echo $client['firstname']; ?></td>
            <td><?php echo $client['lastname']; ?></td>
            <td><?php echo $client['email']; ?></td>
            <td>
                <a href="update.php?id=<?php echo $client['id']; ?>">Edit</a>
                <a href="delete.php?id=<?php echo $client['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
