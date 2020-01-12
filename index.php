<?php
include ('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .ellipsis {
            max-width: 500px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>internships for BINFO students</title>
    <link rel="stylesheet" type="text/css" href="./src/bootstrap.css"></head>

<?php if(isAdmin()) {
    include("./layouts/admin_navbar.php");
}   else {
    include("./layouts/navbar.php");
}?>
<div class="massages">
    <!-- notification message -->
    <?php if (isset($_SESSION['success']) || isset($_SESSION['msg'])) : ?>
        <div class="alert alert-success" role="alert">
            <?php
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif ?>

    <!-- logged in user information -->
    <div class="profile_info">
        <div>Logged as:
            <?php  if (isset($_SESSION['user'])) : ?>
                <strong><?php echo " " . $_SESSION['user']['username']; ?></strong>

                <small>
                    <i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['title']); ?>)</i>
                </small>
            <?php endif ?>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="jumbotron">
        <h1>Welcome!</h1>
        All the best BINFO students internships in one place
    </div>
</div>

<div class="container">
    All internships:
</div>
<br>
<?php $results = mysqli_query($conn, "SELECT * FROM channels ORDER BY date_posted"); ?>

<table  id="interships_table" class="table table-hover">
    <thead class="thead-light">
    <tr>
        <th scope="col" style="display:none;">Intership id</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Date Posted</th>
        <th scope="col"></th>
        <?php if (isAdmin()) { ?>
        <th scope="col"></th>
            <th scope="col"></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = mysqli_fetch_array($results)) { ?>
    <tr scope="col">
        <td style="display:none;"><?php echo $row['channel_id']; ?></td>
        <td><?php echo $row['channel_title']; ?></td>
        <td class="ellipsis"><?php echo $row['channel_description']; ?></td>
        <td><?php echo $row['date_posted']; ?></td>
        <td>
            <a href="intershippage.php?channel=<?php echo $row['channel_id']; ?>">View</a>
        </td>
        <?php if (isAdmin()) { ?>
            <th scope="col"><a href="./admin/editinternship.php?channel=<?php echo $row['channel_id']; ?>">Edit</a></th>
            <td>
                <a href="<?php echo $_SERVER['PHP_SELF'] ?>?channeldel=<?php echo $row['channel_id']; ?>">delete</a>
            </td>
        <?php } ?>
    </tr>
    </tbody>
    <?php } ?>
</table>
</body>
</html>
