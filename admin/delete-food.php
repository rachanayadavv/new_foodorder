 <?php
  include('../config/constants.php');
 

if(isset($_GET['id'])&& isset($_GET['image_name']))
{
    // echo "process to delete";
    //1.get id and image name
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];


    //2.Remove the image if available 
    //Check whether the image is available or not and delete only if available
    if($image_name !="")
    {
        //it has image and need to remove from folder
        //get the image path
        $path="../images/food/".$image_name;

        //Remove image file from folder
        $remove = unlink($path);

        //Check whether the image is removed or not
        if($remove == false)
        {
            //faield to remove image
            $_SESSION['upload']="<div class='error'>failed to remove image file.</div>";
            header('location:' . SITEURL . 'admin/manage-food.php');
            die();

        }
    }    
    //3. delete food from database 

    $sql = "DELETE FROM tbl_food WHERE id=$id";

    $res = mysqli_query($conn,$sql);

    //Check whether the query executed or not and set the session message respectively
        //4. redirect to manage food with session message

    if($res==true)
    {
        //food deleted
        $_SESSION['delete']="<div class='success'>Food deleted successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
    else
    {
         //food deleted
         $_SESSION['delete']="<div class='error'> Failed to delete Food.</div>";
         header('location:' . SITEURL . 'admin/manage-food.php');

    }
}
else
{
    // echo"redirect";
    $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:' . SITEURL . 'admin/manage-food.php');

}
?>













