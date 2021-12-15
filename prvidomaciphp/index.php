<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <title>Domaci</title>

  <style type = "text/css" > 
    body{
      background-image:url(47.jpg);
      background-size: cover;
      background-attachment: fixed;
    }
    </style>
</head>



<body>

 
  <div class="container">

    <div class="row">
      <div class="col-md-12 mt-5">
        <h1 class="text-center">PARFUMES </h1>
      </div>
        <hr style="height: 10px; color:black ; background-color:red;" >
      </div>
    </div>
  
    <div class="row">
      <div class="col-md-5 mx-auto">
        <form action="" method="post" id="form">
          <div id="result"></div>
            <div class="form-group">
              <label for="">Parfume name</label>
              <input type="text" name="" id="title" class="form-control"> 
              <br>
            </div>
            <div class="form-group">
              <label for="">Main accord </label>
              <textarea name="description" id="description" cols="" rows="3" class="form-control"></textarea>
              <br>
            </div>
            <div class="form-group">
              <label for="">Designer</label>
              <input type="text" name="" id="designer" class="form-control"> 
              <br>
            </div>
            <div class="form-group float-right">
              <button type="submit" id="submit" class="btn btn-success" style = "background-color:crimson">Submit</button> 
              <button type="submit" id="sort_title" class="btn btn-dark" style="background-color :Gray;">Sort</button>
            </div>
        </form>
      </div>
    </div>
    <br>
    <div class="row" >
    <div class="col-md-5 mx-auto">
    <label class="sr-only" for="inlineFormInputName2" >Search</label>
            <input type="text" class="form-control mb-2" id="search" placeholder="By name">
    </div>
      <div class="col-md-8 mx-auto">
     
          <div id="show"></div>
          <div id="fetch"></div>
         
      </div>
    </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Parfume</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="read_data"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!--  EDIT Modal -->
  <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="edit_data"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="update">Update</button>
        </div>
      </div>
    </div>
  </div>

   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
 
    <script>
      $(document).on("click","#submit", function(e){
        e.preventDefault();
        var title = $("#title").val();
        var description = $("#description").val();
        var submit = $("#submit").val();
        var designer = $("#designer").val();
        $.ajax({
            url: "insert.php",
            type:"post",
            data:{
              title: title,
              description: description,
              designer:designer,
              submit: submit
            },
            success: function(data){
              fetch();
              $("#result").html(data);
        }
        });

        $("form")[0].reset();
      });

      function fetch()
      {
        $.ajax({
          url:"fetch.php",
          type:"post",
          success: function(data){
            $("#fetch").html(data);
          }
        });  
      }
      fetch();

      // DELETE

      $(document).on("click","#delete", function(e){
        e.preventDefault();
        if(window.confirm("Do you want to delete record?")){
          var del_id = $(this).attr("value"); 
          
          $.ajax({
            url:"delete.php",
            type: "post",
            data:{
              del_id: del_id
            },
            success:function(data){
              fetch();
              $("#show").html(data);
            }
        });
        }
        else{
          return false;
        }
      });
   

    // EDIT
    $(document).on("click","#edit",function(e){
      e.preventDefault();
       var edit_id = $(this).attr("value");

       $.ajax({
         url: "edit.php",
         type: "post",
         data:{
           edit_id:edit_id
         },
         success:function(data){
           $("#edit_data").html(data);
         }
       })
    })
    
    // UPDATE 

    $(document).on("click", "#update", function(e){
      e.preventDefault();

      var edit_title = $("#edit_title").val();
      var edit_description = $("#edit_description").val();
      var update = $("#update").val();
      var edit_id = $("#edit_id").val();
      

      $.ajax({
        url: "update.php",
        type: "post",
        data:{
          edit_id:edit_id,
          edit_title:edit_title,
          edit_description:edit_description,
          update:update
        },
        success: function(data){
          fetch();
          $("#show").html(data);
        }
      });
    });

    // SORT 

    $(document).on("click", "#sort_title", function(e){
        e.preventDefault();

        var sort_title = $(this).val();
        
        $.ajax({
            url: "fetch.php",
            type: "post",
            data: {
              sort_title:sort_title
            },
            success: function(data){
                $("#fetch").html(data);
            }
        })
    });

    // SEARCH
    $(document).ready(function(){
    $("#search").on("keyup", function() {
      let value = $(this).val().toLowerCase();
      console.log(value);
      
      $.ajax({
          url: "fetch.php",
          type: "post",
          data: {
            value: value
          },
          success:function(data){
                $("#fetch").html(data);
            } 
      })
     
    })
  });
    </script>
 
</body>

</html>