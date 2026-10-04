<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>Chat App</title>

    @vite(['resources/js/app.js'])

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

        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {
            overflow: hidden;

            background:
                radial-gradient(
                    circle at top left,
                    #f8dede,
                    transparent 40%
                ),
                linear-gradient(
                    135deg,
                    #f1d3d3,
                    #d98686,
                    #e7bcbc
                );

            color: #444;
        }


        /* =========================================================
           ANIMATION
        ========================================================= */

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-15px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes messageIn {
            from {
                opacity: 0;
                transform: translateY(8px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }


        /* =========================================================
           MENU BUTTON
        ========================================================= */

        .menu-btn {
            position: fixed;
            top: 18px;
            left: 18px;

            width: 48px;
            height: 48px;

            border-radius: 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(217, 134, 134, .95);

            color: white;

            font-size: 25px;

            cursor: pointer;

            z-index: 3000;

            box-shadow:
                0 8px 25px rgba(0,0,0,.18);

            transition: .3s;
        }

        .menu-btn:hover {
            transform: rotate(90deg) scale(1.05);
            background: #c66e6e;
        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .sidebar {
            position: fixed;

            left: -300px;
            top: 0;

            width: 280px;
            height: 100vh;

            padding: 90px 25px 25px;

            background:
                linear-gradient(
                    180deg,
                    rgba(211, 117, 117, .98),
                    rgba(177, 86, 86, .98)
                );

            color: white;

            z-index: 2500;

            transition: .4s ease;

            box-shadow:
                10px 0 35px rgba(0,0,0,.25);

            overflow-y: auto;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .sidebar-avatar {
            width: 95px;
            height: 95px;

            border-radius: 50%;

            object-fit: cover;

            border: 4px solid white;

            box-shadow:
                0 8px 20px rgba(0,0,0,.2);

            margin-bottom: 12px;
        }

        .sidebar-default-avatar {
            width: 95px;
            height: 95px;

            border-radius: 50%;

            margin: auto;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 40px;

            background:
                rgba(255,255,255,.2);

            border: 4px solid white;

            margin-bottom: 12px;
        }

        .sidebar-header h2 {
            font-size: 20px;
        }

        .sidebar-header p {
            margin-top: 5px;
            font-size: 13px;
            opacity: .8;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;

            gap: 12px;

            padding: 13px 15px;

            border-radius: 12px;

            color: white;

            text-decoration: none;

            background:
                rgba(255,255,255,.08);

            transition: .25s;
        }

        .sidebar-menu a:hover {
            background:
                rgba(255,255,255,.2);

            transform: translateX(5px);
        }

        .sidebar-info {
            margin-top: 25px;

            padding: 15px;

            border-radius: 15px;

            background:
                rgba(255,255,255,.1);
        }

        .sidebar-info p {
            font-size: 13px;
            margin-bottom: 10px;
            word-break: break-word;
        }


        /* =========================================================
           MAIN
        ========================================================= */

        .container {
            width: 100%;
            height: 100vh;

            display: flex;

            gap: 15px;

            padding: 15px;
        }


        /* =========================================================
           LEFT
        ========================================================= */

        .left {
            width: 360px;

            height: calc(100vh - 30px);

            padding: 70px 15px 15px;

            display: flex;

            flex-direction: column;

            min-width: 0;
        }


        /* =========================================================
           SEARCH
        ========================================================= */

        .search-area {
            margin-bottom: 15px;
        }

        .search-area form {
            display: flex;
            gap: 7px;
        }

        .search-area input {
            flex: 1;
            min-width: 0;

            height: 44px;

            padding: 0 16px;

            border: none;
            outline: none;

            border-radius: 14px;

            background:
                rgba(255,255,255,.95);

            box-shadow:
                0 5px 18px rgba(0,0,0,.08);

            font-size: 14px;
        }

        .search-btn,
        .clear-btn {
            height: 44px;

            padding: 0 15px;

            border: none;

            border-radius: 14px;

            display: flex;

            align-items: center;
            justify-content: center;

            text-decoration: none;

            cursor: pointer;

            font-weight: bold;

            color: white;

            transition: .25s;
        }

        .search-btn {
            background: #c96f6f;
        }

        .clear-btn {
            background: rgba(255,255,255,.5);
            color: #8e5050;
        }

        .search-btn:hover {
            background: #b95e5e;
            transform: translateY(-2px);
        }

        .clear-btn:hover {
            background: white;
        }


        /* =========================================================
           PANEL
        ========================================================= */

        .panel {
            background:
                rgba(255,255,255,.18);

            border-radius: 20px;

            padding: 12px;

            margin-bottom: 12px;

            min-height: 0;

            backdrop-filter: blur(10px);
        }

        .section-title {
            display: flex;

            align-items: center;

            justify-content: space-between;

            color: white;

            font-size: 14px;

            font-weight: bold;

            margin-bottom: 10px;

            padding: 4px 5px;
        }

        .section-badge {
            background:
                rgba(255,255,255,.25);

            padding: 4px 9px;

            border-radius: 20px;

            font-size: 11px;
        }


        /* =========================================================
           FRIEND LIST
        ========================================================= */

        .friend-list {
            height: 42%;
            overflow-y: auto;
            padding-right: 5px;
        }

        .user-friends {
            display: flex;

            align-items: center;

            gap: 10px;

            padding: 10px;

            margin-bottom: 8px;

            border-radius: 15px;

            background:
                rgba(201,111,111,.92);

            color: white;

            transition: .25s;

            animation: slideIn .3s ease;
        }

        .user-friends:hover {
            background: #b95f5f;

            transform: translateX(3px);

            box-shadow:
                0 7px 18px rgba(0,0,0,.14);
        }

        .friend-click {
            flex: 1;

            min-width: 0;

            display: flex;

            align-items: center;

            gap: 10px;

            cursor: pointer;
        }

        .user-friends img,
        .friend-avatar {
            width: 48px;
            height: 48px;

            flex-shrink: 0;

            border-radius: 50%;

            object-fit: cover;

            border: 3px solid white;
        }

        .friend-avatar {
            display: flex;

            align-items: center;
            justify-content: center;

            background:
                rgba(255,255,255,.2);

            font-size: 21px;
        }

        .friend-info {
            min-width: 0;
            overflow: hidden;
        }

        .friend-name {
            font-weight: bold;

            font-size: 14px;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .friend-id {
            margin-top: 4px;

            font-size: 11px;

            opacity: .75;
        }


        /* =========================================================
           FRIEND BUTTONS
        ========================================================= */

        .friend-actions {
            display: flex;

            align-items: center;

            gap: 5px;
        }

        .action-btn {
            width: 32px;
            height: 32px;

            border: none;

            border-radius: 10px;

            display: flex;

            align-items: center;
            justify-content: center;

            cursor: pointer;

            text-decoration: none;

            font-size: 14px;

            transition: .2s;
        }

        .profile-btn {
            background:
                rgba(255,255,255,.2);

            color: white;
        }

        .profile-btn:hover {
            background: white;
            color: #c96f6f;
        }

        .remove-btn {
            background:
                rgba(100,20,20,.25);

            color: white;
        }

        .remove-btn:hover {
            background: #8e3f3f;
        }


        /* =========================================================
           GROUP SECTION
        ========================================================= */

        .group-section {
            flex: 1;

            min-height: 0;

            display: flex;

            flex-direction: column;

            background:
                rgba(255,255,255,.18);

            padding: 12px;

            border-radius: 20px;

            backdrop-filter: blur(10px);
        }

        .group-list {
            flex: 1;

            min-height: 0;

            overflow-y: auto;

            padding-right: 5px;
        }

        .user-group {
            display: flex;

            align-items: center;

            gap: 12px;

            padding: 11px;

            margin-bottom: 8px;

            border-radius: 15px;

            background:
                rgba(201,111,111,.92);

            color: white;

            cursor: pointer;

            transition: .25s;
        }

        .user-group:hover {
            background: #b95f5f;

            transform: translateX(4px);

            box-shadow:
                0 7px 18px rgba(0,0,0,.15);
        }

        .group-icon {
            width: 48px;
            height: 48px;

            flex-shrink: 0;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                rgba(255,255,255,.18);

            border: 3px solid white;

            font-size: 21px;
        }

        .group-info {
            min-width: 0;
            flex: 1;
        }

        .group-name {
            font-size: 14px;

            font-weight: bold;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .group-label {
            margin-top: 4px;

            font-size: 11px;

            opacity: .75;
        }


        /* =========================================================
           SEARCH RESULTS
        ========================================================= */

        .user-list {
            max-height: 35%;

            overflow-y: auto;

            margin-top: 5px;

            padding-right: 5px;
        }

        .user-card {
            display: flex;

            align-items: center;

            gap: 12px;

            padding: 12px;

            margin-bottom: 8px;

            border-radius: 15px;

            background:
                rgba(201,111,111,.95);

            color: white;

            cursor: pointer;

            transition: .25s;
        }

        .user-card:hover {
            background: #b95f5f;

            transform: translateX(4px);
        }

        .user-card img {
            width: 50px;
            height: 50px;

            border-radius: 50%;

            object-fit: cover;

            border: 3px solid white;

            flex-shrink: 0;
        }

        .user-card-info {
            min-width: 0;
        }

        .user-card-info p {
            font-size: 11px;

            margin: 4px 0;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        /* =========================================================
           RIGHT CHAT
        ========================================================= */

        .right {
            flex: 1;

            height: calc(100vh - 30px);

            min-width: 0;

            padding-top: 5px;

            display: flex;

            flex-direction: column;
        }


        /* =========================================================
           EMPTY CHAT
        ========================================================= */

        .empty-chat {
            width: 100%;
            height: 100%;

            border-radius: 25px;

            display: flex;

            align-items: center;
            justify-content: center;

            text-align: center;

            color: white;

            background:
                rgba(255,255,255,.18);

            backdrop-filter: blur(12px);

            box-shadow:
                0 10px 30px rgba(0,0,0,.08);
        }

        .empty-chat-icon {
            width: 90px;
            height: 90px;

            margin: auto auto 20px;

            border-radius: 50%;

            display: flex;

            align-items: center;
            justify-content: center;

            background:
                rgba(255,255,255,.2);

            font-size: 42px;
        }

        .empty-chat h2 {
            font-size: 23px;
            margin-bottom: 8px;
        }

        .empty-chat p {
            opacity: .8;
            font-size: 14px;
        }


        /* =========================================================
           CHAT HEADER
        ========================================================= */

        .chat-header {
            min-height: 68px;

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 10px 18px;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    #d98686,
                    #bd6262
                );

            color: white;

            box-shadow:
                0 8px 20px rgba(0,0,0,.13);

            flex-shrink: 0;
        }

        .chat-header-avatar {
            width: 44px;
            height: 44px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.2);

            border: 2px solid white;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 20px;

            flex-shrink: 0;
        }

        .chat-header-info {
            min-width: 0;
            flex: 1;
        }

        .chat-header-title {
            font-size: 17px;
            font-weight: bold;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .chat-header-status {
            font-size: 11px;

            margin-top: 3px;

            opacity: .75;
        }

        .group-edit-button {
            padding: 8px 14px;

            border-radius: 12px;

            color: white;

            background:
                rgba(255,255,255,.2);

            text-decoration: none;

            font-size: 12px;

            font-weight: bold;

            transition: .2s;
        }

        .group-edit-button:hover {
            background: white;
            color: #c66d6d;
        }

        .chat-back {
            display: none;

            width: 38px;
            height: 38px;

            border: none;

            border-radius: 11px;

            background:
                rgba(255,255,255,.2);

            color: white;

            font-size: 20px;

            cursor: pointer;
        }


        /* =========================================================
           CHAT BOX
        ========================================================= */

        .chat-box {
            flex: 1;

            min-height: 0;

            margin-top: 10px;

            padding: 20px;

            overflow-y: auto;

            border-radius: 22px;

            background:
                rgba(240,220,220,.8);

            box-shadow:
                inset 0 0 25px rgba(0,0,0,.04);

            display: flex;

            flex-direction: column;

            align-items: flex-start;
        }


        /* =========================================================
           MESSAGE
        ========================================================= */

        .message {
            max-width: 70%;

            padding: 10px 14px;

            margin-bottom: 10px;

            border-radius: 18px;

            color: white;

            background:
                #c97575;

            box-shadow:
                0 5px 12px rgba(0,0,0,.08);

            animation:
                messageIn .25s ease;

            word-break: break-word;
        }

        .message-other {
            align-self: flex-start;

            border-bottom-left-radius: 5px;
        }

        .message-mine {
            align-self: flex-end;

            background:
                linear-gradient(
                    135deg,
                    #ad5a5a,
                    #c66f6f
                );

            border-bottom-right-radius: 5px;
        }

        .message-user {
            font-size: 10px;

            font-weight: bold;

            margin-bottom: 4px;

            opacity: .75;
        }

        .message-text {
            font-size: 14px;

            line-height: 1.45;

            white-space: pre-wrap;
        }

        .chat-loading {
            color: #999;
            margin: auto;
        }

        .chat-error {
            color: #9b4444;

            background: rgba(255,255,255,.7);

            padding: 15px;

            border-radius: 12px;

            margin: auto;

            text-align: center;
        }


        /* =========================================================
           CHAT INPUT
        ========================================================= */

        .chat-input {
            display: flex;

            gap: 10px;

            margin-top: 10px;

            flex-shrink: 0;
        }

        .chat-input input {
            flex: 1;

            min-width: 0;

            height: 48px;

            padding: 0 18px;

            border: none;

            outline: none;

            border-radius: 25px;

            background: white;

            box-shadow:
                0 5px 15px rgba(0,0,0,.08);

            font-size: 14px;
        }

        .chat-input button {
            width: 90px;

            height: 48px;

            border: none;

            border-radius: 25px;

            background:
                linear-gradient(
                    135deg,
                    #d98686,
                    #b95f5f
                );

            color: white;

            font-weight: bold;

            cursor: pointer;

            transition: .25s;
        }

        .chat-input button:hover {
            transform: translateY(-2px);

            box-shadow:
                0 7px 15px rgba(0,0,0,.15);
        }

        .chat-input button:disabled {
            opacity: .6;

            cursor: not-allowed;

            transform: none;
        }


        /* =========================================================
           EMPTY LIST
        ========================================================= */

        .empty-list {
            text-align: center;

            color: white;

            padding: 20px;

            font-size: 13px;

            opacity: .8;
        }


        /* =========================================================
           SCROLLBAR
        ========================================================= */

        .friend-list::-webkit-scrollbar,
        .group-list::-webkit-scrollbar,
        .user-list::-webkit-scrollbar,
        .chat-box::-webkit-scrollbar,
        .sidebar::-webkit-scrollbar {

            width: 5px;
        }

        .friend-list::-webkit-scrollbar-thumb,
        .group-list::-webkit-scrollbar-thumb,
        .user-list::-webkit-scrollbar-thumb,
        .chat-box::-webkit-scrollbar-thumb,
        .sidebar::-webkit-scrollbar-thumb {

            background: #c87575;

            border-radius: 20px;
        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 900px) {

            .left {
                width: 310px;
            }

        }


        @media (max-width: 768px) {

            body {
                overflow: hidden;
            }

            .container {
                display: block;
                padding: 0;
            }

            .left {
                width: 100%;

                height: 100vh;

                padding:
                    75px 10px 10px;
            }

            .right {
                position: fixed;

                top: 0;
                left: 0;

                width: 100%;
                height: 100vh;

                padding: 10px;

                background:
                    linear-gradient(
                        135deg,
                        #e7bcbc,
                        #d98686
                    );

                z-index: 2000;

                display: none;
            }

            .right.active {
                display: flex;
            }

            .chat-back {
                display: flex;

                align-items: center;
                justify-content: center;
            }

            .menu-btn {
                top: 15px;
                left: 15px;
            }

            .friend-list {
                height: 40%;
            }

            .group-section {
                flex: 1;
            }

            .message {
                max-width: 85%;
            }

            .chat-input button {
                width: 75px;
            }

            .search-area form {
                gap: 5px;
            }

            .search-btn,
            .clear-btn {
                padding: 0 12px;
            }
        }


        @media (max-width: 450px) {

            .friend-actions {
                display: none;
            }

            .search-area input {
                font-size: 13px;
            }

            .search-btn,
            .clear-btn {
                font-size: 12px;
            }

            .chat-header-title {
                font-size: 15px;
            }
        }

    </style>

</head>


<body>


<!-- =========================================================
     MENU
========================================================= -->

<div
    class="menu-btn"
    onclick="toggleSidebar()"
>
    ☰
</div>


<!-- =========================================================
     SIDEBAR
========================================================= -->

<div
    class="sidebar"
    id="sidebar"
>

    <div class="sidebar-header">

        @if($user->profile?->image)

            <img
                src="{{ asset('storage/'.$user->profile->image) }}"
                class="sidebar-avatar"
                alt="Profile"
            >

        @else

            <div class="sidebar-default-avatar">
                👤
            </div>

        @endif


        <h2>
            {{ $user->name }}
        </h2>

        <p>
            {{ $user->email }}
        </p>

    </div>


    <div class="sidebar-menu">

        <a href="{{ route('main') }}">
            🏠
            <span>Home</span>
        </a>

        <a href="{{ route('profile') }}">
            👤
            <span>My Profile</span>
        </a>

        <a href="{{ route('groupw.view') }}">
            👥
            <span>Create Group</span>
        </a>

        <a href="{{ route('logins') }}">
            🚪
            <span>Logout</span>
        </a>

    </div>


    <div class="sidebar-info">

        <p>
            <strong>Name</strong><br>
            {{ $user->name }}
        </p>

        <p>
            <strong>Email</strong><br>
            {{ $user->email }}
        </p>

        @if($user->number_id)

            <p>
                <strong>ID</strong><br>
                {{ $user->number_id }}
            </p>

        @endif

    </div>

</div>


<!-- =========================================================
     MAIN
========================================================= -->

<div class="container">


    <!-- =====================================================
         LEFT
    ====================================================== -->

    <div class="left">


        <!-- SEARCH -->

        <div class="search-area">

            <form
                action="{{ route('main') }}"
                method="GET"
            >

                <input
                    type="text"
                    name="search_name"
                    value="{{ $search_name }}"
                    placeholder="🔍 Search users..."
                >

                <button
                    type="submit"
                    class="search-btn"
                >
                    Search
                </button>

                <a
                    href="{{ route('main') }}"
                    class="clear-btn"
                >
                    Clear
                </a>

            </form>

        </div>


        <!-- FRIENDS -->

        <div class="panel friend-list">

            <div class="section-title">

                <span>
                    👥 Friends
                </span>

                <span class="section-badge">
                    {{ count($friend) }}
                </span>

            </div>


            @forelse($friend as $item)


                @if($item->user_id == Auth::id())


                    @if($item->friend)

                        <div class="user-friends">

                            <div
                                class="friend-click"
                                onclick="openChat(
                                    '{{ $item->friend->id }}',
                                    @js($item->friend->name),
                                    '{{ $item->friend->number_id }}'
                                )"
                            >

                                @if($item->friend->profile?->image)

                                    <img
                                        src="{{ asset('storage/'.$item->friend->profile->image) }}"
                                        alt="Friend"
                                    >

                                @else

                                    <div class="friend-avatar">
                                        👤
                                    </div>

                                @endif


                                <div class="friend-info">

                                    <div class="friend-name">
                                        {{ $item->friend->name }}
                                    </div>

                                    <div class="friend-id">
                                        ID:
                                        {{ $item->friend->number_id ?? $item->friend->id }}
                                    </div>

                                </div>

                            </div>


                            <div class="friend-actions">

                                <a
                                    href="{{ route('attibutes', $item->friend->id) }}"
                                    class="action-btn profile-btn"
                                >
                                    👤
                                </a>


                                <form
                                    action="{{ route('remove_friends', ['id' => $item->friend->id]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Remove this friend?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-btn remove-btn"
                                    >
                                        ×
                                    </button>

                                </form>

                            </div>

                        </div>

                    @endif


                @else


                    @if($item->user)

                        <div class="user-friends">

                            <div
                                class="friend-click"
                                onclick="openChat(
                                    '{{ $item->user->id }}',
                                    @js($item->user->name),
                                    '{{ $item->user->number_id }}'
                                )"
                            >

                                @if($item->user->profile?->image)

                                    <img
                                        src="{{ asset('storage/'.$item->user->profile->image) }}"
                                        alt="Friend"
                                    >

                                @else

                                    <div class="friend-avatar">
                                        👤
                                    </div>

                                @endif


                                <div class="friend-info">

                                    <div class="friend-name">
                                        {{ $item->user->name }}
                                    </div>

                                    <div class="friend-id">
                                        ID:
                                        {{ $item->user->number_id ?? $item->user->id }}
                                    </div>

                                </div>

                            </div>


                            <div class="friend-actions">

                                <a
                                    href="{{ route('attibutes', $item->user->id) }}"
                                    class="action-btn profile-btn"
                                >
                                    👤
                                </a>


                                <form
                                    action="{{ route('remove_friends', ['id' => $item->user->id]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Remove this friend?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-btn remove-btn"
                                    >
                                        ×
                                    </button>

                                </form>

                            </div>

                        </div>

                    @endif

                @endif


            @empty

                <div class="empty-list">
                    No friends yet.
                </div>

            @endforelse

        </div>


        <!-- =====================================================
             GROUPS
        ====================================================== -->

        <div class="group-section">

            <div class="section-title">

                <span>
                    👥 Groups
                </span>

                <span class="section-badge">
                    {{ count($groups) }}
                </span>

            </div>


            <div class="group-list">

                @forelse($groups as $group)

                    <div
                        class="user-group"
                        onclick="openGroupChat(
                            '{{ $group->id }}',
                            @js($group->group_name)
                        )"
                    >

                        <div class="group-icon">
                            👥
                        </div>


                        <div class="group-info">
                             
                            <div class="group-name">
                                {{ $group->group_name }}
                            </div>

                            <div class="group-label">
                                Tap to open group chat
                            </div>

                        </div>

                        <div>
                            ›
                        </div>

                 
            <div>
                @if(Auth::id() == $group->user_id)

    <form
        action="{{ route('remove_group', [
            'id' => $group->id,
            'name' => $group->group_name
        ]) }}"
        method="POST"
    >
        @csrf
        @method('DELETE')

        <button type="submit">
            Delete Group
        </button>
    </form>

