<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            // Query to get all active categories from the database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql); // Execute the query

                            // Count the rows to check whether we have categories or not
                            $count = mysqli_num_rows($res);

                            // Check if categories are available
                            if ($count > 0) {
                                // Categories exist
                                while ($row = mysqli_fetch_assoc($res)) {
                                    // Get category details
                                    $id = $row['id']; // Fetch id
                                    $title = $row['title']; // Fetch title
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            } else {
                                // No categories found
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }
                            ?>
                        </select>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        // Check whether the submit button is clicked or not
        if (isset($_POST['submit'])) {
            //1. Get the data from the form 
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            // Set featured and active values based on user input, default to "No" if not selected
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            //2. Upload the image if selected
            if (isset($_FILES['image']['name'])) {
                // Get the details of the selected image
                $image_name = $_FILES['image']['name'];

                if ($image_name != "") {
                    // Image is selected
                    // A. Rename the image with a unique name
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION); // Get the extension of the image

                    $image_name = "Food_Name_" . rand(0000, 9999) . '.' . $ext;

                    // B. Set paths for the image upload
                    $src = $_FILES['image']['tmp_name'];
                    $dst = "../images/food/" . $image_name;

                    // Upload the image
                    $upload = move_uploaded_file($src, $dst);

                    // Check if the image upload was successful
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                        header('location:' . SITEURL . 'admin/add-food.php');
                        die();
                    }
                } else {
                    // Set the image name as blank if no image is selected
                    $image_name = "";
                }
            } else {
                $image_name = ""; // Default image name to blank if not selected
            }

            //3. Insert food data into the database
            // Create SQL Query to save or add food
           //3. Insert food data into the database
            // Create SQL Query to save or add food
            $sql2 = "INSERT INTO tbl_food SET
            title='$title',
            description='$description',
            price=$price,
            image_name='$image_name',
            category_id='$category',
            featured='$featured',
            active='$active'";

            // Execute the query and save in the database
            $res2 = mysqli_query($conn, $sql2);

            // Check whether data is inserted or not
            //4. Redirect with a message to manage food page

            if ($res2 == true)
            {
                $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            } 
            else 
            {
                $_SESSION['add'] = "<div class='error'>Failed to Add Food</div>";
                header('location:' . SITEURL . 'admin/add-food.php');
            }


        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
