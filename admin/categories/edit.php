<?php
require_once "../../helpers/init.php";
require_once pathOf('admin/helpers/is-admin.php');

if (!isset($_REQUEST['id'])) {
    header('Location: ' . urlOf('admin/categories'));
    exit();
}

$id = $_REQUEST['id'];
$category = selectOne("SELECT * FROM `Categories` WHERE `Id` = ? AND `IsDeleted` = 0", [$id]);
if ($category == null) {
    header('Location: ' . urlOf('admin/categories'));
    jsonResponseAndDie(["message" => "Category does not exist!"]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['name'])) {
        http_response_code(400);
        jsonResponseAndDie(["message" => "Incomplete data!"]);
    }

    $name = $_POST['name'];
    if ($name == $category['Name']) {
        jsonResponseAndDie(["message" => "Category updated successfully."]);
    }
    
    $existingCategory = selectOne("SELECT `Id` FROM `Categories` WHERE `Name` = ? AND `IsDeleted` = 0", [$name]);
    if ($existingCategory != null) {
        http_response_code(409);
        jsonResponseAndDie(["message" => "Category already exists!"]);
    }

    execute("UPDATE `Categories` SET `Name` = ? WHERE `Id` = ?", [$name, $id]);
    jsonResponseAndDie(["message" => "Category updated successfully."]);
}

$title = "Edit Category";

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
                        <h1>Edit Category</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= urlOf('admin/') ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= urlOf('admin/notices') ?>">Categories</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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
                                            <input value="<?= $category['Name'] ?>" type="text" class="form-control" id="name" placeholder="Enter Category Name" required autofocus>
                                        </div>
                                    </div>
                                </div>
                                <button id="btn-submit" type="submit" class="btn btn-success" onclick="editCategory(<?= $id ?>)">
                                    <span id="btn-submit-text">Save</span>
                                    <span id="btn-submit-text-saved" style="display: none">Saved!</span>
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