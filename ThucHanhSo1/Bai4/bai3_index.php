<?php
require_once 'db_connect.php';

function get_all_accounts()
{
    global $conn;
    $accounts = [];

    try {
        $stmt = $conn->query("SELECT username, password, lastname, firstname, city, email, course1 FROM accounts ORDER BY username ASC");
        $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("<div class='alert alert-danger'>Lỗi truy vấn CSDL: " . $e->getMessage() . "</div>");
    }

    return $accounts;
}

$account_list = get_all_accounts();
$total_accounts = count($account_list);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Tài khoản </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .container-xl {
            padding-top: 20px;
        }

        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container-xl">
        <header class="text-center mb-4">
            <h1 class="display-5 text-success">Danh sách Tài khoản Sinh viên </h1>

            <hr>
            <div class="alert alert-info" role="alert">
                Tổng cộng: <span class="fw-bold"><?php echo $total_accounts; ?></span> tài khoản
            </div>
        </header>

        <?php if ($total_accounts > 0): ?>
            <div class="table-responsive shadow-sm">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 5%;">#</th>
                            <th scope="col" style="width: 10%;">Username</th>
                            <th scope="col" style="width: 10%;">Password</th>
                            <th scope="col" style="width: 15%;">Last Name</th>
                            <th scope="col" style="width: 10%;">First Name</th>
                            <th scope="col" style="width: 10%;">City</th>
                            <th scope="col" style="width: 25%;">Email</th>
                            <th scope="col" style="width: 15%;">Course1</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($account_list as $index => $account): ?>
                            <tr>
                                <th scope="row"><?php echo $index + 1; ?></th>
                                <td><?php echo htmlspecialchars($account['username']); ?></td>
                                <td><?php echo htmlspecialchars($account['password']); ?></td>
                                <td><?php echo htmlspecialchars($account['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($account['firstname']); ?></td>
                                <td><?php echo htmlspecialchars($account['city']); ?></td>
                                <td><?php echo htmlspecialchars($account['email']); ?></td>
                                <td><?php echo htmlspecialchars($account['course1']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Không tìm thấy dữ liệu tài khoản nào trong CSDL.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>