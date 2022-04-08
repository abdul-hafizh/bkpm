<!DOCTYPE html>
<html lang="en">

<head>
    {!! simple_cms_meta_tag() !!}

    <meta name="keywords" content="@get('keywords')">
    <meta name="description" content="@get('description')">
    <meta name="author" content="@get('author')">

    <title>@get('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

    @styles('head')
    @styles()
    @scripts('head')

</head>

<body>
<div class="flex-center position-ref full-height">
    @partial('header')

    @content()

    @partial('footer')

    <div class="content">
        <div class="title m-b-md">
            {{ site_name() }}
        </div>
    </div>
</div>

@scripts('footer')
@scripts()
</body>
</html>
