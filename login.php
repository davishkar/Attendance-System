<?php
session_start();

// Branch number from URL
$branchId = isset($_GET['branch']) ? intval($_GET['branch']) : 0;

// Set credentials for all branches (तुला नंतर इतर शाखांसाठीही वेगळे युजरनेम/पास सेट करता येतील)
$credentials = [
    1 => ['username' => 'v','password' => 'o'],
    // नंतर इथे इतर शाखांचे username-password टाकू शकतो
];

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUser = $_POST['username'];
    $inputPass = $_POST['password'];

    if (isset($credentials[$branchId]) && 
        $inputUser === $credentials[$branchId]['username'] && 
        $inputPass === $credentials[$branchId]['password']) {

        $_SESSION['loggedin'] = true;
        $_SESSION['branch'] = $branchId;

        header("Location:test.php?id=" . $branchId);
        exit();
    } else {
        $error = "⚠️ चुकीचा युजरनेम किंवा पासवर्ड!";
    }
}
?>
<!DOCTYPE html>
<html lang="mr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>लॉगिन - शाखा <?php echo $branchId; ?></title>
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      background: #fff8e1;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background: #fff3e0;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      width: 300px;
      text-align: center;
    }

    .login-box h2 {
      color: #e65100;
      margin-bottom: 20px;
    }

    .input-field {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 8px;
      border: 1px solid #ffcc80;
    }

    .btn {
      background: #ff9800;
      color: white;
      border: none;
      padding: 10px;
      width: 100%;
      margin-top: 10px;
      font-weight: bold;
      cursor: pointer;
      border-radius: 8px;
      transition: background 0.3s;
    }

    .btn:hover {
      background: #f57c00;
    }

    .error {
      color: red;
      font-size: 0.9rem;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <form method="POST" class="login-box">
    <h2>शाखा <?php echo $branchId; ?> लॉगिन</h2>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>
    <input type="text" name="username" placeholder="User ID" class="input-field" required>
    <input type="password" name="password" placeholder="Password" class="input-field" required>
    <button type="submit" class="btn">Login</button>
  </form>
</body>
</html>
