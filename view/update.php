<?php
$user = $_SESSION['login_user'];
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <a class="pull-right btn btn-danger" href="/index.php/auth/logout">Đăng xuất</a>
        <div class="container">
            <h3 class="text-center">Chỉnh sửa thông tin của bạn</h3>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form name="login" method="post" accept-charset="UTF-8">
                        <p class="text-center" id="alert">
                            <?= isset($_SESSION['success']) && $_SESSION['success'] != '' ? $_SESSION['success'] : '' ?>
                            <?php unset($_SESSION['success']); ?>
                        </p>
                        <div class="form-group">
                            <label>Fullname</label>
                            <input type="text" name="name" class="form-control" value="<?= $user->name ?>" placeholder="Fullname">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="<?= $user->address ?>" placeholder="Address">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="tel" class="form-control" value="<?= $user->tel ?>" placeholder="Telephone">
                        </div>
                        <button type="submit" class="btn btn-default">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            setTimeout(function () {
                document.getElementById('alert').style.display = 'none';
            }, 5000)
        </script>
    </body>
</html>


