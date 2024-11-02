<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <br><br>

        <!-- add category form starts-->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- add category form ends-->

        <?php
        // Check whether the submit button is clicked or not
        if (isset($_POST['submit'])) {
            // 1. Get the value from category form 
            $title = $_POST['title'];

            // For radio input type, check whether the button is selected or not
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            // Check whether the image is selected or not and set the value for image name accordingly
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                // Get the extension of the image
                $image_name = $_FILES['image']['name'];
                $ext = pathinfo($image_name, PATHINFO_EXTENSION);

                // Rename the image
                $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;

                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/category/" . $image_name;

                // Upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

                // Check if the image was uploaded
                if ($upload == false) {
                    $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                    header('location:' . SITEURL . 'admin/add-category.php');
                    die();
                }
            } else {
                // Don't upload the image and set the image_name as blank
                $image_name = "";
            }

            // 2. Create SQL Query to insert category into database
            $sql = "INSERT INTO tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'";

            // 3. Execute the query and save in the database
            $res = mysqli_query($conn, $sql);

            // 4. Check whether the query executed and data added
            if ($res == true) {
                $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>