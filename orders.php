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

    // $user_name = $_POST['user_name'];
    // $user_contact = $_POST['user_contact'];
    // $user_location = $_POST['user_location'];
    // $user_id = $_POST['userid'];
    //
    // $name = $_POST['name'];
    // $contact = $_POST['contact'];
    // $location = $_POST['location'];
    //
    $submit = $_GET['submit'];
    // $edit = $_GET['edit'];
    // $id = $_GET['id'];
    $orderTitle = $_POST['oTitle'];
    $orderDesc = $_POST['oDesc'];
    $orderPrice = $_POST['oPrice'];
    $orderStatus = $_POST['oStatus'];
    $orderDate = $_POST['oDate'];
    $orderClient = $_POST['oClient'];
    //

    $q = mysql_query("SELECT * FROM orders");
    //
    // if( $_POST['submit'] == "Delete" ){
    //     $deleteUser = "DELETE FROM clients WHERE clientID=$user_id";
    //     $userDel = mysql_query($deleteUser);
    //     header('Location: clients.php');
    // }
    // if( $_POST['submit'] == "Update" ){
    //     $updateUser = "UPDATE clients SET clientName='$user_name', clientNumber='$user_contact', clientLocation='$user_location' WHERE clientId='$user_id'";
    //     $userUp = mysql_query($updateUser);
    //     header('Location: clients.php');
    // }
    //
    if( $_POST['submit'] == "Add Order" ){

        $orderAdd = "INSERT INTO orders (orderTitle,orderDesc,orderPrice,orderStatus,orderDate,clientId) VALUES('$orderTitle','$orderDesc','$orderPrice','$orderStatus','$orderDate', '$orderClient')";
        $oAdd = mysql_query($orderAdd);

        header('Location: orders.php');
    }



?>
<?php include_once('includes/header.php');?>

<body>
    <?php include_once('includes/nav.php'); ?>

    <div class="container">
        <h1 class='section_title'>Orders</h1>
        <form action="orders.php" method="post" class="add_order">
            <div class="row">

                <!-- //orderid	clientId	orderDesc	orderPrice	orderTitle	orderStatus orderDate -->

                <div class="col-12 col-sm-12 col-lg-2">
                    <div class="form-group">
                        <input type="text" name="oTitle" value="" class='form-control' placeholder='Enter Order Title' required>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-2">
                    <div class="form-group">
                        <input type="date" name="oDate" value="" class='form-control' placeholder='Enter Order Due Date'>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-2">
                    <div class="form-group">
                        <textarea name="oDesc" rows="8" cols="80" placeholder='Enter Order Description' class='form-control'></textarea>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-2">
                    <div class="form-group">
                        <input type="number" name="oPrice" value="" class='form-control' placeholder='Enter Order Price' min='0' max='200'>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-2">
                    <div class="form-group">
                        <input type="text" name="oStatus" value="" class='form-control' placeholder='Enter Order Status'>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-2">
                    <div class="form-group">
                        <select class="form-control" name="oClient">
                            <?php
                                $qq = "SELECT * FROM clients";
                                $rr = mysql_query($qq);

                                while( $rows = mysql_fetch_object($rr) ):

                                    $qqq = "SELECT * FROM orders";
                                    $rrr = mysql_query($qqq);
                                    $rowss = mysql_query($qqq);

                                    foreach($rowss as $k){
                                        echo "test";
                                    }
                                    // if($rows->clientId == $rowss->clientId){
                                    //
                                    // }
                                    // echo "<option value='$rows->clientId'>$rows->clientName</option>";
                                endwhile;
                            ?>
                        </select>
                        <!-- <input type="text" name="oClient" value="" class='form-control' placeholder='Enter Client'> -->
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-lg-2">
                    <div class="form-group text-right">
                        <input type="submit" name="submit" value="Add Order" class='btn btn-primary'>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
        <?php while( $row = mysql_fetch_object($q) ): ?>
            <form action="orders.php" method="post" class='clients'>
                <input type="hidden" name="orderid" id='orderid' value=<?php echo $row->orderid; ?>>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            Title
                            <input class='form-control' type="text" name="user_name" value="<?php echo $row->orderTitle;?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            Date
                            <input class='form-control' type="text" name="order_date" value="<?php echo $row->orderDate;?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            Status
                            <input class='form-control' type="text" name="order_status" value="<?php echo $row->orderStatus;?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            Description
                            <textarea name="order_desc" rows="8" cols="80" class='form-control'><?php echo $row->orderDesc;?></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            Client
                            <select class="" name="order_client">
                                <?php
                                    $qq = "SELECT * FROM clients";
                                    $rr = mysql_query($qq);

                                    while( $rows = mysql_fetch_object($rr) ):
                                        echo "<option value='$rows->clientId'>$rows->clientName</option>";
                                    endwhile;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
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
