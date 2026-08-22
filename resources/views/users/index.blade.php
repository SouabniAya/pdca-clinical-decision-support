@extends('layouts.app')

@section('title', 'User Management')

@php($active = 'users')

@section('content')
<div class="patients-page">

    <div class="patients-page__head">
        <div>
            <h1>User List</h1>
            <p>View and manage users registered in the system.</p>
        </div>
        <a href="{{ route('users.create') }}" class="patients-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            New User
        </a>
    </div>

    @if (session('success'))
        <div class="clinical-form__success" style="margin-bottom:16px;padding:12px 16px;background:#e6f7ec;color:#1a7f3c;border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="clinical-form__error" style="margin-bottom:16px;padding:12px 16px;background:#fdecea;color:#b3261e;border-radius:8px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="GET" action="{{ route('users.index') }}" class="patients-toolbar">
        <div class="patients-toolbar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search user by name or ID...">
        </div>

        <select name="status" class="patients-toolbar__filter" onchange="this.form.submit()">
            <option value="">Status</option>
            <option value="active" @selected(request('status') === 'active')>Active</option>
            <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
        </select>

        <select name="role" class="patients-toolbar__filter" onchange="this.form.submit()">
            <option value="">Role</option>
            <option value="Doctor" @selected(request('role') === 'Doctor')>Doctor</option>
            <option value="Nurse" @selected(request('role') === 'Nurse')>Nurse</option>
            <option value="Visitor" @selected(request('role') === 'Visitor')>Visitor</option>
            <option value="Administrator" @selected(request('role') === 'Administrator')>Administrator</option>
        </select>

        <button type="submit" class="patients-toolbar__filter" style="border:0;cursor:pointer;">
            Search
        </button>

        <a href="{{ route('users.index') }}" class="patients-toolbar__reset">
            Reset
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </form>

    <div class="patients-table-wrap">
        <table class="patients-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td><span class="patients-table__status">{{ $user['status'] }}</span></td>
                    <td>{{ $user['role'] }}</td>
                    <td>
                        <div class="patients-table__actions" style="position:relative;">
                            <a href="{{ route('users.show', $user['id']) }}" aria-label="View">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                            </a>
                            <button type="button" aria-label="More options" onclick="toggleUserMenu(event, '{{ $user['id'] }}')">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>

                            <div class="user-actions-menu" id="menu-{{ $user['id'] }}" style="display:none;position:absolute;right:0;top:calc(100% + 4px);background:#fff;border:1px solid #e2e2e2;border-radius:8px;box-shadow:0 6px 16px rgba(0,0,0,.1);z-index:20;min-width:130px;overflow:hidden;">
                                <a href="{{ route('users.edit', $user['id']) }}" style="display:block;padding:10px 14px;color:#1a1a1a;text-decoration:none;font-size:14px;">Edit</a>
                                <form method="POST" action="{{ route('users.destroy', $user['id']) }}" onsubmit="return confirm('Delete this user? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="display:block;width:100%;text-align:left;padding:10px 14px;background:none;border:0;border-top:1px solid #f0f0f0;color:#c0392b;font-size:14px;cursor:pointer;">Delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="#" class="patients-page__view-all">View All Users </a>

</div>

<script>
    function toggleUserMenu(event, id) {
        event.stopPropagation();
        document.querySelectorAll('.user-actions-menu').forEach(function (menu) {
            if (menu.id !== 'menu-' + id) menu.style.display = 'none';
        });
        var menu = document.getElementById('menu-' + id);
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }
    document.addEventListener('click', function () {
        document.querySelectorAll('.user-actions-menu').forEach(function (menu) {
            menu.style.display = 'none';
        });
    });
</script>
@endsection