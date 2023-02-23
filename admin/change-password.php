<?php
require_once "../helpers/init.php";
require_once pathOf('admin/helpers/is-admin.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['oldPassword']) || !isset($_POST['newPassword'])) {
        http_response_code(400);
        jsonResponseAndDie(["message" => "Incomplete data"]);
    }

    $userId = $_SESSION['user']['Id'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];

    $user = selectOne("SELECT * FROM `Users` WHERE `Id` = ? AND `UserType` = 'Admin'", [$userId]);

    if (!password_verify($oldPassword, $user['PasswordHash'])) {
        http_response_code(401);
        jsonResponseAndDie(["message" => "Old password is wrong!"]);
    }

    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    execute("UPDATE `Users` SET `PasswordHash` = ? WHERE `Id` = ?", [$newPasswordHash, $userId]);

    jsonResponseAndDie(["message" => "Password changed successfully!"]);
}

require(pathOf("admin/includes/header.php"));
require(pathOf("admin/includes/navbar.php"));
require(pathOf("admin/includes/sidebar.php"));
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
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <form onsubmit="return false;">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="password">Old Password</label>
                                    <input type="password" name="old-password" id="old-password" class="form-control" placeholder="Old Password" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" name="new-password" id="new-password" class="form-control" placeholder="New Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Confirm New Password</label>
                                    <input type="password" name="confirm-password" id="confirm-password" class="form-control" placeholder="Confirm New Password" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button id="btn-submit" type="submit" onclick="changePassword()" class="btn btn-primary btn-login">
                                    <span id="btn-submit-text">Save</span>
                                    <span id="btn-submit-text-saved" style="display: none">Saved!</span>
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
<script src="<?= urlOf('admin/js/auth.js') ?>?<?= time() ?>"></script>
<?php
require_once pathOf('admin/includes/footer.part2.php');
?>