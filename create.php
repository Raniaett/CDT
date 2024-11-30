<?php 
include 'Client.php';
include 'clitable.php';
$loginErrorMsg = "";
$registerErrorMsg = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($objet->conn->connect_error) {
        $loginErrorMsg = $registerErrorMsg = "Failed to connect to database: " . $objet->conn->connect_error;
    } else {
        // Login Logic
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            
            if (empty($email) || empty($password)) {
                $loginErrorMsg = "All fields must be filled!";
            } else {
                $stmt = $objet->conn->prepare("SELECT * FROM Clients WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        $successMsg = "Login successful!";
                        header("Location: read.php");
                        exit();
                    } else {
                        $loginErrorMsg = "Invalid password!";
                    }
                } else {
                    $loginErrorMsg = "No user found with this email!";
                }
                $stmt->close();
            }
        }

        // Registration Logic
        if (isset($_POST["submit"])) {
            $firstname = $_POST["firstName"];
            $lastname = $_POST["lastName"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $idCategory = $_POST["idCategory"];
            $idGroupe = $_POST["idGroupe"];
            $idModule = $_POST["idModule"];
            $idFilier = $_POST["idFilier"];

            if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || 
                empty($idCategory) || empty($idGroupe) || empty($idModule) || empty($idFilier)) {
                $registerErrorMsg = "All fields must be filled!";
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Create a new Client object with the new fields
                $client = new Client($firstname, $lastname, $email, $hashedPassword, $idCategory, $idGroupe, $idModule, $idFilier);
                $client->insertClient("Clients", $objet->conn);

                // Retrieve any messages from Client class
                $registerErrorMsg = Client::$errorMsg;
                $successMsg = Client::$successMsg;
                header("Location: read.php");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration Form</title>
    <link rel="stylesheet" href="style.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }

    .hero {
        height: 100%;
        width: 100%;
        background-image: linear-gradient(rgba(0, 0, 0, .4), rgba(0, 0, 0, .4)), url('https://i.postimg.cc/C5dVWngw/banner.jpg');
        background-position: center;
        background-size: cover;
        position: absolute;
    }

    .form-box {
        width: 380px;
        height: 480px;
        position: relative;
        margin: 6% auto;
        background: #fff;
        padding: 5px;
        overflow: hidden;
        border-radius: 10px;
    }

    .button-box {
        width: 220px;
        margin: 35px auto;
        position: relative;
        box-shadow: 0 0 20px 9px #ff61241f;
        border-radius: 30px;
    }

    .toggle-btn {
        padding: 10px 30px;
        cursor: pointer;
        background: transparent;
        border: none;
        outline: none;
        position: relative;
    }

    #btn {
        top: 0;
        left: 0;
        position: absolute;
        width: 110px;
        height: 100%;
        background: linear-gradient(to right, #ff105f, #ffad06);
        border-radius: 30px;
        transition: .5s;
    }

    .input-group {
        position: absolute;
        width: 280px;
        top: 180px;
        transition: .5s;
        overflow-y: auto;
        max-height: 250px; /* Limit the height of the input group */
    }

    .input-field {
        width: 100%;
        padding: 10px 0;
        margin: 5px 0;
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
        margin: auto;
        background: linear-gradient(to right, #ff105f, #ffad06);
        border: none;
        outline: none;
        border-radius: 30px;
    }

    .check-box {
        margin: 30px 10px 30px 0;
    }

    span {
        color: #777;
        font-size: 12px;
        bottom: 68px;
        position: absolute;
    }

    #login {
        left: 50px;
    }

    #register {
        left: 450px;
    }
</style>
</head>
<body>

    <div class="hero">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Login</button>
                <button type="button" class="toggle-btn" onclick="register()">Register</button>
            </div>
            <form method="POST" class="input-group" id="login">
                <input type="email" class="input-field" name="email" placeholder="Email ID" required>
                <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
                <input type="checkbox" class="check-box"><span>Remember Password</span>
                <button type="submit" name="login" class="submit-btn">Login</button>
            </form>
            <form method="POST" class="input-group" id="register">
                <input type="text" name="firstName" class="input-field" placeholder="First name" required>
                <input type="text" name="lastName" class="input-field" placeholder="Last name" required>
                <select name='idCategory' class="input-field">
                    <option selected>Select your Category</option>
                    <?php
                    include("category.php");
                    $categories = Category::selectAllCategories('Categories', $objet->conn);
                    foreach($categories as $category){
                        echo "<option value='$category[id]'>$category[name]</option>";
                    }
                    ?>
                </select>
                <select name='idGroupe' class="input-field">
                    <option selected>Select your Groupe</option>
                    <?php
                    include("groupe.php");
                    $groupes = Group::selectAllGroups('Groupes', $objet->conn);
                    foreach($groupes as $groupe){
                        echo "<option value='$groupe[id]'>$groupe[name]</option>";
                    }
                    ?>
                </select>
                <select name='idModule' class="input-field">
                    <option selected>Select your Module</option>
                    <?php
                    include("modules.php");
                    $modules = Module::selectAllModules('Modules', $objet->conn);
                    foreach($modules as $module){
                        echo "<option value='$module[id]'>$module[name]</option>";
                    }
                    ?>
                </select>
                <select name='idFilier' class="input-field">
                    <option selected>Select your Filier</option>
                    <?php
                    include("Filier.php");
                    $filiers = Filiere::selectAllFilieres('Filiers', $objet->conn);
                    foreach($filiers as $filier){
                        echo "<option value='$filier[id]'>$filier[name]</option>";
                    }
                    ?>
                </select>
                <input type="email" class="input-field" name="email" placeholder="Email" required>
                <input type="password" class="input-field" name="password" placeholder="Enter Password" required>
                <button type="submit" name="submit" class="submit-btn">Register</button>
                <div><?php echo $registerErrorMsg; ?></div>
                <div><?php echo $successMsg; ?></div>
            </form>
        </div>
    </div>

    <script>
        var x = document.getElementById('login');
        var y = document.getElementById('register');
        var z = document.getElementById('btn');

        function register() {
            x.style.left = "-400px"; // Move login form out of view
            y.style.left = "50px"; // Bring register form into view
            z.style.left = "110px"; // Move the slider to the register side
        }

        function login() {
            x.style.left = "50px"; // Bring login form into view
            y.style.left = "450px"; // Move register form out of view
            z.style.left = "0"; // Move the slider to the login side
        }
    </script>
</body>
</html>
