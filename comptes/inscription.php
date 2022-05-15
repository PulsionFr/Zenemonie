<!DOCTYPE html>
<?php session_start(); ?>
<html>
    <head>
        <link rel="stylesheet" href="./styles/inscription.css">
    </head>
    <body>

    <main class="inscription">
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autofocus>
                <?php if (isset($_SESSION["error_email"])): ?>
                    <small class="error"><?php echo $_SESSION["error_email"]; ?></small>
                    <?php unset($_SESSION["error_email"]); ?>
                <?php endif; ?>
            </div>
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($_SESSION["error_password"])): ?>
                    <small class="error"><?php echo $_SESSION["error_password"]; ?></small>
                    <?php unset($_SESSION["error_password"]); ?>
                <?php endif; ?>
            </div>
            <div>
                <label for="confirmation">Confirmation</label>
                <input type="password" id="confirmation" name="confirmation" required>
                <?php if (isset($_SESSION["error_confirmation"])): ?>
                    <small class="error"><?php echo $_SESSION["error_confirmation"]; ?></small>
                    <?php unset($_SESSION["error_confirmation"]); ?>
                <?php endif; ?>
            </div>
            <button type="submit">Créer</button>
        </main>
    </body>
</html>