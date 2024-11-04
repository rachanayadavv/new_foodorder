<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php
        if (isset($_SESSION['add'])) //hecking whether the session is set or not
        {
            echo $_SESSION['add']; //displaying session message
            unset($_SESSION['add']); //removing session message
        }

        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Your Username"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
//process the value from form and save it in database
//check whether the  submit button is clicked or not  

if (isset($_POST['submit'])) {
    //button clicked
    //echo"Button Clicked";

    //1.get the data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password encryption with md5


    //2.SQL query to save the data into database
    $sql = "INSERT INTO tbl_admin SET
          full_name='$full_name',
          username='$username',
          password='$password'
      ";


    //3Excuting Query and saving data into database
    $res = mysqli_query($conn, $sql) or die(mysqli_error());


    //4. check whether the (query is excuted) data is incerted or not and display appropirate message

    if ($res == TRUE) {
        //DATA Inserted
        // echo "Data Inserted";
        //create a session variable to display message
        $_SESSION['add'] = "<div class='success'>Admin Addded Successfuly</div>";
        //redirect page to manage admin page
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        //Failed to insert data
        //echo "Failed to insert data";
        $_SESSION['add'] = "<div class='error'>Failed to add admin</div>";
        //redirect page to add admin page
        header("location:" . SITEURL . 'admin/add-admin.php');
    }
}

?>