@endif
   </div>
            </div>

                @empty

                    <div class="empty-list">
                        No groups yet.
                    </div>

                @endforelse

            </div>

        </div>


        <!-- SEARCH RESULTS -->

        @if(!empty($search_name))

            <div class="user-list">

                <div class="section-title">
                    🔎 Search Results
                </div>


                @forelse($users as $searchUser)

                    <div
                        class="user-card"
                        onclick="openChat(
                            '{{ $searchUser->id }}',
                            @js($searchUser->name),
                            '{{ $searchUser->number_id }}'
                        )"
                    >

                        @if($searchUser->profile?->image)

                            <img
                                src="{{ asset('storage/'.$searchUser->profile->image) }}"
                                alt="User"
                            >

                        @else

                            <div class="friend-avatar">
                                👤
                            </div>

                        @endif


                        <div class="user-card-info">

                            <p>
                                <strong>
                                    {{ $searchUser->name }}
                                </strong>
                            </p>

                            <p>
                                {{ $searchUser->email }}
                            </p>

                            <p>
                                ID:
                                {{ $searchUser->number_id }}
                            </p>

                        </div>

                    </div>

                @empty

                    <div class="empty-list">
                        No users found.
                    </div>

                @endforelse

            </div>

        @endif

    </div>


    <!-- =====================================================
         RIGHT CHAT
    ====================================================== -->

    <div
        class="right"
        id="chatArea"
    >

        <div class="empty-chat">

            <div>

                <div class="empty-chat-icon">
                    💬
                </div>

                <h2>
                    Welcome to Chat
                </h2>

                <p>
                    Select a friend or group<br>
                    to start chatting.
                </p>

            </div>

        </div>

    </div>

