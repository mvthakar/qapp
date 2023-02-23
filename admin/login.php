<?php
require_once '../helpers/init.php';

session_start();
if (isset($_SESSION['user'])) {
    header('Location: ' . urlOf('admin/dashboard.php'));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        http_response_code(400);
        jsonResponseAndDie(["message" => "Incomplete data"]);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = selectOne("SELECT * FROM `Users` WHERE `Email` = ? AND `UserType` = 'Admin'", [$email]);
    if ($user == null || !password_verify($password, $user['PasswordHash'])) {
        http_response_code(403);
        jsonResponseAndDie(["message" => "Wrong admin email or password!"]);
    }

    $_SESSION['user'] = ['Id' => $user['Id'], 'Email' => $user['Email'], 'UserType' => $user['UserType']];
}

require_once pathOf('admin/includes/header.php');
require_once pathOf('admin/includes/navbar.php');
require_once pathOf('admin/includes/sidebar.empty.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Admin Panel Login</h3>
                        </div>
                        <form onsubmit="return false;">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button id="btn-submit" type="submit" class="btn btn-primary btn-login" id="btn-save-details" onclick="login()">
                                    <span id="btn-submit-text">Submit</span>
                                    <span id="btn-submit-text-saved" style="display: none">Logged in!</span>
                                    <div id="btn-submit-spinner" class="spinner-border spinner-border-sm" role="status" style="display: none">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div id="message">

                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </section>
</div>

<?php
require_once pathOf('admin/includes/footer.part1.php');
require_once pathOf('admin/includes/scripts.php');
?>
<script src="<?= urlOf('admin/js/auth.js') ?>"></script>
<?php
require_once pathOf('admin/includes/footer.part2.php');
?>