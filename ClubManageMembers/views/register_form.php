<form action="register_process.php" method="post" enctype="multipart/form-data" novalidate="novalidate">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required="required">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required="required">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your password" required="required">
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">Register</button>
            </div>
</form>

<div class="d-inline-flex">
                <p class="m-0">You have an account? You can <a href="login.php">Login Now</a></p>
                
</div>