</div>


<script>

/* =========================================================
   GLOBAL STATE
========================================================= */

let selectedUser = null;
let selectedGroup = null;
let selectedChat = null;

let privateChannel = null;
let groupChannel = null;

let currentGroupName = null;

let groupPollTimer = null;

let renderedMessageIds = new Set();

const MY_USER_ID = Number({{ auth()->id() }});

const csrfToken =
    document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content') || '';


/* =========================================================
   HELPER
========================================================= */

function escapeHtml(text)
{
    const div = document.createElement('div');

    div.textContent = text ?? '';

    return div.innerHTML;
}


function getChatBox()
{
    return document.getElementById('chatBox');
}


function clearChatBox()
{
    const box = getChatBox();

    if (box) {
        box.innerHTML = '';
    }

    renderedMessageIds.clear();
}


function stopGroupPolling()
{
    if (groupPollTimer) {

        clearInterval(groupPollTimer);

        groupPollTimer = null;
    }
}


/* =========================================================
   SIDEBAR
========================================================= */

function toggleSidebar()
{
    const sidebar =
        document.getElementById('sidebar');

    if (sidebar) {

        sidebar.classList.toggle('active');

    }
}


/* =========================================================
   LEAVE PRIVATE CHANNEL
========================================================= */

function leavePrivateChannel()
{
    if (
        typeof Echo !== 'undefined' &&
        privateChannel
    ) {

        try {

            Echo.leave(
                'chat.' + privateChannel
            );

        } catch (error) {

            console.warn(
                'Could not leave private channel',
                error
            );

        }

    }

    privateChannel = null;
}
function openGroupChat(groupId, groupName)
{
    groupId = Number(groupId);

    if (!groupId) {
        console.error('Invalid group ID');
        return;
    }

    console.log(
        'Opening group:',
        groupId,
        groupName
    );

    /*
     * Stop previous connections
     */
    stopGroupPolling();
    leavePrivateChannel();
    leaveGroupChannel();

    /*
     * Set state
     */
    selectedUser = null;
    selectedGroup = groupId;
    selectedChat = null;
    currentGroupName = groupName;

    renderedMessageIds.clear();

    const chatArea =
        document.getElementById('chatArea');

    if (!chatArea) {
        return;
    }

    chatArea.classList.add('active');

    /*
     * Generate edit URL
     */
    const editUrl =
        "{{ route('group.edit', [
            'id' => '__ID__',
            'group_name' => '__GROUP__'
        ]) }}"
        .replace(
            '__ID__',
            encodeURIComponent(groupId)
        )
        .replace(
            '__GROUP__',
            encodeURIComponent(groupName)
        );

    /*
     * Chat UI
     */
    chatArea.innerHTML = `

        <div class="chat-header">

            <button
                type="button"
                class="chat-back"
                onclick="closeMobileChat()"
            >
                ←
            </button>

            <div class="chat-header-avatar">
                👥
            </div>

            <div class="chat-header-info">

                <div class="chat-header-title">
                    ${escapeHtml(groupName)}
                </div>

                <div
                    class="chat-header-status"
                    id="groupStatus"
                >
                    Opening group...
                </div>

            </div>

            <a
                href="${editUrl}"
                class="group-edit-button"
            >
                Edit
            </a>

        </div>

        <div
            class="chat-box"
            id="chatBox"
        >
            <div class="chat-loading">
                Loading group messages...
            </div>
        </div>

        <div class="chat-input">

            <input
                type="text"
                id="messageInput"
                placeholder="Type group message..."
                autocomplete="off"
            >

            <button
                type="button"
                onclick="sendGroupMessage()"
            >
                Send
            </button>

        </div>
    `;

    /*
     * Ask Laravel for group + messages.
     */
    fetch(
        "{{ route('group.open') }}",
        {
            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },

            body: JSON.stringify({
                group_id: groupId
            })
        }
    )
    .then(async response => {

        let data = {};

        try {
            data = await response.json();
        } catch (error) {

            console.error(
                'Group response was not JSON.'
            );
        }

        console.log(
            'GROUP OPEN RESPONSE:',
            response.status,
            data
        );

        if (!response.ok) {

            throw new Error(
                data.message ||
                `Group open failed (${response.status})`
            );
        }

        return data;
    })
    .then(data => {

        /*
         * Server can return group_id.
         */
        selectedGroup =
            Number(data.group_id ?? groupId);

        currentGroupName =
            data.group_name ?? groupName;

        /*
         * Clear loading
         */
        clearChatBox();

        /*
         * Render old messages
         */
        if (Array.isArray(data.messages)) {

            data.messages.forEach(
                message => {
                    showMessage(message);
                }
            );
        }

        /*
         * Connect WebSocket
         */
        startGroupWebsocket(
            selectedGroup
        );

        /*
         * Optional fallback polling.
         *
         * Keep this temporarily while debugging.
         */
        startGroupPolling(
            selectedGroup
        );

        const status =
            document.getElementById(
                'groupStatus'
            );

        if (status) {
            status.textContent =
                'Group chat • Connected';
        }

        const input =
            document.getElementById(
                'messageInput'
            );

        if (input) {
            input.focus();
        }

    })
    .catch(error => {

        console.error(
            'GROUP CHAT ERROR:',
            error
        );

        const box =
            document.getElementById(
                'chatBox'
            );

        if (box) {

            box.innerHTML = `

                <div class="chat-error">

                    ❌ ${escapeHtml(
                        error.message
                    )}

                </div>

            `;
        }
    });
}

