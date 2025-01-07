<?php
// session_start();
require_once '../app/controllers/UserController.php';
$userController = new UserController();
// print_r($_SESSION);
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page
$users = $userController->getUsers($page);
// print_r($users);
// if (isset($_POST['user_name']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
//     $newUserId = $userController->addUser($_POST['user_name'], $_POST['email'], $_POST['password']);
//     if ($newUserId) {
//         echo "Data inserted.";
//     }
// }

// if ($_GET['edituser']) {
//     $userId = base64_decode($_GET['edituser']);
//     echo $userId;
// }
?>


<div class="col-12">
    <div class="card">
        <form class="needs-validation" novalidate="" method="post">
            <div class="card-header">
                <h4>Create User</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>User Name</label>
                    <input type="text" class="form-control" name="user_name" required>
                    <div class="invalid-feedback">
                        What's your name?
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" required>
                    <div class="invalid-feedback">
                        Oh no! Email is invalid.
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required>
                    <div class="valid-feedback">
                        Good job!
                    </div>
                </div>

            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4>Basic DataTables</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $key => $user) {
                            // print_r($user);
                        ?>
                            <tr>
                                <td><?= ++$key ?></td>
                                <td><?= $user['user_name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td>
                                    <div class="badge badge-info badge-shadow">Todo</div>
                                </td>
                                <td>
                                    <a href="?page=user&edituser=<?= base64_encode($user['id']) ?>" class="btn btn-primary">Detail</a>
                                </td>

                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>