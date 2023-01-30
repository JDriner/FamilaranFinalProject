
<?php
// core configuration
include_once "config/core.php";

// set page title
$page_title = "Login";

// include login checker
$require_login = false;
include_once "login_checker.php";

// default to false
$access_denied = false;

// if the login form was submitted
if ($_POST) {
    // include classes
    include_once "config/database.php";
    include_once "classes/user.php";

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // initialize objects
    $user = new User($db);

    // check if username and password are in the database
    $user->Username_cv = $_POST['username'];

    // check if username exists, also get user details using this usernameExists() method
    $username_exists = $user->usernameExists();

    // validate login
    if ($username_exists && $_POST['userPassword'] === $user->UserPassword_cv) {
        //&& $user->Status_cv == 1    <<<<<<<<<<INCLUDE SOON!!!!


        // set the session value to true
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $user->Username_cv;
        $_SESSION['password'] = $user->UserPassword_cv;
        $_SESSION['userId'] = $user->UserId_cv;
        $_SESSION['accessLevel'] = $user->AccessLevel_cv;
        $_SESSION['userFirstName'] = $user->UserFirstName_cv;
        $_SESSION['userLastName'] = $user->UserLastName_cv;


        // if access level is 'Admin', redirect to admin section
        if ($user->AccessLevel_cv == 'Admin') {
            header("Location: {$home_url}admin/index.php?action=login_success");
        }

        // else, redirect only to 'Customer' section
        else {
            header("Location: {$home_url}index.php?action=login_success");
        }
    }

    // if username does not exist or password is wrong
    else {
        $access_denied = true;
    }
}

// include page header HTML
include_once "header.php";



// get 'action' value in url parameter to display corresponding prompt messages
$action = isset($_GET['action']) ? $_GET['action'] : "";

// tell the user he is not yet logged in
if ($action == 'not_yet_logged_in') {
    echo "<div class='alert alert-danger margin-top-40' role='alert'>Please login.</div>";
}

// tell the user to login
else if ($action == 'please_login') {
    echo "<div class='alert alert-info'>
        <strong>Please login to access that page.</strong>
    </div>";
}

// tell the user username is verified
else if ($action == 'username_verified') {
    echo "<div class='alert alert-success'>
        <strong>Your username address have been validated.</strong>
    </div>";
}

// tell the user if access denied
if ($access_denied) {
    echo "<div class='alert alert-danger margin-top-40' role='alert'>
        Access Denied.<br /><br />
        Your username or password maybe incorrect
    </div>";
}
?>
<link rel="stylesheet" type="text/css" href="assets/login.css">

<form class="codehim-form" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method='post'>
<div class=col-6>
</div>
<div class=col-6>
</div>
    <div class="form-title">
        <img class="mx-auto d-block" src='assets/images/logo.png' width='60%' style='vertical-align:middle;margin:1px 1px'>
    </div>
    <div class="form-group">
    <label for=""><i class="fa fa-user"></i> Username:</label>
    <input type='text' name='username' class="cm-input" placeholder='Enter Username' required autofocus />
    </div>
    <div class="form-group">
    <label for="pass"><i class="fa fa-lock"></i> Password:</label>
    <input id="pass" type='password' class="cm-input" name='userPassword' placeholder='Enter Password' required />
    </div>
    <div class="form-group">
    <input type='submit' class='btn-login  gr-bg' value='Log in' /> 
    </div>
</form>

<?php
include_once "footer.php";
?>