/* =========================================================
   LEAVE GROUP CHANNEL
========================================================= */

function leaveGroupChannel()
{
    if (
        typeof Echo !== 'undefined' &&
        groupChannel
    ) {

        const channelName =
            'group-chat.' + groupChannel;

        console.log(
            'Leaving group channel:',
            channelName
        );

        try {
            Echo.leave(channelName);
        } catch (error) {
            console.warn(
                'Could not leave group channel:',
                error
            );
        }
    }

    groupChannel = null;
}


/* =========================================================
   OPEN PRIVATE CHAT
========================================================= */

function openChat(id, name, number_id)
{
    stopGroupPolling();

    leaveGroupChannel();

    leavePrivateChannel();

    selectedUser = Number(id);

    selectedGroup = null;

    selectedChat = null;

    currentGroupName = null;

    renderedMessageIds.clear();


    const chatArea =
        document.getElementById('chatArea');

    if (!chatArea) {
        return;
    }

    chatArea.classList.add('active');

  
    chatArea.innerHTML = `

        <div class="chat-header">

            <button
                type="button"
                class="chat-back"
                onclick="closeMobileChat()"
            >
                ←
            </button>
                   <button
                type="button"
                class="chat-header-avatar"
                onclick="openProfile()"
            >
                👤
            </button>
            <div class="chat-header-info">

                <div class="chat-header-title">
                    ${escapeHtml(name)}
                </div>

                <div class="chat-header-status">
                    Private chat
                </div>

            </div>

        </div>


        <div
            class="chat-box"
            id="chatBox"
        >

            <div class="chat-loading">
                Opening chat...
            </div>

        </div>


        <div class="chat-input">

            <input
                type="text"
                id="messageInput"
                placeholder="Type message..."
                autocomplete="off"
            >

            <button
                type="button"
                onclick="sendMessage()"
            >
                Send
            </button>

        </div>

    `;
function openProfile()
{
    const profileUrl = "{{ route('attibutes', ['id' => '__ID__']) }}"
        .replace('__ID__', selectedUser);

    window.location.href = profileUrl;
}

    /*
     * Add friend / open private chat.
     */

    fetch("{{ route('addfriend') }}", {

        method: 'POST',

        headers: {

            'Content-Type':
                'application/json',

            'X-CSRF-TOKEN':
                csrfToken,

            'Accept':
                'application/json'

        },

        body: JSON.stringify({

            user_id:
                "{{ Auth::id() }}",

            id_number:
                number_id

        })

    })

    .then(async response => {

        let data = {};

        try {
            data = await response.json();
        } catch (error) {}

        if (!response.ok) {

            throw new Error(
                data.message ||
                `Add friend failed (${response.status})`
            );

        }

        return data;

    })

    .then(() => {

        return fetch(
            '/open-chat',
            {

                method: 'POST',

                headers: {

                    'Content-Type':
                        'application/json',

                    'X-CSRF-TOKEN':
                        csrfToken,

                    'Accept':
                        'application/json'

                },

                body: JSON.stringify({

                    friend_id:
                        id

                })

            }
        );

    })

    .then(async response => {

        let data = {};

        try {
            data = await response.json();
        } catch (error) {}

        if (!response.ok) {

            throw new Error(
                data.message ||
                `Unable to open chat (${response.status})`
            );

        }

        return data;

    })

    .then(data => {

        selectedChat =
            data.chat_id ?? null;

        clearChatBox();


        if (Array.isArray(data.messages)) {

            data.messages.forEach(
                message => {

                    showMessage(message);

                }
            );

        }


        if (selectedChat) {

            startPrivateWebsocket(
                selectedChat
            );

        }


        const input =
            document.getElementById(
                'messageInput'
            );

        if (input) {
            input.focus();
        }

    })

    .catch(error => {

        console.error(
            'Private chat error:',
            error
        );

        const box =
            document.getElementById(
                'chatBox'
            );

        if (box) {

            box.innerHTML = `

                <div class="chat-error">

                    ${escapeHtml(
                        error.message
                    )}

                </div>

            `;

        }

    });
}


