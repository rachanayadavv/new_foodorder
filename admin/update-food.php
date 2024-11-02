<?php include('partials/menu.php') ?>

<?php
    //check whether id is set or not
    if(isset($_GET['id']))
    {
        //get all the details
        $id=$_GET['id'];

        //sql to get the selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

        $res2=mysqli_query($conn,$sql2);

        $row2=mysqli_fetch_assoc($res2);

        //get the individual values of selected food
        $title=$row2['title'];
        $description=$row2['description'];
        $price=$row2['price'];
        $current_image=$row2['image_name'];
        $current_category=$row2['category_id'];
        $featured=$row2['featured'];
        $active=$row2['active'];


    }
    else
    {
        //redirect to manage food
        header('location:' . SITEURL . 'admin/manage-food.php');

    }
?>

<div class="main-content">
    <div class="wrappper">
        <h1>Update Category</h1>

        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title;?>">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description;?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price;?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                    <?php
                        if ($current_image == "") 
                        {
                            //image not avaiable
                            echo "<div class='error'>Image Not Available.</div>";
                           
                        }
                         else
                          {
                             //image  avaiable
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                            <?php                          
                          }

                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image:</td>
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
                                    $category_title = $row['title']; // Fetch title
                                    $category_id = $row['id']; // Fetch id
                                    ?>
                                    <option <?php if($current_category==$category_id){echo "Selected";}?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            } else {
                                // No categories found
                            
                                echo  "<option value='0'>Category not available</option>";
                            
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if (isset($_POST['submit'])) {
                // echo "clicked";
    
                //1.Get all the values from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];
    
                //2.upload the image if selected
                //check whether the image is selected or not
                if (isset($_FILES['image']['name'])) {
                    //get the image details
                    $image_name = $_FILES['image']['name'];
    
                    //check whether the image is available or not
                    if ($image_name != "") {
                        //image available
                        //A.upload the new image
                        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
    
                        // Rename the image
                        $image_name = "Food_Name_" . rand(0000, 9999) . '.' . $ext;
    
                        $src_path = $_FILES['image']['tmp_name'];
    
                        $dst_path = "../images/food/" . $image_name;
    
                        // Upload the image
                        $upload = move_uploaded_file($src_path, $dst_path);
    
                        // Check if the image was uploaded
                        if ($upload == false) {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload new Image</div>";
                            header('location:' . SITEURL . 'admin/manage-food.php');
                            die();
                        }
                        //B.remove the cuureent image if avaiable
                        if($current_image != "")
                        {
                            $remove_path = "../images/food/" . $current_image;
    
                            $remove = unlink($remove_path);
    
                            //check whether the image is removed or not
                            //if failed to remove then display message and stop the process
                            if($remove==false)
                            {
                                //failed to remove image
                                $_SESSION['remove-failed']= "<div class='error'>Failed to Remove current Image</div>";
                                header('location:' . SITEURL . 'admin/manage-category.php');
                                die();
    
                            }
                        }
                        
                    } else {
                        $image_name = $current_image;
                    }
                } else {
                    $image_name = $current_image;
                }
    
                //3.update the database
                $sql3 = "UPDATE tbl_food SET
                        title='$title',
                        description='$description',
                        price='$price',
                        image_name='$image_name',
                        category_id='$category',
                        featured='$featured',
                        active='$active'
                        WHERE id=$id
                    ";
    
                //excute the query
    
                $res3 = mysqli_query($conn, $sql3);
    
                //4.redirect to manage category with message
                //check wether query is excuted or not
                if ($res3 == true) {
                    //categoty updated
                    $_SESSION['add'] = "<div class='success'>Food Updated Successfully</div>";
                    header('location:' . SITEURL . 'admin/manage-food.php');
                } else {
                    //failed to update category
                    $_SESSION['add'] = "<div class='error'>Failed to Update food</div>";
                    header('location:' . SITEURL . 'admin/manage-food.php');
                }
            }
        ?>



    </div>
</div>
<?php include('partials/footer.php') ?>
