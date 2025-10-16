<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registration</title>
  <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
  <div class="card">
    <h1>Registration</h1>
    <p class="hint">Fill out the form to create your account.</p>

    <form method="post" action="registerAction.php">
      <div class="row">
        <label for="name">Name</label>
        <input
          type="text"
          id="name"
          name="name"
          placeholder="Your name"
          required
        />
      </div>

      <div class="row">
        <label for="email">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="you@example.com"
          required
        />
      </div>

      <div class="row">
        <label for="password">Password</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="min. 6 characters"
          required
        />
      </div>

      <button type="submit">Register</button>
      <a href="index.html" id="login-link">Already have an account?</a>
    </form>
  </div>
</body>
</html>
