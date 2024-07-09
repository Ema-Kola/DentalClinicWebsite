<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dental Clinic Login</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: url('https://www.shutterstock.com/image-photo/blurred-dental-clinic-background-defocused-600nw-2326575003.jpg') no-repeat center center fixed;
    background-color: rgb(72, 121, 228);
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }
  form {
    background: rgba(255, 255, 255, 0.8); 
    padding: 2em;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 300px;
  }
  img {
    width: 80%; 
    height: auto;
    border-radius: 10px;
    display: block;
    margin: 10px auto; 
  }
  input[type=text], input[type=password] {
    width: calc(100% - 20px);
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ddd;
  }
  button[type=submit] {
    width: 100%;
    padding: 10px;
    border: none;
    background-color: #007BFF;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }
  button[type=submit]:hover {
    background-color: #0056b3;
  }
  .warning {
    color: red;
    text-align: center;
    margin-bottom: 15px;
    display: none; /* Hidden by default */
  }
  .error {
    color: red;
    margin-top: 15px;
    padding: 10px;
    background: rgba(255, 0, 0, 0.1);
    border: 1px solid red;
    border-radius: 5px;
    text-align: center;
  }
</style>
</head>
<body>
  <form action="login.php" id="loginForm" method="post">
    <img src="https://static.vecteezy.com/system/resources/previews/020/150/432/original/dentistry-examination-concept-dentist-and-nurse-working-together-in-dental-clinic-medical-staff-in-stomatology-center-examining-patient-teeth-flat-cartoon-illustration-vector.jpg" alt="Dental Clinic Logo">
    <h2>Login</h2>
    <div class="warning" id="messageArea"><?php if (!empty($error)) echo $error; ?></div>
    <input type="text" name="username" id="username" placeholder="Enter your username" required>
    <input type="password" name="password" id="password" placeholder="Enter your password" required>
    <button type="submit">Login</button>
  </form>
  <?php if (!empty($error)){ ?>
    <div class="error"><?php echo $error; ?></div>
  <?php } ?>
  <?php if (isset($_SESSION)){ ?>
    <div class="alert alert-info mt-3">Session Data: <?php print_r($_SESSION); ?></div>
  <?php } ?>
</body>
</html>
