<?php
include 'Connection.php';
include 'Client.php';

$errorMsg = "";
$successMsg = "";

$objet = new Connection();
$objet->selectDatabase("chap4Db");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch the client data to display in the form
    $id = $_GET['id'];
    $row = Client::selectClientById("Clients", $objet->conn, $id);

    if (!$row) {
        die("Client not found!");
    }

    $emailValue = $row["email"];
    $lnameValue = $row["lastname"];
    $fnameValue = $row["firstname"];
} else if (isset($_POST["submit"])) {
    // Handle form submission to update the client
    $id = $_POST["id"];
    $emailValue = $_POST["email"];
    $lnameValue = $_POST["lastName"];
    $fnameValue = $_POST["firstName"];
    $passwordValue = $_POST["password"];

    if (empty($emailValue) || empty($lnameValue) || empty($fnameValue)) {
        $errorMsg = "All fields must be filled!";
    } else {
        $client = new Client($fnameValue, $lnameValue, $emailValue, $passwordValue);
        Client::updateClient($client, "Clients", $objet->conn, $id);
        $successMsg = "Client updated successfully!";
        header("Location: read.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <link rel="stylesheet" type="text/css" href="style.css"> <!-- Include your CSS file here -->
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .hero {
            height: 100vh; /* Full viewport height */
            width: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, .4), rgba(0, 0, 0, .4)), url('https://i.postimg.cc/C5dVWngw/banner.jpg');
            background-position: center;
            background-size: cover;
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-box {
            width: 380px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }

        .form-box h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
        }

        .input-field {
            width: 100%;
            padding: 10px 0;
            margin: 10px 0;
            border-left: 0;
            border-top: 0;
            border-right: 0;
            border-bottom: 1px solid #999;
            outline: none;
            background: transparent;
        }

        .submit-btn {
            width: 85%;
            padding: 10px 30px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
            background: linear-gradient(to right, #ff105f, #ffad06);
            border: none;
            outline: none;
            border-radius: 30px;
        }

        .error, .success {
            font-size: 14px;
            color: #f00;
        }

        .success {
            color: #0f0;
        }

    </style>
</head>
<body>
    <div class="hero">
        <div class="form-box">
            <h2>Update User</h2>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <input type="text" name="firstName" value="<?php echo $fnameValue; ?>" class="input-field" placeholder="First Name">
                <input type="text" name="lastName" value="<?php echo $lnameValue; ?>" class="input-field" placeholder="Last Name">
                <input type="email" name="email" value="<?php echo $emailValue; ?>" class="input-field" placeholder="Email">
                <input type="password" name="password" class="input-field" placeholder="New Password">
                <button type="submit" name="submit" class="submit-btn">Update</button>
            </form>
            <?php if ($errorMsg): ?>
                <div class="error"><?php echo $errorMsg; ?></div>
            <?php endif; ?>
            <?php if ($successMsg): ?>
                <div class="success"><?php echo $successMsg; ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
