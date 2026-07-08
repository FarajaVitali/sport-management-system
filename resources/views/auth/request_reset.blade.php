<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <title>REQUEST PASSWORD</title>
</head>

<body>
    <div class="container d-flex vh-100 justify-content-center align-items-center">
        <div class="col-md-6 row-mt-3">
            <form class="border p-4" action="/request-password-changes" method="post">
                <h3 class="text-center fw-bold">REQUEST PASSWORD CHANGES</h3>
               <p class="form-text">Enter your email to request the link of changing your password. After request link will be send to your email.</p>
                <div class="email">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" class="form-control" name="email" required>
                </div>
                <input type="submit" class="mt-3 btn btn-primary form-control" value="Click To Send Link" required>
            </form>
        </div>

    </div>
    </div>


</body>

</html>