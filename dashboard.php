<?php
session_start();
if (!isset($_SESSION['session_auth_token']))
    header("location: login.php");
require_once './src/db.php';
try {
    $query = $db->prepare("SELECT * FROM qna");
    $query->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if ($query->rowCount() >= 1) {
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['qna'] = $res;
} else {
    $_SESSION['qna'] = null;
}
?>
<html lang="en" data-bs-theme='dark'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./src/style/index.css">
</head>

<body>
    <div class="container p-2 d-flex justify-content-center align-items-center h-100 max-vh-100 w-50 gap-3 flex-column response-container">
        <div class='d-flex border border-1 rounded-2 p-3 w-75 flex-column response' id='QnA'>
            <span class='fs-4 mb-2'>Queries</span>
            <table class='table '>
                <thead>
                    <tr>
                        <th>Index</th>
                        <th>Querstion</th>
                        <th>Answer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($_SESSION['qna'] != null) {
                        for ($i = 0; $i < count($_SESSION['qna']); $i++) {
                            echo "<tr id='row_{$_SESSION['qna'][$i]['id']}'>"
                                . "<td>{$_SESSION['qna'][$i]['id']}</td>"
                                . "<td>{$_SESSION['qna'][$i]['query']}</td>"
                                . "<td>{$_SESSION['qna'][$i]['reply']}</td>"
                                . "<td><button class='btn btn-success me-1' name='edit' id='{$_SESSION['qna'][$i]['id']}'><i class='i bi-pencil-square'></i></button>"
                                . "<button class='btn btn-danger' name='delete' id='{$_SESSION['qna'][$i]['id']}'><i class='bi bi-x-circle'></i></button>"
                                . "</td></tr>";
                        }
                    } else {
                        echo "No records found";
                    }
                    ?>
                </tbody>
            </table>
            <button class='btn btn-dark bg-dark-subtle p-3' name="add"><i class='bi bi-plus-circle'></i></button>
        </div>
        <div class='d-flex flex-column border border-1 rounded-2 p-3 w-75 response' id='settings'>
            <span class='fs-4 mb-2'>Chatbot settings</span>
            <form class='d-flex flex-row gap-2 mb-0' id="edit_bot_name">
                <input type='text' class='form-control' placeholder='Bot name' name='botName' id="botName">
                <input type='hidden' name="token" value="<?php echo $_SESSION['session_auth_token'] ?>">
                <button type='submit' class='btn btn-primary' id="editBotName">Update</button>
            </form>
        </div>
        <div class='d-flex flex-column border border-1 rounded-2 p-3 w-75 response' id='settings'>
            <span class='fs-4 mb-2'>Settings</span>
            <form class='d-flex flex-row gap-2 mb-0' id="change_password">
                <input type='password' class='form-control' placeholder='New password' name='password' id="password">
                <input type='password' class='form-control' placeholder='New password' name='passwordConf' id="passwordConf">
                <input type='hidden' name="token" value="<?php echo $_SESSION['session_auth_token'] ?>">
                <button type='submit' class='btn btn-primary' id="editPassword">Update</button>
            </form>
            <span class="text-danger d-none mt-1" id="passwordHelp"></span>
        </div>
        <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Adding new query</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class='d-flex flex-column gap-2'>
                            <input type='text' class='form-control' name='query' placeholder='Question'>
                            <input type='text' class='form-control' name='reply' placeholder='Reply'>
                            <input type='hidden' name="token" value="<?php echo $_SESSION['session_auth_token'] ?>">
                            <span>
                                Available variables: <span class='text-warning rounded-2 w-auto m-0'>{time}, {date}, {day}, {weather}</span></span>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" name="addRecord">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Editing an existing query</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class='d-flex flex-column gap-2'>
                            <input type='text' class='form-control' name='query' placeholder='Question' value="">
                            <input type='text' class='form-control' name='reply' placeholder='Reply' value="">
                            <input type='hidden' name="token" value="<?php echo $_SESSION['session_auth_token'] ?>">
                            <input type="hidden" name="rowId" value="">
                            <span>
                                Available variables: <span class='text-warning rounded-2 w-auto m-0'>{time}, {date}, {day}, {weather}</span></span>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" name="sendEdit">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h1 class="modal-title fs-5" id="editModalLabel">Are you sure you want to delete this record?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer border-top-0">
                        <input type='hidden' name="token" value="<?php echo $_SESSION['session_auth_token'] ?>">
                        <input type="hidden" name="rowId" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" name="deleteConf">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='./src/js/alert.js'></script>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<script>showAlert('danger','{$_SESSION['error']}');</script>";
        unset($_SESSION['error']);
    } else if (isset($_SESSION['success'])) {
        echo "<script>showAlert('success','{$_SESSION['success']}');</script>";
        unset($_SESSION['success']);
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
    </script>
    <script src='./src/js/dashboard.js'></script>
</body>

</html>