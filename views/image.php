<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <meta name="title" content="{{ $title }}">
    <meta name="description" content="{{ $description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $baseUrl }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $imageUrl }}">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $baseUrl }}">
    <meta property="twitter:title" content="{{ $title }}">
    <meta property="twitter:description" content="{{ $description }}">
    <meta property="twitter:image" content="{{ $imageUrl }}">
    <link rel="stylesheet" href="/static/assets/image.css">
</head>
<body>
    <section>
        <h1>Screenshot: <i>{{ $fileName }}</i></h1>
        <img src="{{ $imageUrl }}" alt="Uploaded Image">
    </section>
</body>
</html>