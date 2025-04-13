<?php
include 'connect.php';
session_start();

// Check if the admin_id is set in the session
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
} else {
    // Redirect to the login page if admin is not logged in
    header('location: admin_login.php');
    exit(); // Stop further execution
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `contacts` WHERE id = ?");
    if ($delete_message->execute([$delete_id])) {
        // Success message using SweetAlert
        echo json_encode(array('status' => 'success', 'message' => 'The message has been deleted successfully!'));
        exit;
    } else {
        // Error message using SweetAlert
        echo json_encode(array('status' => 'error', 'message' => 'Unable to delete the message.'));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="admin_style.css">
   <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="contacts">

    <h1 class="heading">Contact Messages</h1>

    <div class="box-container">

        <?php
        $select_messages = $conn->prepare("SELECT * FROM `contacts`");
        $select_messages->execute();
        if ($select_messages->rowCount() > 0) {
            while ($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box">
                    <p> ID : <span><?= $fetch_message['id']; ?></span></p>
                    <p> Full Name : <span><?= $fetch_message['full_name']; ?></span></p>
                    <p> Email : <span><?= $fetch_message['email']; ?></span></p>
                    <p> Subject : <span><?= $fetch_message['subject']; ?></span></p>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">You have no messages</p>';
        }
        ?>

    </div>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function(e) {
            e.preventDefault();
            var messageId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: 'showcontact_messages.php?delete=' + messageId,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>

</body>
</html>