/* =========================================================
   SEND PRIVATE MESSAGE
========================================================= */

function sendMessage()
{
    const input =
        document.getElementById(
            'messageInput'
        );

    if (!input) {
        return;
    }

    const text =
        input.value.trim();

    if (!text) {
        return;
    }

    if (!selectedUser) {
        return;
    }

    input.disabled = true;


    fetch(
        '/send-message',
        {

            method: 'POST',

            headers: {

                'Content-Type':
                    'application/json',

                'X-CSRF-TOKEN':
                    csrfToken,

                'Accept':
                    'application/json'

            },

            body: JSON.stringify({

                friend_id:
                    selectedUser,

                message:
                    text

            })

        }
    )

    .then(async response => {

        let data = {};

        try {
            data = await response.json();
        } catch (error) {}

        if (!response.ok) {

            throw new Error(
                data.message ||
                'Unable to send message.'
            );

        }

        return data;

    })

    .then(data => {

        if (data.message) {

            showMessage(
                data.message
            );

        }

        input.value = '';

    })

    .catch(error => {

        console.error(
            'Send private message error:',
            error
        );

    })

    .finally(() => {

        input.disabled = false;

        input.focus();

    });
}


/* =========================================================
   OPEN GROUP CHAT
========================================================= */

function openGroupChat(groupId, groupName)
{
    groupId = Number(groupId);

    if (!groupId) {

        console.error(
            'Invalid group ID'
        );

        return;
    }


    console.log(
        'Opening group:',
        groupId,
        groupName
    );


    /* =====================================================
       STOP OLD CHAT
    ===================================================== */

    stopGroupPolling();

    leavePrivateChannel();

    leaveGroupChannel();


    /* =====================================================
       STATE
    ===================================================== */

    selectedUser = null;

    selectedGroup = groupId;

    selectedChat = null;

    currentGroupName = groupName;

    renderedMessageIds.clear();


    /* =====================================================
       CHAT AREA
    ===================================================== */

    const chatArea =
        document.getElementById(
            'chatArea'
        );

    if (!chatArea) {
        return;
    }

    chatArea.classList.add('active');


    /* =====================================================
       EDIT URL
    ===================================================== */

    const editUrl =
        "{{ route('group.edit', [
            'id' => '__ID__',
            'group_name' => '__GROUP__'
        ]) }}"
        .replace(
            '__ID__',
            encodeURIComponent(groupId)
        )
        .replace(
            '__GROUP__',
            encodeURIComponent(groupName)
        );


    /* =====================================================
       GROUP CHAT HTML
    ===================================================== */

    chatArea.innerHTML = `

        <div class="chat-header">

            <button
                type="button"
                class="chat-back"
                onclick="closeMobileChat()"
            >
                ←
            </button>

            <div class="chat-header-avatar">
                👥
            </div>

            <div class="chat-header-info">

                <div class="chat-header-title">
                    ${escapeHtml(groupName)}
                </div>

                <div
                    class="chat-header-status"
                    id="groupStatus"
                >
                    Group chat
                </div>

            </div>


            <a
                href="${editUrl}"
                class="group-edit-button"
            >
                Edit
            </a>

        </div>


        <div
            class="chat-box"
            id="chatBox"
        >

            <div class="chat-loading">
                Loading group chat...
            </div>

        </div>


        <div class="chat-input">

            <input
                type="text"
                id="messageInput"
                placeholder="Type group message..."
                autocomplete="off"
            >

            <button
                type="button"
                onclick="sendGroupMessage()"
            >
                Send
            </button>

        </div>

    `;


    /* =====================================================
       OPEN GROUP ON SERVER
    ===================================================== */

    fetch(
        "{{ route('group.open') }}",
        {

            method: 'POST',

            headers: {

                'Content-Type':
                    'application/json',

                'X-CSRF-TOKEN':
                    csrfToken,

                'Accept':
                    'application/json'

            },

          body: JSON.stringify({
    group_id: groupId
})

        }
    )

    .then(async response => {

        let data = {};

        try {

            data =
                await response.json();

        } catch (error) {

            console.error(
                'Group response is not JSON'
            );

        }


        console.log(
            'GROUP OPEN:',
            response.status,
            data
        );


        if (!response.ok) {

            throw new Error(

                data.message ||
                `Group request failed: ${response.status}`

            );

        }

        return data;

    })

    .then(data => {

        if (data.success === false) {

            throw new Error(

                data.message ||
                'Unable to open group.'

            );

        }


        /*
         * Make sure the selected group is
         * the group returned by Laravel.
         */

        selectedGroup =
            Number(
                data.group_id ??
                groupId
            );


        currentGroupName =
            data.group_name ??
            groupName;


        selectedChat =
            selectedGroup;


        clearChatBox();


        /*
         * LOAD ALL EXISTING GROUP MESSAGES
         */

        if (Array.isArray(data.messages)) {

            data.messages.forEach(
                message => {

                    showMessage(
                        message
                    );

                }
            );

        }


        /*
         * WEBSOCKET
         */

        startGroupWebsocket(
            selectedGroup
        );


        /*
         * FALLBACK POLLING
         *
         * This is important.
         *
         * Even if WebSocket does not deliver
         * the event to another member, this
         * reloads messages from Laravel.
         */

        startGroupPolling(
            selectedGroup
        );


        const input =
            document.getElementById(
                'messageInput'
            );

        if (input) {

            input.focus();

        }

    })

    .catch(error => {

        console.error(
            'GROUP CHAT ERROR:',
            error
        );


        const box =
            document.getElementById(
                'chatBox'
            );

        if (box) {

            box.innerHTML = `

                <div class="chat-error">

                    ❌ ${escapeHtml(
                        error.message
                    )}

                </div>

            `;

        }

    });
}


