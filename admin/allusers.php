<?php
include('../functions.php');

if (!isAdmin()) {
    $_SESSION['msg'] = "this page available only for admin users";
    header('location: ../login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>internships for BINFO students</title>
    <link rel="stylesheet" type="text/css" href="../src/bootstrap.css">
</head>
<body>
<?php include("../layouts/admin_navbar.php") ?>

<div class="header">
    <h2>Admin - Manage Users</h2>
</div>
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="alert alert-success" role="alert">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif;
    $results = mysqli_query($conn, "SELECT * FROM users ORDER BY user_id"); ?>
    <table id="users_table" class="table">
        <thead>
        <tr>
            <th scope="col" style="display:none;">user id</th>
            <th scope="col">First name</th>
            <th scope="col">Last name</th>
            <th scope="col">User name</th>
            <th scope="col">Date of birth</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
            <th scope="col">Title</th>
            <th scope="col">Edit</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_array($results)) { ?>
        <tr scope="col">
            <td style="display:none;"><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['date_of_birth']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td>
                <a href="edituser.php?edit=<?php echo $row['user_id']; ?>" class="edit_btn">Edit</a>
            </td>
            <?php if($row['status'] == "enabled") { ?>
            <td>
                <a href="<?php echo $_SERVER['PHP_SELF'] ?>?disable=<?php echo $row['user_id']; ?>">Disable</a>
            </td>
            <?php }else{ ?>
                <td>
                    <a href="<?php echo $_SERVER['PHP_SELF'] ?>?enable=<?php echo $row['user_id']; ?>">Enable</a>
                </td>
            <?php } ?>
        </tr>
        </tbody>
        <?php } ?>
    </table>

</div>
</body>
</html>
