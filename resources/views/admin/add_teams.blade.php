<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>{% block title %}Dashboard{% endblock %}</title>
</head>

<body class="bg-light">

    <div class="container-fluid vh-100 d-flex flex-column">

        <!-- Navbar -->
        {% include "partials/navbar.html" %}

        <!-- Main -->
        <div class="d-flex flex-grow-1">

            <!-- Sidebar -->
            {% include "partials/admin_sidebar.html" %}

            <!-- Page Content -->
            <div class="border bg-light d-flex justify-content-center align-items-center" style="flex: 0 0 80%;">

                <div class="card shadow-sm border-0 p-4" style="width: 100%; max-width: 600px; border-radius: 12px;">

                    <h4 class="mb-3 fw-bold">Create Team</h4>
                    <p class="text-muted mb-4">Fill in the details to register a new team</p>

                    <form action="/admin/create-teams" method="POST">

                        <!-- Team Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Team Name</label>
                            <input type="text" name="team_name" class="form-control" placeholder="e.g. ATC Warriors"
                                required>
                        </div>

                        <!-- Sport -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sport</label>
                            <select class="form-select" name="sport_id" required>
                                <option disabled selected>Select sport</option>
                                <option>Basketball</option>
                                <option>Football</option>
                            </select>
                        </div>

                        <!-- College -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">College</label>
                            <select class="form-select" name="college_id" required>
                                <option disabled selected>Select college</option>
                                <option>ATC</option>
                                <option>IAA</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="/admin" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Create</button>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</body>

</html>