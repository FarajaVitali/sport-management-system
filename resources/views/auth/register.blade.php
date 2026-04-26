<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../icons-1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>REGISTER PAGE</title>
</head>

<body>
    <div class="container d-flex vh-100 justify-content-center align-items-center">
        <div class="col-md-6 row-mt-3">
            <form class="border p-4" action="/register" method="post">
                <h3 class="text-center fw-bold">REGISTER HERE</h3>
                <div class="names row md-2">
                    <div class="col">
                        <label for="first_name" class="form-label">First Name:</label>
                        <input type="text" class="form-control" id="first_name" name="fname" required>
                    </div>
                    <div class="col">
                        <label for="last_name" class="form-label">First Name:</label>
                        <input type="text" id="last_name" class="form-control" name="fname" required>
                    </div>
                </div>
                <div class="email">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" class="form-control" name="email" required>
                </div>
                <div class="password">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" name="passwd">
                </div>
                <div class="confirm">
                    <label for="confirm_password" class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" name="c_passwd">
                </div>
                <label for="roles">Select Roles:</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="roles" value="Coach">
                    <label for="roles" class="form-check-label">Coach</label>
                </div>
                <div class="form-check">
                    <label for="roles" class="form-check-label">Player</label>
                    <input type="radio" class="form-check-input" name="roles" value="Player" required>
                </div>
                <input type="submit" class="mt-3 btn btn-primary form-control" value="Register" required>

                <p class="text-center">already registered? <a href="#">login here</a></p>
            </form>
        </div>

    </div>
    </div>


</body>

</html>