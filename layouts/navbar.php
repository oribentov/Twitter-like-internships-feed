<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">
        <img src="<?php echo BASE_URL . './src/logo.jpg' ?>" alt="">
    </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

    <div class="collapse navbar-collapse    " id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo BASE_URL . 'index.php' ?>">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL . '?myinternship=1' ?>">my internship</a>
                </li>
                </ul>
        <?php echo "Hello, " . $_SESSION['user']['first_name']; ?>
        <a class="nav-link pull-right" href="<?php echo BASE_URL . 'index.php?logout=1' ?>" style="color: red;">logout</a>
        </div>
</nav>
<br>
    <div class="container">