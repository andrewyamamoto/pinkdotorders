<?php
    ob_start();
    session_start();
    require_once 'dbconnect.php';

    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    // select loggedin users detail
    $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
    $userRow=mysql_fetch_array($res);

    $user_name = $_POST['user_name'];
    $user_contact = $_POST['user_contact'];
    $user_location = $_POST['user_location'];
    $user_id = $_POST['userid'];

    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $location = $_POST['location'];

    $submit = $_GET['submit'];
    $edit = $_GET['edit'];
    $id = $_GET['id'];

    $q = mysql_query("SELECT * FROM clients");

    if( $_POST['submit'] == "Delete" ){
        $deleteUser = "DELETE FROM clients WHERE clientID=$user_id";
        $userDel = mysql_query($deleteUser);
        header('Location: clients.php');
    }
    if( $_POST['submit'] == "Update" ){
        $updateUser = "UPDATE clients SET clientName='$user_name', clientNumber='$user_contact', clientLocation='$user_location' WHERE clientId='$user_id'";
        $userUp = mysql_query($updateUser);
        header('Location: clients.php');
    }

    if( $_POST['submit'] == "Add Client" ){
        $createUser = "INSERT INTO clients (clientName,clientNumber,clientLocation) VALUES('$name', '$contact','$location')";
        $userAdd = mysql_query($createUser);

        header('Location: clients.php');
    }



?>
<?php include_once('includes/header.php');?>

<body>
    <?php include_once('includes/nav.php'); ?>

    <div class="container">
        <h1 class='section_title'>Clients</h1>
        <form action="clients.php" method="post" class="add_client">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-3">
                    <div class="form-group">
                        <input type="text" name="name" value="" class='form-control' placeholder='Enter Client Name' required>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-3">
                    <div class="form-group">
                        <input type="text" name="contact" value="" class='form-control' placeholder='Enter Client Contact'>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-3">
                    <div class="form-group">
                        <input type="text" name="location" value="" class='form-control' placeholder='Enter Client Location'>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-3">
                    <div class="form-group text-right">
                        <input type="submit" name="submit" value="Add Client" class='btn btn-primary'>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
        <?php while( $row = mysql_fetch_object($q) ): ?>
            <form action="clients.php" method="post" class='clients'>
                <input type="hidden" name="userid" id='userid' value=<?php echo $row->clientId; ?>>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <!-- <label for="user_name">Client Name</label> -->
                            <input class='form-control' type="text" name="user_name" value="<?php echo $row->clientName;?>">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <!-- <label for="user_contact">Client Contact</label> -->
                            <input class='form-control' type="text" name="user_contact" value="<?php echo $row->clientNumber;?>">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <!-- <label for="user_location">Client Location</label> -->
                            <input class='form-control' type="text" name="user_location" value="<?php echo $row->clientLocation;?>">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group text-right">
                            <input type="submit" name="submit" value="Update" class='btn btn-success'>
                            <input type="submit" name="submit" value="Delete" class='btn btn-danger' onclick="return confirm('Are you sure bae?')">
                        </div>
                    </div>
                    </div>

            </form>
        <?php endwhile; ?>
            </div>
        </div>
    </div>

    <?php include_once("includes/footer.php"); ?>
