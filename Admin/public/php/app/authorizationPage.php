<!DOCTYPE html>
<html>
    <head>
        <title><? echo(env("APP_NAME","Support")) ?></title>
        <link rel="stylesheet" href="/styles/authorization.css">
    </head>
    <body>
      <div class="form-container">
        <form action="/Api/checkProfile" method="POST">
          <div class="title">Вход</div>
          <div style="display: grid;">
            <label>Email:</label><input name="email" id="email" type="text" :min="8" :max="20" required="true">
            <label>Пароль:</label><input name="password" id="password" type="password" :min="8" :max="20" required="true">
          </div>
          <button type="submit">Вход</button>
        </form>
      </div>
    </body>
</html>