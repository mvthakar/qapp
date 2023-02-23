<?php
require_once "../../helpers/init.php";
require_once pathOf('admin/helpers/is-admin.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['name'])) {
        http_response_code(400);
        jsonResponseAndDie(["message" => "Incomplete data!"]);
    }

    $name = $_POST['name'];

    $category = selectOne("SELECT `Id` FROM `Categories` WHERE `Name` = ? AND `IsDeleted` = 0", [$name]);
    if ($category != null) {
        http_response_code(409);
        jsonResponseAndDie(["message" => "Category already exists!"]);
    }

    execute("INSERT INTO `Categories` SET `Name` = ?", [$name]);
    jsonResponseAndDie(["message" => "Category created successfully."]);
}

$title = "Create New Category";

require_once pathOf("admin/includes/header.php");
require_once pathOf("admin/includes/navbar.php");
require_once pathOf("admin/includes/sidebar.php");
?>

<div class="content-wrapper">
    <div class="container">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create New Category</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= urlOf('admin/') ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= urlOf('admin/notices') ?>">Categories</a></li>
                            <li class="breadcrumb-item active">Create New</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col">
                    <form onsubmit="return false;">
                        <div class="card card-outline card-info">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="name">Category Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="Enter Category Name" required autofocus>
                                        </div>
                                    </div>
                                </div>
                                <button id="btn-submit" type="submit" class="btn btn-success" onclick="createCategory();">
                                    <span id="btn-submit-text">Create</span>
                                    <span id="btn-submit-text-saved" style="display: none">Created!</span>
                                    <div id="btn-submit-spinner" class="spinner-border spinner-border-sm" role="status" style="display: none">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="message">

            </div>
        </section>
    </div>
</div>

<?php
require_once pathOf('admin/includes/footer.part1.php');
require_once pathOf('admin/includes/scripts.php');
?>
<script src="<?= urlOf('admin/js/categories.js') ?>?<?= time() ?>"></script>
<?php
require_once pathOf('admin/includes/footer.part2.php');
?>