<?php 
require('inc/essentials.php');
require('inc/db-config.php');
adminLogin();

if (isset($_GET['seen'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['seen'] === 'all') {
        $q = "UPDATE `user_queries` SET `seen` = ?";
        $values = [1];
        if (update($q, $values, 'i')) {
            alert('success', 'Marked all as read');
        } else {
            alert('error', 'Operation failed');
        }
    } else {
        $q = "UPDATE `user_queries` SET `seen` = ? WHERE `sr_no` = ?";
        $values = [1, $frm_data['seen']];
        if (update($q, $values, 'ii')) {
            alert('success', 'Marked as read');
        } else {
            alert('error', 'Operation failed');
        }
    }

    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

if (isset($_GET['del'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['del'] === 'all') {
        $q = "DELETE FROM `user_queries`";
        if (mysqli_query($con, $q)) {
            alert('success', 'All data deleted');
        } else {
            alert('error', 'Operation failed');
        }
    } else {
        $q = "DELETE FROM `user_queries` WHERE `sr_no` = ?";
        $values = [$frm_data['del']];
        if (delete($q, $values, 'i')) {
            alert('success', 'Data deleted');
        } else {
            alert('error', 'Operation failed');
        }
    }

    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL - User Queries</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

<?php require('inc/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden" id="main-content">
            <h3 class="mb-4">USER QUERIES</h3>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                        <table class="table table-hover border">
                            <thead class="sticky-top">
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" width="20%">Subject</th>
                                    <th scope="col" width="30%">Message</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $q = "SELECT * FROM `user_queries` ORDER BY `sr_no` DESC";
                                $data = mysqli_query($con, $q);
                                $i = 1;

                                while ($row = mysqli_fetch_assoc($data)) {
                                    $seen = '';
                                    if ($row['seen'] != 1) {
                                        $seen = "<a href='?seen={$row['sr_no']}' class='btn btn-sm rounded-pill btn-primary'>Mark As Read</a><br>";
                                    }
                                    $seen .= "<a href='?del={$row['sr_no']}' class='btn btn-sm rounded-pill btn-danger mt-2'>Delete</a>";

                                    echo <<<QUERY
                                    <tr>
                                        <td>{$i}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['subject']}</td>
                                        <td>{$row['message']}</td>
                                        <td>{$row['date']}</td>
                                        <td>{$seen}</td>
                                    </tr>
                                    QUERY;
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('inc/script.php'); ?>

</body>
</html>
