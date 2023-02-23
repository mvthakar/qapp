<?php
require_once "../../helpers/init.php";
require_once pathOf('admin/helpers/is-admin.php');

if (!isset($_GET['questionId'])) {
    header('Location: ' . urlOf('admin/questions'));
    exit();
}

$title = "Answers";
$questionId = $_GET['questionId'];
$answers = select("SELECT * FROM `Answers` WHERE `QuestionId` = ? AND `IsDeleted` = 0 ORDER BY `PostedOn` DESC", [$questionId]);

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
                        <h1>Answers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= urlOf('admin/') ?>">Home</a></li>
                            <li class="breadcrumb-item active"><a href="<?= urlOf('admin/questions') ?>">Manage Questions</a></li>
                            <li class="breadcrumb-item active"><a href="<?= urlOf('admin/questions') ?>"><?= $questionId ?></a></li>
                            <li class="breadcrumb-item active">Manage Answers</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card card-outline card-info mt-4">
                <div class="card-body">
                    <div class="col col-md-12">
                        <table class="table table-striped item-list">
                            <thead>
                                <tr>
                                    <th scope="col" class="item-list-number">Number</th>
                                    <th scope="col" class="item-list-title" style="width: 70%">Name</th>
                                    <th scope="col" class="item-list-actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($answers); $i++) {
                                    $id = $answers[$i]['Id']; ?>
                                    <tr>
                                        <th scope="row" class="item-list-number"><?= $i + 1 ?></th>
                                        <td class="item-list-name"><?= $answers[$i]['TextContent'] ?></td>
                                        <td class="item-list-actions">
                                            <div class="btn-group d-none d-lg-flex" role="group" aria-label="Actions">
                                                <a role="button" class="btn btn-danger" onclick="showDeleteAnswerConfirmation(<?= $answers[$i]['Id'] ?>, <?= $questionId ?>)" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </div>
                                            <div class="btn-group-vertical d-lg-none" role="group" aria-label="Actions">
                                                <a role="button" class="btn btn-danger" onclick="showDeleteAnswerConfirmation(<?= $answers[$i]['Id'] ?>, <?= $questionId ?>)" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </div>
                                            <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete-title" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-delete-title">Cofirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this answer?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                            <button id="btn-yes" type="button" class="btn btn-danger" onclick="deleteAnswer()">Yes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
        </section>
    </div>
</div>

<?php
require_once pathOf('admin/includes/footer.part1.php');
require_once pathOf('admin/includes/scripts.php');
?>
<script src="<?= urlOf('admin/js/answers.js') ?>?<?= time() ?>"></script>
<?php
require_once pathOf('admin/includes/footer.part2.php');
?>