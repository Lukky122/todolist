<?php  
    include 'db.php';
    include 'navbar.php';
?>
<?php
    if(isset($_POST['add_post'])){
        $taskname = mysqli_real_escape_string($conn, $_POST['name_task']);
        $query = mysqli_query($conn, "INSERT INTO task (name_task, status_task, date_task) VALUES ('$taskname','pending',now())");
        header("Location: index.php");
    }
    if(isset($_GET['edit'])){
        $task_id = $_GET['edit'];
        $query = mysqli_query($conn, "UPDATE task SET status_task = 'selesai' WHERE id_task = '$task_id'");
        header("Location: index.php");
    }
    if(isset($_GET['delete'])){
        $task_id = $_GET['delete'];
        $query = mysqli_query($conn, "DELETE FROM task WHERE id_task = '$task_id'");
        header("Location: index.php");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          
</div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h3>Form Pengingat</h3>
                        <form method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name_task" placeholder="input nama tugas">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="add_post" class="btn btn-primary btn-block">add todo list</button>
                            </div>
                        </form>
                        <h3>List tugas</h3>
                        <ul class="list-group">
                            <?php
                                $query = mysqli_query($conn, "SELECT * FROM task WHERE status_task='pending'");
                                while($row = mysqli_fetch_array($query)){
                                    $task_id = $row['id_task'];
                                    $task_name = $row['name_task'];
                            ?>
                            <li class="list-group-item">
                                <?php echo $task_name; ?>
                                <div class="float-right">
                                <a href="index.php?edit=<?php echo $task_id ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="tandai sudah selesai">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                    </svg>
                                </a>
                                <a href="index.php?delete=<?php echo $task_id ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </a>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h3>list tugas selesai</h3>
                        <ul class="list-group"></ul>
                        <?php 
                            $query = mysqli_query($conn, "SELECT * FROM task WHERE status_task='selesai'");
                            while($row = mysqli_fetch_array($query)){
                        ?>
                            <li class="list-group-item">
                                <?php echo $row['name_task'] ?>
                                <div class="class float-right">
                                    <span class="badge badge-primary"><?php echo $row['status_task'] ?></span>
                                </div>
                            </li>
                            <?php } ?>
                    </div>
                </div>
            </div>
              
            </div>
          </div>
        </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script>
        $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>
</html>
