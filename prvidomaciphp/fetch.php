<?php
include 'model.php';

$model = new Model();

$rows = $model->search();
?>
<br>
<table class="table table-striped table-bordered">
    <thead style="background-color :ivory; text-align:center; justify-content:center;">
        <tr>
            <th></th>
            <th>NAME</th>
            <?php
                 if(isset($_POST['sort_title'])){   
                  
                   $rows=$model->sort();
                }
            ?>
            <th>MAIN ACCORD</th>
            <th>DESIGNER</th>
            <th></th>
            
        </tr>
    </thead>
    <tbody>
        <?php

    $i = 1;
        if (!empty($rows)) {
            //vrati sve redove iz baze
            foreach ($rows as $row) {
               // $r = $model->getRow($row['id']);?>

                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['designer'];?></td>
                    <td >
                        <a href="" id="delete" class="btn btn-danger" style = "background-color:crimson" value="<?php echo $row['id']; ?>">DELETE</a>
                        <a href="" id="edit" class="btn btn-info" style = "background-color:darksalmon" value="<?php echo $row['id']; ?>"data-toggle="modal" data-target="#exampleModal1">EDIT</a>
                    </td>
                </tr>

        <?php
            }
        } else {
            echo  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
           NO DATA
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        }
        ?>
    </tbody>
</table>