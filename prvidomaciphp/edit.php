<?php 
    include 'model.php';
    $edit_id = $_POST['edit_id'];

    $model = new Model();
    $row = $model ->edit($edit_id);
    
    if(!empty($row)){?>
     
      <form method="post"  id="form">
         <div>
           <input type="hidden" id="edit_id" value="<?php echo $row['id'];?>">
         </div>
           <div class="form-group">
             <label for="">Name</label>
             <input type="text" name="" id="edit_title" class="form-control" value="<?php echo $row['title'];?>"> 
             <br>
           </div>
           <div class="form-group">
             <label for="">Main accord</label>
             <textarea name="description" id="edit_description" cols="" rows="3" class="form-control" ><?php echo $row['description'];?></textarea>
             <br>
           </div>
          
       </form>     
   <?php
   }

    
?>