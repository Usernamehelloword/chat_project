<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Create Group</title>

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {

            min-height: 100vh;

            display: flex;

            align-items: center;
            justify-content: center;

            padding: 30px;

            background: linear-gradient(
                -45deg,
                #f1d3d3,
                #d98686,
                #e7bcbc,
                #f4dddd
            );

            background-size: 400% 400%;

            animation: bgMove 12s ease infinite;

            overflow-x: hidden;
        }

        @keyframes bgMove {

            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }

        }


        /* =========================
           BACK BUTTON
        ========================= */

        .back-btn {

            position: fixed;

            top: 20px;
            left: 20px;

            padding: 12px 20px;

            border-radius: 25px;

            background: rgba(217, 134, 134, 0.9);

            color: white;

            text-decoration: none;

            font-weight: bold;

            box-shadow:
                0 8px 20px rgba(0, 0, 0, 0.15);

            transition: 0.3s;

            z-index: 10;
        }

        .back-btn:hover {

            background: #c97878;

            transform: translateX(-3px);
        }


        /* =========================
           MAIN WRAPPER
        ========================= */

        .page {

            width: 100%;

            max-width: 1000px;

            min-height: 600px;

            display: flex;

            background:
                rgba(255, 255, 255, 0.18);

            backdrop-filter: blur(15px);

            -webkit-backdrop-filter: blur(15px);

            border-radius: 30px;

            overflow: hidden;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.20);

            border:
                1px solid rgba(255, 255, 255, 0.35);

            animation: pageIn 0.7s ease;
        }

        @keyframes pageIn {

            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }


        /* =========================
           LEFT DECORATION
        ========================= */

        .visual {

            width: 45%;

            min-height: 600px;

            padding: 50px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            text-align: center;

            color: white;

            background:
                linear-gradient(
                    145deg,
                    rgba(217, 134, 134, 0.95),
                    rgba(190, 105, 105, 0.75)
                );
        }


        .visual h1 {

            font-size: 38px;

            margin-bottom: 15px;

            text-shadow:
                0 5px 15px rgba(0, 0, 0, 0.15);
        }


        .visual p {

            font-size: 16px;

            line-height: 1.6;

            opacity: 0.9;

            max-width: 330px;
        }


        /* =========================
           GROUP IMAGE
        ========================= */

        .group-picture {

            width: 190px;
            height: 190px;

            border-radius: 50%;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 85px;

            margin-bottom: 30px;

            background:
                rgba(255, 255, 255, 0.25);

            border:
                7px solid white;

            box-shadow:
                0 15px 35px rgba(0, 0, 0, 0.2);

            transition: 0.4s;

            cursor: pointer;
        }

        .group-picture:hover {

            transform:
                scale(1.08)
                rotate(3deg);
        }


        /* =========================
           DECORATION
        ========================= */

        .features {

            display: flex;

            gap: 10px;

            margin-top: 30px;

            flex-wrap: wrap;

            justify-content: center;
        }


        .feature {

            padding: 9px 15px;

            border-radius: 20px;

            background:
                rgba(255, 255, 255, 0.2);

            border:
                1px solid rgba(255, 255, 255, 0.3);

            font-size: 13px;
        }


        /* =========================
           FORM SIDE
        ========================= */

        .form-area {

            width: 55%;

            padding: 55px;

            background:
                rgba(255, 255, 255, 0.82);

            display: flex;

            flex-direction: column;

            justify-content: center;
        }


        .form-area h2 {

            color: #b96565;

            font-size: 32px;

            margin-bottom: 10px;
        }


        .form-description {

            color: #777;

            margin-bottom: 30px;

            line-height: 1.5;
        }


        /* =========================
           FORM
        ========================= */

        .form-group {

            margin-bottom: 22px;
        }


        .form-group label {

            display: block;

            color: #8f5555;

            font-weight: bold;

            margin-bottom: 8px;

            font-size: 14px;
        }


        .form-group input[type="text"] {

            width: 100%;

            height: 52px;

            padding: 0 18px;

            border: 2px solid #f0caca;

            border-radius: 15px;

            outline: none;

            font-size: 15px;

            color: #555;

            background: white;

            transition: 0.3s;
        }


        .form-group input[type="text"]:focus {

            border-color: #d98686;

            box-shadow:
                0 0 0 4px rgba(217, 134, 134, 0.15);
        }


        /* =========================
           CREATE BUTTON
        ========================= */

        .create-btn {

            width: 100%;

            height: 52px;

            border: none;

            border-radius: 25px;

            background:
                linear-gradient(
                    135deg,
                    #d98686,
                    #c46f6f
                );

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            box-shadow:
                0 10px 20px rgba(201, 120, 120, 0.3);

            transition: 0.3s;
        }


        .create-btn:hover {

            transform: translateY(-3px);

            box-shadow:
                0 15px 25px rgba(201, 120, 120, 0.4);

            background:
                linear-gradient(
                    135deg,
                    #c97878,
                    #b96565
                );
        }


        .create-btn:active {

            transform: translateY(0);
        }


        /* =========================
           CANCEL BUTTON
        ========================= */

        .cancel-btn {

            display: block;

            text-align: center;

            margin-top: 15px;

            padding: 12px;

            border-radius: 20px;

            color: #b96565;

            text-decoration: none;

            font-weight: bold;

            transition: 0.3s;
        }


        .cancel-btn:hover {

            background: #f9e5e5;
        }


        /* =========================
           HIDDEN USER ID
        ========================= */

        input[type="hidden"] {
            display: none;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            body {

                padding: 20px;

                align-items: flex-start;

                padding-top: 80px;
            }


            .page {

                flex-direction: column;

                min-height: auto;

                border-radius: 25px;
            }


            .visual {

                width: 100%;

                min-height: 330px;

                padding: 35px 25px;
            }


            .visual h1 {

                font-size: 28px;
            }


            .visual p {

                font-size: 14px;
            }


            .group-picture {

                width: 130px;
                height: 130px;

                font-size: 60px;

                margin-bottom: 20px;
            }


            .form-area {

                width: 100%;

                padding: 35px 25px;
            }


            .form-area h2 {

                font-size: 26px;
            }


            .back-btn {

                top: 15px;
                left: 15px;

                padding: 10px 16px;

                font-size: 14px;
            }

        }


        /* =========================
           SMALL MOBILE
        ========================= */

        @media (max-width: 400px) {

            .visual {

                min-height: 300px;
            }


            .group-picture {

                width: 110px;
                height: 110px;

                font-size: 50px;
            }


            .form-area {

                padding: 30px 20px;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         BACK BUTTON
    ========================= -->

    <a
        href="{{ route('main') }}"
        class="back-btn"
    >
        ← Back
    </a>


    <!-- =========================
         PAGE
    ========================= -->

    <div class="page">


        <!-- =========================
             LEFT VISUAL
        ========================= -->

        <div class="visual">


            <div
                class="group-picture"
                onclick="changeIcon(this)"
                title="Click to change icon"
            >
                👥
            </div>


            <h1>
                Create Your Group
            </h1>


            <p>
                Bring your friends together,
                start conversations, share ideas,
                and enjoy chatting in one place.
            </p>


            <div class="features">

                <div class="feature">
                    💬 Chat
                </div>

                <div class="feature">
                    👥 Friends
                </div>

                <div class="feature">
                    ❤️ Connect
                </div>

            </div>


        </div>


        <!-- =========================
             FORM
        ========================= -->

        <div class="form-area">


            <h2>
                New Group
            </h2>


            <p class="form-description">
                Give your group a name and start
                connecting with your friends.
            </p>


            <form
                action="{{ route('group.create') }}"
                method="POST"
            >

                @csrf


                <!-- GROUP NAME -->

                <div class="form-group">

                    <label for="name_group">
                        Group Name
                    </label>


                    <input
                        type="text"
                        id="name_group"
                        name="name_group"
                        placeholder="Enter your group name..."
                        maxlength="100"
                        autocomplete="off"
                        required
                    >

                </div>


                <!-- USER ID -->

                <input
                    type="hidden"
                    name="user_id"
                    value="{{ auth()->id() }}"
                >


                <!-- CREATE -->

                <button
                    type="submit"
                    class="create-btn"
                >
                    ✨ Create Group
                </button>


                <!-- CANCEL -->

                <a
                    href="{{ route('main') }}"
                    class="cancel-btn"
                >
                    Cancel
                </a>


            </form>


        </div>


    </div>


    <script>

        /*
        |--------------------------------------------------------------------------
        | GROUP ICON
        |--------------------------------------------------------------------------
        */

        function changeIcon(element)
        {

            const icons = [
                "👥",
                "👨‍👩‍👧‍👦",
                "💬",
                "❤️",
                "⭐",
                "🎮",
                "🎵",
                "🔥"
            ];

            const current =
                element.textContent.trim();

            let index =
                icons.indexOf(current);

            index++;

            if(index >= icons.length)
            {
                index = 0;
            }

            element.textContent =
                icons[index];

        }


        /*
        |--------------------------------------------------------------------------
        | ENTER KEY
        |--------------------------------------------------------------------------
        */

        document
            .getElementById("name_group")
            .addEventListener(
                "input",
                function()
                {

                    this.value =
                        this.value
                            .replace(/\s+/g, " ")
                            .trimStart();

                }
            );

    </script>


</body>

</html>