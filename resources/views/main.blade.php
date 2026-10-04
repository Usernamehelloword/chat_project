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
            height: 100dvh;
            overscroll-behavior: none;
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
           SIDEBAR & OVERLAY
        ========================================================= */

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            height: 100dvh;
            background: rgba(0,0,0,.45);
            backdrop-filter: blur(3px);
            z-index: 2400;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .sidebar {
            position: fixed;

            left: -320px;
            top: 0;

            width: 290px;
            max-width: 85vw;
            height: 100vh;
            height: 100dvh;

            padding: max(80px, calc(env(safe-area-inset-top, 0px) + 65px)) 20px 25px;

            background:
                linear-gradient(
                    180deg,
                    rgba(211, 117, 117, .98),
                    rgba(177, 86, 86, .98)
                );

            color: white;

            z-index: 2500;

            transition: .35s cubic-bezier(.4, 0, .2, 1);

            box-shadow:
                10px 0 35px rgba(0,0,0,.25);

            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
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
            height: 100dvh;

            display: flex;

            gap: 15px;

            padding: 15px;
            box-sizing: border-box;
        }


        /* =========================================================
           LEFT
        ========================================================= */

        .left {
            width: 360px;

            height: 100%;

            padding: 70px 15px 15px;

            display: flex;

            flex-direction: column;

            min-width: 0;
            box-sizing: border-box;
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

            height: 100%;

            min-width: 0;

            padding-top: 5px;

            display: flex;

            flex-direction: column;
            box-sizing: border-box;
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
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
            max-width: 78%;
            animation: messageIn .25s ease;
        }

        .message-other {
            align-self: flex-start;
            align-items: flex-start;
        }

        .message-mine {
            align-self: flex-end;
            align-items: flex-end;
        }

        .message-user {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 3px;
            margin-left: 2px;
            color: #743737;
            opacity: .85;
        }

        .message-bubble {
            padding: 7px 12px;
            border-radius: 16px;
            color: white;
            box-shadow: 0 3px 8px rgba(0,0,0,.08);
            word-break: break-word;
            display: inline-block;
            width: fit-content;
            max-width: 100%;
        }

        .message-bubble-mine {
            background:
                linear-gradient(
                    135deg,
                    #ad5a5a,
                    #c66f6f
                );
            border-bottom-right-radius: 4px;
        }

        .message-bubble-other {
            background: #c97575;
            border-bottom-left-radius: 4px;
        }

        .message-text {
            font-size: 13.5px;
            line-height: 1.35;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .message-below {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 3px;
            padding: 0 2px;
        }

        .message-below-mine {
            justify-content: flex-end;
        }

        .message-below-other {
            justify-content: flex-start;
        }

        .message-time {
            font-size: 10px;
            color: #8c5757;
            opacity: 0.75;
            white-space: nowrap;
        }

        .message-avatar-mini {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid white;
            box-shadow: 0 1px 4px rgba(0,0,0,.15);
            flex-shrink: 0;
        }

        .message-avatar-mini-default {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #b96464;
            color: white;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid white;
            box-shadow: 0 1px 4px rgba(0,0,0,.15);
            flex-shrink: 0;
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


        .group-delete-btn {
            padding: 4px 8px;
            border-radius: 8px;
            border: none;
            background: rgba(120, 20, 20, .35);
            color: white;
            font-size: 11px;
            font-weight: bold;
            cursor: pointer;
            transition: .2s;
            white-space: nowrap;
        }

        .group-delete-btn:hover {
            background: #8e3f3f;
        }


        /* =========================================================
           RESPONSIVE DESIGN (TABLET & MOBILE)
        ========================================================= */

        @media (max-width: 992px) {
            .container {
                gap: 10px;
                padding: 10px;
            }

            .left {
                width: 320px;
                padding-top: 65px;
            }
        }

        @media (max-width: 768px) {
            body {
                overflow: hidden;
            }

            .container {
                display: flex;
                flex-direction: column;
                padding: 0;
                height: 100%;
                height: 100vh;
                height: 100dvh;
                position: relative;
            }

            .left {
                width: 100%;
                height: 100%;
                height: 100vh;
                height: 100dvh;
                padding: max(72px, calc(env(safe-area-inset-top, 0px) + 56px)) 12px max(15px, env(safe-area-inset-bottom, 0px));
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* Hide left list and menu button when chat is open on mobile */
            body.chat-open .left {
                display: none !important;
            }

            body.chat-open .menu-btn {
                display: none !important;
            }

            .menu-btn {
                top: max(14px, env(safe-area-inset-top, 0px));
                left: 14px;
                width: 44px;
                height: 44px;
                font-size: 22px;
                border-radius: 13px;
            }

            .search-area {
                margin-bottom: 12px;
            }

            .search-area form {
                gap: 6px;
            }

            .search-area input {
                height: 42px;
                font-size: 16px; /* Prevents iOS auto-zoom */
                border-radius: 12px;
            }

            .search-btn,
            .clear-btn {
                height: 42px;
                padding: 0 12px;
                font-size: 13px;
                border-radius: 12px;
            }

            .panel {
                padding: 10px;
                border-radius: 16px;
                margin-bottom: 10px;
            }

            .friend-list {
                max-height: 45vh;
                min-height: 140px;
                flex: 1 1 auto;
            }

            .group-section {
                max-height: 45vh;
                min-height: 140px;
                flex: 1 1 auto;
                padding: 10px;
                border-radius: 16px;
            }

            .user-friends,
            .user-group {
                padding: 8px 10px;
                border-radius: 13px;
                gap: 8px;
            }

            .user-friends img,
            .friend-avatar,
            .group-icon {
                width: 42px;
                height: 42px;
                font-size: 18px;
            }

            .friend-name,
            .group-name {
                font-size: 13.5px;
            }

            .friend-actions {
                display: flex;
                gap: 4px;
            }

            .action-btn {
                width: 30px;
                height: 30px;
                font-size: 13px;
                border-radius: 8px;
            }

            /* Fullscreen Chat on Mobile */
            .right {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                width: 100%;
                height: 100%;
                height: 100vh;
                height: 100dvh;
                padding: max(8px, env(safe-area-inset-top, 0px)) 8px max(8px, env(safe-area-inset-bottom, 0px));
                background:
                    linear-gradient(
                        135deg,
                        #f1d3d3,
                        #d98686
                    );
                z-index: 2000;
                display: none;
                flex-direction: column;
                box-sizing: border-box;
            }

            .right.active {
                display: flex;
            }

            .chat-header {
                min-height: 58px;
                padding: 8px 12px;
                gap: 10px;
                border-radius: 14px;
            }

            .chat-back {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
                font-size: 18px;
                border-radius: 10px;
                flex-shrink: 0;
            }

            .chat-header-avatar {
                width: 38px;
                height: 38px;
                font-size: 17px;
            }

            .chat-header-title {
                font-size: 15px;
            }

            .chat-header-status {
                font-size: 10.5px;
            }

            .group-edit-button {
                padding: 6px 10px;
                font-size: 11px;
                border-radius: 10px;
            }

            .chat-box {
                padding: 12px 10px;
                margin-top: 8px;
                border-radius: 16px;
            }

            .message {
                max-width: 86%;
                padding: 8px 12px;
                border-radius: 15px;
                font-size: 13.5px;
            }

            .message-text {
                font-size: 13.5px;
            }

            .chat-input {
                margin-top: 8px;
                gap: 8px;
            }

            .chat-input input {
                height: 44px;
                padding: 0 15px;
                font-size: 16px; /* Prevents auto zoom */
                border-radius: 22px;
            }

            .chat-input button {
                width: 72px;
                height: 44px;
                font-size: 13px;
                border-radius: 22px;
            }
        }

        @media (max-width: 400px) {
            .left {
                padding-left: 8px;
                padding-right: 8px;
            }

            .action-btn {
                width: 26px;
                height: 26px;
                font-size: 11px;
            }

            .search-btn,
            .clear-btn {
                padding: 0 9px;
                font-size: 12px;
            }

            .chat-header-title {
                font-size: 14px;
            }

            .message {
                max-width: 90%;
            }
        }

        /* =========================================================
           PROFILE MODAL
        ========================================================= */

        .profile-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 3000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 0.2s ease;
        }

        .profile-modal-overlay.active {
            display: flex;
        }

        .profile-modal-card {
            position: relative;
            width: 100%;
            max-width: 380px;
            background: linear-gradient(145deg, #ffffff, #fdf5f5);
            border-radius: 24px;
            padding: 28px 24px 24px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
            text-align: center;
            animation: scaleIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-sizing: border-box;
        }

        .profile-modal-close {
            position: absolute;
            top: 14px;
            right: 16px;
            width: 32px;
            height: 32px;
            border: none;
            background: rgba(0, 0, 0, 0.06);
            border-radius: 50%;
            font-size: 20px;
            color: #666;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .profile-modal-close:hover {
            background: rgba(0, 0, 0, 0.12);
            color: #111;
        }

        .profile-modal-avatar-wrap {
            width: 100px;
            height: 100px;
            margin: 0 auto 14px;
            position: relative;
        }

        .profile-modal-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 8px 20px rgba(217, 134, 134, 0.35);
        }

        .profile-modal-avatar-default {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #d98686, #bd6262);
            color: white;
            font-size: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid #fff;
            box-shadow: 0 8px 20px rgba(217, 134, 134, 0.35);
        }

        .profile-modal-name {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
        }

        .profile-modal-id {
            font-size: 12px;
            color: #888;
            margin-bottom: 16px;
        }

        .profile-modal-divider {
            height: 1px;
            background: #eedede;
            margin: 14px 0;
        }

        .profile-modal-details {
            text-align: left;
            background: rgba(245, 225, 225, 0.35);
            border-radius: 14px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13.5px;
        }

        .profile-modal-row {
            display: flex;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .profile-modal-row:last-child {
            margin-bottom: 0;
        }

        .profile-modal-label {
            font-weight: bold;
            color: #7a3e3e;
            width: 75px;
            flex-shrink: 0;
        }

        .profile-modal-value {
            color: #444;
            word-break: break-word;
            flex: 1;
        }

        .profile-modal-actions {
            display: flex;
            gap: 10px;
        }

        .profile-modal-btn {
            flex: 1;
            padding: 11px 16px;
            border-radius: 20px;
            font-size: 13.5px;
            font-weight: bold;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: 0.2s;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .profile-modal-btn-primary {
            background: linear-gradient(135deg, #d98686, #bd6262);
            color: white;
            box-shadow: 0 4px 12px rgba(189, 98, 98, 0.3);
        }

        .profile-modal-btn-primary:hover {
            background: linear-gradient(135deg, #c76f6f, #aa5252);
            transform: translateY(-1px);
        }

        .profile-modal-btn-secondary {
            background: #eee;
            color: #555;
        }

        .profile-modal-btn-secondary:hover {
            background: #e2e2e2;
            color: #222;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.92);
            }
            to {
                opacity: 1;
                transform: scale(1);
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

        @php
            $myRawImage = $user->profile?->image ?? $profile?->image ?? null;
            $myAvatarUrl = null;
            if ($myRawImage) {
                $myAvatarUrl = str_starts_with($myRawImage, 'http')
                    ? $myRawImage
                    : '/storage/' . ltrim($myRawImage, '/');
            }
        @endphp

        @if($myAvatarUrl)

            <img
                src="{{ $myAvatarUrl }}"
                class="sidebar-avatar"
                alt="Profile"
                onerror="this.onerror=null;this.replaceWith(document.createRange().createContextualFragment('<div class=\'sidebar-default-avatar\'>👤</div>'))"
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

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>


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

                            @php
                                $fRaw = $item->friend->profile?->image ?? null;
                                $fImg = $fRaw ? (str_starts_with($fRaw, 'http') ? $fRaw : '/storage/' . ltrim($fRaw, '/')) : null;
                            @endphp
                            <div
                                class="friend-click"
                                onclick="openChat(
                                    '{{ $item->friend->id }}',
                                    @js($item->friend->name),
                                    '{{ $item->friend->number_id }}',
                                    @js($fImg)
                                )"
                            >

                                @if($fImg)

                                    <img
                                        src="{{ $fImg }}"
                                        alt="Friend"
                                        onerror="this.onerror=null;this.replaceWith(document.createRange().createContextualFragment('<div class=\'friend-avatar\'>👤</div>'))"
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

                            @php
                                $uRaw = $item->user->profile?->image ?? null;
                                $uImg = $uRaw ? (str_starts_with($uRaw, 'http') ? $uRaw : '/storage/' . ltrim($uRaw, '/')) : null;
                            @endphp
                            <div
                                class="friend-click"
                                onclick="openChat(
                                    '{{ $item->user->id }}',
                                    @js($item->user->name),
                                    '{{ $item->user->number_id }}',
                                    @js($uImg)
                                )"
                            >

                                @if($uImg)

                                    <img
                                        src="{{ $uImg }}"
                                        alt="Friend"
                                        onerror="this.onerror=null;this.replaceWith(document.createRange().createContextualFragment('<div class=\'friend-avatar\'>👤</div>'))"
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
        onclick="event.stopPropagation()"
        onsubmit="return confirm('Are you sure you want to delete this group?')"
    >
        @csrf
        @method('DELETE')

        <button type="submit" class="group-delete-btn">
            Delete
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

                    @php
                        $sRaw = $searchUser->profile?->image ?? null;
                        $sImg = $sRaw ? (str_starts_with($sRaw, 'http') ? $sRaw : '/storage/' . ltrim($sRaw, '/')) : null;
                    @endphp
                    <div
                        class="user-card"
                        onclick="openChat(
                            '{{ $searchUser->id }}',
                            @js($searchUser->name),
                            '{{ $searchUser->number_id }}',
                            @js($sImg)
                        )"
                    >

                        @if($sImg)

                            <img
                                src="{{ $sImg }}"
                                alt="User"
                                onerror="this.onerror=null;this.replaceWith(document.createRange().createContextualFragment('<div class=\'friend-avatar\'>👤</div>'))"
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

<!-- =====================================================
     PROFILE INFO MODAL
====================================================== -->
<div id="profileModal" class="profile-modal-overlay" onclick="closeProfileModal(event)">
    <div class="profile-modal-card" onclick="event.stopPropagation()">
        <button type="button" class="profile-modal-close" onclick="closeProfileModal()">&times;</button>
        <div class="profile-modal-avatar-wrap">
            <img id="modalProfileImg" src="" alt="Profile Image" class="profile-modal-avatar" style="display:none;">
            <div id="modalProfileDefault" class="profile-modal-avatar-default">👤</div>
        </div>
        <h3 id="modalProfileName" class="profile-modal-name">User</h3>
        <p id="modalProfileId" class="profile-modal-id">ID: -</p>
        <div class="profile-modal-divider"></div>
        <div class="profile-modal-details">
            <div class="profile-modal-row">
                <span class="profile-modal-label">Email:</span>
                <span id="modalProfileEmail" class="profile-modal-value">-</span>
            </div>
            <div class="profile-modal-row">
                <span class="profile-modal-label">Gender:</span>
                <span id="modalProfileGender" class="profile-modal-value">Not set</span>
            </div>
            <div class="profile-modal-row">
                <span class="profile-modal-label">Bio:</span>
                <span id="modalProfileDesc" class="profile-modal-value">No description</span>
            </div>
        </div>
        <div class="profile-modal-actions">
            <a id="modalFullProfileBtn" href="#" class="profile-modal-btn profile-modal-btn-primary">View Full Profile</a>
            <button type="button" class="profile-modal-btn profile-modal-btn-secondary" onclick="closeProfileModal()">Close</button>
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
const CURRENT_USER_AVATAR = @js($myAvatarUrl);
const CURRENT_USER_NAME = @js($user->name);
const STORAGE_URL = '/storage';
let currentFriendAvatar = null;
let currentFriendName = null;
let currentFriendNumberId = null;
let currentFriendData = null;

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


function formatMessageTime(dateString)
{
    if (!dateString) {
        const now = new Date();
        return now.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
    }

    try {
        const d = new Date(dateString);
        if (isNaN(d.getTime())) {
            return '';
        }
        return d.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
    } catch (e) {
        return '';
    }
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
   SIDEBAR & MOBILE NAVIGATION
========================================================= */

function toggleSidebar()
{
    const sidebar =
        document.getElementById('sidebar');
    const overlay =
        document.getElementById('sidebarOverlay');

    if (sidebar) {
        sidebar.classList.toggle('active');
    }
    if (overlay) {
        overlay.classList.toggle('active');
    }
}

function closeMobileChat()
{
    const chatArea =
        document.getElementById('chatArea');

    if (chatArea) {
        chatArea.classList.remove('active');
        chatArea.innerHTML = `
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
        `;
    }

    document.body.classList.remove('chat-open');

    stopGroupPolling();
    leaveGroupChannel();
    leavePrivateChannel();

    selectedUser = null;
    selectedGroup = null;
    selectedChat = null;
    currentGroupName = null;
    currentFriendAvatar = null;
    currentFriendName = null;
    currentFriendNumberId = null;
    currentFriendData = null;
    closeProfileModal();
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
    document.body.classList.add('chat-open');

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

function openChat(id, name, number_id, avatarUrl = null)
{
    stopGroupPolling();

    leaveGroupChannel();

    leavePrivateChannel();

    selectedUser = Number(id);
    currentFriendName = name;
    currentFriendNumberId = number_id;
    currentFriendAvatar = avatarUrl || null;
    currentFriendData = null;

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
    document.body.classList.add('chat-open');

    const headerAvatar = avatarUrl
        ? `<img src="${avatarUrl}" class="chat-header-avatar" style="object-fit:cover;cursor:pointer;" onclick="openProfile(event)" alt="${escapeHtml(name)}" onerror="this.onerror=null;this.replaceWith(document.createRange().createContextualFragment('<button type=\\'button\\' class=\\'chat-header-avatar\\' onclick=\\'openProfile(event)\\'>👤</button>'))">`
        : `<button type="button" class="chat-header-avatar" onclick="openProfile(event)">👤</button>`;

    chatArea.innerHTML = `

        <div class="chat-header" onclick="openProfile(event)" style="cursor:pointer;" title="Tap to view profile">

            <button
                type="button"
                class="chat-back"
                onclick="event.stopPropagation(); closeMobileChat();"
            >
                ←
            </button>
            ${headerAvatar}
            <div class="chat-header-info">

                <div class="chat-header-title">
                    ${escapeHtml(name)}
                </div>

                <div class="chat-header-status">
                    Private chat • Tap to view profile
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

function openProfile(event)
{
    if (event) {
        event.stopPropagation();
    }

    if (!selectedUser) {
        return;
    }

    showProfileModal();
}

function showProfileModal()
{
    const modal = document.getElementById('profileModal');
    if (!modal) return;

    const name = currentFriendData?.name || currentFriendName || 'Friend';
    const numberId = currentFriendData?.number_id || currentFriendNumberId || selectedUser;
    const email = currentFriendData?.email || 'Not available';
    
    let gender = 'Not set';
    const rawGender = currentFriendData?.profile?.gender;
    if (rawGender === 'M') gender = 'Male';
    else if (rawGender === 'F') gender = 'Female';
    else if (rawGender) gender = rawGender;

    const desc = currentFriendData?.profile?.description || 'No description provided.';
    
    let avatar = null;
    const rawImg = currentFriendData?.profile?.image;
    if (rawImg) {
        avatar = rawImg.startsWith('http')
            ? rawImg
            : '/storage/' + rawImg.replace(/^\/+/, '');
    } else {
        avatar = currentFriendAvatar;
    }

    document.getElementById('modalProfileName').textContent = name;
    document.getElementById('modalProfileId').textContent = 'ID: ' + numberId;
    document.getElementById('modalProfileEmail').textContent = email;
    document.getElementById('modalProfileGender').textContent = gender;
    document.getElementById('modalProfileDesc').textContent = desc;

    const img = document.getElementById('modalProfileImg');
    const placeholder = document.getElementById('modalProfileDefault');

    if (avatar) {
        img.src = avatar;
        img.style.display = 'block';
        placeholder.style.display = 'none';
        img.onerror = function() {
            img.style.display = 'none';
            placeholder.style.display = 'flex';
        };
    } else {
        img.style.display = 'none';
        placeholder.style.display = 'flex';
    }

    const fullPageBtn = document.getElementById('modalFullProfileBtn');
    if (fullPageBtn) {
        const fullUrl = "{{ route('attibutes', ['id' => '__ID__']) }}".replace('__ID__', selectedUser);
        fullPageBtn.href = fullUrl;
    }

    modal.classList.add('active');
}

function closeProfileModal(event)
{
    if (event && event.target !== event.currentTarget) {
        return;
    }
    const modal = document.getElementById('profileModal');
    if (modal) {
        modal.classList.remove('active');
    }
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

        if (data.friend) {
            currentFriendData = data.friend;
            if (data.friend.profile?.image) {
                currentFriendAvatar = data.friend.profile.image.startsWith('http')
                    ? data.friend.profile.image
                    : '/storage/' + data.friend.profile.image.replace(/^\/+/, '');
            }
        }

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
    document.body.classList.add('chat-open');


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
        (message.message ?? '').toString().trim();


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

        userHtml = `<div class="message-user">${escapeHtml(username)}</div>`;

    }

    let avatarSrc = null;
    if (mine) {
        const imgPath = message.user?.profile?.image;
        if (imgPath) {
            avatarSrc = imgPath.startsWith('http')
                ? imgPath
                : (STORAGE_URL + '/' + imgPath.replace(/^\/+/, ''));
        } else {
            avatarSrc = CURRENT_USER_AVATAR;
        }
    } else {
        const imgPath = message.user?.profile?.image;
        if (imgPath) {
            avatarSrc = imgPath.startsWith('http')
                ? imgPath
                : (STORAGE_URL + '/' + imgPath.replace(/^\/+/, ''));
        } else {
            avatarSrc = currentFriendAvatar;
        }
    }

    const avatarHtml = avatarSrc
        ? `<img src="${avatarSrc}" class="message-avatar-mini" alt="${escapeHtml(username)}" onerror="this.onerror=null;this.replaceWith(document.createRange().createContextualFragment('<div class=\\'message-avatar-mini-default\\'>👤</div>'))">`
        : `<div class="message-avatar-mini-default">👤</div>`;

    const timeString = formatMessageTime(message.created_at);
    const timeHtml = timeString
        ? `<span class="message-time">${escapeHtml(timeString)}</span>`
        : '';

    const belowHtml = mine
        ? `<div class="message-below message-below-mine">${timeHtml}${avatarHtml}</div>`
        : `<div class="message-below message-below-other">${avatarHtml}${timeHtml}</div>`;

    messageDiv.innerHTML = `${userHtml}<div class="message-bubble ${mine ? 'message-bubble-mine' : 'message-bubble-other'}"><div class="message-text">${escapeHtml(messageText)}</div></div>${belowHtml}`;


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

        if (event.key === 'Escape') {
            closeProfileModal();
            return;
        }

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