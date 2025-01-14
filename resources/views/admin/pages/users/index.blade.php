@extends('layouts.admin')
@section('title', 'User Management')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-alerts />

        <x-heading-w-button href="" icon="ri-add-line me-1_5" headingText="User Management" data-bs-toggle="modal"
            data-bs-target="#newUserModal">
            Add User
        </x-heading-w-button>

        <!-- Modal for Adding New User -->
        <div class="modal fade" id="newUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" name="name" placeholder="Name"
                                            required />
                                        <label>Name</label>
                                    </div>
                                </div>
                                <div class="col mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="email" class="form-control" name="email" placeholder="Email"
                                            required />
                                        <label>Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" class="form-control" name="password" placeholder="Password"
                                            required />
                                        <label>Password</label>
                                    </div>
                                </div>
                                <div class="col mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select name="role_id" class="form-control" required>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                            @endforeach
                                        </select>
                                        <label>Role</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="d-flex justify-content-between mb-4 align-items-center">
            <!-- Search Component -->
            <x-search-form id="appointmentSearch" placeholder="Search Appointments" />

            <!-- Date Filter -->
            <div class="me-3">
                <label for="filterRole" class="form-label">Filter by Role:</label>
                <select id="filterRole" class="form-control" onchange="filterTable()">
                    <option value="">All Roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- User Table -->
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="usersTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr data-role="{{ $user->role->id }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-4">
                                                <img src="{{ asset('assets/img/avatars/' . (($user->id % 7) + 1) . '.png') }}"
                                                    alt="Avatar" class="rounded-circle" />
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate"> {{ $user->name }}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->role->name) }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Edit Button -->
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editUserModal{{ $user->id }}">Edit</button>

                                            <!-- Delete Form -->
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit User Modal -->
                                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ $user->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email"
                                                            value="{{ $user->email }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">Password (leave empty if
                                                            not changing)</label>
                                                        <input type="password" class="form-control" name="password"
                                                            placeholder="Password">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="role" class="form-label">Role</label>
                                                        <select name="role_id" class="form-control" required>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}"
                                                                    {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                                    {{ ucfirst($role->name) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rows = document.querySelectorAll('#usersTable tbody tr');

            // Store the original rows, capturing both the user name and the user role
            originalRows = Array.from(rows).map(row => ({
                element: row,
                name: row.querySelector('td:nth-child(1)').textContent.toLowerCase(),
                email: row.querySelector('td:nth-child(2)').textContent.toLowerCase(),
                role: row.getAttribute('data-role').toLowerCase(),
            }));

            // Add event listeners for the search input and role filter
            document.getElementById('appointmentSearch').addEventListener('input', filterTable);
            document.getElementById('filterRole').addEventListener('change', filterTable);
        });

        function filterTable() {
            const searchQuery = document.getElementById('appointmentSearch').value.toLowerCase();
            const roleFilter = document.getElementById('filterRole').value.toLowerCase();
            const tableBody = document.querySelector('#usersTable tbody');

            // Clear the table body
            tableBody.innerHTML = '';

            if (searchQuery === '' && roleFilter === '') {
                // If both search and role filters are empty, show all rows
                originalRows.forEach(row => tableBody.appendChild(row.element));
            } else {
                // Filter the rows based on search and role
                const filteredRows = originalRows.filter(row =>
                    row.name.includes(searchQuery) &&
                    (roleFilter === '' || row.role === roleFilter)
                );

                filteredRows.forEach(row => tableBody.appendChild(row.element));
            }
        }
    </script>
@endsection
@endsection
