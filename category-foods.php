<?php include('partials-front/menu.php');?>

    <?php
        //check wehther ud is passed or not
        if(isset($_GET['category_id']))
        {
            //category id is set and get the id
            $category_id = $_GET['category_id'];
            //get the category title based on category id

            $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

            $res=mysqli_query($conn,$sql);

            $row = mysqli_fetch_assoc($res);

            //get the title
            $category_title = $row['title'];

        }
        else
        {
            //category not passed
            //redirect to home page
            header('location:'.SITEURL);

        }
    
    ?> 


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title;?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>


            <?php
                //create sql query to display categories from database
                $sql2="SELECT * FROM tbl_food WHERE category_id=$category_id";

                $res2=mysqli_query($conn,$sql2);

                $count2 = mysqli_num_rows($res2);

                if($count2>0)
                {
                    while($row=mysqli_fetch_assoc($res2))
                    {
                        //get the values like id,title,image_name
                        $id=$row['id'];
                        $title=$row['title'];
                        $price=$row['price'];
                        $description=$row['description'];
                        $image_name=$row['image_name'];

                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    //check wether imgae avaiable or not
                                    if($image_name=="")
                                    {
                                        echo "<div class='error'>Image Not Avaiable.</div>";


                                    }
                                    else
                                    {
                                        ?>
                                            <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">


                                        
                                        <?php

                                    }
                                
                                
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title;?></h4>
                                <p class="food-price"><?php echo $price;?></p>
                                <p class="food-detail">
                                    <?php echo $description;?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                            </div>
                       </div>                  
                                                
                        <?php


                    }


                }
                else
                {
                    echo "<div class='error'>Food Not available.</div>";

                }
            
            ?>
            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php');?>
