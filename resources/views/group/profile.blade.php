<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $attibute->name }} - Profile</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;

            padding: 30px 15px;

            background:
                radial-gradient(
                    circle at top left,
                    rgba(255,255,255,0.6),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #f8dddd,
                    #d98686,
                    #e9bcbc,
                    #f7e1e1
                );

            display: flex;

            justify-content: center;

            align-items: center;
        }

        /* =========================================
           CONTAINER
        ========================================= */

        .container {
            width: 100%;
            max-width: 650px;
        }

        /* =========================================
           BACK BUTTON
        ========================================= */

        .back-btn {
            display: inline-flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 15px;

            padding: 9px 15px;

            border-radius: 20px;

            background: rgba(255,255,255,0.85);

            color: #b85f5f;

            text-decoration: none;

            font-size: 13px;

            font-weight: bold;

            box-shadow:
                0 4px 12px rgba(0,0,0,0.08);

            transition: 0.2s;
        }

        .back-btn:hover {
            transform: translateX(-3px);

            background: white;
        }

        /* =========================================
           PROFILE CARD
        ========================================= */

        .profile-card {
            overflow: hidden;

            background: rgba(255,255,255,0.94);

            border-radius: 25px;

            box-shadow:
                0 15px 40px rgba(0,0,0,0.15);

            backdrop-filter: blur(10px);
        }

        /* =========================================
           PROFILE HEADER
        ========================================= */

        .profile-header {
            position: relative;

            padding: 35px 25px 70px;

            text-align: center;

            background:
                linear-gradient(
                    135deg,
                    #d98686,
                    #b85f5f
                );

            color: white;
        }

        .profile-header::before {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            top: -90px;
            right: -50px;

            border-radius: 50%;

            background:
                rgba(255,255,255,0.10);
        }

        .profile-header::after {
            content: "";

            position: absolute;

            width: 130px;
            height: 130px;

            bottom: -70px;
            left: -40px;

            border-radius: 50%;

            background:
                rgba(255,255,255,0.08);
        }

        /* =========================================
           PROFILE IMAGE
        ========================================= */

        .profile-image-wrapper {
            position: relative;

            z-index: 2;

            width: 125px;
            height: 125px;

            margin: 0 auto 15px;
        }

        .profile-image {
            width: 125px;
            height: 125px;

            object-fit: cover;

            border-radius: 50%;

            border: 5px solid white;

            background: #eee;

            box-shadow:
                0 8px 20px rgba(0,0,0,0.20);
        }

        .profile-placeholder {
            width: 125px;
            height: 125px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            border: 5px solid white;

            background:
                rgba(255,255,255,0.25);

            color: white;

            font-size: 45px;

            font-weight: bold;

            box-shadow:
                0 8px 20px rgba(0,0,0,0.20);
        }

        /* =========================================
           NAME
        ========================================= */

        .profile-header h1 {
            position: relative;

            z-index: 2;

            font-size: 27px;
        }

        .profile-header p {
            position: relative;

            z-index: 2;

            margin-top: 6px;

            color:
                rgba(255,255,255,0.82);

            font-size: 14px;
        }

        /* =========================================
           PROFILE BODY
        ========================================= */

        .profile-body {
            padding: 25px;
        }

        /* =========================================
           INFORMATION GRID
        ========================================= */

        .info-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 12px;
        }

        .info-box {
            padding: 15px;

            background: #faf5f5;

            border: 1px solid #f0dddd;

            border-radius: 15px;

            transition: 0.2s;
        }

        .info-box:hover {
            transform: translateY(-2px);

            box-shadow:
                0 5px 15px rgba(0,0,0,0.06);
        }

        .info-label {
            display: block;

            margin-bottom: 7px;

            color: #999;

            font-size: 11px;

            text-transform: uppercase;

            letter-spacing: 0.6px;
        }

        .info-value {
            display: block;

            color: #444;

            font-size: 14px;

            font-weight: bold;

            word-break: break-word;
        }

        /* =========================================
           DESCRIPTION
        ========================================= */

        .description-box {
            margin-top: 12px;

            padding: 17px;

            background: #faf5f5;

            border: 1px solid #f0dddd;

            border-radius: 15px;
        }

        .description-label {
            display: block;

            margin-bottom: 8px;

            color: #999;

            font-size: 11px;

            text-transform: uppercase;

            letter-spacing: 0.6px;
        }

        .description {
            color: #555;

            font-size: 14px;

            line-height: 1.7;

            word-break: break-word;
        }

        /* =========================================
           FOOTER
        ========================================= */

        .profile-footer {
            padding: 18px 25px;

            border-top: 1px solid #eee;

            text-align: center;

            color: #aaa;

            font-size: 12px;
        }

        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 600px) {

            body {
                padding: 15px 10px;
            }

            .profile-header {
                padding:
                    30px 20px 65px;
            }

            .profile-header h1 {
                font-size: 23px;
            }

            .profile-body {
                padding: 18px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .profile-image,
            .profile-placeholder {
                width: 105px;
                height: 105px;
            }

            .profile-image-wrapper {
                width: 105px;
                height: 105px;
            }

        }

    </style>

</head>


<body>

<div class="container">


    <!-- =========================================
         BACK BUTTON
    ========================================== -->

    <a
        href="{{ route('main') }}"
        class="back-btn"
    >
        ← Back
    </a>


    <!-- =========================================
         PROFILE CARD
    ========================================== -->

    <div class="profile-card">


        <!-- =====================================
             PROFILE HEADER
        ====================================== -->

        <div class="profile-header">


            <div class="profile-image-wrapper">

                @php
                    $attRawImg = $attibute->image ?? null;
                    $attImgUrl = $attRawImg ? (str_starts_with($attRawImg, 'http') ? $attRawImg : '/storage/' . ltrim($attRawImg, '/')) : null;
                @endphp
                @if(!empty($attImgUrl))

                    <img
                        src="{{ $attImgUrl }}"
                        alt="{{ $attibute->name }}"
                        class="profile-image"
                        onerror="this.onerror=null;this.replaceWith(document.createRange().createContextualFragment('<div class=\'profile-placeholder\'>{{ strtoupper(substr($attibute->name ?? 'U', 0, 1)) }}</div>'))"
                    >

                @else

                    <div class="profile-placeholder">

                        {{ strtoupper(substr($attibute->name ?? 'U', 0, 1)) }}

                    </div>

                @endif

            </div>


            <h1>
                {{ $attibute->name }}
            </h1>

            <p>
                User Profile
            </p>

        </div>


        <!-- =====================================
             PROFILE INFORMATION
        ====================================== -->

        <div class="profile-body">


            <div class="info-grid">


                <!-- USER ID -->

                <div class="info-box">

                    <span class="info-label">
                        User ID
                    </span>

                    <span class="info-value">
                        #{{ $attibute->id }}
                    </span>

                </div>


                <!-- ID NUMBER -->

                <div class="info-box">

                    <span class="info-label">
                        ID Number
                    </span>

                    <span class="info-value">
                        {{ $attibute->id_number ?? 'Not provided' }}
                    </span>

                </div>


                <!-- EMAIL -->

                <div class="info-box">

                    <span class="info-label">
                        Email
                    </span>

                    <span class="info-value">
                        {{ $attibute->email ?? 'Not provided' }}
                    </span>

                </div>


                <!-- GENDER -->

                <div class="info-box">

                    <span class="info-label">
                        Gender
                    </span>

                    <span class="info-value">
                        {{ $attibute->gender ?? 'Not provided' }}
                    </span>

                </div>


            </div>


            <!-- =================================
                 DESCRIPTION
            ================================== -->

            <div class="description-box">

                <span class="description-label">
                    About
                </span>

                <div class="description">

                    {{ $attibute->description ?? 'No description provided.' }}

                </div>

            </div>


        </div>


        <!-- =====================================
             FOOTER
        ====================================== -->

        <div class="profile-footer">

            Profile ID:
            {{ $attibute->id }}

        </div>


    </div>

</div>

</body>

</html>