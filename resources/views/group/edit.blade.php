<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Edit Group - {{ $group_name }}</title>

    <style>
        /* =========================================================
           RESET
        ========================================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        html {
            width: 100%;
            overflow-x: hidden;
        }

        body {
            width: 100%;
            min-height: 100vh;
            padding: 30px 15px;

            background:
                radial-gradient(
                    circle at top left,
                    rgba(255, 255, 255, 0.55),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #f8dddd,
                    #d98686,
                    #eabbbb,
                    #f8e5e5
                );

            color: #444;
        }

        /* =========================================================
           MAIN CONTAINER
        ========================================================= */

        .container {
            width: 100%;
            max-width: 750px;
            margin: 0 auto;

            display: flex;
            flex-direction: column;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .header {
            position: relative;

            width: 100%;
            padding: 25px;
            margin-bottom: 18px;

            border-radius: 22px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #d98686,
                    #b85f5f
                );

            box-shadow:
                0 12px 30px rgba(130, 60, 60, 0.22);

            overflow: hidden;
        }

        .header::before,
        .header::after {
            content: "";
            position: absolute;
            pointer-events: none;
        }

        .header::before {
            width: 180px;
            height: 180px;

            top: -80px;
            right: -50px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.12);
        }

        .header::after {
            width: 120px;
            height: 120px;

            right: 80px;
            bottom: -60px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.08);
        }

        .back-link {
            position: relative;
            z-index: 2;

            display: inline-flex;

            align-items: center;
            gap: 6px;

            margin-bottom: 18px;

            color: rgba(255, 255, 255, 0.85);

            text-decoration: none;

            font-size: 13px;

            transition: 0.2s ease;
        }

        .back-link:hover {
            color: white;
            transform: translateX(-3px);
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .header h1 {
            font-size: 27px;
            font-weight: 700;
        }

        .header p {
            margin-top: 7px;

            color: rgba(255, 255, 255, 0.85);

            font-size: 14px;
            line-height: 1.5;
        }

        /* =========================================================
           MAIN CARD
        ========================================================= */

        .card {
            width: 100%;

            padding: 22px;

            border-radius: 22px;

            background: rgba(255, 255, 255, 0.93);

            box-shadow:
                0 12px 35px rgba(0, 0, 0, 0.12);

            backdrop-filter: blur(10px);
        }

        /* =========================================================
           GROUP INFORMATION
        ========================================================= */

        .group-info {
            width: 100%;

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 12px;

            margin-bottom: 25px;
        }

        .info-box {
            width: 100%;

            padding: 15px;

            background: #faf4f4;

            border: 1px solid #f0dddd;

            border-radius: 15px;
        }

        .info-label {
            display: block;

            margin-bottom: 6px;

            color: #999;

            font-size: 11px;

            text-transform: uppercase;

            letter-spacing: 0.6px;
        }

        .info-value {
            display: block;

            color: #444;

            font-size: 15px;

            font-weight: bold;

            word-break: break-word;
        }

        /* =========================================================
           SECTION
        ========================================================= */

        .section {
            width: 100%;
            margin-bottom: 28px;
        }

        .section-header {
            width: 100%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 14px;
        }

        .section-title {
            min-width: 0;
        }

        .section-title h2 {
            color: #444;

            font-size: 18px;
        }

        .section-title p {
            margin-top: 4px;

            color: #999;

            font-size: 13px;
        }

        .member-count {
            flex-shrink: 0;

            padding: 7px 12px;

            border-radius: 20px;

            background: #f8e4e4;

            color: #b85f5f;

            font-size: 12px;

            font-weight: bold;
        }

        /* =========================================================
           CURRENT MEMBERS
        ========================================================= */

        .members-grid {
            width: 100%;

            display: flex;

            flex-direction: column;

            gap: 10px;
        }

        .member-card {
            width: 100%;

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 12px;

            border-radius: 16px;

            background: white;

            border: 1px solid #f0dddd;

            transition: 0.2s ease;
        }

        .member-card:hover {
            transform: translateY(-2px);

            box-shadow:
                0 7px 18px rgba(0, 0, 0, 0.08);
        }

        .member-avatar {
            width: 48px;
            height: 48px;

            flex-shrink: 0;

            border-radius: 50%;

            object-fit: cover;

            border: 2px solid #f1d1d1;
        }

        .avatar-placeholder {
            display: flex;

            align-items: center;
            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    #d98686,
                    #b85f5f
                );

            color: white;

            font-size: 18px;

            font-weight: bold;
        }

        .member-info {
            flex: 1;
            min-width: 0;
        }

        .member-name {
            display: block;

            color: #444;

            font-weight: bold;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .member-id {
            display: block;

            margin-top: 4px;

            color: #aaa;

            font-size: 11px;
        }

        .view-btn {
            flex-shrink: 0;

            padding: 8px 12px;

            border-radius: 20px;

            background: #f7e2e2;

            color: #b85f5f;

            text-decoration: none;

            font-size: 12px;

            font-weight: bold;

            transition: 0.2s ease;
        }

        .view-btn:hover {
            background: #ecd0d0;
        }

        .remove-form {
            flex-shrink: 0;
        }

        .remove-btn {
            width: 34px;
            height: 34px;

            display: flex;

            align-items: center;
            justify-content: center;

            border: none;

            border-radius: 50%;

            background: #fff0f0;

            color: #d15f5f;

            font-size: 19px;

            cursor: pointer;

            transition: 0.2s ease;
        }

        .remove-btn:hover {
            background: #d15f5f;

            color: white;

            transform: rotate(8deg);
        }

        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .empty {
            width: 100%;

            padding: 30px 20px;

            text-align: center;

            background: #faf5f5;

            border: 1px dashed #e5caca;

            border-radius: 16px;

            color: #999;
        }

        .empty-icon {
            margin-bottom: 8px;

            font-size: 35px;
        }

        .empty strong {
            display: block;

            color: #666;

            font-size: 15px;
        }

        .empty p {
            margin-top: 5px;

            font-size: 13px;
        }

        /* =========================================================
           DIVIDER
        ========================================================= */

        .divider {
            width: 100%;

            height: 1px;

            margin: 25px 0;

            background: #eee;
        }

        /* =========================================================
           SEARCH
        ========================================================= */

        .search-box {
            width: 100%;
            height: 48px;

            display: flex;

            align-items: center;

            gap: 10px;

            margin-bottom: 14px;

            padding: 0 15px;

            background: #f8f3f3;

            border: 1px solid transparent;

            border-radius: 14px;

            transition: 0.2s ease;
        }

        .search-box:focus-within {
            background: white;

            border-color: #d98686;

            box-shadow:
                0 0 0 3px rgba(217, 134, 134, 0.10);
        }

        .search-icon {
            flex-shrink: 0;

            color: #aaa;

            font-size: 16px;
        }

        .search-box input {
            width: 100%;

            border: none;

            outline: none;

            background: transparent;

            color: #444;

            font-size: 14px;
        }

        .search-box input::placeholder {
            color: #aaa;
        }

        /* =========================================================
           FRIEND LIST
        ========================================================= */

        .friend-list {
            width: 100%;

            display: flex;

            flex-direction: column;

            gap: 9px;

            max-height: 390px;

            overflow-y: auto;

            padding-right: 4px;
        }

        .friend-list::-webkit-scrollbar {
            width: 5px;
        }

        .friend-list::-webkit-scrollbar-track {
            background: #f5eeee;

            border-radius: 10px;
        }

        .friend-list::-webkit-scrollbar-thumb {
            background: #d98686;

            border-radius: 10px;
        }

        .friend {
            position: relative;

            width: 100%;

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 12px;

            border-radius: 15px;

            background: #d98686;

            color: white;

            cursor: pointer;

            border: 2px solid transparent;

            transition:
                transform 0.2s ease,
                background 0.2s ease,
                box-shadow 0.2s ease;
        }

        .friend:hover {
            background: #ca7777;

            transform: translateX(3px);
        }

        .friend.selected {
            background: #ad5757;

            border-color: rgba(255, 255, 255, 0.45);

            box-shadow:
                0 6px 17px rgba(173, 87, 87, 0.25);
        }

        .friend-checkbox {
            position: absolute;

            width: 1px;
            height: 1px;

            opacity: 0;

            pointer-events: none;
        }

        .friend img,
        .friend .avatar {
            width: 48px;
            height: 48px;

            flex-shrink: 0;

            border-radius: 50%;

            object-fit: cover;

            border: 3px solid white;
        }

        .friend .avatar {
            display: flex;

            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, 0.20);

            color: white;

            font-size: 18px;

            font-weight: bold;
        }

        .friend-info {
            flex: 1;

            min-width: 0;
        }

        .friend-name {
            font-weight: bold;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .friend-id {
            margin-top: 4px;

            color: rgba(255, 255, 255, 0.75);

            font-size: 11px;
        }

        .check-icon {
            width: 28px;
            height: 28px;

            flex-shrink: 0;

            display: flex;

            align-items: center;
            justify-content: center;

            border: 2px solid rgba(255, 255, 255, 0.65);

            border-radius: 50%;

            color: transparent;

            font-size: 14px;

            font-weight: bold;

            transition: 0.2s ease;
        }

        .friend.selected .check-icon {
            background: white;

            border-color: white;

            color: #ad5757;
        }

        /* =========================================================
           SELECTED COUNT
        ========================================================= */

        .selected-count {
            width: 100%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-top: 12px;

            padding: 10px 13px;

            border-radius: 11px;

            background: #faf4f4;

            color: #999;

            font-size: 13px;
        }

        .selected-count strong {
            color: #b85f5f;
        }

        /* =========================================================
           ACTIONS
        ========================================================= */

        .actions {
            width: 100%;

            display: flex;

            gap: 10px;

            margin-top: 22px;
        }

        .btn {
            flex: 1;

            min-height: 47px;

            display: flex;

            align-items: center;
            justify-content: center;

            border: none;

            border-radius: 24px;

            cursor: pointer;

            text-decoration: none;

            font-size: 14px;

            font-weight: bold;

            transition: 0.2s ease;
        }

        .cancel-btn {
            background: #eeeeee;

            color: #666;
        }

        .cancel-btn:hover {
            background: #e1e1e1;

            transform: translateY(-1px);
        }

        .save-btn {
            background:
                linear-gradient(
                    135deg,
                    #d98686,
                    #b85f5f
                );

            color: white;

            box-shadow:
                0 6px 15px rgba(184, 95, 95, 0.22);
        }

        .save-btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 9px 20px rgba(184, 95, 95, 0.30);
        }

        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 600px) {

            body {
                padding: 15px 10px;
            }

            .container {
                width: 100%;
                max-width: 100%;
            }

            .header {
                padding: 20px;

                border-radius: 18px;
            }

            .header h1 {
                font-size: 22px;
            }

            .header p {
                font-size: 13px;
            }

            .card {
                padding: 16px;

                border-radius: 18px;
            }

            .group-info {
                grid-template-columns: 1fr;
            }

            .section-header {
                align-items: flex-start;
            }

            .member-card {
                padding: 10px;

                gap: 8px;
            }

            .member-avatar {
                width: 43px;
                height: 43px;
            }

            .view-btn {
                padding: 7px 9px;

                font-size: 11px;
            }

            .remove-btn {
                width: 31px;
                height: 31px;
            }

            .friend {
                padding: 10px;

                gap: 9px;
            }

            .friend img,
            .friend .avatar {
                width: 43px;
                height: 43px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        /* =========================================================
           VERY SMALL MOBILE
        ========================================================= */

        @media (max-width: 380px) {

            body {
                padding: 10px 6px;
            }

            .card {
                padding: 12px;
            }

            .header {
                padding: 17px;
            }

            .member-card {
                gap: 6px;
            }

            .member-name {
                font-size: 13px;
            }

            .member-id {
                font-size: 10px;
            }

            .view-btn {
                padding: 6px 7px;
            }

            .remove-btn {
                width: 29px;
                height: 29px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <div class="header">

        <a
            href="{{ route('main') }}"
            class="back-link"
        >
            ← Back to Groups
        </a>

        <div class="header-content">

            <h1>Edit Group</h1>

            <p>
                Manage your group members and add new friends.
            </p>

        </div>

    </div>


    <!-- =========================================================
         MAIN CARD
    ========================================================== -->

    <div class="card">

        <!-- =====================================================
             GROUP INFORMATION
        ====================================================== -->

        <div class="group-info">

            <div class="info-box">

                <span class="info-label">
                    Group Name
                </span>

                <span class="info-value">
                    {{ $group_name }}
                </span>

            </div>

            <div class="info-box">

                <span class="info-label">
                    Group ID
                </span>

                <span class="info-value">
                    {{ $group_id }}
                </span>

            </div>

        </div>


        <!-- =====================================================
             CURRENT MEMBERS
        ====================================================== -->

        <div class="section">

            <div class="section-header">

                <div class="section-title">

                    <h2>
                        Current Members
                    </h2>

                    <p>
                        People already in this group.
                    </p>

                </div>

                <span class="member-count">

                    {{ count($members) }}

                    {{ count($members) == 1 ? 'member' : 'members' }}

                </span>

            </div>


            <div class="members-grid">

                @forelse ($members as $item)

                    <div class="member-card">

                        <!-- MEMBER AVATAR -->

                        @if (!empty($item->image))

                            <img
                                src="{{ asset('storage/' . $item->image) }}"
                                alt="{{ $item->name ?? 'User' }}"
                                class="member-avatar"
                            >

                        @else

                            <div class="member-avatar avatar-placeholder">

                                {{ strtoupper(substr($item->name ?? 'U', 0, 1)) }}

                            </div>

                        @endif


                        <!-- MEMBER INFORMATION -->

                        <div class="member-info">

                            <span class="member-name">

                                {{ $item->name ?? 'Unknown' }}

                            </span>

                            <span class="member-id">

                                ID:
                                {{ $item->number_id ?? $item->id }}

                            </span>

                        </div>


                        <!-- VIEW -->

                        <a
                            href="{{ route('attibutes', $item->id) }}"
                            class="view-btn"
                        >
                            View
                        </a>


                        <!-- REMOVE -->
@if ($isOwner)

    <form
        action="{{ route('remove_from_groups', ['id' => $item->id]) }}"
        method="POST"
        class="remove-form"
        onsubmit="return confirmRemove(@js($item->name ?? 'this member'))"
    >

        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="remove-btn"
            title="Remove member"
        >
            ×
        </button>

    </form>

@endif


                    </div>

                @empty

                    <div class="empty">

                        <div class="empty-icon">
                            👥
                        </div>

                        <strong>
                            No members yet
                        </strong>

                        <p>
                            Add some friends below.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        <div class="divider"></div>


        <!-- =====================================================
             ADD FRIENDS FORM
        ====================================================== -->

        <form
            action="{{ route('group.update') }}"
            method="POST"
            id="groupForm"
        >

            @csrf

            <!-- GROUP ID -->

            <input
                type="hidden"
                name="group_id"
                value="{{ $group_id }}"
            >

            <!-- GROUP NAME -->

            <input
                type="hidden"
                name="group_name"
                value="{{ $group_name }}"
            >


            <div class="section">

                <!-- SECTION HEADER -->

                <div class="section-header">

                    <div class="section-title">

                        <h2>
                            Add Friends
                        </h2>

                        <p>
                            Select friends you want to add.
                        </p>

                    </div>

                </div>


                <!-- SEARCH -->

                <div class="search-box">

                    <span class="search-icon">
                        🔍
                    </span>

                    <input
                        type="text"
                        id="friendSearch"
                        placeholder="Search friends..."
                        autocomplete="off"
                    >

                </div>


                <!-- FRIEND LIST -->

                <div
                    class="friend-list"
                    id="friendList"
                >

                    @forelse ($friends as $person)

                        <label
                            class="friend"
                            data-name="{{ strtolower($person->name ?? '') }}"
                            data-id="{{ strtolower($person->number_id ?? $person->user_id ?? '') }}"
                        >

                            <!-- CHECKBOX -->

                            <input
                                type="checkbox"
                                name="user_id[]"
                                value="{{ $person->user_id }}"
                                class="friend-checkbox"
                            >


                            <!-- PROFILE IMAGE -->

                            @if (!empty($person->image))

                                <img
                                    src="{{ asset('storage/' . $person->image) }}"
                                    alt="{{ $person->name ?? 'User' }}"
                                >

                            @else

                                <div class="avatar">

                                    {{ strtoupper(substr($person->name ?? 'U', 0, 1)) }}

                                </div>

                            @endif


                            <!-- FRIEND INFORMATION -->

                            <div class="friend-info">

                                <div class="friend-name">

                                    {{ $person->name ?? 'Unknown' }}

                                </div>

                                <div class="friend-id">

                                    ID:
                                    {{ $person->number_id ?? $person->user_id }}

                                </div>

                            </div>


                            <!-- CHECK ICON -->

                            <div class="check-icon">
                                ✓
                            </div>

                        </label>

                    @empty

                        <div class="empty">

                            <div class="empty-icon">
                                👤
                            </div>

                            <strong>
                                No friends found
                            </strong>

                            <p>
                                You don't have any available friends to add.
                            </p>

                        </div>

                    @endforelse

                </div>


                <!-- SELECTED COUNT -->

                <div
                    class="selected-count"
                    id="selectedCount"
                >

                    <span>
                        Selected
                    </span>

                    <strong>
                        0 friends
                    </strong>

                </div>


                <!-- ACTION BUTTONS -->

                <div class="actions">

                    <a
                        href="{{ route('main') }}"
                        class="btn cancel-btn"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn save-btn"
                    >
                        Save Group
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* =========================================================
           FRIEND SELECTION
        ========================================================= */

        const friends = document.querySelectorAll('.friend');

        friends.forEach(function (friend) {

            const checkbox = friend.querySelector('.friend-checkbox');

            if (!checkbox) {
                return;
            }

            checkbox.addEventListener('change', function () {

                friend.classList.toggle(
                    'selected',
                    checkbox.checked
                );

                updateSelectedCount();

            });

        });


        /* =========================================================
           INITIAL COUNT
        ========================================================= */

        updateSelectedCount();


        /* =========================================================
           SEARCH
        ========================================================= */

        const searchInput =
            document.getElementById('friendSearch');

        if (searchInput) {

            searchInput.addEventListener(
                'input',
                searchFriends
            );

        }


        /* =========================================================
           FORM VALIDATION
        ========================================================= */

        const form =
            document.getElementById('groupForm');

        if (form) {

            form.addEventListener('submit', function (event) {

                const selected =
                    document.querySelectorAll(
                        '.friend-checkbox:checked'
                    );

                if (selected.length === 0) {

                    event.preventDefault();

                    alert(
                        'Please select at least one friend.'
                    );

                    return false;
                }

            });

        }

    });


    /* =========================================================
       UPDATE SELECTED COUNT
    ========================================================= */

    function updateSelectedCount() {

        const selected =
            document.querySelectorAll(
                '.friend-checkbox:checked'
            ).length;

        const count =
            document.getElementById('selectedCount');

        if (!count) {
            return;
        }

        const strong =
            count.querySelector('strong');

        if (!strong) {
            return;
        }

        strong.textContent =
            selected === 1
                ? '1 friend'
                : selected + ' friends';
    }


    /* =========================================================
       SEARCH FRIENDS
    ========================================================= */

    function searchFriends() {

        const input =
            document.getElementById('friendSearch');

        if (!input) {
            return;
        }

        const search =
            input.value
                .trim()
                .toLowerCase();

        const friends =
            document.querySelectorAll('.friend');

        friends.forEach(function (friend) {

            const name =
                (friend.dataset.name || '').toLowerCase();

            const id =
                (friend.dataset.id || '').toLowerCase();

            const matches =
                name.includes(search) ||
                id.includes(search);

            friend.style.display =
                matches ? 'flex' : 'none';

        });

    }


    /* =========================================================
       REMOVE MEMBER CONFIRMATION
    ========================================================= */

    function confirmRemove(name) {

        return confirm(
            'Are you sure you want to remove ' +
            name +
            ' from this group?'
        );

    }
</script>

</body>
</html>