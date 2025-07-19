<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Attendance App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('attendances') }}">Attendance App</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('departments') ? 'active' : '' }}"
                        href="{{ route('departments') }}">Departments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employees') ? 'active' : '' }}"
                        href="{{ route('employees') }}">Employees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('attendances') ? 'active' : '' }}"
                        href="{{ route('attendances') }}">Attendances</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('checkin') ? 'active' : '' }}"
                        href="{{ route('checkin') }}">Check In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('checkout') ? 'active' : '' }}"
                        href="{{ route('checkout') }}">Check Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <footer class="text-center py-3">
        <small>
            Build by Denis Hanif Prasetya —
            <a href="https://www.linkedin.com/in/denis-hanif-prasetya-7a815516b/" target="_blank">LinkedIn</a>
        </small>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    @stack('scripts')

</body>

</html>