/* =========================================================
   GROUP POLLING FALLBACK
========================================================= */

function startGroupPolling(groupId)
{
    stopGroupPolling();

    groupId = Number(groupId);

    if (!groupId) {
        return;
    }


    /*
     * Check immediately.
     */

    refreshGroupMessages(
        groupId,
        false
    );


    /*
     * Then every 2 seconds.
     */

    groupPollTimer =
        setInterval(
            function() {

                if (
                    !selectedGroup ||
                    Number(selectedGroup) !== groupId
                ) {

                    stopGroupPolling();

                    return;

                }


                refreshGroupMessages(
                    groupId,
                    true
                );

            },
            2000
        );
}


/* =========================================================
   REFRESH GROUP MESSAGES
========================================================= */

function refreshGroupMessages(
    groupId,
    silent = true
)
{
    if (!groupId) {
        return;
    }


    fetch(
        "{{ route('group.open') }}",
        {

            method: 'POST',

            headers: {

                'Content-Type':
                    'application/json',

                'X-CSRF-TOKEN':
                    csrfToken,

                'Accept':
                    'application/json'

            },

            body: JSON.stringify({

                group_id:
                    Number(groupId),

                group_name:
                    currentGroupName

            })

        }
    )

    .then(async response => {

        if (!response.ok) {
            throw new Error(
                'Unable to refresh group messages.'
            );
        }

        return await response.json();

    })

    .then(data => {

        /*
         * Ignore if user switched to another group.
         */

        if (
            !selectedGroup ||
            Number(selectedGroup) !== Number(groupId)
        ) {

            return;

        }


        if (
            !Array.isArray(data.messages)
        ) {

            return;

        }


        /*
         * IMPORTANT:
         *
         * showMessage() has duplicate protection.
         */

        data.messages.forEach(
            message => {

                showMessage(
                    message
                );

            }
        );


        const status =
            document.getElementById(
                'groupStatus'
            );

        if (status) {

            status.textContent =
                'Group chat • Connected';

        }

    })

    .catch(error => {

        if (!silent) {

            console.error(
                'Group refresh error:',
                error
            );

        }

        const status =
            document.getElementById(
                'groupStatus'
            );

        if (status) {

            status.textContent =
                'Group chat • Checking connection...';

        }

    });
}


/* =========================================================
   SEND GROUP MESSAGE
========================================================= */

function sendGroupMessage()
{
    const input =
        document.getElementById(
            'messageInput'
        );

    if (!input) {
        return;
    }


    const text =
        input.value.trim();


    if (!text) {
        return;
    }


    if (!selectedGroup) {

        console.error(
            'No group selected.'
        );

        return;
    }


    input.disabled = true;


    fetch(
        "{{ route('group.send') }}",
        {

            method: 'POST',

            headers: {

                'Content-Type':
                    'application/json',

                'X-CSRF-TOKEN':
                    csrfToken,

                'Accept':
                    'application/json'

            },

            body: JSON.stringify({

                group_id:
                    Number(selectedGroup),

                group_name:
                    currentGroupName,

                message:
                    text

            })

        }
    )

    .then(async response => {

        let data = {};

        try {

            data =
                await response.json();

        } catch (error) {

            console.error(
                'Group send response is not JSON'
            );

        }


        if (!response.ok) {

            throw new Error(

                data.message ||
                'Unable to send group message.'

            );

        }


        return data;

    })

    .then(data => {

        console.log(
            'GROUP SEND RESPONSE:',
            data
        );


        /*
         * We can display the returned message
         * immediately.
         *
         * Duplicate protection prevents the
         * WebSocket/polling copy from appearing
         * twice.
         */

        if (
            data.success &&
            data.message
        ) {

            showMessage(
                data.message
            );

        }


        input.value = '';


        /*
         * Immediately refresh once.
         */

        refreshGroupMessages(
            selectedGroup,
            true
        );

    })

    .catch(error => {

        console.error(
            'Send group message error:',
            error
        );


        alert(
            error.message
        );

    })

    .finally(() => {

        input.disabled = false;

        input.focus();

    });
}


/* =========================================================
   PRIVATE WEBSOCKET
========================================================= */

function startPrivateWebsocket(chatId, retryCount = 0)
{
    if (typeof Echo === 'undefined') {
        if (retryCount < 10) {
            console.warn(`Laravel Echo initializing, retrying private websocket connection (${retryCount + 1}/10)...`);
            setTimeout(() => startPrivateWebsocket(chatId, retryCount + 1), 250);
            return;
        }

        console.warn('Laravel Echo is not loaded.');
        return;
    }


    leavePrivateChannel();


    privateChannel =
        Number(chatId);


    Echo
        .private(
            'chat.' + privateChannel
        )

        .listen(
            '.message.sent',
            event => {

                console.log(
                    'Private websocket:',
                    event
                );


                if (
                    event.message
                ) {

                    showMessage(
                        event.message
                    );

                }

            }
        );
}


/* =========================================================
   GROUP WEBSOCKET
========================================================= */

function startGroupWebsocket(groupId, retryCount = 0)
{
    if (typeof Echo === 'undefined') {
        if (retryCount < 10) {
            console.warn(`Laravel Echo initializing, retrying group websocket connection (${retryCount + 1}/10)...`);
            setTimeout(() => startGroupWebsocket(groupId, retryCount + 1), 250);
            return;
        }

        console.error('Laravel Echo is NOT loaded.');

        const status = document.getElementById('groupStatus');

        if (status) {
            status.textContent = 'Group chat • WebSocket unavailable';
        }

        return;
    }

    groupId = Number(groupId);

    if (!groupId) {
        console.error('Invalid group ID:', groupId);
        return;
    }

    leaveGroupChannel();

    groupChannel = groupId;

    const channelName = 'group-chat.' + groupId;

    console.log(
        'Joining private group channel:',
        channelName
    );

    try {

        const channel = Echo.private(channelName);

        channel
            .listen(
                '.group.message.sent',
                function (event) {

                    console.log(
                        'GROUP MESSAGE RECEIVED:',
                        event
                    );

                    if (!event || !event.message) {
                        console.warn(
                            'Group event has no message:',
                            event
                        );

                        return;
                    }

                    const message = event.message;

                    /*
                     * Make sure this message belongs
                     * to the currently opened group.
                     */
                    if (
                        message.group_id &&
                        Number(message.group_id) !==
                        Number(selectedGroup)
                    ) {
                        return;
                    }

                    showMessage(message);

                    const status =
                        document.getElementById('groupStatus');

                    if (status) {
                        status.textContent =
                            'Group chat • Connected';
                    }
                }
            );

        /*
         * Echo/Pusher subscription debugging.
         */
        if (channel.subscribed) {
            console.log(
                'Already subscribed to:',
                channelName
            );
        }

        /*
         * Pusher channel object can expose
         * subscription errors.
         */
        if (channel.subscription) {

            channel.subscription.bind(
                'pusher:subscription_error',
                function (status) {

                    console.error(
                        'GROUP CHANNEL SUBSCRIPTION ERROR:',
                        status
                    );

                    const statusElement =
                        document.getElementById(
                            'groupStatus'
                        );

                    if (statusElement) {
                        statusElement.textContent =
                            'Group chat • Authorization failed';
                    }
                }
            );

            channel.subscription.bind(
                'pusher:subscription_succeeded',
                function () {

                    console.log(
                        'GROUP CHANNEL CONNECTED:',
                        channelName
                    );

                    const statusElement =
                        document.getElementById(
                            'groupStatus'
                        );

                    if (statusElement) {
                        statusElement.textContent =
                            'Group chat • Connected';
                    }
                }
            );
        }

    } catch (error) {

        console.error(
            'Unable to join group channel:',
            error
        );
    }
}

/* =========================================================
   GET MESSAGE ID
========================================================= */

function getMessageUniqueId(message)
{
    /*
     * Best option: database message ID.
     */

    if (
        message.id !== undefined &&
        message.id !== null
    ) {

        return 'id-' + message.id;

    }


    /*
     * Fallback for APIs that don't return ID.
     */

    return [

        message.group_id ?? '',
        message.user_id ?? '',
        message.message ?? '',
        message.created_at ?? ''

    ].join('|');
}


/* =========================================================
   DISPLAY MESSAGE
========================================================= */

function showMessage(message)
{
    const box =
        getChatBox();


    if (!box) {
        return;
    }


    /*
     * Remove loading.
     */

    const loading =
        box.querySelector(
            '.chat-loading'
        );


    if (loading) {
        loading.remove();
    }


    /*
     * GROUP FILTER
     */

    if (
        selectedGroup &&
        message.group_id &&
        Number(message.group_id) !==
        Number(selectedGroup)
    ) {

        return;

    }


    /*
     * PRIVATE CHAT FILTER
     */

    if (
        !selectedGroup &&
        selectedChat &&
        message.chat_id &&
        Number(message.chat_id) !==
        Number(selectedChat)
    ) {

        return;

    }


    /*
     * DUPLICATE PROTECTION
     */

    const uniqueId =
        getMessageUniqueId(
            message
        );


    if (
        renderedMessageIds.has(
            uniqueId
        )
    ) {

        return;

    }


    renderedMessageIds.add(
        uniqueId
    );


    /*
     * USER ID
     */

    const messageUserId =
        Number(
            message.user_id
        );


    /*
     * CURRENT USER
     */

    const mine =
        messageUserId ===
        MY_USER_ID;


    /*
     * TEXT
     */

    const messageText =
        message.message ?? '';


    /*
     * USER NAME
     */

    const username =
        message.user?.name ??
        message.user_name ??
        message.name ??
        'User';


    /*
     * MESSAGE DIV
     */

    const messageDiv =
        document.createElement(
            'div'
        );


    messageDiv.className =
        mine
            ? 'message message-mine'
            : 'message message-other';


    /*
     * GROUP SENDER NAME
     *
     * Show the name for everyone except
     * the person who sent the message.
     */

    let userHtml = '';


    if (
        selectedGroup &&
        !mine
    ) {

        userHtml = `

            <div class="message-user">

                ${escapeHtml(
                    username
                )}

            </div>

        `;

    }


    messageDiv.innerHTML = `

        ${userHtml}

        <div class="message-text">

            ${escapeHtml(
                messageText
            )}

        </div>

    `;


    /*
     * Append.
     */

    box.appendChild(
        messageDiv
    );


    /*
     * Scroll.
     */

    box.scrollTop =
        box.scrollHeight;
}


/* =========================================================
   ENTER KEY
========================================================= */

document.addEventListener(
    'keydown',
    function(event)
    {

        if (
            event.key !== 'Enter' ||
            event.shiftKey
        ) {

            return;

        }


        const input =
            document.getElementById(
                'messageInput'
            );


        if (
            !input ||
            document.activeElement !== input
        ) {

            return;

        }


        event.preventDefault();


        /*
         * GROUP
         */

        if (selectedGroup) {

            sendGroupMessage();

            return;

        }


        /*
         * PRIVATE
         */

        if (selectedUser) {

            sendMessage();

        }

    }
);


/* =========================================================
   DEBUG
========================================================= */

console.log(
    'Chat script loaded.'
);

console.log(
    'Current user ID:',
    MY_USER_ID
);

</script>

</body>
</html>